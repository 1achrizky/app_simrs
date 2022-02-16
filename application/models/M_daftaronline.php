<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_daftaronline extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  
    public function insert_file($filename, $title){
        $data = array(
	            'filename'      => $filename,
	            'title'         => $title
	        );
        $this->db->insert('xdaftar_ol', $data);
        return $this->db->insert_id();
    }

    public function get_files(){
	    return $this->db->select()
	            ->from('xdaftar_ol')
	            ->get()
	            ->result();
	}

}