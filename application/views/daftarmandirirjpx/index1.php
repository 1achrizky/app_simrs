<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Full Slider - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/full-slider.css" rel="stylesheet">
	<style>
		.dark-tosca{background-color: #377C73;}
		.carousel-bg{
			background-image: url('img/rscm/RS Citra Medika-coloring2-lite.jpg');
			background-size: cover; 
			background-position:center;
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
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="background-color: #B9F6E7;"> -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top dark-tosca" >
      <div class="container">
        <!-- <a class="navbar-brand" href="#">Start Bootstrap</a> -->
        <a class="navbar-brand" href="#"><img src="img/rscm/LOGO RSCM BARU.png" alt="" width="200"></a>
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

    <header class="mh-100">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner carousel-bg" role="listbox">
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item active" >
            <div class="pt-from-nav">
            	<div class="section ">
            		<h3>First Slide</h3>
					<p>This is a description for the first slide.</p>
					<p>This is a description for the first slide.</p>
					<p>This is a description for the first slide.</p>
					<p>This is a description for the first slide.</p>
            	</div>
              
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
