<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eclaim extends CI_Controller {
  // protected $public_ip = '';
  
  // protected $config_bpjs = [
  //   "consid" => "16141",
  // ];

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");

  }

  public function gen(){
    $this->load->library('ws_eclaim');
    $s = $this->ws_eclaim->generate_claim_number();
    // echo json_encode($s);
    $send = json_encode($s);
    $val = $this->ws_eclaim->ws("POST", $send);
		echo $val;
  }

  public function ajax_eclaim( $name = null, $param=null){
		
      $js[] = null;
      switch($name){
        case "json": //send use script json
            $input = $this->input->post(NULL, TRUE);
            $js = $input;
            // echo json_encode($js); exit;
          break;
          
        case "grouper": //5
            // param: $_POST[nomor_sep]
            $js = [
                "metadata" => [
                  "method" => "grouper",
                  "stage"	 => "1"
                ],
                "data"  => [
                  "nomor_sep" => $param,
                ]
              ];
          break;
    
                
        case "pull_claim": //11
            $input = $this->input->get(NULL, TRUE);
            $js = [
                "metadata" => [
                  "method" => "pull_claim"
                ],
                "data" => [
                  "start_dt"    => $input['start_dt'],
                  "stop_dt"     => $input['stop_dt'],
                  "jenis_rawat" => "1"
                ]                
              ];
          break;
        
        
        case "get_claim_data": //12
            $js = [
                "metadata" => [
                  "method" => "get_claim_data"
                ],
                "data" => [
                  "nomor_sep" => $param,
                ]                
              ];
          break;
        
        
        case "search_diagnosis": //16
            $js = [
                "metadata" => [
                  "method" => "search_diagnosis"
                ],
                "data" => [
                  "keyword" => $param
                ],
              ];
          break;

        case "search_procedures": //17
            $js = array(
              "metadata" => array(
                "method" => $name,
              ),
              "data" => array(
                "keyword" => $param,
              )
            );
					break;
        
        case "search_procedures_inagrouper": //17
            $js = array(
              "metadata" => array(
                "method" => $name,
              ),
              "data" => array(
                "keyword" => $param,
              )
            );
					break;
        
        case "file_get": //17
            $js = [
              "metadata"=> [
                "method"=> "file_get"
              ],
              "data"=> [
                "nomor_sep"=> $param,
              ]
            ];
					break;
        
        case "claim_print": //15 : Cetak klaim
            $js = [
              "metadata"=> [
                "method"=> $name,
              ],
              "data"=> [
                "nomor_sep"=> $param, // $_GET['nomor_sep']
              ]
            ];

            $send = json_encode($js);
            // echo $send; exit;
            $val = $this->ws_eclaim->ws("POST", $send, 1);

            $response = $val;
            // hasil decrypt adalah format json, ditranslate kedalam array
            $msg = json_decode($response,true);
            // echo "<pre>",print_r($msg),"</pre>"; exit;
            
            
            // variable data adalah base64 dari file pdf
            $pdf = base64_decode($msg["data"]);
            // echo "<pre>",print_r($pdf),"</pre>"; exit;
            // hasilnya adalah berupa binary string $pdf, untuk disimpan:
            file_put_contents("klaim.pdf",$pdf);

            
            // atau untuk ditampilkan dengan perintah:
            header("Content-type:application/pdf");
            //header("Content-Disposition:attachment;filename='klaim.pdf'");
            // header("Content-Disposition:attachment;filename=klaim-".$_GET[nomor_sep]."-".$_GET[nobill].".pdf");
            header("Content-Disposition:attachment;filename=klaim-".$param."-".$_GET['nobill'].".pdf");
            echo $pdf;
  
            exit;
      
					break;
        
          
      }
      
      $send = json_encode($js);
      $val = $this->ws_eclaim->ws("POST", $send);
			// return $val;
			echo $val;
  
  }


  public function cek_upload_pdf_eclaim(){
    $post = $this->input->post(NULL, TRUE);
    $allowedFileType = [
      'application/pdf',
      // 'text/xls',
      // 'text/xlsx',
      // 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    // echo json_encode([$_FILES, $post]); exit;
    // echo "<pre>",print_r($_FILES),"</pre>"; exit;

    // $fname = ['f_resume_medis', 'f_ruang_rawat', 'f_laboratorium'];

      if (in_array($_FILES[$post['inputName']]["type"], $allowedFileType)) {
        $pdf_file = file_get_contents($_FILES[$post['inputName']]["tmp_name"]);
        // $_FILES["data"] = $pdf_file;
        $_FILES[$post['inputName']]["pdf_str"] = base64_encode($pdf_file);
        // echo "<pre>",print_r($_FILES),"</pre>"; exit;

        $post_eclaim = [
          "metadata"  => [
            "method"  => "file_upload",
            "nomor_sep" => $post['nosep'],
            "file_class"=> substr($post['inputName'], 2), // menghilangkan 'f_' // "resume_medis",
            "file_name" => $_FILES[$post['inputName']]["name"],
          ],
          "data" => $_FILES[$post['inputName']]["pdf_str"],
        ];
        // echo "<pre>",print_r($post_eclaim),"</pre>"; exit;
        // echo json_encode($post_eclaim); exit;

        $this->load->library('ws_eclaim');
        // $s = $this->ws_eclaim->generate_claim_number();
        // // echo json_encode($s);
        // $send = json_encode($s);

        $menit = 2;
        $settime = 60*$menit;
        set_time_limit($settime);
        $val = $this->ws_eclaim->ws("POST", json_encode($post_eclaim));
        echo $val; exit;

        //=======
        // $_FILES["data"] = file_get_contents($_FILES["myfile"]["tmp_name"]);
        // exit;

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

  }
}