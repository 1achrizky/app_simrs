<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Surat Keterangan</title>

	<!-- <link rel="stylesheet" href="<.?=base_url();?>assets/css/dataTables.bootstrap.min.css"> -->
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css"> 
	
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
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
		font-size:13.3px !important;
		/* style="border:1px solid black;" */
		
	}

	/*
	table tr td,
	table tr th
	{
		padding:4px;
		/* border: 1px solid #ddd !important; /* INI BISA BIKIN BORDER ABU-ABU*\/ *\/
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
}*/
	</style>



	<style type="text/css">
	.bold{font-weight:bold;}
	#tbl_bio tr td:nth-child(1){
		width:250px;
	}
	
	
	/* .borderless td, .borderless th {
    border: none !important;
	} */



/*NEW*/ 
	.bgLabel{
    /* background-color:#b8eeff!important; */
    background-color:#d1d1d1 !important;
  }
  
  .bgLabel>td:nth-child(1){
    font-weight:bold;
  }
	</style>
	
	
	


</head>
<body>

	
	
	<div class="container" style="width: 700px; ">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 5px;">
			<div>
				<!-- <img src="./assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;"> -->
				<img src="<?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:180px;">

				<!-- <span style="float: right;"><.?=$NoBill;?></span> -->
				<div class="bold" style="text-align:center; font-size: 14pt;margin-top:40px;">
					SURAT KETERANGAN</div> 
				<div class="" style="text-align:center; font-size: 12pt;">
					Nomor: <?=$surat['kodeSurat'];?></div> 
					<br><br>
			</div>
			<div>
					
					<!-- <table id="tbl_bio" class="table borderless" style="width:100%;"> -->
					<table id="tbl_bio" class="table table-bordered" style="text-align:justify;">
						<tr>
							<td colspan=2>
							Yang bertanda tangan di bawah ini, Dokter Rumah Sakit Citra Medika Sidoarjo menerangkan bahwa:
							</td>
						</tr>
						
						<tr><td>Nama</td><td> <?=$surat['nama'];?></td></tr>
						<tr><td>Jenis Kelamin</td><td> <?=$surat['jeniskelamin_str'];?></td></tr>
						<tr><td>Usia</td><td> <?=$surat['umur'];?> TH</td></tr>
						<tr><td>Alamat</td><td> <?=$surat['alamat'];?></td></tr>
						<tr><td>Nomor KTP/SIM/ID</td><td> <?=$surat['noka'];?></td></tr>
					
						<tr>
							<td colspan=2>
								Telah menjalani pemeriksaan kesehatan dan tes Covid-19 berupa:
							</td>
						</tr>

						<tr class="bgLabel bold">
							<td colspan=2>RT PCR Hapusan Tenggorokan</td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td><?=($surat['pcr'] == 'Ya')? date('d-m-Y', strtotime($surat['pcrTgl']) ) : 'Tidak Dilakukan'; ?>

							<?php
								// if($surat['pcr'] == 'Ya'){
								// 	echo date('d-m-Y', strtotime($surat['pcrTgl']) );									
								// }else{
								// 	echo 'Tidak Dilakukan';
								// }							
								
								// echo ($surat['pcr'] == 'Ya')? date('d-m-Y', strtotime($surat['pcrTgl']) ) : 'Tidak Dilakukan';
								
								?></td>

								
						</tr>
						<tr>
							<td>Hasil</td>
							<td><?=($surat['pcr'] == 'Ya')? $surat['pcrHasil'] : 'Tidak Dilakukan'; ?></td>
						</tr>
																
						<tr class="bgLabel bold">
							<td colspan=2>Rapid Test <?=$surat['rapidLabel'];?></td>
						</tr>                    
						<tr>
							<td>Tanggal</td>
							<td><?=($surat['rapid'] != '')? date('d-m-Y', strtotime($surat['rapidTgl']) ) : 'Tidak Dilakukan'; ?></td>
						</tr>
						<tr>
							<td>Hasil</td>
							<td><?=($surat['rapid'] != '')? $surat['rapidHasil'] : 'Tidak Dilakukan';?>
							</td>
						</tr>
						<tr>
							<td>IgM</td>
							<td><?=($surat['rapid'] != '')? $surat['igM'] : 'Tidak Dilakukan';?></td>
						</tr>
						<tr>
							<td>IgG</td>
							<td><?=($surat['rapid'] != '')? $surat['igG'] : 'Tidak Dilakukan';?></td>
						</tr>
                    
                    
                    
						<tr class="bgLabel bold">
							<td colspan=2>Radiologi</td>
						</tr>
						<tr>
							<td>Photo Thorax</td>
							<td><?=($surat['radKet'] == 'Ya')? $surat['radKet'] : 'Tidak Dilakukan';?></td>
						</tr>
						<tr>
							<td colspan=2>
								Berdasarkan data hasil pemeriksaan fisik dan penunjang
								memperhatikan segala keterbatasan yang secara intrinsik
								tes tersebut, maka dengan ini saya menyatakan bahwa yang 
								kesehatannya pada tanggal <?=date('d-m-Y');?> 
								<b>tidak menunjukkan gejala yang dapat diindikasikan mengarah</b> pada Covid-19.
								<br><br>
								Demikian surat keterangan ini dibuat dengan sebenarnya untuk digunakan seperlunya.
							</td>
						</tr>
						<tr>
							<td colspan=2>
							Sidoarjo, <?=date('d-m-Y');?>
							<br><br>				
							<br><br>
							<b><u><?=$surat['dokternama'];?> </u></b> <br>
							<?=$surat['SIP'];?> <br>
							</td>
						</tr>
					</table>
					
					<!-- <.?php echo "<pre>",print_r($surat),"</pre>";?> -->
					
					

					
					<br>
					
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