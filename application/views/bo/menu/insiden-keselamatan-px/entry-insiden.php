<style>

.hidden{
  display: none;
}

table tr td:nth-child(1),
table tr td:nth-child(3),
table tr td:nth-child(1),
table tr td:nth-child(3),
.my_tbl tr td:nth-child(1),
.my_tbl tr td:nth-child(3){
  text-align:right;
}

table tr td,
table tr td,
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



</style>

<style>
  
  .tr_bpjs{
    display:none;
  }

  .form-control-my {
      border-top-left-radius:0px;
      border-top-right-radius:0px;
      /* border-top-style:inset; */
      border-top-width:1px;


      -webkit-writing-mode: horizontal-tb !important;
      text-rendering: auto;
      color: -internal-light-dark-color(black, white);
      letter-spacing: normal;
      word-spacing: normal;
      text-transform: none;
      text-indent: 0px;
      text-shadow: none;
      display: inline-block;
      text-align: start;
      -webkit-appearance: textfield;
      background-color: -internal-light-dark-color(white, black);
      -webkit-rtl-ordering: logical;
      cursor: text;
      margin: 0em;
      font: 400 13.3333px Arial;
      padding: 1px 0px;
      border-width: 2px;
      border-style: inset;
      border-color: initial;
      border-image: initial;      
  }


  .input-n {
    height:25px; width:155px;
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
                <h3 class="box-title" style="font-size:20pt; font-weight:bold;">ENTRY INSIDEN</h3>
              </div>
              <div class="box-body">

                <div class="row">
                  <div class="col-md-12">
                    <div id="errors"></div>
                  </div>
                </div>

                
                <form action="<?=base_url();?>/main/insert" method="POST" class="Form_post">
                
                
                  <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <table>
                          <tr>
                            <td>Jenis</td>
                            <td>
                              <select name="jns" style="width:155px;">
                                <option value="NON KPC">NON KPC</option>
                                <option value="KPC">KPC</option>
                              </select>
                            </td>
                          </tr>

                          <tr class="non_kpc">
                            <td>Nomor Billing</td>
                            <td><input type="text" name="nobill" autocomplete="off"></td>
                          </tr>

                          <tr class="non_kpc">
                            <td>NoRM</td>
                            <td><input type="text" name="norm" disabled="disabled"></td>
                          </tr>

                          <tr class="non_kpc"><td>Nama</td><td><input type="text" name="nama" disabled="disabled"></td></tr>
                          <tr class="non_kpc">
                            <td>Jenis Kelamin</td>
                            <td>
                              <input type="text" name="gender" disabled="disabled">
                              <!-- <select id="gender" style="width:155px; padding:1px 0px 1px 0px;" class="select2">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                              </select> -->
                            </td>              
                          </tr>
                          <tr class="non_kpc">
                            <td>Asuransi</td>
                            <td>
                              <select name="asuransix" id="" style="width:155px;"  disabled="disabled">
                                <option value="">- pilih -</option>
                                <option value="UMUM">UMUM</option>
                                <option value="BPJS">BPJS</option>
                                <option value="ASURANSI LAIN">ASURANSI LAIN</option>
                              </select>
                              <!-- <input type="text" name="asuransix" disabled="disabled"> -->
                              <input type="hidden" name="asuransi">
                            </td>
                          </tr>
                          <tr class="non_kpc">
                            <td>Tgl Masuk RS</td>
                            <td>
                              <!-- <input type="text" id="tgl_masuk" class="form-control datepicker input-n"  disabled="disabled"> -->
                              <input type="text" id="tgl_masuk" disabled="disabled">
                            </td>
                          </tr>
                          <tr class="non_kpc">
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
                                
                                <!-- <div class="bootstrap-timepicker">
                                  <input type="text" name="jamIns" class="form-control timepicker input-n" autocomplete="off">
                                </div> -->
                              </td></tr>
                          <!-- time Picker -->
                          <!-- <div class="bootstrap-timepicker">
                            <div class="form-group">
                              <label>Time picker:</label>

                              <div class="input-group">
                                <input type="text" class="form-control timepicker">

                                <div class="input-group-addon">
                                  <i class="fa fa-clock-o"></i>
                                </div>
                              </div>
                            </div>
                          </div> -->

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
                                                  
                        </table>
                        
                    </div>


                    <div class="col-md-5">
                        <table>
                          <tr><td>Lokasi Kejadian</td><td><textarea name="lokasiKejadian" id="" cols="35" rows="3" placeholder=""></textarea></td></tr>
                          
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
                          <tr><td></td><td>
                                <input type="submit" value="Entry Insiden" class="btn btn-success btn-rscm">
                              </td></tr>




                        </table>
                      
                    </div>


                  </div>
                
                </form>

                

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


