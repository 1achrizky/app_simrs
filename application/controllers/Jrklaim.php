<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jrklaim extends CI_Controller {
	public function __construct(){
		parent::__construct();		
		date_default_timezone_set("Asia/Bangkok");
		// $this->mainlib->logged_in();
	}


	public function db($class_name=null, $obj_name=null, $param=null, $param2=null, $param3=null, $param4=null, $param5=null){
		$this->load->model($class_name);
		
		$fx = new $this->$class_name;
		$data = $fx->$obj_name($param, $param2, $param3, $param4, $param5);
		echo json_encode($data);
		
  	}


 //  	public function update_verif($id=null, $verif=null){
	// 	$this->load->model('m_main');

	// 	if($verif == "checked"){
	// 		$upd = [
	// 			"verif" => $verif,
	// 			"verifDate" => date('Y-m-d'),
	// 			"verifTime" => date('H:i:s'),
	// 		];
	// 	}else{
	// 		$upd = [ "verif" => $verif ];
	// 	}
		
	// 	$data = $this->m_main->update( "jrlist", $upd, ["id"=>$id]);
	// 	echo json_encode($data);				
	// }

	public function update_verif($id=null, $verif=null){
		$this->load->model('m_main');

		$input = $this->input->post(NULL, TRUE);

		if($verif == "checked"){
			$upd = [
				"biayaAmbulanVerif" 	=> $input['biayaAmbulanVerif'],
				"biayaP3KVerif" 		=> $input['biayaP3KVerif'],
				"biayaPerawatanVerif" 	=> $input['biayaPerawatanVerif'],
				"noSurat"   => $input['noSurat'],
      			"lampiran"  => $input['lampiran'],
				"verif" 	=> $verif,
				"verifDate" => date('Y-m-d'),
				"verifTime" => date('H:i:s'),
			];
		}else{ // BATAL VERIF
			$upd = [ 
				"biayaAmbulanVerif" => 0,
				"biayaP3KVerif" 	=> 0,
				"biayaPerawatanVerif" => 0,
				"noSurat"  => '',
      			"lampiran" => '',
				"verif" => '',
			];
		}
			
		// $data = $this->m_main->update( "jrlist", ["verif" => $verif], ["id"=>$id]);
		$data = $this->m_main->update( "jrlist", $upd, ["id"=>$id]);
		echo json_encode($data);				
	}




	public function delete_px($id=null){
		$this->load->model('m_main');
		$data = $this->m_main->delete( "jrlist", ["id"=>$id]);
		echo json_encode($data);
		
	}
  


}