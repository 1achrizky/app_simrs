<style>
 
  .bold{
    font-weight: bold;
  }

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Laporan Insiden</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Tabel Laporan Insiden</h3>
            </div>

            <div class="box-body form-inline">
              <input type="text" id="in_datestart" class="form-control datepicker" autocomplete="off">
              &nbsp; - &nbsp;
              <input type="text" id="in_dateend" class="form-control datepicker" autocomplete="off">
              <button type="button" class="btn btn-primary btn-flat" id="btn_ld">
                <i class="fa fa-arrow-circle-right"></i>
              </button>
              <button type="button" class="btn btn-success btn-flat" id="btn_dl_excel">
                <i class="fa fa-download"></i> Excel
              </button>
              
            </div>
            <div class="box-body" id="tbl_store"></div>
          </div>
        </div>
      </div>


      <div class="box-body" id="modal_list"></div>

    </section>
  </div>





  
  <!-- ================ [ MODAL ] =================== -->

      <!-- <div class="modal fade" id="modal_detail_pasien" role="dialog"> -->
      <div class="modal fade" id="mdl_det" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Detail Pasien</h4>
            </div>
            <div class="modal-body" id="el_modal2">

                  
                
                  <div class="row">
                    <div class="col-md-6">
                        <!-- <table id="tbl_mdl_p1"> -->
                        <table id="tbl_mdl_p1">
                          
                          <tr>
                            <td>Nomor Billing</td>
                            <td><input type="text" name="nobill" autocomplete="off"></td>
                          </tr>
                          <tr>
                            <td>NoRM</td>
                            <td><input type="text" name="norm" disabled="disabled"></td>
                          </tr>
                          <tr><td>Nama</td><td><input type="text" name="nama" disabled="disabled"></td></tr>
                          <tr>
                            <td>Jenis Kelamin</td>
                            <td>
                              <input type="text" name="gender" disabled="disabled">
                              <!-- <select id="gender" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                              </select> -->
                            </td>              
                          </tr>
                          <tr>
                            <td>Asuransi</td>
                            <td>
                              <select name="asuransix" id="" style="width:155px;"  disabled="disabled">
                                <option value="UMUM">UMUM</option>
                                <option value="BPJS">BPJS</option>
                                <option value="ASURANSI LAIN">ASURANSI LAIN</option>
                              </select>
                              <input type="hidden" name="asuransi">
                            </td>
                          </tr>
                          <tr>
                            <td>Tgl Masuk RS</td>
                            <td>
                              <input type="text" id="tgl_masuk" disabled="disabled">
                            </td>
                          </tr>
                          <tr>
                            <td>Jenis Asuhan</td>
                            <td>
                              <input type="text" name="jnsAsuhx" disabled="disabled">
                              <input type="hidden" name="jnsAsuh"> 
                            </td>
                              <!-- <select name="jnsAsuh" id="" style="width:155px;">
                                <option value="RJ">Rawat Jalan</option>
                                <option value="RI">Rawat Inap</option>
                                <option value="UG">IGD</option>
                              </select> -->
                            
                          </tr>
                          <tr><td>Tgl Insiden</td><td><input type="text" name="tglIns" class="form-control datepicker input-n" autocomplete="off" value="<?=date('Y-m-d');?>"></td></tr>
                          <tr><td>Jam Insiden</td>
                              <td>
                                <input type="text" name="jamIns" class="form-control input-n" autocomplete="off" placeholder="hh:mm:ss" value="<?=date('H:i:s');?>">
                              </td></tr>                          

                          <tr><td>Insiden</td><td><textarea name="insiden" id="" cols="35" rows="3" placeholder=""></textarea></td></tr>
                        
                          <tr><td>Grade Resiko</td>
                              <td>
                                <input type="radio" name="grade" value="Biru"> Biru
                                <input type="radio" name="grade" value="Hijau"> Hijau
                                <input type="radio" name="grade" value="Kuning"> Kuning
                                <input type="radio" name="grade" value="Merah"> Merah                            
                              </td></tr>
                          <tr><td>Kronologis Insiden</td><td><textarea name="kronologis" id="" cols="35" rows="3" placeholder=""></textarea></td></tr>

                          <tr>
                            <td>Jenis Insiden</td>
                            <td>
                              <select name="jnsInsiden" id="" style="width:155px;">
                                <option value="">- pilih -</option>
                                <option value="KNC">Kejadian Nyaris Cedera / KNC (Near miss)</option>
                                <option value="KTD">Kejadian Tidak diharapkan / KTD (Adverse Event) / Kejadian Sentinel (Sentinel Event)</option>
                                <option value="KTC">Kejadian Tidak Cedera / KTC</option>
                                <option value="KPC">KPC</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Pemberi Laporan</td>
                            <td>
                              <select name="pelapor" id="" style="width:155px;">
                                <option value="">- pilih -</option>
                                <option value="Karyawan">Karyawan : Dokter/Perawat</option>
                                <option value="Pasien">Pasien</option>
                                <option value="Keluarga">Keluarga / Pendamping pasien</option>
                                <option value="Pengunjung">Pengunjung</option>
                                <option value="Lain">Lainnya</option>
                              </select>
                            </td>
                          </tr>
                          <tr><td>Lokasi Kejadian</td><td><textarea name="lokasiKejadian" id="" cols="35" rows="3" placeholder=""></textarea></td></tr>
                        
                        
                        
                        </table>
                        
                    </div>


                    <div class="col-md-6">
                      <table id="tbl_mdl_p2">

                        <tr><td>Insiden Terjadi Pada</td>
                            <td>
                              <select name="lokasiInsiden" style="width:155px;">
                                <option value="">- pilih -</option>
                              </select>
                            </td></tr>
                        
                        <tr><td>Unit Kerja Penyebab</td>
                            <td>
                              <?php $units = [ 
                                  "Komite Mutu dan Manajemen Risiko", 
                                  "Komite Pencegahan dan Pengendalian Infeksi", 
                                  "Rekam Medis", "Pelayanan Konsumen",
                                  "IFRS", "Pemasaran", "OK", "Laboratorium",
                                  "Radiologi", "IRJ", "IGD", "Ranap2", "Ranap3",
                                  "ICU", "NICU", "Bersalin", "IPS", "PPI", "Keuangan",
                                  "SDM", "GIZI", "Pengadaan", "IT", "KPRS", "GERIATRI",
                                  "PONEK", "PPRA",
                                ]; ?>
                              <select name="unitPenyebab" style="width:155px;">
                                <option value="">- pilih -</option>
                                <?= loop_sel_opt($units); ?>
                              </select>
                            </td></tr>
                        
                        <tr><td>Dampak Pada Pasien</td>
                            <td>
                              <select name="dampak" style="width:155px;">
                                <option value="">- pilih -</option>
                                <option value="Kematian">Kematian</option>
                                <option value="Cedera Berat">Cedera Irreversibel / Cedera Berat</option>
                                <option value="Cedera Sedang">Cedera Reversibel / Cedera Sedang</option>
                                <option value="Cedera Ringan">Cedera Ringan</option>
                                <option value="Tidak cedera">Tidak ada cedera</option>
                              </select>
                            </td></tr>
                        
                        <tr><td>Tindakan Setelah Kejadian dan hasilnya</td><td><textarea name="tdknStlhKejadian" id="" cols="35" rows="3" placeholder="Tuliskan tindakan apa saja yang dilakukan setelah insiden dan apa hasilnya..."></textarea></td></tr>
                        <tr>
                          <td>Tindakan dilakukan oleh</td>
                          <td><input type="text" name="pelakuTindakan" autocomplete="off" placeholder="Tim terdiri dari..., dokter, perawat, dll" style="width:258px;"></td>
                        </tr>
                        <tr><td>Insiden serupa pernah terjadi</td><td><textarea name="insidenSerupa" id="" cols="35" rows="3" placeholder="Kapan? dan Langkah/tindakan apa yang telah diambil pada Unit kerja sersebut untuk mencegah terulangnya kejadian yang sama?"></textarea></td></tr>
                        <tr><td>Analisa RCA</td><td><textarea name="analisaRCA" id="" cols="35" rows="3" placeholder=""></textarea></td></tr>
                        <!-- <tr><td></td><td>
                              <input type="submit" value="Entry Insiden" class="btn btn-success btn-rscm">
                            </td></tr> -->




                      </table>
                      
                    </div>


                  </div>

                  

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
  <!-- ================ [ \MODAL ] =================== -->