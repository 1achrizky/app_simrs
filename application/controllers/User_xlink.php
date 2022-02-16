<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_xlink extends CI_Controller {
	protected $username_temp, $password_temp, $user_detail_db;
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
  }


  public function password_check(){
		$this->load->model("m_user_xlink");
		$user_detail = $this->m_user_xlink->get_user_detail($this->username_temp, $this->password_temp);

		if($user_detail != NULL ){ //?
			$this->user_detail_db = $user_detail;
			return TRUE;
		}else{
			$this->form_validation->set_message("password_check","Password salah.");
			return FALSE;
		}

  }
  

  public function login(){
		$this->load->library("form_validation");
		$input = $this->input->post(NULL, TRUE);
		$this->username_temp = @$input["username"];
		$this->password_temp = @$input["password"];

		$this->form_validation->set_rules("username", "Username", "required");
		$this->form_validation->set_rules("password", "Password", "required|callback_password_check");

		if($this->form_validation->run() == FALSE ){
			$this->load->view("login");
		}else{
      $this->load->model('m_user_xlink');
      $menu = $this->m_user_xlink->get_menu_by_level_execute3( $this->user_detail_db['userlogin'], (int)$this->user_detail_db['level'] );
      $rscmklaim_user = $this->m_user_xlink->get_user_rscmklaim($this->user_detail_db['kodekaryawan']);
      // $detail_user = get_user_login();
			
			$this->load->library("session");
			$menu_url_li = [];
			array_push($menu_url_li, base_url().'bo/menu/dashboard' ); // EXCEPT: DASHBOARD, DLL


      for ($i=0; $i < count($menu['db']) ; $i++) { 
				if($menu['db'][$i]['url'] != '')
					array_push($menu_url_li, $menu['db'][$i]['url'] );
			}

			$login_data = [
        "login_status" 	=> TRUE,
        "username" 	=> $input["username"],					
        "id"		=> $this->user_detail_db['kodekaryawan'], // $this->user_detail_db->id, // dulu pake xuser.id
        "ip"		=> my_ip(),
        "menu"  => $menu['gen'],
        "menu_url_li"  => $menu_url_li,
        "detail" => [
          "rscmklaim" => $rscmklaim_user,
        ],
        "user" => [
          "level" => (int)$this->user_detail_db['level'],
        ],
        'date' 	=> date('Y-m-d'),
        'time' 	=> date('H:i:s'),
      ];
    
			$this->session->set_userdata($login_data);
			// echo "<pre>",print_r($login_data),"</pre>";exit; // INI UNTUK CEK. dan comment REDIRECT di bawah

			// // MASUKKAN KE RECORD LOGIN
      $post_xrec = [
          'app'	  => 'login_xlink',
          'data'	=> json_encode($login_data),
          'ip' 		=> json_encode(my_ip()),
          'user' 	=> $input["username"],
          'date' 	=> date('Y-m-d'),
          'time' 	=> date('H:i:s')
        ];
      
      $this->load->model('m_main');
      $xrec = $this->m_main->insert('xrec', $post_xrec);

			redirect(base_url("bo"));
		}

  }
	
	
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url("user_xlink/login"));
	}
	
	public function logout_redirectto($url_enc=null){
		$this->session->sess_destroy();
		$url = base64_decode($url_enc);
		if($url==null) $url = base_url("user_xlink/login");

		redirect($url);
	}


	public function update_user_akses_xmenulevel(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model("m_main");
		
		$del = $this->m_main->delete("xmenulevel", ["level"=>$post["level"] ]);
		
		
		for ($i=0; $i < count($post['tru']); $i++) {
			$ins = $this->m_main->insert("xmenulevel", ["level"=>$post["level"], "idmenu"=>$post["tru"][$i] ]);
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
	
	
	public function update_user_akses_xmenuuser(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model("m_main");
		
		$del = $this->m_main->delete("xmenuuser", ["username"=>$post["username"] ]);
		
		
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


}