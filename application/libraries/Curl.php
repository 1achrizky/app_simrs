<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl {
	// private $consid = "16141";
	// private $secretKey = "8uG8E36B37";

	// private $base_url = array(
	// 	'vclaim' 	=> 'https://new-api.bpjs-kesehatan.go.id:8080', //consid prod ws 1.1
	// 	'aplicare' 	=> 'http://dvlp.bpjs-kesehatan.go.id:8888', //ws1 pake ini

	// 	'rscm' 			=> 'http://192.168.1.5/rscm/api',
	// 	'rscm_web' 	=> 'http://citramedika.com',
	// 	'rscmon_tes'=> 'http://192.168.1.68/rscm/rscmon/',
	// );

	// private	$svc_name = array(
	// 	// 'vclaim' 	=> 'Vclaim-rest'
	// 	'vclaim' 	=> 'new-vclaim-rest', //consid prod ws 1.1
	// 	//'rscm' 	=> 'rest' //controller
	// 	'rscm' 		=> 'ajaxreq', //controller
	// 	'rscm_web' 	=> 'info' //controller
	// 	// 'rscmon_tes' 	=> 'rscm/rscmon' //controller
	// );


	// public function ws_header_encript_MY(){
	// 	$consid = $this->consid; //Ganti dengan consumerID dari BPJS
	// 	$secretKey = $this->secretKey; //Ganti dengan consumerSecret dari BPJS
	// 	// Computes the timestamp
	// 	date_default_timezone_set('UTC');
	// 	$ti = time();
	// 	$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
	// 	// Computes the signature by hashing the salt with the secret key as the key
	// 	$signature = hash_hmac('sha256', $consid."&".$tStamp, $secretKey, true);
	 	
	// 	$encodedSignature = base64_encode($signature); // base64 encode…
	// 	$urlencodedSignature = urlencode($encodedSignature); // urlencode…
		
	// 	$arrheader =  array(
	// 			//'Accept: application/json',
	// 			'X-cons-id: '.$consid,
	// 			'X-timestamp: '.$tStamp,
	// 			'X-signature: '.$encodedSignature,
	// 			'X-ti: '.$ti
	// 		);
	// 	//	'Content-Type: application/x-www-form-urlencoded'  //jerone arrheader
	// 	return $arrheader;

	// }

	
	
	
	// WS RETURN
	public function ws_arr($app, $method, $path, $data_post){
		switch($app){
			
			case "base_url_post":
				$url 	= $path;
				break;
		}


    // $arrheader = $this->ws_header_encript_MY();
    $arrheader = null;
		
    $ch= curl_init();
    $timeout = 10; // second
		
		switch($method){
			case "GET":
				$setopt_arr = [
					// CURLOPT_HTTPHEADER 		=> $arrheader,
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


	public function sendRequest($action = "", $method = "GET", $data = "", $contenType = "application/json", $url = "", $headers=null) {

		$curl = curl_init();
		
		if($headers==null){
			$headers = array(
					"Accept: application/Json",
					// "X-rs-id: ".$this->ssconfig["id"],
					// "X-Timestamp: ".time(),
					// "X-pass: ".$this->ssconfig["key"]
			);
		}

		// exit(json_encode([$action, $method, $data, $contenType, $url, $headers]));
		
		// $url = ($url == '' ? $this->ssconfig["url"] : $url);
		
		curl_setopt($curl, CURLOPT_URL, $url."/".$action);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$headers[count($headers)] = "Content-type: ".$contenType;
		$headers[count($headers)] = "Content-length: ".strlen($data);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($curl);
		curl_close($curl);
		// exit($result);
		return $result;
	}			

}


