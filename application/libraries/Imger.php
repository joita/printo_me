<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imger {

    function cuadrado($color, $alto, $ancho)
    {
        $image = new Imagick();
        $image->newImage($alto, $ancho, new ImagickPixel($color));
        $image->setImageFormat('png');
        echo "<img style='margin:0.5mm;' src='data:image/png;base64,".base64_encode($image->getImageBlob())."' style='vertical-align:middle' /> <small style='font-size:6pt;'>".$color.'</small>';
    }
}
