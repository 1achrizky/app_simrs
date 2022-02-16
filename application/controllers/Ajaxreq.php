<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxreq extends CI_Controller {

	protected $baseUrlWsPrinter = '192.168.1.104/rscm/wsprinter/wsprinter.php';

  protected $public_ip = '';
  
  protected $config_bpjs = [
    "consid" => "16141",
  ];

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");

  }

	public function index(){
		//echo 'ajax';		
	}

	public function myip(){
		echo "You didn't access this site.";
	}

	public function kuip(){
		// $externalContent = file_get_contents('http://checkip.dyndns.com/');
		// preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
		// // $public_ip_addr = $m[1];
		// // echo $public_ip_addr;

		// $this->public_ip = $m[1];
		// echo $this->public_ip;
		// $this->load->helper('site_helper');
		$this->public_ip = public_ip();
		echo $this->public_ip;
	}

	// public function terbilang($nominal=null){
	// 	$bilang = terbilang($nominal);
	// 	$kata = explode(" ", $bilang);
	// 	$val = [
	// 		"nominal" 	=> $nominal,
	// 		"terbilang" => $bilang,
	// 		"kata" 			=> $kata,
	// 		"nkata" 		=> count($kata),	
	// 	];
	// 	echo json_encode($val);
	// }



	//================================================
	//==================== BPJS ======================
	//================================================


		//==================== ws1.1 ======================

	// public function sep_create_bpjs(){ // pindah ke ajax_bpjs11
	// 	// $path = "SEP/insert"; // ws1.0
	// 	//   	$json_request = json_encode( $this->input->post(NULL,TRUE) );
	// 	//   	return json_encode( $this->ws_bpjs->ws("vclaim", "POST", $path, $json_request ) );
		    	
 //    	$path = "SEP/1.1/insert"; //WS1.1
 //    	$json_request = json_encode( $this->input->post(NULL,TRUE) );
 //    	return json_encode( $this->ws_bpjs->ws("vclaim", "POST", $path, $json_request ) );
 //    	//return json_encode( $this->ws_bpjs_1_1->ws("vclaim", "POST", $path, $json_request ) );

	// }


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
	
	public function referensi_kamar_tes(){
		// $param = $this->input->post('url_req');
		//return json_encode( aplicare_ws_get('aplicaresws/rest/ref/kelas') );
		$param = 'aplicaresws/rest/ref/kelas';
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




	//================================================
	//==================== RSCM ======================
	//================================================

	// public function db($class_name=null, $obj_name=null, $param=null){
	public function db($class_name=null, $obj_name=null, $param=null, $param2=null, $param3=null, $param4=null, $param5=null){
		$this->load->model($class_name);
		
		$fx = new $this->$class_name;
		$data = $fx->$obj_name($param, $param2, $param3, $param4, $param5);
		echo json_encode($data);
		
		// $fx = new $this->m_daftarmandiri();
		// $data = $fx->$obj_name();
		// echo json_encode($data);
	}
	
	
	public function xls($class_name=null, $obj_name=null, $param=null, $param2=null, $param3=null, $param4=null, $param5=null){
		$menit = 2;
		$settime = 60*$menit;
		set_time_limit($settime);
		
		$this->load->model($class_name);
		
		$fx = new $this->$class_name;
		$query = $fx->$obj_name($param, $param2, $param3, $param4, $param5);
		
		$set = setting_excel_table($obj_name);
		$filename = $_GET['filename'];
		$this->load->library('my_excel');
		$this->my_excel->data_array($filename, $set, $query);

	}




	//!! INI SUDAH DIPINDAH KE MODEL, BISA LANGSUNG DIPANGGIL DI MODEL.
	//!! periksa di _ajax
	//!! KALAU TIDAK DIPAKAI, HAPUS SAJA
	public function formdiagnosa_get_pxri_det($nobill=null){
		$this->load->model('m_daftarmandiri');
		// $this->db('m_daftarmandiri', 'formdiagnosa_pxri', $nobill);
		// fd=formdiagnosa
		$fd_pxdaf = $this->m_daftarmandiri->formdiagnosa_pxdaftar($nobill)[0];
		$fd_pxri = $this->m_daftarmandiri->formdiagnosa_pxdaftarri($nobill)[0];
		$fd_dokter = $this->m_daftarmandiri->get_dokter_luar_dalam($fd_pxri['TypeDokter'], $fd_pxri['DokterAwal']);
		if($fd_dokter==null){
			// INI ADA KARENA MENANGANI ERROR KODE DOKTER YG PERNAH TRAINING
			// saat di pendaftaran RI(akses pilihan dokter awal).
			// CONTOH: dr.Yudo dengan register training). HARUSNYA TIDAK DITAMPILKAN
			$fd_dokter = [
				"kode" => '',
				"nama" => '',
				"alamat" => '',
				"telp" => '',
			];
		}else{
			$fd_dokter = $fd_dokter[0];
		}

		$fd_bed = $this->m_daftarmandiri->get_kode_bed_formdiagnosa($fd_pxri['Kodebed'])[0];
		$fd_pelayanan = $this->m_daftarmandiri->get_kode_bed_formdiagnosa($fd_pxri['Kodebed'])[0];
		$val = [
			"fd_pxdaf"=> $fd_pxdaf,
			"fd_pxri" => $fd_pxri,
			"fd_bed" 	=> $fd_bed,
			"fd_dokter" 	=> $fd_dokter,
		];
		echo json_encode($val);

	}

	
	// public function kasus($operator=null, $DokterAwal=null){ //by NOKA
	// 	$this->load->model('m_daftarmandiri');
	// 	//$param='0001537332693';
	// 	//$param='0001537332692'; //kosong
	// 	$param = $this->input->post('noka');		
	// 	$data = $this->m_daftarmandiri->get_dokter_luar_dalam($operator, $DokterAwal);
	// 	echo json_encode($data);
	// }
	
	public function get_dokter_luar_dalam($operator=null, $DokterAwal=null){ //by NOKA
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_dokter_luar_dalam($operator, $DokterAwal);
		echo json_encode($data);
	}
	
	
	public function promasuk_initrm($promsk_kd=null, $norm=null){ //by NOKA
		$this->load->model('m_daftarmandiri');		
		$data = $this->m_daftarmandiri->promasuk_initrm($promsk_kd, $norm);
		echo json_encode($data);
	}
	
	public function gd_pasien_rscm(){ //by NOKA
		$this->load->model('m_daftarmandiri');
		//$param='0001537332693';
		//$param='0001537332692'; //kosong
		$param = $this->input->post('noka');		
		$data = $this->m_daftarmandiri->gd_pasien_rscm($param);
		echo json_encode($data);
	}

	public function gd_pasien_rscm_GET(){ //by NOKA
		$this->load->model('m_daftarmandiri');
		$param = $this->input->get('noka');		
		$data = $this->m_daftarmandiri->gd_pasien_rscm($param);
		echo json_encode($data);
	}

	public function gd_pasien_rscm_GET_WS_TX(){ //by NOKA
		$param = $this->input->get('noka');
		$path = 'gd_pasien_rscm_GET?noka='.$param;
		$val = $this->ws_rscm->ws_arr("rscm", "GET", $path, "");
		echo json_encode($val);
	}

	

	// public function gd_pasien_by_norm(){
	// 	$norm = $this->input->post('norm');

	// 	$this->load->model('m_daftarmandiri');
	// 	$data = $this->m_daftarmandiri->gd_pasien_by_norm($norm);
	// 	echo json_encode($data);
	// }

	public function gd_pasien_rscm_by_norm(){ //by NORM
		$this->load->model('m_daftarmandiri');
		//$param='0001537332693';
		//$param='0001537332692'; //kosong
		$param = $this->input->post('norm');		
		$data = $this->m_daftarmandiri->gd_pasien_rscm_by_norm($param);
		echo json_encode($data);
	}
	
		
	public function get_pxrs_by_norm($norm=null){ //by NORM
		$this->load->model('m_daftarmandiri');		
		$data = $this->m_daftarmandiri->get_pxrs_by_norm($norm);
		echo json_encode($data);
	}
	
	public function get_pxrs($param=null){ //by nama/param
		$this->load->model('m_daftarmandiri');		
		$data = $this->m_daftarmandiri->get_pxrs($param);
		echo json_encode($data);
	}

	public function gd_pasien_rscm_by_bill(){
		$this->load->model('m_daftarmandiri');
		$param = $this->input->get('nobill');		
		$data = $this->m_daftarmandiri->gd_pasien_rscm_by_bill($param);
		echo json_encode($data);
	}

	public function gd_pasien_rscm_by_bill_lokasi(){
		$this->load->model('m_daftarmandiri');
		$param = array(
				"nobill" => $this->input->get('nobill'),
				"lokasi" => $this->input->get('lokasi')
			);	
		$data = $this->m_daftarmandiri->gd_pasien_rscm_by_bill_lokasi($param);
		echo json_encode($data);
	}

	public function gd_pasien_rscm_by_bill_lokasi_new($nobill=null, $lokasi=null, $StatusDaftar=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_pasien_rscm_by_bill_lokasi_new($nobill, $lokasi, $StatusDaftar);
		echo json_encode($data);
	}

	public function gd_rujukan_rscm(){
		$param = $this->input->post('noRujukan');
		//$data = $this->m_daftarmandiri->gd_pasien_rscm($this->input->post('noka'));
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_rujukan_rscm($param);
		echo json_encode($data);
	}


	public function get_norm_by_noka(){
		$param = $this->input->post('noka');
		
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_norm_by_noka($param);
		echo json_encode($data);
	}

	public function get_flag_cetak_kartu(){
		$param = $this->input->post('norm');

		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_flag_cetak_kartu($param);
		echo json_encode($data);
	}

	public function update_noka_mst_pasien(){
		//$param = $this->input->post('norm');
		$params = array(
			'norm' => $this->input->post('norm'),
			'noka' => $this->input->post('noka')
		);

		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->update_noka_mst_pasien($params);
		echo json_encode($data);
	}

	public function select_agama($agama=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->select_agama($agama);
		echo json_encode($data);
	}
	
	public function update_agama($norm=null, $agama=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->update_agama($norm, $agama);
		echo json_encode($data);
	}
	
	public function update_suku_bangsa(){
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->update_suku_bangsa($post);
		echo json_encode($data);
	}

	public function get_bill_terakhir(){
		//if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) ){
			$this->load->model('m_daftarmandiri');
			$data = $this->m_daftarmandiri->get_bill_terakhir();
			echo json_encode($data);
		//}			
	}

	public function new_bill(){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->new_bill();
		echo json_encode($data);
	}

	public function create_bill(){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->create_bill();
		echo json_encode($data);
	}
	
	public function new_bill_by_php(){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->new_bill_by_php();

		$param 		= "0000";
		$n_repeat 	= strlen($param) - strlen($data[0]->nobill);
		$repeat 	= str_repeat("0",$n_repeat);
		$new_bill 	= "BL".date('ymd').".".$repeat.$data[0]->nobill;
		$new_bill_4d = $repeat.$data[0]->nobill;

		$arr = array(
				"new_bill" 	  => $new_bill,
				"new_bill_4d" => $new_bill_4d
			);
		echo json_encode($arr);
	}

	public function get_antrian_klinik(){
		//$param = $this->input->post('kode_lokasi');
		$param = $this->input->get('kode_lokasi');
		//$param = 21;
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_antrian_klinik($param);
		echo json_encode($data);
				
	}

	public function get_err_code(){
		$this->load->library('my_error');
		echo $this->my_error->err($this->input->get('err_code'));
		//echo $this->my_error->err('e_reg_rc_4');
	}

	public function gd_skdp(){
		$post = $this->input->post(NULL,TRUE);
		$params = array(
			'NoRM' => $this->input->post('NoRM')
		);		

		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_skdp($params);
		echo json_encode($data);
	}


	public function insert_daftar_rj_xrec(){
		$post = $this->input->post(NULL,TRUE);
		print_r($post);
		$this->load->model('m_daftarmandiri');
		//$this->m_daftarmandiri->insert_daftar_rj_xrec(json_encode($post));
		$this->m_daftarmandiri->insert_daftar_rj_xrec($post);
	}

	public function insert_daftar_rj(){
		$post = $this->input->post(NULL,TRUE);
		print_r($post);

		$data  = $post['data'];
		$data1 = $post['data1'];
		$data2 = $post['data2'];
		$flag  = $post['flag'];

	  $this->load->model('m_daftarmandiri');
		$this->m_daftarmandiri->insert_daftar_rj( $flag, $data, $data1, $data2);

	}






	// mencari persamaa 'nama instansi' dari BRIDGING BPJS dengan XLINK.
	// bila di XLINK tidak ada, akan di tambahkan langsung ke XLINK
	public function gd_instansi_cm(){ //by kode & nama
		$get = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->cek_kd_instansi_cm($get["kode"]);

		if($data['count'] == 0 ){ //bila instansi tidak ketemu, INSERT
			$data = array(
				"Keterangan" => $get["nama"],
				"kd_bpjs" 	 => $get["kode"]
			);
			$this->m_daftarmandiri->insert_kd_instansi_cm($data);
		}		

		$data = $this->m_daftarmandiri->gd_instansi_cm( $get["kode"] );
		echo json_encode($data);
	}

	
	public function gd_penanggung_cm(){
		$get = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_penanggung_cm( $get["penanggung"] );
		echo json_encode($data);
	}
	
	

	public function gd_dx_cm(){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_dx_cm();
		echo json_encode($data);
	}

	public function search_dx_cm($key=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->search_dx_cm($key);
		echo json_encode($data);
	}





	

	public function get_klinik(){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_klinik();
		echo json_encode($data);
	}

	public function get_klinik_ket(){
		$param = $this->input->post('kdpoli_dari_bpjs');
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_klinik_ket($param);
		echo json_encode($data);
	}

	public function get_jadok_all(){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_jadok_all();
		echo json_encode($data);
	}

	public function get_jadok_today(){
		//$fl_klinik = $this->input->post('fl_klinik');
		// $params = array(
		// 	'fl_klinik' => 0,
		// 	'spesialis' => 0
		// );
		
		$params = array(
			'fl_klinik' => $this->input->post('fl_klinik'),
			'spesialis' => $this->input->post('spesialis')
		);
		

		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_jadok_today($params);
		echo json_encode($data);
	}

	
	public function get_jadok_by_idhari(){
		//$fl_klinik = $this->input->post('fl_klinik');
		// $params = array(
		// 	'fl_klinik' => 0,
		// 	'spesialis' => 0,
		// 	'id_hari' => 2
		// );
		
		// $params = array(
		// 	'fl_klinik' => $this->input->post('fl_klinik'),
		// 	'spesialis' => $this->input->post('spesialis'),
		// 	'id_hari'	=> $this->input->post('id_hari')
		// );
		$params = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_jadok_by_idhari($params);
		echo json_encode($data);
	}

	public function get_jadok_by_namaspesialis(){
		$spesialis = $this->input->post('spesialis');

		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_jadok_by_namaspesialis($spesialis);
		echo json_encode($data);
	}

	// public function gd_booking(){
	// 	$param = $this->input->get('tgl');
	// 	//$param = "2018-08-20";
	// 	$this->load->model('m_daftarmandiri');
	// 	$data = $this->m_daftarmandiri->gd_booking($param);
	// 	echo json_encode($data);
	// }

	public function select_booking_count(){ // untuk dapatkan norequest booking
		$input = $this->input->get(NULL, TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->select_booking_count($input);
		echo json_encode($data);
	}

	public function gd_booking_by_datetime(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_booking_by_datetime($post['date'], $post['time']);
		echo json_encode($data);
	}

	public function delete_booking_by_date(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->delete_booking_by_date($post['date']);
		echo json_encode($data);
	}

	public function download_booking_xls(){
		$date = $this->input->get('tgl');
		// $q = "select nama, norm, noanggota, lokasi as kd_lokasi, lokasiket, dokter as kd_dokter, dokterket, time
		$q = "SELECT 
				nama, norm, noanggota, lokasi, lokasiket, 
				dokter, dokterket, flag, date, time
			from fotrbooking
			where  date= '".$date."'
			order by lokasiket, time";		

		$query = $this->db->query($q);

		$this->load->library('my_excel');
		$this->my_excel->set_query($query);
		$this->my_excel->set_header(array( 'time', 'Nama', 'norm', 'noanggota', 'Kode Lokasi', 'lokasiket', 'Kode Dokter', 'Nama Dokter', 'Flag'));
		$this->my_excel->set_column(array( 'time', 'nama', 'norm', 'noanggota', 'lokasi', 'lokasiket', 'dokter', 'dokterket', 'flag'));
		$this->my_excel->set_width(array(10, 30, 7, 15, 3, 15, 7, 20, 5));
		$this->my_excel->exportTo2007("Booking_".$date);
	}



	public function gd_pasienrj_by_date(){
		$param = $this->input->get('tgl');
		//$param = "2018-08-20";
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_pasienrj_by_date($param);
		echo json_encode($data);
	}

	public function laporan_pendaftaran_px($segment=null, $date=null){
		$this->load->model('m_daftarmandiri');
		if($segment=="ALL"){
			$segment_lbl = ["IGD", "RJ", "RI"];
			// $segment_lbl = ["UGD", "RJ"];
		}else if($segment=="IGD" || $segment=="RJ" || $segment=="RI"){
			$segment_lbl = [$segment];
		}else{
			$segment_lbl = null;
		}
		
		$result = [];
		for ($i=0; $i<count($segment_lbl) ; $i++) { 			 
			$data = $this->m_daftarmandiri->laporan_pendaftaran_px($segment_lbl[$i], $date)[0];
			array_push($result, $data);
		}
		// exit;

		// echo json_encode($result);

		$val = [];
		$cnt = 0;
		for ($i=0; $i < count($result) ; $i++) { 
			for ($j=0; $j < count($result[$i]) ; $j++) { 
				$val[$cnt] = $result[$i][$j];
				$cnt++;
			}
		}
		echo json_encode($val);
	}
	
	
	public function gd_logpendaftaranrj_by_date(){
		$param = $this->input->get('tgl');
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_logpendaftaranrj_by_date($param);
		echo json_encode($data);
	}

	public function gd_logpendaftaranrj_by_id(){
		$param = $this->input->get('id');
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_logpendaftaranrj_by_id($param);
		echo json_encode($data);
	}

	public function logdaftarrj_by_key($key_name=null, $key_value=null, $par1=null, $par2=null, $par3=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->logdaftarrj_by_key($key_name, $key_value, $par1, $par2, $par3);
		echo json_encode($data);
	}

	public function cari_namadokter_by_kddokter(){//????TES SAJA
		//$param = $this->input->get('tgl');
		//$param = "2018-08-20";
		$get = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->cari_namadokter_by_kddokter( $get['kddokter'] );
		echo json_encode($data);
	}


	public function get_st_bill_open_rm_by_norm_n($norm=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_st_bill_open_rm_by_norm_n( $norm );
		echo json_encode($data);
	}

	public function get_pelayanan_ri(){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_pelayanan_ri();
		echo json_encode($data);
	}
	
	
	public function cek_px_masuk($bpjs=0, $noka=null, $faskes=null){
    $this->load->model('m_daftarmandiri');
    $val = [];
		$errors = [];
		$bridging_error = 0;
		$bridging_error_message = "";
		$postmrs = 0;
		$postmrs_from_rscm = 1;
		// $postmrs_from_rscm_label = "RS Citra Medika";
		$postmrs_from_label = "";
		$norujukan_postmrs = null;
    $asalppk_postmrs = null;
		$status_billing = null;
		$status_aktif = null;
		$status_aktif_ket = null;
		$btn_lewati = 0;

		//VAR BRIDGING
		$histori = null;
		$multi_rjk = null;
		$px_bpjs = null;

    $cek_rjk = cek_rujukan_aktif("2019-04-19");
    // $cek_rjk["status"];
    
		if($bpjs){			

			//===== HISTORI ===
			$tglakhir= date("Y-m-d");
			$tglmulai= selisih_hari(date("Y-m-d"), "-30");

			$path = "monitoring/HistoriPelayanan/NoKartu/".$noka."/tglAwal/".$tglmulai."/tglAkhir/".$tglakhir;
			$histori = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");


			//kalau bridging BPJS tidak error, maka proses bridging dilanjutkan. 
			// bila error, maka proses bridging dibawah ini di lewati(tanpa bridging).
			// karena bridging yg pertama kali(di atas) ada checking bridging error/success juga.
		
			if($histori == null){
				$bridging_error = 1;

				$bridging_error_message = "Koneksi(Bridging) bermasalah. BPJS error nasional.";
				$error = error("bridging_error", "danger", "", $bridging_error_message);
				array_push($errors, $error);
			}else{
				//===== HISTORI RESPONSE ===
				
				// IF POSTMRS. JIKA JENIS PELAYANAN[0/terbaru] == RI(kode RI bpjs=1)
				if($histori["response"]["histori"][0]["jnsPelayanan"] == 1){ 
					$norujukan_postmrs = $histori["response"]["histori"][0]["noSep"];
					$postmrs = 1;
					$asalppk_postmrs = 2; // FKTL=RS

					$error = error("postmrs", "warning", "", "Pasien POST MRS.");
					array_push($errors, $error);

					if($postmrs == 1){
						$postmrs_from_label = $histori["response"]["histori"][0]["ppkPelayanan"];
						if($postmrs_from_label != "RS Citra Medika"){
							// if(count($histori["response"]["histori"])>=2){
							if(count($histori["response"]["histori"])>=3){
								if( $histori["response"]["histori"][2]["ppkPelayanan"] ==  "RS Citra Medika" ){
									// JIKA POST MRS dari RSCM
									$norujukan_postmrs = $histori["response"]["histori"][2]["noSep"];
									$btn_lewati = 1; // NJAGANI kalo misal monitoring histori :: [RI] RS SOETOMO (0), [IGD] RS SOETOMO, [RI] RSCM
									
									// $error = error("postmrs", "danger", "", "POST MRS(".$postmrs_from_label.").");
									// array_push($errors, $error);
								}else{
									// BUKAN DARI RSCM
									$postmrs_from_rscm = 0;		
									$error = error("postmrs", "danger", "", "POST MRS(".$postmrs_from_label.") selain dari RS. Citra Medika. Tidak boleh didaftarkan. ");
									array_push($errors, $error);									
								}
							}else{ // perbaikan BUG saat histori<2
								// BUKAN DARI RSCM
								$postmrs_from_rscm = 0;
								$error = error("postmrs", "danger", "", "POST MRS(".$postmrs_from_label.") selain dari RS. Citra Medika. Tidak boleh didaftarkan. ");
								array_push($errors, $error);	
							}

							
						}
						
					}
				}else{ // BUKAN POSTMRS (IGD)
					$asalppk_postmrs = 1; // FKTP
					
					$error = error("postmrs", "danger", "", "Bukan pasien POST MRS.");
					array_push($errors, $error);

					$btn_lewati = 1;
				}
				//=====\HISTORI ===



				//===== MULTI RUJUKAN ===
				if($postmrs == 1) $faskes=2;

				if($faskes==1){
					$path = "Rujukan/List/Peserta/".$noka; //PCare
				}else{
					$path = "Rujukan/RS/Peserta/".$noka; //RS
				}
					
				$multi_rjk = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");

				if($multi_rjk["metaData"]["code"] == 200){ // RUJUKAN AKTIF
					$rjk_opt_jsObj   = $multi_rjk["response"]["rujukan"];
					// show_mdl_multi_rjk();
				}else if($multi_rjk["metaData"]["code"] == 201){ 
					// RUJUKAN TIDAK ADA. Multi RJK =null && TIDAK ADA MASALAH PEMBAYARAN								
					$error = error("multirujukan", "danger", $multi_rjk["metaData"]["code"], $multi_rjk["metaData"]["message"]);
					array_push($errors, $error);

					// DIBAWAH INI DARI CODING JS
					// console.log([rujukan_jsObj.metaData.code, rujukan_jsObj.metaData.message]);
					// validate();
				}else{ 
					// >>Rujukan tidak ada & masalah kepesertaan(ADA PREMI)
					$error = error("multirujukan", "danger", $multi_rjk["metaData"]["code"], $multi_rjk["metaData"]["message"]);
					array_push($errors, $error);
					// $('#daftar_error').append( '<div class="alert alert-danger">'+rujukan_jsObj.metaData.message+'</div>' );
				}
				//=====\MULTI RUJUKAN ===


				//===== CARI PESERTA BPJS ===
				// $path = 'Peserta/nokartu/'.$get['noKartu'].'/tglSEP/'.$get['tglSep'];
				$path = 'Peserta/nokartu/'.$noka.'/tglSEP/'.date("Y-m-d");
				$px_bpjs = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");
				
				// cek status aktif
				if($px_bpjs["metaData"]["code"] == 201){ // BPJS : "Peserta Tidak Terdaftar"
					$error = error("px_terdaftar_bpjs", "danger", "", "Pesan BPJS : ".$px_bpjs["metaData"]["message"]);
					array_push($errors, $error);
				}else{
					if($px_bpjs["response"]["peserta"]["statusPeserta"]["kode"] == 0){ //AKTIF
						$status_aktif = 1;

					}else{
						$status_aktif = 0;
						
						$error = error("status_aktif", "danger", "", "Kartu BPJS pasien tidak aktif.");
						array_push($errors, $error);
					}

					$status_aktif_ket = $px_bpjs["response"]["peserta"]["statusPeserta"]["keterangan"];
				}

				//=====\CARI PESERTA BPJS ===

			}

		}

		


		// CEK:: PERNAH CETAK KARTU RS
		$pxrs = $this->m_daftarmandiri->get_pxrs($noka);
		$flagkartu = 0; // DECLARE
		if(count($pxrs) == 0 ){ // DATA PX HANYA ADA DARI BRIDGING. DI RS NDAK ADA. TIDAK BOLEH DIDAFTARKAN 
			
			// NOKA BELUM DI ISIKAN DI NORM nya. ATAU PASIEN BARU yg belum punya NORM
			$error = error("cetak_kartu", "danger", "", "Nomor Kartu JKN KIS belum terdaftar di sistem.");
			array_push($errors, $error);
			
		}else if(count($pxrs)==1){ // NOKA PASIEN ADA DI RS
			$flagkartu = (int)($pxrs[0]["flagkartu"]);
			if( $flagkartu == 0){ // BELUM CETAK KARTU
				$error = error("cetak_kartu", "danger", "", "Pasien belum pernah cetak kartu berobat rumah sakit.");
				array_push($errors, $error);

				// MEMBATASI MENGHILANGKAN TOMBOL LEWATI SAAT PX POSTMRS selain dari RSCM
				if($postmrs_from_rscm == 1){					
					$btn_lewati = 1;
				}

			}else{

			}

			// CEK STATUS BILL = OPEN/CLOSE
			$st_bill = $this->m_daftarmandiri->get_st_bill_open_rm_by_norm_n($pxrs[0]["NoRM"]);
			// LANJUTKAN .....
			// echo "<pre>",print_r($st_bill),"</pre>";
			// echo var_dump($st_bill);
			// exit;
			$status_billing = $st_bill["st_bill_rm"];
			if($status_billing == "open"){
				$error = error("status_billing", "danger", "", "Billing AKTIF. Tidak boleh mendaftar.");
				array_push($errors, $error);
			}else if($status_billing == "close"){
				//proses dilanjutkan. TERUSKAN
				if($bpjs){
					// JIKA STATUS_PESERTA AKTIF, && BILLING CLOSE, JALANKAN INI:
					// UPDATE NIK PESERTA ke NIK PX RS					
					if($status_aktif == 1){					
						$where = ["NoRM" => $pxrs[0]["NoRM"] ];
						$value = ["NoIdentitas" => $px_bpjs["response"]["peserta"]["nik"]];
						$update_nik = $this->m_daftarmandiri->update_new("fomstpasien", $value, $where);
					}
				}
				
			}
		}else{ // NOKA PASIEN ADA DI RS (GANDA). ADA DOUBLE RM. TIDAK BOLEH DAFTAR
			$error = error("cetak_kartu", "danger", "", "Nomor Kartu JKN KIS kembar dengan pasien lain.");
			array_push($errors, $error);
		}

		// -- cek PDP
		// $pdp = ($pxrs[0]['PDP'] == '1' && intval($pxrs[0]['PDPSelisihHari']) < 15) ? "Z038" : "";

		if( $pxrs[0]['PDP'] == '1' && intval($pxrs[0]['PDPSelisihHari']) < 15 ){
			$error = error("pdp", "danger", "", "Pasien PDP pada tanggal ".$pxrs[0]['PDPDate'].". (Berjalan ".$pxrs[0]['PDPSelisihHari']." hari)");
			array_push($errors, $error);
		}
		// --\cek PDP

		if($bpjs){
			$val = [
				"generate" => [
					"bridging_error"=> $bridging_error,
					"bridging_error_message"=> $bridging_error_message,
					"postmrs"      	=> $postmrs,
					"postmrs_from_rscm" => $postmrs_from_rscm,
					"postmrs_from_label"=> $postmrs_from_label,
					"asalppk_postmrs"   => $asalppk_postmrs,
					"norujukan_postmrs" => $norujukan_postmrs, // === $norujukan_postmrs = $histori["response"]["histori"][0]["noSep"],
					"status_aktif"      => $status_aktif,
					"status_aktif_ket"  => $status_aktif_ket,
					
					"flagkartu"  			=> $flagkartu,
					"status_billing"  => $status_billing,
					"btn_lewati"  		=> $btn_lewati,
					// "update_nik"  		=> $update_nik,
					"errors" => $errors,
				],
				"ws_rs" => [
					"get_pxrs" => $pxrs,
				],
				"bridging" => [
					"monitoring_histori"  => $histori,				
					"multi_rjk" 					=> $multi_rjk,
					"peserta_bpjs"        => $px_bpjs,
				],
			];
		}else{ // JIKA SELAIN BPJS(UMUM, PENANGGUNG LAIN)
			$val = [
				"generate" => [					
					"flagkartu"  			=> $flagkartu,
					"status_billing"  => $status_billing,
					"btn_lewati"  		=> $btn_lewati,
					"errors" => $errors,
				],
				"ws_rs" => [
					"get_pxrs" => $pxrs,
				],
			];
		}   

    // echo "<pre>",print_r($val),"</pre>";
    echo json_encode($val);
  }

  // KLIK DAFTAR BKP
	public function daftar_cek_bpjs($noka=null){ // JUST TRY
    // $input = $this->input->post(NULL, TRUE);
    $input = [
      "noRujukan_ppk2_bpjs" => "",
      "get_norm_cm" => "",
      "get_kode_lokasi" => 27,
      "get_kode_dokter" => "",
      "get_norujukan" => "",
      "get_kode_dokter" => "",
      "get_noka" => "",
      "get_jnsPelayanan" => "",
      "get_klsRawat" => "",
      "get_asalRujukan_bpjs" => "",
      "get_tglKunjungan" => "",
      "get_norujukan" => "",
      "get_ppkRujukan" => "",
      "catatan_sep" => "",
      "sel_diag_bpjs" => "",
      "get_poliKode_bpjs" => "",
      "kd_dpjp_bpjs" => "",
      "telp" => "",
    ];
    // get_noka, get_jnsPelayanan, get_klsRawat, get_norm_cm, get_asalRujukan_bpjs,
    // get_tglKunjungan, get_norujukan, get_ppkRujukan, catatan_sep,
    // sel_diag_bpjs, get_poliKode_bpjs, noskdp_bpjs, kd_dpjp_bpjs, telp, config_bpjs_consid

		$this->load->model('m_daftarmandiri');
		$get_norm_cm = "073673";
		$cek_bill_open = $this->m_daftarmandiri->get_st_bill_open_rm_by_norm_n( $get_norm_cm );
		// echo $cek_bill_open;
		if($cek_bill_open['st_bill_rm']=="open"){
			$val = [
				"status" => "failed",
				"message" => "Status Billing OPEN.",
			];
			echo json_encode($val); //?
			exit;
		}else{
			$get_asalRujukan_bpjs=1; //<<< $_POST:ASAL_RUJUKAN
			if($get_asalRujukan_bpjs == 2){ // jika PPK 2(RS)
				//console.log('<Log> Px MRS/dari PPK2');
				$get_norujukan = $input["noRujukan_ppk2_bpjs"]; //$('#noRujukan_ppk2_bpjs').val();
				$get_ppkRujukan= '0195R028';
      }
      
      $pasien_cm_Obj = $this->m_daftarmandiri->get_pxrs($get_norm_cm)[0]; //dari scan input rujukan
      // echo print_r($pasien_cm_Obj); exit;
      //pasien_cm_Obj = gd_pasien_rscm_by_norm(get_norm_cm);
      
			$get_bill = $this->m_daftarmandiri->create_bill();
      $get_bill_siap_pakai = $get_bill["new_bill"];
      $get_bill_4d         = $get_bill["new_bill_4d"];
      // console.log('get_bill_siap_pakai: '+get_bill_siap_pakai+'_&&_get_bill_4d: '+get_bill_4d);

			
			$tc["bill"] = date('H:i:s');
			$noskdp  = date('d').$get_bill_4d."/KP/".date('m')."/".date('Y');
			$noskdp_bpjs = date('d').$get_bill_4d;

			//===
			$get_kode_lokasi = $input["get_kode_lokasi"]; //<<< $_POST:KODE_LOKASI
   


			  $_FL_daftar_ugd = 0; // SAAT PILIHAN LOKASI DIKLIK IGD, BARU GANTI JADI $_FL_daftar_ugd=1
			//========
			  if($_FL_daftar_ugd == 0){ //JIKA BUKAN PASIEN UGD >> dapat antrian poli, cetak.
          $noantrian_ready = $this->m_daftarmandiri->ready_antrian_klinik($get_kode_lokasi);
          // $noantrian_ready_3digit = $noantrian_ready["3d"];
          // $noantrian_ready_full = $noantrian_ready["full"];
          $tc["noantrian"]    = date('H:i:s');
          $StatusDaftar_cm = 'RJ';
    
          $fotrdaftar_rj = [
            "NoBill"  => $get_bill_siap_pakai,
            "Lokasi"  => $get_kode_lokasi,
            "NoUrut"  => $noantrian_ready["full"],
            "typedokter"  => 1,
            "Dokter"      => $input["get_kode_dokter"],
            "Pemeriksaan" => 0,
            "Biaya"   => 0,
            "Total"   => 0,
            "PemeriksaanUpDisc" => 0,
            "BiayaUpDisc" => 0,
            "TotalUpDisc" => 0,
            "FlagDaftar" => 0,
            "Rujukan"     => $input["get_norujukan"], //$get_norujukan,
            "StatusPayment" => "B", //B=belum
            "KetRujukan"  => "",
            "Flagantrian" => 1,
            "tglrujukan"  => "", //>> $get_tglKunjungan,
            "User" => "", //>>$_user_logged_in,
            "Date" => date('Y-m-d'),
            "Time" => date('H:i:s'),
            "CaraMasuk"  => 1
          ];
    
          $fotrdaftar_pilih = $fotrdaftar_rj;
				
			  }else{ //JIKA PASIEN UGD
          $StatusDaftar_cm = 'UG';
    
          $fotrdaftar_ugd = [
            "nobill" => $get_bill_siap_pakai,
            "triage" => 0,
            "dokterrs" => "92516",
            "TypeDokterJaga" =>0,
            "dokterjaga" =>    "92516",
            "pemeriksaan" =>   0,
            "biaya" =>  0,
            "pemeriksaanupdisc" =>0,
            "biayaupdisc" =>  0,
            "total" =>        0,
            "totalupdisc" =>  0,
            "statuspayment" =>  "B",
            "keterangan" 	=> "",
            "kasuspolisi" => "T",
            "lokasi" =>     10,//U G D
            "flagdaftar" => 0,
            "user" => "", //>>$_user_logged_in,
            "date" => date('Y-m-d'),
            "time" => date('H:i:s'),
            "CaraMasuk" =>  "1", //Datang Sendiri
            "AlasanDatang" => "PENYAKIT",
            "Rujukan" =>"", //>> $get_norujukan
          ];
    
          $fotrdaftar_pilih = $fotrdaftar_ugd;
        }
    
        //============
        
        $get_ket_fo = ""; //>>$input["ket_fo"]; // $('input[name=ket_fo]').val();
        $get_hp_cm = $pasien_cm_Obj["HP"];

        // //++++++++++++++++++++ create_sep ++++++++++++++++++++++++
        // get_noka, get_jnsPelayanan, get_klsRawat, get_norm_cm, get_asalRujukan_bpjs,
        // get_tglKunjungan, get_norujukan, get_ppkRujukan, catatan_sep,
        // sel_diag_bpjs, get_poliKode_bpjs, noskdp_bpjs, kd_dpjp_bpjs, telp, config_bpjs_consid
        // 
              //======   ws1.1   ============
            $jpost_sep_create =                                                     
              [
                 "request"=> [
                    "t_sep"=> [
                       "noKartu" => $input["get_noka"],// $get_noka,
                       "tglSep" => date('Y-m-d'),
                       "ppkPelayanan" => "0195R028",
                       "jnsPelayanan" => $input["get_jnsPelayanan"], // $get_jnsPelayanan,
                       "klsRawat" => $input["get_klsRawat"], // $get_klsRawat,
                       "noMR" => $input["get_norm_cm"], // $get_norm_cm,
                       "rujukan"=> [
                          "asalRujukan"=> $input["get_asalRujukan_bpjs"], // $get_asalRujukan_bpjs, //"1",
                          "tglRujukan" => $input["get_tglKunjungan"], // $get_tglKunjungan,
                          "noRujukan"  => $input["get_norujukan"], // $get_norujukan,
                          "ppkRujukan" => $input["get_ppkRujukan"], // $get_ppkRujukan
                        ],
                       "catatan" => $input["catatan_sep"], // $('input[name=catatan_sep]').val(),
                       "diagAwal" => $input["sel_diag_bpjs"], // $('select[name=sel_diag_bpjs]').val(),
                       "poli" => [
                          "tujuan" => $input["get_poliKode_bpjs"], // $get_poliKode_bpjs,
                          "eksekutif" => "0",
                       ],
                       "cob" => [
                          "cob" => "0"
                        ],
                       "katarak" => [
                          "katarak" => "0"
                        ],
                       "jaminan" => [
                          "lakaLantas" => "0",
                          "penjamin" => [
                              "penjamin" => "0",
                              "tglKejadian" => "0000-00-00",
                              "keterangan" => "",
                              "suplesi" => [
                                  "suplesi" => "0",
                                  "noSepSuplesi" => "",
                                  "lokasiLaka" => [
                                      "kdPropinsi" => "",
                                      "kdKabupaten" => "",
                                      "kdKecamatan" => ""
                                    ]
                              ]
                          ]
                      ],
                       "skdp"=> [
                          "noSurat" => $noskdp_bpjs, // $input["noskdp_bpjs"], // $noskdp_bpjs,
                          "kodeDPJP"=> $input["kd_dpjp_bpjs"], // $('input[name=kd_dpjp_bpjs]').val()
                        ],
                       "noTelp"=> $input["telp"], // $('input[name=telp]').val(),
                       // "user": "16141"
                       "user"=> $this->config_bpjs["consid"], // config_bpjs.consid
                    ]
                  ]
              ];
              //======   \ws1.1   ============

        //   // console.log('[Data will send:: sep_create]::');
        //   // console.log(jpost_sep_create);
        //   // progress_daftar(10,'Mengirim data untuk CREATE SEP ke BPJS.');


        //   //[== CREATE SEP ==]
      
    
			  


          
			
			$val = [
				"status" => "success",
				"message" => "",
				"result" => [
					"get_bill" => $get_bill,
					"noskdp" 	=> $noskdp,
					"noantrian_ready_3digit"=> $noantrian_ready["3d"],
          "noantrian_ready_full" 	=> $noantrian_ready["full"],
          "fotrdaftar_pilih" => $fotrdaftar_pilih,
          "bpjs" => [
            "create_sep" => $jpost_sep_create,
          ],
				],
				"tc" => $tc,
			];
		}

		echo json_encode($val); //?
		exit;

	}


  // KLIK DAFTAR
	public function daftar_pasien_klik($kode_lokasi=null){ // $kode_lokasi = 27
		$this->load->model("m_daftarmandiri");
		$input = $this->input->post(NULL, TRUE);
		
		// MENERIMA FULL ARRAY dari POST PENDAFTARAN
		$gen = $this->m_daftarmandiri->generate_bill_antri_skdp($kode_lokasi);

    // get_noka, get_jnsPelayanan, get_klsRawat, get_norm_cm, get_asalRujukan_bpjs,
    // get_tglKunjungan, get_norujukan, get_ppkRujukan, catatan_sep,
    // sel_diag_bpjs, get_poliKode_bpjs, noskdp_bpjs, kd_dpjp_bpjs, telp, config_bpjs_consid

		// $get_norm_cm = "073673";
		
		// 	$get_asalRujukan_bpjs=1; //<<< $_POST:ASAL_RUJUKAN
		// 	if($get_asalRujukan_bpjs == 2){ // jika PPK 2(RS)
		// 		//console.log('<Log> Px MRS/dari PPK2');
		// 		$get_norujukan = $input["noRujukan_ppk2_bpjs"]; //$('#noRujukan_ppk2_bpjs').val();
		// 		$get_ppkRujukan= '0195R028';
    //   }
   

			  // $_FL_daftar_ugd = 0; // SAAT PILIHAN LOKASI DIKLIK IGD, BARU GANTI JADI $_FL_daftar_ugd=1
			  $_FL_daftar_ugd = $input["dataPost"]["flag"]["_FL_daftar_ugd"]; // SAAT PILIHAN LOKASI DIKLIK IGD, BARU GANTI JADI $_FL_daftar_ugd=1
			//========
			  if($_FL_daftar_ugd == 0){ //JIKA BUKAN PASIEN UGD >> dapat antrian poli, cetak.
          $StatusDaftar_cm = 'RJ';
          $tbl_daftar_plh = 'rj';
    
          $fotrdaftar_rj = [
            "NoBill"  => $gen["bill"]["full"],
            "Lokasi"  => $input["dataPost"]["rs"]["klinik"]["kode"], // $kode_lokasi,
            "NoUrut"  => $gen["antri"]["full"],
            "typedokter"  => 1,
            "Dokter"      => $input["dataPost"]["rs"]["dokter"]["kode_dok"], // $input["get_kode_dokter"],
            "Pemeriksaan" => 0,
            "Biaya"   => 0,
            "Total"   => 0,
            "PemeriksaanUpDisc" => 0,
            "BiayaUpDisc" => 0,
            "TotalUpDisc" => 0,
            "FlagDaftar" 	=> 0,
            "Rujukan"     => $input["dataPost"]["rs"]["rujukan"], // $input["get_norujukan"], //$get_norujukan,
            "StatusPayment" => "B", //B=belum
            "KetRujukan"  => "",
            "Flagantrian" => 1,
            "tglrujukan"  => $input["dataPost"]["rs"]["get_tglRujukan"], // "",
            "User" => $this->session->userdata("username"), //>>$_user_logged_in,
            "Date" => date('Y-m-d'),
            "Time" => date('H:i:s'),
            "CaraMasuk"  => 1,
          ];
    
          $fotrdaftar_pilih = $fotrdaftar_rj;
				
			  }else{ //JIKA PASIEN UGD
					$StatusDaftar_cm = 'UG';
					$tbl_daftar_plh = 'ugd';
    
          $fotrdaftar_ugd = [
            "nobill" 	=> $gen["bill"]["full"],
            "triage" 	=> 0,
            "dokterrs"=> "92516",
            "TypeDokterJaga"=> 0,
            "dokterjaga" 		=> "92516",
            "pemeriksaan" 	=> 0,
            "biaya" 				=> 0,
            "pemeriksaanupdisc" =>0,
            "biayaupdisc" => 0,
            "total" 			=> 0,
            "totalupdisc" => 0,
            "statuspayment" => "B",
            "keterangan" 	=> "",
            "kasuspolisi" => "T",
            "lokasi" 			=> 10,//U G D
            "flagdaftar" 	=> 0,
            "user" => $this->session->userdata("username"), //>>$_user_logged_in,
            "date" => date('Y-m-d'),
            "time" => date('H:i:s'),
            "CaraMasuk" 	=> "1", //Datang Sendiri
            "AlasanDatang"=> "PENYAKIT",
            "Rujukan" 		=> 0, //>> $get_norujukan
          ];
    
          $fotrdaftar_pilih = $fotrdaftar_ugd;
				}


				$norm_rs = $input["dataPost"]["rs"]["mp"]["NoRM"];
				// $px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm( $norm_rs )[0]["status_px"];
				$px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $norm_rs )["status_px"];


				$fotrdaftar = [
					"NoBill" 	=> $gen["bill"]["full"],
					"NoRM" 		=> $norm_rs, // $input["dataPost"]["rs"]["mp"]["NoRM"],
					"TanggalMasuk" 	=> date('Y-m-d'),
					"JamMasuk"		 	=> date('H:i:s'),
					"TanggalKeluar"	=> date('Y-m-d'),
					"JamKeluar" 		=> date('H:i:s'),
					"StatusBL" 			=> $px_baru_lama,// st_px_baru_lama, //Bila di mstpasien ada No.RM, isikan LAMA. 
					"FlagBill"			=> 0,
					"DiagnosaAwal"	=> $input["dataPost"]["rs"]["dx_rs"], // '10',
					"Anggota" 			=> $input["dataPost"]["rs"]["penanggung"]["status"],// 'M',//BPJS: M
					"PerusahaanPenanggung" => $input["dataPost"]["rs"]["penanggung"]["kode"], //BPJS: CO031 //...???
					"BiayaKartu" 			=> 0,
					"BiayaKartuUpDisc"=> 0,
					"StatusDaftar" 		=> $input["dataPost"]["rs"]["StatusDaftar_cm"], ////////StatusDaftar_cm,
					"Nama" 		=> $input["dataPost"]["rs"]["mp"]["Nama"],
					"Alamat" 	=> $input["dataPost"]["rs"]["mp"]["Alamat"],
					"Telp" 		=> $input["dataPost"]["rs"]["mp"]["Telp"],
					"HP" 			=> $input["dataPost"]["rs"]["mp"]["HP"],
					"RT" 			=> $input["dataPost"]["rs"]["mp"]["Rt"],
					"RW" 			=> $input["dataPost"]["rs"]["mp"]["Rw"],
					"Kelurahan" => $input["dataPost"]["rs"]["mp"]["Kelurahan"],
					"Kecamatan" => $input["dataPost"]["rs"]["mp"]["Kecamatan"],
					"Kota" 			=> $input["dataPost"]["rs"]["mp"]["Kota"],
					"Propinsi"	=> $input["dataPost"]["rs"]["mp"]["Propinsi"],
					"Negara" 		=> $input["dataPost"]["rs"]["mp"]["Negara"],
					"Agama" 		=> $input["dataPost"]["rs"]["mp"]["Agama"],
					"Pendidikan"=> $input["dataPost"]["rs"]["mp"]["Pendidikan"],
					"Pekerjaan" => $input["dataPost"]["rs"]["mp"]["Pekerjaan"],

					"Sex" 			=> $input["dataPost"]["rs"]["mp"]["Sex"], //$('span[name=pasienRscm_jk]').text(),
					"Marital" 	=> $input["dataPost"]["rs"]["mp"]["Marital"],
					"UmurTahun" => $input["dataPost"]["rs"]["UmurTahun"], //get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun'), //mstpasien->tgl Lahir TglLahir
					"UmurBulan" => $input["dataPost"]["rs"]["UmurBulan"], //get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'bulan'), //mstpasien->tgl Lahir
					"UmurHari" 	=> $input["dataPost"]["rs"]["UmurHari"], //get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'hari'), //mstpasien->tgl Lahir
					"KategoriUsia" => $input["dataPost"]["rs"]["KategoriUsia"], //kategori_usia( get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun') ),//mstpasien->tgl Lahir

					"LimitKredit" 		=> 0,
					"flagpostkartu" 	=> 0,
					"flagpostperiksa" => 0,
					"flagpostbiaya" 	=> 0,
					"FlagDiagnosa" 		=> 0,
					
					"NoAnggota" 	=> $input["dataPost"]["rs"]["penanggung"]["NoAnggota"], //'BPJS',
					"keterangan" 	=> $input["dataPost"]["rs"]["ket_daftar"], //get_ket_fo,
					"caramasuk" 	=> $input["dataPost"]["rs"]["caramasuk"], // '1', //Datang Sendiri
					"asalPPK" 		=> $input["dataPost"]["rs"]["asalPPK"], //get_ppkRujukan+'_'+get_ppkRujukan_nama,
					"asalinstansi"=> $input["dataPost"]["rs"]["asalinstansi"],// get_instansi_kode_cm,
					"nosep" 	=> $input["dataPost"]["rs"]["nosep"], // get_nosep_temp,
					"noskdp" 	=> $gen["noskdp"]["rscm"], // noskdp,
					"User" => $this->session->userdata("username"),
					"Date" => date('Y-m-d'),
					"Time" => date('H:i:s'),
				];

				$fotrbillingshare = [
					"nobill"=> $gen["bill"]["full"], // get_bill_siap_pakai,
					"no"    => 1,
					"masterorextra" => "M",
					"billname"      => $input["dataPost"]["rs"]["mp"]["Nama"],
					"billket"       => "Bill From RJ", //RJ/UG. yg UG hanya 1 record di db
					"billpenanggung"=> $input["dataPost"]["rs"]["penanggung"]["kode"], // "CO031",
					"user" => $this->session->userdata("username"),
					"date" => date('Y-m-d'),
					"time" => date('H:i:s'),
				];

				// untuk insert ke >> insert_daftar_rj_n()
				$flag = $input["dataPost"]["flag"];

				$jpost_insert_reg_cm = [
					"data" 	=> $fotrdaftar,
					"data1"	=> $fotrdaftar_pilih,
					"data2"	=> $fotrbillingshare,
					"flag"	=> $flag,

					"dataPost"				=> $input["dataPost"],
					"generate"				=> $gen,
					"fotrdaftar" 			=> $fotrdaftar,
					"fotrdaftar_pilih"=> $fotrdaftar_pilih,
					"fotrbillingshare"=> $fotrbillingshare,					

					"tbl_daftar_plh"  => $tbl_daftar_plh,
					"tc_insert_daftar_rj_send"  => date('H:i:s'),
				];

				// $this->m_daftarmandiri->insert_daftar_rj( $flag, $data, $data1, $data2);
				// $insert_gen = $this->m_daftarmandiri->insert_daftar_rj( $flag, $fotrdaftar, $fotrdaftar_pilih, $fotrbillingshare);
				$insert_gen = $this->m_daftarmandiri->insert_daftar_rj_n($tbl_daftar_plh, $flag, $fotrdaftar, $fotrdaftar_pilih, $fotrbillingshare);
				
				$status_execute = $insert_gen["status"];
				$bill_response 	= $gen["bill"]["full"];


				// BILA INSERT BILLING BARU >> FAILED
				if($status_execute == "failed"){
					return null;
					exit;
				}else if($status_execute == "success"){
					if($bill_response == '' || $bill_response == null){
						// alert("Nomor Billing kosong. Segera hapus SEP("+get_nosep_temp+"). Ulangi proses pendaftaran.");
					}else{
						// AUTO ENTRY TINDAKAN BILLING. KHUSUS PX BPJS
						// !!! SUDAH DI JS, HARUSNYA DIPINDAH KE SINI. SEBABNYA DI JS: KODING MEPET& di ajaxreq/insert_pos_tindakan PUUANJANG scriptnya


						// IF penanggung KEMENKES(CO051), update masterpx
						if($fotrdaftar["PerusahaanPenanggung"] == 'CO051'){
							$this->load->model("m_main");
							$upd = $this->m_main->update('fomstpasien',["PDP"=> 1, "PDPDate"=>date('Y-m-d')], ["NoRM"=>$norm_rs]);
						}

					}
				}
				// echo json_encode($jpost_insert_reg_cm);
				// exit;
				
				//+++++++++++++++++++ insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++
				$xrec =  [
					"app"  => 'pendaftaran-rjri',
					"data" => [
						"report" => [
							"insert_gen" => $insert_gen,
						],
						"data_utama"  => [
							"billing" => $gen["bill"]["full"],
							"noka"    => $input["dataPost"]["rs"]["mp"]["Barcode"],
							"norm"    => $input["dataPost"]["rs"]["mp"]["NoRM"],
							"nama"    => $input["dataPost"]["rs"]["mp"]["Nama"],
							"antrian" => $gen["antri"]["full"],
						],
						"time_create"=> [
							"tc_klik_daftarrj"=> $input["dataPost"]["tc"]["klik_daftar"],// $tc_klik_daftarrj,
							"tc_bill"         => $gen["tc"]["bill"],
							"tc_noantrian"    => $gen["tc"]["antri"],
							"tc_sep"          => $input["dataPost"]["tc"]["sep"],
							"tc_insert_daftar_rj" => $insert_gen["time"], //"", // ?? tc_insert_daftar_rj . INI DAPAT DARI RESPONSE INSERT
						],
						"data_paket"=> [
							"jpost_insert_reg_cm" => $jpost_insert_reg_cm,
						],
						"bridging"  => [
							"res_c_sep" => $input["dataPost"]["bpjs"]["sep"]["response"], //SELAIN BPJS = null
						],
					],
					"user" => $this->session->userdata("username"),
					"date" => date('Y-m-d'),
					"time" => date('H:i:s'),
				];
				
				//+++++++++++++++++++ \insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++

				$this->m_daftarmandiri->insert_daftar_rj_xrec($xrec);

				// $insert_gen = null; // SEMENTARA !!!
				$res = [
					"request" => $jpost_insert_reg_cm,
					"response" => [
						"insert_gen" => $insert_gen,
						"xrec" => $xrec,
					],
				];
				echo json_encode($res);				
		
				exit;
    
				//============ END ========
				// dibawah hanya tambahan misal konsep create SEP diperhatikan lebih dalam
        

        // //++++++++++++++++++++ create_sep ++++++++++++++++++++++++
        // get_noka, get_jnsPelayanan, get_klsRawat, get_norm_cm, get_asalRujukan_bpjs,
        // get_tglKunjungan, get_norujukan, get_ppkRujukan, catatan_sep,
        // sel_diag_bpjs, get_poliKode_bpjs, noskdp_bpjs, kd_dpjp_bpjs, telp, config_bpjs_consid
        // 
            //   //======   ws1.1   ============
            // $jpost_sep_create =                                                     
            //   [
            //      "request"=> [
            //         "t_sep"=> [
            //            "noKartu" => $input["get_noka"],// $get_noka,
            //            "tglSep" => date('Y-m-d'),
            //            "ppkPelayanan" => "0195R028",
            //            "jnsPelayanan" => $input["get_jnsPelayanan"], // $get_jnsPelayanan,
            //            "klsRawat" => $input["get_klsRawat"], // $get_klsRawat,
            //            "noMR" => $input["get_norm_cm"], // $get_norm_cm,
            //            "rujukan"=> [
            //               "asalRujukan"=> $input["get_asalRujukan_bpjs"], // $get_asalRujukan_bpjs, //"1",
            //               "tglRujukan" => $input["get_tglKunjungan"], // $get_tglKunjungan,
            //               "noRujukan"  => $input["get_norujukan"], // $get_norujukan,
            //               "ppkRujukan" => $input["get_ppkRujukan"], // $get_ppkRujukan
            //             ],
            //            "catatan" => $input["catatan_sep"], // $('input[name=catatan_sep]').val(),
            //            "diagAwal" => $input["sel_diag_bpjs"], // $('select[name=sel_diag_bpjs]').val(),
            //            "poli" => [
            //               "tujuan" => $input["get_poliKode_bpjs"], // $get_poliKode_bpjs,
            //               "eksekutif" => "0",
            //            ],
            //            "cob" => [
            //               "cob" => "0"
            //             ],
            //            "katarak" => [
            //               "katarak" => "0"
            //             ],
            //            "jaminan" => [
            //               "lakaLantas" => "0",
            //               "penjamin" => [
            //                   "penjamin" => "0",
            //                   "tglKejadian" => "0000-00-00",
            //                   "keterangan" => "",
            //                   "suplesi" => [
            //                       "suplesi" => "0",
            //                       "noSepSuplesi" => "",
            //                       "lokasiLaka" => [
            //                           "kdPropinsi" => "",
            //                           "kdKabupaten" => "",
            //                           "kdKecamatan" => ""
            //                         ]
            //                   ]
            //               ]
            //           ],
            //            "skdp"=> [
            //               "noSurat" => $noskdp_bpjs, // $input["noskdp_bpjs"], // $noskdp_bpjs,
            //               "kodeDPJP"=> $input["kd_dpjp_bpjs"], // $('input[name=kd_dpjp_bpjs]').val()
            //             ],
            //            "noTelp"=> $input["telp"], // $('input[name=telp]').val(),
            //            // "user": "16141"
            //            "user"=> $this->config_bpjs["consid"] , // config_bpjs.consid
            //         ]
            //       ]
            //   ];
            //   //======   \ws1.1   ============

        //   // console.log('[Data will send:: sep_create]::');
        //   // console.log(jpost_sep_create);
        //   // progress_daftar(10,'Mengirim data untuk CREATE SEP ke BPJS.');


        //   //[== CREATE SEP ==]
      
    
			  


          
			
		// 	$val = [
		// 		"status" => "success",
		// 		"message" => "",
		// 		"result" => [
		// 			"get_bill" => $get_bill,
		// 			"noskdp" 	=> $noskdp,
		// 			"noantrian_ready_3digit"=> $noantrian_ready["3d"],
    //       "noantrian_ready_full" 	=> $noantrian_ready["full"],
    //       "fotrdaftar_pilih" => $fotrdaftar_pilih,
    //       "bpjs" => [
    //         "create_sep" => $jpost_sep_create,
    //       ],
		// 		],
		// 		"tc" => $tc,
		// 	];
		

		// echo json_encode($val); //?
		// exit;

	}

	public function get_st_bill_rm_by_norm(){ //status bill ada yang AKTIF/TIDAK
		$get = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_st_bill_rm_by_norm( $get['norm'] );
		//echo json_encode($data);

		$js  = json_encode($data);
		//echo $js;

		$jsd  = json_decode($js);
		$cnt = $data['count'];
		//echo $jsd->datajs[0]->NoBill; 

		$st_bill = "close";
		$nobill = "";
		for($i=0; $i<$cnt; $i++){
			if($jsd->datajs[$i]->FlagBill == 0){ //0= status billing OPEN
				$st_bill = "open";
				$nobill  = $jsd->datajs[$i]->NoBill;
			}
		}

		$val = array(
			'st_bill_rm' => $st_bill,
			'nobill' 	 => $nobill
		);

		echo json_encode($val);
	}

	public function delete_billing(){
		$post = $this->input->post(NULL,TRUE);
		$param = $post['nobill'];

		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->delete_billing($param);
		echo json_encode($data);
	}
	
	public function delete_bill_daftar($pelayanan=null, $nobill=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->delete_bill_daftar($pelayanan, $nobill);
		echo json_encode($data);
	}

	public function get_st_px_mrs_by_norm(){ //status bill ada yang AKTIF/TIDAK
		$get = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_st_px_mrs_by_norm( $get['norm'] );
		
		$js  = json_encode($data);
		echo $js;
	}

	public function gd_st_px_baru_lama_by_norm(){ //status px: BARU/LAMA.
		$get = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm( $get['norm'] );
				
		$js  = json_encode($data);
		echo $js;
	}
	
	public function gd_st_px_baru_lama_by_norm_n($norm = null){ //status px: BARU/LAMA.
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $norm );
		echo json_encode($data);
	}
	

	// INSERT TINDAKAN BILLING
	public function create_noreff_tindakan($kdlokasi=null){ //status px: BARU/LAMA.
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->create_noreff_tindakan( $kdlokasi);
		echo json_encode($data);
	}
	
	public function get_tarif_tindakan($kd_tindakan=null){ //status px: BARU/LAMA.
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_tarif_tindakan( $kd_tindakan);
		echo json_encode($data);
	}
	
	public function insert_pos_tindakan($pelayanan=null, $kdlokasi=null, $nobill=null, $kd_dokter=null){ //status px: BARU/LAMA.
		// http://192.168.1.68/rscm/app_dev/ajaxreq/insert_pos_tindakan/IGD/10//BL191010.0001
		// http://192.168.1.68/rscm/app_dev/ajaxreq/insert_pos_tindakan/RJ/22/BL191010.0001

		$this->load->model('m_daftarmandiri');

		if($pelayanan == 'RJ' && $kd_dokter==null) return null;
				
		$CLPenanggung = "CO031";

		if($pelayanan== "IGD") $kd_tindakan = "A325";
		else if($pelayanan== "RJ") $kd_tindakan = "A834";		

		$fomsttindakangrp = $this->m_daftarmandiri->get_tarif_tindakan( $kd_tindakan)[0];
		$c_noreff_tindakan = $this->m_daftarmandiri->create_noreff_tindakan($kdlokasi);

		$noreff = $c_noreff_tindakan["noreff_baru"];
		$inisial_lokasi = $c_noreff_tindakan["inisial_lokasi"];

		if($pelayanan== "IGD"){
			$pelaksana = "92612";
			$pelaksanaket = 'dr. Titia Rahmania';
			$pelaksanatype = 'Dokter Dalam';
			$type = 0;
			$tindet_kd_tind = $inisial_lokasi.$kd_tindakan;

			$tarif = $fomsttindakangrp['Tarif'];
			$rehap = 0;
			$grandtotal = $tarif;

			$StandartCost = $fomsttindakangrp['Tarif'];
		}else if($pelayanan== "RJ"){
			$fomsttindakangrp = $this->m_daftarmandiri->get_tarif_tindakan( $kd_tindakan)[0];

			$pelaksana =  $inisial_lokasi.$kd_tindakan;
			$pelaksanaket = $fomsttindakangrp['Keterangan'];
			$pelaksanatype = 'Dokter Luar';
			$type = 1;
			$tindet_kd_tind = $kd_dokter;

			$tarif = $fomsttindakangrp['TarifOpr'];
			$rehap = $fomsttindakangrp['TarifRS'];
			$grandtotal = $fomsttindakangrp['Tarif'];

			$StandartCost = $fomsttindakangrp['TarifOpr'];
		}

		$typem = 1;

		$fotrpayment = [
			"TglTrans" => date("Y-m-d"),
			"NoBill" => $nobill,
			"No" => 1,
			"MasterOrExtra" => "M",
			"NoNota" => $noreff,
			"Tab" => 4,
			"Lokasi" => $kdlokasi,
			"StandartCost" => $StandartCost, // $fomsttindakangrp['Tarif'],			
			"Billing" => $fomsttindakangrp['Tarif'],			
			"CLPenanggung" => $CLPenanggung, // $post['CLPenanggung'],			
			"User" => $this->session->userdata("username"),
			"Date" 	=> date("Y-m-d"),
			"Time" 	=> date("H:i:s"),
		];


		$fotrpostindakan = [
			"NoReff" 	=> $noreff,
			"Tgl" 	=> date("Y-m-d"),
			"NoBill" 	=> $nobill,
			"Lokasi" 	=> $kdlokasi,
			"Keterangan" 	=> "TINDAKAN TGL.".date("d/m/Y"),
			// "flagpostTindakan" 	=> 0,
			// "flagpostMedis" 	=> 0,
			"User" 	=> $this->session->userdata("username"),
			"Date" 	=> date("Y-m-d"),
			"Time" 	=> date("H:i:s"),
		];


		// echo $fomsttindakangrp['Tarif'];
		// echo ($fomsttindakangrp['Tarif']+$fomsttindakangrp['Tarif']);
		// exit;

		$fotrpostindakandet = [
			"NoReff" 	=> $noreff,
			"No" 	=> 1,
			"type" 	=> $type,
			"typem" 	=> $typem,
			"KodeTindakan" 	=> $tindet_kd_tind,// $inisial_lokasi.$kd_tindakan,
			"Jumlah" 	=> 1,
			"Tarif" 	=> $tarif, //$fomsttindakangrp['Tarif'],
			"TotalTarif" 	=> $tarif, //$fomsttindakangrp['Tarif'],
			// "UpDisc" 	=> "",
			"TotalUpDisc" 	=> $tarif, //$fomsttindakangrp['Tarif'],
			// "Pajak" 	=> "",
			"Rehap" 	=> $rehap,
			"GrandTotal" 	=>  $grandtotal, // ($fomsttindakangrp['Tarif']+$rehap),
			"pelaksana" 	=> $pelaksana,
			"pelaksanaket" 	=> $pelaksanaket,
			"pelaksanatype" => $pelaksanatype,
			"User" 	=> $this->session->userdata("username"),
			"Date" 	=> date("Y-m-d"),
			"Time" 	=> date("H:i:s"),
		];

		$res = [
			"data" => [
				"ip" 						=> my_ip(),
				"user" 					=> $this->session->userdata("username"),
				"pelayanan" 		=> $pelayanan,
				"kode_tindakan" => $kd_tindakan,
				"inisial_lokasi"=> $inisial_lokasi,
				"fomsttindakangrp" => $fomsttindakangrp,
			],
			"insert" => [
				"fotrpayment" 			=> $fotrpayment,
				"fotrpostindakan" 	=> $fotrpostindakan,
				"fotrpostindakandet"=> $fotrpostindakandet,
			],
		];
		echo json_encode($res);

		// TAMBAH INSERT TO 3 TABEL >> ???
		
			//+++++++++++++++++++ insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++
			$xrec =  [
				"app"  => 'pendaftaran-rjri/insert_pos_tindakan/'.$pelayanan.'/'.$nobill,
				"data" => $res,
				"user" => $this->session->userdata("username"),
				"date" => date('Y-m-d'),
				"time" => date('H:i:s'),
			];
			
			$this->m_daftarmandiri->insert_daftar_rj_xrec($xrec);
			//+++++++++++++++++++ \insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++


			$ins1 = $this->m_daftarmandiri->insert_new( "fotrpayment", $fotrpayment);
			$ins2 = $this->m_daftarmandiri->insert_new( "fotrpostindakan", $fotrpostindakan);
			$ins3 = $this->m_daftarmandiri->insert_new( "fotrpostindakandet", $fotrpostindakandet);
			// $ins1 = json_decode( json_encode($ins1) ); // netralisir arr object
			// echo json_encode($result);
	}
	// \INSERT TINDAKAN BILLING


	/************************************************************
	|						pendaftaran-ri																	|
	************************************************************/
	public function daftar_pasienri_klik(){ // $kode_lokasi = 27
		$this->load->model("m_daftarmandiri");
		$this->load->model("m_main");

		//TES
		// $xx = ["app"=>"tess", "element"=>"testing"];
		// $ins_ftdi = $this->m_main->insert( "cx_rec", $xx);

		// if($ins_ftdi['code'] == 200){ $status_daftarri = true;
		// }else{ $status_daftarri = false; }

		// $eco = [
		// 	"result" => $ins_ftdi,
		// 	"response" => [
		// 		"status_daftarri" => $status_daftarri,
		// 	],
		// ];
		// echo json_encode($eco);
		// exit;


		// TES UPDATE
		// $upd_sep_ri = $this->m_main->update( "cx_rec", ["element"=>"tes bo"], ["id" => 16497]);
		// exit;


		//\TES

		// $errors = null;
		$errors = [];
		$bridging_error = 0;
		$bridging_error_message = "";
		// $btn_lewati = 0;

		$nobill = 0;
		$sep 		= 0;
		$spri 	= 0;

		$status_daftarri = false;

		//VAR BRIDGING
		$sep_res = null;


		$input = $this->input->post(NULL, TRUE);	
		// echo "<pre>",print_r($input),"</pre>"; exit;	
		//-------------------------------BATAS TES STOP

		$tc['klik_daftar'] = date('H:i:s');

		$norm 	= $input['px_rs']['NoRM'];

		// $pro_masuk = 1;
		$pro_masuk = $input['pro_masuk'];
		if($pro_masuk == 1){
			// CREATE NEW NOBILL
			$cbill = $this->m_daftarmandiri->create_bill();
			// echo "<pre>",print_r($cbill),"</pre>"; exit;
			$nobill = $cbill['new_bill'];
			

			$spri   = fx_skdp('RI', $nobill);

			$tc['bill'] = date('H:i:s');
			// echo "<pre>",print_r([$cbill,$nobill, $spri, $tc['bill'] ]),"</pre>"; exit;

			$ftd = [
				"nobill" 		=> $nobill,
				"nobillsub" => '',
				"norm" 			=> $input['px_rs']['NoRM'], //$norm,
				"tanggalmasuk" 	=> date('Y-m-d'),
				"tanggalkeluar" => date('Y-m-d'),
				"jammasuk" 	=> date('H:i:s'),
				"jamkeluar" => date('H:i:s'),
				"statusBL" 	=> 'LAMA',
				"flagbill" 	=> 0,
				"diagnosaawal"=> $input['ftd']['sel_dx_auto']['Kode'], // sel_dx_auto.Kode,
				"anggota" 		=> $input['ftd']['penanggung_plh']['status'], // penanggung_plh.status,
				"perusahaanpenanggung" => $input['ftd']['penanggung_plh']['kode'], // penanggung_plh.kode,
				"nama" 		=> $input['px_rs']['Nama'],
				"alamat" 	=> $input['px_rs']['Alamat'],
				"telp" 		=> $input['px_rs']['Telp'],
				"hp" 			=> $input['px_rs']['HP'],
				"fax" 		=> $input['px_rs']['Fax'],
				"email" 	=> $input['px_rs']['Email'],
				"rt" 			=> $input['px_rs']['Rt'],
				"rw" 			=> $input['px_rs']['Rw'],
				"kelurahan" => $input['px_rs']['Kelurahan'],
				"kecamatan" => $input['px_rs']['Kecamatan'],
				"kota" 			=> $input['px_rs']['Kota'],
				"propinsi" 	=> $input['px_rs']['Propinsi'],
				"negara" 		=> $input['px_rs']['Negara'],
				"agama" 		=> $input['px_rs']['Agama'],
				"pendidikan"=> $input['px_rs']['Pendidikan'],
				"pekerjaan" => $input['px_rs']['Pekerjaan'],
				"sex" 			=> $input['px_rs']['Sex'],
				"marital" 	=> $input['px_rs']['Marital'],
				"statusdaftar" => 'RI',
				"umurtahun" => $input['ftd']['get_umur_fv']['tahun'],
				"umurbulan" => $input['ftd']['get_umur_fv']['bulan'],
				"umurhari" 	=> $input['ftd']['get_umur_fv']['hari'],
				"kategoriusia" => $input['ftd']['kategori_usia'], // kategori_usia(get_umur_fv.tahun),

				"noanggota" => $input['ftd']['penanggung_plh']['NoAnggota'],
				"caramasuk" => $input['ftd']['cara_masuk_ri'], //$('#cara_masuk_ri option:selected').val(),
				"asalPPK" 	=> $input['ftd']['rjk_ri']['nama'],
				"asalinstansi" => $input['ftd']['instansi_ri']['kode'],
				"noskdp"      => $spri,

				"user" => $this->session->userdata("username"), // _user_daftar,
				"date" => date('Y-m-d'),
				"time" => date('H:i:s'),
			];
			
			// $ins1 = $this->m_daftarmandiri->insert_new( "fotrdaftar", $ftd);
			$ins1 = $this->m_main->insert( "fotrdaftar", $ftd);


			$bshare = [
				"nobill"=> $nobill,
				"no"    => '1', 
				"masterorextra" => 'M', 
				"billname"      => $input['px_rs']['Nama'], 
				"billket"       => 'Bill From RJ', 
				"billpenanggung"=> $input['ftd']['penanggung_plh']['kode'],
				"user" => $this->session->userdata("username"),
				"date" => date('Y-m-d'),
				"time" => date('H:i:s'),
			];
			
			// $ins2 = $this->m_daftarmandiri->insert_new( "fotrbillingshare", $bshare);
			$ins2 = $this->m_main->insert( "fotrbillingshare", $bshare);
				


			// echo "<pre>",print_r([$cbill,$nobill, $spri, $tc['bill'] ]),"</pre>"; exit;
		}else{ // pro_masus != 1
			 // melalui ugd or rawatjalan (update statusdaftar)
        
			$nobill = $input['nobill_ri'];
			$spri = fx_skdp('RI', $nobill);
			$tc['bill'] = date('H:i:s');

			//skdp BL191129.0169 = 290169/SKDP-IRI/11/2019

			//--UPDATE FOTRDAFTAR
			$upd_var = [
				"noanggota"   =>  $input['ftd']['penanggung_plh']['NoAnggota'],
				"statusdaftar"=> 'RI',
				"noskdp"      =>  $spri,
				"User"        =>  $this->session->userdata("username"),
			];
			
			// $upd = $this->m_daftarmandiri->update_new( "fotrdaftar", $upd_var, ["NoBill" => $nobill]);
			$upd = $this->m_main->update( "fotrdaftar", $upd_var, ["NoBill" => $nobill]);
			 
		}

		
      //--update status bed
			$kdbed_ri = $input['kdbed_ri'];
			// $upd_bed = $this->m_daftarmandiri->update_new( "fokmrmstbed", ["Status"=>"IN"], ["kode" => $kdbed_ri]);
			$upd_bed = $this->m_main->update( "fokmrmstbed", ["Status"=>"IN"], ["kode" => $kdbed_ri]);
			


			//--Save trDaftarRI
      //fotrdaftarri
      $insert_post = [
        "NoBill"    => $nobill,
        "Kodebed"   => $kdbed_ri, // txtKodeBed.Text,
        "TypeTarif" => 1,//INCLUDE=optTypeTarif(1) // IIf(optTypeTarif(0).Value, "0", "1")
				"Tarif"     => $input['tarifkamar_ri'], // txtTarifKamar.TextSQL,
				
        "KeluargaNama"    => $input['KeluargaNama'], // txtNamaKeluarga.Text,
        "KeluargaAlamat"  => $input['KeluargaAlamat'], // txtAlamatKeluarga.Text,
        "KeluargaTelp"    => $input['KeluargaTelp'], // txtTelpKeluarga.Text,
        "TypeDokter"      =>  $input['sel_dpjp_auto']['type'], //IIf(optTypeM(0).Value, "0", "1")
				"DokterAwal"      =>  $input['sel_dpjp_auto']['kode'], // txtDokterAwal.Text,
				
        "ProsedurMskRS" => $pro_masuk,
        "PelayananRI" => $input['sel_pelayanan']['Kode'], //txtPelayanan.Text,
        "CaraMasuk"   => $input['ftd']['cara_masuk_ri'],
        "Rujukan"     => $input['ftd']['rjk_ri']['kode'],
        "FlagDaftar"  => 0,
        "KasusPolisi" => 1, //IIf(optKasusPolisi(0).Value, "0", "1")
        "User" => $this->session->userdata("username"),
        "Date" => date('Y-m-d'),
        "Time" => date('H:i:s'),
			];

			// $ins_ftdi = $this->m_daftarmandiri->insert_new( "fotrdaftarri", $insert_post);
			$ins_ftdi = $this->m_main->insert( "fotrdaftarri", $insert_post);

			if($ins_ftdi['code'] == 200){ $status_daftarri = true;
			}else{ $status_daftarri = false; }



			
			$spri_bpjs   = fx_skdp('BPJS', $nobill);

      // if(penanggung_plh.bpjs){
      if($input['ftd']['penanggung_plh']['bpjs']){
				// sep_ri
        $sep_req =
          [
            "request"=> [
              "t_sep"=> [
                  "noKartu" => $input['sep_req']['noKartu'],
                  "tglSep"  => date('Y-m-d'),
                  "ppkPelayanan"=> $input['sep_req']['ppkPelayanan'],
                  "jnsPelayanan"=> '1', // get_jnsPelayanan,
                  "klsRawat"    => $input['sep_req']['klsRawat'], // dropdown 123, //cari_px_bpjs.response.peserta.hakKelas.kode, // get_klsRawat,
                  "noMR"        => $input['sep_req']['noMR'], // get_norm_cm,
                  "rujukan"=> [
                    "asalRujukan" => "2", // get_asalRujukan_bpjs, // FASKES : 1,2
                    "tglRujukan"  => date('Y-m-d'), //?? get_tglRujukan,
                    "noRujukan"   => $input['sep_req']['noRujukan'], //?? get_norujukan,
                    "ppkRujukan"  => "0195R028", //CITRA MEDIKA // get_ppkRujukan
									],
                  "catatan" => $input['sep_req']['catatan'],
                  "diagAwal"=> $input['sep_req']['diagAwal'],
                  "poli"=> [
                    "tujuan"=> "",// klinik_plh.kode_bpjs, //get_poliKode_bpjs,
                    "eksekutif"=> "0"
									],
                  "cob"=> [
                    "cob"=> "0"
									],
                  "katarak"=> [
                    "katarak"=> "0"
									],
                  "jaminan"=> [
                    "lakaLantas"=> "0",
                    "penjamin"	=> [
                      "penjamin"		=> "0",
                      "tglKejadian"	=> "0000-00-00",
                      "keterangan"	=> "",
                      "suplesi"=> [
                        "suplesi"			=> "0",
                        "noSepSuplesi"=> "",
                        "lokasiLaka"	=> [
                          "kdPropinsi" => "",
                          "kdKabupaten"=> "",
                          "kdKecamatan"=> ""
                        ]
                      ]
                    ]
                  ],
                  "skdp"=> [
                    "noSurat" => $spri_bpjs, // $('input[name=skdp]').val(), // noskdp_bpjs,
                    "kodeDPJP"=> $input['sep_req']['kodeDPJP'],
									],
                  "noTelp"=> $input['sep_req']['noTelp'],
                  // "user": "16141"
                  "user"=> $input['sep_req']['user'],
              ]
            ]
					];
          //======   \ws1.1   ============

          // //[== CREATE SEP RI ==]
					// $sep_res = sep_create_by_noka(sep_req); //JS: response_create_sep [LIHAT KATALOG BPJS]
					
					$json_request = json_encode( $sep_req );
					$path = "SEP/1.1/insert";
					$sep_res = $this->ws_bpjs_11->ws_arr("vclaim", "POST", $path, $json_request );

					// <RESPONSE CREATE SEP>
					if($sep_res == null){
						$bridging_error = 1;
		
						$bridging_error_message = "Koneksi(Bridging) bermasalah. BPJS error nasional.";
						$error = error("bridging_error", "danger", "", $bridging_error_message);
						array_push($errors, $error);
					}else{
						if($sep_res['metaData']['code'] == 200 ){
							$tc['sep'] = date('H:i:s');
            
							$get_nosep_temp = $sep_res['response']['sep']['noSep'];
							$sep = $get_nosep_temp;
							// $('input[name=get_nosep_temp]').val(sep); //--???????
							// CASEMIX:MASUKKAN PASIEN
							
								//UPDATE SEP RI
								$upd_var = [
									"nosep" =>  $sep,
									"User"  =>  $this->session->userdata("username"),
								];
								
								$upd_sep_ri = $this->m_main->update( "fotrdaftar", $upd_var, ["NoBill" => $nobill]);
								

								// cx_daftarritarif
								$cx_daftarritarif = [
									"nobill"   => $nobill,
									"norm"     => $norm,
									"sep"      => $sep,
									"dpjp"     => $input['sel_dpjp_auto']['kode'],
									"st_kelas" => $input['casemix']['st_kelas'],
									"kelas"    => $input['casemix']['kelas'],
									"hakkelas" => $input['casemix']['hakkelas'],
									"user"    => $this->session->userdata("username"),
									"date"    => date('Y-m-d'),
									"time"    => date('H:i:s'),
								];
								$ins_cx_daftarritarif = $this->m_main->insert( "cx_daftarritarif", $cx_daftarritarif);


								// INSERT:cx_rec
								$data_rec = [
									"data_utama" => [
										"nobill" => $nobill
									],
									"data_paket" => $cx_daftarritarif,
								];

								$cx_rec = [
									"id"   => '',
									"app"  => 'bo/menu/casemix/pantauan_biaya_ri',
									"element" => $input['casemix']['element'], // '',// $(this)[0].id, // $(this)[0].name,
									"nama" => 'insert_px_to_daftarritarif',
									"ket"  => 'Pasien ditambahkan di Daftar Tarif RI.',
									"data" => json_encode($data_rec), //JSON.stringify($data_rec),
									"user" => $this->session->userdata("username"),
									"date" => date('Y-m-d'),
									"time" => date('H:i:s'),
								];
								$ins_cx_rec = $this->m_main->insert( "cx_rec", $cx_rec);


								
                //-- INSERT DIAGNOSA AWAL di CASEMIX
								$cx_daftarrihistoridiag = [
									"nobill"  => $nobill,
									"id"      => 1,
									"dx_awal" => $input['casemix']['dx_awal'],
									"user" => $this->session->userdata("username"),
									"date" => date('Y-m-d'),
									"time" => date('H:i:s'),
								];
								$ins_cx_daftarrihistoridiag = $this->m_main->insert( "cx_daftarrihistoridiag", $cx_daftarrihistoridiag);
								//\-- INSERT DIAGNOSA AWAL di CASEMIX


								
                //-- NEW_CLAIM INACBG
                $new_claim_req = [
									"metadata"=> [
										"method"=> "new_claim"
									],
									"data"=> [
										"nomor_kartu" => $input['noka_bpjs'], // $('#noka_bpjs').val(),
										"nomor_sep"   => $sep,
										"nomor_rm"    => $norm, //dtpxri[0].NoRM, // norm,
										"nama_pasien" => $input['px_rs']['Nama'], // px_rs.Nama,
										"tgl_lahir"   => $input['px_rs']['TglLahir'], //px_rs.TglLahir, // dtpxri[0].TglLahir,
										"gender"      => $input['px_rs']['gender_eclaim'], //px_rs.gender_eclaim, // dtpxri[0].gender_eclaim, //??
									]
								];

								$new_claim_res = $this->ws_eclaim->ws( "POST", json_encode($new_claim_req) );
							
								// let js_new_claim = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", j_new_claim);
								// console.log({"js_new_claim":js_new_claim});
								//\-- NEW_CLAIM INACBG


								// POPUP AUTO:CETAK SEP RI
								$sep_cari = $this->ws_bpjs_11->ws_arr("vclaim", "GET", "SEP/".$sep, "" );
								
								$get_noka = $sep_cari['response']['peserta']['noKartu'];
								// $get_noka = $input['sep_req']['noKartu'];
								$path = 'Peserta/nokartu/'.$get_noka.'/tglSEP/'.date('Y-m-d');
								$peserta_cari = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "" );
								
	

						}else{ // IF CODE!=200 , bila create_sep TIDAK SUKSES
            
							//UPDATE SEP RI
							$upd_var = [
								"nosep" => 0,
								"User"  => $this->session->userdata("username"),
							];
							
							$upd_sep_ri = $this->m_main->update( "fotrdaftar", $upd_var, ["NoBill" => $nobill]);
							
							$error = error("create_sep", "danger", $sep_res['metaData']['code'], $sep_res['metaData']['message']);
							array_push($errors, $error);
													

						}
					}

          
						

				//??
			} // ENDIF PENANGGUNG =BPJS

					

		//--------RESULT RETURN VIEW
		if( count($errors) == 0 ){ $errors = null; }

		// if($bpjs){
		if($input['ftd']['penanggung_plh']['bpjs']){
			$val = [
				"generate" => [
					"status_daftarri" => $status_daftarri,
					"bridging_error"=> $bridging_error,
					"bridging_error_message"=> $bridging_error_message,
					"errors" => $errors,

					"nobill" 	=> $nobill,
					"sep" 		=> $sep,
					"spri" 		=> $spri,
					"norm" 		=> $norm,
				],
				"bridging" => [
					"bpjs"  => [
						"sep_req" => $sep_req,
						"sep_res" => $sep_res,
						"sep_cari" 			=> $sep_cari,
						"peserta_cari" 	=> $peserta_cari,
					],
					"inacbg"  => [
						"new_claim_req" => $new_claim_req,
						"new_claim_res" => $new_claim_res,
					],
				],
			];
		}else{ // JIKA SELAIN BPJS(UMUM, PENANGGUNG LAIN)
			$val = [
				"generate" => [
					"status_daftarri" => $status_daftarri,
					"errors" => $errors,

					"nobill" 	=> $nobill,
					"sep"			=> 0,
					"spri" 		=> $spri,
					"norm" 		=> $norm,
				],
			];
		}


		
					//+++++++++++++++++++ insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++
					$data_xrec = [
						"request" 		=> $input,
						"result" 			=> $val,
						"time_create"	=> $tc,
						// "report" => [
						// 	"insert_gen" => $insert_gen,
						// ],
						// "data_utama"  => [
						// 	"billing" => $gen["bill"]["full"],
						// 	"noka"    => $input["dataPost"]["rs"]["mp"]["Barcode"],
						// 	"norm"    => $input["dataPost"]["rs"]["mp"]["NoRM"],
						// 	"nama"    => $input["dataPost"]["rs"]["mp"]["Nama"],
						// 	"antrian" => $gen["antri"]["full"],
						// ],
					];

					$xrec =  [
						"app"  => 'pendaftaran-ri',
						"data" => json_encode($data_xrec),
						"user" => $this->session->userdata("username"),
						"date" => date('Y-m-d'),
						"time" => date('H:i:s'),
					];

					$ins_xrec = $this->m_main->insert( "xrec", $xrec);
					//+++++++++++++++++++ \insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++


    // echo "<pre>",print_r($val),"</pre>";
    echo json_encode($val);

	}

	/************************************************************
	|					\pendaftaran-ri																		|
	************************************************************/


	//================================================
	//==================== \RSCM ======================
	//================================================



/************************************************************
|															|
|						vclaim/sep_cari						|
|															|
************************************************************/
	
	public function encrypt_post_cetak(){
		echo base64_encode(json_encode( $this->input->post() ));
	}

	

	//tes cetak sep & resume medis
	public function tes_cetak_enc(){
		$get_json = $this->input->get("js");
		$json_obj = base64_decode($get_json);

		$js = json_decode($json_obj); //{json obj} to {php array}
		////echo $js->noKartu."&&".$js->tglSep."<br>";

		$this->load->view("file_template/".$this->input->get("filename"), $js);
	}
	


	// NEW: 2019-12-16
	public function popup_print(){
		$get_json = $this->input->get("js");
		$json_obj = base64_decode($get_json);

		$js = json_decode($json_obj); //{json obj} to {php array}
		////echo $js->noKartu."&&".$js->tglSep."<br>";

		$this->load->view("file_template/popup_print/".$this->input->get("filename"), $js);
	}



	public function view_printpreview(){
		$input = $this->input->get(NULL, TRUE);
		$this->load->view("file_template/".$this->input->get("filename"), $input);
	}
	
	public function view_popup_print(){
		$input = $this->input->get(NULL, TRUE);
		$filename = $input['filename'];

		// switch ($filename) {
		// 	case 'tracer-ri':
		// 			$data = [
		// 				"NoBill"    => "BL191212.0012", // 'js_sel.nobill',
		// 				"NoRM"      => "000123", // 'js_sel.norm',
		// 				"Nama"      => 'js_sel.nama',
		// 				"TglLahir"  => "2010-08-08", // 'js_sel.tgllahir',
		// 				"Sex"       => "L", // 'js_sel.jeniskelamin',
		// 				"Alamat"    => "Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat", // 'js_sel.alamat',
		// 				"kelas_ruang" => 'js_sel.kelas_ruang',
		// 				"bed_tarif" => "500000", // js_sel.tarif_bedri,
		// 				// dokter    : js_sel.dokter_nama,
		// 				"user"      => "della", // "_user_logged_in",
		// 				"ket"       => "js_sel.keterangan",
		// 				"umur"      => "12", // js_sel.umur,
		// 				"kategori_usia"   => "DEWASA", // js_sel.kategori_usia,
		// 				"st_px_baru_lama" => "LAMA", // js_sel.statuspasien,
		// 				"penanggung_cm"   => "BPJS", // "js_sel.penanggung_ket", 
		// 			];
		// 		break;
			
		// 	default:
		// 		# code...
		// 		break;
		// }
		
		// $this->load->view("file_template/popup_print/".$this->input->get("filename"), $data);

		$this->load->view("file_template/popup_print/".$this->input->get("filename"), $input);// real
	}

	
	public function cetak_sep_enc_to_frame(){
		$get_json = $this->input->get("js");
		$json_obj = base64_decode($get_json);

		$js = json_decode($json_obj); //{json obj} to {php array}
		////echo $js->noKartu."&&".$js->tglSep."<br>";

		$this->load->view("file_template/sep_cetak",$js);
	}

	public function cetak_bukti_daftar_request(){
		$this->print_kertas->termal_daftar_mandiri($this->input->post("nama_printer"));
	}

	public function cetak_nomor_antrian(){
		$post = $this->input->post(NULL,TRUE);
		$this->print_kertas->termal_nomor_antrian($post);
	}
	
	// public function termal_nomor_antrian_new(){
	// 	$post = $this->input->post(NULL,TRUE);
	// 	$this->print_kertas->termal_nomor_antrian_new($post);
	// }
	
	public function termal_nomor_antrian_new($select_printer=null){
		$post = $this->input->post(NULL,TRUE);
		// $val = [
		// 	"post" => $post,
		// 	"select_printer" => $select_printer,
		// ];
		// echo "<pre>",print_r($val),"</pre>"; exit;
		$this->print_kertas->termal_nomor_antrian_new($post, $select_printer);
	}
	
	public function termal_nomor_antrian_daftar($noantrian=null, $datetime=null){
		// $post = $this->input->post(NULL,TRUE);
		$datetime = rawurldecode($datetime);
		$input = [
			"noantrian" => $noantrian,
			"datetime" => $datetime,
		];
		$this->print_kertas->termal_nomor_antrian_daftar($input);
	}

	public function cetak_tracer(){
		$post = $this->input->post(NULL,TRUE);
		$this->print_kertas->termal_tracer('', $post); //(setting nama printer, data)
	}
	
  
  public function termal_tracer_v2(){
    // echo $this->Printer_kertas->printer['termal_tracer'];
    // echo $this->my_printer_list->termal_tracer;
    // print_r($this->print_kertas);
    // $print = arr_repair($this->print_kertas);
    echo "<pre>",print_r($this->print_kertas),"</pre>";
    // echo "<pre>",print_r($print),"</pre>";
    // $print_kertas = arr_repair($this->print_kertas);
    // print_r($print_kertas);
    exit;
		$post = $this->input->post(NULL,TRUE);
		$this->print_kertas->termal_tracer_v2('', $post); //(setting nama printer, data)
	}

	public function cetak_skdp_langsung(){
		$post = $this->input->post(NULL,TRUE);
		$this->print_kertas->cetak_skdp_langsung($post); //(setting nama printer, data)
	}
	
	
	public function cetak_sep_langsung(){
		$post = $this->input->post(NULL,TRUE);
		$this->print_kertas->cetak_sep_langsung('', $post); //(setting nama printer, data)
	}

	public function cetak_resume_sep_pdf(){
		$post = $this->input->post(NULL,TRUE);
        //load the view and saved it into $html variable
        /////$html=$this->load->view('welcome_message', $data, true);
        $html=$this->load->view('file_template/sep_resume_cetak', $post, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "resume_sep.pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        //$this->m_pdf->pdf->Output($pdfFilePath, "D"); 

        //define('FCPATH', dirname(__FILE__).'/'); 
        //$this->m_pdf->pdf->Output(FCPATH.$pdfFilePath, "F");
        $this->m_pdf->pdf->Output($pdfFilePath, "F");
        return $pdfFilePath;

	}

	public function tambah_font_pdf(){
        //load mPDF library
        $this->load->library('m_pdf');
        //$mpdf-><a href="/reference/mpdf-functions/addfontdirectory.html">AddFontDirectory()</a>
        //$this->$m_pdf-><a href="/reference/mpdf-functions/addfontdirectory.html">AddFontDirectory()</a>;

	}

	


/************************************************************
|															|
|					\vclaim/sep_cari						|
|															|
************************************************************/

/************************************************************
|															|
|					daftarmandiri/admin						|
|															|
************************************************************/
public function select_nomor_antri_daftar($date=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->select_nomor_antri_daftar($date);
		echo json_encode($data);
}

public function select_nomor_antridaftar($date=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->select_nomor_antridaftar($date);
		echo json_encode($data);
}

public function select_nomor_antri_daftar_panggil_now($date=null){
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->select_nomor_antri_daftar_panggil_now($date);
		echo json_encode($data);
}







/************************************************************
|															|
|					\daftarmandiri/admin					|
|															|
************************************************************/


/************************************************************
|															|
|							user/index						|
|															|
************************************************************/
	public function tambah_user(){
		// $this->load->model('m_daftarmandiri');
		// $data = $this->m_daftarmandiri->tambah_user($params);
		// // echo json_encode($data);
		$input = $this->input->post(NULL,TRUE);
		$this->load->model("m_user");
		$this->m_user->user_register($input);
		// redirect(base_url("user/register"));
		redirect(base_url("bo/menu/it/user/user-akses"));

	}






/************************************************************
|															|
|							\user/index						|
|															|
************************************************************/

/************************************************************
|															|
|					page: it_support						|
|															|
************************************************************/
	public function get_tindakan_hapus_3tabel($nota=null){
		
		$this->load->model('m_itsupport');
		$payment = $this->m_itsupport->get_tindakan_hapus_fotrpayment($nota);
		$tindakan = $this->m_itsupport->get_tindakan_hapus_postindakan($nota);
		$tindakan_det = $this->m_itsupport->get_tindakan_hapus_postindakandet($nota);

		$val = [
			"payment" 		=> $payment,
			"tindakan" 		=> $tindakan,
			"tindakan_det"=> $tindakan_det,
		];

		echo json_encode($val);
	}
	


	public function delete_tindakan(){
		//$post = $this->input->post(NULL,TRUE);
		$param = $this->input->post('NoNota');
		//$param = $post['NoNota'];

		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->delete_tindakan($param);
		echo json_encode($data);
	}

		



	public function get_kamar_hapus(){
		$param = $this->input->post('bill');

		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->get_kamar_hapus($param);
		echo json_encode($data);
	}

	public function gd_penanggung_fotrdaftar($bill){
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->gd_penanggung_fotrdaftar($bill);
		echo json_encode($data);
	}

	public function gd_penanggung_fotrbillingshare($bill){
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->gd_penanggung_fotrbillingshare($bill);
		echo json_encode($data);
	}

	public function gd_penanggung_fotrpayment($bill){
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->gd_penanggung_fotrpayment($bill);
		echo json_encode($data);
	}

	public function update_penanggung(){
		$post = $this->input->post();
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->update_penanggung($post);
		echo json_encode($data);
	}



	public function cek_pegawai_tidak_absen($noreg=null, $tgl=null){
		// $noreg = $this->input->post('noreg');
		// $tgl = $this->input->post('tgl');

		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->cek_pegawai_tidak_absen($noreg,$tgl);
		echo json_encode($data);
	}

	
	public function get_ganti_jadwal(){
		// http://192.168.1.68/rscm/Project/8.PendaftaranMandiri/pendaftaranmandiri_devx11/ajaxreq/get_ganti_jadwal?noreg=92411&date=2019-01-03
		$input = $this->input->get(null,true);
		$this->load->model('m_itsupport');

		$date_ex = explode("-",$input['date']);

		$thn_int  = substr($date_ex[0],-2);
		$bln_int = intval($date_ex[1]);
		$tgl_int = intval($date_ex[2]);
		// echo $thn_int."_".$bln_int."_".$tgl_int;

		$datasend = array(
				"noreg"		=> $input['noreg'], 
				"date"  	=> $input['date'], 
				"tgl_int"  	=> $tgl_int, 
				"hrds"  	=> "hrds".$thn_int.$bln_int
			);
		// print_r($datasend);
		$data = $this->m_itsupport->get_ganti_jadwal($datasend);
		echo json_encode($data);
	}

	public function update_ganti_jadwal($date){ //xxxxxxxxxxx GET SUDAH, UPDATE BELUM
		// $where = array(
		//         'date' => $date,
		// 		'flag' => 0
		// 	);

		// $data = array(
		// 		'flag' => 1
		// 	);
		// $this->db->where($where);
		// $this->db->update('hrds', $data);
	}

	public function n_px_by_alamat(){
		$data = array(
				'alamat' 	=> $this->input->get('alamat'),
				'tgl_start' => $this->input->get('tgl_start'),
				'tgl_end' 	=> $this->input->get('tgl_end')
			);
		
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->n_px_by_alamat($data);
		echo json_encode($data);
	}

	public function download_data_px_by_alamat_xls(){
		$get = $this->input->get(NULL, TRUE);
		$data = array(
				'alamat' 	=> $this->input->get('alamat'),
				'tgl_start' => $this->input->get('tgl_start'),
				'tgl_end' 	=> $this->input->get('tgl_end')
			);

		$q = "select NoBill, NoRM, Nama, Alamat, Agama, 
				UmurTahun as Umur, KategoriUsia, Sex, b.Keterangan as Pendidikan
			from fotrdaftar a
			inner join fomstpendidikan b on b.Kode = a.Pendidikan
			where a.Alamat like '%".$data['alamat']."%' 
				&& (a.Date >='".$data['tgl_start']."' 
				&& a.Date <='".$data['tgl_end']."') 
			ORDER BY NoBill DESC";

		// $q = "select NoBill, NoRM, Nama, Alamat, Agama, UmurTahun as Umur, KategoriUsia, Sex, Pendidikan from fotrdaftar 
		// 	where Alamat like '%".$data['alamat']."%' 
		// 	&& (Date >='".$data['tgl_start']."' && Date <='".$data['tgl_end']."') 
		// 	ORDER BY NoBill DESC";		

		$query = $this->db->query($q);

		$this->load->library('my_excel');
		$this->my_excel->set_query($query);
		$this->my_excel->set_header(array( 'NoBill', 'NoRM', 'Nama', 'Alamat', 'Agama', 'Umur', 'KategoriUsia', 'Sex', 'Pendidikan'));
		$this->my_excel->set_column(array( 'NoBill', 'NoRM', 'Nama', 'Alamat', 'Agama', 'Umur', 'KategoriUsia', 'Sex', 'Pendidikan'));
		$this->my_excel->set_width(array( 		15, 	7, 		12, 	15, 		4, 		4,			8, 		3,			5));
		$this->my_excel->exportTo2007("Data Pasien_".$data['alamat']."_tglStart(".$data['tgl_start'].")_tglEnd(".$data['tgl_end'].")" );
	}


	public function gd_transfer_obat(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->gd_transfer_obat($input);
		echo json_encode($data);
	}

	public function update_buka_apsl(){
		$input = $this->input->post(NULL,TRUE);
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->update_buka_apsl($input);
		echo json_encode($data);
	}
	
	public function gd_bill_daftar_for_tf(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->gd_bill_daftar_for_tf($input);
		echo json_encode($data);
	}

	public function update_transfer_apsl(){
		$input = $this->input->post(NULL,TRUE);
		$this->load->model('m_itsupport');
		$data = $this->m_itsupport->update_transfer_apsl($input);
		echo json_encode($data);
	}



/************************************************************
|															|
|					\page: it_support						|
|															|
************************************************************/

/************************************************************
|															|
|					page: daftaronline						|
|															|
************************************************************/

	// curl
	public function get_record_booking_aktif_px($norm=null){
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->get_record_booking_aktif_px($norm);
		echo json_encode($result);

	}

	public function send_form_daftar_online_CURL_TX(){
		$post = $this->input->post(NULL,TRUE);
		$path = base_url().'ajaxreq/send_form_daftar_online_CURL_RX';
		$val = $this->ws_rscm->ws_arr("base_url_post", "POST", $path, $post);
		echo json_encode($val);
	}


	// // DAFTAR BOOKING
	// public function send_form_daftar_online_CURL_RX(){
		// 	// $post['norm'] = '003187';
		// 	// $post['tgllahir'] = '1976-05-28';
		// 	// $post['nama'] = '';
		// 	// $post['alamat'] = '';
		// 	// $post['lokasiket']= 'SPESIALIS ANAK';
		// 	// $post['dokterket']= 'Benny Wibisono, dr, SpA';

		// 	// $post['lokasi']= '';
		// 	// $post['dokter']= '';

		// 	$post = $this->input->post(NULL,TRUE);
		// 	// die( json_encode($post)); // TESTING

		// 	$this->load->model('m_daftarmandiri');
		// 	// $data = arr_repair( $this->m_daftarmandiri->gd_pasien_rscm_by_norm($post['norm']) );
		// 	$data = $this->m_daftarmandiri->gd_pasien_rscm_by_norm_n($post['norm']);
		// 	// $data = arr_repair($data);
			

		// 	if($data['status'] == 'SUKSES'){
		// 		$dt = $data['datajs'][0];

		// 		// if( ($dt->TglLahir == $post['tgllahir']) && ($dt->Barcode == $post['noanggota']) ){ //CEK KESESUAIAN DATA PASIEN DI DB DENGAN INPUTAN 
		// 		// diatas ini di OFF cz ada noanggota yg kosong saat PENANGGUNG SELAIN BPJS.
		// 		// echo json_encode(["dt"=>$dt, "post"=>$post]); exit; // !!!!!CEK ERROR
		// 		if( $dt['TglLahir'] == $post['tgllahir'] && $dt['NoRM'] == $post['norm'] ){ //CEK KESESUAIAN DATA PASIEN DI DB DENGAN INPUTAN 
		// 			// echo "<pre>",print_r($dt),"</pre><br>";
		// 			// echo $dt->NoRM."/".$dt->TglLahir."/".$dt->Alamat."/";
		// 			if($post['penanggung'] == 'CO031'){ // jika penanggung:BPJS
		// 				$noka_valid = ($dt['Barcode'] == $post['noanggota']) ? true : false;
		// 			}else{
		// 				$noka_valid = true;
		// 			}
					

		// 			if(!$noka_valid){ //bila noka_valid:false
		// 				$message = "No.kartu BPJS pasien tidak sesuai. Informasi lebih lanjut hubungi resepsionis.";
		// 				$result = [ 'status' => 'GAGAL', 'message' => $message ];
		// 				die( json_encode($result) );
		// 			}else{
		// 				$post['nama'] 	= $dt['Nama'];
		// 				$post['alamat'] = $dt['Alamat'];

		// 				//CEK RECORD BOOKINGNYA ADA YG AKTIF/TIDAK?? JIKA ADA FLAG=0, TIDAK BOLEH BOOKING LAGI
		// 				// $res_rec_booking_aktif = $this->m_daftarmandiri->get_record_booking_aktif_px($post['norm']);

		// 				// GET DATA KODE_DOKTER DAN KODE_LOKASI
		// 				$dokter_lokasi = $this->m_daftarmandiri->gd_dokter_lokasi_kode_jadwal($post['dokterket']);
		// 				if($dokter_lokasi['status']=='SUKSES'){
		// 					$js_dokter = $dokter_lokasi['dtjs'][0];
		// 					$post['lokasi'] = $js_dokter->Lokasi;
		// 					$post['dokter'] = $js_dokter->kodeDokter;


		// 					$res_rec_booking_aktif = $this->m_daftarmandiri->get_record_booking_aktif_px_n($post['norm'], $js_dokter->kodeDokter);
		// 					if($res_rec_booking_aktif['rec_booking_aktif'] == "ADA"){
		// 						//END. GAK BOLEH BOOKING
		// 						$message = "Pasien sudah terdaftar pada tanggal ".$res_rec_booking_aktif['datajs'][0]['date']." pada ".$post['dokterket'];
		// 						$result = [ 'status' => 'GAGAL', 'message' => $message ];
		// 						die( json_encode($result) );
		// 					}else{
								
		// 							$q_noreq = $this->m_daftarmandiri->get_new_norequest($post['date'], $post['lokasi']);
		// 							// if($q_noreq['status'] == "ADA"){
		// 								$post['norequest'] = $q_noreq['count'] + 1;
		// 								// $post['tgldaftar'] = date('Y-m-d');
										

		// 								//INSERT INTO FOTRBOOKING
		// 								$this->m_daftarmandiri->send_form_daftar_online_CURL_RX($post);
		// 								// ini belum ada response insert di fotrbooking


		// 								$message = "Pendaftaran Berhasil.";

		// 								$px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $dt['NoRM'] )["status_px"];
		// 								// die(json_encode(['tes'=> 'OK', 'posting'=>$post, $px_baru_lama ])); // TESTING

		// 								$prb = ($data['datajs'][0]['PRB']=='1')? "PRB" : "";

		// 								$pdp = ($data['datajs'][0]['PDP'] == '1' && intval($data['datajs'][0]['PDPSelisihHari']) < 15) ? "Z038" : "";

		// 								//!! TAMBAHI ARRAY RESPONSE, isi datanya yaitu data booking yang baru berhasil di create
		// 								$result = [
		// 										'status'  => 'SUKSES',
		// 										'message' => $message,
		// 										'nama' 	  => $dt['Nama'],
		// 										'norequest' => $post['norequest'],
		// 										'tracer' => [
		// 											'NoBill'    => 'BOOK'.$post['tgldaftar'], // tglbook?? add_day('2020-12-30', '+2')
		// 											'lokasikode'=> $js_dokter->Lokasi, // tambahan
		// 											'segment' 	=> 'RJ', // tambahan
		// 											'NoRM'      => $dt['NoRM'],
		// 											'no_antrian'=> $post['norequest'],
		// 											'Nama'      => $dt['Nama'],
		// 											'TglLahir'  => $dt['TglLahir'],
		// 											'Sex'       => $dt['Sex'],
		// 											'Alamat'    => $dt['Alamat'],
		// 											'klinik'    => $post['lokasiket'],
		// 											'dokter'    => $post['dokterket'],
		// 											'user'  		=> $post['user'], //$this->session->userdata("username"),
		// 											'ket'       => $post['keterangan'], //'tglRujukan(multi_1)', // HANYA UTK BPJS
		// 											'umur'      => usia($dt['TglLahir']),
		// 											'st_px_baru_lama' => $px_baru_lama,
		// 											'penanggung_cm' 	=> $post['penanggungket'],
		// 											'prb' 	=> $prb,
		// 											'pdp' 	=> $pdp,
		// 											// "date"  => date("Y-m-d"),
		// 											// "time"  => date("H:i:s"),
		// 										],
		// 									];
											
		// 								die( json_encode($result) );
										
		// 							// }else{
		// 							// 	$message = "No.Request tidak berhasil dibuat. Ulangi pendaftaran.";
		// 							// 	$result = array(
		// 							// 			'status'  => 'GAGAL',
		// 							// 			'message' => $message
		// 							// 		);
		// 							// 	die( json_encode($result) );
		// 							// }
									
								
		// 					} // ELSE: if($res_rec_booking_aktif['rec_booking_aktif'] == "ADA")
		// 				} //if($dokter_lokasi['status']=='SUKSES')
		// 			}

		// 		}else{ //tgl lahir & NOKA tidak sesuai
		// 			// $message = "NORM/Tanggal lahir pasien tidak sesuai. Informasi lebih lanjut hubungi resepsionis.";
		// 			$message = "NORM/Tanggal lahir pasien tidak sesuai. "
		// 				."NORM (DATA:POST) = ('".$dt['NoRM']."':'".$post['norm']."'). "
		// 				."TGLLAHIR (DATA:POST) = ('".$dt['TglLahir']."':'".$post['tgllahir']."'). "
		// 				."Informasi lebih lanjut hubungi resepsionis.";
		// 			$result = [ 'status' => 'GAGAL', 'message' => $message ];
		// 			die( json_encode($result) );
		// 		}

		// 	}else{
		// 		$message = "Data Anda tidak ditemukan. Informasi lebih lanjut hubungi resepsionis.";
		// 		$result = [ 'status' => 'GAGAL', 'message' => $message ];
		// 		die( json_encode($result) );
		// 	}
	// }
	
	
	// DAFTAR BOOKING NEW
	public function send_form_daftar_online_CURL_RX(){		
		$post = $this->input->post(NULL,TRUE);
		
		$post['nama']      = 'nama';
		$post['alamat']    = 'alamat';
		$post['diagnosa']  = 10;
		$post['diagnosaket']='KONTROL';
		$post['lokasi']    = 'kodelokasi';
		$post['typedokter']= 1;
		$post['dokter']    = 'kodedokter';
		$post['flag']      = 0;
		// $post['rujukan']   = '';
		$post['rujukanket']= '';
		$post['instansi']  = '';
		$post['instansiket']='';
		$post['norequest'] = '';
		// die( json_encode($post)); // TESTING

		if($post['norm']==''){
			//TIDAK BISA DAFTAR
			$message = "Tidak Bisa Daftar. NORM kosong.";
			$result = [ 'status' => 'GAGAL', 'message' => $message ];
			die( json_encode($result) );
		}
		

		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->gd_pasien_rscm_by_norm_n($post['norm']);		

		if($data['status'] == 'SUKSES'){
			$dt = $data['datajs'][0];

			if( $dt['TglLahir'] == $post['tgllahir'] && $dt['NoRM'] == $post['norm'] ){ //CEK KESESUAIAN DATA PASIEN DI DB DENGAN INPUTAN 
				// echo "<pre>",print_r($dt),"</pre><br>";
				if($post['penanggung'] == 'CO031'){ // jika penanggung:BPJS
					$noka_valid = ($dt['Barcode'] == $post['noanggota']) ? true : false;
				}else{
					$noka_valid = true;
				}
				

				if(!$noka_valid){ //bila noka_valid:false
					$message = "No.kartu BPJS pasien tidak sesuai. Informasi lebih lanjut hubungi resepsionis.";
					$result = [ 'status' => 'GAGAL', 'message' => $message ];
					die( json_encode($result) );
				}else{
					$post['nama'] 	= $dt['Nama'];
					$post['alamat'] = $dt['Alamat'];

					//CEK RECORD BOOKINGNYA ADA YG AKTIF/TIDAK?? JIKA ADA FLAG=0, TIDAK BOLEH BOOKING LAGI
					// $res_rec_booking_aktif = $this->m_daftarmandiri->get_record_booking_aktif_px($post['norm']);

					// GET DATA KODE_DOKTER DAN KODE_LOKASI
					$dokter_lokasi = $this->m_daftarmandiri->gd_dokter_lokasi_kode_jadwal($post['dokterket']);
					if($dokter_lokasi['status']=='SUKSES'){
						$js_dokter = $dokter_lokasi['dtjs'][0];
						$post['lokasi'] = $js_dokter->Lokasi;
						$post['dokter'] = $js_dokter->kodeDokter;


						$res_rec_booking_aktif = $this->m_daftarmandiri->get_record_booking_aktif_px_n($post['norm'], $js_dokter->kodeDokter);
						if($res_rec_booking_aktif['rec_booking_aktif'] == "ADA"){
							//END. GAK BOLEH BOOKING
							$message = "Pasien sudah terdaftar pada tanggal ".$res_rec_booking_aktif['datajs'][0]['date']." pada ".$post['dokterket'];
							$result = [ 'status' => 'GAGAL', 'message' => $message ];
							die( json_encode($result) );
						}else{
							
								$q_noreq = $this->m_daftarmandiri->get_new_norequest($post['date'], $post['lokasi']);
								// if($q_noreq['status'] == "ADA"){
									$post['norequest'] = $q_noreq['count'] + 1;									

									//INSERT INTO FOTRBOOKING
									$ins = $post;
									// menghapus array param
      						array_splice($ins, array_search("url",array_keys($ins)), 1);
									array_splice($ins, array_search("button_id",array_keys($ins)), 1);
																		
									$this->m_daftarmandiri->send_form_daftar_online_CURL_RX($ins);
									// ini belum ada response insert di fotrbooking

									$message = "Pendaftaran Berhasil.";
									// $px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $dt['NoRM'] )["status_px"];
									$db_px = $this->m_daftarmandiri->laporan_pendaftaran_px_soft_by_bill('BOOK_RJ', $dt['NoRM'] );
									if(count($db_px)>0) $db_px = $db_px[0];
																		
									//!! TAMBAHI ARRAY RESPONSE, isi datanya yaitu data booking yang baru berhasil di create
									$result = [
											'status'  => 'SUKSES',
											'message' => $message,
											'nama' 	  => $dt['Nama'],
											'norequest' => $post['norequest'],
											'tracer' => [
												'url'    		=> $post['url'],
												'button_id' => $post['button_id'],
												'NoBill'    => $dt['NoRM'],
												'nobill_booking'=> 'BOOK'.$post['tgldaftar'], // $dt['NoRM'],
												'lokasikode'=> $js_dokter->Lokasi,
												'segment' 	=> 'BOOK_RJ',
												'no_antrian'=> $post['norequest'],
												'klinik'    => $post['lokasiket'],
												'dokter'    => $post['dokterket'],
											],
										];
										
									die( json_encode($result) );
									
								// }else{
								// 	$message = "No.Request tidak berhasil dibuat. Ulangi pendaftaran.";
								// 	$result = array(
								// 			'status'  => 'GAGAL',
								// 			'message' => $message
								// 		);
								// 	die( json_encode($result) );
								// }
								
							
						} // ELSE: if($res_rec_booking_aktif['rec_booking_aktif'] == "ADA")
					} //if($dokter_lokasi['status']=='SUKSES')
				}

			}else{ //tgl lahir & NOKA tidak sesuai
				// $message = "NORM/Tanggal lahir pasien tidak sesuai. Informasi lebih lanjut hubungi resepsionis.";
				$message = "NORM/Tanggal lahir pasien tidak sesuai. "
					."NORM (DATA:POST) = ('".$dt['NoRM']."':'".$post['norm']."'). "
					."TGLLAHIR (DATA:POST) = ('".$dt['TglLahir']."':'".$post['tgllahir']."'). "
					."Informasi lebih lanjut hubungi resepsionis.";
				$result = [ 'status' => 'GAGAL', 'message' => $message ];
				die( json_encode($result) );
			}

		}else{
			$message = "Data Anda tidak ditemukan. Informasi lebih lanjut hubungi resepsionis.";
			$result = [ 'status' => 'GAGAL', 'message' => $message ];
			die( json_encode($result) );
		}
	}



	public function get_klinik_by_ket(){
		$param = $this->input->get('ket');
		$this->load->model('m_daftarmandiri');
		$data = $this->m_daftarmandiri->get_klinik_by_ket($param);
		echo json_encode($data);
	}


	public function send_google_TX_tes(){
		$url = 'http://google.com'; 
		$val = get_headers($url,0);
		// echo"<pre>",print_r($val),"</pre>";
		echo json_encode($val);
	}




	public function curl_header_test_TX(){
		$post = $this->input->post(NULL,TRUE);
		$path = base_url().'ajaxreq/curl_header_test_RX';
		$val = $this->ws_rscm->ws_arr("base_url_post", "POST", $path, $post);
		echo json_encode($val);
	}

	public function curl_header_test_RX(){ //XXXXXX
		// var_dump($_SERVER);
		$secretKey = "8uG8E36B37"; // KEY

		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		echo time()."\n <br>";
		echo strtotime('1970-01-01 00:00:00')."\n <br>";
		echo $tStamp."\n <br>";
		echo "<br>";

		echo "SERVER: ".$_SERVER["HTTP_X_CONS_ID"]."\n <br>"; 
		echo "SERVER: ".$_SERVER["HTTP_X_TIMESTAMP"]."\n <br>"; 
		echo "SERVER: ".$_SERVER["HTTP_X_SIGNATURE"]."\n <br>"; 
		echo "SERVER: ".$_SERVER["HTTP_X_TI"]."\n <br>"; 
		echo "<br>";
		
		echo "timeRX= ". time()."\n <br>"; 
		echo "timestampRX= ".strval(time()-strtotime('1970-01-01 00:00:00'))."\n <br>"; 
		echo "time1970= ".strtotime('1970-01-01 00:00:00')."\n <br>"; 
		echo "timestampTX= ".$_SERVER["HTTP_X_TIMESTAMP"]."\n <br>";
		echo "<br>";

		$get_time = $_SERVER["HTTP_X_TIMESTAMP"] + strtotime('1970-01-01 00:00:00');
		echo "timeRX(rxx)= ". time()."\n <br>";
		echo "timeTX(get)= ".$get_time."\n <br>";		
		echo "timetostr= ".date("Y-m-d H:i:s", $get_time)."\n <br>"; //i_stamp iki UTF

		date_default_timezone_set('UTC');
		echo "time now= ".date("Y-m-d H:i:s")."\n <br>";
		echo "<br>"; 



		$signature = hash_hmac('sha256', $_SERVER["HTTP_X_CONS_ID"]."&".$get_time, $secretKey, true);
		$encodedSignature = base64_encode($signature); // base64 encode…
		echo "Signature= ".$encodedSignature."<br>";

		date_default_timezone_set("Asia/Bangkok");
	}

	public function send_form_daftar_online_CURL_RX_tes(){ //XXXXXX
		// var_dump($_SERVER);
		echo $_SERVER["HTTP_X_CONS_ID"]."\n <br>"; 
		echo $_SERVER["HTTP_X_TIMESTAMP"]."\n <br>"; 
		echo $_SERVER["HTTP_X_SIGNATURE"]."\n <br>"; 

		$post = $this->input->post(NULL,TRUE);
		// print_r($post);
		// $norm = $post['norm']
		echo $post['norm']."/".$post['noanggota']."/".$post['norm']."/".$post['tgllahir']."\n";
		echo $post['lokasi']."/".$post['lokasiket']."/".$post['dokter']."/".$post['dokterket']."\n";
		
	}

	
/************************************************************
|															|
|					\page: daftaronline						|
|															|
************************************************************/




/************************************************************
|															|
|					page: bo/laporan-indikator-mutu 		|
|															|
************************************************************/
	
	public function insert_lapIndikatorMutu(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$this->m_daftarmandiri->insert_lapIndikatorMutu($post);
		$message = "Indikator berhasil ditambahkan.";
		$result = array(
				'status'  => 'SUKSES',
				'message' => $message
			);
		echo json_encode($result);
	}

	public function select_lapIndikatorMutu_all(){
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_lapIndikatorMutu_all();
		echo json_encode($result);
	}

	public function select_indikator_by_divisi(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->get(NULL,TRUE);
		$result = $this->m_daftarmandiri->select_indikator_by_divisi($input);
		echo json_encode($result);
	}

	public function select_lapIndikatorMutu_all_by_bln_thn(){// load tabel datatable master tampilan mutu
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_lapIndikatorMutu_all_by_bln_thn();
		echo json_encode($result);
	}

	public function select_nd_indikator_by_bln_thn(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		
		$res = $this->m_daftarmandiri->select_nd_indikator_by_bln_thn($input);
		echo json_encode($res);
	}
	
	public function select_nd_indikator_by_bln_thn_pelayanan(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		
		$res = $this->m_daftarmandiri->select_nd_indikator_by_bln_thn_pelayanan($input);
		echo json_encode($res);
	}

	public function select_grf_indikator_by_pelayanan_th(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');		
		$res = $this->m_daftarmandiri->select_grf_indikator_by_pelayanan_th($input);
		echo json_encode($res);
	}
	
	public function select_grf_indikator_by_idindikator_pelayanan_th(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');		
		$res = $this->m_daftarmandiri->select_grf_indikator_by_idindikator_pelayanan_th($input);
		echo json_encode($res);
	}

	public function select_nd_indikator_by_id(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		
		$res = $this->m_daftarmandiri->select_nd_indikator_by_id($post);
		// echo json_encode($res);

		if($res['status'] == 'TIDAK ADA'){ //lakukan insert
			$res2 = $this->m_daftarmandiri->insert_nd_indikator($post);			
			echo json_encode($res2);
		}else if($res['status'] == 'ADA'){ //lakukan update
			$res2 = $this->m_daftarmandiri->update_nd_indikator($post);
			echo json_encode($res2);
		}
	}

	public function insert_nd_indikator(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');

		$this->m_daftarmandiri->insert_nd_indikator($post);
		$message = "Nilai indikator berhasil ditambahkan.";
		$result = array(
				'status'  => 'SUKSES',
				'message' => $message
			);
		echo json_encode($result);
	}

	public function update_indikator(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');

		$result = $this->m_daftarmandiri->update_indikator($post);
		echo json_encode($result);
	}

	public function delete_indikator(){
		$post = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');

		$result = $this->m_daftarmandiri->delete_indikator($post);
		echo json_encode($result);
	}
/************************************************************
|															|
|					\page: bo/laporan-indikator-mutu 		|
|															|
************************************************************/
//=======================[  bo/menu/mutu/rekap-irs]========================
	public function select_irs_indikator(){
		$this->load->model('m_daftarmandiri');		
		$res = $this->m_daftarmandiri->select_irs_indikator();
		echo json_encode($res);
	}
	
	// public function rekap_irs_bulanan($th_bulan=null, $divisi=null, $id_indikator=null, $nilai=null){
	public function rekap_irs_bulanan($th_bulan=null, $divisi=null){
		$divisi = rawurldecode($divisi); // untuk kirim data melalui URL yang MEMAKAI SPASI. ex: 'KAMAR OPERASI'

		$this->load->model('m_daftarmandiri');

		$db_ind = $this->m_daftarmandiri->select_irs_indikator();
    $irsbulanan = $this->m_daftarmandiri->select_irsbulanan($th_bulan, $divisi);

    if($irsbulanan == null){
        for ($j=0; $j < count($db_ind); $j++) { 
          $maxday = month_now_yesterday($th_bulan."-01")['now']['maxday'];
          for ($i=0; $i < $maxday; $i++) { 
            if($i<9){
              $tanggal_isi = $th_bulan."-0".($i+1);
            }else{
              $tanggal_isi = $th_bulan."-".($i+1);
            }					

            $data[] = [
              "divisi" => $divisi,// rawurldecode($divisi), // sudah dibenerin diatas
              "tanggal_isi" => $tanggal_isi,
              "id_indikator" => $db_ind[$j]["id"],
              "nilai" => 0,
              "user"  => $this->session->userdata("username"),
              "date"  => date("Y-m-d"),
              "time"  => date("H:i:s"),
            ];
          }
        }
        
        $res = $this->m_daftarmandiri->insert_batch("mutuirsrekapharian", $data);
        
        if($res==null){ // IF INSERT_BATCH SUCCESS
          //ECHO HASIL SELECT YANG BARUSAN DI INSERT
          $irsbulanan = $this->m_daftarmandiri->select_irsbulanan($th_bulan, $divisi);
          // echo json_encode($irsbulanan);
          $ct = 0;
          for ($j=0; $j < count($db_ind); $j++) { 
            $maxday = month_now_yesterday($th_bulan."-01")['now']['maxday'];
              for ($i=0; $i < $maxday; $i++) { 
                $res[$j][$i] = $irsbulanan[$ct]["nilai"];
                $ct++;
              }

          }
          echo json_encode($res);
        }
    }else{
			// echo json_encode($irsbulanan); // FIX BISA
      $res = [];
      $ct = 0;
      for ($j=0; $j < count($db_ind); $j++) { 
        $maxday = month_now_yesterday($th_bulan."-01")['now']['maxday'];
          for ($i=0; $i < $maxday; $i++) { 
            $res[$j][$i] = $irsbulanan[$ct]["nilai"];
            $ct++;
          }

      }
      echo json_encode($res);
    }
      
  }
  
  public function update_irs_bln_val($divisi=null, $tanggal_isi=null, $id_indikator=null, $val=null){
		$divisi = rawurldecode($divisi);
		
    $this->load->model('m_daftarmandiri');
    $where = [
      "divisi" => $divisi,
      "tanggal_isi" => $tanggal_isi,
      "id_indikator"=> $id_indikator,
    ];
    $result = $this->m_daftarmandiri->update_new("mutuirsrekapharian", ["nilai"=> $val], $where);
    echo json_encode(["status"=> "success"]);
	}
	
	
	
	
	public function laporan_irsbulanan($tanggal_isi=null, $divisi=null, $download=null){
		//http://192.168.1.68/rscm/app_dev/ajaxreq/laporan_irsbulanan/2019-08/RAJAL/0
		$divisi = rawurldecode($divisi);
		
		$this->load->model('m_daftarmandiri');		
		$query = $this->m_daftarmandiri->laporan_irsbulanan($tanggal_isi, $divisi);
		// echo json_encode($res);

		// echo json_encode( setting_excel_table('laporan_rekap_irs') );
		
		if($download){
			// >>> EXCEL
			$maxday   = month_now_yesterday($tanggal_isi."-01")["now"]["maxday"];
			
			$set = setting_excel_table('laporan_rekap_irs', $maxday);
			$filename = "laporan_rekap_irs - ".$divisi."_".$tanggal_isi;
			// exe_xls($query, $set, $filename);

			$this->load->library('my_excel');
			$this->my_excel->data_array($filename, $set, $query);
		}else{
			echo json_encode($query);
		}

		
	}
	


//=======================[ \bo/menu/mutu/rekap-irs]========================


/************************************************************
|															            |
|					 page: bo/dashboard						  |
|															            |
************************************************************/
	public function select_kunjungan_allpenanggung_by_bln_th(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_kunjungan_allpenanggung_by_bln_th($input);
		echo json_encode($result);
	}

	public function select_kunjungan_group_penanggung_bln_by_th(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_kunjungan_group_penanggung_bln_by_th($input);
		echo json_encode($result);
	}

	public function select_kunjungan_tiapLokasi_by_lokasi_th(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_kunjungan_tiapLokasi_by_lokasi_th($input);
		echo json_encode($result);
	}

	
	public function download_xls_kunjungan_1th(){
		$input = $this->input->get(NULL,TRUE);
		// $this->load->model('m_daftarmandiri');
		// $result = $this->m_daftarmandiri->download_xls_kunjungan_1th($input);
		// // echo json_encode($result);
		// // // echo $result;
		// $query = $result;
		

		$q = "SELECT bulan, lokasi, SUM(kunjungan) as total_kunjungan ".
			"FROM formkunjungandet ".
			"WHERE tahun = '".$input['tahun']."' ".
			"GROUP BY bulan, lokasi ".
			"ORDER BY bulan, lokasi ASC";
		$query = $this->db->query($q);
		// echo "<pre>",print_r($query),"</pre>";
		
		// >>> EXCEL
		$filename = "Laporan Kunjungan Poliklinik - ".$input['tahun'];

		$this->load->library('my_excel');
		$this->my_excel->set_query($query);
		$this->my_excel->set_header(array('Bulan', 'Lokasi', 'Total Kunjungan'));
		$this->my_excel->set_column(array('bulan', 'lokasi', 'total_kunjungan'));
		$this->my_excel->set_width(array(7, 40, 7));
		$this->my_excel->exportTo2007($filename);
	}
/************************************************************
|															|
|					\page: bo/dashboard						|
|															|
************************************************************/



/************************************************************
|															|
|		 page: bo/menu/manajemen/morbiditas					|
|															|
************************************************************/



	public function select_kunjunganri_px_dx_by_icd_rangebln_det($kode_icd=null, $tgl_start=null, $tgl_end=null){
		$this->load->model('m_daftarmandiri');
		$result = arr_repair($this->m_daftarmandiri->select_kunjunganri_px_dx_by_icd_rangebln_det($kode_icd, $tgl_start, $tgl_end) );
		echo json_encode($result);
	}

	public function select_kunjunganri_px_dx_by_icd_rangebln($kode_icd=null, $tgl_start=null, $tgl_end=null){
		$this->load->model('m_daftarmandiri');
		$result = arr_repair($this->m_daftarmandiri->select_kunjunganri_px_dx_by_icd_rangebln($kode_icd, $tgl_start, $tgl_end) );
		for($i=count($result); $i<12; $i++){
			$arr = [
				"bulan" 	 => ($i+1),
				"jml_px_all" => 0
			];
			array_push($result, $arr);
		}

		// echo "<pre>",print_r($result),"</pre>";
		echo json_encode($result);
	}

	public function select_kunjunganri_px_dx_by_icd_thn($kode_icd=null, $tahun=null){
		$this->load->model('m_daftarmandiri');
		$result = arr_repair($this->m_daftarmandiri->select_kunjunganri_px_dx_by_icd_rangebln($kode_icd, $tahun."-01", $tahun."-12") );
		for($i=count($result); $i<12; $i++){
			$arr = [
				"bulan" 	 => ($i+1),
				"jml_px_all" => 0
			];
			array_push($result, $arr);
		}

		// echo "<pre>",print_r($result),"</pre>";
		echo json_encode($result);
	}

/************************************************************
|															|
|		\page: bo/menu/manajemen/morbiditas					|
|															|
************************************************************/

/************************************************************
|															|
|	 page: bo/menu/manajemen/efisiensi-hunian-tempat-tidur	|
|															|
************************************************************/
	
	public function select_efisiensi_hunian_full($bln=null, $thn=null){
		$this->load->model('m_daftarmandiri');
		$res = $this->m_daftarmandiri->select_efisiensi_hunian($bln, $thn);

		$detail = ["HP", "LD", "KHM", "dead<48", "dead>=48", "dead", "hidup", "TT"];
		for ($j=0; $j < count($detail); $j++) { 
			$tot[$detail[$j]] = 0;
			for ($i=0; $i < count($res); $i++) { 
				$tot[$detail[$j]] += (int)$res[$i]["detail"][$detail[$j]];
			}
		}			

		$result = [
			"jumlah" => [
				"HP" 	=> $tot["HP"],
				"LD" 	=> $tot["LD"],
				"KHM" 	=> $tot["KHM"],
				"dead<48" 	=> $tot["dead<48"],
				"dead>=48" 	=> $tot["dead>=48"],
				"dead" 	=> $tot["dead"],
				"hidup" => $tot["hidup"],
				"TT" 	=> $tot["TT"],
			],
			"list" => $res 
		];
		echo json_encode($result);
	}


	public function dl_xls_stat_hospital($thn=null, $bln=null, $download=null){
		$this->load->model('m_daftarmandiri');
		$query = $this->m_daftarmandiri->dl_xls_stat_hospital($thn, $bln);

		if($download){
			// >>> EXCEL
			$set = setting_excel_table('laporan_statistik_rs');
			$filename = "laporan_statistik_rs - ".$bln."_".$thn;
			
			// exe_xls($query, $set, $filename);
			$this->load->library('my_excel');
			$this->my_excel->data_array($filename, $set, $query);
		}else{
			echo json_encode($query);
		}
	}

	

	// untuk mengecek di DB pernah insert data/tidak
	public function cek_statistik_inserted($thn=null, $bln=null){
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->cek_statistik_inserted($thn, $bln);
		// echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2)."/".$thn."/".$bln;
		// exit;

		if($result){ // update
			$val = [
				"code" => $result,
				"status" => "update",
				"message" => "Data sudah pernah disimpan. Apakah Anda ingin mengupdate data ini?" // "Data pernah diproses."
			];
		}else{ // insert
			$val = [
				"code" => $result,
				"status" => "insert",
				"message" => "Data akan disimpan ke database."
			];
		}

		echo json_encode($val);		
	}

	
	// public function insert_statistik($thn=null, $bln=null){
	public function execute_statistik($action=null, $thn=null, $bln=null){
		$user = $this->session->userdata("username");

		$this->load->model('m_daftarmandiri');

		$query = $this->m_daftarmandiri->select_efihuni_det_by_bln_thn($thn, $bln);
		$val_jumlah = [
				"tahun" => $thn,
				"bulan" => (int)$bln,
				"TT" => $query["jumlah"]["TT"],
				"HP" => $query["jumlah"]["HP"],
				"LD" => $query["jumlah"]["LD"],
				"KHM"=> $query["jumlah"]["KHM"],
				"dead_krg48" => $query["jumlah"]["dead<48"],
				"dead_lbh48" => $query["jumlah"]["dead>=48"],
				"dead" 	=> $query["jumlah"]["dead"],
				"hidup" => $query["jumlah"]["hidup"],
				"BOR" => $query["jumlah"]["BOR"],
				"LOS" => $query["jumlah"]["LOS"],
				"TOI" => $query["jumlah"]["TOI"],
				"BTO" => $query["jumlah"]["BTO"],
				"GDR" => $query["jumlah"]["GDR"],
				"NDR" => $query["jumlah"]["NDR"],
				"user"=> $user,
				"date"=> date("Y-m-d"),
				"time"=> date("H:i:s"),
			];

		// INSERT_BATCH
		for ($i=0; $i < count($query["list"]) ; $i++) {
			$val[$i] = [
				"tahun" => $thn,
				"bulan" => (int)$bln,
				"kodekelas" => $query["list"][$i]["mkls_kode"],
				"namakelas" => $query["list"][$i]["kls_mor"],
				"TT" => $query["list"][$i]["TT"],
				"HP" => $query["list"][$i]["detail"]["HP"],
				"LD" => $query["list"][$i]["detail"]["LD"],
				"KHM"=> $query["list"][$i]["detail"]["KHM"],
				"dead_krg48" => $query["list"][$i]["detail"]["dead<48"],
				"dead_lbh48" => $query["list"][$i]["detail"]["dead>=48"],
				"dead" 	=> $query["list"][$i]["detail"]["dead"],
				"hidup" => $query["list"][$i]["detail"]["hidup"],
				"BOR" => $query["list"][$i]["stat"]["BOR"],
				"LOS" => $query["list"][$i]["stat"]["LOS"],
				"TOI" => $query["list"][$i]["stat"]["TOI"],
				"BTO" => $query["list"][$i]["stat"]["BTO"],
				"GDR" => $query["list"][$i]["stat"]["GDR"],
				"NDR" => $query["list"][$i]["stat"]["NDR"],
				"user"=> $user,
				"date"=> date("Y-m-d"),
				"time"=> date("H:i:s"),
			];
			
		}


		// echo json_encode($val);
		// exit;
		switch ($action) {
			case 'select':
				$result = [
					"forptstatistik" 	=> $val_jumlah,
					"forptstatistikdet" => $val,
				];
				break;

			case 'insert':
				$result = $this->m_daftarmandiri->insert_new("forptstatistik", $val_jumlah);
				$result = $this->m_daftarmandiri->insert_batch("forptstatistikdet", $val);
				break;

			case 'update':
				$where = [
						"tahun" => $thn,
						"bulan" => $bln,
					];
				$result = $this->m_daftarmandiri->update_new("forptstatistik", $val_jumlah, $where);

				for ($i=0; $i < count($val) ; $i++) { 
					$where_val[$i] = [
							"tahun" => $thn,
							"bulan" => $bln,
							"namakelas" => $val[$i]["namakelas"],
						];
					$result = $this->m_daftarmandiri->update_new("forptstatistikdet", $val[$i], $where_val[$i]);
				}
					
				// $result = $this->m_daftarmandiri->update_batch("forptstatistikdet", $val, ["tahun", "bulan", "namakelas"]);
				// $result = $this->m_daftarmandiri->update_batch("forptstatistikdet", $val, "tahun, bulan, namakelas");
				break;

			case 'delete':
					$where = [
						"tahun" => $thn,
						"bulan" => $bln,
					];
					$result = $this->m_daftarmandiri->delete("forptstatistik", $where);
					$result = $this->m_daftarmandiri->delete("forptstatistikdet", $where); // menghapus detail 1 bulan
				break;
			
			default:
				# code...
				break;
		}				
		
		// $result = json_decode( json_encode($result) );
		echo json_encode( arr_repair($result) );
	}


/************************************************************
|															|
|	\page: bo/menu/manajemen/efisiensi-hunian-tempat-tidur	|
|															|
************************************************************/







/************************************************************
|															|
|			 page: bo/menu/casemix/pantauan_biaya_ri		|
|															|
************************************************************/
	public function get_carakeluar($where=null, $where_val=null){
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->get_carakeluar($where, $where_val);
		echo json_encode($result);
	}
	
	public function gd_biaya_ri_by_billing(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->gd_biaya_ri_by_billing($input);
		echo json_encode($result);
	}

	public function gd_total_biaya_ri_by_billing(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->gd_total_biaya_ri_by_billing($input);
		echo json_encode($result);
	}
	
		
	public function modif_gd_biaya_ri_det_by_billing($nobill=null){
		// $input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->modif_gd_biaya_ri_det_by_billing($nobill);
		// echo json_encode($result);
		echo "<pre>",print_r($result),"</pre>";
		// echo $result;
	}


	// // LAMA. INI V1
	// // DETAIL BILLING, MENAMPILKAN TARIF
	// public function modif_gd_biaya_ri_det_by_billing_pdf($nobill=null){
	// 	// $input = $this->input->get(NULL,TRUE);
	// 	$this->load->model('m_daftarmandiri');
	// 	$result = $this->m_daftarmandiri->modif_gd_biaya_ri_det_by_billing($nobill);
	// 	$px = $this->m_daftarmandiri->dtpx_for_det_bill($nobill)[0];

	// 	$data = ['px'=> $px, 'list' => $result];
	// 	// // TEST RUN
	// 	// echo json_encode($data); exit;

	// 	// untuk RUN view pengerjaan
	// 	// $this->load->view('file_template/pdf/rekening_detail_px_ri', $data); 
	// 	cetak_pdf('file_template/pdf/rekening_detail_px_ri', $data, "BILL_".$data['px']['nosep']."_".$nobill, 1); //$px['nosep']

	// }



	// BARU : 2020.01.13
	// DETAIL BILLING, TANPA MENAMPILKAN TARIF
	public function modif_gd_biaya_ri_det_by_billing_pdf_v2($nobill=null, $showTarif=null){
		// $input = $this->input->get(NULL,TRUE);
		$menit = 2;
		$settime = 60*$menit;
		set_time_limit($settime);

		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->modif_gd_biaya_ri_det_by_billing($nobill);
		$px = $this->m_daftarmandiri->dtpx_for_det_bill($nobill)[0];
		
		$data = ['px'=> $px, 'list' => $result, 'showTarif'=> $showTarif ];
		// echo json_encode($data); exit;
		// // TEST RUN
		// echo json_encode($data); exit;

		// untuk RUN view pengerjaan
		// $this->load->view('file_template/pdf/rekening_detail_px_ri', $data);

		cetak_pdf('file_template/pdf/rekening_detail_px_ri_v2', $data, "BILL_".$data['px']['nosep']."_".$nobill, 1); //$px['nosep']

	}
	
	
	public function sep_detbill_pdf($view=null, $nobill=null, $showTarif=null){
		// $input = $this->input->get(NULL,TRUE);
		$menit = 2;
		$settime = 60*$menit;
		set_time_limit($settime);

		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->modif_gd_biaya_ri_det_by_billing($nobill);
		$px = $this->m_daftarmandiri->dtpx_for_det_bill($nobill)[0];
		// $log = arr_repair( $this->m_daftarmandiri->logdaftarrj_by_key('nosep', $px['nosep']) );
		// $sep = $log[0]['data']['bridging']['res_c_sep'];
		// https://192.168.1.68/rscm/app_dev/ajaxreq/logdaftarrj_by_key/nosep/0195R0281121V003968

		$sep_cari = $this->ws_bpjs_11->ws_arr("vclaim", "GET", "SEP/".$px['nosep'], "" );
		$get_noka = $sep_cari['response']['peserta']['noKartu'];
		$path = 'Peserta/nokartu/'.$get_noka.'/tglSEP/'.date('Y-m-d');
		$peserta_cari = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "" );

		// $sep = null;
		// if($sep_cari['metaData']['code']==200) $sep = $sep_cari['response'];
		
		$data = ['px'=> $px, 'list' => $result, 'showTarif'=> $showTarif, 
			'res_sep' => $sep_cari,
			'res_peserta' => $peserta_cari, 
		];

		if($view==0 ){
			exit( json_encode($data) );
		}else if($view==1){
			// untuk RUN pdf view pengerjaan
			$this->load->view('file_template/pdf/sep_detbill', $data); 
			// exit;
		}else if($view==2){
			cetak_pdf('file_template/pdf/sep_detbill', $data, "BILL_".$data['px']['nosep']."_".$nobill, 1); //$px['nosep']

		}
		// echo "<pre>",print_r($log),"</pre>"; exit;
		// // TEST RUN
		// echo json_encode($data); exit;

		


	}


	// public function sep_detbill_pdf_run($nobill=null, $showTarif=null){

	// 	$data = $this->sep_detbill_pdf($nobill, $showTarif);
	// 	// untuk RUN pdf view pengerjaan
	// 	$this->load->view('file_template/pdf/sep_detbill', $data); 
	// 	// exit;

	// 	// cetak_pdf('file_template/pdf/sep_detbill', $data, "BILL_".$data['px']['nosep']."_".$nobill, 1); //$px['nosep']

	// }

	

	public function get_jadok(){
		// $input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->get_jadok();
		echo json_encode($result);
	}

	public function count_id_historidiag_by_bill(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->count_id_historidiag_by_bill($input);
		echo json_encode($result);
	}

	
	public function insert_daftarritarif(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->post(NULL,TRUE);

		$data1 = $input['data1'];
		$data2 = $input['data2'];

		$result = $this->m_daftarmandiri->insert_daftarritarif($data1,$data2);
		echo json_encode($result);
	}

	public function insert_historidiag(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		$result = $this->m_daftarmandiri->insert_historidiag($input);
		echo json_encode($result);
	}
	
	public function update_historidiag(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		$result = $this->m_daftarmandiri->update_historidiag($input);
		echo json_encode($result);
	}

	public function update(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		$result = $this->m_daftarmandiri->update($input);
		$result = json_decode( json_encode($result) ); // netralisir arr object
		echo json_encode($result);
	}
	
	// public function update_new($table=null, $arr_data=null, $where=null){
	public function update_new(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		// exit;
		$result = $this->m_daftarmandiri->update_new($input["table"], $input["arr_data"], $input["where"]);
		// $result = $this->m_daftarmandiri->update_new($table, $arr_data, $where);
		// $result = json_decode( json_encode($result) ); // netralisir arr object
		echo json_encode($result);
	}

	public function insert(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		$result = $this->m_daftarmandiri->insert($input);
		$result = json_decode( json_encode($result) ); // netralisir arr object
		echo json_encode($result);
	}
	
	public function delete(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		// $result = $this->m_daftarmandiri->delete($table_name, $where);
		$result = $this->m_daftarmandiri->delete($input);
		$result = json_decode( json_encode($result) ); // netralisir arr object
		echo json_encode($result);
	}



	public function get_histori_diag_by_nobill_idhisto(){
		$this->load->model('m_daftarmandiri');
		$input = $this->input->get(NULL,TRUE);
		$result = $this->m_daftarmandiri->get_histori_diag_by_nobill_idhisto($input);
		echo json_encode($result);
	}


	public function select_px_ri_detail_by_bill($nobill = null){
		$this->load->model('m_daftarmandiri');
		// $input = $this->input->get(NULL,TRUE);
		$result = $this->m_daftarmandiri->select_px_ri_detail_by_bill($nobill);
		echo json_encode($result);
	}


	// BISA. FIX PAKE INI
	public function viewpdf_rekeningri($nobill = null){
		
		$data = $this->input->post(NULL,TRUE);
		// $this->load->view('file_template/pdf/rekening_px_ri', $data);


		//CETAK PDF FIX
		$html=$this->load->view('file_template/pdf/rekening_px_ri', $data, true);
 
        //this the the PDF filename that user will get to download
        // $namaFile = "KASIR_".$data['pasien']['nobill'];
        $namaFile = $data['pasien']['nosep']."_".$data['pasien']['nobill'];
        // $namaFile = "KASIR_";
        $pdfFilePath = $namaFile.".pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->pdf;
 
       //generate the PDF from the given html
        // $this->m_pdf->pdf->WriteHTML($html);
        $pdf->WriteHTML($html);
 
        //download it.
        // $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
        $pdf->Output($pdfFilePath, "D"); 
        exit();
	}

	public function viewpdf_rekeningri_detail($nobill = null){
		
		$data = $this->input->post(NULL,TRUE);
		$this->load->view('file_template/pdf/rekening_detail_px_ri', $data);


		// //CETAK PDF FIX
		// $html=$this->load->view('file_template/pdf/rekening_detail_px_ri', $data, true);
 
  //       //this the the PDF filename that user will get to download
  //       // $namaFile = "KASIR_".$data['pasien']['nobill'];
  //       $namaFile = $data['pasien']['nosep']."_".$data['pasien']['nobill'];
  //       // $namaFile = "KASIR_";
  //       $pdfFilePath = $namaFile.".pdf";
 
  //       //load mPDF library
  //       $this->load->library('m_pdf');
  //       $pdf = $this->m_pdf->pdf;
 
  //      //generate the PDF from the given html
  //       // $this->m_pdf->pdf->WriteHTML($html);
  //       $pdf->WriteHTML($html);
 
  //       //download it.
  //       // $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
  //       $pdf->Output($pdfFilePath, "D"); 
  //       exit();
	}

	
	
/************************************************************
|															|
|			\page: bo/menu/casemix/pantauan_biaya_ri		|
|															|
************************************************************/




/************************************************************
|															|
|			 page: bo/menu/casemix/laporan_pasien_ri		|
|															|
************************************************************/
	// INI RENCANA MAU MENYEDERHANAKAN EXCELan select_laporan_px_ri_by_date, cuman kudu merombak
	public function new_select_laporan_px_ri_by_date($date=null){
		// $input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->new_select_laporan_px_ri_by_date($date);
		echo json_encode($result);
	}
	
	public function select_laporan_px_ri_by_date(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_laporan_px_ri_by_date($input);
		echo json_encode($result);
	}
	
	public function select_laporan_px_ri_by_daterange($date_start=null, $date_end=null, $download=null){
		// $input = $this->input->get(NULL,TRUE);
		$this->load->model('m_casemix');
		$query = $this->m_casemix->select_laporan_px_ri_by_daterange($date_start, $date_end, $download);
		
		if($download){
			// echo json_encode($query);exit;

			$set = setting_excel_table('download_xls_laporan_px_ri');
			$filename = "Laporan Pasien RI - ".$date_start."_".$date_end;

			$this->load->library('my_excel');
			$this->my_excel->data_array($filename, $set, $query);
		}else{
			$ina_rs = 0;
			$sum = [
				"HIJAU" => 0,
				"KUNING"=> 0,
				"MERAH" => 0,
				"HITAM" => 0,
			];
			$selisihInaRs = 0;

			for ($i=0; $i < count($query); $i++) { 
				$selisihInaRs = (int)$query[$i]['tarif_ina_terpilih'] - (int)$query[$i]['tarif_rs_now'];
				// $ina_rs += (int)$query[$i]['tarif_ina_terpilih'] - (int)$query[$i]['tarif_rs_now'];
				$ina_rs += $selisihInaRs;
				$sum[ $query[$i]['status_tarif'] ] += $selisihInaRs;
				
			}

			$val = [
				"li" => $query,
				"analisa" => [
					"sum_all" =>[
						"ina_rs" => $ina_rs,
						"sum" => $sum,
					],
				],
			];
			// echo json_encode($query);
			echo json_encode($val);
		}
	}

	public function q_select_laporan_px_ri_by_date(){ //???? TESTING utk get string
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->q_select_laporan_px_ri_by_date($input);
		echo json_encode($result);
		// echo '<pre>',print_r($_SERVER),'</pre>';
	}


	public function download_xls_laporan_px_ri(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$query = $this->m_daftarmandiri->q_select_laporan_px_ri_by_date($input);	

		// //tes
		// $result = $query->result();
		// echo json_encode($result);
		// //\tes

		// >>> EXCEL
		$set = setting_excel_table('download_xls_laporan_px_ri');
		// echo '<pre>',print_r($set),'</pre> <br><br>';
		// echo count($set);

		$header = [];
		$column = [];
		$width = [];
		for($i=0; $i<count($set); $i++){
			array_push($header, $set[$i]["header"]);
			array_push($column, $set[$i]["column"]);
			array_push($width, $set[$i]["width"]);
		}

		$filename = "Laporan Pasien RI - ".$input['date'];

		$this->load->library('my_excel');
		$this->my_excel->set_query($query);
		$this->my_excel->set_header($header);
		$this->my_excel->set_column($column);
		$this->my_excel->set_width($width);
		$this->my_excel->exportTo2007($filename);
	}

/************************************************************
|															|
|			\page: bo/menu/casemix/laporan_pasien_ri		|
|															|
************************************************************/


/************************************************************
|																										|
|			 page: bo/menu/casemix/laporan_pasien_rj			|
|																										|
************************************************************/
	public function select_laporan_px_rj_by_date($date=null, $download=null){
		$this->load->model('m_daftarmandiri');
		$query = $this->m_daftarmandiri->select_laporan_px_rj_by_date($date);
		// echo json_encode($result);
		if($download){
			// >>> EXCEL
			$set = setting_excel_table('laporan_tarif_rj');
			$filename = "Laporan Tarif RJ - ".$date;
			// exe_xls($query, $set, $filename);
			
			$this->load->library('my_excel');
			$this->my_excel->data_array($filename, $set, $query);
		}else{
			echo json_encode($query);
		}
	}

/************************************************************
|																										|
|			\page: bo/menu/casemix/laporan_pasien_rj			|
|																										|
************************************************************/


/************************************************************
|															|
|			 page: bo/menu/casemix/master_cp 				|
|															|
************************************************************/
	public function insert_mst_kegiatan(){
		$input = $this->input->post(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->insert_mst_kegiatan($input);
		echo json_encode($result);
	}

	public function select_mst_kegiatan(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_mst_kegiatan($input);
		echo json_encode($result);
	}

	public function get_detail_kegiatan_by_lokasi(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->get_detail_kegiatan_by_lokasi($input);
		echo json_encode($result);
	}

/************************************************************
|															|
|			\page: bo/menu/casemix/master_cp 				|
|															|
************************************************************/





/************************************************************
|															|
|	page: bo/menu/it/support/departemen/transfer-billing 	|
|															|
************************************************************/
	public function select_transfer_obat($noreff=null){
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_transfer_obat($noreff);
		echo json_encode($result);
	}

	public function select_fotrdaftar_by_bill($nobill=null){
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_fotrdaftar_by_bill($nobill);
		echo json_encode($result);
	}

/************************************************************
|															|
|	\page: bo/menu/it/support/departemen/transfer-billing 	|
|															|
************************************************************/



/************************************************************
|															|
|			 page: bo/menu/it/user/user-akses				|
|															|
************************************************************/
	public function select_user(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_user($input);
		echo json_encode($result);
	}

	public function select_menu_bo_sidebar_by_id(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_menu_bo_sidebar_by_id($input);
		echo json_encode($result);
	}

	public function select_menu_bo_sidebar_by_filterval(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_menu_bo_sidebar_by_filterval($input);
		echo json_encode($result);
	}

	// buat cek user ini punya akses ke menu_bo_sidebar apa saja
	public function cek_menu_akses(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_user');
		$result = $this->m_user->get_userakses_menu($input);
		echo json_encode($result);
	}


/************************************************************
|															|
|			\page: bo/menu/it/user/user-akses				|
|															|
************************************************************/



/************************************************************
|															|
|			 page: bo/menu/it/setting/printer				|
|															|
************************************************************/
	public function load_printer(){
		$this->load->library("Print_kertas");
		// print_r($this->print_kertas->my_printer_list());

		$data = array(
				"username"	=> $this->session->username,
				"my_printer_list" => $this->print_kertas->my_printer_list()
			);
		echo json_encode($data);
	}

/************************************************************
|															|
|			\page: bo/menu/it/setting/printer				|
|															|
************************************************************/

/************************************************************
|															|
|			 page: bo/menu/it/web/upload-artikel			|
|															|
************************************************************/
	public function slug(){
		$input = $this->input->get(NULL, TRUE);
		$data = [
			"slug" => slug($input['judul'])
		];
		echo json_encode($data);
	}

/************************************************************
|															|
|			\page: bo/menu/it/web/upload-artikel			|
|															|
************************************************************/


/************************************************************
|															|
|			 page: akuntansi/laporan-pendapatan-dokter 		|
|															|
************************************************************/

	public function select_dokter_all_lappendapatandokter($tgl_start=null, $tgl_end=null){
		$this->load->model('m_daftarmandiri');
		$query = $this->m_daftarmandiri->select_dokter_all_lappendapatandokter($tgl_start, $tgl_end);
		echo json_encode($query);		
	}

	public function select_laporan_pendapatan_dokter_all($tgl_start=null, $tgl_end=null, $download=null){
		// $input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter_all($tgl_start, $tgl_end, $download);

		if($download){
			// >>> EXCEL
			$set = setting_excel_table('laporan_pendapatan_dokter');
			$filename = "Laporan Pendapatan Dokter ALL - ".$tgl_start."_".$tgl_end;
	    exe_xls($query, $set, $filename);
		}else{
			echo json_encode($query);
		}
	}

	// public function select_laporan_pendapatan_dokter($tgl_start=null, $tgl_end=null, $kode_dokter=null, $penanggung=null, $download=null){
	// 	// $input = $this->input->get(NULL,TRUE);
	// 	$this->load->model('m_daftarmandiri');
	// 	$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter($tgl_start, $tgl_end, $kode_dokter, $penanggung, $download);

	// 	if($download){
	// 		// >>> EXCEL
	// 		$set = setting_excel_table('laporan_pendapatan_dokter');
	// 		$filename = "Laporan Pendapatan Dokter - ".$kode_dokter." - ".$tgl_start."_".$tgl_end."_".$penanggung;
	//         exe_xls($query, $set, $filename);
	// 	}else{
	// 		echo json_encode($query);
	// 	}
	// }

	// public function select_laporan_pendapatan_dokter_bhp($tgl_start=null, $tgl_end=null, $kode_dokter=null, $penanggung=null, $download=null){
	// 	$this->load->model('m_daftarmandiri');
	// 	$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter_bhp($tgl_start, $tgl_end, $kode_dokter, $penanggung, $download);

	// 	if($download){
	// 		// >>> EXCEL
	// 		$set = setting_excel_table('laporan_bhp');
	// 		$filename = "Laporan BHP - ".$kode_dokter." - ".$tgl_start."_".$tgl_end."_".$penanggung;
	//         exe_xls($query, $set, $filename);
	// 	}else{
	// 		echo json_encode($query);
	// 	}
	// }

	public function select_laporan_dokter($pendapatan_bhp=null, $date=null, $kode_dokter=null, $penanggung=null, $download=null){
		$this->load->model('m_daftarmandiri');
		$tgl_start = month_now_yesterday($date."-01")["now"]["startday"];
		$tgl_end   = month_now_yesterday($date."-01")["now"]["endday"];
		// echo $tgl_start.$tgl_end;
		// exit;

		if($pendapatan_bhp=='PENDAPATAN'){
			$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter($tgl_start, $tgl_end, $kode_dokter, $penanggung, $download);
		}else if($pendapatan_bhp=='BHP'){
			$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter_bhp($tgl_start, $tgl_end, $kode_dokter, $penanggung, $download);
		}


		if($download){ // >>> EXCEL
			$set = setting_excel_table('LAPORAN_DOKTER_'.$pendapatan_bhp);
			$filename = $kode_dokter." - LAPORAN DOKTER - ".$pendapatan_bhp."_".$penanggung."_".$date;
	        exe_xls($query, $set, $filename);				
		}else{
			echo json_encode($query);
		}
	}


/************************************************************
|															|
|			\page: /akuntansi/laporan-pendapatan-dokter 	|
|															|
************************************************************/


/************************************************************
|															|
|			 page: /akuntansi/voucher-hutang 			 	|
|															|
************************************************************/

	public function select_laporan_dokter_det($pendapatan_bhp=null, $date=null, $kode_dokter=null, $penanggung=null){
		$this->load->model('m_daftarmandiri');
		$tgl_start = month_now_yesterday($date."-01")["now"]["startday"];
		$tgl_end   = month_now_yesterday($date."-01")["now"]["endday"];
		$total = 0;

		if($pendapatan_bhp=='PENDAPATAN'){
			$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter($tgl_start, $tgl_end, $kode_dokter, $penanggung, 0);
			$param_tot = 'netto';			
		}else if($pendapatan_bhp=='BHP'){
			$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter_bhp($tgl_start, $tgl_end, $kode_dokter, $penanggung, 0);
			$param_tot = 'TotalTarif';
		}


		for($i=0; $i<count($query); $i++){
			$total += (float)$query[$i][$param_tot]; 
		}		

		$val = [
			"bulan" => month_now_yesterday($tgl_start)['now']['bulan_indo'],
			"tahun" => month_now_yesterday($tgl_start)['now']['year'],
			"total" => $total,
			"list"	=> $query
		];
		echo json_encode($val);

	}

	public function select_voucher_hutang_dokter($tgl_start=null, $tgl_end=null, $kode_dokter=null, $download=null, $pdf=null){
		$this->load->model('m_daftarmandiri');

		$penanggung = "nonbpjs";
		$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter($tgl_start, $tgl_end, $kode_dokter, $penanggung, $download);
		$q['pendapatan'][$penanggung] 	= $query;
		$total['pendapatan'][$penanggung] = 0;
		for($i=0; $i<count($query); $i++){
			$total['pendapatan'][$penanggung] += (float)$query[$i]['netto']; 
		}


		$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter_bhp($tgl_start, $tgl_end, $kode_dokter, $penanggung, $download);
		$q['bhp'][$penanggung] 	= $query;
		$total['bhp'][$penanggung] = 0;
		for($i=0; $i<count($query); $i++){
			$total['bhp'][$penanggung] += (float)$query[$i]['TotalTarif']; 
		}



		$penanggung = "bpjs";
		$tgl_start_bpjs = month_now_yesterday($tgl_start)['yesterday']['startday'];
		$tgl_end_bpjs = month_now_yesterday($tgl_start)['yesterday']['endday'];
		$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter($tgl_start_bpjs, $tgl_end_bpjs, $kode_dokter, $penanggung, $download);
		$q['pendapatan'][$penanggung] 	= $query;
		$total['pendapatan'][$penanggung] = 0;
		for($i=0; $i<count($query); $i++){
			$total['pendapatan'][$penanggung] += (float)$query[$i]['netto']; 
		}


		$query = $this->m_daftarmandiri->select_laporan_pendapatan_dokter_bhp($tgl_start_bpjs, $tgl_end_bpjs, $kode_dokter, $penanggung, $download);
		$q['bhp'][$penanggung] 	= $query;
		$total['bhp'][$penanggung] = 0;
		for($i=0; $i<count($query); $i++){
			$total['bhp'][$penanggung] += (float)$query[$i]['TotalTarif']; 
		}

		// echo "<pre>",print_r(month_now_yesterday($tgl_start)),"</pre>";
		// exit;
		$val = [
			"kd_dokter" => $kode_dokter,
			"data" => [
				"pendapatan_nonbpjs" => [
					"bulan" => month_now_yesterday($tgl_start)['now']['bulan_indo'],
					"tahun" => month_now_yesterday($tgl_start)['now']['year'],
					"total" => $total['pendapatan']['nonbpjs'],
					"list"	=> $q['pendapatan']['nonbpjs']
				],
				"pendapatan_bpjs" 	  => [
					"bulan" => month_now_yesterday($tgl_start)['yesterday']['bulan_indo'],
					"tahun" => month_now_yesterday($tgl_start)['yesterday']['year'],
					"total" => $total['pendapatan']['bpjs'],
					"list" 	=> $q['pendapatan']['bpjs']
				],
				"bhp_nonbpjs" => [
					"bulan" => month_now_yesterday($tgl_start)['now']['bulan_indo'],
					"tahun" => month_now_yesterday($tgl_start)['now']['year'],
					"total" => $total['bhp']['nonbpjs'],
					"list"	=> $q['bhp']['nonbpjs']
				],
				"bhp_bpjs" 	  => [
					"bulan" => month_now_yesterday($tgl_start)['yesterday']['bulan_indo'],
					"tahun" => month_now_yesterday($tgl_start)['yesterday']['year'],
					"total" => $total['bhp']['bpjs'],
					"list" 	=> $q['bhp']['bpjs']
				]
			],			
				
		];			


		if($pdf){ 
			//$this->load->view('file_template/pdf/laporan-dokter-pendapatan-bhp-det-pdf', $val);
			cetak_pdf('file_template/pdf/laporan-dokter-pendapatan-bhp-det-pdf', $val, 
				"DETAIL_".$kode_dokter."_".$tgl_start."_".$tgl_end, 1); 
		}else{
			if($download==0){ // view array
				echo json_encode($val);
			}else{
				echo null;
			}
		}
	}

	public function laporan_dokter_pendapatan_bhp_det_pdf($nobill=null){
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->modif_gd_biaya_ri_det_by_billing($nobill);
		$px = $this->m_daftarmandiri->dtpx_for_det_bill($nobill)[0];

		$data = ['px'=> $px, 'list' => $result];
		// untuk RUN view pengerjaan
		// $this->load->view('file_template/pdf/rekening_detail_px_ri', $data); 
		cetak_pdf('file_template/pdf/rekening_detail_px_ri', $data, "BILL_".$data['px']['nosep'], 1); //$px['nosep']
	}

/************************************************************
|															|
|			\page: /akuntansi/voucher-hutang 			 	|
|															|
************************************************************/


/************************************************************
|															|
|			 page: hrd 										|
|															|
************************************************************/

	public function select_hrd_abs_log(){
		$input = $this->input->get(NULL,TRUE);
		$this->load->model('m_daftarmandiri');
		$result = $this->m_daftarmandiri->select_hrd_abs_log($input);
		echo json_encode($result);
	}
/************************************************************
|															|
|			\page: /hrd 									|
|															|
************************************************************/




	// FAIL, BELUM BISA, KARENA OBJECT m-daftarmandiri harus pake variabel passing
	// public function _ajax_get(){
	// 	$input = $this->input->get(NULL,TRUE);
	// 	$this->load->model('m_daftarmandiri');
	// 	$result = $this->m_daftarmandiri->get_detail_kegiatan_by_lokasi($input);
	// 	echo json_encode($result);
	// }



	public function tes_cetak_render(){
		$this->load->library("m_pdf");
		$data = array(
				"noKartu" => $this->input->post("noKartu"),
				"tglSep" => $this->input->post("tglSep")
			);
		$sumber = $this->load->view('vclaim/sep_resume_cetak',$data,TRUE);
		//$sumber = $this->load->view('vclaim/sep_resume_cetak',[],TRUE);

		$html = $sumber;
		
		$pdfFilePath = "sep_resume.pdf";
		
		$css = "assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css";
		$stylesheet = "<style>".file_get_contents($css)."</style>";

		$pdf = $this->m_pdf->load();
		$pdf->AddPage('L');
		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, "D");
		exit();
	}


	public function daftar_printer(){
		$getprt = printer_list(PRINTER_ENUM_CONNECTIONS);
        $printers = serialize($getprt);
        $printers = unserialize($printers);
        $js = json_encode($printers);
        echo $js; //ambil yg NAME

		// echo "<br>";
		// echo count($js);
		// $jsd = json_decode($js);
		//echo json_encode(  array('tes'=>$jsd[0]->NAME) );
        // //echo $jsd[1]; //X
        // echo count($jsd);
        // //echo $js[0]->NAME;
	}


	public function viewpdf_surat_ket_kematian($norm=null, $tgl_meninggal=null, $kd_dokter=null, $dokter=null){
		// $data = $this->input->post(NULL,TRUE);
		$input['tgl_meninggal'] = $tgl_meninggal;
		$input['kd_dokter'] 	= $kd_dokter;
		$input['dokter'] 		= urldecode($dokter);

		$this->load->model('m_daftarmandiri');
		$result = arr_repair($this->m_daftarmandiri->gd_pasien_rscm_by_norm($norm));
		// echo "<pre>",print_r($result),"</pre>";

		$tglLahir = $result["datajs"][0]["TglLahir"];
		$umur 	  = usia($tglLahir); // HITUNG UMUR/USIA

		$data = [
			"nama" 	=> $result["datajs"][0]["Nama"],
			"jk"	=> $result["datajs"][0]["Sex"],
			"umur"	=> $umur,
			"alamat"=> $result["datajs"][0]["Alamat"],
			"tgl_meninggal" => $input['tgl_meninggal'], // pake get
			"dokter"		=> $input['dokter'], // pake get
			"kd_dokter"		=> $input['kd_dokter'], // pake get
		];
		// $this->load->view('file_template/pdf/surat-keterangan-kematian', $data);


		//CETAK PDF FIX
		$html=$this->load->view('file_template/pdf/surat-keterangan-kematian', $data, TRUE);
 
        //this the the PDF filename that user will get to download
        $namaFile = "Surat Kematian_".$norm;
        // $namaFile = "KASIR_";
        $pdfFilePath = $namaFile.".pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');

        // $pdf = $this->m_pdf->pdf; // FIX BISA
        $pdf = new mPDF('c', 'A5-L');
		// $pdf->AddPage('P');        
 
       //generate the PDF from the given html
        $pdf->WriteHTML($html);
 
        //download it.
        $pdf->Output($pdfFilePath, "D"); 
        exit();
	}




	//=======================[   monitoring-error ]========================
	public function dl_xls_sukubangsa_kosong($tgl_start=null, $tgl_end=null, $download=null){
		$this->load->model('m_daftarmandiri');
		$query = $this->m_daftarmandiri->dl_xls_sukubangsa_kosong($tgl_start, $tgl_end);

		if($download){
			// >>> EXCEL
			// echo json_encode($query); exit;
			$set = setting_excel_table('laporan_sukubangsa_kosong');
			$filename = "sukubangsa_kosong - ".$tgl_start."_".$tgl_end;
			// exe_xls($query, $set, $filename);

			$this->load->library('my_excel');
			$this->my_excel->data_array($filename, $set, $query);
		}else{
			echo json_encode($query);
		}
	}

	public function dl_xls_agama_kosong($tgl_start=null, $tgl_end=null, $download=null){
		$this->load->model('m_daftarmandiri');
		$query = $this->m_daftarmandiri->select_agama_kosong($tgl_start, $tgl_end);

		if($download){
			// // >>> EXCEL
			// // echo json_encode($query); exit;
			// $set = setting_excel_table('laporan_sukubangsa_kosong');
			// $filename = "sukubangsa_kosong - ".$tgl_start."_".$tgl_end;
		//       // exe_xls($query, $set, $filename);
		
			// $this->load->library('my_excel');
			// $this->my_excel->data_array($filename, $set, $query);
		}else{
			echo json_encode($query);
		}
	}
	//=======================[  /monitoring-error ]========================


	public function prin($label=null){
		$this->load->library('print_kertas');
		$pr = $this->print_kertas->printer_db_default($label);
		echo json_encode($pr);
	}
	//================================================
	//==================== RSCM ======================
	//================================================



	// SUDAH DIPINDAH KE CONTROLLER ECLAIM. BISA DIHAPUS
	//================================================
	//==================== ws_eclaim =================
	//================================================
	// public function ws_eclaim($method = NULL){
	// 	// if(isset($method)$method == TRUE){

	// 	if(!empty($method)){
	// 		$input = $this->input->get(NULL,TRUE);

	// 		switch($method){
	// 			case "search_diagnosis":
	// 				$js = array(
	// 					"metadata" => array(
	// 						"method" => $method
	// 					),
	// 					"data" => array(
	// 						"keyword" => $input['keyword']
	// 					)
	// 				);
	// 				break;

	// 			case "search_procedures": 
	// 				$js = array(
	// 					"metadata" => array(
	// 						"method" => $method
	// 					),
	// 					"data" => array(
	// 						"keyword" => $input['keyword']
	// 					)
	// 				);
	// 				break;
	// 		}
				
	// 		$json_request = json_encode($js);
	// 		// echo $json_request;

	// 		// $val = $this->ws_eclaim->ws("POST", $json_request);
	// 		// return $val;
			
	// 		$val = $this->ws_eclaim->ws("POST", $json_request);
	// 		echo $val;
	// 	}
			
	// }


	//================================================
	//====================\ws_eclaim =================
	//================================================




	


}
