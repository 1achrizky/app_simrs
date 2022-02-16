<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_akreditasi extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }
  

	// public function insert_formpost_akinsiden($table=null, $arr_data=null){

  //   // $arr_data = [
  //   // 	"nobill" => "BL200130",
  //   // 	// "gender" => "L",
  //   // 	"asuransi" => "UMUM",
  //   // 	// "tgl_masuk" => "2020-01-24",
  //   // 	"tglIns" => "2020-01-25",
  //   // 	"insiden" => '',
  //   // 	"grade" => "Hijau",
  //   // 	"kronologis" => "tes kronologis insiden",
  //   // 	"jnsInsiden" => "KNC",
  //   // 	"pelapor" => "Karyawan",
  //   // 	"lokasiKejadian" => '',
  //   // 	"lokasiInsiden" => '',
  //   // 	"unitPenyebab" => '',
  //   // 	"dampak" => "Kematian",
  //   // 	"tdknStlhKejadian" => '',
  //   // 	"pelakuTindakan" => '',
  //   // 	"insidenSerupa" => '',
  //   // 	"analisaRCA" => '',
  //   // ];
  //   // array_push($arr_data, "user"=>$)
  //   $exe = $this->db->insert($table, $arr_data);

  //   $num_inserts = $this->db->affected_rows();

  //   if($num_inserts){
  //     $metaData = [
  //       "code" 		=> 200,
  //       "status" 	=> "success",
  //       "message" => "OK",
  //     ];
  //   }else{
  //     $metaData = [
  //       "code" 		=> 201,				
  //       "status" 	=> "failed",
  //       "message" => $this->db->_error_number()." - ".$this->db->_error_message(),
  //     ];
  //   }

  //   return $metaData;
  // }



  
  
  // USE
  public function lap_insiden($datestart=null, $dateend=null){
    $q = "SELECT i.*, 
      IF( ISNULL(td.Nama), '', td.Nama) AS Nama, 
      IF( ISNULL(td.NoRM), '', td.NoRM) AS NoRM, 
      td.TanggalMasuk, td.Sex,
      ml.Keterangan AS lokasiInsidenKet,

      IF(i.grade='Biru', 1, 0) AS B,
      IF(i.grade='Hijau', 1, 0) AS H,
      IF(i.grade='Kuning', 1, 0) AS K,
      IF(i.grade='Merah', 1, 0) AS M,
      #IF(i.jnsAsuh='UG', 'IGD', i.jnsAsuh) AS jnsAsuhan,
      CONCAT(i.tglIns, ' ', i.jamIns) AS datetime
      FROM akinsiden i
      LEFT JOIN fotrdaftar td ON td.NoBill=i.nobill
      LEFT JOIN fomstlokasi ml ON ml.Kode=i.lokasiInsiden
      WHERE i.tglIns >='".$datestart."' AND i.tglIns <='".$dateend."'
      ORDER BY i.nobill";
    $query = $this->db->query($q)->result_array();
    return $query;
  }
}
