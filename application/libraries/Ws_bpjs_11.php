<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_bpjs_11 {
	private $consid = "";
	private $secretKey = "";

	private $kodeppk_rscm = ""; // 2020.01.20

	private $base_url = array(
		'vclaim' 		=> 'https://XX.bpjs-kesehatan.go.id:8080', //consid prod ws 1.1
		'aplicare' 	=> 'http://XX.bpjs-kesehatan.go.id',
	);

	private	$svc_name = array(
		// 'vclaim' 	=> 'Vclaim-rest'
		'vclaim' => 'new-vclaim-rest', //consid prod ws 1.1
		'aplicare' => 'aplicaresws', //consid prod ws 1.1
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
				//'Accept: application/json',
				'X-cons-id: '.$consid,
				'X-timestamp: '.$tStamp,
				'X-signature: '.$encodedSignature        
			);
		//	'Content-Type: application/x-www-form-urlencoded'  //jerone arrheader

		// TESTING
		// die(json_encode($arrheader));
		// X-cons-id: 16141
		// X-timestamp: 1579512534
		// X-signature: W6Foe50wYEOEf6qN3rCqjEqEEXtdQqqht2QEbXvxgMU=
		//\TESTING


		return $arrheader;

	}


	public function ws_header_aplicare_encript_MY(){
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
				//'Accept: application/json',
				'X-cons-id: '.$consid,
				'X-timestamp: '.$tStamp,
				'X-signature: '.$encodedSignature,
				'Content-Type: application/json',
			);
		//	'Content-Type: application/x-www-form-urlencoded'  //jerone arrheader

		// TESTING
		// die(json_encode($arrheader));
		// X-cons-id: 16141
		// X-timestamp: 1579512534
		// X-signature: W6Foe50wYEOEf6qN3rCqjEqEEXtdQqqht2QEbXvxgMU=
		//\TESTING


		return $arrheader;

	}

	public function ws($app, $method, $path, $data_post){
		switch($app){
			case "vclaim":
				$url 	= $this->base_url[$app]."/".$this->svc_name[$app]."/".$path;
				break;
			case "aplicare":
				// $url 	= $this->base_url[$app]."/".$path;
				$url 	= $this->base_url[$app]."/".$this->svc_name[$app]."/".$path;
				break;
		}


		$arrheader = $this->ws_header_encript_MY();
		$ch= curl_init();
		
		switch($method){
			case "GET":
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_RETURNTRANSFER => 1, //batas
			        //CURLOPT_ENCODING => "",
			        //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			        CURLOPT_SSL_VERIFYPEER => 0,	//tambahan HTTPS
			        CURLOPT_SSL_VERIFYHOST => 0 	//tambahan HTTPS
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
			        CURLOPT_SSL_VERIFYHOST  => 0 	//tambahan HTTPS
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
			        CURLOPT_SSL_VERIFYHOST  => 0 	//tambahan HTTPS
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
	
	


	
	// WS RETURN
	public function ws_arr($app, $method, $path, $data_post){
		switch($app){
			case "vclaim":
				$url 	= $this->base_url[$app]."/".$this->svc_name[$app]."/".$path;
				break;
			case "aplicare":
				// $url 	= $this->base_url[$app]."/".$path;
				$url 	= $this->base_url[$app]."/".$this->svc_name[$app]."/".$path;
				break;
		}


		$arrheader = $this->ws_header_encript_MY();
		if($app == 'aplicare'){
			array_push($arrheader, "Content-Type: application/json");	
		}

		


    $ch= curl_init();
    $timeout = 10; // second
		
		switch($method){
			case "GET":
				$setopt_arr = [
					CURLOPT_HTTPHEADER 		=> $arrheader,
					CURLOPT_URL 			=> $url,
					CURLOPT_RETURNTRANSFER => 1, //batas
					//CURLOPT_ENCODING => "",
					//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_SSL_VERIFYPEER => 0,	//tambahan HTTPS
					CURLOPT_SSL_VERIFYHOST => 0, 	//tambahan HTTPS
					CURLOPT_TIMEOUT => $timeout,
				];
								
				break;

			case "POST":
				$setopt_arr = [
					CURLOPT_HTTPHEADER 		=> $arrheader,
					CURLOPT_URL 			=> $url,
					CURLOPT_POST 			=> 1,
					CURLOPT_POSTFIELDS 		=> $data_post,
					CURLOPT_RETURNTRANSFER  => 1,
					CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					CURLOPT_TIMEOUT => $timeout,
				];
					
				break;
			
			case "PUT":
				$setopt_arr = [
					CURLOPT_HTTPHEADER 		=> $arrheader,
					CURLOPT_URL 			=> $url,
					CURLOPT_CUSTOMREQUEST 	=> "PUT",
					CURLOPT_POSTFIELDS 		=> $data_post,
					CURLOPT_RETURNTRANSFER  => 1,
					CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					CURLOPT_TIMEOUT => $timeout,
			  ];
				break;

			case "DELETE":
				$setopt_arr = [
					    CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_CUSTOMREQUEST 	=> "DELETE",
			        CURLOPT_POSTFIELDS 		=> $data_post,
			        CURLOPT_RETURNTRANSFER	=> 1,
			        CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					    CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					    CURLOPT_TIMEOUT => $timeout,
				];
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
		
		curl_setopt_array($ch, $setopt_arr);

		// AKTIFKAN INI UNTUK TESTING, BACA DATA YG AKAN DIKIRIM
		$cek = [
			"url" => $url,
			"arrheader" => $arrheader,
			"data_post" => $data_post,
			"setopt_arr" => $setopt_arr,
		];
		// die(json_encode($cek));




		$send = curl_exec($ch);
		// die( "<pre>",print_r($send),"</pre>" );

		// if (curl_errno($ch)) {
		// 	$error_msg = curl_error($ch);
		// 	echo $error_msg; exit;
		// }
		

		curl_close($ch);//tambahan

		if($send===false){
			
			// die("Error fetching data: ".curl_error($ch));
			// $error = [
      //   "metaData" => [
      //     "label" => "error_my_curl",
      //     "code" => 21,
      //     "status" => "failed",
      //     "message" => "Koneksi bermasalah. BPJS error nasional.",
      //     "path" => $path,
      //   ],
      //   "response" => null,    
			// ];
			// echo json_encode($error); // LANGSUNG ECHO JSON. TERUS DI EXIT, SUPAYA PROGRAM LANGSUNG BERHENTI DISINI.
			
			return null; exit;
		}else{
			//$data_json= htmlspecialchars("$send", ENT_QUOTES);
		  return json_decode($send,1);
		}

	}




}


