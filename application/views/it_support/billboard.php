<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Billboard</title>

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
				height:40px;
				border-radius: 0px 0px 10px 10px;
				vertical-align: middle;
			}

			.card-nomor{
				border-radius: 10px 10px 0px 0px;
			}

			.card-nomor span{
				display: inline;
				font-size: 28pt;
			}

			.card-label span{
				display: inline;
				font-size: 16pt;
				vertical-align: middle;
				height:40px;
				
				/*padding-top: 5px;*/
			}


			/*judul header tabel*/
			table[name=tbl_ld_jadok] thead tr th{ 
				text-align: center;
				font-size: 14pt;
				font-weight: bold;
				padding:0px;
			}			
			
			table[name=tbl_ld_jadok] thead{
				background-color: #1b6d67;
				color: white;
			}


			table[name=tbl_ld_jadok] tbody tr td{ 
				width:50%;
			}

			/* div.obj-jadok{
				background: #b7fffa; 
				margin-bottom: 5px;
				padding-left: 5px;
				border-radius: 0px 5px 0px 5px;
			} */
			
			/* elemen loop database jadok */
			span.obj-jadok{
				display:inline-block;
				background: #b7fffa; 
				margin-bottom: 5px;
				padding-left: 5px;
				border-radius: 0px 5px 0px 5px;
				/* width:32%; */
				width:48%;
				/* height:60px; */
				margin:3px;
				vertical-align:top;
			}

			.w50{
				width:50%;
			}

			.obj-jadok div[name=sp]{
				font-size: 10pt;
			}

			/* table[name=tbl_ld_jadok] tbody tr td div.obj-jadok div[name=namaDokter],
			table[name=tbl_ld_jadok] tbody tr td div.obj-jadok div[name=jamPraktek]{ */
			.obj-jadok div[name=namaDokter],
			.obj-jadok div[name=jamPraktek]{
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

			
			.konten_slider_scroll{
				overflow-y: scroll; overflow-x: hidden; 
				height:470px;
			}


			.konten_slider_scroll::-webkit-scrollbar-track
			{
				-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
				background-color: #F5F5F5;
			}

			.konten_slider_scroll::-webkit-scrollbar
			{
				width: 6px;
				background-color: #F5F5F5;
			}

			.konten_slider_scroll::-webkit-scrollbar-thumb
			{
				background-color: #AAAAAA;
			}



	/*or anything else you what this to show/hide*/
	/*		@media (min-width: 1024px){
	        .respoonsive-on{
	        text-decoration: none;
	        display: block;
	    }
	    .respoonsive-off{
	        text-decoration: underline;
	        font-weight: bold;
	        display: none;
	    }

	}
	}
	@media (max-width: 1024px){
	            .respoonsive-on{
	        text-decoration: underline;
	        font-weight: bold;
	        display: none;
	    }
	        .respoonsive-off{
	        display: block;
	        font-weight: normal;
	    }
	}*/


		</style>
  </head>

  <body>
  		<!-- Navigation -->
	    <nav class="navbar navbar-expand-lg navbar-dark dark-tosca fixed-top" >
	      <div class="container">
	        <a class="navbar-brand" href="#"><img src="<?=base_url('assets/daftarmandirirjpx/');?>img/rscm/LOGO RSCM BARU.png" alt="" width="150"></a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>

          <div>
	        	<!-- <button class="btn btn-primary" style="float:right;">DAFTAR</button> -->
	        	<a href="<?=base_url();?>daftarmandiri/daftaronline" class="btn btn-primary" style="float:right;">DAFTAR</a>
	        	<h3 style="float:right; margin-right:20px; color:#FFF;">PENDAFTARAN MANDIRI &rarr;</h3>
	        </div>

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
	        
	      </div>
	    </nav>


	    <header class="text-sdark-tosca">
	      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
	        <ol class="carousel-indicators">
	          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
	        </ol>

	        <div class="carousel-inner carousel-bg" role="listbox">


	          <!-- Slide 2 -->
	          <div class="carousel-item active">
							<div class="container">
								<div class="h-nav"></div>
								<div class="row">
									<h2 class="text-center bold" style="margin:5px auto;">INFORMASI KETERSEDIAAN KAMAR</h2>
								</div>

								<!-- <hr style="margin-top: 0px;"> -->
								<div name="ld_kamar_ready" class="konten_slider_scroll">
									<?php

										// $m_info = new M_info();
										// $onload = $m_info->onload();
										// // echo json_encode( $onload ); exit;

										$beds = $onload['beds'][0]['data'];
										$jadok = $onload['jadok'][0]['data'];
										// echo $onload['get_last_update'];


										// PINDAHAN DARI JS
										$len = count($beds);
										$el_col = ''; $el_col_awal = '';
										$i = 0; 
										$j = 0;
										$arr = 0; //arr dimulai dari 0, ini utk load data_array js

										$n_row = 4; $n_col = 4;

										for($j=0; $j<$n_row; $j++ ){
											// console.log('j='+j);
											for($i=0; $i<$n_col; $i++){
												$arr = (($j*$n_row)+$i);
												//console.log( arr );
												if(($arr+1) <= $len ){ //jika data_array <= len. Untuk batas create el_col yg arr nya overload 
													// ////////////////// console.log('arr='+arr+'__'+js[arr].jmlReady+'_'+js[arr].namaRuang );
													$el_col_awal = 
															'<div class="col-sm-3">'.
																'<div class="card">'.
																	'<div class="card-nomor" style="background-color: #b7fffa;">'.
																		'<span class="card-title bold">'.$beds[$arr]['jmlReady'].'</span>'.
																	'</div>'.
																	'<div class="card-label" style="background-color: #58e2d7; ">'.
																		'<span class="bold">'.$beds[$arr]['namaRuang'].'</span>'.
																	'</div>'.
																'</div>'.
															'</div>';
													$el_col .= $el_col_awal;
												}else{ //jika loop data_arr sudah habis, tidak perlu cetak el_col
													$arr = '';
													// console.log('arr='+arr);
												}           
																
											} // ENDloop i(per col)
											

											$el_row = '<div class="row">'.$el_col.'</div>';
											echo $el_row;
											// $('div[name=ld_kamar_ready]').append(el_row);
											$el_col = '';
										}

									?>

								</div>

							</div>
      			</div>



			<?php
			$hr = $jadok;

			$arr_el = [];
			$el = '';
			for($hariId=0; $hariId<6; $hariId++){
        for($i=0; $i<$hr[$hariId]['cnt']; $i++){
          // $el .= 
          //     '<div class="obj-jadok">'.
          //       '<div name="sp" class="bold">'.$hr[$hariId]['dt_hr'][$i]['Spesialis'].'</div>'.
          //       '<div class="row">'.
          //         '<div name="namaDokter" class="col-8">'.$hr[$hariId]['dt_hr'][$i]['Nama'].'</div>'.
          //         '<div name="jamPraktek" class="col-4">'.$hr[$hariId]['dt_hr'][$i]['jamMasuk'].'-'.$hr[$hariId]['dt_hr'][$i]['jamPulang'].'</div>'.
          //       '</div>'.
          //     '</div>';
					
					
					$el .= 
              '<span class="obj-jadok">'.
								'<div name="sp" class="bold">'.$hr[$hariId]['dt_hr'][$i]['Spesialis'].
									
								'</div>'.
								'<div name="namaDokter">'.$hr[$hariId]['dt_hr'][$i]['Nama'].
									' ('.$hr[$hariId]['dt_hr'][$i]['jamMasuk'].'-'.$hr[$hariId]['dt_hr'][$i]['jamPulang'].')'.
								'</div>'.
                // '<div name="namaDokter">('.$hr[$hariId]['dt_hr'][$i]['jamMasuk'].'-'.$hr[$hariId]['dt_hr'][$i]['jamPulang'].')</div>'.
								
              '</span>';

           
        }

        $arr_el[] = $el;
        $el = '';
      }

			?>
      <!-- Slide 3 - Set the background image for this slide in the line below -->
      <div class="carousel-item">
      	<div class="container">
					<div class="h-nav"></div>
	            	<div class="row">
						<h2 class="text-center bold" style="margin:5px auto;">JADWAL DOKTER SPESIALIS</h2>
					</div>
					<!-- <hr style="margin-top: 0px;"> -->
					
						<div name="ld_jadok" class="konten_slider_scroll">
							<table class="table table-stripped table-bordered" name="tbl_ld_jadok">
								<thead>
									<tr style="text-align: center;">
										<th>SENIN</th>
										<th>SELASA</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td name="hari1"><?=$arr_el[0];?></td>
										<td name="hari2"><?=$arr_el[1];?></td>
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
					<!-- <hr style="margin-top: 0px;"> -->
				
					<div name="ld_jadok" class="konten_slider_scroll">
						<table class="table table-stripped table-bordered" name="tbl_ld_jadok">
							<thead>
								<tr>
									<th>RABU</th>
									<th>KAMIS</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td name="hari4"><?=$arr_el[2];?></td>
									<td name="hari4"><?=$arr_el[3];?></td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
			</div>
      
			
			<!-- Slide 5 -->
      <div class="carousel-item">
      	<div class="container">
					<div class="h-nav"></div>
					<div class="row">
						<h2 class="text-center bold" style="margin:5px auto;">JADWAL DOKTER SPESIALIS</h2>
					</div>
					<!-- <hr style="margin-top: 0px;"> -->
				
					<div name="ld_jadok" class="konten_slider_scroll">
						<table class="table table-stripped table-bordered" name="tbl_ld_jadok">
							<thead>
								<tr>
									<th>JUM'AT</th>
									<th>SABTU</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td name="hari5"><?=$arr_el[4];?></td>
									<td name="hari6"><?=$arr_el[5];?></td>
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
      <p class="m-0 text-center text-white">Copyright &copy; Rumah Sakit Citra Medika &ensp;&ensp;&ensp;
	        <span style="margin-left:100px;">Last Update: </span>
	        <span id="last_update"><?=$onload['get_last_update'];?></span>
	        <!-- <span id="last_update"></span> -->
      </p>
      
  </footer>
  	
	    

  <!-- Bootstrap core JavaScript -->
  <script type='text/javascript' src="<?=base_url('assets/daftarmandirirjpx/');?>vendor/jquery/jquery.min.js"></script>
  <script type='text/javascript' src="<?=base_url('assets/daftarmandirirjpx/');?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>




	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	
	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
	
	<script>
		$(function(event){
			function my_reload(int_refresh_page=5){//satuan: detik
        // let int_refresh_page = 6; 
				console.log("timer");
        setInterval(function(){
          window.location.reload(true)
        }, (int_refresh_page*1000) ); 
      }
			// my_reload(120);
			
			let menit = 15;
			let durasi = menit*60;
      my_reload(durasi);



		});
	</script>

</body>
</html>

