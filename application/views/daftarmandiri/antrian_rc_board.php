<style>
  .font-big, select>option{
    font-size: 20px;
  }

  #btn_cetak_antrian_rc{
    /*width:300px;*/
    width:100%;
  }

</style>
<style>
.tech-slideshow {
  height: 200px;
  max-width: 800px;
  margin: 0 auto;
  position: relative;
  overflow: hidden;
  transform: translate3d(0, 0, 0);
}

.tech-slideshow > div {
  height: 200px;
  width: 2526px;
  background: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/collage.jpg);
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  transform: translate3d(0, 0, 0);
}
.tech-slideshow .mover-1 {
  animation: moveSlideshow 12s linear infinite;
}
.tech-slideshow .mover-2 {
  opacity: 0;
  transition: opacity 0.5s ease-out;
  background-position: 0 -200px;
  animation: moveSlideshow 15s linear infinite;
}
.tech-slideshow:hover .mover-2 {
  opacity: 1;
}

@keyframes moveSlideshow {
  100% { 
    transform: translateX(-66.6666%);  
  }
}
</style>
<style>
		/*CSS untuk set item loader loop di element slider*/
		.bold{ font-weight: bold; }

    /* .mycard{
      display:inline-block; 
      width:200px; height:200px;
      background:yellow;
    } */

		.card-span{
			margin-bottom: 10px;
      width:200px;
      float:left;
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

    /* .carousel-indicatorsXXX li{
      -webkit-box-shadow: 0 3px 3px rgba(0, 0, 0, .3); 
			-moz-box-shadow: 0 3px 3px rgba(0,0,0,.3); 
			box-shadow: 0 3px 3px rgba(0,0,0,.3);
    } */

		/* \tbl_ld_jadok_v2 */

		/*SET SPEED CAROUSEL*/
		/* .carousel-inner .carousel-item {
		  transition: -webkit-transform 2s ease;
		  transition: transform 2s ease;
		  transition: transform 2s ease, -webkit-transform 2s ease;
		} */
		/* \SET SPEED CAROUSEL*/

	</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="height:30px;">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h1 class="box-title" style="font-size:25pt;">Antrian</h1>
              </div>
              <div class="box-body">                
                  <h1 id="number" style="font-weight:bold; font-size:70pt;text-align:center;">&nbsp;</h1>

              </div>
            </div>
          </div>

          

          <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-body">
                <div class="row font-big">
                  <div class="col-md-12">
                    <video controls autoplay loop muted width="100%">  
                    <!-- <video autoplay loop>   -->
                    <!-- <video width="320" height="240" src="<?=base_url();?>assets/Motion Graphic di PowerPoint.mp4" autoplay loop> -->
                              
                      <source src="<?=base_url();?>assets/Motion Graphic di PowerPoint.mp4" type="video/mp4">

                      <!-- <source src="mov_bbb.mp4" type="video/mp4">
                      <source src="mov_bbb.ogg" type="video/ogg"> -->
                      Your browser does not support HTML5 video.
                    </video>
                    
                  </div>
                </div>
                    

              </div>
            </div>

          </div>
        
      </div>
      <!-- /.row -->
      
      <div class="row">
        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h1 class="box-title" style="font-size:25pt;">Ketersediaan Kamar</h1>
            </div>
            <div class="box-body">
            
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item active" id="item1">
                    <!-- <div class="mycard">Papyrus</div>
                    <div class="mycard">Gaharu</div> -->
                  </div>

                  <div class="item">                    
                    <div class="mycard">Eboni</div>
                  </div>

                  <div class="item">                    
                    <div class="mycard">Bubinga</div>
                  </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>

            </div>

            <div class="box-body">
              <!-- <div class="tech-slideshow">
                <div class="mover-1"></div>
                <div class="mover-2"></div>
              </div> -->

              <!-- behavior="slide" -->
              <marquee  direction="left" id="mq_bed" loop="1"></marquee>
                                

            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

