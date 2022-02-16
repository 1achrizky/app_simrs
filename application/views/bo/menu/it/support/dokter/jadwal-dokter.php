  <style>
		/*==================== TABEL INPUT DOKTER ==================*/
		h4{
	font-size: 26pt;
	margin-top: 50px;
	font-weight: bold;
}

select{
	margin:5px 0px;
}

select.form-control{
	width:calc(100% - 20px);
}

select option{
	width:200px;
}

		select[name=hh_in].form-control, 
		select[name=mm_in].form-control,
		select[name=hh_out].form-control, 
		select[name=mm_out].form-control{
			width: 70px;
		}

		table[name=tblFormJadok]{
			margin:0px auto;
		}


		table[name=tblFormJadok] tr td{
			height:52px;
		}

		table[name=tblFormJadok] td span{
			padding: 0px 10px;
		}

		table[name=tblFormJadok] td:nth-child(1){
			width:150px;
			text-align: right;
			padding-right: 15px;
		}

		table[name=tblFormJadok] td:nth-child(2){
			text-align: left;
			padding-left: 15px;
		}

		table[name=tblFormJadok] td[name=jam_selesai]{
			//background-color: yellow;
			//height: 60px;
		}

		table[name=tblFormJadok] td[name=jam_mulai] select,
		table[name=tblFormJadok] td[name=jam_mulai] span{
			float: left;
		}

		table[name=tblFormJadok] td[name=jam_selesai] select.modewaktu,
		table[name=tblFormJadok] td[name=jam_selesai] span.modewaktu{
			float: left;
		}

		table[name=tblFormJadok] td[name=jam_mulai] span,
		table[name=tblFormJadok] td[name=jam_selesai] span{
			//vertical-align: middle; margin-top: 15px;
		}

		button[name=simpan_jadok]{
			display: block;
			margin:0px auto;
			text-align: center;
			width:550px;
		}
		/*====================\TABEL INPUT DOKTER ==================*/

		/*==================== TABEL JADWAL DOKTER ==================*/

		table[name=tbl_jadok]{
			margin:0px auto;
		}
		
		table[name=tbl_jadok] tr{
			height:35px;
		}


		table[name=tbl_jadok] td span{
			padding: 0px 10px;
		}
		
		table[name=tbl_jadok] th:nth-child(1),
		table[name=tbl_jadok] td:nth-child(1){ //Hari
			width:70px;
			text-align: center;
		}

		table[name=tbl_jadok] th:nth-child(2),
		table[name=tbl_jadok] td:nth-child(2){ //Poli Spesialis
			width:200px;
			text-align: center;
		}

		table[name=tbl_jadok] th:nth-child(3){
			width:250px;
			text-align: center;
		}
		table[name=tbl_jadok] td:nth-child(3){ //Nama Dokter
			width:250px;
			text-align: left;
		}

		table[name=tbl_jadok] th:nth-child(4),
		table[name=tbl_jadok] td:nth-child(4){ //Jam Praktek
			width:120px;
			text-align: center;
		}

		table[name=tbl_jadok] th:nth-child(5),
		table[name=tbl_jadok] td:nth-child(5){ //OPSI
			width:100px;
			text-align: center;
		}

		table[name=tbl_jadok] button{
			//height:20px;
			padding:0px 10px;
		}
		/*====================\TABEL JADWAL DOKTER ==================*/
	</style>
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- <section class="content-header" style="height:70px;"><h2 class="bold">Setting Jadwal Dokter</h2></section> -->
    
    <!-- Main content -->
    <section class="content">
      			            
		<div class="row">
          <div class="col-md-12">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:20pt; font-weight:bold;">Setting Jadwal Dokter</h3>
              </div>
              <div class="box-body">
								<table name="tblFormJadok" border=1>
									<tr>
										<td width="150px">Nama Dokter</td>
										<td width="400px">
											<select name="nama_dokter" class="form-control">
												<option value="-">-- Pilih Dokter --</option>
											</select>
										</td>
									</tr>
									<tr>
										<td width="150px">Kode Dokter</td>
										<td width="300px" name="kode_dokter">-</td>
									</tr>
									<tr>
										<td>Poli</td>
										<td name="lokasi">-</td>
									</tr>
									<tr>
										<td>Hari</td>
										<td><select name="hari" class="form-control">
												<option value="-">-- Pilih Hari --</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Jam Mulai</td>
										<td name="jam_mulai">
											<select name="hh_in" class="form-control">
												<?php
												for($i=0;$i<24;$i++){
													if($i<10) $i='0'.$i;
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
												?>
											</select>
											<span>:</span>
											<select name="mm_in" class="form-control">
												<?php
												for($i=0; $i<=45; $i+=15){
													if($i==0) $i='00';
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Jam Selesai
											<input type="checkbox" name="cbox_selesai" value="selesai" title="*Centang bila SELESAI">
										</td>
										<td name="jam_selesai">
											
											<!-- 
											<input type="text" id="timepicker-one" name="timepicker-one" class="timepicker"/> -->
										</td>
									</tr>
								</table>
								<br>
								<button class="btn btn-primary" name="simpan_jadok" id="simpan_jadok"> SIMPAN </button>
								
								<br><br>

							</div>
              
							<div class="box-body">
								<hr>
								<h3 class="box-title" style="font-size:20pt; font-weight:bold; text-align:center;">Tabel Jadwal Dokter</h3>
								<div style="overflow-y: auto; height:400px;  overflow-x: scroll; width:100%;">
									<table name="tbl_jadok" border=1></table>
								</div>
							</div>
            </div>
          </div>
      </div>
	       
    </section>
  </div>