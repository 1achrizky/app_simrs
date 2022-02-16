<style>

.hidden{
  display: none;
}

table[name=tbl_data2_rs_ri] tr td:nth-child(1),
table[name=tbl_data2_rs_ri] tr td:nth-child(3),
table[name=tbl_data_rs_ri] tr td:nth-child(1),
table[name=tbl_data_rs_ri] tr td:nth-child(3),
.my_tbl tr td:nth-child(1),
.my_tbl tr td:nth-child(3){
  text-align:right;
}

table[name=tbl_data2_rs_ri] tr td,
table[name=tbl_data_rs_ri] tr td,
.my_tbl tr td{
  padding: 0px 5px 3px;
}

h4{
  font-weight:bold;
}
textarea[name=Keterangan]{
  vertical-align:top;
}
.border-thin{
  border: 1px solid lightgrey;
}

div[name=foto], div[name=sidikjari]{
  display:inline-block;
  width:100px;
  height:120px;
  margin: 5px 10px 0;
}




    /* ================= [LOAD: MODAL>>KLINIK] ====================== */
    .container_poli{
    margin: 0px auto 0px;
    width:100%;
    padding:0px;
    //border:solid 1px black;
    overflow: auto;
    //text-align: center;

    display:grid;
    //grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
    grid-template-columns:repeat(auto-fill,minmax(130px,1fr));
    justify-items: center;
    grid-gap: 5px;
    grid-row-gap: 0px;

  }
  .obyek{
    //height:150px;
    //overflow: auto;
    width:130px;
    ///width:100%;
    background:yellow;
    float: left;
    margin:5px;
    //border:solid 1px black;
    border-radius: 5px;

    -webkit-box-shadow: 0 4px 6px rgba(0, 0, 0, .3);
    -moz-box-shadow: 0 4px 6px rgba(0,0,0,.3);
    box-shadow: 0 4px 6px rgba(0,0,0,.3);
    -webkit-transition: all .15s linear;
    -moz-transition: all .15s linear;
    //transition: all .15s linear;
    z-index:0;

  }
  .obyek:hover{
    background: lightblue;
  }

  .obyek img{
    display: block;
    height: 100px;
    margin:10px auto 5px;
  }

  .obyek_title{
    height: 60px;
    /*margin:0px auto 0;*/
    margin:0px;
    color: #191919;
    font-weight: bold;
    font-size: 10pt;
  }
  .obyek_title span{
    display: inline-block;
    vertical-align: middle;
    text-align: center;
    color:#047BB9;
    width:100%;

    position: relative;
      top: 50%;
      transform: translateY(-50%);
  }
  
  .polaroid-images a:after {
    color: #333;
    //font-size: 20px;
    font-size: 11pt;
    font-weight:bold;
    content: attr(title);
    position: relative;
    top:5px;
  }

  .polaroid-images img { 
    display: block; 
    //width: inherit; 
    height: 100px; 
  }
  .polaroid-images a{
    background: white;
    display: inline;
    float: left;
    margin: 0 15px 30px;
    padding: 5px 5px 15px;
    text-align: center;
    text-decoration: none;
    -webkit-box-shadow: 0 4px 6px rgba(0, 0, 0, .3);
    -moz-box-shadow: 0 4px 6px rgba(0,0,0,.3);
    box-shadow: 0 4px 6px rgba(0,0,0,.3);
    -webkit-transition: all .15s linear;
    -moz-transition: all .15s linear;
    transition: all .15s linear;
    z-index:0;
      position:relative;

  }
  
/*
  .modal-lg{
    width:1000px;
    margin:auto;
  }
*/

    /* =================\[LOAD: MODAL>>KLINIK] ====================== */
</style>

<style>
    /* .ui-autocomplete {
      max-height: 100px;
      overflow-y: auto;
      /\* prevent horizontal scrollbar *\/
      overflow-x: hidden;
    } 

    /\* IE 6 doesn't support max-height
    * we use height instead, but this forces the menu to always be this tall
    *\/
    * html .ui-autocomplete {
      height: 100px;
    }
    */
    .tr_bpjs{
      display:none;
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
                <h3 class="box-title" style="font-size:20pt; font-weight:bold;">PENDAFTARAN PASIEN RAWAT INAP</h3>
              </div>
              <div class="box-body">
              


                <div class="row">
                  <div class="col-md-12">
                    <div id="errors"></div>
                  </div>
                </div>

                <div class="row">                    
                  <div class="col-md-4">
                      <table name="tbl_data_rs_ri" >
                        <tr><td colspan=4 style="text-align:center;"><h4>DATA RAWAT INAP</h4></td></tr>
                        <tr>
                          <td>Penanggung</td>
                          <td>
                            <select name="sel_penanggung_cm" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                              <option value="" data-noanggota="">UMUM</option>
                            </select>
                          </td>              
                        </tr>
                        <tr>
                          <td>Prosedur Masuk</td>
                          <td>
                            <select id="pro_masuk" style="width:155px;">
                              <option value="1">LANGSUNG RAWAT INAP</option>
                              <option value="2">MELALUI UNIT DARURAT</option>
                              <option value="3">MELALUI UNIT RAWAT JALAN</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>NoRM</td>
                          <td><input type="text" id="norm_ri" autocomplete="off"></td>
                        </tr>
                        <tr>
                          <td>Cara Masuk</td>
                          <td>
                            <select name="" id="cara_masuk_ri" style="width:155px;">
                              <option value=""></option>
                              <?php
                                for ($i=0; $i < count($caramasuk); $i++)
                                  echo '<option value="'.$caramasuk[$i]['Kode'].'">'.$caramasuk[$i]['Keterangan'].'</option>';
                              ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Rujukan dari</td>
                          <td>
                            <select name="" id="rujukan_ri" style="width:155px;" class="select2">
                              <option value=""></option>
                              <?php
                                for ($i=0; $i < count($rjk_cm); $i++)
                                  echo '<option value="'.$rjk_cm[$i]['kode'].'">'.$rjk_cm[$i]['ppk'].'</option>';
                              ?>
                            </select>
                          </td>
                        </tr>
                        
                        <tr><td>Nama</td><td><input type="text" name="Nama" disabled="disabled"></td></tr>
                        <tr>
                          <td>Nomor Billing</td>
                          <td><input type="text" id="nobill_ri" disabled="disabled"></td>
                        </tr>
                        <!-- <tr>
                          <td>Nomor SPRI</td>
                          <td><input type="text" id="nobill_ri"></td>
                        </tr>
                        <tr>
                          <td>DPJP Pemberi SPRI</td>
                          <td><input type="text" id="nobill_ri"></td>
                        </tr> -->
                        <tr class="param_bpjs">
                          <td>Status Kelas</td>
                          <td>
                            <select name="status_kelas">
                              <option value=""></option>
                              <option value="NAIK KELAS">NAIK KELAS</option>
                              <option value="TURUN KELAS">TURUN KELAS</option>
                            </select>

                            <select name="kelas">
                              <option value="" data-bpjs=""></option>
                              <option value="1" data-bpjs="kelas_1">1</option>
                              <option value="2" data-bpjs="kelas_2">2</option>
                              <option value="3" data-bpjs="kelas_3">3</option>
                              <option value="VIP" data-bpjs="vip">VIP</option>
                              <option value="VVIP" data-bpjs="vvip">VVIP</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Kode Bed</td>
                          <td><input type="text" id="kdbed_ri" autocomplete="off"></td>
                        </tr>
                        <tr>
                          <td>Ruang</td>
                          <td><input type="text" id="ruangbed_ri" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>Kelas</td>
                          <td><input type="text" id="kelasbed_ri" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>Tarif Kamar</td>
                          <td><input type="text" id="tarifkamar_ri" disabled="disabled"></td>
                        </tr>
                        <tr>
                          <td>Pelayanan</td>
                          <td>
                            <div class="ui-widget">
                              <input type="text" id="pelayanan_ri">
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Diagnosa Awal</td>
                          <td><div class="ui-widget"><input type="text" id="dxawal_ri"></div></td>
                        </tr>
                        <!-- <tr>
                          <td>Nama Penanggung</td>
                          <td><input type="text" id="penanggung_nama"></td>
                        </tr>
                        <tr>
                          <td>Alamat Penanggung</td>
                          <td><input type="text" id="penanggung_alamat"></td>
                        </tr>
                        <tr>
                          <td>Telp Penanggung</td>
                          <td><input type="text" id="penanggung_telp"></td>
                        </tr> -->
                        <tr>
                          <td>Nama Keluarga</td>
                          <td><input type="text" id="keluarga_nama"></td>
                        </tr>
                        <tr>
                          <td>Alamat Keluarga</td>
                          <td><input type="text" id="keluarga_alamat"></td>
                        </tr>
                        <tr>
                          <td>Telp Keluarga</td>
                          <td><input type="text" id="keluarga_telp"></td>
                        </tr>
                        <!-- <tr>
                          <td>Operator</td>
                          <td>
                            <select id="operator_ri">
                              <option value="DALAM">DALAM</option>
                              <option value="LUAR">LUAR</option>
                            </select>
                          </td>
                        </tr> -->
                        <tr>
                          <td>Dokter Awal</td>
                          <td>
                            <div class="ui-widget">
                              <input type="text" id="dokter_awal_ri">
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Asal Instansi</td>
                          <td>
                            <div class="ui-widget">
                              <select name="" id="instansi_ri" style="width:155px;" class="select2">
                                <option value=""></option>
                                <?php
                                  for ($i=0; $i < count($instansi); $i++)
                                    echo '<option value="'.$instansi[$i]['kode'].'">'.$instansi[$i]['Keterangan'].'</option>';
                                ?>
                              </select>
                            </div>
                          </td>
                        </tr>
                        <tr><td>Keterangan Daftar</td><td><input type="text" name="ket_daftar"></td></tr>
                      </table>
                      
                  </div>


                  <div class="col-md-4">
                    <table name="tbl_data2_rs_ri" >
                      <tr><td colspan=4 style="text-align:center;"><h4>&nbsp;</h4></td></tr>
                      <tr><td>Nomor KTP</td><td><input type="text" name="NoIdentitas" autocomplete="off"></td></tr>
                      <tr><td>Telp</td>
                          <td><input type="text" name="Telp" autocomplete="off" style="width:123px;">
                              <button title="Update Telp" id="btn_update_telp"><i class="fa fa-arrow-up"></i> </button></td></tr>
                      <tr><td>Suku Bangsa</td>
                          <td>
                            <?php $sukubangsa = array(
                              "JAWA", "SUNDA","BATAK","BETAWI","TIONGHOA","MADURA","TENGGER",
                              "BANJAR","BANTEN","MELAYU","BUGIS","ARAB","BALI","SASAK","DAYAK",
                              "MAKASAR","CIREBON","MINANGKABAU","KOREA","JEPANG","INDIA","INDO"); ?>
                            <select name="pasienRscm_sukubangsa" style="width:155px;">
                              <option value="">- pilih -</option>
                              <?php 
                              foreach($sukubangsa as $suku){
                                echo '<option value="'.$suku.'">'.$suku.'</option>';
                              } ?>
                            </select>
                          </td></tr>
                      <tr><td>Agama</td>
                          <td>
                            <select name="sel_agama" style="width:155px;">
                              <option value="">- pilih -</option>
                              <?php
                                for ($i=0; $i < count($agama); $i++) { 
                                  echo '<option value="'.$agama[$i]['Kode'].'">'.$agama[$i]['Keterangan'].'</option>';
                                }
                              ?>
                            </select>
                          </td></tr>
                      <tr><td>Alamat</td><td><input type="text" name="Alamat" disabled="disabled"></td></tr>
                      <tr>
                        <td>Jenis Kelamin</td><td><input type="text" name="Sex" disabled="disabled"></td>                        
                      </tr>
                      <tr>
                        <td>Tempat Lahir</td><td><input type="text" name="TempatLahir" disabled="disabled"></td>
                      </tr>
                      <tr>
                        <td>Tanggal Lahir</td><td><input type="text" name="TglLahir" disabled="disabled"></td>
                      </tr>
                      <tr><td>Umur</td><td><input type="text" name="umur" disabled="disabled"></td></tr>
                      
                      <!--
                      <tr><td>Marital</td><td><input type="text" name="marital_ket" disabled="disabled"></td></tr>
                      <tr><td>HP</td><td><input type="text" name="HP" disabled="disabled"></td></tr>
                      <tr><td>Pendidikan</td><td><input type="text" name="pendidikan_ket" disabled="disabled"></td></tr> 
                      <tr><td>Pekerjaan</td><td><input type="text" name="pekerjaan_ket" disabled="disabled"></td></tr>
                      <tr>
                        <td>RT / RW</td>
                        <td>
                          <input type="text" name="Rt" disabled="disabled" style="width:50px;"> / 
                          <input type="text" name="Rw" disabled="disabled" style="width:50px;">
                        </td>
                      </tr>
                      <tr><td>Negara</td><td><input type="text" name="negara_ket" disabled="disabled"></td></tr>
                      <tr><td>Propinsi</td><td><input type="text" name="propinsi_ket" disabled="disabled"></td></tr>
                      <tr><td>Kota</td><td><input type="text" name="kota_ket" disabled="disabled"></td></tr>
                      <tr><td>Kecamatan</td><td><input type="text" name="kecamatan_ket"  disabled="disabled"></td></tr>
                      <tr><td>Kelurahan</td><td><input type="text" name="kelurahan_ket" disabled="disabled"></td></tr>
                      <tr><td>Golongan Darah</td><td><input type="text" name="GolDarah" disabled="disabled"></td></tr>
                      -->

                      <tr><td colspan="2"><textarea name="Keterangan" id="" cols="35" rows="4" placeholder="Keterangan..." disabled="disabled"></textarea></td></tr>
                      <tr><td colspan="2">
                              <div name="foto" class="border-thin" style="float:left;">Foto
                                <img src="" name="foto" alt="">
                              </div>
                              <div name="sidikjari" class="border-thin">Sidik Jari</div>
                            </td></tr>
                    </table>
                  </div>


                  <div class="col-md-4">
                    <table name="tbl_data_bpjs" class="my_tbl">
                      <tr><td colspan=4 style="text-align:center;"><h4 id="lbl_data_bpjs" style="cursor:pointer;" title="DoubleClick: tampil tombol SEP">DATA BPJS</h4></td></tr>
                      <tr class="tr_bpjs"><td>Nobill Parameter</td><td><input type="text" id="nobill_param" autocomplete="off"></td></tr>
                      <tr><td>Nomor KIS</td>
                          <td><input type="text" id="noka_bpjs" autocomplete="off">
                          <!-- <td><input type="text" id="noka_bpjs" autocomplete="off" style="width:123px;"> -->
                              <!-- <button title="Update Nomor KIS di Master" id="btn_update_noka"><i class="fa fa-arrow-up"></i> </button> -->
                              </td></tr>
                      <tr><td>Nomor KTP</td><td><input type="text" name="nik_bpjs" disabled="disabled"></td></tr>
                      <tr><td>Nama Peserta</td><td><input type="text" name="nama_bpjs" disabled="disabled"></td></tr>
                      <tr><td>Tanggal Lahir</td><td><input type="text" name="tgllahir_bpjs" disabled="disabled"></td></tr>
                      <tr><td>Kelas</td>
                          <td>
                            <!-- <input type="text" name="kelas_bpjs" disabled="disabled"> -->
                            <select id="kelas_bpjs">
                              <option value="">- pilih -</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                            </select>
                          </td></tr>
                      <tr><td>PPK Asal Rujukan</td><td><input type="text" name="asalPPK_bpjs" disabled="disabled"></td></tr>
                      <tr><td>Jenis Peserta</td><td><input type="text" name="jns_peserta" disabled="disabled"></td></tr>
                      <!-- <tr><td>Tanggal Rujukan</td><td><input type="text" name="get_tglRujukan" autocomplete="off"></td></tr>
                      <tr><td>Nomor Rujukan</td><td><input type="text" name="norujukan" autocomplete="off"></td></tr> -->
                      <tr class="tr_bpjs"><td>Nomor SPRI</td>
                          <td><input type="text" name="skdp" autocomplete="off"></td>
                      </tr>
                      <tr><td>DPJP Pemberi SPRI</td><td><input type="text" name="kd_dpjp_bpjs" autocomplete="off"></td></tr>
                      <tr><td>Tanggal SEP</td><td><input type="text" name="tglsep" autocomplete="off" value="<?=date('Y-m-d');?>"></td></tr>
                      <tr><td>Nomor RM</td><td><input type="text" name="norm_bpjs" autocomplete="off"></td></tr>
                      <tr><td>Diagnosa <input type="text" name="dxkey_bpjs" autocomplete="off" style="width:50px;"> </td>
                          <td>
                            <select name="dx_bpjs" style="width:155px;">
                              <option value=""></option>
                            </select>
                          </td>
                      </tr>
                      <tr><td>Diagnosa SPRI</td><td><input type="text" id="dx_casemix" autocomplete="off"></td></tr>
                      <tr><td>Nomor Telp</td><td><input type="text" name="telp_bpjs" autocomplete="off"></td></tr>
                      <tr><td>Catatan</td><td><input type="text" name="catatan_bpjs" autocomplete="off"></td></tr>
                      <tr><td>Status Kecelakaan</td><td><input type="text" name="status_laka" autocomplete="off"></td></tr>
                      <tr><td></td><td><button id="btn_buatSepRI" class="btn btn-danger" style="display:none;">BUAT SEP RI</button></td></tr>
                    </table>

                    
                  </div>
                </div>


                

              </div>


              <div class="box-footer">
                <!-- <button id="btn_daftarri" class="btn btn-success btn-rscm">Daftar RI</button> -->
                <button id="btn_daftarri_new" class="btn btn-success btn-rscm">Daftar RI</button>
              </div>

              <div class="box-footer">
                <div class="form-inline">
                    <span>SEP berhasil dibuat:</span> 
                    <input type="text" class="form-control input-sm" id="get_nosep_temp" />
                    <!-- <button class="btn btn-danger" name="btn_sep_hapus"> Hapus SEP </button> -->
                    <button class="btn btn-warning" id="btn_cetak_sep_ri"> Cetak SEP </button>

                    <span style="margin-left: 50px;">BILLING:</span>
                    <input type="text" class="form-control input-sm" id="get_bill_siap_pakai" />
                    <button class="btn btn-warning" id="btn_cetak_tracer_ri"> Cetak TRACER </button>
                </div>
              </div>

            </div>


          </div>
        
        <!-- </form> -->
      </div>
      <!-- /.row -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- ================ [ MODAL ] =================== -->
  <div id="modal_list"></div>
      			
			<div class="modal fade" id="modal_li_px" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Cari Pasien:</h4>
						</div>
						<div class="modal-body">
							
								<table class="table table-bordered" name="tbl_modal_li_px">
									<thead>
										<tr>
											<td>No.</td>
                      <td>NoRM</td>
											<td>Nama</td>
											<td>Alamat</td>
										</tr>
									</thead>
									<tbody></tbody>
								</table>						

						</div>
						<div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
					</div>
				</div>
			</div>



      <div class="modal fade" id="modal_cari_jadok" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Pilih Dokter (Sesuai Jadwal Hari Ini): </h4>
						</div>
						<div class="modal-body" id="el_modal2">

							<div class="container_cari_jadok">
								<table name="tbl_cari_jadok" class="table table-bordered">
								    <thead>
								      <tr>
								        <th>Hari</th>
								        <th>Nama Dokter</th>
								        <th>Poli Spesialis</th>
								        <th>Jam Praktek</th>
								        <th>Opsi</th>
								      </tr>
								    </thead>
								    <tbody></tbody>
							  	</table>
							</div>

						</div>
						<div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
					</div>
				</div>
			</div>



			<div class="modal fade" id="modal_klinik" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Pilih Klinik Tujuan: </h4>
						</div>
						<div class="modal-body" id="el_modal">

							<div class="container_poli"></div>

						</div>
						<div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modal_klinik_alert" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Jadwal Klinik Tujuan: </h4>
						</div>
						<div class="modal-body" id="el_modal_klinik_alert">
							<span name="message" style="font-size: 14pt; margin-bottom: 10px;" ></span>
							<div class="container_poli_alert">
								<table name="tbl_klinik_alert" class="table table-bordered">
								    <thead>
								      <tr>
								        <th>Hari</th>
								        <th>Nama Dokter</th>
								        <th>Poli Spesialis</th>
								        <th>Jam Praktek</th>
								      </tr>
								    </thead>
								    <tbody></tbody>
							  	</table>
							</div>

						</div>
						<div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
					</div>
				</div>
			</div>


			<div class="modal fade" id="modal_cari_skdp" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Pilih SKDP: </h4>
						</div>
						<div class="modal-body">
							
								<table name="tbl_cari_skdp" class="table table-bordered">
								    <thead>
								      <tr>
								        <th>Tgl.Masuk</th>
								        <th>No.SKDP</th>
								        <th>Lokasi</th>
								        <th>Nama Dokter</th>
								        <th>Opsi</th>
								      </tr>
								    </thead>
								    <tbody></tbody>
							  	</table>						

						</div>
						<div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
					</div>
				</div>
			</div>

			
			<div class="modal fade" id="modal_ambil_px_booking" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Ambil Pasien Booking: <span name="span_ambil_tgl_book"></span> </h4>
						</div>
						<div class="modal-body">
							
								<table class="table table-bordered" name="tbl_booking_daftar">
									<thead>
										<tr>
											<td>No.</td>
											<td>Opsi</td>
											<td>Time</td>
											<td>Noreq</td>
											<td>Nama</td>
											<td>NoRM</td>
											<td>Penanggung</td>
											<td>Noka BPJS</td>
											<td>Lokasi</td>
											<td>Nama Dokter</td>
										</tr>
									</thead>
									<tbody></tbody>
								</table>						

						</div>
						<div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
					</div>
				</div>
			</div>



      <div class="modal fade" id="modal_list_rjk_multi" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Rujukan Multi Record: </h4>
                </div>
                <div class="modal-body">
                  
                    <table class="table table-bordered" name="tbl_list_rjk_multi">
                      <thead>
                        <tr>
                          <td>No.</td>
                          <td>Opsi</td>
                          <td>No.Rujukan</td>
                          <td>Tgl.Rujukan</td>
                          <td>NOKA</td>
                          <td>Nama</td>
                          <td>Spesialis</td>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>						

                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
              </div>
            </div>
          </div>
          
			
			<!-- ================ [\MODAL ] =================== -->


      
				<div id="div_frame"></div>


