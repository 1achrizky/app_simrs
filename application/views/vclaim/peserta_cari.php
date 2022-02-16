<?php
/*
	session_start();
	//echo 'Session='.$_SESSION['username'];
	if(!isset($_SESSION['coder_nik'])){
		header("location: ../login.php");
	}*/
	//echo 'Session='.$_SESSION['coder_nik'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pencarian Peserta</title>
	<link href="<?=base_url();?>assets/plugin/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css">

</head>
<body>
	<div style="text-align: center;">
			<h4 style="font-weight: bold;">Pencarian Peserta</h4>
	</div>

	<div name="div_pesertaCariByNoka" id="div_pesertaCariByNoka">
		<p style="font-weight: bold;">Berdasarkan Noka</p>
		<table name="tbl_cariByNoka" border=1>
			<tr>
				<td>NoKartu / NIK</td>
				<td><input type="text" name="noKartu" /></td>
			</tr>
			<tr>
				<td>Tanggal Pelayanan/SEP</td>
				<td><input type="text" name="tglSep_Noka" /></td>
			</tr>
		</table>
		<button id="btnSepCariByNoka" class="btn btn-success">Cari Peserta</button>
		

	</div>

	<hr>
	<div name="div_pesertaCariByNik" id="div_pesertaCariByNik">
		<p style="font-weight: bold;">Data Hasil Pencarian</p>
		<table name="" border=1>
			<tr>
				<td>Nama Peserta</td>
				<td><span id="nama_peserta">-</span></td>
			</tr> 
			<tr>
				<td>Status</td>
				<td><span id="status_peserta">-</span></td>
			</tr>
		</table>
	</div>


	<hr>
	<?php //include "menu.php";?>



	<script src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
  	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery.xdomainrequest.min.js"></script>
  	<script type='text/javascript' src="<?=base_url();?>assets/js/moment-with-locales.js"></script>
  	<!-- 
	<script src="../assets/js/site.js"></script> -->


		<!-- untuk TABS
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 -->
	<script>
	$(function(event){
		let contentType ="application/x-www-form-urlencoded; charset=utf-8";
		if(window.XDomainRequest) contentType = "text/plain";
		//=============== formPasien.php=============================

		let tglNow = moment().format('YYYY-MM-DD');
		$('input[name=tglSep_Noka]').val(tglNow);

		let path_ByNoka = '#div_pesertaCariByNoka ';
		let path_tblByNoka = 'table[name=tbl_cariByNoka] tr td ';

		const digit_noka = 13, digit_nik = 16;

		let status_peserta = '-', nama_peserta = '-';


		$('#btnSepCariByNoka').click(function(){
			//alert($(path_tblByNoka+"input[name=tglSep_Noka]").val());
			let param = $(path_tblByNoka+"input[name=noKartu]").val();
			if(param.length == digit_noka){  //'Data noka'
				$.ajax({
					async: false,
					url:"<?=base_url();?>ajaxreq/peserta_cari",
					type:"POST",
					data:{
						noKartu : param,
						tglSep : tglNow
					},
					success:function(data){
						//alert(data);
						//alert(data.metaData.message);
						let dtjson = JSON.parse(data);
						//alert(dtjson.metaData.message);
						nama_peserta = dtjson.response.peserta.nama;
						status_peserta = dtjson.response.peserta.statusPeserta.keterangan;
						//status_peserta_fx(dtjson.response.peserta.statusPeserta.keterangan);
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert("Error SEP Cari By Noka: "+errorThrown);
					}
				});

			}else if(param.length == digit_nik){
				//console.log('Data nik');
				$.ajax({
					async: false,
					url:"<?=base_url();?>ajaxreq/peserta_cari_by_nik",
					data:{
						nik 	: param,
						tglSep 	: tglNow
					},
					type:"POST",
					success:function(data){
						//alert(data);
						let dtjson = JSON.parse(data);
						nama_peserta = dtjson.response.peserta.nama;
						status_peserta = dtjson.response.peserta.statusPeserta.keterangan;
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert("Error SEP Cari By NIK: "+errorThrown);
					}
				});

			}else{
				alert('Data yang Anda masukkan tidak sesuai dengan jumlah digit NOKA/NIK. Silahkan cek kembali.');
			}

			$('#nama_peserta').text(nama_peserta);
			$('#status_peserta').text(status_peserta);

			
		});


		

	});
	</script>

</body>
</html>