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

		/* =================\[LOAD: MODAL>>KLINIK] ====================== */


	</style>

</head>
<body>
	<div class="container row" name="main">
		<h2 style="text-align: center; margin-top: 50px; font-weight: bold;">Referensi Kamar</h2>
		<br>
		<span>Referensi Kamar</span>
		<select name="referensi_kamar" id="referensi_kamar">
			<option value=""></option>
		</select>


		<div class="col-xs-6">
			<table name="tblDataRm" class="table-bordered mytable div_center">
				<tr>
					<td>No.RM</td>
					<td><input type="text" name="pasienRscm_norm" class="form-control" placeholder="Masukkan No.RM..." required></td>
				</tr>
				<tr>
					<td>No.RM</td>
					<td><input type="text" name="pasienRscm_norm" class="form-control" placeholder="Masukkan No.RM..." required></td>
				</tr>
			</table>
		</div>

		<div class="col-xs-6">
			<table class="table-borderless" border="0">
				<tr><td>
						<input type="text" name="cari_jadok" class="form-control" style="float:left;" placeholder="Cari Dokter..." required>
						<button class="btn btn-danger btn_clear" style="float:left;margin-bottom:20px;">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
					</td>
				</tr>
				<tr><td>
						<input type="text" name="klinikTujuan" class="form-control" style="float:left;" placeholder="Cari Klinik Tujuan..." required>
						<button class="btn btn-danger btn_clear" style="float:left;margin-bottom:20px;">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>

					</td>
				</tr>

			</table>
			
			<h3 style="margin:5px auto; font-weight: bold;">BPJS</h3>
			<table name="tbl_bpjs" class="table-bordered mytable">
				<tr>
					<td width="150px">No. Kartu</td>
					<td width="300px"><input type="text" name="noka" class="form-control" placeholder="Noka..." required></td>
				</tr>
				<tr>
					<td width="150px">No. Rujukan</td>
					<td width="300px"><span name="norujukan">-</span></td>
				</tr>
			</table>


				<!-- 
				<button class="btn btn-primary" name="btnOpen" data-toggle="modal" data-target="#modal_klinik"> Modal OPen </button> -->
		</div>
		
		<div style="clear:left; padding-top:50px;">
			<button class="btn btn-primary div_center" name="btn_tes" style=""> DAFTAR </button>

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

		$.ajax({
			async: false,
			url:"<?=base_url();?>ajaxreq/referensi_kamar",
			type:"POST",
			data: { 
				url_req : 'aplicaresws/rest/ref/kelas'
			},
			success:function(data){
				console.log(data);
				let js = JSON.parse(data);
				
			},
			error:function(jqXHR,textStatus,errorThrown){
				console.log("ERROR[ajaxreq/referensi_kamar]: "+errorThrown);
			}
		});


		console.log(moment().format('YYYY-MM-DD hh:mm:ss'));
		$('button[name=btn_tes]').click(function(){
			alert('plm');
			$.ajax({
				async: false,
				url:"<?=base_url();?>main/sep_create",
				type:"POST",
				data: { 
					fl_klinik : fl_klinik,
					spesialis : spesialis 
				},
				success:function(data){
					console.log(data);
					let js = JSON.parse(data);
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log("ERROR[get_klinik]: "+errorThrown);
				}
			});
		});



	});

	</script>





</body>
</html>