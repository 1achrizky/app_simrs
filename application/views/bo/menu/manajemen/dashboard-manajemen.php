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

    .ta-center, .ta-c{
      text-align:center;
    }

    table>thead>tr>th{
      text-align:center;
    }

    </style>

    
              <div class="modal modal-info fade" id="mdl_rj_today_det">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><strong>Detail Rawat Jalan</strong></h4>
                    </div>
                    <!-- <div class="modal-body" style="background-color: #00a7d0 !important;"> -->
                    
                    <div class="modal-body" style="background-color: #0090B5 !important;">
                      <!-- <.?php echo "<pre>", print_r($rj),"</pre>";?> -->
                      <table class="table table-borderred" name="tbl_rj_today_det">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Nama Lokasi</th>
                            <th>Jumlah Kunjungan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            for ($i=0; $i < count($rj); $i++) { 
                              $tbody = 
                                '<tr>'.
                                  '<td>'.($i+1).'. </td>'.
                                  '<td>'.$rj[$i]['lokasiket'].'</td>'.
                                  '<td class="ta-c" style="ext-align:center;">'.$rj[$i]['jml_px_all'].'</td>'.
                                '</tr>';
                                echo $tbody;
                            }                          
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal modal-info fade" id="mdl_ri_today_det">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><strong>Detail Rawat Inap</strong></h4>
                    </div>
                    <!-- <div class="modal-body" style="background-color: #00a7d0 !important;"> -->
                    <div class="modal-body" style="background-color: #0090B5 !important;">
                      <table class="table table-borderred" name="tbl_ri_today_det">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Kamar</th>
                            <th>Tersedia</th>
                            <th>Terpakai</th>
                            <th>Checkout</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $tersedia=0; $terpakai=0; $checkout=0; $rj_today=0;
                            $tbody_tbl_ri = '';
                            for ($i=0; $i < count($bedri); $i++) {                               
                              $tersedia += (int)$bedri[$i]['jml_ready'];
                              $terpakai += (int)$bedri[$i]['jml_in'];
                              $checkout += (int)$bedri[$i]['jml_checkout'];
                              
                              $tbody_tbl_ri .= 
                                '<tr>'.
                                  '<td>'.($i+1).'</td>'.
                                  '<td>'.$bedri[$i]['namaRuang'].'</td>'.
                                  '<td class="ta-c">'.$bedri[$i]['jml_ready'].'</td>'.
                                  '<td class="ta-c">'.$bedri[$i]['jml_in'].'</td>'.
                                  '<td class="ta-c">'.$bedri[$i]['jml_checkout'].'</td>'.
                                '</tr>';
                              
                            }                          
                          ?>
                          <?=$tbody_tbl_ri;?>
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">DASHBOARD MANAJEMEN</h2></section>
    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="rj_today"><?=$visit['rj_today']?></h3>

              <p>Pasien</p>
            </div>
            <div class="icon">
              <i class="fa fa-stethoscope"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#mdl_rj_today_det" title="Lihat Detail Rawat Jalan">Rawat Jalan</a>
          </div>
        </div>
        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="tersedia"><?=$tersedia?></h3>

              <p>Kamar Tersedia</p>
            </div>
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#mdl_ri_today_det" title="Lihat Detail Rawat Inap">Rawat Inap</a>
          </div>
        </div>

        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="terpakai"><?=$terpakai?></h3>

              <p>Kamar Terpakai</p>
            </div>
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#mdl_ri_today_det" title="Lihat Detail Rawat Inap">Rawat Inap</a>
          </div>
        </div>

        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="checkin"><?=$panel[0]['checkin']?></h3>

              <p>Check In</p>
            </div>
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#mdl_ri_today_det" title="Lihat Detail Rawat Inap">Rawat Inap</a>
          </div>
        </div>
        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="pxri_today"><?=$panel[0]['pxri_today']?></h3>

              <p>Pasien</p>
            </div>
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#mdl_ri_today_det" title="Lihat Detail Rawat Inap">Rawat Inap</a>
          </div>
        </div>

        <div class="col-lg-2">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="checkout"><?=$panel[0]['checkout']?></h3>

              <p>Check Out</p>
            </div>
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#mdl_ri_today_det" title="Lihat Detail Rawat Inap">Rawat Inap</a>
          </div>
        </div>

      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="form-inline">
            <input type="text" name="tgl_start" class="form-control datepicker" placeholder="tanggal mulai..." autocomplete="off" value="<?=date('Y-m-d')?>">
            <span> - </span>
            <input type="text" name="tgl_end" class="form-control datepicker" placeholder="tanggal selesai..." autocomplete="off" value="<?=date('Y-m-d')?>">            
          </div>
        </div>
        <div class="col-md-6">
          <span>*Tanpa Bed Bayi</span>
        </div>
      </div>

      <!-- <div class="row">
        <div class="col-md-12">
              <div class="progress active">
                <div class="val progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                  <span class="sr-only">0% Complete</span>
                </div>
              </div>
        </div>
      </div> -->
      
      <div class="row">
        
        <div class="col-md-6">
          <h3 class="box-title" style="text-align: center;font-weight: bold;">KUNJUNGAN RAWAT JALAN
            
            <button type="button" class="btn btn-info btn-flat" name="btn_ld_dboard_mnj_visit_rj">
              Load <i class="fa fa-arrow-circle-right"></i>
            </button>
          </h3>
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Rincian Tiap Klinik Spesialis</h3>
              <button class="btn btn-success btn-flat" id="btn_dl_rincianKlinikSP" title="Download Excel"><i class="fa fa-download"></i></button>
              <br>
              <h3 class="box-title">Total : <span name="tot_rincian_grf_bar_kunjungan_klinik_1hari"></span></h3>
            </div>

            <div class="box-body" name="grf_bar_kunjungan_klinik_1hari"></div>
            <div class="box-body with-border" name="grf_bar_kunjungan_klinik_1hari_legend"></div>

          </div>



          
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Rincian Tiap Dokter Spesialis</h3>
            </div>

            <div class="box-body" name="tbl_kunjungan_px_to_sp_by_1hari"></div>
          </div>



          
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Rincian Tiap Penanggung</h3><br>
              <h3 class="box-title">Total : <span name="tot_kunjungan_px_penanggung_by_rangehari"></span></h3>
            </div>
            <div class="box-body" name="grf_donat_kunjungan_px_penanggung_by_rangehari"></div>
            <div class="box-body with-border" name="grf_donat_kunjungan_px_penanggung_by_rangehari_legend"></div>
          </div>

          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Rincian Tiap Demografi</h3>
            </div>

            <div>
              <div class="box-header" style="text-align: center; padding:0px;">
                <h5 class="box-title" style="font-size:14pt; font-weight: bold;">Suku Bangsa</h5>
              </div>
              <div class="box-body" name="grf_donat_kunjungan_px_demografi_suku_by_rangehari"></div>
              <div class="box-body with-border" name="grf_donat_kunjungan_px_demografi_suku_by_rangehari_legend"></div>
              
            </div>
              
            <div>
              <div class="box-header" style="text-align: center; padding:0px;">
                <h5 class="box-title" style="font-size:14pt; font-weight: bold;">Agama</h5>
              </div>
              <div class="box-body" name="grf_donat_kunjungan_px_demografi_agama_by_rangehari"></div>
              <div class="box-body with-border" name="grf_donat_kunjungan_px_demografi_agama_by_rangehari_legend"></div>
            </div>

            <div>
              <div class="box-header" style="text-align: center; padding:0px;">
                <h5 class="box-title" style="font-size:14pt; font-weight: bold;">Wilayah (Top 10)</h5>
              </div>
              <div class="box-body" name="tbl_kunjungan_px_demografi_kec_top10_by_rangehari"></div>
            </div>
              
            

          </div>


        </div>



        <!-- ------------------------------------------------- RAWAT INAP ------------------------------------------------- -->

        <div class="col-md-6">
          <h3 class="box-title" style="text-align: center;font-weight: bold;">KUNJUNGAN RAWAT INAP
            <button type="button" class="btn btn-success btn-flat" name="btn_ld_dboard_mnj_visit_ri">
              Load <i class="fa fa-arrow-circle-right"></i>
            </button>
          </h3>

          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Rincian Tiap Penanggung</h3><br>
              <h3 class="box-title">Total : <span name="tot_rincian_grf_donat_kunjunganri_penanggung_rangehari"></span></h3>
            </div>
            <div class="box-body" name="grf_donat_kunjunganri_px_penanggung_by_rangehari"></div>
            <div class="box-body with-border" name="grf_donat_kunjunganri_px_penanggung_by_rangehari_legend"></div>

          </div>


          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Jumlah Pasien Rawat Inap</h3>
            </div>

            <div class="box-body" name="tbl_select_kunjunganri_px_kmr_by_rangehari"></div>
          </div>



          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Rincian Tiap Demografi RI</h3>
            </div>

            <div>
              <div class="box-header" style="text-align: center; padding:0px;">
                <h5 class="box-title" style="font-size:14pt; font-weight: bold;">Suku Bangsa</h5>
              </div>
              <div class="box-body" name="grf_donat_select_kunjunganri_px_demografi_suku_by_rangehari"></div>
              <div class="box-body with-border" name="grf_donat_select_kunjunganri_px_demografi_suku_by_rangehari_legend"></div>
              
            </div>
              
            <div>
              <div class="box-header" style="text-align: center; padding:0px;">
                <h5 class="box-title" style="font-size:14pt; font-weight: bold;">Agama</h5>
              </div>
              <div class="box-body" name="grf_donat_select_kunjunganri_px_demografi_agama_by_rangehari"></div>
              <div class="box-body with-border" name="grf_donat_select_kunjunganri_px_demografi_agama_by_rangehari_legend"></div>
            </div>

            <div>
              <div class="box-header" style="text-align: center; padding:0px;">
                <h5 class="box-title" style="font-size:14pt; font-weight: bold;">Wilayah (Top 10)</h5>
              </div>
              <div class="box-body" name="tbl_select_kunjunganri_px_demografi_kec_top10_by_rangehari"></div>
            </div>           

          </div>


          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Morbiditas (Top 10)</h3>
            </div>
            <div class="box-body" name="tbl_select_kunjunganri_px_dx_top10_by_rangehari"></div>
          </div>


        </div>



      </div>

          

    </section>
  </div>