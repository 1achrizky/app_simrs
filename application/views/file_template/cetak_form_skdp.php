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
		


	</style>

</head>
<body>
	<div class="container" style="width: 400px; ">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 20px;">
			<div>
				<img src="<?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;">
				<span style="float: right;"><?=$billing;?></span>
			</div>
			<br>
			<div style="text-align: center; font-weight: bold;">SURAT KETERANGAN DALAM PERAWATAN</div>
			<div style="text-align: center; font-weight: bold;"><?=$noskdp;?></div>
						
			<table name="" style="width: 100%;">
				<tr>
					<td style="width: 20%;">No. RM</td>
					<td>: <?=$norm;?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td class="uppercase">: <?=$nama;?> </td>
				</tr>
				<tr>
					<td>Tgl.Lahir</td>
					<td>: <?=$tglLahir;?></td>
				</tr>
				<tr>
					<td>Klinik</td>
					<td>: <?=$provPerujuk;?></td>
				</tr>
				<tr>
					<td>Diagnosa</td>
					<td>: </td>
				</tr>
			</table>

			<table name="" style="width: 100%;">
				<tr>
					<td>1.</td>
					<td>Belum dapat dikembalikan ke FKTP :</td>
				</tr>
				<tr>
					<td></td>
					<td>1.<br> 
						2.<br> 
						3.<br></td>
				</tr>
				<tr>
					<td>2.</td>
					<td>Rencana tindak lanjut pada kunjungan selanjutnya :</td>
				</tr>
				<tr>
					<td></td>
					<td>1.<br> 
						2.<br> 
						3.<br></td>
				</tr>

				<tr>
					<td style="vertical-align: top;">[&emsp;]&nbsp;</td>
					<td>Surat keterangan ini digunakan untuk kunjungan selanjutnya pada tanggal :</td>
				</tr>
				<tr>
					<td style="vertical-align: top;">[&emsp;]&nbsp;</td>
					<td>Pasien dalam kondisi stabil dan dapat melanjutkan perawatan kembali di FKTP :</td>
				</tr>
			</table>

			<table name="" style="width: 100%;">
				<tr>
					<td style="width: 30%;"></td>
					<td  style="text-align: center;">
						<br>
						<p>Sidoarjo, 
							<?= date_format(date_create_from_format('Y-m-d', $tglSep), 'd-m-Y'); ?></p>
						<p>DPJP</p>
						<br>
						<br>
						<p class="italic"> <?=$dpjp;?> </p>
					</td>
				</tr>
			</table>






			
			<div>
				<span class="col-md-6 col-md-offset-5">
					
				</span>
				
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

	<script>


	$(function(event){
		


	});

	</script>





</body>
</html>