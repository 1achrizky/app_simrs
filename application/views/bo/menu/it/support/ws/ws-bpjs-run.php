<style>
a{
  cursor:pointer;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">RUNNING WS BPJS</h2></section>
    <!-- Main content -->
    <section class="content">
      
      
      <div class="row">


        <div class="col-md-12">
          
        </div>

        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-body" name="tbl_lap_daftarrj">
              <div>Example Input:
                <ol>
                  <li>Peserta/nokartu/0001716591442/tglSEP/<?=date('Y-m-d');?></li>
                  <li>Rujukan/List/Peserta/{noka}</li>
                  <li>referensi/dokter/pelayanan/2/tglPelayanan/<?=date('Y-m-d');?>/Spesialis/mata</li>
                  <!-- <li></li> -->
                </ol>
              </div>
              
              <div>Cari Dokter Spesialis Baru:
                <ol>
                  <li>referensi/poli/GIGI ORTHODONTI</li>
                  <li>referensi/dokter/pelayanan/2/tglPelayanan/<?=date('Y-m-d');?>/Spesialis/GOR</li>
                  <!-- <li></li> -->
                </ol>
              </div>
              
              
              <div>URL POST:
                <ol>
                  <li>Sep/pengajuanSEP</li>
                </ol>
              </div>



              <div class="form-inline">
                <h3>GET</h3>
                <input type="text" id="param" class="form-control" style="width:500px;" autocomplete="off">

                <button type="button" class="btn btn-info btn-flat" id="btn_run_ws_bpjs">
                  RUN <i class="fa fa-arrow-circle-right"></i>
                </button>
              </div>
              
              
              <div class="form-inline">
                <h3>POST</h3>
                <textarea id="param_post" cols="50" rows="10"></textarea>
                
                <button type="button" class="btn btn-info btn-flat" id="btn_run_ws_bpjs_post">
                  RUN POST<i class="fa fa-arrow-circle-right"></i>
                </button>
              </div>
              
              <h3>RESULT</h3>
              <textarea id="result" cols="70" rows="10"></textarea>

            </div>
          </div>
        </div>


      </div>

      <div id="div_frame"></div>

          

    </section>
  </div>