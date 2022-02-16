<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wsrscm extends CI_Controller {
	public function __construct(){
		parent::__construct();		
		date_default_timezone_set("Asia/Bangkok");
    // $this->mainlib->logged_in();
    // CHECK TOKEN
  }

  public function px_rs($norm=null){
    $res = [];
		$post = json_decode(file_get_contents( 'php://input' ),1);
    $reqHeaders = apache_request_headers();
    echo '<pre>',print_r($reqHeaders),'</pre>'; exit;


    $this->load->model('m_daftarmandiri');
    $px_rs = $this->m_daftarmandiri->gd_pasien_rscm_by_norm_n($norm);	
    echo json_encode($px_rs);
  }
  

  public function get_jadok(){
    $res = [];
		// $post = json_decode(file_get_contents( 'php://input' ),1);
    $reqHeaders = apache_request_headers();
    // echo '<pre>',print_r([$reqHeaders, $hariId]),'</pre>'; exit;


    $this->load->model('m_daftarmandiri');
    $jd = $this->m_daftarmandiri->get_jadok_all();	
    echo json_encode($jd);
  }
}