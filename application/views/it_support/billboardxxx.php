<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <title>Full Slider - Start Bootstrap Template</title> -->
    <title>RS. Citra Medika - Billboard</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('assets/daftarmandirirjpx/');?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('assets/daftarmandirirjpx/');?>css/full-slider.css" rel="stylesheet">
	<style>
		body{
			height:100%;
		}

		.page-100persen{
			height: auto;
			max-width: 100%;
		}

		/*.dark-tosca{background-color: #377C73;}*/
		.dark-tosca{background-color: rgba(55,124,115, 0.9);}
		.text-dark-tosca{color: #377C73;}
		.text-sdark-tosca{color: #284340;}

		.carousel-bg{
			/*background-image: url("<.?=base_url('assets/daftarmandirirjpx/');?>img/rscm/RS Citra Medika-coloring2-lite.jpg");*/
			background-image: url("<?=base_url('assets/daftarmandirirjpx/');?>img/rscm/rscm-kanan.JPG");
			opacity: 0.9;
			//filter: alpha(opacity=80); /* For IE8 and earlier */
			background-size: cover; 
			background-position:center;
		}

		.h-nav{
			height:71px;
		}

		.mt-from-nav{
			margin-top:50px;
		}
		.pt-from-nav{
			margin-top:50px;
		}
	</style>
	<style>
		/*CSS untuk set item loader loop di element slider*/
		.bold{ font-weight: bold; }
		.card{
			margin-bottom: 10px;
		}

		.card-nomor, .card-label{
			text-align: center;
		}

		.card-label{
			height:50px;
			border-radius: 0px 0px 10px 10px;
			vertical-align: middle;
		}

		.card-nomor{
			border-radius: 10px 10px 0px 0px;
		}

		.card-nomor span{
			display: inline;
			font-size: 36pt;
		}

		.card-label span{
			display: inline;
			font-size: 20pt;
			vertical-align: middle;
			height:50px;
			
			/*padding-top: 5px;*/
		}


		/*judul header tabel*/
		table[name=tbl_ld_jadok] thead tr th{ 
			text-align: center;
			font-size: 16pt;
			font-weight: bold;
			padding:0px;
		}

		table[name=tbl_ld_jadok] thead{
			background-color: #1b6d67;
			color: white;
		}

		table[name=tbl_ld_jadok] tbody tr td div.obj-jadok{
			background: #b7fffa; 
			margin-bottom: 5px;
			padding-left: 5px;
			/*overflow: auto; */
			border-radius: 0px 5px 0px 5px;
		}

		table[name=tbl_ld_jadok] tbody tr td div.obj-jadok div[name=sp]{
			font-size: 10pt;
		}

		table[name=tbl_ld_jadok] tbody tr td div.obj-jadok div[name=namaDokter],
		table[name=tbl_ld_jadok] tbody tr td div.obj-jadok div[name=jamPraktek]{
			font-size: 8pt;
		}


		.tosca-light{
			background-color: #b7fffa;
		}
		.tosca-dark{
			background-color: #58e2d7;
		}
		.tosca-sdark{
			background-color: #1b6d67;
		}

		.card div.card-nomor, .card div.card-label{
			-webkit-box-shadow: 0 4px 6px rgba(0, 0, 0, .3); 
			-moz-box-shadow: 0 4px 6px rgba(0,0,0,.3); 
			box-shadow: 0 4px 6px rgba(0,0,0,.3);
		}

		
		.vertical-text,.label_hari {
			/*transform: rotate(90deg);
			transform-origin: left top 0;*/

			word-wrap: break-word;
		    width:10px;
		    padding:0.9em;
		    box-sizing:border-box;
		    text-transform:uppercase;
		}


		/* tbl_ld_jadok_v2 */
		/*table[name=tbl_ld_jadok_v2]{
			background-color: #b7fffa; 
		}*/
		table[name=tbl_ld_jadok_v2] tbody tr td{
			padding: 0px;
			font-size: 10pt;
		}


		.label_hari{
			text-align: center; 
			vertical-align: middle;
		}
		.label_hari div{
			word-wrap: break-word;
		    width:10px;
		    margin: 0px auto;
		}

		/* \tbl_ld_jadok_v2 */

		/*SET SPEED CAROUSEL*/
		.carousel-inner .carousel-item {
		  transition: -webkit-transform 2s ease;
		  transition: transform 2s ease;
		  transition: transform 2s ease, -webkit-transform 2s ease;
		}
		/* \SET SPEED CAROUSEL*/

	</style>
  </head>

  <!-- <body data-user_logged_in="<?=$username;?>" data-baseurl="<.?=base_url();?>"> -->
  <body data-baseurl="<?=base_url();?>">
  		<!-- Navigation -->
	    <nav class="navbar navbar-expand-lg navbar-dark dark-tosca fixed-top" >
	      <div class="container">

	        <a class="navbar-brand" href="#"><img src="<?=base_url('assets/daftarmandirirjpx/');?>img/rscm/LOGO RSCM BARU.png" alt="" width="200"></a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>

	        <!-- <div class="collapse navbar-collapse" id="navbarResponsive">
	          <ul class="navbar-nav ml-auto">
	            <li class="nav-item active">
	              <a class="nav-link" href="#">Home
	                <span class="sr-only">(current)</span>
	              </a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link" href="#">About</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link" href="#">Services</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link" href="#">Contact</a>
	            </li>
	          </ul>
	        </div> -->
	        <div>
	        	<!-- <button class="btn btn-primary" style="float:right;">DAFTAR</button> -->
	        	<a href="<?=base_url();?>daftarmandiri/daftaronline" class="btn btn-primary" style="float:right;">DAFTAR</a>
	        	<h3 style="float:right; margin-right:20px; color:#FFF;">PENDAFTARAN MANDIRI &rarr;</h3>
	        </div>
	      </div>
	    </nav>


	    <header class="text-sdark-tosca">
	      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
	        <ol class="carousel-indicators">
	          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
	        </ol>

	        <div class="carousel-inner carousel-bg" role="listbox">

	          <!-- Slide One - Set the background image for this slide in the line below -->
	          <!-- <div class="carousel-item active" >
	            <div class="container">
	            	<div class="h-nav"></div>
            		<h3>Selamat Datang di Rumah Sakit Citra Medika</h3>
					<button class="btn btn-primary" href="#carouselExampleIndicators" role="button" data-slide="next">Selanjutnya &raquo;</button> 
	            </div>
	          </div> -->

	          <!-- Slide x -->
	          <!-- <div class="carousel-item active">
	          	<div class="container">
					<div class="h-nav"></div>
	            	<div class="row">
						<h2 class="text-center bold" style="margin:5px auto;">JADWAL DOKTER SPESIALIS</h2>
					</div>
					<hr style="margin-top: 0px;">
					
						<div name="ld_jadok">
							<table class="table table-stripped table-bordered tosca-light" name="tbl_ld_jadok_v2">
								<thead>
									<tr>
										<th>HARI</th>
										<th>SPESIALIS</th>
										<th>NAMA</th>
										<th>JAM PRAKTEK</th>
									</tr>
								</thead>
								<tbody>
									<tr name="hari1">
										<td class="bold label_hari"><div>SENIN</div></td>
									</tr>
									<tr name="hari2">
										<td class="bold label_hari"><div>SELASA</div></td>
									</tr>
								</tbody>
							</table>
						</div>

	          	</div>
	          </div> -->

	          <!-- Slide 2 -->
	          <div class="carousel-item active">
							<div class="container">
								<div class="h-nav"></div>
								<div class="row">
									<h2 class="text-center bold" style="margin:5px auto;">INFORMASI KETERSEDIAAN KAMAR</h2>
								</div>
								<hr style="margin-top: 0px;">
								<div name="ld_kamar_ready"></div>

							</div>
	        	</div>


	          <!-- Slide 3 - Set the background image for this slide in the line below -->
	          <div class="carousel-item">
	          	<div class="container">
					<div class="h-nav"></div>
	            	<div class="row">
						<h2 class="text-center bold" style="margin:5px auto;">JADWAL DOKTER SPESIALIS</h2>
					</div>
					<hr style="margin-top: 0px;">
					
						<div name="ld_jadok">
							<table class="table table-stripped table-bordered" name="tbl_ld_jadok">
								<thead>
									<tr style="text-align: center;">
										<th>SENIN</th>
										<th>SELASA</th>
										<th>RABU</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td name="hari1"></td>
										<td name="hari2"></td>
										<td name="hari3"></td>
									</tr>
								</tbody>
							</table>
						</div>

	          	</div>
	          </div>


	          <!-- Slide 4 -->
	          <div class="carousel-item">
	          	<div class="container">
					<div class="h-nav"></div>
	            	<div class="row">
						<h2 class="text-center bold" style="margin:5px auto;">JADWAL DOKTER SPESIALIS</h2>
					</div>
					<hr style="margin-top: 0px;">
					
						<div name="ld_jadok">
							<table class="table table-stripped table-bordered" name="tbl_ld_jadok">
								<thead>
									<tr>
										<th>KAMIS</th>
										<th>JUM'AT</th>
										<th>SABTU</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td name="hari4"></td>
										<td name="hari5"></td>
										<td name="hari6"></td>
									</tr>
								</tbody>
							</table>
						</div>

	          	</div>
	          </div>




	        </div>
	        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	          <span class="sr-only">Previous</span>
	        </a>
	        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	          <span class="carousel-control-next-icon" aria-hidden="true"></span>
	          <span class="sr-only">Next</span>
	        </a>
	      </div>
	    </header>

	    <!-- Footer -->
	    <!-- <footer class="py-2 bg-dark"> -->
	    <footer class="py-2 navbar-dark dark-tosca fixed-bottom">
	        <p class="m-0 text-center text-white">Copyright &copy; Rumah Sakit Citra Medika</p>
	    </footer>
  	
	    

    <!-- Bootstrap core JavaScript -->
    <script src="<?=base_url('assets/daftarmandirirjpx/');?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/daftarmandirirjpx/');?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

