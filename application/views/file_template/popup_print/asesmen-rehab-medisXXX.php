<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Asesmen Rehab Medis</title>

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<!-- <link rel="stylesheet" href="<>?=base_url();?>assets/css/style.css" type="text/css">  -->
	
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/site.css" type="text/css">
	
	<style type="text/css">
	.bold{font-weight:bold;}
	#tbl_bio tr td:nth-child(1){
		width:100px;
	}
	
	#tbl_asesmen tr td:nth-child(1){
		width:220px;
		font-weight:bold;
	}

	.borderless td, .borderless th {
    border: none !important;
	}
	</style>

</head>
<body>

	
	
	<div class="container" style="width: 800px; ">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 20px;">
			<div>
				<img src="<?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;">
				<!-- <span style="float: right;"><.?=$NoBill;?></span> -->
				<div class="bold" style="text-align:center; font-size: 14pt;">ASESMEN REHAB MEDIS</div> 
			</div>
			<div>
					<br>
					<table id="tbl_bio" class="table borderless" style="width:100%;">
							<tr><td>Nomor RM</td><td>: <?=$rehab['bio']['NoRM'];?></td></tr>
							<tr><td>Nama</td><td>: <?=$rehab['bio']['Nama'];?></td></tr>
							<tr><td>Tanggal Lahir</td><td>: <?=$rehab['bio']['TglLahir'];?></td></tr>
							<tr><td>Jenis Kelamin</td><td>: <?=$rehab['bio']['Sex'];?></td></tr>
							<tr><td>Alamat</td><td>: <?=$rehab['bio']['Alamat'];?></td></tr>
					</table>
					
					<br>
					<table id="tbl_asesmen" style="width:100%;" class="table table-bordered">
						<tr><td>Tanggal Pelayanan</td><td><?=$rehab['asesmen']['tglPelayanan'];?></td></tr>
						<tr><td>Anamnesa</td><td><?=$rehab['asesmen']['anamnesa'];?></td></tr>
						<tr><td>Pemeriksaan Fisik dan Uji Fungsi</td><td><?=$rehab['asesmen']['fisik'];?></td></tr>
						<tr><td>Pemeriksaan Penunjang</td><td><?=$rehab['asesmen']['penunjang'];?></td></tr>
						<tr><td>Diagnosa Primer</td><td><?=$rehab['asesmen']['dxPrimer'];?></td></tr>
						<tr><td>Diagnosa Sekunder</td><td><?=$rehab['asesmen']['dxSekunder'];?></td></tr>
						<tr><td>Tatalaksana KFR</td><td><?=$rehab['asesmen']['tatalaksanaKFR'];?></td></tr>
						<tr><td>Anjuran</td><td><?=$rehab['asesmen']['anjuran'];?></td></tr>
					</table>
      </div>
			<!-- <.?="<pre>",print_r($rehab),"</pre>";?> -->
      
      <div>
				<span class="">Dicetak pada: <?=date('H:i:s d-m-Y');?></span>
				<span class=""><?//=$user;?></span>
			</div>

			
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