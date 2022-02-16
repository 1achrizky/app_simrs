<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct(){
		parent::__construct();		
		date_default_timezone_set("Asia/Bangkok");
		// $this->mainlib->logged_in();
	}

	public function index(){
		// $data = [	"username" => $this->session->username];
		// $this->load->view("main/index", $data);

		redirect(base_url("bo/menu/dashboard"));

	}

	public function getUrlJsonFile($url=null){
    // $url = 'https://raw.githubusercontent.com/rreichel3/US-Stock-Symbols/main/nyse/nyse_full_tickers.json';
    $url = $_GET['u'];
    exit(file_get_contents($url));
  }

	public function db($class_name=null, $obj_name=null, $param=null, $param2=null, $param3=null, $param4=null, $param5=null){
		$this->load->model($class_name);
		
		$fx = new $this->$class_name;
		$data = $fx->$obj_name($param, $param2, $param3, $param4, $param5);
		echo json_encode($data);
		
		// $fx = new $this->m_daftarmandiri();
		// $data = $fx->$obj_name();
		// echo json_encode($data);
	}
	
	public function db_param($class_name=null, $obj_name=null){
		if(isset($_GET))
			if(isset($_GET['param']) ){
				// print_r([$class_name, $obj_name, $_GET, $_GET['param1']]); exit;
				
				$this->load->model($class_name);
				$fx = new $this->$class_name;
				$data = $fx->$obj_name($_GET['param']);
				echo json_encode($data);

			}

	}

	// ?? BELUM DIPIKIRKAN, HANYA COPAS
	public function insert($table=null){
		$this->load->model('m_main');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		$result = $this->m_main->insert($table, $input);
		// $result = json_decode( json_encode($result) ); // netralisir arr object
		echo json_encode($result);
	}
	
	
	public function delete($table=null){
		$this->load->model('m_main');
		$input = $this->input->post(NULL,TRUE);
		// print_r($input);
		$result = $this->m_main->delete($table, $input);
		// $result = json_decode( json_encode($result) ); // netralisir arr object
		echo json_encode($result);
	}

	public function curl_insert_TX($path=null){ //by NOKA
		$input = $this->input->post(NULL,TRUE);
		// $path = 'gd_pasien_rscm_GET?noka='.$param;
		$this->ws_rscm->ws("rscm", "POST", $path, $input);
	}


	public function xls($class_name=null, $obj_name=null, $param=null, $param2=null, $param3=null, $param4=null, $param5=null){
		$menit = 2;
		$settime = 60*$menit;
		set_time_limit($settime);
		
		$this->load->model($class_name);
		
		$fx = new $this->$class_name;
		$query = $fx->$obj_name($param, $param2, $param3, $param4, $param5);
		
		$set = setting_excel_table($obj_name);
		$filename = $_GET['filename'];
		$this->load->library('my_excel');
		$this->my_excel->data_array($filename, $set, $query);

	}
	
	
	public function table($class_name=null, $obj_name=null, $param=null, $param2=null, $param3=null, $param4=null, $param5=null){
		$menit = 2;
		$settime = 60*$menit;
		set_time_limit($settime);
		
		$this->load->model($class_name);
		
		$fx = new $this->$class_name;
		$query = $fx->$obj_name($param, $param2, $param3, $param4, $param5);
		// $set = setting_excel_table($obj_name);

		$keys = array_keys($query[0]);

		// echo "<pre>",print_r($set),"</pre>"; exit;
		// echo "<pre>",print_r($keys),"</pre>"; exit;

		$th = '';
		for ($i=0; $i < count($keys); $i++) { 
			$th .= '<th>'.$keys[$i].'</th>';
		}
		
		$tr = '';
		for ($i=0; $i < count($query); $i++) { 
			$td = '';
			for ($j=0; $j < count($keys); $j++) { 
				$td .= '<td>'.$query[$i][$keys[$j]].'</td>';
			}
			$tr .= '<tr>'.$td.'</tr>';
		}

		$table = '<table border=1><thead>'.$th.'</thead><tbody>'.$tr.'</tbody></table>';
		echo $table; exit;

	}
	
	
	
	// // DARURAT CARA CEPAT, SECURITY KURANG AMAN, KARENA PARAM YANG DIKIRIM LANGSUNG MASUK DB
	// // CONS = TIDAK BISA PUSH ARRAY pada POST[]
	// public function db_formpost($class_name=null, $obj_name=null, $table_name=null){
	// 	$this->load->model($class_name);

	// 	$input = $this->input->get_post(NULL, TRUE);
	// 	// $input = $this->input->post(NULL, TRUE);
	// 	// echo "<pre>",print_r($input),"</pre>"; exit;
	// 	// $input= null;

	// 	$fx = new $this->$class_name;
	// 	$data = $fx->$obj_name($table_name, $input);
	// 	echo json_encode($data);
	// }


	public function direct_print($obj_name=null, $param=null, $param2=null, $param3=null, $param4=null, $param5=null){
		// $obj_name = "termal_tracer_booking";
		$this->load->library('print_kertas');

		$post = $this->input->post(NULL,TRUE);

		$fx = new $this->print_kertas;
		
		// $data = $fx->$obj_name($param, $param2, $param3, $param4, $param5); // utk METHOD GET
		switch ($obj_name) {
			case 'termal_tracer_v3':
					$exe = $fx->$obj_name($post);
				break;
			
			case 'termal_tracer_booking':					
					$this->load->model("m_daftarmandiri");

					// CARI DATA PASIEN
					$norm_rs = $param;
					$px_mp = $this->m_daftarmandiri->get_pxrs_by_norm( $norm_rs );
					if(count($px_mp)>0){ $px_mp = $px_mp[0]; }

					$px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $norm_rs )["status_px"];

					$params = [
						// // "NoBill"    : "BOOKING",
						"NoRM"      => $norm_rs,
						"no_antrian"=> $post["no_antrian"],
						"Nama"      => $px_mp["Nama"],
						"TglLahir"  => $px_mp["TglLahir"],
						"Sex"       => $px_mp["Sex"],
						"Alamat"    => $px_mp["Alamat"],
						"klinik"    => $post["klinik"],
						"dokter"    => $post["dokter"],
						"user"      => $post["user"],
						"ket"       => $post["ket"],
						"umur"      => usia($px_mp["TglLahir"]),
						"st_px_baru_lama" => $px_baru_lama,
						"penanggung_cm"=> $post["penanggung_cm"],
					];

					$exe = $fx->$obj_name($params);
				break;
			
			default:
					// $params = $post;
					// $exe = $fx->$obj_name($params);
				break;
		}



		if($exe == null){
			$res = [
				"metadata" => [
					"code" 		=> 200,
					"status" 	=> "success",
				],
				"response" => $exe,
			];
		}else{
			$res = [
				"metadata" => [
					"code" 		=> 201,
					"status" 	=> "failed",
				],
				"response" => $exe, // string
			];
		}
		
		// echo json_encode(["response" => $exe]);
		echo json_encode($res);
		
		// $fx->$obj_name($post);


		// $datetime = rawurldecode($datetime);
		// $this->print_kertas->termal_nomor_antrian_daftar($input);
	}

	// public function termal_nomor_antrian_new(){
	// 	$post = $this->input->post(NULL,TRUE);
	// 	$this->print_kertas->termal_nomor_antrian_new($post);
	// }



	
	// NEW: 2019-12-16
	public function popup_print(){
		$get_json = $this->input->get("js");
		$json_obj = base64_decode($get_json);

		$js = json_decode($json_obj); //{json obj} to {php array}
		////echo $js->noKartu."&&".$js->tglSep."<br>";

		$this->load->view("file_template/popup_print/".$this->input->get("filename"), $js);
	}
	

	// 2021.01.13 -> untuk POPUP PRINT TERBARU
	public function file_template($page=null){
		// https://192.168.1.68/rscm/app_dev/main/file_template/popup_print/protokol-terapi-rehab/000629/6

		if($page==null) redirect(base_url("bo/menu/dashboard"));

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
				// final loop will get max segment
				$segment_arr[] = $this->uri->segment($i);
			}
		}
		
		
		// print_r($segment_arr); exit;
		if($segment_arr[0]=='popup_print'){
			$filename = $segment_arr[1];
			// array_shift($segment_arr);
			// array_shift($segment_arr);

			// print_r($segment_arr); exit;
			$pages = join('/', $segment_arr);		
			// print_r($pages); exit;
			// if($segment>=3)	$data = $this->mainlib->popup_print_onload($pages);
			$data = $this->mainlib->file_temp_onload($pages);
			
			$this->load->view("file_template/popup_print/".$filename, $data);
		}else{
			// $this->load->view("template/header-lte" , $sess);
			$this->load->view("file_template/".$pages, $data);
			// $this->load->view("template/footer-lte");
		}
		
	}


	public function file_pdf($page=null){
		// $CI =& get_instance();
		
		if($page==null) redirect(base_url("bo/menu/dashboard"));

		$data=null;
		$sess = json_decode(json_encode($this->session->userdata), true);

		//count num of segment. start 4.
		$segment = 0; //set awal, supaya tidak error do logika <get data XUSERAKSES>
		$segment_arr = [];		
		$pages = '';
		for($i=3; $i<10; $i++){
			if( !$this->uri->segment($i)){
				break;
			}else{
				$segment_arr[] = $this->uri->segment($i);
			}
		}
		
		
		if($segment_arr[0]=='popup_print'){
			$filename = $segment_arr[1];
			$pages = join('/', $segment_arr);
			$data = $this->mainlib->file_temp_onload($pages);
			// // print_r($data);
			// // $html = $this->load->view("file_template/popup_print/".$filename, $data, true);
			// // cetak_pdf('file_template/pdf/rekening_detail_px_ri_v2', $data, "BILL_", 1); // BISA
			// cetak_pdf('file_template/popup_print/protokol_terapi_rehab', $data, "BILLl_", 1);
			// cetak_pdf('file_template/popup_print/protokol-terapi-rehab', $data, "BILLl_", 1);


			$html = $this->load->view("file_template/popup_print/".$filename, $data, true);
			//CETAK PDF FIX
			// $html = $CI->load->view($url_view, $data, true);
	 
				//this the the PDF filename that user will get to download
				$pdfFilePath = $data['filename'].".pdf";
				echo $pdfFilePath;
				
				//load mPDF library
				$this->load->library('m_pdf');
				$pdf = $this->m_pdf->pdf;
				$pdf->showImageErrors = true;
				// $pdf->SetFont('tahoma');
	
				//generate the PDF from the given html
				// $this->m_pdf->pdf->WriteHTML($html);
				$pdf->WriteHTML($html);
	
				//download it.
				// $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
				$pdf->Output($pdfFilePath, "D");
				exit();
		}else{
			$html = $this->load->view("file_template/".$pages, $data, true);
		}


		
		
	}
	
	
	public function popup_print_dbload(){
		$get_json = $this->input->get("js");
		$pages = $this->input->get("pages");

		$json_obj = base64_decode($get_json);

		$db = $this->mainlib->page_onload($pages);
		$data = [
			"js" => json_decode($json_obj), //{json obj} to {php array}
			"db" => $db,
		]; 
		// echo "<pre>",print_r($data),"</pre>";

		$this->load->view("file_template/popup_print/".$this->input->get("filename"), $data);
	}



	public function view_printpreview(){
		$input = $this->input->get(NULL, TRUE);
		$this->load->view("file_template/".$this->input->get("filename"), $input);
	}


	public function curl_post($url=null){
		$post = $this->input->post(NULL,TRUE);
		$val = $this->ws_rscm->ws_arr("rscm_web", "POST", $url, $post);
		echo json_encode($val);
	}

	
	public function view_popup_print(){
		$input = $this->input->get(NULL, TRUE);
		$filename = $input['filename'];

		switch ($filename) {
			case 'tracer-ri':
					$data = [
						"NoBill"    => "BL191212.0012", // 'js_sel.nobill',
						"NoRM"      => "000123", // 'js_sel.norm',
						"Nama"      => 'js_sel.nama',
						"TglLahir"  => "2010-08-08", // 'js_sel.tgllahir',
						"Sex"       => "L", // 'js_sel.jeniskelamin',
						"Alamat"    => "Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat", // 'js_sel.alamat',
						"kelas_ruang" => 'js_sel.kelas_ruang',
						"bed_tarif" => "500000", // js_sel.tarif_bedri,
						// dokter    : js_sel.dokter_nama,
						"user"      => "della", // "_user_logged_in",
						"ket"       => "js_sel.keterangan",
						"umur"      => "12", // js_sel.umur,
						"kategori_usia"   => "DEWASA", // js_sel.kategori_usia,
						"st_px_baru_lama" => "LAMA", // js_sel.statuspasien,
						"penanggung_cm"   => "BPJS", // "js_sel.penanggung_ket", 
					];
				break;
			
			case 'surat-jrklaim':
					$verifData = '2020-03-31';

					$data = [
						"verifDate" => '2020-03-31', // 'js_sel.nobill',
						"namapx"    => "nama_px", // 'js_sel.nobill',
						"tglMasuk" => '2020-03-30', // 'js_sel.nobill',
						"gender"    => "L", // 'js_sel.nobill',
						"usia"    	=> "50", // 'js_sel.nobill',
						"biayaAmbulanVerif" => "500000", // 'js_sel.biayaAmbulan',
						"biayaP3KVerif" => "1000000", // 'js_sel.biayaP3K',
						"biayaPerawatanVerif" => "20000000", // 'js_sel.biayaPerawatan',
						"alamat"    => "Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat", // 'js_sel.alamat',

						"NoBill"    => "BL191212.0012", // 'js_sel.nobill',
						"Nama"      => 'js_sel.nama',
						"tglLaka"  => "2010-08-08", // 'js_sel.tgllahir',
						"Sex"       => "L", // 'js_sel.jeniskelamin',
						
						"user"      => "della", // "_user_logged_in",
						"ket"       => "js_sel.keterangan",
						"umur"      => "12", // js_sel.umur,
					];

					$input = $data;
				break;
			
			default:
				# code...
				break;
		}
		
		// $this->load->view("file_template/popup_print/".$this->input->get("filename"), $data);

		$this->load->view("file_template/popup_print/".$this->input->get("filename"), $input);// real
	}


	public function qrcode($page=null){
		
		// header("Content-Type: image/png");
		// $this->load->library('ciqrcode');
		// $params['data'] = 'This is a text to encode become QR Code';
		// $this->ciqrcode->generate($params);


		$dirname = 'assets/img/qrcode/';
		
		$this->load->library('ciqrcode');
		$params['data'] = 'Coba '.$page;
		$params['level'] = 'H';
		$params['size'] = 10;
		$params['savename'] = FCPATH.$dirname.$page.'.png';
		$this->ciqrcode->generate($params);

		echo base_url().$dirname.$page.'.png';
		echo '<br>';
		echo '<img src="'.base_url().$dirname.$page.'.png" />';
	}

	public function read_img($page=null){
		
		// header("Content-Type: image/png");
		
		echo base_url().$page.'.png';
		echo '<img src="'.base_url().$page.'.png" />';
	}

	protected $dbs = [

	];

	public function pg($method=null){
		// $host = "192.168.1.68";
		$host = "127.0.0.1";
    $port = "5432"; // "32"; // "5432";
    $dbname = "omob";
    $user = "postgres";
    $password = "adminckfs"; 
    // $password = md5("adminckfs"); 
    $con_str = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
		// echo $con_str; exit;
		$dbconn = pg_connect($con_str);     
		
		switch ($method) {
			case 'insert':
					$sql = "INSERT into scrape(id, title)  values('1','testing')";
					$result = pg_query($dbconn, $sql);
					if($result){
						echo "Record saved";
					}  
				break;
			
			case 'select':
					$sql = "SELECT * FROM scrape";
					$result = pg_query($dbconn, $sql);
					// print_r($result);

					// while ($row = pg_fetch_row($result)) {
					// while ($row = pg_fetch_array($result)) {
					$r = [];
					while ($row = pg_fetch_assoc($result)) {
						$r[] = $row;
						// echo "Author: $row[0]  E-mail: $row[1]";
						// echo "<br />\n";
					}
					echo json_encode($r);
				break;
			
			default:
				# code...
				break;
		}
	}
	
	
}
