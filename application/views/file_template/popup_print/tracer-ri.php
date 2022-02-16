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
				<span class="bold"><?=$NoBill;?></span> 
				<span class="bold" style="margin-left:70px;">RAWAT INAP</span>
			</div>
			<div>
				<span class="bold" style="font-size:18pt;"><?=$NoRM;?></span> 
				<span class="barcode" style="margin-left:90px;">*<?=$NoRM;?>*</span>
			</div>

			<div class="bold" style="font-size:16pt;"><?=$nosep;?></div>
			<div class="bold" ><?=$Nama;?></div>
			
			<div>
				<span class=""><?=$TglLahir;?></span> /
				<span class=""><?=$umur;?> TAHUN</span> /
				<span class=""><?=$Sex;?></span>
			</div>

			<div style="width:250px; text-align:justify;"><?=$Alamat;?></div>

			<hr>
			<div class="bold"><?=rupiah($bed_tarif, 1);?></div>
			<div class="bold"><?=$kelas_ruang;?></div>

			<br><br><br>

			<div><?=$kategori_usia;?></div>
			<div>(<?=$st_px_baru_lama;?>)</div>
			<div class="bold" style="text-align:center;"><?=$penanggung_cm;?></div>
			<hr>
			<div class="barcode" style="text-align:center;"><?=$NoBill;?></div>

			<div>(<?=$user;?>)</div>
			<br>
			
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