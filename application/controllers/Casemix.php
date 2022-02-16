<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Casemix extends CI_Controller {
	protected $public_ip = '';

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
  }

  public function first_load_eclaim(){
    $this->load->model(["m_daftarmandiri"]);
    $js_dpjp_new = $this->m_daftarmandiri->get_dokter_luar_dalam("ALL");
    $js_ckeluar = $this->m_daftarmandiri->get_carakeluar();

    $val = [
      "js_dpjp_new" => $js_dpjp_new,
      "js_ckeluar" => $js_ckeluar,
    ];

    echo json_encode($val);
  }
  
  
  public function r_historyDiagnosa($nobill=null){
    $this->load->model("m_casemix");
    $val = $this->m_casemix->historyDiagnosa($nobill);
    echo json_encode($val);
  }

  public function billing_enter_eclaim($nobill=null){
    $this->load->model(["m_daftarmandiri", "m_casemix"]);

    $biopx    = $this->m_casemix->bioPasienByBill($nobill);
    $payment= $this->m_casemix->get_payment_by_billing($nobill);
    // $dtpxsegment = $this->m_casemix->select_pxsegment_by_bill($nobill);    

    $trf_rs_ina  = $this->m_casemix->select_tarif_rs_for_ina($nobill);
    $cariObatBill= $this->m_casemix->cariObatBill($nobill);

    $norm = $biopx['NoRM'];
    $historyDiagnosa= $this->m_casemix->historyDiagnosa($norm);
    
    $js_histo    = $this->m_casemix->get_list_histori_diag_by_nobill($nobill); // cx_diagri
    $js_pxritarif= $this->m_casemix->get_pantauritarif_by_nobill($nobill);

    $bpjs = null;
    
    if($biopx['nosep'] == '' || $biopx['nosep'] == 0){
    }else{
      $path = "SEP/".$biopx['nosep'];
      $js_sep = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");
      
      $path = "sep/cbg/".$biopx['nosep'];
      $js_sepcbg = $this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");


      $bpjs = [
        "js_sep"    => $js_sep,
        "js_sepcbg" => $js_sepcbg,
      ];
    }
    

    $val = [
      "rs"        => [
        // "dtpx"    => $dtpx,
        "biopx"     => $biopx,
        "payment"   => $payment,
        "trf_rs_ina"=> $trf_rs_ina,
        "cariObatBill"  => $cariObatBill,
        "historyDiagnosa"  => $historyDiagnosa,
        "js_histo"      => $js_histo,
        "js_pxritarif"  => $js_pxritarif,
      ],
      "bpjs" => $bpjs,
    ];

    echo json_encode($val);
  }


  
  public function tes($nobill){
    $this->load->model("m_daftarmandiri");
    $fd_pxdaf = $this->m_daftarmandiri->formdiagnosa_pxdaftar($nobill)[0];
    echo json_encode($fd_pxdaf); exit;
      
      $send = [
        "BillNo" => $nobill, 
        "BillStatusDaftar"=> $fd_pxdaf["StatusDaftar"],
        "TglMasuk" => $fd_pxdaf["TanggalMasuk"], 
        "TglKeluar" => $fd_pxdaf["TanggalKeluar"],
        "JamMasuk" => $fd_pxdaf["JamMasuk"], 
        "JamKeluar" => $fd_pxdaf["JamKeluar"],
        "RmNo" => $fd_pxdaf["NoRM"], 
        "Sex" => $fd_pxdaf["Sex"],
      ];

      $sendx = $send;
      unset($sendx['BillNo']);

      $val = [ $send, $sendx ];
      echo json_encode($val);

  }

  public function simpan_eklaimrs_rj(){
    $post = $this->input->post(null, true);
    $this->load->model(["m_main", "m_casemix"]);
    
    $upd_sep = $this->m_main->update("fotrdaftar", ["nosep"=>$post['sep']], ["NoBill"=> $post['nobill']] );
    $upd_noka = $this->m_main->update("fomstpasien", ["Barcode"=>$post['noka']], ["NoRM"=> $post['norm']] );
            
      $post_rmdx = [
        // "BillNo"  => $nobill,
        "BillStatusDaftar"  => $post['biopx']['StatusDaftar'],
        "TglMasuk"  => $post['biopx']['TanggalMasuk'], 
        "TglKeluar" => $post['biopx']['TanggalKeluar'],
        "JamMasuk"  => $post['biopx']['JamMasuk'],
        "JamKeluar" => $post['biopx']['JamKeluar'],
        "RmNo"  => $post['biopx']['NoRM'], 
        "Sex"   => $post['biopx']['Sex'],
        "RmUmurThn"   => $post['biopx']['UmurTahun'], 
        "RmUmurBln"   => $post['biopx']['UmurBulan'], 
        "RmUmurHari"  => $post['biopx']['UmurHari'],
        "Pendidikan"  => $post['biopx']['Pendidikan'], 
        "Pekerjaan"   => $post['biopx']['Pekerjaan'],
        "LokasiKode"  => $post['biopx']['Lokasi'],
        "DokterKode"  => $post['biopx']['Dokter'],
        "DokterType"  => $post['biopx']['typedokter'],

        "User"  => $this->session->userdata("username"), 
        "Date"  => date('Y-m-d'), 
        "Time"  => date('H:i:s'),
            
        "Anamnesa"  => $post['anamnesa'],
        "fisik"     => $post['fisik'],
        "DokterKode"  => $post['DokterKode'],
        "DokterNama"  => $post['DokterNama'],
        "TriageKode"  => $post['TriageKode'],
        "kodekasus"   => $post['kodekasus'],
        
        "ICDKode"   => $post['ICDKode'], //$diagArr4Rscm[0],
        "ICDKode2"  => $post['ICDKode2'], //$diagArr4Rscm[1],
        "ICDKode3"  => $post['ICDKode3'], // $diagArr4Rscm[2],
        "ICDKode4"  => $post['ICDKode4'], // $diagArr4Rscm[3],
        "ICDKode5"  => $post['ICDKode5'], // $diagArr4Rscm[4],
        "kodetindakan"  => $post['kodetindakan'], // $prosedurArr4Rscm[0],
        "kodetindakan2" => $post['kodetindakan2'], // $prosedurArr4Rscm[1],
        "kodetindakan3" => $post['kodetindakan3'], // $prosedurArr4Rscm[2],
        "kodetindakan4" => $post['kodetindakan4'], // $prosedurArr4Rscm[3]
      ];
    
    
    //cek FORMDIAGNOSA. Bila belum ada, insertkan. Bila ada, update.
    $c_rmdx = $this->m_casemix->count_rmdx_by_bill($nobill);
    if($c_rmdx > 0){
      $status_exe_rmdx = "update";
      $exe_rmdx = $this->m_main->update('formdiagnosa', $post_rmdx, ["BillNo" => $post['nobill'] ] );      
    }else{
      $status_exe_rmdx = "insert";
      $post_rmdx["BillNo"] = $post['nobill'];
      $exe_rmdx = $this->m_main->insert('formdiagnosa', $post_rmdx);
    }
    
    
    // url:"model_rscm.php?kode=diagnosa_tindakan_input",    
    // $ins_dx = $this->m_main->update('formdiagnosa', $post_rmdx, ["BillNo" => $post['nobill'] ] );

    $val = [
      "upd_sep"  => $upd_sep,
      "upd_noka" => $upd_noka,
      "status_exe_rmdx" => $status_exe_rmdx,
      "exe_rmdx" => $exe_rmdx,
      // "upd_pelengkap" => $upd_pelengkap,
    ];
    echo json_encode($val);
  }
  
  
  public function final_klaim($nobill=null){
    $this->load->model("m_daftarmandiri");
    $this->load->model("m_main");

    $input = $this->input->post(NULL, TRUE);
    $log   = [];
    $alert = [];    

    //--INSERT FORMDIAGNOSA
    $cek_rmdx = $this->m_daftarmandiri->formdiagnosa_cekada_bill( $nobill );
    
    // value log
    $vlog = [
      "label" => "select_cek",
      "req"   => null,
      "res"   => [
        "cek_rmdx"    => $cek_rmdx,
        // "c_rmdx_pxri" => $c_rmdx_pxri,
      ],
    ];
    array_push($log, $vlog);


    // TAMBAHAN. PINDAHAN DARI RSCM_KLAIM
    $fd_pxdaf = $this->m_daftarmandiri->formdiagnosa_pxdaftar($nobill)[0];

    if($input['statusRawatLabel'] == 'Rawat Jalan'){      
      $send = [
        "BillNo" => $nobill, 
        "BillStatusDaftar"=> $fd_pxdaf["StatusDaftar"],
        "TglMasuk" => $fd_pxdaf["TanggalMasuk"], 
        "TglKeluar" => $fd_pxdaf["TanggalKeluar"],
        "JamMasuk" => $fd_pxdaf["JamMasuk"], 
        "JamKeluar" => $fd_pxdaf["JamKeluar"],
        "RmNo" => $fd_pxdaf["NoRM"], 
        "Sex" => $fd_pxdaf["Sex"],
        // "User" =>, 
        // "Date"=>, 
        // "Time" =>,
        "RmUmurThn" => $fd_pxdaf["UmurTahun"], 
        "RmUmurBln" => $fd_pxdaf["UmurBulan"], 
        "RmUmurHari" => $fd_pxdaf["UmurHari"],
        "Pendidikan" => $fd_pxdaf["Pendidikan"],
        "Pekerjaan" => $fd_pxdaf["Pekerjaan"],
        // "LokasiKode" =>, 
        // "DokterKode"=>,
        // "DokterType" =>,

        // tambahan
        "LokasiKode"=> $input["LokasiKode"], // 0,
        "DokterKode"=> $input["dpjp_kode"],
        "DokterNama"=> $input["dpjp_nama"],
        "DokterType"=> $input["dpjp_type"],      
        "ICDKode"  => $input["ICDKode"],
        "ICDKode2" => $input["ICDKode2"],
        "ICDKode3" => $input["ICDKode3"],
        "ICDKode4" => $input["ICDKode4"],
        "ICDKode5" => $input["ICDKode5"],

        "Anamnesa" => $input["Anamnesa"],
        "Diagnosa" => $input["Diagnosa"],
        "Terapi" => $input["Terapi"], // LIST OBAT
        "KeadaanKeluarKode" => $input["KeadaanKeluarKode"],

        "kodetindakan"  => $input["kodetindakan"],
        "kodetindakan2" => $input["kodetindakan2"],
        "kodetindakan3" => $input["kodetindakan3"],
        "kodetindakan4" => $input["kodetindakan4"],
        "tindakanket"   => $input["tindakanket"],
        "fisik"         => $input["fisik"],
        "User" => $this->session->userdata("username"), //>>$_user_logged_in,
        "Date" => date('Y-m-d'),
        "Time" => date('H:i:s'),
      ];

    }else{ // 'Rawat Inap'
      //!!! utk bill yg di fotrdaftarri.dokterawal=20028, jangan dipakai
      $c_rmdx_pxri = $this->m_daftarmandiri->formdiagnosa_get_pxri_det( $nobill );

      $send = [
        "BillNo" => $nobill,
        "BillStatusDaftar" => $fd_pxdaf["StatusDaftar"],
        "TglMasuk"  => $fd_pxdaf["TanggalMasuk"],
        "TglKeluar" => $fd_pxdaf["TanggalKeluar"],
        "JamMasuk"  => $fd_pxdaf["JamMasuk"],
        "JamKeluar" => $fd_pxdaf["JamKeluar"],
        "RmNo"      => $fd_pxdaf["NoRM"],
        "RmUmurThn" => $fd_pxdaf["UmurTahun"],
        "RmUmurBln" => $fd_pxdaf["UmurBulan"],
        "RmUmurHari"=> $fd_pxdaf["UmurHari"],
        "Pendidikan"=> $fd_pxdaf["Pendidikan"],
        "Pekerjaan" => $fd_pxdaf["Pekerjaan"],
        "Sex"       => $fd_pxdaf["Sex"],
        "LokasiKode"=> 0,
        "DokterKode"=> $input["dpjp_kode"],
        "DokterNama"=> $input["dpjp_nama"],
        "DokterType"=> $input["dpjp_type"],
        
        "ICDKode"  => $input["ICDKode"],
        "ICDKode2" => $input["ICDKode2"],
        "ICDKode3" => $input["ICDKode3"],
        "ICDKode4" => $input["ICDKode4"],
        "ICDKode5" => $input["ICDKode5"],
  
        "KasusBL"    => $fd_pxdaf["KasusBL"],
        "KasusBLBln" => $fd_pxdaf["KasusBLBln"],
        "KasusBLTri" => $fd_pxdaf["KasusBLTri"],
        "KasusBLSms" => $fd_pxdaf["KasusBLSms"],
        "KasusBLThn" => $fd_pxdaf["KasusBLThn"],
  
        "Anamnesa" => $input["Anamnesa"],
        "Diagnosa" => $input["Diagnosa"],
        "Terapi" => $input["Terapi"], // LIST OBAT
        "KeadaanKeluarKode" => $input["KeadaanKeluarKode"],
  
        "KodeBuilding"    => $c_rmdx_pxri["fd_bed"]["KodeBuilding"],
        "KodeBuildingKet" => $c_rmdx_pxri["fd_bed"]["KodeBuildingKet"],
        "KodeLantai"    => $c_rmdx_pxri["fd_bed"]["KodeLantai"],
        "KodeLantaiKet" => $c_rmdx_pxri["fd_bed"]["KodeLantaiKet"],
        "KodeRuang"     => $c_rmdx_pxri["fd_bed"]["KodeRuang"],
        "KodeRuangKet"  => $c_rmdx_pxri["fd_bed"]["KodeRuangKet"],
        "KodeKelas"     => $c_rmdx_pxri["fd_bed"]["KodeKelas"],
        "KodeKelasKet"  => $c_rmdx_pxri["fd_bed"]["KodeKelasKet"],
        "KodeKelasLevel"=> $c_rmdx_pxri["fd_bed"]["KodeKelasLevel"],
        "KodeBed"       => $c_rmdx_pxri["fd_bed"]["KodeBed"],
        "KodeBedKet"    => $c_rmdx_pxri["fd_bed"]["KodeBedket"],
        "KodePelayanan" => $c_rmdx_pxri["fd_pxri"]["PelayananRI"],
        "KodePelayananKet" => $c_rmdx_pxri["fd_pxri"]["PelayananRIKet"],
  
        "kodetindakan"  => $input["kodetindakan"],
        "kodetindakan2" => $input["kodetindakan2"],
        "kodetindakan3" => $input["kodetindakan3"],
        "kodetindakan4" => $input["kodetindakan4"],
        "tindakanket"   => $input["tindakanket"],
        "fisik"         => $input["fisik"],
        "User" => $this->session->userdata("username"), //>>$_user_logged_in,
        "Date" => date('Y-m-d'),
        "Time" => date('H:i:s'),
      ];
    }
					

    // $ret = [
    //   "cek_rmdx"    => $cek_rmdx,
    //   "c_rmdx_pxri" => $c_rmdx_pxri,
    //   "send"        => $send,
    // ];
    // echo json_encode($ret); exit;

    

    if($cek_rmdx=='0'){ // Data tidak ada. Belum entri di RM Diagnosa.
      // array_push($log, "Data tidak ada. Belum entri di RM Diagnosa.");

      // // INSERT
      $jInsert = $this->m_main->insert('formdiagnosa', $send);
      $vlog = [
        "label" => "insert_formdiagnosa",
        "req"   => $send,
        "res"   => $jInsert,
      ];
      array_push($log, $vlog);

      // // UPDATE FLAGDIAGNOSA      
      $upd_td = $this->m_main->update('fotrdaftar', ["FlagDiagnosa"=>1], ["NoBill" => $nobill]);
      

      $vlog = [
        "label" => "update_flagdiagnosa",
        "req"   => null,
        "res"   => $upd_td,
      ];
      array_push($log, $vlog);

    }else{
      // update formdiagnosa
      // if($input['statusRawatLabel'] == 'Rawat Jalan'){
      //   unset($send['BillNo']); // hilangkan(destroy) array NoBill di $send
      //   $upd_td = $this->m_main->update('formdiagnosa', $send, ["BillNo" => $nobill]);      
      // }

      unset($send['BillNo']); // hilangkan(destroy) array NoBill di $send
      $upd_td = $this->m_main->update('formdiagnosa', $send, ["BillNo" => $nobill]);      
      
      $valert = [
        "label"   => "cek_rmdx != 0",
        "message" => "Data sudah pernah dientri di RM Diagnosa.",
      ];
      array_push($alert, $valert);

      // $this->my_error->err_my_ws_exit($alert, $log);
    }
    //\--INSERT FORMDIAGNOSA

    // exit;
    
    //--FINAL
    $final_ina = [
      "metadata" => [
        "method" => "claim_final"
      ],
      "data" => [
        "nomor_sep" => $input["final_ina"]["nomor_sep"],
        "coder_nik" => $input["final_ina"]["coder_nik"],
      ],
    ];

    $js_final_ina = $this->ws_eclaim->ws( "POST", json_encode($final_ina) );

    $vlog = [
      "label" => "bridging_send_final_ina",
      "req"   => $final_ina,
      "res"   => $js_final_ina,
    ];
    array_push($log, $vlog);
    //\--FINAL
    
    //--SEND_CLAIM_INDIVIDUAL
    $send_claim_indiv = [
      "metadata" => [
        "method" => "send_claim_individual"
      ],
      "data" => [
        "nomor_sep" => $input["final_ina"]["nomor_sep"],
      ],
    ];

    $js_send_claim = $this->ws_eclaim->ws( "POST", json_encode($send_claim_indiv) );

    $vlog = [
      "label" => "bridging_send_claim_indiv",
      "req"   => $send_claim_indiv,
      "res"   => $js_send_claim,
    ];
    array_push($log, $vlog);
    //\--SEND_CLAIM_INDIVIDUAL

                  
    $jPost = [
      "id_histori" => $input["id_histori"],
      "date_krs"   => $input["date_krs"],
      "proses"     => 1,
    ];
    
    $dt = $this->m_main->update('cx_daftarritarif', $jPost, ["nobill" => $nobill]);
    
    $vlog = [
      "label" => "update_cx_daftarritarif",
      "req"   => $jPost,
      "res"   => $dt,
    ];
    array_push($log, $vlog);


      // UPDATE TARIF INA
      $totalINA = $input["totalINA"];
      if($input['statusRawatLabel'] == 'Rawat Jalan'){ 
        $upd_td_trf_ina = $this->m_main->update('fotrdaftar', ["totalINA"=>$totalINA], ["NoBill" => $nobill]);
        
        $vlog = [ "label" => "upd_td_trf_ina", "req"=> null, "res"=> $upd_td_trf_ina,];
        array_push($log, $vlog);
      }else{      
        //SELECT field tarif_ina dari dx_terpilih
        // $js_totINA = _ajax("GET", "db/m_daftarmandiri/select_trf_ina_by_dx_pilih/"+nobill+"/"+id_histori, "");
        $js_totINA = $this->m_daftarmandiri->select_trf_ina_by_dx_pilih( $nobill, $input["id_histori"] );
        if($js_totINA["metaData"]["status"] == "failed"){
          $valert = [
            "label"   => "js_totINA -> FAILED",
            "message" => "ID diagnosa terpilih tidak sesuai.",
          ];
          array_push($alert, $valert);

          $this->my_error->err_my_ws_exit($alert, $log);
        }else{
          $upd_td_trf_ina = $this->m_main->update('fotrdaftar', ["totalINA"=>$totalINA], ["NoBill" => $nobill]);
          
          $vlog = [ "label" => "upd_td_trf_ina", "req"=> null, "res"=> $upd_td_trf_ina,];
          array_push($log, $vlog);    
        }
      }
    

    // INSERT
    $data_rec = [
      "data_utama" => [
        "nobill" => $nobill
      ],
      "data_paket" => $jPost,
    ];

    $jPost_tblrec = [
      "id"   => '',
      "app"  => 'bo/menu/casemix/pantauan_biaya_ri',
      "element" => $input["element"],
      "nama" => 'final_px_to_daftarritarif',
      "ket"  => 'Set Final Pasien di Daftar Tarif RI.',
      "data" => json_encode($data_rec), // JSON.stringify(data_rec),
      "user" => $this->session->userdata("username"),
			"date" => date('Y-m-d'),
			"time" => date('H:i:s'),
    ];

    $jInsert = $this->m_main->insert( "cx_rec", $jPost_tblrec);
    
    $vlog = [
      "label" => "insert_cx_rec",
      "req"   => $jPost_tblrec,
      "res"   => $jInsert,
    ];
    array_push($log, $vlog);



    $val = [
			"metaData" => [
				"code"   => 200,
				"status" => "success",
				"message" => "OK",
			],
			"response" => [
				"alert" => $alert,
        "log"   => $log,        
			],
		];
    echo json_encode($val);

  }





  // ===[ pindahan eclaim/rscm_klaim ]===

  // IGD : 0195R0280720V000233 - BL200702.0199
  //  RJ : 0195R0280720V000227 - BL200702.0194
  public function eclaimrj_billingEnter($nobill=null){
    $this->load->model(["m_casemix"]);
    $bio = $this->m_casemix->bioPasienByBill($nobill);

    $post_formdiagnosa = [
      "BillNo"  => $bio['nobill'],
      "BillStatusDaftar"  => $bio['StatusDaftar'],
      "TglMasuk"  => $bio['TanggalMasuk'], 
      "TglKeluar" => $bio['TanggalKeluar'],
      "JamMasuk"  => $bio['JamMasuk'], 
      "JamKeluar" => $bio['JamKeluar'],
      "RmNo"  => $bio['NoRM'], 
      "Sex"   => $bio['Sex'],
      "User"  => $this->session->userdata("username"),
      "Date"  => date('Y-m-d'), 
      "Time"  => date('H:i:s'),
      "RmUmurThn"   => $bio['UmurTahun'], 
      "RmUmurBln"   => $bio['UmurBulan'], 
      "RmUmurHari"  => $bio['UmurHari'],
      "Pendidikan"  => $bio['Pendidikan'], 
      "Pekerjaan"   => $bio['Pekerjaan'],
      "LokasiKode"  => $bio['LokasiKode'],
      "DokterKode"  => $bio['DokterKode'],
      "DokterType"  => $bio['DokterType']
    ];

    // JIKA NOBILL tidak benar(pengetikannya, jangan di insert)
    // $ins_formdiagnosa = $this->m_casemix->insert_formdiagnosa($nobill, $post_formdiagnosa);

    $historyDiagnosa      = $this->m_casemix->historyDiagnosa($bio['NoRM']);
    $detail_bill_tindakan = $this->m_casemix->detail_bill_tindakan($nobill);
    $cariTarif            = $this->m_casemix->cariTarif($nobill);
    $cariObatBill         = $this->m_casemix->cariObatBill($nobill);

    $val = [
      "bio" => $bio,
      "formdiagnosa" => [
        "request" => $post_formdiagnosa,
        // "response" => $ins_formdiagnosa,
      ],
      "historyDiagnosa" => $historyDiagnosa,
      "detail_bill_tindakan" => $detail_bill_tindakan,
      "cariTarif"       => $cariTarif,
      "cariObatBill"    => $cariObatBill,
    ];
    echo json_encode($val);


  }


  public function sepNokaReplace($nobill=null){
    $input = $this->input->post(NULL, TRUE);
    // echo json_encode($input); exit;
    $this->load->model(["m_casemix", "m_main"]);

    //nosep_replace
    $nosep_replace  = $this->m_main->update("fotrdaftar", ["nosep"=>$input['nosep']], ["NoBill"=>$nobill]);
    $noka_replace   = $this->m_main->update("fomstpasien", ["Barcode"=>$input['noka']], ["NoRM"=>$input['norm']]);

    $set = [
      "Anamnesa"  => $input['Anamnesa'],
			"fisik"     => $input['fisik'],
			"DokterKode"=> $input['DokterKode'],
			"DokterNama"=> $input['DokterNama'],
			"TriageKode"=> $input['TriageKode'],
			"kodekasus" => $input['kodekasus']
    ];
    $form_pelengkap_rscm = $this->m_main->update("formdiagnosa", $set, ["BillNo"=>$nobill]);

    $val = [
      "nosep_replace" => $nosep_replace,
      "noka_replace"  => $noka_replace,
      "form_pelengkap_rscm" => $form_pelengkap_rscm,
    ];
    echo json_encode($val);

  }


  public function btn_grouping($nobill=null){
    $input = $this->input->post(NULL, TRUE);
    $this->load->model(["m_casemix", "m_main"]);
    $set_claim = $this->ws_eclaim->ws("POST", json_encode($input['set_claim']) );

    $p_grouper = [
      "metadata" => [
        "method" => "grouper",
        "stage"	 => "1"
      ],
      "data"  => [
        "nomor_sep" => $input['set_claim']['data']['nomor_sep'],
      ],
    ];
    $grouper = $this->ws_eclaim->ws("POST", json_encode($p_grouper) );

    // update_totalINA
    $totalINA = $grouper['response']['cbg']['tariff'];
    $update_totalINA = $this->m_main->update("fotrdaftar", ["totalINA"=> $totalINA], ["NoBill"=> $nobill]);

    //[CEK RM DOUBLE]
    $p_get_claim_data = [
      "metadata" => [
        "method" =>"get_claim_data"
      ],
      "data" => [
        "nomor_sep" => $input['set_claim']['data']['nomor_sep'],
      ],
    ];
    $get_claim_data = $this->ws_eclaim->ws("POST", json_encode($p_get_claim_data) );


    $val = [
      "set_claim" => $set_claim,
      "grouper"   => $grouper,
      "totalINA"  => $totalINA,
      "update_totalINA"   => $update_totalINA,
      "p_get_claim_data"  => $p_get_claim_data,
      "get_claim_data"    => $get_claim_data,
    ];
    echo json_encode($val);
  }

  // ===[\pindahan eclaim/rscm_klaim ]===





  public function cov(){
    $url = 'https://api.covid19api.com/dayone/country/indonesia';

    // // ini_set("allow_url_fopen", 1);
    $json = file_get_contents($url);
    $res = json_decode($json,1);
    // print_r($json); exit;
    // // var_dump( json_encode(json_decode($json))  ); exit;

    // // $x = json_encode(json_decode($json)) ;
    // // $obj = json_decode($json);
    // // echo $obj->access_token;
    echo $res[1]['Confirmed']; exit;


    
    $ch = curl_init();
    // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
    // in most cases, you should set it to true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($result,1);

    // print_r($result);
    echo $res[0]['Country'];
    // $obj = json_decode($result);
    // echo $obj->access_token;

  }
}