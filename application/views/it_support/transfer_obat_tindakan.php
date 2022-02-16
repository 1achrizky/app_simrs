
	<div class="container">
		<h3 style="text-align: center; margin-top: 0px;" class="bold">TRANSFER OBAT/TINDAKAN</h3>
		<div class="row form-inline form-group">
			<input class="form-control" name="inp_noreff" type="text" placeholder="no.reff(APSL/DPSL)...">
			<button class="form-control btn-success" name="btn_buka_apsl">Buka APSL/DPSL</button>
		</div>

		<div class="row form-inline form-group">
			<input class="form-control" name="inp_bill_asal" type="text" placeholder="billing asal..." disabled>
			ke
			<input class="form-control" name="inp_bill_tujuan" type="text" placeholder="billing tujuan...">			

			<button class="form-control btn-danger" name="btn_transfer_obat">Transfer Obat</button>
		</div>

		<div class="row panel panel-primary">
			<div class="panel-heading">Data Asal(Fotrpayment & Boivsales)</div>
			<div class="panel-body">
				<pre id="hasil_jview_asal"></pre>
			</div>			
		</div>

		<div class="row panel panel-primary">
			<div class="panel-heading">Fotrdaftar</div>
			<div class="panel-body" id="hasil_jview_fotrdaftar">
			</div>
		</div>

		

	</div>
		
