<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {
	public function __construct(){
		parent::__construct();		
		date_default_timezone_set("Asia/Bangkok");
		$this->mainlib->logged_in();
  }

  public function booking_cek_noka_enter($get_noka=null, $hariDaftar = null){
    $this->load->model('m_daftarmandiri');

    $errors = [];
    $success = [];
    $tglRujukan = null;
    $cek_rjk_aktif_book = null;

    $jsPxCm = arr_repair($this->m_daftarmandiri->gd_pasien_rscm($get_noka));
    // echo json_encode($jsPxCm); exit;
    
		$statusBL = $this->m_daftarmandiri->get_st_bill_open_rm_by_norm_n( $jsPxCm['datajs'][0]['NoRM'] ) ;
		// $_a_js_mrs = $this->m_daftarmandiri->get_st_px_mrs_by_norm( $jsPxCm['datajs'][0]['NoRM'] ) ;
		$js_mrs = $this->m_daftarmandiri->get_st_px_mrs_by_norm( $jsPxCm['datajs'][0]['NoRM'] )['datajs'] ;
    // echo print_r($statusBL); exit;
    if($statusBL['st_bill_rm'] == 'open'){
      $error = error("statusBL", "danger", "", $statusBL['message']);
      array_push($errors, $error);
    }

    // ---- cek rujukan ada/tidak
    // ajax_bpjs11/rujukan_multirecord
    $path = "Rujukan/List/Peserta/".$get_noka;
    $JS_rjk_multi = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");
    
    $_bpjs_syarat_rjk = 1;
    if($JS_rjk_multi['metaData']['code'] == 201){ // rujukan tidak ada
      $error = error("multi_rjk", "danger", "", $JS_rjk_multi['metaData']['message']);
      array_push($errors, $error);
      
    }else if($JS_rjk_multi['metaData']['code'] == 200){ //SUKSES
      // console.log('Peserta BPJS boleh didaftarkan.');
      $tglRujukan = $JS_rjk_multi['response']['rujukan'][0]['tglKunjungan'];
      $cek_rjk_aktif_book = cek_rujukan_aktif_booking($tglRujukan, $hariDaftar);
      if($cek_rjk_aktif_book['status'] == 'AKTIF'){
        $error = error("status_rjk", "success", "", $cek_rjk_aktif_book['message']);
      }else{
        $error = error("status_rjk", "danger", "", $cek_rjk_aktif_book['message']);
      }
      array_push($errors, $error);
      
    }else{
      $error_message = "TIDAK TERDETEKSI SISTEM BPJS.";
      $error = error("multi_rjk", "danger", "", $error_message);
      array_push($errors, $error);
      $_bpjs_syarat_rjk = 0;
    }
    
    
    $path = "Peserta/nokartu/".$get_noka."/tglSEP/".date('Y-m-d');
    $px_bpjs = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");
    $tdk_ditanggung_bpjs = ($px_bpjs['response']['peserta']['statusPeserta']['keterangan'] == 'TIDAK DITANGGUNG')? 1:0;

    if($tdk_ditanggung_bpjs == 1){
      $error = error("tdk_ditanggung_bpjs", "danger", "", $px_bpjs['response']['peserta']['statusPeserta']['keterangan']);
      array_push($errors, $error);
    }

    // (+) TGL: 2020.08.19
    // KET: NON AKTIF DIAKHIR BULAN
    // KODE TIDAK BOLEH DIDAFTAR: {15,} 
    // KODE BOLEH DIDAFTAR: {0(AKTIF),} 
    if($px_bpjs['response']['peserta']['statusPeserta']['kode'] == '15'){
      $error = error("statusPesertaBpjs", "danger", "", "(".$px_bpjs['response']['peserta']['statusPeserta']['kode'].") ". $px_bpjs['response']['peserta']['statusPeserta']['keterangan']);
      array_push($errors, $error);
    }else{
      $error = error("statusPesertaBpjs", "info", "", "Untuk Pengecekan Status Peserta: (".$px_bpjs['response']['peserta']['statusPeserta']['kode'].") ". $px_bpjs['response']['peserta']['statusPeserta']['keterangan']);
      array_push($errors, $error);
    }

    $res = [
      "bridging" => [
        "multi_rjk"     => $JS_rjk_multi,
        "peserta_bpjs"  => $px_bpjs,
      ],
      "ws_rs" => [
        "gd_px_rscm" => $jsPxCm,
        "statusBL" => $statusBL,
        "js_mrs" => $js_mrs,
      ],
      "gen" => [
        "tglRujukan" => $tglRujukan,
        "cek_rjk_aktif_book" => $cek_rjk_aktif_book,
        "tdk_ditanggung_bpjs" => $tdk_ditanggung_bpjs,
        "status_bl" => $statusBL['st_bill_rm'],
        "_bpjs_syarat_rjk" => $_bpjs_syarat_rjk,
      ],
      "errors" => $errors,
      
    ];
    echo json_encode($res);
    // ----\cek rujukan ada/tidak

  }



}