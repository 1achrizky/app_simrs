<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pendaftaran Mandiri RS Citra Medika</title>

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

		.div_center{
			margin:0px auto;
		}

		.container{
			font-weight: bold;
			height: 100vh;
			width: 800px;
			//background:#eaeaea;
			margin:0px auto;
		}

		table[name=sep1] tr,
		table[name=sep2] tr{
			height: 20px;
		}

		table[name=sep1] tr td:nth-child(1),
		table[name=sep2] tr td:nth-child(1){
			width:120px;
		}

		table[name=sep1] tr td:nth-child(2),
		table[name=sep2] tr td:nth-child(2){
			width:250px;
		}

		.ft_normal{
			font-weight: normal;
		}

		.ft_title{
			font-weight: bold;
			font-size: 12pt;
		}

		.ft_size_note{
			font-size: 8pt;
		}

		.ft_size_ttd{
			font-size: 10pt;
		}

		.bpjs_logo{
			width:210px;
		}




		/* =================\[LOAD: MODAL>>KLINIK] ====================== */


	</style>

</head>
<body>
	<div class="container row" name="main">
		<div style="padding:20px 0px 20px 0; height:80px;">
			<div class="col-xs-4">
				<img src="<?=base_url()?>/assets/img/bpjs-logo.png" alt="" class="bpjs_logo">
			</div>
			<div class="col-xs-8 ft_title">
				<span>SURAT ELEGIBILITAS PESERTA</span><br>
				<span>RS Citra Medika</span>
			</div>
			
		</div>


		<div class="col-xs-6">
			<!-- <table name="tblDataRm" class="table-bordered mytable div_center">  -->
			<table name="sep1" class="mytable div_center ft_normal" border=0>

				<tr>
					<td>No.SEP</td>
					<td>: &emsp;</td>
				</tr>
				<tr>
					<td>Tgl.SEP</td>
					<td></td>
				</tr>
				<tr>
					<td>No.Kartu</td>
					<td></td>
				</tr>
				<tr>
					<td>Nama Peserta</td>
					<td></td>
				</tr>
				<tr>
					<td>Tgl.Lahir</td>
					<td></td>
				</tr>
				<tr>
					<td>No.Telepon</td>
					<td></td>
				</tr>
				<tr>
					<td>Poli Tujuan</td>
					<td></td>
				</tr>
				<tr>
					<td>Faskes Perujuk</td>
					<td></td>
				</tr>
				<tr>
					<td>Diagnosa Awal</td>
					<td></td>
				</tr>
				<tr>
					<td>Catatan</td>
					<td></td>
				</tr>
			</table>
		</div>


		<div class="col-xs-6">
			<!-- <table name="tbl_bpjs" class="table-bordered mytable"> -->
			<table name="sep2" class="mytable div_center ft_normal" border=0>
				<tr>
					<td>Peserta</td>
					<td>: &emsp;</td>
				</tr>
				<tr>
					<td>COB</td>
					<td></td>
				</tr>
				<tr>
					<td>Jns.Rawat</td>
					<td></td>
				</tr>
				<tr>
					<td>Kls.Rawat</td>
					<td></td>
				</tr>
				<tr>
					<td>Penjamin</td>
					<td></td>
				</tr>
			</table>
		</div>


		<div style="clear:left; padding-top:20px; font-weight: normal;">
			<div class="col-xs-8">
				<span class="ft_size_note">*Saya menyetujui BPJS Kesehatan menggunakan informasi medis pasien jika diperlukan.</span><br>
				<span class="ft_size_note">SEP Bukan sebagai bukti penjamin peserta.</span>
				<br><br>
				<span class="ft_size_note">Cetakan .....</span>
			</div>

			<div class="col-xs-4">
				<span>Pasien/Keluarga Pasien</span>
				<br><br>
				<span>______________________</span>
			</div>
		</div>


				<!-- 
				<button class="btn btn-primary" name="btnOpen" data-toggle="modal" data-target="#modal_klinik"> Modal OPen </button> -->
	</div>


		



		<br>
		<br>
		<br>
		<br>
		<br>
		<br>

		
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
		console.log(moment().format('YYYY-MM-DD hh:mm:ss'));
		

		let poli_tujuan_ax, ppkRujukan_ax, tglRujukan_ax, noRujukan, tglSep_ax, noKartu_ax;
		let jnsPelayanan_ax, klsRawat_ax, diagAwal_ax;
		let nomr_ax;

		$("input[name=noRujukanCari]").keypress(function (e) { //TEKAN ENTER
			noRujukan = $(this).val();
	 		
		});


		$('button[name=btn_sep_create]').click(function(){
			//alert('oke');
			
		});


		$('button[name=btn_sep_cari]').click(function(){
			//alert('oke');
			
		});

		$('button[name=btn_sep_hapus]').click(function(){
			//alert('HAPUS');
			
		});

		$('button[name=btn_cetak]').click(function(){
			//alert('oke');
			window.print();
		});


	});

	</script>





</body>
</html>