<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Media extends MY_Admin
{

	public function __construct ()
	{
		parent::__construct();
		
		$this->load->library('file');
		$file 		= new File();
		
		$this->root	= 'media';
		$this->url 	= site_url() . 'media';

		
		// create folder
		if (!file_exists($this->root))
		{
			$file->create($this->root, 0755);		
		
			// create list sub folder
			if (!file_exists($this->root .'/'. 'assets'))		
				$file->create($this->root .'/'. 'assets', 0755); // folder of media
			
			if (!file_exists($this->root .'/'. 'cliparts'))		
				$file->create($this->root .'/'. 'cliparts', 0755); // folder of cliparts
			
			if (!file_exists($this->root .'/'. 'data'))		
				$file->create($this->root .'/'. 'data', 0755); // folder of data: file layout, language...
		}
	}
	
	function index()
	{
		
		$this->data['breadcrumb'] 	= lang('media_admin_media_breadcrumb');
		$this->data['meta_title'] 	= lang('media_admin_media_title');
		$this->data['sub_title'] 	= lang('media_admin_media_sub_title');
		
		$root		= 'assets';
		
		$this->load->library('file');
		$file 		= new file();
		$folders 	= $file->folders($this->root .'/'. $root);
		$files 		= $file->files($this->root .'/'. $root);
		
		$this->data['root'] 		= $root;
		$this->data['folders'] 		= $folders;
		$this->data['files'] 		= $files;
		$this->data['imgURL'] 		= $this->url;
		$this->data['subview'] 		= 'admin/media/index';
		
		$this->load->view('admin/_layout_main', $this->data);
		
	}
	
	function modals($function = null, $selected = 1)
	{
		
		$this->data['breadcrumb'] 	= ('media_admin_media_breadcrumb');
		$this->data['meta_title'] 	= ('media_admin_media_title');
		$this->data['sub_title'] 	= ('media_admin_media_sub_title');
		
		$root		= 'assets';
		
		$this->load->library('file');
		$file 		= new File();
		$folders 	= $file->folders($this->root .'/'. $root);
		$files 		= $file->files($this->root .'/'. $root); 
		
		$this->data['root'] 		= $root;
		$this->data['folders'] 		= $folders;
		$this->data['function'] 	= $function;
		$this->data['selected'] 	= $selected;
		$this->data['files'] 		= $files;
		$this->data['imgURL'] 		= $this->url;
		//$this->data['subview'] 		= 'admin/media/index';
		
		$this->load->view('administracion/media/modals', $this->data);
	}
	
	function upload()
	{
		$file = $_FILES['myfile'];
		$folder = $this->input->get('folder');

		if($file)
		{
			$config['upload_path'] = $this->root .'/'. $folder;
						
			$config['allowed_types'] = 'gif|png|jpg|pdf|pdf|doc|txt|docx';				

			$this->upload->initialize($config);
			$this->upload->do_upload('myfile');
			
			$file = $this->upload->data();
			$file['url'] 	= site_url() .  str_replace('//', '/', '/media/'.$folder .'/'. $file['file_name']);
			$file['url']	= str_replace('\\', '/', $file['url']);
			echo json_encode($file);
			exit;
		}
	}
	
	function add()
	{
		$path 		= $this->input->post('path');
		$folder 	= $this->input->post('folder');
		
		$this->load->library('file');
		$file = new file();
		
		$path 		= $this->root .'/'. $path .'/'. $folder;
		
		$check 		= $file->create($path, 0755);
		
		if($check == false)
		{
			echo lang('media_exists');
		}else{
			echo 1;
		}
		exit();
	}
	
	function remove()
	{
		$path 	= $this->input->post('path');
		
		$this->load->library('file');
		$file = new file();
		echo $file->removeFolder($this->root . $path);
		exit();
	}
	
	function rename()
	{
		$path 	= $this->input->post('path');
		$tree = $this->input->post('folder');
		
		$check = strripos($path, '/');
		$ds = '/';
		
		if($check === false)
		{
			$check = strripos($path, '\\');
			$ds = '\\';
		}
		
		if($check === false)
		{
			echo lang('media_folder_found');
			exit;
		}
		
		$folders = explode($ds, $path);
		if($folders > 1)
		{
			$src 	= '';
			$n = count($folders) - 1;
			for($i=0; $i<$n; $i++)
			{
				if($i == 0) $src = $folders[$i];
				else $src .= $ds . $folders[$i];
			}
			$src .= $ds . $tree;
		}		
		
		$this->load->library('file');
		$file = new file();
		echo $file->rename($this->root . $path, $this->root . $src);
		exit();
	}
	
	function folder($action = 'load')
	{
		$path 	= $this->input->post('path');
		$tree = $this->input->post('folder');
		
		$arr = array();
		if($action == 'load')
		{
			$this->load->library('file');
			$file = new file();
				
			$folders 		= $file->folders($this->root . $path);
			$arr['folder'] 	= $folders;
			
			if($tree != '1')
			{
				$files 			= $file->files($this->root . $path); 
				$arr['files'] 	= $files;
			}
		}
		
		echo json_encode($arr);
	}
	
	function fileRemove()
	{
		$path 	= $this->input->post('path');
		
		$this->load->library('file');
		$file = new file();
		$check = $file->delete_file( $this->root . $path );
		if($check == true)
		{
			echo '1';
		}
		else
		{
			echo lang('media_remove_file_msg');
		}
		exit();
	}
	
	function fileFename()
	{
		$file 	= $this->input->post('path');
		$title = $this->input->post('folder');
		
		if(file_exists($this->root .'/'. $file) == true)
		{
			$info = pathinfo($this->root .'/'. $file);
			$new = $info['dirname'] .'/'. $title .'.'. $info['extension'];
			$check = rename($this->root .'/'. $file, $new);
			
			if($check == false)
			{
				echo lang('media_file_rename');
				exit();
			}
			echo '1';
			exit();
		}
		else
		{
			echo lang('media_file_found');
			exit();
		}
	}
}
?>