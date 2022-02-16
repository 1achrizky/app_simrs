<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vclaim extends CI_Controller {
	protected $data;
	public function __construct(){
		parent:: __construct();

		$data = $this->data;
		$data = array(
				"username"	=> $this->session->username
			);
		$this->load->view("template/header" , $data);
	}

	
	public function index(){
		// $data = array(
		// 		"username"	=> $this->session->username
		// 	);
		// $this->load->view("template/header" , $data);
		$data = $this->data;
		$this->load->view($this->uri->segment(1)."/"."sep_create_tes");
		$this->load->view("template/footer");
	}

	public function sep_create_11(){
		// $data = array(
		// 		"username"	=> $this->session->username
		// 	);
		// $this->load->view("template/header" , $data);
		$data = $this->data;
		$this->load->view($this->uri->segment(1)."/"."sep_create_11");
		$this->load->view("template/footer");
	}

	public function peserta_cari(){
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}

	public function sep_create_tes(){
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}

	public function cetak_sep_resume(){
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}

	public function sep_cari(){
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}

	public function sep_cetak(){
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}

	public function sep_resume_cetak(){
		$this->load->view($this->uri->segment(1)."/file_template/".$this->uri->segment(2));
	}

	public function tes_cetak(){
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}

	public function tes_katalog_bpjs(){
		// $data = array(
		// 		"username"	=> $this->session->username
		// 	);
		$data = $this->data;
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2), $data);
		$this->load->view("template/footer");
	}


	public function __deconstruct(){ //durung kenek
		//parent:: __destruct();
		$this->load->view("template/footer");

	}
}
