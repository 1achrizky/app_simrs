<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Full Slider - Start Bootstrap Template</title>

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
			background-image: url("<?=base_url('assets/daftarmandirirjpx/');?>img/rscm/RS Citra Medika-coloring2-lite.jpg");
			opacity: 0.5;
			filter: alpha(opacity=80); /* For IE8 and earlier */
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
  </head>

  <body>
  		<!-- Navigation -->
	    <nav class="navbar navbar-expand-lg navbar-dark dark-tosca fixed-top" >
	      <div class="container">
	        <!-- <a class="navbar-brand" href="#">Start Bootstrap</a> -->
	        <a class="navbar-brand" href="#"><img src="<?=base_url('assets/daftarmandirirjpx/');?>img/rscm/LOGO RSCM BARU.png" alt="" width="200"></a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarResponsive">
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
	        </div>
	      </div>
	    </nav>

	    <header class="text-sdark-tosca">
	      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	        <ol class="carousel-indicators">
	          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	        </ol>

	        <div class="carousel-inner carousel-bg" role="listbox">
	          <!-- Slide One - Set the background image for this slide in the line below -->
	          <div class="carousel-item active" >
	            <div class="container">
	            	<div class="h-nav"></div>
            		<h3>First Slide</h3>
					<p>This is a description for the first slide.</p>
					<p>This is a description for the first slide.</p>
					<p>This is a description for the first slide.</p>
					<p>This is a description for the first slide.</p>
					<button class="btn btn-primary" href="#carouselExampleIndicators" role="button" data-slide="next">Selanjutnya &raquo;</button>	
	            	
	              
	            </div>
	          </div>
	          <!-- Slide Two - Set the background image for this slide in the line below -->
	          <div class="carousel-item">
	            <div class="carousel-caption d-none d-md-block">
	              <h3>Second Slide</h3>
	              <p>This is a description for the second slide.</p>
	            </div>
	          </div>
	          <!-- Slide Three - Set the background image for this slide in the line below -->
	          <div class="carousel-item">
	            <div class="carousel-caption d-none d-md-block">
	              <h3>Third Slide</h3>
	              <p>This is a description for the third slide.</p>
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

  </body>

</html>
