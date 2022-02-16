	
	<div class="container bold" name="main">
		<div class="row">
			<h2 class="text-center bold" style="margin:5px auto;">PENDAFTARAN RAWAT JALAN</h2>
		</div>
		<hr style="margin-top: 0px;">

		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
	                <span>Penanggung</span>
	                <select class="form-control select2" name="sel_penanggung_cm" style="width: 70%;">
	                	<option val=""></option>
	                </select>
	            </div>
	        </div>
		</div>

		
		<div class="row" name="form_add_else_bpjs" style="display:none;">
			<div class="col-xs-4">
				<div class="form-group">
	                <label>Cara Masuk &nbsp;</label>
	                <select class="form-control select2" name="sel_cara_masuk_cm" style="width: 60%;">
	                	<option val=""></option>
	                </select>
	            </div>
	        </div>
	        <div class="col-xs-4">
				<div class="form-group">
	                <label>Rujukan Dari</label>
	                <select class="form-control select2" name="sel_rujukan_dari_db_cm" style="width: 60%;">
	                	<option val=""></option>
	                </select>
	            </div>
	        </div>
	        <div class="col-xs-4">
				<div class="form-group">
	                <label>Asal Instansi</label>
	                <select class="form-control select2" name="sel_instansi_cm_all" style="width: 60%;">
	                	<option val=""></option>
	                </select>
	            </div>
	        </div>
		</div>

		<!-- <div class="row">
			<button id="clr_sel">GET Select</button>
		</div> -->

		<div class="row">
			<div class="col-md-6">
				<div class="input-group">
					<input type="text" name="scan_noka" class="form-control input-sm text-center" placeholder="Scan Kartu BPJS..." />
					<span class="input-group-addon btn btn-primary" name="btn_ambil_pasien_booking">
			    		Ambil Pasien Booking
			    	</span>
				</div>
			</div>
			<div class="col-md-6 form-inline">
				<!-- <button class="btn btn-primary input-sm" name="btn_ambil_pasien_booking">Ambil Pasien Booking</button>	 -->
				<div class="checkbox" name="div_cbox_booking" style=" margin-left: 15px;">
						<label>
							<input name="cbox_booking" type="checkbox">
							<b>BOOKING</b>
						</label>
					</div>
			</div>
		</div>
		<div class="row">
			<br>
			<div id="daftar_error"></div>
		</div>

		<hr style="margin-top: 0px;">
		<div class="row">
			<?//=form_open(base_url().'main/sep_create');?>
			<!-- <div class="col-md-5 col-md-offset-1" > -->
			<div class="col-md-6" >
				
				<!-- <table name="tblDataRm" class="table-bordered mytable div_center ikii"> -->
				<table name="tblDataRm" style="margin: 0px auto; width:100%;" class="" border=1>
					<tr>
						<td style="width:20%;">No.RM</td>
						<td style="width:70%;"><input type="text" name="pasienRscm_norm" class="form-control input-sm" placeholder="Masukkan No.RM..." autocomplete="off" required></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td><span name="pasienRscm_nama">-</span></td>
					</tr>
					<tr>
						<td>Tgl.Lahir</td>
						<td><span name="pasienRscm_tglLahir">-</span></td>
					</tr>
					<tr>
						<td>Umur/JK</td>
						<td><span name="pasienRscm_umur">-</span> / <span name="pasienRscm_jk">-</span></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td><span name="pasienRscm_alamat">-</span></td>
					</tr>
					<tr>
						<td style="font-size: 10pt;">Suku Bangsa</td>
						<td style="font-size: 10pt;">
							<?php $sukubangsa = array(
								"JAWA", "SUNDA","BATAK","BETAWI","TIONGHOA","MADURA","TENGGER",
								"BANJAR","BANTEN","MELAYU","BUGIS","ARAB","BALI","SASAK","DAYAK",
								"MAKASAR","CIREBON","MINANGKABAU","KOREA","JEPANG","INDIA","INDO"); ?>
							<select name="pasienRscm_sukubangsa">
								<option value="">- pilih -</option>
								<?php 
								foreach($sukubangsa as $suku){
									echo '<option value="'.$suku.'">'.$suku.'</option>';
								} ?>
							</select>
						</td>
					</tr>
				</table>
				<br>
				
				<div class="row">
					<div class="col-md-7">
						<div class="input-group">
							<input type="text" name="skdp" class="form-control input-sm" placeholder="No.SKDP BPJS..." />
							<span class="input-group-addon btn btn-default" name="cari_skdp">
					    		<i class="glyphicon glyphicon-search"></i>
					    	</span>
							<!-- tglMasuk(sort: tgl terbaru atas),lokasi,noskdp -->
						</div>
					</div>
					<div class="col-md-5">
						<input type="text" name="telp" class="form-control input-sm" placeholder="No.Telp..." value="123456789"/>
					</div>
				</div>
				
				<input type="text" name="catatan_sep" class="form-control input-sm" placeholder="Catatan SEP..." />
				<input type="text" name="ket_fo" class="form-control input-sm" placeholder="Ket.FO..." />
				<textarea name="ket_mst_px" class="form-control" rows="3" placeholder="keterangan pasien..." disabled="disabled"></textarea>

			</div>


			<div class="col-md-6">
				<div class="input-group" style="width:350px;">
			    	<input type="text" class="form-control input-sm" name="klinikTujuan" placeholder="Cari Klinik Tujuan..." autocomplete="off" required>
			    	<span class="input-group-addon btn btn-danger btn_clear">
			    		<i class="glyphicon glyphicon-remove"></i>
			    	</span>
			    </div>

				<div class="input-group" style="width:350px;">
			    	<input type="text" class="form-control input-sm" name="cari_jadok" placeholder="Cari Dokter RS..." autocomplete="off" required>
			    	<span class="input-group-addon btn btn-danger btn_clear">
			    		<i class="glyphicon glyphicon-remove"></i>
			    	</span>
			    </div>

			    <div class="input-group" style="width:350px;">
			    	<input type="text" class="form-control input-sm" name="kd_dpjp_bpjs" placeholder="Kode Dokter Vclaim..." autocomplete="off" required>
			    	<span class="input-group-addon btn btn-danger btn_clear">
			    		<i class="glyphicon glyphicon-remove"></i>
			    	</span>
			    </div>
				
				<div class="row" style="width:350px; margin:0px;">
					<div class="col-xs-3" style="padding-left:0px;padding-right:0px;">
						<input type="text" class="form-control input-sm" name="diagkey_bpjs" placeholder="diag..." autocomplete="off" required>
					</div>
					<div class="col-xs-9 form-group" style="padding-left:0px;padding-right:0px;">
		                <select class="form-control select2" name="sel_diag_bpjs">
		                	<!-- <option val=""></option> -->
		                </select>
						<!-- <div class="input-group">
					    	<input type="text" class="form-control" name="diag_bpjs" placeholder="Diagnosa awal..." autocomplete="off" required>
					    	<span class="input-group-addon btn btn-danger btn_clear">
					    		<i class="glyphicon glyphicon-remove"></i>
					    	</span>
					    </div> -->
					</div>
				</div>
				

			    <!-- 
			    <span>*Poli: </span> <span name="poli_bpjs"></span> -->
			    



				<h3 id="tes_prog" style="margin:5px auto; font-weight: bold;">BPJS</h3>
				<!-- <table name="tbl_bpjs" class="table-bordered mytable ikii" border=1>  -->
				<table name="tbl_bpjs" class="" border=1>
					<tr>
						<td>No. Kartu</td>
						<td><span name="noka">-</span></td>
					</tr>
					<tr>
						<td>No. Rujukan</td>
						<td><span name="norujukan">-</span></td>
					</tr>
					<tr>
						<td>Poli (VCLAIM)</td>
						<td><span name="poli_bpjs">-</span></td>
					</tr>
					<tr>
						<td><span>PPK Asal</span>
							<input type="text" name="asalRujukan_bpjs" id="asalRujukan_bpjs"  style="width:50px; text-align: center;">
						</td>
						<td><input type="text" name="noRujukan_ppk2_bpjs" id="noRujukan_ppk2_bpjs" class="form-control input-sm" placeholder="isi rjk bila PPK=2..."></td>
					</tr>
				</table>
			
				<br>
				<div class="form-inline">
					<button type="submit" class="btn btn-primary" name="btn_daftarrj" value="DAFTAR"> DAFTAR </button>
					<!-- <button class="btn btn-primary" name="btn_cetak_skdp">Cetak SKDP</button> -->

					<!-- <button class="btn btn-danger" onclick="window.location.href=unescape(window.location.pathname);"> Reset </button> -->
					<button class="btn btn-danger" onclick="window.location.reload(true)"> Reset </button>
					
				</div>
					
				


				<!-- BUKA MODAL BY [ATTR]DATA_TOGGLE
				<button class="btn btn-primary" name="btnOpen" data-toggle="modal" data-target="#modal_klinik"> Modal OPen </button> -->
			

				<input type="hidden" name="kode_lokasi" />
			  	<input type="hidden" name="user_logged_in" value="<?=$username;?>" />
				
				<div id="div_frame"></div>
				
				
			</div>
			
			<?//=form_close();?>

		</div>

		<hr style="margin-top: 0px;">
		<span>Progress pendaftaran:</span> 
		<span id="progress_daftar_lbl">-</span>
		<div class="progress">
			<div id="progress_daftar_val" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
			  0%
			</div>
		</div>


		<div class="row" name="hasil_daftar">
			<div class="form-inline">
					<span>SEP berhasil dibuat:</span> 
					<input type="text" class="form-control input-sm" name="get_nosep_temp" />
					<button class="btn btn-danger" name="btn_sep_hapus"> Hapus SEP </button>

					<span style="margin-left: 25px;">BILLING:</span>
					<input type="text" class="form-control input-sm" name="get_bill_siap_pakai" />
			</div>
		</div>
		<br>

		<!-- <button name="btn_get_final" class="btn btn-primary">btn_get_final</button> -->
		
		<div class="row">
				<!-- 
				<button class="btn btn-primary div_center" name="btn_daftarrj" style=""> DAFTAR </button> 
				
				
				<input type="submit" class="btn btn-primary div_center" name="btn_daftarrj" value="DAFTAR" />
				-->
				
				<!-- <button class="btn btn-primary" onclick="alert(get_antrian_klinik(20))"> get_antrian_klinik </button>
				<button class="btn btn-primary" onclick="alert(buat_antrian_klinik_baru(20))"> buat_antrian_klinik_baru </button>
				<button class="btn btn-primary" name="btn_sep_create">sep_create</button>
				-->
				
				
		</div>



			<!-- ================ [ MODAL ] =================== -->

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
	</div>


	<!-- <div>Alamat</div> -->
	<div>
		<?php 
			$Alamat_tes = "JL. SUPARJAN MW 4B MOJOROTO"; 
			//echo alamat_split($Alamat_tes);


		?>
		
	</div>
	
	