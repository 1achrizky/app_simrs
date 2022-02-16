<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftarmandiri extends CI_Controller {
	public function __construct(){
		parent::__construct();

		$page_no_session = [
			'daftaronline', 'px_cetak_antrian', 
			'px_cetak_antrian_rc', 'antrian_rc_board'];
		$page_status = true;

		for ($i=0; $i < count($page_no_session); $i++) { 
			if($this->uri->segment(2) == $page_no_session[$i]){
			// if(in_array($this->uri->segment(2), $page_no_session[$i])){
				$page_status = false;
			}
		}
		
		if($page_status){
			$this->mainlib->logged_in();
		}
	}
	
	// public function index(){
	// 	$this->load->view($this->uri->segment(1)."/"."bpjs_umum");
	// }

	// public function scanrujukan(){
	// 	$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	// }

	// public function main(){
	// 	$this->load->helper("form");
	// 	$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	// }

	// public function sep_create(){
	// 	// print_r($_POST);
	// 	if( !empty($this->input->post("btn_daftarrj")) ){
	// 		$data = array(
	// 			"pasien_nama" => $this->input->post("pasien_nama"),
	// 			"pasien_umur" => $this->input->post("pasien_umur"),
	// 			"cari_jadok"  => $this->input->post("cari_jadok")
	// 		);
	// 		$this->load->view("vclaim/sep_create", $data);
	// 	}else{
	// 		echo "Failed load page...";
	// 	}
		
	// }

	// public function admin(){
	// 	$data = array(
	// 			"username"	=> $this->session->username
	// 		);
	// 	$this->load->view("template/header" , $data);
	// 	$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2) , $data);
	// 	$this->load->view("template/footer");
	// }
	

	// public function booking(){
	// 	$data = array(
	// 			"username"	=> $this->session->username
	// 		);
	// 	$this->load->view("template/header" , $data);
	// 	$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2) , $data);
	// 	$this->load->view("template/footer");
	// }

	// public function daftar_pasienrj(){
	// 	$data = array(
	// 			"username"	=> $this->session->username
	// 		);
	// 	$this->load->view("template/header" , $data);
	// 	$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2) , $data);
	// 	$this->load->view("template/footer");
	// }

	public function log_pendaftaranrj(){
		$data = array(
				"username"	=> $this->session->username
			);
		$this->load->view("template/header" , $data);
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2) , $data);
		$this->load->view("template/footer");
	}

	public function daftaronline(){

		$location = 'Location: '.base_url().'daftarmandiri/px_cetak_antrian';
		if(my_ip()['client'] == '192.168.1.93'){ header($location); exit; }		


		$this->load->view("template/header-lte-topnav");

		$this->load->model('m_daftarmandiri');
		$jadok = arr_repair($this->m_daftarmandiri->get_jadok_all() )['dtjs'];
		$penanggung = $this->m_daftarmandiri->gd_penanggung_cm(null);
		
		$sess = arr_repair( $this->session->userdata() );
		// echo '<pre>',print_r($sess),'</pre>'; exit;
		if(!isset($sess['username'])) $sess['username']='pasien';
		$data = [
			"jadok" => $jadok,
			"penanggung" => $penanggung,
			"username" => $sess['username'],
		]; // jadok, poli hari ini
		$this->load->view($this->uri->segment(1)."/daftaronline", $data);
	}

	public function px_cetak_antrian(){
		$this->load->view("template/header-lte-topnav");
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}
	
	public function px_cetak_antrian_book(){
		$this->load->view("template/header-lte-topnav");
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}
	



	public function antrian_book($norm=null, $tgl=null, $kodePoli=null){
		$this->load->model(['m_daftarmandiri']);
		$val = $this->m_daftarmandiri->antrian_book($norm, $tgl, $kodePoli);
		exit(json_encode($val));
	}
	
	public function get_klinik_bpjs(){
		$this->load->model(['m_daftarmandiri']);
		$val = $this->m_daftarmandiri->get_klinik_bpjs();
		exit(json_encode($val));
	}
	
	public function antrian_book_multiklinik($norm=null, $tgl=null){
		$this->load->model(['m_daftarmandiri']);
		$val = $this->m_daftarmandiri->antrian_book_multiklinik($norm, $tgl);
		exit(json_encode($val));
	}







	public function px_cetak_antrian_rc(){
		$this->load->model(['m_publik']);
		$db = $this->m_publik->select_nomor_antridaftar_max(date('Y-m-d'));

		$this->load->view("template/header-lte-topnav");
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2), $db);
		$this->load->view("template/footer-lte-topnav");
	}
	
	public function antrian_rc_board(){
		$this->load->view("template/header-lte-topnav");
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
		$this->load->view("template/footer-lte-topnav");
	}


	public function ttd(){
		$data = array(
				"username"	=> $this->session->username
			);
		$this->load->view("template/header-lte" , $data);
		$this->load->view("Daftarmandiri/".$this->uri->segment(2));
		$this->load->view("template/footer-lte");
	}


	





	public function file_template(){
		$data = array(
				"norm" => "123123",
				"tglSep" => "2018-08-13"
			);		
		$this->load->view("file_template/cetak_form_skdp", $data);
	}

	public function file_template_cetak_sep(){
		$data = array(
				"norm" => "123123",
				"tglSep" => "2018-08-13"
			);		
		$this->load->view("file_template/sep_cetak", $data);
	}

	public function export_pdf(){
		$data = [];
        //load the view and saved it into $html variable
        /////$html=$this->load->view('welcome_message', $data, true);
        $html=$this->load->view('devtry/tes', $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "output_pdf_name.pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");     
	}
	/* End of file welcome.php */
	/* Location: ./application/controllers/welcome.php */

	public function export_pdf_view(){
		$data = [];
		//$this->load->view('devtry/tes', $data, true); 
		// ada true, untuk export pdf. kalo di show, htmlnya ndak muncul. saat dihapus true nya, muncul.
		$this->load->view('devtry/tes', $data);
	}

	

}
