<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_bpjs_2 {
	private $consid = "";
	private $secretKey = "";
  private $user_key = ""; // +ws2.0
  
  private $tmStamp = null;

	private $kodeppk_rscm = ""; // 2020.01.20

	private $base_url = array(
		'vclaim' 		=> 'https://XX.bpjs-kesehatan.go.id:8080/new-vclaim-rest/', //consid prod ws 1.1
		'vclaimdev' 	=> 'https://XX.bpjs-kesehatan.go.id/vclaim-rest-dev/',
		'aplicare' 	=> 'http://XX.bpjs-kesehatan.go.id/aplicaresws/',
	);

	// public function __construct(){
	// 	parent::__construct();// you have missed this line.
	// 	$this->load->library('My_lzstring');
	// } 
		

	public function ws_header_encript_MY(){
		$consid = $this->consid; //Ganti dengan consumerID dari BPJS
		$secretKey = $this->secretKey; //Ganti dengan consumerSecret dari BPJS
		// Computes the timestamp
		date_default_timezone_set('UTC');
    $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
    $this->tmStamp = $tStamp;

		// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', $consid."&".$tStamp, $secretKey, true);
	 	
		$encodedSignature = base64_encode($signature); // base64 encode…
		$urlencodedSignature = urlencode($encodedSignature); // urlencode…
		
		$arrheader =  array(
				//'Accept: application/json',
				'X-cons-id: '.$consid,
				'X-timestamp: '.$tStamp,
        'X-signature: '.$encodedSignature,
        'user_key: '.$this->user_key,
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


  // function decrypt
  function stringDecrypt($key, $string){
    $encrypt_method = 'AES-256-CBC';

    // hash
    $key_hash = hex2bin(hash('sha256', $key));

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
    return $output;
  }
  
  // function lzstring decompress 
  // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
  function decompress($string){    // LAMA, AWAL COBA LZSTRING BISA
    // require_once dirname(__FILE__) . '/PHPExcel/PHPExcel/IOFactory.php';
    require_once dirname(__FILE__) . '/LZCompressor/LZString.php';
    require_once dirname(__FILE__) . '/LZCompressor/LZReverseDictionary.php';
    require_once dirname(__FILE__) . '/LZCompressor/LZData.php';
    require_once dirname(__FILE__) . '/LZCompressor/LZUtil.php';
    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
	}
	

	// function decompress($string){
	// 	$this->load->library('My_lzstring');
	// 	// return $this->my_lzstring->decompressFromEncodedURIComponent($string);
	// }
	
	

  function responseDecrypted($responseEncrypted){
    // MY_DECRYPT
    // $encryptedResponse = hasil langsung(pertama kali) dari curl BPJS

    // key enkripsi: consid + conspwd + timestamp request (concatenate string)
    $key = $this->consid . $this->secretKey . $this->tmStamp;

    // echo "<br><br>==============<br>";
    // $strDec = $this->stringDecrypt( $key, $res_enc['response']);
    $strDec = $this->stringDecrypt( $key, $responseEncrypted);
    // echo $strDec;

    // echo "<br><br>==============<br>";
    $decom = $this->decompress($strDec);
    $res = json_decode($decom, true);
    return $res;
  }

	
	// WS RETURN
	public function ws_arr($app, $method, $path, $data_post){
		// switch($app){
    //   case "vclaimdev":
		// 	case "vclaim":
		// 		$url 	= $this->base_url[$app].$path;
		// 		break;
		// 	case "aplicare":
		// 		// $url 	= $this->base_url[$app]."/".$path;
		// 		$url 	= $this->base_url[$app].$path;
		// 		break;
    // }
    
    $url 	= $this->base_url[$app].$path;

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
		
		date_default_timezone_set("Asia/Jakarta");
		
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
      // return json_decode($send,1); // ASLI PAKE INI SEBELUMNYA
      
      $curl_res = json_decode($send,1); // array
		  // metaData = tidak terenkripsi
		  // response = terenkripsi
		  // return $curl_res; // hasil asli, belum di decrypt

			if($curl_res['metaData']['code']=='200'){
				$val = $this->responseDecrypted($curl_res['response']);
				// $val = $this->responseDecrypted($send);
				// return $val;// terakhir kali pakai ini.
				$curl_res['response'] = $val;
			// 	return $curl_res;
			// }else{
			// 	return $curl_res;
			}
			
			return $curl_res;
      
		}

	}




}


