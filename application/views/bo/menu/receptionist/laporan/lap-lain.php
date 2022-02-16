
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Laporan-laporan</h2></section>
    <!-- Main content -->
    <section class="content">
      
      
      <div class="row">


        <div class="col-md-12">
          
        </div>

        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Laporan Suku Bangsa Kosong</h3>
            </div>
            <div class="box-body">
              <div class="form-inline">
                <input type="text" name="tgl_start" class="form-control datepicker" autocomplete="off">
                <span> - </span>
                <input type="text" name="tgl_end" class="form-control datepicker" autocomplete="off">

                <button type="button" class="btn btn-info btn-flat" name="btn_ld_lap_lain">
                  <i class="fa fa-arrow-circle-right"></i>
                </button>
              </div>
            </div>
            <div class="box-body" name="tbl_lap_lain"></div>
          </div>
        </div>


        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Laporan Agama Kosong</h3>
            </div>
            <div class="box-body">
              <div class="form-inline">
                <input type="text" name="tgl_start_agama" class="form-control datepicker" autocomplete="off">
                <span> - </span>
                <input type="text" name="tgl_end_agama" class="form-control datepicker" autocomplete="off">

                <button type="button" class="btn btn-info btn-flat" name="btn_ld_lap_agama">
                  <i class="fa fa-arrow-circle-right"></i>
                </button>
              </div>
            </div>
            <div class="box-body" name="tbl_lap_agama"></div>
          </div>
        </div>


      </div>

      <div id="div_frame"></div>

          

    </section>
  </div>



  <!-- ================ [ MODAL ] =================== -->

      <div class="modal fade" id="modal_detail_pasien" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Detail Pasien</h4>
            </div>
            <div class="modal-body" id="el_modal2">

              <!-- <div class="container"> -->
                <div class="row">
                  <table name="tbl_detail_pasien" class="table table-bordered bold">
                    <tr><td class="col-xs-3">Billing    </td><td name="nobill" class="col-xs-4" style="width:300px;">-</td></tr>
                    <tr><td>Nama Pasien </td><td name="Nama">-</td></tr>
                    <tr><td>NoRM    </td><td name="NoRM">-</td></tr>
                    <tr><td>SEP     </td><td name="nosep">-</td></tr>
                    <tr><td>SKDP    </td><td name="noskdp">-</td></tr>
                    <tr><td>Lokasi    </td><td name="Lokasi">-</td></tr>
                    <tr><td>Kode Dokter </td><td name="Dokter">-</td></tr>
                    <tr><td>Nama Dokter </td><td name="namaDokter">-</td></tr>
                    <tr><td>Tgl.Rujukan </td><td name="tglRujukan">-</td></tr>
                    <tr><td>No.Antrian  </td><td name="NoUrut">-</td></tr>
                    </table>
                    <br>
                </div>
                <div class="row">
                  <button name="btn_cetak_antrian" class="btn btn-warning">Cetak Antrian</button>
                  <button name="btn_cetak_resume_sep" class="btn btn-warning">Cetak Resume SEP</button>
                  <!-- <button name="btn_cetak_sep" class="btn btn-warning">Cetak SEP</button> -->
                  <button name="btn_cetak_sep_preview" class="btn btn-warning">Cetak SEP</button>
                  <button name="btn_cetak_skdp" class="btn btn-warning">Cetak SKDP</button>
                  <!-- <button name="btn_del_bill" class="btn btn-danger">Delete Billing</button> -->
                </div>
                  

              <!-- </div> -->

            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
      </div>
  <!-- ================ [ \MODAL ] =================== -->