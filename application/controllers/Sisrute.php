<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sisrute extends CI_Controller {  
  protected $config_sisrute = [
    "kode_rs"  =>  "3515131",
    "pass"    => "12345",
  ];

	public function __construct(){
		parent::__construct();
    date_default_timezone_set("Asia/Bangkok");
    
    $this->load->library("ws_sisrute");
  }

  // public function ws_tes(){
  //   $path = "referensi/faskes?query=wahidin";
  //   $result = $this->ws_sisrute->ws("sisrute", "GET", $path, "");
  //   echo json_encode($result);
  // }
  
  public function url($method=null){
    // $path = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    $fullpath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $baseurl_ws_replace = base_url($this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3)."/");
    $len = strlen( $baseurl_ws_replace );
    $path = substr($fullpath, $len);
    $x = [$fullpath, $baseurl_ws_replace, $len, $path];
    
    if($method == "GET"){      
      $result = $this->ws_sisrute->ws("sisrute", $method , $path, "");
    }else if($method == "POST"){      
      $input = $this->input->post(NULL, TRUE);
      $result = $this->ws_sisrute->ws("sisrute", $method , $path, $input);
    }else{
      return false;
    }
    echo json_encode($result);
  }
  
  // public function url_post(){
  //   // $path = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
  //   $fullpath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  //   $baseurl_ws_replace = base_url($this->uri->segment(1)."/".$this->uri->segment(2)."/");
  //   $len = strlen( $baseurl_ws_replace );
  //   $path = substr($fullpath, $len);
    
  //   $result = $this->ws_sisrute->ws("sisrute", "GET", $path, "");
  //   echo json_encode($result);
  // }

  

}