<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
  
  protected $_table_name = '';
  protected $_primary_key = 'id';
  protected $_primary_filter = 'intval';
  protected $_order_by = 'id';
  public $rules = array();
  protected $_timestamps = FALSE;
  
  public function __construct() {
    parent::__construct();
    $this->load->database();
  }
  
  public function array_from_post($fields){
    $data = array();
    foreach ($fields as $field) {
      $data[$field] = $this->input->post($field);
    }
    return $data;
  }
  
  public function get($id = NULL, $single = FALSE){
    
    if ($id != NULL) {
      $filter = $this->_primary_filter;
      $id = $filter($id);
      $this->db->where($this->_primary_key, $id);
      $method = 'row';
    } elseif($single == TRUE) {
      $method = 'row';
    } else {
      $method = 'result';
    }
    
    ///if (!count($this->db->ar_orderby)) {
      //$this->db->order_by($this->_order_by);
    //}
    
    if(is_array($this->_table_name)){
      //$this->_table_name = implode();
    }
    return $this->db->get($this->_table_name)->$method();
  }
  
  public function get_by($where, $single = FALSE){
    $this->db->where($where);
    return $this->get(NULL, $single);
  }
  
  // get total of query
  public function getTotal()
  {
    return $this->db->select()->get($this->_table_name)->num_rows();
  }
  
  public function save($data, $id = NULL){
    
    // Set timestamps
    if ($this->_timestamps == TRUE) {
      $now = date('Y-m-d H:i:s');
      $id || $data['created'] = $now;
    }
    
    // Insert
    if ($id === NULL) {
      !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
      $this->db->set($data);
      $this->db->insert($this->_table_name);
      $id = $this->db->insert_id();
    }
    // Update
    else {
      $filter = $this->_primary_filter;
      $id = $filter($id);
      $this->db->set($data);
      $this->db->where($this->_primary_key, $id);
      $this->db->update($this->_table_name);
    }
    
    return $id;
  }
  
  public function delete($id){
    $filter = $this->_primary_filter;
    $id = $filter($id);
    
    if (!$id) {
      return FALSE;
    }
    $this->db->where($this->_primary_key, $id);
    $this->db->limit(1);
    $this->db->delete($this->_table_name);
  }
  
  public function update($data, $id){
    $filter = $this->_primary_filter;
    $id = $filter($id);
    
    if (!$id) {
      return FALSE;
    }
    $this->db->where($this->_primary_key, $id);
    $this->db->limit(1);
    $this->db->update($this->_table_name, $data);
  }
}