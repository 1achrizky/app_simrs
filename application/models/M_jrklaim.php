<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jrklaim extends CI_Model{
	public function __construct(){
		parent::__construct();

		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		
		$this->load->database();
	}
	
	public function select_list_klaim($date=null){
		// $q = "SELECT * FROM jrlist	WHERE kode='".$kd_tindakan."'";
		$q = "SELECT * FROM jrlist";
		$query = $this->db->query($q)->result_array();
		return $query;
	}

	public function select_list_klaim_by_verif($verif=null){
		$q = "SELECT * FROM jrlist WHERE verif='".$verif."'";
		$query = $this->db->query($q)->result_array();
		return $query;
	}

	public function select_klaim_by_nobill($nobill=null){
		$q = "SELECT * FROM jrlist WHERE nobill='".$nobill."'";
		$query = $this->db->query($q)->result_array();
		return $query;
	}





	// ======
	public function select_user_rscmon($data=null){
		// $select = "*";
		// $select = ['u.id', 'u.noreg', 'u.username', 
		// 	'd.Kode AS departemenkode', 
		// 	'd.Keterangan AS departemen', 
		// 	'ds.Kode AS departemensubkode', 
		// 	'ds.Keterangan AS departemensub', 
		// ];

		$select = ['u.id', 'u.noreg', 'u.username', ];
		$this->db->select($select);
		$this->db->from('xuser u');		
		// $this->db->join('hrdmstkaryawan mk', 'mk.kode=u.noreg', 'left');
		// $this->db->join('hrdmstdepartemen d', 'd.Kode=mk.departemen', 'left');
		// $this->db->join('hrdmstdepartemensub ds', 'ds.Kode=mk.departemensub', 'left');
		// $this->db->order_by('u.username ASC');
		// $this->db->order_by('d.Kode ASC, ds.Kode ASC, u.noreg ASC');
		$query = $this->db->get();

		return $query->result();
	}
	// ======




}