
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="height:30px;">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div id="errors"></div>
        </div>
      </div>

      <div class="row">
        <!-- <form action="#" name="form_daftar_online" method="POST"> -->
          <div class="col-md-8 col-md-offset-2">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:20pt;">Pendaftaran Mandiri</h3>
              </div>
              <div class="box-body">
                <a class="label label-info" data-toggle="modal" data-target="#modal_info_daftar_online">*Info</a>
                  
                    <div class="modal modal-info fade" id="modal_info_daftar_online">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><strong>Informasi Pendaftaran</strong></h4>
                          </div>
                          <!-- <div class="modal-body" style="background-color: #00a7d0 !important;"> -->
                          <div class="modal-body" style="background-color: #0090B5 !important;">
                            <ul>
                              <li>Pendaftaran Online H-1 dari jadwal periksa dan bisa dilakukan 24 jam.</li>
                              <li>Pendaftaran Online hanya bisa dilakukan oleh pasien yang sudah pernah berobat, memiliki kartu pasien dan mempunyai nomor rekam medis di Rumah Sakit Citra Medika.</li>
                              <li>Pasien diwajibkan memasukkan NORM, No Hp Aktif, Tanggal Lahir (Format dd/mm/yyyy, contoh: 02/12/1995), No. Rujukan aktif dan No. SKDP.</li>
                              <li>Pasien diwajibkan datang 15 menit sebelum jam praktek dokter dimulai.</li>
                              <li>Pasien diharuskan konfirmasi ke petugas Resepsionis jika sudah melakukan pendaftaran online H-1 untuk mengambil no antrian.</li>
                              <li>Pasien BPJS diharuskan menunjukkan kartu BPJS dan surat rujukan dari faskes I ke Petugas Resepsionis.</li>
                              <li>Jika pasien datang terlambat dan pelayanan sudah selesai, pasien dianggap batal periksa.</li>
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

                
                <a class="label label-success" data-toggle="modal" data-target="#modal_ambilweb_daftar_online" name="btn_modal_ambilweb_daftar_online">Ambil dari web <span name="cnt_list_web"></span></a>

                    <div class="modal modal-info fade" id="modal_ambilweb_daftar_online">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title"><strong>Data Booking melalui Web <span name="tgl_jadok"></span> </strong></h4>
                            </div>
                            <!-- <div class="modal-body" style="background-color: #00a7d0 !important;"> -->
                            <div class="modal-body" style="background-color: #0090B5 !important;"  name="tbl_laporan_daftaronline_web">

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

                <div class="row">
                  <div class="col-md-6">
                    <!-- norm -->
                    <div class="form-group">
                      <label>Hari Pendaftaran:</label>
                      <select name="sel_hari_daftar" class="form-control">
                        <option value="hari_besok">Besok (<?=date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));?>)</option>
                        <option value="hari_ini">Hari ini</option>
                      </select>
                    </div>

                  </div>

                  <div class="col-md-6">
                    <!-- norm -->
                    <div class="form-group">
                      <label>Penanggung:</label>
                      <select name="sel_penanggung_cm" class="form-control select2" style="width:100%;">
                        <option value="">UMUM</option>
                      </select>
                    </div>

                  </div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                    <!-- norm -->
                    <div class="form-group">
                      <label name="lbl_norm">No.Rekam Medis:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-file"></i>
                        </div>
                        <input type="text" name="norm" class="form-control" data-inputmask='"mask": "999999"' data-mask required>
                      </div><!-- /.input group -->
                    </div>

                  </div>
                  <div class="col-md-6">
                    <!-- noka -->
                    <div class="form-group">
                      <label>No. Kartu BPJS (Rujukan berlaku &le; 90 hari) </label>
                      <!-- (Masa rujukan berlaku 90 hari dari tanggal dibuat) -->
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-file"></i>
                        </div>
                        <input type="text" name="noka" class="form-control" data-inputmask='"mask": "9999-9999-99999"' data-mask required>
                      </div><!-- /.input group -->
                    </div>
  
                  </div>

                </div>


                <div class="row">
                  <div class="col-md-6">
                     <!-- Date -->
                    <div class="form-group">
                      <label>Tanggal Lahir: (dd/mm/yyyy)</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <!-- <input type="text" name="tglLahir" class="form-control pull-right" id="datepicker" autocomplete="off"> -->
                        <input type="text" name="tglLahir" class="form-control datepicker_daftaronline" autocomplete="off" data-inputmask="'mask': '99/99/9999'" data-mask="" required>
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!-- phone mask -->
                    <div class="form-group">
                      <label>No.HP:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-phone"></i>
                        </div>
                        <!-- <input type="text" name="nohp" class="form-control" data-inputmask='"mask": "999-999-999-9999"' data-mask> -->
                        <input type="number" name="nohp" class="form-control" autocomplete="off" maxlength="13" required>
                      </div><!-- /.input group -->
                    </div>

                  </div>

                </div>


                <div class="row">
                  <div class="col-md-6">
                     <!-- Date -->
                    <div class="form-group">
                      <label>Nama Dokter:</label> 
                      <a class="label label-info" data-toggle="modal" data-target="#modal_jadok_daftar_online">*Jadwal Dokter</a>

                      <select name="sel_dokter" id="sel_dokter" class="form-control select2" style="width: 80%;">
                        <!-- <option selected="selected">- Pilih Dokter -</option> -->
                      </select>
                      <button class="btn btn-danger clear"><i class="fa fa-remove"></i></button>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!-- phone mask -->
                    <div class="form-group">
                      <label>Spesialis: </label> <br>
                      <select name="sel_spesialis" class="form-control select2" style="width: 80%;">
                        <!-- <option selected="selected">- Pilih Spesialis -</option> -->
                      </select>
                      <button class="btn btn-danger clear"><i class="fa fa-remove"></i></button>
                    </div>

                  </div>

                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Keterangan:</label>                        
                      <input type="text" id="keterangan" class="form-control" autocomplete="off" >                      
                    </div>
                  </div>                  
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Rujukan:</label>                        
                      <input type="text" name="rujukan" class="form-control" autocomplete="off" >                      
                    </div>
                  </div>                  
                </div>
              
              </div>

              

              <div class="box-footer">
                <button id="btn_form_daftar_online" class="btn btn-success btn-rscm">Daftar</button>

                  <span style="margin-left:30px;">
                    <input type="checkbox" name="chk_tracer_rc">
                    Cetak Tracer di RC
                  </span>
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


                      <div class="modal modal-info fade" id="modal_jadok_daftar_online">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title"><strong>Informasi Jadwal Dokter <span name="tgl_jadok"></span> </strong></h4>
                            </div>
                            <!-- <div class="modal-body" style="background-color: #00a7d0 !important;"> -->
                            <div class="modal-body" style="background-color: #0090B5 !important;">
                              <table class="table table-borderred" name="tbl_jadok_harian">
                                <thead>
                                  <tr>
                                    <th>No.</th>
                                    <th>Spesialis</th>
                                    <th>Nama Dokter</th>
                                    <th>Jam Praktek</th>
                                  </tr>
                                </thead>
                                <tbody></tbody>
                              </table>
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
