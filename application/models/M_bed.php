<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bed extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		date_default_timezone_set("Asia/Jakarta");
  }


	//!!!HAPUS
  // public function onload_bed_jadok(){
  //   $q = "SELECT data, date, time from xview where app='billboard_bed'";
  //   $beds = $this->db->query($q)->result_array();
  //   // $beds[0]['data'] 	= json_decode( json_decode($beds[0]['data'], 1), 1); 
  //   $beds[0]['data'] 	= json_decode($beds[0]['data'], 1); 
    
  //   $q = "SELECT data, date, time from xview where app='billboard_jadok'";
  //   $jadok = $this->db->query($q)->result_array();
  //   // $jadok[0]['data'] = json_decode( json_decode($jadok[0]['data'], 1), 1);
  //   $jadok[0]['data'] = json_decode($jadok[0]['data'], 1);
    
  //   $val = [
  //     "onload" => [
  //       "get_last_update" => $beds[0]['date'].' '.$beds[0]['time'],
  //       "beds" => $beds,
  //       "jadok" => $jadok,
  //     ]
  //   ];

	// 	return $val;
  // }
	
	
	// CARA BARU LOAD & UPDATE BILLBOARD. 2021.03.17
	public function onload_bed_jadok_langsung(){
		$this->load->model(['m_daftarmandiri', 'm_bed', 'm_main']);
		$beds = $this->m_bed->cnt_info_tt_rs()['billboard'];
		$jadok = arr_repair( $this->m_daftarmandiri->get_jadok_all()['dtjs'] );
		// $jadok = arr_repair( $jadok);		


		$js = $jadok;
		$len = count($js);
		$hr = [0,0,0,0,0,0,0]; // senin = array[1]. HR0 tidak dipakai.
		$dt_hr = [];

		for($i=0; $i<$len; $i++){
			for ($j=1; $j < 7; $j++) { 

				if($js[$i]['hariId'] == $j){
					$hr[$j]++;
					$dt_hr[$j][] = $js[$i] ;					
				}

			}
		}


		$dt_hr_fix = [];
		for ($d=0; $d < count($dt_hr); $d++) { 
			$dt_hr_fix[$d] = [
				"dt_hr" => $dt_hr[$d+1],
        "cnt" => $hr[$d+1],
			];
		}
				
		// $val = [$beds, $jadok, $hr, $dt_hr, $dt_hr[6], count($dt_hr), $x ];
		// echo '<pre>', print_r($val) ,'</pre>';

		$set_bed = [
			'data' => json_encode($beds),
			'user' => $this->session->userdata("username"),
			'date' => date('Y-m-d'),
			'time' => date('H:i:s'),
		];
		$res_bed = $this->m_main->update('xview', $set_bed, ["app" => 'billboard_bed']);
		
				
		$set_jadok = [
			'data' => json_encode($dt_hr_fix),
			'user' => $this->session->userdata("username"),
			'date' => date('Y-m-d'),
			'time' => date('H:i:s'),
		];
		$res_jadok = $this->m_main->update('xview', $set_jadok, ["app" => 'billboard_jadok']);

    		
		$val = [
      "onload" => [
        "get_last_update" => date('Y-m-d H:i:s'), // $beds[0]['date'].' '.$beds[0]['time'],
				"beds" 	=> [
					[
						"data" => $beds,
						"date" => date('Y-m-d'),
						"time" => date('H:i:s'),
					],
				],
        "jadok" => [
					[
						"data" => $dt_hr_fix,
						"date" => date('Y-m-d'),
						"time" => date('H:i:s'),
					],
				],
			],
			"response" => [
				"res_bed" 		=> $res_bed, // ONKAN
				"res_jadok" 	=> $res_jadok, // ONKAN
				"time_upload" => date('Y-m-d H:i:s'), // ONKAN
			],
    ];
		// echo '<pre>', print_r($val) ,'</pre>'; exit;
		return $val;
  }


  public function cnt_info_tt_rs(){
		/* untuk namaRuang kosong, lihat b.kode dan b.Keterangan */ 
		$q_ruang = "SELECT b.namaRuang,  b.kode AS kodeRuang,
				b.kodeRuangBpjs, b.namaRuangBpjs, b.kodeKelasBpjs
			from fokmrsetupbed a 
			LEFT JOIN fokmrmstruang b on b.Kode = a.KodeRuang
			LEFT JOIN fokmrmstbed c on c.kode = a.KodeBed
			where  (c.status = 'RD' OR c.status = 'IN' OR c.status = 'CO') # (c.status = 'RD' OR c.status = 'IN')
				AND c.jenis <>'BOX BAYI' 
				AND NOT(c.keterangan like 'Bed Bayangan%')
				AND NOT(b.keterangan like 'R BAYI%')
			group by b.namaRuang #, b.keterangan
			order by b.kelasRuang #, b.Keterangan ASC
			";

		$query_ruang = $this->db->query($q_ruang)->result_array();
		$val = $query_ruang;
		// echo '<pre>',print_r($val),'</pre>'; exit;
		
    //RD = BED_TERSEDIA
    $billboard = [];
		for($i=0; $i<count($query_ruang); $i++){
			$q2 = "SELECT 
					COUNT(b.namaRuang) as jml
					#IFNULL(COUNT(b.namaRuang),0) as jml
				from fokmrsetupbed a 
				LEFT JOIN fokmrmstruang b on b.Kode = a.KodeRuang
				LEFT JOIN fokmrmstbed c on c.kode = a.KodeBed
				where  c.status = 'RD'
					AND b.namaRuang='".$query_ruang[$i]['namaRuang']."'
					AND c.jenis <>'BOX BAYI' 
					AND NOT(c.keterangan like 'Bed Bayangan%')
					AND NOT(b.keterangan like 'R BAYI%')
				group by b.namaRuang
				order by b.kelasRuang, b.Keterangan ASC";

			$query2 = $this->db->query($q2)->result_array();
			if($query2 == null)  $query2[0]["jml"] = 0;			
			// return $query2; exit;

			$val[$i]["jml_ready"] = (int)$query2[0]["jml"];
      //$val[$i]["jml_all"] = (int)$val[$i]["jml_in"] + (int)$val[$i]["jml_ready"];
      

      // LOOP BILLBOARD
      if($val[$i]["namaRuang"] != 'INTERMEDIET' && $val[$i]["jml_ready"]!= 0 && $val[$i]["namaRuang"] != '')
        $billboard[] = [ "namaRuang" => $val[$i]["namaRuang"], "jmlReady" => (int)$val[$i]["jml_ready"] ];
		}
		

		//CO = BED_CEKOUT
		for($i=0; $i<count($query_ruang); $i++){
			$q2 = "SELECT 
					COUNT(b.namaRuang) as jml
					#IFNULL(COUNT(b.namaRuang),0) as jml
				from fokmrsetupbed a 
				LEFT JOIN fokmrmstruang b on b.Kode = a.KodeRuang
				LEFT JOIN fokmrmstbed c on c.kode = a.KodeBed
				where c.status = 'CO'
					AND b.namaRuang='".$query_ruang[$i]['namaRuang']."'
					AND c.jenis <>'BOX BAYI' 
					AND NOT(c.keterangan like 'Bed Bayangan%')
					AND NOT(b.keterangan like 'R BAYI%')
				group by b.namaRuang
				order by b.kelasRuang, b.Keterangan ASC";

			$query2 = $this->db->query($q2)->result_array();
			if($query2 == null)  $query2[0]["jml"] = 0;
			// return $query2; exit;

			$val[$i]["jml_checkout"] = $query2[0]["jml"];
    }
    

    
		
		//RD = BED_BAYANGAN
		for($i=0; $i<count($query_ruang); $i++){
			$q2 = "SELECT 
					COUNT(b.namaRuang) as jml
					#IFNULL(COUNT(b.namaRuang),0) as jml
				from fokmrsetupbed a 
				LEFT JOIN fokmrmstruang b on b.Kode = a.KodeRuang
				LEFT JOIN fokmrmstbed c on c.kode = a.KodeBed
				where  c.status = 'IN'
					AND b.namaRuang='".$query_ruang[$i]['namaRuang']."'
					AND c.jenis <>'BOX BAYI' 
					AND c.keterangan like 'Bed Bayangan%'
					AND NOT(b.keterangan like 'R BAYI%')
				group by b.namaRuang
				order by b.kelasRuang, b.Keterangan ASC";

			$query2 = $this->db->query($q2)->result_array();
			if($query2 == null) 	$query2[0]["jml"] = 0;
			
			// return $query2; exit;

			$val[$i]["jml_bayangan"] = (int)$query2[0]["jml"];
			//$val[$i]["jml_all"] = (int)$val[$i]["jml_in"] + (int)$val[$i]["jml_ready"];
		}

    
    //IN = BED_TERPAKAI
    // bedanya dg BED_BAYANGAN, yaitu pada "WHERE ..AND NOT"
		for($i=0; $i<count($query_ruang); $i++){
			$q2 = "SELECT 
					COUNT(b.namaRuang) as jml
					#IFNULL(COUNT(b.namaRuang),0) as jml
					#IF(ISNULL(b.namaRuang),1,0) as jml
				from fokmrsetupbed a 
				LEFT JOIN fokmrmstruang b on b.Kode = a.KodeRuang
				LEFT JOIN fokmrmstbed c on c.kode = a.KodeBed
				where  c.status = 'IN' 
					AND b.namaRuang='".$query_ruang[$i]['namaRuang']."'
					AND c.jenis <>'BOX BAYI' 
					AND NOT(c.keterangan like 'Bed Bayangan%')
					AND NOT(b.keterangan like 'R BAYI%')
				group by b.namaRuang
				order by b.kelasRuang, b.Keterangan ASC";

			$query2 = $this->db->query($q2)->result_array();
			if($query2 == null)  $query2[0]["jml"] = 0;
			// return $query2; exit;

			$val[$i]["jml_in"] = (int)$query2[0]["jml"];
			$val[$i]["jml_inAddBayangan"] = (int)$val[$i]["jml_in"] + (int)$val[$i]["jml_bayangan"];
            
      // jml_all sebelumnya di comment di info_tt_rs disini, 
      // kemudian diaktifkan karena yang query menu/dashboard ambil disini juga.
      // JUMLAH BED dari ALL STATUS(IN, RD, CO)
			$val[$i]["jml_all"] = (int)$val[$i]["jml_in"] + (int)$val[$i]["jml_ready"] + (int)$val[$i]["jml_checkout"];
    }


    // LOOP SUM
    $sum = [
      "jml_bayangan" => 0,
      "jml_checkout" => 0,
      "jml_in" => 0,
      "jml_inAddBayangan" => 0,
      "jml_ready" => 0,
    ];
    
    for($i=0; $i<count($query_ruang); $i++){
      $sum["jml_bayangan"] += (int)$val[$i]["jml_bayangan"];
      $sum["jml_checkout"] += (int)$val[$i]["jml_checkout"];
      $sum["jml_in"] 			 += (int)$val[$i]["jml_in"];
      $sum["jml_inAddBayangan"] += (int)$val[$i]["jml_inAddBayangan"];
      $sum["jml_ready"] += (int)$val[$i]["jml_ready"];
    }
    

    $res = [
      "sum"   => $sum,
      "list"  => $val,
      "billboard" => $billboard,
    ];

		return $res;

  } //cnt_info_tt_rs()
  
  
}