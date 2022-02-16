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

    .tx-center{
      text-align:center;
    }

    table>thead>tr>th,
    table>tfoot>tr>th{
      text-align: center;
    }

    </style>

    

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Dashboard</h2></section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 name="cnt_ri_today"><?=$count_rirj_dboard['ri_today'];?></h3>

              <p>Rawat Inap</p>
            </div>
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <a href="#" class="small-box-footer">Hari ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 name="cnt_rj_today"><?=$count_rirj_dboard['rj_today'];?></h3>

              <p>Rawat Jalan</p>
            </div>
            <div class="icon">
              <i class="fa fa-stethoscope"></i>
            </div>
            <a href="#" class="small-box-footer">Hari ini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3 name="cnt_ri_yesterday"><?=$count_rirj_dboard['ri_yesterday'];?></h3>

              <p>Rawat Inap</p>
            </div>
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <a href="#" class="small-box-footer">Kemarin <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3 name="cnt_rj_yesterday"><?=$count_rirj_dboard['rj_yesterday'];?></h3>

              <p>Rawat Jalan</p>
            </div>
            <div class="icon">
              <i class="fa fa-stethoscope"></i>
            </div>
            <a href="#" class="small-box-footer">Kemarin <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->

      </div><!-- ./row -->
      
      <div class="row">

        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Kunjungan Poliklinik Berdasarkan Penanggung</h3>
            </div>
            <div class="box-body form-inline">
              <!-- <select name="sel_grf_line_kunjungan_poli" class="form-control">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
              </select> -->

              <input type="text" name="sel_grf_line_kunjungan_poli" class="form-control datepicker-y" placeholder="tahun..." style="width:100px;" autocomplete="off">

              <button type="button" class="btn btn-info btn-flat" name="btn_grf_line_kunjungan_poli">
                <i class="fa fa-arrow-circle-right"></i>
              </button>
            </div>
            <div class="box-body" name="grf_line_kunjungan_poli">
            </div>
            <div class="box-footer with-border">
              <ul class="list-inline" name="grf_line_kunjungan_poli_legend"></ul>             
              
            </div>
          </div>



          
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Kunjungan Poliklinik</h3>
            </div>
            <div class="box-body form-inline">
               <select name="sel_grf_kunjungan_all_bln" class="form-control">
                  <?php 
                  // foreach($sel_mutu_bulan as $bln){
                  //   echo '<option value="'.$bln.'">'.$bln.'</option>';
                  // } 
                  $sel_mutu_bulan = array(
                    "JANUARI", "FEBRUARI", "MARET", "APRIL", 
                    "MEI", "JUNI", "JULI", "AGUSTUS", 
                    "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"
                  );

                  for($i=0; $i<count($sel_mutu_bulan); $i++){
                    echo '<option value="'.($i+1).'">'.$sel_mutu_bulan[$i].'</option>';
                  } 

                  ?>
                </select>

                <!-- <select name="sel_grf_kunjungan_all_thn" class="form-control">
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                </select> -->

                <input type="text" name="sel_grf_kunjungan_all_thn" class="form-control datepicker-y" placeholder="tahun..." style="width:100px;" autocomplete="off">


                <button type="button" class="btn btn-info btn-flat" name="btn_grf_kunjungan_all_by_bln_th">
                  <i class="fa fa-arrow-circle-right"></i>
                </button>

                <?php if( $username != 'tamu'){ ?>
                <button type="button" class="btn btn-success btn-flat" name="btn_dl_dt_grf_kunjungan_all_by_bln_th" title="Download 1 Tahun">
                  <i class="fa fa-download"></i>
                </button>
                <?php } ?>
            </div>

            <div class="box-body" name="grf_donat_kunjungan_poli"></div>

            <div class="box-footer with-border" name="grf_donat_kunjungan_poli_legend">
              <!-- <ul class="list-inline" id="myLblLegend_Chart"></ul> -->
              <!-- <div id="myLblLegend_Chart" class="row"></div> -->
            </div>
          </div>



          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Kunjungan Tiap Poliklinik</h3>
            </div>
            <div class="box-body form-inline">
              <!-- <select name="sel_grf_select_kunjungan_tiapLokasi_by_lokasi_th" class="form-control">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
              </select> -->

              <input type="text" name="sel_grf_select_kunjungan_tiapLokasi_by_lokasi_th" class="form-control datepicker-y" placeholder="tahun..." style="width:100px;" autocomplete="off">


              <select name="sel_grf_kunjungan_sp" class="form-control">
                <?php
                  for ($i=0; $i < count($lokasi); $i++)
                    echo '<option value="'.$lokasi[$i]['lokasi'].'">'.$lokasi[$i]['lokasi'].'</option>';
                  
                ?>
              </select>

              

              <button type="button" class="btn btn-info btn-flat" name="select_kunjungan_tiapLokasi_by_lokasi_th">
                <i class="fa fa-arrow-circle-right"></i>
              </button>
            </div>
            
            <div class="box-body" name="grf_line_kunjungan_namaPoli"></div>

            <div class="box-footer with-border">
              <ul class="list-inline" name="grf_line_kunjungan_namaPoli_legend"></ul>
              
            </div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Informasi Ketersediaan Tempat Tidur</h3>
            </div>
            <div class="box-body" name="tbl_kamar_ready">
                <table class="table table-bordered table-striped" name="'+el_name+'">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Kamar</th>
                      <th>Tersedia</th>
                      <th>Terpakai</th>
                      <th>Checkout</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $list = $info_tt['list'];
                      $el = '';
                      for ($i=0; $i < count($list); $i++) { 
                        $el .= 
                          '<tr>'
                            .'<td>'.($i+1).'.</td>'
                            .'<td>'.$list[$i]['namaRuang'].'</td>'
                            .'<td class="tx-center">'.$list[$i]['jml_ready'].'</td>'
                            .'<td class="tx-center">'.$list[$i]['jml_in'].'</td>'
                            .'<td class="tx-center">'.$list[$i]['jml_checkout'].'</td>'
                            .'<td class="tx-center">'.$list[$i]['jml_all'].'</td>'
                          .'</tr>';
                      }
                      echo $el;

                      $total = (int)$info_tt['sum']['jml_ready'] + (int)$info_tt['sum']['jml_in'] + (int)$info_tt['sum']['jml_checkout'];
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th>TOTAL</th>
                      <th><?=$info_tt['sum']['jml_ready'];?></th>
                      <th><?=$info_tt['sum']['jml_in'];?></th>
                      <th><?=$info_tt['sum']['jml_checkout'];?></th>
                      <th><?=$total;?></th>
                    </tr>
                  
                  </tfoot>
                </table>
            </div>
          </div>
        </div>


      </div>

          

    </section>

  </div>