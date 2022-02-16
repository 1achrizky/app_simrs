<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_itsupport extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_tindakan_hapus_fotrpayment($NoNota){
		$q = "SELECT tp.TglTrans, tp.NoBill, tp.NoNota, tp.BillingKeterangan, td.FlagBill, tp.flagpostcl
			FROM fotrpayment tp 
			LEFT JOIN fotrdaftar td ON td.NoBill = tp.NoBill
			WHERE tp.NoNota = '".$NoNota."'";
		
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'   => 'get_tindakan_hapus_fotrpayment',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function get_tindakan_hapus_postindakan($NoNota){
		$q = "SELECT 
				pt.NoReff, pt.Tgl, pt.NoBill, mp.Nama, 
				pt.flagpostTindakan, pt.flagpostMedis,
				td.PerusahaanPenanggung, td.NoAnggota
			from fotrpostindakan pt
			LEFT JOIN fotrdaftar td ON td.NoBill = pt.NoBill
			LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM
			where pt.NoReff = '".$NoNota."'";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'   => 'get_tindakan_hapus_postindakan',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function get_tindakan_hapus_postindakandet($NoNota){
		$q = "select NoReff, No, KodeTindakan, TotalTarif from fotrpostindakandet where NoReff = '".$NoNota."'";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'   => 'get_tindakan_hapus_postindakandet',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}


	public function delete_tindakan($NoNota){
	    $this->db->where('NoNota', $NoNota);
	    $this->db->delete('fotrpayment'); // Untuk mengeksekusi perintah delete di nama table

	    $this->db->where('NoReff', $NoNota);
	    $this->db->delete('fotrpostindakan');

	    $this->db->where('NoReff', $NoNota);
	    $this->db->delete('fotrpostindakandet');
	}







	public function get_kamar_hapus($bill){
		$q = "select TglTrans,NoBill,NoNota,BillingKeterangan from fotrpayment where NoNota = '".$bill."'";
		//$q = "select TglTrans,NoBill,NoNota,BillingKeterangan from fotrpayment where NoNota = 'BL180719.0003'";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'   => 'get_kamar_hapus',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function gd_penanggung_fotrdaftar($bill){
		$q = "select NoBill,NoRM, Nama, Anggota, PerusahaanPenanggung, NoAnggota from fotrdaftar where NoBill = '".$bill."'";
		$query = $this->db->query($q);
		return $query->result();
	}

	public function gd_penanggung_fotrbillingshare($bill){
		$q = "select nobill, billname, billpenanggung from fotrbillingshare where nobill = '".$bill."'";
		$query = $this->db->query($q);
		return $query->result();
	}

	public function gd_penanggung_fotrpayment($bill){
		$q = "SELECT NoBill, NoNota, CLPenanggung, BillingKeterangan, flagpostcl, flagpostgratis
			from fotrpayment 
			where NoBill = '".$bill."' AND BillingKeterangan = '' ";
		$query = $this->db->query($q);
		return $query->result();
	}

	public function update_penanggung($param){
		$data = array(
		        'Anggota' 				=> $param['anggota'],
		        'PerusahaanPenanggung'  => $param['penanggung_kode'],
		        'NoAnggota' 			=> $param['penanggung_nama']
			);
		$this->db->where('NoBill', $param['bill']);
		$this->db->update('fotrdaftar', $data);



		$data = array(
		        'billpenanggung' => $param['penanggung_kode']
			);
		$this->db->where('nobill', $param['bill']);
		$this->db->update('fotrbillingshare', $data);



		$where = array(
		        'NoBill' => $param['bill'],
		        'BillingKeterangan' => ''
			);

		$data = array(
		        'CLPenanggung' => $param['penanggung_kode']
			);
		$this->db->where($where);
		$this->db->update('fotrpayment', $data);

	}

	public function gd_transfer_obat($data=null){
		$select = array(
				"a.NoNota", "a.NoBill", "a.CLPenanggung", "b.Nama", "b.Alamat", "b.flag"
			);

		$where = "a.NoNota ='".$data['NoNota']."'";
		$query = $this->db->select($select)
		->from("fotrpayment a")
		->join("boivsales b", "b.nobukti = a.NoNota", "left")
		->where($where)
		->get();

		// $query = $this->db->get();
		return $query->result();
	}

	public function update_buka_apsl($data=null){
		$where = "nobukti ='".$data['nobukti']."'";
		$data = array(
		        'flag' => 'A'
			);
		$this->db->where($where);
		$this->db->update('boivsales', $data);
	}

	public function gd_bill_daftar_for_tf($data=null){
		$select = array(
				"NoBill", "Nama", "Alamat", "PerusahaanPenanggung"
			);

		$where = "NoBill ='".$data['NoBill']."'";
		$query = $this->db->select($select)
		->from("fotrdaftar")
		->where($where)
		->get();

		// $query = $this->db->get();
		return $query->result();
	}

	public function update_transfer_apsl($data=null){
		$where = "nobukti ='".$data['nobukti']."'";
		$data = array(
		        'NoBilling' => $data['NoBilling'],
		        'Nama' 		=> $data['Nama'],
		        'Alamat' 	=> $data['Alamat']
			);
		$this->db->where($where);
		$this->db->update('boivsales', $data);



		$where = "NoNota ='".$data['nobukti']."'";
		$data = array(
		        'NoBill' => $data['NoBilling']
			);
		$this->db->where($where);
		$this->db->update('fotrpayment', $data);
	}





	public function cek_pegawai_tidak_absen($noreg,$tgl){
		$q = "SELECT h.id, h.fddate, mk.nama
			from hrd_abs_log h
			left join hrdmstkaryawan mk ON mk.kode = h.id
			where h.id = '".$noreg."' AND h.fddate LIKE '".$tgl."%' ";
			
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'   => 'cek_pegawai_tidak_absen',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}

	public function get_ganti_jadwal($data=null){
		$select = array(
				"a.NPP", "a.Nama", "a.DepartemenSub", "a.`".$data['tgl_int']."`", 
				"b.TANGGAL", "b.NAMA", "b.DINAS" 
			);

		$query = $this->db->select($select)
			->from($data['hrds']." a") //hrds191 a
			->join("hrdabsensi b", "b.NIP = a.NPP && b.date='".$data['date']."'", "left")
			->where("a.NPP = ".$data['noreg'])
			->get();

		return $query->result();
	}


	public function n_px_by_alamat($data){
		$q = "select NoBill, NoRM, Nama, Alamat, Agama, 
				UmurTahun as Umur, KategoriUsia, Sex, b.Keterangan as Pendidikan
			from fotrdaftar a
			inner join fomstpendidikan b on b.Kode = a.Pendidikan
			where a.Alamat like '%".$data['alamat']."%' 
				&& (a.Date >='".$data['tgl_start']."' 
				&& a.Date <='".$data['tgl_end']."') 
			ORDER BY NoBill DESC";
		$query = $this->db->query($q);

		$rowCount = $query->num_rows();
		$status = ($rowCount > 0)? "SUKSES": "GAGAL";
		$message = ($rowCount > 0)? "Data berhasil diload.": "Data tidak berhasil diakses.";

		$js_full = array(
				'nama'   => 'n_px_by_alamat',
				'status' => $status,
				'count'	 => $rowCount,
				'dtjs'	 => $query->result(),
				'message'=> $message
			);

		return $js_full;
	}



	/* [== bo/menu/it/support/dokter/jadwal-dokter ==] */
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
			-- where  a.TypeX = 'SP' AND ((a.Lokasi >=20 AND a.Lokasi <=37) OR a.Lokasi=11)
			where  a.TypeX = 'SP' AND ( 
					(a.Lokasi >=20 AND a.Lokasi <=38) OR a.Lokasi = 11 OR a.Lokasi = 6
				)
			order by a.Nama";
		$query = $this->db->query($q);
		return $query->result();
	}
	
	public function jadok_tampil(){
		$q = "SELECT 
				a.Id,
				a.hari,
				a.hariId,
				b.Keterangan as Spesialis,
				c.Nama,
				a.jamMasuk,
				a.jamPulang 
			FROM cm_dokterjadwal a 
			LEFT JOIN fomstlokasi b on c.Lokasi = b.Kode
			LEFT JOIN bohtmstvendor c on c.Lokasi = b.Kode
			WHERE a.kodeDokter = c.Kode
			ORDER BY a.hariId, b.Keterangan";
		$query = $this->db->query($q);
		return $query->result();
	}
	
	
	public function jadok_input(){
		$q = "INSERT INTO cm_dokterjadwal ("
		."`Id`,`kodeDokter`,"
		."`hari`,`hariId`,"
		."`jamMasuk`,`jamPulang`,"
		."`user`,`date`)"
	 ." VALUES ("
		 ."'','$_POST[kodeDokter]',"
		 ."'".mysql_real_escape_string($_POST['hari'])."','$_POST[hariId]',"
		 ."'$_POST[jamMasuk]','$_POST[jamPulang]',"
		 ."'$_POST[user]','$_POST[date]'"
	 .")";
		$query = $this->db->query($q);
		return $query->result();
	}
	
	
	public function hapus_jadok($id){
		$q = "INSERT INTO cm_dokterjadwal ("
		."`Id`,`kodeDokter`,"
		."`hari`,`hariId`,"
		."`jamMasuk`,`jamPulang`,"
		."`user`,`date`)"
	 ." VALUES ("
		 ."'','$_POST[kodeDokter]',"
		 ."'".mysql_real_escape_string($_POST['hari'])."','$_POST[hariId]',"
		 ."'$_POST[jamMasuk]','$_POST[jamPulang]',"
		 ."'$_POST[user]','$_POST[date]'"
	 .")";
		$query = $this->db->query($q);
		return $query->result();
	}
	/* [== \bo/menu/it/support/dokter/jadwal-dokter ==] */





}
