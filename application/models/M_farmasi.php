<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_farmasi extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }

  public function detail_rekap_obat_range_dateXXX($date_start=null, $date_end=null){
    // ASLI DARI XLINK
    $q = "SELECT 
      a.tglentry, a.nobukti, a.lokasiket, d.keterangan as jenis,
      if(a.nobilling<>'',a.nobilling,'-') as nobilling,
      a.nama, a.alamat, a.asalrket, a.dokterket, 
      if(b.namaresep<>'',concat('R',b.noresep,' ',b.namaresep),'') as namaresep, 
      b.kodebrg, b.kodebrgket, b.jumlah, b.kemasan,
      b.hpp, b.hpptotal, b.hargajual, b.total,
      ((a.updiscp/100)*b.total) as updisc, 
      b.total+((a.updiscp/100)*b.total) as TotD, 
      (b.total+((a.updiscp/100)*b.total))*(a.pajakp/100) as Pajak,
      ((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100)) as gtot,
      (((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100))-b.hpptotal) as profit,
      a.dokter2, e.clpenanggung as kodepenanggung, f.nama as namapenanggung, a.kronis 
      from boivsales a 
      left join boivsalesdet b on a.nobukti=b.nobukti 
      left join boivmstbarang c on c.kodebrg=b.kodebrg 
      left join boivmstjenis d on d.kode=c.jenis 
      left join fotrpayment e on a.nobukti=e.nonota 
      left join boptmstcustomer f on e.clpenanggung=f.kode 
      where a.tglentry>=? and a.tglentry<=? 
      order by a.tglentry, a.nobukti, a.lokasiket, a.nobilling, b.type, b.noresep";
    $query = $this->db->query($q, [$date_start, $date_end])->result_array();
    // $query = $this->db->query($q, [$tahun, $bulan, $status])->result_array();
    // return $query;
    echo "<pre>",print_r($query),"</pre>"; exit;
  }
  
  
  public function detail_rekap_obat_range_date($date_start=null, $date_end=null){
    $q = "SELECT 
      a.tglentry, a.nobukti, a.lokasiket, d.keterangan as jenis,
      if(a.nobilling<>'',a.nobilling,'-') as nobilling,
      td.nosep,
      a.nama, a.alamat, a.asalrket, a.dokterket, 
      if(b.namaresep<>'',concat('R',b.noresep,' ',b.namaresep),'') as namaresep, 
      b.kodebrg, b.kodebrgket, b.jumlah, b.kemasan,
      b.hpp, b.hpptotal, b.hargajual, b.total,
      ((a.updiscp/100)*b.total) as updisc, 
      b.total+((a.updiscp/100)*b.total) as TotD, 
      (b.total+((a.updiscp/100)*b.total))*(a.pajakp/100) as Pajak,
      ((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100)) as gtot,
      SUM(((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100))) AS SUM_GTOT,
      (ov.verif - SUM(((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100))) ) AS SELISIH,
      COUNT(*) AS N_DETAIL_OBAT,
      -- ov.tagihan, 
      ov.verif,
      (((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100))-b.hpptotal) as profit,
      a.dokter2, e.clpenanggung as kodepenanggung, f.nama as namapenanggung, a.kronis 
      from boivsales a 
      left join boivsalesdet b on a.nobukti=b.nobukti 
      left join boivmstbarang c on c.kodebrg=b.kodebrg 
      left join boivmstjenis d on d.kode=c.jenis 
      left join fotrpayment e on a.nobukti=e.nonota 
      left join boptmstcustomer f on e.clpenanggung=f.kode 
      left join fotrdaftar td on td.NoBill=a.nobilling 
      left join xobatverif ov on ov.sep=td.nosep 
      where       
      a.tglentry>=? and a.tglentry<=?
      AND e.clpenanggung = 'CO031' AND a.kronis = 'kronis'
      group by a.nobukti
      order by a.tglentry, a.nobukti, a.lokasiket, a.nobilling, b.type, b.noresep
      ";

    $query = $this->db->query($q, [$date_start,$date_end])->result_array();
    // $query = $this->db->query($q)->num_rows();
    // $query = $this->db->query($q, [$tahun, $bulan, $status])->result_array();
    return $query;
    // echo "<pre>",print_r($query),"</pre>"; exit;
  }
  
  public function detail_rekap_obat_by_nosep($nosep=null){
    // $q = "SELECT * FROM fotrinacbg
    //   WHERE Tahun =? AND Bulan =? AND Status=?
    //   ORDER BY Nobill";

    $q = "SELECT 
    a.tglentry, a.nobukti, a.lokasiket, d.keterangan as jenis,
    if(a.nobilling<>'',a.nobilling,'-') as nobilling,
    a.nama, td.nosep, a.alamat, a.asalrket, a.dokterket, 
    if(b.namaresep<>'',concat('R',b.noresep,' ',b.namaresep),'') as namaresep, 
    b.kodebrg, b.kodebrgket, b.jumlah, b.kemasan,
    b.hpp, b.hpptotal, b.hargajual, b.total,
    #((a.updiscp/100)*b.total) as updisc, 
    #b.total+((a.updiscp/100)*b.total) as TotD, 
    #(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100) as Pajak,
    ((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100)) as gtot,
    #(((b.total+((a.updiscp/100)*b.total))+(b.total+((a.updiscp/100)*b.total))*(a.pajakp/100))-b.hpptotal) as profit,
    a.dokter2, e.clpenanggung as kodepenanggung, f.nama as namapenanggung, a.kronis 
    from fotrdaftar td
    left join boivsales a ON a.nobilling=td.NoBill
    left join boivsalesdet b on a.nobukti=b.nobukti 
    left join boivmstbarang c on c.kodebrg=b.kodebrg 
    left join boivmstjenis d on d.kode=c.jenis 
    left join fotrpayment e on a.nobukti=e.nonota 
    left join boptmstcustomer f on e.clpenanggung=f.kode 
  -- 	left join fotrdaftar td ON td.NoBill=a.nobilling
    where 
    #a.tglentry>='2020-01-01' and a.tglentry<='2020-01-31'
    #	a.nobilling='BL200114.0170'
    td.nosep = ? 
    #AND a.kronis = 'kronis'
    order by a.tglentry, a.nobukti, a.lokasiket, a.nobilling, b.type, b.noresep";

    $query = $this->db->query($q, [$nosep])->result_array();

    $sum_gtot = 0;
    for ($i=0; $i < count($query); $i++) { 
      $sum_gtot += (float) $query[$i]['gtot'];
    }

    $res = [
      "sum_gtot"  => $sum_gtot,
      "detail"    => $query,
    ];

    return $res;
  }



}