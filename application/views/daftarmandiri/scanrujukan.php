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
	<title>Pendaftaran Mandiri - RS. Citra Medika</title>
	<link href="<?=base_url();?>assets/plugin/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css">
	<style>
	.container{
		//font-size: 24pt;
		width:600px;
	}
	
	.judul{
		text-align: center;
		margin-top:100px;
	}

	div[name=div_norujukan]{
		text-align: center;
		margin:5px auto;
	}

	input[name=noRujukan]{
		text-align: center;
		display: block;
		margin: 0px auto;
		width:100%;
		height:50px;
	}
	
	.font24pt{
		font-size: 24pt;
	}
	/*
	.judul h4, input[name=noRujukan], #btnNextRujukan{
		font-size: 24pt;
	}
	*/

	#btnNextRujukan{
		//display:inline-block;
		margin-top: 70px;
		width:100%;
		white-space: normal;
	}

	</style>

</head>
<body>
	<div class="container"> 
		<div class='judul' style="">
				<h4 class="font24pt" style="font-weight: bold;">Scan Nomor Rujukan</h4>
		</div>

		<div name="div_norujukan" id="div_norujukan">
			<input type="text" name="noRujukan" class="form-control font24pt" placeholder="Scan nomor rujukan Anda..." />
			<button id="btnNextRujukan" class="btn btn-success font24pt">Gagal Scan Rujukan? TEKAN TOMBOL INI.</button>
			
			<br><br>
			<button id="btnGetRM" class="btn btn-success font24pt">btnGetRM</button>
			
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
	</div>


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
		$('input[name=noRujukan]').focus();

		let contentType ="application/x-www-form-urlencoded; charset=utf-8";
		if(window.XDomainRequest) contentType = "text/plain";
		//=============== formPasien.php=============================

		let dateNow = moment().format('YYYY-MM-DD');
		let tgl_now, bln_now, thn_now;
		let tgl_rjk, bln_rjk, thn_rjk;

		let dt_now = moment([
				moment().format('YYYY'),
				moment().format('MM'),
				moment().format('DD')
			]);

		let message = [
			['reg_gagal' , 'Pendaftaran tidak berhasil. Silahkan ke Resepsionis untuk mendapat informasi lebih lanjut.'],
			['reg_sukses' , 'Pendaftaran BERHASIL.']
		];

		let b = moment(['2017','06','17']);

		// let a = moment([2018,5,16]);
		// let b = moment([2017,6,17]);

		////////////let selisih_bln = a.diff(b,'months'); // a-b=+
		//alert(selisih_bln);



		const digit_norujukan = 13;

		let noRujukan, nama, noka, tglKunjungan, statusKetPeserta, statusKodePeserta;

		$('#btnNextRujukan').click(function(){
			noRujukan = $('input[name=noRujukan]').val();
			$.ajax({
				async: false,
				url:"<?=base_url();?>ajaxreq/rujukan",
				data:{
					noRujukan : noRujukan
				},
				type:"POST",
				success:function(data){
					console.log('[ajaxreq/rujukan]::'+data);
					//console.log(data);
					let js = JSON.parse(data);
					nama = js.response.rujukan.peserta.nama;
					noka = js.response.rujukan.peserta.noKartu;
					tglKunjungan = js.response.rujukan.tglKunjungan;
					statusKetPeserta = js.response.rujukan.peserta.statusPeserta.keterangan;
					statusKodePeserta = js.response.rujukan.peserta.statusPeserta.kode;
					//console.log(nama+'=[nama] / [noka]='+noka+'/[tglKunjungan]='+tglKunjungan+'/'+statusKetPeserta+'/'+statusKodePeserta);

					let dt_rjk = moment([
						moment(tglKunjungan).format('YYYY'),
						moment(tglKunjungan).format('MM'),
						moment(tglKunjungan).format('DD')
					]);

					let selisih_bln = dt_now.diff(dt_rjk,'months');
					

					if(statusKodePeserta == 0){ //0=aktif
						console.log(nama+'=[nama] / [noka]='+noka+'/[tglKunjungan]='+tglKunjungan+'/'+statusKetPeserta+'/'+statusKodePeserta);

						//=[CEK KADALUWARSA RUJUKAN <= 1 BULAN]
						if(selisih_bln <= 1){
							alert(selisih_bln);
						}else{
							//=[CEK KADALUWARSA RUJUKAN <= 3 BULAN]
							console.log('..[CEK DB KADALUWARSA RUJUKAN <= 3 BULAN]..');
							//==[mengecek flag kadaluarsa dr noRujukan di DB rscm]
							$.ajax({
								async: false,
								url:"<?=base_url();?>ajaxreq/gd_rujukan_rscm",
								data:{
									noRujukan : noRujukan
								},
								type:"POST",
								success:function(data){
									console.log('[ajaxreq/gd_rujukan_rscm]::'+data);
									let js = JSON.parse(data);

								},
								error:function(jqXHR,textStatus,errorThrown){
									alert("Error[ajx/gd_rujukan_rscm]: "+errorThrown);
								}
							});
						}

					}else{ //peserta TIDAK AKTIF/BERMASALAH
						alert(message[0][1]);
					}

					


					
					$.ajax({
						async: false,
						url:"<?=base_url();?>ajaxreq/gd_pasien_rscm",
						data:{
							noka : noka
						},
						type:"POST",
						success:function(data){
							console.log('[ajaxreq/gd_pasien_rscm]:: '+data);
							let js = JSON.parse(data);

						},
						error:function(jqXHR,textStatus,errorThrown){
							alert("Error[rujukan]: "+errorThrown);
						}
					});

				},
				error:function(jqXHR,textStatus,errorThrown){
					alert("Error[rujukan]: "+errorThrown);
				}
			});

			
		});

		$('#btnGetRM').click(function(){
			//alert(noka);
			//noka = '0001537332693';
			$.ajax({
				async: false,
				url:"<?=base_url();?>ajaxreq/gd_pasien_rscm",
				data:{
					noka : noka
				},
				type:"POST",
				success:function(data){
					alert(data);
					//console.log(data);
					let js = JSON.parse(data);

				},
				error:function(jqXHR,textStatus,errorThrown){
					alert("Error[rujukan]: "+errorThrown);
				}
			});

		});

		// $.ajax({
		// 	async: false,
		// 	url:"<...?=base_url();?>ajaxreq/gd_pasien_rscm",
		// 	data:{
		// 		noka : '0001537332692'
		// 	},
		// 	type:"POST",
		// 	success:function(data){
		// 		alert(data);
		// 		//console.log(data);
		// 		let js = JSON.parse(data);

		// 	},
		// 	error:function(jqXHR,textStatus,errorThrown){
		// 		alert("Error[rujukan]: "+errorThrown);
		// 	}
		// });





		//=====================================================
		//===================== TES AJAX ======================
		//===================== 		 ======================

		let norm;
		noka = '0001537650696';
		//noka = '0000000148580';

				$.ajax({//=[CARI NORM dg param NOKA]
					async: false,
					url:"<?=base_url();?>ajaxreq/get_norm_by_noka",
					data:{
						noka : noka
					},
					type:"POST",
					success:function(data){
						console.log('[ajaxreq/get_norm_by_noka]::'+data);
						let js = JSON.parse(data);
						if(js.count == 0){
							alert(message[0][1]);
						}else{
							norm = js.datajs[0].NoRM;
							console.log('Data ADA = '+norm);


							//=[CEK. PERNAH CETAK KARTU BEROBAT(RSCM)]
							$.ajax({
								async: false,
								url:"<?=base_url();?>ajaxreq/get_flag_cetak_kartu",
								data:{
									norm : norm
								},
								type:"POST",
								success:function(data){
									console.log('[ajaxreq/get_flag_cetak_kartu]::'+data);
									let js = JSON.parse(data);
									if(js.datajs[0].flagkartu == 0){ //0=belum cetak kartu
										alert('Kartu berobat belum dicetak. '+ message[0][1]);
									}else{
										console.log('PERNAH CETAK = '+js.datajs[0].flagkartu);
										//=[LANJUT KE REPLACE NOKA DI MASTER PASIEN]
										//=[PARAM KIRIM NORM & NOKA]

										//////alert(norm+'&'+noka);
									}

								},
								error:function(jqXHR,textStatus,errorThrown){
									alert("Error[ajx/get_flag_cetak_kartu]: "+errorThrown);
								}
							});
							
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert("Error[ajx/get_norm_by_noka]: "+errorThrown);
					}
				});

				///alert(norm+'&'+noka);

				//let norm_x = '103742', noka_x = '345345';
				let norm_x = '103742', noka_x='pp';
				//if(typeof noka_x !== 'undefined'){
				if(!noka_x){
					alert('undef');
				}else{
					alert(noka_x);
				}
							// $.ajax({
							// 	async: false,
							// 	url:"<>?=base_url();?>ajaxreq/update_noka_mst_pasien",
							// 	data:{
							// 		norm : norm_x,
							// 		noka : noka_x
							// 	},
							// 	type:"POST",
							// 	success:function(data){
							// 		console.log('[ajaxreq/update_noka_mst_pasien]::'+data);
							// 		let js = JSON.parse(data);
									
							// 		console.log('Sukses = '+js.message);
										

							// 	},
							// 	error:function(jqXHR,textStatus,errorThrown){
							// 		alert("Error[ajx/get_flag_cetak_kartu]: "+errorThrown);
							// 	}
							// });

		//=====================/TES AJAX ======================
		//=====================================================

		
		

	});
	</script>

</body>
</html>