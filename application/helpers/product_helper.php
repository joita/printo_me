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

class helperProduct{

	public function sortDesign($design, $orderby = 'ordering'){
		$rows 	= array();		
		foreach( $design as $key => $value )
		{
			if(is_array($value))
			{
				for( $i=0; $i<count($value); $i++ )
				{
					$rows[$i][$key]	= $value[$i];
				}
			}
		}
			

		$sortArray = array(); 
		foreach($rows as $row){
			foreach($row as $key=>$value){
				if(!isset($sortArray[$key])){ 
					$sortArray[$key] = array(); 
				}
				$sortArray[$key][] = $value; 
			} 
		}
		//print_m($sortArray);
		if( count($sortArray) ) {
			//array_multisort($sortArray[$orderby], SORT_ASC, $rows);
		}
		//print_m($rows);
		return $rows;
	}
	
	public function json($design)	{
		$rows = new stdClass();
		foreach($design as $key => $value){
			$rows->$key = json_decode($value);
		}
		
		return $rows;
	}
	
	public function getImgage($str){
		$data = str_replace("'", '"', $str);
		$data = json_decode($data);
		
		if( count($data) > 0 ){
			foreach($data as $vector){
				if( isset($vector->img) && $vector->img != '' ){
					$img = $vector->img;
					return base_url($img);
				}
			}
		}
		
		return '';
	}
	
	public function getDesign($data) {
		$CI =& get_instance();
		
		$design = new stdClass();
		
		if (strlen($data->front) > 10){
			$design->front = json_decode($data->front);
		}else{
			$design->front = false;
		}
		
		if (strlen($data->back) > 10) {
			$design->back = json_decode($data->back);
		}else{
			$design->back		= false;
		}
		
		if (strlen($data->left) > 10){
			$design->left		= json_decode($data->left);
		}else{
			$design->left		= false;
		}
		
		if (strlen($data->right) > 10){
			$design->right		= json_decode($data->right);
		}else{
			$design->right		= false;
		}		

		$design->area = json_decode($data->area);
		$design->params = json_decode($data->params);
		$design->color_hex= json_decode($data->color_hex);
		$design->color_title= json_decode($data->color_title);
		
		/* foreach($design->color_title as $indice=>$coltit) {
			$design->color_title[$indice] = url_title($coltit);
		} */
		
		$db_color = $CI->catalogo_modelo->obtener_colores_por_producto($data->id_producto);
		
		$color_id = array();
		foreach ($design->color_hex as $key => $value) {
			$color_name = $design->color_title[$key];
			foreach ($db_color as $color_index => $color) {
				$item = str_replace("#", "", $color->codigo_color);
				$name = $color->nombre_color;
				if ($item == strtoupper($value) && $name == $color_name) {
					$color_id[] = $color->id_color;
					unset($db_color[$color_index]);
					break;
				}
			}
		}

		$design->color_id = $color_id;
		
		return $design;
	}
	
	public function displayAttributes($attribute)	{
		if (isset($attribute->name) && $attribute->name != ''){
			$attrs = new stdClass();
		
			$attrs->name 		= json_decode($attribute->name);
			$attrs->titles 		= json_decode($attribute->titles);
			$attrs->prices 		= json_decode($attribute->prices);
			$attrs->type 		= json_decode($attribute->type);
			
			$html 				= '';
			for ($i=0; $i<count($attrs->name); $i++)
			{
				$html 	.= '<div class="form-group product-fields">';
				$html 	.= 		'<label for="fields">'.$attrs->name[$i].'</label>';
				
				$id 	 = 'attribute['.$attribute->id.']['.$i.']';
				$html 	.= 		$this->field($attrs->name[$i], $attrs->titles[$i], $attrs->prices[$i], $attrs->type[$i], $id);
				
				$html 	.= '</div>';
			}
			return $html;
		}else{
			return '';
		}
	}
	
	public function field($name, $title, $price, $type, $id){
		$html = '<div class="dg-poduct-fields">';
		switch($type) {
			case 'checkbox':
				for ($i=0; $i<count($title); $i++){
					$html .= '<label class="checkbox-inline">';
					$html .= 	'<input type="checkbox" name="'.$id.'['.$i.']" value="'.$i.'"> '.$title[$i];
					$html .= '</label>';
				}
			break;
			
			case 'selectbox':
				$html .= '<select class="form-control input-sm" name="'.$id.'">';
				
				for ($i=0; $i<count($title); $i++){
					$html .= '<option value="'.$i.'">'.$title[$i].'</option>';
				}
				
				$html .= '</select>';
			break;
			
			case 'radio':
				for ($i=0; $i<count($title); $i++){
					$html .= '<label class="radio-inline">';
					$html .= 	'<input type="radio" name="'.$id.'" value="'.$i.'"> '.$title[$i];
					$html .= '</label>';
				}
			break;
			
			case 'textlist':
				$html 		.= '<style>.product-quantity{display:none;}</style><ul class="p-color-sizes list-number col-md-12">';
				for ($i=0; $i<count($title); $i++){
					$html .= '<li>';
					$html .= 	'<label>'.$title[$i].'</label>';
					$html .= 	'<input type="text" class="form-control input-sm size-number" name="'.$id.'['.$i.']">';					
					$html .= '</li>';
				}
				$html 		.= '</ul>';
			break;
		}
		$html	.= '</div>';
		
		return $html;
	}
	
	public static function quantity($min = 1, $name = 'Cantidad', $name2 = 'cantidad minima: '){
		
		$html = '<div class="form-group product-fields product-quantity">';
		$html .= 	'<label class="col-sm-4">'.$name.'</label>';
		$html .= 	'<div class="col-sm-6">';
		$html .= 		'<input type="text" class="form-control input-sm" value="0" name="quantity" id="quantity">';
		$html .= 	'</div>';
		$html .= 	'<span class="help-block"><small>'.$name2.$min.'</small></span>';
		$html .= '</div>';
		
		return $html;
	}

	public static function position($position)
	{
		switch ($position) {
			case 'front':
				return "Frente";
				break;

			case 'back':
				return "Atras";
				break;

			case 'left':
				return "Izquierda";
				break;

			case 'right':
				return "Derecho";
				break;
			
			default:
				return "No Aplica";
				break;
		}
	}

    //Check if thid vendor has Already posted this product then return ID

    public function checkIfCreateOrUpdate($vendorId,$pid)
    {

        $CI =& get_instance();
        $result = $CI->db->get_where('proveedores_shopify_prod',['vendor_id' => $vendorId, 'product_id' => $pid])->row();
        if($result)
        {
            return $result->shopify_id;
        }else{
            return false;
        }
    }

    //Post to shopify vendors
    public function postApiForShopifyVendors($vendor,$infoArr)
    {



        $shopify_id  = $this->checkIfCreateOrUpdate($vendor->id,$infoArr['pid']);
        if($shopify_id !== false)
        {
            $this->UpdateProductShopifyVendors($infoArr,$vendor,$shopify_id);
        }else{

            $this->CreateProductShopifyVendors($infoArr,$vendor);

        }


    }

    private function CreateProductShopifyVendors($product,$vendor)
    {
        $baseUrl = "https://".$vendor->api_key .":". $vendor->api_pass ."@".$vendor->store_url;
        // echo  $baseUrl;
        //$baseUrl = "https://56ca196faaa26c9febebd50794e1c3a1:f434d278c11b1d2c592232467eb4277f@manrox.myshopify.com";
        //$product['body_html'] = "xxccx";
        $pid = $product['pid'];
        unset($product['pid']);
        $ch = curl_init($baseUrl.'/admin/products.json'); //set the url
        //$data_string = json_encode(array('product'=>$product));
        $data_string = json_encode(array('product'=>$product)); //encode the product as json

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  //specify this as a POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); //set the POST string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //specify return value as string
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        ); //specify that this is a JSON call
        $server_output = curl_exec ($ch); //get server output if you wish to error handle / debug
        if($server_output === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }

        $productJson = json_decode($server_output);
        if(isset($productJson->product))
        {
            $shopifyID =  $productJson->product->id;
            $CI =& get_instance();
            $CI->db->insert('proveedores_shopify_prod',['vendor_id'=>$vendor->id,'shopify_id'=>$shopifyID,'product_id'=>$pid]);

            //redirect('administracion/campanas');
        }else{
            //insert log response
            $CI =& get_instance();
            $CI->db->insert('shopify_logs',['vendor_id'=>$vendor->id,'logs'=>$server_output]);
        }

        curl_close ($ch); //close the connection
    }

    private function UpdateProductShopifyVendors($product,$vendor,$shopify_pid)
    {
        $baseUrl = "https://".$vendor->api_key .":". $vendor->api_pass ."@".$vendor->store_url;


        $pid = $product['pid'];
        unset($product['pid']);
        //$product['body_html'] = "dsds";
        $product['id'] = $shopify_pid;
        $ch = curl_init($baseUrl.'/admin/products/'.$shopify_pid.'.json'); //set the url
        $data_string = json_encode(array('product'=>$product)); //encode the product as json

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  //specify this as a POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); //set the POST string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //specify return value as string
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        ); //specify that this is a JSON call
        $server_output = curl_exec ($ch); //get server output if you wish to error handle / debug
        $CI =& get_instance();
        $CI->db->insert('shopify_logs',['vendor_id'=>$vendor->id,'logs'=>$server_output]);
        curl_close ($ch); //close the connection

        //redirect('administracion/campanas');
    }


    public function getTotalOrdersShopify($domain){

        $CI =& get_instance();
        $result = $CI->db->query("select * from shopify_vendor_orders as spo left join Pedidos as pd on pd.id_pedido = spo.order_id  where shopify_domain ='".$domain."'")->result();
        return count($result);
    }

    public function getTotalPaymentShopify($domain){

        $CI =& get_instance();
        $result = $CI->db->query("select sum(pd.total) as total from shopify_vendor_orders as spo left join Pedidos as pd on pd.id_pedido = spo.order_id  where shopify_domain ='".$domain."'")->row();
        return isset($result->total) ? $result->total : 0;
    }
}
?>