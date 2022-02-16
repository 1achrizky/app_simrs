<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");

		$this->load->library('upload');
    }


	function do_upload($dir=null) {
        // setting konfigurasi upload
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['upload_path'] = './uploads/img/'.$dir;
        if($dir!=null){
        	$config['upload_path'] .= '/';
        }

        echo '<pre>',print_r($config),'</pre>'; 
        
        // load library upload
        // $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('gambar')) {
            $error = $this->upload->display_errors();
            // menampilkan pesan error
            print_r($error);
        }else{
            $result = $this->upload->data();
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    // mfikri.com
    function upload_image($dir=null){
        // $config['upload_path'] = './assets/images/'; //path folder
        $config['upload_path'] = './uploads/img/'.$dir;
        if($dir!=null){
        	$config['upload_path'] .= '/';
        }
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name']  = TRUE; //nama yang terupload nantinya
 
        $this->upload->initialize($config);
        if(!empty($_FILES['filefoto']['name'])){
            if ($this->upload->do_upload('filefoto')){
                $gbr 	= $this->upload->data();
                $gambar = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
                $judul 	= strip_tags($this->input->post('judul'));
                $this->m_upload->simpan_upload($judul,$gambar);
                echo "Upload Berhasil";
            }else{
                // echo "Gambar Gagal Upload. Gambar harus bertipe gif|jpg|png|jpeg|bmp";
                $error = $this->upload->display_errors();
                echo $error;
            }
                  
        }else{
            // echo "Gagal, gambar belum di pilih";
            $error = $this->upload->display_errors();
            echo $error;
        }
                 
    }
    
    
    function upload_pdf($dir=null){
        // $config['upload_path'] = './assets/images/'; //path folder
        $config['upload_path'] = './uploads/hrd/pdf/'.$dir;
        if($dir!=null){
        	$config['upload_path'] .= '/';
        }
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        // $config['encrypt_name']  = TRUE; //nama yang terupload nantinya di autoencrypt
 
        $this->upload->initialize($config);
        // echo "<pre>",print_r($config),"</pre>"; exit;

        // if(!empty($_FILES['filefoto']['name'])){
        if(!empty($_FILES['myfile']['name'])){
            if ($this->upload->do_upload('myfile')){
                $gbr 	= $this->upload->data();
                $gambar = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
                $judul 	= strip_tags($this->input->post('judul'));

                $res = [
                    "kirim" => $_FILES['myfile'],
                    "terima" => $gbr,
                ];
                echo "<pre>",print_r($res),"</pre>";

                // $this->m_upload->simpan_upload($judul,$gambar);
                // echo "Upload Berhasil";
            }else{
                // echo "Gambar Gagal Upload. Gambar harus bertipe gif|jpg|png|jpeg|bmp";
                $error = $this->upload->display_errors();
                echo $error;
            }
                  
        }else{
            // echo "Gagal, gambar belum di pilih";
            $error = $this->upload->display_errors();
            echo $error;
        }
                 
    }

    
	public function upload_canvas(){
		$input = $this->input->post(NULL,TRUE);
		// echo "<pre>",print_r($input),"</pre>";
		$img = $input['imgBase64'];
		// $img = str_replace('data:image/png;base64,', '', $img); // GAK BISA
		$img = str_replace('[removed]', '', $img);
		$img = str_replace(' ', '+', $img);
		$fileData = base64_decode($img);
		//saving
		$fileName = $input['filename'].".".$input['format']; // image.png
		file_put_contents($input['location'].$fileName, $fileData);
	}
    

    public function upload_xls($dir=null){
      echo "<pre>",print_r($_FILES),"</pre>"; exit;
      
		    $config['upload_path'] = './uploads/xls/'.$dir;
        if($dir!=null){
        	$config['upload_path'] .= '/';
        }
        $config['allowed_types'] = 'xls|xlsx'; //type yang dapat diakses bisa anda sesuaikan
        // $config['encrypt_name']  = TRUE; //nama yang terupload nantinya di autoencrypt
        
 
        $this->upload->initialize($config);
        // echo "<pre>",print_r($config),"</pre>"; exit;

        // if(!empty($_FILES['filefoto']['name'])){
        if(!empty($_FILES['myfile']['name'])){
          // echo "<pre>",print_r($_FILES),"</pre>"; exit;

            if ($this->upload->do_upload('myfile')){
                $gbr 	= $this->upload->data();
                $gambar = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
                $judul 	= strip_tags($this->input->post('judul'));

                $res = [
                    "kirim" => $_FILES['myfile'],
                    "terima" => $gbr,
                ];
                echo "<pre>",print_r($res),"</pre>";

                // $this->m_upload->simpan_upload($judul,$gambar);
                // echo "Upload Berhasil";
            }else{
                // echo "Gambar Gagal Upload. Gambar harus bertipe gif|jpg|png|jpeg|bmp";
                $error = $this->upload->display_errors();
                echo $error;
            }
                  
        }else{
            // echo "Gagal, gambar belum di pilih";
            $error = $this->upload->display_errors();
            echo $error;
        }
	}
}