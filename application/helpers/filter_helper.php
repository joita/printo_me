<?php

if ( ! function_exists('descomponer_filtros'))
{
	function descomponer_filtros($get_filtros)
	{
        if($get_filtros != '') {
            $filtros = explode(',', $get_filtros);
            foreach($filtros as $indice_filtro=>$filtro) {
                $filtros[$indice_filtro] = explode(':', $filtro);
            }

            $nice_filtros = array();
            foreach($filtros as $filtro) {
                if(isset($filtro[1])) {
                    $nice_filtros[$filtro[0]] = $filtro[1];
                }
            }

            return $nice_filtros;
        } else {
            return array();
        }
	}
}

if ( ! function_exists('generar_url_filtro')) {
    function generar_url_filtro($nice_filtros, $new_filter = '')
    {
        if(!is_array($new_filter)) {
            if($new_filter != '') {
                $exploded_new_filter = explode(":", $new_filter);
                $url_filtro_adicional = '';
                if(isset($exploded_new_filter[1])) {
                    if(array_key_exists($exploded_new_filter[0], $nice_filtros)) {
                        if($nice_filtros[$exploded_new_filter[0]] != $exploded_new_filter[1]) {
                            $nice_filtros[$exploded_new_filter[0]] = $exploded_new_filter[1];
                        }
                    } else {
                        $nice_filtros[$exploded_new_filter[0]] = $exploded_new_filter[1];
                    }
                }
            }
        } else {
            foreach($new_filter as $nf) {
                if($nf != '') {
                    $exploded_new_filter = explode(":", $nf);
                    $url_filtro_adicional = '';
                    if(isset($exploded_new_filter[1])) {
                        if(array_key_exists($exploded_new_filter[0], $nice_filtros)) {
                            if($nice_filtros[$exploded_new_filter[0]] != $exploded_new_filter[1]) {
                                $nice_filtros[$exploded_new_filter[0]] = $exploded_new_filter[1];
                            }
                        } else {
                            $nice_filtros[$exploded_new_filter[0]] = $exploded_new_filter[1];
                        }
                    }
                }
            }
        }

        $url = '';
        if(sizeof($nice_filtros) > 0) {
            foreach($nice_filtros as $criterio => $valor) {
                $url .= $criterio.':'.$valor.',';
            }
            $url = '?filtros='.substr($url, 0, -1);
            return $url;
        } else {
            if($new_filter != '') {
                return '?filtros='.$new_filter;
            } else {
                return '';
            }
        }
    }
}

if ( ! function_exists('generar_url_filtro_excluyente')) {
    function generar_url_filtro_excluyente($nice_filtros, $exclude_filter = '')
    {
        if($exclude_filter != '') {
            $exploded_new_filter = explode(":", $exclude_filter);
            $url_filtro_adicional = '';
            if(isset($exploded_new_filter[1])) {
                if(array_key_exists($exploded_new_filter[0], $nice_filtros)) {
					unset($nice_filtros[$exploded_new_filter[0]]);
                }
            }
        }

        $url = '';
        if(sizeof($nice_filtros) > 0) {
            foreach($nice_filtros as $criterio => $valor) {
                $url .= $criterio.':'.$valor.',';
            }
            $url = '?filtros='.substr($url, 0, -1);
            return $url;
        } else {
            return '';
        }
    }
}

if ( ! function_exists('activar_filtro_option'))
{
    function activar_filtro_option($filtros, $idClasificacion, $idSubclasificacion) {
        if(isset($filtros['idClasificacion'])) {
            if($filtros['idClasificacion'] == '*') {
                echo ' selected';
            } else {
                if(isset($filtros['idSubclasificacion'])) {
                    if($filtros['idSubclasificacion'] == $idSubclasificacion) {
                        echo ' selected';
                    }
                } else {
                    if($filtros['idClasificacion'] == $idClasificacion) {
                        echo ' selected';
                    }
                }
            }
        } else {
            echo ' selected';
        }
    }
}
