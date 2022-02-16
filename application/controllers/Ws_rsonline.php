<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* created on 18 September 2020 by eindraz */

date_default_timezone_set('Asia/Jakarta');

class Ws_rsonline extends CI_Controller {

  public function __construct() {
		parent::__construct();
	
		$this->ssconfig["id"] ='3515131'; // kode rumahsakit di RS ONLINE
		$this->ssconfig["key"] ='$CMF2020$'; //password RS ONLINE
		$this->ssconfig["url"] ='http://sirs.kemkes.go.id/fo/index.php/LapV2';

    $this->parameterCovid = [   
			'1' => 'Suspect Dengan Komorbid',
			'2' => 'Suspect Tanpa Komorbid',
			'3' => 'Probable Dengan Komorbid',
			'4' => 'Probable Tanpa Komorbid',
			'5' => 'Konfirmasi Dengan Komorbid',
			'6' => 'Konfirmasi Tanpa Komorbid',
			'7' => 'Discarded Dengan Komorbid',
			'8' => 'Discarded Tanpa Komorbid'
		];
	}

	public function index()
	{
	}

    public function sendRequest($action = "", $method = "GET", $data = "", $contenType = "application/json", $url = "") {

        $curl = curl_init();
      
        $headers = array(
            "Accept: application/Json",
            "X-rs-id: ".$this->ssconfig["id"],
            "X-Timestamp: ".time(),
            "X-pass: ".$this->ssconfig["key"]
        );		
        
        $url = ($url == '' ? $this->ssconfig["url"] : $url);
        
        curl_setopt($curl, CURLOPT_URL, $url."/".$action);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $headers[count($headers)] = "Content-type: ".$contenType;
        $headers[count($headers)] = "Content-length: ".strlen($data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }			
		
    //******************* Bridging Informasi Kapasitas Tempat Tidur 

	public function post_tempat_tidur() { // simpan baru
		$this->update_tempat_tidur("POST");
	}

	public function put_tempat_tidur() { // update
		$this->update_tempat_tidur("PUT");
	}

	public function update_tempat_tidur($method) {

		$query = " QUERY DISESUAIKAN MASING-MASING DB SIMRS RUMAHSAKIT ";

    	$result = $this->db->query($query);
       	if ($result->num_rows() > 0 ) {
	        foreach ($result->result_array() as $row) {         

            	$arr["id_tt"] = $row["id_tt"];
            	$arr["ruang"] = $row["ruang"]; 
            	$arr["jumlah_ruang"] = $row["jumlah_ruang"];
	            $arr["jumlah"] = $row["kapasitas"];
				$arr["terpakai"] = $row["terpakai"]; 
	            $arr["prepare"] = $row["prepare"];
	            $arr["prepare_plan"] = $row["prepare_plan"];
	            $arr["covid"] = (int)$row["covid"];
	            // update 26/02/2021
	            if ( $method == "PUT" ) { $arr["id_t_tt"] = $row["id_t_tt"]; }

	            $json = json_encode($arr);
	            echo $this->sendRequest("Fasyankes",$method,$json,"","http://sirs.kemkes.go.id/fo/index.php");
	        }
	    }
	}

	public function get_referensi_tempat_tidur() {
	 	echo $this->sendRequest("Referensi/tempat_tidur","GET","","","http://sirs.kemkes.go.id/fo/index.php");
	 }

	public function get_fasyankes() {
		echo $this->sendRequest("Fasyankes","GET","","","http://sirs.kemkes.go.id/fo/index.php");
	}


	// ***************** Bridging Data Pasien Covid Masuk 

	public function post_pasien_masuk() {
		
		$tanggal = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))); // ambil tanggal kemarin
		$arr["tanggal"] = $tanggal;

		// CONTOH AMBIL DATA JUMLAH PASIEN COVID19 RAWAT JALAN DAN IGD
		// PASIEN RAWAT JALAN TIDAK RUJUK KE RAWAT INAP 
		$query = "SELECT a.TANGGAL,
			SUM(CASE WHEN a.COVID_STATUS IN (1,2) AND a.KDPOLY = 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'L' THEN 1 ELSE 0 END) AS igd_suspect_l,
			SUM(CASE WHEN a.COVID_STATUS IN (1,2) AND a.KDPOLY = 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'P' THEN 1 ELSE 0 END) AS igd_suspect_p,
			SUM(CASE WHEN a.COVID_STATUS IN (5,6) AND a.KDPOLY = 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'L' THEN 1 ELSE 0 END) AS igd_confirm_l,
			SUM(CASE WHEN a.COVID_STATUS IN (5,6) AND a.KDPOLY = 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'P' THEN 1 ELSE 0 END) AS igd_confirm_p,
			SUM(CASE WHEN a.COVID_STATUS IN (1,2) AND a.KDPOLY <> 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'L' THEN 1 ELSE 0 END) AS rj_suspect_l,
			SUM(CASE WHEN a.COVID_STATUS IN (1,2) AND a.KDPOLY <> 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'P' THEN 1 ELSE 0 END) AS rj_suspect_p,
			SUM(CASE WHEN a.COVID_STATUS IN (5,6) AND a.KDPOLY <> 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'L' THEN 1 ELSE 0 END) AS rj_confirm_l,
			SUM(CASE WHEN a.COVID_STATUS IN (5,6) AND a.KDPOLY <> 'IGD' AND a.STATUS <> 'RAWATINAP' AND b.JENISKELAMIN = 'P' THEN 1 ELSE 0 END) AS rj_confirm_p
			FROM tb_rawatjalan a
			LEFT JOIN tb_pasien b ON b.NOMR = a.NOMR
			WHERE a.COVID = 1 AND DATE(a.TANGGAL) = '".$tanggal."'
			GROUP BY a.TANGGAL";

    	$result = $this->db->query($query);
			if ($result->num_rows() > 0 ) {
				foreach ($result->result_array() as $row) {

					$arr["igd_suspect_l"] = $row["igd_suspect_l"];
					$arr["igd_suspect_p"] = $row["igd_suspect_p"];
					$arr["igd_confirm_l"] = $row["igd_confirm_l"];
					$arr["igd_confirm_p"] = $row["igd_confirm_p"];

					$arr["rj_suspect_l"] = $row["rj_suspect_l"];
					$arr["rj_suspect_p"] = $row["rj_suspect_p"];
					$arr["rj_confirm_l"] = $row["rj_confirm_l"];
					$arr["rj_confirm_p"] = $row["rj_confirm_p"];

				}
	    }

		// CONTOH AMBIL DATA JUMLAH PASIEN COVID19 MASUK RAWAT INAP
	    $query = "SELECT 
	    	SUM(CASE WHEN a.COVID_STATUS IN (1,2) AND b.JENISKELAMIN = 'L' THEN 1 ELSE 0 END) AS ri_suspect_l,
				SUM(CASE WHEN a.COVID_STATUS IN (1,2) AND b.JENISKELAMIN = 'P' THEN 1 ELSE 0 END) AS ri_suspect_p,
	    	SUM(CASE WHEN a.COVID_STATUS IN (5,6) AND b.JENISKELAMIN = 'L' THEN 1 ELSE 0 END) AS ri_confirm_l,
				SUM(CASE WHEN a.COVID_STATUS IN (5,6) AND b.JENISKELAMIN = 'P' THEN 1 ELSE 0 END) AS ri_confirm_p	
			FROM tb_rawatinap a 
			WHERE a.status_ruang = 'COVID19' AND DATE(a.TGL_MASUK) = '".$tanggal."'";

    	$result = $this->db->query($query);
			if ($result->num_rows() > 0 ) {
				foreach ($result->result_array() as $row) {

				$arr["ri_suspect_l"] = $row["ri_suspect_l"];
				$arr["ri_suspect_p"] = $row["ri_suspect_p"];
				$arr["ri_confirm_l"] = $row["ri_confirm_l"];
				$arr["ri_confirm_p"] = $row["ri_confirm_p"];

				}
	    }

	    $json = json_encode($arr, JSON_PRETTY_PRINT);
    
	    echo $this->sendRequest("PasienMasuk","POST",$json);
	}

	public function get_pasien_masuk() {

		echo $this->sendRequest("PasienMasuk");
	}


	// ***************** Bridging Data Pasien Covid Dirawat 

	public function post_pasien_dirawat() {

		$tanggal = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))); // ambil tanggal kemarin
		$arr["tanggal"] = $tanggal;

		$query = " QUERY DISESUAIKAN MASING-MASING DB SIMRS RUMAHSAKIT ";
    	$result = $this->db->query($query);
       	if ($result->num_rows() > 0 ) {
	        foreach ($result->result_array() as $row) {  
	       	}
	    } 	

	    $arr["icu_dengan_ventilator_suspect_l"] = 0;
	    $arr["icu_dengan_ventilator_suspect_p"] = 0;
	    $arr["icu_dengan_ventilator_confirm_l"] = 0;
	    $arr["icu_dengan_ventilator_confirm_p"] = 0;
	    $arr["icu_tanpa_ventilator_suspect_l"] = 0;
	    $arr["icu_tanpa_ventilator_suspect_p"] = 0;
	    $arr["icu_tanpa_ventilator_confirm_l"] = 0;
	    $arr["icu_tanpa_ventilator_confirm_p"] = 0;
	    $arr["icu_tekanan_negatif_dengan_ventilator_suspect_l"] = 0;
	    $arr["icu_tekanan_negatif_dengan_ventilator_suspect_p"] = 0;
	    $arr["icu_tekanan_negatif_dengan_ventilator_confirm_l"] = 0;
	    $arr["icu_tekanan_negatif_dengan_ventilator_confirm_p"] = 0;
	    $arr["icu_tekanan_negatif_tanpa_ventilator_suspect_l"] = 0;
	    $arr["icu_tekanan_negatif_tanpa_ventilator_suspect_p"] = 0;
	    $arr["icu_tekanan_negatif_tanpa_ventilator_confirm_l"] = 0;
	    $arr["icu_tekanan_negatif_tanpa_ventilator_confirm_p"] = 0;
	    $arr["isolasi_tekanan_negatif_suspect_l"] = 0;
	    $arr["isolasi_tekanan_negatif_suspect_p"] = 0;
	    $arr["isolasi_tekanan_negatif_confirm_l"] = 0;
	    $arr["isolasi_tekanan_negatif_confirm_p"] = 0;
	    

		// TANPA KOMORBID
	    $arr["isolasi_tanpa_tekanan_negatif_suspect_l"] = $tkom_s_l;
	    $arr["isolasi_tanpa_tekanan_negatif_suspect_p"] = $tkom_s_p;
	    $arr["isolasi_tanpa_tekanan_negatif_confirm_l"] = $tkom_c_l;
	    $arr["isolasi_tanpa_tekanan_negatif_confirm_p"] = $tkom_c_p;

	   	$json = json_encode($arr);
	   	echo $this->sendRequest("PasienDirawatTanpaKomorbid","POST",$json);

	   	// DENGAN KOMORBID
	    $arr["isolasi_tanpa_tekanan_negatif_suspect_l"] = $kom_s_l;
	    $arr["isolasi_tanpa_tekanan_negatif_suspect_p"] = $kom_s_p;
	    $arr["isolasi_tanpa_tekanan_negatif_confirm_l"] = $kom_c_l;
	    $arr["isolasi_tanpa_tekanan_negatif_confirm_p"] = $kom_c_p;

	   	$json = json_encode($arr);
	   	echo "<hr>";
	   	echo $this->sendRequest("PasienDirawatKomorbid","POST",$json);

	    // pasien keluar
	    $ark["tanggal"] = $tanggal;
	    $ark["sembuh"] = 0;
	    $ark["discarded"] = 0;
	    $ark["meninggal_komorbid"] = 0;
	    $ark["meninggal_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_pre_komorbid"] = 0;
	    $ark["meninggal_prob_neo_komorbid"] = 0;
	    $ark["meninggal_prob_bayi_komorbid"] = 0;
	    $ark["meninggal_prob_balita_komorbid"] = 0;
	    $ark["meninggal_prob_anak_komorbid"] = 0;
	    $ark["meninggal_prob_remaja_komorbid"] = 0;
	    $ark["meninggal_prob_dws_komorbid"] = 0;
	    $ark["meninggal_prob_lansia_komorbid"] = 0;
	    $ark["meninggal_prob_pre_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_neo_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_bayi_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_balita_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_anak_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_remaja_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_dws_tanpa_komorbid"] = 0;
	    $ark["meninggal_prob_lansia_tanpa_komorbid"] = 0;
	    $ark["meninggal_disarded_komorbid"] = 0;
	    $ark["meninggal_discarded_tanpa_komorbid"] = 0;
    	$ark["dirujuk"] = 0;
    	$ark["isman"] = 0;
    	$ark["aps"] = 0;
		$ark["sembuh"] = $k_sembuh;
		$ark["dirujuk"] = $k_rujuk;
    	$ark["aps"] = $k_aps;
	    $ark["meninggal_komorbid"] = $k_mati_komorbid;
	    $ark["meninggal_tanpa_komorbid"] = $k_mati_tanpa_komorbid;

		$json = json_encode($ark);
	   	echo "<hr>";
	   	echo $this->sendRequest("PasienKeluar","POST",$json);
	}

	public function get_pasien_dirawat_komorbid() {

		echo $this->sendRequest("PasienDirawatKomorbid");
	}

	public function get_pasien_dirawat_tanpa_komorbid() {

		echo $this->sendRequest("PasienDirawatTanpaKomorbid");
	}

	public function get_pasien_keluar() {
	 	echo $this->sendRequest("PasienKeluar");
	}


}