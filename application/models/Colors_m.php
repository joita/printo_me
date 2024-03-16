<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colors_m extends MY_Model {
    public $_table_name     = 'colores';
    public $_order_by       = 'title asc';
    public $_primary_key    = 'id';
	
	public function getColors($count = false, $search = '', $number = 10000, $offset = 0, $publish = false)
	{
        if($search != '')
			$this->db->like('title', $search);
			
		$this->db->order_by('title', 'ASC');
		
		if($publish == true)
			$this->db->where('published', 1);
			
        if($count == TRUE){
			$query = $this->db->get('colores');
			return count($query->result());
        }else{
            $query = $this->db->get('colores', $number, $offset);
            return $query->result();
        }
    }
	
	public function getNew()
	{
		$color = new stdClass();
		$color->hex = '';
		$color->title = '';
		$color->type = '';
		$color->lang_code = '';
		$color->published = '';
		return $color;
	}
	
	public function getData($id)
	{
		$this->db->like('id', $id);
		$query = $this->db->get('colores');
		return $query->row();
	}
	
	public function checkData($data, $id = '')
	{
		if(isset($data['title']))
		{
			if($id != '')
				$this->db->where('id !=', $id);
				
			$this->db->where('title', $data['title']);
			$query = $this->db->get('colores');
			if($query->num_rows() > 0)
				return false;
			else
				return true;
		}else{
			return false;
		}
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		if($this->db->delete('colores'))
			return true;
		else
			return false;
	}
}