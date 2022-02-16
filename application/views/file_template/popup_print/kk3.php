<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>KK3</title>

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<!-- <link rel="stylesheet" href="<>?=base_url();?>assets/css/style.css" type="text/css">  -->
	
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/site.css" type="text/css">
	<style type="text/css">
		
		.kop-atas tr td:nth-child(3) div{
			width:100% !important;
		}
		/* .kop-atas-kanan div{
			width:100% !important;
		} */

		.kop-atas-kanan{ border: 3px solid black;}

		.tbl_form1 tr td{ border: 0px solid black;}
		.tbl_form1 tr>td{vertical-align:top;}
		.tbl_form1 tr>td:nth-child(1){ width:20px; }
		.tbl_form1 tr>td:nth-child(2){ width:200px; }		
		.tbl_form1 tr>td:nth-child(3){ width:10px !important; }		
		/* .tbl_form tr>td:nth-child(4){ width:250px !important; } */

	</style>

</head>
<body>

	<!-- <.?="<pre>",print_r($js_sel),"</pre>";?>
	<.?="<pre>",print_r($peserta_cari),"</pre>";?>
	<.?="<pre>",print_r($js_sep),"</pre>";?> -->

	<div class="container row font_cetak kertas_A4" name="main">
		<!-- <div style="clear:left; height:20px;"></div> INI FORMAT ASLI RESUME. dicomment karena ada clear -->
		<div style="height:20px;"></div>
		<div id="kertas_resume" class="row ft_normal" style="font-size: 10pt;">
			<table class="kop-atas">
				<tr>
					<td class="col-md-3">
						<img src="<?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;">
					</td>
					<td class="col-md-6 text_center bold" style="font-size: 12pt;">
						SURAT KETERANGAN DOKTER 
						<br> KASUS KECELAKAAN KERJA </td>
					<td class="col-md-3 kop-atas-kanan" style="text-align: center;">
						<!-- <p style="font-family:'Free 3 of 9'; font-size: 24pt; line-height: 0.9;" class="unbold">*<?=$js_sel['nobill'];?>*</p>
						<p style="font-size: 10pt;" class="bold"><.?=$js_sel['nobill'];?></p> -->
						<div>Formulir</div>
						<div style="font-weight:bold;">3b KK 3</div>
						<div>BPJS Ketenagakerjaan</div>
					</td>
				</tr>
			</table>
			
			<table class="tbl_form1">
				<tr>
					<td></td>
					<td colspan=3>Dengan ini saya dokter yang memeriksa peserta BPJS Ketenagakerjaan dibawah ini:</td>
				</tr>
				<tr>
					<td></td>
					<td>Nama dokter</td>
					<td>:</td>
					<td>
						<span name="namaDokter" style="width:200px;display:inline-block;" class="uppercase"><?='aaa';?></span>
						<span>Dokter pemeriksa</span>
						<span>Dokter penasehat</span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>No. telepon/Hp</td>
					<!-- <.?=$js_sel['jeniskelamin'];?> -->
					<td>:</td>
					<td class="uppercase"><?='';?></td>
				</tr>
				<tr>
					<td></td>
					<td>Nama Fasilitas kesehatan</td>
					<td>:</td>
					<td class="uppercase"><?='';?></td>
				</tr>
			</table>
			
			Menerangkan dengan sesungguhnya bahwa:

			<table class="tbl_form1">
				<tr>
					<td>1. </td>
					<td>Nama Peserta</td>
					<td>:</td>
					<td class="uppercase"><?='';?></td>
				</tr>
				<tr>
					<td></td>
					<td>No. Peserta</td>
					<td>:</td>
					<td class="uppercase"><?='';?></td>
				</tr>
				<tr>
					<td></td>
					<td>NIK No. Paspor(WNA/PMI)</td>
					<td>:</td>
					<td class="uppercase"><?='';?></td>
				</tr>

				<tr>
					<td>2. </td>
					<td>Nama Pemberi Kerja/ Wadah/ Mitra/ Proyek Jasa Konstruksi</td>
					<td>:</td>
					<td class="uppercase"><?='';?></td>
				</tr>
				<tr>
					<td>3. </td>
					<td>Tanggal Kecelakaan</td>
					<td>:</td>
					<td><?='';?> ......../........./................ (dd/mm/yyyy)</td>
				</tr>
				<tr>
					<td>4. </td>
					<td>Tanggal pemeriksaan oleh dokter</td>
					<td>:</td>
					<td><?='';?> ......../........./................ (dd/mm/yyyy)</td>
				</tr>

				<tr>
					<td>5. </td>
					<td>Berdasarkan anamnesa</td>
					<td>:</td>
					<td class="uppercase">
						<textarea name="" id="" cols="30" rows="3" style="width:100%;"></textarea>
					</td>
				</tr>
				<tr>
					<td>6. </td>
					<td>Berdasarkan pemeriksaan fisik</td>
					<td>:</td>
					<td class="uppercase">
						<textarea name="" id="" cols="30" rows="4" style="width:100%;"></textarea>
					</td>
				</tr>
				<tr>
					<td>7. </td>
					<td>Penatalaksanaan atau tindakan medis yang diberikan</td>
					<td>:</td>
					<td class="uppercase">
						<textarea name="penatalaksana" id="" cols="30" rows="3" style="width:100%;"></textarea>
					</td>
				</tr>
				<tr>
					<td>8. </td>
					<td>Diagnosis</td>
					<td>:</td>
					<td class="uppercase"><?='';?></td>
				</tr>
				<tr>
					<td>9. </td>
					<td>Komorbiditas/komplikasi</td>
					<td>:</td>
					<td>
						<input type="radio" name="komorbid"> tidak ada
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="komorbid"> ada, sebutkan ..........
					</td>
				</tr>
				
				<tr>
					<td>10.</td>
					<td>Hasil pemeriksaan/pengobatan</td>
					<td>:</td>
					<td>
						<input type="radio" name="pemeriksaan"> Sembuh tanpa cacat <br>
						<input type="radio" name="pemeriksaan"> Cacat anatomis akibat kehilangan anggota badan ......... <br>
						<input type="radio" name="pemeriksaan"> Cacat fungsi pada anggota badan ......... <br>
						&emsp;  dengan besarnya cacat fungsi ......... %  terbilang (............) <br>
						<input type="radio" name="pemeriksaan"> Memerlukan prothesa berupa ......... <br>
						<input type="radio" name="pemeriksaan"> Memerlukan orthesa berupa ......... <br>
						<input type="radio" name="pemeriksaan"> Meninggal dunia tanggal : .............(dd/mm/yyyy) &emsp;  jam: ..........(hr:mn)
					</td>
				</tr>
				
				<tr>
					<td>11.</td>
					<td>Setelah sembuh peserta dapat melakukan pekerjaan</td>
					<td>:</td>
					<td>
						<input type="radio" name="levelKerja"> Biasa dengan kondisi tertentu berupa ................................. <br>
						<input type="radio" name="levelKerja"> Ringan dengan kondisi tertentu berupa ................................. <br>
						<input type="radio" name="levelKerja"> Tidak dapat bekerja
					</td>
				</tr>
				
				<tr>
					<td>12.</td>
					<td>Lamanya perawatan/pengobatan</td>
					<td>:</td>
					<td>dari tanggal:....................(dd/mm/yyyy) &emsp;&emsp; sd &emsp; tanggal:....................(dd/mm/yyyy) <br></td>
				</tr>
				
				<tr>
					<td>13.</td>
					<td>Diberikan istirahat</td>
					<td>:</td>
					<td>dari tanggal:....................(dd/mm/yyyy) &emsp;&emsp; sd &emsp; tanggal:....................(dd/mm/yyyy) <br></td>
				</tr>
				<tr>
					<td>14. </td>
					<td>Keterangan lainnya jika perlu</td>
					<td>:</td>
					<td class="uppercase">
						<textarea name="" id="" cols="30" rows="3" style="width:100%;"></textarea>
					</td>
				</tr>
				
			</table>

			<div style="text-align:center; border: 1px solid black;">
				Dengan ini saya menyatakan bahwa data dan keterangan yang saya sampaikan kepada BPJS Ketenagakerjaan adalah benar.
				Apabila data yang diberikan tidak benar, saya bersedia bertanggung jawab sesuai peraturan perundangan yang berlaku.
			</div>

			<!-- <input type="radio" id="html" name="fav_language" value="HTML">
<label for="html">HTML</label><br>
<input type="radio" id="css" name="fav_language" value="CSS">
<label for="css">CSS</label><br>
<input type="radio" id="javascript" name="fav_language" value="JavaScript">
<label for="javascript">JavaScript</label> -->

			
		</div>

		<table>
			<tr>
				<td width="320px">
					<br>
					<span>Keterangan:</span><br>
					<span>Laporan ini diperuntukkna :</span><br>
					<span>- Lembar pertama : BPJS Ketenagakerjaan</span><br>
					<span>- Lembar kedua : Dinas Tenaga Kerja Setempat</span><br>
					<span>- Lembar ketiga : Pusat Layanan Kecelakaan Kerja</span><br>
					<span>- Lembar keempat : Perusahaan</span><br>
				</td>
				<td>
					<div>Kota/Kab : </div>
					<div>Tanggal</div>
					<br><br>
					<div>______________________(tanda tangan dan stempel fasilitas kesehatan)</div>
					<div>Nama</div>
				</td>
			</tr>
		</table>


		<!-- <div class="row" style="padding-top:0px; font-weight: normal; vertical-align:top;">
			<div class="col-md-5 ft_size_note">
				<br>
				<span>Keterangan:</span><br>
				<span>Laporan ini diperuntukkna :</span><br>
				<span>- Lembar pertama : BPJS Ketenagakerjaan</span><br>
				<span>- Lembar kedua : Dinas Tenaga Kerja Setempat</span><br>
				<span>- Lembar ketiga : Pusat Layanan Kecelakaan Kerja</span><br>
				<span>- Lembar keempat : Perusahaan</span><br>
			</div>

			<div class="col-md-7">
				<div>Kota/Kab : </div>
				<div>Tanggal</div>
				<br><br>
				<div>______________________(tanda tangan dan stempel fasilitas kesehatan)</div>
				<div>Nama</div>
			</div>
		</div> -->


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
		


	});

	</script>





</body>
</html>