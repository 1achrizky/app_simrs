<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function statistic_hospital($label=null, $thn=null, $bln=null, $kode_kelas=null, $kdpulang=null){
	switch ($label) {
		case "HP":
				$q = "SELECT(select count(NoBill) 
					from fotrpaymentdetbed
					where MONTH(TglTrans)='".$bln."' and YEAR(TglTrans)='".$thn."'
						and KodeKelas='".$kode_kelas."'
					) as '".$label."'";
			break;

		case "LD":
				$q = "SELECT 
					(SELECT count(nobill) from fotrpaymentdetbed where nobill=a.nobill) as los 
					from formmorbiditasri a
					left join fotrdaftar h on h.nobill=a.nobill 
					LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=a.kelas
					#Where h.tanggalmasuk >= '2019-03-01' and h.tanggalmasuk <= '2019-03-31' 
					Where MONTH(h.tanggalmasuk) = '".$bln."' AND YEAR(h.tanggalmasuk) = '".$thn."' 
					#AND a.kelas='ANGSANA (KELAS 2 BERSALIN)'
					AND mkls.kode='".$kode_kelas."'
					group by a.nobill";
			break;

		case "KHM":
				$q = "SELECT(select count(*)
					from formmorbiditasri mor
					LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
					LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
					WHERE MONTH(td.TanggalMasuk)='".$bln."' and YEAR(td.TanggalMasuk)='".$thn."' 
						and mkls.kode='".$kode_kelas."'
					) as '".$label."'";
			break;

		case "dead<48":
				$q = "SELECT(select count(*)
					from formmorbiditasri mor
					LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
					LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
					left join FoRIMstKeadaanKeluar mkeluar on mkeluar.kode = mor.keadaankeluar
					WHERE MONTH(td.TanggalMasuk)='".$bln."' and YEAR(td.TanggalMasuk)='".$thn."' 
						and mkls.kode='".$kode_kelas."'
						and mor.keadaankeluar = 3
					order by mor.kelas ASC) as '".$label."'";
			break;
				
		case "dead>=48":
				$q = "SELECT(select count(*)
					from formmorbiditasri mor
					LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
					LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
					left join FoRIMstKeadaanKeluar mkeluar on mkeluar.kode = mor.keadaankeluar
					WHERE MONTH(td.TanggalMasuk)='".$bln."' and YEAR(td.TanggalMasuk)='".$thn."' 
						and mkls.kode='".$kode_kelas."'
						and mor.keadaankeluar= 4
					order by mor.kelas ASC) as '".$label."'";
			break;
				
		case "dead":
				$q = "SELECT(select count(*)
					from formmorbiditasri mor
					LEFT JOIN fotrdaftar td ON td.nobill=mor.nobill
					LEFT JOIN fokmrmstkelas mkls ON mkls.keterangan=mor.kelas
					left join FoRIMstKeadaanKeluar mkeluar on mkeluar.kode = mor.keadaankeluar
					WHERE MONTH(td.TanggalMasuk)='".$bln."' and YEAR(td.TanggalMasuk)='".$thn."' 
						and mkls.kode='".$kode_kelas."'
						and (mor.keadaankeluar= 3 or mor.keadaankeluar= 4)
					order by mor.kelas ASC) as '".$label."'";
			break;
		
		default:
			# code...
			break;
	}

	return $q;

}



  //================ STATISTIC_HOSPITAL =====================

              
  // LOS ( Length Of Stay ) = Rata-2 lama dirawat | (3-12) Hari

  function BOR($HP=null, $TT=null, $T=null){
    // BOR ( Bed Occupancy Rate ) = Rata-2 TT ditempati | (75-85)%
    // BOR = (Jumlah hari perawatan rumah sakit / (Jumlah tempat tidur x Jumlah hari dalam satu periode)) X 100%
    // BOR = (Jumlah HP / (Jumlah TT x Periode)) X 100%

    //((Jumlah TT X Periode) – HP) / Jumlah KHM
    
    if($TT==0){
    	$val = 0;
    }else{
    	$val = ((int)$HP/((int)$TT*$T) )*100;
    }

    return (float)number_format($val,2);
  }

  function LOS($LD=null, $KHM=null){
    // AVLOS (Average Length of Stay) = Rata-rata lamanya pasien  | (6-9)hari
    // AVLOS = Jumlah lama dirawat / Jumlah pasien keluar (hidup + mati)
    // AVLOS = Jumlah LD / Jumlah KHM
    
    if($LD==0||$KHM==0){
    	$val = 0;
    }else{
    	$val = (int)$LD/(int)$KHM;
    }

    return (float)number_format($val,2);
  }

  function TOI($KHM=null, $TT=null, $T=null, $HP=null){
    // TOI ( Turn Over Interval ) = Selang waktu TT terpakai lagi  | (1-3) Hari
    // TOI = ((Jumlah tempat tidur X Periode) – Hari perawatan) / Jumlah pasien keluar (hidup + mati)
    // TOI = ((Jumlah TT X Periode) – HP) / Jumlah KHM

    //((Jumlah TT X Periode) – HP) / Jumlah KHM
    if($KHM==0){
    	$val = 0;
    }else{
    	$val = ( ( (int)$TT*$T)-(int)$HP )/(int)$KHM;
    }
    return (float)number_format($val,2);
  }

  function BTO($KHM=null, $TT=null){
    // BTO ( Bed Turn Over ) = Frek pemakaian TT | (35-45) Pasien
    // BTO = Jumlah pasien keluar (hidup + mati) / Jumlah tempat tidur
    // BTO = Jumlah KHM / Jumlah TT
    if($TT==0){
    	$val = 0;
    }else{
    	$val = (int)$KHM/(int)$TT;
    }
    
    return (float)number_format($val,2);
  }

  function GDR($KHM=null, $dead=null){ 
    // GDR : <45 per mil        
    // GDR = ( Jumlah pasien mati seluruhnya / Jumlah pasien keluar (hidup + mati)) X 1000 permil
    // GDR = ( Jumlah MATI / Jumlah KHM) X 1000 permil
    if($KHM==0){
    	$val = 0;
    }else{
    	$val = ( (int)$dead/(int)$KHM)*1000;
    }
    return (float)number_format($val,2);
  }

  function NDR($KHM=null, $dead_lebih48=null){     
    // NDR = (Jumlah pasien mati > 48 jam / Jumlah pasien keluar (hidup + mati)) X 1000 permil
    // NDR = (Jumlah 'dead>=48' / Jumlah KHM) X 1000 permil
    if($KHM==0){
    	$val = 0;
    }else{    	
		$val = ( (int)$dead_lebih48/(int)$KHM)*1000;
    }
    return (float)number_format($val,2);
  }
  
  //================\STATISTIC_HOSPITAL =====================

?>