<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tes extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function update_noka_mst_pasien($params){
		$q = "update xx_tes set nama='".$params['nama']."'  where NoRM='".$params['alamat']."'";

		$query = $this->db->query($q);
		return $this->db->affected_rows();
	}


	public function insert($data){
	    // $data = array(
	    //   "nis" => "ana",
	    //   "alamat" => "kenongo"
	    // );
	    
	    $this->db->insert('xx_tes', $data); // Untuk mengeksekusi perintah insert data
	  }

	public function edit($bill,$data){
	    // $data = array(
	    //   "nama" => 'afandi',
	    //   "alamat" => 'tulangan'
	    // );
	    
	    $this->db->where('bill', $bill);
	    $this->db->update('xx_tes', $data); // Untuk mengeksekusi perintah update data
	  }
  
  // Fungsi untuk melakukan menghapus data siswa berdasarkan NIS siswa
  public function delete($nis){
    $this->db->where('nis', $nis);
    $this->db->delete('siswa'); // Untuk mengeksekusi perintah delete data
  }







}
