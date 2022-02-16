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

  .ada_surat{
    display:none;
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
              <h3 class="box-title" style="font-size:16pt;">Form Surat Keterangan</h3>
            </div>
            <div class="box-body">
                <form class="Form_post" id="form_ket">
                  <table class="table table-borderred table-striped tbl_form" name="tbl_form">
                    <tr>
                      <td>Nomor Billing</td>
                      <td><input name="nobill" type="text" placeholder="Enter cari billing..." style="width:70%;" autocomplete="off"/></td>
                    </tr>
                    <tr class="ada_surat" >
                      <td>Kode Surat</td>
                      <td><input name="kodeSurat" type="text" disabled="disabled" style="width:70%;"/></td>
                    </tr>
                    <tr>
                      <td>Nama</td>
                      <td><input name="nama" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td><input name="sex" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Usia</td>
                      <td><input name="usia" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td><textarea name="alamat" id="" cols="30" rows="3" disabled="disabled"></textarea></td>
                    </tr>
                    <tr>
                      <td>Nomor KTP/SIM/ID</td>
                      <td><input name="ktp" type="text" disabled="disabled" /></td>
                    </tr>
                    <tr>
                      <td colspan=2>Telah menjalani pemeriksaan kesehatan dan tes Covid-19 berupa:</td>
                    </tr>
                                        
                    <tr class="bgLabel">
                      <td>RT PCR Hapusan Tenggorokan</td>
                      <td>
                        <select name="pcr" style="width:50px;">
                          <!-- <option value=""></option> -->
                          <option value="Tidak">Tidak dilakukan</option>
                          <option value="Ya">Dilakukan</option>
                        </select>
                      </td>
                    </tr>
                    
                    <tr>
                      <td>Tanggal</td>
                      <td><input name="pcrTgl" type="text" class="datepickers" style="width:50%;" autocomplete="off"/></td>
                    </tr>
                    <tr>
                      <td>Hasil</td>
                      <td>
                        <select name="pcrHasil" style="width:50px;">
                          <option value=""></option>
                          <option value="Positif">Positif</option>
                          <option value="Negatif">Negatif</option>
                        </select>
                      </td>
                    </tr>
                                        
                    <tr class="bgLabel">
                      <td>Rapid Test</td>
                      <td>
                        <select name="rapid" style="width:50px;">
                          <option value=""></option>
                          <option value="antigen">Antigen Anti SARS CoV 2</option>
                          <option value="antibodi">Antibodi Anti SARS CoV 2</option>
                        </select>
                      </td>
                    </tr>                    
                    <tr>
                      <td>Tanggal</td>
                      <td><input name="rapidTgl" type="text" class="datepickers" style="width:50%;" autocomplete="off"/></td>
                    </tr>
                    <tr>
                      <td>Hasil</td>
                      <td>
                        <select name="rapidHasil" style="width:50px;">
                          <option value=""></option>
                          <option value="Reaktif">Reaktif</option>
                          <option value="Non Reaktif">Non Reaktif</option>
                          <option value="Negatif">Negatif</option>
                          <option value="Positif">Positif</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>IgM</td>
                      <td>
                        <select name="igM" style="width:50px;">
                          <option value=""></option>
                          <option value="Reaktif">Reaktif</option>
                          <option value="Non Reaktif">Non Reaktif</option>
                          <option value="Negatif">Negatif</option>
                          <option value="Positif">Positif</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>IgG</td>
                      <td>
                        <select name="igG" style="width:50px;">
                          <option value=""></option>
                          <option value="Reaktif">Reaktif</option>
                          <option value="Non Reaktif">Non Reaktif</option>
                          <option value="Negatif">Negatif</option>
                          <option value="Positif">Positif</option>
                        </select>
                      </td>
                    </tr>
                    
                    
                    
                    <tr class="bgLabel">
                      <td>Radiologi</td>
                      <td>
                        <select name="rad" style="width:50px;">
                          <!-- <option value=""></option> -->
                          <option value="Tidak">Tidak dilakukan</option>
                          <option value="Ya">Dilakukan</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Photo Thorax</td>
                      <td><textarea name="radKet" id="" cols="30" rows="3"></textarea></td>
                    </tr>
                    
                    
                    <tr>
                      <td>Dokter</td>
                      <td>
                        <select name="dokter" style="width:250px;">
                          <option value="">-pilih dokter-</option>
                          <?php
                          for ($i=0; $i < count($dokter); $i++) { 
                            echo '<option value="'.$dokter[$i]['kode'].'">'.$dokter[$i]['nama'].'</option>';
                          }
                          ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <!-- <button type="submit" class="btn btn-success">Buat Asesmen</button> -->
                        <input type="hidden" name="kode" value="KET">
                        <button id="btn_insert" href="<?=base_url('rm/insert_surat_ket');?>" class="btn btn-success"  style="margin-right:15px;">Simpan</button>
                        <button id="btn_update" href="<?=base_url('rm/update_surat_ket');?>" class="btn btn-warning ada_surat" style="margin-right:15px;">Update</button>
                        <button id="btn_delete" href="<?=base_url('rm/delete_surat_ket');?>" class="btn btn-danger ada_surat" style="margin-right:15px;">Hapus</button>
                        <button id="btn_cetak" href="<?=base_url('rm/print_surat_ket');?>" class="btn btn-info ada_surat" style="margin-right:15px;">Cetak</button>
                        
                        
                      </td>
                    </tr>
                  </table>
                  <!-- <.?php echo "<pre>",print_r($dokter),"</pre>"?> -->
                
                </form>
            </div>
          </div>

        </div>
        

      </div>


    </section>
  </div>

  <div id="div_frame"></div>