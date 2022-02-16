<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_casemix extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }

  //=======================[  bo/menu/casemix/pantauan_biaya_ri ]========================
  
	public function get_payment_by_billing($nobill=null){
		$debet = "if(0>
      (if(tp.tab<=7,tp.Billing, 
          if(tp.tab=8,tp.cash, 
            if(tp.tab=9,tp.debit, 
              if(tp.tab=10,tp.cash, 
                if(tp.tab=11,tp.cash, 
                  if(tp.tab=12,tp.debit, 
                    if(tp.tab=13,tp.kreditcard, 
                      if(tp.tab=14,tp.cl, 
                        if(
                          tp.tab=15,tp.gratis,if(tp.tab=16,tp.cash,'')
                        ))))))))
        )
      ),abs(
        (if(tp.tab<=7,tp.Billing, 
            if(tp.tab=8,tp.cash, 
              if(tp.tab=9,tp.debit, 
                if(tp.tab=10,tp.cash, 
                  if(tp.tab=11,tp.cash, 
                    if(tp.tab=12,tp.debit, 
                      if(tp.tab=13,tp.kreditcard, 
                        if(tp.tab=14,tp.cl, 
                          if(tp.tab=15,tp.gratis,
                              if(tp.tab=16,tp.cash,'')
                          )))))))))
        )
      ),0) as debet";


		$Ket = "if(tp.tab=1,'Biaya Kartu', 
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
																	)))))))))))
						)
					)
		        )
		      ) as Ket";	
		$select = array(
				'tp.TglTrans', 'tp.NoBill', 'a.NoRM', 'a.Nama', 'a.TanggalMasuk', 
				// 'tp.NoNota', 'tp.Keterangan', 'tp.Lokasi', 
				'tp.NoNota', $debet, 
				'tp.Lokasi', 
				$Ket, 'tp.tab', 
				'if(tp.tab=11, tp.cash, 
					if(tp.tab=14, tp.cl, 
						if(tp.tab=16, tp.cash, tp.Billing))) as Billing'
			);
		$this->db->select($select);
		$this->db->from('fotrpayment tp');
		$this->db->join('fotrdaftar a', 'a.NoBill = tp.NoBill', 'left');
		$this->db->join('fomstlokasi ml', 'ml.Kode = tp.Lokasi', 'left');
		$this->db->join('boptmstcustomer cs', 'cs.kode=tp.clpenanggung', 'left');//boptmstcustomer cs on cs.kode=tp.clpenanggung
		$where = "(tp.billing!=0 or tp.tab>=8) and tp.NoBill='".$nobill."'";
		// $where = "(tp.billing!=0 or tp.tab<8) and tp.NoBill='".$data['NoBill']."'"; // TANPA tab>8
		$this->db->where($where);
		// $this->db->order_by('tp.NoNota ASC');
		$this->db->order_by('tp.tab, tp.TglTrans, tp.nonota');

		$res = $this->db->get()->result_array();
		return $res;
  }
  

  public function select_px_by_bill($nobill=null){
		$select = array(
				'c.NoBill as nobill', 'b.Nama', 'b.NoRM', 'b.Barcode', 'b.Alamat', 
				'c.StatusDaftar',
				'c.nosep', 'c.TanggalMasuk', 'c.TanggalKeluar', 
				'b.TglLahir', 'b.Sex',
				'IF(b.Sex="L",1,2) AS gender_eclaim',
				'c.UmurTahun', 'c.UmurBulan', 'c.UmurHari',
				'c.PerusahaanPenanggung as kodePenanggung',
				'c.NoAnggota as namaPenanggung'
			);
		$this->db->select($select);
		$this->db->from('fotrdaftar c');
		$this->db->join('fomstpasien b','b.NoRM=c.norm','left');

		$where = "c.NoBill='".$nobill."'";
    $this->db->where($where);
    
    $res = $this->db->get()->result_array();
    if(count($res)>0){
      $res = $res[0];

      // cari trdaftarrj, ri, atau ug
      if($res['StatusDaftar'] == 'RJ'){
        $segment = 'rj';
        $this->db->select([ 'v.Nama AS namaDokter', 's.*']);
        $this->db->from('fotrdaftar'.$segment.' s');
        $this->db->join('bohtmstvendor v','v.Kode=s.Dokter','left');
  
        $where = "s.NoBill='".$nobill."'";
        $this->db->where($where);

        $res_segment = $this->db->get()->result_array();
        if(count($res_segment)>0){
          $res['segment_det'] =  $res_segment[0];
        }else{
          $res['segment_det'] = null;
        }
        
      }


      return $res;
    }else{ return false; }

  }


  public function bioPasienByBill($nobill=null){
    // $q = "SELECT
    //     td.NoBill, td.nosep, td.NoRM, td.noskdp, td.Sex,
    //     td.StatusDaftar,
    //     td.TanggalMasuk, td.TanggalKeluar, td.JamMasuk, td.JamKeluar,
    //     td.UmurTahun, td.UmurBulan, td.UmurHari,
    //     td.Pendidikan, td.Pekerjaan,
    //     mp.Nama, mp.TglLahir, mp.Sex,
    //     rd.Anamnesa, rd.fisik,
    //     rd.TriageKode, rd.kodekasus,
    //     IF( td.StatusDaftar='RJ', drj.Lokasi, du.lokasi) AS LokasiKode,
    //     IF( td.StatusDaftar='RJ', drj.Dokter, du.dokterrs) AS DokterKode,
    //     IF( td.StatusDaftar='RJ', drj.typedokter, du.TypeDokterJaga) AS DokterType
    //   FROM fotrdaftar td
    //   LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
    //   LEFT JOIN formdiagnosa rd ON rd.BillNo=td.NoBill
    //   LEFT JOIN fotrdaftarugd du ON du.Nobill=td.NoBill 
    //     AND !(du.lokasi='50' OR du.lokasi='51') AND !(du.dokterrs='' OR du.dokterrs=92446) 
    //   LEFT JOIN fotrdaftarrj drj ON drj.Nobill=td.NoBill 
    //     AND !(drj.Lokasi='50' OR drj.Lokasi='51') AND !(drj.Dokter='' OR drj.Dokter=92446) 
    //   WHERE td.NoBill='".$nobill."'";
    // return $this->db->query($q)->row_array();


    $select = array(
      'td.NoBill AS nobill', 'td.nosep', 'td.NoRM', 'td.noskdp', 'td.Sex', 'mp.Barcode', 'mp.Alamat', 
      'td.StatusDaftar',
      'td.TanggalMasuk', 'td.TanggalKeluar', 'td.JamMasuk', 'td.JamKeluar',
      'td.UmurTahun', 'td.UmurBulan', 'td.UmurHari',
      'td.Pendidikan', 'td.Pekerjaan',
      'mp.Nama', 'mp.TglLahir', 'mp.Sex',
      'rd.Anamnesa', 'rd.fisik',
      'rd.TriageKode', 'rd.kodekasus',
      'rd.ICDKode', 'rd.ICDKode2', 'rd.ICDKode3', 'rd.ICDKode4', 'rd.ICDKode5',
      'rd.kodetindakan', 'rd.kodetindakan2', 'rd.kodetindakan3', 'rd.kodetindakan4',
      'IF( td.StatusDaftar="RJ", drj.Lokasi, du.lokasi) AS LokasiKode',
      'IF( td.StatusDaftar="RJ", drj.Dokter, du.dokterrs) AS DokterKode',
      'IF( td.StatusDaftar="RJ", drj.typedokter, du.TypeDokterJaga) AS DokterType',
      'IF(mp.Sex="L",1,2) AS gender_eclaim',
      'td.UmurTahun', 'td.UmurBulan', 'td.UmurHari',
      'td.PerusahaanPenanggung as kodePenanggung',
      'td.NoAnggota as namaPenanggung'
    );
    $this->db->select($select);
    $this->db->from('fotrdaftar td');
    $this->db->join('fomstpasien mp','mp.NoRM=td.NoRM','left');
    $this->db->join('formdiagnosa rd','rd.BillNo=td.NoBill','left');
    // $this->db->join('fotrdaftarugd du', "du.Nobill=td.NoBill AND !(du.lokasi='50' OR du.lokasi='51') AND !(du.dokterrs='' OR du.dokterrs=92446)", 'left');
    $this->db->join('fotrdaftarugd du', "du.Nobill=td.NoBill", 'left');
    // $this->db->join('fotrdaftarrj drj', "drj.Nobill=td.NoBill AND !(drj.Lokasi='50' OR drj.Lokasi='51') AND !(drj.Dokter='' OR drj.Dokter=92446)", 'left');
    $this->db->join('fotrdaftarrj drj', "drj.Nobill=td.NoBill", 'left');
    $this->db->where('td.NoBill', $nobill );
    $res = $this->db->get()->result_array();
    
    if(count($res)>0){
      $res = $res[0];

      // // cari trdaftarrj, ri, atau ug
      // if($res['StatusDaftar'] == 'RJ'){
      //   $segment = 'rj';
      //   $this->db->select([ 'v.Nama AS namaDokter', 's.*']);
      //   $this->db->from('fotrdaftar'.$segment.' s');
      //   $this->db->join('bohtmstvendor v','v.Kode=s.Dokter','left');
  
      //   $where = "s.NoBill='".$nobill."'";
      //   $this->db->where($where);

      //   $res_segment = $this->db->get()->result_array();
      //   if(count($res_segment)>0){
      //     $res['segment_det'] =  $res_segment[0];
      //   }else{
      //     $res['segment_det'] = null;
      //   }
        
      // }


      return $res;
    }else{ return false; }
  }


  public function count_rmdx_by_bill($nobill=null){
    $this->db->select(["BillNo"]);
    $this->db->from('formdiagnosa');
    $this->db->where('BillNo', $nobill );
    $res = $this->db->get()->result_array();
    return count($res);
  }

  

  public function select_tarif_rs_for_ina($nobill=null){ // case "cariTarif":
		$q = "SELECT 
			a.nobill,a.norm,a.nama,a.alamat,a.tanggalmasuk,a.tanggalkeluar,sum(b.billing) as total,
			(select sum(billing) from fotrpayment where lokasi='10' and nobill=a.nobill and mid(nonota,3,2)<>'sl') as igd,
			(select sum(billing) from fotrpayment where lokasi='11' and nobill=a.nobill) as fis,
			(select sum(billing) from fotrpayment where lokasi='50' and nobill=a.nobill) as lab,
			(select sum(billing) from fotrpayment where lokasi='51' and nobill=a.nobill) as rad,
			(select sum(billing) from fotrpayment where lokasi='55' and nobill=a.nobill and mid(nonota,3,2)<>'sl') as OK,
			(select sum(billing) from fotrpayment where (lokasi='46' or lokasi='53') and nobill=a.nobill) as ICU,
			(select sum(billing) from fotrpayment where mid(nonota,3,2)='sl' and nobill=a.nobill) as apt,
			(select sum(billing) from fotrpayment where nonota=a.nobill) as chargebed,
			(select sum(dd.grandtotal) from fotrpostindakandet dd 
				left join fotrpostindakan cc on cc.noreff=dd.noreff 
				left join fotrpayment aa on cc.noreff=aa.nonota
				where (dd.type=1 and dd.typem=1) and aa.lokasi<>51 and aa.lokasi<>55 and aa.lokasi<>10 and aa.lokasi<>11 and aa.nobill=a.nobill) as ml,
			a.user,a.date,time_format(a.time,'%T') as time 
			from fotrdaftar a 
			left join fotrpayment b on b.nobill=a.nobill
			Where a.nobill='$nobill' 
			group by a.nobill";
			
		// DIPERBAIKI PADA TANGGAL 2019-12-24
		$result = $this->db->query($q)->result_array();

		if(count($result)>0){ 
      // return $result[0];
      $row = $result[0];

      if($row['OK']=='') $row['OK']=0;
      if($row['ml']=='') $row['ml']=0;
      if($row['rad']=='') $row['rad']=0;
      if($row['lab']=='') $row['lab']=0;
      if($row['fis']=='') $row['fis']=0;
      if($row['chargebed']=='') $row['chargebed']=0;
      if($row['ICU']=='') $row['ICU']=0;
      if($row['apt']=='') $row['apt']=0;
      //igd ikut keperawatan
      $keperawatan = $row['total'] - ($row['fis']+$row['lab']+$row['rad']+$row['OK']+$row['ICU']+$row['apt']+$row['chargebed']+$row['ml']);
      if($keperawatan=='') $keperawatan=0;
    
      $json_arr = [
        "hasil" => "Sukses",
        "total_tarif" 		=> (int)$row['total'],
        "detail_tarif"		=> [
          "prosedur_non_bedah"=> 0,
          "prosedur_bedah"=> (int)$row['OK'],
          "konsultasi"		=> (int)$row['ml'],
          "tenaga_ahli"		=> 0,
          "keperawatan"		=> (int)$keperawatan,
          "penunjang"			=> 0,
          "radiologi"			=> (int)$row['rad'],
          "laboratorium"		=> (int)$row['lab'],
          "pelayanan_darah"	=> 0,
          "rehabilitasi"		=> (int)$row['fis'],
          "kamar"						=> (int)$row['chargebed'],
          "rawat_intensif"	=> (int)$row['ICU'],
          "obat"			=> (int)$row['apt'],
          "alkes"			=> 0,
          "bmhp"			=> 0,
          "sewa_alat"	=> 0
        ]
      ];

      // echo json_encode($json_arr, 1);
      return $json_arr;

		}else{ return false; }			
			
	}


  public function get_list_histori_diag_by_nobill($nobill=null){
		$this->db->select('*');
		$this->db->from('cx_daftarrihistoridiag');
		$where = "nobill='".$nobill."'";
		$this->db->where($where);
		$res = $this->db->get()->result_array();
		return $res;
  }
  
  public function get_pantauritarif_by_nobill($nobill=null){
		$this->db->select('*');
		$this->db->from('cx_daftarritarif');
		$where = "nobill='".$nobill."'";
		$this->db->where($where);
		$res = $this->db->get()->result_array();
		return $res;
  }
  
  
  //https://192.168.1.68/rscm/app_dev/main/db/m_casemix/lap_eklaim/2020-01-01/2020-01-31
  public function lap_eklaim($date_start=null, $date_end=null){
    $menit = 3;
		$settime = 60*$menit;
    set_time_limit($settime);
    
    $this->db->select(["td.NoBill", "td.nosep", "td.StatusDaftar", "td.NoRM", "mp.Nama", "TanggalMasuk AS tglMRS", 
      "rd.Anamnesa", "rd.fisik", "rd.Terapi", "td.PerusahaanPenanggung" ]);
    // penanggung, tanpa billing batal
    $this->db->from('fotrdaftar td');
		$this->db->join('fomstpasien mp','mp.NoRM=td.norm','left');
		$this->db->join('formdiagnosa rd','rd.BillNo=td.NoBill','left');
		$where = "td.date>='".$date_start."' AND td.date<='".$date_end."' AND td.FlagBill<>4 AND td.PerusahaanPenanggung='CO031'" ;
		$this->db->where($where);
    $res = $this->db->get()->result_array();
    

    for ($i=0; $i < count($res); $i++) { 
      // $res[$i]["detail"] = $this->m_casemix->cariObatBill($res[$i]["NoBill"]);
      // $res[$i]["terapi"] = [];

      // $res_obat = [];
      $nobill = $res[$i]["NoBill"];
      $q_obat = "SELECT 
        b.kodebrgket
      FROM boivsales a
      LEFT JOIN boivsalesdet b ON b.nobukti=a.nobukti  AND b.jenis='01'
      WHERE a.lokasi='60' AND a.NoBilling='".$nobill."'";
      $res_obat = $this->db->query($q_obat)->result_array();
      $res[$i]["detail"] = $res_obat;
      // $res[$i]["terapi"] = $q_obat;

      // $res[$i]["terapi"] = [$nobill, 'x'];
    }

		return $res;
  }
  
  
  public function lap_eklaim_det_obat($date_start=null, $date_end=null){
    // $menit = 2;
		// $settime = 60*$menit;
    // set_time_limit($settime);
    
    $this->db->select(["td.NoBill", "td.nosep", "td.StatusDaftar", "td.NoRM", "mp.Nama", "TanggalMasuk AS tglMRS", 
      "rd.Anamnesa", "rd.fisik", "rd.Terapi", "td.PerusahaanPenanggung", "od.kodebrgket" ]);
    // penanggung, tanpa billing batal
    $this->db->from('fotrdaftar td');
		$this->db->join('fomstpasien mp','mp.NoRM=td.norm','left');
		$this->db->join('formdiagnosa rd','rd.BillNo=td.NoBill','left');
		$this->db->join('boivsales o','o.NoBilling=td.NoBill','left');
		$this->db->join('boivsalesdet od','od.nobukti=b.nobukti','left');
    $where = "td.date>='".$date_start."' AND td.date<='".$date_end."' 
      AND td.FlagBill<>4 AND td.PerusahaanPenanggung='CO031'
      AND od.jenis='01' AND o.lokasi='60' " ;
		$this->db->where($where);
    $res = $this->db->get()->result_array();
    

    // for ($i=0; $i < count($res); $i++) { 
    //   // $res[$i]["detail"] = $this->m_casemix->cariObatBill($res[$i]["NoBill"]);
    //   // $res[$i]["terapi"] = [];

    //   // $res_obat = [];
    //   $nobill = $res[$i]["NoBill"];
    //   $q_obat = "SELECT        
    //     b.kodebrgket
    //   FROM boivsales a
    //   LEFT JOIN boivsalesdet b ON a.nobukti=b.nobukti  AND b.jenis='01'
    //   WHERE a.lokasi='60' AND a.NoBilling='".$nobill."'";
    //   $res_obat = $this->db->query($q_obat)->result_array();
    //   $res[$i]["detail"] = $res_obat;
    //   // $res[$i]["terapi"] = $q_obat;

    //   // $res[$i]["terapi"] = [$nobill, 'x'];
    // }

		return $res;
  }
  
  
  public function lap_eklaim_det_obatq($date_start=null, $date_end=null){
    $q = "SELECT
      td.NoBill, td.nosep, td.StatusDaftar, td.NoRM, mp.Nama, TanggalMasuk AS tglMRS, 
        rd.Anamnesa, rd.fisik, rd.Terapi, td.PerusahaanPenanggung, od.kodebrgket
      FROM fotrdaftar td
      LEFT JOIN fomstpasien mp ON mp.NoRM=td.norm
      LEFT JOIN formdiagnosa rd ON rd.BillNo=td.NoBill
      LEFT JOIN boivsales o ON o.NoBilling=td.NoBill
      LEFT JOIN boivsalesdet od ON od.nobukti=o.nobukti
      WHERE td.date>='".$date_start."' AND td.date<='".$date_end."' 
        AND td.FlagBill<>'4' AND td.PerusahaanPenanggung='CO031'
        AND od.jenis='01' AND o.lokasi='60' ";
    $res = $this->db->query($q)->result_array();
    // echo "<pre>",print_r($res),"</pre>"; exit;
		return $res;
  }
  


  //=======================[ \bo/menu/casemix/pantauan_biaya_ri ]========================

  //=======================[  bo/menu/casemix/laporan_pasien_ri ]========================
  // diperbaiki pada : 2021.03.24
	// SANGAT CEPAT
	public function select_laporan_px_ri_by_daterange($date_start=null, $date_end=null, $download=null){
		// $menit = 3;
		// $settime = 60*$menit;
		// set_time_limit($settime);
		$tarif_ina_terpilih = 'if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) as tarif_ina_terpilih';
		$status_bill = 'if(a.proses = 0, "PROSES", "FINAL") as status_bill';
		$status_tarif = 
			'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HIJAU",
				if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"KUNING",
					if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"MERAH",
						if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"HITAM","")
					)
				)
			) as status_tarif';

		$label_css = 
			'if(SUM(tp.Billing)<0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"success",
				if( SUM(tp.Billing)>=0.5*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"warning",
					if( SUM(tp.Billing)>=0.75*(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ) AND SUM(tp.Billing)<(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"danger",
						if( SUM(tp.Billing)>=(if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) ),"default","")
					)
				)
			) as label_css';

		

		// if($download){
		// 	$ftd = 'f.NoBill=a.nobill AND StatusDaftar="RI" AND (f.FlagBill="0" OR f.FlagBill="1")';
		// }else{
		// 	$ftd = 'f.NoBill=a.nobill AND StatusDaftar="RI" AND f.FlagBill="0"';
		// }

		$select = array('a.*', $tarif_ina_terpilih, 
				'b.Nama', 'c.Kodebed', 'd.KodeLantai', 'd.KodeRuang', 
				'e.keterangan as nama_ruang', 
        'SUM(tp.Billing) as tarif_rs_now', 
        'if(aa.tarif_inacbg is null, 0, aa.tarif_inacbg) - SUM(tp.Billing) as selisih_ina_rs',        
        'f.FlagBill',
				'IF(f.FlagBill=0,"OPEN", IF(f.FlagBill=1,"CLOSE","") ) AS FlagBillKet',
				$status_bill, 
				$status_tarif, $label_css
			);

		$this->db->select($select);
		$this->db->from('cx_daftarritarif a');
		$this->db->join('cx_daftarrihistoridiag aa', 'aa.nobill=a.nobill', 'left');

		$this->db->join('fotrdaftar f','f.NoBill=a.nobill', 'left');
		
		$this->db->join('fomstpasien b','b.NoRM=a.norm', 'left');
		$this->db->join('fotrdaftarri c','c.Nobill=a.nobill', 'left');
		$this->db->join('fotrpayment tp', 'tp.NoBill=a.nobill ', 'left');
		$this->db->join('fokmrsetupbed d','d.KodeBed=c.Kodebed', 'left');
		$this->db->join('fokmrmstruang e','e.Kode=d.KodeRuang', 'left');
		$where = "f.TanggalMasuk>='".$date_start."' AND f.TanggalMasuk<='".$date_end."'
		AND aa.id=a.id_histori
		AND StatusDaftar='RI' AND (f.FlagBill='0' OR f.FlagBill='1')
		AND (tp.billing<>0 OR tp.tab<8)
		";
		$this->db->where($where);
		// $this->db->group_by('tp.Billing');
		$this->db->group_by('tp.NoBill');
		$this->db->order_by('a.nobill ASC');
		$query = $this->db->get();
		
		return $query->result_array();

	}
  //=======================[ \bo/menu/casemix/laporan_pasien_ri ]========================




  public function formdiagnosa_get_pxri_det($nobill=null){

  }




  // ===[ pindahan eclaim/rscm_klaim ]===
  
  public function cari_billing_by_nosep($nosep=null){
    $q = "SELECT NoBill FROM fotrdaftar WHERE nosep='".$nosep."'";
    return $this->db->query($q)->result_array();
  }
  
    
  
  
  
  // public function insert_formdiagnosa($kode_rj_ugd=null, $nomor_billing=null){
  public function insert_formdiagnosa($nomor_billing=null, $data=null){
    $q = "SELECT BillNo FROM formdiagnosa WHERE BillNo='".$nomor_billing."'";
    $num = $this->db->query($q)->num_rows();

    if($num>0){ // echo "Billing sudah ada di RM DIAGNOSA!";
      return false;
    }else{
      $ins = $this->db->insert("formdiagnosa", $data);
      return $ins;
    }

  }

  public function historyDiagnosa($norm=null){
    $q = "SELECT
        a.BillNo,
        a.Date AS Tanggal,
        b.Keterangan AS Lokasi,
        IF(ISNULL(a.ICDKode) , '', a.ICDKode) AS ICD,
        IF(ISNULL(a.ICDKode2) , '', a.ICDKode2) AS ICD2,
        IF(ISNULL(a.ICDKode3) , '', a.ICDKode3) AS ICD3,
        IF(ISNULL(a.ICDKode4) , '', a.ICDKode4) AS ICD4,
        IF(ISNULL(a.ICDKode5) , '', a.ICDKode5) AS ICD5
      FROM formdiagnosa a
      LEFT JOIN fomstlokasi b ON a.LokasiKode=b.Kode
      WHERE RmNo=?
      ORDER BY Tanggal DESC";
    return $this->db->query($q, [$norm])->result_array();
  }
  
  public function detail_bill_tindakan($nobill=null){
    $q = "SELECT
        a.NoBill, a.NoReff, a.Tgl,
        c.Keterangan as lokasi_ket,
        b.KodeTindakan,
        IF(
          (SELECT COUNT(d.Nama) FROM bohtmstvendor d WHERE d.kode = b.KodeTindakan)>0,
          d.Nama,
          (select keterangan from fomsttindakan where kode =  b.KodeTindakan)
        ) as nama_tindakan,
        b.pelaksanaket,
        b.Jumlah,
        b.GrandTotal,
        a.User
      FROM fotrpostindakan a
      LEFT JOIN fotrpostindakandet b ON b.NoReff=a.NoReff
      LEFT JOIN fomstlokasi c ON c.Kode=a.Lokasi
      LEFT JOIN bohtmstvendor d ON d.Kode=b.KodeTindakan
      WHERE a.NoBill='".$nobill."'";
    return $this->db->query($q)->result_array();
  }
  
  public function cariTarif($nobill=null){
    $q = "SELECT a.nobill,a.norm,a.nama,a.alamat,
        a.tanggalmasuk,a.tanggalkeluar,
        sum(b.billing) as total,
        (select sum(billing) from fotrpayment where lokasi='10' and nobill=a.nobill and mid(nonota,3,2)<>'sl') as igd,
        (select sum(billing) from fotrpayment where lokasi='11' and nobill=a.nobill) as fis,
        (select sum(billing) from fotrpayment where lokasi='50' and nobill=a.nobill) as lab,
        (select sum(billing) from fotrpayment where lokasi='51' and nobill=a.nobill) as rad,
        (select sum(billing) from fotrpayment where lokasi='55' and nobill=a.nobill and mid(nonota,3,2)<>'sl') as OK,
        (select sum(billing) from fotrpayment where (lokasi='46' or lokasi='53') and nobill=a.nobill) as ICU,
        (select sum(billing) from fotrpayment where mid(nonota,3,2)='sl' and nobill=a.nobill) as apt,
        (select sum(billing) from fotrpayment where nonota=a.nobill) as chargebed,
        (select sum(dd.grandtotal) from fotrpostindakandet dd left join fotrpostindakan cc on cc.noreff=dd.noreff left join fotrpayment aa on cc.noreff=aa.nonota
          where(dd.type=1 and dd.typem=1) and aa.lokasi<>51 and aa.lokasi<>55 and aa.lokasi<>10 and aa.lokasi<>11 and aa.nobill=a.nobill) as ml,
        a.user,a.date,time_format(a.time,'%T') as time 
      FROM fotrdaftar a 
      left join fotrpayment b on b.nobill=a.nobill
      Where a.nobill='".$nobill."' 
      group by a.nobill";
    $query = $this->db->query($q)->result_array();

    $row = $query[0];
    if($row['OK']=='') $row['OK']=0;
					if($row['ml']=='') $row['ml']=0;
					if($row['rad']=='') $row['rad']=0;
					if($row['lab']=='') $row['lab']=0;
					if($row['fis']=='') $row['fis']=0;
					if($row['chargebed']=='') $row['chargebed']=0;
					if($row['ICU']=='') $row['ICU']=0;
					if($row['apt']=='') $row['apt']=0;
					//igd ikut keperawatan
					$keperawatan = $row['total'] - ($row['fis']+$row['lab']+$row['rad']+$row['OK']+$row['ICU']+$row['apt']+$row['chargebed']+$row['ml']);
					if($keperawatan=='') $keperawatan=0;
				
					$json_arr = [
            "hasil" => "Sukses",
            "total_tarif" => "$row[total]",
            "data"	=> [
							"prosedur_non_bedah"=> "0",
							"prosedur_bedah"	  => "$row[OK]",
							"konsultasi"		=> "$row[ml]",
							"tenaga_ahli"		=> "0",
							"keperawatan"		=> "$keperawatan",
							"penunjang"			=> "0",
							"radiologi"			=> "$row[rad]",
							"laboratorium"		=> "$row[lab]",
							"pelayanan_darah"	=> "0",
							"rehabilitasi"		=> "$row[fis]",
							"kamar"				    => "$row[chargebed]",
							"rawat_intensif"	=> "$row[ICU]",
							"obat"				    => "$row[apt]",
							"alkes"				    => "0",
							"bmhp"				    => "0",
							"sewa_alat"			  => "0"
              ]
            ];
              
    return $json_arr;
  }

  public function cariObatBill($nobill=null){
    $q = "SELECT
        a.NoBilling,
        a.nobukti,
        b.kodebrgket,
        b.jenisket
      FROM boivsales a
      LEFT JOIN boivsalesdet b ON a.nobukti=b.nobukti  AND b.jenis='01'
      WHERE a.NoBilling='".$nobill."' AND lokasi='60'";
    return $this->db->query($q)->result_array();
  }
  
  public function cariObatBillJoin($nobill=null){
    $q = "SELECT
        b.kodebrgket
      FROM boivsales a
      LEFT JOIN boivsalesdet b ON a.nobukti=b.nobukti AND b.jenis='01'
      WHERE a.lokasi='60' AND a.NoBilling='".$nobill."'";
    $res = $this->db->query($q)->result_array();
    // return ["res" => join(", ", $res)];
    $obats = [];
    for ($i=0; $i < count($res); $i++) { 
      $obats[] = $res[$i]['kodebrgket'];
    }
    // return $res;
    $val = ["res" => join(", ", $obats)];
    return $val;


  }
  
  
  
  
  public function cariDokter($dokter_param=null){
    $q = "SELECT a.kode, a.nama 
      FROM hrdmstkaryawan a
      WHERE (
        SUBSTR(a.nama,1,2) = 'dr'
        AND a.flagaktif = 0
        AND (
          a.kode like '".$dokter_param."%'
          OR a.nama like '%".$dokter_param."%'
        )
      )
      UNION
      SELECT b.Kode, b.Nama 
      FROM bohtmstvendor b
      WHERE (
        b.TypeX ='SP' AND (
          b.Kode like '".$dokter_param."%'
          OR b.Nama like '%".$dokter_param."%' 
        )
      )";
    return $this->db->query($q)->result_array();
  }
  
  
  
  
  
  // public function diagnosa_tindakan_input($_POST=null){
  //   $q = "UPDATE formdiagnosa 
  //     SET `ICDKode`='$_POST[ICDKode]',
  //       `ICDKode2`='$_POST[ICDKode2]', 
  //       `ICDKode3`='$_POST[ICDKode3]',
  //       `ICDKode4`='$_POST[ICDKode4]',
  //       `ICDKode5`='$_POST[ICDKode5]',
  //       `kodetindakan`='$_POST[kodetindakan]',
  //       `kodetindakan2`='$_POST[kodetindakan2]',
  //       `kodetindakan3`='$_POST[kodetindakan3]',
  //       `kodetindakan4`='$_POST[kodetindakan4]' 
  //     WHERE BillNo='$_POST[nomor_billing]'";
  //   return $this->db->query($q)->result_array();
  // }
  
  
  public function xx($param=null){
    $q = "";
    return $this->db->query($q)->result_array();
  }



  // ===[\pindahan eclaim/rscm_klaim ]===
  

}