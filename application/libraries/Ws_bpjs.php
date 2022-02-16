<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_bpjs {
	private $consid = "";
	private $secretKey = "";

	private $base_url = array(
		'vclaim' 	=> 'https://XX.bpjs-kesehatan.go.id:8080', //consid prod ws 1.1
		'aplicare' 	=> 'http://XX.bpjs-kesehatan.go.id:8888'
	);

	private	$svc_name = array(
		'vclaim' => 'new-vclaim-rest' //consid prod ws 1.1
	);


	public function ws_header_encript_MY(){
		$consid = $this->consid; //Ganti dengan consumerID dari BPJS
		$secretKey = $this->secretKey; //Ganti dengan consumerSecret dari BPJS
		// Computes the timestamp
		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', $consid."&".$tStamp, $secretKey, true);
	 	
		$encodedSignature = base64_encode($signature); // base64 encode…
		$urlencodedSignature = urlencode($encodedSignature); // urlencode…
		
		$arrheader =  array(
				'X-cons-id: '.$consid,
				'X-timestamp: '.$tStamp,
				'X-signature: '.$encodedSignature        
			);
		//	'Content-Type: application/x-www-form-urlencoded'  //jerone arrheader
		return $arrheader;

	}

	public function ws($app, $method, $path, $data_post){
		switch($app){
			case "vclaim":
				$url 	= $this->base_url[$app]."/".$this->svc_name[$app]."/".$path;
				break;
			case "aplicare":
				$url 	= $this->base_url[$app]."/".$path;
				break;
		}


		$arrheader = $this->ws_header_encript_MY();
		$ch= curl_init();
		
		switch($method){
			case "GET":
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_RETURNTRANSFER	=> 1
			      ));
				break;

			case "POST":
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER 	=> $arrheader,
			        CURLOPT_URL 		=> $url,
			        CURLOPT_POST 		=> 1,
			        CURLOPT_POSTFIELDS 	=> $data_post,
			        CURLOPT_RETURNTRANSFER=> 1
			      ));
				break;

			case "DELETE":
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_CUSTOMREQUEST 	=> "DELETE",
			        CURLOPT_POSTFIELDS 		=> $data_post,
			        CURLOPT_RETURNTRANSFER	=> 1
	      		));
				break;
		}

		/* curl_setopt_array($curl, array(
	            CURLOPT_URL => "http://example.com",
	            CURLOPT_RETURNTRANSFER => true,
	            CURLOPT_ENCODING => "",
	            CURLOPT_MAXREDIRS => 10,
	            CURLOPT_TIMEOUT => 30,
	            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	            CURLOPT_CUSTOMREQUEST => "POST",
	            CURLOPT_POSTFIELDS => "value1=111&value2=222",
	            CURLOPT_HTTPHEADER => array(
	                "cache-control: no-cache",
	                "content-type: application/x-www-form-urlencoded"
	            	)
	    				));
		*/
		

		$send = curl_exec($ch);
		curl_close($ch);//tambahan

		if($send===false){
			die("Error fetching data: ".curl_error($ch));
		}else{
			//$data_json= htmlspecialchars("$send", ENT_QUOTES);
		   	echo $send;
		}

	}




}


