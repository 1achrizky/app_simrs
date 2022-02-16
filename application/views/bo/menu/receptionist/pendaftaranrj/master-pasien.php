<style>
.lbl_right tr td:nth-child(1){
  text-align:right; 
  padding-right:3px;
  padding-left:20px;
}

table tr{
  /* margin-bottom:3px; */
  height:28px;
}

.tb50{
  /* width:50%; */
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="height:30px;">
    </section>
    <input type="hidden" id="ip_client" value="<?=my_ip()['client'];?>">
    
    <!-- Main content -->
    <section class="content">

      
      <div class="row">
          <div class="col-md-12">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:20pt; font-weight:bold;">PENDAFTARAN PASIEN</h3>
              </div>
              <div class="box-body">
                <table style="margin:0px auto;">
                  <tr>
                    <td style="vertical-align:top;">
                        <table name="tbl1" class="lbl_right tb50">
                          <tr>
                            <td>No. RM</td>
                            <td>
                              <button title="Update Telp" id="btn_update_telp"><i class="fa fa-arrow-up"></i> </button>
                              <input type="text" id="NoRM" autocomplete="off" style="width:123px;">
                            </td>                        
                          </tr>
                          <tr>
                            <td>Barcode</td>
                            <td><input type="text" id="Barcode" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          <tr>
                            <td>No.KTP / SIM</td>
                            <td><input type="text" id="NoIdentitas" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          <tr>
                            <td>Nama</td>
                            <td><input type="text" id="Nama" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          
                          <tr>
                            <td>Tempat Lahir</td>
                            <td>
                              <select id="TempatLahirKode" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <?php
                                  for ($i=0; $i < count($kota); $i++) { 
                                    echo '<option value="'.$kota[$i]['Kode'].'">'.$kota[$i]['Keterangan'].'</option>';
                                  }
                                ?>
                              </select>
                            </td>                        
                          </tr>
                          <tr>
                            <td>Tanggal Lahir</td>
                            <td><input type="text" id="TglLahir" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          <tr>
                            <td>Umur</td>
                            <td><input type="text" id="Umur" autocomplete="off" style="width:30px;"> Tahun</td>                     
                          </tr>
                          

                          


                          <tr>
                            <td>Telp</td>
                            <td><input type="text" id="Telp" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          <tr>
                            <td>HP</td>
                            <td><input type="text" id="HP" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          <tr>
                            <td>Fax</td>
                            <td><input type="text" id="Fax" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td><input type="text" id="Email" autocomplete="off" style="width:123px;"></td>                     
                          </tr>
                          <tr>
                            <td>Golongan Darah</td>
                            <td>
                              <select id="sel_darah" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                              </select>
                            </td>                      
                          </tr>
                          <tr>
                            <td>Sex</td>
                            <td>
                              <select id="sel_sex" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                              </select>
                            </td>                      
                          </tr>
                          <tr>
                            <td>Marital</td>
                            <td>
                              <select id="sel_marital" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <option value="Y">Kawin</option>
                                <option value="T">Belum Kawin</option>
                                <option value="D">Duda</option>
                                <option value="J">Janda</option>
                              </select>
                            </td>                      
                          </tr>
                        </table>

                    </td>
                    <td style="vertical-align:top;">
                        <table name="tbl2" class="lbl_right tb50">
                          <tr>
                            <td>Alamat</td>
                            <td><textarea id="Alamat" cols="20" rows="2"></textarea></td>                     
                          </tr>
                          <tr>
                            <td>RT</td>
                            <td><input type="text" id="Rt" autocomplete="off" style="width:30px;"> &emsp;
                                RW <input type="text" id="Rw" autocomplete="off" style="width:30px;"> 
                            </td>                     
                          </tr>
                          <tr>
                            <td>Negara</td>
                            <td>
                              <!-- <button title="Update Telp" id="btn_update_telp"><i class="fa fa-arrow-up"></i> </button>
                              <input type="text" id="norm" autocomplete="off" style="width:123px;"> -->
                              <select id="sel_negara" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <?php
                                  for ($i=0; $i < count($negara); $i++) { 
                                    echo '<option value="'.$negara[$i]['Kode'].'">'.$negara[$i]['Keterangan'].'</option>';
                                  }
                                ?>
                              </select>
                            </td>                        
                          </tr>
                          <tr>
                            <td>Propinsi</td>
                            <td>
                              <select id="sel_propinsi" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <?php
                                  for ($i=0; $i < count($propinsi); $i++) { 
                                    echo '<option value="'.$propinsi[$i]['Kode'].'">'.$propinsi[$i]['Keterangan'].'</option>';
                                  }
                                ?>
                              </select>
                            </td>                        
                          </tr>
                          <tr>
                            <td>Kota</td>
                            <td>
                              <select id="sel_kota" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <?php
                                  for ($i=0; $i < count($kota); $i++) { 
                                    echo '<option value="'.$kota[$i]['Kode'].'">'.$kota[$i]['Keterangan'].'</option>';
                                  }
                                ?>
                              </select>
                            </td>                        
                          </tr>
                          <tr>
                            <td>Kecamatan</td>
                            <td>
                              <select id="sel_kecamatan" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                              </select>
                            </td>                        
                          </tr>
                          <tr>
                            <td>Kelurahan</td>
                            <td>
                              <select id="sel_kelurahan" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                              </select>
                            </td>                        
                          </tr>

                          <tr>
                            <td>Agama</td>
                            <td>
                              <select id="sel_agama" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <?php
                                  for ($i=0; $i < count($agama); $i++) { 
                                    echo '<option value="'.$agama[$i]['Kode'].'">'.$agama[$i]['Keterangan'].'</option>';
                                  }
                                ?>
                              </select>
                            </td>                        
                          </tr>
                          <tr>
                            <td>Pendidikan</td>
                            <td>
                              <select id="sel_pendidikan" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <?php
                                  for ($i=0; $i < count($pendidikan); $i++) { 
                                    echo '<option value="'.$pendidikan[$i]['Kode'].'">'.$pendidikan[$i]['Keterangan'].'</option>';
                                  }
                                ?>
                              </select>
                            </td>                        
                          </tr>
                          <tr>
                            <td>Pekerjaan</td>
                            <td>
                              <select id="sel_pekerjaan" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="">-</option>
                                <?php
                                  for ($i=0; $i < count($pekerjaan); $i++) { 
                                    echo '<option value="'.$pekerjaan[$i]['Kode'].'">'.$pekerjaan[$i]['Keterangan'].'</option>';
                                  }
                                ?>
                              </select>
                            </td>                        
                          </tr>
                          
                          <tr>
                            <td>Anggota Perusahaan</td>
                            <td>
                              <button title="Update Telp" id="btn_update_telp"><i class="fa fa-arrow-up"></i> </button>
                              <input type="text" id="norm" autocomplete="off" style="width:123px;">
                            </td>                        
                          </tr>
                          

                          <tr>
                            <td>Keterangan</td>
                            <td>
                              <textarea id="" cols="20" rows="3"></textarea>
                            </td>                     
                          </tr>
                          
                          <tr>
                            <td><button id="simpanMstPx" class="btn btn-success">Simpan</button></td>
                            <td>
                            </td>                     
                          </tr>

                          
                        </table>
                    </td>
                  </tr>
                </table>


                  
                  
                  
                  

              </div>
            </div>
          </div>
      </div>
      <!-- /.row -->

    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
