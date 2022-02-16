<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('alamat_split')){
	function alamat_split($alamat_rumah){
		//$alamat_rumah = "Jl. Melati, No.196, Ds. Padangan RT.10,RW.04, Kec. Tulangan, Kab. Sidoarjo.";
		//echo strlen($alamat_rumah)."<br>"; //75
		$batas = 40;
		//substr($alamat_rumah, 0,35) ; strlen($alamat_rumah);  $words = explode(" ", $text);
		$cnt_baris = ceil(strlen($alamat_rumah)/$batas);
		//echo $cnt_baris."<br>"; //3

		//$baris = 0;
		$panjang_str_sum = 0;
		$panjang_str[0] = 0;
		for($baris=0; $baris<$cnt_baris; $baris++){
			//$s_x[$baris] = substr($alamat_rumah, 0, 35);
			//$s_x[$baris] = substr($alamat_rumah, $batas*$baris+1, $batas*($baris+1));
			$s_x[$baris] = substr($alamat_rumah, $panjang_str_sum, $panjang_str_sum+$batas);
			$arr_exp_s_x[$baris] = explode(" ", $s_x[$baris]);
			$cnt_exp_s_x[$baris] = count(explode(" ", $s_x[$baris]));

			$arr_exp_s = explode(" ", $alamat_rumah);

			//$index_arr_max[$baris] = 0; //index_arr_max[0]

			$val[$baris] = "";
			if(strlen($arr_exp_s_x[$baris][$cnt_exp_s_x[$baris]-1]) == strlen($arr_exp_s[$cnt_exp_s_x[$baris]-1]) ){
				$val[$baris] =  $s_x[$baris];
				//////////////$index_arr_max[$baris] = $cnt_exp_s_x[$baris]-1;
			}else{
				for($i=0; $i<($cnt_exp_s_x[$baris]-1); $i++){ //menjumlahkan(menyatukan kata) hasil dari EXPLODE S_X dlm baris ke-x
					$val[$baris] = $val[$baris].$arr_exp_s_x[$baris][$i]." ";
					/////////////$index_arr_max[$baris] = $cnt_exp_s_x[$baris]-2;
				}

				//echo $arr_exp_s1_x[2];
			}
			$panjang_str[$baris+1] = strlen($val[$baris]); //panjang string di baris ke-x
			$panjang_str_sum =  $panjang_str_sum + $panjang_str[$baris+1];
		}
			
		
		for($baris=0; $baris<$cnt_baris; $baris++){
			$data[$baris] = array(
					"s_x" => $s_x[$baris], 
					"val" => $val[$baris],
					"panjang_str" => $panjang_str[$baris+1]
				);
		}
		

		//echo "<pre>";
		//echo json_encode($arr_alamat);
		return json_encode($data);
		//echo print_r($data);
		//echo "</pre>";



	}
}

if(!function_exists('alamat')){
	function alamat(){
		$alamat_rumah = "Jl. Melati, No.196, Ds. Padangan RT.10/RW.04, Kec. Tulangan, Kab. Sidoarjo.";
		//substr($alamat_rumah, 0,35) ; strlen($alamat_rumah);  $words = explode(" ", $text);

		$s1_x = substr($alamat_rumah, 0, 35);
		$arr_exp_s1_x = explode(" ", $s1_x);
		$cnt_exp_s1_x = count(explode(" ", $s1_x));

		$arr_exp_s = explode(" ", $alamat_rumah);

		$index_arr_max[0] = 0; //index_arr_max[0]

		$val1 = "";
		if(strlen($arr_exp_s1_x[$cnt_exp_s1_x-1]) == strlen($arr_exp_s[$cnt_exp_s1_x-1]) ){
			$val1 =  $s1_x;
			$index_arr_max[0] = $cnt_exp_s1_x-1;
		}else{
			for($i=0; $i<($cnt_exp_s1_x-1); $i++){
				$val1 = $val1.$arr_exp_s1_x[$i]." ";
				$index_arr_max[0] = $cnt_exp_s1_x-2;
				//echo $val1;
			}
			//echo $arr_exp_s1_x[2];
		}

		//echo "iki=".($cnt_exp_s1_x-1);


		$arr_alamat = array(
				"a1" => $s1_x,
				"cnt_exp_s1_x" => $cnt_exp_s1_x,
				"val1" => $val1,
				"index_arr" => $index_arr_max[0]
			);
		echo json_encode($arr_alamat);
	}
}

if(!function_exists('a')){
	function a(){
		$postdata = array(
			'name' => 'rizky',
			'alamat' => 'kepadangan'
		);

		echo $postdata['name'];
	}
}

if(!function_exists('tes')){
	function tes($iki){
		return "iki:: {$iki}";
	}
}


if(!function_exists('vclaim_ws_post')){
	function vclaim_ws_post($path,$data_post){
		$consid = "16141"; //(cons-id)Ganti dengan consumerID dari BPJS
	  $secretKey = "8uG8E36B37"; //Ganti dengan consumerSecret dari BPJS

	}
}