<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grid extends CI_Controller {
  public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");

  }

  public function tes(){
    // require_once(realpath($_SERVER["DOCUMENT_ROOT"]) ."/phpGrid/conf.php"); // absolute path to conf.php
    require_once(APPPATH. 'libraries/phpGrid_Lite/conf.php'); // APPPATH is path to application folder
    // $data['phpgrid'] = new C_DataGrid("SELECT * FROM fotrdaftar", "NoBill", "fotrdaftar"); //$this->ci_phpgrid->example_method(3);
    // echo "<pre>",print_r($data['phpgrid']),"</pre>"; 
    // echo "<pre>",print_r($data['phpgrid']->display()),"</pre>"; 

    $dg = new C_DataGrid("SELECT * FROM fotrdaftar", "NoBill", "fotrdaftar"); //$this->ci_phpgrid->example_method(3);
    // $dg->display();
    echo "<pre>",print_r($dg),"</pre>";
    // $this->load->view('show_grid',$data);

  }
  
}