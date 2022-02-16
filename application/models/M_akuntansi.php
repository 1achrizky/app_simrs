<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_akuntansi extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }

  public function lap_verif_inacbg($tahun=null, $bulan=null, $status=null){
    $q = "SELECT * FROM fotrinacbg
      WHERE Tahun =? AND Bulan =? AND Status=?
      ORDER BY Nobill";
    $query = $this->db->query($q, [$tahun, $bulan, $status])->result_array();
    return $query;
  }
  
  public function count_verif_inacbg($tahun=null, $bulan=null, $status=null){
    $q = "SELECT COUNT(Nobill) AS count FROM fotrinacbgx WHERE Tahun =? AND Bulan =? AND Status=?";
    $query = (int)$this->db->query($q, [$tahun, $bulan, $status])->row_array()['count'];
    return $query;
  }

}