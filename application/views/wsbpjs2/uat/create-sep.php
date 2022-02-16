<style>
input[type=text], select{
  height:22px !important;
  margin-bottom:2px;
  border-radius:2px;
  border-width: thin;
}

div.dataTables_wrapper {
  margin: 0 auto;
  width: 90%;
}

.datepicker{
  width:80px;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- <section class="content-header" style="height:70px;"></section> -->
    
    <!-- Main content -->
    <section class="content">
      	<div class="row">
	        
        </div>
      	
        
        <div class="row">
	        <div class="col-md-6">
	          <div class="box box-info">
	            <div class="box-body">    
                <input type="text" id="mainSearchBox">

                <h3 class="bold">Create SEP</h3>
                <!-- <table name="tbl_data_bpjs" class="my_tbl table table-sm"> -->
                
                <div id="notifLabel"></div>
                <!-- <span name="" class="alert alert-success" style="padding:5px 5px;">Status Peserta: AKTIF</span>
                <span class="alert alert-danger" style="padding:5px 5px;"><i class="fa fa-exclamation-circle"></i> Billing AKTIF. Tidak boleh mendaftar.</span>

                <div style="margin:2px 0px;"><span name="" class="alert alert-success" style="padding:0px 5px;">Status Peserta: AKTIF</span></div>
                 -->


                <!-- <form action="<.?=base_url('wsbpjs2/createSep');?>" name="frmCreateSep" method="POST"> -->
                <form action="<?=base_url('wsbpjs2/');?>" name="frmCreateSep" method="POST">
                  <table name="tbl_data_bpjs" class="my_tbl">
                    <tr><td colspan=4 style="text-align:center;"><h4 id="lbl_data_bpjs" style="cursor:pointer;" title="DoubleClick: tampil tombol SEP">DATA BPJS</h4></td></tr>
                    <tr><td>Nomor KIS <button id="btn_ambil_booking"><i class="fa fa-search" title="Ambil Booking"></i></button></td>
                        <td><input type="text" name="noka" autocomplete="off" placeholder="enter untuk cari..."></td></tr>
                        <input type="hidden" name="FL_ambil_px_book" value="">
                        <input type="hidden" name="book_date" value="">
                        <input type="hidden" name="book_time" value="">
                    <tr><td>Jenis Pelayanan</td>
                        <td>
                          <select name="jnsPelayanan" style="width:155px;">
                            <option value="2">Rawat Jalan</option>
                            <option value="1">Rawat Inap</option>
                          </select>
                        </td>
                    </tr>
                    <tr><td>Nomor KTP</td><td><input type="text" name="nik_bpjs" autocomplete="off" placeholder="enter untuk cari..."></td></tr>
                    <tr><td>Nama Peserta</td><td><input type="text" name="nama_bpjs" disabled="disabled"></td></tr>
                    <tr><td>Tanggal Lahir</td><td><input type="text" name="tgllahir_bpjs" disabled="disabled"></td></tr>
                    <tr><td>Kelas</td><td><input type="text" name="kelas_bpjs" autocomplete="off" required></td></tr>
                    <tr><td>Jenis Peserta</td><td><input type="text" name="jns_peserta" disabled="disabled"></td></tr>
                    <tr><td>Prolanis</td><td><input type="text" name="prolanis" disabled="disabled"></td></tr>
                    <tr><td>Nomor RM</td><td><input type="text" name="norm_bpjs" autocomplete="off"></td></tr>
                    <tr><td>Nomor Telp</td><td><input type="text" name="telp_bpjs" autocomplete="off" required></td></tr>
                    
                    <tr><td colspan=2><hr style="margin:3px auto;"></td></tr>
                    <tr><td>Asal Rujukan</td>
                        <td>
                          <select name="asalRujukan" style="width:155px;">
                            <option value="1">Faskes 1</option>
                            <option value="2">Faskes 2(RS)</option>
                          </select>
                        </td>
                    </tr>
                    <tr><td>Nomor Rujukan</td><td><input type="text" name="noRujukan" autocomplete="off" required></td></tr>
                    <tr><td>Tanggal Rujukan</td><td><input type="text" name="tglRujukan" class="datepicker"></td></tr>
                    <tr><td>PPK Asal Rujukan</td><td><input type="text" name="asalPpk"></td></tr>
                    <input type="hidden" name="asalPpkKode" value="">
                    <tr><td colspan=2><hr style="margin:3px auto;"></td></tr>

                    <tr><td>Nomor SKDP</td>
                        <td>
                          <div class="input-group input-group-sm"  style="width:170px;">
                            <input type="text" name="skdp" autocomplete="off" class="form-control">
                            <span class="input-group-append">	  			
                              <button id="cari_skdp" title="Cari SKDP"><i class="fa fa-search"></i></button>
                            </span>
                          </div>                            
                        </td>                        
                    </tr>
                    <tr><td>Klinik <input type="text" name="klinikkey" autocomplete="off" style="width:50px;"> </td>
                        <td>
                          <select name="klinik" style="width:155px;">
                            <option value=""></option>
                          </select>
                        </td>
                    </tr>
                    <tr><td>DPJP Pemberi SKDP</td><td><input type="text" name="dpjp_bpjs" autocomplete="off" required></td></tr>
                    <input type="hidden" name="dpjpKode_bpjs" value="">
                    <tr><td>DPJP Layanan</td><td><input type="text" name="dpjpLayan_bpjs" autocomplete="off" required></td></tr>
                    <input type="hidden" name="dpjpLayanKode_bpjs" value="">
                    
                    <tr><td>Tanggal SEP</td><td><input type="text" name="tglSep" class="datepicker" autocomplete="off" value="<?=date('Y-m-d');?>"></td></tr>
                    <tr><td>Diagnosa <input type="text" name="dxkey" autocomplete="off" style="width:50px;"> </td>
                        <td><select name="dx" style="width:155px;">
                              <option value=""></option>
                            </select>
                        </td>
                    </tr>
                    <tr><td>Catatan</td><td><input type="text" name="catatan_bpjs" autocomplete="off"></td></tr>
                    <!-- <tr><td>Status Kecelakaan</td><td><input type="text" name="status_laka" autocomplete="off"></td></tr> -->
                    <tr class="katarak" style="display:none;"><td>Katarak</td><td><input type="checkbox" name="chk_katarak"></td></tr>
                    

                    <style>
                      .laka{display:none;}
                    </style>
                    <tr><td>Status Kecelakaan</td>
                        <td>
                          <select name="lakaLantas" style="width:155px;">
                            <option value="">- pilih -</option>
                            <option value="0">Bukan Kecelakaan lalu lintas</option>
                            <option value="1">KLL dan bukan kecelakaan Kerja</option>
                            <option value="2">KLL dan Kecelakaan Kerja</option>
                            <option value="3">Kecelakaan Kerja</option>
                          </select>
                        </td>
                    </tr>
                    <tr class="laka"><td>Tanggal Kejadian</td><td><input type="text" name="tglKejadian" class="datepicker" autocomplete="off" value="<?=date('Y-m-d');?>"></td></tr>
                    <tr class="laka"><td>No.LP</td><td><input type="text" name="noSepSuplesi" autocomplete="off"></td></tr>
                    <tr class="laka"><td>Lokasi Kejadian</td>
                        <td><select name="kdPropinsi" style="width:155px;"></select></td></tr>
                    <tr class="laka"><td></td><td><select name="kdKabupaten" style="width:155px;"></select></td></tr>
                    <tr class="laka"><td></td><td><select name="kdKecamatan" style="width:155px;"></select></td></tr>
                    <tr class="laka"><td>Keterangan Kejadian</td>
                        <td><textarea name="keterangan"></textarea></tr>
                    


                    <!-- <tr><td></td><td><button id="btn_create_sep" class="btn btn-danger" style="display:none;">Create SEP</button></td></tr> -->
                    <tr><td></td>
                        <td><input type="submit" name="createSep" class="btn btn-danger btn-xs" value="Create SEP"></td></tr>
                  </table>

                  <!-- <input type="hidden" name="wsbpjs" value=""> -->
                  <!-- <input type="hidden" name="wsfull" value=""> -->

                

                <br>
                <div id="xtbl_list">
                  NOSEP: <input type="text" name="nosep" autocomplete="off">
                  <button id="btnSepCari" class="btn btn-success btn-xs">Cari</button>

                  <!-- 0195R0281221V000001 -->
                  <!-- <button id="btnSepUpdate" class="btn btn-warning btn-xs">Update</button> -->
                  <input type="submit" name="updateSep" value="UPDATE" class="btn btn-warning btn-xs">
                  <!-- <input type="submit" id="deleteSep" value="Hapus" class="btn btn-warning btn-xs" style="margin-left:30px;"> -->
                  <button id="btnSepDelete" class="btn btn-danger btn-xs" style="margin-left:10px;">Hapus</button>
                </div>


                </form>


                  <div id="modal_list"></div>
                  <div id="modal_mst_mRjk"></div>
                  <div id="modal_mst_book"></div>
                  <div id="xtbl_list"></div>


                  

	            </div>
	            
	          </div>
	          
	        </div>


          <div class="col-md-6">

            <div class="box box-info">
	            <div class="box-body">
                <h3 class="bold" style="margin-top:0px;">Monitoring Histori Pelayanan</h3>
                No.Kartu : <input type="text" name="nokaHisto"> <br>
                
                <input type="text" name="tglAwal_Histo" class="datepicker" value="<?=selisih_hari(date("Y-m-d"), "-100")?>">
                - <input type="text" name="tglAkhir_Histo" class="datepicker" value="<?=date('Y-m-d');?>">
                <br>
                <button id="btnLdHisto" class="btn btn-success btn-xs">Load Histori</button>
                                 
              </div>
	            <div class="box-body" id="tblMainHisto"></div>
            </div>


	          <div class="box box-info">
	            <div class="box-body">
              <!-- 
              1) Cari SEP. dapat klinik
              2) CAri dokter, dapatkan kode dokternya.

              cek bila sudah buat surat kontrol
              http://192.168.1.68/rscm/app_dev/wsbpjs2/url?url=referensi/dokter/pelayanan/2/tglPelayanan/2021-12-20/Spesialis/INT


               -->
                <h3 class="bold" style="margin-top:0px;">Surat Kontrol</h3>
                <form action="<?=base_url('wsbpjs2/');?>" name="frmSuratKontrol" method="POST">
                    <table>
                      <tr>
                        <td>SEP Kontrol</td>
                        <td><input type="text" name="noSEPKontrol"></td>
                      </tr>
                      <tr>
                        <td>No.Rujukan</td>
                        <td><input type="text" name="noRujukanKontrol"></td>
                      </tr>
                      <tr>
                        <td>Tgl. Rencana Kontrol/Inap</td>
                        <td><input type="text" name="tglRencanaKontrol" class="datepicker" value="<?=date('Y-m-d');?>"></td>
                      </tr>
                      <!-- <tr>
                        <td>Pelayanan</td>
                        <td><input type="text" class=""></td>
                      </tr> -->
                      <!-- <tr>
                        <td>No.Surat Kontrol/Inap</td>
                        <td><input type="text" class=""></td>
                      </tr> -->
                      <tr>
                        <td>Spesialis <input type="text" name="poliKontrolKey" style="width:70px;"></td>
                        <td>
                          <select name="poliKontrol" style="width:155px;">
                            <option value=""></option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>DPJP Tujuan Kontrol</td>
                        <td>
                          <!-- <input type="text" name="kodeDokterKontrol" class=""> -->
                          <select name="kodeDokterKontrol" style="width:155px;">
                            <option value=""></option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <input type="submit" value="CREATE SURAT KONTROL" class="btn btn-success btn-xs">
                        </td>
                        <td>
                        
                        </td>
                      </tr>
                    </table>
                    <br>
                    No.Surat Kontrol : <input type="text" name="noSuratKontrolRes">
                    <br>
                    <input type="submit" name="updateSuratKontrol" value="UPDATE" class="btn btn-warning btn-xs">
                    <input type="submit" name="hapusSuratKontrol" value="HAPUS" class="btn btn-danger btn-xs" style="margin-left:10px;">
                </form>
              </div>
            </div>
          </div>
    	</div>

    </section>
  </div>

