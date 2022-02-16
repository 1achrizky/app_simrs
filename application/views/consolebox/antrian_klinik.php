<style>
select[name=sel_cari_by],
input[name=in_cari_by]{
  font-size:14pt;
}

select[name=sel_cari_by]{
  text-align:center;
  text-align-last:center; /*hanya di chrome*/
}

select[name=sel_cari_by] option{
  /* text-indent: 50px; */
  text-align:center !important;
}

input[name=in_cari_by]{
  text-align:center;
}
</style>

<section class="content"> 
  
      <div id="modal_numpad"></div>
      
      <div class="row" style="margin-top:115px;">
        <!-- <form action="#" name="form_daftar_online" method="POST"> -->
          <div class="col-md-6 col-md-offset-3">
            <div class="box box-info  main-console" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h1 class="box-title" style="font-size:28pt;">Pengambilan <br> Antrian Klinik & SKDP</h1>
                <!-- <h3>(Pengambilan Antrian Klinik & SKDP)</h3> -->
              </div>
              <div class="box-body">


                    <div class="modal modal-info fade" id="modal_info_daftar_online">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><strong>BILA MEMILIKI 2 ANTRIAN DALAM 1 HARI</strong></h4>
                          </div>
                          <div class="modal-body" style="background-color: #0090B5 !important;">
                            <table class="table table-stripped">
                              <tr>
                                <td>NORM</td><td></td>
                                <td>NAMA</td><td></td>
                                <td>ALAMAT</td><td></td>
                                <td>TGL.LAHIR</td><td></td>
                              </tr>
                            </table>
                            <ul>
                              <li>Pendaftaran Online H-1 dari jadwal periksa dan bisa dilakukan 24 jam.</li>
                              <li>Pendaftaran Online hanya bisa dilakukan oleh pasien yang sudah pernah berobat, memiliki kartu pasien dan mempunyai nomor rekam medis di Rumah Sakit Citra Medika.</li>
                            </ul>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                
                <div class="row font-big">
                  <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                      <h3 style="text-align:center;">CETAK BERDASARKAN:</h3>
                      <select name="sel_cari_by" class="form-control select2">                      
                        <option value="noka">KARTU BPJS</option>
                        <option value="norm">NORM</option>
                      </select>
                    </div>

                    <!-- norm -->
                    <div class="form-group">
                      <!-- <label name="lbl_cari_by">No.Kartu BPJS</label><span>:</span> -->
                      <!-- <label name="lbl_cari_by">Masukkan Nomor</label><span>:</span> -->
                      <div class="input-group">
                        <input type="text" name="in_cari_by" class="form-control" data-inputmask='"mask": "999999"' data-mask autocomplete="off" placeholder="Masukkan nomor...." required>
                        <!-- <span class="input-group-append">
                          <button class="btn btn-info btn-flat" style="display:inline-block;"><i class="fa fa-barcode"></i></button>                        
                        </span> -->
                        <div class="input-group-addon numpad">
                          
                          <i class="fa fa-keyboard-o"></i>                          
                        </div>
                      </div><!-- /.input group -->
                    </div>

                  </div>
                </div>


                <div class="row font-big">
                  <div class="col-md-10 col-md-offset-1">
                    <button id="btn_cetak_antrian_skdp" class="btn btn-lg btn-success btn-block" style="font-size:20pt;">CETAK</button>
                  </div>
                </div>
                    

              </div>
              <div class="box-footer"></div>
            </div>

          </div>
        
        <!-- </form> -->
      </div>
      <!-- /.row -->

</section>
  