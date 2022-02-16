<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_termal extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		// $this->mainlib->logged_in();
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		$this->load->library('mainlib');
		$this->load->model('m_it');
	}
	

	public function index(){  }
	
	protected $dokter_igd = "dr. Lucky Dana Victory";
	protected $baseUrlWsPrinter = "192.168.1.104/rscm/wsprinter/wsprinter.php"; // ORI
	// protected $baseUrlWsPrinter = "192.168.1.68/rscm/wsprinter/wsprinter.php";
	// protected $baseUrlWsPrinter = "192.168.1.104/rscm/wsprinter_dev/wsprinter.php";

	// private $print_db = [
	// 	[ 
	// 		'url' 			=> 'bo/menu/receptionist/laporan/lap-daftarrj', 
	// 		'button_id' => 'btn_cetak_antrian_skdp_1', 
	// 		'fx_name' 	=> 'termal_nomor_antrian_new', //1
	// 		'printername' => '\\\\192.168.1.104\\Code Soft 32xx Series',],
	// 	[ 
	// 		'url' 			=> 'bo/menu/receptionist/laporan/lap-daftarrj', 
	// 		'button_id' => 'btn_cetak_antrian_skdp_1', 
	// 		'fx_name' 	=> 'cetak_skdp_langsung_termal', //1
	// 		'printername' => '\\\\192.168.1.104\\Code Soft 32xx Series',],
	// ];

	// public function lists(){
	// 	echo json_encode($this->print_db);
	// 	//return $this->pr;
	// }
	
	public function restart_spooler(){
		$output=null;
		$retval=null;
		// exec('whoami', $output, $retval);
		// echo "Returned with status $retval and output:\n";

		// exec('cleanmgr', $output, $retval);
		exec('net stop spooler', $output, $retval);
		exec('net start spooler', $output, $retval);
		print_r($output);
		echo "<br>Sudah Restart Spooler.";
	}
	
	public function wsprinter_send($wsmethod='', $repeat=1){
		settype($repeat, 'integer');
		$post = $this->input->post(NULL,TRUE);
		$post['ipclient'] = my_ip()['client'];
		if(!isset($post['user'])) $post['user'] = $this->session->userdata("username");

		// exit(json_encode([$post, $repeat]));

		$this->load->library('curl');
		
		$val = [];
		if($repeat<=2)
			for ($i=0; $i < $repeat; $i++)
				$val[] = json_decode($this->curl->sendRequest($wsmethod, "POST", json_encode($post),'application/json', $this->baseUrlWsPrinter) ,1);
				
		// return $val;
		exit(json_encode($val));
	}
	
	
	public function wsprinter_send_redirect($wsmethod='', $repeat=1){
		settype($repeat, 'integer');
		$post = $this->input->post(NULL,TRUE);
		$post['ipclient'] = my_ip()['client'];
		if(!isset($post['user'])) $post['user'] = $this->session->userdata("username");
		$post['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
		$post['SERVER'] = $_SERVER;
		// exit(json_encode($post));
		// echo "<pre>",print_r($post),"</pre>";
		$this->load->library('curl');
		$val = json_decode($this->curl->sendRequest($wsmethod, "POST", json_encode($post),'application/json', $this->baseUrlWsPrinter) ,1);
		header('Location: '.$post['HTTP_REFERER']); exit;
		// exit(json_encode([$post, $repeat]));


		
		// $val = [];
		// if($repeat<=2)
		// 	for ($i=0; $i < $repeat; $i++)
		// 		$val[] = json_decode($this->curl->sendRequest($wsmethod, "POST", json_encode($post),'application/json', $this->baseUrlWsPrinter) ,1);
				
		// // return $val;
		// exit(json_encode($val));
		
	}


	public function cetak_skdp_antrian($norm_noka=null, $nomor=null){
		$this->load->model('m_daftarmandiri');
		$post = $this->input->post(NULL, TRUE);
		// $query = $this->m_daftarmandiri->cetak_skdp_antrian($norm_noka, $nomor);
		$date = (isset($post['date']))? $post['date'] : date('Y-m-d');
		// die($date);
		$query = $this->m_daftarmandiri->cetak_skdp_antrian($post['norm_noka'], $post['nomor'], $date);

		// echo "<pre>",print_r($query),"</pre>"; exit; // TESTING
		// var_dump($query); exit;
		if($query!=null){
			// $post = $query[0];
			// echo json_encode($post);
			// // echo "<pre>",print_r($post),"</pre>";

			$post['ipclient'] = my_ip()['client'];

			$js_sel = $query[0];
			$antrian = [
				"ipclient" 	=> $post['ipclient'], // _ADDR,
				"url" 		  => $post['url'], // _ADDR,
				"button_id" => $post['button_id'], // $(this).attr("id"),
				"billing"   => $js_sel['billing'],
				"no_antrian"=> $js_sel['no_antrian'],
				"tglrujukan"=> $js_sel['tglrujukan'],
				"nama"      => $js_sel['nama'],
				"dpjp"      => $js_sel['dpjp'],
				"nosep"     => $js_sel['nosep'],
			];
			
			$skdp = [
				"ipclient" 	=> $post['ipclient'], // _ADDR,
				"url" 		  => $post['url'], // _ADDR,
				"button_id" => $post['button_id'], // $(this).attr("id"),
				"billing" => $js_sel['billing'],
				"noskdp"  => $js_sel['noskdp'],
				"norm"    => $js_sel['norm'],
				"nama"    => $js_sel['nama'],
				"tglLahir"=> $js_sel['tglLahir'],
				"provPerujuk" => $js_sel['provPerujuk'],
				"tglSep"  => $js_sel['tglSep'],
				"dpjp"    => $js_sel['dpjp'],
			];

			// echo json_encode([$antrian, $skdp]); exit;

			// WS RS
			// $_ws_antrian = json_decode( $this->mainlib->curl("","POST", $antrian,"application/json","http://192.168.1.68/rscm/wsprinter/wsprinter.php/termal_nomor_antrian_new"), 1 );
	    // $_ws_skdp 	 = json_decode( $this->mainlib->curl("","POST", $skdp,"application/json","http://192.168.1.68/rscm/wsprinter/wsprinter.php/skdp"), 1 );
					
			$this->load->library('curl');
			$_ws_antrian = json_decode( $this->curl->sendRequest("termal_nomor_antrian_new","POST", json_encode($antrian),"application/json",$this->baseUrlWsPrinter), 1 );
	    $_ws_skdp 	 = json_decode( $this->curl->sendRequest("skdp","POST", json_encode($skdp),"application/json",$this->baseUrlWsPrinter), 1 );
			
			// echo '<pre>',print_r([$_ws_antrian, $_ws_skdp ]),'</pre>'; exit;
			$res = [$js_sel, $_ws_antrian, $_ws_skdp ];
			$val = ["metadata"=> ["code"=>200, "status"=>"success","message"=>"OK."], "response"=>$res];			
			// echo json_encode([$js_sel, $_ws_antrian, $_ws_skdp ]); exit;
			
		}else{
			$val = ["metadata"=> ["code"=>201, "status"=>"failed","message"=>"Gagal cetak."], "response"=>null];
		}

		echo json_encode($val); exit;
	}




	// ======================================================

  // public function termal_nomor_antrian_new($data=null, $select_printer=null){
  public function termal_nomor_antrian_new(){
		$data = $this->input->post(NULL, TRUE);
		$data['methodname']  = $this->router->fetch_method();
		$data['printername'] = $this->m_it->printername($data['url'], $data['button_id'], $data['methodname']);

		// // /* write the text to the print job */
		$handle = printer_open( $data['printername'] );

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc( $handle, $data['methodname'] );
		printer_start_page($handle);



		$margin_left_page = 50;
		$margin_top_page = 50;
		$font_height = 30;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "NOMOR ANTRIAN";
		printer_draw_text($handle, $text, $margin_left_page, $margin_top_page);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS. Citra Medika";
		printer_draw_text($handle, $text, $margin_left_page, ($margin_top_page+$font_height*1) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		/*BILLING*/
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['billing'];
		printer_draw_text($handle, $text, $margin_left_page, ($margin_top_page+$font_height*2) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*BARCODE SEP*/
		$font = printer_create_font("Free 3 of 9", 40, 25, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "*".$data['nosep']."*";
		//printer_draw_text($handle, $text, $margin_left_page, 170);
		printer_draw_text($handle, $text, 5, 170);
		printer_delete_font($font);


		/*NO.ANTRIAN*/
		$font = printer_create_font("Lucida Console", 120, 80, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['no_antrian'];
		printer_draw_text($handle, $text, $margin_left_page*5+20, 50);
		////printer_draw_text($handle, $text, $margin_left_page+50, 130); //posisi X CENTER
		printer_delete_font($font);


		/* ====== DATA PASIEN ====== */
		$font = printer_create_font("Lucida Console", 28, 14, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		function tulis($handle_my, $row_dt_pasien, $text_my){
			$x = 20;
			$y = 250;
			printer_draw_text($handle_my, $text_my, $x, $y+(28*($row_dt_pasien-1)) );
		}

		$tulisan = array(
			"Tgl.Rujukan: ".$data['tglrujukan'],
			"Nama   : ".$data['nama'],
			"Dokter : ".$data['dpjp'],
			"Cetak  : ".date('Y-m-d h:i:s')
		);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, $tulisan_i, $tulisans);
			$tulisan_i++;
		}


		printer_delete_font($font);
		/* ======\DATA PASIEN ====== */

		// echo "<pre>",print_r($handle),"</pre>"; //Resource id : 601 (ini echo webservice)

		$printer_end_page = printer_end_page($handle);
		$printer_end_doc = printer_end_doc($handle);
		$printer_close = printer_close($handle);

		$val = [
			"response" => [
				"status" => "selesai",
				"datapost" => $data,
			],
			"printer_end_page"=> $printer_end_page,
			"printer_end_doc" => $printer_end_doc,
			"printer_close" 	=> $printer_close,
		];

		echo json_encode($val); exit;

	}



	
	public function tulis_loop($handle_my, $x, $y, $row_dt_pasien, $text_my, $spacing_enter){
		//printer_draw_text($handle_my, $text_my, $x, $y+(75*($row_dt_pasien-1)) );
		printer_draw_text($handle_my, $text_my, $x, $y+($spacing_enter*($row_dt_pasien-1)) );
	}


	public function skdp(){
		$data = $this->input->post(NULL, TRUE);
		$data['methodname']  = $this->router->fetch_method();
		$data['printername'] = $this->m_it->printername($data['url'], $data['button_id'], $data['methodname']);

		// /* write the text to the print job */
		$handle = printer_open( $data['printername'] );
		// var_dump($handle);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, $data['methodname']);
		printer_start_page($handle);



		
		/* ====== data_skdp ====== */
		$font_h_pasien = 23; //25
		$font = printer_create_font("Lucida Console", $font_h_pasien, 12, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		
		
		
		//jika  'U G D', dokter kosong
		// if($data['dpjp'] == "dr. Lucky Dana Victory"){
			// if($data['dpjp'] == "dr. Titia Rahmania,M.H.Kes"){
		if($data['dpjp'] == $this->dokter_igd) $data['dpjp'] = " ";		

		$tulisan = array(
				"                             ".$data['billing'],
				"",
				"",
				"",
				"",
				"",
				"",
				"No.RM     : ".$data['norm']."    (S.Kontrol/SKDP)**", //.$data['noSep'],
				"Nama      : ".$data['nama'],
				"Tgl.Lahir : ".$data['tglLahir'],
				"Klinik    : ".$data['provPerujuk'],
				"Diagnosa  : ",
				"",
				"1. Belum dapat dikembalikan ke FKTP:",
				"   1.",
				"   2.",
				"   3.",
				"2. Rencana tindak lanjut pada kunjungan",
				"   selanjutnya:",
				"   1.",
				"   2.",
				"   3.",
				"[ ] Surat keterangan ini digunakan untuk",
				"    kunjungan selanjutnya pada tanggal:",
				"",
				"[ ] Pasien dalam kondisi stabil dan dapat",
				"    melanjutkan perawatan kembali di FKTP",
				"",
				"[ ] Mohon skrining dan evaluasi ulang di FKTP",
				"    untuk kunjungan ke .......... pada tanggal:",
				"    ....... dengan diagnosa:...................",
				"",
				"           Sidoarjo, ".$data['tglSep'],
				"                  DPJP",
				"",
				"",
				"          ".$data['dpjp'],
				"",
				"* Mohon surat ini selalu dibawa saat berobat",
				"**Lingkari yang perlu",
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			// tulis($handle, 100, 200, $tulisan_i, $tulisans);
			$this->tulis_loop($handle, 10, 50, $tulisan_i, $tulisans, 28);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\data_skdp ====== */

		//=====
		$margin_left_page = 50;
		$margin_top_page = 50;
		$font_height = 30;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS. Citra Medika";
		printer_draw_text($handle, $text, 30, 0 );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "           SURAT KETERANGAN*"; //"NOMOR ANTRIAN";
		printer_draw_text($handle, $text, $margin_left_page, $margin_top_page);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "       No : ".$data['noskdp'];
		printer_draw_text($handle, $text, $margin_left_page, ($margin_top_page+$font_height*1) );
		printer_delete_font($font);


		/* BARCODE NORM */
		$font = printer_create_font("Free 3 of 9", 40, 30, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "*".$data['norm']."*";
		printer_draw_text($handle, $text, 5, 160);
		printer_delete_font($font);

		
		$font = printer_create_font("Tahoma", 60, 30, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['norm'];
		printer_draw_text($handle, $text, 280, 150 );
		printer_delete_font($font);
		//=====
		


		$printer_end_page = printer_end_page($handle);
		$printer_end_doc = printer_end_doc($handle);
		$printer_close = printer_close($handle);

		$val = [
			"response" => [
				"status" => "selesai",
				"datapost" => $data,
			],
			"printer_end_page"=> $printer_end_page,
			"printer_end_doc" => $printer_end_doc,
			"printer_close" 	=> $printer_close,
		];

		echo json_encode($val); exit;
	}
		
	
	
	// public function termal_tracer_v3($data=null, $lokasi=null, $label_printer=null){
	public function tracer_curl(){
		$data = $this->input->post(NULL, TRUE);
		if($data == null){
			$data = json_decode(file_get_contents( 'php://input' ),true);
			
		}
		echo '<pre>',print_r($data),'</pre>'; exit;
		// echo '<pre>',var_dump($data),'</pre>'; exit;
		
	}

	public function tracer(){
		$data = $this->input->post(NULL, TRUE);
		if($data == null){  // dari CURL XDOMAIN
			$data = json_decode(file_get_contents( 'php://input' ),1);
			// echo '<pre>',print_r($data),'</pre>'; exit;
			$db_px = $data['db_px_tracer'];
		}else{
			// DB
			// https://192.168.1.68/rscm/app_dev/ajaxreq/db/m_daftarmandiri/laporan_pendaftaran_px_soft_by_bill/RJ/BL210217.0007/30
			$this->load->model('m_daftarmandiri');
			$db_px = $this->m_daftarmandiri->laporan_pendaftaran_px_soft_by_bill($data['segment'], $data['NoBill'], $data['lokasikode']);
			if(count($db_px)>0) $db_px = $db_px[0];
			// echo json_encode([$data, $db_px]); exit;
		}

		$data['methodname']  = $this->router->fetch_method();
		$data['printername'] = $this->m_it->printername($data['url'], $data['button_id'], $data['methodname']);
		
		// // /* write the text to the print job */
		$handle = printer_open( $data['printername'] );

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, $data['methodname']);
		printer_start_page($handle);
		
		// echo "<pre>",print_r($handle),"</pre>"; // exit; //#TEST


		$margin_left_page = 25;
		$margin_top_page = 50;
		$font_height = 30;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		// $text = $data['NoBill']." / RAWAT JALAN / ".$data['st_px_baru_lama'];
		$nobill_lbl = ($data['segment'] == 'BOOK_RJ')? $db_px['nobill_booking'] : $data['NoBill'];
		$text = $nobill_lbl." / RAWAT JALAN / ".$db_px['statuspasien'];
		printer_draw_text($handle, $text, $margin_left_page, 0);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*NO.RM*/
		$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $db_px['norm']; // $data['NoRM'];
		printer_draw_text($handle, $text, $margin_left_page, 40);
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = 'Antrian: '.$data['no_antrian'];
		printer_draw_text($handle, $text, $margin_left_page+280, 50);	
		printer_delete_font($font);


		/*BARCODE RM*/
		// $font = printer_create_font("Free 3 of 9", 40, 25, 400, false, false, false, 0);
		// printer_select_font($handle, $font);
		// $text = "*".$data['NoRM']."*";
		// printer_draw_text($handle, $text, $margin_left_page*6, 40); //($handle, $text, $margin_left_page, 170)
		// printer_delete_font($font);



		/* ====== DATA PASIEN ====== */
		$font_h_pasien = 30;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 17, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		function tulis($handle_my, $x, $y, $row_dt_pasien, $text_my){
			printer_draw_text($handle_my, $text_my, $x, $y+(30*($row_dt_pasien-1)) );
		}

		$tulisan = array(
				// $data['Nama'],
				// $data['TglLahir']." / ".$data['Sex']." / ".$data['umur']." TH"
				$db_px['nama'],
				$db_px['tgllahir']." / ".$db_px['jeniskelamin']." / ".$db_px['umur']." TH"
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 25, 120, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\DATA PASIEN ====== */


		/* ====== ALAMAT PASIEN ====== */
		$font_h_pasien = 25;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 12, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		//$alamat_pasien = alamat_split("Jl. Melati, No.196, Ds. Padangan RT.10,RW.04, Kec. Tulangan, Kab. Sidoarjo.");
		$alamat_pasien =  alamat_split($db_px['alamat']); // alamat_split($data['Alamat']);
		$js_alamat = json_decode($alamat_pasien);
		$alamat_row1 = $js_alamat[0]->val;
		///////////$alamat_row2 = $js_alamat[1]->val; //ini bikin error kalau kosong!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		$alamat_row2 = "";
		$tulisan = array(
				$alamat_row1,
				$alamat_row2
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 25, 180, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\ALAMAT PASIEN ====== */



		/* ====== DATA KLINIK TUJUAN ====== */
		$font_h_pasien = 30;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 17, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);
		
		
		$tulisan = array(
				"------------------------------",
				$data['klinik'],
				$data['dokter']
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 25, 240, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\DATA KLINIK TUJUAN ====== */


		$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		// $text = date('Y-m-d h:i:s')."  ".$data['user'];
		$text = date('Y-m-d h:i:s')."  ".$this->session->userdata("username");
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*9));	
		printer_delete_font($font);


		/*BARCODE BILLING*/
		$font = printer_create_font("Free 3 of 9", 40, 25, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "*".$data['NoBill']."*";
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*10));
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		// $text = "Ket:".$data['ket'];
		$text = "Ket:".$db_px['keterangan'];
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*11)+15);	
		printer_delete_font($font);

		// $font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $db_px['penanggung_ket']; // $data['penanggung_cm'];
		
		if($text == "" || $text == "-") $text = "UMUM";

		// $text .= " / ".$data['prb']." / ".$data['pdp'];
		$text .= " / ".$db_px['prb_str']." / ".$db_px['PDPStatus'];
		
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*13)+15);	
		printer_delete_font($font);
		
		
		$printer_end_page = printer_end_page($handle);
		$printer_end_doc = printer_end_doc($handle);
		$printer_close = printer_close($handle);

		$val = [
			"response" => [
				"status" => "selesai",
				"datapost" => $data,
			],
			"printer_end_page"=> $printer_end_page,
			"printer_end_doc" => $printer_end_doc,
			"printer_close" 	=> $printer_close,
		];

		echo json_encode($val); exit;
	}



	// ANTRIAN PENDAFTARAN di RC / (BUKAN KLINIK)
	// public function termal_nomor_antrian_daftar($data=null){
	public function antrian_rc($data=null){
		$this->load->model(['m_publik', 'm_main']);
		$db = $this->m_publik->select_nomor_antridaftar_max(date('Y-m-d'));

		$data = $this->input->post(NULL, TRUE);

		$data['noantrian'] = $db['next']['nominal'];
		$data['methodname']  = $this->router->fetch_method();
		$data['printername'] = $this->m_it->printername($data['url'], $data['button_id'], $data['methodname']);

		$ymd = date('Y-m-d');
		$his = date('H:i:s');

		$insert = [
			"lokasi" => 110,
			"nomor"  => $data['noantrian'],
			"mulai"  => $his,
			"date"   => $ymd,
			// "user"   => $this->session->userdata("username"), // cz yang klik px, maka user=''
		];

		// echo json_encode([$insert, $data]); exit;
		$this->m_main->insert('antridaftar', $insert);
		


		// // /* write the text to the print job */
		$handle = printer_open( $data['printername'] );

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, $data['methodname']);
		printer_start_page($handle);



		$margin_left_page = 25;
		$margin_top_page = 50;
		$font_height = 30;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "NOMOR ANTRIAN PENDAFTARAN";
		printer_draw_text($handle, $text, $margin_left_page, 0);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);
		
		
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS. CITRA MEDIKA";
		printer_draw_text($handle, $text, $margin_left_page, (30*2));	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*NO.RM*/
		// $font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		$font = printer_create_font("Lucida Console", 120, 75, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['noantrian'];
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*1) );
		printer_delete_font($font);



		$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		// $text = "CETAK: ".$data['datetime']; //date('Y-m-d h:i:s')."  ".
		$text = "CETAK: ".$ymd." ".$his;
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*6));	
		printer_delete_font($font);


		
		$printer_end_page = printer_end_page($handle);
		$printer_end_doc = printer_end_doc($handle);
		$printer_close = printer_close($handle);

		$val = [
			"response" => [
				"status" => "selesai",
				"datapost" => $data,
			],
			"printer_end_page"=> $printer_end_page,
			"printer_end_doc" => $printer_end_doc,
			"printer_close" 	=> $printer_close,
		];

		echo json_encode($val); exit;
	}




}