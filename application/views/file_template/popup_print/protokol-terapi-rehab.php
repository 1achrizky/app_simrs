<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Asesmen Rehab Medis</title>

	<!-- <link rel="stylesheet" href="<.?=base_url();?>assets/css/dataTables.bootstrap.min.css"> -->
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css"> 
	
	<!-- <link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css"> -->
	<style type="text/css">
	/* MY BOOTSTRAP */
	*{
		/* font-family:"Tahoma" !important; */
		box-sizing: border-box;
	}
	
	body{
		font-family: Tahoma; 
		 /* Tahoma, Calibri,"Helvetica Neue",Helvetica,Arial,sans-serif; */
		box-sizing: border-box;
	}

	.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
	}
	
	table{
		/* margin:0px auto; */
		font-size:12px !important;
		/* style="border:1px solid black;" */
		
	}

	
	table tr td,
	table tr th
	{
		padding:4px;
		/* border: 1px solid #ddd !important; /* INI BISA BIKIN BORDER ABU-ABU*\/ */
	}

	.table-bordered{
		border: 1px solid #ddd;
		border-collapse: collapse;
	}

	.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, 
	.table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, 
	.table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
		border: 1px solid #ddd !important;
		border-width:thin;
	}

	.table>tbody>tr>td, .table>tbody>tr>th, 
	.table>tfoot>tr>td, .table>tfoot>tr>th, 
	.table>thead>tr>td, .table>thead>tr>th
	{
		
    padding: 6px;
    line-height: 1.42857143;
    vertical-align: top;
    /* border-top: 1px solid #ddd; */
    border: 1px solid #ddd !important;
	}
	
	

	:after, :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
	}

	td {
    display: table-cell;
    vertical-align: inherit;
}
	</style>



	<style type="text/css">
	.bold{font-weight:bold;}

	.tbl_bio tr td:nth-child(1){
		width:150px;
	}
	
	.tbl_bio tr td,
	#tbl_asesmen tr td,
	#tbl_detail_paket tr td
	{
		padding:0px 5px;
	}
	
	#tbl_asesmen tr td:nth-child(1){
		width:220px;
		font-weight:bold;
	}
	#tbl_detail_paket thead tr th,
	#tbl_detail_paket tbody tr td:nth-child(1),
	#tbl_detail_paket tbody tr td:nth-child(2)	
	{ text-align:center; }
	
	#tbl_detail_paket tbody tr td:nth-child(1)
	{ width:40px; }
	#tbl_detail_paket tbody tr td:nth-child(2)
	{ width:180px; }

	/* #tbl_detail_paket tbody tr td:nth-child(3){ */
	#tbl_detail_paket tbody tr td:nth-child(4){
		padding-left:20px;
	}
	
	#tbl_detail_paket tr td:nth-child(1){
		width:20px;
	}
	#tbl_detail_paket tr td:nth-child(2){
		width:200px;
	}
	
	#tbl_detail_paket tr td:nth-child(3){
		width:120px; 
		text-align:center;
	}

	.borderless td, .borderless th, 
	.borderless tr td{
    border: none!important;
	}
	</style>
	
	
	


</head>
<body>

	
	
	<div class="container" style="width: 800px; ">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 5px;">
			<div>
				<img src="./assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;">

				<!-- <span style="float: right;"><.?=$NoBill;?></span> -->
				<div class="bold" style="text-align:center; font-size: 14pt;margin-top:20px;">
					ASESMEN DAN PROTOKOL TERAPI REHAB MEDIK</div> 
			</div>
			<div>
					<br>
										
					<!-- <table id="tbl_bio" class="table borderless" style="width:100%;"> -->
					<table class="tbl_bio" style="width:100%;">
							<tr><td>Nomor RM</td><td>: <?=$rehab['bio']['NoRM'].' / '.$rehab['bio']['noka'];?></td></tr>
							<tr><td>Nama</td><td>: <?=$rehab['bio']['Nama'];?></td></tr>
							<tr><td>Tanggal Lahir</td><td>: <?=date('d-m-Y', strtotime($rehab['bio']['TglLahir']) );?></td></tr>
							<tr><td>Jenis Kelamin</td><td>: <?=$rehab['bio']['Sex'];?></td></tr>
							<tr><td>Alamat</td><td>: <?=$rehab['bio']['Alamat'];?></td></tr>
							<tr><td>Rujukan dari Dokter</td><td>: <?=$rehab['asesmen']['namadokterperujuk'];?></td></tr>
							<tr><td>Tanggal Rujukan</td><td>: <?=($rehab['asesmen']['tglRujukan']=='')?'': date('d-m-Y', strtotime($rehab['asesmen']['tglRujukan']) );?></td></tr>
					</table>
					<br>
					
					<!-- <table id="tbl_asesmen" style="width:100%;" class="table table-bordered"> -->
					<table border=1 id="tbl_asesmen" style="width:100%;" class="table table-bordered">
						<tr><td>Tanggal Pelayanan</td><td><?=($rehab['asesmen']['tglPelayanan']=='')?'': date('d-m-Y', strtotime($rehab['asesmen']['tglPelayanan']) );?></td></tr>
						<tr><td>Anamnesa</td><td><?=$rehab['asesmen']['anamnesa'];?></td></tr>
						<tr><td>Pemeriksaan Fisik dan Uji Fungsi</td><td><?=$rehab['asesmen']['fisik'];?></td></tr>
						<tr><td>Pemeriksaan Penunjang</td><td><?=$rehab['asesmen']['penunjang'];?></td></tr>
						<tr><td>Diagnosa Primer</td><td><?=$rehab['asesmen']['dxPrimer'];?></td></tr>
						<tr><td>Diagnosa Sekunder</td><td><?=$rehab['asesmen']['dxSekunder'];?></td></tr>
						<tr><td>Tindakan / Tatalaksana KFR</td><td><?=$rehab['asesmen']['tatalaksanaKFR'];?></td></tr>
						<tr><td>Anjuran</td><td><?=$rehab['asesmen']['anjuran'];?></td></tr>
						<tr><td>Frekuensi Tindakan</td><td><?=$rehab['asesmen']['frekuensi'];?></td></tr>
						<tr><td>Lama 1 siklus asesmen</td><td><?=$rehab['asesmen']['siklus'];?></td></tr>
						<tr><td>Goal OF Treatment</td><td><?=$rehab['asesmen']['goal'];?></td></tr>
					</table>

					
					<br>
					<!-- <table id="tbl_detail_paket" style="width:100%;" class="table table-bordered"> -->
					<table border=1 id="tbl_detail_paket" style="width:100%;" class="table table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<!-- <th>No.Billing</th> -->
								<th>SEP</th>
								<th>Tanggal Masuk</th>
								<th>Protokol Terapi</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php
								
								for ($i=0; $i < count($rehab['detail_paket']); $i++) { 
									echo 
									'<tr>'.
										'<td>'.($i+1).'</td>'.
										// '<td>'.$rehab['detail_paket'][$i]['nobill'].'</td>'.
										'<td>'.$rehab['detail_paket'][$i]['nosep'].'</td>'.
										'<td>'.date('d-m-Y', strtotime($rehab['detail_paket'][$i]['TanggalMasuk']) ).'</td>'.
										// '<td style="padding-left:10px;">&emsp;'.$rehab['detail_paket'][$i]['nobill'].'</td>'.
										'<td>'.$rehab['detail_paket'][$i]['detail_tx'].'</td>'.
										'<td>'.$rehab['detail_paket'][$i]['ket'].'</td>'.
									'<tr>';
								}
							?>
						
						</tbody>
					</table>

					<br>
					<table border=0 class="tbl_bio" style="width:100%;">
						<tr><td colspan=2>Achievement of goal (Diisi setelah 1 siklus asesmen selesai dilaksanakan)</td></tr>
						<tr><td>Tanggal</td><td>: 
							<!-- <.?=date('d-m-Y', strtotime($rehab['asesmen']['goalTgl']) );?> -->
							<?=($rehab['asesmen']['goalTgl']=='')?'': date('d-m-Y', strtotime($rehab['asesmen']['goalTgl']) );?>
							</td></tr>
						<tr><td>Hasil</td><td>: <?=$rehab['asesmen']['goalHasil'];?></td></tr>
					</table>
					
					<br>
					<table border=0 class="tbl_bio" style="width:100%;" class="">
						<tr><td colspan=2>Rencana tindak lanjut pasien :</td></tr>
						<tr>
							<td>
							<input type="checkbox" name="tindak1" class="cbox_tindakLanjut" value="0" <?=$rehab['asesmen']['checked_tindak1'];?> /> 
							Pasien memerlukan tambahan siklus terapi / asesmen baru
							</td>
						</tr>
						<tr>
							<td>
							<input type="checkbox" name="tindak2" class="cbox_tindakLanjut" value="0" <?=$rehab['asesmen']['checked_tindak2'];?> />
							Pasien kontrol kembali ke DPJP perujuk</td>
						</tr>
						<tr>
							<td>
							<input type="checkbox" name="tindak3" class="cbox_tindakLanjut" value="0" <?=$rehab['asesmen']['checked_tindak3'];?> />
							Pasien selesai terapi tidak perlu control kembali ke DPJP perujuk</td>
						</tr>
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
      
			<!-- <div style="text-align:right;">
				<br>
				<span class="">Dicetak pada: <.?=date('H:i:s d-m-Y');?></span>
			</div> -->

						

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