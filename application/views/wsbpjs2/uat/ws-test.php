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
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-body">
              <div>Example Input:
                <ol>
                  <li>Peserta/nokartu/0001716591442/tglSEP/<?=date('Y-m-d');?></li>
                  <li>Peserta/nik/{nik}/tglSEP/<?=date('Y-m-d');?></li>
                  <li>SEP/{nosep}</li>
                  <li>Rujukan/List/Peserta/{noka}</li>
                  <li>referensi/dokter/pelayanan/2/tglPelayanan/<?=date('Y-m-d');?>/Spesialis/mata</li>
                </ol>
              </div>
              
              <div>Cari Dokter Spesialis Baru:
                <ol>
                  <li>referensi/poli/GIGI ORTHODONTI</li>
                  <li>referensi/dokter/pelayanan/2/tglPelayanan/<?=date('Y-m-d');?>/Spesialis/GOR</li>
                </ol>
              </div>
              
              
              <div>URL POST:
                <ol>
                  <li>Sep/pengajuanSEP</li>
                </ol>
              </div>


              
              
              
              
              <div class="form-inline">
                <h3>POST</h3>
                <textarea id="param_post" rows="10" style="width:100%;"></textarea>
                <!-- <textarea id="param_post" style="width:150px !important; height:400px;"></textarea> -->
                
                <button type="button" class="btn btn-info btn-flat" id="btn_run_ws_bpjs_post">
                  RUN POST<i class="fa fa-arrow-circle-right"></i>
                </button>
              </div>


            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-body">
              <div class="form-inline">
                <h4 style="margin-top:0px;">GET</h4>
                <input type="text" id="param" class="form-control" style="width:90%;" autocomplete="off">

                <button type="button" class="btn btn-info btn-flat" id="btn_run_ws_bpjs">
                  <i class="fa fa-arrow-circle-right"></i>
                </button>
              </div>

              <h4>RESULT</h4>
              <textarea id="result" rows="20" style="width:100%;"></textarea>


            </div>
          </div>
        </div>

      </div>


          

    </section>
  </div>