  <style>
    .big-box h2 {
      text-align: center;
      width: 100%;
      font-size: 1.8em;
      letter-spacing: 2px;
      font-weight: 700;
      text-transform: uppercase;
      cursor:pointer;
    }
    .modal-dialog {
        width: 100%;
        height: 100%;
        padding: 0;
        margin:0;
    }
    .modal-content {
        height: 100%;
        border-radius: 0;
        color:#333;
        overflow:auto;
    }
    .modal-title {
        font-size: 3em;
        font-weight: 300;
        margin: 0 0 10px 0;
    }
    .close {
        color:black ! important;
        opacity:1.0;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="height:30px;">
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div id="list_audio">
          <audio id="myAudio" src="<?=base_url('assets/Sounds/asli/seratus.mp3');?>" type="audio/mpeg">
            <!-- <source  id="myAudioSRC" src="<..?=base_url('assets/Sounds/asli/nomor-urut.mp3');?>" type="audio/mpeg"> -->


            <!-- <source  id="myAudioSRC" src="" type="audio/mpeg"> -->
            
            <!-- <source src="<..?=base_url('assets/Sounds/asli/nomor-urut.wav');?>" type="audio/wav"> -->
            <!-- <source src="horse.mp3" type="audio/mpeg"> -->
            <!-- <source src="horse.ogg" type="audio/ogg">
            <source src="horse.mp3" type="audio/mpeg"> -->
            Your browser does not support the audio element.
          </audio>

          <!-- <audio id="myAudio1">
          <source  id="myAudioSRC" src="<.?=base_url('assets/Sounds/asli/satu.mp3');?>" type="audio/mpeg">
          
          </audio> -->
        
        </div>
          
        

        <p>Click the buttons to play or pause the audio.</p>

        <button id="play" type="button">Play Audio</button>
        <button id="pause" type="button">Pause Audio</button> 

        <div>
          <h3 id="cnt">0</h3>
          <button id="start" type="button">Start</button>
          <button id="reset" type="button">Reset</button>
          
          <!-- <button id="stop" type="button">Stop</button> -->
        </div>
        <br><br>

        <div>
          <input type="text" id="in_nomor" placeholder="nomor panggilan..."/>
          <button id="panggil" type="button">Panggil</button>
        </div>

        <div>
          <button id="next" type="button">Next</button>
        </div>

        <div id="json"></div>



      </div>

    </div> <!-- /.row -->

    <div class="container-fluid">
      <div class="row">        
        <div class="col-xs-6 col-md-6 big-box" >
          <h2 data-toggle="modal" data-target="#modal1">FULL VIEW</h2>
          <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog text-justify">
              <div class="modal-content ">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h3 class="modal-title" id="myModalLabel"><strong>Nomor Antrian </strong>
                  </br><small>Published Juni, 2015</small></h3>
                </div>
                <div class="modal-body">	
                  <p>Thundercats adipisicing marfa wes anderson farm-to-table, +1 vero yr ennui messenger bag occaecat williamsburg cosby sweater anim tattooed. Farm-to-table umami direct trade viral cosby sweater Austin. Magna tattooed irure, DIY </p>
                  <p>Thundercats adipisicing marfa wes anderson farm-to-table, +1 vero yr ennui messenger bag occaecat williamsburg cosby sweater anim tattooed. Farm-to-table umami direct trade viral cosby sweater Austin. Magna tattooed irure, DIY </p>
                  <p>Thundercats adipisicing marfa wes anderson farm-to-table, +1 vero yr ennui messenger bag occaecat williamsburg cosby sweater anim tattooed. Farm-to-table umami direct trade viral cosby sweater Austin. Magna tattooed irure, DIY </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



  </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->