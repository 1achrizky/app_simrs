<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mainlib {
	public function logged_in(){
		$_this =& get_instance();
		$_this->load->helper('url');
		if($_this->session->userdata('login_status') != TRUE){
			// redirect(base_url('user/login'));
			redirect(base_url('user_xlink/login'));
		}
	}
	
	
	public function get_printername($url, $button_id, $fx_name){
		$_this =& get_instance();
		$_this->load->model('m_it');
		$db = $_this->m_it->printername($url, $button_id, $fx_name);
		// $val = (count($db)>0)? $db[0]['printername'] : '';
		// return $val;
		return $db;
	}
	
	public function page_onload($page){
		// echo $page;
		$data = null;
		$_this =& get_instance();
		if($page == 'it/user/user-akses-page'){
			$_this->load->model('m_it');
			$_this->load->model('m_user_xlink');
			$db['menu'] = $_this->m_it->select_menu();
			$db['user'] = $_this->m_user_xlink->get_user();
			$db['level']= $_this->m_user_xlink->get_level();
			// $db['menu_new']= $this->m_user_xlink->get_menu_by_level_execute3(0);
			$data = $db;
		}else if($page == 'receptionist/pendaftaranrj/master-pasien'){
			$_this->load->model('m_pendaftaran');
			$db['negara'] 	= $_this->m_pendaftaran->negara();
			$db['propinsi'] = $_this->m_pendaftaran->propinsi();
			$db['kota'] 		= $_this->m_pendaftaran->kota();
			$db['pendidikan']= $_this->m_pendaftaran->pendidikan();
			$db['pekerjaan']= $_this->m_pendaftaran->pekerjaan();
			$db['agama'] 		= $_this->m_pendaftaran->agama();
			$data = $db;
		}
		else if($page == 'dashboard'){
			$_this->load->model(['m_daftarmandiri', 'm_bed']);
			$db['count_rirj_dboard'] 	= $_this->m_daftarmandiri->count_rirj_dboard();
			$db['info_tt'] 	= $_this->m_bed->cnt_info_tt_rs(); // ['list'];
			$db['lokasi'] 	= $_this->m_daftarmandiri->select_lokasi_kunjungan_dboard(2018);

			$data = $db;
		}
		else if($page == 'manajemen/dashboard-manajemen'){
			$_this->load->model(['m_daftarmandiri', 'm_manajemen', 'm_bed']);
    
			$datenow = date('Y-m-d');
			$db['visit'] = $_this->m_daftarmandiri->count_rirj_dboard();
			$db['bedri'] = $_this->m_bed->cnt_info_tt_rs()['list'];
			$db['rj']    = $_this->m_manajemen->select_kunjunganrj_px_tiapklinik_by_rangehari($datenow, $datenow);
			$db['panel'] = $_this->m_daftarmandiri->dboard_mnj_panelutama_today();

			$data = $db;
		}
		else if($page == 'receptionist/pendaftaranrj/pendaftaran-rjri'){
			$_this->load->model(['m_daftarmandiri', 'm_bed']);
			$db['agama'] 		= $_this->m_daftarmandiri->select_agama();
			$db['instansi'] = arr_repair( $_this->m_daftarmandiri->gd_instansi_cm_all() ) ;
			$db['rjk_cm'] 	= arr_repair( $_this->m_daftarmandiri->gd_rujukan_dari_db_cm() );
			$db['caramasuk']= arr_repair( $_this->m_daftarmandiri->gd_cara_masuk_cm() );
			$db['antricall']= $_this->m_daftarmandiri->select_nomor_antridaftar_last_selesai_panggil(date('Y-m-d'));

			if($db['antricall'] == null)
				$db['antricall']= $_this->m_daftarmandiri->select_nomor_antridaftar_max( date('Y-m-d') );
			
			$data = $db;
			// echo "<pre>",print_r($db),"</pre>";
		}
		else if($page == 'tppri/pendaftaran-ri'){
			$_this->load->model(['m_daftarmandiri', 'm_bed']);
			$db['agama'] 		= $_this->m_daftarmandiri->select_agama();
			$db['instansi'] = arr_repair( $_this->m_daftarmandiri->gd_instansi_cm_all() ) ;
			$db['rjk_cm'] 	= arr_repair( $_this->m_daftarmandiri->gd_rujukan_dari_db_cm() );
			$db['caramasuk']= arr_repair( $_this->m_daftarmandiri->gd_cara_masuk_cm() );

			$data = $db;
		}
		else if($page == 'receptionist/lain-lain/jadwal-dokter'){
			$_this->load->model(['m_daftarmandiri', 'm_dokter']);
			$db['jadok_tampil'] 		= arr_repair( $_this->m_daftarmandiri->get_jadok_all()['dtjs'] );
			$db['dokter'] 		= arr_repair( $_this->m_dokter->dokter_daftar() );

			$data = $db;
		}
		else if($page == 'rm/asesmen-rehab-medis'){
			$_this->load->model(['m_dokter','m_daftarmandiri']);
			$db['dokter'] = arr_repair( $_this->m_dokter->dokter_by_lokasi(11) );
			// $db['dokter_sp'] = arr_repair( $_this->m_daftarmandiri->get_jadok_today(0)['dtjs'] );
			$db['dokter_sp'] = $_this->m_dokter->dokter_daftar();
			$data = $db;
		}
		
		else if($page == 'rm/surat/form-surat-ket'){
			$_this->load->model(['m_rm',]);
			$db['dokter'] = $_this->m_rm->get_dokter_surat();
			$data = $db;
		}

		return $data;
	}

		
	public function file_temp_onload($page){
		// echo $page;
		$explo = explode("/", $page);
		// print_r($explo); exit;

		$db = null;
		$_this =& get_instance();
		if($explo[0] == 'popup_print'){
			if($explo[1] == 'asesmen-rehab-medis'){
				$_this->load->model('m_rm');
				// https://192.168.1.68/rscm/app_dev/main/db/m_rm/detail_tindakan_rehab_by_norm/000629/4
				$db['rehab'] = $_this->m_rm->detail_tindakan_rehab_by_norm($explo[2], $explo[3]);
				// $data = $db;
			}
			else if($explo[1] == 'protokol-terapi-rehab'){
				$_this->load->model('m_rm');
				// https://192.168.1.68/rscm/app_dev/main/db/m_rm/detail_tindakan_rehab_by_norm/000629/4
				$db['rehab'] = $_this->m_rm->detail_tindakan_rehab_by_norm($explo[2], $explo[3]);
				// echo "<pre>",print_r($db),"</pre>"; exit;
				$cnt = count($db['rehab']['detail_paket']);
				if($cnt>0)
					$db['filename'] = 'Rehab_'.$db['rehab']['detail_paket'][($cnt-1)]['nosep'].'_'.$db['rehab']['detail_paket'][($cnt-1)]['nobill'];
				else
					$db['filename'] = 'Rehab_0_0';
				
				$db['rehab']['asesmen']['arr_tindak'] = explode(',', $db['rehab']['asesmen']['tindakLanjut']);

				// DEKLARASI VAR checked_tindak[X], utk yg di popup.php
				for ($i=0; $i < 3; $i++)
					$db['rehab']['asesmen']['checked_tindak'.($i+1)] = '';


				// if($db['rehab']['asesmen']['tindakLanjut'] != ''){
					for ($i=0; $i < 3; $i++) { 						
						if(in_array( ($i+1), $db['rehab']['asesmen']['arr_tindak'])){
							$db['rehab']['asesmen']['checked_tindak'.($i+1)] = 'checked="checked"';
						}
						// else{
						// 	$db['rehab']['asesmen']['checked_tindak'.($i+1)] = '';
						// }
					}
				// }

				// echo "<pre>",print_r($db),"</pre>"; exit;
					// $data = $db;
			}
			else if($explo[1] == 'sep_resume_cetak'){
				$_this->load->model('m_daftarmandiri');
				// "+js[get_id]["segment"]+"/"+js[get_id]["nobill"]+"/"+js[get_id]["kodelokasi"], "");
				
				// $segment = 'RJ'; $nobill = 'BL210111.0116'; $kodelokasi = '11';
				$segment = 'RJ'; $nobill = $explo[2]; $kodelokasi = $explo[3];
				$db['js_sel'] = $_this->m_daftarmandiri->laporan_pendaftaran_px_soft_by_bill($segment, $nobill, $kodelokasi);
				if(count($db['js_sel'])>0) $db['js_sel'] = $db['js_sel'][0];
				
				
				$_this->load->library('ws_bpjs_11');

				$tglSep = date('Y-m-d');
				$path = 'Peserta/nokartu/'.$db['js_sel']['noka'].'/tglSEP/'.$tglSep;
				$peserta_cari = $_this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");
				$db['peserta_cari'] = $peserta_cari;
				
				$path = "SEP/".$db['js_sel']['nosep'];
				$js_sep = $_this->ws_bpjs_11->ws_arr("vclaim", "GET", $path, "");
				$db['js_sep'] = $js_sep;

				// $data = $db;
			}
			else if($explo[1] == 'surat-ket'){
				$_this->load->model('m_rm');
				// https://192.168.1.68/rscm/app_dev/main/db_param/m_rm/getsurat_ket_by_nobill?param=BL210308.0170
				$db['surat'] = $_this->m_rm->getsurat_ket_by_nobill($explo[2]);
				// echo "<pre>",print_r($db),"</pre>"; exit;
				// $cnt = count($db['rehab']['detail_paket']);
				// if($cnt>0)
				// 	$db['filename'] = 'Rehab_'.$db['rehab']['detail_paket'][($cnt-1)]['nosep'].'_'.$db['rehab']['detail_paket'][($cnt-1)]['nobill'];
				// else
				// 	$db['filename'] = 'Rehab_0_0';
				
				// // echo "<pre>",print_r($db),"</pre>"; exit;
				// 	// $data = $db;
			}
			else if($explo[1] == 'kk3'){
				$_this->load->model('m_rm');
				// https://192.168.1.68/rscm/app_dev/main/db_param/m_rm/getsurat_ket_by_nobill?param=BL210308.0170
				$db['surat'] = $_this->m_rm->getsurat_ket_by_nobill($explo[2]);
				
			}
		}
		return $db;
	}


	
	public function curl($action = "", $method = "GET", $data_post = "", $contenType = "application/json", $url = "", $arrheader=null) {
		$curl = curl_init();
		$timeout = 15; // second

		// echo print_r([$action, $method, $data_post, $contenType, $url]); exit;
		if($arrheader == null){
			$arrheader = [
					"Content-Type: ".$contenType,
					// "X-rs-id: ".$this->secure_key,
					// "X-Timestamp: ".time(),
					// "X-pass: ".$this->ssconfig["key"]
			];
		}

		// $url = ($url == '' ? $this->ssconfig["url"] : $url);
		// echo print_r([$headers, $url]); exit;
		

		switch($method){
			case "GET":
				$setopt_arr = [
					CURLOPT_HTTPHEADER 		=> $arrheader,
					CURLOPT_URL 			=> $url.$action,
					CURLOPT_RETURNTRANSFER => 1, //batas
					CURLOPT_SSL_VERIFYPEER => 0,	//tambahan HTTPS
					CURLOPT_SSL_VERIFYHOST => 0, 	//tambahan HTTPS
					CURLOPT_TIMEOUT => $timeout,
				];
				break;

			case "POST":
				$setopt_arr = [
					CURLOPT_HTTPHEADER 		=> $arrheader,
					CURLOPT_URL 			=> $url.$action,
					CURLOPT_POST 			=> 1,
					CURLOPT_POSTFIELDS 		=> json_encode($data_post), // $data_post, // 
					CURLOPT_RETURNTRANSFER  => 1,
					CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					CURLOPT_TIMEOUT => $timeout,
				];
				break;
			
			case "PUT":
				$setopt_arr = [
					CURLOPT_HTTPHEADER 		=> $arrheader,
					CURLOPT_URL 			=> $url.$action,
					CURLOPT_CUSTOMREQUEST 	=> "PUT",
					CURLOPT_POSTFIELDS 		=> $data_post,
					CURLOPT_RETURNTRANSFER  => 1,
					CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
					CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
					CURLOPT_TIMEOUT => $timeout,
				];
				break;

			case "DELETE":
				$setopt_arr = [
							CURLOPT_HTTPHEADER 	=> $arrheader,
							CURLOPT_URL 			=> $url.$action,
							CURLOPT_CUSTOMREQUEST 	=> "DELETE",
							CURLOPT_POSTFIELDS 		=> $data_post,
							CURLOPT_RETURNTRANSFER	=> 1,
							CURLOPT_SSL_VERIFYPEER  => 0,	//tambahan HTTPS
							CURLOPT_SSL_VERIFYHOST  => 0, 	//tambahan HTTPS
							CURLOPT_TIMEOUT => $timeout,
				];
				break;
		}

		curl_setopt_array($curl, $setopt_arr);
		// echo '<pre>',print_r($setopt_arr),'</pre>'; exit;
		
		$result = curl_exec($curl);
		curl_close($curl);

		if($contenType == "application/json")
			return $result;
		else
			return json_decode($result,1);
	}


	
}