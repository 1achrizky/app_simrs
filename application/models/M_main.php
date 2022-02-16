<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_main extends CI_Model{
	public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		
		$this->load->database();
	}


	public function update($table=null, $arr_data=null, $where=null){
		$this->db->update($table, $arr_data, $where);
		// $this->db->where('id',$id);
  //       $this->db->update('users',$value)
	}

	// public function update_batch($table=null, $arr_data=null, $value=null, $batch_size=null){
	public function update_batch($table=null, $arr_data=null, $value=null){
		$this->db->update_batch($table, $arr_data, $value);
	}

	public function insert($table=null, $arr_data=null){
		$exe = $this->db->insert($table, $arr_data);

		$num_inserts = $this->db->affected_rows();
		// $errNo   = $this->db->_error_number();
		// $errMess = $this->db->_error_message();

		if($num_inserts){
			$metaData = [
				"code" 		=> 200,
				"status" 	=> "success",
				"message" => "OK",
			];
		}else{
			$metaData = [
				"code" 		=> 201,				
				"status" 	=> "failed",
				"message" => $this->db->_error_number()." - ".$this->db->_error_message(),
			];
		}

		return $metaData;
	}
	

	// public function insert_formpost($table=null, $arr_data=null){

	// 	$exe = $this->db->insert($table, $arr_data);

	// 	$num_inserts = $this->db->affected_rows();

	// 	if($num_inserts){
	// 		$metaData = [
	// 			"code" 		=> 200,
	// 			"status" 	=> "success",
	// 			"message" => "OK",
	// 		];
	// 	}else{
	// 		$metaData = [
	// 			"code" 		=> 201,				
	// 			"status" 	=> "failed",
	// 			"message" => $this->db->_error_number()." - ".$this->db->_error_message(),
	// 		];
	// 	}

	// 	return $metaData;
	// }
	

	public function insert_batch($table=null, $arr_data=null){
		$this->db->insert_batch($table, $arr_data);
	}

	public function delete($table=null, $where=null){
		// $this->db->where('id', $data['id']);
	 	// $this->db->delete('mutumst');
		$this->db->where($where);		
	  $this->db->delete($table);
	}


	public function db_version(){
		return $this->db->query('SELECT @@version AS version')->result_array()[0];
	}

	
  
}