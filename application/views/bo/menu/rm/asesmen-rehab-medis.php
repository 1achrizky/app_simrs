<style>
  input, textarea{width:100%;}
  select{height:25px;}

  .bold{font-weight:bold;}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header bold" style="height:70px; text-align:center;"><h3>ASESMEN REHAB MEDIS</h3></section>

    <section class="">
      
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box-body form-inline">
              <input type="text" name="tgl_start" class="form-control datepickers date_xls" autocomplete="off">
              &nbsp; - &nbsp;
              <input type="text" name="tgl_end" class="form-control datepickers date_xls" autocomplete="off">
              
              <!-- <button type="button" class="btn btn-success btn-flat" name="btn_dl_excel">
                <i class="fa fa-download"></i> Excel
              </button> -->
              <a id="btn_dl_excel" href="" class="btn btn-success btn-flat" >
                <i class="fa fa-download"></i> Excel
              </a>
            </div>
        </div>
      </div>
    </section>


    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <!-- <div class="col-md-5"> -->
        <div class="col-md-10 col-md-offset-1">

          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center; padding-bottom:0px;">
              <h3 class="box-title bold" style="font-size:16pt;">FORM ASESMEN</h3>
            </div>
            <div class="box-body">

              <form class="Form_post" id="asesmen-form">
                <div class="row">
                  <div class="col-md-6">
                      <table class="table table-borderred table-striped tbl_form" name="tbl_form">
                        <tr>
                          <td>NORM</td>
                          <td><input name="norm" type="text" placeholder="Enter cari NORM..." style="width:50%;" autocomplete="off"/></td>
                        </tr>
                        <tr>
                          <td>Pilih Siklus</td>
                          <td>
                            <select name="paket" style="width:50px;">
                              <option value=""></option>
                              <!-- <option value="">Buat Paket Baru</option> -->
                            </select>

                            <button id="btn_paketbaru" href="<?=base_url('rm/insert_asesmen_rehab');?>" class="btn btn-success"  style="margin-right:15px;">Siklus Baru</button>
                          </td>
                        </tr>
                        <tr>
                          <td>Nama</td>
                          <td><input name="nama" type="text" disabled="disabled" /></td>
                        </tr>
                        <tr>
                          <td>Tanggal Lahir</td>
                          <td><input name="tglLahir" type="text" disabled="disabled" /></td>
                        </tr>
                        <tr>
                          <td>Jenis Kelamin</td>
                          <td><input name="sex" type="text" disabled="disabled" /></td>
                        </tr>
                        <tr>
                          <td>Alamat</td>
                          <td><textarea name="alamat" id="" cols="30" rows="3" disabled="disabled"></textarea></td>
                        </tr>
                        
                        <tr>
                          <td>Rujukan dari Dokter</td>
                          <td>
                              <?php // echo print_r($dokter_sp);?>
                            <select name="dokterPerujuk" style="width:250px;">
                              <option value="">-pilih dokter-</option>
                              <?php
                              for ($i=0; $i < count($dokter_sp); $i++) { 
                                echo '<option value="'.$dokter_sp[$i]['Kode'].'">'.$dokter_sp[$i]['Nama'].'</option>';
                              }
                              ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Tanggal Rujukan</td>
                          <td><input name="tglRujukan" type="text" class="datepickers" style="width:50%;" autocomplete="off"/></td>
                        </tr>

                        <tr>
                          <td>Tanggal Pelayanan</td>
                          <td><input name="tglPelayanan" type="text" class="datepickers" style="width:50%;" autocomplete="off"/></td>
                        </tr>
                        <tr>
                          <td>Anamnesa</td>
                          <td><textarea name="anamnesa" id="" cols="30" rows="3"></textarea></td>
                        </tr>
                        <tr>
                          <td>Pemeriksaan Fisik dan Uji Fungsi</td>
                          <td><textarea name="fisik" id="" cols="30" rows="3"></textarea></td>
                        </tr>
                        <tr>
                          <td>Pemeriksaan Penunjang</td>
                          <td><textarea name="penunjang" id="" cols="30" rows="3"></textarea></td>
                        </tr>
                        <tr>
                          <td>Diagnosa Primer</td>
                          <td><input name="dxPrimer" type="text" autocomplete="off"/></td>
                        </tr>
                        <tr>
                          <td>Diagnosa Sekunder</td>
                          <td><input name="dxSekunder" type="text" autocomplete="off"/></td>
                        </tr>
                      </table>
                  </div>
                  
                  <div class="col-md-6">
                      <table class="table table-borderred table-striped tbl_form" name="tbl_form">
                        
                        <tr>
                          <td>Tatalaksana KFR</td>
                          <td><textarea name="tatalaksanaKFR" id="" cols="30" rows="3"></textarea></td>
                        </tr>
                        <tr>
                          <td>Anjuran</td>
                          <td><textarea name="anjuran" id="" cols="30" rows="3"></textarea></td>
                        </tr>
                        <tr>
                          <td>Dokter</td>
                          <td>
                            <select name="dokter" style="width:250px;">
                              <option value="">-pilih dokter-</option>
                              <?php
                              for ($i=0; $i < count($dokter); $i++) { 
                                echo '<option value="'.$dokter[$i]['Kode'].'">'.$dokter[$i]['Nama'].'</option>';
                              }
                              ?>
                            </select>
                          </td>
                        </tr>
                        
                        <tr>
                          <td>Frekuensi Tindakan</td>
                          <td><input name="frekuensi" type="text" autocomplete="off"/></td>
                        </tr>
                        <tr>
                          <td>Lama 1 siklus asesmen</td>
                          <td><input name="siklus" type="text" autocomplete="off"/></td>
                        </tr>
                        <tr>
                          <td>Goal of Treatment</td>
                          <td><input name="goal" type="text" autocomplete="off"/></td>
                        </tr>
                        <tr>
                          <td colspan=2 class="bold">Achievement of goal (Diisi setelah 1 siklus asesmen selesai dilaksanakan) <br>
                          </td>
                        </tr>
                        <tr>
                          <td>Tanggal</td>
                          <td><input name="goalTgl" type="text" class="datepickers" style="width:50%;" autocomplete="off"/></td>
                        </tr>
                        <tr>
                          <td>Hasil</td>
                          <td><textarea name="goalHasil" cols="30" rows="2"></textarea></td>
                        </tr>

                        <tr>
                          <td colspan=2> <span class="bold">Rencana tindak lanjut pasien</span> <br>
                            <!-- <input type="hidden" name="tindakLanjut" value=""> -->
                            <table class="table">
                              <tr>
                                <td>
                                <input type="checkbox" name="tindak1" class="cbox_tindakLanjut" value="0"/> 
                                Pasien memerlukan tambahan siklus terapi / asesmen baru
                                </td>
                              </tr>
                              <tr>
                                <td>
                                <input type="checkbox" name="tindak2" class="cbox_tindakLanjut" value="0"/>
                                Pasien kontrol kembali ke DPJP perujuk</td>
                              </tr>
                              <tr>
                                <td>
                                <input type="checkbox" name="tindak3" class="cbox_tindakLanjut" value="0"/>
                                Pasien selesai terapi tidak perlu control kembali ke DPJP perujuk</td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        
                        <tr>
                          <td colspan="2">
                            <!-- <button type="submit" class="btn btn-success">Buat Asesmen</button> -->                            
                            <!-- <button id="btn_simpan" onclick="submitForm('<.?=base_url('rm/insert_asesmen_rehab');?>')" class="btn btn-success">Buat Asesmen</button>
                            <button id="btn_update" onclick="submitForm('<.?=base_url('rm/update_asesmen_rehab');?>')" class="btn btn-warning">Edit</button> -->
                                                  
                            <button id="btn_update" href="<?=base_url('rm/update_asesmen_rehab');?>" class="btn btn-warning" style="margin-right:15px;">Update</button>
                            <button id="btn_delete" href="<?=base_url('rm/delete_asesmen_rehab');?>" class="btn btn-danger" style="margin-right:15px;">Hapus</button>
                                                        
                          </td>
                        </tr>
                      </table>
                  </div>
                </div>

                    <!-- <form class="Form_post" action="<.?=base_url('rm/insert_asesmen_rehab');?>" method="POST"> -->
              
                      <!-- <.?php echo "<pre>",print_r($dokter),"</pre>"?> -->   
                      
              </form>

            </div>
          </div>

        </div>
        
        
        

      </div>

      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center; padding-bottom:0px;">
              <h3 class="box-title bold" style="font-size:16pt;">FORM PROTOKOL TERAPI</h3>
            </div>
            <div class="box-body">                          

              <button id="btn_li_tindakan" class="btn btn-success" style="margin-right:10px;">List Tindakan</button>
              
              <table class="table table-borderred table-striped tbl_form" id="tbl_li_sel">
                <thead>
                  <tr>
                    <th>No.</th>
                    <!-- <th>Nobill</th> -->
                    <th>SEP</th>
                    <th>Tanggal Masuk</th>
                    <th>Tindakan</th>
                    <th>Keterangan</th>
                    <th>Opsi</th>
                  </tr>                
                </thead>
                <tbody></tbody>
              </table>

             

            </div>
          </div>

           <!-- <button id="btn_simpan" href="<.?=base_url('rm/insert_asesmen_rehab');?>" class="btn btn-success" style="margin-right:15px;">Buat Asesmen</button> -->
                            
            <button id="btn_cetak_protokol_terapi" class="btn btn-warning" style="margin-right:15px;">Cetak</button>
            <button id="btn_download" href="<?=base_url('main/file_pdf/popup_print/protokol-terapi-rehab/');?>" class="btn btn-success" style="margin-right:15px;">Download</button>
                            

        </div>
      </div>


      <div id="modal_store_tindakan"></div>
          

    </section>
  </div>

  <div id="div_frame"></div>