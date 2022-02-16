<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pendaftaran Antrian Online RS Citra Medika</title>

	<link href="<?=base_url();?>assets/plugin/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css">

	<style type="text/css">
		html, body { height: 100%; margin: 0; background: #eeffff;}

		.container{
			text-align: center; 
			font-weight: bold;
			height: 100vh;
			width: 100%;
			//background:#eaeaea;
			padding-top: 20px;
		}
		.labelPilih{
			height:20vh;
			line-height: 15vh;
			background:yellow;
			text-align: center;
			font-weight: bold;
		}
		.btnPilihPeserta{
			height:32vh;
			width:50%;
			//line-height: 32vh;
			margin:10px auto 10px;
			padding:0px;
			text-align: center;
			font-weight: bold;
			font-size: 26pt;
			border-radius: 10px;
		}

		h4{
			font-size: 26pt;
			margin-top: 50px;
			font-weight: bold;
		}
	</style>

</head>
<body>
	<div class="container">
		<h4>PENDAFTARAN PASIEN RAWAT JALAN</h4>
		<button class="btn btn-success btnPilihPeserta" name="btnBpjs" data-penanggung="bpjs"> BPJS </button>
		<button class="btn btn-primary btnPilihPeserta" name="btnUmum" data-penanggung="umum"> UMUM </button>
		<!-- 
		<div class="btn-success">BPJS</div>
		<div class="btn-primary">UMUM</div> -->
	</div>


	<script src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
  	<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.xdomainrequest.min.js"></script>
  	<script type="text/javascript" src="<?=base_url();?>assets/js/moment-with-locales.js"></script>

	<script>
	$(function(eve){
		let tglNow = moment().format('YYYY-MM-DD');
		let contentType ="application/x-www-form-urlencoded; charset=utf-8";
		if(window.XDomainRequest) contentType = "text/plain";
		//=============== formPasien.php=============================

		const base_url_max_idx = '<?=base_url();?>'.split('/').length-2;
		function uri_segment(segment){
			let fullpath = window.location.protocol + "//" + window.location.host + window.location.pathname;
			return fullpath.split('/')[base_url_max_idx+segment];
		}
		
		console.log(uri_segment(1));


		$('button[name=btnBpjs]').click(function(){
			window.location.href= '<?=base_url();?>'+uri_segment(1)+'/scanrujukan';
		});
	});
	</script>

</body>
</html>