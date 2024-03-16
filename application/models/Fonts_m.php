<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fonts_m extends MY_Model
{
	public $_table_name = 'fuentes';
	public $_primary_key = 'id';
	public $_order_by = 'title asc';
		
	public function getNew()
	{
		$font = new stdClass();
		$font->title 		= '';			
		$font->type 		= '';			
		$font->filename 	= '';
		$font->thumb 		= '';
		$font->published 	= 1;
		$font->path 		= '';
		$font->subtitle 	= '';
		$font->cate_id 		= '';
		return $font;
	}
	
	public function getFonts($count = false, $search = '', $cate = '', $number = '', $offset = '', $publish = false)
	{	
		$this->db->select('title, filename, thumb, published, id, type, path');
		
		if($search != '')
			$this->db->like('title', $search);
		
		if($publish == true)
			$this->db->where('published', 1);
		
		if($count == TRUE)
		{
			$query = $this->db->get('fuentes');
			return count($query->result());
		}
		else
		{
			$query = $this->db->get('fuentes', $number, $offset);
			return $query->result();
		}
	}
	
	public function getFont($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('fuentes');
		return $query->row();
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		if($this->db->delete($this->_table_name))
			return true;
		else
			return false;
	}
}