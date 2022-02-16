
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="height:30px;">
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
                  width: 100%;
                  border: 1px solid black;
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
                
                <!-- <div class="keypad">
                  <div>
                    <button class="btn btn-info">1</button>
                    <button class="btn btn-info">4</button>
                    <button class="btn btn-info">7</button>
                    <button class="btn btn-info"><</button>
                  </div>
                  <div>
                    <button class="btn btn-info">2</button>
                    <button class="btn btn-info">5</button>
                    <button class="btn btn-info">8</button>
                    <button class="btn btn-info">0</button>
                  </div>
                  <div>
                    <button class="btn btn-info">3</button>
                    <button class="btn btn-info">6</button>                    
                    <button class="btn btn-info">9</button>
                    <button class="btn btn-info">C</button>
                  </div>                
                </div> -->
                
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
                

                  <!-- <style>
                    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300);

                    html,
                    body {
                      margin: 0;
                      padding: 0;
                      background-color: #000000;
                      font-family: "Open Sans", sans serif;
                      font-weight: 300;
                      -webkit-tap-highlight-color: transparent;
                    }

                    .rotate {
                      display: none;
                      color: #ffffff;
                      position: absolute;
                      left: 50%;
                      top: 50%;
                      text-align: center;
                      width: 400px;
                      height: 50px;
                      margin-left: -200px;
                      margin-top: -25px;
                    }

                    .keypadwrapper {
                      text-align: center;
                      width: 100%;
                      color: #ffffff;

                      .inputwrapper {
                        margin: 2em;
                        line-height: 0.61em;
                        vertical-align: middle;
                      }

                      .numberinput {
                        display: inline-block;
                        height: 15px;
                        width: 15px;
                        border-radius: 50px;
                        border: 1px solid #ffffff;
                        margin-right: 2%;
                        margin-left: 2%;
                        font-size: 2em;
                      }

                      .keypad {
                        .numberline {
                          width: 100%;
                        }

                        #linefour {
                          position: absolute;
                          bottom: 10%;
                        }

                        #linethree {
                          position: absolute;
                          bottom: 30%;
                        }

                        #linetwo {
                          position: absolute;
                          bottom: 50%;
                        }

                        #lineone {
                          position: absolute;
                          bottom: 70%;
                        }

                        .content {
                          display: inline-block;
                          margin: 0 8%;

                          div {
                            width: 4em;
                            height: 4em;
                            text-align: center;
                            border: 1px solid #ffffff;
                            border-radius: 70px;
                            display: inline-block;
                            cursor: pointer;
                            -webkit-touch-callout: none;
                            -webkit-user-select: none;
                            -khtml-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;

                            span:nth-child(1) {
                              display: block;
                              font-size: 1.8em;
                              height: 1em;
                              margin-top: 0.2em;
                            }

                            span:nth-child(2) {
                              font-size: 0.6em;
                            }
                          }

                          div:hover {
                            background-color: #ffffff;
                            color: #000000;
                            -webkit-touch-callout: none;
                            -webkit-user-select: none;
                            -khtml-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                          }
                        }
                      }
                    }

                    .nocircle {
                      width: auto !important;
                      border: none !important;
                      height: auto !important;
                    }

                    @media all and (max-width: 470px) {
                      .content {
                        margin: 0 5% !important;
                      }
                    }

                    @media all and (max-width: 350px) {
                      .content {
                        margin: 0 2% !important;
                      }
                    }

                    @media all and (max-height: 470px) {
                      #linefour {
                        bottom: 2% !important;
                      }

                      #linethree {
                        bottom: 23% !important;
                      }

                      #linetwo {
                        bottom: 43% !important;
                      }

                      #lineone {
                        bottom: 63% !important;
                      }
                    }

                  </style>
                  <div class="keypadwrapper">
                    <div class="inputwrapper">
                      <span class="numberinput"></span>
                      <span class="numberinput"></span>
                      <span class="numberinput"></span>
                      <span class="numberinput"></span>
                    </div>
                    <div class="keypad">
                      <div id="lineone" class="numberline">
                        <div class="content">
                          <div>
                            <span class="number">1</span>
                            <span>___</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">2</span>
                            <span>ABC</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">3</span>
                            <span>DEF</span>
                          </div>
                        </div>
                      </div>
                      <div id="linetwo" class="numberline">
                        <div class="content">
                          <div>
                            <span class="number">4</span>
                            <span>GHI</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">5</span>
                            <span>JKL</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">6</span>
                            <span>MNO</span>
                          </div>
                        </div>
                      </div>
                      <div id="linethree" class="numberline">
                        <div class="content">
                          <div>
                            <span class="number">7</span>
                            <span>PQRS</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">8</span>
                            <span>TUV</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">9</span>
                            <span>WXYZ</span>
                          </div>
                        </div>
                      </div>
                      <div id="linefour" class="numberline">
                        <div class="content">
                          <div>
                            <span class="number"><</span>
                            <span>___</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">0</span>
                            <span>___</span>
                          </div>
                        </div>
                        <div class="content">
                          <div>
                            <span class="number">*</span>
                            <span>___</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->


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
    let in_foc = '';
    let in_foc_name = '';

    $('input').click(function(){
      in_foc = $('input:focus');
      in_foc_name = in_foc[0].name
      console.log(in_foc);
      console.log(in_foc_name);
    });


    let val = '';
    $('.keypad div button').click(function(){
      let _this = $(this);
      // console.log(_this);
      // console.log(_this[0]);
      // console.log(_this[0].text());
      let ky = _this[0].textContent;

      switch (ky) {
        case 'C':
            ky  ='';
            val = '';
          break;
      
        default:
            val += ky;
            console.log(ky);
          break;
      }
      

      
      console.log(in_foc);
      $('input[name="'+in_foc_name+'"]').val(val);
    });
  </script>
  <!--\KEYPAD RIZ -->
</body>
</html>
