<?php
class NuSoap_library
{
   function Nusoap_library()
   {
       require_once('lib/nusoap.php');
   }



function soaprequest($api_url, $service, $params,$api_username=null, $api_password=null)
{
 
    if ($api_url != '' && $service != '' && count($params) > 0)
    {
        $wsdl = $api_url."?WSDL";
        $client = new nusoap_client($wsdl, 'wsdl');

        if($api_username!=null && $api_password !=null){
            $client->setCredentials($api_username,$api_password);
        }
        
        
        $error = $client->getError();
        if ($error)
        {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            return false;
        }
        else
        {
            $result = $client->call($service, array('parameters' => $params), '', '', false, true);
            if ($client->fault) {
                echo '<h2>Fault</h2><pre>';
                print_r($result);
                echo '</pre>';
            } else {
                
                $err = $client->getError();
                if ($err) {
                    // Display the error
                    echo '<h2>Error</h2><pre>' . $err . '</pre>';
                } else {
                    // Display the result
                    return $result;
                }

               
            }
        }
    }
}

}