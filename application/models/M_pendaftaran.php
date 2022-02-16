<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendaftaran extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	

	public function list_prb($date_start=null, $date_end=null){
		$q = "SELECT td.NoBill, td.NoRM, mp.Barcode, mp.Nama, mp.PRB, td.FlagBill
			FROM fotrdaftar td 
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM
			WHERE td.date>='".$date_start."' AND td.date<='".$date_end."'
			AND mp.PRB = 1 ";

		$query = $this->db->query($q)->result_array();
		return $query;
	}

	// JUST CHECK
	public function list_pdp_trdaftar($date_start=null, $date_end=null, $order=null){
		$q = "SELECT td.NoRM, td.Nama, td.NoBill, 
				td.TanggalMasuk, td.date, td.PerusahaanPenanggung,
				td.StatusDaftar
			FROM fotrdaftar td
			WHERE td.PerusahaanPenanggung ='CO051'
			AND td.date>='".$date_start."' AND td.date<='".$date_end."'
			ORDER BY '".$order."'
			";
			//NoRM // if order by NoRM, willbe know more than 1 visite pdp

		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	public function list_pdp($date_start=null, $date_end=null){
		$q = "SELECT mp.NoRM, mp.Nama, mp.PDP, mp.PDPDate
			FROM fomstpasien mp
			WHERE mp.PDP ='1'
			AND mp.PDPDate>='".$date_start."' AND mp.PDPDate<='".$date_end."'
			ORDER BY mp.PDPDate
			";
			
		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	
	// JUST CHECK
	public function get_norm_pdp_by_daftar($norm=null){
		$q = "SELECT td.NoRM, td.Nama, td.NoBill, 
				td.TanggalMasuk, td.date, td.PerusahaanPenanggung,
				td.StatusDaftar
			FROM fotrdaftar td
			WHERE td.PerusahaanPenanggung ='CO051'
			AND td.NoRM='".$norm."'
			ORDER BY date";

		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	// 017293,
	// 001316 // 06-21
	// 0001205199235
	// public function get_norm_pdp($norm=null){
	// 	$q = "SELECT mp.NoRM, mp.Nama, mp.PDP, mp.PDPDate,
	// 			DATEDIFF(CURDATE(), mp.PDPDate) AS PDPSelisihHari
	// 		FROM fomstpasien mp
	// 		WHERE mp.NoRM='".$norm."'
	// 		AND mp.PDP ='1'";
	// 	// -- DATEDIFF(day, '2020/06/22', mp.PDPDate) AS DateDiff

	// 	$query = $this->db->query($q)->result_array();
	// 	return $query;
	// }


	/* == master-pasien == */
	
	public function getNormMstPasien($txtnorm = null){
		$q = "SELECT
			NoRM,Nama,Alamat,TglLahir,NoIdentitas,if(Anggota='U','Umum','Member') as Type
			from fomstpasien where
			(norm like '%" .$txtnorm. "%' or
			nama like '%" .$txtnorm. "%' or
			alamat like '%" .$txtnorm. "%' or
			tgllahir like '%" .$txtnorm. "%') order by norm";
		return $this->db->query($q)->result_array();
	}
	
	public function tempatLahir($txtTempatLahir = null){
		$q = "SELECT Kode,Keterangan from fowilmstkota where
			(kode like '%".$txtTempatLahir."%' or
			keterangan like '%" .$txtTempatLahir."%') order by kode";
		return $this->db->query($q)->result_array();
	}
	
	public function anggotaPers($txtAnggotaPers = null){
		$q = "SELECT Kode,NPP,Nama,Alamat,
				if(Type='1','Company',if(Type='2','Card','Personal')) as Type 
			FROM boptmstcustomer 
			WHERE type<>'2' and (kode like '%" .$txtAnggotaPers."%' or
			NPP like '%" .$txtAnggotaPers."%' or
			Nama like '%" .$txtAnggotaPers."%')
			order by kode";
		return $this->db->query($q)->result_array();
	}
	
	public function negara($txtNegara=null){
		$q = "SELECT Kode,Keterangan from fowilmstnegara where
    (kode like '%" .$txtNegara. "%' or
    keterangan like '%" .$txtNegara. "%') order by kode";
		return $this->db->query($q)->result_array();
	}
	
	public function propinsi($txtPropinsi=null){
		$q = "SELECT Kode,Keterangan from fowilmstpropinsi where
    (kode like '%" .$txtPropinsi. "%' or
    keterangan like '%" .$txtPropinsi. "%') order by kode";
		return $this->db->query($q)->result_array();
	}
	
	public function kota($txtKota=null){
		$q = "SELECT Kode,Keterangan from fowilmstkota where
    (kode like '%" .$txtKota. "%' or
    keterangan like '%" .$txtKota. "%') order by kode";
		
		// txtKecamatan.SQL = "select Kode,Keterangan from fowilmstkecamatan where " & _
		// 	"(kode like '%" & txtKecamatan.Text & "%' or " & _
		// 	"keterangan like '%" & txtKecamatan.Text & "%') and kodekota='" & txtKota.Text & "' order by kode"
		
		// txtKelurahan.SQL = "select Kode,Keterangan from fowilmstkelurahan where " & _
		// 	"(kode like '%" & txtKelurahan.Text & "%' or " & _
		// 	"keterangan like '%" & txtKelurahan.Text & "%') and kodekota='" & txtKota.Text & "' and kodekecamatan='" & txtKecamatan.Text & "' order by kode"
		
		
		return $this->db->query($q)->result_array();
	}
	
	public function kecamatan($txtKota=null, $txtKecamatan=null){
		$q = "SELECT Kode,Keterangan from fowilmstkecamatan where
			(kode like '%" .$txtKecamatan. "%' or
			keterangan like '%" .$txtKecamatan. "%') 
			and kodekota='" .$txtKota. "' 
			order by kode";
		return $this->db->query($q)->result_array();
	}
	
	public function kelurahan($txtKota=null, $txtKecamatan=null, $txtKelurahan=null){
		$q = "SELECT Kode,Keterangan FROM fowilmstkelurahan 
			WHERE
			(kode like '%" .$txtKelurahan. "%' or	keterangan like '%" .$txtKelurahan. "%') 
			and kodekota='" .$txtKota. "' 
			and kodekecamatan='" .$txtKecamatan. "' 
			order by kode";
		return $this->db->query($q)->result_array();
	}
	
	public function pendidikan(){
		$q = "SELECT Kode,Keterangan from fomstpendidikan";
		return $this->db->query($q)->result_array();
	}
	
	public function pekerjaan(){
		$q = "SELECT Kode,Keterangan from fomstpekerjaan";
		return $this->db->query($q)->result_array();
	}
	
	public function agama(){
		$q = "SELECT Kode,Keterangan from fomstagama";
		return $this->db->query($q)->result_array();
	}

	
	/* == \master-pasien == */


	/* ==  PENDAFTARAN PASIEN BARU 2022 == */
	public function multilokasi_by_kodebpjs($kodeBpjs, $kodeDokter){
		$q = "SELECT ml.* FROM fomstlokasi WHERE kdpoli_bpjs='.$kodeBpjs.'";
		return $this->db->query($q)->result_array();
	}
	
	public function dokter_bpjs(){
		// return ['ok']; exit;
		$q = "SELECT 
			mv.kd_dpjp_bpjs 
			,mv.Kode AS kodeDokterRs 
			,mv.Nama AS namaDokterRs 
			,mv.Lokasi AS kodeLokasiRs 
			,ml.Keterangan AS labelLokasiRs 
			,mv.flag AS flagDokter
			,ml.kdpoli_bpjs				
		FROM bohtmstvendor mv 
		LEFT JOIN fomstlokasi ml ON ml.Kode=mv.Lokasi
		WHERE mv.kd_dpjp_bpjs <> ''";
		$val = $this->db->query($q)->result_array();
		return $val;
	}
	
	public function dokter_by_kodebpjs($kodeDokterBpjs){
		// return ['ok']; exit;
		$q = "SELECT mv.kd_dpjp_bpjs 
				,mv.Kode AS kodeDokterRs 
				,mv.Type 
				,mv.TypeKet 
				,mv.TypeX 
				,mv.TypeXKet 
				,mv.Nama AS namaDokterRs 
				,mv.Lokasi AS kodeLokasiRs 
				,ml.Keterangan AS labelLokasiRs 
				,mv.flag AS flagDokter
				,ml.* 
			FROM bohtmstvendor mv 
			LEFT JOIN fomstlokasi ml ON ml.Kode=mv.Lokasi
			WHERE mv.kd_dpjp_bpjs=?";
		$val = $this->db->query($q,[$kodeDokterBpjs])->result_array();

		if(count($val)<1){
			// exit(json_encode( metaData(201, 'Kode dokter tidak sesuai(Bpjs/RS).', "failed") ));
			$q2 = "SELECT mk.kd_dpjp_bpjs 
					,mk.Kode AS kodeDokterRs 
					,'' AS Type 
					,'' AS TypeKet 
					,'' AS TypeX 
					,'' AS TypeXKet 
					,mk.nama AS namaDokterRs 
					,ml.Kode AS kodeLokasiRs 
					,ml.Keterangan AS labelLokasiRs 
					,'' AS flagDokter
					,ml.* 
				FROM hrdmstkaryawan mk
				LEFT JOIN fomstlokasi ml ON ml.Kode='10'
				WHERE mk.kd_dpjp_bpjs=?";
			$dokter_intern = $this->db->query($q2,[$kodeDokterBpjs])->result_array();
			if(count($dokter_intern)<1)
				exit(json_encode( metaData(201, 'Kode dokter tidak sesuai(Bpjs/RS).', "failed") ));
			else $val = $dokter_intern[0];

		}else $val = $val[0];

		return $val;
	}

	/* == \PENDAFTARAN PASIEN BARU 2022 == */

}