<?php
if ( ! function_exists('dd'))
{
  function dd(){
    echo "<pre>";
    array_map(function($x) { var_dump($x); }, func_get_args());
    echo "</pre>";
    die;
  }
}
if (! function_exists('row_extract'))
{
  function row_extract($row, $attribute = null)
  {
    if (!is_null($attribute)) {
      return (!is_null($row)) ? $row->{$attribute} : null;
    }
    return (!is_null($row)) ? $row : null;
  }
}

if ( ! function_exists('caracteristicas_parse'))
{
  function caracteristicas_parse($json_string){
    $json = json_decode($json_string);

    $caracteristicas = "";
    foreach ($json as $key => $value) {
      $caracteristicas .= $value;
    }
    return $caracteristicas;
  }
}

if ( ! function_exists('caracteristicas_parse2'))
{
  function caracteristicas_parse2($string){

    $caracteristicas = "";
    foreach ($string as $key => $value) {
      $caracteristicas .= $value;
    }
    return $caracteristicas;
  }
}

if ( ! function_exists('color_awesome'))
{
  function color_awesome($color_code){
    return '<i class="fa fa-square" style="color:'.$color_code.';text-shadow:0px 0px 1px #666;"></i>';
  }
}

if ( ! function_exists('redondeo'))
{
  function redondeo($precio, $inverse = FALSE){
    return $precio;
  }
}


if ( ! function_exists('createFile'))
{
  function createFile($data, $prefix = '', $filename = '', $file_url = '')
  {

    $assets  = APPPATH. "../public/media/assets";
    $path = $assets .'/system';
    $CI = get_instance();
    if ($file_url == '')
    {
      $CI->load->library('file');
      $file     = new file();

      $date   = new DateTime();
      $year = $date->format('Y');
      $month  = $date->format('m');

      $folder_year = $path .'/'. $year;
      $folder_month = $folder_year .'/'. $month;

      if (!file_exists($assets))
        $file->create($assets, 0755);

      if (!file_exists($path))
        $file->create($path, 0755);

      if (!file_exists($folder_year))
        $file->create($folder_year, 0755);

      if (!file_exists($folder_month))
        $file->create($folder_month, 0755);

      if ($filename == '')
        $file     = $prefix .'_'. strtotime("now") . '.png';
      else
        $file     = $prefix .'_'. $filename .'.png';

      $path_file  = $path .'/'. $year .'/'. $month .'/'. $file;
      $file   = 'media/assets/system/'.$year .'/'. $month .'/'. $file;
    }
    else
    {
      $path_file  = $path .'/'. str_replace('/', '/', $file_url);
    }

    $temp     = explode(';base64,', $data);
    $buffer   = base64_decode($temp[1]);
    $CI->load->helper('file');

    if ( ! write_file($path_file, $buffer))
      return '';
    else
      return $file;
  }

}
if ( ! function_exists('spanit'))
{
  function spanit($content){
    if (is_null($content)) {
      return;
    }

    return "<span>". $content . "</span>";
  }
}


if ( ! function_exists('descuento'))
{
  function descuento($product_price, $product_discount, $cart_discount){

    /* $price_with_cart_discount = $cart_discount;

    $price_with_product_discount = ($product_price - ($product_price / (1 - $product_discount)));

    if ($price_with_product_discount < 0) {
      $price_with_product_discount = ($price_with_product_discount * -1);
    }

    if ($price_with_product_discount < $price_with_cart_discount) {
      if ($price_with_cart_discount == 0) {
        break;
      }
      return "CART";
    }else if ($price_with_product_discount > $price_with_cart_discount) {
      if ($price_with_product_discount == 0) {
        break;
      }
      return "PRODUCT";
    }
    return "NONE"; */

  }
}

if ( ! function_exists('tipo_descuento'))
{
  function tipo_descuento($options, $discount, $percent, $cupon_name){
    $type = $options['tipo_descuento'];
    //$descuento = $options['descuento'];

    switch ($type) {
      case 'CART':

        if (!$percent) {
          return "Descuento: -$ $discount" . "(CUPÓN: " . $cupon_name . ")";
        }else{
          $temp = $discount*100;
          return "Descuento: -". $temp . "% (CUPÓN: " . $cupon_name . ")";
        }
      break;

      case 'PRODUCT':
        return "Descuento: -" . $options['descuento'] ." %";
        break;

      default:
        return null;
        break;
    }

  }
}


if (!function_exists("cut_title")) {
  function cut_title($string, $limite)
  {
    $limite = (!empty($limite)) ? $limite : 3;
    $palabras = explode(" ",$string);
    return implode(" ",array_splice($palabras,0,$limite));
  }
}


function svgJs($document){
	$search = array('@<script[^>]*?>.*?</script>@si', '@onkeydown=.*?[ ]@si', '@onclick=.*?[ ]@si', '@onmouseover=.*?[ ]@si', '@onchange=.*?[ ]@si', '@onmouseout=.*?[ ]@si', '@onload=.*?[ ]@si');
	$text = preg_replace($search, '', $document);
	return $text;
}


if ( ! function_exists('cdn_url'))
{
	function cdn_url($uri = '')
	{
		//return 'https://printome-creatividaddigit.netdna-ssl.com/'.$uri;
		return site_url($uri);
	}
}


if ( ! function_exists('rgb2hex'))
{
	function rgb2hex($rgb) {
		$hex = "#";
		$hex .= str_pad(dechex($rgb['r']), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb['g']), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb['b']), 2, "0", STR_PAD_LEFT);

		return $hex;
	}
}
