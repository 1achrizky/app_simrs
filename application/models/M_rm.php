<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rm extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }


  public function asesmen_rehab_medis_by_bill($nobill=null){
    // BL201214.0029
    $q = "SELECT mp.NoRM, td.NoBill, tp.NoNota, tp.Lokasi
    , ptd.KodeTindakan, mt.keterangan
    FROM fotrdaftar td
    LEFT JOIN fotrpayment tp ON tp.NoBill=td.NoBill
    LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
    LEFT JOIN fotrpostindakan pt ON pt.NoReff=tp.NoNota
    LEFT JOIN fotrpostindakandet ptd ON ptd.NoReff=pt.NoReff
    LEFT JOIN fomsttindakan mt ON mt.kode=ptd.KodeTindakan
    WHERE td.NoBill ='".$nobill."' AND tp.Lokasi='11' 
      AND !(ptd.KodeTindakan LIKE 'SP_%')";
    
    $query = $this->db->query($q)->result_array();
    return $query;
  }
  
  public function detail_tindakan_rehab_by_norm($norm=null, $idasesmen=null){
    $q = "SELECT rd.*
        , rd.tindakan AS detail_tx
        , rd.kodeTindakan AS detailkode_tx
        , td.nosep
        , td.TanggalMasuk
      FROM xfoasesrehabdet rd
      LEFT JOIN fotrdaftar td ON td.NoBill=rd.nobill
      WHERE rd.norm=? AND rd.idasesmen=? ORDER BY rd.urut ASC";
      // WHERE rd.norm=? AND rd.idasesmen=? ORDER BY rd.idasesmen ASC";
    $detail_paket = $this->db->query($q, [$norm, $idasesmen])->result_array();


    $q_mp = "SELECT NoRM, Barcode AS noka, Nama, TglLahir, Sex, Alamat FROM fomstpasien WHERE NoRM=?";
    $query_bio = $this->db->query($q_mp, [$norm])->result_array();
    if(count($query_bio)>0) $query_bio = $query_bio[0];

    $q_asesmen = "SELECT 
      a.*
      , mv.Nama AS namadokter
      , (SELECT mvv.Nama FROM bohtmstvendor mvv WHERE mvv.Kode=a.dokterPerujuk) AS namadokterperujuk
      FROM xfoasesrehab a 
      LEFT JOIN bohtmstvendor mv ON mv.Kode=a.dokter
      WHERE a.norm=? AND a.idasesmen=?";
    $asesmen = $this->db->query($q_asesmen, [$norm, $idasesmen])->result_array();
    if(count($asesmen)>0) $asesmen = $asesmen[0];


    $res = [
      "idasesmen" => intval($idasesmen),
      "bio"       => $query_bio,
      "asesmen"   => $asesmen,
      "detail_paket" => $detail_paket,
    ];
    
    return $res;    
  }


  // PERBAIKI KET
  // tambahan kode tindakan dokter => FTA267, FTA261.
  public function asesmen_rehab_medis_by_norm($norm=null){
    $q = "SELECT td.NoBill, tp.NoNota, tp.Lokasi, ptd.KodeTindakan 
      , IF(ISNULL(mt.keterangan), ptd.pelaksanaket, mt.keterangan ) AS keterangan 
      , mt.kode, ptd.pelaksana
      , td.nosep
      , td.TanggalMasuk
    FROM fotrdaftar td
    LEFT JOIN fotrpayment tp ON tp.NoBill=td.NoBill
    LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
    LEFT JOIN fotrpostindakan pt ON pt.NoReff=tp.NoNota
    LEFT JOIN fotrpostindakandet ptd ON ptd.NoReff=pt.NoReff 
    LEFT JOIN fomsttindakan mt ON mt.kode=ptd.KodeTindakan
    WHERE mp.NoRM =? AND tp.Lokasi='11' 
    AND (
      !(ptd.KodeTindakan LIKE 'SP_%')
      OR ptd.pelaksana='FTA267'
      OR ptd.pelaksana='FTA261'
      )

    -- AND td.FlagBill = 0
    ORDER BY td.NoBill DESC
    ";
    
    $query = $this->db->query($q, [$norm])->result_array();
    // echo "<pre>",print_r($query),"</pre>"; exit;
    // HASIL $query:  KodeTindakan belum terGROUP oleh NoBill
    
    
    $arr = [];
    foreach ($query  as $key => $value) {
      // echo "<pre>",print_r([ $value['NoBill'], $key]),"</pre><br>";
      $arr[$value['NoBill']][] = $value; //  BISA
    }
    // echo "<pre>",print_r($arr),"</pre>"; exit;
    // HASIL $arr:  KodeTindakan terGROUP oleh NoBill

    $bills = array_keys($arr);
    // print_r($bills); exit;


    $val = [];
    for ($i=0; $i < count($bills); $i++) {
      $arr_det_str = [];
      $arr_detkode_str = [];
      for ($d=0; $d < count($arr[$bills[$i]]); $d++) { 
        $arr_det_str[] = $arr[$bills[$i]][$d]['keterangan'];
        $arr_detkode_str[] = $arr[$bills[$i]][$d]['KodeTindakan'];
      }

      $val[] = [
        "nobill" => $bills[$i],
        "nosep"  => $arr[ $bills[$i] ][0]['nosep'],
        "TanggalMasuk"  => $arr[ $bills[$i] ][0]['TanggalMasuk'],
        "detail_tx" => join(", ", $arr_det_str),
        "detailkode_tx" => join(",", $arr_detkode_str),
        "detail" => $arr[$bills[$i]],
      ];
    }


    $q_mp = "SELECT NoRM, Nama, TglLahir, Sex, Alamat FROM fomstpasien WHERE NoRM=?";
    $query_bio = $this->db->query($q_mp, [$norm])->result_array();
    if(count($query_bio)>0) $query_bio = $query_bio[0];
    
    
    $q_list_paket = "SELECT * FROM xfoasesrehab a WHERE a.norm=? ORDER BY idasesmen ASC";
    $list_paket = $this->db->query($q_list_paket, [$norm])->result_array();
    

    $res = [
      "bio" => $query_bio,
      "list" => $val, // LIST tindakan by nobill
      "list_paket" => $list_paket,
    ];
    
    return $res;
    // echo "<pre>",print_r( $val),"</pre><br>"; exit;
  }


  public function list_ases_rehab_by_norm($norm=null){
    $q = "SELECT * FROM xfoasesrehab WHERE norm=?";
    $query = $this->db->query($q,[$norm])->result_array();
    // $query = $this->db->query($q,[$norm])->num_rows();
    return $query;
  }

  public function list_rehab_by_rangedate($dateStart=null, $dateEnd=null){
    $q = "SELECT r.* 
      , rd.urut, rd.nobill, rd.tindakan, rd.kodeTindakan, rd.ket
      , mp.Nama, td.TanggalMasuk, td.nosep, mp.Barcode as noka
      -- , mv.Nama AS namadokter
      , (SELECT mv.Nama FROM bohtmstvendor mv WHERE mv.Kode=r.dokter) AS namadokter
      , (SELECT mvv.Nama FROM bohtmstvendor mvv WHERE mvv.Kode=r.dokterPerujuk) AS namadokterperujuk
    FROM xfoasesrehab r
      LEFT JOIN xfoasesrehabdet rd ON rd.norm=r.norm AND rd.idasesmen=r.idasesmen
      LEFT JOIN fotrdaftar td ON td.NoBill=rd.nobill
      LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
      -- LEFT JOIN bohtmstvendor mv ON mv.kode=r.dokter
    WHERE td.TanggalMasuk>=? AND td.TanggalMasuk<=?     
    ORDER BY r.norm ASC, r.idasesmen ASC, rd.urut ASC";

    $query = $this->db->query($q,[$dateStart, $dateEnd])->result_array();
    return $query;
  }
  



  
  public function rmdx_fotrdaftar($nobill=null){
    // ini FOTRDAFTAR(RJ) saja
    $q = "SELECT td.*, rj.Lokasi, rj.Dokter, rj.typedokter FROM fotrdaftar td 
      LEFT JOIN fotrdaftarrj rj on rj.NoBill=td.NoBill
      WHERE td.NoBill=?";
    $query_trdaftar = $this->db->query($q,[$nobill])->result_array();
    if(count($query_trdaftar)>0) $query_trdaftar = $query_trdaftar[0];
    
    
    $q = "SELECT * FROM formdiagnosa WHERE BillNo=?";
    $query_rmdx = $this->db->query($q,[$nobill])->result_array();
      
    $query = [
      "trdaftar"  => $query_trdaftar,
      "rmdx"      => $query_rmdx,
    ];
    
    return $query;
  }
  
  
  public function bill_latest_by_norm(){
    // $q = "SELECT mp.NoRM, mp.Nama
    //     -- , td.NoBill 
    //   FROM fomstpasien mp 
    //   -- LEFT JOIN fotrdaftar td ON td.NoRM = mp.NoRM
    //   -- GROUP BY mp.NoRM
    //   ";
    // // echo $q; exit;
    $menit = 3;
		$settime = 60*$menit;
    set_time_limit($settime);

    $q = "SELECT x.NoRM, x.Nama
      , x.NoBill, x.date 
      , DATEDIFF(CURDATE(), x.date) AS selisihHari
      , TIMESTAMPDIFF( YEAR, x.date, CURDATE()) AS y
      , TIMESTAMPDIFF( MONTH, x.date, CURDATE()) AS m
      , TIMESTAMPDIFF( DAY, x.date, CURDATE()) AS d
      FROM (
        SELECT * FROM fomstpasien mp 
        LEFT JOIN fotrdaftar td ON td.NoRM = mp.NoRM
        ORDER BY mp.NoRM, td.date DESC
      ) AS x 
      GROUP BY x.NoRM";
    $query = $this->db->query($q)->result_array();
    // $query = $this->db->query($q)->num_rows();

    // return $query;
    echo "<pre>",print_r($query),"</pre>"; exit;
  }
  
  
    
  public function get_nomor_surat($tahun=null){
    $q = "SELECT nomor FROM xsurat WHERE tahun=? ORDER BY nomor DESC";
    $query = $this->db->query($q, [$tahun])->row_array();
    $val = ($query==null)? 1 : ((int)$query['nomor']+1);    
    return $val;
  }
  
  public function getsurat_ket_by_nobill($nobill=null){
    $q = "SELECT s.*, sk.*
        , IF(sk.rapid='antigen', 'Antigen Anti SARS CoV 2', 
            IF(sk.rapid='antibodi', 'Antibodi Anti SARS CoV 2',  '')
          ) AS rapidLabel
        , td.NoRM as norm, td.UmurTahun AS umur
        , mp.Nama AS nama, mp.Alamat AS alamat
        , mp.Sex AS jeniskelamin
        , IF(mp.Sex='L', 'LAKI-LAKI','PEREMPUAN') as jeniskelamin_str
        , mp.Barcode AS noka
        , mk.nama AS dokternama, mk.SIP 
      FROM xsurat s
      LEFT JOIN xsurat_ket sk ON sk.kodeSurat=s.kodeSurat
      LEFT JOIN hrdmstkaryawan mk ON mk.kode=sk.dokter
      LEFT JOIN fotrdaftar td ON td.NoBill=sk.nobill
      LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
      WHERE sk.nobill=? AND s.kode='KET' AND s.flag=0";
    $query = $this->db->query($q, [$nobill])->row_array(); 

    if($query == null){
      $_this =& get_instance();
      $_this->load->model('m_daftarmandiri');
      $query = $_this->m_daftarmandiri->px_by_bill($nobill)['detail'];
    }
    
    return $query;
    

  }
  
  

  // public function getsurat_ket_by_nobill($nobill=null){
  //   $q = "SELECT s.*, sk.*, td.NoRM, mp.Nama, mp.Alamat, mp.Sex
  //       , mk.nama AS dokternama, mk.SIP 
  //     FROM fotrdaftar td
  //     LEFT JOIN xsurat s ON s.nobill=td.NoBill
  //     LEFT JOIN xsurat_ket sk ON sk.kodeSurat=s.kodeSurat
  //     LEFT JOIN hrdmstkaryawan mk ON mk.kode=sk.dokter
  //     LEFT JOIN fomstpasien mp ON mp.NoRM=td.NoRM
  //     WHERE td.nobill=? AND s.kode='KET'";
  //   $query = $this->db->query($q, [$nobill])->row_array(); 
  //   // if($query == null){

  //   // }else{
  //   //   return $query;
  //   // }
  //   return $query;
  // }
  
  // public function getsurat_ket($kodesurat=null){
  //   $q = "SELECT s.*, sk.*, mk.nama, mk.SIP 
  //     FROM xsurat s
  //     LEFT JOIN xsurat_ket sk ON sk.kodeSurat=s.kodeSurat
  //     LEFT JOIN hrdmstkaryawan mk ON mk.kode=sk.dokter
  //     WHERE sk.kodeSurat=?";
  //   $query = $this->db->query($q, [$kodesurat])->row_array(); 
  //   return $query;
  // }
  
  
  public function get_dokter_surat(){
    $q = "SELECT d.*, mk.nama, mk.SIP 
      FROM xmstdoktermenu d 
      LEFT JOIN hrdmstkaryawan mk ON mk.kode=d.kode
      ORDER BY mk.nama ASC";
    $query = $this->db->query($q)->result_array();
    return $query;
  }
  
  
  public function get_master_pasien(){
    $q = "SELECT mp.NoRM, mp.Barcode, mp.NoIdentitas AS NIK, mp.Nama, mp.Sex
        , mp.Alamat , mp.TglLahir, mp.Telp, mp.HP
      FROM fomstpasien mp
      ORDER BY mp.NoRM ASC
      LIMIT 10000";
    $query = $this->db->query($q)->result_array();
    return $query;
    // print_r($query); exit;
  }

}
