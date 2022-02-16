<style>
a{
  cursor:pointer;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Laporan Pendaftaran Rawat Jalan</h2></section>
    <!-- Main content -->
    <section class="content">
      
      
      <div class="row">


        <div class="col-md-12">
          <div class="form-inline">
            <input type="text" name="tgl" class="form-control datepicker" autocomplete="off" value="<?=date('Y-m-d');?>">
            <!-- <span> - </span>
            <input type="text" name="tgl_end" class="form-control datepicker"> -->

            <button type="button" class="btn btn-info btn-flat" name="btn_ld_lap_daftarrj">
              <i class="fa fa-arrow-circle-right"></i>
            </button>

            <i id="spin" class="fa fa-refresh fa-spin" style="margin-left:10px; display:none;"></i>

          </div>
        </div>

        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-body" name="tbl_lap_daftarrj"></div>
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
                    <tr><td>Nama Pasien </td><td name="nama">-</td></tr>
                    <tr><td>NoRM    </td><td name="norm">-</td></tr>
                    <tr><td>SEP     <button id="btn_upd_sep">Update</button></td>
                        <!-- <td name="nosep">-</td></tr> -->
                        <td><input type="text" name="in_nosep"></td></tr>
                    <tr><td>SKDP    </td><td name="noskdp">-</td></tr>
                    <tr><td>Lokasi    </td><td name="lokasi">-</td></tr>
                    <tr><td>Nama Dokter </td><td name="dokter_nama">-</td></tr>
                    <tr><td>Tgl.Rujukan </td><td name="tglrujukan">-</td></tr>
                    <tr><td>No.Antrian  </td><td name="nourut">-</td></tr>
                    <tr><td>Keterangan <button id="btn_upd_ket">Update</button></td>
                        <td><input type="text" name="keterangan"></td></tr>
                    </table>
                    <br>
                </div>
                
                <div class="row" style="padding-left:20px;">
                  <button id="btn_cetak_antrian" class="btn btn-warning">Cetak Antrian</button>                  
                  <button id="btn_cetak_skdp" class="btn btn-warning">Cetak SKDP</button>
                  <button id="btn_cetak_tracer" class="btn btn-warning">Cetak Tracer(2X)</button>
                  <button id="btn_cetak_tracer_igd" class="btn btn-danger">Cetak Tracer IGD</button>
                  <button name="btn_cetak_resume_sep" class="btn btn-warning">Cetak Resume SEP</button>
                  <button name="btn_cetak_sep_preview" class="btn btn-warning">Cetak SEP</button>
                </div>
                <div class="row" style="padding-left:20px; margin-top:10px;">
                  <button id="btn_cetak_antrian_skdp_1" class="btn btn-warning">Cetak Antrian+SKDP 1</button> 
                  <button id="btn_cetak_antrian_skdp_2" class="btn btn-warning">Cetak Antrian+SKDP 2 (LENOVO PUTIH)</button> 
                  <button id="btn_cetak_tracer_rj_popup" class="btn btn-warning">Cetak TRACER POPUP</button> 
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