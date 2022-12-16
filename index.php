<?php


class Sendeo
{

    public $token_login_data;
    public $token_url;


    public function __construct($musteri,$sifre)
    {

        $this->token_login_data       = json_encode(array("musteri"=> $musteri , "sifre" => $sifre));
        $this->token_url              = "https://api.sendeo.com.tr/api/Token/Login";

    }

    public function getToken() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, ''.$this->token_url.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$this->token_login_data");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = 'Accept: application/xml';
        $headers[] = 'Content-Type: application/json-patch+json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

		$status = array();

		if (curl_errno($ch)) {
			$status['status']      = false ;
			$status['token']       = "" ;
			$status['customer_id'] = "" ;
			$status['status_text'] = 'Error:' . curl_error($ch); 
		}
	
     
		$xml      = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
		$response = json_decode(json_encode($xml), TRUE);


        if ($response['StatusCode'] == 200) {
			
			$result     = (object)$response['result'];
			$CustomerId = $result->CustomerId;
			$Token      = $result->Token;
			
			$status['status']       = true ;
			$status['token']        = $Token ;
			$status['customer_id']  = $CustomerId ;
			$status['status_text']  = "";
        }
		
        if ($response['StatusCode'] == 400) {
        
			$status['status']       = false ;
			$status['token']        = "" ;
			$status['customer_id']  = "" ;
			$status['status_text']  = $response['exceptionMessage'];
		
        }
		
		return $status;
		

		curl_close($ch);
 
    }

}


$sendeo = new Sendeo("TEST","TesT.43e54");

$sendeo->getToken();


?>
