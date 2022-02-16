	
	<style>
		table[name=tbl_voucher_hutang_trf]>thead>tr>th{
			text-align: center;
		}

		table[name=tbl_voucher_hutang_trf]>tbody>tr>td:nth-child(4),
		table[name=tbl_voucher_hutang_trf]>tbody>tr>td>input{
			text-align: right;
		}
	</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">VOUCHER HUTANG</h2></section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
	        	<div class="form-inline" style="margin-bottom: 10px;">
		            <input type="text" name="tgl_start" class="form-control datepicker" placeholder="tgl start...">
		            <span> - </span>
		            <input type="text" name="tgl_end" class="form-control datepicker" placeholder="tgl end...">
		            
		            <button type="button" class="btn btn-info btn-flat" name="btn_ld_dokter">
		              Load Dokter <i class="fa fa-arrow-circle-right"></i>
		            </button>
	        	</div>
	        	<div class="form-inline" style="margin-bottom: 10px;">            
		            <select name="sel_dokter" class="form-control select2">
		              <option value="">- pilih dokter -</option>
		            </select>

		            <button type="button" class="btn btn-info btn-flat" name="btn_ld_voucher">
		              <i class="fa fa-arrow-circle-right"></i>
		            </button>

		        </div>

		        
	        </div>
        </div>

	<div class="row">
		<div class="col-xs-12">
			<table class="" style="width:100%;" border=0 >
				<tr>
					<td style="width:100px;">Tanggal Bukti</td>
					<td style="width:500px;">: <span name="tgl_bukti"><?=date("Y-m-d");?></span></td>
				</tr>
				<tr>
					<td>No.Bukti</td>
					<td>: <span name="nobukti"></span></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>: <span name="type"></span></td>
				</tr>
				<tr>
					<td>Type Vendor</td>
					<td>: <span name="type_vendor"></span></td>
				</tr>
				<tr>
					<td>Vendor</td>
					<td>: <span name="vendor"></span></td>
				</tr>
				<tr>
					<td>Jumlah Dikoreksi</td>
					<td>: <span name="jumlah_dikoreksi"></span></td>				
				</tr>
				<tr>
					<td>Keterangan</td>
					<td>: <input name="keterangan" type="text" style="width:90%;"></td>					
				</tr>
			</table>
		</div>
	</div>


		<br>

		<div class="row">
			<div class="col-xs-12">

	            <!-- <button type="button" class="btn btn-danger btn-flat" name="btn_dl_detail_all_pdf">
	              DOWNLOAD LAPORAN PDF <i class="fa fa-arrow-circle-right"></i>
	            </button> -->

	            <div class="form-inline" style="margin-bottom: 10px;">            
		            <select name="sel_pendapatan_bhp" class="form-control select2">
		              <option value="PENDAPATAN">PENDAPATAN</option>
		              <option value="BHP">BHP</option>
		            </select>

		            <select name="sel_rjri" class="form-control select2">
		              <option value=""></option>
		              <option value="RJ">RJ</option>
		              <option value="RI">RI</option>
		            </select>

		            <select name="sel_penanggung" class="form-control select2">
		              <option value="bpjs">BPJS</option>
		              <option value="nonbpjs">NON BPJS</option>
		            </select>

		            <input type="text" name="date" class="form-control datepicker-bln" placeholder="yyyy-mm...">

		            <button type="button" class="btn btn-info btn-flat" name="btn_addlist_voucher">
		              <i class="fa fa-plus"></i>
		            </button>

		        </div>

				<table name="tbl_list_voucher_hutang" class="table table-stripped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Opsi</th>
							<th>Faktur</th>
							<th>Tgl Jatuh Tempo</th>
							<th>Bayar</th>
							<th>Diskon</th>
							<th>Keterangan</th>
							<th>Hapus List</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1.</td>
							<td><button type="button" class="btn btn-success btn-flat" name="btn_dl_pendapatan_bpjs">
					              Excel <i class="fa fa-arrow-circle-down"></i>
					            </button>
							</td>
							<td>PENDAPATAN (BPJS) - <span name="bln_bpjs"></span></td>
							<td>-</td>
							<td>
								<input name="trf_dokter_bpjs" type="text" style="width:80px; text-align:right;" disabled="disabled">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>2.</td>
							<td><button type="button" class="btn btn-success btn-flat" name="btn_dl_pendapatan_nonbpjs">
					              Excel <i class="fa fa-arrow-circle-down"></i>
					            </button>
					        </td>
							<td>PENDAPATAN (NON BPJS) - <span name="bln_nonbpjs"></span></td>
							<td>-</td>
							<td>
								<input name="trf_dokter_nonbpjs" type="text" style="width:80px; text-align:right;" disabled="disabled">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>3.</td>
							<td><button type="button" class="btn btn-success btn-flat" name="btn_dl_bhp_bpjs">
					              Excel <i class="fa fa-arrow-circle-down"></i>
					            </button>
					        </td>
							<td>BHP & SEWA ALAT (BPJS) - <span name="bln_bhp_bpjs"></span></td>
							<td>-</td>
							<td>
								<input name="trf_dokter_bhp_bpjs" type="text" style="width:80px; text-align:right;" disabled="disabled">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>4.</td>
							<td><button type="button" class="btn btn-success btn-flat" name="btn_dl_bhp_nonbpjs">
					              Excel <i class="fa fa-arrow-circle-down"></i>
					            </button>
					        </td>
							<td>BHP & SEWA ALAT (NON BPJS) - <span name="bln_bhp_nonbpjs"></span></td>
							<td>-</td>
							<td>
								<input name="trf_dokter_bhp_nonbpjs" type="text" class="money"  data-inputmask='"mask": "9999-9999-99999"' data-mask style="width:80px; text-align:right;" disabled="disabled">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>5.</td>
							<td></td>
							<td>PPH</td>
							<td>-</td>
							<td><input name="trf_dokter_pph" type="text" style="width:80px; text-align:right;"></td>
							<td>-</td>
							<td>-</td>
							<td>
								<button type="button" class="btn btn-danger btn-flat btn_del">
					                <i class="fa fa-trash"></i>
					            </button>
				          	</td>
						</tr>
					</tbody>					
				</table>
			</div>
		</div>
		


    </section>
  </div>