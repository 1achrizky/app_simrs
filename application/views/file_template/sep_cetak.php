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
		/* style sheet for "A4" printing */
		/*@media print and (width: 21cm) and (height: 29.7cm) {*/
		/*
		@media print and (width: 21cm) and (height: 15cm) {
			@page {
			  margin: 3cm;
			}
		}*/

		/* 
		@media print {
		  body {
		    width: 21cm; width of index card
		    height: 15cm; height of index card
		  }
		  etc
		}  */


	</style>

</head>
<body>
	<div class="container row font_cetak" name="main">
		<div style="clear:left; height:20px;"></div>

		<div class="kertas_sep" style="font-size: 8pt;">
			<div style="overflow: hidden; margin-bottom: 10px;">
				<div class="col-xs-3">
					<img src="<?=base_url();?>/assets/img/bpjs-logo.png" alt="" class="bpjs_logo" style="width:150px;">
				</div>
				<div class="col-xs-4" style="font-size: 11pt; font-weight: bold; padding: 0px;">
					<span>SURAT ELEGIBILITAS PESERTA</span><br>
					<span>RS Citra Medika</span>
				</div>
				<div class="col-xs-5" style="height: 30px; line-height: 0.8;">
					<span style="font-family:'Free 3 of 9'; font-size: 28pt;" class="unbold">*<?=$noSep;?>*</span>
				</div>
				
			</div>

			<!-- TES -->
			<style>
				/*table[name=sep1]>tr>td:nth-child(1), 
				table[name=sep1]>tr>td:nth-child(3){
					width : 10%;
				}
				table[name=sep1]>tr>td:nth-child(2),
				table[name=sep1]>tr>td:nth-child(4){
					width : 40%;
				}*/
			</style>
			<div class="col-xs-12">
				<table name="sep1" class="ft_normal" border=0 width="100%">
					<tr>
						<td>No.SEP</td>
						<td style="font-size: 14pt;">: <?=$noSep;?></td>
						<td>Prolanis PRB</td>
						<td style="font-size: 16pt; font-weight: bold;">: <?=$prb;?></td>
					</tr>
					<tr>
						<td width="10%">Tgl.SEP</td>
						<td width="40%">: &ensp;<?=$tglSep;?></td>
						<td>Peserta</td>
						<td>: &ensp;<?=$jnsPeserta;?></td>
					</tr>
					<tr>
						<td>No.Kartu</td>
						<td>: &ensp;<?=$noKartu;?></td>
						<td>COB</td>
						<td>: &ensp;<?=$asuransi;?></td>
					</tr>
					<tr>
						<td>Nama Peserta</td>
						<td class="uppercase">: &ensp;<?=$nama;?></td>
						<td>Jns.Rawat</td>
						<td>: &ensp;<?=$jnsPelayanan;?></td>
					</tr>
					<tr>
						<td>Tgl.Lahir</td>
						<td>: &ensp;<?=$tglLahir;?></td>
						<td>Kls.Rawat</td>
						<td>: &ensp;<?=$kelasRawat;?></td>
					</tr>
					<tr>
						<td>No.Telepon</td>
						<td>: &ensp;<?=$noTelepon;?></td>						
						<td>Penjamin</td>
						<td>: &ensp;<?=$penjamin;?></td>
					</tr>
					<tr>
						<td>Poli Tujuan</td>
						<td>: &ensp;<?=$poli;?></td>
						<!-- <td>Prolanis PRB</td>
						<td>: &ensp;<?=$prb;?></td> -->
					</tr>
					<tr>
						<td>Faskes Perujuk</td>
						<td colspan="3">: &ensp;<?=$provPerujuk;?></td>
					</tr>
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan="3">: &ensp;<?=$diagnosa;?></td>
					</tr>
					<tr>
						<td>Catatan</td>
						<td colspan="3">: &ensp;<?=$catatan;?></td>
					</tr>
					
				</table>
				
			</div>

				
			<!-- \TES -->



			<div style="clear:left; padding-top:20px; font-weight: normal;">
				<div class="col-xs-8">
					<span class="ft_size_note">*Saya menyetujui BPJS Kesehatan menggunakan informasi medis pasien jika diperlukan.</span><br>
					<span class="ft_size_note">SEP Bukan sebagai bukti penjamin peserta.</span>
					<br><br>
					<span class="ft_size_note">Cetakan .....</span>
				</div>

				<div class="col-xs-4">
					<div class="text_center">Pasien/Keluarga Pasien</div>
					<br><br>
					<div class="text_center">______________________</div>
				</div>
			</div>
			<!-- <span style="font-family:'Free 3 of 9'; font-size: 28pt;" class="unbold">*<?=$noSep;?>*</span>
			<span> ::SEP_&_BL::: </span>
			<span style="font-family:'Free 3 of 9'; font-size: 28pt;" class="unbold">*BL180703.1234*</span> -->
		</div>

		<!-- <div style="clear:left; height:20px;"></div> -->

				<!-- 
				<button class="btn btn-primary" name="btnOpen" data-toggle="modal" data-target="#modal_klinik"> Modal OPen </button> -->
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

	<script>


	$(function(event){
		


	});

	</script>





</body>
</html>