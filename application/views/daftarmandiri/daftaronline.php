
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- <form action="#" name="form_daftar_online" method="POST"> -->
          <!-- <div class="col-md-6 col-md-offset-3"> -->
          <div class="col-md-6 col-md-offset-1">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:20pt;">Pendaftaran Mandiri</h3>
              </div>
              <div class="box-body">
                <?php
                $admin = false;
                if($username != 'pasien') $admin = true;
                ?>

                <?php if($admin){ ?>
                  <div>
                    <label style="margin-bottom:0px;">Login: <?=$username;?></label>.
                    <br> Untuk login sebagai pasien, klik <a href="<?=base_url('user_xlink/logout_redirectto/').base64_encode('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">ini</a>.
                    <!-- <.?=$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?> -->
                  </div>
                  
                <?php } ?>

                <input type="hidden" name="username" value="<?=$username;?>">

                <a class="label label-info" data-toggle="modal" data-target="#modal_info_daftar_online">*Info</a>
                <!-- <a class="label label-warning" data-toggle="modal" data-target="#modal_ambilweb_daftar_online">Ambil dari web</a> -->
  
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

                <div class="row">
                  <div class="col-md-6">
                    
                    <div class="form-group">
                      <label>Hari Pendaftaran:</label>
                      <select name="sel_hari_daftar" class="form-control">
                        <option value="hari_besok">Besok (<?=date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));?>)</option>
                          <?php
                          date_default_timezone_set("Asia/Bangkok");
                          $batas_jam_daftar_hari_ini = 10;
                          $get_jam_sekarang = intval(date('H')); // parseInt( moment().format('HH') );
                          if($get_jam_sekarang < $batas_jam_daftar_hari_ini){
                            echo '<option value="hari_ini">Hari ini</option>';
                          }
                          ?> 
                      </select>
                    </div>

                  </div>

                  <div class="col-md-6">
                    <!-- norm -->
                    <div class="form-group">
                      <label>Penanggung:</label>
                      <select name="sel_penanggung_cm" class="form-control select2" style="width:100%;">
                        <option value=""></option>
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



                      <select name="sel_dokter" class="form-control select2" style="width: 80%;">
                        <!-- <option selected="selected">- Pilih Dokter -</option> -->
                      </select>
                      <button class="btn btn-danger clear"><i class="fa fa-remove"></i></button>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!-- phone mask -->
                    <div class="form-group">
                      <label>Spesialis:</label>
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
                      <input type="text" name="keterangan" class="form-control" autocomplete="off" >                      
                    </div>
                  </div>                  
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Rujukan:</label>
                      <input type="text" name="rujukan" class="form-control" autocomplete="off" >                      
                    </div>
                  </div>                  
                </div>

                <!-- <div class="row">
                  <div class="col-md-12">
                    <span style="margin-left:50px;">
                      <input type="checkbox" name="chk_tracer_rc">
                      Cetak Tracer di RC
                    </span>
                  </div>
                </div> -->
                    

              </div>
              <div class="box-footer">
                <!-- <button type="submit" id="btn_daftar" class="btn btn-success btn-rscm">Daftar</button> -->
                <button id="btn_form_daftar_online" class="btn btn-success btn-rscm">Daftar</button>
                <!-- <button id="btn_cek_rjk_multi" class="btn btn-success btn-rscm">Cek Rujukan Multi</button> -->
              </div>
            </div>

          </div>



          <div class="col-md-4">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:20pt;">Tombol Masukan</h3>
              </div>
              <div class="box-body">
                <style>
                /* .keypad>div{
                  margin:0px auto;
                } */

                /* .keypad {
                  width: 100%;
                  border: 1px solid black;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                } */

                .keypad {
                  width: 250px; /* 100%; */
                  border: 1px solid black;
                  text-align:center;  /* centering button */
                  margin:0px auto;
                }

                .keypad>div>button{
                  margin:10px;
                  width:60px;
                  height:60px;
                  font-size:35px;
                  /* padding-top:0px; */
                  line-height: 0.61em;
                  vertical-align: middle;
                }
                </style>
                                
                <div class="keypad">
                  <div>
                    <button class="btn btn-info">1</button>
                    <button class="btn btn-info">2</button>
                    <button class="btn btn-info">3</button>
                  </div>
                  <div>
                    <button class="btn btn-info">4</button>
                    <button class="btn btn-info">5</button>
                    <button class="btn btn-info">6</button>
                  </div>
                  <div>
                    <button class="btn btn-info">7</button>
                    <button class="btn btn-info">8</button>
                    <button class="btn btn-info">9</button>
                  </div>
                  <div>
                    <button class="btn btn-info"><</button>
                    <button class="btn btn-info">0</button>
                    <button class="btn btn-info">C</button>
                  </div>                
                </div>
                


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
  <!-- <.?php echo '<pre>',print_r($jadok),'</pre>';?> -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.1.0
    </div>
    <strong>Copyright &copy; 2018 <a href="https://citramedika.com">IT - RS. Citra Medika</a>.</strong>
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?=base_url();?>assets/plugin/lte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- formvalidate -->
<!-- tidak ada di folder source -->
<!-- <script src="<.?=base_url();?>assets/plugin/jquery-validation-1.17.0/dist/jquery.validate.js"></script>
<script src="<.?=base_url();?>assets/plugin/jquery-validation-1.17.0/dist/jquery.validate.min.js"></script> -->


<!-- Select2 -->
<script src="<?=base_url();?>assets/plugin/lte/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url();?>assets/plugin/lte/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=base_url();?>assets/plugin/lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=base_url();?>assets/plugin/lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?=base_url();?>assets/plugin/lte/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->

<script src="<?=base_url();?>assets/plugin/lte/plugins/sweetalert2-7.32.2/package/dist/sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
<!-- <script src="<.?=base_url();?>assets/plugin/lte/plugins/sweetalert2-7.32.2/package/web/promise-polyfill.js"></script> -->


<!-- ChartJS -->
<script src="<?=base_url();?>assets/plugin/lte/bower_components/Chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="<?=base_url();?>assets/plugin/lte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>assets/plugin/lte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url();?>assets/plugin/lte/dist/js/demo.js"></script>
<!-- page script -->


  <!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script> -->
  <script type="text/javascript" src="<?=base_url();?>assets/plugin/lte/else/lodash.min.js"></script>

  <script type='text/javascript' src="<?=base_url();?>assets/js/library.js"></script>
  <script type='text/javascript' src="<?=base_url();?>assets/js/site_lte.js"></script>

  <!-- KEYPAD RIZ -->
  <script type='text/javascript'>
    
  </script>
  <!--\KEYPAD RIZ -->
</body>
</html>
