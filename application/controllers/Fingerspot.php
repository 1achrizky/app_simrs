<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fingerspot extends CI_Controller {
  protected $server_IP_dev = "192.168.1.68";
  
  // protected $config_bpjs = [
  //   "consid" => "",
  // ];

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");

  }

  public function device_info(){
    $this->load->model("m_fingerspot");
    $this->load->library("ws_fingerspot");
    $devinfo = $this->m_fingerspot->tb_device();
    $devinfo[0]['server_IP_dev'] = $this->server_IP_dev;
    // echo json_encode($devinfo); exit;

    $data = $devinfo[0];
    $sn = $data["device_sn"];
    $port = $data["server_port"];

    $url = $data["server_IP"]."/dev/info";
		$parameter = "sn=".$sn;
    $server_output = $this->ws_fingerspot->webservice($port,$url,$parameter);
    echo json_encode($server_output); exit;
    // echo $server_output;

  }
  
  public function allScan(){
    // scanlog.php/b_allScan
    $this->load->model("m_fingerspot");
    $this->load->model("m_main");
    $this->load->library("ws_fingerspot");

    $devinfo = $this->m_fingerspot->tb_device();
    $devinfo[0]['server_IP_dev'] = $this->server_IP_dev;
    // echo json_encode($devinfo); exit;

    $data = $devinfo[0];
    $sn = $data["device_sn"];
    $port = $data["server_port"];

    $session=true;
		$delSession=true;
		$pagingLimit= ''; // $_POST['i_pagingGetLog'];
		
		$url = $datadev['server_IP']."/scanlog/all/paging";
		
		while($session){
			$parameter = "sn=".$sn."&limit=".$pagingLimit;
			$server_output = $this->ws_fingerspot->webservice($port,$url,$parameter);
      // $content = json_decode($server_output);
      $content = $server_output; // $content ini format array. asli dari seller pake obj

      
			if(($content['Data'])>0){
				// if($delSession){
				// 	echo "<<Perintah Hapus>>";
				// 	$querydel= mysql_query("delete from tb_scanlog");
				//// 	$querydel= $this->m_main->delete('tb_scanlog');
				
				// 	if($querydel){}else{
				// 		echo '<script>alert ("Failed !")</script>';
				// 	}
				// 	$delSession=false;
				// }
					
				// foreach($content->Data as $entry){
				// 	$Jsn = $entry->SN;
				// 	$Jsd = $entry->ScanDate;
				// 	$Jpin = $entry->PIN;
				// 	$Jvm = $entry->VerifyMode;
				// 	$Jim = $entry->IOMode;
				// 	$Jwc = $entry->WorkCode;
				// 	$sqlinsertscan	= 'insert into tb_scanlog (sn,scan_date,pin,verifymode,iomode,workcode) values ("'.$Jsn.'","'.$Jsd.'","'.$Jpin.'","'.$Jvm.'","'.$Jim.'","'.$Jwc.'")';
        ////  samakan dulu label param arr_batch nya dengan field db
        //// 	$sqlinsertscan	= $this->m_main->insert_batch('tb_scanlog', $content['Data']);
				// 	$queryinsert	= mysql_query($sqlinsertscan);
        
        
				// 	//server RSCM
				// 	$sqlinsertscan	= 'insert into hrd_abs_log (reader_addr,reader_no,id,fddate) values ("192.168.1.20","'.$Jsn.'","'.$Jpin.'","'.$Jsd.'")';
        ////  samakan dulu label param arr_batch nya dengan field db
        //// 	$sqlinsertscan	= $this->m_main->insert_batch('hrd_abs_log', $content['Data']);
        //   $queryinsert	= mysql_query($sqlinsertscan);
        				
        // }
      }
        
    }

  }
  
  
  // NO USE
  // public function getNewScan(){
  //   // scanlog.php/b_getNewScan
  //   $this->load->model("m_fingerspot");
  //   $this->load->library("ws_fingerspot");
  //   $devinfo = $this->m_fingerspot->tb_device();
  //   $devinfo[0]['server_IP_dev'] = $this->server_IP_dev;
  //   // echo json_encode($devinfo); exit;

  //   $data = $devinfo[0];
  //   $sn = $data["device_sn"];
  //   $port = $data["server_port"];

    
	// 	$url = $data["server_IP"]."/scanlog/new";
	// 	$parameter = "sn=".$sn;
	// 	$server_output = webservice($port,$url,$parameter);
		
  //   echo json_encode($server_output); exit;
  //   // echo $server_output;

  // }


}