<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akuntansi extends CI_Controller {
	protected $public_ip = '';

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
  }

  public function read_xls(){
    $filename = 'RAWAT JALAN.xls';
    $fullName = FCPATH.'assets\upload\bpjs_verif\FEB 2020\\'.$filename;
        
    $this->load->library('my_excel');
    $objPHPExcel = $this->my_excel->load('Excel5', $fullName );

    $worksheet = $objPHPExcel->setActiveSheetIndex(0);
    $highestRow = $worksheet->getHighestRow();
    $highestCol = $worksheet->getHighestColumn();
    // print_r($worksheet->rangeToArray("A4:$highestCol$highestRow", null, true, false, false));
    
    $range = $worksheet->rangeToArray("A1:$highestCol$highestRow", null, true, false, false);
    echo "<pre>",print_r($range),"</pre>"; exit;
  }




  public function cek_upload_verif_bpjs(){
    $allowedFileType = [
      'application/vnd.ms-excel',
      'text/xls',
      'text/xlsx',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

  // print_r($_FILES); exit;
    if (in_array($_FILES["myfile"]["type"], $allowedFileType)) {
      // print_r($_FILES); exit;

      // $targetPath = 'uploads/' . $_FILES['myfile']['name'];
      
      $targetPath = FCPATH.'assets\upload\xls\\' . $_FILES['myfile']['name'];
      
      move_uploaded_file($_FILES['myfile']['tmp_name'], $targetPath); // INI UPLOAD FILE KE DIR
                      
      $this->load->library('my_excel');
      $objPHPExcel = $this->my_excel->load('Excel5', $targetPath );

      $worksheet = $objPHPExcel->setActiveSheetIndex(0);
      $highestRow = $worksheet->getHighestRow();
      $highestCol = $worksheet->getHighestColumn();
      // print_r($worksheet->rangeToArray("A4:$highestCol$highestRow", null, true, false, false));
      
      $range = $worksheet->rangeToArray("A1:$highestCol$highestRow", null, true, false, false); // rupiah tanpa koma
      echo json_encode($range[0]);
      unlink($targetPath); // HAPUS FILE
    }
      // $post = $this->input->post(null, true);

  }


  public function upload_verif_bpjs(){
    
    // require_once dirname(__FILE__) . '/PHPExcel/PHPExcel.php';
    // echo dirname(__FILE__);
    // exit;

    // use Phppot\DataSource;
    // use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    // require_once 'DataSource.php';
    // $db = new DataSource();
    // $conn = $db->getConnection();
    // require_once ('./vendor/autoload.php');


    // echo "yes".$_POST["import"]; exit;
    // if (isset($_POST["import"])) {
      
        $allowedFileType = [
            'application/vnd.ms-excel',
            'text/xls',
            'text/xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        // print_r($_FILES); exit;
        if (in_array($_FILES["myfile"]["type"], $allowedFileType)) {
            // print_r($_FILES); exit;

            // $targetPath = 'uploads/' . $_FILES['myfile']['name'];
            
            $targetPath = FCPATH.'assets\upload\xls\\' . $_FILES['myfile']['name'];
            
            move_uploaded_file($_FILES['myfile']['tmp_name'], $targetPath); // INI UPLOAD FILE KE DIR
                            
            $this->load->library('my_excel');
            $objPHPExcel = $this->my_excel->load('Excel5', $targetPath );

            $worksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $worksheet->getHighestRow();
            $highestCol = $worksheet->getHighestColumn();
            // print_r($worksheet->rangeToArray("A4:$highestCol$highestRow", null, true, false, false));
            
            $range = $worksheet->rangeToArray("A1:$highestCol$highestRow", null, true, false, false); // rupiah tanpa koma
            
            
            $post = $this->input->post(null, true);

            $explo_date = explode("-", $post['date_bln']);
            $tahun = $explo_date[0];
            $bulan = (int) $explo_date[1];

            $username = $this->session->userdata("username");
            $datenow = date('Y-m-d');

            


            $this->load->model(['m_main', 'm_akuntansi']);
            $cnt = $this->m_akuntansi->count_verif_inacbg($tahun, $bulan);

            // echo "<pre>",print_r( [$post, $tahun, $bulan, $username, $datenow, $cnt] ),"</pre>"; 
            // echo "<pre>",print_r($range),"</pre>"; exit;

            if($cnt==0){
              for ($i=1; $i < count($range); $i++) { 
                if($range[$i][0] != '' && $range[$i][0] != null){
                  $val = [
                    'Nobill'=> $range[$i][0],
                    'Bulan' => $bulan,
                    'Tahun' => $tahun,
                    'NoRM'  => $range[$i][1],
                    'Nama'  => $range[$i][2],
                    'Inacbg'=> $range[$i][3],
                    'Status'=> $post['rjri'],
                  ];
                  $this->m_main->insert('fotrinacbgx', $val);
                }
                  
              }

              $res = [
                "status" => "success",
                "message"=> "Sukses entry data.",
              ];

              // BISA
              unlink($targetPath); // HAPUS FILE
              // header('Location: '.base_url().'bo/menu/akuntansi/upload-verif-bpjs');            
              // exit;
              
            }else{
              $res = [
                "status" => "failed",
                "message"=> "Sudah pernah entry data.",
              ];
            }

            
              
            
            
            // // $excelSheet = $objPHPExcel->getActiveSheet();
            // $spreadSheetAry = $worksheet->toArray(); // // rupiah dengan koma
            // echo "<pre>",print_r($spreadSheetAry),"</pre>"; 
                        

            



    //         $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    //         $spreadSheet = $Reader->load($targetPath);
    //         $excelSheet = $spreadSheet->getActiveSheet();
    //         $spreadSheetAry = $excelSheet->toArray();
    //         $sheetCount = count($spreadSheetAry);

    //         for ($i = 0; $i <= $sheetCount; $i ++) {
    //             $name = "";
    //             if (isset($spreadSheetAry[$i][0])) {
    //                 $name = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
    //             }
    //             $description = "";
    //             if (isset($spreadSheetAry[$i][1])) {
    //                 $description = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
    //             }

    //             if (! empty($name) || ! empty($description)) {
    //                 $query = "insert into tbl_info(name,description) values(?,?)";
    //                 $paramType = "ss";
    //                 $paramArray = [ $name, $description ];
    //                 $insertId = $db->insert($query, $paramType, $paramArray);
    //                 // $query = "insert into tbl_info(name,description) values('" . $name . "','" . $description . "')";
    //                 // $result = mysqli_query($conn, $query);

    //                 if (! empty($insertId)) {
    //                     $type = "success";
    //                     $message = "Excel Data Imported into the Database";
    //                 } else {
    //                     $type = "error";
    //                     $message = "Problem in Importing Excel Data";
    //                 }
    //             }
    //         }
        } else {
            $res = [
              "status" => "failed",
              "message"=> "Invalid File Type. Upload Excel File.",
            ];
        }

        echo json_encode($res);

    // } // $_POST['import]
  }

}