<style>


  /*==================== index.php =======================*/

    /*==================== NAV=======================*/
    .my_nav{
      height: 50px;
      background-color: #009593;
    }
    
    #logout,#user_login{
      height: 50px;
      color: white;
      float: right;
      font-weight: bold;
      padding:10px 20px;
    }


    /*====================/NAV=======================*/
    /*====================/PART3=======================*/

    select[name=nama_dokter]{
      width:300px;
    }
    /*====================/PART3=======================*/


    .uppercase { text-transform: uppercase; }

    

      hr{
        background-color: #fff;
        border-top: 2px dashed #8c8b8b;
        width: 95%;
      }

      input[type=submit]{
        width:120px;
        height: 50px;
        margin-top: 50px; 
      }

      input[type=text]{
        //border-radius: 5px; 
      }

      input[name=namaPasien]{
        width:100%;
      }

      input[name=nosepIna]{
        width:200px;
      }
      #diag,#poli{
        width:200px;
      }

      table tr{
        height:40px;
      }

      table tr td:nth-child(1){
        margin:20px;
      }
      
      table[name=tblBuatKlaim] tr td:nth-child(1){
        text-align: right;
        padding:0 10px;
      }

      table[name=tblBuatKlaim] tr td input[name=namaPasien]{
        width:500px;
      }

      table[name=tblBuatKlaim] tr td:nth-child(2){
        //width:500px;
        text-align: left;
        padding:0 10px;
      }
      
      table[name=tblBuatKlaim],
      table[name=tblUpdateKlaimHead],
      table[name=tblUpdateKlaim],
      table[name=tblUpdateKlaimTarif]{
        //border:1px solid #000;
        margin:5px auto;
        text-align: center;
        
      }

      table[name=tblUpdateKlaimHead] tr td{
        padding:0 10px;
      }

      table[name=tblUpdateKlaim] tr td:nth-child(1) , table[name=tblUpdateKlaim] tr td:nth-child(3){
        text-align: right;
        padding:0 10px;
      }
      table[name=tblUpdateKlaim] tr td:nth-child(2),
      table[name=tblUpdateKlaim] tr td:nth-child(4){
        width:500px;
        text-align: left;
        padding:0 10px;

      }
      table[name=tblUpdateKlaim] tr td:nth-child(4){
        width:250px;
      }



      table[name=tblUpdateKlaimTarif] tr td{
        text-align: right;
        padding:0 15px;
      }

      table[name=tblUpdateKlaimTarif] tr td input{
        width:100px;
        text-align: right;
      }

      .bagian{
        text-align: center;
      }

      .buatKlaim button{
        margin:0px 10px;
      }


      #divDataKlaimRscm{
        width: 350px;
        margin:10px auto;
      }

      #divDataKlaimRscm textarea{
        display: block;
        margin:0 auto 10px;
      }




    /*========== DIAGNOSA & PROSEDUR =========*/
    
    .diagPanelUtama{
      width:900px;
      margin:0px auto;
    }


    .diagPanel{
      margin:0px auto;
      float: left;
    }

    .diagPanel1, .diagPanel2{
      width:50%;
    }

        
    ol[name=daftar_diagnosa_terpilih]{
      margin:0px auto;
      padding:0px;
    }
    
    ol[name=daftar_prosedur_terpilih]{
      margin:0px auto;
      width:400px;
    }

    ol[name=daftar_diagnosa_terpilih] li,
    ol[name=daftar_prosedur_terpilih] li{
      //width:300px;
      margin:0px auto;
    }

    ol[name=daftar_diagnosa_terpilih] li span,
    ol[name=daftar_prosedur_terpilih] li span{
      display:inline-block;
      //width:80%;
      width:300px;
      text-align:left;
      vertical-align: top;
    }


    table[name=tbl_historyDiagnosa] tr,.my_table tr{
      height : 25px;
    }

    table[name=tbl_historyDiagnosa] tr th, .my_table tr th{
      background-color: yellow;
      padding: 0px 10px;
    }
    

    /*(2) = Lokasi*/
    table[name=tbl_historyDiagnosa] tr th:nth-child(2),
    table[name=tbl_historyDiagnosa] tr td:nth-child(2){
      width:180px;
    }

    /*\========== DIAGNOSA & PROSEDUR ========*/




    /* divBtnFinalGroup*/
    .divBtnFinalGroup button{
      //width:110px;
      margin:0px 10px;
      padding: 5px 15px;
    }


    /*\divBtnFinalGroup*/
  /*=================== /index.php =======================*/

</style>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header" style="height:70px;"><h2 class="bold">Eclaim Rawat Jalan</h2></section>
  <!-- Main content -->
  <section class="content">
          
    <div class="row">
      <?php // echo "<pre>",print_r($_SESSION),"</pre>"; ?>
      <div class="col-md-12">




          <div style="background-color: #C0E8DE;">

            <div class="bagian">
              <h4>Integrasi SEP dan INACBG</h4>
              <label for="nosep">Nomor SEP{Inacbg}: </label>
              <input type="text" name="nosepIna" id="nosepIna" class="uppercase" />
              <!-- 
              <button id="btnCariSepIna" class="btn btn-primary">Cari SEP INA</button> -->
              
              <label for="nosep" style="margin-left: 30px">Billing: </label>

              
              
                <?php if($_SESSION['username'] == 'tppri'){	?>
                    <input type="text" name="nomor_billing_RI" class="uppercase" placeholder="no.billing RI" />
                    <button class="btn btn-primary" id="btnSepReplace_RI">INPUT SEP</button>
                <?php }else{ ?>
                    <input type="text" name="nomor_billing" class="uppercase"/>
                <?php } ?>

              <br>
              <!-- 
              <textarea name="hasiljsonIna" id="hasiljsonIna" cols="80" rows="3"></textarea> -->

            </div>
              


            <hr>
            <div class="bagian buatKlaim">
              <h4>Data Form dari VClaim</h4>
              <table name="tblBuatKlaim" border=1>
                <tr>
                  <td>No. RM (VClaim)</td>
                  <td><input type="text" name="nomor_rm"></td>
                </tr>
                <tr>
                  <td>No. RM (xlink)</td>
                  <td><input type="text" name="nomor_rm_xlink" disabled> ( Status: <span name="status_rm_xlink">-</span> )</td>
                </tr>
                <tr>
                  <td>*No. RM (BARU)</td>
                  <td><input type="text" name="nomor_rm_baru" placeholder="*Kasus Duplikasi SEP">
                  (*Khusus untuk EDIT harus diisi)</td>
                </tr>
                <tr>
                  <td>Nama Lengkap Pasien</td>
                  <td><input type="text" name="nama_pasien"></td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>
                    <input type="radio" name="radioJk" value="1" />
                    <label for="radio-jk-l">Laki-laki</label>
                    <input type="radio" name="radioJk" value="2" />
                    <label for="radio-jk">Perempuan</label>
                  </td>
                </tr>
                <tr>
                  <td>Tanggal Lahir</td>
                  <td><input type="text" name="tgl_lahir" id="tgl_lahir" class="datepicker" /></td>
                  <!--<td><input type="text" name="tgl_lahir" id="tgl_lahir" class="datepicker" value="<= date("d M Y")?>" /></td>-->
                </tr>
              </table>

            <?php
            if($_SESSION['username'] != 'tppri'){
            ?>
              <button id="btnBuatKlaimBaru" class="btn btn-primary">Buat Klaim Baru</button>
              <button id="btnEditKlaim" class="btn btn-warning">Edit Klaim</button>
              <button id="btnHapusKlaim" class="btn btn-danger">Hapus Klaim</button>
              <!-- 
              <button id="btnTesNewKlaim" class="btn btn-danger">[TES]NEW Klaim</button> -->
              
            </div>
            
            
            <hr>
            <div>
              <table name="tblUpdateKlaimHead" border=1>
                <tr>
                  <td>Jaminan / Cara Bayar</td>
                  <td>No. Peserta</td>
                  <td>Nomor SEP</td>
                  <td>COB</td>
                </tr>
                <tr>
                  <td><!-- lihat di EKLAIM>>SETUP>>JAMINAN -->
                    <select name="payor" id="payor">
                      <option value="3">JKN</option>
                      <option value="5">JAMKESDA</option>
                      <option value="1">PASIEN BAYAR</option>
                    </select>
                  </td>
                  <td id="lblNoBpjsVal" width="150px">-</td>
                  <td id="lblNosepVal" width="200px">-</td>
                  <td id="lblCobVal" width="200px">-</td>
                </tr>
              </table>
            </div>


            <div>
              <table name="tblUpdateKlaim" border=1>
                <tr>
                  <td>Jenis Rawat</td>
                  <td>
                    <input type="radio" name="rdJenisRawat" value="2" />
                    <label for="rdKelasRawat-l">Jalan</label>
                    <input type="radio" name="rdJenisRawat" value="1" />
                    <label for="rdKelasRawat-2">Inap</label>
                  </td>
                  <td>Kelas Rawat</td>
                  <td>
                    Regular
                    <!--  
                    <input type="radio" name="rdKelasRawat" value="1" />
                    <label for="rdKelasRawat-l">Regular</label>
                    <input type="radio" name="rdKelasRawat" value="2" />
                    <label for="rdKelasRawat-2">Eksekutif</label>
                    -->
                  </td>
                </tr>
                <tr>
                  <td>Tanggal Rawat</td>
                  <td>
                    Masuk :	<span id="tgl_masuk" style="display:inline-block;width:35%;"> - </span>
                    Pulang : <span id="tgl_pulang" style="display:inline-block;width:35%;"> - </span>
                  </td>
                  <td>Umur</td>
                  <td id="umur">-</td>
                </tr>
                <tr>
                  <td>LOS(hari)</td>
                  <td>-</td>
                  <td>Berat Lahir(gram)</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>ADL Score</td>
                  <td>
                    <span>Sub Acute : </span>
                    <span id="adl_sub_acute" style="display:inline-block;width:30%;"> - </span>
                    <span>Chronic : </span>
                    <span id="adl_chronic" style="display:inline-block;width:30%;"> - </span>
                  </td>
                  <td>Cara Pulang</td>
                  <td>
                    <select name="discharge_status" id="discharge_status">
                      <option value="1">Atas Persetujuan Dokter</option>
                      <option value="2">Dirujuk</option>
                      <option value="3">Atas Permintaan Sendiri</option>
                      <option value="4">Meninggal</option>
                      <option value="5">Lain-lain</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>DPJP</td>
                  <td>
                    <!--<input type="text" name="nama_dokter" />
                    <select name="nama_dokter" id="nama_dokter"></select> <!!- ASLI ->
                    <br>-->

                    <input type="text" name="inputCariDokter" style="width: 80px;" />
                    <select name="nama_dokter" id="nama_dokter" style="width: 150px;"></select>
                  </td>
                  <td>Jenis Tarif</td>
                  <td>TARIF RS KELAS C SWASTA</td>
                  <!-- kode_tarif : CS; -->
                </tr>
              </table>
            </div>

            
            <hr>
            <div class="row">
              
              <div class="col-md-5">
                <div class="bold" style="text-align: center;">Data Form dari Billing</div>
                <table name="tblViewBilling" border=1 style="margin:0px auto;">
                  <tr>
                    <td>No. RM</td>
                    <td width="300px"><span name="pasienRscm_norm">-</span></td>
                  </tr>
                  <tr>
                    <td>Nama Lengkap Pasien</td>
                    <td><span name="pasienRscm_nama">-</span></td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td><span name="pasienRscm_jk">-</span></td>
                  </tr>
                  <tr>
                    <td>Tanggal Lahir</td>
                    <td><span name="pasienRscm_tglLahir">-</span></td>
                    <!--<td><input type="text" name="tgl_lahir" id="tgl_lahir" class="datepicker" value="<= date("d M Y")?>" /></td>-->
                  </tr>
                </table>

              </div>
              

              <div class="col-md-3">
                <div>Triage : 
                  <select name="triage" id="">
                    <option value=""> - pilih triage - </option>
                    <option value="1" style="color: green;">TIDAK GAWAT TIDAK DARURAT</option>
                    <option value="3" style="color: red;">GAWAT DARURAT</option>
                    <option value="4" style="color: #aaaf00;">DARURAT TIDAK GAWAT</option>
                    <option value="5">MENINGGAL</option>
                  </select>
                </div>

                <br>
                <div>Kasus : 
                  <select name="kasus" id="">
                    <option value=""> - pilih kasus - </option>
                    <option value="1">Bedah - Trauma</option>
                    <option value="2">Bedah - Non Trauma</option>
                    <option value="3">Non Bedah - Interna</option>
                    <option value="4">Non Bedah - Pediatri</option>
                    <option value="5">Non Bedah - Obsgyn</option>
                    <option value="6">Non Bedah - Neurologi</option>
                  </select>
                </div>
                <div>
                  <!-- <button class="btn btn-primary" id="updateTriage">updateTriage</button> -->
                </div>
              </div>


              <div class="col-md-4">
                <h5 class="bold" style="text-align: center;">Form Pelengkap untuk RSCM</h5>
                <div  id="divDataKlaimRscm">
                  
                  <textarea name="anamnesa" id="" cols="30" rows="2" placeholder="Ringkasan Riwayat Penyakit" class="uppercase"></textarea>

                  <textarea name="fisik" id="" cols="30" rows="2" placeholder="Pemeriksaan Fisik" class="uppercase"></textarea>

                  <textarea name="daftarObatRscmByBill" id="" cols="30" rows="2" placeholder="Terapi/Pengobatan Selama di Rumah Sakit"></textarea>
                  
                  <!--
                  <div>
                    <table name="tblPelengkapRscm" border="1">
                      <tr>
                        <td>Kondisi Waktu Pulang</td>
                        <td>
                          <select name="" id="">
                            <option value="">Sembuh</option>
                            <option value="">Pindah RS</option>
                            <option value="">Pulang Atas Permintaan Sendiri</option>
                            <option value="">Meninggal</option>
                            <option value="">Lain-lain</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Pengobatan Dilanjutkan</td>
                        <td>
                          <select name="" id="">
                            <option value="">Poliklinik RS. Citra Medika</option>
                            <option value="">Rumah Sakit Lain</option>
                            <option value="">Puskesmas</option>
                            <option value="">Dokter Luar</option>
                            <option value="">Lain-lain</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Tanggal Kontrol</td>
                        <td><input type="text" /></td>
                      </tr>
                    </table>
                    
                  </div>
                  -->
                </div>
              </div>
              <div style="clear: left; text-align: center;">
                <button class="btn btn-primary" id="btnSepReplace">SEP &amp; NOKA Replace &amp; Pelengkap</button>
              </div>

            </div>
            

            <hr>
            <div>
              <div style="text-align: center;">
                <h5 style="font-weight: bold;">Tarif Rumah Sakit : <span name="total_tarif">Rp. - </span></h5>
              </div>
              <table name="tblUpdateKlaimTarif" border=1>
                <tr>
                  <td>Prosedur Non Bedah 
                    <input type="text" name="prosedur_non_bedah" disabled="disabled" /></td>
                  <td>Prosedur Bedah 
                    <input type="text" name="prosedur_bedah" disabled="disabled" /></td>
                  <td>Konsultasi 
                    <input type="text" name="konsultasi" disabled="disabled" /> </td>
                </tr>
                <tr>
                  <td>Tenaga Ahli 
                    <input type="text" name="tenaga_ahli" disabled="disabled" /></td>
                  <td>Keperawatan 
                    <input type="text" name="keperawatan" disabled="disabled" /></td>
                  <td>Penunjang 
                    <input type="text" name="penunjang" disabled="disabled" /></td>
                </tr>
                <tr>
                  <td>Radiologi 
                    <input type="text" name="radiologi" disabled="disabled" /></td>
                  <td>Laboratorium 
                    <input type="text" name="laboratorium" disabled="disabled" /></td>
                  <td>Pelayanan Darah 
                    <input type="text" name="pelayanan_darah" disabled="disabled" /></td>
                </tr>
                <tr>
                  <td>Rehabilitasi 
                    <input type="text" name="rehabilitasi" disabled="disabled" /></td>
                  <td>Kamar / Akomodasi 
                    <input type="text" name="kamar" disabled="disabled" /></td>
                  <td>Rawat Intensif 
                    <input type="text" name="rawat_intensif" disabled="disabled" /></td>
                </tr>
                <tr>
                  <td>Obat 
                    <input type="text" name="obat" disabled="disabled" /></td>
                  <td>Alkes 
                    <input type="text" name="alkes" disabled="disabled" /></td>
                  <td>BMHP 
                    <input type="text" name="bmhp" disabled="disabled" /></td>
                </tr>
                <tr>
                  <td>Sewa Alat 
                    <input type="text" name="sewa_alat" disabled="disabled" /></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            </div>

            <div>
              <table name="tbl_detail_bill_tindakan" style="margin: 0px auto;" class="my_table" border="1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Noreff</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>

            </div>

            <hr>
            <div class="bagian diagPanelUtama">
              <div class="diagPanel diagPanel1">
                Diagnosa (ICD-10): <input type="text" name="inputCariDiagnosa" id="inputCariDiagnosa" /> <br>

                <select name="daftarDiagnosa" id="daftarDiagnosa" style="width:300px; margin:0px auto;"></select>
                <button class="btn btn-primary" id="btnPilihDiagnosa">Pilih</button>
                
                <p>Daftar Diagnosa Terpilih :</p>
                <ol name="daftar_diagnosa_terpilih"></ol>

                <br>
                Value: <input type="text" name="valReqDiagnosa" disabled />
              </div>

              
              <div class="diagPanel diagPanel2">
                <div style="overflow-y: auto; height:200px;  overflow-x: scroll; width:100%;">
                  <p style="margin: 0px auto;">Tabel History Diagnosa :</p>
                  <table name="tbl_historyDiagnosa" border=1 >
                    <tr>
                      <th>NoBill</th>
                      <th>Lokasi</th>
                      <th>ICD</th>
                      <th>ICD2</th>
                      <th>ICD3</th>
                      <th>ICD4</th>
                      <th>ICD5</th>
                      <th>Tanggal</th>
                    </tr>
                  </table>
                </div>
                
              </div>
              <div style="clear:left;"></div>

            </div>

            <hr>
            <div class="bagian">
              Prosedur (ICD-9-CM): 
              <input type="text" name="inputCariProsedur" id="inputCariProsedur"  /><br>
              <!-- 
              <button class="btn btn-primary" id="btnCariProsedur">Cari</button>  -->

              <select name="daftarProsedur" id="daftarProsedur" style="width:350px; margin-left:50px;"></select>
              <button class="btn btn-primary" id="btnPilihProsedur">Pilih</button>

              <p>Daftar Prosedur Terpilih :</p>
              <ol name="daftar_prosedur_terpilih"></ol>
              
              <br>
              Value: <input type="text" name="valReqProsedur" width="70" disabled />

            </div>
            

            <hr>
            <div class="bagian divBtnFinalGroup">
              Coder : <span name="coder" data-codernik="<?=$detail['rscmklaim']['coder_nik'];?>"><?=$_SESSION['username']?></span>
              <br><br>
              <button id="icd_input" class="btn btn-success">ICD Input</button>
              <!-- 
              <button id="btnSetKlaim" class="btn btn-success">Set Claim</button>  -->
              <button id="btnGrouping" class="btn btn-success">Grouping</button>
              <button id="btnFinalKlaim" class="btn btn-success">Final</button>
              <a id="btnDetailBill_pdf" href="" class="btn btn-success" target="_blank">Detail Bill PDF</a>
              <button id="btnCetakKlaim" class="btn btn-success">Cetak Klaim</button>
            </div>

            <hr>


            <div class="bagian">
              <label name="lbl_status_rm" class="btn btn-primary">Status RM : </label>
              <label name="status_rm" class="btn btn-primary" >-</label>
              <br>
              <!-- 
              <h4>Mengambil Data Detail per Klaim</h4>
              <!!-
              <label for="nosep">Nomor SEP: </label>
              <input type="text" name="nosep_get_claim_data" />  ->
              <button id="btn_get_claim_data" class="btn btn-primary">Cari Data</button><br>
              <textarea name="jsreq_get_claim_data" cols="80" rows="5"></textarea>
              -->

            </div>
            <hr>


          <?php } ?>

          </div>



      </div>
    </div>

          

  </section>
</div>