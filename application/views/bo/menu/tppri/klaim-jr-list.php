<style>
a{
  cursor:pointer;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Daftar Klaim JR</h2></section>
    <!-- Main content -->
    <section class="content">      
      
      <div class="row">


         <div class="col-md-12" style="margin-bottom: 5px;">
          <div class="form-inline">
            <!-- <input type="text" name="tgl" class="form-control datepicker" autocomplete="off" value="<.?=date('Y-m-d');?>"> -->
            <!-- <span> - </span>
            <input type="text" name="tgl_end" class="form-control datepicker"> -->
            <select id="selVerif" class="form-control">
              <option value="">BELUM VERIF</option>
              <option value="checked">SUDAH VERIF</option>
            </select>
            <button type="button" class="btn btn-info btn-flat" id="btn_ld_jrlist">
              <i class="fa fa-arrow-circle-right"></i>
            </button>
          </div>
        </div>

        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-body" id="tbl_jrlist"></div>
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

                <div class="row">
                  <div class="col-xs-6">
                    <table name="tbl_detail_pasien" class="table table-bordered bold table-striped">
                      
                      <tr><td class="col-xs-3">BILLING</td><td id="md_nobill" class="col-xs-3" style="width:300px;">-</td></tr>
                      <tr><td>NAMA PASIEN</td><td id="md_nama">-</td></tr>
                      <tr><td>NORM</td><td id="md_norm">-</td></tr>
                      <tr><td>NIK</td><td id="md_nik">-</td></tr>
                      <tr><td>TEMPAT LAHIR</td><td id="md_tempatLahir">-</td></tr>
                      <tr><td>TANGGAL LAHIR</td><td id="md_tglLahir">-</td></tr>
                      <tr><td>TELP    </td><td id="md_telp">-</td></tr>
                      <tr><td>DIAGNOSA AWAL</td><td id="md_dxawal">-</td></tr>
                      <tr><td>RUANG</td><td id="md_ruang">-</td></tr>
                      <tr><td>STATUS PENGAJUAN</td><td id="md_stPengajuan">-</td></tr>
                      <tr><td>ALAMAT PASIEN</td><td id="md_alamatx">
                            <textarea name="" id="md_alamat" cols="30" rows="3" disabled="disabled"></textarea>
                          </td></tr>
                    </table>
                    <br>
                  </div>

                  <div class="col-xs-6">

                      <table id="tbl_detail_pasien2" class="table table-bordered bold table-striped">
                        <tr><td>TANGGAL PENGAJUAN</td><td id="md_tglPengajuan"></td></tr>
                        <tr><td>JAM PENGAJUAN</td><td id="md_jamPengajuan"></td></tr>
                        <tr><td>TANGGAL LAKA</td><td id="md_tglLaka"></td></tr>
                        <tr><td>TKP</td><td id="md_tkp"></td></tr>
                        <tr><td>STATUS LP</td><td id="md_statusLP"></td></tr>
                        
                        <tr><td>BIAYA AMBULAN</td><td id="md_biayaAmbulan"></td></tr>
                        <tr><td>BIAYA P3K</td><td id="md_biayaP3K"></td></tr>
                        <tr><td>BIAYA PERAWATAN</td><td id="md_biayaPerawatan"></td></tr>
                        
                           
                        <tr>
                          <td colspan="2" bgcolor="#abfff1">
                              <table>
                                <tr><td colspan="2" style="font-weight: bold; text-align: center;">VERIFIKASI JASA RAHARJA</td></tr>
                                <tr><td>BIAYA AMBULAN (VERIF)</td><td><input type="text" id="md_biayaAmbulanVerif" class="keypress" disabled></td></tr>
                                <tr><td>BIAYA P3K (VERIF)</td><td><input type="text" id="md_biayaP3KVerif" class="keypress" disabled></td></tr>
                                <tr><td>BIAYA PERAWATAN (VERIF)</td><td><input type="text" id="md_biayaPerawatanVerif" class="keypress" disabled></td></tr>
                                <tr><td>NO. SURAT</td><td><input type="text" id="md_noSurat" disabled></td></tr>
                                <tr><td>LAMPIRAN</td><td><input type="text" id="md_lampiran" disabled></td></tr>

                              </table>
                          </td>
                        </tr>
                      </table>


                  </div>
                </div>
                
                <!-- <div class="row" style="padding-left:20px; margin-top:10px;">
                  <button id="btn_cetak_antrian_skdp_1" class="btn btn-warning">Cetak Antrian+SKDP 1</button> 
                  <button id="btn_cetak_antrian_skdp_2" class="btn btn-warning">Cetak Antrian+SKDP 2 (LENOVO PUTIH)</button> 
                  <button id="btn_cetak_tracer_rj_popup" class="btn btn-warning">Cetak TRACER POPUP</button> 
                </div> -->
                  


            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
      </div>
  <!-- ================ [ \MODAL ] =================== -->