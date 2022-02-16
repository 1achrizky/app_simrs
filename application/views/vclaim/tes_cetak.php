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
	<div class="container">
		<?//=form_open(base_url()."ajaxreq/cetak_a");?> 
		<!-- NDUWUR IKI ILANGONO COMMENT e, LHA WES ISO -->
		<div>
			<input name="noKartu" type="text">
			<input name="tglSep" type="text">
			<button name="tes_cetak">Tes cetak</button>
			<button name="tes_curl">Tes CURL</button> <br>

			<button type="submit" class="btn btn-primary" name="btn_submit" > SUBMIT! </button>

		</div>
		<?//=form_close();?>

		<div id="div_frame">
			<!-- <iframe src="<..?=base_url();?>application/views/vclaim/sep_resume_cetak.php" name="frame"></iframe> -->
			<!-- <iframe src="<..?=base_url();?>ajaxreq/tes_cetak" name="frame"></iframe> -->
			<!-- <iframe src="<..?=base_url();?>ajaxreq/tes_cetak_enc/?noKartu=123&tglSep=2018-06-26" name="frame" style="display:none;"></iframe> -->
			<!-- <iframe id="frame" src="<..?=base_url();?>ajaxreq/tes_cetak_enc" name="frame" ></iframe> -->

			<iframe src="<?=base_url();?>application/third_party/PHPExcel-1.8/Coba/sample/RESUME_SEP.xlsx" name="frame2"></iframe>

			<input type="button" onclick="frames['frame'].print()" value="printletter">
			<button name="print" >PRINT</button>
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
		console.log(moment().format('YYYY-MM-DD hh:mm:ss'));
		

		let poli_tujuan_ax, ppkRujukan_ax, tglRujukan_ax, noRujukan, tglSep_ax, noKartu_ax;
		let jnsPelayanan_ax, klsRawat_ax, diagAwal_ax;
		let nomr_ax;

		$("input[name=noRujukanCari]").keypress(function (e) { //TEKAN ENTER
			noRujukan = $(this).val();
	 		
		});


		$('button[name=tes_curl]').click(function(){
			//alert('curl');
			// //window.print();
			$.ajax({
				async: false,
				url:"<?=base_url();?>ajaxreq/curl_tes",
				type:"POST",
				data:{
					// noKartu : 'param',
					// tglSep : 'tglNow'
					noKartu : $('input[name=noKartu]').val(),
					tglSep : $('input[name=tglSep]').val()
				},
				success:function(data){					
					let src = "<?=base_url();?>ajaxreq/tes_cetak_enc/?js="+data;

					var iframe = $('<iframe id="frame" name="frame" src="'+src+'" style="display:none;"></iframe>');
					$("#div_frame").append(iframe);
					window.frames['frame'].print();
					//$("#div_frame").find("#frame").remove();

				},
				error:function(jqXHR,textStatus,errorThrown){
					alert("Error SEP Cari By Noka: "+errorThrown);
				}
			});
		});

		$('button[name=tes_cetak]').click(function(){
			//alert('oke');
			//window.print();
			$.ajax({
					async: false,
					//url:"<?=base_url();?>ajaxreq/tes_cetak",
					url:"<?=base_url();?>ajaxreq/tes_cetak_render",
					type:"POST",
					data:{
						noKartu : 'param',
						tglSep : 'tglNow'
					},
					success:function(data){
						alert(data);
						//////frames['frame'].print();
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert("Error SEP Cari By Noka: "+errorThrown);
					}
				});
		});

		//$('button[name=print]').click(function(){
		$(document).on('click','button[name=print]', function(){
			//alert("op");
			let noKartu = '123Riz';
			let o = {
			    noKartu: noKartu,
			    tglSep: '2018-06-26'
			};
			let js_post = JSON.stringify(o); //IKI KUDU DIGANTI PETIK E
			//alert(JSON.stringify(o));

			////let src = "<?=base_url();?>ajaxreq/tes_cetak_enc/?noKartu=123&tglSep=2018-06-26";
			let src = "<?=base_url();?>ajaxreq/tes_cetak_enc/?js="+js_post;
			
			var iframe = $('<iframe  id="frame" name="frame" src="' + src + '"></iframe>');
			$("#div_frame").append(iframe);

			window.frames['frame'].print();

			$("#div_frame").find("#frame").remove();
		});

		//let js_aj =[];
		



	});

	</script>





</body>
</html>