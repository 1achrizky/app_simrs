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

		.ft-mini>tbody>tr>td{
			font-size: 8pt;
		}


	</style>

</head>
<body class="ft-10">
	<?php
	// $data = $val.data;
	?>
	<div class="container" name="main">
		<!-- <div class="row" style="padding:20px 0px 20px 0; height:80px;"> -->
		<div class="row">
			<div class="col-xs-4">
				<img src="<?=base_url()?>/assets/img/rscm/LOGO RSCM BARU.png" alt="" class="rscm_logo">
			</div>			
		</div>

		<div class="row" style="margin-top:5px;">
			<div class="ft_title" style="margin:0px auto; text-align: center; font-size: 14pt;">DETAIL LAPORAN PENDAPATAN DOKTER</div>			
		</div>

		<hr>
		<!-- <div class="row">
			<div class="col-xs-12">
				<table class="tbl_px" border=0 style="width:100%;" >
					<tr>
						<td>No.Billing : </td>
						<td><span name="nobill"><.?=$px['NoBill'];?></span></td>
						<td>No.RM : </td>
						<td><span name="norm"><.?=$px['NoRM'];?></span></td>
					</tr>
					<tr>
						<td>Nama :</td>
						<td><span name="nama"><.?=$px['Nama'];?></span></td>
						<td>No.SEP :</td>
						<td><span name="nosep"><.?=$px['nosep'];?></span></td>
					</tr>					
				</table>
			</div>
		</div> 

		<hr>-->
		<div class="row">
			<div class="col-xs-12">
			<?php
				$sub = array_keys($data);
				// print_r($x);
				for($j=0; $j<count($data); $j++){
				

            		switch ($sub[$j]) {
            			case "pendapatan_nonbpjs":
	            			?>
								<h3>PENDAPATAN NON BPJS</h3>
								<div>Periode : <?=$data[$sub[$j]]['bulan']." ".$data[$sub[$j]]['tahun'];?></div>

								<table name="" class="ft-mini" border=1 style="width:100%; margin-bottom:10px;">
					                <thead>
					                  <tr>
					                    <th class="text-center" style="width:5%;">No.</th>
					                    <th class="text-center" style="width:10%;">Tanggal</th>
					                    <th class="text-center" style="width:10%;">No.Bill</th>
					                    <th class="text-center" style="width:10%;">No.Bukti</th>
					                    <th class="text-center" style="width:5%;">Kode</th>
					                    <!-- <th class="text-center" style="width:10%;">Dokter</th> -->
					                    <th class="text-center" style="width:20%;">Tindakan</th>
					                    <th class="text-center" style="width:25%;">Nama Pasien</th>
					                    <th class="text-center" style="width:15%;">Total</th>
					                  </tr>
					                </thead>
					                <tbody>
					            	<?php 
					            		for($i=0; $i<count($data[$sub[$j]]['list']); $i++){
					            			// $total_tarif_rs += (int)$list_biaya_ri[$i]['Billing'];
					            			$el = 
					            			"<tr>".
					            				"<td>".($i+1).".</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Tgl']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoBill']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoBukti']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Kode']."</td>".
					            				// "<td>".$data[$sub[$j]]['list'][$i]['Dokter']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Tindakan']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NamaPasien']."</td>".
					            				// "<td class='text-center'>".$data[$sub[$j]]['list'][$i]['Tgl']."</td>".
					            				"<td class='text-right' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['list'][$i]['netto'], 0, ",", ".").
					            				"</td>".
					            			"</tr>";
					            			echo $el;
					            		}
					            		echo "<tr>
					            				<td class='text-right bold' style='padding-right:10px;' colspan=7>Total</td>
					            				<td class='text-right bold' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['total'], 0, ",", ".").
					            				"</td>
					            			</tr>";
					            	?>
					                </tbody>
					            </table>
							
	            			<?php


            				break;

            			case "pendapatan_bpjs":
	            			?>
								<h3>PENDAPATAN BPJS</h3>
								<div>Periode : <?=$data[$sub[$j]]['bulan']." ".$data[$sub[$j]]['tahun'];?></div>

								<table name="" border=1 style="width:100%; margin-bottom:10px;">
					                <thead>
					                  <tr>
					                    <th class="text-center" style="width:5%;">No.</th>
					                    <th class="text-center" style="width:10%;">Tanggal</th>
					                    <th class="text-center" style="width:10%;">No.Bill</th>
					                    <th class="text-center" style="width:10%;">No.Bukti</th>
					                    <th class="text-center" style="width:5%;">Kode</th>
					                    <!-- <th class="text-center" style="width:10%;">Dokter</th> -->
					                    <th class="text-center" style="width:20%;">Tindakan</th>
					                    <th class="text-center" style="width:25%;">Nama Pasien</th>
					                    <th class="text-center" style="width:15%;">Total</th>
					                  </tr>
					                </thead>
					                <tbody>
					            	<?php 
					            		for($i=0; $i<count($data[$sub[$j]]['list']); $i++){
					            			// $total_tarif_rs += (int)$list_biaya_ri[$i]['Billing'];
					            			$el = 
					            			"<tr>".
					            				"<td>".($i+1).".</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Tgl']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoBill']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoBukti']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Kode']."</td>".
					            				// "<td>".$data[$sub[$j]]['list'][$i]['Dokter']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Tindakan']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NamaPasien']."</td>".
					            				// "<td class='text-center'>".$data[$sub[$j]]['list'][$i]['Tgl']."</td>".
					            				"<td class='text-right' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['list'][$i]['netto'], 0, ",", ".").
					            				"</td>".
					            			"</tr>";
					            			echo $el;
					            		}
					            		echo "<tr>
					            				<td class='text-right bold' style='padding-right:10px;' colspan=7>Total</td>
					            				<td class='text-right bold' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['total'], 0, ",", ".").
					            				"</td>
					            			</tr>";
					            	?>
					                </tbody>
					            </table>
							
	            			<?php


            				break;

            			case "bhp_nonbpjs":
	            			?>
								<h3>BHP NON BPJS</h3>
								<div>Periode : <?=$data[$sub[$j]]['bulan']." ".$data[$sub[$j]]['tahun'];?></div>

								<table name="" border=1 style="width:100%; margin-bottom:10px;">
					                <thead>
					                  <tr>
					                    <th class="text-center" style="width:5%;">No.</th>
					                    <th class="text-center" style="width:10%;">Tanggal</th>
					                    <th class="text-center" style="width:10%;">No.Bill</th>
					                    <th class="text-center" style="width:10%;">No.Bukti</th>
					                    <th class="text-center" style="width:5%;">Dokter</th>
					                    <th class="text-center" style="width:5%;">Kode</th>
					                    <!-- <th class="text-center" style="width:10%;">Dokter</th> -->
					                    <th class="text-center" style="width:20%;">Tindakan</th>
					                    <th class="text-center" style="width:20%;">Nama Pasien</th>
					                    <th class="text-center" style="width:15%;">Total</th>
					                  </tr>
					                </thead>
					                <tbody>
					            	<?php 
					            		for($i=0; $i<count($data[$sub[$j]]['list']); $i++){
					            			// $total_tarif_rs += (int)$list_biaya_ri[$i]['Billing'];
					            			$el = 
					            			"<tr>".
					            				"<td>".($i+1).".</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Date']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoBill']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoReff']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['pelaksana']."</td>".
					            				// "<td>".$data[$sub[$j]]['list'][$i]['Dokter']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['KodeTindakan']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['kettindakan']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Nama']."</td>".
					            				// "<td class='text-center'>".$data[$sub[$j]]['list'][$i]['Tgl']."</td>".
					            				"<td class='text-right' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['list'][$i]['TotalTarif'], 0, ",", ".").
					            				"</td>".
					            			"</tr>";
					            			echo $el;
					            		}
					            		echo "<tr>
					            				<td class='text-right bold' style='padding-right:10px;' colspan=8>Total</td>
					            				<td class='text-right bold' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['total'], 0, ",", ".").
					            				"</td>
					            			</tr>";
					            	?>
					                </tbody>
					            </table>
							
	            			<?php


            				break;

            			case "bhp_bpjs":
	            			?>
								<h3>BHP BPJS</h3>
								<div>Periode : <?=$data[$sub[$j]]['bulan']." ".$data[$sub[$j]]['tahun'];?></div>

								<table name="" border=1 style="width:100%; margin-bottom:10px;">
					                <thead>
					                  <tr>
					                    <th class="text-center" style="width:5%;">No.</th>
					                    <th class="text-center" style="width:10%;">Tanggal</th>
					                    <th class="text-center" style="width:10%;">No.Bill</th>
					                    <th class="text-center" style="width:10%;">No.Bukti</th>
					                    <th class="text-center" style="width:5%;">Dokter</th>
					                    <th class="text-center" style="width:5%;">Kode</th>
					                    <!-- <th class="text-center" style="width:10%;">Dokter</th> -->
					                    <th class="text-center" style="width:20%;">Tindakan</th>
					                    <th class="text-center" style="width:20%;">Nama Pasien</th>
					                    <th class="text-center" style="width:15%;">Total</th>
					                  </tr>
					                </thead>
					                <tbody>
					            	<?php 
					            		for($i=0; $i<count($data[$sub[$j]]['list']); $i++){
					            			// $total_tarif_rs += (int)$list_biaya_ri[$i]['Billing'];
					            			$el = 
					            			"<tr>".
					            				"<td>".($i+1).".</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Date']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoBill']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['NoReff']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['pelaksana']."</td>".
					            				// "<td>".$data[$sub[$j]]['list'][$i]['Dokter']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['KodeTindakan']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['kettindakan']."</td>".
					            				"<td>".$data[$sub[$j]]['list'][$i]['Nama']."</td>".
					            				// "<td class='text-center'>".$data[$sub[$j]]['list'][$i]['Tgl']."</td>".
					            				"<td class='text-right' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['list'][$i]['TotalTarif'], 0, ",", ".").
					            				"</td>".
					            			"</tr>";
					            			echo $el;
					            		}
					            		echo "<tr>
					            				<td class='text-right bold' style='padding-right:10px;' colspan=8>Total</td>
					            				<td class='text-right bold' style='padding-right:10px;'>".
					            					number_format($data[$sub[$j]]['total'], 0, ",", ".").
					            				"</td>
					            			</tr>";
					            	?>
					                </tbody>
					            </table>
							
	            			<?php


            				break;

            			
            			default:
            				# code...
            				break;
            		}

            		

	        	// echo "GRAND TOTAL : ".$grandTotal;
        		// echo '<div style="text-align:right; margin-top:20px;" class="bold">
        		// 		GRAND TOTAL : '.number_format($grandTotal, 0, ",", ".").'
        		// 	</div>';
            	}
	        	?>


			</div>
		</div>
		<!-- 
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
	            	<.?php 
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
	                    <th class="tarif_rs" style="text-align: right;">&emsp;<.?=number_format($totalTarifRs, 0, ",", ".");?></th>
	                  </tr>
	                  <tr>
	                    <th colspan="4" class='p-l-tbl-list'>UANG MASUK</th>
	                    <th class="tarif_rs" style="text-align: right;">&emsp;<.?=number_format($totalTarifRs, 0, ",", ".");?></th>
	                  </tr>
	                  <tr>
	                    <th colspan="4" class='p-l-tbl-list'>GRAND TOTAL</th>
	                    <th class="tarif_rs" style="text-align: right;">&emsp;<.?=number_format($grandTotalRs, 0, ",", ".");?></th>
	                  </tr>
	                </tfoot>
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

<?php
// echo "<div style='clear:both;'></div>";
// echo "<pre>",print_r($list),"</pre>";
?>