<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_sisrute {
  protected $config_sisrute = [
    "kode_rs"  =>  "3515131", // "16141",
    "pass"    => "12345",
  ];

	// private $consid     = $config_sisrute["kode_rs"]; // "16141";
	// private $secretKey  = $config_sisrute["pass"]; // "8uG8E36B37";

	private $base_url = "http://api.dvlp.sisrute.kemkes.go.id";


	public function ws_header_encript_MY(){
    // Id & Password yang diberikan kemkes
    // $id = 1000;
    // $pass = md5("X123X123");
    
    $id = $this->config_sisrute["kode_rs"];
    $pass = md5($this->config_sisrute["pass"]);
    // print_r([$id, $pass]);
    // exit;

    //Get Timestamp
    $dt = new DateTime(null, new DateTimeZone("UTC"));
    $timestamp = $dt->getTimestamp();

    // Generate Signature
    $key = $id."&".$timestamp;					
    $signature = base64_encode(hash_hmac("sha256", utf8_encode($key), utf8_encode($pass), true));

    // Contoh untuk mengakses referensi faskes
    // $url = "http://api.dvlp.sisrute.kemkes.go.id/referensi/faskes?query=wahidin";
    // $url = "http://api.dvlp.sisrute.kemkes.go.id/referensi/faskes/3515131";
    // $url = "http://api.dvlp.sisrute.kemkes.go.id/rumahsakit/rsdatauser";
    // $url = "http://api.dvlp.sisrute.kemkes.go.id/rujukan?tanggal=2019-10-26";
    // $url = ;
    // $method = "GET"; // POST / PUT / DELETE
    // $postdata = "";
    $headers = [
      "X-cons-id: ".$id,
      "X-Timestamp: ".$timestamp,
      "X-signature: ".$signature,
      "Content-type: application/json",
      // "Content-length: ".strlen($postdata)      
    ];
    return $headers;

	}

	
	// WS RETURN
	public function ws($app, $method, $path, $data_post){
		switch($app){
			case "sisrute":
				$url 	= $this->base_url."/".$path;
				break;
    }

    // print_r($url); exit;


    $arrheader = $this->ws_header_encript_MY();
    // print_r($arrheader); exit;

    $ch= curl_init();
    $timeout = 10; // second
		
		switch($method){
			case "GET":
				curl_setopt_array($ch, array(
					    CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_RETURNTRANSFER => 1, //batas
			        //CURLOPT_ENCODING => "",
			        //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			        CURLOPT_SSL_VERIFYPEER => 0,	//tambahan HTTPS
					    CURLOPT_SSL_VERIFYHOST => 0, 	//tambahan HTTPS
					    CURLOPT_TIMEOUT => $timeout,
			      ));
				break;

			case "POST":
				curl_setopt_array($ch, array(
					    CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_POST 			=> 1,
			        CURLOPT_POSTFIELDS 		=> $data_post,
			        CURLOPT_RETURNTRANSFER  => 1,
			        CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					    CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					    CURLOPT_TIMEOUT => $timeout,
			      ));
				break;
			
			case "PUT":
				curl_setopt_array($ch, array(
					    CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_CUSTOMREQUEST 	=> "PUT",
			        CURLOPT_POSTFIELDS 		=> $data_post,
			        CURLOPT_RETURNTRANSFER  => 1,
			        CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					    CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					    CURLOPT_TIMEOUT => $timeout,
			      ));
				break;

			case "DELETE":
				curl_setopt_array($ch, array(
					    CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_CUSTOMREQUEST 	=> "DELETE",
			        CURLOPT_POSTFIELDS 		=> $data_post,
			        CURLOPT_RETURNTRANSFER	=> 1,
			        CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					    CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					    CURLOPT_TIMEOUT => $timeout,
	      		));
				break;
		}

		

		$send = curl_exec($ch);
		curl_close($ch);//tambahan

		if($send===false){

			return null;
      exit;
		}else{
			//$data_json= htmlspecialchars("$send", ENT_QUOTES);
		  return json_decode($send,1);
		}

	}




}


