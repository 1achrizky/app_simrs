   <!-- Styles -->
    <style>
    select{ height:24px; }

    .lowercase{
      text-transform: lowercase;
    }

    .uppercase{
      text-transform: uppercase;
    }

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

    .in_icd_ket, .in_tindakan_ket{
      width:250px;
    }

    .sel_icd, .sel_tindakan{
      width:250px;
    }

    
    


    /* TABLE ECLAIM */
    .tblUpdateKlaimTarif tr td{
      text-align: right;
      /*padding:0 15px;*/
    }

    .tblUpdateKlaimTarif tr td:nth-child(1),
    .tblUpdateKlaimTarif tr td:nth-child(2),
    .tblUpdateKlaimTarif tr td:nth-child(3){
      width: 33%;
    }

    .tbl_icheck_me{
      position:static;
      margin-right:50px;
    }

    .tblUpdateKlaimTarif tr td input
    /* .iCheck-helper */
    {
      width:100px;
      text-align: right;
      margin-right:50px;
      
    }

    hr{
      background-color: #fff;
      border-top: 2px dashed #8c8b8b;
      /*height:3px;*/
    }
    </style>

    <style>
    .ui-autocomplete {
      max-height: 100px;
      overflow-y: auto;
      /* prevent horizontal scrollbar */
      overflow-x: hidden;
    }
    /* IE 6 doesn't support max-height
    * we use height instead, but this forces the menu to always be this tall
    */
    * html .ui-autocomplete {
      height: 100px;
    }

    .menu_rj{
      display:none;
    }
    </style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- <section class="content-header" style="height:70px;"><h3>Pantauan Biaya Rawat Inap</h3></section> -->
    <?php 
      if($detail['rscmklaim']!=null){
        echo '<input type="hidden" id="coder_nik" value="'.$detail['rscmklaim']['coder_nik'].'" />';
      }

      // echo "<pre>",print_r($user),"</pre>";
      // print_r($detail);
      
      $level_block = [27, ];
      $show = (in_array($user['level'], $level_block))? false: true;
    ?>
    <!-- <..?=$detail['rscmklaim']['coder_nik'];?> -->

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt; font-weight: bold;">PANTAUAN BIAYA RAWAT JALAN/RAWAT INAP</h3>
            </div>

            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <td>PELAYANAN</td>
                  <td>                    
                    <input type="text" style="width:100px;" id="jnsPelayanan" disabled="disabled">
                    <!-- <select id="pelayanan">
                      <option value="RI">RAWAT INAP</option>
                      <option value="RJ">RAWAT JALAN</option>
                    </select> -->
                  </td>
                </tr>
                <tr>
                  <td style="width:100px;">NO. BILLING</td>
                  <td style="width:300px;"> 
                    <input type="text" name="nobill" class="uppercase"  style="width:100px;" />
                    &nbsp;&nbsp;&nbsp; (STATUS RM: <span id="status_rm"></span>)
                  </td>
                  <td style="width:100px;">NAMA</td>
                  <td style="width:300px;"> <span name="nama"></span></td>
                </tr>
                <tr>
                  <td>NO. RM / UMUR / NOKA</td>
                  <td> <span name="norm"></span> / <span id="umur"></span> / <span id="barcode"></span>
                    <!-- (STATUS: <span name="norm_status"></span>) -->
                    <span class="bayi" style="display:none;">
                      <span>&ensp;&ensp;&ensp;</span>
                      <span>BERAT LAHIR </span>
                      <input type="text" id="birth_weight" placeholder="GRAM..." style="width:50px;" value="0" />
                    
                    </span>
                      
                  </td>
                  <td colspan="2">
                    <span>TGL. MRS : </span>
                    <input type="text" style="width:100px;" name="tgl_mrs" disabled="disabled">
                    <!-- <span name="tgl_mrs" style="width:150px;">-</span> -->
                    
                    <span>&ensp;&ensp;&ensp;</span>
                    <span>TGL. KRS : </span>
                    <input type="text" style="width:100px;" name="tgl_krs" class="datepicker_krs" autocomplete="off" data-inputmask="'mask': '9999-99-99'" data-mask=""> 
                    
                    <span>&ensp;&ensp;&ensp;</span>
                    <span>LOS :</span>
                    <span id="los">-</span>
                    <!-- <input type="text" style="width:50px;" name="los">  -->
                  </td>
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
                    <select id="discharge_status">
                      <option value=""></option>
                      <!-- <option value="1">Atas Persetujuan Dokter</option>
                      <option value="2">Dirujuk</option>
                      <option value="3">Atas Permintaan Sendiri</option>
                      <option value="4">Meninggal</option>
                      <option value="5">Lain-lain</option> -->
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>NO. SEP</td>
                  <td> <input type="text" name="nosep" class="uppercase" style="width:150px;" />
                    <span>(HAK KELAS: <span name="brj_hakKelas"></span>)</span>
                  </td>
                  <td>DPJP</td>
                  <td>
                    <!-- <select name="sel_dpjp" class="select2" style="width:150px;">
                      <option value=""></option>
                    </select> -->
                    <div class="ui-widget">
                      <input type="text" id="sel_dpjp_auto">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>STATUS KELAS <br>
                    <input type="checkbox" id="icu_indicator"> Intensif
                  </td>
                  <td> 
                    <!-- <select name="status_kelas" class="select2"> -->
                    <select name="status_kelas">
                      <option value=""></option>
                      <option value="NAIK KELAS">NAIK KELAS</option>
                      <option value="TURUN KELAS">TURUN KELAS</option>
                    </select>
                    <!-- <select name="kelas" class="select2"> -->
                    <select name="kelas">
                      <option value="" data-bpjs=""></option>
                      <option value="1" data-bpjs="kelas_1">1</option>
                      <option value="2" data-bpjs="kelas_2">2</option>
                      <option value="3" data-bpjs="kelas_3">3</option>
                      <option value="VIP" data-bpjs="vip">VIP</option>
                      <option value="VVIP" data-bpjs="vvip">VVIP</option>
                    </select>
                    <input type="text" id="upgrade_class_los" placeholder="HARI..." style="width:50px; display:none;" title="Upgrade Class LOS"/>
                    
                  </td>
                  <td class="menu_ri">DIAG TERPILIH</td>
                  <td class="menu_ri"> 
                    <input type="text" name="in_dx_terpilih" style="width:50px;" />
                    <!-- <button name="btn_upd_dx_terpilih" class="btn btn-warning" style="margin-right:10px;">UPDATE DIAGNOSA</button> -->

                  </td>
                </tr>


                <tr class="rawat_intensif" style="display:none;">
                  <td>RAWAT INTENSIF</td>
                  <td>: <input type="text" id="icu_los" style="width:50px;" > HARI</td>
                  <td>VENTILATOR</td>
                  <td>: <input type="text" id="ventilator_hour" style="width:50px;" > JAM</td>
                </tr>
                
                <tr class="menu_igd" style="display:none;">
                  <td>TRIAGE</td>
                  <td>
                      <select name="triage" id="">
                        <option value=""> - pilih triage - </option>
                        <option value="1" style="color: green;">TIDAK GAWAT TIDAK DARURAT</option>
                        <option value="3" style="color: red;">GAWAT DARURAT</option>
                        <option value="4" style="color: #aaaf00;">DARURAT TIDAK GAWAT</option>
                        <option value="5">MENINGGAL</option>
                      </select>
                  </td>
                  <td>KASUS</td>
                  <td><select name="kasus" id="">
                        <option value=""> - pilih kasus - </option>
                        <option value="1">Bedah - Trauma</option>
                        <option value="2">Bedah - Non Trauma</option>
                        <option value="3">Non Bedah - Interna</option>
                        <option value="4">Non Bedah - Pediatri</option>
                        <option value="5">Non Bedah - Obsgyn</option>
                        <option value="6">Non Bedah - Neurologi</option>
                      </select></td>
                </tr>

                <tr>
                  <td colspan="2">
                    <button name="btn_insert_daftarritarif" class="btn btn-success btn-xs menu_ri" style="margin-right:10px;">MASUKKAN PASIEN</button>
                    <button name="btn_update_daftarritarif" class="btn btn-warning btn-xs menu_ri" style="margin-right:10px;">EDIT PASIEN</button>                                       
                  </td>
                  
                  <td colspan="2">
                    <?php if($show){?>
                        <button name="btn_hapus_daftarritarif" class="btn btn-danger btn-xs" style="margin-right:10px;">HAPUS PASIEN</button>
                        <button id="btn_hapus_klaim_ina" class="btn btn-danger btn-xs" style="margin-right:10px;">HAPUS KLAIM INACBG</button>
                        <button id="btn_buat_klaim_ina" class="btn btn-warning btn-xs" style="margin-right:10px;">BUAT KLAIM INACBG</button>
                    <?php } ?>
                  </td>
                </tr>
              </table>
              <br>
              
              

              <table class="table table-bordered"  style="display:none;">
                <tr>
                  <td>CLINICAL PATHWAY</td>
                  <td>INFORMASI</td>
                </tr>
                <tr>
                  <td>
                    <ol>
                      <li></li>
                      <li></li>
                      <li></li>
                      <li></li>
                      <li></li>
                    </ol>
                  </td>
                  <td> </td>
                </tr>
              </table>
              


              <hr>

              <table class="table table-bordered">
                <tr>                  
                  <td style="text-align:center;">
                    <div>Ringkasan Riwayat Penyakit</div>
                    <textarea name="anamnesa" id="" cols="30" rows="4" placeholder="" class="uppercase"></textarea>
                  </td>
                  <td style="text-align:center;">
                    <div>Pemeriksaan Fisik</div>
                    <textarea name="fisik" id="" cols="30" rows="4" placeholder="" class="uppercase"></textarea>
                  </td>
                  <td style="text-align:center;">
                    <div>Terapi/Pengobatan Selama di Rumah Sakit</div>
                    <textarea name="daftarObatRscmByBill" id="" cols="30" rows="4" placeholder=""></textarea>
                  </td>
                </tr>
              </table>

              <!-- <div class="row">
                <div style="clear: left; text-align: center;">
                  <button class="btn btn-success" id="btn_simpan_form_pelengkap">SIMPAN</button>
                </div>
              </div> -->
              
              <hr>
                
                <div class="row">
                  <div class="col-md-6" style="">
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
                  </div>

                  <div class="col-md-6" style="">
                      <div>Tabel History Diagnosa</div>
                      <div style="overflow-y: auto; height:200px;  overflow-x: scroll; width:100%;">

                        <style>
                          table[name=tbl_historyDiagnosa] tr,.my_table tr{
                            height : 25px;
                          }

                          table[name=tbl_historyDiagnosa] tr th, .my_table tr th{
                            background-color: yellow;
                            padding: 0px 10px;
                          }
                          
                          table[name=tbl_historyDiagnosa] tr th:nth-child(2),
                          table[name=tbl_historyDiagnosa] tr td:nth-child(2){
                            width:180px;
                          }
                        </style>
                        <table name="tbl_historyDiagnosa" border=1 >
                          <tr>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>ICD</th>
                            <th>ICD2</th>
                            <th>ICD3</th>
                            <th>ICD4</th>
                            <th>ICD5</th>
                          </tr>
                        </table>
                      </div>

                  </div>
                  
                </div>
                

              <hr>


              <span>HISTORI DIAGNOSA: </span>
              <span name="arr_histori_diag">
                <!-- <a href="" class="label label-info">1</a>
                <a href="" class="label label-info">2</a> -->
              </span>
              <table class="table table-bordered table-striped">
                <tr>
                  <td style="width:100px;">ID HISTORI: <span name="id_historidiag">-</span></td>
                  <td style="width:300px; text-align: center;">KETERANGAN</td>
                  <td style="width:300px; text-align: center;">ICD</td>
                </tr>
                <tr class="menu_ri">
                  <td>DIAGNOSA AWAL</td>
                  <td> &nbsp;<input type="text" name="diag_awal" class="in_icd_ket" /></td>
                  <td>
                    <div class="form-inline"> &nbsp;
                      <input type="text" name="in_diag_awal" class="in_icd uppercase" style="width:80px;">
                      <select name="sel_diag_awal" class="sel_icd"></select>
                    </div>                      
                  </td>
                </tr>
                <tr>
                  <td>DIAGNOSA UTAMA</td>
                  <td> &nbsp;<input type="text" name="diag_utama" class="in_icd_ket" /></td>
                  <td>
                    <div class="form-inline">  &nbsp;
                      <input type="text" name="in_diag_utama" class="in_icd uppercase" style="width:80px;">
                      <select name="sel_diag_utama" class="sel_icd"></select>
                    </div>  
                  </td>
                </tr>
                <tr>
                  <td>DIAGNOSA SEK</td>
                  <td>
                    <ol style="padding-left: 5px;">
                      <li><input type="text" name="diag_sek1" class="in_icd_ket" /></li>
                      <li><input type="text" name="diag_sek2" class="in_icd_ket" /></li>
                      <li><input type="text" name="diag_sek3" class="in_icd_ket" /></li>
                      <li><input type="text" name="diag_sek4" class="in_icd_ket" /></li>
                      <li><input type="text" name="diag_sek5" class="in_icd_ket" /></li>
                    </ol>
                  </td>
                  <td>
                    <ol style="padding-left: 5px;">
                      <?php for ($i=1; $i <=5; $i++) { 
                        echo '
                        <li>
                          <div class="form-inline">
                            <input type="text" name="in_diag_sek'.$i.'" class="in_icd uppercase" style="width:80px;">
                            <select name="sel_diag_sek'.$i.'" class="sel_icd"></select>
                          </div>
                        </li>
                        ';
                      }; ?>
                      
                    </ol>
                  </td>
                </tr>
                <tr>
                  <td>TINDAKAN<br>
                  <?php if($show){?>
                    <button class="btn btn-warning" id="btn_update_dx_proc_cbg">UPDATE</button>
                  <?php } ?>
                  </td>
                  <td>
                    <ol style="padding-left: 5px;">
                      <li><input type="text" name="tindakan1" class="in_tindakan_ket" /></li>
                      <li><input type="text" name="tindakan2" class="in_tindakan_ket" /></li>
                      <li><input type="text" name="tindakan3" class="in_tindakan_ket" /></li>
                      <li><input type="text" name="tindakan4" class="in_tindakan_ket" /></li>
                    </ol>
                  </td>
                  <td>
                    <ol style="padding-left: 5px;">
                      <?php
                      for ($i=1; $i <=4; $i++) { 
                        echo '
                        <li>
                          <div class="form-inline">
                            <input type="text" name="in_tindakan'.$i.'" class="in_tindakan uppercase" style="width:80px;">
                            <select name="sel_tindakan'.$i.'" class="sel_tindakan"></select>
                             x <input type="number" name="x_tx'.$i.'" class="" style="width:50px;">
                          </div>
                        </li>
                        ';
                      } ?>
                      
                    </ol>
                  </td>
                </tr>
                <tr>
                  <td>TARIF INACBG</td>
                  <td>
                    <input type="text" name="tarif_inacbg" disabled="disabled"/>
                    <?php if($show){?>
                      <button id="btn_grouping" class="btn btn-warning" style="margin-right:10px;">GROUPING</button>
                      <!-- <button name="btn_final_daftarritarif" class="btn btn-info" style="margin-right:10px;">FINAL</button> -->
                      <!-- <button id="btn_final" class="btn btn-info" style="margin-right:10px;">FINAL</button> -->
                      <button id="btn_final_new" class="btn btn-info" style="margin-right:10px;">FINAL</button>
                      <button id="btn_editulangklaim" class="btn btn-danger" style="margin-right:10px;">EDIT KLAIM</button>
                    <?php } ?>
                  </td>
                  <td></td>
                </tr>
                

                <?php if($show){?>
                <tr>
                  <td colspan=4>
                    <div style="text-align: center;">
                      <h4 style="font-weight: bold;">HASIL GROUPER</h4>
                    </div>
                    <!-- <table class="table table-bordered"> -->

                    <style>
                      #tbl_hasil_grouper tr td{
                        height:30px;
                        /* padding-left:10px; */
                        padding:0 10px;
                      }
                      #tbl_hasil_grouper tr td select{
                        /* margin:5px 10px; */
                        /* margin:5px 0; */
                      }
                      #tbl_hasil_grouper tr td:nth-child(1){
                        width:25%;
                        
                      }
                      #tbl_hasil_grouper tr td:nth-child(2){
                        width:35%;
                      }
                      #tbl_hasil_grouper tr td:nth-child(3){
                        width:20%;
                        text-align:center;
                      }
                      #tbl_hasil_grouper tr td:nth-child(4){
                        width:20%; text-align:right; 
                        /* padding-right:10px; */
                      }

                      .trTambahanBiaya{
                        display:none;
                      }

                      .bold{
                        font-weight:bold;
                      }
                    </style>

                    <table id="tbl_hasil_grouper" border=1 style="width:100%;">
                      <tr>
                        <td>GROUP</td>
                        <td id="GroupKet"></td>
                        <td id="GroupCode">-</td>
                        <td id="GroupTarif">0</td>
                      </tr>
                      <tr>
                        <td>SPECIAL PROCEDURE</td>
                        <td> 
                          <select id="SpecialProc" class="selCmgOpt">
                            <option value="">-</option>
                          </select>
                        </td>
                        <td id="SpecialProcCode">-</td>
                        <td id="SpecialProcTarif">0</td>
                      </tr>
                      <tr>
                        <td>SPECIAL PROSTHESIS</td>
                        <td> 
                          <select id="SpecialPros" class="selCmgOpt">
                            <option value="">-</option>
                          </select>
                        </td>
                        <td id="SpecialProsCode">-</td>
                        <td id="SpecialProsTarif">0</td>
                      </tr>
                      <tr>
                        <td>SPECIAL INVESTIGATION</td>
                        <td> 
                          <select id="SpecialInv" class="selCmgOpt">
                            <option value="">-</option>
                          </select>
                        </td>
                        <td id="SpecialInvCode">-</td>
                        <td id="SpecialInvTarif">0</td>
                      </tr>
                      <tr>
                        <td>SPECIAL DRUG</td>
                        <td> 
                          <select id="SpecialDrug" class="selCmgOpt">
                            <option value="">-</option>
                          </select>
                        </td>
                        <td id="SpecialDrugCode">-</td>
                        <td id="SpecialDrugTarif">0</td>
                      </tr>
                      <tr>
                        <td>                          
                          <!-- <button id="btn_grouping2" class="btn btn-warning" style="margin-right:10px;">GROUPING STAGE 2</button> -->
                        </td>
                        <td></td>
                        <td class="bold">TOTAL</td>
                        <td id="totTarifGrouper" class="bold">0</td>
                      </tr>
                      <tr class="trTambahanBiaya">
                        <td colspan="4" class="bold">Tambahan Biaya Yang Dibayar Pasien Untuk 
                          <span id="naikTurunTambahanBiaya"></span>
                          <span id="kelasTambahanBiaya"></span>
                        </td>
                      </tr>
                      <tr class="trTambahanBiaya">
                        <td>TAMBAHAN BIAYA</td>
                        <td id="ketTambahanBiaya"></td>
                        <td></td>
                        <td id="totTambahanBiaya" class="bold">0</td>
                      </tr>
                    </table>


                    <div style="text-align: center;">
                      <h4 style="font-weight: bold;">HASIL GROUPER E-Klaim v6</h4>
                    </div>

                    <table id="tbl_hasil_grouper" border=1 style="width:100%;">
                      <tr>
                        <td>MDC</td>
                        <td id="mdc" colspan=3></td>
                      </tr>
                      <tr>
                        <td>DRG</td>
                        <td id="drg" colspan=3></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <?php } ?>

                <tr>
                  <td>TARIF RS</td>
                  <td class="tarif_rs">{tarif_rs = mengikuti total billing}</td>
                  <td>(STATUS TARIF: <span name="status_tarif">-</span>) </td>
                </tr>
                <!-- <tr class="menu_ri"> -->
                <tr class="">
                  <td>Verifikator </td>
                  <td colspan="2"> 
                    <input type="text" name="in_verifikator" style="width:80px; text-align:center; margin-right:10px;">
                    <button name="btn_insert_historidiag" class="btn btn-success" style="margin-right:10px;">
                      <i class="fa fa-plus"></i> HISTORI
                    </button>
                    <!-- <button name="btn_update_historidiag" class="btn btn-warning" style="margin-right:10px;">EDIT</button> -->

                  </td>
                </tr>
              </table>
              
              <hr>
              <div>
                <div style="text-align: center;">
                  <h4 style="font-weight: bold;">KLASIFIKASI TARIF RS DENGAN INACBG</h4>
                </div>
                <div style="text-align: center;">
                  <h4 style="font-weight: bold;">TARIF RUMAH SAKIT : <span name="total_tarif">Rp. - </span></h4>
                </div>


                <table name="tblUpdateKlaimTarif" border=1 class="table table-bordered table-striped tblUpdateKlaimTarif">
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
                
                
                <div style="text-align:center; font-style:italic;" class="tblKemkes">Faktor pengurang, pilih checkbox pemeriksaan penunjang berikut yang tidak dilakukan:</div>
                <table border=1 class="table table-bordered table-striped tblUpdateKlaimTarif tbl_icheck_me tblKemkes">
                  <tr>
                    <td id="tes_cbox">Asam Laktat
                      <input type="checkbox" name="lab_asam_laktat" class="cbox_cov" value="0" />
                    </td>
                    <td>Procalcitonin 
                      <input type="checkbox" name="lab_procalcitonin" class="cbox_cov" value="0" /></td>
                    <td>CRP 
                      <input type="checkbox" name="lab_crp" class="cbox_cov" value="0" /> </td>
                  </tr>
                  <tr>
                    <td>Kultur MO (aerob) dengan resistansi 
                      <input type="checkbox" name="lab_kultur" class="cbox_cov" value="0" /></td>
                    <td>D Dimer 
                      <input type="checkbox" name="lab_d_dimer" class="cbox_cov" value="0" /></td>
                    <td>PT 
                      <input type="checkbox" name="lab_pt" class="cbox_cov" value="0" /></td>
                  </tr>
                  <tr>
                    <td>APTT 
                      <input type="checkbox" name="lab_aptt" class="cbox_cov" value="0" /></td>
                    <td>Waktu Pendarahan 
                      <input type="checkbox" name="lab_waktu_pendarahan" class="cbox_cov" value="0" /></td>
                    <td>Anti HIV 
                      <input type="checkbox" name="lab_anti_hiv" class="cbox_cov" value="0" /></td>
                  </tr>
                  <tr>
                    <td>Analisa Gas 
                      <input type="checkbox" name="lab_analisa_gas" class="cbox_cov" value="0" /></td>
                    <td>Albumin 
                      <input type="checkbox" name="lab_albumin" class="cbox_cov" value="0" /></td>
                    <td>Thorax AP / PA 
                      <input type="checkbox" name="rad_thorax_ap_pa" class="cbox_cov" value="0" /></td>
                  </tr>
                  
                </table>

                <br>
                <div style="text-align: center;" class="tblKemkes">
                  <h4 style="font-weight: bold;">Unggah Berkas Pendukung Klaim</h4>
                </div>

                  <!-- <p id="f1_upload_process">Loading...<br/><img src="loader.gif" /></p>
                  <p id="result"></p> -->



                  <form id="frmBerkas" action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
                    <table class="table tblKemkes">
                      <tr>
                        <td>Resume Medis</td>
                        <!-- <td><input name="myfile" type="file" /></td> -->
                        <td><input name="f_resumse_medis" type="file" /></td>
                      </tr>
                      <tr>
                        <td>
                          <div id="div_resume_medis">
                            <!-- <object name="resume_medis" data="test.pdf" type="application/pdf" width="300" height="200">
                            alt : <a href="test.pdf">test.pdf</a>
                            </object> -->
                          </div>

                          <!-- <iframe name="ifr" src="" style="width: 600px; height: 400px;" ></iframe> -->
                        </td>
                      </tr>
                      <tr>
                        <td>Ruang Perawatan</td>
                        <td><input name="f_ruang_rawat" type="file" /></td>
                      </tr>
                      <tr>
                        <td>Hasil Laboratorium</td>
                        <td><input name="f_laboratorium" type="file" /></td>
                      </tr>
                      <tr>
                        <td>Hasil Radiologi</td>
                        <td><input name="f_radiologi" type="file" /></td>
                      </tr>
                      <tr>
                        <td>Penunjang Lain</td>
                        <td><input name="f_penunjang_lain" type="file" /></td>
                      </tr>
                      <tr>
                        <td>Resep Obat</td>
                        <td><input name="f_resep_obat" type="file" /></td>
                      </tr>
                      <tr>
                        <td>Tagihan</td>
                        <td><input name="f_tagihan" type="file" /></td>
                      </tr>
                      <tr>
                        <td>Kartu Identitas</td>
                        <td><input name="f_kartu_identitas" type="file" /></td>
                      </tr>
                      <tr>
                        <td>Lain-lain</td>
                        <td><input name="f_lain_lain" type="file" /></td>
                      </tr>
                    </table>
                
                      <!-- <input type="submit" name="submitBtn" value="Upload" /> -->
                  </form>
                  
                  <!-- <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>                  -->
                  
              </div>


              <hr>
              <table class="table table-bordered table-striped" name="tbl_pantauan_biaya_ri">
                <thead>
                  <tr>
                    <th colspan="5" style="text-align: center;"><h4 style="font-weight: bold;">PANTAUAN TARIF</h4></th>
                  </tr>                  
                </thead>
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>TANGGAL</th>
                    <th>NO. BUKTI</th>
                    <th>KETERANGAN</th>
                    <th>TARIF</th>
                  </tr>                  
                </thead>
                <tbody></tbody>
                <tfoot>
                  <tr>
                    <th colspan="4">TOTAL BIAYA RUMAH SAKIT</th>
                    <th class="tarif_rs" style="text-align: right;">{nilai}</th>
                  </tr>
                  <tr>
                    <th colspan="4">GRAND TOTAL</th>
                    <th class="grandTotalRs" style="text-align: right;">{nilai}</th>
                  </tr>
                  <tr>
                    <th colspan="4">TARIF INACBG</th>
                    <th style="text-align: right;">{nilai}</th>
                  </tr>
                </tfoot>
              </table>

              <?php if($show){?>
              <!-- <button id="btn_insert_daftarrj" class="btn btn-success menu_rj" style="margin-right:10px;">SIMPAN RAWAT JALAN</button> -->
              <a id="btnDetailBill_pdf" href="" class="btn btn-success menu_rj" target="_blank" title="Download Detail Billing PDF">
                <i class="fa fa-file-pdf-o"></i> Detail Billing</a>
              <button class="btn btn-success menu_ri" name="btn_dl_pdf_rekering_ri" title="Download Rekening">
                <i class="fa fa-file-pdf-o"></i> Rekening
              </button>
              &nbsp;
              <button class="btn btn-info" id="btn_dl_pdf_inacbg" title="Download INACBG">
                <i class="fa fa-file-pdf-o"></i> INACBG
              </button>

              <?php } ?>
              <!-- <button class="btn btn-success" name="btn_dl_pdf_detail_ri" title="Download Rekening">
                <i class="fa fa-file-pdf-o"></i> Download Detail
              </button> -->
            </div>

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