<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_bpjs11 extends CI_Controller {
	protected $config_bpjs = [
    "consid" => "",
	];
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");

    }

	public function index(){
		//echo 'ajax';
		
	}


	//================================================
	//==================== BPJS ======================
	//================================================

	public function peserta_cari(){ //wes ganti, iki lama
		$get = $this->input->get(NULL, TRUE);
		$path = 'Peserta/nokartu/'.$get['noKartu'].'/tglSEP/'.$get['tglSep'];
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	

	public function peserta_cari_by_nik(){ //wes ganti, iki lama
		$get = $this->input->get(NULL, TRUE);
		$path = 'Peserta/nik/'.$get['nik'].'/tglSEP/'.$get['tglSep'];
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );		
	}


	

	


	// TIDAK DIPAKAI, WES GANTI ke sep_hapus_bpjs11
	// public function sep_hapus_bpjs(){		
	// 	$path = "SEP/Delete";
	// 	$json_request = array(
	// 			'request'	=> array(
	// 				't_sep' => array(
	// 						'noSep' => $this->input->post('nosep'),
	// 						'user'	=> $this->input->post('user')
	// 				)								
	// 			)
	// 	);
	// 	return json_encode( $this->ws_bpjs_11->ws('vclaim','DELETE',$path, json_encode($json_request) ) );
	// }



	//==================== ws1.1 ======================

	public function url($method=null){
    // $path = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    $fullpath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $baseurl_ws_replace = base_url($this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3)."/");
    $len = strlen( $baseurl_ws_replace );
    $path = substr($fullpath, $len);
    $x = [$fullpath, $baseurl_ws_replace, $len, $path];
    
    if($method == "GET"){
      $result = $this->ws_bpjs_11->ws_arr("vclaim", $method , $path, "");
    }else if($method == "POST"){
			// $input = $this->input->post(NULL, TRUE);
			$json_request = json_encode( $this->input->post(NULL,TRUE) );
      // $result = $this->ws_bpjs_11->ws_arr("vclaim", $method , $path, $json_request);
      $result = $this->ws_bpjs_11->ws("vclaim", $method , $path, $json_request);
    }else{
      return false;
    }
    echo json_encode($result);
	}
	

	public function pengajuanSEP(){
			$path = "Sep/pengajuanSEP"; //WS1.1
			
			// $input = $this->input->post(NULL,TRUE);
			// echo "<pre>",print_r($input),"</pre>";
			// exit;

    	$json_request = json_encode( $this->input->post(NULL,TRUE) );
    	// return json_encode( $this->ws_bpjs_11->ws("vclaim", "POST", $path, $json_request ) );
			// return json_encode( $this->ws_bpjs_11->ws_arr("vclaim", "POST", $path, $json_request ) );
			
    	// $json_request = $this->input->post(NULL,TRUE) ;
			echo json_encode( $this->ws_bpjs_11->ws_arr("vclaim", "POST", $path, $json_request ) );
	}
	
	
	public function aprovalSEP(){
			$path = "Sep/aprovalSEP";
    	$json_request = json_encode( $this->input->post(NULL,TRUE) );
			echo json_encode( $this->ws_bpjs_11->ws_arr("vclaim", "POST", $path, $json_request ) );
	}

	public function sep_create_bpjs(){
    	$path = "SEP/1.1/insert"; //WS1.1
    	$json_request = json_encode( $this->input->post(NULL,TRUE) );
    	return json_encode( $this->ws_bpjs_11->ws("vclaim", "POST", $path, $json_request ) );
	}

	public function peserta_cari_get(){
		$get = $this->input->get(NULL, TRUE);
		if(!isset($get['tglSep'])) $get['tglSep'] = date('Y-m-d');
		$path = 'Peserta/nokartu/'.$get['noKartu'].'/tglSEP/'.$get['tglSep'];
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, ""));
	}

	public function get_data_rujukan_by_noka(){
		$param = $this->input->get('noka');
		$path = 'Rujukan/Peserta/'.$param;
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, ""));
	}

	public function sep_cari_bpjs(){
		$param = $this->input->get('nosep');
		$path = "SEP/".$param;
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, ""));
	}

	public function ref_diagnosa(){
		$path = "referensi/diagnosa/".$this->input->get('diagnosa');
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, ""));
	}

	public function propinsi(){
		//$this->load->library('ws_bpjs_11');
		$path = "referensi/propinsi";
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, ""));
	}
	
	public function poli($param=null){ // KODE/NAMA POLI
		//$this->load->library('ws_bpjs_11');
		$path = "referensi/poli/".$param;
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, ""));
	}

	public function dokter_dpjp(){
		//{Base URL}/{Service Name}/referensi/dokter/pelayanan/{Parameter 1}/tglPelayanan/{Parameter 2}/Spesialis/{Parameter 3}
		$get = $this->input->get(NULL,TRUE);
		$path = "referensi/dokter/pelayanan/".$get['pelayanan']."/tglPelayanan/".$get['tglPelayanan']."/Spesialis/".$get['Spesialis'];
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	public function rujukan(){
		$param = $this->input->get('noRujukan');
		$path = 'Rujukan/'.$param;
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	public function rujukan_1record(){
		$get = $this->input->get(NULL,TRUE);
		$path = "Rujukan/Peserta/".$get['noka'];
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	public function rujukan_1record_rs_by_noka(){
		$get = $this->input->get(NULL,TRUE);
		$path = "Rujukan/RS/Peserta/".$get['noka'];
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	public function rujukan_multirecord(){
		///Rujukan/RS/Peserta/
		$get = $this->input->get(NULL,TRUE);
		//$path = "/Rujukan/RS/Peserta/".$get['noka']; //RS
		$path = "Rujukan/List/Peserta/".$get['noka']; //PCare
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	public function monitoring_dt_kunjungan(){
		$get = $this->input->get(NULL,TRUE);
		$path = "Monitoring/Kunjungan/Tanggal/".$get['Tanggal']."/JnsPelayanan/".$get['JnsPelayanan'];
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	public function monitoring_dt_history_pelayanan_px($noka=null, $tglmulai=null, $tglakhir=null){
		$path = "monitoring/HistoriPelayanan/NoKartu/".$noka."/tglAwal/".$tglmulai."/tglAkhir/".$tglakhir;
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}
	
	public function integrasi_sep_cbg($sep=null){
		$path = "sep/cbg/".$sep;
		return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	}

	
	public function update_tgl_pulang($noSep=null, $tglPulang=null){
		$path = "Sep/updtglplg";
		// $json_request = json_encode( $this->input->post(NULL,TRUE) );
		$datapost = [
			"request" =>[
				"t_sep" =>[
					"noSep" => $noSep,
					// "tglPulang" => $tglPulang." ".date("H:i:s"), /////$tglPulang,// ." ".date("H:i:s"),
					"tglPulang" => $tglPulang,
					"user" => $this->config_bpjs["consid"],
				]
			]
		];
		$json_request = json_encode( $datapost );
    echo json_encode( $this->ws_bpjs_11->ws_arr("vclaim", "PUT", $path, $json_request ) );
	}
	

	// public function monitoring_dt_history_pelayanan_px(){
	// 	$get = $this->input->get(NULL,TRUE);
	// 	$path = "monitoring/HistoriPelayanan/NoKartu/".$get['NoKartu']."/tglAwal/".$get['tglMulai']."/tglAkhir/".$get['tglAkhir'];
	// 	return json_encode( $this->ws_bpjs_11->ws("vclaim", "GET", $path, "") );
	// }

	public function sep_hapus_bpjs11(){	
		$get = $this->input->get(NULL,TRUE);
		$path = "SEP/Delete";
		$json_request = array(
				'request'	=> array(
					't_sep' => array(
							// 'noSep' => $get['nosep'],
							'noSep' => $get['noSep'],
							//'user'	=> 'candra'
							'user'	=> $get['user']
					)								
				)
		);
		return json_encode( $this->ws_bpjs_11->ws('vclaim','DELETE',$path, json_encode($json_request) ) );
	}


		//====================\ws1.1 ======================


	//================================================
	//====================/BPJS ======================
	//================================================




	//================================================
	//==================== APLICARE ==================
	//================================================
	public function referensi_kamar(){
		$param = $this->input->post('url_req');
		//return json_encode( aplicare_ws_get('aplicaresws/rest/ref/kelas') );
		return json_encode( aplicare_ws_get( $param ) );
	}

	public function insert_ruangan_baru(){
		//$param = $this->input->post('noRujukan');
		//$path = 'Rujukan/'.$param;

		$json_request = <<<EOT
        { 
        	"kodekelas":"$_POST[kodekelas]",
		    "koderuang":"$_POST[koderuang]",
		    "namaruang":"$_POST[namaruang]",
		    "kapasitas":"$_POST[kapasitas]",
		    "tersedia":"$_POST[tersedia]",
		    "tersediapria":"$_POST[tersediapria]",
		    "tersediawanita":"$_POST[tersediawanita]",
		    "tersediapriawanita":"$_POST[tersediapriawanita]"
		}
EOT;
		//echo $json_request;
		//vclaim_ws_post('SEP/insert',$json_request);
		// $this->load->library('vclaim_ws');
		// $this->vclaim_ws->ws_post('SEP/insert',$json_request);

		return json_encode( aplicare_ws_post($url_req,$json_request) );
	}



	//================================================
	//====================/APLICARE ==================
	//================================================






	


}
