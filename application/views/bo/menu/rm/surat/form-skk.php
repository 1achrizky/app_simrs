<style>
  input, textarea{width:100%;}
  select{height:25px; width:150px !important;}

  .bgLabel{
    /* background-color:#b8eeff!important; */
    background-color:#d1d1d1 !important;
  }
  
  .bgLabel>td:nth-child(1){
    font-weight:bold;
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- <section class="content-header" style="height:70px;"><h3>Form Surat</h3></section> -->

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
                
        <div class="col-md-offset-3 col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center; padding-bottom:0px;">
              <h3 class="box-title" style="font-size:16pt;">Form Surat Keterangan Kematian</h3>
            </div>
            <div class="box-body">                          

              <form class="Form_post" id="form_skk">
                  <table class="table table-borderred table-striped tbl_form" name="tbl_form">
                    <tr>
                      <td>Nomor Billing</td>
                      <td><input name="norm" type="text" placeholder="Enter cari billing..." style="width:50%;" autocomplete="off"/></td>
                    </tr>
                    <tr>
                      <td>Nama Lengkap</td>
                      <td><input name="nama" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Nomor KTP</td>
                      <td><input name="ktp" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Tempat Tanggal Lahir</td>
                      <td><input name="sex" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td><input name="sex" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Pada Usia</td>
                      <td><input name="usia" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td><textarea name="alamat" id="" cols="30" rows="3" disabled="disabled"></textarea></td>
                    </tr>
                                                            
                    <tr>
                      <td>Tanggal Kematian</td>
                      <td><input name="deadTgl" type="text" class="datepickers" style="width:50%;" autocomplete="off"/></td>
                    </tr>
                    <tr>
                      <td>Pukul</td>
                      <td><input name="deadTgl" type="text" class="datepickers" style="width:50%;" autocomplete="off"/></td>
                    </tr>
                    
                    <tr>
                      <td>Sebab Kematian</td>
                      <td><textarea name="sebab" id="" cols="30" rows="3"></textarea></td>
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
                      <td>Jabatan</td>
                      <td>
                        <select name="rad" style="width:50px;">
                          <option value=""></option>
                          <option value="Dokter Jaga IGD">Dokter Jaga IGD</option>
                          <option value="Dokter Jaga Rawat Inap">Dokter Jaga Rawat Inap</option>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <input type="hidden" name="kode" value="SKK">
                        <button id="btn_update" href="<?=base_url('rm/update_asesmen_rehab');?>" class="btn btn-warning" style="margin-right:15px;">Update</button>
                        <button id="btn_delete" href="<?=base_url('rm/delete_asesmen_rehab');?>" class="btn btn-danger" style="margin-right:15px;">Hapus</button>
                        
                        
                      </td>
                    </tr>
                  </table>
                  <!-- <.?php echo "<pre>",print_r($dokter),"</pre>"?> -->
                
                </form>
             

            </div>
          </div>

           <!-- <button id="btn_simpan" href="<.?=base_url('rm/insert_asesmen_rehab');?>" class="btn btn-success" style="margin-right:15px;">Buat Asesmen</button> -->
                            
            <button id="btn_cetak_protokol_terapi" class="btn btn-warning" style="margin-right:15px;">Cetak</button>
            <!-- <a id="btn_download" href="<.?=base_url('main/file_pdf/popup_print/protokol-terapi-rehab/');?>" class="btn btn-success" style="margin-right:15px;">Download</a> -->
            <button id="btn_download" href="<?=base_url('main/file_pdf/popup_print/protokol-terapi-rehab/');?>" class="btn btn-success" style="margin-right:15px;">Download</button>
                            

        </div>

      </div>


    </section>
  </div>

  <div id="div_frame"></div>