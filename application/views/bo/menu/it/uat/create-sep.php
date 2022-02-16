<style>
/* input[type=text], select{ */
.myForm input[type=text], .myForm select{
  /* height:22px !important; */
  height:22px;
  margin-bottom:3px;
  border-radius:2px;
  border-width: thin;
}

div.dataTables_wrapper {
  margin: 0 auto;
  width: 90%;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"></section>
    
    <!-- Main content -->
    <section class="content">
      	<div class="row">
	        <div class="col-md-6">
	          <div class="box box-info">
	            <div class="box-body">
                <h3 class="bold" style="margin-top:0px;">Surat Kontrol</h3>
                <table>
                  <tr>
                    <td>Tgl. Rencana Kontrol/Inap</td>
                    <td><input type="text" class="datepicker"></td>
                  </tr>
                  <tr>
                    <td>Pelayanan</td>
                    <td><input type="text" class=""></td>
                  </tr>
                  <tr>
                    <td>No.Surat Kontrol/Inap</td>
                    <td><input type="text" class=""></td>
                  </tr>
                  <tr>
                    <td>Spesialis</td>
                    <td><input type="text" class=""></td>
                  </tr>
                  <tr>
                    <td>DPJP Tujuan Kontrol</td>
                    <td><input type="text" class=""></td>
                  </tr>
                  <tr>
                    <td>
                      <input type="submit" value="OK">
                    </td>
                    <td></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      	
        
        <div class="row">
	        <div class="col-md-12">
	          <div class="box box-info">
	            <div class="box-body">    
                <input type="text" id="mainSearchBox">

                <h3 class="bold">Create SEP</h3>
                <!-- <table name="tbl_data_bpjs" class="my_tbl table table-sm"> -->
                
                <form action="<?=base_url('wsbpjs2/createSep');?>" name="frmCreateSep" class="myForm" method="POST">
                  <table name="tbl_data_bpjs" class="my_tbl">
                    <tr><td colspan=4 style="text-align:center;"><h4 id="lbl_data_bpjs" style="cursor:pointer;" title="DoubleClick: tampil tombol SEP">DATA BPJS</h4></td></tr>
                    <tr><td>Nomor KIS</td><td><input type="text" name="noka" autocomplete="off" placeholder="enter untuk cari..."></td></tr>
                    <tr><td>Jenis Pelayanan</td>
                        <td>
                          <select name="jnsPelayanan" style="width:155px;">
                            <option value="2">Rawat Jalan</option>
                            <option value="1">Rawat Inap</option>
                          </select>
                        </td>
                    </tr>
                    <tr><td>Nomor KTP</td><td><input type="text" name="nik_bpjs" disabled="disabled"></td></tr>
                    <tr><td>Nama Peserta</td><td><input type="text" name="nama_bpjs" disabled="disabled"></td></tr>
                    <tr><td>Tanggal Lahir</td><td><input type="text" name="tgllahir_bpjs" disabled="disabled"></td></tr>
                    <tr><td>Kelas</td><td><input type="text" name="kelas_bpjs" disabled="disabled"></td></tr>
                    <tr><td>Jenis Peserta</td><td><input type="text" name="jns_peserta" disabled="disabled"></td></tr>
                    <tr><td>Nomor RM</td><td><input type="text" name="norm_bpjs" autocomplete="off"></td></tr>
                    <tr><td>Nomor Telp</td><td><input type="text" name="telp_bpjs" autocomplete="off"></td></tr>
                    
                    <tr><td colspan=2><hr style="margin:3px auto;"></td></tr>
                    <tr><td>Asal Rujukan</td>
                        <td>
                          <select name="asalRujukan" style="width:155px;">
                            <option value="1">Faskes 1</option>
                            <option value="2">Faskes 2(RS)</option>
                          </select>
                        </td>
                    </tr>
                    <tr><td>Tanggal Rujukan</td><td><input type="text" name="tglRujukan" class="datepicker"></td></tr>
                    <tr><td>Nomor Rujukan</td><td><input type="text" name="noRujukan"></td></tr>
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
                    <tr><td>DPJP Pemberi SKDP</td><td><input type="text" name="dpjp_bpjs" autocomplete="off"></td></tr>
                    <input type="hidden" name="dpjpKode_bpjs" value="">
                    <tr><td>DPJP yang Melayani</td><td><input type="text" name="dpjpLayan_bpjs" autocomplete="off"></td></tr>
                    <input type="hidden" name="dpjpLayanKode_bpjs" value="">
                    <tr><td>Klinik <input type="text" name="klinikkey" autocomplete="off" style="width:50px;"> </td>
                        <td>
                          <select name="klinik" style="width:155px;">
                            <option value=""></option>
                          </select>
                        </td>
                    </tr>
                    <tr><td>Tanggal SEP</td><td><input type="text" name="tglSep" class="datepicker" autocomplete="off" value="<?=date('Y-m-d');?>"></td></tr>
                    <tr><td>Diagnosa <input type="text" name="dxkey" autocomplete="off" style="width:50px;"> </td>
                        <td><select name="dx" style="width:155px;">
                              <option value=""></option>
                            </select>
                        </td>
                    </tr>
                    <tr><td>Catatan</td><td><input type="text" name="catatan_bpjs" autocomplete="off"></td></tr>
                    <!-- <tr><td>Status Kecelakaan</td><td><input type="text" name="status_laka" autocomplete="off"></td></tr> -->
                    <tr><td>Katarak</td><td><input type="checkbox" name="chk_katarak"></td></tr>
                    
                    <!-- <tr><td></td><td><button id="btn_create_sep" class="btn btn-danger" style="display:none;">Create SEP</button></td></tr> -->
                    <tr><td></td><td><input type="submit" class="btn btn-danger" value="Create SEP"></td></tr>
                  </table>

                  <input type="hidden" name="wsbpjs" value="">

                </form>

                  <div id="modal_list"></div>
                  <div id="modal_mst_mRjk"></div>
                  <div id="xtbl_list"></div>

	            </div>
	            
	          </div>
	          
	        </div>
    	</div>

    </section>
  </div>

