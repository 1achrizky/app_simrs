<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pendaftaran Mandiri RS Citra Medika</title>

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<!-- <link rel="stylesheet" href="<>?=base_url();?>assets/css/style.css" type="text/css">  -->
	
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/site.css" type="text/css">
	<style type="text/css">
		


	</style>

</head>
<body>

	<!-- <.?="<pre>",print_r($js_sel),"</pre>";?>
	<.?="<pre>",print_r($peserta_cari),"</pre>";?>
	<.?="<pre>",print_r($js_sep),"</pre>";?> -->

	<div class="container row font_cetak kertas_A4" name="main">
		<div style="clear:left; height:20px;"></div>
		<div id="kertas_resume" class="row ft_normal" style="font-size: 10pt;">
			<table name="" border=1>
				<tr>
					<td class="col-xs-3">
						<img src="<?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;">
					</td>
					<td class="col-xs-4 text_center bold" style="font-size: 12pt;">RESUME RAWAT JALAN</td>
					<td class="col-xs-5" style="text-align: center;">
						<p style="font-family:'Free 3 of 9'; font-size: 24pt; line-height: 0.9;" class="unbold">*<?=$js_sel['nobill'];?>*</p>
						<p style="font-size: 10pt;" class="bold"><?=$js_sel['nobill'];?></p>

					</td>
				</tr>
			</table>
			
			<table name="" border=1>
				<tr>
					<td class="col-xs-2">Nama Pasien</td>
					<td class="col-xs-4 uppercase"><?=$js_sel['nama'];?></td>
					<td class="col-xs-2">No.RM</td>
					<td class="col-xs-4 text_center"><span class="bold" style="font-size: 18pt;"><?=$js_sel['norm'];?></span></td>
				</tr>
				<tr>
					<td class="col-xs-2">Tgl.Lahir / JK</td>
					<td class="col-xs-4"><?=$js_sel['tgllahir'];?> / <?=$js_sel['jeniskelamin'];?></td>
					<td class="col-xs-2">Tgl.Masuk</td>
					<td class="col-xs-4"><?=$js_sep['response']['tglSep'];?></td>
				</tr>
				<tr>
					<td class="col-xs-2">Umur</td>
					<td class="col-xs-4"><?=$js_sel['umur'];?></td>
					<td class="col-xs-2">Tgl.Keluar</td>
					<td class="col-xs-4"><span><?=$js_sep['response']['tglSep'];?></span></td>
				</tr>
				<tr>
					<td class="col-xs-2" rowspan="2">Alamat</td>
					<td class="col-xs-4" rowspan="2"><?=$js_sel['alamat'];?></td>
					<td class="col-xs-2">Lokasi</td>
					<td class="col-xs-4"><?=$js_sel['lokasi'];?> / <?=$js_sel['nourut'];?></td>
				</tr>
				<tr>
					<td class="col-xs-2">Penanggung</td>
					<td class="col-xs-4"><?=$js_sel['penanggung_ket'];?></td>
					<!-- <td class="col-xs-4">BPJS</td> -->
				</tr>
			</table>


			<table name="part_3" border=1">
				<tr>
					<td class="col-xs-3">Ringkasan Riwayat Penyakit</td>
					<td class="col-xs-9"><span name="riwayat"></span></td>
				</tr>
				<tr>
					<td class="col-xs-3">Pemeriksaan Fisik</td>
					<td class="col-xs-9"><span name="fisik"></span></td>
				</tr>
				<tr>
					<td class="col-xs-3">Pemeriksaan Penunjang/ Diagnostik terpenting</td>
					<td class="col-xs-9"><span name="penunjang"></span></td>
				</tr>
				<tr>
					<td class="col-xs-3">Terapi/Pengobatan Selama di rumah sakit</td>
					<td class="col-xs-9"><span name="terapi"></span></td>
				</tr>
			</table>

			<table name="part_4" border=1">
				<tr>
					<td class="col-xs-3">Diagnosis Utama</td>
					<td class="col-xs-5"><span name=""></span></td>
					<td class="col-xs-2">ICD 10</td>
					<td class="col-xs-2"><span name=""></span></td>
				</tr>
				<tr>
					<td class="col-xs-3">Diagnosis Sekunder</td>
					<td class="col-xs-5">
						1. <span name=""></span><br>
						2. <span name=""></span><br>
					</td>
					<td class="col-xs-2">ICD 10</td>
					<td class="col-xs-2">
						1. <span name=""></span><br>
						2. <span name=""></span><br>
					</td>
				</tr>
				<tr>
					<td class="col-xs-3">Tindakan/Prosedur</td>
					<td class="col-xs-5">
						1. <span name=""></span><br>
						2. <span name=""></span><br>
						3. <span name=""></span><br>
					</td>
					<td class="col-xs-2">ICD 9 CM</td>
					<td class="col-xs-2">
						1. <span name=""></span><br>
						2. <span name=""></span><br>
						3. <span name=""></span><br>
					</td>
				</tr>
			</table>

			<div name="part_5" class="border" style="overflow:hidden;">
				<div style="padding: 0px 15px;">Tanggal kontrol poliklinik : </div>			

				<div name="part_6" style="overflow:hidden;">
					<span class="col-xs-6"></span>
					<span class="col-xs-6">
						<p>Sidoarjo, <span> <?= date_format(date_create_from_format('Y-m-d', $js_sep['response']['tglSep']), 'd-m-Y'); ?> </span></p>
						<p>Dokter Penanggung Jawab Pelayanan</p>
						<br>
						<br>
						<?php
							// if($lokasi_ket == 'U G D'){
							if($js_sel['lokasi'] == 'I G D'){
								$js_sel['dokter_nama'] = ' ';
							}
						?>
						<p><?=$js_sel['dokter_nama'];?></p>
						<hr style="margin:0px; border-width: 1px; border-color: #000;">
						<p class="italic">Tanda tangan &amp; Nama lengkap</p>
					</span>
					<!-- 
					<div style="padding: 0px 15px;">
						<span class="col-xs-4 bold">Lembar 1 : Pasien</span>
						<span class="col-xs-4 bold">Lembar 2 : Rekam Medis</span>
						<span class="col-xs-4 bold">Lembar 3 : Penjamin</span>
					</div> -->
				</div>

			</div>
			<p class="italic justify" style="margin:0px 20px 0px; font-size: 8pt;">MOHON UNTUK TIDAK MENGGUNAKAN SINGKATAN DALAM PENULISAN DIAGNOSA DAN TINDAKAN SERTA DITULIS DENGAN RAPIH</p>
			

			
		</div>

		<div style="clear:left; height:5px;"></div>
		<hr class="hr_potong_kertas">


		<div class="kertas_sep" style="font-size: 7pt;">
			<div class="row" style="overflow: hidden; margin-bottom: 10px;">
				<div class="col-xs-3">
					<img src="<?=base_url();?>/assets/img/bpjs-logo.png" alt="" class="bpjs_logo" style="width:150px;">
				</div>
				<div class="col-xs-4" style="padding: 0px; font-size: 10pt;">
					<span>SURAT ELEGIBILITAS PESERTA</span><br>
					<span>RS Citra Medika</span>
				</div>
				<div class="col-xs-5" style="height: 30px; line-height: 0.8;">
					<span style="font-family:'Free 3 of 9'; font-size: 26pt;" class="unbold">*<?=strtoupper($js_sel['nosep']);?>*</span>
				</div>
				
			</div>
			
			<div class="col-xs-12">
				<table name="sep1" class="ft_normal" border=0 width="100%">
					<tr>
						<td>No.SEP</td>
						<td style="font-size: 14pt;">: <?=strtoupper($js_sel['nosep']);?></td>
						<td>Prolanis PRB</td>
						<td>: <span style="font-size: 16pt; font-weight: bold;"><?=$peserta_cari['response']['peserta']['informasi']['prolanisPRB'];?></span> </td>
					</tr>
					<tr>
						<td width="10%">Tgl.SEP</td>
						<td width="40%">: &ensp;<?=$js_sep['response']['tglSep'];?></td>
						<td>Peserta</td>
						<td>: &ensp;<?=$js_sep['response']['peserta']['jnsPeserta'];?></td>
					</tr>
					<tr>
						<td>No.Kartu</td>
						<td>: &ensp;<?=$js_sel['noka'];?></td>
						<td>COB</td>
						<td>: &ensp;<?=$js_sep['response']['peserta']['asuransi'];?></td>
					</tr>
					<tr>
						<td>Nama Peserta</td>
						<td class="uppercase">: &ensp;<?=$js_sep['response']['peserta']['nama'];?></td>
						<td>Jns.Rawat</td>
						<td>: &ensp;<?=$js_sep['response']['jnsPelayanan'];?></td>
					</tr>
					<tr>
						<td>Tgl.Lahir</td>
						<td>: &ensp;<?=$js_sep['response']['peserta']['tglLahir'];?></td>
						<td>Kls.Rawat</td>
						<td>: &ensp;<?=$js_sep['response']['kelasRawat'];?></td>
					</tr>
					<tr>
						<td>No.Telepon</td>
						<td>: &ensp;<?=$peserta_cari['response']['peserta']['mr']['noTelepon'];?></td>						
						<td>Penjamin</td>
						<td>: &ensp;<?=$js_sep['response']['penjamin'];?></td>
					</tr>
					<tr>
						<td>Poli Tujuan</td>
						<td>: &ensp;<?=$js_sep['response']['poli'];?></td>
					</tr>
					<tr>
						<td>Faskes Perujuk</td>
						<td colspan="3">: &ensp;<?=$js_sel['asalPPK'];?></td>
					</tr>
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan="3">: &ensp;<?=$js_sep['response']['diagnosa'];?></td>
					</tr>
					<tr>
						<td>Catatan</td>
						<td colspan="3">: &ensp;<?=$js_sep['response']['catatan'];?></td>
					</tr>
					
				</table>
				
			</div>


			<div style="clear:left; padding-top:20px; font-weight: normal;">
				<div class="col-xs-8">
					<span class="ft_size_note">*Saya menyetujui BPJS Kesehatan menggunakan informasi medis pasien jika diperlukan.</span><br>
					<span class="ft_size_note">SEP Bukan sebagai bukti penjamin peserta.</span>
					<br><br>
					<span class="ft_size_note">Cetakan .....</span>
				</div>

				<div class="col-xs-4">
					<div class="text_center">Pasien/Keluarga Pasien</div>
					<br><br>
					<div class="text_center">______________________</div>
				</div>
			</div>
			
		</div>

		<!-- <div style="clear:left; height:20px;"></div> -->

				<!-- 
				<button class="btn btn-primary" name="btnOpen" data-toggle="modal" data-target="#modal_klinik"> Modal OPen </button> -->
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