   <!-- Styles -->
    <style>
    #chartdiv {
      width: 90%;
      height: 500px;
      /*width: 300px;
      height: 500px;*/
    }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }

    </style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h3>Laporan Indikator Mutu</h3></section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Input Data Laporan Indikator Mutu</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>Jenis Pelayanan</td>
                  <td>: 
                    <?php 
                    $tahun = ['2018','2019'];
                    $jnsPelayananDivisi = array(
                      "RANAP 2", "RANAP 3", "ICU", "NICU", "BERSALIN", "IRJ",
                      "IKO", "IGD", "RADIOLOGI", "LAB", "GIZI", 
                      "IFRS", "SDM", "PK", "PEMASARAN", "KEUANGAN", 
                      "IPS", "RM", "PEMBELIAN&GUDANG NON MEDIS", "PPI",
                      "TIM PPRA", "TIM GERIATRI", "TIM PONEK"
                    ); ?>
                    <select name="sel_jnsPelayananDivisi">
                      <?php 
                      if($uakses_det['level_page'] == "MEMBER"){
                        $jnsPelayananDivisi = array( $uakses_det['filter_val'] ); 
                      }

                      foreach($jnsPelayananDivisi as $divisi){
                        echo '<option value="'.$divisi.'">'.$divisi.'</option>';
                      }

                      // for($i=0; $i<count($jnsPelayananDivisi); $i++){
                      //   echo '<option value="'.$jnsPelayananDivisi[$i].'">'.$jnsPelayananDivisi[$i].'</option>';
                      // }

                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Indikator</td>
                  <td>&ensp;<textarea name="indikator" cols="30" rows="4"></textarea></td>
                </tr>
                <tr>
                  <td>Standar</td>
                  <td>: <input name="standar" type="text" /></td>
                </tr>
                <tr>
                  <td>Satuan</td>
                  <td>: 
                    <select name="satuanStandar">
                      <option value="">%</option>
                      <option value="">menit</option>
                      <option value="">detik</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="btn_insert_lapIndikatorMutu" class="btn btn-primary">Tambahkan Indikator</button>
                    <!-- <button name="btn_update_lapIndikatorMutu" class="btn btn-warning">Edit</button> &emsp;
                    <button name="btn_delete_lapIndikatorMutu" class="btn btn-danger">Hapus</button> -->
                  </td>
                </tr>
              </table>
              
              

            </div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Grafik Laporan Indikator Mutu (progress)</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>Jenis Pelayanan</td>
                  <td>: 
                    <input type="hidden" name="level_page" value="<?=$uakses_det['level_page']?>">
                    <?php
                    if($uakses_det['level_page'] == "MEMBER"){
                      $jnsPelayananDivisi = array( $uakses_det['filter_val'] ); 
                    } ?>
                    <select name="sel_divisi_grf">
                      <?php
                      foreach($jnsPelayananDivisi as $divisi){
                        echo '<option value="'.$divisi.'">'.$divisi.'</option>';
                      } ?>
                    </select>
                    <select name="sel_tahun_grf">
                      <?php
                      foreach($tahun as $th){ echo '<option value="'.$th.'">'.$th.'</option>'; }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Indikator</td>
                  <td>: 
                    <select name="sel_indikator_grf"></select>
                  </td>
                </tr>
                
                <tr>
                  <td colspan="2">
                    <button name="btn_ld_grfIndikatorMutu" class="btn btn-primary">Tampilkan Grafik</button>
                    <!-- <button name="btn_update_lapIndikatorMutu" class="btn btn-warning">Edit</button> &emsp;
                    <button name="btn_delete_lapIndikatorMutu" class="btn btn-danger">Hapus</button> -->
                  </td>
                </tr>
              </table>              

            </div>
            
            <div class="box-body" name="grf_line_indikatormutu"></div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Tabel Laporan Indikator Mutu</h3>
            </div>

            <div class="box-body form-inline">
              <select name="sel_mutu_bulan" class="form-control">
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
              <select name="sel_mutu_tahun" class="form-control">
                <?php
                  foreach($tahun as $th){ echo '<option value="'.$th.'">'.$th.'</option>'; }
                ?>
              </select>
              <select name="sel_jnsPelayananDivisi_filter" class="form-control">
                <?php
                if($uakses_det['level_page'] == "MANAGER"){
                  echo '<option value="SEMUA">SEMUA</option>';
                }

                foreach($jnsPelayananDivisi as $divisi){
                  echo '<option value="'.$divisi.'">'.$divisi.'</option>';
                } ?>
              </select>
              <button class="btn btn-primary" name="btn_ld_lapIndikatorMutu" title="Load berdasarkan bulan tahun">
                <i class="fa fa-refresh"></i>
              </button>
            </div>

            <div class="box-body" name="tbl_mutu_mst"></div>

          </div>
        </div>
      </div>


      <!-- ================ [ MODAL ] =================== -->

      <div class="modal fade" id="modal_mutu_edit" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Indikator Mutu: </h4>
            </div>
            <div class="modal-body" id="el_modal_mutu_edit">

                
                    <table class="table table-borderred table-striped">
                      <tr>
                        <td>Jenis Pelayanan</td>
                        <td>: 
                          <?php $jnsPelayananDivisi = array(
                            "RANAP", "ICU", "NICU", "BERSALIN", "IRJ",
                            "IKO", "IGD", "RADIOLOGI", "LAB", "GIZI", 
                            "IFRS", "SDM", "PK", "PEMASARAN", "KEUANGAN", 
                            "IPS", "RM", "PEMBELIAN&GUDANG NON MEDIS", "PPI"
                          ); ?>
                          <select name="MDEL_sel_jnsPelayananDivisi">
                            <?php 
                            foreach($jnsPelayananDivisi as $divisi){
                              echo '<option value="'.$divisi.'">'.$divisi.'</option>';
                            } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Indikator</td>
                        <td>&ensp;<textarea name="MDEL_indikator" cols="30" rows="4"></textarea></td>
                      </tr>
                      <tr>
                        <td>Standar</td>
                        <td>: <input name="MDEL_standar" type="text" /></td>
                      </tr>
                      <tr>
                        <td>Satuan</td>
                        <td>: 
                          <select name="satuanStandar">
                            <option value="">%</option>
                            <option value="">menit</option>
                            <option value="">detik</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <button name="btn_mutu_edit" class="btn btn-warning">Edit Indikator</button>
                          <!-- <button name="btn_update_lapIndikatorMutu" class="btn btn-warning">Edit</button> &emsp;
                          <button name="btn_delete_lapIndikatorMutu" class="btn btn-danger">Hapus</button> -->
                        </td>
                      </tr>
                    </table>
                   

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- ================ [ MODAL ] =================== -->
          

    </section>
  </div>