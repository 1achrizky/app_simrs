<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_kertas {
	private $printer = array(
		//'daftar_mandiri' => '\\\\192.168.1.106\\80mm Series Printer',
		// 'termal_nomor_antrian'	=> '\\\\192.168.1.104\\POS-80C', //2019/04/27
		// 'termal_nomor_antrian'	=> '\\\\192.168.1.104\\TM-P230C Series',

		// 'termal_nomor_antrian'	=> '\\\\192.168.1.104\\TM-P76xxC Series', // SEKARANG REAKRE2020
		'termal_nomor_antrian'	=> '\\\\192.168.1.205\\80mm Series Printer', // SEKARANG REAKRE2020

		'termal_tracer' 	 			=> '\\\\192.168.1.106\\80mm Series Printer',
		'termal_tracer_rc' 	 		=> '\\\\192.168.1.93\\TM-32XX Series',
		'termal_nomor_antrian_daftar' => '\\\\192.168.1.93\\TM-32XX Series',
		'cetak_sep_langsung'		=> '\\\\192.168.1.100\\Canon LBP6030/6040/6018L',
		'cetak_skdp_langsung' 	=> '\\\\192.168.1.104\\HP LaserJet Professional M1132 MFP', //RC SKDP
		// // 'cetak_skdp_langsung_termal'=> '\\\\192.168.1.93\\TM-32XX Series',
		// 'cetak_skdp_langsung_termal'=> '\\\\192.168.1.68\\TM-P31xx Series',
		// 'termal_nomor_antrian_new'=> '\\\\192.168.1.68\\TM-P31xx Series',

		'cetak_skdp_langsung_termal'=> '\\\\192.168.1.93\\TM-32XX Series',
		'termal_nomor_antrian_new'=> '\\\\192.168.1.93\\TM-32XX Series',
		'cetak_skdp_langsung_termal_1'=> '\\\\192.168.1.205\\80mm Series Printer',
		'termal_nomor_antrian_new_1'=> '\\\\192.168.1.205\\80mm Series Printer',
	);

	public function my_printer_list(){
		return $this->printer;
		//return $this->pr;
	}

	public function termal_daftar_mandiri($nama_printer){
		//echo $nama_printer;
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */		
		$alamat = $nama_printer;
		// ////$printer = printer_open("EPSON L120 Series");  
		// /* write the text to the print job */  
		// var_dump($printer);

		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "tes_cetak_termal");
		printer_start_page($handle);

		//==========================================================
		// function print_img($doc,$img,$res,$pos_x,$pos_y){
			// 	$img_size = getimagesize($img);
			// 	$img_resolution = $res;

			// 	$img_width = $img_size[0];
			// 	$img_height = $img_size[1];

			// 	echo $img_width.'<BR>';
			// 	echo $img_height.'<BR>';

			// 	$ptr_resolution_x = printer_get_option($doc, PRINTER_RESOLUTION_X);
			// 	$ptr_resolution_y = printer_get_option($doc, PRINTER_RESOLUTION_Y);

			// 	echo $ptr_resolution_x.'<BR>';
			// 	echo $ptr_resolution_y.'<BR>';

			// 	$img_scale_x = $ptr_resolution_x / $img_resolution;
			// 	$img_scale_y = $ptr_resolution_y / $img_resolution;

			// 	echo $img_scale_x.'<BR>';
			// 	echo $img_scale_y.'<BR>';

			// 	$ptr_width = $img_width * $img_scale_x;                            
			// 	$ptr_height = $img_height * $img_scale_y;

			// 	echo $doc.'<BR>';
			// 	echo $ptr_width.'<BR>';
			// 	echo $ptr_height.'<BR>';

			// 	printer_draw_bmp($doc,$img,$pos_x,$pos_y,$ptr_width,$ptr_height);
			// 	//printer_draw_bmp(printer_handle, filename, x, y)
		// }

		//print_img($handle, '..\img\logo_rscm_bmp.bmp', 72, 10, 10);
		////////////////////printer_draw_bmp($handle,"logo.bmp", 1, 1); //SETTING ALAMAT GAMBAR

		//=================================

		$margin_left_page = 50;
		$margin_top_page = 50;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "Permintaan Pendaftaran";
		printer_draw_text($handle, $text, $margin_left_page, 50);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS. Citra Medika";
		printer_draw_text($handle, $text, $margin_left_page, 80);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		/*NO.RM*/
		$font = printer_create_font("Tahoma", 60, 22, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "123456";
		printer_draw_text($handle, $text, $margin_left_page*7, 50);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		$font = printer_create_font("Free 3 of 9", 50, 30, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "*BR180602.0123*";
		printer_draw_text($handle, $text, $margin_left_page, 130);
		printer_delete_font($font);


		/* ====== DATA PASIEN ====== */
		$font = printer_create_font("Lucida Console", 30, 16, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		function tulis($handle_my, $row_dt_pasien, $text_my){
			$x = 50;
			$y = 220;
			printer_draw_text($handle_my, $text_my, $x, $y+(30*($row_dt_pasien-1)) );
		}

		$nama = "abc acb acb";
		$tulisan = array(
				"Nama   : ".$nama,
				"Klinik : ....",
				"Dokter : ....",
				"Kunjung: ....",
				"Cetak  : ...."
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, $tulisan_i, $tulisans);
			$tulisan_i++;
		}


		printer_delete_font($font);
		/* ======\DATA PASIEN ====== */



		$font = printer_create_font("Lucida Console", 25, 12, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "(Serahkan Bukti ini ke Receptionist)";
		printer_draw_text($handle, $text, $margin_left_page, 350);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);



		printer_end_page($handle);
		printer_end_doc($handle);
		//////printer_close($handle);
		printer_close($alamat);

	}


	// REAKRE2020
	// 104
	public function termal_nomor_antrianNO($data){
		//echo $nama_printer;
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */    
		////////$alamat = "\\\\192.168.1.104\\POS-80C"; //RC2
		$alamat = $this->printer['termal_nomor_antrian'];
		// /* write the text to the print job */  
		// var_dump($printer);

		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_termal_nomor_antrian");
		printer_start_page($handle);



		$margin_left_page = 10;
		$margin_top_page = 10;
		$font_height = 10;

		//WINDOWS XP - driver stabil - yg lama : POS-80C
		// $margin_left_page = 50;
		// $margin_top_page = 50;
		// $font_height = 30;
		//WINDOWS XP - driver stabil - yg lama : POS-80C

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", $font_height, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "NOMOR ANTRIAN";
		printer_draw_text($handle, $text, $margin_left_page, $margin_top_page);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		$font = printer_create_font("Tahoma", $font_height, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS. Citra Medika";
		printer_draw_text($handle, $text, $margin_left_page, ($margin_top_page+$font_height*1) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		/*BILLING*/
		$font = printer_create_font("Tahoma", $font_height, 15, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['billing'];
		printer_draw_text($handle, $text, $margin_left_page, ($margin_top_page+$font_height*2) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*BARCODE SEP*/
		//$font = printer_create_font("Free 3 of 9", 40, 23, 400, false, false, false, 0);
		// $font = printer_create_font("Free 3 of 9", 12, 25, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 10, 15, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "*".$data['nosep']."*";
		//printer_draw_text($handle, $text, $margin_left_page, 170);
		printer_draw_text($handle, $text, 5, 100);
		printer_delete_font($font);


		/*NO.ANTRIAN*/
		// $font = printer_create_font("Lucida Console", 120, 80, 400, false, false, false, 0);
		$font = printer_create_font("Lucida Console", 30, 45, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['no_antrian'];
		printer_draw_text($handle, $text, 250, $margin_top_page);
		////printer_draw_text($handle, $text, $margin_left_page+50, 130); //posisi X CENTER
		printer_delete_font($font);


		/* ====== DATA PASIEN ====== */
		$font = printer_create_font("Lucida Console", $font_height, 16, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		function tulis($handle_my, $row_dt_pasien, $text_my){
			$x = 5;
			$y = 150;
			printer_draw_text($handle_my, $text_my, $x, $y+(20*($row_dt_pasien-1)) );
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

		// ----
		$font = printer_create_font("Tahoma", 10, 15, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "---";
		//printer_draw_text($handle, $text, $margin_left_page, 170);
		printer_draw_text($handle, $text, 5, 200);
		printer_delete_font($font);
		// ----
		
		/* ======\DATA PASIEN ====== */


		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
		//printer_close($alamat);
	}
	
	
	public function termal_nomor_antrian_new($data){
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */    
		////////$alamat = "\\\\192.168.1.104\\POS-80C"; //RC2
		$alamat = $this->printer['termal_nomor_antrian_new'];
		// /* write the text to the print job */  
		// var_dump($printer);

		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "termal_nomor_antrian_new");
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
		////$font = printer_create_font("Free 3 of 9", 40, 30, 400, false, false, false, 0);
		//$font = printer_create_font("Free 3 of 9", 40, 23, 400, false, false, false, 0);
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


		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}



	// BACKUP VERSI BAGUS, LAMA, STABIL
	// public function termal_nomor_antrianXXX($nama_printer,$data){
	public function termal_nomor_antrian($nama_printer,$data){
		//echo $nama_printer;
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */    
		////////$alamat = "\\\\192.168.1.104\\POS-80C"; //RC2
		$alamat = $this->printer['termal_nomor_antrian'];
		// /* write the text to the print job */  
		// var_dump($printer);

		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_termal_nomor_antrian");
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
		$text = $data['NoBill'];
		printer_draw_text($handle, $text, $margin_left_page, ($margin_top_page+$font_height*2) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*BARCODE SEP*/
		////$font = printer_create_font("Free 3 of 9", 40, 30, 400, false, false, false, 0);
		//$font = printer_create_font("Free 3 of 9", 40, 23, 400, false, false, false, 0);
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
		$font = printer_create_font("Lucida Console", 30, 16, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		function tulis($handle_my, $row_dt_pasien, $text_my){
			$x = 50;
			$y = 250;
			printer_draw_text($handle_my, $text_my, $x, $y+(30*($row_dt_pasien-1)) );
		}

		$tulisan = array(
				"Tgl.Rujukan: ".$data['tglrujukan'],
				"Nama   : ".$data['Nama'],
				"Dokter : ".$data['dokter'],
				"Cetak  : ".date('Y-m-d h:i:s')
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, $tulisan_i, $tulisans);
			$tulisan_i++;
		}


		printer_delete_font($font);
		/* ======\DATA PASIEN ====== */


		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
		//printer_close($alamat);

	}


	// JS FILE>> cetak_tracer
	public function termal_tracer($nama_printer,$data=null){
		//echo $nama_printer;
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */ 
		///////////$alamat = "\\\\192.168.1.106\\80mm Series Printer"; //tracer rm
		$alamat = $this->printer['termal_tracer']; //tracer rm
		
		//$alamat = $_POST['nama_printer'];
		////////////////////////////$alamat = $nama_printer;

		// echo $alamat."__".$_POST['nama_printer'];
		// ////$printer = printer_open("EPSON L120 Series");  
		// /* write the text to the print job */  
		// var_dump($printer);

		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_termal_tracer");
		printer_start_page($handle);



		$margin_left_page = 25;
		$margin_top_page = 50;
		$font_height = 30;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['NoBill']." / RAWAT JALAN / ".$data['st_px_baru_lama'];
		printer_draw_text($handle, $text, $margin_left_page, 0);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*NO.RM*/
		$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['NoRM'];
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
				$data['Nama'],
				$data['TglLahir']." / ".$data['Sex']." / ".$data['umur']." TH"
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
		$alamat_pasien = alamat_split($data['Alamat']);
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
		$text = "BPJS   ".date('Y-m-d h:i:s')."  ".$data['user'];
		// $text = date('Y-m-d h:i:s')."  ".$data['user'];
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
		$text = "Ket:".$data['ket'];
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*11)+15);	
		printer_delete_font($font);



		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}
	


	
	// $nama_printer = $this->printer['termal_tracer'];
	// public function termal_tracer_v2($data){
		// 	header('Access-Control-Allow-Origin: *'); 
		// 	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			
		// 	$handle = printer_open($data["nama_printer"]);

		// 	printer_set_option($handle, PRINTER_MODE, "RAW");
		// 	printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		// 	printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		// 	printer_set_option($handle, PRINTER_SCALE, 50);
			
		// 	printer_start_doc($handle, "cetak_termal_tracer");
		// 	printer_start_page($handle);



		// 	$margin_left_page = 25;
		// 	$margin_top_page = 50;
		// 	$font_height = 30;

		// 	//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		// 	//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		// 	$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		// 	printer_select_font($handle, $font);
		// 	$text = $data['NoBill']." / RAWAT JALAN / ".$data['st_px_baru_lama'];
		// 	printer_draw_text($handle, $text, $margin_left_page, 0);	////printer_draw_text(printer_handle, text, x, y);
		// 	printer_delete_font($font);


		// 	/*NO.RM*/
		// 	$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		// 	printer_select_font($handle, $font);
		// 	$text = $data['NoRM'];
		// 	printer_draw_text($handle, $text, $margin_left_page, 40);
		// 	printer_delete_font($font);

		// 	$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		// 	printer_select_font($handle, $font);
		// 	$text = 'Antrian: '.$data['no_antrian'];
		// 	printer_draw_text($handle, $text, $margin_left_page+280, 50);	
		// 	printer_delete_font($font);


		// 	/*BARCODE RM*/
		// 	// $font = printer_create_font("Free 3 of 9", 40, 25, 400, false, false, false, 0);
		// 	// printer_select_font($handle, $font);
		// 	// $text = "*".$data['NoRM']."*";
		// 	// printer_draw_text($handle, $text, $margin_left_page*6, 40); //($handle, $text, $margin_left_page, 170)
		// 	// printer_delete_font($font);



		// 	/* ====== DATA PASIEN ====== */
		// 	$font_h_pasien = 30;
		// 	$font = printer_create_font("Lucida Console", $font_h_pasien, 17, PRINTER_FW_NORMAL, false, false, false, 0);
		// 	printer_select_font($handle, $font);

		// 	function tulis($handle_my, $x, $y, $row_dt_pasien, $text_my){
		// 		printer_draw_text($handle_my, $text_my, $x, $y+(30*($row_dt_pasien-1)) );
		// 	}

		// 	$tulisan = array(
		// 			$data['Nama'],
		// 			$data['TglLahir']." / ".$data['Sex']." / ".$data['umur']." TH"
		// 		);

		// 	$tulisan_i = 0;
		// 	foreach($tulisan as $tulisans){
		// 		tulis($handle, 25, 120, $tulisan_i, $tulisans);
		// 		$tulisan_i++;
		// 	}

		// 	printer_delete_font($font);
		// 	/* ======\DATA PASIEN ====== */


		// 	/* ====== ALAMAT PASIEN ====== */
		// 	$font_h_pasien = 25;
		// 	$font = printer_create_font("Lucida Console", $font_h_pasien, 12, PRINTER_FW_NORMAL, false, false, false, 0);
		// 	printer_select_font($handle, $font);

		// 	//$alamat_pasien = alamat_split("Jl. Melati, No.196, Ds. Padangan RT.10,RW.04, Kec. Tulangan, Kab. Sidoarjo.");
		// 	$alamat_pasien = alamat_split($data['Alamat']);
		// 	$js_alamat = json_decode($alamat_pasien);
		// 	$alamat_row1 = $js_alamat[0]->val;
		// 	///////////$alamat_row2 = $js_alamat[1]->val; //ini bikin error kalau kosong!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// 	$alamat_row2 = "";
		// 	$tulisan = array(
		// 			$alamat_row1,
		// 			$alamat_row2
		// 		);

		// 	$tulisan_i = 0;
		// 	foreach($tulisan as $tulisans){
		// 		tulis($handle, 25, 180, $tulisan_i, $tulisans);
		// 		$tulisan_i++;
		// 	}

		// 	printer_delete_font($font);
		// 	/* ======\ALAMAT PASIEN ====== */



		// 	/* ====== DATA KLINIK TUJUAN ====== */
		// 	$font_h_pasien = 30;
		// 	$font = printer_create_font("Lucida Console", $font_h_pasien, 17, PRINTER_FW_NORMAL, false, false, false, 0);
		// 	printer_select_font($handle, $font);

			
		// 	$tulisan = array(
		// 			"------------------------------",
		// 			$data['klinik'],
		// 			$data['dokter']
		// 		);

		// 	$tulisan_i = 0;
		// 	foreach($tulisan as $tulisans){
		// 		tulis($handle, 25, 240, $tulisan_i, $tulisans);
		// 		$tulisan_i++;
		// 	}

		// 	printer_delete_font($font);
		// 	/* ======\DATA KLINIK TUJUAN ====== */


		// 	$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		// 	printer_select_font($handle, $font);
		// 	$text = "BPJS   ".date('Y-m-d h:i:s')."  ".$data['user'];
		// 	printer_draw_text($handle, $text, $margin_left_page, 120+(30*9));	
		// 	printer_delete_font($font);


		// 	/*BARCODE BILLING*/
		// 	$font = printer_create_font("Free 3 of 9", 40, 25, 400, false, false, false, 0);
		// 	printer_select_font($handle, $font);
		// 	$text = "*".$data['NoBill']."*";
		// 	printer_draw_text($handle, $text, $margin_left_page, 120+(30*10));
		// 	printer_delete_font($font);

		// 	$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		// 	printer_select_font($handle, $font);
		// 	$text = "Ket:".$data['ket'];
		// 	printer_draw_text($handle, $text, $margin_left_page, 120+(30*11)+15);	
		// 	printer_delete_font($font);



		// 	printer_end_page($handle);
		// 	printer_end_doc($handle);
		// 	printer_close($handle);
	// }



	
	// JS FILE>> cetak_tracer
	// menambahi penanggung di bagian bawah dengan variabel(sebelumnya langsung string 'BPJS')
	public function termal_tracer_v3($data=null, $lokasi=null){
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */ 
		///////////$alamat = "\\\\192.168.1.106\\80mm Series Printer"; //tracer rm
		if($lokasi == "rc"){
			$alamat = $this->printer['termal_tracer_rc']; //tracer rc
		}else{ // null dan selain rc
			$alamat = $this->printer['termal_tracer']; //tracer rm
		}
		
		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_termal_tracer");
		printer_start_page($handle);



		$margin_left_page = 25;
		$margin_top_page = 50;
		$font_height = 30;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['NoBill']." / RAWAT JALAN / ".$data['st_px_baru_lama'];
		printer_draw_text($handle, $text, $margin_left_page, 0);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*NO.RM*/
		$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['NoRM'];
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
				$data['Nama'],
				$data['TglLahir']." / ".$data['Sex']." / ".$data['umur']." TH"
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
		$alamat_pasien = alamat_split($data['Alamat']);
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
		$text = date('Y-m-d h:i:s')."  ".$data['user'];
		// $text = date('Y-m-d h:i:s')."  ".$data['user'];
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
		$text = "Ket:".$data['ket'];
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*11)+15);	
		printer_delete_font($font);

		// $font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['penanggung_cm'];
		
		if($text == "" || $text == "-"){
			$text = "UMUM";
		}
		
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*13)+15);	
		printer_delete_font($font);



		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}


	// TRACER_BOOKING -> dari termal_tracer_v3
	// public function termal_tracer_booking($data=null, $lokasi=null){
	public function termal_tracer_booking($data=null){
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		$tes = ["status"=> "OK", "data"=> $data, "lokasi"=> "lokasi"];
		return $tes; exit;

		// /* tulis dan buka koneksi ke printer */ 
		// if($lokasi == "rc"){
		// 	$alamat = $this->printer['termal_tracer_rc']; //tracer rc
		// }else{ // null dan selain rc
		// 	$alamat = $this->printer['termal_tracer']; //tracer rm
		// }

		$alamat = $this->printer['termal_tracer']; //tracer rm
		
		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_termal_tracer_booking");
		printer_start_page($handle);



		$margin_left_page = 25;
		$margin_top_page = 50;
		$font_height = 30;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 30, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		// $text = $data['NoBill']." / RAWAT JALAN / ".$data['st_px_baru_lama'];
		$text = "BOOKING / RAWAT JALAN / ".$data['st_px_baru_lama'];
		printer_draw_text($handle, $text, $margin_left_page, 0);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		/*NO.RM*/
		$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['NoRM'];
		printer_draw_text($handle, $text, $margin_left_page, 40);
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = 'Antrian: '.$data['no_antrian']; // =NO_REQUEST
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
				$data['Nama'],
				$data['TglLahir']." / ".$data['Sex']." / ".$data['umur']." TH"
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
		$alamat_pasien = alamat_split($data['Alamat']);
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
		$text = date('Y-m-d h:i:s')."  ".$data['user'];
		// $text = date('Y-m-d h:i:s')."  ".$data['user'];
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
		$text = "Ket:".$data['ket'];
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*11)+15);	
		printer_delete_font($font);

		// $font = printer_create_font("Tahoma", 25, 12, 400, false, false, false, 0);
		$font = printer_create_font("Lucida Console", 40, 25, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['penanggung_cm'];
		
		if($text == "" || $text == "-"){
			$text = "UMUM";
		}
		
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*13)+15);	
		printer_delete_font($font);



		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}


	// ANTRIAN PENDAFTARAN di RC / (BUKAN KLINIK)
	// ???
	public function termal_nomor_antrian_daftar($data=null){
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */ 
		///////////$alamat = "\\\\192.168.1.106\\80mm Series Printer"; //tracer rm
		
		$alamat = $this->printer['termal_nomor_antrian_daftar']; //tracer rc
		
		$handle = printer_open($alamat);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "termal_nomor_antrian_daftar");
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
		$text = "CETAK: ".$data['datetime']; //date('Y-m-d h:i:s')."  ".
		// $text = date('Y-m-d h:i:s')."  ".$data['user'];
		printer_draw_text($handle, $text, $margin_left_page, 120+(30*6));	
		printer_delete_font($font);


		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}







	public function cetak_skdp_langsung($data){
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */		
		///////$alamat = "\\\\192.168.1.92\\HP LaserJet Professional P1102"; //TES PRINTER RM , LASER
		////////////$alamat = "\\\\192.168.1.100\\Canon LBP6030/6040/6018L"; //TES PRINTER APOTEK

		$alamat = $this->printer['cetak_skdp_langsung']; //TES PRINTER
		//$alamat = "\\\\192.168.1.104\\HP LaserJet Professional M1132 MFP"; //TES PRINTER

		//$alamat = "\\\\192.168.1.104\\Epson LX-300+ (Copy 1)"; //TES PRINTER RC, dot matrix 2
		
		// /* write the text to the print job */
		$handle = printer_open($alamat);
		// var_dump($handle);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_skdp_langsung");
		printer_start_page($handle);



		
		/* ====== data_skdp ====== */
		$font_h_pasien = 70;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 36, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		
		function tulis($handle_my, $x, $y, $row_dt_pasien, $text_my){
			//printer_draw_text($handle_my, $text_my, $x, $y+(75*($row_dt_pasien-1)) );
			printer_draw_text($handle_my, $text_my, $x, $y+(90*($row_dt_pasien-1)) );
		}

		//jika  'U G D', dokter kosong
		if($data['dpjp'] == "dr. Lucky Dana Victory"){
			$data['dpjp'] = " ";
		}

		$tulisan = array(
				"                                          ".$data['billing'],
				"",
				"",
				"",
				"",
				"",
				"",
				"No.RM     : ".$data['norm']."         (Surat Kontrol / SKDP)**", //.$data['noSep'],
				"Nama      : ".$data['nama'],
				"Tgl.Lahir : ".$data['tglLahir'],
				"Klinik    : ".$data['provPerujuk'],
				"Diagnosa  : ",
				"",
				"1. Belum dapat dikembalikan ke FKTP :",
				"   1.",
				"   2.",
				"   3.",
				"2. Rencana tindak lanjut pada kunjungan selanjutnya :",
				"   1.",
				"   2.",
				"   3.",
				"[ ] Surat keterangn ini digunakan untuk kunjungan",
				"    selajutnya pada tanggal :",
				"[ ] Pasien dalam kondisi stabil dan dapat melanjutkan",
				"    perawatan kembali di FKTP",
				"[ ] Mohon skrining dan evaluasi ulang di FKTP untuk",
				"    kunjungan ke ............. pada tanggal:..........",
				"    dengan diagnosa:...................",
				"",
				"                          Sidoarjo, ".$data['tglSep'],
				"                                        DPJP",
				"",
				"",
				"                           ".$data['dpjp'],
				"",
				"* Mohon surat ini selalu dibawa saat berobat",
				"**Lingkari yang perlu",
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 100, 200, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\data_skdp ====== */

		//$margin_left_page = 100;
		$mt_start = 100;
		$y_font = 70; //50
		//$margin_top_page = 150;
		//$font_height = 70;


		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		$font = printer_create_font("Tahoma", 100, 50, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS. Citra Medika";
		printer_draw_text($handle, $text, 200, $mt_start+$y_font);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 100, 45, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "           SURAT KETERANGAN*";
		printer_draw_text($handle, $text, 200, $mt_start+(3*$y_font) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 100, 45, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "          No : ".$data['noskdp'];
		printer_draw_text($handle, $text, 200, $mt_start+(5*$y_font) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}

	public function tulis_loop($handle_my, $x, $y, $row_dt_pasien, $text_my, $spacing_enter){
		//printer_draw_text($handle_my, $text_my, $x, $y+(75*($row_dt_pasien-1)) );
		printer_draw_text($handle_my, $text_my, $x, $y+($spacing_enter*($row_dt_pasien-1)) );
	}

	// PRINTER BARU. UNTUK AKSES PASIEN CETAK LANGSUNG.
	public function cetak_skdp_langsung_termal($data){
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		$alamat = $this->printer['cetak_skdp_langsung_termal'];
		
		// /* write the text to the print job */
		$handle = printer_open($alamat);
		// var_dump($handle);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_skdp_langsung_termal");
		printer_start_page($handle);



		
		/* ====== data_skdp ====== */
		$font_h_pasien = 23; //25
		$font = printer_create_font("Lucida Console", $font_h_pasien, 12, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		
		

		//jika  'U G D', dokter kosong
		if($data['dpjp'] == "dr. Lucky Dana Victory"){
			$data['dpjp'] = " ";
		}

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
		


		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}


	// TIDAK DIPAKAI
	public function cetak_langsung_skdp_antrian($data){
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		$alamat = $this->printer['cetak_skdp_langsung'];
		
		// /* write the text to the print job */
		$handle = printer_open($alamat);
		// var_dump($handle);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_skdp_langsung");
		printer_start_page($handle);



		
		/* ====== data_skdp ====== */
		$font_h_pasien = 70;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 36, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		
		function tulis($handle_my, $x, $y, $row_dt_pasien, $text_my){
			//printer_draw_text($handle_my, $text_my, $x, $y+(75*($row_dt_pasien-1)) );
			printer_draw_text($handle_my, $text_my, $x, $y+(90*($row_dt_pasien-1)) );
		}

		//jika  'U G D', dokter kosong
		if($data['dpjp'] == "dr. Lucky Dana Victory"){
			$data['dpjp'] = " ";
		}

		$tulisan = array(
				"                                          ".$data['billing'],
				"",
				"",
				"",
				"",
				"",
				"",
				"No.RM     : ".$data['norm']."         (Surat Kontrol / SKDP)*", //.$data['noSep'],
				"Nama      : ".$data['nama'],
				"Tgl.Lahir : ".$data['tglLahir'],
				"Klinik    : ".$data['provPerujuk'],
				"Diagnosa  : ",
				"",
				"1. Belum dapat dikembalikan ke FKTP :",
				"   1.",
				"   2.",
				"   3.",
				"2. Rencana tindak lanjut pada kunjungan selanjutnya :",
				"   1.",
				"   2.",
				"   3.",
				"[ ] Surat keterangn ini digunakan untuk kunjungan",
				"    selajutnya pada tanggal :",
				"[ ] Pasien dalam kondisi stabil dan dapat melanjutkan",
				"    perawatan kembali di FKTP",
				"[ ] Mohon screening dan evaluasi ulang ke klinik",
				"    ....................... pada tanggal:............",
				"    dengan diagnosa:..........................",
				"",
				"                            Sidoarjo, ".$data['tglSep'],
				"                                     DPJP",
				"",
				"",
				"                           ".$data['dpjp'],
				"*Lingkari yang perlu",
				"-----------------------------------------------------",
				"NOMOR ANTRIAN",
				"RS. Citra Medika",
				$data['billing'],
				"",
				"",
				$data['nosep'],
				"Tgl.Rujukan: ".$data['tglrujukan'],
				"Nama   : ".$data['nama'],
				"Dokter : ".$data['dpjp'],

				"Cetak : ".$data['tglrujukan'],
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 100, 200, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\data_skdp ====== */

		//$margin_left_page = 100;
		$mt_start = 100;
		$y_font = 70; //50
		//$margin_top_page = 150;
		//$font_height = 70;


		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		$font = printer_create_font("Tahoma", 100, 50, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS. Citra Medika";
		printer_draw_text($handle, $text, 200, $mt_start+$y_font);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 100, 45, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "           SURAT KETERANGAN";
		printer_draw_text($handle, $text, 200, $mt_start+(3*$y_font) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 100, 45, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "          No : ".$data['noskdp'];
		printer_draw_text($handle, $text, 200, $mt_start+(5*$y_font) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);


		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}

	public function cetak_sep_langsung($nama_printer,$data){
		//echo $nama_printer;
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

		// /* tulis dan buka koneksi ke printer */
		///////$alamat = "\\\\192.168.1.92\\HP LaserJet Professional P1102"; //TES PRINTER RM , LASER
		////////////$alamat = "\\\\192.168.1.100\\Canon LBP6030/6040/6018L"; //TES PRINTER APOTEK
		$alamat = $this->printer['cetak_sep_langsung']; //TES PRINTER APOTEK

		//$alamat = "\\\\192.168.1.104\\Epson LX-300+ (Copy 1)"; //TES PRINTER RC, dot matrix 2
		
		// /* write the text to the print job */  
		$handle = printer_open($alamat);
		// var_dump($handle);

		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
		printer_set_option($handle, PRINTER_PAPER_WIDTH, 70);
		printer_set_option($handle, PRINTER_SCALE, 50);
		//FIX//$handle = printer_open();
		printer_start_doc($handle, "cetak_sep_langsung");
		printer_start_page($handle);



		$margin_left_page = 100;
		$margin_top_page = 50;
		$font_height = 70;

		//printer_create_font(face, height, width, font_weight, italic, underline, strikeout, orientation);
		//$font = printer_create_font("Tahoma", 150, 80, 400, false, false, false, 0);
		$font = printer_create_font("Tahoma", 100, 50, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "SURAT ELEGIBILITAS PESERTA";
		printer_draw_text($handle, $text, 400, $margin_top_page);	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);

		$font = printer_create_font("Tahoma", 100, 50, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = "RS Citra Medika";
		printer_draw_text($handle, $text, 400, (3*$margin_top_page) );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);



		$font = printer_create_font("Tahoma", 120, 55, 600, false, false, false, 0);
		printer_select_font($handle, $font);
		$text = $data['noSep'];
		printer_draw_text($handle, $text, 1000, 300 );	////printer_draw_text(printer_handle, text, x, y);
		printer_delete_font($font);




		/* ====== data_sep1 ====== */
		$font_h_pasien = 70;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 45, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);

		
		function tulis($handle_my, $x, $y, $row_dt_pasien, $text_my){
			printer_draw_text($handle_my, $text_my, $x, $y+(75*($row_dt_pasien-1)) );
		}

		$tulisan = array(
				"No.SEP         : ", //.$data['noSep'],
				"",
				"Tgl.SEP        : ".$data['tglSep'],
				"No.Kartu       : ".$data['noKartu'],
				"Nama Peserta   : ".$data['nama'],
				"Tgl.Lahir      : ".$data['tglLahir'],
				"No.Telepon     : ".$data['noTelepon'],
				"Poli Tujuan    : ".$data['poli'],
				"Faskes Perujuk : ".$data['provPerujuk'],
				"Diagnosa Awal  : ".$data['diagnosa'],
				"Catatan        : ".$data['catatan'],
				"",
				"",
				"Saya menyetujui BPJS Kesehatan menggunakan informasi medis pasien jika diperlukan.",
				"SEP Bukan sebagai bukti penjamin peserta.",
				"",
				"Cetakan .....",
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 200, 400, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\data_sep1 ====== */


		/* ====== data_sep2 ====== */
		$font_h_pasien = 70;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 45, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);


		$tulisan = array(
				"Peserta         : ".$data['jnsPeserta'],
				"COB             : ".$data['asuransi'],
				"Jns.Rawat       : ".$data['jnsPelayanan'],
				"Kls.Rawat       : ".$data['kelasRawat'],
				"Penjamin        : ".$data['penjamin']
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 2500, 400, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\data_sep2 ====== */




		/* ====== ttd ====== */
		$font_h_pasien = 70;
		$font = printer_create_font("Lucida Console", $font_h_pasien, 45, PRINTER_FW_NORMAL, false, false, false, 0);
		printer_select_font($handle, $font);


		$tulisan = array(
				" Pasien/Keluarga Pasien",
				"",
				"",
				"",
				"________________________",
			);

		$tulisan_i = 0;
		foreach($tulisan as $tulisans){
			tulis($handle, 3500, 1700, $tulisan_i, $tulisans);
			$tulisan_i++;
		}

		printer_delete_font($font);
		/* ======\ttd ====== */




		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}

  



}



//============= NOTE ===============
// $dir = 'c:\\somedir';
// $file = 'myimage.bmp';

// if (is_dir($dir)) {
//    if($dhandle = opendir($dir)) {
//       $handle = printer_open();
//       printer_start_doc($handle, "My Document");
//       printer_start_page($handle);

//       printer_draw_bmp($handle, $file, 1, 1);

//       printer_end_page($handle);
//       printer_end_doc($handle);
//       printer_close($handle);
//    }
//    closedir($dhandle);
// }


///=========================

// $handle = printer_open();
// printer_start_doc($handle, "My Document");
// printer_start_page($handle);

// printer_draw_bmp($handle, "c:\\image.bmp", 1, 1);

// printer_end_page($handle);
// printer_end_doc($handle);
// printer_close($handle);


//============= NOTE ===============


