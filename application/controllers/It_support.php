<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class It_support extends CI_Controller {
	protected $user_verify = false;
	protected $user_it = ["rizky", "anton"];

	public function index(){
		//$this->load->view($this->uri->segment(1)."/"."sep_create_tes");
	}

	public function tindakan_hapus(){
		$username = $this->session->username;		
		if(in_array($username, $this->user_it)) $this->user_verify = true;
		
		if($this->user_verify){
			$data = [ "username" => $username ];
			$this->load->view("template/header" , $data);
			$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
			$this->load->view("template/footer");
		}else{
			echo "Not found. Go to <a href='".base_url()."'>home</a>";
		}
	}

	public function kamar_hapus(){
		$username = $this->session->username;		
		if(in_array($username, $this->user_it)) $this->user_verify = true;
		
		if($this->user_verify){
			$data = [ "username" => $username ];
			$this->load->view("template/header" , $data);
			$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
			$this->load->view("template/footer");
		}else{
			$this->load->view("main/index");
		}
	}

	public function ganti_penanggung(){
		$username = $this->session->username;		
		if(in_array($username, $this->user_it)) $this->user_verify = true;

		if($this->user_verify){
			$data = [ "username" => $username ];
			$this->load->view("template/header" , $data);
			$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
			$this->load->view("template/footer");
		}else{
			echo "Not found. Go to <a href='".base_url()."'>home</a>";
		}
			
	}

	// // !!!TIDAK DIPAKAI
	// public function transfer_obat_tindakan(){
	// 	$username = $this->session->username;		
	// 	if(in_array($username, $this->user_it)) $this->user_verify = true;
		
	// 	if($this->user_verify){
	// 		$data = [ "username" => $username ];
	// 		$this->load->view("template/header" , $data);
	// 		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	// 		$this->load->view("template/footer");
	// 	}else{
	// 		$this->load->view("main/index");
	// 	}
			
	// }

	
	
	public function cek_pegawai_tidak_absen(){
		$username = $this->session->username;		
		if(in_array($username, $this->user_it)) $this->user_verify = true;

		if($this->user_verify){
			$data = array(
					"username"	=> $this->session->username
				);
			$this->load->view("template/header" , $data);
			$this->load->view($this->uri->segment(1)."/hrd/".$this->uri->segment(2));
			$this->load->view("template/footer");
		}else{
			$this->load->view("main/index");
		}
	}


	public function data_pasien_by_alamat(){
		$data = array(
				"username"	=> $this->session->username
			);
		$this->load->view("template/header" , $data);
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
		$this->load->view("template/footer");
	}

	public function billboard(){
		// $this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
		// $this->load->view("template/footer");


		$this->load->model("m_bed");
		// $onload = $this->m_bed->onload_bed_jadok(); // LAMA, ini harus ada countdown upload generate
		$onload = $this->m_bed->onload_bed_jadok_langsung();
		// echo json_encode($onload); exit;

		$this->load->view("it_support/billboard", $onload);
	}

	public function upload_data_billboard(){
		$data = ["username"	=> $this->session->username];

		$this->load->view("template/header" , $data);
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
		$this->load->view("template/footer");
	}

	public function upload_data_billboard_auto(){
		$data = [ "username" => $this->session->username ];
		$this->load->view("template/header" , $data);
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
		$this->load->view("template/footer");
	}

	


}
