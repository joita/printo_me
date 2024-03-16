<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
use Dompdf\Dompdf;

function pdf_create($html, $filename='', $stream=TRUE) 
{
    //require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf",array('Attachment'=>0));
    } else {
        return $dompdf->output();
    }
}

function pdf_create_file($html, $filename='tmp', $stream=TRUE) 
{	
	$dompdf = new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $output = $dompdf->output();
	
	$directorio = getcwd().'/assets/pdf';
	
	if(!file_exists($directorio) and !is_dir($directorio)) {
		mkdir($directorio);
		chmod($directorio, 0755);
	}
	
	$filename_full = $directorio."/".$filename.'.pdf';
	
	if(!file_exists($filename_full)) {
		file_put_contents($filename_full, $output);
	}
	
    return $filename.'.pdf';
}