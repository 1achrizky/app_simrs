<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends CI_Controller {
	protected $public_ip = '';

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");

    }

	public function index(){
		//echo 'ajax';		
	}

	
	public function tes_ip(){
		/* 
		 Simple File untuk Ngetes Send Pesan ke Bot
		 Memiliki banyak kegunaan dan tujuan
		 
		 misalnya ngetes pesan dengan format tertentu, line break, char khusus, dll.
		 bisa dipergunakan juga untuk test hosting, cronjob, dan segala test lainnya. 
		 
		 Jika menggunakan mode GET :
		 - Line break (ENTER) = %0A
		 - Space = %20 
		 Atau rawurlencode($string);
		 
		 Contoh dibawah ini menggunakan mode POST. Baris baru cukup dengan \n.
		 
		 * -----------------------
		 * Grup @botphp
		 * Jika ada pertanyaan jangan via PM
		 * langsung di grup saja.
		 * ----------------------
		 
		*/
		// $TOKEN  = "TOKENBOT";  // ganti token ini dengan token bot mu
		$TOKEN  = "310779410:AAFyWQdOIfQZYJCfJlYg-YUb-UBWgK1POpc";  //  token bot rizky: pulsa.ea
		// $chatid = "213567634"; // ini id saya di telegram @hasanudinhs silakan diganti dan disesuaikan
		$chatid = "79756408"; // id rizky : @RizkyServiceLaptop
		$pesan 	= "Bismillah. Iki IP_PUBLIC pc rizky \n".public_ip();
		// ----------- code -------------
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
		$post = [
		 'chat_id' => $chatid,
		 // 'parse_mode' => 'HTML', // aktifkan ini jika ingin menggunakan format type HTML, bisa juga diganti menjadi Markdown
		 'text' => $pesan
		];
		$header = [
		 "X-Requested-With: XMLHttpRequest",
		 "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
		];

		// hapus 1 baris ini:
		// die('Hapus baris ini sebelum bisa berjalan, terimakasih.');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_REFERER, $refer);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$datas = curl_exec($ch);
		$error = curl_error($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$debug['text'] = $pesan;
		$debug['code'] = $status;
		$debug['status'] = $error;
		$debug['respon'] = json_decode($datas, true);
		print_r($debug);
		/* 
		* by @hasanudinhs
		* Telegram @botphp
		* Last update: 27 Sept 2017 22:53
		*/

	}

	public function daftaronline(){
		
		$TOKEN  = "310779410:AAFyWQdOIfQZYJCfJlYg-YUb-UBWgK1POpc";  //  token bot rizky: pulsa.ea
		// $chatid = "213567634"; // ini id saya di telegram @hasanudinhs silakan diganti dan disesuaikan
		$chatid = "79756408"; // id rizky : @RizkyServiceLaptop
		$pesan 	= "Bismillah. Iki IP_PUBLIC pc rizky \n".public_ip();
		// ----------- code -------------
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
		$post = [
		 'chat_id' => $chatid,
		 // 'parse_mode' => 'HTML', // aktifkan ini jika ingin menggunakan format type HTML, bisa juga diganti menjadi Markdown
		 'text' => $pesan
		];
		$header = [
		 "X-Requested-With: XMLHttpRequest",
		 "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
		];

		// hapus 1 baris ini:
		// die('Hapus baris ini sebelum bisa berjalan, terimakasih.');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_REFERER, $refer);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$datas = curl_exec($ch);
		$error = curl_error($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$debug['text'] = $pesan;
		$debug['code'] = $status;
		$debug['status'] = $error;
		$debug['respon'] = json_decode($datas, true);
		print_r($debug);
		/* 
		* by @hasanudinhs
		* Telegram @botphp
		* Last update: 27 Sept 2017 22:53
		*/

	}

	public function balas($chat_id=null){
		$TOKEN  = "310779410:AAFyWQdOIfQZYJCfJlYg-YUb-UBWgK1POpc";


		$email = $_POST['email'];
		$pesan = $_POST['pesan'];
		$date = date('d F Y').'%0A';
		 
		 
		$message = $date.'Bro ada pesan ni di share-system.com dari '.$email.' : %0A'.$pesan.'';
		 
		// $api = 'https://api.telegram.org/bot'.$TOKEN.'/sendMessage?chat_id=xxxx&text='.$message.'';
		$api = 'https://api.telegram.org/bot'.$TOKEN.'/sendMessage?chat_id='.$chat_id.'&text='.$message.'';
		 
		 
		$ch = curl_init($api);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);
		 
		var_dump($api);
	}

	public function baca_pesan($chat_id=null){
		$TOKEN  = "310779410:AAFyWQdOIfQZYJCfJlYg-YUb-UBWgK1POpc";		 
		// $api = 'https://api.telegram.org/bot'.$TOKEN.'/sendMessage?chat_id=xxxx&text='.$message.'';
		// $api = 'https://api.telegram.org/bot'.$TOKEN.'/sendMessage?chat_id='.$chat_id.'&text='.$message.'';
		$api = 'https://api.telegram.org/bot'.$TOKEN.'/getUpdates';
		 
		 
		$ch = curl_init($api);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 0);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);
		 
		// var_dump($api);
		// var_dump($result);

		// $en = json_encode($result);
		// var_dump($en); XXX

		$js = json_decode($result); // js(str) -> js(obj)
		var_dump($js->result[0]->message->text);
		if($js->ok == 1){
			echo $js->result[0]->message->text;
		}else{
			return false;
		}
		
		// var_dump($en->result[0]);
	}

	public function getMe(){
		$TOKEN  = "310779410:AAFyWQdOIfQZYJCfJlYg-YUb-UBWgK1POpc";
		$cmd = 'getMe';
		$api = 'https://api.telegram.org/bot'.$TOKEN.'/'.$cmd;
		 
		 
		$ch = curl_init($api);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 0);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}

	// http://192.168.1.68/rscm/Project/8.PendaftaranMandiri/pendaftaranmandiri_devx11/telegram/tele_cmd/jadwaldokterbesok
	public function tele_cmd($katapertama=null){
		switch ($katapertama) {
		    case '/start':
		      $text = "Hai $namamu.. Akhirnya kita bertemu!";
		      break;

		    case '/time':
		      $text  = "Waktu Sekarang :\n";
		      $text .= date("d-m-Y H:i:s");
		      break;

		    case '/daftar':
		      $text  = "Hai $namamu, \n";
		      $text .= "Untuk daftar booking online, anda harus mengirimkan pesan telegram dengan format sebagai berikut: \n";
		      $text .= "[NORM]_[NO.KARTU BPJS]_[TGL LAHIR]_[NO.HP] \n";
		      $text .= "Contoh: 123456_000111222333444_12/08/1994_089678220585 \n";
		      $text .= date("d-m-Y H:i:s")."\n\n";
		      $text .= "parse:\n\n";
		      break;

		    case 'jadwaldokterbesok':
		    	//https://citramedika.com/info/model.php?kode=view_billboard&app=billboard_jadok
		    	$path = "https://citramedika.com/info/model.php?kode=view_billboard&app=billboard_jadok";
				$text = "Pilih dokter: ";
				
				$val = $this->ws_rscm->ws("base_url_post", "GET", $path, "");
				// echo $val;
				

				$index_hr_now = date('w');
				$index_hr_besok = date('w')+1;
				// echo $index_hr_besok;

				// var_dump( $val[0]->dt_hr);
				var_dump( $val);
				break;
		}
	}


}