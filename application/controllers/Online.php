<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller {
  // protected $public_ip = '';
  
  // protected $config_bpjs = [
  //   "consid" => "16141",
  // ];
  
	public function __construct(){
    parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
    
  }
  
  
  
  //=======================[ info ]=========================
	// update_billboard_new , TIDAK DIPAKAI. Cuman, ini ada update ke website.
	// sudah pindah ke function: onload_bed_jadok_langsung
	// https://192.168.1.68/rscm/app_dev/main/db/m_bed/onload_bed_jadok_langsung
  public function update_billboard_new(){
		// $post = $this->input->post(NULL,TRUE);
		// echo json_encode($post);

		$this->load->model(['m_daftarmandiri', 'm_bed']);
		$beds = $this->m_bed->cnt_info_tt_rs()['billboard'];
		$jadok = arr_repair( $this->m_daftarmandiri->get_jadok_all()['dtjs'] );
		// $jadok = arr_repair( $jadok);		


		$js = $jadok;
		$len = count($js);
		$hr = [0,0,0,0,0,0,0]; // senin = array[1]. HR0 tidak dipakai.
		$dt_hr = [];

		for($i=0; $i<$len; $i++){
			for ($j=1; $j < 7; $j++) { 

				if($js[$i]['hariId'] == $j){
					$hr[$j]++;
					$dt_hr[$j][] = $js[$i] ;					
				}

			}
		}


		$dt_hr_fix = [];
		for ($d=0; $d < count($dt_hr); $d++) { 
			$dt_hr_fix[$d] = [
				"dt_hr" => $dt_hr[$d+1],
        "cnt" => $hr[$d+1],
			];
		}
				
		// $val = [$beds, $jadok, $hr, $dt_hr, $dt_hr[6], count($dt_hr), $x ];
		// $str_jadok = json_encode($x);
		// $val = [$beds, $x , $str_jadok];

		// echo json_encode($val);
		// echo '<pre>', print_r($val) ,'</pre>';


		$post_bed = [
			"set" => [
				"data" => $beds,
				"user" => $this->session->userdata("username"),
			],
			"where" => [
				"app" => 'billboard_bed',
			],        
		];

		$res_bed = $this->m_daftarmandiri->update_billboard($post_bed);
		
		// $curl_bed = $post_bed;
		// $curl_bed['set']['data'] = $beds; // $beds;

		$curl_bed = [
			"data" => json_encode($beds), // $beds,
			"user" => $this->session->userdata("username"),
			"app" => 'billboard_bed',
		];
    
		
		
		$post_jadok = [
			"set" => [
				"data" => $dt_hr_fix,
				"user" => $this->session->userdata("username"),
			],
			"where" => [
				"app" => 'billboard_jadok',
			],        
    ];
    
		$res_jadok = $this->m_daftarmandiri->update_billboard($post_jadok);

    $curl_jadok = [
			"data" => json_encode($dt_hr_fix),
			"user" => $this->session->userdata("username"),
			"app" => 'billboard_jadok',
		];





		// WEB
		// $path = 'http://192.168.1.68/citramedika/public_html/repairvul/info/update_bed.php'; // BISA FIX
		// $path = 'http://192.168.1.68/citramedika/public_html/repairvul/info/c_info.php/update_bed'; // OTW
		// $path = 'http://192.168.1.68/citramedika/public_html/repairvul/info/c_info_simple.php?svc=update_bed_jadok'; // FIX BISA
		$path = 'http://citramedika.com/info/c_info_simple.php?svc=update_bed_jadok'; // FIX BISA
		$res_bed_web = $this->ws_rscm->ws_arr("base_url_post", "POST", $path, $curl_bed );
		$res_jadok_web = $this->ws_rscm->ws_arr("base_url_post", "POST", $path, $curl_jadok  );
		
		
		//\WEB


		$val = [
			"request" => [
				"post_bed" 		=> $post_bed,
				"curl_bed" 		=> $curl_bed, // json_encode($post_bed),
				"post_jadok" 	=> $post_jadok,
				"curl_jadok" 	=> $curl_jadok,
			],
			"response" => [
				"res_bed" 		=> $res_bed, // ONKAN
				"res_bed_web" => $res_bed_web, // json_decode($res_bed_web), 
				"res_jadok" 	=> $res_jadok, // ONKAN
				"res_jadok_web"=> $res_jadok_web, // ONKAN
				"time_upload" => date('Y-m-d H:i:s'), // ONKAN
			],
		];
		echo json_encode($val);


		// echo "<pre>",var_dump($res_bed_web),"</pre>";
		// echo "<pre>",print_r($res_bed_web),"</pre>";
		// var_dump($res_bed_web);
		// var_dump($val);
	}

	
	//=======================[\info ]=========================


	public function curl_tes($key=null){

		switch ($key) {
			case 'google': $url="https://www.google.co.id/";  break;
			case 'tokopedia': $url="https://www.tokopedia.co.id/";  break;
			case 'medium': $url="https://www.medium.com/";  break;
			
			default:
				# code...
				break;
		}
		// persiapkan curl
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    echo $output;
	}

}