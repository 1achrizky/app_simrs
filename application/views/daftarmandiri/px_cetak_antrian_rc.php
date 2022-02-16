<style>
  .font-big, select>option{
    font-size: 20px;
  }

  #btn_cetak_antrian_rc{
    /*width:300px;*/
    width:100%;
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
        <!-- <form action="#" name="form_daftar_online" method="POST"> -->
          <div class="col-md-6 col-md-offset-3">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h1 class="box-title" style="font-size:30pt;">Pengambilan <br> Antrian Pendaftaran</h1>
              </div>
              <div class="box-body">
                
                <div class="row font-big">
                  <div class="col-md-8 col-md-offset-2">
                    <h1 id="number" style="font-weight:bold; font-size:70pt;text-align:center;"><?=$next['nominal'];?> </h1>

                  </div>
                </div>


                <div class="row font-big">
                  <div class="col-md-8 col-md-offset-2">
                    <button id="btn_cetak_antrian_rc" class="btn btn-lg btn-success btn-rscm" style="margin-top: 30px; font-size:30pt; width:100%;">CETAK</button>
                  </div>
                </div>
                    

              </div>
              <div class="box-footer">
                <!-- <button type="submit" id="btn_daftar" class="btn btn-success btn-rscm">Daftar</button> -->
                
                <!-- <button id="btn_cek_rjk_multi" class="btn btn-success btn-rscm">Cek Rujukan Multi</button> -->
              </div>
            </div>

          </div>
        
        <!-- </form> -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

