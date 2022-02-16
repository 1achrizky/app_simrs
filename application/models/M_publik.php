<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_publik extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


  public function select_nomor_antridaftar_max($date=null){
    $q = "SELECT nomor from antridaftar WHERE date = '".$date."'	ORDER BY nomor desc	LIMIT 1";
    $query = $this->db->query($q)->result_array();
    $nominal = (count($query)>0) ?  (int)$query[0]['nomor'] : 0;

    function nom($nominal){
      $bilang = terbilang( $nominal );
      $kata 	= explode(" ", $bilang);
      $val = [
        "nominal" 	=> $nominal,
        "terbilang" => $bilang,
        "kata" 			=> $kata,
        "nkata" 		=> count($kata),			
      ];
      return $val;
    }

    $res['now'] = nom($nominal);
    $res['next'] = nom($nominal+1);
    return $res;
  }

}