<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_eclaim {
	///////////////// INACBG ////////////////////////
	//Encryption Key>> Integrasi SIMRS
	//$key = "595ae4e87fc1cacd36c82b92c9153f05f4220f386d0a89b2d2c4f5add5c40321"; 
	private $key 	= "b866a94e7f6c134d73614872834b88ea149bf1a2f228a7a6ba5f07bdaf45e70f"; //Generated Datetime	2018-04-09 10:56:26
	private $koders = "3515131";
	private $url 	= "http://192.168.1.89/E-Klaim/ws.php";

	///////////////// INACBG \////////////////////////

	public function ws($method, $json_request, $print=null){
		
		$url = $this->url;
		// data yang akan dikirimkan dengan method POST adalah encrypted:
		$payload = $this->inacbg_encrypt($json_request, $this->key);
		$data_post = $payload;
		// tentukan Content-Type pada http header
		$arrheader = array("Content-Type: application/x-www-form-urlencoded");
		
		// $arrheader = $this->ws_header_encript_MY();
		$ch= curl_init();
		
		switch($method){
			case "GET":
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_RETURNTRANSFER  => 1, //batas
			      ));
				break;

			case "POST":
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_POST 			=> 1,
			        CURLOPT_POSTFIELDS 		=> $data_post,
			        CURLOPT_RETURNTRANSFER  => 1,
			      ));
				break;

			case "DELETE":
				curl_setopt_array($ch, array(
					CURLOPT_HTTPHEADER 		=> $arrheader,
			        CURLOPT_URL 			=> $url,
			        CURLOPT_CUSTOMREQUEST 	=> "DELETE",
			        CURLOPT_POSTFIELDS 		=> $data_post,
			        CURLOPT_RETURNTRANSFER	=> 1,
	      		));
				break;
		}
		

		$exec = curl_exec($ch);
		$send = $this->_response( $exec );

		curl_close($ch);//tambahan

		if($send===false){
			die("Error fetching data: ".curl_error($ch));
		}else{
			// //$data_json= htmlspecialchars("$send", ENT_QUOTES);
			// if($print){
			// 	return $send;
			// }else{				
			// 	// echo $send; // IKI ERROR KALO ECHO DI PENDAFTARAN RI
			// 	return $send;
			// }

			return $send;
		}

	}



	// Encryption Function
	function inacbg_encrypt($data, $key) {
		/// make binary representasion of $key
		$key = hex2bin($key);
		/// check key length, must be 256 bit or 32 bytes
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}
		/// create initialization vector
		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		$iv 	 = openssl_random_pseudo_bytes($iv_size); // dengan catatan dibawah
		/// encrypt
		$encrypted = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv );

		/// create signature, against padding oracle attacks
		$signature = mb_substr( hash_hmac("sha256", $encrypted, $key, true),0,10,"8bit");
		
		/// combine all, encode, and format
		$encoded = chunk_split(base64_encode($signature.$iv.$encrypted));
		return $encoded;
	}


		// Decryption Function
	function inacbg_decrypt($str, $strkey){
		/// make binary representation of $key
		$key = hex2bin($strkey);
		/// check key length, must be 256 bit or 32 bytes
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}

		/// calculate iv size
		$iv_size 	= openssl_cipher_iv_length("aes-256-cbc");
		/// breakdown parts
		$decoded 	= base64_decode($str);
		$signature 	= mb_substr($decoded,0,10,"8bit");
		$iv 		= mb_substr($decoded,10,$iv_size,"8bit");
		$encrypted 	= mb_substr($decoded,$iv_size+10,NULL,"8bit");
		/// check signature, against padding oracle attack
		$calc_signature = mb_substr( hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit");

		if(!$this->inacbg_compare($signature,$calc_signature)) {
			return "SIGNATURE_NOT_MATCH"; /// signature doesn't match
		}

		$decrypted = openssl_decrypt($encrypted, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
		return $decrypted;
	}

	/// Compare Function
	function inacbg_compare($a, $b) {
		/// compare individually to prevent timing attacks
		/// compare length
		if (strlen($a) !== strlen($b)) return false;
		/// compare individual
		$result = 0;
		for($i = 0; $i < strlen($a); $i ++) {
			$result |= ord($a[$i]) ^ ord($b[$i]);
		}
		return $result == 0;
	}

	/// Respon Function
	function _response($response) {
		$first = strpos($response, "\n")+1;
		$last = strrpos($response, "\n")-1;
		$response = substr(
			$response,
			$first,
			strlen($response) - $first - $last
		);

		$response = $this->inacbg_decrypt($response,$this->key);
		//===========echo $response."{inacbg_decrypt}<br>";
		return $response;
	}



	function ws_eclaim_method_cetak($response){
		$msg = json_decode($response,true);
	
		////echo $msg['data']."{msg json}<br>";
	
		
		// variable data adalah base64 dari file pdf
		$pdf = base64_decode($msg["data"]);
		// hasilnya adalah berupa binary string $pdf, untuk disimpan:
		file_put_contents("klaim.pdf",$pdf);
	
		
		// atau untuk ditampilkan dengan perintah:
		header("Content-type:application/pdf");
		//header("Content-Disposition:attachment;filename='klaim.pdf'");
		header("Content-Disposition:attachment;filename=klaim.pdf");
		echo $pdf;
	}





	// TEMPLATE WS ECLAIM
	
	// 5, 6
	public function grouper($stage=1, $nomor_sep=null, $special_cmg=null){
		$a = [
			"metadata" => [
				"method" => "grouper",
				"stage" => $stage,
			],
			"data" => [
				"nomor_sep" => $nomor_sep,
			],
		];
		
		if($stage == 2) 
			$a["data"]["special_cmg"] = $special_cmg;
		
		return $a;
	}
	
	// 18
	public function generate_claim_number(){
		$a = [
			"metadata" => [
				"method" => "generate_claim_number",
			],
			"data" => [
				"payor_id" => "71",
			],
		];
		return $a;
	}
	

	// 19
	/* Untuk method file_upload / file_delete boleh dipanggil kapan saja 
		asalkan setelah method new_claim dan sebelum method claim_final
	*/ 
	public function file_upload($nomor_sep=null, $file_class=null, $file_name=null, $binary_file=null){
		$a = [
			"metadata" => [
				"method" => "file_upload",
				"nomor_sep" => $nomor_sep,
				"file_class"=> $file_class,
				"file_name" => $file_name,
			],
			"data" => $binary_file,
		];
		return $a;
	}
	//\TEMPLATE WS ECLAIM

}


