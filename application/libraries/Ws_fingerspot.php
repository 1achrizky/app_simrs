<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws_fingerspot {
  private $consid = "16141";
 
  public function webservice($port,$url,$parameter){
    $curl = curl_init();
    set_time_limit(0);
    curl_setopt_array($curl, array(
      CURLOPT_PORT => $port,
      CURLOPT_URL => "http://".$url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $parameter,
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded"
        ),
      )
    );
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      $response = ("Error #:" . $err);
    }else{
      $response;
    }
    // return $response;
    return json_decode($response,1);
  }

}