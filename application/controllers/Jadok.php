<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// TIDAK DIGUNAKAN. DIPENCARIAN FILE : "jadok/" -> no result found 
class Jadok extends CI_Controller {
	public function __construct()
 	{
 		parent::__construct();
		//$this->load->helper('url');
 		//$this->load->model('m_absensi');
 	}

	public function index(){
		$this->load->model('m_dokter');
	}

	public function dokter_daftar(){
		//$this->load->view('cek_noka');
		$this->load->model('m_dokter');
		$data['dokter_daftar'] = $this->m_dokter->get_dokter();
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2),$data);
	}


	public function ex_daftarpasien(){
		$this->load->model('m_absensi');
		$data['fotrbooking']=$this->m_absensi->get_all_books();
		$this->load->view($this->uri->segment(1)."/"."v_absensi",$data);
	}

}
