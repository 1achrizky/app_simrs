<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pendaftaran Mandiri RS Citra Medika</title>

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<!-- <link rel="stylesheet" href="<>?=base_url();?>assets/css/style.css" type="text/css">  -->
	
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/site.css" type="text/css">
	<style type="text/css">
		@media print and (width: 21cm) and (height: 15cm) {
			@page {
			  margin: 3cm;
			}
		}


	</style>


</head>
<body>
	<div class="container font_cetak" name="main">
		<div style="height:30px;"></div>
		<div id="kertas_resume" class="row form-group ft_normal">
			<div class="col-xs-6">
				<input class="form-control" type="text" name="nosep_cari" placeholder="nomor sep ...">
			</div>

			<div class="col-xs-6">
				<!-- <button class="btn btn-primary" name="btn_sep_cari" >Cari SEP</button> -->
				<button class="btn btn-primary" name="btn_sep_resume_cetak" >Cetak SEP & Resume</button>
				<button class="btn btn-primary" name="btn_sep_cetak" >Cetak SEP</button>
				<button class="btn btn-primary" name="btn_cetak_bukti_daftar" >Cetak Bukti Daftar</button>
				<button class="btn btn-primary" name="btn_cetak_nomor_antrian" >Cetak Nomor Antrian</button>
				<button class="btn btn-primary" name="btn_cetak_tracer" >Cetak Tracer</button>
			</div>

			<div style="clear:left; padding-top: 20px;">
				<span>Pilih Printer :</span> 
				<?php
			        //////$getprt = printer_list(PRINTER_ENUM_LOCAL);
			        //$getprt = printer_list(PRINTER_ENUM_SHARED);
			        $getprt = printer_list(PRINTER_ENUM_CONNECTIONS);
			        $printers = serialize($getprt);
			        $printers = unserialize($printers);
			        //Menampilkan List Printer
			        echo '<select name="printers" id="printer">';
			        foreach ($printers as $PrintDest)
			            //echo "<option value='" . $PrintDest["NAME"] . "'>" . explode(",", $PrintDest["DESCRIPTION"])[1] . "</option>";
			            echo "<option value='" .$PrintDest["NAME"]. "'>" .$PrintDest["NAME"]. "</option>";
			        echo '</select>';
		        ?>
		        <br>
			</div>

			
		</div>

		<hr class="hr_potong_kertas">

		<div id="div_frame"></div>
		
		<div id="div_tes_print_plugin">
			<p>CETAK PRINT YA</p>
			<p>OKE</p>
		</div>
		<button class="btn btn-primary" name="klik" >KLIK</button>

		<div style="clear:left; height:20px;"></div>

				<?php
		$nama_lengkap = "Haji Oemar Said Cokroaminoto";
		$nama_lengkap1 = "Abdul Haris Nasution";
		$nama_lengkap2 = "Abu Bakar Assidiq";

		echo $nama_lengkap."<br>";

		$arr = explode(" ", $nama_lengkap);
		echo $arr[1]." ".count($arr)."<br>";
		echo (strlen($arr[0])+strlen($arr[1]));
		?>
	</div>

		
	
	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/bootstrap.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
  <script type='text/javascript' src="<?=base_url();?>assets/js/jquery.xdomainrequest.min.js"></script>
  <script type='text/javascript' src="<?=base_url();?>assets/js/moment-with-locales.js"></script>  
  <script type='text/javascript' src="<?=base_url();?>assets/js/jQuery.print.js"></script>
	
	<!-- UNTUK MODAL -->
	<script src="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/js/bootstrap.min.js"></script>

 	<script type='text/javascript' src="<?=base_url();?>assets/js/library.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/site.js"></script>
	
 

	<script>
	$(function(event){
		$('button[name=klik]').click(function(){
			alert('okey klik');
			//$('#div_tes_print_plugin').print();
			$.print('#div_tes_print_plugin');
		});
			
		console.log('status:: '+get_status_kartu_aktif_by_norujukan('1320U0660518Y000128'));
		console.log('tglKunjungan:: '+get_tglKunjungan_by_norujukan('1320U0660518Y000128'));
		console.log('hitungBulanRujukan:: '+get_hitungBulanRujukan_by_norujukan('1320U0660518Y000128'));

    //window.print();
    //window.location = "<.?=base_url();?>vclaim/tes_cetak";


	});

	</script>





</body>
</html>