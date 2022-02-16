<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akreditasi extends CI_Controller {
	public function __construct(){
		parent::__construct();		
		date_default_timezone_set("Asia/Bangkok");
		$this->mainlib->logged_in();
  }

  public function insert_insiden( $table_name=null ){
    $this->load->model('m_main');
    
    $input = $this->input->get_post(NULL, TRUE);

    $input["user"] = $this->session->userdata("username");
    $input["date"] = date("Y-m-d");
    $input["time"] = date("H:i:s");

    // echo json_encode($input); exit;

		$result = $this->m_main->insert( $table_name, $input );
		echo json_encode($result);
	}
  
}