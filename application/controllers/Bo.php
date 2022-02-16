<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bo extends CI_Controller {
	protected $user_verify = false;
	protected $divisi = '';

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		// die('ini bo');
		$this->mainlib->logged_in();
	}
	
	public function index(){
		redirect(base_url("bo/menu/dashboard"));
	}

	public function indec(){
		// redirect(base_url("indec"));
		$this->load->view("indec");
	}
	
	public function page_not_found(){
		// redirect(base_url("indec"));
		$this->load->view("errors/html/myerror/page-not-found");
	}

	// ------------------------- MENU ---------------------------

	// public function upload_data_billboard(){
	public function menu($page=null){
		if($page==null) redirect(base_url("bo/menu/dashboard"));

		// jika file_exist tidak ada, redirect
		// }else{
		// 	redirect(base_url("bo/"));
		// 	// redirect(base_url());
		// }

		
		// $this->output->set_status_header('404');
		// echo "404 - Page not found. <br> Go <a href='".base_url("bo/menu/dashboard")."'>Home</a>";
		// // $this->load->view('error404');
		// // $this->load->view('errors/html/error_404', ["message"=> "Go to HOME!"]);
		// // // $this->load->view('errors/error404', ["message"=> "Go to HOME!"]);
		// exit;
			 
		$data=null;

		// echo $this->uri->segment(1); //controller name
		$sess = json_decode(json_encode($this->session->userdata), true); //array
		// echo "<pre>",print_r($sess),"</pre>"; // melihat semua data session user aktif


		//count num of segment. start 4.
		$segment = 0; //set awal, supaya tidak error do logika <get data XUSERAKSES>
		$segment_arr = [];		
		$pages = '';
		for($i=3; $i<10; $i++){
			// echo $this->uri->segment($i).' , ';	// CEK
			if( !$this->uri->segment($i)){
				break;
			}else{
				$segment = $i; // final loop will get max segment
				// $page .= '/'.$this->uri->segment($segment);
				$segment_arr[] = $this->uri->segment($segment);
			}
		}
		
		$pages = join('/', $segment_arr);

		//get data XUSERAKSES by id_user & pageurl
		// if($segment>=4){ 
		// echo $segment;
		if($segment>=3){ // REPAIR: 2020.09.18 
			// echo $page; 	// CEK
			$this->load->model('m_user');
			$result = $this->m_user->get_userakses_detail($sess['id'], $this->uri->segment($segment) );
			// echo json_encode($result);
			$js_uakses = json_decode(json_encode($result), true);
			$sess['uakses_det'] = $js_uakses;

			//melihat session
			// echo "<pre>",print_r($sess),"</pre>";	
			
			// KHUSUS CONTROLLER AKSES 'BO/MENU'
			$data = $this->mainlib->page_onload($pages);
			// echo "<pre>",print_r($data),"</pre>";
		}
		

		// BATASAN AKSES URL PAGE [2021.10.02]
		// echo "<pre>",print_r($sess['menu_url_li']),"</pre>";	
		$url_will_open = base_url()."bo/menu/".$pages;
		// echo $url_will_open;
		if(!in_array($url_will_open, $sess['menu_url_li'] )){
			// [AKTIFKAN INI, UTK BATASAN USER ACCESS] die('Anda (<strong>'.$sess["username"].'</strong>) tidak diizinkan mengakses halaman ini. Kembali ke <a href="'.base_url().'">Home</a>.');
			
			// $this->load->view("template/header-lte" , $sess);
			// // $this->load->view("bo/menu/".$pages, $data);
			// echo('Anda tidak diizinkan mengakses halaman ini. Kembali ke <a href="'.base_url().'">Home</a>.');
			// $this->load->view("template/footer-lte");
		}
		// \BATASAN AKSES URL PAGE

		// $fullpage = base_url().'bo/menu/'.$page;
		// echo '<br>'.$fullpage;//
		// masuk ke IP MONITORING
		

		// // MASUKKAN KE RECORD LOGIN
		$post_xrec = [
			'page'	=> $pages,
			'base_url' 	=> base_url(),
			'ip_client' => $sess['ip']['client'],
			'ip_server' => $sess['ip']['server'],
			'user' 			=> $sess["username"],
			'datetime' 	=> date('Y-m-d H:i:s'),
		];
	
		$this->load->model('m_main');
		$xrec = $this->m_main->insert('xrecpage', $post_xrec);


		$this->load->view("template/header-lte" , $sess);
		$this->load->view("bo/menu/".$pages, $data);
		$this->load->view("template/footer-lte");
			
	}
	// -------------------------\MENU ---------------------------

	
}