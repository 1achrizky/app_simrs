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
		.bold{ font-weight:bold; }
		.barcode{
			font-family:'Free 3 of 9';
			font-size: 18pt;
			line-height: 0.9;
		}
		hr{
			margin:0px 0px; 
			width:100%;
			height:2px;
			color:#333;background-color:#333;
		}

	</style>

</head>
<body>
	<div class="container" style="width: 300px; ">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 20px;">
			<div>
				<!-- <img src="<.?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;"> -->
				<!-- <span style="float: right;"><.?=$NoBill;?></span> -->
				<span class="bold"><?=$NoBill;?> / RAWAT JALAN / <?=$st_px_baru_lama;?></span> 
			</div>
			<div>
				<span class="bold" style="font-size:18pt;"><?=$NoRM;?></span>
				<span class="bold" style="margin-left:10px;">Antrian : <?=$no_antrian;?></span>
			</div>

			<!-- <div class="bold" style="font-size:16pt;"><.?=$nosep;?></div> -->
			<div class="bold" ><?=$Nama;?></div>
			
      <div>
				<span class=""><?=$TglLahir;?></span> /
				<span class=""><?=$Sex;?></span> / 
				<span class=""><?=$umur;?> TH</span>
			</div>
			
			<div style="width:250px; text-align:justify;"><?=$Alamat;?></div>

			<br>
			<div><?=$klinik;?></div>
			<div><?=$dokter;?></div>

			<br>
      
      <div>
				<!-- <span class=""><.?=$penanggung_cm;?></span> / -->
				<span class=""><?=date('Y-m-d H:i:s');?></span> / 
				<span class=""><?=$user;?></span>
			</div>

			
			<div class="barcode"><?=$NoBill;?></div>
			<div style="width:250px; text-align:justify;">Ket: <?=$ket;?></div>

			<br>

      <?php
      // $text = $penanggung_cm;
		
      // if($text == "" || $text == "-"){
      //   $text = "UMUM";
      // }
      
		
      if($penanggung_cm == "" || $penanggung_cm == "-"){
        $penanggung_cm = "UMUM";
      }
      
      ?>
      <span style="text-align:center; font-size:18pt;"><?=$penanggung_cm;?></span>
			
			<?php exit;?>
			

		</div>
		
	</div>
		
	

	
	
	<script src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?=base_url();?>assets/plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
  	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery.xdomainrequest.min.js"></script>
  	<script type='text/javascript' src="<?=base_url();?>assets/js/moment-with-locales.js"></script>
	
	<!-- UNTUK MODAL -->
	<script src="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/js/bootstrap.min.js"></script>



</body>
</html>