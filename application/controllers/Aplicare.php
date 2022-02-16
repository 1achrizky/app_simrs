<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aplicare extends CI_Controller {
	public function __construct(){
	   parent::__construct();
	   //$this->ctrl = $this->router->fetch_class();;
	}

	public function index(){
		$this->load->view($this->uri->segment(1).'/index');
	}
	
	
	public function header_code(){
		echo json_encode($this->ws_bpjs_11->ws_header_encript_MY());
	}

	// $kodeppk = 0195R028
	public function referensi_kamar(){
		//$this->load->view($this->ctrl.'/kamar_ref.php');
		//////////echo aplicare_ws_get('aplicaresws/rest/ref/kelas');

		// echo $this->ws_bpjs->ws_get( $this->uri->segment(1),"aplicaresws/rest/ref/kelas");
		// echo $this->ws_bpjs11->ws_arr( $this->uri->segment(1),"aplicaresws/rest/ref/kelas");
		$path = "rest/ref/kelas";
		$data = $this->ws_bpjs_11->ws_arr("aplicare", "GET", $path, "");
		echo json_encode($data);
	}
	
	public function tbl_ketersediaan_kamar_rs($kodeppk=null, $start=null, $limit=null){
		$path = "rest/bed/read/".$kodeppk."/".$start."/".$limit;
		$data = $this->ws_bpjs_11->ws_arr("aplicare", "GET", $path, "");
		// echo "<pre>",print_r($data),"</pre>"; exit;

		$field = ["koderuang", "namaruang", "namakelas", "kodekelas", 
			"kapasitas", "tersedia", "rownumber",
			"tersediapriawanita", "lastupdate"
		];

		echo return_tbl_ws($data, $field);
	}
	
	public function ketersediaan_kamar_rs($kodeppk=null, $start=null, $limit=null){
		// EX: http://192.168.1.68/rscm/app_dev/aplicare/ketersediaan_kamar_rs/0195R028/1/100
		$path = "rest/bed/read/".$kodeppk."/".$start."/".$limit;
		$data = $this->ws_bpjs_11->ws_arr("aplicare", "GET", $path, "");
		echo json_encode($data);
	}
	
	
	// http://192.168.1.68/rscm/app_dev/aplicare/insert_tt_baru/GET/0195R028/KL2/DAHLIA/DAHLIA/3/1
	// public function insert_tt_baru($method=null, $kodeppk=null, $kodekelas=null, $koderuang=null, $namaruang=null, $kapasitas=null, $tersedia=null){
	public function insert_tt_baru($kodeppk=null, $kodekelas=null, $koderuang=null, $namaruang=null, $kapasitas=null, $tersedia=null){
		// EX: http://192.168.1.68/rscm/app_dev/aplicare/ketersediaan_kamar_rs/0195R028/1/100
		$path = "rest/bed/create/".$kodeppk;

		$send = [
			"kodekelas"	=> "VIP", 
			"koderuang"	=> "RG01", 
			"namaruang"	=> "Ruang Anggrek VIP", 
			"kapasitas"	=> "20", 
			"tersedia"	=> "10",
			"tersediapria"		=> "0", 
			"tersediawanita"	=> "0", 
			"tersediapriawanita"	=> "0",
		];

		// if($method=="GET"){
		// 	$send = [
		// 		"kodekelas"	=> $kodekelas, // "VIP", 
		// 		"koderuang"	=> $koderuang, // "RG01", 
		// 		"namaruang"	=> $namaruang, // "Ruang Anggrek VIP", 
		// 		"kapasitas"	=> $kapasitas, // "20", 
		// 		"tersedia"	=> $tersedia, // "10",
		// 		"tersediapria"		=> "0", 
		// 		"tersediawanita"	=> "0", 
		// 		"tersediapriawanita"	=> $tersedia,
		// 	];
		// }else if($method=="POST"){
		// 	$post = $this->input->post(NULL,TRUE);

		// 	$send = [
		// 		"kodekelas"	=> $post["kodekelas"], // "VIP", 
		// 		"koderuang"	=> $post["koderuang"], // "RG01", 
		// 		"namaruang"	=> $post["namaruang"], // "Ruang Anggrek VIP", 
		// 		"kapasitas"	=> $post["kapasitas"], // "20", 
		// 		"tersedia"	=> $post["tersedia"], // "10",
		// 		"tersediapria"		=> "0", 
		// 		"tersediawanita"	=> "0", 
		// 		"tersediapriawanita"	=> $post["tersedia"],
		// 	];
		// }


			
		// die(json_encode($send));
		$data = $this->ws_bpjs_11->ws_arr("aplicare", "POST", $path, json_encode($send) );
		echo json_encode($data);
	}
	
	
	public function update_tt($method=null, $kodeppk=null, $kodekelas=null, $koderuang=null, $namaruang=null, $kapasitas=null, $tersedia=null){
		// EX: http://192.168.1.68/rscm/app_dev/aplicare/ketersediaan_kamar_rs/0195R028/1/100
		$path = "rest/bed/update/".$kodeppk;
		
		if($method=="GET"){
			$send = [
				"kodekelas"	=> $kodekelas, // "VIP",
				"koderuang"	=> $koderuang, // "RG01",
				"namaruang"	=> $namaruang, // "Ruang Anggrek VIP",
				"kapasitas"	=> $kapasitas, // "20",
				"tersedia"	=> $tersedia, // "10",
				"tersediapria"		=> "0", 
				"tersediawanita"	=> "0", 
				"tersediapriawanita"	=> $tersedia,
			];
		}else if($method=="POST"){
			$post = $this->input->post(NULL,TRUE);

			$send = [
				"kodekelas"	=> $post["kodekelas"], // "VIP", 
				"koderuang"	=> $post["koderuang"], // "RG01", 
				"namaruang"	=> $post["namaruang"], // "Ruang Anggrek VIP", 
				"kapasitas"	=> $post["kapasitas"], // "20", 
				"tersedia"	=> $post["tersedia"], // "10",
				"tersediapria"		=> "0", 
				"tersediawanita"	=> "0", 
				"tersediapriawanita"	=> $post["tersedia"],
			];
		}else if($method=="MANUAL"){ 
			// TESTING BISA
			// http://192.168.1.68/rscm/app_dev/aplicare/update_tt/MANUAL/0195R028
			$send = [
				"kodekelas"	=> "KL3", // "VIP", 
				"koderuang"	=> "CEMARA", // "RG01", 
				"namaruang"	=> "CEMARA", // "Ruang Anggrek VIP", 
				"kapasitas"	=> 10, // "20", 
				"tersedia"	=> 7, // "10",
				"tersediapria"		=> "0", 
				"tersediawanita"	=> "0", 
				"tersediapriawanita"	=> 0,
			];
		}
			
		// die(json_encode($send));
		$data = $this->ws_bpjs_11->ws_arr("aplicare", "POST", $path, json_encode($send) );
		echo json_encode($data);
	}
	
	

	
	public function hapus_kamar($kodeppk=null, $kodekelas=null, $koderuang=null){
		// EX: http://192.168.1.68/rscm/app_dev/aplicare/ketersediaan_kamar_rs/0195R028/1/100
		$path = "rest/bed/delete/".$kodeppk;
		$send = [
				"kodekelas"	=> $kodekelas, // "VIP", 
				"koderuang"	=> $koderuang, // "RG01",
		];

		$data = $this->ws_bpjs_11->ws_arr("aplicare", "POST", $path, json_encode($send) );
		echo json_encode($data);
	}

}
