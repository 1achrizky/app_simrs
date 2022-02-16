<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->mainlib->logged_in();
	}
	
	public function index(){
		$this->load->view($this->uri->segment(1)."/"."bpjs_umum");
	}


	public function user_level(){
		//$this->load->helper("form");
		$data = array(
				"username"	=> $this->session->username
			);
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2), $data);
	}

	public function printer(){
		$this->load->library("Print_kertas");
		// print_r($this->print_kertas->my_printer_list());

		$data = array(
				"username"	=> $this->session->username,
				"my_printer_list" => $this->print_kertas->my_printer_list()
			);

		$this->load->view("template/header" , $data);
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2), $data);
		$this->load->view("template/footer");
	}

	public function printer_list(){
		$this->load->library("Print_kertas");
	}

	public function file_template($file){
		// if($file == 'sep_resume_cetak'){
		// 	echo $file;
		// }
		$data = array(
				"noSep"   => "*SEP1234567890*",
				"norm"    => "123123",
				"alamat"  => "",
				"tglSep"  => date("Y-m-d"),
				"noKartu" => "",
				"nama"    => "",
				"nama_cm" => "",
				"tglLahir"=> "",
				"poli"    => "",
				"diagnosa"=> "",
				"catatan" => "",
				"umurSaatPelayanan" => "",
				"sex"     => "",

				"noTelepon"   => "",
				"provPerujuk" => "",
				"jnsPelayanan"=> "",
				"kelasRawat"  => "",
				"jnsPeserta"  => "",
				"asuransi"    => "",
				"penjamin"    => "",

				"billing"     => "BL".date("ymd").".0000",
				"lokasi_ket"  => "",
				"nama_dokter" => "",
				"penanggung_cm"=> "BPJS"
			);
		$this->load->view($this->uri->segment(2)."/".$this->uri->segment(3), $data);
	}

	

}
