<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	protected $username_temp, $user_detail_db;
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
	}

	public function register(){ // BELUM BISA
		$this->load->library("form_validation");
		//$this->form_validation->set_rules("username","Username","required");
		
		if($this->form_validation->run() == FALSE){
			$this->load->view($this->uri->segment(1)."/user_register");
		}else{
			// echo "RUN";
			$this->load->model("m_user");
			$this->m_user->user_register($this->input->post(NULL,TRUE)); //' or 1=1 '
			// $this->load->view($this->uri->segment(1)."/user_register_sukses");
		}
	}

	public function username_check($str){ // DARI TUTORIAL, DURUNG ISO
		$this->load->model("m_user");
		if($this->m_user->exist_row_check("username", $str) > 0){
			$this->form_validation->set_message("username_check", "Username sudah digunakan. Mohon ganti yang lain.");
			// echo "Sudah ada";
			return FALSE;
			// echo FALSE;
		}else{			
			// echo "Tidak ada";
			return TRUE;
		}
		// echo $str;

	}

	public function my_username_check($str){
		$this->load->model("m_user");
		if($this->m_user->exist_row_check("username", $str) > 0){ // echo "Sudah ada";
			// $this->form_validation->set_message("username_check", "Username sudah digunakan. Mohon ganti yang lain.");			
			$result = FALSE;
		}else{	// echo "Tidak ada";
			$result = TRUE;
		}
		echo json_encode($result);

	}


	public function login_tamu(){
		$this->load->library("session");
		$login_data = array(
				"username" 		=> 'tamu',
				"login_status" 	=> TRUE,
				"id"			=> 0,
				"menu_bo_sidebar" =>  ["dashboard", "perpustakaan"]
			);
		$this->session->set_userdata($login_data);
		redirect(base_url("bo"));
	}

	public function login(){
		$this->load->library("form_validation");
		$input = $this->input->post(NULL, TRUE);
		$this->username_temp = @$input["username"];

		$this->form_validation->set_rules("username", "Username", "required");
		$this->form_validation->set_rules("password", "Password", "required|callback_password_check");

		if($this->form_validation->run() == FALSE ){
			$this->load->view("login");
		}else{
			// load user_menu_akses
			$input_akses_cek = [
				'id_user' => $this->user_detail_db->id,
				'filter_name' => 'menu_bo_sidebar'
			];
			$this->load->model('m_user');
			$menu_lama = $this->m_user->get_userakses_menu($input_akses_cek);

			$this->load->model('m_user_xlink');
			$menu = $this->m_user_xlink->get_menu_by_level_execute3(0);
			// $menu = json_decode($this->m_user->get_userakses_menu($input) );
			// echo json_encode($result);
			// \load user_menu_akses

			if($this->user_detail_db->noreg == 0){
				$rscmklaim_user = null;
			}else{
				$rscmklaim_user = $this->m_user->get_user_rscmklaim($this->user_detail_db->noreg);
			}
			
			$this->load->library("session");
			// $my_ip = json_decode(my_ip(),1);
			$my_ip = my_ip();
			$login_data = array(
					"login_status" 	=> TRUE,
					"username" 	=> $input["username"],					
					"id"		=> $this->user_detail_db->id,
					"ip"		=> [
						"server" => $my_ip['server'],
						"client" => $my_ip['client']
					],
					"menu_bo_sidebar" => $menu_lama,
					"menu" => $menu['gen'],
					"detail" => [						
						"rscmklaim" => $rscmklaim_user,
					],
					'date' 	=> date('Y-m-d'),
					'time' 	=> date('H:i:s'),
				);
			$this->session->set_userdata($login_data);
			// echo "<pre>",print_r($login_data),"</pre>"; // INI UNTUK CEK. dan comment REDIRECT di bawah

			// MASUKKAN KE RECORD LOGIN
			//
			$post_xrec = [
					'app'	=> 'login',
					'data'	=> $login_data,
					'user' 	=> $input["username"],	
					'date' 	=> date('Y-m-d'),
					'time' 	=> date('H:i:s')
				];
			$this->load->model('m_daftarmandiri');
			$xrec = $this->m_daftarmandiri->insert_daftar_rj_xrec($post_xrec);

			redirect(base_url("bo"));
		}

  }
	
	
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url("user/login"));
	}


	
  public function record($app=null, $action_name=null, $element_name=null){
    $this->load->library("session");
    // $my_ip = json_decode(my_ip(),1);
    $my_ip = my_ip();
    $login_data = array(
        "login_status"=> TRUE,
        "username" 	  => $this->session->userdata("username"), //$this->username_temp,//$input["username"],					
        "id"		=> $this->session->userdata("id"), //$this->user_detail_db->id,
        "ip"		=> [
          "server" => $my_ip['server'],
          "client" => $my_ip['client']
        ],
        "action_name" => $action_name,
        "element_name" => $element_name,
        'date' 	=> date('Y-m-d'),
        'time' 	=> date('H:i:s'),
      );
    // $this->session->set_userdata($login_data);      

    $post_xrec = [
      'app'	=> $app,
      'data'	=> $login_data,
      'user' 	=> $this->session->userdata("username"),// $this->username_temp, // $input["username"],	
      'date' 	=> date('Y-m-d'),
      'time' 	=> date('H:i:s')
    ];
    $this->load->model('m_daftarmandiri');
    $xrec = $this->m_daftarmandiri->insert_daftar_rj_xrec($post_xrec);
  }

	public function password_check($str){
		$this->load->model("m_user");
		$user_detail = $this->m_user->get_user_detail($this->username_temp);

		if($user_detail->password == crypt($str, $user_detail->password) ){
			$this->user_detail_db = $user_detail;
			return TRUE;
		}else{
			$this->form_validation->set_message("password_check","Password salah.");
			return FALSE;
		}

	}

	// sebenarnya cara ini tidak boleh, karena username seharusnya tidak masuk melalui URL
	public function my_username_password_check($username, $password){ // $password = before encrypt
		$this->load->model("m_user");
		// $user_detail = arr_repair($this->m_user->get_user_detail($username) ); // array
		$user_detail = $this->m_user->get_user_detail($username);
		// echo "<pre>",print_r($user_detail),"</pre>";

		if($user_detail->password == crypt($password, $user_detail->password) ){
			$this->user_detail_db = $user_detail;
			$result = TRUE;
		}else{
			$result = FALSE;
		}

		echo json_encode($result);
	}

	// kalau lupa password, bisa langsung panggil controller ini
	// http://192.168.1.68/rscm/app_dev/user/my_password_change/shofwan/shofwan123
	public function my_password_change($username, $password){
		$this->load->model("m_user");
		$enCrypt_password = bCrypt($password, 12);
		$data = [
			"arr_data" => [
				"password" => $enCrypt_password
			],
			"where" => [
				"username" => $username
			],
			"table" => "xuser"
		];
		$result = $this->m_user->update($data);
		echo json_encode($result);

	}

	public function list_karyawan(){
		$this->load->model("m_user");
		$result = $this->m_user->list_karyawan();
		echo json_encode($result);
	}
	
	public function list_karyawan_registered_app(){
		$this->load->model("m_user");
		$result = $this->m_user->list_karyawan_registered_app();
		echo json_encode($result);
	}



	// -- NEW
	public function user_akses_menu(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model("m_main");
		
		$del = $this->m_main->delete("xmenuuser", ["username"=>$post["username"] ]);
		// for ($d=0; $d < count($post['fal']); $d++) { 
		// 	$del = $this->m_main->delete("xmenuuser", ["username"=>$post["username"], "idmenu"=>$post["fal"][$d] ]);
		// }
		
		for ($i=0; $i < count($post['tru']); $i++) {
			$ins = $this->m_main->insert("xmenuuser", ["username"=>$post["username"], "idmenu"=>$post["tru"][$i] ]);
		}
		// echo json_encode($post);
		$val = [
			"request"  => $post,
			"response" => [
				"delete" => $del,
				"insert" => $ins,
			],
		];
		echo json_encode($val);
	}
	
	
	
	// --\NEW

	

	

}
