<style>

.hidden{
  display: none;
}


.my_tbl_form td:nth-child(1),
.my_tbl_form td:nth-child(3){
  text-align:right;
}

.my_tbl_form tr td{
  padding: 0px 5px 3px;
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
        <!-- <form action="#" name="form_daftar_online" method="POST"> -->
          <div class="col-md-12">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:20pt; font-weight:bold;">ENTRY KLAIM JASA RAHARJA</h3>
              </div>
              <div class="box-body">
              


                <div class="row">
                  <div class="col-md-12">
                    <div id="errors"></div>
                  </div>
                </div>

                <div class="row">                    
                  <div class="col-md-6">
                      <table id="tbl_form1" class="my_tbl_form" >
                        
                        <tr>
                          <td>NOMOR BILLING</td>
                          <td><input type="text" id="nobill" autocomplete="off"></td>
                        </tr>
                        <tr>
                          <td>NORM / GENDER</td>
                          <td>
                            <input type="text" id="norm" disabled="disabled" style="width:80px;"> / 
                            <input type="text" id="sex" disabled="disabled" style="width:50px;">
                          </td>
                        </tr>
                        <tr>
                          <td>NAMA PASIEN</td>
                          <td><input type="text" id="nama" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>TANGGAL MASUK</td>
                          <td><input type="text" id="TanggalMasuk" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>NIK</td>
                          <td><input type="text" id="nik" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>TEMPAT LAHIR</td>
                          <td><input type="text" id="TempatLahir" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>TANGGAL LAHIR</td>
                          <td><input type="text" id="tglLahir" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>TELP</td>
                          <td><input type="text" id="telp" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>DIAGNOSA AWAL</td>
                          <td><input type="text" id="dxawal" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>RUANG</td>
                          <td><input type="text" id="ruang" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>STATUS PENGAJUAN</td>
                          <td><input type="text" id="statusPengajuan" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>ALAMAT PASIEN</td>
                          <td><textarea name="" id="alamat" cols="" rows="3" disabled="disabled"></textarea></td>
                        </tr>
                      </table>
                      
                  </div>
                  
                  
                  <div class="col-md-6">
                      <table id="tbl_form2" class="my_tbl_form">
                        <tr>
                          <td>TANGGAL PENGAJUAN</td>
                          <td><input type="text" id="tglPengajuan" class="form-control datepicker input-n" autocomplete="off" value="<?=date('Y-m-d');?>"></td>
                        </tr>
                        <tr>
                          <td>JAM PENGAJUAN</td>
                          <td><input type="text" id="jamPengajuan" class="form-control input-n" autocomplete="off" placeholder="hh:mm:ss" value="<?=date('H:i:s');?>"></td>
                        </tr>
                        <tr>
                          <td>TANGGAL LAKA</td>
                          <td><input type="text" id="tglLaka" class="form-control datepicker input-n" autocomplete="off" value="<?=date('Y-m-d');?>"></td>
                        </tr>
                        <tr>
                          <td>TKP</td>
                          <td><input type="text" id="tkp" autocomplete="off"></td>
                        </tr>
                        <tr>
                          <td>STATUS LP</td>
                          <td><input type="text" id="statusLP" autocomplete="off"></td>
                        </tr>
                        
                        <tr>
                          <td>BIAYA AMBULAN</td>
                          <td><input type="text" id="biayaAmbulan" class="keypress" autocomplete="off"></td>
                        </tr>
                        <tr>
                          <td>BIAYA P3K</td>
                          <td><input type="text" id="biayaP3K" class="keypress" autocomplete="off"></td>
                        </tr>
                        <tr>
                          <td>BIAYA PERAWATAN</td>
                          <td><input type="text" id="biayaPerawatan" class="keypress" autocomplete="off"></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td><button class="btn btn-success" id="btn_entry"> Entry </button></td>
                        </tr>
                        
                      </table>
                      
                  </div>
                </div>

              </div>
            </div>
          </div>
      </div>


    </section>
  </div>
