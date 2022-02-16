<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pendaftaran Mandiri RS Citra Medika</title>

	<!-- 
	<link href="<>?=base_url();?>assets/plugin/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	 -->

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css">


	<!-- 
	JQUERY HARUS DI LOAD DULU DARIPADA BOOTSTRAP, SUPAYA MODAL BISA JALAN. 
	Modal butuh: 
	[1] 3.3.7/css/bootstrap.min.css
	[2] jquery-3.2.1.min.js (sembarang)
	[3] 3.3.7/js/bootstrap.min.js
	-->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
	<!-- 
	<script src="<>?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>	
	<script src="<>?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/js/bootstrap.min.js"></script>
	 -->
	
	 
<!--  [Kelengkapan Modal]
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script src="<>?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	 -->

  
  

	<style type="text/css">
	/*  click & scroll*/
	* {
		-webkit-user-select: none;
		-moz-user-select: moz-none;
		-ms-user-select: none;
		user-select: none;
	}
	/* \click & scroll*/

	html, body { height: 100%; margin: 0; background: #eeffff;}

	.div_center{
		margin:0px auto;
	}

	
	.mytable.table-bordered>tbody>tr>td, .mytable.table-bordered>tbody>tr>th, 
	.mytable.table-bordered>tfoot>tr>td, .mytable.table-bordered>tfoot>tr>th, 
	.mytable.table-bordered>thead>tr>td, .mytable.table-bordered>thead>tr>th {
		border: 1px solid #707070;
	}


	

	.container{
		font-weight: bold;
		height: 100vh;
		//width: 900px;
		//background:#eaeaea;
		margin:0px auto;
	}

	div[name=main] input , 
	table[name=tblDataRm] td:nth-child(1),
	table[name=tblDataRm] td:nth-child(2),
	table[name=tbl_bpjs] td:nth-child(1),
	table[name=tbl_bpjs] td:nth-child(2) {
		font-size: 12pt;
	}
	
	input[name=pasienRscm_norm]{
		width:180px;
		margin:0px 10px 10px;

	}

	table[name=tblDataRm] td:nth-child(1),
	table[name=tbl_bpjs] td:nth-child(1){
		padding-right: 10px;
		text-align: right;
		width: 150px;
	}

	table[name=tblDataRm] td:nth-child(2),
	table[name=tbl_bpjs] td:nth-child(2){
		padding-left: 10px;
		width:300px;
	}
	
	input[name=pasienRscm_norm]{
		margin:0px;
	}

	input[name=klinikTujuan], input[name=cari_jadok]{
		width:300px;
		//margin:5px 0px 45px;
		//margin:5px 0px 5px;
		
	}

	button[name=btn_daftarrj]{
		display: block; 
		width:600px; 
		height:100px; 
		font-size: 20pt; 
		font-weight:bold;
	}

		/* ================= [LOAD: MODAL>>KLINIK] ====================== */
	.container_poli{
		margin: 0px auto 0px;
		width:100%;
		padding:0px;
		//border:solid 1px black;
		overflow: auto;
		//text-align: center;

		display:grid;
		//grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
		grid-template-columns:repeat(auto-fill,minmax(130px,1fr));
		justify-items: center;
		grid-gap: 5px;
		grid-row-gap: 0px;

	}
	.obyek{
		//height:150px;
		//overflow: auto;
		width:130px;
		///width:100%;
		background:yellow;
		float: left;
		margin:5px;
		//border:solid 1px black;
		border-radius: 5px;

		-webkit-box-shadow: 0 4px 6px rgba(0, 0, 0, .3);
		-moz-box-shadow: 0 4px 6px rgba(0,0,0,.3);
		box-shadow: 0 4px 6px rgba(0,0,0,.3);
		-webkit-transition: all .15s linear;
		-moz-transition: all .15s linear;
		//transition: all .15s linear;
		z-index:0;

	}
	.obyek:hover{
		background: lightblue;
	}

	.obyek img{
		display: block;
		height: 100px;
		margin:10px auto 5px;
	}

	.obyek_title{
		height: 60px;
		/*margin:0px auto 0;*/
		margin:0px;
		color: #191919;
		font-weight: bold;
		font-size: 10pt;
	}
	.obyek_title span{
		display: inline-block;
		vertical-align: middle;
		text-align: center;
		color:#047BB9;
		width:100%;

		position: relative;
  		top: 50%;
  		transform: translateY(-50%);
	}
	
	.polaroid-images a:after {
		color: #333;
		//font-size: 20px;
		font-size: 11pt;
		font-weight:bold;
		content: attr(title);
		position: relative;
		top:5px;
	}

	.polaroid-images img { 
		display: block; 
		//width: inherit; 
		height: 100px; 
	}
	.polaroid-images a{
		background: white;
		display: inline;
		float: left;
		margin: 0 15px 30px;
		padding: 5px 5px 15px;
		text-align: center;
		text-decoration: none;
		-webkit-box-shadow: 0 4px 6px rgba(0, 0, 0, .3);
		-moz-box-shadow: 0 4px 6px rgba(0,0,0,.3);
		box-shadow: 0 4px 6px rgba(0,0,0,.3);
		-webkit-transition: all .15s linear;
		-moz-transition: all .15s linear;
		transition: all .15s linear;
		z-index:0;
	    position:relative;

	}
	
/*
	.modal-lg{
		width:1000px;
		margin:auto;
	}
*/

		/* =================\[LOAD: MODAL>>KLINIK] ====================== */


	</style>
	<script>
	$(function(event){
		//alert('tes');
		//$('#myModal').modal('show');


	});
	</script>
</head>
<body>
	<div class="container row" name="main">
		<h2 style="text-align: center; margin-top: 50px; font-weight: bold;">PILIH DOKTER &amp; KLINIK TUJUAN</h2>
		<br>

		<?=form_open(base_url().'main/sep_create');?>
		<div class="col-xs-6">
			
			<table name="tblDataRm" class="table-bordered mytable div_center">
				<tr>
					<td>No.RM</td>
					<td><input type="text" name="pasienRscm_norm" class="form-control" placeholder="Masukkan No.RM..." required></td>
				</tr>
				<tr>
					<td>Nama Lengkap</td>
					<td><span name="pasienRscm_nama">-</span></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td><span name="pasienRscm_tglLahir">-</span></td>
				</tr>
				<tr>
					<td>Umur</td>
					<td><span name="pasienRscm_umur">-</span></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td><span name="pasienRscm_jk">-</span></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td><span name="pasienRscm_alamat">-</span></td>
				</tr>
			</table>

		</div>


		<div class="col-xs-6">
			<div class="input-group" style="width:350px;">
		    	<input type="text" class="form-control" name="cari_jadok" placeholder="Cari Dokter..." required>
		    	<span class="input-group-addon btn btn-danger btn_clear">
		    		<i class="glyphicon glyphicon-remove"></i>
		    	</span>
		    </div>
			<br>

		    <div class="input-group" style="width:350px;">
		    	<input type="text" class="form-control" name="klinikTujuan" placeholder="Cari Klinik Tujuan..." required>
		    	<span class="input-group-addon btn btn-danger btn_clear">
		    		<i class="glyphicon glyphicon-remove"></i>
		    	</span>
		    </div>
		    <br>


			
			<h3 style="margin:5px auto; font-weight: bold;">BPJS</h3>
			<table name="tbl_bpjs" class="table-bordered mytable">
				<tr>
					<td width="150px">No. Kartu</td>
					<td width="300px"><input type="text" name="noka" class="form-control" placeholder="Noka..." ></td>
				</tr>
				<tr>
					<td width="150px">No. Rujukan</td>
					<td width="300px"><span name="norujukan">-</span></td>
				</tr>
			</table>


				<!-- BUKA MODAL BY [ATTR]DATA_TOGGLE
				<button class="btn btn-primary" name="btnOpen" data-toggle="modal" data-target="#modal_klinik"> Modal OPen </button> -->
		</div>
		
		<div style="clear:left; padding-top:50px;">
			<!-- 
			<button class="btn btn-primary div_center" name="btn_daftarrj" style=""> DAFTAR </button> 
			
			
			<input type="submit" class="btn btn-primary div_center" name="btn_daftarrj" value="DAFTAR" />
			-->
			<button type="submit" class="btn btn-primary div_center" name="btn_daftarrj" value="DAFTAR"> DAFTAR </button>
			
		</div>
		
		<?=form_close();?>

		





		<!-- ================ [ MODAL ] =================== -->

		<div class="modal fade" id="modal_cari_jadok" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Pilih Dokter (Sesuai Jadwal Hari Ini): </h4>
					</div>
					<div class="modal-body" id="el_modal2">

						<div class="container_cari_jadok">
							<table name="tbl_cari_jadok" class="table table-bordered">
							    <thead>
							      <tr>
							        <th>Hari</th>
							        <th>Nama Dokter</th>
							        <th>Poli Spesialis</th>
							        <th>Jam Praktek</th>
							        <th>Opsi</th>
							      </tr>
							    </thead>
							    <tbody></tbody>
						  	</table>
						</div>

					</div>
					<div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
				</div>
			</div>
		</div>



		<div class="modal fade" id="modal_klinik" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Pilih Klinik Tujuan: </h4>
					</div>
					<div class="modal-body" id="el_modal">

						<div class="container_poli"></div>

					</div>
					<div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal_klinik_alert" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Jadwal Klinik Tujuan: </h4>
					</div>
					<div class="modal-body" id="el_modal_klinik_alert">
						<span name="message" style="font-size: 14pt; margin-bottom: 10px;" ></span>
						<div class="container_poli_alert">
							<table name="tbl_klinik_alert" class="table table-bordered">
							    <thead>
							      <tr>
							        <th>Hari</th>
							        <th>Nama Dokter</th>
							        <th>Poli Spesialis</th>
							        <th>Jam Praktek</th>
							      </tr>
							    </thead>
							    <tbody></tbody>
						  	</table>
						</div>

					</div>
					<div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
				</div>
			</div>
		</div>
		
		
		<!-- ================ [\MODAL ] =================== -->

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
		//==================== [CLICK & SCROLL] ======================
		var curDown = false,
			curYPos = 0,
			curXPos = 0;

		$(window).mousemove(function(m){
			if(curDown === true){
				$(window).scrollTop($(window).scrollTop() + (curYPos - m.pageY)); 
				$(window).scrollLeft($(window).scrollLeft() + (curXPos - m.pageX));
			}
		});

		$(window).mousedown(function(m){
			curDown = true;
			curYPos = m.pageY;
			curXPos = m.pageX;
		});

		$(window).mouseup(function(){
			curDown = false;
		});



		//====================\[CLICK & SCROLL] ======================


		function hitungUmurPart(birthDay, birthMonth, birthYear) {
		    var currentDate = new Date();
		    var currentYear = currentDate.getFullYear();
		    //var currentMonth = currentDate.getMonth();
		    var currentMonth = (currentDate.getMonth())+1;//karena januari nilainya 0
		    var currentDay = currentDate.getDate(); 
		    var calculatedAge = currentYear - birthYear;
		    if(calculatedAge>0){
		    	if (currentMonth < birthMonth) {
			        calculatedAge--;
			    }else{
			    	if(currentDay < birthDay){
			    		calculatedAge--;
			    	}
			    }
		    }
		    return calculatedAge;
		}

		function hitungUmur(dateLahir){
			let res = dateLahir.split("-");
			let tglLahir = res[2];
			let blnLahir = res[1];
			let thnLahir = res[0];
			return hitungUmurPart(tglLahir, blnLahir, thnLahir);
		}

		function input_hdn(name,val){
			return '<input type="hidden" name="'+name+'" value="'+val+'">';
		}



		const jmlDigitRmRscm = 6;

		$( "input[name=pasienRscm_norm]" ).focusout(function() {
			let norm = $(this).val();
			let hitungDigit = norm.length;
			
			if(hitungDigit!=jmlDigitRmRscm){
				alert("NoRM harus 6 digit");
			}else{
				$.ajax({
					async: false,
					url:"<?=base_url();?>ajaxreq/gd_pasien_rscm_by_norm",
					data:{norm : norm},
					type:"POST",
					success:function(data){
						let js = JSON.parse(data);
						//alert(dtjson[0].TglLahir);
						//alert(js.datajs[0].NoRM);

						if(js.count==1){
							$('span[name=pasienRscm_nama]').text(js.datajs[0].Nama);
							$('form').append(input_hdn('pasien_nama',js.datajs[0].Nama));

							$('span[name=pasienRscm_tglLahir]').text(js.datajs[0].TglLahir);
							$('form').append(input_hdn('pasien_tglLahir',js.datajs[0].TglLahir));

							$('span[name=pasienRscm_umur]').text(hitungUmur(js.datajs[0].TglLahir)+' Tahun');
							$('form').append( input_hdn('pasien_umur', hitungUmur(js.datajs[0].TglLahir) ));

							$('span[name=pasienRscm_jk]').text(js.datajs[0].Sex);
							$('form').append(input_hdn('pasien_jk',js.datajs[0].Sex));

							$('span[name=pasienRscm_alamat]').text(js.datajs[0].Alamat);
							$('form').append(input_hdn('pasien_alamat',js.datajs[0].Alamat));
						}else{
							$('span[name=pasienRscm_nama]').text('-');
							$('span[name=pasienRscm_tglLahir]').text('-');
							$('span[name=pasienRscm_umur]').text('-');
							$('span[name=pasienRscm_jk]').text('-');
							$('span[name=pasienRscm_alamat]').text('-');
						}
						
						
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert("ERROR[gd_pasien_rscm_by_norm]: "+errorThrown);
					}
				});
			}

		});

		$('input[name=cari_jadok]').click(function(){
			let inputKlinik = $('input[name=klinikTujuan]').val();
			let fl_klinik, spesialis;
			if(inputKlinik == ''){
				fl_klinik = 0;
				spesialis = '';
			}else{
				fl_klinik = 1;
				spesialis = inputKlinik;
			}
			//alert(fl_klinik);

			$.ajax({
				async: false,
				url:"<?=base_url();?>ajaxreq/get_jadok_today",
				type:"POST",
				data: { 
					fl_klinik : fl_klinik,
					spesialis : spesialis 
				},
				success:function(data){
					console.log(data);
					let js = JSON.parse(data);

					//$('table[name=tbl_cari_jadok] tbody').children().remove();
					$('table[name=tbl_cari_jadok] tbody').children().remove();
					for(let i=0; i<js.dtjs.length; i++){
						let el = 
							'<tr>'+
								'<td>'+js.dtjs[i].hari+'</td>'+
								'<td name="nama">'+js.dtjs[i].Nama+'</td>'+
								'<td name="spesialis">'+js.dtjs[i].Spesialis+'</td>'+
								'<td>'+js.dtjs[i].jamMasuk+' - '+js.dtjs[i].jamPulang+'</td>'+
								'<td><button class="btn btn-success">Pilih</button></td>'+
							'</tr>';

						$('table[name=tbl_cari_jadok] tbody').append(el);
					}
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log("ERROR[get_klinik]: "+errorThrown);
				}
			});

			$('#modal_cari_jadok').modal('show');
		});



		$('input[name=klinikTujuan]').click(function(){
			$('#modal_klinik').modal('show');
		});

		// $('#el_modal button').click(function(){
		// 	//alert("OKEE");
		// 	alert($(this).data('val'));
		// });

		



		$.ajax({
			async: false,
			url:"<?=base_url();?>ajaxreq/get_klinik",
			type:"POST",
			success:function(data){
				let js = JSON.parse(data);

				for(let i=0; i<js.dtjs.length; i++){

					let el = 
						'<div class="obyek" data-id="'+js.dtjs[i].Kode+'">'+
							'<img src="<?=base_url();?>assets/img/icon-spesialis/tes/'+js.dtjs[i].Keterangan+'.png" alt="'+js.dtjs[i].Keterangan+'" />'+
							'<div class="obyek_title"><span>'+js.dtjs[i].Keterangan+'</span></div>'+
						'</div>';

					$('#el_modal .container_poli').append(el);

					//>[UNTUK MENGATUR FONT-SIZE LABEL POLI YANG PANJANG]
					if(js.dtjs[i].Keterangan.length > 30){
						console.log(js.dtjs[i].Keterangan.length);
						$('.container_poli').find('.obyek[data-id='+js.dtjs[i].Kode+'] .obyek_title span').css("font-size", "95%");
					}


				}
			},
			error:function(jqXHR,textStatus,errorThrown){
				console.log("ERROR[get_klinik]: "+errorThrown);
			}
		});


		$(document).on('click','table[name=tbl_cari_jadok] tbody tr td button', function(){
			
			let namaDokter_pilih = $(this).parent().parent().find('td[name=nama]').text();
			let spesialis_pilih  = $(this).parent().parent().find('td[name=spesialis]').text();
			$('#modal_cari_jadok').modal('hide');

			// //console.log(klinik_kode+'_'+klinik_ket);
			$('input[name=cari_jadok]').val(namaDokter_pilih);
			$('input[name=klinikTujuan]').val(spesialis_pilih);
		});


		/*====================== [CLICK DIV KLINIK TUJUAN] ====================*/
		$(document).on('click','.obyek', function(){
			let klinik_kode = $(this).data('id');
			let klinik_ket = $(this).text();

			/* 
				<CEK ADA/TIDAKNYA JADWAL SPESIALIS PADA HARI ITU> 
				Bila TIDAK ADA dokter yang hadir hari itu, muncul modal "Jadwal Spesialis" yg dipilih tersebut buka pada hari apa saja.
			*/
			$.ajax({
				async: false,
				url:"<?=base_url();?>ajaxreq/get_jadok_today",
				type:"POST",
				data: { 
					fl_klinik : '1', //1= kliniknya diisi/sudah dipilih
					spesialis : klinik_ket 
				},
				success:function(data){
					console.log(data);
					let js = JSON.parse(data);
					if(js.count == 0){
						//console.log('Mohon maaf, Hari ini tidak ada jadwal spesialis tersebut.');
						$('input[name=klinikTujuan]').val('');
						
						/* <GET SEMUA JADWAL SPESIALIS YANG SUDAH DIPILIH USER>  */
						$.ajax({
							async: false,
							url:"<?=base_url();?>ajaxreq/get_jadok_by_namaspesialis",
							type:"POST",
							data: { 
								spesialis : klinik_ket 
							},
							success:function(data){
								console.log(data);
								let js = JSON.parse(data);
								$('table[name=tbl_klinik_alert] tbody').children().remove();
								for(let i=0; i<js.dtjs.length; i++){
									let el = 
										'<tr>'+
											'<td>'+js.dtjs[i].hari+'</td>'+
											'<td name="nama">'+js.dtjs[i].Nama+'</td>'+
											'<td name="spesialis">'+js.dtjs[i].Spesialis+'</td>'+
											'<td>'+js.dtjs[i].jamMasuk+' - '+js.dtjs[i].jamPulang+'</td>'+
										'</tr>';

									$('table[name=tbl_klinik_alert] tbody').append(el);
								}

								$('span[name=message]').html(
									'Mohon maaf, hari ini tidak ada jadwal '+klinik_ket+'. <br>'+
									'Jadwal klinik tujuan '+klinik_ket+' : '
								);
								
							},
							error:function(jqXHR,textStatus,errorThrown){
								console.log("ERROR[ajaxreq/get_jadok_by_namaspesialis]: "+errorThrown);
							}
						});

						$('#modal_klinik_alert').modal('show');

					}else{
						$('input[name=klinikTujuan]').val(klinik_ket);
					}
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log("ERROR[get_klinik]: "+errorThrown);
				}
			});


			$('input[name=cari_jadok]').val('');
			$('#modal_klinik').modal('hide');
			//console.log(klinik_kode+'_'+klinik_ket);
			
		});


		$('.btn_clear').click(function(){
			$('input[name=cari_jadok]').val('');
			$('input[name=klinikTujuan]').val('');			
		});



		// $('button[name=btn_daftarrj]').click(function(){
		// 	if($('input[name=cari_jadok]').val() == '' || $('input[name=klinikTujuan]').val()==''){
		// 		alert('Semua kolom isian harus diisi.');
		// 	}else{
		// 		//alert('Iki data seng diolah...'+$('input[name=cari_jadok]').val()+'___'+$('input[name=klinikTujuan]').val());
		// 		//let url = '@Url.Action("ActionMethod", "<>?=base_url();?>main/sep_create")';
		// 		let url = '<>?=base_url();?>main/sep_create';
		//     	url += '?nama_dokter=' + escape( $('input[name=cari_jadok]').val() );
		//     	url += "&klinik_tujuan=" + escape( $('input[name=klinikTujuan]').val() );
		//     	url += "&param3=" + escape('xyz');

		//         window.location.href = url;
		// 	}
		// });


	});

	</script>





</body>
</html>