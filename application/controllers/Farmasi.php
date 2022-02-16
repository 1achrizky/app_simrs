<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Farmasi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
  }


  public function upload_selisih_obat_kronis_bpjs(){
    
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
            echo "<pre>",print_r($range),"</pre>"; exit;
            
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