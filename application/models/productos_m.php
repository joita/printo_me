<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Productos_m extends MY_Model{

  public $_table_name   = 'products';
  public $_order_by     = 'created desc';
  public $_primary_key  = 'id';
  public $_timestamps   = TRUE;
  public $validate = array(
    array(
            'field' => 'title', 'label' => 'Product title', 'rules' => 'trim|required|max_length[15]|xss_clean|alpha_numeric'
        ),
  );

  /*
   * get product with where field
   *  fields = array("field_name"=>"value");
  */
  public function getProduct($fields = array()){
    $this->db->select('*');
    
    if( count($fields) ){
      foreach( $fields as $key => $value ) {
        $this->db->where($key, $value);
      }
    }
    
    $this->db->order_by('RAND()', 'DESC');
    $this->db->limit(1, 0);
    
    $product = parent::get();
    
    if ( count($product) ){
      return $product;
    }else{
      return false;
    }
  }

  public function getProductDesign($id)
  {
    $this->_table_name = 'products_design';
    $this->_order_by = 'id DESC';
    $this->db->where('product_id', $id);
    
    return parent::get(null, true);
  }
}
