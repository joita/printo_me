<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dhltest extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

    function tracking()
    {
        $xmlData = '<?xml version="1.0" encoding="UTF-8"?>
        <req:KnownTrackingRequest xmlns:req="http://www.dhl.com"
        						xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        						xsi:schemaLocation="http://www.dhl.com
        						TrackingRequestKnown.xsd">
        	<Request>
        		<ServiceHeader>
        			<MessageTime>'.date("c").'</MessageTime>
        			<SiteID>DHLMexico</SiteID>
        			<Password>hUv5E3nMjQz6</Password>
        		</ServiceHeader>
        	</Request>
        	<LanguageCode>es</LanguageCode>
        	<AWBNumber>1780538701</AWBNumber>
        	<LevelOfDetails>ALL_CHECK_POINTS</LevelOfDetails>
        </req:KnownTrackingRequest>';


        $headers = array(
            "Content-Type: text/xml",
            "SOAPAction: \"/soap/action/query\"",
            "Content-length: " . strlen($xmlData)
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://xmlpitest-ea.dhl.com/XMLShippingServlet");
        curl_setopt($curl, CURLOPT_PORT , 443);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($curl);

        curl_close($curl);

        $xml = simplexml_load_string ($response);

        print "<pre>";
        print_r($xml);
        print "</pre>";
    }

}
