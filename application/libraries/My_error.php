<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_error {
	public function err($err_code){
		//echo $err_code;
    // $code = 123;
    // $msg = 'ini error';

	    switch($err_code){
	    	case "e_reg_rc_0":
	    		$msg = "Nomor Rujukan Anda tidak ditemukan. Mohon cek kembali.";
	    		break;
	    	case "e_reg_rc_1":
	    		$msg = "Gagal Daftar! Kartu BPJS NON AKTIF. Silahkan cek kartu BPJS.";
	    		break;
	    	case "e_reg_rc_2":
	    		$msg = "Gagal Daftar! Rujukan FKTP lebih dari 1 bulan.";
	    		break;
	    	case "e_reg_rc_2a":
	    		$msg = "Gagal Daftar! Status Rujukan Tidak Terdefinisi.";
	    		break;
	    	// case "e_reg_rc_2b":
	    	// 	$msg = "Gagal Daftar! Rujukan SKDP tidak terdaftar di RS Citra Medika.";
	    	// 	break;
	    	case "e_reg_rc_3":
	    		$msg = "Gagal Daftar! Surat Keterangan Dalam Perawatan(SKDP) lebih dari 3 bulan.";
	    		break;
	    	case "e_reg_rc_3a":
	    		$msg = "Gagal Daftar! Rujukan lebih dari 3 bulan. <button name='btn_lewati_cetak_kartu' class='btn btn-success' style='padding:0px 5px;'>Daftar UGD</button>";
	    		break;
	    	case "e_reg_rc_4":
	    		$msg = "Gagal Daftar! Pasien belum pernah cetak kartu berobat rumah sakit.
	    				<button name='btn_lewati_cetak_kartu' class='btn btn-success' style='padding:0px 5px;'>Lewati</button>";
	    		break;
	    	case "e_reg_rc_5":
	    		$msg = "Gagal Daftar! Nomor Kartu JKN KIS belum terdaftar di sistem. ";
	    		break;
	    	case "e_reg_rc_5a":
	    		$msg = "Gagal Daftar! Nomor Kartu JKN KIS pasien ini kembar dengan pasien lain.";
	    		break;
	    	case "e_reg_rc_rjk_tdk_ada":
	    		// $msg = "Gagal Daftar! Rujukan tidak ada.
	    		// 		<button name='btn_lewati_rjk_tdk_ada' class='btn btn-success' style='padding:0px 5px;'>Lewati</button>";
	    		$msg = "Gagal Daftar! Rujukan tidak ada.";
	    		break;
	    	case "e_reg_rc_bukan_px_mrs":
	    		$msg = "Gagal Daftar! Bukan pasien MRS. Bila daftar UGD, klik: 
	    				<button name='btn_lewati_cetak_kartu' class='btn btn-success' style='padding:0px 5px;'>Daftar UGD</button>";
	    		break;
	    		
	    	// case "e_reg_rc_5b"://XXXXXGAK DIPAKE LOGIKA IKI
	    	// 	$msg = "Gagal Daftar! NOKA BPJS kembar. Ada lebih dari 1 pasien yang memiliki NOKA SAMA. ";
	    	// 	break;
	    }

	    $html = 
	    	'<div style="padding:5px; margin:2px 0px;">'.
	    		'<span name="'.$err_code.'" class="alert alert-danger" style="padding:5px 5px;">'.$msg.'</span>'.
	    	'</div>';

		$err =  array(
				'code' 	 => $err_code,
				'message'=> $msg,
				'html' 	 => $html
			);
		//	'Content-Type: application/x-www-form-urlencoded'  //jerone arrheader
		return json_encode($err);
		

	}
	
	public function err_my_ws_exit($alert=null, $log=null){
		// $alert = [];
		// $valert = [
		// 	"label"   => "js_totINA -> FAILED",
		// 	"message" => "ID diagnosa terpilih tidak sesuai.",
		// ];
		// array_push($alert, $valert);

		// $log = [];
		// $vlog = [
    //   "label" => "send_final_ina",
    //   "req"   => $final_ina, // $send,
    //   "res"   => $js_final_ina, // $jInsert,
    // ];
    // array_push($log, $vlog);

		$val = [
			"metaData" => [
				"code"   => 201,
				"status" => "failed",
			],
			"response" => [
				"alert" => $alert,
				"log"   => $log,
			],
		];
		echo json_encode($val); exit;
	}



}
