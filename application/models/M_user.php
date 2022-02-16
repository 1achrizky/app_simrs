<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function user_register($input){
		$this->load->helper('site_helper');
		$enCrypt_password = bCrypt($input['password'], 12);
		$array_user = array(
				'id' 		=> '',
				'noreg' 	=> $input['noreg'],
				'username' 	=> $input['username'],
				'password' 	=> $enCrypt_password,
				'level' 	=> $input['level'],
				'date' 		=> date('Y-m-d'),
				'time' 		=> date('H:i:s')
			);
		$this->db->insert("xuser", $array_user);
	}

	public function update($data=null){
		$this->db->where($data['where']);
		$this->db->update($data['table'], $data['arr_data']);
	}

	public function exist_row_check($field,$data){
		$this->db->where($field,$data);
		$this->db->from('xuser');
		$q = $this->db->get();
		return $q->num_rows();
	}

	public function get_user_detail($username){
		$this->db->where("username", $username);
		$q = $this->db->get('xuser');

		if($q->num_rows() >0){
			$data = $q->row();
			$q->free_result();
		}else{
			$data = NULL;
		}
		return $data;
	}

	public function get_userakses_detail($id_user=null, $pageurl=null){		
		$select = "*";
		$this->db->select($select);
		$this->db->from('xuserakses');
		$this->db->where("id_user='".$id_user."' && pageurl='".$pageurl."'");
		$query = $this->db->get();
		// return $query->result();

		if($query->num_rows() >0){
			$data = $query->row();
			// echo "yes";
		}else{
			$data = NULL;
		}

		return $data;
	}
	
	
	public function get_userakses_menu($data=null){		
		$select = "filter_val";
		// $select = "*";
		$this->db->select($select);
		$this->db->from('xuserakses');
		// $this->db->where("id_user='".$data['id_user']."' && filter_name='menu_bo_sidebar'");
		$this->db->where("id_user='".$data['id_user']."' && filter_name='".$data['filter_name']."' && status=1");
		$query = $this->db->get();
		// return $query->result();

		$data = [];
		$data_js = [];

		if($query->num_rows() >0){
			$data_js = $query->result();
		}else{
			$data = NULL;
		}

		for($i=0; $i<count($data_js); $i++){
			array_push($data, $data_js[$i]->filter_val);
		}

		return $data;
	}
	
	
	public function get_user_rscmklaim($noreg=null){
		$select = ["coder_nik", "noreg", "username"];
		// $select = "*";
		$this->db->select($select);
		$this->db->from('rscmklaim_user');
		// $this->db->where("id_user='".$data['id_user']."' && filter_name='menu_bo_sidebar'");
		$this->db->where("noreg='".$noreg."'");
		$query = $this->db->get();
		// return $query->result();

		if($query->num_rows() >0){
			$data = $query->row();
			// echo "yes";
		}else{
			$data = NULL;
		}

		return $data;
	}

	public function list_karyawan(){
		$q = "SELECT kode, nama FROM hrdmstkaryawan WHERE flagaktif='0'";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	public function list_karyawan_det($param=null){
		$q = "SELECT k.* , 
			d.Keterangan AS departemenket,
			ds.Keterangan AS departemensubket
		FROM hrdmstkaryawan k 
		LEFT JOIN hrdmstdepartemen d ON d.Kode = k.departemen
		LEFT JOIN hrdmstdepartemensub ds ON ds.Kode = k.departemensub AND ds.Kodedepartemen=k.departemen
		WHERE k.flagaktif='0'
		AND (
			k.kode LIKE '%".$param."%' OR
			k.nama LIKE '%".$param."%' OR
			d.Keterangan LIKE '%".$param."%' OR
			ds.Keterangan LIKE '%".$param."%'
		)
		";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	public function list_karyawan_registered_app(){
		$q = "SELECT kode, nama 
			FROM hrdmstkaryawan mk
			-- LEFT JOIN xuser u ON u.noreg=mk.kode
			WHERE mk.flagaktif='0' AND mk.kode NOT IN (SELECT noreg FROM xuser)";
		$query = $this->db->query($q)->result_array();
		return $query;
	}


}
