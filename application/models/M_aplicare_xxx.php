<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Daftarmandiri extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	public function gd_pasien_rscm($param){
		$q = "select
				a.NoRM,
				a.Barcode,
				a.Nama,
				a.Alamat,
				a.Sex
			from fomstpasien a
			where  a.Barcode = ".$param;

		$query = $this->db->query($q);
		//$js_array = array();
		//$js_full = array();

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

	public function get_norm_by_noka($noka){
		$q = "select NoRM from fomstpasien where Barcode = '".$noka."'";
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



	public function get_klinik(){
		$q = "select Kode,Keterangan from fomstlokasi where Kode>=20 AND Kode<=36";
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
		$q = "select 
				a.Id,
				a.hari,
				a.hariId,
				b.Keterangan as Spesialis,
				c.Nama,
				a.jamMasuk,
				a.jamPulang 
			from cm_dokterjadwal a 
			left join fomstlokasi b on c.Lokasi = b.Kode
			left join bohtmstvendor c on c.Lokasi = b.Kode
			where  a.kodeDokter=c.Kode
			order by a.hariId,b.Keterangan,a.jamMasuk";

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

	public function get_jadok_today($params){
		if($params['fl_klinik'] == 0){
			$q = "select 
				a.Id,
				a.hari,
				a.hariId,
				b.Keterangan as Spesialis,
				c.Nama,
				a.jamMasuk,
				a.jamPulang 
			from cm_dokterjadwal a 
			left join fomstlokasi b on c.Lokasi = b.Kode
			left join bohtmstvendor c on c.Lokasi = b.Kode
			where  a.kodeDokter=c.Kode && a.hariId=".date('w')."
			order by c.Nama";
		}else{
			$q = "select 
				a.Id,
				a.hari,
				a.hariId,
				b.Keterangan as Spesialis,
				c.Nama,
				a.jamMasuk,
				a.jamPulang 
			from cm_dokterjadwal a 
			left join fomstlokasi b on c.Lokasi = b.Kode
			left join bohtmstvendor c on c.Lokasi = b.Kode
			where  a.kodeDokter=c.Kode 
					&& a.hariId=".date('w')."
					&& b.Keterangan ='".$params['spesialis'] ."'
			order by c.Nama";
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
		left join fomstlokasi b on c.Lokasi = b.Kode
		left join bohtmstvendor c on c.Lokasi = b.Kode
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












	public function gd_pasien_rscm_by_norm($norm){
		$q = "select * from fomstpasien where NoRM='".$norm."'";

		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "EMPTY";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak ditemukan.";

		$js_full = array(
				'status'	=> $status,
				'count'		=> $rowCount,
				'datajs'	=> $query->result(),
				'message'	=> $message
			);

		return $js_full;
		//echo json_encode($js_full); //belakangnya ada NULL. JGN PAKAI INI
		
	}







	public function gd_rujukan_rscm($noRujukan){
		$q = "select
				a.rujukan,
				a.norm,
				a.exp_bulan
			from xrujukan a
			where a.rujukan = '".$noRujukan."'";

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




}
