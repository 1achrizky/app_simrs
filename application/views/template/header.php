<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<link rel="shortcut icon" href="<?=base_url();?>assets/img/rscm/LOGO RSCM MINI.png" />
	<title>Pendaftaran Mandiri RS Citra Medika</title>

	<!-- 
	<link href="<>?=base_url();?>assets/plugin/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	 -->

	<link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap.min.css">
	


	<!-- 
	JQUERY HARUS DI LOAD DULU DARIPADA BOOTSTRAP, SUPAYA MODAL BISA JALAN. 
	Modal butuh: 
	[1] 3.3.7/css/bootstrap.min.css
	[2] jquery-3.2.1.min.js (sembarang)
	[3] 3.3.7/js/bootstrap.min.js
	-->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/css/bootstrap.min.css">
	<!-- 
	<script src="<>?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>	
	<script src="<>?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/js/bootstrap.min.js"></script>
	 -->
	
	 
<!--  [Kelengkapan Modal]
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script src="<>?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	 -->
	

	<link rel="stylesheet" href="<?=base_url();?>assets/css/site.css" type="text/css">
	<link rel="stylesheet" href="<?=base_url();?>assets/plugin/jquery-ui-1.12.1/jquery-ui.css">
	
</head>

<body class="site-bg" data-user_logged_in="<?=$username;?>" data-baseurl="<?=base_url();?>">
	<!-- Navbar -->
	<div class="navbar navbar-default" style="" role="navigation">
	  <div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	      <span class="sr-only">Toggle navigation</span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	    </button>
	    <!-- <a class="navbar-brand" href="#" onclick="history.go(-1)">RS Citra Medika</a> -->
	    <a class="navbar-brand" href="<?=base_url();?>">RS Citra Medika</a>
	  </div>


	  <div class="navbar-collapse collapse">

	    <!-- Left nav -->
	    <ul class="nav navbar-nav">
	      <li><a href="<?=base_url();?>">Home</a></li>

	      <li><a href="#">Layanan<span class="caret"></span></a>
	        <ul class="dropdown-menu">
	          <li><a href="#">Rawat Jalan <span class="caret"></span></a>
	            <ul class="dropdown-menu">
								<li><a href="#">Pendaftaran <span class="caret"></span></a>
												<ul class="dropdown-menu">
										<!-- <li><a href="<.?=base_url('daftarmandiri/daftaronline');?>">Booking(Online)</a></li> -->
										<li><a href="<?=base_url('daftarmandiri/admin');?>">Pendaftaran RJ</a></li>
									</ul>
								</li>
								<li><a href="#">Laporan <span class="caret"></span></a>
												<ul class="dropdown-menu">
										<li><a href="<?=base_url('daftarmandiri/booking');?>">Booking</a></li>
										<!-- <li><a href="<..?=base_url('daftarmandiri/daftar_pasienrj');?>">Pendaftaran RJ</a></li> -->
										<li><a href="<?=base_url('daftarmandiri/log_pendaftaranrj');?>">Log Pendaftaran</a></li>
									</ul>
								</li>
	            </ul>
	          </li>
	        </ul>
	      </li>

	      <!-- <li><a href="#">RSCM Klaim<span class="caret"></span></a>
	        <ul class="dropdown-menu">
	          <li><a href="index.php">Home</a></li>
	          <li><a href="klaimPull.php">Lihat Data Klaim</a></li>

	          <li class="divider"></li>
	          <li class="dropdown-header">Nav header</li>

	          <li><a href="dokter.php">Data Dokter</a></li>
	          <li><a href="user.php">Data User</a></li>
	        </ul>
	      </li> -->

	      <li><a href="#">VClaim<span class="caret"></span></a>
	        <ul class="dropdown-menu">
	        	<li><a href="<?=base_url('vclaim');?>">Menu SEP</a></li>
				<!-- <li><a href="ref-diag.php">Ref Diagnosa</a></li>
				<li><a href="peserta.php">Peserta</a></li>
				<li><a href="rujukan-cek.php">Rujukan</a></li> -->

				<li class="divider"></li>
				<!-- <li class="dropdown-header">TOT_1.1</li> -->
				<li><a href="#">TOT_1.1 <span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><a href="<?=base_url('vclaim/sep_create_11');?>">Menu SEP_1.1(tes)</a></li>
					  <li><a href="<?=base_url('vclaim/tes_katalog_bpjs');?>">Tes Katalog BPJS</a></li>
					</ul>
				</li>
				
	        </ul>
	      </li>

	      <li><a href="#">Support<span class="caret"></span></a>
	        <ul class="dropdown-menu">
	          <li><a href="#">IT<span class="caret"></span></a>
	            <ul class="dropdown-menu">
	              <li><a href="<?=base_url('it_support/tindakan_hapus');?>">Hapus Tindakan</a></li>
	              <li><a href="<?=base_url('daftarmandiri/admin');?>">Hapus Kamar</a></li>
	              <li><a href="<?=base_url('it_support/ganti_penanggung');?>">Ganti Penanggung</a></li>
	              <li><a href="<?=base_url('it_support/transfer_obat_tindakan');?>">Transfer Obat/Tindakan</a></li>
	              <li><a href="<?=base_url('it_support/data_pasien_by_alamat');?>">Data Pasien(by Alamat)</a></li>
	              <li><a href="<?=base_url('it_support/upload_data_billboard');?>">Upload Data Billboard</a></li>
	              <li><a href="<?=base_url('it_support/cek_pegawai_tidak_absen');?>">HRD - Cek Pegawai Tidak Absen</a></li>
	            </ul>
	          </li>
	        </ul>
	      </li>

			<li><a href="#">Setting<span class="caret"></span></a>
				<ul class="dropdown-menu">
				 	<li><a href="<?=base_url('setting/printer');?>">Printer</a></li>
				</ul>
			</li>

	    </ul>

	    <!-- Right nav -->
	    <ul class="nav navbar-nav navbar-right">
	      <li><h3 style="margin:10px auto;"><span class="label label-primary"><?=$username;?></span></h3></li>
	      <li><a href="<?=base_url('user/logout')?>" style="padding: 10px;"><button class="btn btn-danger">Logout</button></a></li>
	      
	    </ul>

	  </div><!--/.nav-collapse -->
	</div>