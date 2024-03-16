<?php

if ( ! function_exists('activar_color_adicional'))
{
	function activar_color_adicional($enhances_adicionales, $id_color, $elemento)
	{
		foreach($enhances_adicionales as $indice_adicional => $enhance_adicional) {
            if($enhance_adicional->id_color == $id_color) {
                if($elemento == 'a') {
                    echo ' class="already-added"';
                } else if($elemento == 'i') {
                    echo '-check';
                }
            }
        }
	}
}

if ( ! function_exists('generar_imagen_imagick'))
{
	function generar_imagen_imagick($imagen_base, $imagen_diseno, $ancho_especifico, $alto_especifico, $posicion_izquierda, $posicion_arriba, $lado, $mismo_diseno, $id_adicional)
	{
        $image = new \Imagick();
        $image->readImage(realpath($imagen_base));
        $image->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
        $nombre_archivo_dis = 'media/assets/system/'.date('Y').'/'.date('m').'/dis_'.$lado.'_'.$mismo_diseno.'_'.$id_adicional.'.jpg';

        $image_diseno = new \Imagick();
        $image_diseno->readImage(realpath($imagen_diseno));
        $image_diseno->writeImage($nombre_archivo_dis);
        $image_diseno->resizeimage($ancho_especifico, $alto_especifico, \Imagick::FILTER_LANCZOS, 1);

        $image->compositeImage($image_diseno, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $posicion_izquierda), str_replace("px", "", $posicion_arriba));
        $nombre_archivo = 'media/assets/system/'.date('Y').'/'.date('m').'/'.$lado.'_'.$mismo_diseno.'_'.$id_adicional.'.jpg';
        $image->writeImage($nombre_archivo);

        return $nombre_archivo;
	}
}
