
	<div class="container">
		<div class="row">
			<h3 style="text-align: center;">Cek Pegawai Tidak Absen</h3>
		</div>
		<div class="row">
			<div class='col-sm-3'>
				<input class="form-control" name="inp_noreg" type="text" placeholder="noreg...">
			</div>
			<div class='col-sm-3'>
				<div class="input-group">
					<input class="form-control" name="inp_tgl" type="text" placeholder="YYYY/MM/DD">
					<div class="input-group-addon" >
			        	<span class="glyphicon glyphicon-th"></span>
			    	</div>
			    </div>
			</div>

			<div class='col-sm-6'>
				<button class="btn btn-primary" name="btnCek_abslog">Cek Absensi Pegawai di abs_log</button>
			</div>
		</div>

		<div id="hrd_abs_log" class="panel panel-default">
			<table>
				<tr>
					<td>Tanggal</td>
					<td>: <span name="tgl_select"></span></td>
				</tr>
				<!-- <tr>
					<td>Nama</td>
					<td>: <span name="nama_pegawai"></span></p></td>
				</tr> -->
				<tr>
					<td>Register</td>
					<td>: <span name="reg_pegawai"></span></td>
				</tr>
			</table>

			<hr>
			<p>Hasil Log Mesin Absensi (ABS LOG)</p>
			<div id="jview_hrd_abs_log"></div>
			
		</div>

		<!-- datepicker source: https://github.com/uxsolutions/bootstrap-datepicker -->
		<!-- tutorial: https://formden.com/blog/date-picker -->


	</div>

