<?php

if ( ! function_exists('ac_agregar_etiqueta'))
{
	function ac_agregar_etiqueta($email_persona, $etiqueta)
	{
        $CI =& get_instance();

        $ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

        $contact_exists = $ac->api("contact/view?email=".$email_persona);

        if(!isset($contact_exists->id)) {
            return false;
        } else {
            $params = [
    			'email' => $email_persona,
    			'tags' => $etiqueta
    		];

    		$persona_update = $ac->api('contact/tag_add', $params);

            return true;
        }
	}
}

if ( ! function_exists('ac_quitar_etiqueta'))
{
	function ac_quitar_etiqueta($email_persona, $etiqueta)
	{
        $CI =& get_instance();

        $ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

        $contact_exists = $ac->api("contact/view?email=".$email_persona);

        if(!isset($contact_exists->id)) {
            return false;
        } else {
    		$params = [
    			'email' => $email_persona,
    			'tags' => $etiqueta
    		];

    		$persona_update = $ac->api('contact/tag_remove', $params);

            return true;
        }
	}
}

if ( ! function_exists('ac_obtener_perfil_persona'))
{
	function ac_obtener_perfil_persona($email_persona)
	{
        $CI =& get_instance();

        $ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

        $contact_exists = $ac->api("contact/view?email=".$email_persona);

        if(!isset($contact_exists->id)) {
            return false;
        } else {
            return $contact_exists;
        }
    }
}

if ( ! function_exists('ac_actualizar_genero_persona'))
{
	function ac_actualizar_genero_persona($email_persona, $genero)
	{
        $CI =& get_instance();

        $ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

        $contact_exists = $ac->api("contact/view?email=".$email_persona);

        if(!isset($contact_exists->id)) {
            return false;
        } else {

            if($genero == 'M') {
                $opcion = 'Masculino';
            } else if($genero == 'F') {
                $opcion = 'Femenino';
            } else {
                $opcion = '';
            }

            if($opcion != -1) {
                $params = [
        			'email' => $email_persona,
        			'field[3,0]' => $opcion
        		];

        		$persona_update = $ac->api('contact/sync', $params);
            }

            return true;
        }
    }
}

if ( ! function_exists('ac_actualizar_cumpleanos_persona'))
{
	function ac_actualizar_cumpleanos_persona($email_persona, $fecha)
	{
        $CI =& get_instance();

        $ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

        $contact_exists = $ac->api("contact/view?email=".$email_persona);

        if(!isset($contact_exists->id)) {
            return false;
        } else {

            if($fecha != '') {
                $params = [
        			'email' => $email_persona,
        			'field[2,0]' => date("Y-m-d", strtotime($fecha))
        		];

        		$persona_update = $ac->api('contact/sync', $params);
            }

            return true;
        }
    }
}

if ( ! function_exists('ac_actualizar_total_persona'))
{
	function ac_actualizar_total_persona($email_persona, $total)
	{
        $CI =& get_instance();

        $ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

        $contact_exists = $ac->api("contact/view?email=".$email_persona);

        if(!isset($contact_exists->id)) {
            return false;
        } else {

            $params = [
    			'email' => $email_persona,
    			'field[6,0]' => $total
    		];

    		$persona_update = $ac->api('contact/sync', $params);

            $info = $ac->api("deal/list?filters[email]=".$email_persona."&full=1&sort=id&sort_direction=DESC");
            $deal = array(
                'id' => $info->deals[0]->id,
                'value' => $total
            );
            $ac->api('deal/edit', $deal);

            return true;
        }
    }
}

if ( ! function_exists('ac_actualizar_deal_total_persona'))
{
	function ac_actualizar_deal_total_persona($email_persona, $total)
	{
        $CI =& get_instance();

        $ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

        $contact_exists = $ac->api("deal/edit?email=".$email_persona);

        if(!isset($contact_exists->id)) {
            return false;
        } else {

            $params = [
    			'email' => $email_persona,
    			'field[6,0]' => $total
    		];

    		$persona_update = $ac->api('contact/sync', $params);

            return true;
        }
    }
}
