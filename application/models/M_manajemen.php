<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_manajemen extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }
  

  public function selisih_tarif_rs_ina($datestart=null, $dateend=null){
    // QUERY DARI RSCM_KLAIM
    // select_tarif_rs_for_ina
    $q = "SELECT a.nobill,a.norm,a.nama,a.alamat,a.tanggalmasuk,a.tanggalkeluar,sum(b.billing) as total,
    (select sum(billing) from fotrpayment where nobill=a.nobill and lokasi='10' and mid(nonota,3,2)<>'sl') as igd,
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
    Where a.Date>='$datestart' AND a.Date<='$dateend' 
    group by a.nobill
    ";
		$query = $this->db->query($q)->result_array();
		return $query;
  }
  





  
  
  // USE
  public function lap_selisih_trf_rs_ina_grp_sp_det($datestart=null, $dateend=null, $sp=null){
    // select_tarif_rs_for_ina
    $q_add = "";
    if($sp!=null){
      $q_add = " AND dj.Dokter='".$sp."' ";
    }

    $q = "SELECT 
        dj.Dokter,
        mv.Nama AS namadokter,
        a.nobill,a.nosep, a.norm,a.nama,
        a.tanggalmasuk,a.tanggalkeluar,a.StatusDaftar,
        a.FlagBill,
        a.NoAnggota,
        sum(b.billing) as total_rs,
        a.totalINA AS total_ina,
        #ina.Inacbg AS total_ina_verif,
        IF( ina.Inacbg IS NULL , 0, ina.Inacbg ) AS total_ina_verif,
        #IF(a.totalINA=0, 0, (a.totalINA - sum(b.billing)) ) AS selisihInaRs,
        #IF(ina.Inacbg=0, 0, (ina.Inacbg - sum(b.billing)) ) AS selisihInaRs,
        IF( ina.Inacbg IS NULL , (-1*sum(b.billing)), (ina.Inacbg - sum(b.billing)) ) AS selisihInaRs,

        (select sum(billing) from fotrpayment where nobill=a.nobill and lokasi='10' and mid(nonota,3,2)<>'sl') as igd,
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
          
        a.user, a.date, time_format(a.time,'%T') as time 
      from fotrdaftar a 
      left join fotrpayment b on b.nobill=a.nobill
      left join fotrdaftarrj dj on dj.NoBill=a.NoBill
      left join bohtmstvendor mv on mv.Kode=dj.Dokter
      left join fotrinacbg ina on ina.Nobill=a.NoBill
      WHERE a.Date>='".$datestart."' AND a.Date<='".$dateend."' 
        ".$q_add."
        AND a.StatusDaftar = 'RJ' AND typedokter = '1'
        AND a.FlagBill<>4 
        AND a.PerusahaanPenanggung = 'CO031'
        AND dj.Dokter<>'92571' #dr.yudo
        AND dj.Dokter<>'92260' #Sri Lestari Wati, Amd.Ft
      group by a.nobill
      order by mv.Nama
    ";

    // echo $q; exit;

		$query = $this->db->query($q)->result_array();
		return $query;
  }
  
  

  // USE
  public function lap_selisih_trf_rs_ina_grp_sp($datestart=null, $dateend=null){
    $q_dok = "SELECT dj.Dokter,
        mv.Nama AS namadokter
      from fotrdaftar a 
      left join fotrpayment b on b.nobill=a.nobill
      left join fotrdaftarrj dj on dj.NoBill=a.NoBill
      left join bohtmstvendor mv on mv.Kode=dj.Dokter
      WHERE a.Date>='".$datestart."' AND a.Date<='".$dateend."' 
        #AND dj.Dokter='SP_102'
        AND a.StatusDaftar = 'RJ' AND dj.typedokter = '1'
        AND dj.Dokter <> '' # Lokasi=50, tidak ada SP
        AND a.FlagBill<>4         
        AND a.PerusahaanPenanggung = 'CO031'
        AND dj.Dokter<>'92571' #dr.yudo
        AND dj.Dokter<>'92260' #Sri Lestari Wati, Amd.Ft
      group by dj.Dokter # a.nobill
      order by mv.Nama  
    ";

    $query_dok = $this->db->query($q_dok)->result_array();
    // return $query_dok; exit;
    
    for ($i=0; $i < count($query_dok) ; $i++) {
      $query_dokdet = $this->m_manajemen->lap_selisih_trf_rs_ina_grp_sp_det($datestart, $dateend, $query_dok[$i]['Dokter']);
      
      $total_rs = 0;
      $total_ina = 0;
      $total_ina_verif = 0;
      $selisihInaRs = 0;
      for ($j=0; $j < count($query_dokdet) ; $j++) { 
        $total_rs += (int)$query_dokdet[$j]['total_rs'];
        $total_ina += (int)$query_dokdet[$j]['total_ina'];
        $total_ina_verif += (int)$query_dokdet[$j]['total_ina_verif'];
        $selisihInaRs += (int)$query_dokdet[$j]['selisihInaRs']; //??? 
      }

      $query_dok[$i]['detail'] = $query_dokdet;
      $query_dok[$i]['total_rs'] = $total_rs;
      $query_dok[$i]['total_ina'] = $total_ina;
      $query_dok[$i]['total_ina_verif'] = $total_ina_verif;
      $query_dok[$i]['selisihInaRs'] = $selisihInaRs; //???
      // $query_dok[$i]['selisihInaRs'] = $total_ina - $total_rs; //???

      // echo "<pre>",print_r($query_dok),"</pre>";
      // exit;
    }

    return $query_dok;
  }
  
  
  
  
  
  
  


  // =========== RI dengan dokter utama(DPJP) data di CASEMIX =======
  public function lap_ricx_selisih_trf_rs_ina_grp_sp_det($datestart=null, $dateend=null, $sp=null){
    // select_tarif_rs_for_ina
    $q_add = "";
    if($sp!=null){
      $q_add = " AND cx.dpjp ='".$sp."' ";
    }

    $q = "SELECT 
        cx.dpjp AS Dokter,
        di.DokterAwal AS Dokter_di,
        mv.Nama AS namadokter,
        cx.dpjp AS dokter_cx,
        mvcx.Nama AS dokter_cx_nama,
        a.nobill,a.nosep, a.norm,a.nama,
        a.tanggalmasuk,a.tanggalkeluar,a.StatusDaftar,
        a.FlagBill,
        cx.proses AS proses_final,
        a.NoAnggota,
        sum(b.billing) as total_rs,
        a.totalINA AS total_ina,
        IF( ina.Inacbg IS NULL , 0, ina.Inacbg ) AS total_ina_verif,
        cx.nobill AS nobill_cx,
        #IF(cx.nobill='', 'nobill_kosong', a.nobill ) AS nobill_cx,
        #IF(a.totalINA=0, 0, (a.totalINA - sum(b.billing)) ) AS selisihInaRs, #lastuse2
        #IF(ina.Inacbg=0, 0, (ina.Inacbg - sum(b.billing)) ) AS selisihInaRs, #lastuse1
        IF( ina.Inacbg IS NULL , (-1*sum(b.billing)), (ina.Inacbg - sum(b.billing)) ) AS selisihInaRs,
        a.user, a.date, time_format(a.time,'%T') as time 
      from fotrdaftar a 
      left join fotrpayment b on b.nobill=a.nobill
      left join fotrdaftarri di on di.NoBill=a.NoBill
      #left join bohtmstvendor mv on mv.Kode=di.DokterAwal
      left join bohtmstvendor mv on mv.Kode=cx.dpjp
      left join cx_daftarritarif cx on cx.nobill=a.NoBill
      left join bohtmstvendor mvcx on mvcx.Kode=cx.dpjp
      left join fotrinacbg ina on ina.Nobill=a.NoBill
      WHERE a.Date>='".$datestart."' AND a.Date<='".$dateend."' 
        ".$q_add."
        AND a.StatusDaftar = 'RI' #AND di.typedokter = '1'
        AND cx.dpjp<>''
        AND a.FlagBill<>4 
        AND a.PerusahaanPenanggung = 'CO031'
        AND di.DokterAwal<>'92571' #dr.yudo
        AND di.DokterAwal<>'92260' #Sri Lestari Wati, Amd.Ft
        #AND cx.proses='1' 
      group by a.nobill
      order by mv.Nama
    ";

    // WHERE:: #AND cx.proses='1'| FINAL=1, tidak dinyalakan karena baru mulai stabil casemix bulan januari tengah 2020

    // echo $q; exit;

		$query = $this->db->query($q)->result_array();
		return $query;
  }


  public function lap_ricx_selisih_trf_rs_ina_grp_sp($datestart=null, $dateend=null){
    $q_dok = "SELECT 
        #di.DokterAwal AS Dokter,
        cx.dpjp AS Dokter,
        mv.Nama AS namadokter
      from fotrdaftar a 
      left join fotrpayment b on b.nobill=a.nobill
      left join fotrdaftarri di on di.NoBill=a.NoBill
      #left join bohtmstvendor mv on mv.Kode=di.DokterAwal
      left join cx_daftarritarif cx on cx.nobill=a.NoBill
      left join bohtmstvendor mv on mv.Kode=cx.dpjp
      WHERE a.Date>='".$datestart."' AND a.Date<='".$dateend."'
        AND a.StatusDaftar = 'RI' #AND di.typedokter = '1'
        #AND di.DokterAwal <> '' # Lokasi=50, tidak ada SP
        AND cx.dpjp <> ''
        AND a.FlagBill<>4
        AND a.PerusahaanPenanggung = 'CO031'
        #AND di.DokterAwal<>'92571' #dr.yudo
        #AND di.DokterAwal<>'92260' #Sri Lestari Wati, Amd.Ft
      #group by di.DokterAwal # a.nobill
      group by cx.dpjp # a.nobill
      order by mv.Nama  
    ";

    $query_dok = $this->db->query($q_dok)->result_array();
    // return $query_dok; exit;
    
    for ($i=0; $i < count($query_dok) ; $i++) {
      $query_dokdet = $this->m_manajemen->lap_ricx_selisih_trf_rs_ina_grp_sp_det($datestart, $dateend, $query_dok[$i]['Dokter']);
      
      $total_rs = 0;
      $total_ina = 0;
      $total_ina_verif = 0;
      $selisihInaRs = 0;
      for ($j=0; $j < count($query_dokdet) ; $j++) { 
        $total_rs += (int)$query_dokdet[$j]['total_rs'];
        $total_ina += (int)$query_dokdet[$j]['total_ina'];
        $total_ina_verif += (int)$query_dokdet[$j]['total_ina_verif'];
        $selisihInaRs += (int)$query_dokdet[$j]['selisihInaRs']; //??? 
      }

      $query_dok[$i]['detail'] = $query_dokdet;
      $query_dok[$i]['total_rs'] = $total_rs;
      $query_dok[$i]['total_ina'] = $total_ina;
      $query_dok[$i]['total_ina_verif'] = $total_ina_verif;
      $query_dok[$i]['selisihInaRs'] = $selisihInaRs; //???
      // $query_dok[$i]['selisihInaRs'] = $total_ina - $total_rs; //???

      // echo "<pre>",print_r($query_dok),"</pre>";
      // exit;
    }

    return $query_dok;
  }



  //\=========== RI dengan dokter utama data di CASEMIX =======











  public function select_kunjunganri_px_dx_top10_by_rangehari_usia_cnt($tgl_start=null, $tgl_end=null, $usia_start=null, $usia_end=null){
		$q = "SELECT
				#td.NoRM,
				#td.NoBill,
				#rmdx.BillNo,
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
		$query = $this->db->query($q)->result();
		return $query;
  }


  // select_kunjunganri_px_dx_top10_by_rangehari_usia/2019-01-01/2019-12-24/60/69
  public function select_kunjunganri_px_dx_top10_by_rangehari_usia($tgl_start=null, $tgl_end=null, $usia_start=null, $usia_end=null){
		$q = "SELECT
        td.NoRM,
        td.NoBill,
        mp.TglLahir,
        td.UmurTahun,
        
        #FLOOR(DATEDIFF(DAY, mp.TglLahir, CURDATE()) / 365.25),
        rmdx.BillNo,
        td.StatusBL,
        td.StatusDaftar,
        rmdx.BillStatusDaftar,
        rmdx.ICDKode,
        rmdx.ICDKode2
        #COUNT(td.NoBill) as jml_px_all 
      FROM fotrdaftar td 
      LEFT JOIN fotrdaftarri tdri ON tdri.NoBill = td.NoBill 
      LEFT JOIN formdiagnosa rmdx ON rmdx.BillNo = tdri.NoBill
      LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM  
      WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' AND 
        td.FlagBill<>4 AND td.StatusDaftar='RI' AND BillStatusDaftar='RI'
        AND td.UmurTahun>='".$usia_start."'
        AND td.UmurTahun<='".$usia_end."'
      ORDER BY rmdx.ICDKode DESC
			";
		$query = $this->db->query($q)->result_array();
		return $query;
	}
  
  
  public function select_kunjunganrj_px_dx_top10_by_rangehari_usia($tgl_start=null, $tgl_end=null, $usia_start=null, $usia_end=null){
		$q = "SELECT
        td.NoRM,
        td.NoBill,
        mp.TglLahir,
        td.UmurTahun,
        
        #FLOOR(DATEDIFF(DAY, mp.TglLahir, CURDATE()) / 365.25),
        rmdx.BillNo,
        td.StatusBL,
        td.StatusDaftar,
        rmdx.BillStatusDaftar,
        rmdx.ICDKode,
        rmdx.ICDKode2
        #COUNT(td.NoBill) as jml_px_all 
      FROM fotrdaftar td
      LEFT JOIN formdiagnosa rmdx ON rmdx.BillNo = td.NoBill
      LEFT JOIN fomstpasien mp ON mp.NoRM = td.NoRM  
      WHERE td.Date>='".$tgl_start."' AND td.Date<='".$tgl_end."' 
        AND td.FlagBill<>4 
        AND rmdx.BillStatusDaftar='RJ'
        AND td.UmurTahun>='".$usia_start."' 
        AND td.UmurTahun<='".$usia_end."'
      ORDER BY rmdx.ICDKode DESC
			";
		$query = $this->db->query($q)->result_array();
		return $query;
  }
  


  // efihuni-tt/efihuni-tt-thn
  public function select_statistik($thn=null){
		$q = "
      SELECT rs.* 
      , CONCAT(?, '-', 
          IF( LENGTH(rs.bulan)>1, rs.bulan, CONCAT('0',rs.bulan) ), 
          '-01') AS dates
      , DAY(LAST_DAY(
          CONCAT(?, '-', 
          IF( LENGTH(rs.bulan)>1, rs.bulan, CONCAT('0',rs.bulan) ), 
          '-01')
        )) as nday
      FROM forptstatistik rs 
			WHERE tahun=?";
		$query = $this->db->query($q, [$thn, $thn, $thn])->result_array();
		return $query;
  }
    
  
	public function select_statistik_det($thn=null){
		// $q = "SELECT * FROM forptstatistik rs 
		// 	WHERE tahun='".$thn."'";
    // $query = $this->db->query($q)->result_array();
    
		$query = $this->m_manajemen->select_statistik($thn);    
    $n_bln = count($query);
    $TT = 122;
    $T = 30;

    $nday_bulans = 0;


    // TOTAL BOR dari hitungan BARIS TOTAL
    // RATA2 BOR dari hitungan KOLOM BOR

    
    $listn = $query;
    for ($i=0; $i < $n_bln; $i++) { 
      $listn[$i]['BOR'] = BOR((float)$listn[$i]['HP'], $TT, (float)$listn[$i]['nday']);
      $listn[$i]['LOS'] = LOS((float)$listn[$i]['LD'], (float) $listn[$i]['KHM']);
      $listn[$i]['TOI'] = TOI((float)$listn[$i]['KHM'], $TT, (float)$listn[$i]['nday'], (float) $listn[$i]['HP']);
      $listn[$i]['BTO'] = BTO((float)$listn[$i]['KHM'], $TT);
      $listn[$i]['GDR'] = GDR((float)$listn[$i]['KHM'], (float) $listn[$i]['dead']);
      $listn[$i]['NDR'] = NDR((float)$listn[$i]['KHM'], (float) $listn[$i]['dead_lbh48']);

      $nday_bulans += (int) $listn[$i]['nday'];

      // TOI($KHM=null, $TT=null, $T=null, $HP=null){
      // BTO($KHM=null, $TT=null){
      // GDR($KHM=null, $dead=null){ 
      // NDR($KHM=null, $dead_lebih48=null){  
    }

		$val = [
			'list' => $query,
			'listn' => $listn,
			'ave' => [
				'HP' 	=> 0, 
				'LD' 	=> 0,
				'KHM' => 0,
				'dead_krg48' => 0,
				'dead_lbh48' => 0,
				'dead' => 0,
				'hidup'=> 0,
				'BOR'=> 0,
				'LOS'=> 0,
				'TOI'=> 0,
				'BTO'=> 0,
				'GDR'=> 0,
				'NDR'=> 0,
			],
			'sum' => [
				'HP' 	=> 0, 
				'LD' 	=> 0,
				'KHM' => 0,
				'dead_krg48' => 0,
				'dead_lbh48' => 0,
				'dead' => 0,
				'hidup'=> 0,
				'BOR'=> 0,
				'LOS'=> 0,
				'TOI'=> 0,
				'BTO'=> 0,
				'GDR'=> 0,
				'NDR'=> 0,
				'nday'  => $nday_bulans,
			],
		];


		$li_ave = [
			'HP', 'LD', 'KHM', 'dead_krg48', 'dead_lbh48', 'dead', 'hidup',
			'BOR', 'LOS', 'TOI', 'BTO', 'GDR', 'NDR',
		];

		// $li_sum = ['HP', 'LD', 'KHM', 'dead_krg48', 'dead_lbh48', 'dead', 'hidup' ];
		$li_no_sum = ['BOR', 'LOS', 'TOI', 'BTO', 'GDR', 'NDR', ];
		
		
		for ($i=0; $i < count($listn) ; $i++) { 
			for ($j=0; $j < count($val['ave']) ; $j++) { 
				$val['sum'][$li_ave[$j]] += (float) $listn[$i][$li_ave[$j]];  

				if($i == (count($listn)-1) ){
					// $val['ave'][$li_ave[$j]] = round( $val['sum'][$li_ave[$j]] /12, 2);  // terakhir dipake 2021.02.23
					$val['ave'][$li_ave[$j]] = round( (float)($val['sum'][$li_ave[$j]] /$n_bln), 2);					
				}
				
			}      
      
      // // netralisir yg tidak boleh di sum
			// for ($not=0; $not < count($li_no_sum) ; $not++) { 
			// 	if($i == (count($query)-1) ){
			// 		$val['sum'][$li_no_sum[$not]] = '-';
			// 	}
      // }
      
    }

    
    $val['sum']['BOR'] = BOR((float)$val['sum']['HP'], $TT, (float)$val['sum']['nday']);
    $val['sum']['LOS'] = LOS((float)$val['sum']['LD'], (float) $val['sum']['KHM']);
    $val['sum']['TOI'] = TOI((float)$val['sum']['KHM'], $TT, (float)$val['sum']['nday'], (float) $val['sum']['HP']);
    $val['sum']['BTO'] = BTO((float)$val['sum']['KHM'], $TT);
    $val['sum']['GDR'] = GDR((float)$val['sum']['KHM'], (float) $val['sum']['dead']);
    $val['sum']['NDR'] = NDR((float)$val['sum']['KHM'], (float) $val['sum']['dead_lbh48']);
		
		return $val;
	}

  // == NEW 2021.01.08
  public function statistic_hospital_sex_1th($label=null, $thn=null, $sex=null){
    switch ($label) {
      // ["HP", "LD", "KHM", "dead_krg_48", "dead_lbh_48", "dead"]
      case "HP":
          $q = "SELECT(select count(p.NoBill) 
            from fotrpaymentdetbed p
            LEFT JOIN fotrdaftar td ON td.NoBill=p.NoBill
            where YEAR(p.TglTrans)='".$thn."'
            AND td.Sex='".$sex."'
            ) as '".$label."'";
        break;
  
      case "LD": // BELUM
          $q = "SELECT 
            (SELECT count(nobill) from fotrpaymentdetbed where nobill=a.nobill) as los 
            from formmorbiditasri a
            left join fotrdaftar h on h.nobill=a.nobill 
            LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=a.kelas
            #Where h.tanggalmasuk >= '2019-03-01' and h.tanggalmasuk <= '2019-03-31' 
            Where YEAR(h.tanggalmasuk) = '".$thn."' 
            #AND a.kelas='ANGSANA (KELAS 2 BERSALIN)'
            group by a.nobill";
        break;
      
      case "KHM":
				$q = "SELECT(select count(*)
					from formmorbiditasri mor
					LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
					LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
					WHERE YEAR(td.TanggalMasuk)='".$thn."'
          AND td.Sex='".$sex."'
					) as '".$label."'";
			break;

		  case "dead_krg_48":
				$q = "SELECT(select count(*)
					from formmorbiditasri mor
					LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
					LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
					left join FoRIMstKeadaanKeluar mkeluar on mkeluar.kode = mor.keadaankeluar
					WHERE YEAR(td.TanggalMasuk)='".$thn."' 
						and mor.keadaankeluar = 3
            AND td.Sex='".$sex."'
					order by mor.kelas ASC) as '".$label."'";
      break;
      	
      case "dead_lbh_48":
        $q = "SELECT(select count(*)
          from formmorbiditasri mor
          LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
          LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
          left join FoRIMstKeadaanKeluar mkeluar on mkeluar.kode = mor.keadaankeluar
          WHERE YEAR(td.TanggalMasuk)='".$thn."' 
            and mor.keadaankeluar= 4
            AND td.Sex='".$sex."'
          order by mor.kelas ASC) as '".$label."'";
        break;
          
    case "dead":
        $q = "SELECT(select count(*)
          from formmorbiditasri mor
          LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
          LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
          left join FoRIMstKeadaanKeluar mkeluar on mkeluar.kode = mor.keadaankeluar
          WHERE YEAR(td.TanggalMasuk)='".$thn."' 
            and (mor.keadaankeluar= 3 or mor.keadaankeluar= 4)
            AND td.Sex='".$sex."'
          order by mor.kelas ASC) as '".$label."'";
      break;
    }

    $res = $this->db->query($q)->result_array();
    return $res;

  }
  //\ == NEW 2021.01.08

  //\ efihuni-tt/efihuni-tt-thn
  
  

  // ============[ bo/menu/manajemen/dashboard-manajemen ]=================================
  
	public function select_kunjunganrj_px_tiapklinik_by_rangehari($tgl_start=null, $tgl_end=null, $download=null){
		$q = "SELECT ml.keterangan as lokasiket,
				count(td.noBill) As jml_px_all 
			from fotrdaftar td 
			left join fotrdaftarrj tdrj on td.nobill=tdrj.nobill 
			left join fomstlokasi ml on ml.kode=tdrj.lokasi 
			left join boptmstcustomer d on td.perusahaanpenanggung=d.kode 
			where td.tanggalmasuk>='".$tgl_start."' and td.TanggalMasuk<='".$tgl_end."' 
				and td.flagbill<>'4' and tdrj.lokasi<>'' and td.diagnosaawal<>'5892' 
				and ml.kode<>50 and ml.kode<>51 and ml.kode<>13 
			group by lokasiket";
		
		// $query = $this->db->query($q)->result_array();
		// return $query;
		
		if($download){ // TRUE = download excel
			return $this->db->query($q);
		}else{ // show data
			return $this->db->query($q)->result_array();
		}
		
	}
  // ============[\bo/menu/manajemen/dashboard-manajemen ]=================================


  // ============[ bo/menu/manajemen/anggaran rata2 ]=================================
  public function lap_selisih_trf_rs_ina_det($datestart=null, $dateend=null, $sp=null){
    $q_add = "";
    if($sp!=null){
      $q_add = " AND dj.Dokter='".$sp."' ";
    }

    $q = "SELECT 
        dj.Dokter,
        mv.Nama AS namadokter,
        a.nobill,a.nosep, a.norm,a.nama,
        a.tanggalmasuk,a.tanggalkeluar,a.StatusDaftar,
        a.FlagBill,
        a.NoAnggota,
        sum(b.billing) as total_rs,
        a.totalINA AS total_ina,
        #ina.Inacbg AS total_ina_verif,
        IF( ina.Inacbg IS NULL , 0, ina.Inacbg ) AS total_ina_verif,
        #IF(a.totalINA=0, 0, (a.totalINA - sum(b.billing)) ) AS selisihInaRs,
        #IF(ina.Inacbg=0, 0, (ina.Inacbg - sum(b.billing)) ) AS selisihInaRs,
        IF( ina.Inacbg IS NULL , (-1*sum(b.billing)), (ina.Inacbg - sum(b.billing)) ) AS selisihInaRs,
        a.user, a.date, time_format(a.time,'%T') as time 
      from fotrdaftar a 
      left join fotrpayment b on b.nobill=a.nobill
      left join fotrdaftarrj dj on dj.NoBill=a.NoBill
      left join bohtmstvendor mv on mv.Kode=dj.Dokter
      left join fotrinacbg ina on ina.Nobill=a.NoBill
      WHERE a.Date>='".$datestart."' AND a.Date<='".$dateend."' 
        ".$q_add."
        AND a.StatusDaftar = 'RJ' AND typedokter = '1'
        AND a.FlagBill<>4 
        AND a.PerusahaanPenanggung = 'CO031'
        AND dj.Dokter<>'92571' #dr.yudo
        AND dj.Dokter<>'92260' #Sri Lestari Wati, Amd.Ft
      group by a.nobill
      order by mv.Nama
    ";

    // echo $q; exit;

		$query = $this->db->query($q)->result_array();
		return $query;
  }
  // ============[\bo/menu/manajemen/anggaran rata2 ]=================================

}

//NOTE
/*

//--CARI USIA
select FLOOR(DATEDIFF(DAY, '1994-08-12', CURDATE() ) / 365.25) AS 'x'

//1--LIST
SELECT a.nobill,a.norm,a.nama,
      a.tanggalmasuk,a.tanggalkeluar,a.StatusDaftar,
      a.FlagBill,
      sum(b.billing) as total_rs,
      a.totalINA AS total_ina,
      IF(a.totalINA=0, 0, (a.totalINA - sum(b.billing)) ) AS selisihInaRs,
      dj.Dokter,
      mv.Nama AS namadokter,
      a.user,a.date,time_format(a.time,'%T') as time 
    from fotrdaftar a 
    left join fotrpayment b on b.nobill=a.nobill
    left join fotrdaftarrj dj on dj.NoBill=a.NoBill
    left join bohtmstvendor mv on mv.Kode=dj.Dokter
    WHERE a.Date>='2019-12-02' AND a.Date<='2019-12-03' 
      AND dj.Dokter='SP_102'
      AND a.StatusDaftar = 'RJ' AND typedokter = 1
      AND a.FlagBill<>4 
      AND dj.Dokter<>'92571' #dr.yudo
      AND dj.Dokter<>'92260' #Sri Lestari Wati, Amd.Ft
    group by a.nobill
    order by dj.Dokter



//2
	SELECT sum(b.billing) as total_rs
	from fotrdaftar a 
    left join fotrpayment b on b.nobill=a.nobill
    left join fotrdaftarrj dj on dj.NoBill=a.NoBill
    left join bohtmstvendor mv on mv.Kode=dj.Dokter
    WHERE a.Date>='2019-12-02' AND a.Date<='2019-12-03' 
      AND dj.Dokter='SP_102'
      AND a.StatusDaftar = 'RJ' AND typedokter = 1
      AND a.FlagBill<>4 
      AND dj.Dokter<>'92571' #dr.yudo
      AND dj.Dokter<>'92260' #Sri Lestari Wati, Amd.Ft
    group by a.nobill




//3
	SELECT dj.Dokter, sum(b.billing) as total_rs,
	a.totalINA AS total_ina
	from fotrdaftar a 
    left join fotrpayment b on b.nobill=a.nobill
    left join fotrdaftarrj dj on dj.NoBill=a.NoBill
    left join bohtmstvendor mv on mv.Kode=dj.Dokter
    WHERE a.Date>='2019-12-02' AND a.Date<='2019-12-03' 
      AND dj.Dokter='SP_102'
      AND a.StatusDaftar = 'RJ' AND typedokter = 1
      AND a.FlagBill<>4 
      AND dj.Dokter<>'92571' #dr.yudo
      AND dj.Dokter<>'92260' #Sri Lestari Wati, Amd.Ft
    group by dj.Dokter, a.nobill





//4
SELECT dj.Dokter,
sum(b.billing) as sum_total_rs,
sum(a.totalINA) AS sum_total_ina
from fotrdaftar a 
    left join fotrpayment b on b.nobill=a.nobill
    left join fotrdaftarrj dj on dj.NoBill=a.NoBill
    left join bohtmstvendor mv on mv.Kode=dj.Dokter
    WHERE a.Date>='2019-12-02' AND a.Date<='2019-12-03' 
      AND dj.Dokter='SP_102'
      AND a.StatusDaftar = 'RJ' AND typedokter = 1
      AND a.FlagBill<>4 
      AND dj.Dokter<>'92571' #dr.yudo
      AND dj.Dokter<>'92260' #Sri Lestari Wati, Amd.Ft
    group by dj.Dokter #, a.nobill




*/