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

		html, body { height: 100%; margin: 0; background: #FFFFFF;}

		.bold{ font-weight: bold; }

		.div_center{ margin:0px auto; }

		.container{
			/*font-weight: bold;*/
			height: 100vh;
			width: 800px;
			//background:#eaeaea;
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

		table tr td{
			font-weight: bold;
		}




		/* =================\[LOAD: MODAL>>KLINIK] ====================== */


	</style>

</head>
<body class="ft-10">
	<div class="container" name="main">
		<!-- <div class="row" style="padding:20px 0px 20px 0; height:80px;"> -->
		<div class="row">
			<div class="col-xs-4">
				<img src="<?=base_url()?>/assets/img/rscm/LOGO RSCM BARU.png" alt="" class="rscm_logo">
			</div>			
		</div>

		<div class="row" style="margin-top:20px; margin-bottom:10px;">
			<div class="ft_title" style="margin:0px auto; text-align: center; text-decoration: underline;">SURAT KETERANGAN KEMATIAN</div>			
		</div>

		<div class="row" style="margin-top:20px; margin-bottom:10px;">
			<div>
				Yang bertanda tangan dibawah ini, <strong>Dokter</strong> 
				<?=$dokter;?>
			</div>			
			<div>Menerangkan bahwa penderita :</div>			
		</div>

		<div class="row">
			<!-- <div class="col-xs-12"> -->
			<div>
				<table name="" style="margin: 0px auto;">
					<tr>
						<td style="width:120px;">Nama</td>
						<td>: <span name="nama"><?=$nama;?></span></td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td>: <span name="nama"><?=$jk;?></span></td>
					</tr>
					<tr>
						<td>Umur</td>
						<td>: <span name="alamat"><?=$umur;?> TAHUN</span></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>: <span name="alamat"><?=$alamat;?></span></td>
					</tr>
					
				</table>
			</div>
		</div>

		<div class="row" style="margin-top:10px; margin-bottom:10px;">
			<div>Pada tanggal <?=$tgl_meninggal;?> telah meninggal dunia, bukan karena penyakit menular.</div>	
			<!-- <div style="float:right;"> -->
			<div style="margin-left: 400px;">
				<div style="margin-top:20px; margin-bottom:10px; text-align: center;">
					<div>Sidoarjo, <?=date("d-m-Y");?></div>
					<!-- <div><br><br><br></div> -->
					<div><img src="<?=base_url('uploads/img/ttd/').$kd_dokter;?>.png" style="height:80px;"></div>
					<div>( <?=$dokter;?> )</div>
					<div>Dokter RS. Citra Medika</div>
				</div>	
			</div>
			<!-- <div style="clear:right;"></div> -->
						
		</div>
		

<!-- 

		<div class="row">
			<div class="col-xs-12" style="padding-top:20px;">
				<table name="" class="table borderless">
					<tr>
						<td style="text-align: center; width:35%;">
							Pasien, <br><br><br><br>
							<span name="nama_px">( <.?=$pasien['Nama'];?> )</span>
						</td>
						<td style="text-align: center; width:30%;"></td>
						<td style="text-align: center; width:35%;">
							Operator, <br><br><br><br>
							<span name="operator">( <?=$operator;?> )</span>
						</td>					
					</tr>
				</table>
			</div>
		</div> -->

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