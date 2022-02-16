<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rm extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
  }


    
  public function update_sep0($date=null){
    $this->load->model(['m_main']);
    // $upd = $this->m_main->update('fotrdaftar', ['nosep'=>0], ['nosep'=>'', 'nobill'=>'BL211125.0005', 'NoAnggota'=> 'BPJS']);
    $upd = $this->m_main->update('fotrdaftar', ['nosep'=>0], ['nosep'=>'', 'Date'=>$date, 'NoAnggota'=> 'BPJS']);
    exit(json_encode($upd));
  }


  public function insert_asesmen_rehab(){
    $this->load->model(['m_main', 'm_rm']);
    $input = $this->input->post(NULL, TRUE);
    // echo json_encode($input); exit;
    
    // echo strlen('01122'); exit;
    if(strlen($input['norm']) == 6){
      //buat paket baru
      //count id paket terbaru+1
      $cnt = count($this->m_rm->list_ases_rehab_by_norm($input['norm']))+1;
      $input["idasesmen"] = $cnt;
      $input["user"] = $this->session->userdata("username");
      $input["date"] = date('Y-m-d');
      $input["time"] = date('H:i:s');
  
      $exe_insert = $this->m_main->insert("xfoasesrehab", $input);
      
      $result = [
        "metadata"  => [
          "status"  => 'success',
          "message"  => 'OK',          
        ],
        "exe_insert"  => $exe_insert,
        "idasesmen"   => $cnt,
      ];
    }else{
      $result = [
        "metadata"  => [
          "status"  => 'failed',
          "message"  => 'NORM tidak sama dengan 6 digit.',          
        ],
        "exe_insert"  => false,
        "idasesmen"   => false,
      ];
    }

    
    echo json_encode($result);
    
    exit;    
  }
  
  
  public function update_asesmen_rehab(){
    $this->load->model(['m_main', 'm_rm']);
    $input = $this->input->post(NULL, TRUE);
    // echo json_encode($input); exit;


    if($input["paket"] == ''){
      $result = [
        "status" => "failed",
        "message" => "Opsi paket harus dipilih.",
      ];
      // echo json_encode($result);
    }else{
      //buat paket baru

      //count id paket terbaru+1
      // $cnt = count($this->m_rm->list_ases_rehab_by_norm($input['norm']))+1;
      $input["idasesmen"] = $input["paket"];
      $input["user"] = $this->session->userdata("username");
      $input["date"] = date('Y-m-d');
      $input["time"] = date('H:i:s');
      if($input["goalTgl"] == '') $input["goalTgl"] = null;
      if($input["tglRujukan"] == '') $input["tglRujukan"] = null;
      $send = $input;

      $arr_tindak = [];
      for ($i=0; $i < 3; $i++) { 
        if(isset($input['tindak'.($i+1)]) && $input['tindak'.($i+1)] != ''){
          $arr_tindak[] = ($i+1);
          array_splice($send, array_search('tindak'.($i+1), array_keys($send)), 1);
        } 
      }
      $send["tindakLanjut"] = implode (",", $arr_tindak);

      // menghapus array paket
      array_splice($send, array_search("paket",array_keys($send)), 1);
      array_splice($send, array_search("norm",array_keys($send)), 1);
      // echo json_encode($send); exit;

      $table = "xfoasesrehab";
      $where = [
        "norm"      => $input["norm"],
        "idasesmen" => $input["paket"],
      ];
      $result = $this->m_main->update($table, $send, $where);

    }
    echo json_encode($result);
    exit;   
    
  }
  
  
  
  public function delete_asesmen_rehab(){
    $this->load->model(['m_main', 'm_rm']);
    $input = $this->input->post(NULL, TRUE);
    // echo json_encode($input); exit;

    if($input["norm"] == ''){
      $result = [
        "status" => "failed",
        "message" => "Norm harus diisi.",        
      ];
      // echo json_encode($result);
    }else{      
      if($input["paket"] == ''){
        $result = [
          "status" => "failed",
          "message" => "Opsi paket harus dipilih.",
        ];
      }else{
        $result = $this->m_main->delete("xfoasesrehab", ["norm" => $input["norm"], "idasesmen" => $input["paket"],]);
        $result = $this->m_main->delete("xfoasesrehabdet", ["norm" => $input["norm"], "idasesmen" => $input["paket"],]);
      }

    }
    echo json_encode($result);
    exit;   
    
  }

  // saat delete list, insert batch. Karena utk menangani delete pertengahan array yg tidak urut
  // INI DIPERBAIKI KET
  public function insert_batch_detail_tindakan_rehab(){
    $this->load->model(['m_main', 'm_rm']);
    $input = $this->input->post(NULL, TRUE);
    
    $send = [];
    for ($i=0; $i < count($input['list']); $i++) { 
      $send[] = [
        "norm"      => $input['norm'],
        "idasesmen" => $input['idasesmen'],
        "urut"        => $i+1,
        "nobill"      => $input['list'][$i]['nobill'],
        "tindakan"    => $input['list'][$i]['detail_tx'],
        "kodeTindakan"=> $input['list'][$i]['detailkode_tx'],
        "ket"         => $input['list'][$i]['ket'],
      ];
    }

    $result = $this->m_main->delete("xfoasesrehabdet", ["norm" => $input["norm"], "idasesmen" => $input["idasesmen"],]);

    $result_ins_asesrehabdet = $this->m_main->insert_batch("xfoasesrehabdet", $send);
    echo json_encode($result_ins_asesrehabdet);
    exit;


    // CEK ADA/TIDAK
    $li_latest = $input['list'][count($input['list'])-1];
    $rmdx = $this->m_rm->rmdx_fotrdaftar($li_latest['nobill']);
    echo json_encode($rmdx); exit;

    if(count($rmdx['rmdx'])>0 ){
      $val = [
        "metaData" => [
          "status" => "failed",
          "message" => "Billing sudah ada di FO RM Diagnosa.",
        ],
      ];
    }else{
      $send_rmdx = [
        "BillNo"      => $input['norm'],
        "BillStatusDaftar" => $rmdx['trdaftar']['StatusDaftar'],
        "TglMasuk"    => $rmdx['trdaftar']['TanggalMasuk'],
        "TglKeluar"   => $rmdx['trdaftar']['TanggalKeluar'],
        "JamMasuk"    => $rmdx['trdaftar']['JamMasuk'],
        "JamKeluar"   => $rmdx['trdaftar']['JamKeluar'],
        "RmNo"   => $rmdx['trdaftar']['NoRM'],
        "Sex"    => $rmdx['trdaftar']['Sex'],
        "User"   => $this->session->userdata("username"),
        "Date"   => date('Y-m-d'),
        "Time"   => date('H:i:s'),
        "RmUmurThn"   => $rmdx['trdaftar']['UmurTahun'],
        "RmUmurBln"   => $rmdx['trdaftar']['UmurBulan'],
        "RmUmurHari"  => $rmdx['trdaftar']['UmurHari'],
        "Pendidikan"  => $rmdx['trdaftar']['Pendidikan'],
        "Pekerjaan"   => $rmdx['trdaftar']['Pekerjaan'],
        "LokasiKode"  => $rmdx['trdaftar']['Lokasi'],
        "DokterKode"  => $rmdx['trdaftar']['Dokter'],
        "DokterType"  => $rmdx['trdaftar']['typedokter'],
        "Anamnesa"    => $input['paket_pilih']['anamnesa'],
        "fisik"       => $input['paket_pilih']['fisik'],
      ];
      $result_ins_rmdx = $this->m_main->insert("formdiagnosa", $send_rmdx);
      
      $val = [
        "metaData" => [
          "status" => "failed",
          "message" => "Billing sudah ada di FO RM Diagnosa.",
        ],
        "response" => [
          "result_ins_asesrehabdet" => $result_ins_asesrehabdet,
          "rmdx" => $rmdx,
          "result_ins_rmdx" => $result_ins_rmdx,
        ],
        
      ];
    }

    echo json_encode($val);
    exit;      

  }
  
  
  // public function insert_detail_tindakan_rehab(){
  //   $this->load->model(['m_main', 'm_rm']);
  //   $input = $this->input->post(NULL, TRUE);
    
  //   $send = [
  //     "norm"      => $input['norm'],
  //     "idasesmen" => $input['idasesmen'],
  //     "urut"        => $i+1, //?
  //     "nobill"      => $input['list'][$i]['nobill'], //?
  //     "tindakan"    => $input['list'][$i]['detail_tx'], //?
  //     "kodeTindakan"=> $input['list'][$i]['detailkode_tx'], //?
  //   ];    
  //   $result = $this->m_main->insert("xfoasesrehabdet", $send);    
  // }






  // public function create_surat($tahun=null, $bulan=null, $ket=null, $nomor=null){
  public function create_surat($tahun=null, $bulan=null, $kode=null){
    $this->load->model('m_rm');
    $nomor = $this->m_rm->get_nomor_surat($tahun);
    // echo $nomor; exit;
       
    // $romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
    $gen = create_digit(3,$nomor).'/RM.'.$kode.'/'.romawi_bulan($bulan).'/'.$tahun;
    return $gen;
  }

  
  public function insert_surat_ket(){
    $this->load->model(['m_main', 'm_rm']);
    $input = $this->input->post(NULL, TRUE);

    $tahun = (int)date('Y');
    $bulan = (int)date('n');
    $nomor = $this->m_rm->get_nomor_surat($tahun);
    $c_surat = $this->create_surat($tahun, $bulan, $input['kode']);
    // echo json_encode([$input, $nomor, $tahun, $bulan, $input['kode'], $c_surat]); exit;
    
    $input["pcrTgl"] = ($input["pcrTgl"] == '') ? null: $input['pcrTgl'];
    $input['rapidTgl'] = ($input["rapidTgl"] == '') ? null: $input['rapidTgl'];
    
    $input["kodeSurat"] = $c_surat;
    $input["user"]      = $this->session->userdata("username");
    $input["datetime"]  = date('Y-m-d H:i:s');

    $ins_xsurat = [
      "tahun" => $tahun,
      "bulan" => $bulan,
      "nomor" => $nomor,
      "kode"  => $input["kode"],
      "kodeSurat" => $c_surat,
      "user"      => $input["user"],
      "datetime"  => $input["datetime"],
    ];

    $exe_ins_xsurat = $this->m_main->insert("xsurat", $ins_xsurat);

    // menghapus array paket
    array_splice($input, array_search("kode",array_keys($input)), 1);

    $exe_ins_xsurat_ket = $this->m_main->insert("xsurat_ket", $input);
    $result = [
      "request"  => [
        "xsurat"      => $ins_xsurat,
        "xsurat_ket"  => $input,
      ],
      "response"  => [
        "xsurat"      => $exe_ins_xsurat,
        "xsurat_ket"  => $exe_ins_xsurat_ket,
      ],
    ];
    echo json_encode($result); exit;    
  }
  
  
  
  public function getsurat_ket_by_nobill($nobill=null){
    $this->load->model(['m_main', 'm_rm']);
    $nomor = $this->m_rm->get_nomor_surat($tahun);
    echo json_encode($result); exit;    
  }

  public function update_surat_ket(){
    $this->load->model(['m_main']);
    $input = $this->input->post(NULL, TRUE);
    // echo json_encode($input); exit;

    $input["user"]      = $this->session->userdata("username");
    $input["datetime"]  = date('Y-m-d H:i:s');
    $send = $input;

    // menghapus array paket
    array_splice($send, array_search("kodeSurat",array_keys($send)), 1);
    array_splice($send, array_search("kode",array_keys($send)), 1);
    
    $table = "xsurat_ket";
    $where = [
      "kodeSurat" => $input["kodeSurat"],
    ];
    // echo json_encode([$input, $send, $where]); exit;
    $result = $this->m_main->update($table, $send, $where);

    echo json_encode($result); exit;       
  }
  
  
  public function delete_surat_ket(){
    $this->load->model(['m_main']);
    if(isset($_GET["kodeSurat"])){
      // if($_GET["kodeSurat"] == '' || $_GET["kodeSurat"] == null || $_GET["kodeSurat"] == TRUE){
      if($_GET["kodeSurat"] == '' || $_GET["kodeSurat"] == null ){
        $result = false;
      }else{
        $where = [ "kodeSurat" => $_GET["kodeSurat"] ];
        $result = $this->m_main->update("xsurat", ["flag" => 1], $where);
      }
    }

    echo json_encode($result); exit;       
  }
  









  // =======================

  protected $conf_db_pdo = [
  	"main" => [
  		"hostname" => "192.168.1.5",
	    "dbname" 	 => "xlink",
	    "username" => "root",
	    "password" => "root",
  	],
  ];

  public function pdo_declare(){
    $host = $this->conf_db_pdo['main']['hostname'];
    $dbname = $this->conf_db_pdo['main']['dbname'];
    $username = $this->conf_db_pdo['main']['username'];
    $password = $this->conf_db_pdo['main']['password'];
    try {
        $db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
        die("Connection error: " . $e->getMessage());
    }
    return $db;
  }

  public function px($i=null){
    $db = $this->pdo_declare();

    $lim = 10000;
    $q = "SELECT mp.NoRM, mp.Barcode, mp.NoIdentitas AS NIK, mp.Nama, mp.Sex
    , mp.Alamat , mp.TglLahir, mp.Telp, mp.HP
    FROM fomstpasien mp
    LIMIT ?,?
    ";
    // -- LIMIT 10000

    $query = $db->prepare($q);
    $query->bindValue(1, ($i*$lim) , PDO::PARAM_INT);
    $query->bindValue(2, $lim , PDO::PARAM_INT);
    // $query->bindValue(2, $button_id );
    // $query->bindValue(3, $fx_name );
    $query->execute();
    $val = $query->fetchAll(PDO::FETCH_ASSOC);
    // return $val;

    // print_r($val); exit;
    if($val)
      // return $val['printername'];
      return $val;
    	// return ["metadata"=> ["code"=>200, "status"=>"success", "message"=>"OK"], "response"=>$val];
    else
      return '';
   		// return ["metadata"=> ["code"=>201, "status"=>"failed", "message"=>"Tidak berhasil."], "response"=>null];    
  }
  
  
  public function count_px($i=null){
    $db = $this->pdo_declare();

    $q = "SELECT COUNT(*) AS cnt FROM fomstpasien";

    $query = $db->prepare($q);
    $query->execute();
    $val = $query->fetch(PDO::FETCH_ASSOC);
    return $val;

    print_r($val); exit;
    if($val)
      return $val;
    else
      return '';    
  }


  function CreateJSON_ScanLog(){	
    $header = '{"Result":true,"Data":[';
    $footer = "]}";
    $content = "";
    // $sqlscan = mysql_query("SELECT mp.NoRM, mp.Barcode, mp.NoIdentitas AS NIK, mp.Nama, mp.Sex
    // , mp.Alamat , mp.TglLahir, mp.Telp, mp.HP
    // FROM fomstpasien mp");

    $px = $this->px(13); 
  
    // // while($datascan = mysql_fetch_array($sqlscan)){
    // while($datascan = $sqlscan){
    // }
    
    
    // for ($i=0; $i < count($datascan); $i++) {
    foreach ($px as $datascan) {        
        if ($content != "") $content .= ',';       
        
        $content .= '{"NoRM":"'.$datascan['NoRM']
          .'","Barcode":"'.$datascan['Barcode']
          .'","NIK":"'.$datascan['NIK']
          .'","Nama":"'.$datascan['Nama']
          .'","Sex":"'.$datascan['Sex']
          .'","TglLahir":"'.$datascan['TglLahir']
          .'","Telp":"'.$datascan['Telp']
          .'","HP":"'.$datascan['HP']
          .'","Alamat":"'.$datascan['Alamat'].'}';
    
    }
    
    return ($header.$content.$footer);
  }
  
  
  public function get_master_pasien(){
    $this->load->model(['m_rm']);
    
    // $result = $this->m_rm->get_master_pasien();

    // $handle = fopen ("content/".$namafile, "w"); 
    // if (!$handle) { 				
    //     $server_output = "Filed Save"; 
    // } else { 				
    //   fwrite ($handle, CreateUserJSON()); 					
    //   $dirname = dirname($path)."/JSOnDataScanLog.txt";
    // } 
    // fclose($handle); 
    
    $namafile = "JSOnDataScanLog.txt";
    $handle = fopen ($namafile, "w"); 
    if (!$handle) { 				
        $server_output = "Filed Save"; 
    } else { 				
      // fwrite ($handle, CreateUserJSON()); 					
      // fwrite ($handle, 'tesssss'); 					
      fwrite ($handle, $this->CreateJSON_ScanLog()); 					
      $dirname = "JSOnDataScanLog.txt";
    } 
    fclose($handle); 
    

    // echo json_encode($result); exit;       
  }
  
  



  function CreateTxtExcel($data=null, $fields=null, $delimiter=";", $withField=true){	
    $content = "";    
    $header = '"' . implode('"'.$delimiter.'"', $fields) . '"'."\r\n";

    foreach ($data as $datascan) {        
      if ($content != "") $content .= "\r\n";
      $cf = "";
      foreach ($fields as $f) {
        if ($cf != "") $cf = $delimiter;
        $content .= $cf.'"'.$datascan[$f].'"';
        $cf = $delimiter;
      }      
    }
    
    if($withField) return $header.$content;
    else return $content;
  }
  
  protected $baseUrlWsDbPx = "192.168.1.104/rscm/wsprinter/wsprinter.php";
  public function assembly_db_px($n=0){
    // for ($i=0; $i < $n; $i++) { 
    //   $this->load->library('curl');
    //   $antrian = ["i"=> 2];
		// 	$_ws_px = json_decode( $this->curl->sendRequest("px","POST", json_encode($antrian),"application/json",$this->baseUrlWsDbPx), 1 );			
		// 	// $_ws_px = $this->curl->sendRequest("px","POST", json_encode($antrian),"application/json",$this->baseUrlWsDbPx);			
    // }
    // print_r($_ws_px);

    $this->load->library('curl');
    // $antrian = ["i"=> intval($n)];
		// $_ws_px = json_decode( $this->curl->sendRequest("px","POST", json_encode($antrian),"application/json",$this->baseUrlWsDbPx), 1 );			
		$_ws_px = json_decode( $this->curl->sendRequest("px?i=".$n,"POST", json_encode([]),"application/json",$this->baseUrlWsDbPx), 1 );			
			
    exit(json_encode($_ws_px));
  }

  public function get_master_pasien_txt(){    
    $fields = ["NoRM", "Barcode", "NIK", "Nama", "Sex", "TglLahir", "Telp", "HP", "Alamat"];
    // $fields = ["NoRM", "Barcode","Nama",];
    $delimiter = ";";


    $STR = $this->CreateTxtExcel($this->px(12), $fields, $delimiter, true);
    $namafile = "txtPX.txt";
    $handle = fopen ($namafile, "w"); 
    if (!$handle) {
        $server_output = "Filed Save"; 
    } else {
      fwrite ($handle, $STR);
    } 
    fclose($handle); 
    

    // echo json_encode($result); exit;       
  }
   
  
}
    