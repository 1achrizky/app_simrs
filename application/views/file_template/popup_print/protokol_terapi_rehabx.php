<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Rekening Pasien Rawat Inap</title>

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css">
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">

	<style type="text/css">
		/*  click & scroll*/
		* {
			-webkit-user-select: none;
			-moz-user-select: moz-none;
			-ms-user-select: none;
			user-select: none;
		}
		/* \click & scroll*/

		html, body { height: 100%; margin: 0; background: #FFFFFF; font-family: 'tahoma';}

		hr{
			margin :3px auto;
		}

		.bold{ font-weight: bold; }

		.div_center{ margin:0px auto; }

		.container{
			/*font-weight: bold;*/
			height: 100vh;
			width: 800px;
			/*background:#eaeaea;*/
			margin:0px auto;
		}

		.ft_normal{ font-weight: normal; }

		.ft_title{
			font-weight: bold;
			font-size: 12pt;
		}

		.rscm_logo{
			width: 150px;
		}


		.borderless td, .borderless th {
		    border: none;
		}

		.text-center{ text-align: center; }

		.text-right{ text-align: right;	}

		.p-l-tbl-list{ padding-left: 10px; }

		.ft-10, td, th, span{
			font-size: 10pt;
			font-family: 'tahoma';
		}




		/* =================\[LOAD: MODAL>>KLINIK] ====================== */
		.va-top{
			vertical-align: top;
		}

		.tbl_px tr td:nth-child(1), 
		.tbl_px tr td:nth-child(3){
			font-weight: bold;
			text-align: right;
			width:15%;
		}

		.tbl_px tr td:nth-child(2){
			width:40%;
			padding-left: 5px;
		}

		.tbl_px tr td:nth-child(4){
			width:30%;
			padding-left: 5px;
		}


	</style>

</head>
<body class="ft-10">
<div class="container" style="width: 800px; " name="main">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 5px;">
			<div>
				<img src="<?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;">
				<!-- <span style="float: right;"><.?=$NoBill;?></span> -->
				<div class="bold" style="text-align:center; font-size: 14pt;margin-top:20px;">
					ASESMEN DAN PROTOKOL TERAPI REHAB MEDIK</div> 
			</div>
			<div>
					<br>
					<!-- <table id="tbl_bio" style="width:100%;" class="table borderless">
							<tr><td>Nomor RM</td><td>: <.?=$rehab['bio']['NoRM'];?></td></tr>
							<tr><td>Nama</td><td>: <.?=$rehab['bio']['Nama'];?></td></tr>
							<tr><td>Tanggal Lahir</td><td>: <.?=$rehab['bio']['TglLahir'];?></td></tr>
							<tr><td>Jenis Kelamin</td><td>: <.?=$rehab['bio']['Sex'];?></td></tr>
							<tr><td>Alamat</td><td>: <.?=$rehab['bio']['Alamat'];?></td></tr>
					</table> -->
					
					<table id="tbl_bio" class="table borderless" style="width:100%;">
							<tr><td>Nomor RM</td><td>: <?=$rehab['bio']['NoRM'];?></td></tr>
							<tr><td>Nama</td><td>: <?=$rehab['bio']['Nama'];?></td></tr>
							<tr><td>Tanggal Lahir</td><td>: <?=$rehab['bio']['TglLahir'];?></td></tr>
							<tr><td>Jenis Kelamin</td><td>: <?=$rehab['bio']['Sex'];?></td></tr>
							<tr><td>Alamat</td><td>: <?=$rehab['bio']['Alamat'];?></td></tr>
					</table>
					
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




					
					
					<!-- <br>
					<table id="tbl_asesmen" style="width:100%;" class="table borderless">
						<tr><td>Diagnosa Primer</td><td>: <.?=$rehab['asesmen']['dxPrimer'];?></td></tr>
						<tr><td>Diagnosa Sekunder</td><td>: <.?=$rehab['asesmen']['dxSekunder'];?></td></tr>
					</table> -->
					
					<br>
					<!-- <table id="tbl_detail_paket" style="width:100%;" class="table table-bordered"> -->
					<table id="tbl_detail_paket" style="width:100%;" class="table-bordered">
						<thead>
							<tr>
								<th>No.</th><th>No.Billing</th><th>Protokol Terapi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								
								for ($i=0; $i < count($rehab['detail_paket']); $i++) { 
									echo 
									'<tr>'.
										'<td>'.($i+1).'</td>'.
										'<td>'.$rehab['detail_paket'][$i]['nobill'].'</td>'.
										// '<td style="padding-left:10px;">&emsp;'.$rehab['detail_paket'][$i]['nobill'].'</td>'.
										'<td>'.$rehab['detail_paket'][$i]['detail_tx'].'</td>'.
									'<tr>';
								}
							?>
						
						</tbody>
					</table>
      </div>
			<!-- <.?="<pre>",print_r($rehab),"</pre>";?> -->
      
      <div style="margin-top:20px;">
				Dokter yang membuat
				<br><br>
				TTD
				<br><br>
				(<?=$rehab['asesmen']['namadokter'];?>)
			</div>
      
			<div style="text-align:right;">
				<br>
				<span class="">Dicetak pada: <?=date('H:i:s d-m-Y');?></span>
				<span class=""><?//=$user;?></span>
			</div>

			
			

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

<?php
// echo "<div style='clear:both;'></div>";
// echo "<pre>",print_r($list),"</pre>";
?>