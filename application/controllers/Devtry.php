<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devtry extends CI_Controller {
	public function index(){
		//$this->load->view('cek_noka');
	}

	public function display_printer(){
		$this->load->view($this->uri->segment(1)."/".$this->uri->segment(2));
	}

	public function cetak_langsung(){
		$this->load->view($this->uri->segment(1)."/php_printer/".$this->uri->segment(2));
	}




	/*  PHP2EXCEL */
	public function php2excel(){
		$json_request = array(
			'req' => array(
				'sep' => array(
					'nosep' => '0195R0280518V001959',
					'tglSep'=> '0',
					'noka' 	=> '0',
					'nama' 	=> 'yustanti',
					'tglLahir' 	=> '0',
					'telp' 		=> '0',
					'poli_tujuan' 	=> '0',
					'faskes_perujuk'=> '0',
					'diagnosa' 	=> '0',
					'catatan' 	=> '0',
					'peserta' 	=> '0',
					'cob' 	=> '0',
					'jenisRawat'=> '0',
					'kelasRawat'=> '0',
					'penjamin' 	=> '0'
				),
				'user'	=> 'HERMAWAN'								
				//'user'	=> $this->input->post('user')								
			)
		);

		$this->load->library('third_party');
		//$this->third_party->php2excel($path);
		$this->third_party->php2excel(json_encode($json_request));
	}
	/* \PHP2EXCEL */



	/*  SEO */
	public function scrap_goo_autocomplete(){
		
		$q = "jual%20madu";
		$psi = "rJo7X4rFMN2Z4-EPrquF-A8.1597741746321";
		$dpr = "0.8999999761581421";
		$ei  = "rJo7X4rFMN2Z4-EPrquF-A8";
		$url = "https://www.google.co.id/complete/search?q=".$q.
			"&cp=9&client=psy-ab".
			"&xssi=t".
			"&gs_ri=gws-wiz".
			"&hl=en-ID".
			"&authuser=0".
			"&psi=".$psi."&dpr=".$dpr."&ei=".$ei;

			$path = $url;
			$res = $this->ws_rscm->ws_arr("base_url_post", "GET", $path, ""  );
		var_dump($res);

		// $ch1 = curl_init()
		// curl_setopt($ch1, CURLOPT_URL, "https://stackoverflow.com/questions/1053424/how-do-i-get-php-errors-to-display");
		// curl_setopt($ch1, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)'); //user agen
		// curl_setopt($ch1, CURLOPT_REFERER, 'http://www.google.com');  //referer
		// curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 20);

		// $htmlContent = curl_exec($ch1);
		// $html = str_get_html($htmlContent);
		// if (!empty($html)) {
		// 		echo $html;
		// 	}



	}

	public function scrap_goo(){
    $url = 'https://google.co.id';

    // // ini_set("allow_url_fopen", 1);
    $json = file_get_contents($url);
		$res = json_decode($json,1);
		var_dump($json); exit;
    // print_r($json); exit;
    // // var_dump( json_encode(json_decode($json))  ); exit;

    // // $x = json_encode(json_decode($json)) ;
    // // $obj = json_decode($json);
    // // echo $obj->access_token;
		// echo $res[1]['Confirmed']; exit;
	}
	/* \SEO */



}
