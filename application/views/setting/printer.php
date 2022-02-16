
	<div class="container bold" name="main">
		<div class="row">
			<h2 class="text-center bold" style="margin:5px auto;">SETTING PRINTER PENDAFTARAN RJ</h2>
		</div>
		<div class="row">
			<table class="table table-bordered" style="width:600px;">
				<tr>
					<td colspan="2" class="bold">
						<h3>Daftar printer yang harus dikoneksikan.</h3>
					</td>
				</tr>
				<tr>
					<td class="col-md-3">termal_nomor_antrian</td>
					<td><?=$my_printer_list['termal_nomor_antrian'];?></td>
				</tr>
				<tr>
					<td>termal_tracer</td>
					<td><?=$my_printer_list['termal_tracer'];?></td>
				</tr>
				</tr>
				<tr>
					<td>termal_tracer_rc</td>
					<td><?=$my_printer_list['termal_tracer_rc'];?></td>
				</tr>
				<tr>
					<td>cetak_sep_langsung</td>
					<td><?=$my_printer_list['cetak_sep_langsung'];?></td>
				</tr>
				<tr>
					<td>cetak_skdp_langsung</td>
					<td><?=$my_printer_list['cetak_skdp_langsung'];?></td>
				</tr>
			</table>
		</div>

		<!-- 
		NOTE:: seharusnya format data tabel dan SISTEM PHP_PRINTnya 
		IP / NAMA PRINTER / TUGAS PRINTER(ex: termal_nomor_antrian, termal tracer, dsb)
		 -->

		<div class="row">
			<div class="col-md-6 form-inline">
				<label>Pilih Printer :</label> 
				<?php
			        //////$getprt = printer_list(PRINTER_ENUM_LOCAL);
			        //$getprt = printer_list(PRINTER_ENUM_SHARED);
			        $getprt = printer_list(PRINTER_ENUM_CONNECTIONS);
			        $printers = serialize($getprt);
			        $printers = unserialize($printers);
			        //Menampilkan List Printer
			        echo '<select name="printers" id="printer" class="form-control">';
			        foreach ($printers as $PrintDest)
			            //echo "<option value='" . $PrintDest["NAME"] . "'>" . explode(",", $PrintDest["DESCRIPTION"])[1] . "</option>";
			            echo "<option value='" .$PrintDest["NAME"]. "'>" .$PrintDest["NAME"]. "</option>";
			        echo '</select>';
		        ?>
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary" name="btn_ambil_pasien_booking">Tambah ke Daftar Printer</button>
			</div>
		</div>

		<div class="row">
			<br>
			<div id="daftar_error"></div>
		</div>

		<hr>
		<div class="row">
				<button class="btn btn-primary" name="btn_simpan_setting_printer">Simpan</button>
				
		</div>


	
	</div>
	