<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sdm extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }

  public function jadwal_pegawai_by_th_bln($tahun=null, $bulan=null){
    $q = "SELECT a.NIP, a.NAMA, d.Keterangan AS BAGIAN, a.DINAS, a.TANGGAL, a.date 
    FROM hrdabsensi a
    LEFT JOIN hrdmstdepartemensub AS d ON d.Kode=a.BAGIAN
    WHERE a.date like '".
    $this->db->escape_like_str($tahun)."-".
    $this->db->escape_like_str($bulan)."-%' ESCAPE '!'
    ORDER BY a.date ASC, BAGIAN ASC, a.NAMA ASC";
    // echo $q; exit;
    
    // $q = "SELECT a.NIP, a.NAMA, a.BAGIAN, a.DINAS, a.TANGGAL, a.date 
    // FROM hrdabsensi a
    // LEFT JOIN hrdmstdepartemensub AS d ON d.Kode=a.BAGIAN
    // WHERE a.date like '".$tahun."-".$bulan."-%'
    // ORDER BY a.date ASC, a.BAGIAN ASC, a.NAMA ASC";

    $query = $this->db->query($q)->result_array();
    return $query;
  }


  // // https://192.168.1.68/rscm/app_dev/main/db/m_sdm/keduluan_tarik_absen/2020-12-30
  // public function keduluan_tarik_absen($date=null){
  //   // ======= ERROR =========
  //   // proses query pertama bisa tereksekusi. Query kedua tidak bisa 
  //   // Call to a member function result_array() on boolean in C:\xampp\htdocs\rscm\app_dev\application\models\M_sdm.php on line 42

  //   // $q = "UPDATE hrd_abs_log SET active_flag=NULL WHERE fddate like '".
  //   //   $this->db->escape_like_str($date)."%'";
  //   // $query = $this->db->query($q)->result_array();    
    
  //   $q_abs = "UPDATE hrdabsensi 
  //     SET TANGGALIN=NULL, JAMIN=NULL, 
  //     TANGGALOUT=NULL, JAMOUT=NULL, KETERANGAN=NULL
  //     where date = ?";
  //   $query_abs = $this->db->query($q_abs,[$date])->result_array();


  //   $q = "UPDATE hrd_abs_log SET active_flag=NULL WHERE fddate like '".$date."%'";
  //   $query = $this->db->query($q)->result_array();

  //   return [ "log"=>$query, "absensi"=>$query_abs, ];

  //   // UPDATE hrd_abs_log set active_flag=NULL where fddate like '2020-12-30%'
  
  //   //   UPDATE hrdabsensi 
  //   //   SET TANGGALIN=NULL, JAMIN=NULL, 
  //   //   TANGGALOUT=NULL, JAMOUT=NULL, KETERANGAN=NULL
  //   //   where date = '2020-12-30'
  // }


  

}


