<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftarmandirirjpx extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->mainlib->logged_in();
	}

	public function index(){
		$this->load->view('daftarmandirirjpx/index');
		$this->load->view("template/footer");
	}


	
}