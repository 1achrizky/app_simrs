<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wsbpjs2 extends CI_Controller {
	protected $vclaimVersion = "vclaimdev";
	protected $vclaimUser = "";
	protected $PATH_INFO = null;

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->library('Ws_bpjs_2' );
		$this->vclaimUser = $this->session->userdata("username");
		$this->PATH_INFO = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
	}


	function dataHeader(){
		$menu = [
			[
				"title" => "SEP",
				"url" => "",
				"icon" => "fa fa-folder",
				"children" => [
					[
						"title" => "Create SEP",
						"url" => base_url()."wsbpjs2/uat/create-sep",
						"icon" => "fa fa-circle-o text-aqua",
						"children" => null,
					],
					[
						"title" => "Pengajuan SEP",
						"url" => base_url()."wsbpjs2/uat/pengajuan-sep",
						"icon" => "fa fa-circle-o text-aqua",
						"children" => null,
					],
					[
						"title" => "Update Pulang SEP",
						"url" => base_url()."wsbpjs2/uat/sep/update-tgl-plg",
						"icon" => "fa fa-circle-o text-aqua",
						"children" => null,
					],
					

				],
			],
			[
				"title" => "Klaim",
				"url" => "",
				"icon" => "fa fa-folder",
				"children" => [
					[
						"title" => "Data Klaim",
						"url" => base_url()."wsbpjs2/uat/monitoring/monitoring-klaim",
						"icon" => "fa fa-circle-o text-aqua",
						"children" => null,
					],
				],
			],
			[
				"title" => "Referensi",
				"url" => base_url()."wsbpjs2/uat/referensi",
				"icon" => "fa fa-book text-aqua",
				"children" => null,
			],
			[
				"title" => "WS Test",
				"url" => base_url()."wsbpjs2/uat/ws-test",
				"icon" => "fa fa-book text-aqua",
				"children" => null,
			],
		];

		$dataHeader = [
			"username" => "admin",
			"menu" => $menu,
		];
		return $dataHeader;
	}

	function errorMetaData($code=null, $message=null, $status='failed'){
		return [
			"metaData" => [
				"code" 		=> $code,
				"message" => $message,
				"status" 	=> $status,
			],
		];
	}

	function notifLabel( $code=null, $message=null, $alertType=null, $keyName=null){
		if($alertType == null) $alertType = ($code==200)? 'success' : 'danger';
		
		$notif = [
			'code' 	 	=> $code,
			'message'	=> $message,
			'alertType'=> $alertType,
			'keyName' => $keyName, // untuk antisipasi bila jadi KEY pencarian
		];
		return $notif;
	}
	

	// // Belum dipakai, karena saat cetak json_encode, tampilan tidak PRETTY JSON karena ada HTML
	// // solusi htmlnya, olah di function JS
	// function notifLabelHtml( $code=null, $message=null, $type=null){
	// 	if($type == null) $type = ($code==200)? 'success' : 'danger';
		
	// 	$html = 
	// 		'<div style="margin:2px 0px;">'.
	// 			'<span name="'.$code.'" class="alert alert-'.$type.'" style="padding:0px 5px;">'.$message.'</span>'.
	// 		'</div>';

	// 	$notif = [
	// 		'code' 	 => $code,
	// 		'message'=> $message,
	// 		'html' 	 => $html,
	// 	];
	// 	return $notif;
	// }


	function cek_rujukan_aktif($tglKunjungan){
		$daydiff = dateDiff($tglKunjungan, date("Y-m-d"));	
		$status = ($daydiff <= 90)? "AKTIF" : "HABIS";
			
		return [
			"status" => $status,
			"selisih_hari" => $daydiff,
		];
	}
	
	function cek_rujukan_aktif_booking($tglKunjungan, $hariDaftar=null){
		// $hariDaftar= ['hari_besok', 'hari_ini'];
		$tglDaftar = ($hariDaftar=='hari_besok')? $tglDaftar = selisih_hari(date("Y-m-d"), "+1") : date("Y-m-d");
		
		$daydiff = dateDiff($tglKunjungan, $tglDaftar);	
		$logic 	= ($daydiff <= 90)? true: false;
		$status = ($daydiff <= 90)? "AKTIF": "HABIS";			
		$message = "Rujukan sudah berjalan ".$daydiff." hari.";
	
		return [
			"logic"  => $logic,
			"status" => $status,
			"selisih_hari" 	=> $daydiff,
			"tglDaftar" 		=> $tglDaftar,
			"tglKunjungan" 	=> $tglKunjungan,
			"hariDaftar" 		=> $hariDaftar,
			"message" 			=> $message,
			"shortMsg" 			=> $status.'('.$daydiff.' hari)',
		];
	}



	// ==============\FUNCTION =============


	
	public function index(){
		// $this->load->view("wsbpjs2/uat/header", $this->dataHeader());
		// $this->load->view("wsbpjs2/uat/create-sep");
		// $this->load->view("wsbpjs2/uat/footer");
		
		header('Location: '.base_url().'wsbpjs2/uat/create-sep'); exit;	
	}


	function my_uri(){
		//=== function uri ===
		// if (!defined('PATH_INFO')) define('PATH_INFO', str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']) );
		defined('PATH_INFO') OR define('PATH_INFO', str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']) );
		// define('PATH_INFO', str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']) );
		// echo PATH_INFO;
		//print_r($_GET);
		
		$uri = [];
		if(strlen(PATH_INFO) != 0 ){
			if(PATH_INFO[0] == '/'){
				$uri =  explode("/", substr( $_SERVER['PATH_INFO'], 1) );
				return $uri;
				//echo "<br>===".$uri[0];
				// echo "<pre>", print_r($uri) ,"</pre>";
			}else return false;		
		}else return false;		
		//\=== function uri ===
	}

	function url_partition(){
		$methodName = $this->router->fetch_method();
		$arr_path = explode('/', $this->PATH_INFO);
		$id_method = array_search( $methodName, $arr_path);
		$page_slice = array_slice($arr_path, $id_method+1);
		$cnt_page_slice = count($page_slice);
		$res_page = implode('/', $page_slice);

		$start = 3;
		$max_url = $start+$cnt_page_slice;
		//count num of segment. start 4.
		$segment = 0; //set awal, supaya tidak error do logika <get data XUSERAKSES>
		$segment_arr = [];		
		$pages = '';
		for($i=$start; $i<$max_url; $i++){
			// echo $this->uri->segment($i).' , ';	// CEK
			if( !$this->uri->segment($i)){
				break;
			}else{
				$segment = $i; // final loop will get max segment
				// $page .= '/'.$this->uri->segment($segment);
				$segment_arr[] = $this->uri->segment($segment);
			}
		}
		
		$pages = join('/', $segment_arr);

		

		$val = [
			"PAGES" => $pages,
			"PATH_INFO" => $this->PATH_INFO,
			"EXPLODE" 	=> explode('/', $this->PATH_INFO),
			"id_method" => $id_method,
			"page_slice"=> $page_slice,
			"cnt_page_slice"=> $cnt_page_slice,
			"res_page" 	=> $res_page,
			"METHOD_NAME" => $methodName,
		];
		return $val;
	} 
	
	public function uatx($page=null){
		// $pages = $this->url_partition($page);
		// exit(json_encode($pages ));	
		
		$pages = [
			$this->url_partition($page),
		];
		exit(json_encode($pages ));	

	}

	public function uat($page=null){
		if($page==null) redirect(base_url("wsbpjs2/index"));
		
		$this->load->view("wsbpjs2/uat/header", $this->dataHeader());
		// $this->load->view("wsbpjs2/uat/".$page);
		$this->load->view("wsbpjs2/uat/".$this->url_partition($page)['PAGES']);
		$this->load->view("wsbpjs2/uat/footer");
	}

	public function url(){
		// echo $_GET['url'];
		// exit(json_encode([$_GET['url']] ));
		$get = $this->input->get(NULL, TRUE);
		$path = $get['url'];
		// exit(json_encode([$path] ));
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		exit(json_encode($res ));
	}

  	
	public function r_historiPelayanan($noka=null, $tglMulai=null, $tglAkhir=null){
		$path = 'monitoring/HistoriPelayanan/NoKartu/'.$noka.'/tglMulai/'.$tglMulai.'/tglAkhir/'.$tglAkhir;
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		return $res;
	}

	public function historiPelayanan($noka=null, $tglMulai=null, $tglAkhir=null){
		$res = $this->r_historiPelayanan($noka, $tglMulai, $tglAkhir);
		$histos = $res['response']['histori'];

		// cari yg hanya rscm  =>>> ppkPelayanan": "RS Citra Medika",
		$newHistos = [];
		for ($i=0; $i < count($histos); $i++) { 
			if($histos[$i]['ppkPelayanan'] == 'RS Citra Medika' ){
				$histos[$i]['jnsPelayananLabel'] = ($histos[$i]['jnsPelayanan']=='2')? 'Rawat Jalan':'Rawat Inap';
				$newHistos[] = $histos[$i];
			}
		}

		$res['response']['newHistori'] = $newHistos;
		exit(json_encode($res ));
	}
	
	
	public function r_fingerprint($noka=null, $tgl=null){
		$tgl = ($tgl==null)? date('Y-m-d'): $tgl;
    $path = 'SEP/FingerPrint/Peserta/'.$noka.'/TglPelayanan/'.$tgl;    
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		return $res;
	}

	function fingerprint_lokasi_boolean($kdLokasi=null){
		$kdLokasi = strtoupper($kdLokasi);
		$li = ["MAT", "JAN", "IRM", "HDL"];
		$val = in_array($kdLokasi, $li);
		// $res = ($val!=-1)? true:false;
		// return $res;
		return ["value" => $val]; 
	}

	function r_fingerprint_check($noka=null, $klinik=null){
		$fp = null;
		$fp_boleh = false;
		$fp_lokasi_bool = $this->fingerprint_lokasi_boolean($klinik)['value'];

		if($fp_lokasi_bool){
			$fp = $this->r_fingerprint($noka);
			// 0 = "Peserta belum melakukan validasi finger print"
			if($fp['metaData']['code']==200) $fp_boleh = ($fp['response']['kode']=='1')? true:false;
			else exit(json_encode( $fp ));

			if(!$fp_boleh) exit(json_encode( $this->errorMetaData(201, $fp['response']['status'], "failed") ));
		}

		return [
			"ws" => $fp,
			"fp_boleh" => $fp_boleh,
			"fp_lokasi_bool" => $fp_lokasi_bool,
		];
	}

	// testing
	public function fingerprint_lokasi($kdLokasi=null){
		exit(json_encode(  $this->fingerprint_lokasi_boolean($kdLokasi) ));	
	}
	
	public function fingerprint_check($noka=null, $klinik=null){
		exit(json_encode(  $this->r_fingerprint_check($noka, $klinik) ));	
	}


	
	public function r_peserta($noka=null, $tglSep=null){
		$tglSep = ($tglSep==null)? date('Y-m-d'): $tglSep;
		// exit(json_encode([$noka, $tglSep] ));
    $path = 'Peserta/nokartu/'.$noka.'/tglSEP/'.$tglSep;
    
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		return $res;		
	}
	
	public function peserta_by_nik($nik=null, $tglSep=null){
		$tglSep = ($tglSep==null)? date('Y-m-d'): $tglSep;
    $path = 'Peserta/nik/'.$nik.'/tglSEP/'.$tglSep;
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		exit(json_encode($res ));			
	}
	
	public function peserta($noka=null, $tglSep=null){
		$res = $this->r_peserta($noka, $tglSep);
		exit(json_encode($res ));		
	}

	public function r_multirjk($noka=null){
    $path = 'Rujukan/List/Peserta/'.$noka;   
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		return $res;		
	}


	public function refFaskes($nama=null, $jenis=1){
		$path = 'referensi/faskes/'.$nama.'/'.$jenis;
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		exit(json_encode($res ));	
	}
	
	public function refDokterDpjp($kdLokasi=null, $tgl=null, $pelayanan=null){
		$tgl = ($tgl==null)? date('Y-m-d'): $tgl;
		// Jenis Pelayanan (1. Rawat Inap, 2. Rawat Jalan)
		$pelayanan = ($pelayanan==null)? 2: $pelayanan;
		$path = 'referensi/dokter/pelayanan/'.$pelayanan.'/'.'tglPelayanan/'.$tgl.'/'.'Spesialis/'.$kdLokasi;
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		exit(json_encode($res ));	
	}
	
	
	public function refDokter($a=null){
		// $path = 'referensi/dokter/'.$a;
		$path = 'referensi/dokter/anggono';
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		exit(json_encode($res ));
	}
	// ihwan, thiwut, anggono
	
	public function spesialistik($a=null){
		$path = 'referensi/spesialistik';
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		exit(json_encode($res ));	
	}
	
	
	
	
	public function multiRujukan(){
		$get = $this->input->get(NULL, TRUE);
		$path = $get['url'];
		$noka = explode('/', $path)[3];
		// exit(json_encode($exp ));	

		$this->load->library('Ws_bpjs_2' );
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		$res['notifLabel'][] = $this->notifLabel($res['metaData']['code'], $res['metaData']['message']);
		
		// $noka = ;
		if($res['response']==null){
			$peserta = $this->r_peserta($noka);
			$res['peserta'] = $peserta;
			$res['notifLabel'][] = $this->notifLabel('', $peserta['response']['peserta']['statusPeserta']['keterangan'], 'info');
		}
		exit(json_encode($res ));	
	}

	

	public function cariPesertaFilter($noka=null){
		$peserta = $this->r_peserta($noka);
		$mRjk = null;
		$notif = [];

		//Filter Status Peserta. Cek Kepesertaan.
		if($peserta['metaData']['code'] == 200){
			$statusPeserta = $peserta['response']['peserta']['statusPeserta'];
			$alertType = ($statusPeserta['kode']=="0")? "success":"danger";
			$notif[] = $this->notifLabel('', 'Status Peserta: '.$statusPeserta['keterangan'], $alertType );			
			
		}else{
			$notif[] = $this->notifLabel($peserta['metaData']['code'], '[BPJS | Cek Status Peserta]'.$peserta['metaData']['message'] );			
		}

		//Filter Multi Rujukan
		$mRjk = $this->r_multirjk($noka);
		if($mRjk['metaData']['code'] == 200){
				$rujukans = $mRjk['response']['rujukan'];
				for ($i=0; $i < count($rujukans); $i++) { 
					$mRjk['response']['rujukan'][$i]['checkRjk'] = $this->cek_rujukan_aktif_booking( $mRjk['response']['rujukan'][$i]['tglKunjungan'], 'hari_ini');
					// $mRjk['response']['rujukan'][$i]['statusRjk'] = $mRjk['response']['rujukan'][$i]['checkRjk']['status'];
				}
		}else{
			$notif[] = $this->notifLabel($mRjk['metaData']['code'], '[BPJS | Cek Multirujukan]'.$mRjk['metaData']['message'] );
		}		

		
		$res = [
			"peserta" => $peserta,
			"mRjk" => $mRjk,
			"notifLabel" => $notif,
		];
		
		exit(json_encode($res ));		
		// exit(json_encode($res["ws"]["peserta"] ));		
	}
	
	
	public function r_SEP($nosep=null){
    $path = 'SEP/'.$nosep;    
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		return $res;
	}
	
	public function SEP($nosep=null){
		exit(json_encode( $this->r_SEP($nosep) ));
	}
	
	public function r_propinsi(){
		$path = 'referensi/propinsi';
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		
		if($res['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_SEP['metaData']['code'].']'.$r_SEP['metaData']['message'], "failed") ));
		else $res = $res['response']['list'];
		
		return $res;
	}
	
	public function r_kabupaten($kode='14'){
		$path = 'referensi/kabupaten/propinsi/'.$kode;
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		
		if($res['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_SEP['metaData']['code'].']'.$r_SEP['metaData']['message'], "failed") ));
		else $res = $res['response']['list'];
		
		return $res;
	}
	
	public function r_kecamatan($kode='0195'){
		$path = 'referensi/kecamatan/kabupaten/'.$kode;
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		
		if($res['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_SEP['metaData']['code'].']'.$r_SEP['metaData']['message'], "failed") ));
		else $res = $res['response']['list'];

		return $res;
	}
	
	// public function ld_first_pendaftaran(){}

	public function ld_first_laka(){
		$propinsi = $this->r_propinsi();
		$kabupaten = $this->r_kabupaten();
		$kecamatan = $this->r_kecamatan();
		
		$val = [
			"lokasiLaka" => [
				"propinsi" => $propinsi,
				"kabupaten" => $kabupaten,
				"kecamatan" => $kecamatan,
			],
		];

		exit(json_encode( $val ));
	}


	// TESTING: 0002038123146
	public function createSep(){
		// echo $_GET['url'];
		// exit(json_encode([$_GET['url']] ));	
		$input = $this->input->post(NULL, TRUE);

		// $peserta = $this->r_peserta($input["noka"]);

		$this->load->library(['My_lzstring']);
		// $decBase64 = $this->my_lzstring->decompressFromBase64($input['wsbpjs']);
		// $ws = json_decode($decBase64,1);

		$wsfull = json_decode($this->my_lzstring->decompressFromBase64($input['wsfullEnc']),1);
		// exit(json_encode( [$input, $ws] ));
		// exit(json_encode( ["mRjk_selected" => $ws] ));

		$mRjk = $wsfull['mRjk_selected'];

		// filter KLL -----------------
		$KLL = ($input['lakaLantas']=='1' || $input['lakaLantas']=='2')? true: false;
		
		
		
		// filter BPJS -----------------
		$katarak = (isset($input['chk_katarak']))? 1:0; 
		
		if($input['klinik']!='IGD')
			if($input["noRujukan"]=='') exit(json_encode( $this->errorMetaData(201, "No.Rujukan kosong.", "failed") ));
		
		if($input["telp_bpjs"]=='') exit(json_encode( $this->errorMetaData(201, "No.Telepon kosong.", "failed") ));
		if(!preg_match('/^[0-9]*$/',$input["telp_bpjs"])) exit(json_encode( $this->errorMetaData(201, "Format No.Telepon tidak sesuai. Harus angka.", "failed") ));
		if($input["dx"]=='') exit(json_encode($this->errorMetaData(201, "Diagnosa kosong. Harus diisi.", "failed") ));
		if($input["norm_bpjs"]=='') exit(json_encode($this->errorMetaData(201, "No.RM kosong. Harus diisi.", "failed") ));

		// 6.1. Validasi Tgl SEP > dari tanggal sekarang
		if($input["tglSep"]>date('Y-m-d')) exit(json_encode( $this->errorMetaData(201, "Tgl SEP lebih dari tanggal sekarang.", "failed") ));
		
		// 6.2. Validasi Tgl SEP < tanggal TMT
		if($input["tglSep"] < $mRjk["peserta"]["tglTMT"]) exit(json_encode( $this->errorMetaData(201, "Tgl SEP kurang dari tanggal TMT(".$mRjk["peserta"]["tglTMT"].").", "failed") ));

		// 6.3. Validasi Tanggal Rujukan Lebih dari tanggal SEP
		if($input["tglRujukan"] > $input["tglSep"]) exit(json_encode( $this->errorMetaData(201, "Tanggal Rujukan(".$input["tglRujukan"].") Lebih dari tanggal SEP.", "failed") ));


		// // VALIDASI FINGERPRINT
		// $validasi_fp = $this->r_fingerprint_check($input["noka"], $input["klinik"]);
			

		
		$noTelp = ($mRjk["peserta"]["mr"]["noTelepon"]==null)? '0123456789' : $mRjk["peserta"]["mr"]["noTelepon"];
		//======   ws2   ============
		$sep_create =
		[
			"request"=> [
				"t_sep"=> [
					"noKartu" => $input["noka"],// $get_noka,
					"tglSep" => $input["tglSep"], // date('Y-m-d'), 
					"ppkPelayanan" => "0195R028",
					"jnsPelayanan" => $input["jnsPelayanan"], // $get_jnsPelayanan,
					"klsRawat" => [
						"klsRawatHak"	=> $mRjk["peserta"]["hakKelas"]["kode"],
						"klsRawatNaik"=> "",
						"pembiayaan"	=> "",
						"penanggungJawab"	=> ""
					],
					"noMR" => $input["norm_bpjs"], //  $ws["peserta"]["mr"]["noMR"], 
					"rujukan"=> [
						"asalRujukan"=> $input["asalRujukan"], // $get_asalRujukan_bpjs, //"1",
						"tglRujukan" => $input["tglRujukan"], // $get_tglKunjungan,
						"noRujukan"  => $input["noRujukan"], // $get_norujukan,
						"ppkRujukan" => $input["asalPpkKode"], // $get_ppkRujukan
					],
					"catatan" => $input["catatan_bpjs"],
					"diagAwal" => $input["dx"], // $('select[name=sel_diag_bpjs]').val(),
					"poli" => [
						"tujuan" => $input["klinik"], // $get_poliKode_bpjs,
						"eksekutif" => "0",
					],
					"cob" => [
						"cob" => "0"
					],
					"katarak" => [
						"katarak" => $katarak,
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
					"tujuanKunj"	=> "0",
					"flagProcedure"	=> "",
					"kdPenunjang"	=> "",
					"assesmentPel"=> "",
					"skdp"=> [
						"noSurat" => $input["skdp"], // $input["noskdp_bpjs"],
						"kodeDPJP"=> $input["dpjpLayanKode_bpjs"], // $input["dpjpKode_bpjs"],
					],
					"dpjpLayan" => $input["dpjpLayanKode_bpjs"],
					"noTelp"=> $noTelp,
					"user"=> $this->vclaimUser,
					// "user"=> $this->config_bpjs["consid"],
				]
			]
		];
		//======   \ws2   ============
		

		$path = "SEP/2.0/insert"; //WS2.0
		$json_request = json_encode( $sep_create );
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'POST', $path, $json_request); // arr
		// $res = $this->ws_bpjs_2->ws_arr('vclaimdev', 'POST', $path, $sep_create); // arr
		// exit(json_encode($res ));

		$timeCreateSep = ($res['metaData']['code']==200)? date('H:i:s') : null;

		$val = [
			"input" => $input,
			"wsfull" => $wsfull,
			"sep_req" => $sep_create,
			"sep_res" => $res,
			"timeCreateSep" => $timeCreateSep,
		];
		exit(json_encode( metaData(200, 'OK', "success", $val) ));

		// $path = "SEP/1.1/insert"; //WS1.1
		// $json_request = json_encode( $this->input->post(NULL,TRUE) );
		// return json_encode( $this->ws_bpjs_11->ws("vclaim", "POST", $path, $json_request ) );
	}


	public function updateSep(){
		$input = $this->input->post(NULL, TRUE);
		$katarak = (isset($input['chk_katarak']))? 1:0;
		if($input["telp_bpjs"]=='') exit(json_encode( $this->errorMetaData(201, "No.Telepon kosong.", "failed") ));
		if(!preg_match('/^[0-9]*$/',$input["telp_bpjs"])) exit(json_encode( $this->errorMetaData(201, "Format No.Telepon tidak sesuai. Harus angka.", "failed") ));
		
		if($input["dx"]=='') exit(json_encode($this->errorMetaData(201, "Diagnosa kosong. Harus diisi.", "failed") ));
		if($input["norm_bpjs"]=='') exit(json_encode($this->errorMetaData(201, "No.RM kosong. Harus diisi.", "failed") ));
		// exit(json_encode(['dx'=>$input["dx"] ]));

		$send = [
			"request"	=> [
				 "t_sep"	=> [
						"noSep"	=> $input['nosep'],
						"klsRawat"	=>[
							"klsRawatHak"	=> "3",
							"klsRawatNaik"=> "",
							"pembiayaan"	=> "",
							"penanggungJawab"	=>"",
						],
						"noMR"		=>  $input["norm_bpjs"],
						"catatan"	=> $input["catatan_bpjs"],
						"diagAwal"=> $input["dx"],
						"poli"	=> [
							"tujuan"	=> $input["klinik"],
							"eksekutif"	=> "0"
						],
						"cob"	=> [
							"cob"	=> "0",
						],
						"katarak"=> [
							"katarak"=> $katarak,
						],
						"jaminan"=> [
							"lakaLantas" 	=> "0",
							"penjamin"=> [
								"tglKejadian"=> "",
								"keterangan" => "",
								"suplesi" 	=> [
									"suplesi"	=> "0",
									"noSepSuplesi"=> "",
									"lokasiLaka"=> [
										"kdPropinsi" => "",
										"kdKabupaten"=> "",
										"kdKecamatan"=> ""
									],
								],
							],
						],
						"dpjpLayan" => $input["dpjpLayanKode_bpjs"],
						"noTelp" 		=> $input["telp_bpjs"],
						"user" 			=> $this->vclaimUser,
					],
				],
			];


	}

	public function r_deleteSep($nosep){
		$send = [
			"request"=> [
				"t_sep"=> [
					"noSep"=> $nosep,
					"user"=> $this->vclaimUser,
				]
			]
		];
		$path = 'SEP/2.0/delete';
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'DELETE', $path, json_encode($send) ); // arr
		return $res;
	}
	
	public function deleteSep($nosep){
		exit(json_encode( $this->r_deleteSep($nosep) ));
	}

	public function r_Rujukan($noRujukan=null){
    $path = 'Rujukan/'.$noRujukan;
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		return $res;
	}

	public function Rujukan($noRujukan=null){
		exit(json_encode( $this->r_Rujukan($noRujukan) ));
	}
	
	

	// ---- [SURAT KONTROL] ----
	function check_date_format($date=null){
		// $date="2012-09-12";

		// correct format('yyyy-mm-dd')
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
			return true;
			// echo 123;
		} else {
			return false;
				// echo 000;
		}
	}


	public function validasi_rujukan_habis($tglRujukan=null, $tgl=null){ 
		// $tgl = hari ini / besok / date
		$tgl = ($tgl==null)? date('Y-m-d'): $tgl;

		$tglRujukanPlus90 = selisih_hari($tglRujukan, "+90");

		$logic = ($tgl > $tglRujukanPlus90)? true: false;
		if($logic) exit(json_encode( $this->errorMetaData(201, 'Rujukan HABIS. Tgl.Rujukan lebih dari 90 hari. Tidak bisa diproses.', "failed") ));
		return false;
	}

	public function validasi_tglKontrol_krgSama_tglSep($tglKontrol=null, $tglSep=null){
		$logic = ($tglKontrol <= $tglSep)? true: false;
		if($logic) exit(json_encode( $this->errorMetaData(201, 'Tgl.Kontrol <= Tgl.SEP sebelumnya. Tidak bisa diproses.', "failed") ));
		return false;
	}
	
	public function validasi_tglKontrol_lbh90h_tglRujukan($tglKontrol=null, $tglRujukan=null){
		// selisih_hari(date("Y-m-d"), "-100")
		$tglRujukanPlus90 = selisih_hari($tglRujukan, "+90");

		$logic = ($tglKontrol > $tglRujukanPlus90)? true: false;
		// $message = ($tglKontrol > $tglRujukanPlus90)? 'Tgl.Kontrol > 90 hari Tgl.Rujukan. Tidak bisa diproses.': 'OK.';
		if($logic) exit(json_encode( $this->errorMetaData(201, 'Tgl.Kontrol > 90 hari Tgl.Rujukan. Tidak bisa diproses.', "failed") ));
		return false;
	}

	public function insertRencanaKontrol(){
		$input = $this->input->post(NULL, TRUE);

		// $input["noSEPKontrol"] ='0195R0281221V000001'; // ''; // '0195R0281221V000101'; //


		// filter SEP 
		if($input["noSEPKontrol"] == '') exit(json_encode( $this->errorMetaData(201, 'Kolom SEP kosong.', "failed") ));
		
		$r_SEP = $this->r_SEP($input["noSEPKontrol"]);
		if($r_SEP['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_SEP['metaData']['code'].']'.$r_SEP['metaData']['message'], "failed") ));
		
		// get data bridging RUJUKAN 
		// ambil dari pencarian noRujukan. dapatkan tglKunjungan.
		$r_Rujukan = $this->r_Rujukan($input["noRujukanKontrol"]);
		if($r_Rujukan['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_Rujukan['metaData']['code'].']'.$r_Rujukan['metaData']['message'], "failed") ));
		$tglRujukan = $r_Rujukan['response']['rujukan']['tglKunjungan'];

		// 20.1.2. Validasi nomor rujukan FKTP sudah habis masa berlakunya
		$validasi_rujukan_habis = $this->validasi_rujukan_habis($tglRujukan);

		// check date format: yyyy-mm-dd
		if(!$this->check_date_format($input["tglRencanaKontrol"])) exit(json_encode( $this->errorMetaData(201, 'Format tanggal Rencana Kontrol tidak sesuai. Harus : yyyy-mm-dd.', "failed") ));
		
		// check kode dokter
		if($input["kodeDokterKontrol"]== '') exit(json_encode( $this->errorMetaData(201, 'Kode dokter kosong.', "failed") ));
		
		// check kode poli tidak sama (20.1.4, 20.1.5). dari Monitoring Histori dg yg dipilih.
		$poliRjk_kode = $r_Rujukan['response']['rujukan']['poliRujukan']['kode'];
		if($input["poliKontrol"]!= $poliRjk_kode) exit(json_encode( $this->errorMetaData(201, 'Poli kontrol('.$input["poliKontrol"].') tidak sesuai dengan poli rujukan('.$poliRjk_kode.').', "failed") ));
		
		// Validasi tglRencanaKontrol <= tanggal pelayanan noSEP . --> MUNCUL peringatan.
		$tglSep = $r_SEP['response']['tglSep'];
		// $input["tglRencanaKontrol"]
		$validasi_tglKontrol_krgSama_tglSep = $this->validasi_tglKontrol_krgSama_tglSep($input["tglRencanaKontrol"], $tglSep);

		// (20.1.8) Validasi tglRencanaKontrol > 90 hari tanggal surat rujukan FKTP.
		$validasi_tglKontrol_lbh90h_tglRujukan = $this->validasi_tglKontrol_lbh90h_tglRujukan($input["tglRencanaKontrol"], $tglRujukan);

		// exit;

		// if($input["noSEPKontrol"]=='') 

		$send = [
			"request"	=> [
					"noSEP"	=> $input["noSEPKontrol"],
					"kodeDokter"	=> $input["kodeDokterKontrol"],
					"poliKontrol"	=> $input["poliKontrol"],
					"tglRencanaKontrol"	=> $input["tglRencanaKontrol"],
					"user"	=> $this->vclaimUser,
			],
		];
		// exit(json_encode($send ));
		
		$path = "RencanaKontrol/insert"; //WS2.0
		$json_request = json_encode( $send );
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'POST', $path, $json_request); // arr
		exit(json_encode($res ));
	}
	

	public function r_cariSuratKontrol($noSuratKontrol=null){
    $path = 'RencanaKontrol/noSuratKontrol/'.$noSuratKontrol;    
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'GET', $path, ''); // arr
		return $res;
	}

	public function cariSuratKontrol($noSuratKontrol=null){
		exit(json_encode( $this->r_cariSuratKontrol($noSuratKontrol) ));
	}
	
	public function updateRencanaKontrol(){
		$input = $this->input->post(NULL, TRUE);
		// exit(json_encode($input));

		// Validasi noSuratKontrol tidak ditemukan atau kosong
		$r_cariSuratKontrol = $this->r_cariSuratKontrol($input["noSuratKontrolRes"]);
		if($r_cariSuratKontrol['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_cariSuratKontrol['metaData']['code'].']'.$r_cariSuratKontrol['metaData']['message'], "failed") ));

		// Validasi noSEP tidak ditemukan
		// Validasi noSEP tidak 20 digit
		if($input["noSEPKontrol"] == '') exit(json_encode( $this->errorMetaData(201, 'Kolom SEP kosong.', "failed") ));
		
		$r_SEP = $this->r_SEP($input["noSEPKontrol"]);
		if($r_SEP['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_SEP['metaData']['code'].']'.$r_SEP['metaData']['message'], "failed") ));
		

		// Validasi nomor rujukan FKTP sudah habis masa berlakunya
		$r_Rujukan = $this->r_Rujukan($input["noRujukanKontrol"]);
		if($r_Rujukan['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_Rujukan['metaData']['code'].']'.$r_Rujukan['metaData']['message'], "failed") ));
		$tglRujukan = $r_Rujukan['response']['rujukan']['tglKunjungan'];
		
		$validasi_rujukan_habis = $this->validasi_rujukan_habis($tglRujukan);


		// Validasi kodeDokter tidak ditemukan
		if($input["kodeDokterKontrol"]== '') exit(json_encode( $this->errorMetaData(201, 'Kode dokter kosong.', "failed") ));
		
		// Validasi kodeDokter tidak sesuai poli rujukan FKTP

		// Validasi kode poli (poliKontrol) tidak sesuai poli rujukan FKTP
		$poliRjk_kode = $r_Rujukan['response']['rujukan']['poliRujukan']['kode'];
		if($input["poliKontrol"]!= $poliRjk_kode) exit(json_encode( $this->errorMetaData(201, 'Poli kontrol('.$input["poliKontrol"].') tidak sesuai dengan poli rujukan('.$poliRjk_kode.').', "failed") ));
		
		// Validasi tglRencanaKontrol tidak sesuai format (yyyy-mm-dd)
		if(!$this->check_date_format($input["tglRencanaKontrol"])) exit(json_encode( $this->errorMetaData(201, 'Format tanggal Rencana Kontrol tidak sesuai. Harus : yyyy-mm-dd.', "failed") ));
		
		// Validasi tglRencanaKontrol <= tanggal pelayanan noSEP
		$tglSep = $r_SEP['response']['tglSep'];
		$validasi_tglKontrol_krgSama_tglSep = $this->validasi_tglKontrol_krgSama_tglSep($input["tglRencanaKontrol"], $tglSep);

		// Validasi tglRencanaKontrol > 90 hari tanggal surat rujukan FKTP
		$validasi_tglKontrol_lbh90h_tglRujukan = $this->validasi_tglKontrol_lbh90h_tglRujukan($input["tglRencanaKontrol"], $tglRujukan);

		// Validasi dokter tidak ada jadwal pada hari itu (selain poli awal HDL dan IRM)

		$send = [
			"request"	=> [
					"noSuratKontrol"	=> $input["noSuratKontrolRes"],
					"noSEP"	=> $input["noSEPKontrol"],
					"kodeDokter"	=> $input["kodeDokterKontrol"],
					"poliKontrol"	=> $input["poliKontrol"],
					"tglRencanaKontrol"	=> $input["tglRencanaKontrol"],
					"user"	=> $this->vclaimUser,
			],
		];
		exit(json_encode($send ));
		
		$path = "RencanaKontrol/Update"; //WS2.0
		$json_request = json_encode( $send );
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'PUT', $path, $json_request); // arr
		exit(json_encode($res ));
	}

	public function hapusRencanaKontrol(){
		$input = $this->input->post(NULL, TRUE);

		// Validasi noSuratKontrol tidak ditemukan atau kosong
		$r_cariSuratKontrol = $this->r_cariSuratKontrol($input["noSuratKontrolRes"]);
		if($r_cariSuratKontrol['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_cariSuratKontrol['metaData']['code'].']'.$r_cariSuratKontrol['metaData']['message'], "failed") ));

	}

	// ----\[SURAT KONTROL] ----
	
	
	public function pengajuanSep($type=null){ // PENGAJUAN, APROVAL
		$input = $this->input->post(NULL, TRUE);
		$send = [
			"request"	=> [
				"t_sep"	=> [
					 "noKartu"	=> $input['noKartu'],
					 "tglSep"	=> $input['tglSep'],
					 "jnsPelayanan"	=> $input['jnsPelayanan'],
					 "jnsPengajuan"	=> $input['jnsPengajuan'],
					 "keterangan"	=> $input['keterangan'],
					 "user"	=> $this->vclaimUser,
				],
			],
		];

		if($type=='PENGAJUAN') $path = "Sep/pengajuanSEP";
		else if($type=='APROVAL') $path = "Sep/aprovalSEP";

		// exit(json_encode([$type, $path, $send ]));

		$json_request = json_encode( $send );
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'POST', $path, $json_request);
		exit(json_encode($res ));		
	}
	
	
	public function updateTglPulang(){ // pengajuan,aproval
		$input = $this->input->post(NULL, TRUE);

		// 11.2 Validasi Update Tanggal Lebih Dari Tanggal Hari Ini
		if($input['tglPulang']>date('Y-m-d')) exit(json_encode( $this->errorMetaData(201, 'Tanggal Pulang Lebih Dari Tanggal Hari Ini.', "failed") ));

		// 11.3 Validasi Update Tanggal Lebih Kecil Dari Tanggal SEP
		if($input['tglPulang']<$input['tglSep']) exit(json_encode( $this->errorMetaData(201, 'Tanggal Pulang('.$input['tglPulang'].') Lebih Kecil Dari Tanggal SEP('.$input['tglSep'].').', "failed") ));

		// 11.4 Validasi Update Tanggal Pulang Status Verifikasi Disetujui

		// 11.5 Validasi Update Tanggal Pulang Status Verifikasi Tidak Layak Klaim

		// 11.6 Update Tanggal Pulang Status Verifikasi Pending

		// 11.7 Validasi Update Tanggal Pulang Status Verifikasi Layak Klaim
		// 11.8 Update Tanggal Pulang Status Purifikasi
		// 11.9 Validasi Update Tanggal Pulang Status Sudah Dirujuk
		
		// 11.10 Cara pulang meninggal wajib mengisikan nomor surat meninggal minimal 5 karakter
		
		if($input['statusPulang'] =='4' && strlen($input['noSuratMeninggal'])<5)
			exit(json_encode( $this->errorMetaData(201, 'Nomor surat meninggal harus diisi. Minimal 5 karakter.', "failed") ));
		
		// 11.11 SEP KLL perlu mengisikan nomor laporan polisi minimal 5 karakter
		if( ($input['kdStatusKecelakaan'] =='1'||$input['kdStatusKecelakaan'] =='2') 
			&& strlen($input['kdStatusKecelakaan'])<5) 
				exit(json_encode( $this->errorMetaData(201, 'SEP KLL perlu mengisikan nomor laporan polisi minimal 5 karakter. Kode status KLL:('.$input['kdStatusKecelakaan'].')', "failed") ));
		

		$send = [
			"request"	=> [
				"t_sep"	=> [
					 "noSep"	=> $input['noSep'],
					 "statusPulang"	=> $input['statusPulang'],
					 "noSuratMeninggal"	=> $input['noSuratMeninggal'],
					 "tglMeninggal"	=> $input['tglMeninggal'],
					 "tglPulang"	=> $input['tglPulang'],
					 "noLPManual"	=> $input['noLPManual'],
					 "user"				=> $this->vclaimUser,
				],
			],
		];

		$path = "SEP/2.0/updtglplg";

		exit(json_encode([$path, $send ]));

		$json_request = json_encode( $send );
		$res = $this->ws_bpjs_2->ws_arr($this->vclaimVersion, 'PUT', $path, $json_request);
		exit(json_encode($res ));		
	}
	
	



	// ======================== CREATE BILLING ==========================

	public function s_pxrs($noka){
		exit(json_encode( $this->r_pxrs($noka) ));
	}

	public function r_pxrs($noka){
		$this->load->model("m_daftarmandiri");
		$errors = [];
		$btn_lewati = 0;
		$postmrs_from_rscm = 1;
		// CEK:: PERNAH CETAK KARTU RS
		$pxrs = $this->m_daftarmandiri->get_pxrs($noka);
		// exit(json_encode( $pxrs ));

		$flagkartu = false; // DECLARE
		$px_bpjs["response"]["peserta"]["nik"]= '';


		if(count($pxrs) == 0 ){ // DATA PX HANYA ADA DARI BRIDGING. DI RS NDAK ADA. TIDAK BOLEH DIDAFTARKAN 
			
			// NOKA BELUM DI ISIKAN DI NORM nya. ATAU PASIEN BARU yg belum punya NORM
			$message = "Nomor Kartu JKN KIS belum terdaftar di sistem RS.";
			array_push($errors, error("cetak_kartu", "danger", "", $message) );	
			exit(json_encode( metaData(201, $message, "failed") ));		
		}else if(count($pxrs)==1){ // NOKA PASIEN ADA DI RS
			$pxrs = $pxrs[0];

			$flagkartu = ( (int)($pxrs["flagkartu"]) == '1')? true:false;
			if( !$flagkartu ){ // BELUM CETAK KARTU
				array_push($errors, error("cetak_kartu", "danger", "", "Pasien belum pernah cetak kartu berobat rumah sakit.") );

				// MEMBATASI MENGHILANGKAN TOMBOL LEWATI SAAT PX POSTMRS selain dari RSCM
				if($postmrs_from_rscm == 1) $btn_lewati = 1;				

			}else{	}

			// CEK STATUS BILL = OPEN/CLOSE
			$st_bill = $this->m_daftarmandiri->get_st_bill_open_rm_by_norm_n($pxrs["NoRM"]);
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
						$where = ["NoRM" => $pxrs["NoRM"] ];
						$value = ["NoIdentitas" => $px_bpjs["response"]["peserta"]["nik"]];
						$update_nik = $this->m_daftarmandiri->update_new("fomstpasien", $value, $where);
					}
				}
				
			}
		}else{ // NOKA PASIEN ADA DI RS (GANDA). ADA DOUBLE RM. TIDAK BOLEH DAFTAR
			$message = "Nomor Kartu JKN KIS kembar dengan pasien lain.";
			array_push($errors, error("cetak_kartu", "danger", "", $message) );
			exit(json_encode( metaData(201, $message, "failed") ));	
		}

		// -- cek PDP
		// $pdp = ($pxrs[0]['PDP'] == '1' && intval($pxrs[0]['PDPSelisihHari']) < 15) ? "Z038" : "";

		if( $pxrs['PDP'] == '1' && intval($pxrs['PDPSelisihHari']) < 15 )
			array_push($errors, error("pdp", "danger", "", "Pasien PDP pada tanggal ".$pxrs['PDPDate'].". (Berjalan ".$pxrs['PDPSelisihHari']." hari)") );
		

		$val = [
			"pxrs" => $pxrs,
			"errors" => $errors,
		];
		// return $val;
		return metaData(201, "OK", "success", $val);
	}



	public function r_gd_instansi_cm($kode_bpjs=null, $nama=null){
		if($kode_bpjs==null) exit;		
		$this->load->model("m_daftarmandiri");
		$cek_instansi = $this->m_daftarmandiri->cek_kd_instansi_cm($kode_bpjs);

		if($cek_instansi['count'] == 0 ){ //bila instansi tidak ketemu, INSERT
			$this->m_daftarmandiri->insert_kd_instansi_cm( [ "Keterangan"=>$nama, "kd_bpjs"=>$kode_bpjs ] );
		}

		$gd_instansi_cm = $this->m_daftarmandiri->gd_instansi_cm( $kode_bpjs );
		// return $gd_instansi_cm['datajs'][0];
		if(count($gd_instansi_cm['datajs'])<1) exit(json_encode( $this->errorMetaData(201, 'List instansi di RS kosong.', "failed") ));
		else 
			// exit(json_encode($gd_instansi_cm['datajs'][0]));
			return $gd_instansi_cm['datajs'][0];
	}

	public function gd_instansi_cm($kode_bpjs=null, $nama=null){
		exit(json_encode($this->r_gd_instansi_cm($kode_bpjs, $nama) ));
	}
	
	public function gd_instansi_cm_dump($kode_bpjs=null, $nama=null){
		// echo var_dump($this->r_gd_instansi_cm($kode_bpjs, $nama) );
		echo "<pre>",print_r( var_dump([ [$kode_bpjs, $nama], $this->r_gd_instansi_cm($kode_bpjs, $nama) ] ) ),"</pre>";
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
		// echo json_encode($res); // INI UNCOMMENT

		
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
			return $res;
	}
	// \INSERT TINDAKAN BILLING


	// KLIK DAFTAR
	// IGD: dr.lucky = 285581
	// SP = dr.ihwan = 16588
	public function daftar_pasien_klik_bpjs(){ // $kode_lokasi = 27
		$this->load->model(["m_daftarmandiri", "m_pendaftaran"]);
		$input = $this->input->post(NULL, TRUE);

		$this->load->library(['My_lzstring']);
		$ins_tx_auto = null;

		$wsRes_createSep = json_decode($this->my_lzstring->decompressFromBase64($input['wsResEnc_createSep']),1); //!!!???

		$res_sep = $wsRes_createSep['response']['sep_res']['response']['sep'];

		$wsfull = json_decode($this->my_lzstring->decompressFromBase64($input['wsfullEnc']),1);
		// exit(json_encode( [$input, $wsRes_createSep, $wsfull] ));

		// die(isset($input['dpjpLayanKode_bpjs']));
		if(!isset($input['dpjpLayanKode_bpjs'])) exit(json_encode( metaData(201, 'Parameter kosong.', "failed") ));
		$db_dokter_rs = $this->m_pendaftaran->dokter_by_kodebpjs($input['dpjpLayanKode_bpjs']);
		// exit(json_encode($db_dokter_rs ));

		// if($db_dokter_rs['metaData']['code']!= '200') exit(json_encode( metaData(201, 'Kode dokter tidak sesuaiBbpjs/RS).', "failed") ));
		// else $db_dokter_rs = $db_dokter_rs['response'];
		// if($res['metaData']['code']!= '200') exit(json_encode( $this->errorMetaData(201, '['.$r_SEP['metaData']['code'].']'.$r_SEP['metaData']['message'], "failed") ));
		// else $res = $res['response']['list'];

		$dataPost = [
			"rs" => [
				"klinik" => [
					"kode" => $db_dokter_rs['kodeLokasiRs'],
				],
				"dokter" => [
					"kode_dok" => $db_dokter_rs['kodeDokterRs'],
				],
				"rujukan" => $input['noRujukan'],
				"get_tglRujukan" => $input['tglRujukan'],

			],
			"tc" => [
				"klik_daftar" => date('H:i:s'),
				"sep" => $wsRes_createSep['response']['timeCreateSep'],
			],
		];
		$input["dataPost"] = $dataPost;

		// exit(json_encode($db_dokter_rs ));
		
		// MENERIMA FULL ARRAY dari POST PENDAFTARAN
		$kode_lokasi = $input["dataPost"]["rs"]["klinik"]["kode"];
		$gen = $this->m_daftarmandiri->generate_bill_antri_skdp($kode_lokasi);
		// exit(json_encode($gen ));	

		
		$_FL_daftar_ugd = $db_dokter_rs['labelLokasiRs'] == 'I G D'? true: false;
		// exit(json_encode( [$db_dokter_rs, $dataPost, $gen, $_FL_daftar_ugd ]));

			  // $_FL_daftar_ugd = 0; // SAAT PILIHAN LOKASI DIKLIK IGD, BARU GANTI JADI $_FL_daftar_ugd=1
				// INI DIPAKAI , $_FL_daftar_ugd = $input["dataPost"]["flag"]["_FL_daftar_ugd"]; // SAAT PILIHAN LOKASI DIKLIK IGD, BARU GANTI JADI $_FL_daftar_ugd=1
			//========

			  if(!$_FL_daftar_ugd){ //JIKA BUKAN PASIEN UGD >> dapat antrian poli, cetak.
          $StatusDaftar_cm = 'RJ';
					$tbl_daftar_plh = 'rj';
					$pelayanan = 'RJ';
    
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
					$pelayanan = 'IGD';
    
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


				//PAKAI $norm_rs = $input["dataPost"]["rs"]["mp"]["NoRM"];
				$norm_rs = $input["norm_bpjs"]; // ?????
				// $px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm( $norm_rs )[0]["status_px"];
				$px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $norm_rs )["status_px"];
				// exit(json_encode( [$db_dokter_rs, $dataPost, $gen, $_FL_daftar_ugd, $norm_rs, $px_baru_lama ]));
				
				// ==>>>>>>>>> SAMPAI SINI
				// cek_px_masuk.ws_rs.get_pxrs
				// $pxrs = $this->m_daftarmandiri->get_pxrs($noka);
				$pxrs = $this->m_daftarmandiri->get_pxrs_by_norm($norm_rs);
				if(count($pxrs)<1) exit(json_encode( metaData(201, 'Pasien tidak ditemukan.', "failed") ));
				else $pxrs = $pxrs[0];
				// exit(json_encode( [$db_dokter_rs, $dataPost, $gen, $_FL_daftar_ugd, $norm_rs, $px_baru_lama, $pxrs ]));


				// let get_umur_fv = get_umur_fx_new(px_rs_plh.TglLahir);
				$umur_det = get_age_detail($pxrs['TglLahir']);

				$penanggung = [
					"status" => "M",
					"kode" => "CO031",
					"NoAnggota" => "BPJS",
				];
				$input["dataPost"]["rs"]["penanggung"] = $penanggung;

				$input["dataPost"]["rs"]["dx_rs"] = '10';
				$input["dataPost"]["rs"]["ket_daftar"] = '';
				$input["dataPost"]["rs"]["caramasuk"] = '1'; //Datang Sendiri
				$input["dataPost"]["rs"]["asalPPK"] = ''; //get_ppkRujukan+'_'+get_ppkRujukan_nama,

								
				// $decBase64 = $this->my_lzstring->decompressFromBase64($input['wsbpjs']);
				// $px_bpjs = json_decode($this->my_lzstring->decompressFromBase64($input['wsfullEnc']),1); //!!!???
				$px_bpjs = $wsfull['px'];
				$gd_instansi_cm = $this->r_gd_instansi_cm($px_bpjs["jenisPeserta"]["kode"], $px_bpjs["jenisPeserta"]["keterangan"]);
				
				$input["dataPost"]["rs"]["asalinstansi"] = $gd_instansi_cm['kode'];// get_instansi_kode_cm, m_daftarmandiri->insert_kd_instansi_cm, fotrasalpasien
				$input["dataPost"]["rs"]["nosep"] = $input['nosep_inhide']; //!!!???
				$input["dataPost"]["rs"]["mp"] = $pxrs;
				

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
					"StatusDaftar" 		=> $StatusDaftar_cm, // $input["dataPost"]["rs"]["StatusDaftar_cm"], ////////StatusDaftar_cm,
					"Nama" 		=> $pxrs["Nama"],// $input["dataPost"]["rs"]["mp"]["Nama"],
					"Alamat" 	=> $pxrs["Alamat"],
					"Telp" 		=> $pxrs["Telp"],
					"HP" 			=> $pxrs["HP"],
					"RT" 			=> $pxrs["Rt"],
					"RW" 			=> $pxrs["Rw"],
					"Kelurahan" => $pxrs["Kelurahan"],
					"Kecamatan" => $pxrs["Kecamatan"],
					"Kota" 			=> $pxrs["Kota"],
					"Propinsi"	=> $pxrs["Propinsi"],
					"Negara" 		=> $pxrs["Negara"],
					"Agama" 		=> $pxrs["Agama"],
					"Pendidikan"=> $pxrs["Pendidikan"],
					"Pekerjaan" => $pxrs["Pekerjaan"],

					"Sex" 			=> $pxrs["Sex"], //$('span[name=pasienRscm_jk]').text(),
					"Marital" 	=> $pxrs["Marital"],
					"UmurTahun" => $umur_det['y'], // $input["dataPost"]["rs"]["UmurTahun"], //get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun'), //mstpasien->tgl Lahir TglLahir
					"UmurBulan" => $umur_det['m'], // $input["dataPost"]["rs"]["UmurBulan"], //get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'bulan'), //mstpasien->tgl Lahir
					"UmurHari" 	=> $umur_det['d'], // $input["dataPost"]["rs"]["UmurHari"], //get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'hari'), //mstpasien->tgl Lahir
					"KategoriUsia" => kategori_usia($umur_det['y']), // $input["dataPost"]["rs"]["KategoriUsia"], //kategori_usia( get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun') ),//mstpasien->tgl Lahir

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
					"billname"      => $pxrs["Nama"],
					"billket"       => "Bill From RJ", //RJ/UG. yg UG hanya 1 record di db
					"billpenanggung"=> $input["dataPost"]["rs"]["penanggung"]["kode"], // "CO031",
					"user" => $this->session->userdata("username"),
					"date" => date('Y-m-d'),
					"time" => date('H:i:s'),
				];
				

				// untuk insert ke >> insert_daftar_rj_n()				
				$flag = [
					"_FL_daftar_ugd"    => $_FL_daftar_ugd,
					"_FL_ambil_px_book" => $input['FL_ambil_px_book'],
					"date" => $input['book_date'],
					"time" => $input['book_time'],
				];
				$input["dataPost"]["flag"] = $flag;

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

				exit(json_encode( [ 
					[$input, $wsRes_createSep, $wsfull],
					[$db_dokter_rs, $dataPost, $gen, $_FL_daftar_ugd ], 
					[$norm_rs, $px_baru_lama, $pxrs, $fotrdaftar, $fotrbillingshare], 
					$jpost_insert_reg_cm ] ));

				// $this->m_daftarmandiri->insert_daftar_rj( $flag, $data, $data1, $data2);
				// $insert_gen = $this->m_daftarmandiri->insert_daftar_rj( $flag, $fotrdaftar, $fotrdaftar_pilih, $fotrbillingshare);
				$insert_gen = $this->m_daftarmandiri->insert_daftar_rj_n($tbl_daftar_plh, $flag, $fotrdaftar, $fotrdaftar_pilih, $fotrbillingshare);
				
				$status_execute = $insert_gen["status"];
				$bill_response 	= $gen["bill"]["full"];

				// CEK BILL yg BARENG di klik itu DOBEL/tidak. BILLING KOSONG, SEP JADI <<???
				// BILA INSERT BILLING BARU >> FAILED
				if($status_execute == "failed")
					exit(json_encode( metaData(201, 'Pendaftaran GAGAL. Segera hapus SEP '.$input['nosep_inhide'], "failed") ));
				else if($status_execute == "success"){
					if($bill_response == '' || $bill_response == null)
						exit(json_encode( metaData(201, 'Nomor Billing kosong. Segera hapus SEP '.$input['nosep_inhide'].'. Ulangi proses pendaftaran.', "failed") ));
					else{ // JIKA CREATE BILLING SUKSES
						// AUTO ENTRY TINDAKAN BILLING. KHUSUS PX BPJS
						// !!! SUDAH DI JS, HARUSNYA DIPINDAH KE SINI. SEBABNYA DI JS: KODING MEPET& di ajaxreq/insert_pos_tindakan PUUANJANG scriptnya
						
						if($fotrdaftar["PerusahaanPenanggung"] == 'CO031'){
							// // SP_129 = dr. Prima // dokter yg tanpa auto entry tindakan
							$FL_insert_tindakan = ( $db_dokter_rs['kodeDokterRs'] == 'SP_129')? false : true;
							if($FL_insert_tindakan){
								// $ins_tx_auto_str = 'insert_pos_tindakan/'.$pelayanan.'/'.$kode_lokasi.'/'.$bill_response.'/'.$db_dokter_rs['kodeDokterRs'];
								$ins_tx_auto = $this->insert_pos_tindakan($pelayanan, $kode_lokasi, $bill_response, $db_dokter_rs['kodeDokterRs']);
							}
						}else if($fotrdaftar["PerusahaanPenanggung"] == 'CO051'){
							// IF penanggung KEMENKES(CO051), update masterpx
							$this->load->model("m_main");
							$upd = $this->m_main->update('fomstpasien',["PDP"=> 1, "PDPDate"=>date('Y-m-d')], ["NoRM"=>$norm_rs]);
						}

					}
				}
				// echo json_encode($jpost_insert_reg_cm);
				// exit;
				
				//+++++++++++++++++++ insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++
				
				
				$input["dataPost"]["bpjs"]["sep"]["response"] = $res_sep;

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

				// // $insert_gen = null; // SEMENTARA !!!
				$res = [
					"request" => $jpost_insert_reg_cm,
					"response" => [
						"insert_gen" => $insert_gen,
						"xrec" => $xrec,
						"ins_tx_auto" => $ins_tx_auto,
					],
				];
				// echo json_encode($res);
				// exit;

				exit(json_encode( metaData(200, 'OK', "success", $res ) ));
		

	}
	// ========================\CREATE BILLING ==========================
	

}