<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function bCrypt($pass,$cost){
      $chars='./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
 
      // Build the beginning of the salt
      $salt=sprintf('$2a$%02d$',$cost);
 
      // Seed the random generator
      mt_srand();
 
      // Generate a random salt
      for($i=0;$i<22;$i++) $salt.=$chars[mt_rand(0,63)];
 
     // return the hash
    return crypt($pass,$salt);
}

function arr_repair($arr){
	return json_decode( json_encode($arr), TRUE);
}

function usia($tgl_lahir){ // $tgl_lahir = yyyy-mm-dd
	return date_diff(date_create($tgl_lahir), date_create('now'))->y;
}

function kategori_usia($usia_th){
	if($usia_th <= 1){
		$kategori = "BAYI";
	}else if($usia_th >1 && $usia_th <= 14){
		$kategori = "ANAK";
	}else if($usia_th >14 && $usia_th <= 21){
		$kategori = "REMAJA";
	}else if($usia_th >21 && $usia_th <= 50){
		$kategori = "DEWASA";
	}else{
		$kategori = "MANULA";
	}
	return $kategori;
}

function public_ip(){
	//https://api.ipify.org/?format=json
	$externalContent = file_get_contents('http://checkip.dyndns.com/');
	preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
	$public_ip_addr = $m[1];
	return $public_ip_addr;

	// $this->public_ip = $m[1];
	// echo $this->public_ip;
}

function my_ip(){
	// header('Cache-Control: no-cache, must-revalidate');
	// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	// header('Content-type: application/json');

	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	  $ip_local = $_SERVER['HTTP_CLIENT_IP'];
	}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	  $ip_local = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
	  $ip_local = $_SERVER['REMOTE_ADDR'];
	}
	// print json_encode(array('ip_local ' => $ip_local));
	$res = [
		'client' => $ip_local,
		'server' => $_SERVER['SERVER_ADDR']
	];

	return $res;
	// return json_encode($res);
}


function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
	}     
	return $temp;
}

function terbilang($nilai) {
	if($nilai<0) {
		$hasil = "minus ". trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil;
}

function terbilang_arr($nominal=null){
	$bilang = terbilang($nominal);
	$kata = explode(" ", $bilang);
	$val = [
		"nominal" 	=> $nominal,
		"terbilang" => $bilang,
		"kata" 			=> $kata,
		"nkata" 		=> count($kata),	
	];
	return $val;
}



function my_uri(){
  //=== function uri ===
  define('PATH_INFO', str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']) );
  //echo PATH_INFO;
  //print_r($_GET);
  
  $uri = [];
  if(strlen(PATH_INFO) != 0 ){
    if(PATH_INFO[0] == '/'){
      $uri =  explode("/", substr( $_SERVER['PATH_INFO'], 1) );
      return $uri;
      //echo "<br>===".$uri[0];
      // echo "<pre>", print_r($uri) ,"</pre>";
    }else return false;		
  }else return false;		
  //\=== function uri ===
}

function nominal_terbilang($nominal){
	$bilang = terbilang( $nominal );
	$kata 	= explode(" ", $bilang);
	$val = [
		"nominal" 	=> $nominal,
		"terbilang" => $bilang,
		"kata" 			=> $kata,
		"nkata" 		=> count($kata),			
	];
	return $val;
}


// // INI STABIL. sebelum 2020.03.31
// function rupiah($angka, $id=null){
// 	switch ($id) {
// 		case 1: //Rp. 500.000
// 			$hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
// 			break;

// 		case 2: //Rp. 500.000,-
// 			$hasil_rupiah = "Rp. " . number_format($angka,0,',','.') . ",-";
// 			break;
		
// 		default: //Rp. 500.000,00
// 			$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
// 			break;
// 	}

// 	return $hasil_rupiah;	
// }



// 2020.03.31
function rupiah($angka, $id=null){
	// HARUSNYA $id =1 LOGIKANYA ditukar dengan DEFAULT, karena default bisa ditambahi ",-" diluar fungsi
	if($angka == null || $angka == ''){
		return ''; exit;
	}

	switch ($id) {
		case 1: //Rp. 500.000
			$hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
			break;

		case 2: //Rp. 500.000,-
			$hasil_rupiah = "Rp. " . number_format($angka,0,',','.') . ",-";
			break;
		
		default: //Rp. 500.000,00
			$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
			break;
	}

	return $hasil_rupiah;	
}



function maxday_of_month($th_bln=null) { // $th_bln = '2019-04';
	$fulldate = $th_bln.'-01'; // syarat tanggal harus 01
	$plusBln = date('Y-m-d', strtotime("+1 months", strtotime($fulldate)));
	$val 	 = date('Y-m-d', strtotime('-1 days', strtotime($plusBln)));	  		
	return $val;
}

function selisih_bulan($date=null, $number=null){
	$val = date('Y-m-d', strtotime($number.' months', strtotime($date)));
	return $val;
}

function selisih_hari($date=null, $number=null){
	$val = date('Y-m-d', strtotime($number.' days', strtotime($date)));
	return $val;
}

function dateDiff($date_1 , $date_2 , $differenceFormat = '%a' ){
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format('%r' .$differenceFormat);    
}


//=add_day('2020-12-30', '+2');
function add_day($date, $number){
	$val = date('Y-m-d', strtotime($date. ' '.$number.' days'));			
	return $val;
}


function cek_rujukan_aktif($tglKunjungan){
	$daydiff = dateDiff($tglKunjungan, date("Y-m-d"));	
	if($daydiff <= 90){
		$status = "AKTIF";
	}else{
		$status = "HABIS";
	}

	$val = [
		"status" => $status,
		"selisih_hari" => $daydiff,
	];
	return $val;
}

function cek_rujukan_aktif_booking($tglKunjungan, $hariDaftar=null){
	$tglDaftar = ($hariDaftar=='hari_besok')? $tglDaftar = selisih_hari(date("Y-m-d"), "+1") : date("Y-m-d");
	
	$daydiff = dateDiff($tglKunjungan, $tglDaftar);	
	if($daydiff <= 90){
		$status = "AKTIF";
	}else{
		$status = "HABIS";
	}

	$message = "Rujukan sudah berjalan ".$daydiff." hari.";

	$val = [
		"status" => $status,
		"selisih_hari" 	=> $daydiff,
		"tglDaftar" 		=> $tglDaftar,
		"tglKunjungan" 	=> $tglKunjungan,
		"hariDaftar" 		=> $hariDaftar,
		"message" 			=> $message,
	];
	return $val;
}


function error($key=null, $status=null, $code=null, $message=null){
	$error = [
    "key" => $key,
    "status" => $status,
    "result" => [
      "code"    => $code,
      "message" => $message,
    ],
	];
  return $error;
}

// function errorMetaData($code=null, $message=null, $status='failed'){
// 	return [
// 		"metaData" => [
// 			"code" 		=> $code,
// 			"message" => $message,
// 			"status" 	=> $status,
// 		],
// 	];
// }

function metaData($code=null, $message=null, $status='failed', $response=null){
  return [
    "metaData" => [
      "code" 		=> $code,
      "message" => $message,
      "status" 	=> $status,
    ],
    "response" => $response,
  ];
}

function bulan_indo($id){
	$bulan = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];
	return $bulan[$id-1];
}

function month_now_yesterday($get_tgl=null){ //$get_tgl= '2019-04-01'
	$date = new DateTime($get_tgl);

	$year = (int) $date->format('Y');
	$month_now = (int) $date->format('m');
	$month_yesteday = $month_now-1;
	if($month_yesteday == 0){
		$month_yesteday = 12;
		$year_yesteday = $year-1;
	}else{
		$year_yesteday = $year;
	}

	$val = [
		"now" => [			
			"month_lbl" => sdate($month_now),
			"month" => $month_now,
			"bulan_indo" => bulan_indo($month_now),
			"year"  => $year,
			"startday" => $year."-".sdate($month_now)."-01",
			"endday" => maxday_of_month( $year."-".sdate($month_now) ),
			"maxday" => explode('-', maxday_of_month( $year."-".sdate($month_now) ) )[2] ,
		],
		"yesterday" => [
			"month_lbl" => sdate($month_yesteday),
			"month" => $month_yesteday,
			"bulan_indo" => bulan_indo($month_yesteday),
			"year"  => $year_yesteday,
			"startday" => $year."-".sdate($month_yesteday)."-01",
			"endday" => maxday_of_month( $year_yesteday."-".sdate($month_yesteday) ),
			"maxday" => explode('-', maxday_of_month( $year_yesteday."-".sdate($month_yesteday) ) )[2] ,
		]
	];

	return $val;
}

function get_age_detail($date){
	// $interval = date_diff(date_create(), date_create('2008-01-01 10:30:00'));
	$interval = date_diff(date_create(), date_create($date));
	// echo $interval->format("You are  %Y Year, %M Months, %d Days, %H Hours, %i Minutes, %s Seconds Old");
	// echo "<pre>",print_r($interval),"</pre>";
	$val = arr_repair($interval);
	return $val;
	// echo "<pre>",print_r($val),"</pre>";
}

function sdate($digit){ //change 1 to '01'
	if($digit<10){
		$digit = "0".$digit;
	}
	return $digit;
}

function slug($text){
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // lowercase
    $text = strtolower($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text))
    {
        return 'n-a';
    }
    return $text;
}

// 2021.03.08 - project surat rm
function romawi_bulan($bln=null){
	$romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
	return $romawi[($bln-1)];
}    

// 2021.03.08 - project surat rm
function create_digit($ndigit, $nomor){
	// $param 		= "000";
	// $n_repeat 	= strlen($param) - strlen($nomor);
	$n_repeat 	= $ndigit - strlen($nomor);
	$repeat 	= str_repeat("0",$n_repeat);
	$val = $repeat.$nomor;
	return $val;
}  



function cetak_pdf($url_view=null, $data=null, $filename=null, $cetak=null){
	$CI =& get_instance();

	if($cetak == 0){
		// $this->load->view($url_view, $data); 
		// Using $this when not in object context in C:\xampp\htdocs\rscm\app_dev\application\helpers\site_helper.php on [this line]
		$CI->load->view($url_view, $data); //
	}else{
	//CETAK PDF FIX
		$html = $CI->load->view($url_view, $data, true);
 
			//this the the PDF filename that user will get to download
			// $namaFile = "KASIR_".$data['pasien']['nobill'];
			$namaFile =  $filename;
			// $namaFile = "KASIR_";
			$pdfFilePath = $namaFile.".pdf";

			//load mPDF library
			$CI->load->library('m_pdf');
			$pdf = $CI->m_pdf->pdf;

			//generate the PDF from the given html
			// $this->m_pdf->pdf->WriteHTML($html);
			$pdf->WriteHTML($html);

			//download it.
			// $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
			$pdf->Output($pdfFilePath, "D"); 
			exit();
	}
}

function role_base_menu($username=null, $menu=null) { //filename = controller name => on ajaxreq
	switch ($menu) {
		case 'receptionist':
			$user_menu[$menu] = ['rizky', 'candra', 'yuci'];
		break;
		
		default:
			# code...
			break;
	}

	
    if( in_array($username, $user_menu[$menu]) ){
      // $menu_pilih[$menu] = true;
      $status_menu = true;
    }else{
      // $menu_pilih[$menu] = false;
      $status_menu = false;
    }
			
	return $status_menu;
}

function role_base_menu_new($menu_name=null, $menu_bo_sidebar=null, $username=null) { //filename = controller name => on ajaxreq
    $it_users = ['rizky', 'anton', 'shofwan'];
	if( in_array($username, $it_users) ){
		$val = true;
	}else{
		if($menu_bo_sidebar != null){
		  if( in_array($menu_name, $menu_bo_sidebar) ){
		    $val = true;
		  }else{
		  	$val = false;
		  }
	    }else{
	      $val = false;
	    }
	}
			
	return $val;
	// return $menu[$menu_name];
}


function fx_skdp($layanan=null, $nobill=null){
	$s = '';
	switch ($layanan) {
		case 'RI':
				// $s = $nobill.substr(6,2)+$nobill.substr(9,4)+'/SKDP-IRI/'+nobill.substr(4,2)+'/20'+nobill.substr(2,2);
				$s = substr($nobill,6,2).substr($nobill,9,4)."/SKDP-IRI/".substr($nobill,4,2)."/20".substr($nobill,2,2);
	
			break;
		
		case 'BPJS': // 6 digit: tgl+4digit nobill
				// $s = nobill.substr(6,2)+nobill.substr(9,4);
				$s = substr($nobill,6,2).substr($nobill,9,4);
			break;
	
		default:
			break;
	}

	return $s;
}


function return_tbl_ws($data=null, $field=null){
	// $field = ["koderuang", "namaruang", "namakelas", "kodekelas", 
	// 		"kapasitas", "tersedia", "rownumber",
	// 		"tersediapriawanita", "lastupdate"
	// 	];

	$ths = "";
	for ($f=0; $f < count($field); $f++) { 
		$ths .= "<th>".$field[$f]."</th>";
	}
	$thead = "<tr>".$ths."</tr>";

	$tbody = "";
	for ($i=0; $i < count($data["response"]["list"]); $i++) { 
		$tds = "";
		for ($f=0; $f < count($field); $f++) { 
			$tds .= "<td>".$data["response"]["list"][$i][$field[$f]]."</td>";
		}

		$tbody .= "<tr>".$tds."</tr>";
		
		// // MANUAL
		// $tbody .= "<tr>".
		// 		"<td>".$data["response"]["list"][$i]["koderuang"]."</td>".
		// 		"<td>".$data["response"]["list"][$i]["namaruang"]."</td>".
		// 		"<td>".$data["response"]["list"][$i]["namakelas"]."</td>".
		// 	"</tr>";
	}

	$tbl = "<table border=1><thead>".$thead."</thead><tbody>".$tbody."</tbody></table>";
	return $tbl;
}



// ==================== VIEW ======================
function loop_sel_opt($arr){
	$val = '';
	foreach($arr as $arrs){
		$val .= '<option value="'.$arrs.'">'.$arrs.'</option>';
	}
	return $val;
} 
// ====================\VIEW ======================

// function role_it($username=null) {
// 	$it_users = ['rizky', 'anton', 'shofwan'];
// 	if( in_array($username, $it_users) ){
// 		$st = true;
// 	}else{
// 		$st = false;
// 	}			
// 	return $st;
// }

 
 
	// $angka = 1530093;
	// echo terbilang($angka);
	

?>