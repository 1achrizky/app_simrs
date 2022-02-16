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
			font-weight: bold;
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
			<div class="ft_title" style="margin:0px auto; text-align: center;">REKENING</div>			
		</div>


		<div class="row">
			<div class="col-xs-12">
				<table name="" class="table" border=0>
					<tr>
						<td>No.Billing</td>
						<td>: <span name="nobill"><?=$pasien['nobill'];?></span></td>
						<td>No.RM</td>
						<td>: <span name="norm"><?=$pasien['NoRM'];?></span></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>: <span name="nama"><?=$pasien['Nama'];?></span></td>
						<td>No.SEP</td>
						<td>: <span name="nosep"><?=$pasien['nosep'];?></span></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>: <span name="alamat"><?=$pasien['Alamat'];?></span></td>
						<td>Penanggung</td>
						<td>: <span name="alamat"><?=$pasien['namaPenanggung'];?></span></td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>
					<tr style="border-style:dashed;">
						<td>Ruang</td>
						<td colspan="3">: 
							<span name="ruang">
								<?=$pasien['namaGedung'].' - '.$pasien['namaLantai'].' - Ruang '.$pasien['namaRuang'].' - '.$pasien['namaBed'].' - Kelas '.$pasien['namaKelas'];?>
							</span>
						</td>
					</tr>
					
				</table>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-12" style="padding-top:20px;">
				<table class="table table-bordered table-striped" name="tbl_pantauan_biaya_ri">
	                <thead>
	                  <tr>
	                    <th class="text-center">No.</th>
	                    <th class="text-center">TANGGAL</th>
	                    <th class="text-center">NOREFF</th>
	                    <th class="text-center">KETERANGAN</th>
	                    <th class="text-center">JUMLAH</th>
	                  </tr>
	                </thead>
	                <tbody>
	            	<?php 
	            		$cnt = count($list_biaya_ri);
	            		$total_tarif_rs = 0;
	            		for($i=0; $i<$cnt; $i++){
	            			$total_tarif_rs += (int)$list_biaya_ri[$i]['Billing'];

	            			$el = 
	            			"<tr>".
	            				"<td class='p-l-tbl-list'>".($i+1).".</td>".
	            				"<td class='p-l-tbl-list'>".$list_biaya_ri[$i]['TglTrans']."</td>".
	            				"<td class='p-l-tbl-list'>".$list_biaya_ri[$i]['NoNota']."</td>".
	            				"<td class='p-l-tbl-list'>".$list_biaya_ri[$i]['Ket']."</td>".
	            				"<td class='p-l-tbl-list text-right'>".number_format($list_biaya_ri[$i]['Billing'], 0, ",", ".")."</td>".
	            			"</tr>";
	            			echo $el;
	            		}
	            	?>
	                </tbody>
	                <tfoot>
	                  <tr>
	                    <th colspan="4" class='p-l-tbl-list'>TOTAL</th>
	                    <th class="tarif_rs" style="text-align: right;">&emsp;<?=number_format($totalTarifRs, 0, ",", ".");?></th>
	                  </tr>
	                  <tr>
	                    <th colspan="4" class='p-l-tbl-list'>UANG MASUK</th>
	                    <th class="tarif_rs" style="text-align: right;">&emsp;<?=number_format($totalTarifRs, 0, ",", ".");?></th>
	                  </tr>
	                  <tr>
	                    <th colspan="4" class='p-l-tbl-list'>GRAND TOTAL</th>
	                    <th class="tarif_rs" style="text-align: right;">&emsp;<?=number_format($grandTotalRs, 0, ",", ".");?></th>
	                  </tr>
	                </tfoot>
	              </table>
			</div>
		</div>

		<!-- <div class="row">
			<div class="col-md-4">
				Pasien, <br><br><br><br>
				<span name="nama_px">( <.?=$pasien['Nama'];?> )</span>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4">
				Operator, <br><br><br><br>
				<span name="operator">( <?=$operator;?> )</span>
			</div>
		</div> -->


		<div class="row">
			<div class="col-xs-12">
				<table>
					<tr>
						<td>Terbilang</td>
						<td>: <?=terbilang($totalTarifRs).' rupiah';?></td>				
					</tr>
					<tr>
						<td>Tercetak &nbsp;</td>
						<td>: <?=date('Y-m-d H:i:s')?></td>				
					</tr>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12" style="padding-top:20px;">
			<!-- <div style="clear:left; padding-top:20px; font-weight: normal;"> -->
				<table name="" class="table borderless">
					<tr>
						<td style="text-align: center; width:35%;">
							Pasien, <br><br><br><br>
							<span name="nama_px">( <?=$pasien['Nama'];?> )</span>
						</td>
						<td style="text-align: center; width:30%;"></td>
						<td style="text-align: center; width:35%;">
							Operator, <br><br><br><br>
							<span name="operator">( <?=$operator;?> )</span>
						</td>					
					</tr>
				</table>
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