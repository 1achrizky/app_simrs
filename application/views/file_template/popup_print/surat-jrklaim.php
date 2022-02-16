<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Surat Klaim JR - RS Citra Medika</title>

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	<!-- <link rel="stylesheet" href="<>?=base_url();?>assets/css/style.css" type="text/css">  -->
	
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/site.css" type="text/css">
	<style type="text/css">
		.bold{ font-weight:bold; }
		.barcode{
			font-family:'Free 3 of 9';
			font-size: 18pt;
			line-height: 0.9;
		}
		hr{
			margin:0px 0px; 
			width:100%;
			height:2px;
			color:#333;background-color:#333;
		}

		.justify{
			text-align:justify;
		}

	</style>

</head>
<body>
	<div class="container" style="width: 800px; ">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 20px;">

			
			<div class="justify">
				<img src="<?=base_url();?>assets/img/jr-logo.png" alt="">
				<div>Jakarta, 
					<?=($verifDate!=null)? date('d/m/Y', strtotime($verifDate) ): '';?>
				</div>
				<br>				

				<table>
					<tr><td></td><td></td></tr>
					<tr><td>Nomor</td><td> : <?=$noSurat;?></td></tr>
					<tr><td>Sifat</td><td> : Penting</td></tr>
					<tr><td>Lampiran</td><td> : <?=$lampiran;?></td></tr>
					<tr><td>Hal</td><td> : Jaminan Santunan Jasa Raharja a.n. Sdr/i <?=$namapx;?></td></tr>
				</table>

				<br>
				Yth. Direktur RS CITRA MEDIKA, KAB.<br>
				SIDOARJO
				<br><br>

				Berdasarkan ketentuan Undang-Undang No. 34 tahun 1964 jo. Peraturan Pemerintah No. 18 tahun 1965,
				dengan surat ini PT. Jasa Raharja (Persero) memberikan jaminan pembayaran santunan biaya perawatan dan pengobatan untuk pasien korban kecelakaan lalu
				lintas yang dirawat di Rumah Sakit Saudara, sebagai berikut :
				<br><br>

				<table>				
					<tr><td>Nama/jenis kelamin/umur</td><td> : <?=$namapx;?> / <?=$gender;?> / <?=$usia;?></td></tr>
					<tr><td>Tempat/tgl kecelakaan</td><td> : <?=date('d/m/Y', strtotime($tglLaka) );?></td></tr>
					<tr><td>Tanggal Mulai Dirawat</td><td> : <?=date('d/m/Y', strtotime($tglMasuk) );?></td></tr>
					<tr><td>Alamat Korban</td><td> : <?=$alamat;?></td></tr>
				</table>

				<br>
				Biaya yang kami jamin pembayarannya adalah : <br><br>
				a. Biaya Ambulans dari TKP ke Rumah Sakit paling banyak <?=rupiah($biayaAmbulanVerif, 1);?> <br>
				b. Biaya Pertolongan Pertama Pada Kecelakaan (P3K) di IGD/UGD paling banyak <?=rupiah($biayaP3KVerif, 1);?> <br>
				c. Biaya Perawatan dan pengobatan paling banyak <?=rupiah($biayaPerawatanVerif, 1);?> <br>
				
				<br>
				Rumah Sakit berhak untuk menagih biaya perawatan dan pengobatan pasien tersebut di atas kepada PT. Jasa Raharja (Persero)
				dengan syarat dan ketentuan sebagai berikut : <br><br>
			

					<ol style="padding-left:15px;" class="justify">
						<li>Penagihan didasarkan kepada Surat Pernyataan dan Kuasa, sesuai format terlampir, yang ditandatangani pihak korban dengan 
							diketahui oleh Petugas PT Jasa Raharja (Persero)</li>
						<li>Penagihan harus segera dilaksanakan setelah pasien pulang dengan kelengkapan dokumen : 
							<ol type="a" style="padding-left:15px;">
								<li>Asli kuitansi biaya perawatan dan pengobatan (bermaterai sesuai ketentuan) berikut lampiran perincian biaya, tindakan, bahan/alat kesehatan,
								obat-obatan dan sebagainya, secara lengkap.</li>
								<li>Keterangan kesehatan korban akibat kecelakaan pada formulir terlampir.</li>
								<li>Surat pengantar tagihan sebagaimana contoh format terlampir.</li>
							</ol>
						</li>
						<li>Saudara beserta seluruh jajaran Rumah Sakit bersedia memberikan keterangan dan catatan-catatan (termasuk catatan medis) yang
							diperlukan oleh PT. Jasa Raharja dalam rangka proses penelitian keabsahan pengajuan tagihan biaya perawatan dan pengobatan tersebut.</li>
					</ol>
							
				
				Apabila memerlukan penjelasan lebih lanjut, Saudara dapat menghubungi PT. Jasa Raharja (Persero) CABANG JAWA TIMUR. 
				Atas Perhatian dan kerjasama Saudara kami ucapkan terima kasih.

				<br><br><br>
				CABANG JAWA TIMUR
				<br><br>
				DICKY SYIWA PERMADI <br>
				KEPALA BAGIAN
				
				
				<br><br>
				Tembusan : <br>
				1. Kepala BPJS Kesehatan <br>
				2. Korban a.n. <?=$namapx;?>
			
			</div>
			

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



</body>
</html>