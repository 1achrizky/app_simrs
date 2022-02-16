<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftaronline extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->mainlib->logged_in();
	}

	public function upload(){
		$this->load->view('daftaronline/upload');
	}

	public function upload_file(){
	    $status = "";
	    $msg = "";
	    $file_element_name = 'userfile';
	      
	    if (empty($_POST['title'])){
	        $status = "error";
	        $msg = "Please enter a title";
	    }
	      
	    if ($status != "error"){
	        //$config['upload_path'] = './files/';
	        $config['upload_path'] = '../';
	        $config['allowed_types'] = 'gif|jpg|png|doc|txt';
	        $config['max_size'] = 1024 * 8;
	        $config['encrypt_name'] = TRUE;
	  
	        $this->load->library('upload', $config);
	  
	        if (!$this->upload->do_upload($file_element_name)){
	            $status = 'error';
	            $msg = $this->upload->display_errors('', '');
	        }else{
	            $data = $this->upload->data();
	            $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
	            if($file_id){
	                $status = "success";
	                $msg = "File successfully uploaded";
	            }else{
	                unlink($data['full_path']);
	                $status = "error";
	                $msg = "Something went wrong when saving the file, please try again.";
	            }
	        }
	        @unlink($_FILES[$file_element_name]);
	    }
	    echo json_encode(array('status' => $status, 'msg' => $msg));
	}

	public function files(){
		$this->load->model('M_Daftaronline');
	    $files = $this->M_Daftaronline->get_files();
	    $this->load->view('daftaronline/files', array('files' => $files));
	}

	public function upload_js(){
		$whitelist = array('jpg', 'jpeg', 'png', 'gif');
		$name      = null;
		$error     = 'No file uploaded.';

		if (isset($_FILES)) {
			if (isset($_FILES['file'])) {
				$tmp_name = $_FILES['file']['tmp_name'];
				$name     = basename($_FILES['file']['name']);
				$error    = $_FILES['file']['error'];
				
				if ($error === UPLOAD_ERR_OK) {
					$extension = pathinfo($name, PATHINFO_EXTENSION);

					if (!in_array($extension, $whitelist)) {
						$error = 'Invalid file type uploaded.';
					} else {
						move_uploaded_file($tmp_name, $name);
					}
				}
			}
		}

		echo json_encode(array(
			'name'  => $name,
			'error' => $error,
		));
		die();

	}

	public function ajax_upload(){
		if(isset($_FILES["userfile"]["name"])){
			$config['upload_path'] = './upload/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('userfile')){
				echo $this->upload->display_errors();
			}else{
				$data = $this->upload->data();
				echo "<img src='".base_url().'upload/'."'/>";
			}
		}
	}


	
}