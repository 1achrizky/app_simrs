<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen extends CI_Controller {
	public function __construct(){
		parent::__construct();		
		date_default_timezone_set("Asia/Bangkok");
		$this->mainlib->logged_in();
  }

  public function dboard_mnj(){
    $this->load->model(['m_daftarmandiri', 'm_manajemen', 'm_bed']);
    
    $datenow = date('Y-m-d');
    $visit = $this->m_daftarmandiri->count_rirj_dboard();
    $bedri = $this->m_bed->cnt_info_tt_rs()['list'];
    $rj    = $this->m_manajemen->select_kunjunganrj_px_tiapklinik_by_rangehari($datenow, $datenow);
    $panel = $this->m_daftarmandiri->dboard_mnj_panelutama_today();

    $val = [
      "visit" => $visit,
      "bedri" => $bedri,
      "rj"    => $rj,
      "panel" => $panel,
    ];

    echo json_encode($val);
  }
  
  
  public function dboard_mnj_rj($date_start=null, $date_end=null){
    $this->load->model(['m_daftarmandiri', 'm_manajemen']);
    
    $dt_perklinik = $this->m_manajemen->select_kunjunganrj_px_tiapklinik_by_rangehari($date_start, $date_end);
    $dt_per_sp    = $this->m_daftarmandiri->select_kunjungan_px_to_sp_by_1hari($date_start, $date_end);
    $dt_penanggung= $this->m_daftarmandiri->select_kunjungan_px_penanggung_by_rangehari($date_start, $date_end);
    $dt_suku      = $this->m_daftarmandiri->select_kunjungan_px_demografi_suku_by_rangehari($date_start, $date_end);
    $dt_agama     = $this->m_daftarmandiri->select_kunjungan_px_demografi_agama_by_rangehari($date_start, $date_end);
    $dt_wilayah   = $this->m_daftarmandiri->select_kunjungan_px_demografi_kec_top10_by_rangehari($date_start, $date_end);
    
    $val = [
      "dt_perklinik"  => $dt_perklinik,
      "dt_per_sp"     => $dt_per_sp,
      "dt_penanggung" => $dt_penanggung,
      "dt_suku"       => $dt_suku,
      "dt_agama"      => $dt_agama,
      "dt_wilayah"    => $dt_wilayah,
    ];

    echo json_encode($val);
  }
  
  
  public function dboard_mnj_ri($date_start=null, $date_end=null){
    $this->load->model(['m_daftarmandiri', 'm_manajemen']);

    $dt_penanggungri= $this->m_daftarmandiri->select_kunjunganri_px_penanggung_by_rangehari($date_start, $date_end);
    $dt_kamar       = $this->m_daftarmandiri->select_kunjunganri_px_kmr_by_rangehari($date_start, $date_end);
    $dt_suku_ri     = $this->m_daftarmandiri->select_kunjunganri_px_demografi_suku_by_rangehari($date_start, $date_end);
    $dt_agama_ri    = $this->m_daftarmandiri->select_kunjunganri_px_demografi_agama_by_rangehari($date_start, $date_end);
    $dt_wilayah_ri  = $this->m_daftarmandiri->select_kunjunganri_px_demografi_kec_top10_by_rangehari($date_start, $date_end);
    $res_dx         = $this->m_daftarmandiri->select_kunjunganri_px_dx_top10_by_rangehari_n($date_start, $date_end);
    
    $val = [
      "dt_penanggungri" => $dt_penanggungri,
      "dt_kamar"        => $dt_kamar,
      "dt_suku_ri"      => $dt_suku_ri,
      "dt_agama_ri"     => $dt_agama_ri,
      "dt_wilayah_ri"   => $dt_wilayah_ri,
      "dt_dx_ri"        => $res_dx,
    ];

    echo json_encode($val);
  }

  public function select_kunjunganrj_px_tiapklinik_by_rangehari($date_start=null, $date_end=null, $download=null){
		$this->load->model('m_manajemen');
		$query = $this->m_manajemen->select_kunjunganrj_px_tiapklinik_by_rangehari($date_start, $date_end, $download);
		
    if($download){
			// >>> DOWNLOAD EXCEL STRING
			$set = setting_excel_table('dl_xls_lap_kunjungan_rj_tiap_klinik');
			$filename = "Lap Kunjungan RJ Klinik - ".$date_start."_".$date_end;
	    exe_xls($query, $set, $filename);
		}else{
			echo json_encode($query);
		}
    
	}


}