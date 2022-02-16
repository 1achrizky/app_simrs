
<div class="container bold">
	<div class="row">
		<h2 style="text-align: center; margin-top: 0px;">Pembuatan SEP</h2>

		<input type="text" name="noRujukanCari" class="form-control" placeholder="Masukkan Nomor Rujukan..." style="width: 300px; margin:10px auto; text-align: center;" required>

	</div>
	<div class="row">
		<div class="col-xs-6">
			<!-- <table name="tblDataRm" class="table-bordered mytable div_center">  -->
			<table name="tblDataRm">
				<tr>
					<td>Poli Tujuan</td>
					<td><input type="text" name="poli_tujuan" class="form-control" required></td>
				</tr>
				<tr>
					<td>PPK Rujukan</td>
					<td><input type="text" name="ppkRujukan" class="form-control" required></td>
				</tr>
				<tr>
					<td>Asal Rujukan</td>
					<td><input type="text" name="asalRujukan" class="form-control" required></td>
				</tr>
				<tr>
					<td>Tgl Rujukan</td>
					<td><input type="text" name="tglRujukan" class="form-control" required></td>
				</tr>

				<tr>
					<td>No.Rujukan</td>
					<td><input type="text" name="noRujukan" class="form-control" required></td>
				</tr>
				<tr>
					<td>Tgl Sep</td>
					<td><input type="text" name="tglSep" class="form-control" required></td>
				</tr>
				<tr>
					<td>NoMR</td>
					<td><input type="text" name="noMR" class="form-control" required></td>
				</tr>

				<tr>
					<td>NoKartu</td>
					<td><input type="text" name="noKartu" class="form-control" required></td>
				</tr>

			</table>
		</div>


		<div class="col-xs-6">
			<!-- <table name="tbl_bpjs" class="table-bordered mytable"> -->
			<table name="tbl_bpjs">
				<tr>
					<td>Jenis Pelayanan</td>
					<td><input type="text" name="jnsPelayanan" class="form-control" required></td>
				</tr>
				<tr>
					<td>Kelas Rawat</td>
					<td><input type="text" name="klsRawat" class="form-control" required></td>
				</tr>

				<tr>
					<td>Diagnosa Awal</td>
					<td><input type="text" name="diagAwal" class="form-control" required></td>
				</tr>
				<tr>
					<td>No.Telp</td>
					<td><input type="text" name="noTelp" class="form-control" value="123456789" required></td>
				</tr>
				<tr>
					<td>Catatan</td>
					<td><textarea name="catatan" class="form-control" cols="30" rows="3" style="display:block;margin:5px auto;"></textarea></td>
				</tr>
				<tr>
					<td>DPJP</td>
					<td><input type="text" name="dpjp" class="form-control" value="16588" required></td>
				</tr>
				<tr>
					<td>SKDP</td>
					<td><input type="text" name="noskdp" class="form-control" value="123456" required></td>
				</tr>

				<!-- <tr>
					<td>User</td>
					<td><input type="text" name="user" class="form-control" value="HERMAWAN" required></td>
				</tr> -->
			</table>


				<!-- 
				<button class="btn btn-primary" name="btnOpen" data-toggle="modal" data-target="#modal_klinik"> Modal OPen </button> -->
		</div>
		
		<div style="clear:left; padding-top:10px;">
			<button class="btn btn-primary div_center" name="btn_sep_create_11" style="width:500px; font-size: 20pt; display:block;"> Buat SEP </button>
		</div>




		<div style="clear:left; padding-top:20px;">
			<div class="row"  style="width: 400px; margin:0px auto;" >
				<input type="text" name="sep_cari" class="form-control" style="width: 100%; text-align:center; margin: 0px auto;" placeholder="Nomor SEP..." />
				
				<button class="btn btn-primary bold btn_sep" name="btn_sep_cari" > Cari SEP </button>
				<button class="btn btn-danger  bold btn_sep" name="btn_sep_hapus" > Hapus SEP </button>
				
			</div>
		</div>

		<br>
		<button class="btn btn-primary" name="btn_cetak"> Cetak </button>
		
		<br>
		<br>
		<br>		
	</div>
</div>

	
	
	<script src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?=base_url();?>assets/plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
  	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery.xdomainrequest.min.js"></script>
  	<script type='text/javascript' src="<?=base_url();?>assets/js/moment-with-locales.js"></script>
	
	<!-- UNTUK MODAL -->
	<script src="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/js/bootstrap.min.js"></script>

	<script>


	$(function(event){
		console.log(moment().format('YYYY-MM-DD hh:mm:ss'));
		

		let poli_tujuan_ax, ppkRujukan_ax, tglRujukan_ax, noRujukan, tglSep_ax, noKartu_ax;
		let jnsPelayanan_ax, klsRawat_ax, diagAwal_ax;
		let nomr_ax;

		$("input[name=noRujukanCari]").keypress(function (e) { //TEKAN ENTER
			noRujukan = $(this).val();
	 		if (e.which == 13) {
	 			//alert($(this).val());
	 			//alert($(this).val()+'__<>?=base_url();?>ajaxreq/rujukan');
	 			$.ajax({
					async: false,
					url:"<?=base_url();?>ajax_bpjs11/rujukan",
					//type:"POST",
					type:"GET",
					data: { 
						noRujukan : $(this).val() 
					},
					success:function(data){
						//console.log(data);
						let js = JSON.parse(data);
						console.log(js);
						
						poli_tujuan_ax = js.response.rujukan.poliRujukan.kode;
						ppkRujukan_ax = js.response.rujukan.provPerujuk.kode;
						tglRujukan_ax = js.response.rujukan.tglKunjungan;
						tglSep_ax = moment().format('YYYY-MM-DD');
						noKartu_ax = js.response.rujukan.peserta.noKartu;

						jnsPelayanan_ax = js.response.rujukan.pelayanan.kode;
						klsRawat_ax = js.response.rujukan.peserta.hakKelas.kode;
						diagAwal_ax = js.response.rujukan.diagnosa.kode;

						nomr_ax = js.response.rujukan.peserta.mr.noMR;

						$('input[name=poli_tujuan]').val(poli_tujuan_ax);
						$('input[name=ppkRujukan]').val(ppkRujukan_ax);
						$('input[name=tglRujukan]').val(tglRujukan_ax);
						$('input[name=noRujukan]').val(noRujukan);
						$('input[name=tglSep]').val(tglSep_ax);
						$('input[name=noMR]').val(nomr_ax);
						$('input[name=noKartu]').val(noKartu_ax);

						$('input[name=jnsPelayanan]').val(jnsPelayanan_ax);
						$('input[name=klsRawat]').val(klsRawat_ax);
						$('input[name=diagAwal]').val(diagAwal_ax);
					},
					error:function(jqXHR,textStatus,errorThrown){
						console.log("ERROR[get_klinik]: "+errorThrown);
					}
				});

	 		}
		});


		// $('button[name=btn_sep_create]').click(function(){
		$('button[name=btn_sep_create_11]').click(function(){
		 	//alert('oke sep');
		 // 	//======   ws1   ============
			// let jpost_sep_create = {
		 //           "request"  : {
		 //              "t_sep" : {
		 //                "noKartu" : $('input[name=noKartu]').val(),
		 //                //"tglSep"  : moment().format('YYYY-MM-DD'),
		 //                "tglSep"  : $('input[name=tglSep]').val(),//tglSep
		 //                "ppkPelayanan"  : '0195R028',
		 //                "jnsPelayanan"  : $('input[name=jnsPelayanan]').val(),
		 //                "klsRawat": $('input[name=klsRawat]').val(),
		 //                "noMR"    : $('input[name=noMR]').val(),
		 //                "rujukan" : {
		 //                  "asalRujukan": '1',
		 //                  "tglRujukan" : $('input[name=tglRujukan]').val(),
		 //                  "noRujukan"  : $('input[name=noRujukan]').val(),
		 //                  "ppkRujukan" : $('input[name=ppkRujukan]').val()
		 //                },
		 //                //"catatan" : $('input[name=catatan_sep]').val(),
		 //                "catatan" : $('textarea[name=catatan]').val(),
		 //                "diagAwal": $('input[name=diagAwal]').val(),
		 //                "poli"    : {
		 //                  "tujuan"   : $('input[name=poli_tujuan]').val(),
		 //                  "eksekutif": '0'
		 //                },
		 //                "cob" : {
		 //                  "cob" : '0'
		 //                },
		 //                "jaminan" : {
		 //                  "lakaLantas"  : '0',
		 //                  "penjamin"    : '0',
		 //                  "lokasiLaka"  : '0'
		 //                },
		 //                "noTelp": $('input[name=noTelp]').val(),
		 //                "user"  : "16141"
		 //              }               
		 //            }
		 //    	};
		 //    //======   \ws1   ============

		    //======   ws1.1   ============
			let jpost_sep_create =                                                     
        {
           "request": {
              "t_sep": {
                 "noKartu":$('input[name=noKartu]').val(),
                 "tglSep": $('input[name=tglSep]').val(),
                 "ppkPelayanan": "0195R028",
                 "jnsPelayanan": $('input[name=jnsPelayanan]').val(),
                 "klsRawat": $('input[name=klsRawat]').val(),
                 "noMR": $('input[name=noMR]').val(),
                 "rujukan": {
                    "asalRujukan": $('input[name=asalRujukan]').val(),
                    "tglRujukan": $('input[name=tglRujukan]').val(),
                    "noRujukan": $('input[name=noRujukan]').val(),
                    "ppkRujukan":  $('input[name=ppkRujukan]').val()
                 },
                 "catatan": $('textarea[name=catatan]').val(),
                 "diagAwal": $('input[name=diagAwal]').val(),
                 "poli": {
                    "tujuan": $('input[name=poli_tujuan]').val(),
                    "eksekutif": "0"
                 },
                 "cob": {
                    "cob": "0"
                 },
                 "katarak": {
                    "katarak": "0"
                 },
                 "jaminan": {
                    "lakaLantas": "0",
                    "penjamin": {
                        "penjamin": "0",
                        "tglKejadian": "0000-00-00",
                        "keterangan": "",
                        "suplesi": {
                            "suplesi": "0",
                            "noSepSuplesi": "",
                            "lokasiLaka": {
                                "kdPropinsi": "",
                                "kdKabupaten": "",
                                "kdKecamatan": ""
                                }
                        }
                    }
                 },
                 "skdp": {
                    //"noSurat": "123456",
                    "noSurat": $('input[name=noskdp]').val(),
                    //"kodeDPJP": "16588"//dr ihwan
                    "kodeDPJP": $('input[name=dpjp]').val()//dr ihwan
                 },
                 "noTelp": $('input[name=noTelp]').val(),
                 "user": "16141"
              }
           }
        };
		    //======   \ws1.1   ============
		    	
		    console.log('[Data will send (sep_create)]::');
		    console.log(jpost_sep_create);

		    $.ajax({
	          async: false,
	          url  : baseUrl()+"ajax_bpjs11/sep_create_bpjs",
	          type :"POST",
	          data : jpost_sep_create,
	          success:function(data){
	            //console.log(data);
	            let js = JSON.parse(data);
	            console.log(js);
	            alert(data);
	          },
	          error:function(jqXHR,textStatus,errorThrown){
	            console.log("ERROR[ajax_bpjs11/sep_create_bpjs]: "+errorThrown);
	          }
	        });

		});


		$('button[name=btn_sep_cari]').click(function(){
			//alert('oke');
			$.ajax({
				async: false,
				//url:"<.?=base_url();?>ajaxreq/sep_cari_bpjs",
				url:"<?=base_url();?>ajax_bpjs11/sep_cari_bpjs",
				type:"GET",
				data: { 
					nosep : $('input[name=sep_cari]').val()
				},
				success:function(data){
					console.log(data);
					let js = JSON.parse(data);
					alert(data);
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log("ERROR[ajaxreq/sep_cari_bpjs]: "+errorThrown);
				}
			});
		});

		$('button[name=btn_sep_hapus]').click(function(){
			//alert('HAPUS');
			$.ajax({
				async: false,
				url:"<?=base_url();?>ajax_bpjs11/sep_hapus_bpjs11",
				type:"GET",
				data: { 
					//_method	: 'delete',
					nosep: $('input[name=sep_cari]').val(),
					//user : "16141"
					user : "rscitra.medika"
				},
				success:function(data){
					console.log(data);
					let js = JSON.parse(data);
					alert(data);
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log("ERROR[ajaxreq/sep_hapus_bpjs]: "+errorThrown);
				}
			});
		});

		$('button[name=btn_cetak]').click(function(){
			//alert('oke');
			window.print();
		});


	});

	</script>





</body>
</html>