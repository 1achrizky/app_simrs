<input type="hidden" name="user_logged_in" value="<?=$username;?>" />

	<div class="container bold" name="main">
		<div class="row">
			<h2 class="text-center bold" style="margin:5px auto;">LOG PENDAFTARAN PASIEN RAWAT JALAN</h2>
		
			<div class="col-md-4 col-md-offset-4 form-inline">
				<input type="text" name="in_tgl" class="datepicker form-control text-center" placeholder="tgl: [yyyy-mm-dd]" />
			</div>
			
			<div  class="col-md-6 col-md-offset-3" id="daftar_error"></div>
			<br>	
		</div>

		<div class="row" name="div_val">
			<!-- tabel load disini by js -->
		</div>


	</div>



	<!-- ================ [ MODAL ] =================== -->

			<div class="modal fade" id="mdl_log_daftarrj" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Detail Pasien</h4>
						</div>
						<div class="modal-body" id="el_modal2">

							<!-- <div class="container"> -->
								<div class="row">
									<!-- <pre name="val_js_all" class="pre-scrollable"></pre> -->
									<pre name="val_js_all" style="height:300px;"></pre>
									<!-- <pre name="val_js_all"></pre> -->

									<!-- <pre name="val_js_all" class="pre-scrollable" style="display: block; font-family: monospace; white-space: pre; margin: 1em 0;"></pre> -->

									<!-- <table name="tbl_detail_pasien" class="table table-bordered bold">
										<tr><td class="col-xs-3">Billing		</td><td name="nobill" class="col-xs-4" style="width:300px;">-</td></tr>
										<tr><td>Nama Pasien	</td><td name="Nama">-</td></tr>
										<tr><td>NoRM		</td><td name="NoRM">-</td></tr>
										<tr><td>SEP			</td><td name="nosep">-</td></tr>
										<tr><td>SKDP		</td><td name="noskdp">-</td></tr>
										<tr><td>Lokasi		</td><td name="Lokasi">-</td></tr>
										<tr><td>Kode Dokter	</td><td name="Dokter">-</td></tr>
										<tr><td>Nama Dokter	</td><td name="namaDokter">-</td></tr>
										<tr><td>Tgl.Rujukan	</td><td name="tglRujukan">-</td></tr>
										<tr><td>No.Antrian	</td><td name="NoUrut">-</td></tr>
								  	</table>
								  	<br> -->
								</div>

						</div>
						<div class="modal-footer">
				          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
					</div>
				</div>
			</div>
	<!-- ================ [ \MODAL ] =================== -->