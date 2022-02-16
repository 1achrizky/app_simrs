<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxReq extends CI_Controller {
	protected $public_ip = '';

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
    }
}