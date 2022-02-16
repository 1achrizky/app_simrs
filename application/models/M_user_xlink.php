<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user_xlink extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	public function get_user_detail($username=null, $password=null){
		$this->db->where("userlogin='".$username."' AND password=encode('".$username."', '".$password."')");
		$q = $this->db->get('muser');

		if($q->num_rows() >0){
			$data = $q->row_array();
			$q->free_result();
		}else{
			$data = NULL;
		}
		return $data;
	}


	public function get_user_rscmklaim($noreg=null){
		$select = ["noreg", "coder_nik", "username"];
		$this->db->select($select);
		$this->db->from('rscmklaim_user');
		$this->db->where("noreg" , $noreg);
		$query = $this->db->get();

		$data = ($query->num_rows() >0)? $query->row() : NULL;
		return $data;
	}

	// TANPA MENAMPILKAN PASSWORD
  public function get_user_login($username=null, $password=null){	
		$select = "userlogin, kodekaryawan, nama, level, status";
		$this->db->select($select);
		$this->db->from('muser');
		$this->db->where("userlogin='".$username."' AND password=encode('".$username."', '".$password."')");
		$query = $this->db->get();

		$data = ($query->num_rows() >0)? $query->row_array() : NULL;
		return $data;
	}
	
	
	// TIDAK BISA TAMPIL HASIL PHPnya. Kalau run di SQL bisa tampil.
	// public function encrypt_sql($username=null, $password=null){
	// 	$data = $this->db->query("SELECT encode('".$username."', '".$password."')")->result_array();
	// 	return $data;
	// }
	
	public function get_user(){
		$select = "mu.userlogin, mu.kodekaryawan, mu.nama, mu.level, mu.status";
		$this->db->select($select);
		$this->db->from('muser mu');
		$this->db->where('mu.status', '0');
		$this->db->order_by('mu.userlogin');
		$query = $this->db->get();
		
		$data = ($query->num_rows() >0)? $query->result_array() : NULL;
		return $data;
	}
	
	public function get_level_users($level=null){		
		$select = "mu.userlogin, mu.kodekaryawan, mu.nama, mu.level, mu.status, mu.date, mu.time";
		$this->db->select($select);
		$this->db->from('muser mu');
		$this->db->where(["mu.level" => $level, "status" => 0]);
		$this->db->order_by('mu.userlogin');
		$query = $this->db->get()->result_array();
		
		return $query;
	}
	
	public function get_level(){		
		$select = "mu.level";
		$this->db->select($select);
		$this->db->from('muser mu');
		$this->db->group_by('mu.level');
		$query = $this->db->get()->result_array();
		
		return $query;
	}
	
	
	public function get_menu_by_level($level=null){	
		$q = "SELECT 
		ml.level, m.*
		FROM xmenulevel ml
		LEFT JOIN xmenu m ON m.id=ml.idmenu
		WHERE ml.level='".$level."'";	
		$query = $this->db->query($q)->result_array();

		return $query;
	}
	
	public function get_menu_by_username($username=null){	 // username = userlogin xlink
		$q = "SELECT 
		mu.username, m.*
		FROM xmenuuser mu
		LEFT JOIN xmenu m ON m.id=mu.idmenu
		WHERE mu.username='".$username."'";	
		$query = $this->db->query($q)->result_array();

		return $query;
	}
	
	
	// SEDANG DIGUNAKAN
	public function get_menu_by_level_exe_v2($level=null){	
		$q = "SELECT 
		ml.level, 
		ml.idmenu, #?
		m.id, 
		m.menuname, #?
		m.menuname AS title, 
		m.sort,
		CONCAT(m.icon_name, ' ', m.icon_color) AS icon, #?
		m.icon_name,
		m.icon_color,			
		#length(m.sort),
		#length(replace(m.sort, '.', ''))   AS nsub,			
(select 1 + length(m.sort) - length(replace(m.sort, '.', '')) ) AS nsub,

CONVERT( SUBSTRING_INDEX(m.sort, '.', 1) , UNSIGNED INTEGER) AS sub1,

CONVERT( IF(   (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) )     >=2, 
SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 2) , '.', -1) , 0) , UNSIGNED INTEGER) AS sub2,

CONVERT( IF(   (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) )     >=3, 
SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 3) , '.', -1) , 0), UNSIGNED INTEGER) AS sub3,

CONVERT( IF(   (select 1 + length(m.sort) - length(replace(m.sort, '.', '')) )     >=4, 
SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 4) , '.', -1) , 0), UNSIGNED INTEGER) AS sub4,

m.status,
m.url,
		-- IF(m.url='', 1, NULL) AS children
NULL AS children
FROM xmenulevel ml
LEFT JOIN xmenu m ON m.id=ml.idmenu
WHERE m.status=1 
AND ml.level='".$level."'
ORDER BY sub1, sub2, sub3, sub4
		";	

		$query = $this->db->query($q)->result_array();
		return $query;
	}
	
	
	/*
	public function get_menu_by_level_exe($level=null){	
		$q = "SELECT 
			ml.level, 
			ml.idmenu, m.id, 
			m.menuname, 
			m.menuname AS title, 
			m.sort,
			CONCAT(m.icon_name, ' ', m.icon_color) AS icon,
			-- CONVERT(INT, (length(replace(m.sort, '.', '')) ) ) AS nsub,
			-- CAST ( (length(replace(m.sort, '.', '')) )  AS UNSIGNED) AS nsub,
			length(replace(m.sort, '.', ''))   AS nsub,
			-- CONVERT(FLOAT, '3')   AS x,
			-- CAST(length(replace(m.sort, '.', '')) AS UNSIGNED)   AS nsub,
			-- CONVERT(INT, (length(replace(m.sort, '.', '')) )   AS nsub,
			SUBSTRING_INDEX(m.sort, '.', 1) AS sub1,
			IF( (length(replace(m.sort, '.', '')) ) >=2, 
				SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 2) , '.', -1) , 0) AS sub2,
			IF( (length(replace(m.sort, '.', '')) ) >=3, 
				SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 3) , '.', -1) , 0) AS sub3,
			IF( (length(replace(m.sort, '.', '')) ) >=4, 
				SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 4) , '.', -1) , 0) AS sub4,
			#SUBSTRING_INDEX(m.sort, '.', -1) AS sublast			
			#(1 + length(m.sort) - length(replace(m.sort, '.', '')) ) AS len
			m.menuname, m.url,
			-- IF(m.url='', 1, NULL) AS children
			NULL AS children
		FROM xmenulevel ml
		LEFT JOIN xmenu m ON m.id=ml.idmenu
		WHERE ml.level='".$level."'
		ORDER BY sub1, sub2, sub3, sub4
		";	

		$query = $this->db->query($q)->result_array();
		return $query;
	}
	*/

	
	
	// LOGIN USER EXCEPTION
	public function get_menu_by_username_exe($username=null){	
		$q = "SELECT 
			ml.username, 
			ml.idmenu, m.id, 
			m.menuname, 
			m.menuname AS title, 
			m.sort,
			CONCAT(m.icon_name, ' ', m.icon_color) AS icon,
			length(replace(m.sort, '.', ''))   AS nsub,
			SUBSTRING_INDEX(m.sort, '.', 1) AS sub1,
			IF( (length(replace(m.sort, '.', '')) ) >=2, 
				SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 2) , '.', -1) , 0) AS sub2,
			IF( (length(replace(m.sort, '.', '')) ) >=3, 
				SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 3) , '.', -1) , 0) AS sub3,
			IF( (length(replace(m.sort, '.', '')) ) >=4, 
				SUBSTRING_INDEX(SUBSTRING_INDEX(m.sort, '.', 4) , '.', -1) , 0) AS sub4,
			m.menuname, m.url,
			NULL AS children
		FROM xmenuuser ml
		LEFT JOIN xmenu m ON m.id=ml.idmenu
		WHERE ml.username='".$username."'
		ORDER BY sub1, sub2, sub3, sub4
		";	

		$query = $this->db->query($q)->result_array();
		return $query;
	}
	

	// FIX BISA
	public function get_menu_by_level_execute3($username=null, $level=null){
		//cek user exception
		$cnt_query = count($this->m_user_xlink->get_menu_by_username($username));
		// jika ada di exception
		$query = ($cnt_query>0)? 
			$this->m_user_xlink->get_menu_by_username_exe($username) :
			$this->m_user_xlink->get_menu_by_level_exe_v2($level);
			// $this->m_user_xlink->get_menu_by_level_exe($level); // HARI JUMAT 2020.11.13

		$gen = [];

		// count max sub
		for ($cm=0; $cm < count($query); $cm++) { 
			$nsubs[] = $query[$cm]['nsub'];
		}
		$max = max($nsubs);
		
		$cnt_sub = [0,0,0,0]; // ada 4 sub

		for ($i=0; $i < count($query) ; $i++) { 
			if(count(explode('[base_url]', $query[$i]['url']))>1 )
					$query[$i]['url'] = base_url().explode('[base_url]', $query[$i]['url'])[1];
				
			switch ((int)$query[$i]['nsub']) {
				case 1:
					$gen[] = $query[$i];
					$cnt_sub[0]++;
					$cnt_sub[1] = 0;
					break;
				
				case 2:
					$gen[ $cnt_sub[0]-1 ]['children'][] = $query[$i];
					$cnt_sub[1]++;
					$cnt_sub[2] = 0;
					break;
				
				case 3:
					$gen[ $cnt_sub[0]-1 ]['children'][ $cnt_sub[1]-1 ]['children'][] = $query[$i];
					$cnt_sub[2]++;
					$cnt_sub[3] = 0;
					break;
				
				case 4:
					$gen[ $cnt_sub[0]-1 ]['children'][ $cnt_sub[1]-1 ]['children'][ $cnt_sub[2]-1 ]['children'][] = $query[$i];
					$cnt_sub[3]++;
					break;
			}
		}

		$val = [
			"db" => $query,
			"gen" => $gen,
		];
		return $val;

	}


	/*
	SELECT 
ml.level, ml.idmenu, m.*
FROM xmenulevel ml
LEFT JOIN xmenu m ON m.id=ml.idmenu
WHERE ml.level=8


SELECT abs.* , mk.nama
FROM hrd_abs_log abs 
LEFT JOIN hrdmstkaryawan mk ON mk.kode = abs.id
WHERE fddate LIKE '2020-06-25%' 
	*/
	
	
	
  
}