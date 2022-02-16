
	<div class="container">
		<h3 style="text-align: center; margin-top: 0px;" class="bold">GANTI PENANGGUNG</h3>
		<div class="row form-inline form-group">
			<input class="form-control" name="inp_bill_toPenanggung" type="text" placeholder="no.billing...">
			<button class="form-control btn-success" name="btnCari_bill_toPenanggung">Cari Billing</button>
		</div>

		<div class="row form-inline form-group">
			<input class="form-control" name="inp_asal_penanggung" type="text" placeholder="asal penanggung..." disabled>
			<span> ke </span>

			<div class="form-group">
                <select class="form-control select2" name="sel_penanggung_cm" style="width: 250px;">
                	<option val=""></option>
                </select>
            </div>

			<button class="form-control btn-danger" name="btn_ganti_penanggung">Ganti Penanggung</button>
		</div>

		<div class="row panel panel-primary">
			<div class="panel-heading">Fotrdaftar</div>
			<div class="panel-body">
				<pre id="hasil_jview_fotrdaftar"></pre>
			</div>
			
		</div>

		<div class="row panel panel-primary">
			<div class="panel-heading">Fotrbillshare</div>
			<div class="panel-body">
				<pre id="hasil_jview_fotrbillingshare"></pre>
			</div>
		</div>

		<div class="row panel panel-primary">
			<div class="panel-heading">Fotrpayment</div>
			<div class="panel-body" id="hasil_jview_fotrpayment">
				<!-- <pre id="hasil_jview_fotrpayment"></pre> -->
			</div>
			<!-- <table name="res_deltindakan_postindakandet" border=1 class="">
				<thead>
					<tr>
						<td width="30">No.</td>
						<td width="200">NoNota</td>
						<td width="50">Opsi</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td><button>Delete</button></td>
					</tr>
				</tbody>
				
			</table> -->
		</div>

		

	</div>
		
