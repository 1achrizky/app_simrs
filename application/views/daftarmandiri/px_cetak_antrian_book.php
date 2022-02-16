<style>
  .font-big, select>option{
    font-size: 20px;
  }

  #btn_cetak_antrian_skdp{
    /*width:300px;*/
    width:100%;
  }

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="height:30px;">
    </section>

    <div id="modal_numpad"></div>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- <form action="#" name="form_daftar_online" method="POST"> -->
          <div class="col-md-6 col-md-offset-3">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h1 class="box-title" style="font-size:28pt;">Pengambilan <br> Antrian BOOKING</h1>
                <!-- <h3>(Pengambilan Antrian Klinik & SKDP)</h3> -->
              </div>
              <div class="box-body">


                
                <div class="row font-big">
                  <div class="col-md-8 col-md-offset-2">
                                        
                    <div class="form-group">
                      <div class="input-group">
                        
                        <!-- <input type="text" name="in_cari_by" class="form-control" data-inputmask='"mask": "999999"' data-mask autocomplete="off" placeholder="Masukkan no...." required> -->
                        NORM: 
                        <input type="text" id="norm" class="form-control" autocomplete="off" placeholder="NORM" required>
                        <br><br>
                        Tanggal untuk dapatkan billing: <br>
                        <input type="text" id="tgl" class="form-control" autocomplete="off" placeholder="Tanggal untuk dapatkan billing..." value="<?=date('Y-m-d');?>" required>
                        <!-- <button id="getKlinik" class="btn btn-info">Cari Klinik</button> -->
                        <br><br>
                        <!-- <input type="text" id="klinik" class="form-control" autocomplete="off" placeholder="NORM" required> -->
                        Klinik: <select id="selKlinik">
                          <!-- <option value="">-pilih-</option> -->
                        </select>
                        

                        <button id="btn_cetak_antrian_skdp" class="btn btn-success" style="margin-top: 30px;">CETAK NO.REQUEST</button>
                      </div>
                    </div>

                  </div>
                </div>


                <div class="row font-big">
                  <div class="col-md-8 col-md-offset-2">
                    
                    
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
  


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
  <script type='text/javascript' src="<?=base_url();?>assets/js/site_uat.js"></script>
</body>
</html>
