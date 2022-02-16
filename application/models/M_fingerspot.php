<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_fingerspot extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }

  public function tb_device(){
    $q = "SELECT * FROM tb_device";
    $query = $this->db->query($q)->result_array();
    return $query;
  }

}