<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dokter extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	// ini hanya dipakai di jadok
	public function get_dokter(){
		$q = "SELECT
				a.Kode,
				a.TypeX,
				a.Nama,
				a.Lokasi,
				b.Keterangan 
			from bohtmstvendor a 
			left join fomstlokasi b on a.Lokasi = b.Kode
			-- where  a.TypeX = 'SP' && a.Lokasi >=20 && a.Lokasi <=38 
			where  a.TypeX = 'SP' AND ( 
					(a.Lokasi >=20 AND a.Lokasi <=38) 
					OR a.Lokasi = 11 OR a.Lokasi = 6 OR a.Lokasi = 41
				) -- LAMA
			order by a.Nama";
		//$this->db->select('(SELECT SUM(payments.amount) FROM payments WHERE payments.invoice_id=4) AS amount_paid', FALSE);
		$this->db->select($q, FALSE);
		$query = $this->db->get();

		return $query->result();
	}

	
	// rm/asesmen-rehab-medis
	// arahkan pakai ini
	public function dokter_daftar(){
		$q = "SELECT 
				a.Kode,
				a.TypeX,
				a.Nama,
				a.Lokasi,
				b.Keterangan,
				b.kdpoli_bpjs
			from bohtmstvendor a 
			left join fomstlokasi b on a.Lokasi = b.Kode
			where  a.TypeX = 'SP' AND ( 
					(a.Lokasi >=20 AND a.Lokasi <=38) 
					OR a.Lokasi = 11 OR a.Lokasi = 6 OR a.Lokasi = 41
				)
			order by a.Nama";
		return $this->db->query($q)->result_array();
	}
	
	
	// https://192.168.1.68/rscm/app_dev/main/db/m_dokter/dokter_by_lokasi/11
	public function dokter_by_lokasi($lokasi=null){
		$q = "SELECT 
				a.Kode,
				a.TypeX,
				a.Nama,
				a.Lokasi,
				b.Keterangan,
				b.kdpoli_bpjs
			from bohtmstvendor a 
			left join fomstlokasi b on a.Lokasi = b.Kode
			where  a.TypeX = 'SP' AND ( 
					(a.Lokasi >=20 AND a.Lokasi <=38) 
					OR a.Lokasi = 11 OR a.Lokasi = 6 OR a.Lokasi = 41
				)
				AND a.Lokasi=?
			order by a.Nama";
		return $this->db->query($q, [$lokasi])->result_array();
	}
	
	
	// public function insert_jadwal_dokter(){
	// 	$q = "INSERT";
	// 	return $this->db->query($q)->result_array();
	// }




}
