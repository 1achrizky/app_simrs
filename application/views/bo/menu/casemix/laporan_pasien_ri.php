   <!-- Styles -->
    <style>
    #chartdiv {
      width: 90%;
      height: 500px;
      /*width: 300px;
      height: 500px;*/
    }

    .bold{
      font-weight: bold;
    }

    </style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Laporan Pasien Rawat Inap</h2></section>
    <!-- Main content -->
    <section class="content">
      
      
      <div class="row">


        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Tabel Pasien Rawat Inap</h3>
            </div>

            <div class="box-body form-inline">
              <input type="text" name="tgl_px_ri" class="form-control datepicker" autocomplete="off">
              &nbsp; - &nbsp;
              <input type="text" name="tgl_end_px_ri" class="form-control datepicker" autocomplete="off">
              <button type="button" class="btn btn-primary btn-flat" name="btn_tgl_px_ri">
                <i class="fa fa-arrow-circle-right"></i>
              </button>
              <button type="button" class="btn btn-success btn-flat" name="btn_dl_excel_px_ri">
                <i class="fa fa-download"></i> Excel
              </button>
              <!-- <.?=terbilang(11530011);?> -->
            </div>
            <div class="box-body" name="tbl_laporan_px_ri"></div>
          </div>
        </div>


      </div>

          

    </section>
  </div>