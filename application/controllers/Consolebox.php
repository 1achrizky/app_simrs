<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consolebox extends CI_Controller {
	// protected $user_verify = false;
	// protected $divisi = '';

	protected $menu_selected = '';
	// protected 


	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		// die('ini bo');
		// $this->mainlib->logged_in();
		$this->menu_selected = $this->uri->segment(2);
		if($this->menu_selected=='') $this->menu_selected = 'home';
		// echo($this->menu_selected);

		$data['menu_selected'] = $this->menu_selected;
		$li = $li = [
			[
				"file" => 'home',
				"label" => 'Home',
				"href" => base_url('consolebox'),
				"logo" => '<i class="fa fa-circle-o text-yellow"></i>',
			],
			[
				"file" => 'antrian_daftar',
				"label" => 'Antrian Daftar',
				"href" => base_url('consolebox/antrian_daftar'),
				"logo" => '<i class="fa fa-circle-o text-yellow"></i>',
			],
			[
				"file" => 'antrian_klinik',
				"label" => 'Antrian Klinik',
				"href" => base_url('consolebox/antrian_klinik'),
				"logo" => '<i class="fa fa-circle-o text-yellow"></i>',
				// "logo" => '<i class="fa fa-circle-o text-aqua"></i>',
			],
			[
				"file" => 'jadwal_dokter',
				"label" => 'Jadwal Dokter',
				"href" => base_url('consolebox/jadwal_dokter'),
				"logo" => '<i class="fa fa-circle-o text-yellow"></i>',
			],
			[
				"file" => 'ketersediaan_kamar',
				"label" => 'Ketersediaan <br> &nbsp;&nbsp;&nbsp;&nbsp; Kamar',
				"href" => base_url('consolebox/ketersediaan_kamar'),
				"logo" => '<i class="fa fa-circle-o text-yellow"></i>',
			],
		];
		$data['li'] = $li;

		$this->load->model("m_bed");
		$onload = $this->m_bed->onload_bed_jadok_langsung();
		$onload['onload']['beds'] = $onload['onload']['beds'][0];
		$onload['onload']['response'] = $onload['response'];
		$data['onload'] = $onload['onload'];

		$this->load->view('consolebox/header-console.php', $data);
	}
	
	public function index(){
		$this->load->view('consolebox/home');
		$this->load->view('consolebox/footer-console.php');
  }
	
	public function antrian_daftar(){
		$this->load->model('m_publik');
		$db = $this->m_publik->select_nomor_antridaftar_max(date('Y-m-d'));
		$this->load->view('consolebox/antrian_daftar', $db);
		$this->load->view('consolebox/footer-console.php');
  }
	
	public function antrian_klinik(){
		$this->load->view('consolebox/antrian_klinik');
		$this->load->view('consolebox/footer-console.php');
  }
	
	public function jadwal_dokter(){
		$this->load->view('consolebox/jadwal_dokter');
		$this->load->view('consolebox/footer-console.php');
	}
	
	public function ketersediaan_kamar(){
		$this->load->view('consolebox/ketersediaan_kamar');
		$this->load->view('consolebox/footer-console.php');
	}
	
	// public function __destruct(){
	// 	parent::__destruct();
	// 	$this->load->view('consolebox/footer-console.php');
	// }
  
}