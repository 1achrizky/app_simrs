<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_daftarmandiri extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function gd_pasien_rscm($param=null){

		$q = "select
				a.NoRM,
				a.Barcode,
				a.Nama,
				a.TglLahir,
				a.Alamat,
				a.Sex,
				a.flagkartu,
				a.HP
			from fomstpasien a
			where  a.Barcode = ?";
		$query = $this->db->query($q,[$param]);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name'	 => 'gd_pasien_rscm',
				'status' => $status,
				'count'	 => $rowCount,
				'datajs' => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function gd_pasien_rscm_by_norm($param){
		$q = "SELECT mp.* 
			FROM fomstpasien mp
			WHERE mp.NoRM = '".$param."'";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result(),
				'message'	=> $message
			);

		return $js_full;
	}
	
	
	public function gd_pasien_rscm_by_norm_n($norm=null){
		// $q = "SELECT mp.*, DATEDIFF(CURDATE(), mp.PDPDate) AS PDPSelisihHari
		// 	FROM fomstpasien mp 
		// 	WHERE mp.NoRM = '".$norm."'";
		// $query = $this->db->query($q);
		
		$q = "SELECT mp.*, DATEDIFF(CURDATE(), mp.PDPDate) AS PDPSelisihHari
			FROM fomstpasien mp 
			WHERE mp.NoRM = ?";
		$query = $this->db->query($q, [$norm]);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		// // $querybook = [];
		// $q2 = "SELECT flag, date, time 
		// 	FROM fotrbooking 
		// 	WHERE norm = '".$norm."' AND flag=0";
		// $query2 = $this->db->query($q2)->result_array();
		
		
		$q2 = "SELECT flag, date, time 
			FROM fotrbooking 
			WHERE norm = ? AND flag=0";
		$query2 = $this->db->query($q2, [$norm])->result_array();

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result_array(),
				'message'	=> $message,
				'booking'	=> $query2,
			);

		return $js_full;
	}
  
  public function get_pxrs_by_norm($norm){
		$q = "SELECT mp.* ,
		DATEDIFF(CURDATE(), mp.PDPDate) AS PDPSelisihHari,
		IF(mp.Sex='L',1,2) AS gender_eclaim,
    kel.Keterangan AS kelurahan_ket,
    kec.Keterangan AS kecamatan_ket, 
    kt.Keterangan AS kota_ket,
    prop.Keterangan AS propinsi_ket,
    ng.Keterangan AS negara_ket,
    ag.Keterangan AS agama_ket,
    krj.Keterangan AS pekerjaan_ket,
    pnd.Keterangan AS pendidikan_ket,
    IF(mp.marital='Y', 'Kawin', 
      IF(mp.marital='T', 'Belum Kawin',
        IF(mp.marital='D', 'Duda',
          IF(mp.marital='J', 'Janda','')))) AS marital_ket
    FROM fomstpasien mp 
    LEFT JOIN fowilmstkelurahan kel ON kel.Kode=mp.Kelurahan
		AND kel.KodeKecamatan=mp.Kecamatan AND kel.KodeKota=mp.Kota
    LEFT JOIN fowilmstkecamatan kec ON kec.Kode=mp.Kecamatan AND kec.Kodekota=mp.Kota
    LEFT JOIN fowilmstkota kt ON kt.Kode=mp.Kota
    LEFT JOIN fowilmstpropinsi prop ON prop.Kode=mp.Propinsi
    LEFT JOIN fowilmstnegara ng ON ng.Kode=mp.Negara
    LEFT JOIN fomstagama ag ON ag.Kode=mp.Agama
    LEFT JOIN fomstpekerjaan krj ON krj.Kode=mp.Pekerjaan
    LEFT JOIN fomstpendidikan pnd ON pnd.Kode=mp.Pendidikan
    WHERE mp.NoRM = '".$norm."'";
		$query = $this->db->query($q)->result_array();
    return $query;
    
    /* MARITAL: Kawin, Belum Kawin, Duda, Janda. Y,T,D,J*/
	}
  
  public function get_pxrs($param=null){
		$q = "SELECT mp.* ,
		DATEDIFF(CURDATE(), mp.PDPDate) AS PDPSelisihHari,
		IF(mp.Sex='L',1,2) AS gender_eclaim,
    kel.Keterangan AS kelurahan_ket,
    kec.Keterangan AS kecamatan_ket, 
    kt.Keterangan AS kota_ket,
    prop.Keterangan AS propinsi_ket,
    ng.Keterangan AS negara_ket,
    ag.Keterangan AS agama_ket,
    krj.Keterangan AS pekerjaan_ket,
    pnd.Keterangan AS pendidikan_ket,
    IF(mp.marital='Y', 'Kawin', 
      IF(mp.marital='T', 'Belum Kawin',
        IF(mp.marital='D', 'Duda',
          IF(mp.marital='J', 'Janda','')))) AS marital_ket
    FROM fomstpasien mp 
    LEFT JOIN fowilmstkelurahan kel ON kel.Kode=mp.Kelurahan  
		AND kel.KodeKecamatan=mp.Kecamatan AND kel.KodeKota=mp.Kota
    LEFT JOIN fowilmstkecamatan kec ON kec.Kode=mp.Kecamatan AND kec.Kodekota=mp.Kota
    LEFT JOIN fowilmstkota kt ON kt.Kode=mp.Kota
    LEFT JOIN fowilmstpropinsi prop ON prop.Kode=mp.Propinsi
    LEFT JOIN fowilmstnegara ng ON ng.Kode=mp.Negara
    LEFT JOIN fomstagama ag ON ag.Kode=mp.Agama
    LEFT JOIN fomstpekerjaan krj ON krj.Kode=mp.Pekerjaan
    LEFT JOIN fomstpendidikan pnd ON pnd.Kode=mp.Pendidikan
    WHERE mp.NoRM = '".$param."' OR mp.Nama LIKE '%".$param."%' OR mp.Barcode = '".$param."'";
    //WHERE mp.NoRM LIKE '%".$param."%' OR mp.Nama LIKE '%".$param."%'";
		$query = $this->db->query($q)->result_array();
    return $query;
    
    /* MARITAL: Kawin, Belum Kawin, Duda, Janda. Y,T,D,J*/
	}

	public function get_norm_by_noka($noka){
		$q = "select NoRM,flagkartu from fomstpasien where Barcode = ".$noka;
		//$q = "select NoRM,flagkartu from fomstpasien where Barcode = '0000726541457'";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result(),
				'message'	=> $message
			);
		return $js_full;
	}

	public function gd_pasien_rscm_by_bill($bill){
		$q = "select *, c.TglLahir from fotrdaftar a 
			left join fotrdaftarrj b on b.NoBill = a.NoBill
			left join fomstpasien c on c.NoRM = a.NoRM
			where a.NoBill = ".$bill;

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				"req_name"	=> "gd_pasien_rscm_by_bill",
				"status"	=> $status,
				"count"		=> $rowCount,
				"datajs"	=> $query->result(),
				"message"	=> $message
			);
		return $js_full;
	}

	public function gd_pasien_rscm_by_bill_lokasi($param){
		// IF(a.StatusDaftar='UG', ugd.dokterrs, 
		// 			IF(a.StatusDaftar='RJ', b.Dokter, '')					
		// 		) as kd_dokter,

		// 		IF(a.StatusDaftar='UG', (select nama from hrdmstkaryawan hrd where hrd.kode = kd_dokter),
		// 			IF(a.StatusDaftar='RJ', c.Nama, 'RI')				
		// 		) as NamaDokter,
		$q = "SELECT
				a.*, b.*, #ugd.*
				-- IF(a.StatusDaftar='UG', ugd.*,
		 	-- 		IF(a.StatusDaftar='RJ', b.*, 'RI')				
		 	-- 	),
				a.NoBill AS billing, 				
				c.Nama AS nama,
				mv.Nama AS dpjp,
				c.TglLahir, 
				d.Keterangan as lokasi_ket 
			from fotrdaftar a 
			left join fotrdaftarrj b on b.NoBill = a.NoBill
			left join fotrdaftarugd ugd on ugd.nobill = a.NoBill
			left join fomstpasien c on c.NoRM = a.NoRM
			left join fomstlokasi d on d.Kode = b.Lokasi
			LEFT JOIN bohtmstvendor mv ON mv.Kode=b.Dokter
			where a.NoBill = ".$param['nobill']." AND b.Lokasi = ".$param['lokasi'];

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				"req_name"	=> "gd_pasien_rscm_by_bill_lokasi",
				"status"	=> $status,
				"count"		=> $rowCount,
				"datajs"	=> $query->result(),
				"message"	=> $message
			);
		return $js_full;
	}

	public function gd_pasien_rscm_by_bill_lokasi_new($nobill=null, $lokasi=null, $StatusDaftar=null){
		if($StatusDaftar=="RJ"){
			$select_if = "b.*, ";
		}else if($StatusDaftar=="UG"){
			$select_if = "ugd.*, ";
		}
		
		$q = "SELECT
				a.*, 
		 		".$select_if."
				a.NoBill AS billing, 				
				c.Nama AS nama,
				mv.Nama AS dpjp,
				c.TglLahir, 
				d.Keterangan as lokasi_ket 
			from fotrdaftar a 
			left join fotrdaftarrj b on b.NoBill = a.NoBill
			left join fotrdaftarugd ugd on ugd.nobill = a.NoBill
			left join fomstpasien c on c.NoRM = a.NoRM
			left join fomstlokasi d on d.Kode = b.Lokasi
			LEFT JOIN bohtmstvendor mv ON mv.Kode=b.Dokter
			where a.NoBill = '".$nobill."'";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				"req_name"	=> "gd_pasien_rscm_by_bill_lokasi",
				"status"	=> $status,
				"count"		=> $rowCount,
				"datajs"	=> $query->result(),
				"message"	=> $message
			);
		return $js_full;
	}

	public function create_noreff_tindakan($kdlokasi=null){
		$q = "SELECT Kode, Keterangan, inisial, Flag, cito
			FROM fomstlokasi
			WHERE (flag<=4) AND kode='".$kdlokasi."'";

		$query = $this->db->query($q)->result_array();
		// return $query;
		// exit;

		if(count($query)){
			if($query[0]['Flag']<2 || $query[0]['Flag'] == 4){
				// LIST BILL
				// $q2 = "SELECT 
				// 		'".$query[0]['Flag']."' AS fl, td.NoBill , 
				// 		IF(ISNULL(mid(tdj.nourut,'7','3')), '' , mid(tdj.nourut,'7','3')) AS NoUrut,
				// 		td.NoRM, td.Nama, td.Alamat, tdj.Lokasi
				// 	FROM fotrdaftar td
				// 	LEFT JOIN fotrdaftarrj tdj ON tdj.nobill=td.nobill
				// 	WHERE td.flagbill = 0 AND
				// 	IF(statusdaftar='RI', statusdaftar='RI', tdj.lokasi=' ".$kdlokasi."' AND tdj.flagdaftar = 0)
				// 	AND (td.nobill LIKE '%".$nobill."%' OR td.norm LIKE '%".$nobill."%' OR td.nama LIKE '%".$nobill."%')
				// 	ORDER BY tdj.nobill, tdj.nourut";

					// $q2 = "
					// select max(mid(noreff,10,3)) as NoNow from fotrpostindakan 
					// where noreff like '(select CONCAT('SA', date_format(CURDATE(), '%y%m%d'), '%' ) )'
					// ";

					$date = date('ymd');
					// $date = '190930';
					$q2 = "SELECT max(mid(noreff,10,3)) AS NoNow FROM fotrpostindakan 
						WHERE noreff LIKE '".$query[0]['inisial'].$date."%'
					";


					$query2 = $this->db->query($q2)->result_array();
					$noreff_get = $query2[0]['NoNow'];
					if($noreff_get == null){
						$noreff_get = 0;
					}else{
						$noreff_get = (int) $noreff_get;
					}

					$noreff_get++;


					$param 		= "000";
					$n_repeat = strlen($param) - strlen($noreff_get);
					$repeat 	= str_repeat("0",$n_repeat);
					// $new_bill 	= "BL".date('ymd').".".$repeat.$qr[0]['nobill'];
					$noreff_new = $repeat.$noreff_get;
					$noreff_new_full = $query[0]['inisial'].$date.'.'.$noreff_new;

			}
			// else if($query[0]['Flag'] == 4){

			// 	//QUERY
			// 	SELECT " & _
      //   "td.NoBill , td.NoRM, td.Nama, td.Alamat " & _
      //   "FROM fotrdaftar td " & _
      //   "Where statusdaftar='UG' and td.flagbill = 0 And " & _
      //   "(td.nobill like '%" & txtNoBill.Text & "%' or td.norm like '%" & txtNoBill.Text & "%' or td.nama like '%" & txtNoBill.Text & "%')" & _
      //   "order by td.nobill
			// }


		}
		

		// return $query2;
		// return $noreff_get;
		$result = [ 
			"kd_lokasi" => $kdlokasi,
			"inisial_lokasi" => $query[0]['inisial'],
			"noreff_baru" => $noreff_new_full,
		];
		return $result;
	}

	public function get_tarif_tindakan($kd_tindakan=null){
		$q = "SELECT * FROM fomsttindakangrp	WHERE kode='".$kd_tindakan."'";
		$query = $this->db->query($q)->result_array();
		return $query;
	}


	public function get_bill_terakhir(){
		$q = "select RIGHT(
				(
					select NoBill from fotrdaftar 
					where TanggalMasuk=CURDATE() 
					ORDER BY NoBill DESC limit 1
				), 4
			) as bill_akhir";
		$query = $this->db->query($q);

		if($query->result()[0]->bill_akhir == null){
			$query->result()[0]->bill_akhir = '0000';
		}

		return $query->result();
	}

	public function new_bill(){
		// $q = "select concat(
		// 	     'BL',DATE_FORMAT(NOW(), '%y%m%d'),'.',
		// 	     REPEAT(0,4-(LENGTH( (select COUNT(*)+1 from fotrdaftar where date = (DATE_FORMAT(NOW(), '%Y-%m-%d'))) )) ),
		// 	     (select COUNT(*)+1 from fotrdaftar where date = (DATE_FORMAT(NOW(), '%Y-%m-%d')) )
		// 	) as 'nobill'"; //LAMAAAAA=3.5detik

		$q = "select concat(
			     'BL',DATE_FORMAT(NOW(), '%y%m%d'),'.',
			     REPEAT(0,4-(LENGTH( (select COUNT(*)+1 from fotrdaftar where date = (DATE_FORMAT(NOW(), '%Y-%m-%d'))) )) ),
			     (select COUNT(*)+1 from fotrdaftar where date = '".date('Y-m-d')."' )
			) as 'nobill'";
		$query = $this->db->query($q);

		return $query->result();
	}

	public function new_bill_by_php(){
		//$now = date();
		//$q = "select (select COUNT(*)+1 from fotrdaftar where date = (DATE_FORMAT(NOW(), '%Y-%m-%d')) ) as 'nobill'";

		$q = "select (select COUNT(*)+1 from fotrdaftar where date = '".date('Y-m-d')."') as 'nobill'";
		//$q = "select (select COUNT(*)+1 from fotrdaftar where date = '2018-10-13') as 'nobill'";
		$query = $this->db->query($q);

		return $query->result();
	}
	
	public function create_bill(){
		$q = "select (select COUNT(*)+1 from fotrdaftar where date = '".date('Y-m-d')."') as 'nobill'";
		$qr = $this->db->query($q)->result_array();

		$param 		= "0000";
		$n_repeat 	= strlen($param) - strlen($qr[0]['nobill']);
		$repeat 	= str_repeat("0",$n_repeat);
		$new_bill 	= "BL".date('ymd').".".$repeat.$qr[0]['nobill'];
		$new_bill_4d = $repeat.$qr[0]['nobill'];

		$val = array(
				"new_bill" 	  => $new_bill,
				"new_bill_4d" => $new_bill_4d
			);

		return $val;
	}

	public function generate_bill_antri_skdp($kode_lokasi=null){
		$bill = $this->m_daftarmandiri->create_bill();
		$tc["bill"] = date("H:i:s");

		$antri= $this->m_daftarmandiri->ready_antrian_klinik($kode_lokasi);
		$tc["antri"] = date("H:i:s");

		$noskdp  = date('d').$bill["new_bill_4d"]."/KP/".date('m')."/".date('Y');
		$noskdp_bpjs = date('d').$bill["new_bill_4d"];

		$val = [
			"bill" => [
				"4d" 	=> $bill["new_bill_4d"],
				"full"=> $bill["new_bill"],
			],
			"antri" => $antri,
			"noskdp" => [
				"rscm" => $noskdp,
				"bpjs" => $noskdp_bpjs,
			],
			"tc" => $tc,
		];
		return $val;
	}


	public function error_count_bill_by_date($date=null){
		$q = "SELECT NoBill, COUNT(*) AS count,
		date,time, 
		'' AS identify,
		'' AS trdaftarrj
		FROM fotrbillingshare
		WHERE date='".$date."'
		GROUP BY NoBill
		HAVING COUNT(*)>1";

		$query = $this->db->query($q)->result_array();

		for ($i=0; $i < count($query); $i++) { 
			$q2 = "SELECT 
					#bs.*, 
					nobill, billname, user, date, time,
					#drj.Lokasi, drj.NoUrut, drj.Dokter,
					#ml.Keterangan,
					'' AS trdaftar
				FROM fotrbillingshare bs
				#LEFT JOIN fotrdaftarrj drj ON drj.NoBill=bs.NoBill AND drj.user=bs.user 
				#LEFT JOIN fomstlokasi ml ON ml.Kode=drj.Lokasi
				WHERE bs.date='".$date."' AND bs.NoBill='".$query[$i]['NoBill']."'";
			$query2 = $this->db->query($q2)->result_array();
			
			
			for ($j=0; $j < count($query2); $j++) { 
				$q2a = "SELECT
						td.NoBill AS nobill_baru, td.Nama,
						IF(td.NoBill<>'".$query[$i]['NoBill']."', 'SALAH', 'BENAR') AS STATUS_GEN, 
						td.time,
						td.StatusDaftar,
						j.Lokasi, ml.Keterangan
					FROM fotrdaftar td
					LEFT JOIN fotrdaftarrj j ON j.NoBill=td.NoBill
					LEFT JOIN fomstlokasi ml ON ml.Kode=j.Lokasi
					WHERE td.Nama='".$query2[$j]['billname']."' AND td.date='".$date."'";
				$query2a = $this->db->query($q2a)->result_array();
				$query2[$j]['trdaftar'] = $query2a;
			}

			$query[$i]['identify'] = $query2;
			
			
			
			$q3 = "SELECT
					drj.Lokasi, ml.Keterangan, drj.NoUrut #, drj.Dokter
				FROM fotrdaftarrj drj 
				LEFT JOIN fomstlokasi ml ON ml.Kode=drj.Lokasi
				WHERE drj.NoBill='".$query[$i]['NoBill']."'";
			$query3 = $this->db->query($q3)->result_array();
			$query[$i]['trdaftarrj'] = $query3;



		}
		

		return $query;
	}

	public function get_antrian_klinik($kode_lokasi){
		$q = "select RIGHT(
				(
					select NoUrut from fotrdaftarrj 
					where Date=CURDATE() && Lokasi='".$kode_lokasi."'
					ORDER BY NoUrut DESC limit 1
				), 3
			) as no_antrian_klinik";
		$query = $this->db->query($q);

		if($query->result()[0]->no_antrian_klinik == null){
			$query->result()[0]->no_antrian_klinik = '000';
		}

		return $query->result();
	}

	// NEW
	public function ready_antrian_klinik($kode_lokasi=null){ //digit3 BELUM di +1. FX ini untuk MENAMBAH 1
		$last_antrian_klinik = arr_repair( $this->get_antrian_klinik($kode_lokasi));
		$digit3 = $last_antrian_klinik[0]['no_antrian_klinik'];

		$id = (int)($digit3)+1;

		$digit = "000"; // memberitahu sistem kalau ini 3 digit
		// $id_tot = substr($digit, count($digit) - count($id)) + $id;

		$id_tot = substr($digit, strlen( (string)($id))) . $id;

		$val = [
			"3d" => $id_tot,
			"full" => date("ymd").$id_tot,
		];
		// return $id_tot; //001
		return $val; //001
	}



	public function get_flag_cetak_kartu($norm){

		$q = "select flagkartu from fomstpasien where NoRM = '".$norm."'";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result(),
				'message'	=> $message
			);

		return $js_full;
	}

	public function update_noka_mst_pasien($params){
		$q = "update fomstpasien set Barcode='".$params['noka']."'  where NoRM='".$params['norm']."'";
		$query = $this->db->query($q);
		return $this->db->affected_rows();
	}

	public function select_agama($params=null){
		if($params==null){
			$q = "SELECT Kode,Keterangan FROM fomstagama";
		}else{			
			$q = "SELECT Kode,Keterangan FROM fomstagama WHERE Kode='".$params."' OR Keterangan='".$params."' ";
		}
		$result = $this->db->query($q)->result_array();
		return $result;
	}

	public function update_agama($norm=null, $agama=null){
		$q = "update fomstpasien set Agama='".$agama."'  where NoRM='".$norm."'";
		$query = $this->db->query($q);
		return $this->db->affected_rows(); //jika returnnya 1, BERHASIL UPDATE.
	}

	public function update_suku_bangsa($params){
		$q = "update fomstpasien set Sukubangsa='".$params['Sukubangsa']."'  where NoRM='".$params['NoRM']."'";
		$query = $this->db->query($q);
		return $this->db->affected_rows(); //jika returnnya 1, BERHASIL UPDATE.
	}



	public function get_klinik(){
		$q = "SELECT Kode, Keterangan, Inisial as kdpoli_rs, kdpoli_bpjs, durasi 
			FROM fomstlokasi 
			WHERE (Kode>=1 AND Kode<=6) OR (Kode>=20 AND Kode<=41) 
				OR Kode=150
				OR Kode=11 OR Kode=10 
			ORDER BY Keterangan";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				"nama" 	 => "get_klinik",
				"status" => $status,
				"count"	 => $rowCount,
				"dtjs"	 => $query->result(),
				"message"=> $message
			);

		return $js_full;
	}

	public function get_klinik_ket($kdpoli_bpjs){
		$q = "select Kode, Keterangan, Inisial as kdpoli_rs, kdpoli_bpjs from fomstlokasi where ((Kode>=20 && Kode<=37) || Kode='11' || Kode='10') && kdpoli_bpjs='".$kdpoli_bpjs."'";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		// $js_full = array(
		// 		"nama" 	 => "get_klinik_ket",
		// 		"status" => $status,
		// 		"count"	 => $rowCount,
		// 		"dtjs"	 => $query->result(),
		// 		"message"=> $message
		// 	);

		// return $js_full;
		return $query->result();
	}

	public function get_klinik_by_ket($klinik_ket=null){
		$q = "SELECT Kode, Keterangan, Inisial as kdpoli_rs, kdpoli_bpjs FROM fomstlokasi 
			WHERE kdpoli_bpjs !='' AND Keterangan='".$klinik_ket."'";
		$query = $this->db->query($q);
		return $query->result();
	}
	
	// public function klinik_det_by_kode($klinik_ket=null){
	// 	$q = "SELECT Kode, Keterangan, Inisial as kdpoli_rs, kdpoli_bpjs FROM fomstlokasi 
	// 		WHERE kdpoli_bpjs !='' AND Keterangan='".$klinik_ket."'";
	// 	$query = $this->db->query($q);
	// 	return $query->result();
	// }

	public function gd_dokter_lokasi_kode_jadwal($namadokter){
		$q ="select a.Id,
				a.hari,
				a.hariId,
				b.Keterangan as Spesialis,
				b.Kode as Lokasi,
				b.kdpoli_bpjs,
				c.Nama,
				c.Kode as kodeDokter,
				c.kd_dpjp_bpjs,
				a.jamMasuk,
				a.jamPulang
			from cm_dokterjadwal a 
			left join bohtmstvendor c on c.kode = a.kodeDokter
			left join fomstlokasi b on b.Kode = c.Lokasi 
			where  c.Nama ='".$namadokter ."'
			group by c.Nama";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function get_jadok_all(){
		$q = "SELECT 
				a.Id,	a.hari,	a.hariId,
				b.Keterangan as Spesialis,
				c.Nama,	a.jamMasuk,	a.jamPulang,
				c.Kode, c.kd_dpjp_bpjs
			from cm_dokterjadwal a 
			left join fomstlokasi b on c.Lokasi = b.Kode
			left join bohtmstvendor c on c.Lokasi = b.Kode
			where  a.kodeDokter=c.Kode
			order by a.hariId,b.Keterangan,a.jamMasuk";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";


		$js = arr_repair($query->result());  

			$dt_hr = [];
			$dokter_by_day = [];
			for ($h=1; $h < 7; $h++) { 
				$dt_hr[$h] = [];
				
				for($i=0; $i<count($js); $i++){
					if($js[$i]['hariId'] == $h){
						$dt_hr[$h][] = $js[$i];
					}
				}

				$dokter_by_day[] = $dt_hr[$h];
			}



			$klinik_by_day = [];
			for($i=0; $i<count($dokter_by_day); $i++){ 
				$klinik_by_day[] = [];
				for($j=0; $j<count($dokter_by_day[$i]); $j++){ 
					//jika spesialis tidak ada di array sp_all_1hari[], masukkan data spesialis
					if(!in_array( $dokter_by_day[$i][$j]['Spesialis'], $klinik_by_day[$i] ) ){ 
						$klinik_by_day[$i][] = $dokter_by_day[$i][$j]['Spesialis'];
					}
				}
			}



		$js_full = array(
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'dokter_by_day' => $dokter_by_day,
				'klinik_by_day' => $klinik_by_day,
				'message'=> $message
			);

		return $js_full;
	}
	
	
	// // TIDAK DIPAKAI, 2021.04.22. Pengerjaan bridging antrean BPJS(console box).
	// // meringkas arr_by_day
	// public function get_jadok_all(){
	// 	$q = "SELECT 
	// 			a.Id,
	// 			a.hari,
	// 			a.hariId,
	// 			b.Keterangan as Spesialis,
	// 			c.Nama,
	// 			a.jamMasuk,
	// 			a.jamPulang 
	// 		from cm_dokterjadwal a 
	// 		left join fomstlokasi b on c.Lokasi = b.Kode
	// 		left join bohtmstvendor c on c.Lokasi = b.Kode
	// 		where  a.kodeDokter=c.Kode
	// 		order by a.hariId,b.Keterangan,a.jamMasuk";

	// 	$query = $this->db->query($q);

	// 	$rowCount = $query->num_rows();
	// 	$status = ($rowCount > 0)? "SUKSES": "GAGAL";
	// 	$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";


	// 	$js = arr_repair($query->result());
  //   $len = count($js);
  //   $hr = [0,0,0,0,0,0,0]; // senin = array[1]
  //   // $dt_hr1 = []; $dt_hr2 = []; $dt_hr3 = [];
	// 	// $dt_hr4 = []; $dt_hr5 = []; $dt_hr6 = [];
		
	// 	    // for($i=0; $i<$len; $i++){
  //       //   if($js[$i]['hariId'] == 1){
  //       //     $hr[1]++;
  //       //     $dt_hr1[] = $js[$i];
  //       //   }else if($js[$i]['hariId'] == 2){
  //       //     $hr[2]++;
  //       //     $dt_hr2[] = $js[$i];
  //       //   }else if($js[$i]['hariId'] == 3){
  //       //     $hr[3]++;
  //       //     $dt_hr3[] = $js[$i];
  //       //   }else if($js[$i]['hariId'] == 4){
  //       //     $hr[4]++;
  //       //     $dt_hr4[] = $js[$i];
  //       //   }else if($js[$i]['hariId'] == 5){
  //       //     $hr[5]++;
  //       //     $dt_hr5[] = $js[$i];
  //       //   }else if($js[$i]['hariId'] == 6){
  //       //     $hr[6]++;
  //       //     $dt_hr6[] = $js[$i];
  //       //   }
  //       // }


  //       // $arr_by_day = [
  //       //   "len" => $len,
  //       //   "hr" => [
  //       //     [
  //       //       "dt_hr" => $dt_hr1,
  //       //       "cnt" => $hr[1]
	// 			// 		],[
  //       //       "dt_hr" => $dt_hr2,
  //       //       "cnt" => $hr[2]
  //       //     ],[
  //       //       "dt_hr" => $dt_hr3,
  //       //       "cnt" => $hr[3]
  //       //     ],[
  //       //       "dt_hr" => $dt_hr4,
  //       //       "cnt" => $hr[4]
  //       //     ],[
  //       //       "dt_hr" => $dt_hr5,
  //       //       "cnt" => $hr[5]
  //       //     ],[
  //       //       "dt_hr" => $dt_hr6,
  //       //       "cnt" => $hr[6]
	// 			// 		]
  //       //   ]
	// 			// ];


	// 			$dt_hr = [];
	// 			$hrs = [];
	// 			for ($h=1; $h < 7; $h++) { 
	// 				$dt_hr[$h] = [];
					
	// 				for($i=0; $i<$len; $i++){
	// 					if($js[$i]['hariId'] == $h){
	// 						$hr[$h]++;
	// 						$dt_hr[$h][] = $js[$i];
	// 					}
	// 				}

	// 				// $hrs[($h-1)] = [
	// 				$hrs[] = [
	// 					"dt_hr" => $dt_hr[$h],
	// 					"cnt" => $hr[$h]
	// 				];
	// 			}

	// 			$arr_by_day = [
  //         "len" => $len,
	// 				"hr" => $hrs,
	// 			];


	// 			$klinik_by_day = [];
	// 			for($i=0; $i<count($arr_by_day['hr']); $i++){ 
	// 				$klinik_by_day[] = [];
	// 				for($j=0; $j<count($arr_by_day['hr'][$i]['dt_hr']); $j++){ 
	// 					//jika spesialis tidak ada di array sp_all_1hari[], masukkan data spesialis
	// 					if(!in_array( $arr_by_day['hr'][$i]['dt_hr'][$j]['Spesialis'], $klinik_by_day[$i] ) ){ 
	// 						$klinik_by_day[$i][] = $arr_by_day['hr'][$i]['dt_hr'][$j]['Spesialis'];
	// 					}
	// 				}
  //       }



	// 	$js_full = array(
	// 			'status' => $status,
	// 			'count'	 => $rowCount,
	// 			'dtjs'	 => $query->result(),
	// 			'arr_by_day' => $arr_by_day,
	// 			'klinik_by_day' => $klinik_by_day,
	// 			'message'=> $message
	// 		);

	// 	return $js_full;
	// }



	public function get_jadok_today($params){
		if($params['fl_klinik'] == 0){
			$q = "SELECT a.Id,
					a.hari,
					a.hariId,
					b.Keterangan as Spesialis,
					b.Kode as Lokasi,
					b.kdpoli_bpjs,
					b.durasi,
					c.Nama,
					c.Kode as kodeDokter,
					c.kd_dpjp_bpjs,
					a.jamMasuk,
					a.jamPulang
				from cm_dokterjadwal a 
				left join bohtmstvendor c on c.kode = a.kodeDokter
				left join fomstlokasi b on b.Kode = c.Lokasi 
				where  a.kodeDokter=c.Kode 
						&& a.hariId=".date('w')."
				order by Spesialis";
		}else{
			$q ="SELECT a.Id,
					a.hari,
					a.hariId,
					b.Keterangan as Spesialis,
					b.Kode as Lokasi,
					b.kdpoli_bpjs,
					c.Nama,
					c.Kode as kodeDokter,
					c.kd_dpjp_bpjs,
					a.jamMasuk,
					a.jamPulang
				from cm_dokterjadwal a 
				left join bohtmstvendor c on c.kode = a.kodeDokter
				left join fomstlokasi b on b.Kode = c.Lokasi 
				where  a.kodeDokter=c.Kode 
						&& a.hariId=".date('w')."
						&& b.Keterangan ='".$params['spesialis'] ."'
				order by Spesialis";
		}
		

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	
	public function get_dokter_cm_internal(){		
		$q = "SELECT 
					'' AS Id, 
					'' AS hari, 
					'' AS hariId, 
					ml.Keterangan AS Spesialis,
					hmk.lokasi AS Lokasi, 
					'' AS kdpoli_bpjs, 
					'' AS durasi, 
					hmk.nama AS Nama, 
					hmk.npp AS kodeDokter,
					'' AS kd_dpjp_bpjs,
					'' AS jamMasuk,
					'' AS jamPulang			
				FROM hrdmstkaryawan hmk
				LEFT JOIN fomstlokasi ml ON ml.Kode=hmk.lokasi
				WHERE hmk.npp = '92607' 
					#OR hmk.npp = '92257' #drg. Yossy Christianto
					OR hmk.npp = '92074' OR hmk.npp = '92260'
			";
			// FROM hrdmstkaryawan WHERE (statuskaryawan = '1' OR statuskaryawan = '3') AND `nama` LIKE '%dr.%'";

		$query = $this->db->query($q)->result_array();

		$add_dokter = [
			"Id" 		=> "",
			"hari" 	=> "",
			"hariId"=> "",
			"Spesialis" => "KLINIK RAWAT LUKA",
			"Lokasi" 		=> "2",
			"kdpoli_bpjs" => "",
			"durasi" 			=> "",
			"Nama" 				=> "dr. Mohammad Atmanegara", // "dr. Yudo Affandi",
			"kodeDokter" 	=> "92607", // "92571",
			"kd_dpjp_bpjs"=> "",
			"jamMasuk" 		=> "",
			"jamPulang" 	=> "",
		];

		array_push($query, $add_dokter);

		$rowCount = true; // $query->num_rows();
		$status = true; //  ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = true; //  ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
			'status' => $status,
			'count'	 => true, // $rowCount,
			'dtjs'	 => $query,
			'message'=> $message
		);

		return $js_full;
	}

	public function get_jadok_by_idhari($params){
		if($params['fl_klinik'] == 0){
			$q = "select a.Id,
					a.hari,
					a.hariId,
					b.Keterangan as Spesialis,
					b.Kode as Lokasi,
					c.Nama,
					c.Kode as kodeDokter,
					a.jamMasuk,
					a.jamPulang
				from cm_dokterjadwal a 
				left join bohtmstvendor c on c.kode = a.kodeDokter
				left join fomstlokasi b on b.Kode = c.Lokasi 
				where  a.kodeDokter=c.Kode && a.hariId=".$params['id_hari']."
				order by Spesialis";
		}else{
			$q ="select a.Id,
					a.hari,
					a.hariId,
					b.Keterangan as Spesialis,
					b.Kode as Lokasi,
					c.Nama,
					c.Kode as kodeDokter,
					a.jamMasuk,
					a.jamPulang
				from cm_dokterjadwal a 
				left join bohtmstvendor c on c.kode = a.kodeDokter
				left join fomstlokasi b on b.Kode = c.Lokasi 
				where  a.kodeDokter=c.Kode 
						&& a.hariId=".$params['id_hari']."
						&& b.Keterangan ='".$params['spesialis'] ."'
				order by Spesialis";
		}
		

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function get_jadok_by_namaspesialis($spesialis){
		$q = "select 
			a.Id,
			a.hari,
			a.hariId,
			b.Keterangan as Spesialis,
			c.Nama,
			a.jamMasuk,
			a.jamPulang 
		from cm_dokterjadwal a
		left join bohtmstvendor c on c.kode = a.kodeDokter
		left join fomstlokasi b on b.Kode = c.Lokasi
		where  a.kodeDokter=c.Kode
				&& b.Keterangan ='".$spesialis."'
		order by a.hariId,c.Nama";		

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	
	public function gd_booking($date, $flag=null){
		// $px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $dt->NoRM )["status_px"];
		if($flag == 'all'){
			$s_flag = "";
		}else{
			$s_flag = "AND a.flag = '0'";
		}

		$q = "SELECT 
			a.nama, a.norm, a.noanggota, a.flag,
			a.penanggung, a.penanggungket, 
			a.lokasi as kd_lokasi, a.lokasiket, ml.kdpoli_bpjs, ml.durasi,
			a.dokter as kd_dokter, a.dokterket, 
			c.kd_dpjp_bpjs, 
			a.tgldaftar, 
			a.user, a.date, a.time, 
			a.norequest,
			a.keterangan,
			mp.Alamat, mp.TglLahir, mp.Sex,
			mp.PRB,
			IF(mp.PRB='1', 'PRB', '') AS prb_str,
			mp.PDP, mp.PDPDate,
			DATEDIFF(CURDATE(), mp.PDPDate) AS PDPSelisihHari,
			IF(mp.PDP=1, IF( DATEDIFF(CURDATE(), mp.PDPDate)<15,'Z038','') ,'') AS PDPStatus,
			CONCAT('BOOK', DATE_ADD(a.date, INTERVAL 1 DAY) ) AS nobill_book_tracer,
			'LAMA' AS st_px_baru_lama
		FROM fotrbooking a
		LEFT JOIN fomstpasien mp ON mp.NoRM = a.norm
		LEFT JOIN bohtmstvendor c ON c.Kode = a.dokter
		LEFT JOIN fomstlokasi ml ON ml.Kode=c.Lokasi
		WHERE a.date= '".$date."' ".$s_flag."
		ORDER BY a.lokasiket, a.norequest, a.time";		

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name' 	 => 'gd_booking',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}


	public function gd_booking_all($date){
		// $px_baru_lama = $this->m_daftarmandiri->gd_st_px_baru_lama_by_norm_n( $dt->NoRM )["status_px"];
									
		$q = "SELECT 
			a.nama, a.norm, a.noanggota, a.flag,
			a.penanggung, a.penanggungket, 
			a.lokasi as kd_lokasi, a.lokasiket, a.dokter as kd_dokter, 
			a.dokterket, 
			c.kd_dpjp_bpjs, 
			a.tgldaftar, 
			a.user, a.date, a.time, 
			a.norequest,
			a.keterangan,
			mp.Alamat, mp.TglLahir, mp.Sex
		FROM fotrbooking a
		LEFT JOIN fomstpasien mp ON mp.NoRM = a.norm
		LEFT JOIN bohtmstvendor c ON c.Kode = a.dokter
		WHERE a.date= '".$date."' AND a.flag = '0'
		ORDER BY a.lokasiket, a.norequest, a.time";		

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name' 	 => 'gd_booking_all',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function gd_booking_by_datetime($date, $time){ //get 1 pasien
		$q = "select * from fotrbooking where date= '".$date."' && time = '".$time."'";		

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name' 	 => 'gd_booking_by_datetime',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}
	
	// NEW 2020.03.02
	public function gd_booking_by_norm_date($norm=null, $date=null){ //get 1 pasien
		$q = "SELECT * from fotrbooking where norm='".$norm."' AND date= '".$date."'";		

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name' 	 => 'gd_booking_by_norm_date',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function delete_booking_by_date($date){
		// $where = array(
		// 		'date' => $date,
		// 		'flag' => 0
		// 	);
		// $this->db->where($where);
	 //    $this->db->delete('fotrbooking');

		$where = array(
		        'date' => $date,
				'flag' => 0
			);

		$data = array(
				'flag' => 1
			);
		$this->db->where($where);
		$this->db->update('fotrbooking', $data);
	}
	
	public function delete_booking($date=null, $time=null, $norm=null){
		// $where = array(
		// 		'date' => $date,
		// 		'flag' => 0
		// 	);
		// $this->db->where($where);
	 //    $this->db->delete('fotrbooking');

		$where = [
		    'date' => $date,
		    'time' => $time,
		    'norm' => $norm,
				'flag' => 0
			];

		$data = [ 'flag' => 1 ];
		$this->db->where($where);
		$this->db->update('fotrbooking', $data);
	}

	public function select_booking_count($data=null){
		$this->db->select('*');
		$this->db->from('fotrbooking');
		// $this->db->join('mutumst', 'mutumst.id = mutumstbln.idIndikator', 'left');
		$where = "date='".$data['date']."' AND lokasi='".$data['lokasi']."'";
		$this->db->where($where);
		$query = $this->db->get();

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		$js_full = array(
				'name'	 => $this->uri->segment(2),
				'status' => $status,
				'count'	 => $rowCount,
				// 'datajs' => $query->result(),
			);

		return $js_full;
	}

	// NEW 2020.01.14
	public function get_new_norequest($date=null, $lokasi=null){
		$this->db->select('*');
		$this->db->from('fotrbooking');
		$where = "date='".$date."' AND lokasi='".$lokasi."'";
		$this->db->where($where);
		$query = $this->db->get();

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		$js_full = [
				'status' => $status,
				'count'	 => $rowCount,
				'norequest_next' => $rowCount+1,
			];

		return $js_full;
	}

	//cari nama dokter dalam dan dokter luar
	public function cari_namadokter_by_kddokter($kd_dokter){
		$q = "select 
				IF( COUNT(a.Nama)>0, 
					a.Nama, 
					(select nama from hrdmstkaryawan where kode = '".$kd_dokter."')
		 		)  as val 
		 	from bohtmstvendor a where a.kode = '".$kd_dokter."'";


		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		return $query->result();
	}



	//EX QUERY IF
	// #b.Dokter as kd_dokter,
	// 			IF(a.StatusDaftar='UG', ugd.dokterrs, b.Dokter) as kd_dokter,
	// 			(select 
	// 				IF( COUNT(c.Nama)>0, 
	// 					c.Nama,  
	// 					(select nama from hrdmstkaryawan where kode = b.Dokter)
	// 		 		)
	// 		 		from bohtmstvendor c where c.kode = b.Dokter
	// 		 	) as NamaDokter,
	// 			# d.Keterangan as Lokasi,
	// 			b.Lokasi as kd_lokasi,
	// 			a.NoBill, a.NoRM, a.StatusDaftar, mp.Barcode, a.nosep, a.TanggalMasuk, a.Nama, 
	// 			a.PerusahaanPenanggung as kd_penanggung, a.NoAnggota as penanggung,
	// 			#b.Dokter as kd_dokter,
	// 			IF(a.StatusDaftar='UG', ugd.dokterrs, b.Dokter) as kd_dokter,
	// 			# d.Keterangan as Lokasi,
	// 			b.Lokasi as kd_lokasi,
				
	// 			IF(a.StatusDaftar='UG', 'IGD', d.Keterangan) as Lokasi,
	// 			IF(a.StatusDaftar='UG', (SELECT Kode from fomstlokasi where Keterangan='I G D'), b.Lokasi) as kd_lokasi_n,
	// 			IF(a.StatusDaftar='UG', (select nama from hrdmstkaryawan hrd where hrd.kode = b.Dokter),c.Nama) as NamaDokter
	public function gd_pasienrj_by_date($date){
		$q = "select 
				a.NoBill, a.NoRM, a.StatusDaftar, mp.Barcode, a.nosep, a.TanggalMasuk, a.Nama, 
				a.PerusahaanPenanggung as kd_penanggung, a.NoAnggota as penanggung,
				#b.Dokter as kd_dokter,
				IF(a.StatusDaftar='UG', ugd.dokterrs, 
					IF(a.StatusDaftar='RJ', b.Dokter, '')					
				) as kd_dokter,

				IF(a.StatusDaftar='UG', (select nama from hrdmstkaryawan hrd where hrd.kode = kd_dokter),
					IF(a.StatusDaftar='RJ', c.Nama, 'RI')				
				) as NamaDokter,
				# d.Keterangan as Lokasi,

				b.Lokasi as kd_lokasi,
				# IF(a.StatusDaftar='UG', (SELECT Kode from fomstlokasi where Keterangan='I G D'), b.Lokasi) as kd_lokasi,
				IF(a.StatusDaftar='UG', (SELECT Kode from fomstlokasi where Keterangan='I G D'), b.Lokasi) as kd_lokasi_n,
				
				IF(a.StatusDaftar='UG', 
					IF(ISNULL(b.Lokasi),'IGD', d.Keterangan),
					IF(a.StatusDaftar='RJ', d.Keterangan, 'RI')
				) as Lokasi
				#d.Keterangan as Lokasi
				
				
			from fotrdaftar a 
			left join fotrdaftarrj b on b.NoBill = a.NoBill
			left join fotrdaftarugd ugd on ugd.nobill = a.NoBill
			left join bohtmstvendor c on c.kode = b.Dokter
			left join fomstlokasi d on d.Kode = b.Lokasi 
			left join fomstpasien mp on mp.NoRM = a.NoRM 
			where  a.Date= '".$date."' AND a.FlagBill<>4
			order by a.NoBill";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name' 	 => 'gd_pasienrj_by_date',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}


	public function laporan_pendaftaran_px($segment=null, $date=null){
		$query_all = [];
		// $segment_lbl = ["UGD", "RJ", "RI"];		
		// for()

		switch ($segment) {
			case 'IGD':
				$q[$segment] = "
					SELECT 
					    'IGD' as segment,'' as nourut,
					    trim(y.tanggalmasuk) as tanggalmasuk,
					    trim(y.tanggalkeluar) as tanggalkeluar,
					    time_format(y.jammasuk,'%T') as jammasuk, 
					    time_format(y.jamkeluar,'%T') as jamkeluar,
					    'IGD' as lokasi, y.norm, a.nobill, z.Barcode as noka,
							z.nama, z.alamat, z.rt, z.rw, z.tgllahir, z.HP,
					    if(z.pendidikan='' or isnull(z.pendidikan),'-',
								if(z.pendidikan=1,'TK',
									if(z.pendidikan=2,'SD',
										if(z.pendidikan=3,'SLTP',
											if(z.pendidikan=4,'SLTA',
												if(z.pendidikan=5,'D1',
													if(z.pendidikan=6,'D2',
														if(z.pendidikan=7,'D3',
															if(z.pendidikan=8,'S1',
																if(z.pendidikan=9,'S2','S3')))))))))) as pendidikan, 
					    if(z.agama='' or isnull(z.agama),'-',if(z.agama='BD','BUDHA',if(z.agama='HD','HINDU',if(z.agama='IS','ISLAM',if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
					    (f.keterangan) as kelurahan, (g.keterangan) as kecamatan, (h.keterangan) as kota,
					    y.statusbl as statuspasien,
							y.sex as jeniskelamin,
							y.umurtahun as umur,
							#w.nama as perusahaanpenanggung,
							y.perusahaanpenanggung as penanggung_kd,
							w.nama as penanggung_ket,
							if(y.flagbill=0,'Aktif',if(y.flagbill=1,'keluar',if(y.flagbill=2,'Pending',if(y.flagbill=3,'Dummy','Batal')))) as statusbill, 
							y.keterangan, j.keterangan as caramasuk,
							y.asalPPK, i.keterangan as asalinstansi, a.user,
							d.keterangan as diagnosa,
							y.nosep, y.noskdp, 
							'' as rujukan, '' as tglrujukan,
							z.sukubangsa,
							#'' as lokasi_kd, '' as lokasi_ket,
							'' as dokter_kd, '' as dokter_nama
					from fotrdaftarugd a
					left join fotrdaftar y on y.nobill=a.nobill 
					left join fomstpasien z on z.norm=y.norm
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung 
					left join fomstdiagnosaawal d on d.kode=y.diagnosaawal
					left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
					left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
					left join fowilmstkota h on z.kota=h.kode
					left join fotrasalpasien i on i.kode=y.asalinstansi
					left join forimstcaramasuk j on y.caramasuk=j.kode
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.tanggalmasuk>='".$date."'
						and y.tanggalmasuk<='".$date."'
					order by y.tanggalmasuk, y.nobill
				";

				$query[$segment] = $this->db->query($q[$segment])->result_array();
				array_push($query_all, $query[$segment]);

				break;

			case 'RJ':
				$q[$segment] = "
					SELECT 
					    'RJ' as segment, 
					    right(nourut,3) as nourut,
					    trim(y.tanggalmasuk) as tanggalmasuk,
					    trim(y.tanggalkeluar) as tanggalkeluar,
					    time_format(y.jammasuk,'%T') as jammasuk,
							time_format(y.jamkeluar,'%T') as jamkeluar, 
							x.keterangan as lokasi,
							y.norm, a.nobill, z.Barcode as noka,
							z.nama, z.alamat,
							z.rt, z.rw, z.tgllahir, z.HP,
					    if(z.pendidikan='' or isnull(z.pendidikan),'-',
								if(z.pendidikan=1,'TK',
									if(z.pendidikan=2,'SD',
										if(z.pendidikan=3,'SLTP',
											if(z.pendidikan=4,'SLTA',
												if(z.pendidikan=5,'D1',
													if(z.pendidikan=6,'D2',
														if(z.pendidikan=7,'D3',
															if(z.pendidikan=8,'S1',
																if(z.pendidikan=9,'S2','S3')
								))))))))) as pendidikan,
					    if(z.agama='' or isnull(z.agama),'-',
								if(z.agama='BD','BUDHA',
									if(z.agama='HD','HINDU',
										if(z.agama='IS','ISLAM',
											if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
					    (f.keterangan) as kelurahan,
							(g.keterangan) as kecamatan,
							(h.keterangan) as kota,
					    y.statusbl as statuspasien,
							y.sex as jeniskelamin,
							y.umurtahun as umur,
							#if(w.nama='' or isnull(w.nama),'-',w.nama) as perusahaanpenanggung,
							y.perusahaanpenanggung as penanggung_kd,
							if(w.nama='' or isnull(w.nama),'-',w.nama) as penanggung_ket,
								if(y.flagbill=0,'Aktif',
									if(y.flagbill=1,'keluar',
										if(y.flagbill=2,'Pending',
											if(y.flagbill=3,'Dummy','Batal')))) as statusbill, 
							y.keterangan,
							j.keterangan as caramasuk,
							y.asalPPK,
							i.keterangan as asalinstansi,
							a.user,
							d.keterangan as diagnosa, y.nosep, y.noskdp, 
							a.Rujukan as rujukan, a.tglrujukan as tglrujukan,
							z.sukubangsa,
							#x.Kode as lokasi_kd, x.Keterangan as lokasi_ket,
							a.Dokter as dokter_kd, mv.Nama as dokter_nama
					from fotrdaftarrj a
					left join fomstlokasi x on x.kode=a.lokasi
					left join fotrdaftar y on y.nobill=a.nobill
					left join fomstpasien z on z.norm=y.norm
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung
					left join fomstdiagnosaawal d on d.kode=y.diagnosaawal
					left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
					left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
					left join fowilmstkota h on z.kota=h.kode
					left join fotrasalpasien i on i.kode=y.asalinstansi
					left join forimstcaramasuk j on y.caramasuk=j.kode
					left join bohtmstvendor mv on mv.Kode=a.Dokter
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.tanggalmasuk>='".$date."' 
						and y.tanggalmasuk<='".$date."'
					order by y.tanggalmasuk, a.nourut, y.nobill
				";

				$query[$segment] = $this->db->query($q[$segment])->result_array();
				array_push($query_all, $query[$segment]);

				break;

			case 'RI':
				$q[$segment] = "
					SELECT 
					    'RI' as segment, '' as nourut, 
					    trim(y.tanggalmasuk) as tanggalmasuk,
							trim(y.tanggalkeluar) as tanggalkeluar,
							time_format(y.jammasuk,'%T') as jammasuk,
							time_format(y.jamkeluar,'%T') as jamkeluar,
							'Rawat Inap' as lokasi,
							y.norm, a.nobill, z.Barcode as noka,
							z.nama, z.alamat,
							z.rt, z.rw, z.tgllahir, z.HP,
					    if(z.pendidikan='' or isnull(z.pendidikan),'-',
								if(z.pendidikan=1,'TK',
									if(z.pendidikan=2,'SD',
										if(z.pendidikan=3,'SLTP',
											if(z.pendidikan=4,'SLTA',
												if(z.pendidikan=5,'D1',
													if(z.pendidikan=6,'D2',
														if(z.pendidikan=7,'D3',
															if(z.pendidikan=8,'S1',
																if(z.pendidikan=9,'S2','S3')))))))))) as pendidikan,
					    if(z.agama='' or isnull(z.agama),'-',if(z.agama='BD','BUDHA',if(z.agama='HD','HINDU',if(z.agama='IS','ISLAM',if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
					    (f.keterangan) as kelurahan,
							(g.keterangan) as kecamatan, (h.keterangan) as kota,
					    y.statusbl as statuspasien, y.sex as jeniskelamin, y.umurtahun as umur,
							# w.nama as perusahaanpenanggung,
							y.perusahaanpenanggung as penanggung_kd,
							w.nama as penanggung_ket,
						
					    if(y.flagbill=0,'Aktif',if(y.flagbill=1,'keluar',if(y.flagbill=2,'Pending',if(y.flagbill=3,'Dummy','Batal')))) as statusbill,
							y.keterangan, j.keterangan as caramasuk,
							y.asalPPK, i.keterangan as asalinstansi, a.user,
							d.keterangan as diagnosa, y.nosep, y.noskdp, 
							'' as rujukan, '' as tglrujukan,
							z.sukubangsa,
							#'' as lokasi_kd, '' as lokasi_ket,
							'' as dokter_kd, '' as dokter_nama
					from fotrdaftarri a 
					left join fotrdaftar y on y.nobill=a.nobill
					left join fomstpasien z on z.norm=y.norm 
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung 
					left join fomstdiagnosaawal d on d.kode=y.diagnosaawal 
					left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
					left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
					left join fowilmstkota h on z.kota=h.kode 
					left join fotrasalpasien i on i.kode=y.asalinstansi 
					left join forimstcaramasuk j on y.caramasuk=j.kode 
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.tanggalmasuk>='".$date."'
						and y.tanggalmasuk<='".$date."'
					order by y.tanggalmasuk, y.nobill
				";

				$query[$segment] = $this->db->query($q[$segment])->result_array();
				array_push($query_all, $query[$segment]);

				break;
			
			default:
				# code...
				break;
		}
				

		// $query_all = $query["RJ"];

		return $query_all;
	}



	public function px_by_bill($nobill=null){
		// HATI-HATI, untuk NOBILL yang memiliki 2 lokasi di RJ
		$q = "SELECT td.NoBill as nobill, td.StatusDaftar AS segment
				, (IF(td.StatusDaftar='RJ', (SELECT Lokasi FROM fotrdaftarrj WHERE NoBill=? AND Lokasi=1), '') ) AS lokasi
				, (IF(td.StatusDaftar='RJ', 
						(SELECT ml.keterangan 
							FROM fotrdaftarrj j 
							LEFT JOIN fomstlokasi ml ON ml.Kode=j.Lokasi 
							WHERE NoBill=? AND Lokasi=1), '') ) AS lokasiket
			FROM fotrdaftar td
			WHERE td.NoBill=?
		";

		$query = $this->db->query($q, [$nobill, $nobill, $nobill])->row_array();
		$detail = $this->laporan_pendaftaran_px_soft_by_bill($query['segment'], $nobill, $query['lokasi']);
		if(count($detail)>0) $detail = $detail[0];
		
		$val = [
			"data" => $query, 
			"detail" => $detail, 
		];
		return $val;
	}

	
	// ALTERNATIF RINGAN, DIPAKAI
	public function laporan_pendaftaran_px_soft_by_bill($segment=null, $nobill=null, $kodelokasi=null){
		
		switch ($segment) {
			case 'UG':
			case 'IGD':
				$q = "SELECT 
					    'IGD' as segment,'' as nourut,
					    trim(y.tanggalmasuk) as tanggalmasuk,
					    trim(y.tanggalkeluar) as tanggalkeluar,
					    time_format(y.jammasuk,'%T') as jammasuk, 
					    time_format(y.jamkeluar,'%T') as jamkeluar,
					    'IGD' as lokasi, 
							'IGD' as lokasikode,
							y.norm, a.nobill, z.Barcode as noka,
							z.nama, z.alamat, z.rt, z.rw, z.tgllahir, z.HP,
					    if(z.pendidikan='' or isnull(z.pendidikan),'-',
								if(z.pendidikan=1,'TK',
									if(z.pendidikan=2,'SD',
										if(z.pendidikan=3,'SLTP',
											if(z.pendidikan=4,'SLTA',
												if(z.pendidikan=5,'D1',
													if(z.pendidikan=6,'D2',
														if(z.pendidikan=7,'D3',
															if(z.pendidikan=8,'S1',
																if(z.pendidikan=9,'S2','S3')))))))))) as pendidikan, 
					    if(z.agama='' or isnull(z.agama),'-',if(z.agama='BD','BUDHA',if(z.agama='HD','HINDU',if(z.agama='IS','ISLAM',if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
					    (f.keterangan) as kelurahan, (g.keterangan) as kecamatan, (h.keterangan) as kota,
					    y.statusbl as statuspasien,
							y.sex as jeniskelamin,
							IF(y.sex='L', 'LAKI-LAKI','PEREMPUAN') as jeniskelamin_str,
							y.umurtahun as umur,
							#w.nama as perusahaanpenanggung,
							y.perusahaanpenanggung as penanggung_kd,
							w.nama as penanggung_ket,
							if(y.flagbill=0,'Aktif',if(y.flagbill=1,'keluar',if(y.flagbill=2,'Pending',if(y.flagbill=3,'Dummy','Batal')))) as statusbill, 
							y.keterangan, j.keterangan as caramasuk,
							y.asalPPK, i.keterangan as asalinstansi, a.user,
							d.keterangan as diagnosa,
							y.nosep, y.noskdp, 
							'' as rujukan, '' as tglrujukan,
							z.sukubangsa,
							'' as dokter_kd, '' as dokter_nama,
							z.PRB,
							IF(z.PRB='1', 'PRB', '') AS prb_str,
							z.PDP, z.PDPDate, 
							DATEDIFF(CURDATE(), z.PDPDate) AS PDPSelisihHari,
							IF(z.PDP=1, IF( DATEDIFF(CURDATE(), z.PDPDate)<15,'Z038','') ,'') AS PDPStatus
					from fotrdaftarugd a
					left join fotrdaftar y on y.nobill=a.nobill 
					left join fomstpasien z on z.norm=y.norm
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung 
					left join fomstdiagnosaawal d on d.kode=y.diagnosaawal
					left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
					left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
					left join fowilmstkota h on z.kota=h.kode
					left join fotrasalpasien i on i.kode=y.asalinstansi
					left join forimstcaramasuk j on y.caramasuk=j.kode
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.nobill = ?
				";
				$bind = [$nobill];
				// $query[$segment] = $this->db->query($q[$segment])->result_array();
				// array_push($query_all, $query[$segment]);

				break;

			case 'RJ':
				$q = "SELECT 
					    'RJ' as segment, 
					    right(nourut,3) as nourut,
					    trim(y.tanggalmasuk) as tanggalmasuk,
					    trim(y.tanggalkeluar) as tanggalkeluar,
					    time_format(y.jammasuk,'%T') as jammasuk,
							time_format(y.jamkeluar,'%T') as jamkeluar, 
							x.keterangan as lokasi,
							x.Kode as lokasikode,
							y.norm, a.nobill, z.Barcode as noka,
							z.nama, z.alamat,
							z.rt, z.rw, z.tgllahir, z.HP,
					    if(z.pendidikan='' or isnull(z.pendidikan),'-',
								if(z.pendidikan=1,'TK',
									if(z.pendidikan=2,'SD',
										if(z.pendidikan=3,'SLTP',
											if(z.pendidikan=4,'SLTA',
												if(z.pendidikan=5,'D1',
													if(z.pendidikan=6,'D2',
														if(z.pendidikan=7,'D3',
															if(z.pendidikan=8,'S1',
																if(z.pendidikan=9,'S2','S3')
								))))))))) as pendidikan,
					    if(z.agama='' or isnull(z.agama),'-',
								if(z.agama='BD','BUDHA',
									if(z.agama='HD','HINDU',
										if(z.agama='IS','ISLAM',
											if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
					    (f.keterangan) as kelurahan,
							(g.keterangan) as kecamatan,
							(h.keterangan) as kota,
					    y.statusbl as statuspasien,
							y.sex as jeniskelamin,
							IF(y.sex='L', 'LAKI-LAKI','PEREMPUAN') as jeniskelamin_str,
							y.umurtahun as umur,
							#if(w.nama='' or isnull(w.nama),'-',w.nama) as perusahaanpenanggung,
							y.perusahaanpenanggung as penanggung_kd,
							if(w.nama='' or isnull(w.nama),'-',w.nama) as penanggung_ket,
								if(y.flagbill=0,'Aktif',
									if(y.flagbill=1,'keluar',
										if(y.flagbill=2,'Pending',
											if(y.flagbill=3,'Dummy','Batal')))) as statusbill, 
							y.keterangan,
							j.keterangan as caramasuk,
							y.asalPPK,
							i.keterangan as asalinstansi,
							a.user,
							d.keterangan as diagnosa, y.nosep, y.noskdp, 
							a.Rujukan as rujukan, a.tglrujukan as tglrujukan,
							z.sukubangsa,
							a.Dokter as dokter_kd, mv.Nama as dokter_nama,
							z.PRB,
							IF(z.PRB='1', 'PRB', '') AS prb_str,
							z.PDP, z.PDPDate, 
							DATEDIFF(CURDATE(), z.PDPDate) AS PDPSelisihHari,
							IF(z.PDP=1, IF( DATEDIFF(CURDATE(), z.PDPDate)<15,'Z038','') ,'') AS PDPStatus
					from fotrdaftarrj a
					left join fomstlokasi x on x.kode=a.lokasi
					left join fotrdaftar y on y.nobill=a.nobill
					left join fomstpasien z on z.norm=y.norm
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung
					left join fomstdiagnosaawal d on d.kode=y.diagnosaawal
					left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
					left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
					left join fowilmstkota h on z.kota=h.kode
					left join fotrasalpasien i on i.kode=y.asalinstansi
					left join forimstcaramasuk j on y.caramasuk=j.kode
					left join bohtmstvendor mv on mv.Kode=a.Dokter
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.nobill = ?
						and a.Lokasi = ?
				";
				$bind = [$nobill, $kodelokasi];
				// $query[$segment] = $this->db->query($q[$segment])->result_array();
				// array_push($query_all, $query[$segment]);

				break;

			case 'RI':
				$q = "SELECT 
					    'RI' as segment, '' as nourut, 
					    trim(y.tanggalmasuk) as tanggalmasuk,
							trim(y.tanggalkeluar) as tanggalkeluar,
							time_format(y.jammasuk,'%T') as jammasuk,
							time_format(y.jamkeluar,'%T') as jamkeluar,
							'Rawat Inap' as lokasi,
							'Rawat Inap' as lokasikode,
							y.norm, a.nobill, z.Barcode as noka,
							z.nama, z.alamat,
							z.rt, z.rw, z.tgllahir, z.HP,
					    if(z.pendidikan='' or isnull(z.pendidikan),'-',
								if(z.pendidikan=1,'TK',
									if(z.pendidikan=2,'SD',
										if(z.pendidikan=3,'SLTP',
											if(z.pendidikan=4,'SLTA',
												if(z.pendidikan=5,'D1',
													if(z.pendidikan=6,'D2',
														if(z.pendidikan=7,'D3',
															if(z.pendidikan=8,'S1',
																if(z.pendidikan=9,'S2','S3')))))))))) as pendidikan,
					    if(z.agama='' or isnull(z.agama),'-',if(z.agama='BD','BUDHA',if(z.agama='HD','HINDU',if(z.agama='IS','ISLAM',if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
					    (f.keterangan) as kelurahan,
							(g.keterangan) as kecamatan, (h.keterangan) as kota,
					    y.statusbl as statuspasien, 
							y.sex as jeniskelamin, 
							IF(y.sex='L', 'LAKI-LAKI','PEREMPUAN') as jeniskelamin_str,
							y.umurtahun as umur,
							y.perusahaanpenanggung as penanggung_kd,
							w.nama as penanggung_ket,						
					    if(y.flagbill=0,'Aktif',if(y.flagbill=1,'keluar',if(y.flagbill=2,'Pending',if(y.flagbill=3,'Dummy','Batal')))) as statusbill,
							y.keterangan, j.keterangan as caramasuk,
							y.asalPPK, i.keterangan as asalinstansi, a.user,
							d.keterangan as diagnosa, y.nosep, y.noskdp, 
							'' as rujukan, '' as tglrujukan,
							z.sukubangsa,
							'' as dokter_kd, '' as dokter_nama,
							z.PRB,
							IF(z.PRB='1', 'PRB', '') AS prb_str,
							z.PDP, z.PDPDate, 
							DATEDIFF(CURDATE(), z.PDPDate) AS PDPSelisihHari,
							IF(z.PDP=1, IF( DATEDIFF(CURDATE(), z.PDPDate)<15,'Z038','') ,'') AS PDPStatus
					from fotrdaftarri a 
					left join fotrdaftar y on y.nobill=a.nobill
					left join fomstpasien z on z.norm=y.norm 
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung 
					left join fomstdiagnosaawal d on d.kode=y.diagnosaawal 
					left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
					left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
					left join fowilmstkota h on z.kota=h.kode 
					left join fotrasalpasien i on i.kode=y.asalinstansi 
					left join forimstcaramasuk j on y.caramasuk=j.kode 
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.nobill = ?
				";
				$bind = [$nobill];

				// $query[$segment] = $this->db->query($q[$segment])->result_array();
				// array_push($query_all, $query[$segment]);

				break;
			
			case 'BOOK_RJ':
				$norm = $nobill; //
				$q = "SELECT 
					    'BOOK_RJ' as segment, 
					    a.norequest as nourut,
					    '' as tanggalmasuk,
					    '' as tanggalkeluar,
					    '' as jammasuk,
							'' as jamkeluar, 
							x.keterangan as lokasi,
							x.Kode as lokasikode,
							a.norm, 
							CONCAT('BOOK', a.tgldaftar) AS nobill, 
							CONCAT('BOOK', a.tgldaftar) AS nobill_booking, 
							z.Barcode as noka,
							z.nama, z.alamat,
							z.rt, z.rw, z.tgllahir, z.HP,
					    if(z.pendidikan='' or isnull(z.pendidikan),'-',
								if(z.pendidikan=1,'TK', if(z.pendidikan=2,'SD',
										if(z.pendidikan=3,'SLTP', if(z.pendidikan=4,'SLTA',
												if(z.pendidikan=5,'D1', if(z.pendidikan=6,'D2',
														if(z.pendidikan=7,'D3', if(z.pendidikan=8,'S1',
																if(z.pendidikan=9,'S2','S3')
								))))))))) as pendidikan,
					    if(z.agama='' or isnull(z.agama),'-',
								if(z.agama='BD','BUDHA',
									if(z.agama='HD','HINDU',
										if(z.agama='IS','ISLAM',
											if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
					    (f.keterangan) as kelurahan,
							(g.keterangan) as kecamatan,
							(h.keterangan) as kota,
					    (SELECT IF((SELECT COUNT(nobill) FROM fotrdaftar WHERE norm = ?)>0, 'LAMA', 'BARU') ) AS statuspasien,
							z.Sex as jeniskelamin,
							TIMESTAMPDIFF( YEAR, z.tgllahir, CURDATE()) AS umur,
							a.penanggung as penanggung_kd,
							if(w.nama='' or isnull(w.nama),'-',w.nama) as penanggung_ket,
							if(a.flag=0,'Aktif', 'Nonaktif') as statusbill, 
							a.keterangan,
							-- j.keterangan as caramasuk,
							-- y.asalPPK,
							a.instansiket as asalinstansi,
							a.user,
							d.keterangan as diagnosa, 
							-- y.nosep, y.noskdp, 
							-- a.Rujukan as rujukan, a.tglrujukan as tglrujukan,
							z.sukubangsa,
							a.dokter as dokter_kd, mv.Nama as dokter_nama,
							z.PRB,
							IF(z.PRB='1', 'PRB', '') AS prb_str,
							z.PDP, z.PDPDate, 
							DATEDIFF(CURDATE(), z.PDPDate) AS PDPSelisihHari,
							IF(z.PDP=1, IF( DATEDIFF(CURDATE(), z.PDPDate)<15,'Z038','') ,'') AS PDPStatus
					from fotrbooking a
					left join fomstlokasi x on x.kode=a.lokasi
					-- left join fotrdaftar y on y.nobill=a.nobill
					left join fomstpasien z on z.norm=a.norm
					left join boptmstcustomer w on w.kode=a.penanggung
					left join fomstdiagnosaawal d on d.kode=a.diagnosa
					left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
					left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
					left join fowilmstkota h on z.kota=h.kode
					-- left join fotrasalpasien i on i.kode=y.asalinstansi
					-- left join forimstcaramasuk j on y.caramasuk=j.kode
					left join bohtmstvendor mv on mv.Kode=a.dokter
					where 
						-- y.diagnosaawal<>283 and y.FlagBill<>4
						a.norm = ?
						and a.flag = 0
				";
				$bind = [$nobill, $nobill];
				break;

			case 'PRINT_FROM_POST':
					$q = "SELECT '' AS result" ;
					$bind=null;
				break;
			
			default:
					$q = "SELECT '' AS result" ;
					$bind=null;
				break;
		}
		
		$query = $this->db->query($q, $bind)->result_array();
		return $query;
	}





	// ALTERNATIF RINGAN
	public function laporan_pendaftaran_px_soft($segment=null, $date=null){
		$q = [
			"IGD" => "SELECT 
							'IGD' as segment,'' as nourut,
							'' as kodelokasi,
							'IGD' as lokasi, 
							y.norm, a.nobill, z.Barcode as noka,
							z.nama,
							y.statusbl as statuspasien,
							y.perusahaanpenanggung as penanggung_kd,
							w.nama as penanggung_ket,
							if(y.flagbill=0,'Aktif',if(y.flagbill=1,'keluar',if(y.flagbill=2,'Pending',if(y.flagbill=3,'Dummy','Batal')))) as statusbill,
							y.nosep, y.noskdp,
							'' as dokter_kd, '' as dokter_nama
					from fotrdaftarugd a
					left join fotrdaftar y on y.nobill=a.nobill 
					left join fomstpasien z on z.norm=y.norm
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.tanggalmasuk='".$date."'
					order by y.tanggalmasuk, y.nobill",

			"RJ" => "SELECT 
							'RJ' as segment, 
							right(nourut,3) as nourut,
							x.Kode as kodelokasi,
							x.Keterangan as lokasi,
							y.norm, a.nobill, z.Barcode as noka,
							z.nama,							
							y.statusbl as statuspasien,
							#if(w.nama='' or isnull(w.nama),'-',w.nama) as perusahaanpenanggung,
							y.perusahaanpenanggung as penanggung_kd,
							if(w.nama='' or isnull(w.nama),'-',w.nama) as penanggung_ket,
								if(y.flagbill=0,'Aktif',
									if(y.flagbill=1,'keluar',
										if(y.flagbill=2,'Pending',
											if(y.flagbill=3,'Dummy','Batal')))) as statusbill, 
							y.nosep, y.noskdp,
							a.Dokter as dokter_kd, mv.Nama as dokter_nama
					from fotrdaftarrj a
					left join fomstlokasi x on x.kode=a.lokasi
					left join fotrdaftar y on y.nobill=a.nobill
					left join fomstpasien z on z.norm=y.norm
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung
					
					left join bohtmstvendor mv on mv.Kode=a.Dokter
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.tanggalmasuk='".$date."'
					order by y.tanggalmasuk, a.nourut, y.nobill",

			"RI" => "SELECT 
							'RI' as segment, '' as nourut,
							'' as kodelokasi,
							'Rawat Inap' as lokasi,
							y.norm, a.nobill, z.Barcode as noka,
							z.nama,
							y.statusbl as statuspasien,
							# w.nama as perusahaanpenanggung,
							y.perusahaanpenanggung as penanggung_kd,
							w.nama as penanggung_ket,
							if(y.flagbill=0,'Aktif',if(y.flagbill=1,'keluar',if(y.flagbill=2,'Pending',if(y.flagbill=3,'Dummy','Batal')))) as statusbill,
							y.nosep, y.noskdp,
							'' as dokter_kd, '' as dokter_nama
					from fotrdaftarri a 
					left join fotrdaftar y on y.nobill=a.nobill
					left join fomstpasien z on z.norm=y.norm 
					left join boptmstcustomer w on w.kode=y.perusahaanpenanggung 
					where y.diagnosaawal<>283 and y.FlagBill<>4
						and y.tanggalmasuk='".$date."'
					order by y.tanggalmasuk, y.nobill",
		];


		switch ($segment) {
			case 'IGD':
				$query_val = $this->db->query($q[$segment])->result_array();
				break;

			case 'RJ':
				$query_val = $this->db->query($q[$segment])->result_array();
				break;

			case 'RI':
				$query_val = $this->db->query($q[$segment])->result_array();
				break;
			
			case 'ALL':
				$result = [];
				$segment_lbl = ["IGD", "RJ", "RI"];
				for ($i=0; $i<count($segment_lbl) ; $i++) {
					$data = $this->db->query($q[ $segment_lbl[$i] ] )->result_array();
					array_push($result, $data);
				}

				$val = [];
				$cnt = 0;
				for ($i=0; $i < count($result) ; $i++) { 
					for ($j=0; $j < count($result[$i]) ; $j++) { 
						$val[$cnt] = $result[$i][$j];
						$cnt++;
					}
				}

				// $query_val = $result;
				$query_val = $val;
				break;
			
			default:
				# code...
				break;
		}
		

		return $query_val;
	}




	//
	public function pxri_det($nobill=null){
		$q = "SELECT 
						'RI' as segment, '' as nourut, 
						trim(y.tanggalmasuk) as tanggalmasuk,
						trim(y.tanggalkeluar) as tanggalkeluar,
						time_format(y.jammasuk,'%T') as jammasuk,
						time_format(y.jamkeluar,'%T') as jamkeluar,
						'Rawat Inap' as lokasi,
						y.norm, a.nobill, 
						a.Kodebed,
						k.keterangan as kelas_ruang,
						a.Tarif as tarif_bedri,
						-- bd.Keterangan as BedKet,
						z.Barcode as noka,
						z.nama, z.alamat,
						z.rt, z.rw, z.tgllahir, z.HP,
						if(z.pendidikan='' or isnull(z.pendidikan),'-',
							if(z.pendidikan=1,'TK',
								if(z.pendidikan=2,'SD',
									if(z.pendidikan=3,'SLTP',
										if(z.pendidikan=4,'SLTA',
											if(z.pendidikan=5,'D1',
												if(z.pendidikan=6,'D2',
													if(z.pendidikan=7,'D3',
														if(z.pendidikan=8,'S1',
															if(z.pendidikan=9,'S2','S3')))))))))) as pendidikan,
						if(z.agama='' or isnull(z.agama),'-',if(z.agama='BD','BUDHA',if(z.agama='HD','HINDU',if(z.agama='IS','ISLAM',if(z.agama='KR','KRISTEN','KATHOLIK'))))) as agama,
						(f.keterangan) as kelurahan,
						(g.keterangan) as kecamatan, (h.keterangan) as kota,
						y.statusbl as statuspasien, y.sex as jeniskelamin, y.umurtahun as umur,
						# w.nama as perusahaanpenanggung,
						y.perusahaanpenanggung as penanggung_kd,
						w.nama as penanggung_ket,
					
						if(y.flagbill=0,'Aktif',if(y.flagbill=1,'keluar',if(y.flagbill=2,'Pending',if(y.flagbill=3,'Dummy','Batal')))) as statusbill,
						y.keterangan, j.keterangan as caramasuk,
						y.asalPPK, i.keterangan as asalinstansi, a.user,
						d.keterangan as diagnosa, y.nosep, y.noskdp, 
						'' as rujukan, '' as tglrujukan,
						z.sukubangsa,
						#'' as lokasi_kd, '' as lokasi_ket,
						'' as dokter_kd, '' as dokter_nama
				from fotrdaftarri a 
				left join fotrdaftar y on y.nobill=a.nobill
				left join fomstpasien z on z.norm=y.norm 
				left join boptmstcustomer w on w.kode=y.perusahaanpenanggung 
				left join fomstdiagnosaawal d on d.kode=y.diagnosaawal 
				left join fowilmstkelurahan f on z.kelurahan=f.kode AND f.KodeKota=z.Kota AND f.KodeKecamatan=z.Kecamatan
				left join fowilmstkecamatan g on z.kecamatan=g.kode AND g.Kodekota=z.Kota
				left join fowilmstkota h on z.kota=h.kode 
				left join fotrasalpasien i on i.kode=y.asalinstansi 
				left join forimstcaramasuk j on y.caramasuk=j.kode 

				-- left join fokmrmstbed bd on bd.kode=a.Kodebed
				left join fokmrsetupbed sb ON sb.KodeBed=a.Kodebed
				-- left join fokmrmstbuilding b on b.kode=sb.kodebuilding
				-- left join fokmrmstlantai l on l.kodebuilding=sb.kodebuilding and l.kode=sb.kodelantai
				left join fokmrmstruang r on r.kode=sb.koderuang
				left join fokmrmstkelas k on k.kode=r.kelas

				where y.diagnosaawal<>283 and y.FlagBill<>4
					and y.nobill='".$nobill."'
			";

				// and y.tanggalmasuk>='".$date."'
				// 		and y.tanggalmasuk<='".$date."'
				// 	order by y.tanggalmasuk, y.nobill
		$query = $this->db->query($q)->result_array();

		if(count($query)>0){
			$query[0]['kategori_usia'] = kategori_usia($query[0]['umur']);
			return $query[0];
		}else{
			return false;
		}
		
	}

	public function gd_logpendaftaranrj_by_date($date){
		$q = "SELECT * FROM xrec WHERE app='daftarmandiri/admin' AND  date= '".$date."' order by time";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name' 	 => 'gd_logpendaftaranrj_by_date',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}
	
	public function gd_log_login_by_date($date=null){
		$q = "SELECT * FROM xrec WHERE app='login' AND  date= '".$date."' ORDER BY time";
		$query = $this->db->query($q)->result_array();
		return $query;
	}

	public function gd_logpendaftaranrj_by_id($id){
		$q = "select * from xrec where  Id= '".$id."'";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'name' 	 => 'gd_logpendaftaranrj_by_id',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function logdaftarrj_by_key($key_name=null, $key_value=null, $par1=null, $par2=null, $par3=null){
		switch ($key_name) {
			case 'billing':
				$q = "SELECT * from xrec where  `data` like '%billing\":\"".$key_value."%'";
				break;

			case 'nosep':
				$q = "SELECT * from xrec where  `data` like '%noSep\":\"".$key_value."%'";
				break;
			
			case 'nosep0':
				$q = "SELECT * from xrec where date='".$key_value."' AND  `data` like '%noSep\":\"0%'";
				break;

			case 'prolanisPRB':
				$q = "SELECT * from xrec where  `data` like '%prolanisPRB\":\"Potensi PRB%' AND date= '".$key_value."' ORDER BY time DESC";
				break;
			
			
			case 'prolanisPRBLite':
				$q = "SELECT Id, app, date, data from xrec where `data` like '%prolanisPRB\":\"Potensi PRB%' AND date= '".$key_value."' ORDER BY time DESC";
				
				$query = $this->db->query($q)->result_array();
				
				if($query==null){
					return null; exit;
				}else{
					for ($i=0; $i < count($query) ; $i++) {						
						$x = json_decode( $query[$i]["data"], 1);
						// $query[$i]['prolanis'] = json_decode( $query[$i]["data"])['bridging']['res_c_sep']['response']['sep']['informasi']['prolanisPRB'];
						$query[$i]['prolanis'] = $x['bridging']['res_c_sep']['response']['sep']['informasi']['prolanisPRB'];
						$query[$i]['nobill'] = $x['data_utama']['billing'];												
					}
		
					return $query;
					exit;
				}

				break;
			
			
			case 'login':
				$q = "SELECT * FROM xrec WHERE `app`='login' AND date= '".$key_value."' ORDER BY time DESC";
				break;
			
			case 'pendaftaran-rjri':
				$q = "SELECT * FROM xrec WHERE `app`='".$key_name."' AND date= '".$key_value."' ORDER BY time DESC";
				break;
			
			case 'billing-kosong':
				$q = "SELECT * from xrec where `data` like '%billing\":\"\"%' AND date='".$key_value."'";
				break;
			
			case 'insert-pos-tindakan':
				// >> $key_value = nobill
				// $q = "SELECT * from xrec where  `data` like '%billing\":\"".$key_value."\"%'";
				if($key_value == null){
					return ["message" => "Masukkan Billing setelah slash."];
				}

				// app LIKE 'pendaftaran-rjri/insert_pos_tindakan/%' AND data like '%BL191014.0151%'
				$q = "SELECT * from xrec where `app` = 'pendaftaran-rjri/insert_pos_tindakan/".$key_value."'";
				break;
			
			case 'insert-pos-tindakan-bpjs-igd':
				if($key_value == null) return ["message" => "Masukkan Tanggal setelah slash."];

				$q = "SELECT * from xrec where app LIKE 'pendaftaran-rjri/insert_pos_tindakan/%' 
					AND data like '%pelayanan\":\"IGD%' 
					AND date='".$key_value."'
					ORDER BY date DESC, time DESC
					-- LIMIT 1
					";
				break;
			
			case 'insert-pos-tindakan-bpjs-rj':
				if($key_value == null) return ["message" => "Masukkan Tanggal setelah slash."];

				$q = "SELECT * from xrec where app LIKE 'pendaftaran-rjri/insert_pos_tindakan/%' 
					AND data like '%pelayanan\":\"RJ%' 
					AND date='".$key_value."'
					ORDER BY date DESC, time DESC
					-- LIMIT 1
					";
				break;
			
			default:
				# code...
				break;
		}
		

		$query = $this->db->query($q)->result_array();
		if($query==null){
			return null;
		}else{
			for ($i=0; $i < count($query) ; $i++) { 
				$val[] = [
					"Id" => $query[$i]["Id"],
					"app" => $query[$i]["app"],
					"user" => $query[$i]["user"],
					"date" => $query[$i]["date"],
					"time" => $query[$i]["time"],
					"data" => json_decode( $query[$i]["data"]),
				];
			}

			return $val;
		}
		
	}


	public function prolanisPRB_byNobill($nobill){
		$q = "SELECT Id, app, date, data from xrec 
			WHERE `data` like '%\"data_utama\":{\"billing\":\"".$nobill."%'
			ORDER BY time DESC";
	
		$query = $this->db->query($q)->result_array();
		if($query==null){
			return null; exit;
		}else{
			$val = [];
			for ($i=0; $i < count($query) ; $i++) {						
				$x = json_decode( $query[$i]["data"], 1);
				// $query[$i]['prolanis'] = json_decode( $query[$i]["data"])['bridging']['res_c_sep']['response']['sep']['informasi']['prolanisPRB'];
				$query[$i]['prolanisPRB'] = $x['bridging']['res_c_sep']['response']['sep']['informasi']['prolanisPRB'];
				$query[$i]['nobill'] = $x['data_utama']['billing'];


				$val[$i] = [
					"nobill" => $query[$i]['nobill'],
					"prolanisPRB" => $query[$i]['prolanisPRB'],
				];
			}
			
			// return $query;
			return $val;
			exit;
		}
	}

	//--pendaftaran-rjri

	public function gd_skdp($params){
		$q = "select 
				a.NoBill,
				a.NoRM,
				a.TanggalMasuk,
				a.noskdp,
				b.Dokter as KodeDokter,
				c.Nama as NamaDokter,
				c.kd_dpjp_bpjs,
				d.Keterangan
			from fotrdaftar a 
			left join fotrdaftarrj b on b.NoBill = a.NoBill
			left join bohtmstvendor c on c.kode = b.Dokter
			left join fomstlokasi d on d.Kode = c.Lokasi 
			where a.NoRM='".$params['NoRM']."' && a.StatusDaftar='RJ'
			order by a.TanggalMasuk DESC";			

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}











	public function gd_rujukan_rscmXX($param){
		$q = "select
				a.rujukan,
				a.norm,
				a.exp_bulan
			from xrujukan a
			where a.rujukan = '".$param."'";

		$query = $this->db->query($q);
		return $query->result();
	}

	public function gd_rujukan_rscm($noRujukan){
		$q = "select
				rujukan, norm, exp_bln,
				noka, date
			from xrujukan
			where rujukan = '".$noRujukan."'";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result(),
				'message'	=> $message
			);

		return $js_full;
	}


	public function cek_kd_instansi_cm($kd_instansi){
		$q = "select * from fotrasalpasien where kd_bpjs = '".$kd_instansi."'";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama' 		=> 'cek_kd_instansi_cm',
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result_array(),
				'message'	=> $message
			);
		return $js_full;
	}

	public function insert_kd_instansi_cm($data){	
		$this->db->insert('fotrasalpasien', $data);
	}

	public function gd_instansi_cm($kode_bpjs){
		$q = "select * from fotrasalpasien where kd_bpjs = '".$kode_bpjs."'";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result_array(),
				'message'	=> $message
			);

		return $js_full;
		//return $query->result();
	}

	public function gd_instansi_cm_all(){
		$q = "select * from fotrasalpasien";
		$query = $this->db->query($q);
		return $query->result();
	}

	public function gd_penanggung_cm($penanggung){
		$q = "SELECT mc.Kode, mc.Nama,
					IFNULL(ma.NoAnggota, mc.Nama) AS NoAnggota
			FROM boptmstcustomer mc
			LEFT JOIN fomrkanggota ma ON ma.AnggotaPerusahaan=mc.Kode
			WHERE ma.AnggotaPerusahaan <> 'CO001' 
				AND (mc.Nama like '%".$penanggung."%' OR mc.Kode LIKE '%".$penanggung."%')
			GROUP BY mc.Kode
			ORDER BY mc.Nama";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'dtjs'		=> $query->result(),
				'message'	=> $message
			);

		return $js_full;
		//return $query->result();
	}

	// public function gd_penanggung_cm_noanggota($kode_penanggung=null, $nama_penanggung=null){
	// 	$q = "SELECT ma.AnggotaPerusahaan as Kode,# ma.NoAnggota #, 
	// 				IFNULL(ma.NoAnggota, '".$nama_penanggung."') AS NoAnggota
	// 		FROM fomrkanggota ma
	// 		LEFT JOIN boptmstcustomer mc ON ma.AnggotaPerusahaan=mc.Kode
	// 		WHERE ma.AnggotaPerusahaan = '".$kode_penanggung."' AND ma.AnggotaPerusahaan <> 'CO001'
	// 		#GROUP BY ma.AnggotaPerusahaan
	// 		";
	// 	$query = $this->db->query($q)->result_array();
	// 	return $query;
	// }

	public function gd_cara_masuk_cm(){
		$q = "select Kode, Keterangan from forimstcaramasuk";
		$query = $this->db->query($q);
		return $query->result();
	}

	public function gd_rujukan_dari_db_cm(){
		$q = "SELECT kode,ppk FROM fomstfaskes1 ORDER BY kode";
		$query = $this->db->query($q);
		return $query->result();
	}

	public function gd_dx_cm(){
		$q = "select Kode, Keterangan from fomstdiagnosaawal";
		$query = $this->db->query($q)->result_array();
		return $query;
	}

	public function search_dx_cm($key=null){
		$q = "SELECT Kode, Keterangan FROM fomstdiagnosaawal 
			WHERE Kode LIKE '%".$key."%' OR Keterangan LIKE '%".$key."%'
			ORDER BY Kode";
		$query = $this->db->query($q)->result_array();
		return $query;
	}


	//---pendaftaran-ri
	public function get_pelayanan_ri(){
		$q = "SELECT Kode,Keterangan FROM forimstpelayanan 
			-- WHERE (kode like '%%' or keterangan like '%%') 
			ORDER BY kode
  	";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	// BED_READY 
	// XLINK
	public function get_kode_bed($KodeBed=null){
		$q = "SELECT 
			bd.kode as KodeBed,
			bd.Keterangan as KeteranganBed, 
			b.keterangan as Building,
			l.keterangan as Lantai,
			r.keterangan as Ruang,
			k.keterangan as Kelas,
			bd.Status,
			k.tarifumum as Tarif_Include,k.rehab,k.pajak,
			k.tarifumum+(k.tarifumum * (k.rehab/100))+(k.tarifumum * (k.pajak/100)) as Tarif_Exclude,
			sb.user, date_format(sb.date,'%d-%m-%Y') as date,
			time_format(sb.time,'%T') as time
    from fokmrsetupbed sb
    left join fokmrmstbuilding b on b.kode=sb.kodebuilding
    left join fokmrmstlantai l on l.kodebuilding=sb.kodebuilding and l.kode=sb.kodelantai
    left join fokmrmstruang r on r.kode=sb.koderuang
    left join fokmrmstbed bd on bd.kode=sb.kodebed
    left join fokmrmstkelas k on k.kode=r.kelas
    where (bd.status='RD') and (bd.kode like '%".$KodeBed."%' or bd.keterangan like '%".$KodeBed."%') and bd.keterangan not like '%bayangan%'
    order by sb.kodebuilding,sb.kodelantai,k.kode,sb.koderuang,bd.kode
  	";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	public function get_kode_bed_all($KodeBed=null){
		$q = "SELECT 
			bd.kode as KodeBed,
			bd.Keterangan as KeteranganBed, 
			b.keterangan as Building,
			l.keterangan as Lantai,
			r.keterangan as Ruang,
			k.keterangan as Kelas,
			bd.Status,
			k.tarifumum as Tarif_Include,k.rehab,k.pajak,
			k.tarifumum+(k.tarifumum * (k.rehab/100))+(k.tarifumum * (k.pajak/100)) as Tarif_Exclude,
			sb.user, date_format(sb.date,'%d-%m-%Y') as date,
			time_format(sb.time,'%T') as time
    from fokmrsetupbed sb
    left join fokmrmstbuilding b on b.kode=sb.kodebuilding
    left join fokmrmstlantai l on l.kodebuilding=sb.kodebuilding and l.kode=sb.kodelantai
    left join fokmrmstruang r on r.kode=sb.koderuang
    left join fokmrmstbed bd on bd.kode=sb.kodebed
    left join fokmrmstkelas k on k.kode=r.kelas
    where bd.kode = '".$KodeBed."'
    order by sb.kodebuilding, sb.kodelantai, k.kode, sb.koderuang, bd.kode
  	";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	
	public function get_kode_bed_formdiagnosa($KodeBed=null){
		$q = "SELECT 
        ca.Kode as KodeBed, ca.Keterangan as KodeBedket,
        cb.KodeRuang, cd.Keterangan as KodeRuangKet,
        cd.Kelas as KodeKelas, ce.Keterangan as KodeKelasKet, 
				ce.tKelas as KodeKelasLevel,
        cb.KodeLantai, cf.Keterangan as KodeLantaiKet,
        cb.KodeBuilding , cg.Keterangan as KodeBuildingKet
			FROM fokmrmstbed ca
			left join fokmrsetupbed cb on cb.KodeBed = ca.Kode
			left join fokmrmstruang cd on cd.Kode = cb.KodeRuang
			left join fokmrmstkelas ce on ce.Kode = cd.Kelas
			left join fokmrmstlantai cf on cf.Kode = cb.KodeLantai
			left join fokmrmstbuilding cg on cg.Kode = cb.KodeBuilding
			Where ca.Kode = '".$KodeBed."'
			having !(cb.KodeRuang='')
			order by ca.Kode
  	";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	public function formdiagnosa_cekada_bill($nobill=null){
		$q = "SELECT * from formdiagnosa where BillNo='".$nobill."'";
		$query = $this->db->query($q)->num_rows();
		return $query;
	}
	
	public function formdiagnosa_ri_pelayanan($nobill=null){
		$q = "SELECT
        bb.Kode, bb.Keterangan
        from fotrdaftarri as ba
        left join forimstpelayanan as bb on bb.kode = ba.PelayananRI
        where ba.NoBill='".$nobill."'
  	";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	public function formdiagnosa_pxdaftar($nobill=null){		
		$q = "SELECT
				ba.NoBill, ba.NoRM, ba.StatusDaftar,
				ba.Nama, ba.Alamat, ba.Pendidikan, ba.Pekerjaan,
				ba.TanggalMasuk, ba.JamMasuk, 
				ba.TanggalKeluar, ba.JamKeluar, 
				ba.StatusBL, 
				IF(ba.StatusBL='BARU','B','L') AS KasusBL,
				IF(ba.StatusBL='BARU','B','L') AS KasusBLBln,
				IF(ba.StatusBL='BARU','B','L') AS KasusBLTri,
				IF(ba.StatusBL='BARU','B','L') AS KasusBLSms,
				IF(ba.StatusBL='BARU','B','L') AS KasusBLThn,
				ba.nosep,
				ba.UmurTahun, ba.UmurBulan, ba.UmurHari, ba.Sex, 
				ba.FlagBill,
				ba.perusahaanpenanggung,
				IF(ba.perusahaanpenanggung='','',
				(SELECT pt.nama FROM boptmstcustomer pt WHERE pt.kode=ba.perusahaanpenanggung)
				) as penanggungket
			FROM fotrdaftar as ba
			WHERE ba.nobill='".$nobill."'
  	";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	public function formdiagnosa_pxdaftarri($nobill=null){
		$q = "SELECT
				ba.nobill, ba.Kodebed, ba.TypeDokter, ba.DokterAwal, 
				ba.PelayananRI, bb.Keterangan as PelayananRIKet
      from fotrdaftarri as ba
			left join forimstpelayanan as bb on bb.kode = ba.PelayananRI
      where ba.NoBill='".$nobill."'
  	";
		$query = $this->db->query($q)->result_array();
		return $query;
	}


	//BARU - 2020.01.09
	public function formdiagnosa_get_pxri_det($nobill=null){
		// $this->load->model('m_daftarmandiri');
		// $this->db('m_daftarmandiri', 'formdiagnosa_pxri', $nobill);
		// fd=formdiagnosa
		$fd_pxdaf = $this->m_daftarmandiri->formdiagnosa_pxdaftar($nobill)[0];

		$fd_pxri = $this->m_daftarmandiri->formdiagnosa_pxdaftarri($nobill)[0];
		$fd_dokter = $this->m_daftarmandiri->get_dokter_luar_dalam($fd_pxri['TypeDokter'], $fd_pxri['DokterAwal']);
		if($fd_dokter==null){
			// INI ADA KARENA MENANGANI ERROR KODE DOKTER YG PERNAH TRAINING
			// saat di pendaftaran RI(akses pilihan dokter awal).
			// CONTOH: dr.Yudo dengan register training). HARUSNYA TIDAK DITAMPILKAN
			$fd_dokter = [
				"kode" => '',
				"nama" => '',
				"alamat" => '',
				"telp" => '',
			];
		}else{
			$fd_dokter = $fd_dokter[0];
		}

		$fd_bed = $this->m_daftarmandiri->get_kode_bed_formdiagnosa($fd_pxri['Kodebed'])[0];
		$fd_pelayanan = $this->m_daftarmandiri->get_kode_bed_formdiagnosa($fd_pxri['Kodebed'])[0];
		$val = [
			"fd_pxdaf"=> $fd_pxdaf,
			"fd_pxri" => $fd_pxri,
			"fd_bed" 	=> $fd_bed,
			"fd_dokter" 	=> $fd_dokter,
		];
		// echo json_encode($val);
		return $val;

	}
	
	public function promasuk_initrm($promsk_kd=null, $norm=null){
		switch ($promsk_kd) {
			case '1': //langsung rawat inap
					$q = "SELECT
					p.NoRM,p.NoRMOld as NoRMLama,p.Nama,p.Alamat,p.TglLahir,
					p.NoIdentitas,if(p.Anggota='U','Umum','Member') as Type, '' AS NoBill,
					'RI' AS lokasiket
					FROM fomstpasien p
					left join fotrdaftar d on d.norm=p.norm and d.flagbill='0'
					where IsNull(d.norm) and
					(p.norm like '%".$norm."%' or
					p.nama like '%".$norm."%' or
					p.alamat like '%".$norm."%' or
					p.tgllahir like '%".$norm."%') and p.kondisi='H' 
					order by p.norm";
				break;
			
			case '2': //from ugd
					$q = "SELECT
					NoRM,Nama,Alamat,if(Anggota='U','Umum','Member') as Type, NoBill,
					'UGD' AS lokasiket
					FROM fotrdaftar where flagbill=0 and statusdaftar='UG' and
					(norm like '%".$norm."%' or
					nama like '%".$norm."%' or
					alamat like '%".$norm."%')
					order by norm";
				break;
			
			case '3': //from rj
					$q = "SELECT
					td.NoRM, td.Nama, td.Alamat, 
					if(Anggota='U','Umum','Member') as Type, td.NoBill,
					ml.Keterangan AS lokasiket
					FROM fotrdaftar td
					LEFT JOIN fotrdaftarrj tdj ON tdj.NoBill=td.NoBill
					LEFT JOIN fomstlokasi ml ON ml.Kode=tdj.Lokasi
					where flagbill=0 and statusdaftar='RJ' and
					(norm like '%".$norm."%' or
					nama like '%".$norm."%' or
					alamat like '%".$norm."%')
					order by norm";
				break;
			
			default:
				# code...
				break;
		}
		
  	
		$query = $this->db->query($q)->result_array();
		return $query;
	}


	public function kasus($icd=null){
		$q = "SELECT
				KodeICD as Kode_ICD, 
				KodeJenis as Kode_Jenis, 
				DaftarTerinci as Daftar_Terinci, Keterangan, keterangan1
    from formmsticd
    Where KodeICD ='".$icd."' and flag='0'
  	";
		$query = $this->db->query($q)->result_array();
		// return $query;
		
		
		$q2 = "SELECT
    RmNo, ICDKode
    from formdiagnosa
    Where RmNo='".$norm."' and ICDKode ='".$icd."'
  	";
		$query2 = $this->db->query($q2)->result_array();
		return $query2;
	}

	
	
	public function get_dokter_luar_dalam($operator=null, $DokterAwal=null){
		$SDTypeVendorMedis = "MD";
		// $DokterAwal = "";

		// $q_0 = "SELECT kode, nama, 
		// 		'' AS kd_dpjp_bpjs,
		// 		alamat, notelp as telp,
		// 		'0' AS type,
		// 		'DALAM' AS typeket
		// 	from hrdmstkaryawan where
		// 	flagaktif='0' and
		// 	flagoperator='O' and 
		// 	(kode like '%" .$DokterAwal. "%' or
		// 	 nama like '%" .$DokterAwal. "%' or
		// 	alamat like '%" .$DokterAwal. "%' or
		// 	notelp like '%" .$DokterAwal. "%')";
	
		$q_0 = "SELECT kode, nama, 
				'' AS kd_dpjp_bpjs,
				alamat, notelp as telp,
				'0' AS type,
				'DALAM' AS typeket
			from hrdmstkaryawan where
			flagaktif='0' and
			nama like '%" .$DokterAwal. "%' AND
			-- flagoperator='O' and 
			(nama like '%dr.%' OR nama like '%drg.%')
			";

		$q_1 = "SELECT kode, nama, 
				kd_dpjp_bpjs COLLATE utf8_general_ci,
				alamat, telp,
				'1' AS type,
				'LUAR' AS typeket
			from bohtmstvendor where
			type='" .$SDTypeVendorMedis. "' and
			(kode like '%" .$DokterAwal. "%' or
			nama like '%" .$DokterAwal. "%' or
			alamat like '%" .$DokterAwal. "%' or
			telp like '%" .$DokterAwal. "%') and flag<>1";


		if($operator=='0'){ // OPERATOR DALAM/DOKTER DALAM
			$q = $q_0." order by kode";
		}else if($operator=='1'){
			$q = $q_1." order by kode";
		}else if($operator=='ALL' || $operator==null){
			// KALAU tanpa petik dengan pakai petik, hasil beda.
			// ex: ($operator=='0') dengan ($operator==0)

			// $q = "SELECT kode,nama,kd_dpjp_bpjs,alamat,telp,
			// 	'1' AS type,
			// 	'LUAR' AS typeket
      // from bohtmstvendor where
      // type='" .$SDTypeVendorMedis. "' and
      // (kode like '%" .$DokterAwal. "%' or
      // nama like '%" .$DokterAwal. "%' or
      // alamat like '%" .$DokterAwal. "%' or
      // telp like '%" .$DokterAwal. "%') and flag<>1 
			// -- order by kode
			// UNION
			// SELECT kode, nama, '' AS kd_dpjp_bpjs, alamat, notelp as telp,
			// 	'0' AS type,
			// 	'DALAM' AS typeket
      // from hrdmstkaryawan where
      // flagoperator='O' and
			// flagaktif='0' and
      // (kode like '%" .$DokterAwal. "%' or
      // nama like '%" .$DokterAwal. "%' or
      // alamat like '%" .$DokterAwal. "%' or
			// notelp like '%" .$DokterAwal. "%') 
			// ORDER BY kode
			// ";

			$q = $q_0." UNION ".$q_1." ORDER BY kode";
		}

		$query = $this->db->query($q)->result_array();
		return $query;
	}
	//\---pendaftaran-ri


	public function insert_daftar_rj_xrec($data){
		$data_save = array(
				'app'	=> $data['app'],
				'data'	=> json_encode( $data['data'] ),
				'user' 	=> $data['user'],
				'date' 	=> $data['date'],
				'time' 	=> $data['time']
			);

		// print_r( $data_save );

		$this->db->insert('xrec', $data_save);
		
	}

	public function insert_daftar_rj($flag, $data, $data1, $data2){
		//tambahi status daftar(booking/langsung)		
		$this->db->insert('fotrdaftar', $data);
		$this->db->insert('fotrbillingshare', $data2);

		if($flag['_FL_daftar_ugd'] == 0){ //jika SELAIN DAFTAR UGD
			$this->db->insert('fotrdaftarrj', $data1);

			if($flag['_FL_ambil_px_book'] == 1){
				$q = "update fotrbooking set flag='1' where date='".$flag['date']."' AND time='".$flag['time']."'";
				$query = $this->db->query($q);
				//return $this->db->affected_rows();
			}
		}else{
			$this->db->insert('fotrdaftarugd', $data1);
		}
		
	}

	public function insert_daftar_rj_n($pelayanan, $flag, $data, $data1, $data2){
		//tambahi status daftar(booking/langsung)		
		$this->db->insert('fotrdaftar', $data); // $in_daftar =
		$aff_rows = $this->db->affected_rows();		
		$val = ($aff_rows > 0)?  TRUE : FALSE;	

		
		if($val == TRUE){
			$this->db->insert('fotrbillingshare', $data2);

			if($flag['_FL_daftar_ugd'] == 0){ //jika SELAIN DAFTAR UGD
				$this->db->insert('fotrdaftarrj', $data1);

				if($flag['_FL_ambil_px_book'] == 1){
					$q = "update fotrbooking set flag='1' where date='".$flag['date']."' AND time='".$flag['time']."'";
					$query = $this->db->query($q);
					//return $this->db->affected_rows();
				}
			}else{
				$this->db->insert('fotrdaftarugd', $data1);
			}


			$res = [
				"status" => "success",
				"message" => "OK",
				"time" => date('H:i:s'),
			];
		}else{
			$res = [
				"status" => "failed",
				"message" => "GAGAL",
				"time" => date('H:i:s'),
			];
		}

		return $res;		
		
	}



	//\--pendaftaran-rjri




	public function tambah_user($data){
		$this->db->insert('xuser', $data);
	}

	public function get_st_bill_rm_by_norm($nobill){
		$q = "select NoBill, FlagBill from fotrdaftar where NoRM = '".$nobill."' order by NoBill desc";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'	 => '',
				'status' => $status,
				'count'	 => $rowCount,
				'datajs' => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}
	
	//NEW
	public function get_st_bill_open_rm_by_norm_n($norm=null){
		$q = "SELECT 
				NoBill, FlagBill 
			FROM fotrdaftar 
			WHERE NoRM = ? AND FlagBill=0";
		$result = $this->db->query($q, [$norm])->result_array();
		
		if(count($result)>0){
			$val = [
				"st_bill_rm" => "open",
				"message" => "Status Billing Open.",
				"flagbill"=> $result[0]["FlagBill"],
				"nobill"=> $result[0]["NoBill"],
			];
		}else{
			$val = [
				"st_bill_rm" => "close",
				"message" => "Status Billing Close.",
				"flagbill"=> 1,
				"nobill"=> "",
			];
		}
		return $val;
	}

	public function delete_billing($nobill){
		$this->db->where('NoBill', $nobill);
	    $this->db->delete('fotrdaftar'); // Untuk mengeksekusi perintah delete di nama table

	    $this->db->where('NoBill', $nobill);
	    $this->db->delete('fotrdaftarrj');

	    $this->db->where('nobill', $nobill);
	    $this->db->delete('fotrbillingshare');

	}

	public function delete_bill_daftar($pelayanan=null, $nobill=null){
		// echo $pelayanan.$nobill; exit;

		$this->db->where('NoBill', $nobill);
	  $this->db->delete('fotrdaftar'); // Untuk mengeksekusi perintah delete di nama table
		
		if($pelayanan=="rj" || $pelayanan=="ugd" || $pelayanan=="ri"){
			$this->db->where('NoBill', $nobill);
	    $this->db->delete('fotrdaftar'.$pelayanan);
		}
		
		$this->db->where('nobill', $nobill);
		$this->db->delete('fotrbillingshare');

	}

	public function get_st_px_mrs_by_norm($norm=null){
		$q = "SELECT NoBill, TanggalMasuk, TanggalKeluar 
		from fotrdaftar where NoRM = ? AND StatusDaftar = 'RI' 
		order by NoBill desc LIMIT 1";
		$query = $this->db->query($q, [$norm]);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'	 => 'get_st_px_mrs_by_norm',
				'status' => $status,
				'count'	 => $rowCount,
				'datajs' => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function gd_st_px_baru_lama_by_norm($norm=null){		
		$q = "select 
				IF(
				  (select COUNT(NoBill) from fotrdaftar where NoRM = '".$norm."')>0, 
				  'LAMA',
				  'BARU'
				) as status_px ";
		$query = $this->db->query($q);
		return $query->result();
	}
	
	public function gd_st_px_baru_lama_by_norm_n($norm=null){		
		$q = "select 
				IF(
				  (select COUNT(NoBill) from fotrdaftar where NoRM = '".$norm."')>0, 
				  'LAMA',
				  'BARU'
				) as status_px ";
		$query = $this->db->query($q)->result_array()[0];
		return $query;
	}


	//=======================[ informasi_untuk_pasien ]=========================
	
	
	
	// public function upld_bed_ready_all_room($data){	
	public function insert_billboard($data){	
		$this->db->insert('xview', $data);
	}

	// !!!HAPUS 2021.03.17
	// public function update_billboard($param){
	// 	$data = [
	// 		'data' => json_encode($param['set']['data']),
	// 		'user' => $param['set']['user'],
	// 		'date' => date('Y-m-d'), // $param['date'],
	// 		'time' => date('H:i:s'), // $param['time']
	// 	];
	// 	$this->db->where('app', $param['where']['app']);
	// 	$this->db->update('xview', $data);
	// }



	//=======================[ \informasi_untuk_pasien ]========================

	//=======================[ daftarmandiri/daftaronline - lokal ]========================
	public function send_form_daftar_online_CURL_RX($data){	
		$this->db->insert('fotrbooking', $data);
	}

	
	public function get_record_booking_aktif_px_n($norm=null, $kdDokter=null){ //aktif: bisa dipake daftar(flag=0)
		$q = "SELECT norm, nama, flag, date, time 
			FROM fotrbooking 
			WHERE norm='".$norm."' AND dokter='".$kdDokter."' AND flag=0";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		$js_full = array(
				'name'	 => 'get_st_booking_px',
				'rec_booking_aktif' => $status,
				'count'	 => $rowCount,
				'datajs' => $query->result(),
			);

		return $js_full;
	}

	//=======================[ \daftarmandiri/daftaronline - lokal ]========================

	//=======================[ daftarmandiri/px_cetak_antrian_rc ]========================
		public function select_nomor_antri_daftar($date=null){
			$q = "SELECT * from antridaftar WHERE date = '".$date."'";
			$query = $this->db->query($q)->result_array();
			$val = [
				"count" => count($query),
				"list" => $query,
			];
			return $val;
		}
		
		public function get_cetak_antridaftar_last($date=null){
			$q = "SELECT * from antridaftar WHERE date = '".$date."'";
			$query = $this->db->query($q)->result_array();
			$val = [
				"count" => count($query),
				"list" => $query,
			];
			return $val;
		}
		
		public function select_nomor_antridaftar_last_selesai_panggil($date=null){
			$q = "SELECT nomor from antridaftar 
				WHERE date = '".$date."' AND selesai IS NULL
				ORDER BY nomor LIMIT 1
				";
			$query = $this->db->query($q)->result_array();
			if($query == null){
				return null;
			}else{
				$nominal= (int)$query[0]['nomor'];
				$bilang = terbilang( $nominal );
				$kata 	= explode(" ", $bilang);
				$val = [
					"nominal" 	=> $nominal,
					"terbilang" => $bilang,
					"kata" 			=> $kata,
					"nkata" 		=> count($kata),			
				];

				$query[0]['terbilang'] = $val;
				return $query[0];
			}
		}
		
		public function select_nomor_antridaftar_max($date=null){
			$q = "SELECT nomor from antridaftar WHERE date = '".$date."'	ORDER BY nomor desc	LIMIT 1";
			$query = $this->db->query($q)->result_array();
			if($query == null){
				return null;
			}else{
				$nominal= (int)$query[0]['nomor'];
				$bilang = terbilang( $nominal );
				$kata 	= explode(" ", $bilang);
				$val = [
					"nominal" 	=> $nominal,
					"terbilang" => $bilang,
					"kata" 			=> $kata,
					"nkata" 		=> count($kata),			
				];

				$query[0]['terbilang'] = $val;
				
				return $query[0];
			}
		}
		
		public function select_nomor_antri_daftar_panggil_now($date=null){
			$q = "SELECT * from antridaftar 
				WHERE date = '".$date."'
				AND selesai IS NOT NULL
				ORDER BY selesai DESC
				LIMIT 1
				";
			$query = $this->db->query($q)->result_array();
			return $query;
		}
		
		






		public function antrian_book($norm=null, $tgl=null, $kodePoli=null){
			$q = "SELECT * 
				from fotrbooking b
				WHERE b.norm =  '".$norm."'			
				AND b.tgldaftar = '".$tgl."' 
				AND b.lokasi= '".$kodePoli."'
				";
			$query = $this->db->query($q)->result_array();
			return $query;
		}
		
		public function get_klinik_bpjs(){
			$q = "SELECT Kode AS lokasi, Keterangan AS lokasiket, kdpoli_bpjs FROM fomstlokasi WHERE kdpoli_bpjs IS NOT NULL";
			$query = $this->db->query($q)->result_array();
			return $query;
		}
		
		
		public function antrian_book_multiklinik($norm=null, $tgl=null){
			$q = "SELECT * from fotrbooking b
				WHERE b.norm =  '".$norm."'			
				AND b.tgldaftar = '".$tgl."'
				"; 
			$query = $this->db->query($q)->result_array();
			return $query;
		}


	//=======================[ \daftarmandiri/px_cetak_antrian_rc ]========================



	//=======================[  bo/laporan_indikator_mutu ]========================
	public function insert_lapIndikatorMutu($data=null){
		$this->db->insert('mutumst', $data);
	}

	public function select_lapIndikatorMutu_all(){
		$this->db->select('*');
		$this->db->from('mutumst');
		$this->db->order_by('pelayanan ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_indikator_by_divisi($data=null){
		$this->db->select('*');
		$this->db->from('mutumst');
		
		if($data['pelayanan'] != "SEMUA"){
			$where = "pelayanan='".$data['pelayanan']."'";
			$this->db->where($where);
		}
		
		$this->db->order_by('id ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_lapIndikatorMutu_all_by_bln_thn(){
		$this->db->select('*');
		$this->db->from('mutumst');
		$this->db->join('mutumstbln', 'mutumstbln.idIndikator = mutumst.id', 'left');
		// $this->db->join('comments', 'comments.id = blogs.id', 'left');
		$this->db->order_by('pelayanan ASC');
		$query = $this->db->get();

		return $query->result();
	}

	
	public function select_nd_indikator_by_bln_thn($data=null){// ndak dipake
		$this->db->select('*');
		$this->db->from('mutumstbln');
		$this->db->join('mutumst', 'mutumst.id = mutumstbln.idIndikator', 'left');
		$where = "bulan='".$data['bulan']."' AND tahun='".$data['tahun']."'";
		$this->db->where($where);
		$query = $this->db->get();

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		$js_full = array(
				'name'	 => $this->uri->segment(2),
				'status' => $status,
				'count'	 => $rowCount,
				'datajs' => $query->result(),
			);

		return $js_full;
	}

	public function select_nd_indikator_by_bln_thn_pelayanan($data=null){
		$this->db->select('*');
		$this->db->from('mutumstbln');
		$this->db->join('mutumst', 'mutumst.id = mutumstbln.idIndikator', 'left');
		if($data['pelayanan'] == "SEMUA"){
			$where = "bulan='".$data['bulan']."' AND tahun='".$data['tahun']."'";
		}else{
			$where = "bulan='".$data['bulan']."' AND tahun='".$data['tahun']."' AND pelayanan='".$data['pelayanan']."'";
		}
		
		$this->db->where($where);
		$query = $this->db->get();

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		$js_full = array(
				'name'	 => $this->uri->segment(2),
				'status' => $status,
				'count'	 => $rowCount,
				'datajs' => $query->result(),
			);

		return $js_full;
	}

	public function select_nd_indikator_by_id($data=null){
		// $names = array('Frank', 'Todd', 'James');
		// $this->db->where_in('username', $names);
		// // Produces: WHERE username IN ('Frank', 'Todd', 'James')

		$this->db->select('*');
		$this->db->from('mutumstbln');
		$where = "idIndikator='".$data['idIndikator']."' AND bulan='".$data['bulan']."' AND tahun='".$data['tahun']."'";
		$this->db->where($where);
		$query = $this->db->get();

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		$js_full = array(
				'name'	 => 'select_nd_indikator_by_id',
				'status' => $status,
				'count'	 => $rowCount,
				'datajs' => $query->result(),
			);

		return $js_full;
	}

	public function select_grf_indikator_by_pelayanan_th($data=null){
		$this->db->select('*');
		$this->db->from('mutumst a');
		$this->db->join('mutumstbln b', 'b.idIndikator = a.id', 'left');
		$where = "a.pelayanan='".$data['pelayanan']."' AND b.tahun='".$data['tahun']."'";
		$this->db->where($where);
		$this->db->group_by("a.indikator");
		$query = $this->db->get();

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		if($rowCount > 0){
			return $query->result();
		}else{
			return null;
		}
		
	}

	public function select_grf_indikator_by_idindikator_pelayanan_th($data=null){
		$this->db->select('*');
		$this->db->from('mutumst a');
		$this->db->join('mutumstbln b', 'b.idIndikator = a.id', 'left');
		$where = "b.idIndikator='".$data['idIndikator']."' AND a.pelayanan='".$data['pelayanan']."' AND b.tahun='".$data['tahun']."'";
		$this->db->where($where);
		$this->db->order_by("b.bulan");
		$query = $this->db->get();

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "ADA": "TIDAK ADA";

		if($rowCount > 0){
			return $query->result();
		}else{
			return null;
		}
		
	}

	public function insert_nd_indikator($data=null){
		$this->db->insert('mutumstbln', $data);

		$message = "Nilai indikator berhasil ditambahkan.";
		$result = array(
				'status'  => 'SUKSES',
				'message' => $message
			);
		return $result;
	}

	public function update_nd_indikator($data=null){
		$where = "idIndikator='".$data['idIndikator']."' AND bulan='".$data['bulan']."' AND tahun='".$data['tahun']."'";
		$this->db->where($where);
		$this->db->update('mutumstbln', $data);

		$message = "Nilai indikator berhasil diupdate.";
		$result = array(
				'status'  => 'SUKSES',
				'message' => $message
			);
		return $result;
	}

	public function update_indikator($data=null){
		$where = "id='".$data['id']."'";
		$this->db->where($where);
		$this->db->update('mutumst', $data);

		$message = "Master indikator berhasil diupdate.";
		$result = array(
				'status'  => 'SUKSES',
				'message' => $message
			);
		return $result;
	}


	public function delete_indikator($data=null){
		$this->db->where('id', $data['id']);
	    $this->db->delete('mutumst');

	    $message = "Master indikator berhasil dihapus.";
		$result = array(
				'status'  => 'SUKSES',
				'message' => $message
			);
		return $result;
	}

	//=======================[ \bo/laporan_indikator_mutu ]========================

	//=======================[  bo/menu/mutu/rekap-irs]========================
	public function select_irs_indikator(){
		$q = "
			SELECT ind.id, ind.indikator, irs.IRS 
			FROM mutuirsmstind ind
			LEFT JOIN mutuirsmst irs ON irs.id=ind.IRS
		";

		$result = $this->db->query($q)->result_array();
		return $result;
	}	
	
	public function select_irsbulanan($date=null, $divisi=null){
		$divisi = rawurldecode($divisi);
		// KELIRU, GAK URUT MATRIX e
		// $q = "
		// 	SELECT * 
		// 	FROM mutuirsrekapharian irshr
		// 	WHERE tanggal_isi LIKE '".$date."%' AND divisi='".$divisi."'
		// ";
		$q = "
			SELECT * 
			FROM mutuirsrekapharian irshr
			WHERE tanggal_isi LIKE '".$date."%' AND divisi='".$divisi."'
			ORDER BY id_indikator, tanggal_isi
		";

		$result = $this->db->query($q)->result_array();
		return $result;
	}	
	
	
	public function laporan_irsbulanan($date=null, $divisi=null){
		$divisi = rawurldecode($divisi);
		
		$q_loop = "";
		// $max = maxday_of_month($date);
		$month = month_now_yesterday($date."-01");
		$max = (int) $month["now"]["maxday"];
		// echo json_encode($max);
		// exit;

		$i2d = 1;
		for ($i=1; $i <= $max; $i++) { 

			if($i<10){ $i2d = "0".$i; }
			else{ $i2d = $i; }

			$q_loop .= "(SELECT irshrS.nilai
			FROM mutuirsrekapharian irshrS
			LEFT JOIN mutuirsmstind indS ON indS.id=irshrS.id_indikator
			LEFT JOIN mutuirsmst irsS ON irsS.id=indS.IRS
			WHERE irshrS.tanggal_isi = '".$date."-".$i2d."' 
			AND irshrS.divisi = '".$divisi."'
			AND irshrS.id_indikator = ind.id
			) AS '".$i."'";
			
			if($i < $max){
				$q_loop .= ", ";
			}
		}

		

		$q_divisi = "(SELECT irshrS.divisi
		FROM mutuirsrekapharian irshrS
		LEFT JOIN mutuirsmstind indS ON indS.id=irshrS.id_indikator
		LEFT JOIN mutuirsmst irsS ON irsS.id=indS.IRS
		WHERE irshrS.tanggal_isi = '".$date."-".$i2d."' 
		AND irshrS.divisi = '".$divisi."'
		AND irshrS.id_indikator = ind.id
		) AS 'DIVISI'";

		$q = "
		SELECT ".$q_divisi.", ind.id AS NO, ind.indikator AS INDIKATOR, 
		irs.IRS, 
			".$q_loop." ,
		(SELECT SUM(nilai) FROM mutuirsrekapharian irshrS
			WHERE irshrS.tanggal_isi LIKE '".$date."-%' 
			AND irshrS.divisi = '".$divisi."'
			AND irshrS.id_indikator = ind.id) AS TOTAL
		FROM mutuirsmstind ind
		LEFT JOIN mutuirsmst irs ON irs.id=ind.IRS
		";
		
		// $q = "
		// SELECT ind.id AS NO, ind.indikator AS INDIKATOR, irs.IRS, 
		// 	(SELECT irshrS.nilai
		// 	FROM mutuirsrekapharian irshrS
		// 	LEFT JOIN mutuirsmstind indS ON indS.id=irshrS.id_indikator
		// 	LEFT JOIN mutuirsmst irsS ON irsS.id=indS.IRS
		// 	WHERE irshrS.tanggal_isi = '".$date."-01' 
		// 	AND irshrS.divisi = '".$divisi."'
		// 	AND irshrS.id_indikator = ind.id
		// 	) AS '1',

		// 	(SELECT irshrS.nilai
		// 	FROM mutuirsrekapharian irshrS
		// 	LEFT JOIN mutuirsmstind indS ON indS.id=irshrS.id_indikator
		// 	LEFT JOIN mutuirsmst irsS ON irsS.id=indS.IRS
		// 	WHERE irshrS.tanggal_isi = '".$date."-02' 
		// 	AND irshrS.divisi = '".$divisi."'
		// 	AND irshrS.id_indikator = ind.id
		// 	) AS '2' ".$q_loop." 
		// FROM mutuirsmstind ind
		// LEFT JOIN mutuirsmst irs ON irs.id=ind.IRS
		// ";

		// echo $q_loop;
		// exit;

		$result = $this->db->query($q)->result_array();
		return $result;
	}	

	//FX DELETE = DELETE FROM mutuirsrekapharian WHERE `divisi` = 'KAMAR OPERASI'
		

	//=======================[ \bo/menu/mutu/rekap-irs ]========================



	//=======================[  bo/menu/manajemen/dashboard-manajemen ]========================
	public function dboard_mnj_panelutama_today(){
		$q = "
		SELECT 
		(select count(nobill) from fotrdaftar where flagbill=0 and statusdaftar='RI') as 'pxri_today',
		(select count(nobill) from fotrdaftar where flagbill=0 and statusdaftar='RI' and TanggalMasuk=CURDATE()) as 'checkin',
		(select count(nobill) from fotrdaftar where flagbill=1 and statusdaftar='RI' and TanggalKeluar=CURDATE()) as 'checkout'
		";
		$result = $this->db->query($q)->result_array();
		return $result;
	}
	

	public function select_kunjungan_px_to_sp_by_1hari($tgl_start=null, $tgl_end=null){
		$select = [
			"c.Lokasi", "b.Keterangan", "c.Dokter", 
			"IFNULL(d.Nama, 'Pegawai RS') as nama_dokter",
			"COUNT(c.NoBill) as jml_px_all",
		];
		$this->db->select($select);
		$this->db->from('fotrdaftar a');
		$this->db->join('fomstlokasi b', 'b.Kode = c.Lokasi', 'left' );
		$this->db->join('fotrdaftarrj c', 'c.NoBill = a.NoBill', 'left' );
		$this->db->join('bohtmstvendor d', 'd.Kode = c.Dokter', 'left' );
		// $where = "a.Date>='".$tgl_start."' AND a.Date<='".$tgl_end."' AND ((b.Kode>=20 AND b.Kode<=37) || b.Kode=11 || b.Kode=10 )";
		$where = "a.tanggalmasuk>='".$tgl_start."' and a.TanggalMasuk<='".$tgl_end."' 
				and a.Flagbill<>'4' and c.lokasi<>'' and a.DiagnosaAwal<>'5892' 
				and b.kode<>50 and b.kode<>51 and b.kode<>13";
		$this->db->where($where);
		$this->db->group_by('c.Dokter');
		$this->db->order_by('jml_px_all DESC, b.Keterangan ASC, d.Nama ASC');
		$query = $this->db->get();

		return $query->result();
	}


	public function select_kunjungan_px_penanggung_by_rangehari($tgl_start=null, $tgl_end=null){
		$q = "select 
				IF(a.PerusahaanPenanggung='CO031','BPJS KESEHATAN',
				IF(a.PerusahaanPenanggung='CO011','BPJS KETENAGAKERJAAN',
				IF(a.PerusahaanPenanggung='','UMUM','ASURANSI'))) as 'penanggung', 
				COUNT(c.NoBill) as jml_px_all
			FROM fotrdaftar a
			LEFT JOIN fomstlokasi b ON b.Kode = c.Lokasi
			LEFT JOIN fotrdaftarrj c ON c.NoBill = a.NoBill
			LEFT JOIN bohtmstvendor d ON d.Kode = c.Dokter
			LEFT JOIN fomstpasien mp ON mp.NoRM = a.NoRM
			LEFT JOIN boptmstcustomer ptmc ON ptmc.Kode = a.PerusahaanPenanggung
			WHERE a.tanggalmasuk>='".$tgl_start."' and a.TanggalMasuk<='".$tgl_end."' 
				and a.Flagbill<>'4' and c.lokasi<>'' and a.DiagnosaAwal<>'5892' 
				and b.kode<>50 and b.kode<>51 and b.kode<>13 
			GROUP BY penanggung
			ORDER BY jml_px_all DESC";
		$query = $this->db->query($q)->result();
		return $query;
	}

	
	// NDAK DIPAKE
	// TIAP KLINIK, TIAP PENANGGUNG
	public function select_kunjunganrj_px_tiapklinik_penanggung_by_rangehari($tgl_start=null, $tgl_end=null){
		$q = "select c.keterangan as Keterangan,
				if(a.perusahaanpenanggung='CO031','BPJS KESEHATAN',
					if(a.perusahaanpenanggung='CO011','BPJS KETENAGAKERJAAN',
					if(a.perusahaanpenanggung='','UMUM','ASURANSI'))) as PENANGGUNG, 
				count(a.noBill) As jml_px_all 
			from fotrdaftar a 
			left join fotrdaftarrj b on a.nobill=b.nobill 
			left join fomstlokasi c on c.kode=b.lokasi 
			left join boptmstcustomer d on a.perusahaanpenanggung=d.kode 
			where a.tanggalmasuk>='".$tgl_start."' and a.TanggalMasuk<='".$tgl_end."' 
				and a.Flagbill<>'4' and b.lokasi<>'' and a.DiagnosaAwal<>'5892' 
				and c.kode<>50 and c.kode<>51 and c.kode<>13 
			group by Keterangan, PENANGGUNG";
		$query = $this->db->query($q)->result_array();
		return $query;
	}


	// Sukubangsa: "" , DITAMBAHKAN SAJA DENGAN NAMA TIDAK DIKETAHUI
	public function select_kunjungan_px_demografi_suku_by_rangehari($tgl_start=null, $tgl_end=null){
		$q = "select IF(mp.Sukubangsa='','TIDAK DIKETAHUI',mp.Sukubangsa) as Sukubangsa,
				COUNT(tdrj.NoBill) as jml_px_all 
			from fotrdaftar td 
			left join fotrdaftarrj tdrj on tdrj.nobill=td.nobill 
			left join fomstlokasi ml on ml.kode=tdrj.lokasi
			left join bohtmstvendor mv on mv.Kode=tdrj.Dokter
			left join fomstpasien mp on mp.NoRM=td.NoRM
			where td.tanggalmasuk>='".$tgl_start."' and td.TanggalMasuk<='".$tgl_end."' 
				and td.flagbill<>'4' and tdrj.lokasi<>'' and td.diagnosaawal<>'5892' 
				and ml.kode<>50 and ml.kode<>51 and ml.kode<>13 
			group by Sukubangsa
			order by jml_px_all DESC";
		$query = $this->db->query($q)->result_array();
		return $query;
	}


	public function select_kunjungan_px_demografi_agama_by_rangehari($tgl_start=null, $tgl_end=null){	
		$select = [ 
			"IF(e.Agama='','TIDAK DIKETAHUI', agama.Keterangan) as Agama",
			"COUNT(c.NoBill) as jml_px_all"			
		];

		$this->db->select($select);
		$this->db->from('fotrdaftar a');
		$this->db->join('fomstlokasi b', 'b.Kode = c.Lokasi', 'left' );
		$this->db->join('fotrdaftarrj c', 'c.NoBill = a.NoBill', 'left' );
		$this->db->join('bohtmstvendor d', 'd.Kode = c.Dokter', 'left' );
		$this->db->join('fomstpasien e', 'e.NoRM = a.NoRM', 'left' );
		$this->db->join('fomstagama agama', 'agama.Kode = a.Agama', 'left' );
		$where = "a.tanggalmasuk>='".$tgl_start."' and a.TanggalMasuk<='".$tgl_end."' 
				and a.flagbill<>'4' and c.lokasi<>'' and a.diagnosaawal<>'5892' 
				and b.kode<>50 and b.kode<>51 and b.kode<>13";
		$this->db->where($where);
		$this->db->group_by('e.Agama');
		$this->db->order_by('jml_px_all DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_kunjungan_px_demografi_kec_top10_by_rangehari($tgl_start=null, $tgl_end=null){
		$select = [ 
			"mp.Kecamatan",
			"kec.Keterangan as kec",
			"kota.Keterangan as kota",
			"COUNT(c.NoBill) as jml_px_all"			
		];

		$this->db->select($select);
		$this->db->from('fotrdaftar a');
		$this->db->join('fomstlokasi b', 'b.Kode = c.Lokasi', 'left' );
		$this->db->join('fotrdaftarrj c', 'c.NoBill = a.NoBill', 'left' );
		$this->db->join('bohtmstvendor d', 'd.Kode = c.Dokter', 'left' );
		$this->db->join('fomstpasien mp', 'mp.NoRM = a.NoRM', 'left' );
		$this->db->join('fowilmstkecamatan kec', 'kec.Kode = mp.Kecamatan', 'left' );
		$this->db->join('fowilmstkota kota', 'kota.Kode = mp.Kota', 'left' );
		$where = "a.tanggalmasuk>='".$tgl_start."' and a.TanggalMasuk<='".$tgl_end."' 
				and a.flagbill<>'4' and c.lokasi<>'' and a.diagnosaawal<>'5892' 
				and b.kode<>50 and b.kode<>51 and b.kode<>13";
		$this->db->where($where);
		$this->db->group_by('kec.Keterangan');
		$this->db->order_by('jml_px_all DESC');
		$this->db->limit(10);
		$query = $this->db->get();

		return $query->result();
	}




	public function select_kunjunganri_px_penanggung_by_rangehari($tgl_start=null, $tgl_end=null){
		$q = "select
				IF(td.PerusahaanPenanggung='CO031','BPJS KESEHATAN',
				IF(td.PerusahaanPenanggung='CO011','BPJS KETENAGAKERJAAN',
				IF(td.PerusahaanPenanggung='','UMUM','ASURANSI'))) as 'penanggung', 
				COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN fokmrsetupbed ksbed ON ksbed.KodeBed = tdri.Kodebed 
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM 
			LEFT JOIN boptmstcustomer ptmc ON ptmc.Kode = td.PerusahaanPenanggung 
			WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' 
				AND td.FlagBill<>4 AND td.StatusDaftar='RI'
			GROUP BY penanggung
			ORDER BY jml_px_all DESC";
		$query = $this->db->query($q)->result();
		return $query;
	}

	public function select_kunjunganri_px_kmr_by_rangehari($tgl_start=null, $tgl_end=null){
		$q = "select
				kmruang.keterangan,
				COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN fokmrsetupbed ksbed ON ksbed.KodeBed = tdri.Kodebed 
			LEFT JOIN fokmrmstruang kmruang ON kmruang.Kode = ksbed.KodeRuang
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM 
			LEFT JOIN boptmstcustomer ptmc ON ptmc.Kode = td.PerusahaanPenanggung 
			WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND
				td.FlagBill<>4 AND td.StatusDaftar='RI'
			GROUP BY kmruang.Kode
			ORDER BY jml_px_all DESC";

		$query = $this->db->query($q)->result();
		return $query;
	
	}

	public function select_kunjunganri_px_demografi_suku_by_rangehari($tgl_start=null, $tgl_end=null){		
		$q = "select
				IF(mp.Sukubangsa='', 'TIDAK DIKETAHUI', mp.Sukubangsa) as Sukubangsa,
				COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN fokmrsetupbed ksbed ON ksbed.KodeBed = tdri.Kodebed 
			LEFT JOIN fokmrmstruang kmruang ON kmruang.Kode = ksbed.KodeRuang
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM 
			LEFT JOIN boptmstcustomer ptmc ON ptmc.Kode = td.PerusahaanPenanggung 
			WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
				td.FlagBill<>4 AND td.StatusDaftar='RI'
			GROUP BY mp.Sukubangsa
			ORDER BY jml_px_all DESC";
		$query = $this->db->query($q)->result();
		return $query;
	}

	public function select_kunjunganri_px_demografi_agama_by_rangehari($tgl_start=null, $tgl_end=null){
		$q = "select
				IF(mp.Agama='', 'TIDAK DIKETAHUI', agama.Keterangan) as Agama,
				COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN fokmrsetupbed ksbed ON ksbed.KodeBed = tdri.Kodebed 
			LEFT JOIN fokmrmstruang kmruang ON kmruang.Kode = ksbed.KodeRuang
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM 
			LEFT JOIN fomstagama agama ON agama.Kode = td.Agama 
			WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
				td.FlagBill<>4 AND td.StatusDaftar='RI'
			GROUP BY mp.Agama
			ORDER BY jml_px_all DESC";
		$query = $this->db->query($q)->result();
		return $query;
	}

	public function select_kunjunganri_px_demografi_kec_top10_by_rangehari($tgl_start=null, $tgl_end=null){
		$q = "select
				mp.Kecamatan,
				kec.Keterangan as kec,
				kota.Keterangan as kota,
				COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN fokmrsetupbed ksbed ON ksbed.KodeBed = tdri.Kodebed 
			LEFT JOIN fokmrmstruang kmruang ON kmruang.Kode = ksbed.KodeRuang
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM 
			LEFT JOIN fowilmstkecamatan kec ON kec.Kode = mp.Kecamatan 
			LEFT JOIN fowilmstkota kota ON kota.Kode = mp.Kota 
			WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
				td.FlagBill<>4 AND td.StatusDaftar='RI'
			GROUP BY kec.Keterangan
			ORDER BY jml_px_all DESC
			LIMIT 10";
		$query = $this->db->query($q)->result();
		return $query;
	}


	// last repair code: 2020-06-03 	
	public function select_kunjunganri_px_dx_top10_by_rangehari_n($tgl_start=null, $tgl_end=null){
		$q = "SELECT
				td.StatusDaftar,
				rmdx.BillStatusDaftar,
				rmdx.ICDKode,
			COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN formdiagnosa rmdx ON rmdx.BillNo = tdri.NoBill
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM  
			WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
				td.FlagBill<>4 AND td.StatusDaftar='RI' AND BillStatusDaftar='RI'
			GROUP BY rmdx.ICDKode
			ORDER BY jml_px_all DESC
			LIMIT 10";
		$query = $this->db->query($q)->result_array();


		$res_dx = $query;
		for($i=0; $i<count($res_dx); $i++){
			$js = array(
				"metadata" => array(
					"method" => "search_diagnosis"
				),
				"data" => array(
					"keyword" => $res_dx[$i]['ICDKode'],
					// "keyword" => $input['keyword']
				)
			);					
			$json_request = json_encode($js);

			// mengubah dari ECHO JSON -> RETURN ARRAY
			// ob_start();
			// $this->ws_eclaim->ws("POST", $json_request);
			// $val = ob_get_clean();
			// $val = json_decode($val, 1);

			$val_dx = $this->ws_eclaim->ws("POST", $json_request);
			$val_dx = json_decode($val_dx, 1);

			$res_dx[$i]['ICDKet'] = $val_dx['response']['data'][0][0];
		}
		return $res_dx;
	}

	public function select_kunjunganri_px_dx_top10_by_rangehari_det($tgl_start=null, $tgl_end=null){
		$q = "select
				td.NoRM,
				td.NoBill,
				rmdx.BillNo,
				td.StatusDaftar,
				rmdx.BillStatusDaftar,
				rmdx.ICDKode
				#COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN formdiagnosa rmdx ON rmdx.BillNo = tdri.NoBill
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM  
			WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
				td.FlagBill<>4 AND td.StatusDaftar='RI' AND BillStatusDaftar='RI'
			#GROUP BY rmdx.ICDKode
			#ORDER BY jml_px_all DESC
			ORDER BY rmdx.ICDKode DESC
			#LIMIT 10
			";
		$query = $this->db->query($q)->result();
		return $query;
	}



	//=======================[ \bo/menu/manajemen/dashboard-manajemen ]========================


	//=======================[  bo/menu/manajemen/morbiditas ]========================
	
	public function select_kunjunganri_px_dx_by_icd_rangebln_det($kode_icd=null, $bln_start=null, $bln_end=null){
		$tgl_start 	= $bln_start."-01";
		$tgl_end 	= maxday_of_month($bln_end);
		$q = "select
				td.NoRM,
				mp.Nama,
				CAST( SUBSTRING(td.NoBill, 5, 2) AS UNSIGNED) as bulan,
				td.NoBill,
				rmdx.BillNo,
				td.StatusDaftar,
				rmdx.BillStatusDaftar,
				rmdx.ICDKode
				#COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN formdiagnosa rmdx ON rmdx.BillNo = tdri.NoBill
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM  
			WHERE rmdx.ICDKode='".$kode_icd."' AND td.Date >= '".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
				td.FlagBill<>4 AND td.StatusDaftar='RI' AND BillStatusDaftar='RI'
			ORDER BY td.Date ASC
			";

		$query = $this->db->query($q)->result();
		return $query;
	}

	public function select_kunjunganri_px_dx_by_icd_rangebln($kode_icd=null, $bln_start=null, $bln_end=null){
		$tgl_start 	= $bln_start."-01";
		$tgl_end 	= maxday_of_month($bln_end);

		$q = "SELECT
				CAST( SUBSTRING(td.NoBill, 5, 2) AS UNSIGNED) as bulan,
				COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN formdiagnosa rmdx ON rmdx.BillNo = tdri.NoBill
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM  
			WHERE rmdx.ICDKode='".$kode_icd."' AND td.Date >= '".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
				td.FlagBill<>4 AND td.StatusDaftar='RI' AND BillStatusDaftar='RI'
			GROUP BY bulan
			ORDER BY td.Date ASC
			";

		$query = $this->db->query($q)->result();
		return $query;
	}

	//=======================[ \bo/menu/manajemen/morbiditas ]========================

	//=======================[  bo/menu/manajemen/efisiensi-hunian-tempat-tidur ]========================
	public function select_hunian($bln=null, $thn=null){
		$q = "SELECT B.KETERANGAN AS KELAS,COUNT(A.NOBILL) AS HUNIAN 
			FROM FOTRPAYMENTDETBED A 
			LEFT JOIN fokmrmstkelas B ON B.KODE=A.KODEKELAS 
			WHERE MONTH(A.TGLTRANS)='".$bln."' AND YEAR(A.TGLTRANS)='".$thn."' 
			GROUP BY KELAS
			";

		$query = $this->db->query($q)->result_array();
		return $query;
	}


	//FIRST LOAD NAMAKELAS 1 TAHUN
	public function select_efihuni_namakelas_by_th($thn=null){
		$q = "SELECT 
				mk.KODE AS mkls_kode,
				morb.kelas AS kls_mor,
				count(pdb.nobill) as cnt_bill_by_kls
				#(select count(a.nobill) from fotrpaymentdetbed where nobill=a.nobill) as LOS
			from formmorbiditasri morb
			LEFT JOIN fotrpaymentdetbed pdb ON pdb.NoBill=morb.nobill
			LEFT JOIN fokmrmstkelas mk ON mk.keterangan=morb.kelas
			where YEAR(TglTrans)='".$thn."'
			group by morb.kelas";
		$val = $this->db->query($q)->result_array();
		return $val;
	} //<END>select_efihuni_namakelas_by_th

	public function select_efihuni_jmlkamar_by_th($thn=null){
		$q = $this->m_daftarmandiri->select_efihuni_namakelas_by_th($thn);
		//return $q;

		for ($i=0; $i<count($q) ; $i++) { 
			$kdkelas = $q[$i]["mkls_kode"];
			if($kdkelas != null){
				$q_ruang = $this->m_daftarmandiri->select_jml_kamar_efihuni($kdkelas);
				
				if ($q_ruang["list"] != null) {
					$q[$i]["TT"] = (int)$q_ruang["list"][0]["jml"];
				}else{
					$q[$i]["TT"] = 0;
				}				

			}else{ // Kode kelas tidak ada di master kelas. Hanya ada di morbiditas.
				$q[$i]["TT"] = 0;
			}

		}

		return $q;

	}

	public function select_hp_by_thn_bln_hr($thn=null, $bln=null, $hr=null){
		$q = "SELECT(
			select count(NoBill) 
			from fotrpaymentdetbed
			where YEAR(TglTrans)='".$thn."' and MONTH(TglTrans)='".$bln."'  
			and DAY(TglTrans)='".$hr."'
			) as 'HP'";
		$query = $this->db->query($q)->result_array()[0];
		return $query;
	}
	
	public function select_hp_bill_by_thn_bln_hr($thn=null, $bln=null, $hr=null){
		$q = "SELECT(
			select count(NoBill) 
			from fotrpaymentdetbed
			where YEAR(TglTrans)='".$thn."' and MONTH(TglTrans)='".$bln."'  
			and DAY(TglTrans)='".$hr."'
			) as 'HP'";
		$query = $this->db->query($q)->result_array()[0];
		
		$q2 = "SELECT TglTrans, NoBill, KodeBed
			from fotrpaymentdetbed
			where YEAR(TglTrans)='".$thn."' and MONTH(TglTrans)='".$bln."'  
			and DAY(TglTrans)='".$hr."'";
		$query2 = $this->db->query($q2)->result_array();

		$val = [
			"HP" => $query['HP'],
			"detail_bill" => $query2
		];
		return $val;
	}

	public function select_efihuni_by_bln_thn($thn=null, $bln=null){
		$list_kmr = $this->m_daftarmandiri->select_efihuni_jmlkamar_by_th($thn);
		//ikuti kls_mor, karena group by morb.kelas
		if(count($list_kmr)>0){ 
			
			for ($i=0; $i<count($list_kmr); $i++) {
				//HP
				$label = 'HP';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['mkls_kode']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];
				}


				//LD
				$label = 'LD';
				$list_kmr[$i]['detail'][$label] = 0; // karena ada loop, makanya harus di deklarasi

				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['mkls_kode']);
				$arr_los = $this->db->query($q)->result_array();

				if(count($arr_los)>0){
					for($l=0; $l<count($arr_los); $l++){
						$list_kmr[$i]['detail'][$label] += (int)$arr_los[$l]['los']; //sigma LOS
					}				
				}

				

				//KHM (keluar hidup mati)
				$label = 'KHM';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['mkls_kode']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];
				}

				//'dead<48'
				$label = 'dead<48';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['mkls_kode']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					if($det[0][$label]== NULL){
						$det[0][$label] = 0;
					}
				}
				$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];


				//'dead>=48'
				$label = 'dead>=48';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['mkls_kode']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					if($det[0][$label]== NULL){
						$det[0][$label] = 0;
					}
				}
				$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];


				//'dead'
				$label = 'dead';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['mkls_kode']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					if($det[0][$label]== NULL){
						$det[0][$label] = 0;
					}
				}
				$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];

				//'hidup'
				$list_kmr[$i]['detail']['hidup'] = $list_kmr[$i]['detail']['KHM']-$list_kmr[$i]['detail']['dead'];


				// //'tt'
				// $q_tt = $this->m_daftarmandiri->select_jml_kamar_efihuni($list_kmr[$i]['kode_kls_mst']);
				// $list_kmr[$i]['detail']['TT'] = $q_tt['sum_jml_all'];
				
			}
			
			return $list_kmr;				

		}else{
			return 0;
		}
	}


	public function select_efihuni_det_by_bln_thn($thn=null, $bln=null){
		$res = $this->m_daftarmandiri->select_efihuni_by_bln_thn($thn, $bln);

		$detail = ["HP", "LD", "KHM", "dead<48", "dead>=48", "dead", "hidup", "TT"];
		for ($j=0; $j < count($detail); $j++) { 
			$tot[$detail[$j]] = 0;

			if($detail[$j] != "TT"){
				for ($i=0; $i < count($res); $i++) { 
					$tot[$detail[$j]] += (int)$res[$i]["detail"][$detail[$j]];
				}
			}else{
				for ($i=0; $i < count($res); $i++) { 
					$tot[$detail[$j]] += (int)$res[$i][$detail[$j]];
				}
			}
				
		}			

		$result = [
			"jumlah" => [
				"HP" 	=> $tot["HP"],
				"LD" 	=> $tot["LD"],
				"KHM" 	=> $tot["KHM"],
				"dead<48" 	=> $tot["dead<48"],
				"dead>=48" 	=> $tot["dead>=48"],
				"dead" 	=> $tot["dead"],
				"hidup" => $tot["hidup"],
				"TT" 	=> $tot["TT"],
			],
			"list" => $res 
		];	



		// $T = 31; // !INI HARUS DICARI BY MAXDAY OF THAT MONTH
		$mon_ny = month_now_yesterday($thn."-".$bln."-01");
		$T =  $mon_ny["now"]["maxday"]; // !INI HARUS DICARI BY MAXDAY OF THAT MONTH
		$result["periode"] = (int)$T;
		$result["bulan_label"] = bulan_indo($bln);

		for ($a=0; $a<count($res); $a++) { 
			// $res[$a]["stat"]["BOR"] = BOR($result["list"][$a]["detail"]["HP"], $result["list"][$a]["TT"], $T);
			$result["list"][$a]["stat"]["BOR"] = BOR($result["list"][$a]["detail"]["HP"], $result["list"][$a]["TT"], $T);
			$result["list"][$a]["stat"]["LOS"] = LOS($result["list"][$a]["detail"]["LD"], $result["list"][$a]["detail"]["KHM"]);
			$result["list"][$a]["stat"]["TOI"] = TOI($result["list"][$a]["detail"]["KHM"], $result["list"][$a]["TT"], $T, $result["list"][$a]["detail"]["HP"]);
			$result["list"][$a]["stat"]["BTO"] = BTO($result["list"][$a]["detail"]["KHM"], $result["list"][$a]["TT"]);
			$result["list"][$a]["stat"]["GDR"] = GDR($result["list"][$a]["detail"]["KHM"], $result["list"][$a]["detail"]["dead"]);
			$result["list"][$a]["stat"]["NDR"] = NDR($result["list"][$a]["detail"]["KHM"], $result["list"][$a]["detail"]["dead>=48"]);
		}

			$result["jumlah"]["BOR"] = BOR($result["jumlah"]["HP"], $result["jumlah"]["TT"], $T);
			$result["jumlah"]["LOS"] = LOS($result["jumlah"]["LD"], $result["jumlah"]["KHM"]);
			$result["jumlah"]["TOI"] = TOI($result["jumlah"]["KHM"], $result["jumlah"]["TT"], $T, $result["jumlah"]["HP"]);
			$result["jumlah"]["BTO"] = BTO($result["jumlah"]["KHM"], $result["jumlah"]["TT"]);
			$result["jumlah"]["GDR"] = GDR($result["jumlah"]["KHM"], $result["jumlah"]["dead"]);
			$result["jumlah"]["NDR"] = NDR($result["jumlah"]["KHM"], $result["jumlah"]["dead>=48"]);


		return $result;
	}

	public function dl_xls_stat_hospital($thn=null, $bln=null){
		$res = $this->m_daftarmandiri->select_efihuni_det_by_bln_thn($thn, $bln);

		for ($i=0; $i <count($res["list"]) ; $i++) { 
			$result[$i] = [
				"mkls_kode" => $res["list"][$i]["mkls_kode"],
				"kls_mor" 	=> $res["list"][$i]["kls_mor"],
				"TT" 		=> $res["list"][$i]["TT"],
				"HP" 	=> $res["list"][$i]["detail"]["HP"],
				"LD" 	=> $res["list"][$i]["detail"]["LD"],
				"KHM" 	=> $res["list"][$i]["detail"]["KHM"],
				"dead<48" 	=> $res["list"][$i]["detail"]["dead<48"],
				"dead>=48" 	=> $res["list"][$i]["detail"]["dead>=48"],
				"dead"	=> $res["list"][$i]["detail"]["dead"],
				"hidup" => $res["list"][$i]["detail"]["hidup"],
				"BOR" 	=> $res["list"][$i]["stat"]["BOR"],
				"LOS" 	=> $res["list"][$i]["stat"]["LOS"],
				"TOI" 	=> $res["list"][$i]["stat"]["TOI"],
				"BTO" 	=> $res["list"][$i]["stat"]["BTO"],
				"GDR" 	=> $res["list"][$i]["stat"]["GDR"],
				"NDR" 	=> $res["list"][$i]["stat"]["NDR"],
			];
		}

		return $result;
	}

	public function cek_statistik_inserted($thn=null, $bln=null){ // STATISTIK PERNAH DIINSERT
		// $q = "SELECT tahun, bulan, date FROM forptstatistik WHERE tahun='".$thn."' AND bulan='".$bln."'";
		$q = "SELECT tahun FROM forptstatistik WHERE tahun='".$thn."' AND bulan='".$bln."'";
		$query = $this->db->query($q)->result_array();		

		return ($query != null)? 1 : 0;
	}

	// INI TAMBAHAN SAJA, NDAK ADA DI CONTROLLER.
	// HANYA UNTUK JAGA2 BILA CARI DETAIL ERROR
	public function cek_detail_nama_kamar(){
		$q = "SELECT a.KodeRuang, a.KodeBed, 
				mr.keterangan AS ket_ruang,
				mr.namaRuang, #,b.keterangan
				mr.kelas as kodeKelas, 
				mkls.kode AS mkls_kd,
				mkls.keterangan as namaKelas
				#COUNT(mkls.keterangan) as jml
			from fokmrsetupbed a 
			LEFT JOIN fokmrmstruang mr on mr.Kode = a.KodeRuang
			LEFT JOIN fokmrmstbed c on c.kode = a.KodeBed
			LEFT JOIN fokmrmstkelas mkls on mkls.kode = mr.kelas
			#LEFT JOIN formmorbiditasri morb on morb.ruang = ....
			where (c.status = 'RD' OR c.status = 'IN' OR c.status = 'CO')
			AND c.jenis <>'BOX BAYI' 
			AND !(c.keterangan like 'Bed Bayangan%')
			AND !(mr.keterangan like 'R BAYI%') 
			#AND mkls.kode='27'
			#group by b.namaRuang
			order by namaKelas";

		$query = $this->db->query($q)->result_array();
		return $query;
	}

	// public function select_statistik($thn=null){
	// 	$q = "SELECT * FROM forptstatistik rs 
	// 		WHERE tahun='".$thn."'";
	// 	$query = $this->db->query($q)->result_array();
	// 	return $query;
	// }
	









	public function select_jml_kamar_efihuni($kdkelas=null){
		// get dari select yg info ketersediaan kamar di dashboard, 
		// matrix data sesuai nama kamar morbiditas
		if($kdkelas==null){
			$where = '';
		}else{
			$where = "AND mkls.kode='".$kdkelas."'";
			// $where = "AND b.kelas='".$kdkelas."'";
			// $where = "AND b.kelas='".$kdkelas."'";
		}
		
		$q_ruang = "SELECT b.namaRuang, #,b.keterangan
				b.kelas as kodeKelas, mkls.kode AS 'mkls_kd', 
				mkls.keterangan as namaKelas,
				COUNT(mkls.keterangan) as jml

			from fokmrsetupbed a 
			LEFT JOIN fokmrmstruang b on b.Kode = a.KodeRuang
			LEFT JOIN fokmrmstbed c on c.kode = a.KodeBed
			LEFT JOIN fokmrmstkelas mkls on mkls.kode = b.kelas
			#LEFT JOIN formmorbiditasri morb on morb.ruang = ....
			where  (c.status = 'RD' OR c.status = 'IN' OR c.status = 'CO') # (c.status = 'RD' OR c.status = 'IN')
				AND c.jenis <>'BOX BAYI' 
				AND !(c.keterangan like 'Bed Bayangan%')
				AND !(b.keterangan like 'R BAYI%') 
				".$where."
			group by b.namaRuang
			order by namaKelas
			";

		$query_ruang = $this->db->query($q_ruang)->result_array();

		$sum_jml_all = 0;
		for($i=0; $i<count($query_ruang); $i++){
			$sum_jml_all += (int)$query_ruang[$i]['jml']; 
		}

		$val = [
			"sum_jml_all" => $sum_jml_all,
			"list" => $query_ruang
		];

		return $val;
	}



	public function select_efisiensi_hunian($bln=null, $thn=null){
		//GET LIST NAMA+KODE KAMAR dalam 1 bulan/1th
		$q = "SELECT 
				b.KODE AS kode_kls_mst,
				#b.KETERANGAN AS kls_mst,
				#morb.nobill as nobill_sample,
				morb.kelas AS kls_mor,
				count(a.nobill) as cnt_bill_by_kls
				#(select count(a.nobill) from fotrpaymentdetbed where nobill=a.nobill) as LOS
			from formmorbiditasri morb
			LEFT JOIN fotrpaymentdetbed a ON a.NoBill=morb.nobill
			LEFT JOIN fokmrmstkelas b ON b.keterangan=morb.kelas
			where MONTH(TglTrans)='".$bln."' and YEAR(TglTrans)='".$thn."'
			group by morb.kelas";
		$list_kmr = $this->db->query($q)->result_array();
		
		//ikuti kls_mor, karena group by morb.kelas
		if(count($list_kmr)>0){ 
			
			for ($i=0; $i<count($list_kmr); $i++) {
				//HP
				$label = 'HP';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['kode_kls_mst']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];
				}


				//LD
				$label = 'LD';
				$list_kmr[$i]['detail'][$label] = 0; // karena ada loop, makanya harus di deklarasi

				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['kode_kls_mst']);
				$arr_los = $this->db->query($q)->result_array();

				if(count($arr_los)>0){
					for($l=0; $l<count($arr_los); $l++){
						$list_kmr[$i]['detail'][$label] += (int)$arr_los[$l]['los']; //sigma LOS
					}				
				}

				

				//KHM (keluar hidup mati)
				$label = 'KHM';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['kode_kls_mst']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];
				}

				//'dead<48'
				$label = 'dead<48';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['kode_kls_mst']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					if($det[0][$label]== NULL){
						$det[0][$label] = 0;
					}
				}
				$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];


				//'dead>=48'
				$label = 'dead>=48';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['kode_kls_mst']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					if($det[0][$label]== NULL){
						$det[0][$label] = 0;
					}
				}
				$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];


				//'dead'
				$label = 'dead';
				$q = statistic_hospital($label, $thn, $bln, $list_kmr[$i]['kode_kls_mst']);
				$det = $this->db->query($q)->result_array();
				if(count($det)>0){
					if($det[0][$label]== NULL){
						$det[0][$label] = 0;
					}
				}
				$list_kmr[$i]['detail'][$label] = (int)$det[0][$label];

				//'hidup'
				$list_kmr[$i]['detail']['hidup'] = $list_kmr[$i]['detail']['KHM']-$list_kmr[$i]['detail']['dead'];


				//'tt'
				$q_tt = $this->m_daftarmandiri->select_jml_kamar_efihuni($list_kmr[$i]['kode_kls_mst']);
				$list_kmr[$i]['detail']['TT'] = $q_tt['sum_jml_all'];
				
			}
			
			return $list_kmr;				

		}else{
			return 0;
		}
	} //<END>select_efisiensi_hunian



	public function select_efisiensi_hunian_det($bln=null, $thn=null){
		$q = "SELECT a.nobill,a.norm,a.nama,a.alamat,
			h.tanggalmasuk,h.tanggalkeluar,h.kategoriusia as kategori,
			a.tglkeluar,a.kelas,a.tgloperasi,k.icdkode,k.diagnosa,a.diagnosautama,a.operasiortindakan,
			if(b.keterangan='' or isnull(b.keterangan),'-',b.keterangan) as keadaankeluar,
			if(c.keterangan='' or isnull(c.keterangan),'-',c.keterangan) as carakeluar,
			if(d.keterangan='' or isnull(d.keterangan),'-',d.keterangan) as carabayar,
			if(a.type='0','Reguler',if(a.type='1','Obstetri','Perinatal')) as type,
			if(f.keterangan='' or isnull(f.keterangan),'-',f.keterangan) as caramelahirkan,
			if(e.keterangan='' or isnull(e.keterangan),'-',e.keterangan) as keadaanlahiribu,
			if(g.keterangan='' or isnull(g.keterangan),'-',g.keterangan) as keadaanlahirbayi,sum(i.billing) as total,
			(select sum(billing) from fotrpayment where lokasi='50' and nobill=a.nobill) as lab,
			(select sum(billing) from fotrpayment where lokasi='51' and nobill=a.nobill) as rad,
			(select sum(billing) from fotrpayment where mid(nonota,3,2)='sl' and nobill=a.nobill) as apt,
			(select sum(billing) from fotrpayment where nonota=a.nobill) as chargebed,
			(select sum(aa.grandtotal) from fotrpostindakandet aa 
				left join fotrpostindakan bb on aa.noreff=bb.noreff 
				left join fotrpayment cc on bb.noreff=cc.nonota 
				where (aa.type=1 and aa.typem=1) and cc.lokasi<>51 and cc.nobill=a.nobill) as ml,
			j.nama as penanggung, a.user, a.date, time_format(a.time,'%T') as time,
			(select count(nobill) from fotrpaymentdetbed where nobill=a.nobill) as los 
		from formmorbiditasri a
		left join FoRIMstKeadaanKeluar b on a.keadaankeluar=b.kode 
		left join forimstcarakeluar c on a.carakeluar=c.kode 
		left join forimstcarabayar d on a.carabayar=d.kode 
		left join foBKIAMstCaraMelahirkan f on a.caramelahirkan=f.kode 
		left join foBKIAMstKeadaanLahirIbu e on a.keadaanlahiribu=e.kode 
		left join foBKIAMstKeadaanLahiranak g on a.keadaanlahirbayi=g.kode 
		left join fotrdaftar h on h.nobill=a.nobill 
		left join fotrpayment i on i.nobill=h.nobill 
		left join boptmstcustomer j on h.perusahaanpenanggung=j.kode 
		left join formdiagnosa k on a.nobill=k.billno 
		Where MONTH(h.tanggalmasuk)='".$bln."' AND YEAR(h.tanggalmasuk)='".$thn."'
		group by a.nobill
			";

		$query = $this->db->query($q)->result_array();
		return $query;
	}

	public function select_hari_perawatan_by_bill($bill=null){
		$q = "SELECT NoBill, TglTrans
				#COUNT(NOBILL) AS HARI_PERAWATAN
			FROM FOTRPAYMENTDETBED 
			WHERE NoBill='".$bill."'
			";

		$query = $this->db->query($q)->result_array();
		return $query;
	}

	//=======================[ \bo/menu/manajemen/efisiensi-hunian-tempat-tidur ]========================

	//=======================[  bo/dashboard ]========================
	public function select_kunjungan_allpenanggung_by_bln_th($data=null){
		// $select = array('tahun', 'bulan', 'lokasi', 'SUM(kunjungan) as total_kunjungan');		
		$select = array('lokasi', 'SUM(kunjungan) as total_kunjungan');
		$this->db->select($select);
		$this->db->from('formkunjungandet');
		$where = "tahun='".$data['tahun']."' AND bulan='".$data['bulan']."'";
		$this->db->where($where);
		$this->db->group_by('lokasi');
		// $this->db->order_by('lokasi ASC');
		$this->db->order_by('total_kunjungan DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_kunjungan_group_penanggung_bln_by_th($data=null){
		$select = array('penanggung', 'bulan', 'SUM(kunjungan) as total_kunjungan');
		$this->db->select($select);
		$this->db->from('formkunjungandet');
		$where = "tahun='".$data['tahun']."'";
		$this->db->where($where);
		$group = array('penanggung','bulan');
		$this->db->group_by($group);
		$this->db->order_by('penanggung ASC','bulan');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_kunjungan_tiapLokasi_by_lokasi_th($data=null){		
		$select = array( 'bulan', 'lokasi', 'SUM(kunjungan) as total_kunjungan');
		$this->db->select($select);
		$this->db->from('formkunjungandet');
		$where = "tahun='".$data['tahun']."' AND lokasi='".$data['lokasi']."'";
		$this->db->where($where);
		$this->db->group_by(array('lokasi','bulan') );
		// $this->db->order_by('lokasi ASC');
		$this->db->order_by('bulan ASC', 'lokasi ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_lokasi_kunjungan_dboard($tahun=null){		
		$select = array('lokasi');
		$this->db->select($select);
		$this->db->from('formkunjungandet');
		$where = "tahun='".$tahun."'";
		$this->db->where($where);
		$this->db->group_by('lokasi');
		$this->db->order_by('lokasi ASC');
		// $this->db->order_by('total_kunjungan DESC');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function count_rirj_dboard($data=null){ //StatusDaftar = RI , RJ, UG
		$today 		= date("Y-m-d");
		$yesterday 	= date('Y-m-d',strtotime("-1 days"));
		// $q = "
		// select 
		// 	(SELECT COUNT(*) FROM fotrdaftarrj WHERE Date='".$today."') as rj_today, 
		// 	(SELECT COUNT(*) FROM fotrdaftarrj WHERE Date='".$yesterday."') as rj_yesterday,
		//   	(SELECT COUNT(*) FROM fotrdaftarri WHERE Date='".$today."') as ri_today,
		//  	(SELECT COUNT(*) FROM fotrdaftarri WHERE Date='".$yesterday."') as ri_yesterday
		// ";

		$q = "SELECT 
				IF(a.tanggalmasuk='".$yesterday."', 'rj_yesterday', 'rj_today') as 'label_day', 
				a.tanggalmasuk,
				COUNT(c.NoBill) as jml_px_all
			FROM fotrdaftar a
			LEFT JOIN fomstlokasi b ON b.Kode = c.Lokasi
			LEFT JOIN fotrdaftarrj c ON c.NoBill = a.NoBill
			LEFT JOIN bohtmstvendor d ON d.Kode = c.Dokter
			LEFT JOIN fomstpasien mp ON mp.NoRM = a.NoRM
			LEFT JOIN boptmstcustomer ptmc ON ptmc.Kode = a.PerusahaanPenanggung
			WHERE a.tanggalmasuk>='".$yesterday."' and a.TanggalMasuk<='".$today."' 
				and a.Flagbill<>'4' and c.lokasi<>'' and a.DiagnosaAwal<>'5892' 
				and b.kode<>50 and b.kode<>51 and b.kode<>13 
			GROUP BY tanggalmasuk
			UNION
			SELECT
				IF(td.tanggalmasuk='".$yesterday."', 'ri_yesterday', 'ri_today') as 'label_day', 
				td.tanggalmasuk, 
				COUNT(td.NoBill) as jml_px_all 
			FROM fotrdaftar td 
			LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
			LEFT JOIN fokmrsetupbed ksbed ON ksbed.KodeBed = tdri.Kodebed 
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM 
			LEFT JOIN boptmstcustomer ptmc ON ptmc.Kode = td.PerusahaanPenanggung 
			WHERE td.Date>='".$yesterday."' AND td.Date<='".$today."' 
				AND td.FlagBill<>4 AND td.StatusDaftar='RI'
			GROUP BY tanggalmasuk
			ORDER BY jml_px_all DESC";
		$query = $this->db->query($q)->result_array();
		// return $query; 


		$val = [
			"rj_yesterday" => 0,
			"rj_today" 		 => 0,
			"ri_yesterday" => 0,
			"ri_today"		 => 0,
		];

		for($i=0; $i<count($query); $i++){
			switch ($query[$i]['label_day']) {
				case 'rj_yesterday':
						$val['rj_yesterday'] = (int) $query[$i]['jml_px_all'];
					break;

				case 'rj_today':
						$val['rj_today'] = (int) $query[$i]['jml_px_all'];
					break;

				case 'ri_yesterday':
						$val['ri_yesterday'] = (int) $query[$i]['jml_px_all'];
					break;

				case 'ri_today':
						$val['ri_today'] = (int) $query[$i]['jml_px_all'];
					break;
			}
		}
			
		return $val;	
	}

	public function count_rirj_dboard_det($rirj=null, $day=null){
		if($day == 'today'){
			$date = date("Y-m-d");
		}else if($day == 'yesterday'){
			$date = date('Y-m-d',strtotime("-1 days"));
		}		
		
		$q = "
			select (SELECT COUNT(*)FROM fotrdaftar".$rirj." WHERE Date='".$date."')  as rirj_det 
		";

		$query = $this->db->query($q);
		$result = $query->result();
		return $result;		
	}

	public function download_xls_kunjungan_1th($data=null){
		// $select = array('bulan','lokasi', 'SUM(kunjungan) as total_kunjungan');
		// $this->db->select($select);
		// $this->db->from('formkunjungandet');
		// $where = "tahun='".$data['tahun']."'";
		// $this->db->where($where);
		// // $this->db->group_by('penanggung');
		// $this->db->group_by( array('bulan','lokasi') );
		// $this->db->order_by('bulan','lokasi ASC');
		// // $this->db->order_by('total_kunjungan DESC');
		// $query = $this->db->get();

		// return $query;
		// // return $query->result();

		$q = "SELECT bulan, lokasi, SUM(kunjungan) as total_kunjungan ".
			"FROM formkunjungandet ".
			"WHERE tahun = '2018' ".
			"GROUP BY bulan, lokasi ".
			"ORDER BY bulan, lokasi ASC";
		$query = $this->db->query($q);
		return $query;
	}
	//=======================[ \bo/dashboard ]========================


	//=======================[  bo/menu/casemix/pantauan_biaya_ri ]========================
	public function gd_biaya_ri_by_billing($data=null){		
		$select = array(
				'a.TglTrans', 'a.NoBill', 'b.NoRM', 'b.Nama', 'b.TanggalMasuk', 
				'a.NoNota', 'a.Keterangan', 'a.Lokasi', 
				'concat("Tindakan ", c.Keterangan) as Ket', 'a.Billing'
			);
		$this->db->select($select);
		$this->db->from('fotrpayment a');
		$this->db->join('fotrdaftar b', 'b.NoBill = a.NoBill', 'left');
		$this->db->join('fomstlokasi c', 'c.Kode = a.Lokasi', 'left');
		$where = "a.NoBill='".$data['NoBill']."'";
		$this->db->where($where);
		$this->db->order_by('a.NoNota ASC');
		// $this->db->order_by('total_kunjungan DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function gd_total_biaya_ri_by_billing($data=null){
		$select = 'SUM(Billing) as total_tarif_rs';
		$this->db->select($select);
		$this->db->from('fotrpayment tp');
		
		$where = "(tp.billing!=0 or tp.tab<8) and tp.NoBill='".$data['NoBill']."'"; // TANPA tab>8
		$this->db->where($where);
		// $this->db->order_by('tp.NoNota ASC');
		$this->db->order_by('tp.tab, tp.TglTrans, tp.nonota');
		$query = $this->db->get();

		return $query->result();
	}


	
	public function dtpx_for_det_bill($nobill=null){
		$select = [
			"td.NoBill", "td.NoRM", "td.nosep", "td.Nama", "mp.Alamat", 
			"td.PerusahaanPenanggung as penanggung", 
			"bpmc.Nama as penanggungket"
		];
		$this->db->select($select);
		$this->db->from('fotrdaftar td');
		$this->db->join('fomstpasien mp', 'mp.NoRM = td.NoRM', 'left');
		$this->db->join('boptmstcustomer bpmc', 'bpmc.Kode = td.PerusahaanPenanggung', 'left');
		$this->db->where("td.NoBill='".$nobill."'");
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function modif_gd_biaya_ri_det_by_billing($nobill=null){
		$logic = "if(tp.tab=1,'Biaya Kartu', 
        		if(tp.tab=2,concat('Pemeriksaan ',ifnull(ml.keterangan,'')), 
					if(tp.tab=3,concat('Biaya ',ifnull(ml.keterangan,tp.billingketerangan)), 
						if(tp.tab=4,concat('Tindakan ',ifnull(ml.keterangan,'')), 
							if(tp.tab=5,concat('Obat ',ifnull(ml.keterangan,'')), 
								if(tp.tab=6,tp.BillingKeterangan, 
									if(tp.tab=7,'', 
										If(tp.tab=8,'Uang Masuk - Cash', 
											if(tp.tab=9,'Uang Masuk - Debit', 
												if(tp.tab=10,'Uang Keluar', 
													if(tp.tab=11,'Payment By Cash', 
														if(tp.tab=12,concat('Payment By Debit','-','No.Approval:',tp.debitnoapprov),
															if(tp.tab=13,concat('Payment By Kredit','-','No.Approval:',tp.kreditnoapprov),
																if(tp.tab=14,concat('Payment By Penanggung','-',cs.nama), 
																	if(tp.tab=15,concat('Payment By Gratis','-','Ket:',tp.gratisketerangan),
																			if(tp.tab=16,concat('Retur Obat',' - ',tp.billingketerangan),'')
																	))))))))))))
					)
		        )
		    ) as Ket";	
		$select = array(
				'tp.TglTrans', 'tp.NoBill', 'a.NoRM', 'a.Nama', 'a.TanggalMasuk', 
				// 'tp.NoNota', 'tp.Keterangan', 'tp.Lokasi', 
				'tp.NoNota', 'tp.Lokasi', 'ml.Keterangan as Lokasiket',
				$logic, 'tp.tab',
				'if(tp.tab=11, tp.cash, 
					if(tp.tab=14, tp.cl, 
						if(tp.tab=16, tp.cash, tp.Billing))) as Billing',
				'concat("Opr. ",tp.User) as User'
			);
		$this->db->select($select);
		$this->db->from('fotrpayment tp');
		$this->db->join('fotrdaftar a', 'a.NoBill = tp.NoBill', 'left');
		$this->db->join('fomstlokasi ml', 'ml.Kode = tp.Lokasi', 'left');
		$this->db->join('boptmstcustomer cs', 'cs.kode=tp.clpenanggung', 'left');//boptmstcustomer cs on cs.kode=tp.clpenanggung
		$where = "(tp.billing!=0 or tp.tab>=8) and tp.NoBill='".$nobill."' AND tp.tab<>5";
		// $where = "(tp.billing!=0 or tp.tab<8) and tp.NoBill='".$nobill."'"; // TANPA tab>8
		$this->db->where($where);
		$this->db->order_by('tp.tab, tp.TglTrans, tp.nonota');
		$dbDataTmp = $this->db->get()->result_array();

		// obat belum close
		$obat = $this->obat_belum_close($nobill);
		for ($i=0; $i < count($obat); $i++) { 
			$dbDataTmp[] = $obat[$i];
		}

		if(count($dbDataTmp)>0){
			$bolFirstKartu 	 = True;
		    $bolFirstPeriksa = True;
		    $bolFirstBiaya 	 = True;
		    $bolFirstTindakan= True;
		    $bolFirstObat 	 = True;
		    $bolFirstRuang 	 = True;
		    $bolFirstLain 	 = True;
		    $bolFirstUKeluar = True;

			$det = [];
			
			for($i=0; $i<count($dbDataTmp); $i++){
				switch ($dbDataTmp[$i]['tab'] ) {
					case '1': //kartu
						# code...
						break;

					case '4': // Tindakan
						if($bolFirstTindakan){
							$q = "select ph.*,ml.keterangan as lokasiket
        						from fotrpostindakan ph
        						left join fomstlokasi ml on ml.kode=ph.lokasi
        						where ph.noreff='".$dbDataTmp[$i]['NoNota']."'";
							$dbdataDet = $this->db->query($q)->result_array();
							
							if(count($dbdataDet)>0){ //no ok
								$q = "select * from fotrpostindakandet pd 
										where pd.noreff='".$dbDataTmp[$i]['NoNota']."'
										order by no";
								$dbdataDet = $this->db->query($q)->result_array();
								//
								$det = [];
								if(count($dbdataDet)>0){
																		
									for($j=0; $j<count($dbdataDet); $j++){
										$det_arr = [
												"No" => $dbdataDet[$j]['No'],
												"KodeTindakan" 	=> $dbdataDet[$j]['KodeTindakan'],
												// "Keterangan" 	=> $dbdataDet[$j]['Keterangan'],
												"Jumlah" 		=> $dbdataDet[$j]['Jumlah'],
												"GrandTotal" 	=> $dbdataDet[$j]['GrandTotal'],
											];

										if($dbdataDet[$j]['type'] == 0){
											$q = "select * from fomsttindakan where kode='".$dbdataDet[$j]['KodeTindakan']."'";
											$dbDataDet1 = $this->db->query($q)->result_array();
											$det_arr["keterangan"] = $dbDataDet1[0]['keterangan'];
										}else if($dbdataDet[$j]['type'] == 1){//medis
											if($dbdataDet[$j]['typem'] == 0){ //dalam
												$q = "select * from hrdmstkaryawan where kode='".$dbdataDet[$j]['KodeTindakan']."'";
												$dbDataDet1 = $this->db->query($q)->result_array();
												$det_arr["keterangan"] = $dbDataDet1[0]['nama']."-".$dbdataDet[$j]['pelaksanaket'];
											}else if($dbdataDet[$j]['typem'] == 1){ //luar
												$q = "select * from bohtmstvendor where kode='".$dbdataDet[$j]['KodeTindakan']."'";
												$dbDataDet1 = $this->db->query($q)->result_array();
												$det_arr["keterangan"] = $dbDataDet1[0]['Nama']."-".$dbdataDet[$j]['pelaksanaket'];
											}
										}
										
										$det[$j] = $det_arr;
									}				
										
								}else{
									// return false;
									$det = [];
								}

										
								// array_push($li_reff[$i]['detail'], $det_arr);
								$dbDataTmp[$i]['detail'] = $det;
							}else{ // ok
								$q = "select ph.*,ml.keterangan as lokasiket
				                	from fotrpostindakanok ph
				                	left join fomstlokasi ml on ml.kode=ph.lokasi
				                	where ph.noreff='".$dbDataTmp[$i]['NoNota']."'";
								$dbdataDet = $this->db->query($q)->result_array();
								if(count($dbdataDet)>0){
									//tmpJenisOperasi = Trim(dbdataDet!kodejenis)
								}

							}

							// $bolFirstTindakan = False;

						}
						break;

					case '5': // Obat
						if($bolFirstObat){
							$q = "select * from boivsales where nobukti='".$dbDataTmp[$i]['NoNota']."'";
							$dbdataDet = $this->db->query($q)->result_array();
							
							if(count($dbdataDet)>0){
								$q = "select * from boivsalesdet where nobukti='".$dbDataTmp[$i]['NoNota']."' order by no";
								$dbdataDet = $this->db->query($q)->result_array();

								$det = [];
								if(count($dbdataDet)>0){
									for($j=0; $j<count($dbdataDet); $j++){
										$det_arr = [
												"no" => $dbdataDet[$j]['no'],
												"kodebrg" 	=> $dbdataDet[$j]['kodebrg'],
												"kodebrgket"=> $dbdataDet[$j]['kodebrgket'],
												"jumlah" 	=> $dbdataDet[$j]['jumlah'],
												"kemasan" 	=> $dbdataDet[$j]['kemasan'],
											];
										$det[$j] = $det_arr;
									}
								}

							}

							$dbDataTmp[$i]['detail'] = $det;
							// $bolFirstObat = False;
						}



						break;

					case '6': // ruang

						break;

					case '16': // retur jual
							$q = "select * from boivreturjual where nobukti='".$dbDataTmp[$i]['NoNota']."'";
							$dbdataDet = $this->db->query($q)->result_array();
							
							if(count($dbdataDet)>0){
								//NoBukti, TglEntry, User
								$q = "select * from boivreturjualdet where nobukti='".$dbDataTmp[$i]['NoNota']."' order by no";
								$dbdataDet = $this->db->query($q)->result_array();

								$det = [];
								if(count($dbdataDet)>0){
									for($j=0; $j<count($dbdataDet); $j++){
										$det_arr = [
												"no" => $dbdataDet[$j]['no'],
												"kodebrg" 	=> $dbdataDet[$j]['kodebrg'],
												"kodebrgket"=> $dbdataDet[$j]['kodebrgket'],
												"jumlah" 	=> $dbdataDet[$j]['jumlah'],
												"kemasan" 	=> $dbdataDet[$j]['kemasan'],
											];
										$det[$j] = $det_arr;
									}
								}
							}

							$dbDataTmp[$i]['detail'] = $det;

						break;

					
					default:
						# code...
						break;
				}

			}
		}

			

		return $dbDataTmp;
		// return $li_reff[1]['NoNota'];
	}


	public function obat_belum_close($nobill=null){
		$q ="SELECT 
		s.tglentry AS TglTrans
		, s.NoBilling AS NoBill
		, td.NoRM AS NoRM
		, mp.Nama AS Nama
		, td.TanggalMasuk AS TanggalMasuk
		, s.nobukti AS NoNota
		, s.lokasi AS Lokasi
		, s.lokasiket AS LokasiKet
		, s.Keterangan AS Ket
		, '5' AS tab
		, s.GTotal AS Billing
		, s.user AS User
		FROM boivsales s
		LEFT JOIN fotrdaftar td ON td.NoBill = s.NoBilling
		LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM
		-- LEFT JOIN fomstlokasi ml ON ml.Kode = b.Lokasi
		WHERE s.NoBilling = ?
		";
		$query = $this->db->query($q,[$nobill])->result_array();
		return $query;
	}


	// SCRIPT MASTER RSCM
	public function get_jadok(){
		// $select = array(
		// 		'a.kodeDokter', 'b.Nama'
		// 	);
		// $this->db->select($select);
		// $this->db->from('cm_dokterjadwal a');
		// $this->db->join('bohtmstvendor b', 'b.Kode = a.kodeDokter', 'left');
		// $this->db->join('fomstlokasi c', 'c.Kode = b.Lokasi', 'left');
		// $this->db->group_by('a.kodeDokter');
		// // $this->db->order_by('a.NoNota ASC');
		// $query = $this->db->get();

		$q ="SELECT a.kodeDokter, 
			IF(ISNULL(b.Nama), 
			(SELECT nama FROM hrdmstkaryawan mk WHERE mk.kode=a.kodeDokter), 
			b.Nama) AS Nama 
		FROM cm_dokterjadwal a
		LEFT JOIN bohtmstvendor b ON b.Kode = a.kodeDokter
		LEFT JOIN fomstlokasi c ON c.Kode = b.Lokasi
		GROUP BY a.kodeDokter	
		ORDER BY Nama	
		";
		$query = $this->db->query($q);

		return $query->result();
	}
		
	
	
	// SCRIPT MASTER RSCM
	public function get_carakeluar($where=null, $where_val=null){
		if ($where==null) {			
			$q ="SELECT * FROM forimstcarakeluar";
		}else{
			$q ="SELECT * FROM forimstcarakeluar WHERE ".$where."='".$where_val."'";
		}
		$query = $this->db->query($q);
		return $query->result();
	}

	public function count_id_historidiag_by_bill($data=null){
		$query = $this->db->query("SELECT * FROM cx_daftarrihistoridiag WHERE nobill='".$data['nobill']."'");
		$row = $query->num_rows();
		return $row;
	}

		
	public function get_histori_diag_by_nobill_idhisto($data=null){
		$status_tarif = 
			'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HIJAU",
				if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"KUNING",
					if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"MERAH",
						if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HITAM","")
					)
				)
			) as status_tarif';

		$label_css = 
			'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"success",
				if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"warning",
					if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"danger",
						if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"default","")
					)
				)
			) as label_css';
		$select = array('aa.*', $status_tarif, $label_css);
		$this->db->select($select);
		$this->db->from('cx_daftarrihistoridiag aa');
		$this->db->join('fotrpayment tp', '(tp.NoBill=aa.nobill && (tp.billing!=0 or tp.tab<8) )', 'left');
		$where = "aa.nobill='".$data['nobill']."' && aa.id='".$data['id']."'";
		$this->db->where($where);
		$this->db->group_by('tp.NoBill');
		$query = $this->db->get();
		return $query->result();
	}

	public function insert_daftarritarif($data1, $data2){	
		$this->db->insert('cx_daftarritarif', $data1);
		$this->db->insert('cx_rec', $data2);
	}

	// public function insert_historidiag($data1, $data2, $data3){	
	public function insert_historidiag($data){
		$this->db->insert('cx_daftarrihistoridiag', $data['data1']);
		$this->db->insert('cx_rec', $data['data2']);
	}

	public function update_historidiag($data){
		$this->db->where($data['where']);
		$this->db->update('cx_daftarrihistoridiag', $data['cx_daftarrihistoridiag']);

		$this->db->insert('cx_rec', $data['cx_rec']);
	}

	public function update_dx_terpilih($data){
		$this->db->where($data['where']);
		$this->db->update('cx_daftarritarif', $data['arr_update']);
	}


	public function select_px_ri_detail_by_bill($data=null){
		$select = array(
				'a.NoBill as nobill', 'b.Nama', 'b.NoRM', 'b.Alamat',  'c.nosep', 
				'c.PerusahaanPenanggung as kodePenanggung',
				'c.NoAnggota as namaPenanggung',
				'a.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 
				'e.keterangan as namaRuang', 'f.keterangan as namaKelas', 
				'g.keterangan as namaBed', 'h.keterangan as namaLantai',
				'i.keterangan as namaGedung'
			);
		$this->db->select($select);
		$this->db->from('fotrdaftarri a');
		$this->db->join('fotrdaftar c','c.NoBill=a.NoBill','left');
		$this->db->join('fomstpasien b','b.NoRM=c.norm','left');
		$this->db->join('fokmrsetupbed d','d.KodeBed=a.Kodebed','left');
		$this->db->join('fokmrmstruang e','e.Kode=d.KodeRuang','left');
		$this->db->join('fokmrmstkelas f','f.kode=e.kelas','left');
		$this->db->join('fokmrmstbed g','g.kode=a.Kodebed','left');
		$this->db->join('fokmrmstlantai h','h.kode=d.KodeLantai','left');
		$this->db->join('fokmrmstbuilding i','i.kode=d.Kodebuilding','left');

		$where = "c.NoBill='".$data."'";
		$this->db->where($where);
		$query = $this->db->get();


		$rowCount = $query->num_rows();

		if($rowCount > 0){
			return $query->result();
		}else{
			return null;
		}

		// return $query->result();
	}

	
	public function select_trf_ina_by_dx_pilih($nobill=null, $id_dx=null){
		$q = "SELECT tarif_inacbg, nobill, id AS id_dx FROM cx_daftarrihistoridiag WHERE nobill='".$nobill."' AND id='".$id_dx."'";
		$query = $this->db->query($q)->result_array();
		if($query == null){
			$val = [
				"metaData"  => [
					"status"  => "failed",
					"message" => "Data tidak ada!",
				],
			];
		}else{
			$val = [
				"metaData"  => [
					"status"  => "success",
					"message" => "OK",
				],				
				"response" => $query[0],
			];
		}
		return $val;
	}

	


	//=======================[ \bo/menu/casemix/pantauan_biaya_ri ]========================


	//=======================[  bo/menu/casemix/laporan_pasien_ri ]========================
	// public function select_laporan_px_ri_by_date($data=null){
	// 	$select = array('a.*', 'aa.tarif_inacbg as tarif_ina_terpilih', 'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 'e.keterangan as nama_ruang');
	// 	$this->db->select($select);
	// 	$this->db->from('cx_daftarritarif a');
	// 	$this->db->from('cx_daftarrihistoridiag aa', 'aa.nobill=a.nobill && aa.id=a.id_histori', 'left');
	// 	$this->db->join('fomstpasien b','b.NoRM=a.norm','left');
	// 	$this->db->join('fotrdaftarri c','c.Nobill=a.nobill','left');
	// 	$this->db->join('fokmrsetupbed d','d.KodeBed=c.Kodebed','left');
	// 	$this->db->join('fokmrmstruang e','e.Kode=d.KodeRuang','left');
	// 	$where = "a.date='".$data['date']."'";
	// 	$this->db->where($where);
	// 	$this->db->order_by('a.nobill ASC');
	// 	$query = $this->db->get();

	// 	return $query->result();
	// }

	public function select_laporan_px_rj_by_date($date=null){
		$q = "SELECT NoBill, nosep, NoRM, Nama, 
				totalINA,
				IF(totalINA=0, 'NOL', 'OK') as 'status',
				NoAnggota, PerusahaanPenanggung, StatusDaftar, 
				IF(FlagBill=0, 'OPEN', 
					IF(FlagBill=1, 'CLOSE', 
						IF(FlagBill=4, 'BATAL', FlagBill)
					)) AS FlagBill
			FROM fotrdaftar 
			WHERE date = '".$date."'";
		$query = $this->db->query($q)->result_array();
		return $query;
	}

	public function new_select_laporan_px_ri_by_date($data=null){
		$q = "SELECT a.*, if(aa.tarif_inacbg is null, 0, 
		aa.tarif_inacbg) as tarif_ina_terpilih, 
		b.Nama, c.Kodebed, d.KodeLantai, d.KodeRuang, 
		e.keterangan as nama_ruang, 
		SUM(tp.Billing) as tarif_rs_now
		FROM cx_daftarritarif a
		LEFT JOIN cx_daftarrihistoridiag aa ON (aa.nobill=a.nobill AND aa.id=a.id_histori)
		LEFT JOIN fotrpayment tp ON (tp.NoBill=a.nobill AND (tp.billing!=0 OR tp.tab<8) )
		LEFT JOIN fomstpasien b ON b.NoRM=a.norm
		LEFT JOIN fotrdaftarri c ON c.Nobill=a.nobill
		LEFT JOIN fokmrsetupbed d ON d.KodeBed=c.Kodebed
		LEFT JOIN fokmrmstruang e ON e.Kode=d.KodeRuang
		LEFT JOIN fotrdaftar f ON f.NoBill=a.nobill
		WHERE f.TanggalMasuk='2019-09-16'
		GROUP BY tp.NoBill
		ORDER BY a.nobill ASC";

		$query = $this->db->query($q)->result_array();
		return $query;

	}

	// // SANGAT LAMA, KADANG FAILED LOAD
	// public function select_laporan_px_ri_by_date($data=null){
	// 	set_time_limit(60);
	// 	$tarif_ina_terpilih = 'if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg)';
	// 	$status_bill = 'if(a.proses = 0, "PROSES", "FINAL")';
	// 	$status_tarif = 
	// 		'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HIJAU",
	// 			if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"KUNING",
	// 				if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"MERAH",
	// 					if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HITAM","")
	// 				)
	// 			)
	// 		) as status_tarif';

	// 	$label_css = 
	// 		'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"success",
	// 			if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"warning",
	// 				if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"danger",
	// 					if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"default","")
	// 				)
	// 			)
	// 		) as label_css';
	// 	$select = array('a.*', $tarif_ina_terpilih.' as tarif_ina_terpilih', 
	// 		'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 'e.keterangan as nama_ruang', 
	// 		'SUM(tp.Billing) as tarif_rs_now', 
	// 		$status_bill.' as status_bill', $status_tarif, $label_css
	// 	);
	// 	// $select = array('a.*', 'aa.tarif_inacbg as tarif_ina_terpilih', 'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 'e.keterangan as nama_ruang');
	// 	$this->db->select($select);
	// 	$this->db->from('cx_daftarritarif a');
	// 	$this->db->join('cx_daftarrihistoridiag aa', '(aa.nobill=a.nobill AND aa.id=a.id_histori)', 'left');
	// 	$this->db->join('fotrpayment tp', '(tp.NoBill=a.nobill AND (tp.billing!=0 or tp.tab<8) )', 'left');
	// 	$this->db->join('fomstpasien b','b.NoRM=a.norm', 'left');
	// 	$this->db->join('fotrdaftarri c','c.Nobill=a.nobill', 'left');
	// 	$this->db->join('fokmrsetupbed d','d.KodeBed=c.Kodebed', 'left');
	// 	$this->db->join('fokmrmstruang e','e.Kode=d.KodeRuang', 'left');
	// 	$this->db->join('fotrdaftar f','f.NoBill=a.nobill', 'left');
	// 	// $where = "a.date='".$data['date']."'";
	// 	$where = "f.TanggalMasuk='".$data['date']."'";
	// 	$this->db->where($where);
	// 	// $this->db->group_by('tp.Billing');
	// 	$this->db->group_by('tp.NoBill');
	// 	$this->db->order_by('a.nobill ASC');
	// 	$query = $this->db->get();

	// 	return $query->result();
	// }



	// TERAKHIR KALI PAKE INI
	// dicomment pada : 2021.03.24
	// // CEPAT
	// public function select_laporan_px_ri_by_daterange($date_start=null, $date_end=null, $download=null){
	// 	$menit = 3;
	// 	$settime = 60*$menit;
	// 	set_time_limit($settime);
	// 	$tarif_ina_terpilih = 'if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) as tarif_ina_terpilih';
	// 	$status_bill = 'if(a.proses = 0, "PROSES", "FINAL") as status_bill';
	// 	$status_tarif = 
	// 		'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HIJAU",
	// 			if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"KUNING",
	// 				if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"MERAH",
	// 					if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HITAM","")
	// 				)
	// 			)
	// 		) as status_tarif';

	// 	$label_css = 
	// 		'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"success",
	// 			if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"warning",
	// 				if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"danger",
	// 					if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"default","")
	// 				)
	// 			)
	// 		) as label_css';

		

	// 	// if($download){
	// 	// 	$ftd = 'f.NoBill=a.nobill AND StatusDaftar="RI" AND (f.FlagBill="0" OR f.FlagBill="1")';
	// 	// }else{
	// 	// 	$ftd = 'f.NoBill=a.nobill AND StatusDaftar="RI" AND f.FlagBill="0"';
	// 	// }

	// 	$select = array('a.*', $tarif_ina_terpilih, 
	// 			'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 
	// 			'e.keterangan as nama_ruang', 
	// 			'SUM(tp.Billing) as tarif_rs_now', 'f.FlagBill',
	// 			'IF(f.FlagBill=0,"OPEN", IF(f.FlagBill=1,"CLOSE","") ) AS FlagBillKet',
	// 			$status_bill, 
	// 			$status_tarif, $label_css
	// 		);

	// 	$this->db->select($select);
	// 	$this->db->from('cx_daftarritarif a');
	// 	$this->db->join('cx_daftarrihistoridiag aa', '(aa.nobill=a.nobill AND aa.id=a.id_histori)', 'left');

	// 	$this->db->join('fotrdaftar f','f.NoBill=a.nobill AND StatusDaftar="RI" AND (f.FlagBill="0" OR f.FlagBill="1")', 'left');
		
	// 	$this->db->join('fomstpasien b','b.NoRM=a.norm', 'left');
	// 	$this->db->join('fotrdaftarri c','c.Nobill=a.nobill', 'left');
	// 	$this->db->join('fotrpayment tp', 'tp.NoBill=a.nobill AND (tp.billing<>0 OR tp.tab<8) ', 'left');
	// 	$this->db->join('fokmrsetupbed d','d.KodeBed=c.Kodebed', 'left');
	// 	$this->db->join('fokmrmstruang e','e.Kode=d.KodeRuang', 'left');
	// 	$where = "f.TanggalMasuk>='".$date_start."' AND f.TanggalMasuk<='".$date_end."'";
	// 	$this->db->where($where);
	// 	// $this->db->group_by('tp.Billing');
	// 	$this->db->group_by('tp.NoBill');
	// 	$this->db->order_by('a.nobill ASC');
	// 	$query = $this->db->get();
		
	// 	return $query->result_array();

	// 	// $q = "SELECT a.*, $tarif_ina_terpilih, 
	// 	// 'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 
	// 	// 'e.keterangan as nama_ruang', 
	// 	// 'SUM(tp.Billing) as tarif_rs_now', 'f.FlagBill'"

	// }
	


	

	
	// dicomment pada : 2021.03.24
	// // CEPAT, MASIH PERBAIKAN BELUM CEPAT
	// public function select_laporan_px_ri_by_daterange_n($date_start=null, $date_end=null, $download=null){
	// 	$menit = 4;
	// 	$settime = 60*$menit;
	// 	set_time_limit($settime);
	// 	$q = "SELECT a.*, if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) as tarif_ina_terpilih, 
	// 	b.Nama, c.Kodebed, d.KodeLantai, d.KodeRuang, 
	// 	e.keterangan as nama_ruang, 
	// 	SUM(tp.Billing) as tarif_rs_now, f.FlagBill,
	// 	IF(f.FlagBill=0,'OPEN', IF(f.FlagBill=1,'CLOSE','') ) AS FlagBillKet,
	// 	if(a.proses = 0, 'PROSES', 'FINAL') as status_bill, 
	// 				if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'HIJAU',
	// 					if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'KUNING',
	// 						if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'MERAH',
	// 							if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'HITAM','')
	// 						)
	// 					)
	// 				) as status_tarif, 
	// 	if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'success',
	// 					if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'warning',
	// 						if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'danger',
	// 							if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),'default','')
	// 						)
	// 					)
	// 				) as label_css
					
	// 	FROM cx_daftarritarif a
	// 	LEFT JOIN cx_daftarrihistoridiag aa ON (aa.nobill=a.nobill AND aa.id=a.id_histori)
	// 	LEFT JOIN fotrdaftar f ON f.NoBill=a.nobill AND StatusDaftar='RI' AND (f.FlagBill='0' OR f.FlagBill='1')
	// 	LEFT JOIN fomstpasien b ON b.NoRM=a.norm
	// 	LEFT JOIN fotrdaftarri c ON c.Nobill=a.nobill
	// 	LEFT JOIN fotrpayment tp ON tp.NoBill=a.nobill AND (tp.billing<>0 OR tp.tab<8) 
	// 	LEFT JOIN fokmrsetupbed d ON d.KodeBed=c.Kodebed
	// 	LEFT JOIN fokmrmstruang e ON e.Kode=d.KodeRuang
		
	// 	WHERE f.TanggalMasuk>='".$date_start."' AND f.TanggalMasuk<='".$date_end."'
	// 	group by tp.NoBill
	// 	order by a.nobill ASC		
	// 	";

	// 	$query = $this->db->query($q)->result_array();
	// 	return $query;
	// }








	public function q_select_laporan_px_ri_by_date($data=null){
		set_time_limit(50);
		$tarif_ina_terpilih = 'if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) as tarif_ina_terpilih';
		$status_bill = 'if(a.proses = 0, "PROSES", "FINAL") as status_bill';
		
		$status_tarif = 
			'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HIJAU",
				if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"KUNING",
					if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"MERAH",
						if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HITAM","")
					)
				)
			) as status_tarif';

		$label_css = 
			'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"success",
				if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"warning",
					if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) && SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"danger",
						if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"default","")
					)
				)
			) as label_css';

		$select = array('a.*', $tarif_ina_terpilih, $status_tarif, 'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 'e.keterangan as nama_ruang', 'SUM(tp.Billing) as tarif_rs_now', $status_bill, $label_css);
		// $select = array('a.*', 'aa.tarif_inacbg as tarif_ina_terpilih', 'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 'e.keterangan as nama_ruang');
		$this->db->select($select);
		$this->db->from('cx_daftarritarif a');
		$this->db->join('cx_daftarrihistoridiag aa', '(aa.nobill=a.nobill AND aa.id=a.id_histori)', 'left');
		$this->db->join('fotrdaftar f','f.NoBill=a.nobill', 'left');
		$this->db->join('fotrpayment tp', '(tp.NoBill=a.nobill AND (tp.billing!=0 or tp.tab<8) )', 'left');
		$this->db->join('fomstpasien b','b.NoRM=a.norm', 'left');
		$this->db->join('fotrdaftarri c','c.Nobill=a.nobill', 'left');
		$this->db->join('fokmrsetupbed d','d.KodeBed=c.Kodebed', 'left');
		$this->db->join('fokmrmstruang e','e.Kode=d.KodeRuang', 'left');
		// $where = "a.date='".$data['date']."'";
		$where = "f.TanggalMasuk='".$data['date']."'";
		$this->db->where($where);
		// $this->db->group_by('tp.Billing');
		$this->db->group_by('tp.NoBill');
		$this->db->order_by('a.nobill ASC');
		$query = $this->db->get();

		// return $query->result();
		return $query;
	}

	//=======================[ \bo/menu/casemix/laporan_pasien_ri ]========================



	//=======================[  bo/menu/casemix/master_cp ]========================
	public function insert_mst_kegiatan($data){	
		$this->db->insert('cx_mstkegiatan', $data);
	}


	public function select_mst_kegiatan($data=null){		
		$select = array('kegiatan');
		$this->db->select($select);
		$this->db->from('cx_mstkegiatan');
		$this->db->order_by('id ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_detail_kegiatan_by_lokasi($data=null){		
		$select = array('a.Kode as kodelokasi', 
				'a.Keterangan as lokasiket', 
				'b.kode as kodetindakan',
				// '(SELECT RIGHT(b.kodetindakan,2))',
				'b.keterangan',
				'b.tarifumum',
				'b.FlagHidden',
				'c.Kode as kode_tindakangrp'
			);
		$this->db->select($select);
		$this->db->from('fomstlokasi a');
		$this->db->join('fomsttindakan b', 'b.kodelokasi = a.Kode', 'left');
		// $this->db->join('fomsttindakangrp c', 'c.Kode = (SELECT RIGHT(b.kodetindakan,4)', 'left');
		$this->db->join('fomsttindakangrp c', 'c.Kode LIKE "%b.kode%"', 'left');
		$where = "a.Keterangan='".$data['lokasiket']."' AND b.FlagHidden='0'";
		$this->db->where($where);
		$query = $this->db->get();

		return $query->result();
	}
	//=======================[ \bo/menu/casemix/master_cp ]========================



	//=======================[  bo/menu/it/support/departemen/transfer-billing ]========================
	public function select_transfer_obat($noreff=null){
		$select = [ "mp.Nama","tp.TglTrans", "tp.NoBill", "td.FlagBill", "tp.NoNota", "tp.User", "tp.Date", "tp.Time"];
		$this->db->select($select);
		$this->db->from("fotrpayment tp");
		$this->db->join('fotrdaftar td', 'td.NoBill = tp.NoBill', 'left');
		$this->db->join('fomstpasien mp', 'mp.NoRM = td.NoRM', 'left');
		$this->db->where("tp.NoNota ='".$noreff."'");
		$query = $this->db->get();

		return $query->result();
	}

	public function select_fotrdaftar_by_bill($nobill=null){
		$select = ['td.*', 'md.Keterangan AS DiagnosaAwalKet', 
				'mp.TempatLahir', 'mp.TglLahir', 'mp.NoIdentitas',
				'IF(td.StatusDaftar="UG", "IGD", 
					IF(td.StatusDaftar="RI", 
						(
							SELECT k.keterangan as kelas_ruang
							FROM fotrdaftarri di
							left join fokmrsetupbed sb ON sb.KodeBed=di.Kodebed
							left join fokmrmstruang r on r.kode=sb.koderuang
							left join fokmrmstkelas k on k.kode=r.kelas
							WHERE NoBill=td.NoBill), 
					"")
				) AS ruangJR'
			];
		$this->db->select($select);
		$this->db->from("fotrdaftar td");		
		$this->db->join('fomstdiagnosaawal md', 'md.Kode = td.DiagnosaAwal', 'left');
		$this->db->join('fomstpasien mp', 'mp.NoRM = td.NoRM', 'left');
		$this->db->where("td.NoBill ='".$nobill."'");
		$query = $this->db->get()->result_array();

		return $query;
	}

	//=======================[ \bo/menu/it/support/departemen/transfer-billing ]========================
	
	
	//=======================[  bo/menu/it/support/ws/e_char_aneh_fotrdaftar ]========================
	public function e_char_aneh_fotrdaftar($nobill=null){
		// $q = "";
		$x = ['NoBill', 'NoBillSub', 'NoRM','TanggalMasuk', 
					'JamMasuk', 'TanggalKeluar', 'JamKeluar',
					'StatusBl', 'FlagBill',
					'DiagnosaAwal', 'Anggota',
					'PerusahaanPenanggung', 'BiayaKartu',
					'BiayaKartuUpDisc',
					'StatusDaftar', 'Nama', 'Alamat', 'Telp',
					'HP', 'Fax',
					'Email', 'RT', 'RW', 'Kelurahan',
					'Kecamatan', 'Kota', 'Propinsi',
					'Negara', 'Agama', 'Pendidikan', 'Pekerjaan',
					'Sex', 'Marital'
				];
				
				
				for($i=0; $i<count($x); $i++){
					echo $i.". ".$x[$i]." >> ";
					$q = "SELECT ".$x[$i]."	from fotrdaftar where NoBill='".$nobill."'";
					$query = $this->db->query($q)->result_array();
					// $val[$i] = [$x[$i] , $query ];

					echo json_encode($query);
					echo "<br>";
				}
				// return $val;

	}	
	
	//=======================[ \bo/menu/it/support/ws/e_char_aneh_fotrdaftar ]========================


	//=======================[  bo/menu/it/support/ws/prb ]========================
	public function select_prb_by_date($date=null){
		$q = "SELECT td.nobill, td.norm, mp.nama, mp.PRB 
			FROM fotrdaftar td
			LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM			
			WHERE td.date='".$date."'
				AND mp.PRB='1'
		";

		$query = $this->db->query($q)->result_array();
		return $query; 
	}
	//=======================[ \bo/menu/it/support/ws/prb ]========================

	//=======================[  bo/menu/it/user/user-akses ]========================

	public function select_user($data=null){
		// $select = "*";
		$select = ['u.id', 'u.noreg', 'u.username', 
			'd.Kode AS departemenkode', 
			'd.Keterangan AS departemen', 
			'ds.Kode AS departemensubkode', 
			'ds.Keterangan AS departemensub', 
		];
		$this->db->select($select);
		$this->db->from('xuser u');		
		$this->db->join('hrdmstkaryawan mk', 'mk.kode=u.noreg', 'left');
		$this->db->join('hrdmstdepartemen d', 'd.Kode=mk.departemen', 'left');
		$this->db->join('hrdmstdepartemensub ds', 'ds.Kode=mk.departemensub', 'left');
		// $this->db->order_by('u.username ASC');
		$this->db->order_by('d.Kode ASC, ds.Kode ASC, u.noreg ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function select_menu_bo_sidebar_by_id($data=null){
		$select = "*";
		$this->db->select($select);
		$this->db->from('xuserakses a');
		$where = "a.id_user='".$data['id_user']."' && a.filter_name='menu_bo_sidebar' && a.filter_val='".$data['filter_val']."'";
		$this->db->where($where);
		$query = $this->db->get();

		return $query->result();
	}

	public function select_menu_bo_sidebar_by_filterval($data=null){
		$select = "*";
		$this->db->select($select);
		$this->db->from('xuserakses a');
		$where = "a.filter_name='menu_bo_sidebar' && a.filter_val='".$data['filter_val']."'";
		$this->db->where($where);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_userakses_menu($data=null){
		$select = "filter_val";
		// $select = "*";
		$this->db->select($select);
		$this->db->from('xuserakses');
		$this->db->where("id_user='".$data['id_user']."' && filter_name='menu_bo_sidebar' && status=1");
		$query = $this->db->get();
		return $query->result();
	}






	//=======================[  /bo/menu/it/user/user-akses ]========================

	//=======================[  bo/menu/rm/other/perbaikan-karakter-aneh ]========================

	public function select_billing_karakter_aneh($nobill=null){
		$select = "*";
		$this->db->select($select);
		$this->db->from('fotrdaftar');
		$this->db->where('NoBill = "'.$nobill.'"');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function select_billing_karakter_aneh_mstpx($norm=null){
		$select = "*";
		$this->db->select($select);
		$this->db->from('fomstpasien');
		$this->db->where('NoRM = "'.$norm.'"');
		$query = $this->db->get();

		return $query->result();
	}




	//=======================[  /bo/menu/rm/other/perbaikan-karakter-aneh ]========================

	//=======================[   bo/menu/hrd ]========================
	public function select_hrd_abs_log($data=null){
		$select = "*";
		$this->db->select($select);
		$this->db->from('hrd_abs_log');
		$this->db->where('id = "92586" && fddate like "2019-03-18%"');
		// $this->db->where('id = "'.$data['NoRM'].'"');
		$query = $this->db->get();

		return $query->result();
	}
	
	public function select_pegawai_terlambat($date=null){
		$q = "SELECT * FROM hrd_abs_log 
			WHERE fddate like '".$date."-%' AND TIME(fddate) >= '08:00:00' AND TIME(fddate) < '09:00:00'
			ORDER BY id,fddate";
		$query = $this->db->query($q)->result_array();
		return $query; 
	}
	
	public function select_pegawai_terlambat_by_id($date=null, $id=null){
		$q = "SELECT * FROM hrd_abs_log 
			WHERE id='".$id."' AND fddate like '".$date."-%' AND TIME(fddate) >= '08:00:00' AND TIME(fddate) < '09:00:00'
			ORDER BY id,fddate";
		$query = $this->db->query($q)->result_array();
		return $query; 
	}

	public function update_hrd_abs_log($data=null){
		// $select = "*";
		// $this->db->select($select);
		// $this->db->from('hrd_abs_log');
		// $this->db->where('id = "92586" && fddate like "2019-03-18%"');
		// // $this->db->where('id = "'.$data['NoRM'].'"');
		// $query = $this->db->get();

		// return $query->result();

		$q = "update hrd_abs_log set fddate='".$params['Sukubangsa']."' where id='92586' && fddate like '2019-05-14%'";
		$query = $this->db->query($q);
		return $this->db->affected_rows();
	}
	//=======================[  /bo/menu/hrd ]========================

	//=======================[  CETAK PRINTER ]========================

	public function cetak_skdp_antrian($norm_noka=null, $nomor=null, $date='CURDATE()'){
		$where = ($norm_noka == 'norm')? 'td.NoRM' : 'mp.Barcode';
		
		$q = "SELECT td.NoRM AS norm, td.NoBill AS billing,
				td.TanggalMasuk AS tglSep,
				td.nosep, td.noskdp, 
				td.asalPPK AS provPerujuk, tdrj.tglrujukan,
				tdrj.Lokasi, ml.Keterangan AS lokasiket,
				tdrj.NoUrut, SUBSTRING(tdrj.NoUrut, 7, 9) AS no_antrian,
				tdrj.Dokter, mv.Nama AS dpjp,
				mp.Barcode, mp.Nama AS nama, mp.Alamat, mp.TglLahir AS tglLahir,
				td.Date, td.Time
			FROM fotrdaftar td
			LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
			LEFT JOIN fotrdaftarrj tdrj ON tdrj.NoBill=td.NoBill
			LEFT JOIN fomstlokasi ml ON ml.Kode=tdrj.Lokasi
			-- LEFT JOIN fotrpayment tp ON tp.NoBill=td.NoBill
			LEFT JOIN bohtmstvendor mv ON mv.Kode=tdrj.Dokter
			WHERE $where=?
			AND (isnull(td.nobill) or td.flagbill<>'4')
			AND td.Date = '".$date."'";

		// return $q;
		return $this->db->query($q, [$nomor])->result_array();
		// return $this->db->query($q)->result_array();
	}


  public function select_printer_list(){

  }

	//=======================[ \CETAK PRINTER ]========================

	//=======================[  APP ]========================

	public function update($data=null){
		$this->db->where($data['where']);
		$this->db->update($data['table'], $data['arr_data']);
	}

	public function update_new($table=null, $arr_data=null, $where=null){
		$this->db->update($table, $arr_data, $where);
		// $this->db->where('id',$id);
  //       $this->db->update('users',$value)
	}

	// public function update_batch($table=null, $arr_data=null, $value=null, $batch_size=null){
	public function update_batch($table=null, $arr_data=null, $value=null){
		$this->db->update_batch($table, $arr_data, $value);
	}

	public function insert($data){
		$this->db->insert($data['table'], $data['arr_data']);
	}

	public function insert_new($table=null, $arr_data=null){
		$this->db->insert($table, $arr_data);
	}

	public function insert_batch($table=null, $arr_data=null){
		$this->db->insert_batch($table, $arr_data);
	}

	public function delete($table=null, $where=null){
		// $this->db->where('id', $data['id']);
	 	// $this->db->delete('mutumst');
		$this->db->where($where);		
	  $this->db->delete($table);
	}
	
	public function delete_post($data){
		// $this->db->where('id', $data['id']);
	 	// $this->db->delete('mutumst');
		$this->db->where($data['where']);
	  $this->db->delete($data['table_name']);
	}
	//=======================[ \APP ]========================


	//=======================[  bo/menu/akuntansi/laporan-pendapatan-dokter ]========================
	public function select_dokter_all_lappendapatandokter($tgl_start=null, $tgl_end=null){
		$q = "
			select 
			d.kodetindakan as kodeDokter,
			if(d.TypeM=0,hk.nama,mv.nama) as Nama			
			from fotrpostindakan h
			left join fotrpostindakandet d on d.noreff=h.noreff
			left join fotrdaftar x on x.nobill=h.nobill
			left join fotrdaftarri m on x.nobill=m.nobill
			left join fokmrsetupbed n on m.kodebed=n.kodebed
			left join fokmrmstruang o on n.koderuang=o.kode
			left join fokmrmstkelas p on o.kelas=p.kode
			left join fomstpasien z on z.norm=x.norm
			left join hrdmstkaryawan hk on hk.kode=d.kodetindakan
			left join bohtmstvendor mv on mv.kode=d.kodetindakan
			left join boptmstcustomer e on e.kode=x.perusahaanpenanggung
			where (isnull(x.nobill) or x.flagbill<>'4') and d.type=1 and
			h.tgl>='".$tgl_start."' and h.tgl<='".$tgl_end."'
			and h.flagpostmedis='1'
			group by d.kodetindakan
			order by d.kodetindakan";

		return $this->db->query($q)->result_array();
	}

	//belum dipakai
	public function select_laporan_pendapatan_dokter_all($tgl_start=null, $tgl_end=null, $download=null){
		$q = "#tindakan medis
			#BPJS(RAWAT JALAN)
			select 
			h.Tgl,h.nobill as NoBill,
			d.NoReff as NoBukti,
			d.kodetindakan as Kode,
			if(d.TypeM=0,hk.nama,mv.nama) as Dokter,
			d.pelaksanaket as Tindakan,

			d.totaltarif as 'tarif_asli', #'biayadokter(bruto)'
			if(d.totaltarif=45000, (d.totaltarif+5000), d.totaltarif) as 'bruto',
			#d.totaltarif - (d.totaltarif * (2.5 / 100)) as 'netto_lama', #'biayadokter(netto)',
			if(d.totaltarif=45000, 
				(d.totaltarif+5000) - (d.totaltarif * (2.5 / 100)), 
				d.totaltarif - (d.totaltarif * (2.5 / 100))
			) as 'netto',

			(d.totaltarif * (2.5 / 100)) as 'pph', # pph=bruto-netto

			if(h.nobill<>'',z.nama,h.nama) as NamaPasien,
			if(h.nobill<>'',z.alamat,h.alamat) as AlamatPasien,
			e.kode as kodePenanggung,
			e.nama as Penanggung,
			p.keterangan as Kelas
			from fotrpostindakan h
			left join fotrpostindakandet d on d.noreff=h.noreff
			left join fotrdaftar x on x.nobill=h.nobill
			left join fotrdaftarri m on x.nobill=m.nobill
			left join fokmrsetupbed n on m.kodebed=n.kodebed
			left join fokmrmstruang o on n.koderuang=o.kode
			left join fokmrmstkelas p on o.kelas=p.kode
			left join fomstpasien z on z.norm=x.norm
			left join hrdmstkaryawan hk on hk.kode=d.kodetindakan
			left join bohtmstvendor mv on mv.kode=d.kodetindakan
			left join boptmstcustomer e on e.kode=x.perusahaanpenanggung
			where (isnull(x.nobill) or x.flagbill<>'4') and d.type=1 and
			h.tgl>='".$tgl_start."' and h.tgl<='".$tgl_end."'
			and h.flagpostmedis='1'
			order by h.tgl, h.nobill, h.noreff #d.kodetindakan";

		if($download){ // TRUE = download excel
			return $this->db->query($q);
		}else{ // show data
			return $this->db->query($q)->result_array();
		}
		
	}

	public function select_laporan_pendapatan_dokter($tgl_start=null, $tgl_end=null, $kode_dokter=null, $penanggung=null, $print_query=null){

				// if(d.totaltarif=45000, 
				// 	(d.totaltarif+5000) - (d.totaltarif*(2.5/100)), 
				// 	d.totaltarif - (d.totaltarif*(2.5/100))
				// ) as 'netto',

		// #tindakan medis
		// #BPJS(RAWAT JALAN)
		$q_select_join = "
			SELECT 
				h.Tgl,h.nobill as NoBill,
				d.NoReff as NoBukti,
				d.kodetindakan as Kode,
				if(d.TypeM=0,hk.nama,mv.nama) as Dokter,
				d.pelaksanaket as Tindakan,
				d.totaltarif as 'tarif_asli', #'biayadokter(bruto)'

				#if(d.totaltarif=45000, (d.totaltarif+5000), d.totaltarif) as 'bruto',

				if(e.kode='CO031',
					if(d.totaltarif=45000, (d.totaltarif+5000), d.totaltarif),
					if(d.pelaksanaket='Periksa/Konsultasi dokter spesialis', 80000, d.totaltarif)
				) as 'bruto',

				if(e.kode='CO031',
					if(d.totaltarif=45000, 
						(d.totaltarif+5000) - (d.totaltarif*(2.5/100)), 
						d.totaltarif - (d.totaltarif*(2.5/100))
					),
					if(d.pelaksanaket='Periksa/Konsultasi dokter spesialis',
						80000 - (d.totaltarif*(2.5/100)), 
						d.totaltarif - (d.totaltarif*(2.5/100))
					)	
				) as 'netto',

				(d.totaltarif * (2.5 / 100)) as 'pph', # pph=bruto-netto

				#If(SDOptPjkProfesi = '1', 'd.totaltarif - (d.totaltarif * (' & nPjkProfesi & ' / 100))', 'd.totaltarif') & ' as Total,
				if(h.nobill<>'',z.nama,h.nama) as NamaPasien,
				if(h.nobill<>'',z.alamat,h.alamat) as AlamatPasien,
				e.kode as kodePenanggung,
				e.nama as Penanggung,
				p.keterangan as Kelas
			from fotrpostindakan h
			left join fotrpostindakandet d on d.noreff=h.noreff
			left join fotrdaftar x on x.nobill=h.nobill
			left join fotrdaftarri m on x.nobill=m.nobill
			left join fokmrsetupbed n on m.kodebed=n.kodebed
			left join fokmrmstruang o on n.koderuang=o.kode
			left join fokmrmstkelas p on o.kelas=p.kode
			left join fomstpasien z on z.norm=x.norm
			left join hrdmstkaryawan hk on hk.kode=d.kodetindakan
			left join bohtmstvendor mv on mv.kode=d.kodetindakan
			left join boptmstcustomer e on e.kode=x.perusahaanpenanggung
			where (isnull(x.nobill) or x.flagbill<>'4') and d.type=1 and
				h.tgl>='".$tgl_start."' and h.tgl<='".$tgl_end."'
				and h.flagpostmedis='1'
				and mv.kode='".$kode_dokter."'
		";

		if($penanggung == 'bpjs'){
			$q_where = "				 
				and e.kode = 'CO031'
				and (d.pelaksanaket='BPJS PERIKSA DOKTER SPESIALIS' or d.pelaksanaket='BPJS PERIKSA DOKTER SPESIALISS')
				order by e.kode, h.tgl, h.nobill, h.noreff #d.kodetindakan";
		}else if($penanggung == 'nonbpjs'){
			$q_where = "
				and (e.kode <>'CO031' or isnull(e.kode) )
				order by e.kode, h.tgl, h.nobill, h.noreff #d.kodetindakan";
		}
		$q = $q_select_join.$q_where;

		
		if($print_query){ // TRUE = download excel
			return $this->db->query($q);			
		}else{ // show data 			
			return $this->db->query($q)->result_array();
		}
			
	}

	//=======================[  /bo/menu/akuntansi/laporan-pendapatan-dokter ]========================

	//=======================[   bo/menu/akuntansi/voucher-hutang ]========================
	public function select_laporan_pendapatan_dokter_bhp($tgl_start=null, $tgl_end=null, $kode_dokter=null, $penanggung=null, $download=null){

		$q_select_join = "
			SELECT ptd.Date, ptd.NoReff,
				td.NoBill, td.NoRm, mp.Nama,
				pt.Lokasi, ml.Keterangan as Lokasiket,
				kmr.keterangan as Ruang,
				pt.Keterangan,
				ptd.KodeTindakan, mt.keterangan as kettindakan,
				ptd.TotalTarif,
				ptd.pelaksana, ptd.pelaksanaket, 
				td.PerusahaanPenanggung, pmc.nama as Penanggung
			FROM fotrpostindakan pt
			LEFT JOIN fotrpostindakandet ptd ON ptd.NoReff = pt.NoReff 
			LEFT JOIN fotrdaftar td ON td.nobill=pt.nobill
			LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
			LEFT JOIN boptmstcustomer pmc ON pmc.kode=td.PerusahaanPenanggung
			LEFT JOIN fomsttindakan mt ON mt.kode=ptd.KodeTindakan
			LEFT JOIN fomstlokasi ml ON ml.Kode=pt.Lokasi
			LEFT JOIN fokmrmstruang kmr ON kmr.Kode=ptd.Ruang
			WHERE ptd.Date>='".$tgl_start."' and ptd.Date<='".$tgl_end."' 
				and pt.Lokasi='55'
				and ptd.pelaksana='".$kode_dokter."'
				and (isnull(td.nobill) or td.flagbill<>'4')
		";

		if($penanggung == 'bpjs'){
			$q_where = "		
				and td.PerusahaanPenanggung='CO031'";
		}else if($penanggung == 'nonbpjs'){
			$q_where = "
				and td.PerusahaanPenanggung<>'CO031'";
		}

		$q = $q_select_join.$q_where;

		if($download){ // TRUE = download excel
			return $this->db->query($q);
		}else{ // show data
			return $this->db->query($q)->result_array();
		}
			
	}
	//=======================[  /bo/menu/akuntansi/voucher-hutang ]========================




	//=======================[   monitoring-error ]========================
	public function dl_xls_sukubangsa_kosong($tgl_start=null, $tgl_end=null){
		$q = "
			SELECT 
				td.StatusDaftar, td.NoBill, td.NoRM, td.Nama,
				td.FlagBill, td.TanggalMasuk, td.TanggalKeluar,
				td.User, td.Date, td.Time
			FROM fotrdaftar td
			LEFT JOIN fomstpasien mp on mp.NoRM = td.NoRM
			where td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND Sukubangsa=''
		";

		return $this->db->query($q)->result_array();			
	}

	public function select_agama_kosong($tgl_start=null, $tgl_end=null){
		$q = "
			SELECT 
				td.StatusDaftar, td.NoBill, td.NoRM, td.Nama, mp.Agama,
				td.FlagBill, td.TanggalMasuk, td.TanggalKeluar,
				td.User, td.Date, td.Time
			FROM fotrdaftar td
			LEFT JOIN fomstpasien mp on mp.NoRM = td.NoRM
			where td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND mp.Agama=''
		";

		return $this->db->query($q)->result_array();			
	}
	//=======================[  /monitoring-error ]========================








	public function _bo($method=null, $data=null){
		if(!empty($method)){
			switch ($method) {
				case 'value':
					# code...
					break;
				
				default:
					# code...
					break;
			}
		}
			

	}

}

/*NOTE
 --- SQL Query Execute ---
// INSERT : insert into mutumstirs (IRS) VALUES ('CVC')


insert into hrd_abs_log ( `id`, `fddate`) 
VALUES ('92586', '2019-10-24 07:59:55') 

NOTE */