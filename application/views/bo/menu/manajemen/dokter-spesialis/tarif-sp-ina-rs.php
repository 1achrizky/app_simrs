<style>
 
  .bold{
    font-weight: bold;
  }

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Tarif Dokter Inacbg-RS</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Tabel Tarif Dokter Inacbg-RS (Rawat Jalan)</h3>
            </div>

            <div class="box-body form-inline">
              <input type="text" id="in_datestart" class="form-control datepicker" autocomplete="off">
              &nbsp; - &nbsp;
              <input type="text" id="in_dateend" class="form-control datepicker" autocomplete="off">
              <button type="button" class="btn btn-primary btn-flat" id="btn_ld_trf">
                <i class="fa fa-arrow-circle-right"></i>
              </button>
              <button type="button" class="btn btn-success btn-flat" id="btn_dl_excel">
                <i class="fa fa-download"></i> Excel
              </button>
              
            </div>
            <div class="box-body" id="tbl_laporan"></div>
          </div>
        </div>
      </div>


      <div class="box-body" id="modal_list"></div>

    </section>
  </div>