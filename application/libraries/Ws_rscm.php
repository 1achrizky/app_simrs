<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_rscm {
	private $consid = "16141";
	private $secretKey = "8uG8E36B37";

	private $base_url = array(
		'vclaim' 	=> 'https://new-api.bpjs-kesehatan.go.id:8080', //consid prod ws 1.1
		'aplicare' 	=> 'http://dvlp.bpjs-kesehatan.go.id:8888', //ws1 pake ini

		'rscm' 			=> 'http://192.168.1.5/rscm/api',
		'rscm_web' 	=> 'http://citramedika.com',
		'rscmon_tes'=> 'http://192.168.1.68/rscm/rscmon/',
	);

	private	$svc_name = array(
		// 'vclaim' 	=> 'Vclaim-rest'
		'vclaim' 	=> 'new-vclaim-rest', //consid prod ws 1.1
		//'rscm' 	=> 'rest' //controller
		'rscm' 		=> 'ajaxreq', //controller
		'rscm_web' 	=> 'info' //controller
		// 'rscmon_tes' 	=> 'rscm/rscmon' //controller
	);


	public function ws_header_encript_MY(){
		$consid = $this->consid; //Ganti dengan consumerID dari BPJS
		$secretKey = $this->secretKey; //Ganti dengan consumerSecret dari BPJS
		// Computes the timestamp
		date_default_timezone_set('UTC');
		$ti = time();
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
				'X-ti: '.$ti
			);
		//	'Content-Type: application/x-www-form-urlencoded'  //jerone arrheader
		return $arrheader;

	}

	
	
	
	// WS RETURN
	public function ws_arr($app, $method, $path, $data_post){
		switch($app){
			case "rscmon_tes":
				$url 	= $this->base_url[$app].$path;
				break;

			case "rscm":
				$url 	= $this->base_url[$app]."/".$this->svc_name[$app]."/".$path;
				break;

			case "rscm_web":
				$url 	= $this->base_url[$app]."/".$this->svc_name[$app]."/".$path;
				break;

			case "base_url_post":
				$url 	= $path;
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

		
		curl_setopt_array($ch, $setopt_arr);

		// AKTIFKAN INI UNTUK TESTING, BACA DATA YG AKAN DIKIRIM
		// $cek = [
		// 	"url" => $url,
		// 	"arrheader" => $arrheader,
		// 	"data_post" => $data_post,
		// 	"setopt_arr" => $setopt_arr,
		// ];
		// die(json_encode($cek));




		$send = curl_exec($ch);
				

		curl_close($ch);//tambahan

		if($send===false){
			
			return null; exit;
		}else{
			//$data_json= htmlspecialchars("$send", ENT_QUOTES);
		  return json_decode($send,1); // ASLI
		  // return ["val" =>  json_decode($send,1) ];
		  // return $send;
		}

	}



}


