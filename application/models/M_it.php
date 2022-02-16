<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_it extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
  }

  public function printername($url, $button_id, $fx_name){
    $q = "SELECT * FROM xprinter 
      WHERE url=? AND button_id=? AND fx_name=?";
    $query = $this->db->query($q, [$url, $button_id, $fx_name])->result_array();
    $val = (count($query)>0)? $query[0]['printername'] : '';
		return $val;
  }

  public function select_printer(){
    $q = "SELECT * FROM xsetting WHERE app_menu='printer' ORDER BY value";
    $query = $this->db->query($q)->result_array();
    for ($i=0; $i < count($query); $i++)
      $query[$i]['str'] = str_replace('\\', '_', $query[$i]['value']);
    


    $getprt = printer_list(PRINTER_ENUM_CONNECTIONS);
    $printers = serialize($getprt);
    $printers = unserialize($printers);
    for ($j=0; $j < count($printers); $j++)
      $printers[$j]['str'] = str_replace('\\', '_', $printers[$j]["NAME"]);
    

    $val = [
      "db" => $query,
      "connected" => $printers,
    ];
		return $val;
  }


  //update terbaru: 2020.11.13
  public function select_menu(){
    $q = "SELECT 
			m.id, 
			m.menuname AS title, 
			m.sort,
			m.icon_name,
			m.icon_color,			
			#length(m.sort),
			#length(replace(m.sort, '.', ''))   AS nsub,			
      (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) ) AS nsub,
      (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) ) AS levelsub,
      CONVERT( SUBSTRING_INDEX(m.sort, '.', 1) , UNSIGNED INTEGER) AS sub1,

      CONVERT( IF(   (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) )     >=2, 
      SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 2) , '.', -1) , 0) , UNSIGNED INTEGER) AS sub2,

      CONVERT( IF(   (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) )     >=3, 
      SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 3) , '.', -1) , 0), UNSIGNED INTEGER) AS sub3,

      CONVERT( IF(   (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) )     >=4, 
      SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 4) , '.', -1) , 0), UNSIGNED INTEGER) AS sub4,

      m.status,
      m.url,
      NULL AS children
      FROM xmenu m 
      WHERE m.status=1 
      ORDER BY sub1, sub2, sub3, sub4";

    $query = $this->db->query($q)->result_array();
    

    $explo = []; 
    for ($i=0; $i < count($query); $i++) { 
      // $explo = explode('.', $query[$i]['sort']);
      $explo = array_map('intval', explode('.', $query[$i]['sort']) );
      $levelsub = count($explo);
      if(count(explode('[base_url]', $query[$i]['url']))>1 )
        $query[$i]['url'] = base_url().explode('[base_url]', $query[$i]['url'])[1];
      
      $query[$i]['icon'] = [$query[$i]['icon_name'], $query[$i]['icon_color']];
      $query[$i]['explo'] = $explo;
      $query[$i]['levelsub'] = $levelsub;
      $query[$i]['children'] = null;


      // TRANSFORM
      $val = [];
      if ($levelsub==1) {
        array_push($val, $query[$i]);
      }else{
        for ($ex=0; $ex < count($levelsub); $ex++) { 
          // array_push($val[$i]['children'], $query[$i]);
        }
      }


    }

		return $query;
  }




  // CEK KARAKTER ANEH
  public function e_char_aneh_fomsttindakan($nobill=null){
    $q = "SELECT * FROM fomsttindakan";
    // $q = "SELECT * FROM fomsttindakan WHERE keterangan LIKE '%\u00a0'";
    // $q = "SELECT * FROM fomsttindakan WHERE keterangan LIKE '%\u00a0'";
    $query = $this->db->query($q)->result_array();
    echo json_encode($query);
          

		$x = ['NoBill', 'NoBillSub', 'NoRM','TanggalMasuk', 
					'JamMasuk', 'TanggalKeluar', 'JamKeluar',
					'StatusBl', 'FlagBill',
					'DiagnosaAwal', 'Anggota',
					'PerusahaanPenanggung', 'BiayaKartu',
					'BiayaKartuUpDisc',
					'StatusDaftar', 'Nama', 'Alamat', 'Telp',
					'HP', 'Fax',
					'Email', 'RT', 'RW', 'Kelurahan',
					'Kecamatan', 'Kota', 'Propinsi',
					'Negara', 'Agama', 'Pendidikan', 'Pekerjaan',
					'Sex', 'Marital'
				];
				
				
				// for($i=0; $i<count($x); $i++){
				// 	echo $i.". ".$x[$i]." >> ";
				// 	$q = "SELECT ".$x[$i]."	from fomsttindakan where NoBill='".$nobill."'";
				// 	$query = $this->db->query($q)->result_array();
				// 	// $val[$i] = [$x[$i] , $query ];

				// 	echo json_encode($query);
				// 	echo "<br>";
				// }

	}	
  //\CEK KARAKTER ANEH
  
  
  
  
  // public function select_menu(){
  //   $q = "SELECT id, menuname AS title, sort, url, status, icon_name, icon_color 
  //     FROM xmenu WHERE status=1 ORDER BY sort";
  //   $query = $this->db->query($q)->result_array();
    

  //   $explo = []; 
  //   for ($i=0; $i < count($query); $i++) { 
  //     // $explo = explode('.', $query[$i]['sort']);
  //     $explo = array_map('intval', explode('.', $query[$i]['sort']) );
  //     $levelsub = count($explo);
  //     if(count(explode('[base_url]', $query[$i]['url']))>1 )
  //       $query[$i]['url'] = base_url().explode('[base_url]', $query[$i]['url'])[1];
      
  //     $query[$i]['icon'] = [$query[$i]['icon_name'], $query[$i]['icon_color']];
  //     $query[$i]['explo'] = $explo;
  //     $query[$i]['levelsub'] = $levelsub;
  //     $query[$i]['children'] = null;


  //     // TRANSFORM
  //     $val = [];
  //     if ($levelsub==1) {
  //       array_push($val, $query[$i]);
  //     }else{
  //       for ($ex=0; $ex < count($levelsub); $ex++) { 
  //         // array_push($val[$i]['children'], $query[$i]);
  //       }
  //     }


  //   }

	// 	return $query;
  // }








  // public function select_menu_transformX(){
  //   $mn = $this->m_it->select_menu();
  //   // return $mn;

  //   function infiChild($db){
  //     $levelsub = $db['levelsub'];
  //     $res = [];

  //     if($levelsub == 1){
  //       $res[] = $db;
  //     }else{
  //       for ($j=0; $j < $levelsub; $j++) { 
  //         // $c_explo = count($db[$i]['explo']);
  //         for ($k=0; $k < count($db['explo']); $k++) { // loop explode
            
  //         }
  //       }
  //     }

  //     return $res;
  //     // return $db;
  //   }

  //   // for ($i=0; $i < count($mn); $i++) { 
  //   for ($i=0; $i < 3; $i++) { 
  //     $val =
  //     [
  //       "i" => $i,
  //       "gen" => infiChild($mn[$i]),
  //       "db" => $mn[$i],
  //     ];
  //   }

  //   return $val;

  // }
  
  
  // public function select_menu_transform(){
  //   $mn = $this->m_it->select_menu();
  //   // return $mn;

  //   function infiChild($db){
  //     $levelsub = $db['levelsub'];
  //     $res = [];

  //     if($levelsub == 1){
  //       $res[] = $db;
  //     }else if($levelsub == 2){

        
  //       array_push($arr[$db['explo'][0]]['children'], $db);

  //       // for ($j=0; $j < $levelsub; $j++) { 
  //       //   // $c_explo = count($db[$i]['explo']);
  //       //   for ($k=0; $k < count($db['explo']); $k++) { // loop explode
  //       //     // $arr[['']]
  //       //     $arr[$db['explo'][0]]['children']
  //       //     array_push($arr, $db);
  //       //   }
  //       // }
  //     }else{
  //       // for ($j=0; $j < $levelsub; $j++) { 
  //       //   // $c_explo = count($db[$i]['explo']);
  //       //   for ($k=0; $k < count($db['explo']); $k++) { // loop explode
  //       //     // $arr[['']]
  //       //     $arr[$db['explo'][0]]['children']
  //       //     array_push($arr, $db);
  //       //   }
  //       // }
  //     }

  //     return $res;
  //     // return $db;
  //   }


  //   $res = [];
  //   for ($i=0; $i < count($mn); $i++) { 
  //   // for ($i=0; $i < 5; $i++) { 
  //     $db = $mn[$i];

  //     $levelsub = $db['levelsub'];

  //     if($levelsub == 1){
  //       $res[] = $db;
  //     }else if($levelsub == 2){        
  //       // array_push($res[ intval($db['explo'][0])-1 ]['children'][], $db);
  //       $res[ intval($db['explo'][0])-1 ]['children'][] = $db;
  //     }else if($levelsub == 3){
  //       $res[ intval($db['explo'][0])-1 ]['children'][ intval($db['explo'][1])-1 ]['children'][] = $db;
  //     }
      

  //     // $vals = [
  //     //   "i" => $i,
  //     //   "res" => $res,
  //     //   // "db" => $mn[$i],
  //     // ];

  //     // $val[] = $vals;
  //   }

  //   $val = $res;
  //   return $val;

  // }
}