<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_diagnosa extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }

  public function get_dx_by_ket($ket=null){
    $ket = rawurldecode($ket);
    
    $q = "SELECT td.NoBill, td.NoRM, td.diagnosaawal, da.Keterangan, rd.ICDKode, 
    COUNT(rd.ICDKode) AS nICD #, MAX(td.date)
    , td.date # DATE tidak bisa kalau ada GROUP BY
    FROM fotrdaftar td
    LEFT JOIN formdiagnosa rd ON rd.BillNo = td.NoBill
    LEFT JOIN fomstdiagnosaawal da ON da.Kode = td.diagnosaawal
    WHERE td.diagnosaawal <> 0
    AND td.FlagBill <> 4
    AND da.Keterangan IS NOT NULL
    AND rd.ICDKode IS NOT NULL
    #AND td.diagnosaawal = 1347
    AND da.Keterangan LIKE '%".$ket."%'
    GROUP BY rd.ICDKode
    ORDER BY da.Keterangan
    , rd.ICDKode
    , nICD DESC";
    return $this->db->query($q)->result_array();
  }
  
  public function get_dx_by_kodedxrs($kode=null){
    $q = "SELECT td.NoBill, td.NoRM, td.diagnosaawal, da.Keterangan, rd.ICDKode, 
    COUNT(rd.ICDKode) AS nICD #, MAX(td.date)
    , td.date # DATE tidak bisa kalau ada GROUP BY
    FROM fotrdaftar td
    LEFT JOIN formdiagnosa rd ON rd.BillNo = td.NoBill
    LEFT JOIN fomstdiagnosaawal da ON da.Kode = td.diagnosaawal
    WHERE td.diagnosaawal <> 0
    AND td.FlagBill <> 4
    AND da.Keterangan IS NOT NULL
    AND rd.ICDKode IS NOT NULL 
    AND rd.ICDKode <> ''
    AND td.diagnosaawal = '".$kode."'
    GROUP BY rd.ICDKode
    ORDER BY da.Keterangan
    , nICD DESC
    , rd.ICDKode
    ";
    return $this->db->query($q)->result_array();
  }

}