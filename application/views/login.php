<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>

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
</head>
<?php
$my_ip = my_ip();
// print_r($my_ip);
?>
<body data-baseurl="<?=base_url();?>">
	<input type="hidden" name="ip_server" value="<?=$my_ip['server'];?>">
	<input type="hidden" name="ip_client" value="<?=$my_ip['client'];?>">

	<div class="container">
		<div class="row">
			<legend><center><h2><b>Login Aplikasi</b></h2></center></legend>
		</div>

		<!-- <form action="<.?=base_url('user/login');?>" method="POST"> -->
		<form action="<?=base_url('user_xlink/login');?>" method="POST">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="input-group form-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" name="username" class="form-control" placeholder="username..." autocomplete="off" required>
				    </div>
				    <div class="input-group form-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" name="password" class="form-control" placeholder="password..." autocomplete="off" required>
				    </div>
			    
					<input type="submit" name="submit_login" class="btn btn-primary btn-block" value="LOGIN">
					<!-- <button class="btn btn-success btn-block">TAMU</button> -->
					<a class="btn btn-success btn-block" href="<?=base_url('user/login_tamu');?>">TAMU</a>

					<?php
					if(my_ip()["client"]!="192.168.1.98" && my_ip()["client"]!="192.168.1.104"){
					?>
					<a class="btn btn-warning btn-block" href="<?=base_url('daftarmandiri/daftaronline');?>">PASIEN</a>
					<?php } ?>
				</div>
			</div>
		</form>
		<?//=form_close();?>

	</div>
		


	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/bootstrap.bundle.min.js"></script><!-- INCLUDE POPPER.JS , BOOTSTRAP-4 -->
	<script type='text/javascript' src="<?=base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
  <script type='text/javascript' src="<?=base_url();?>assets/js/jquery.xdomainrequest.min.js"></script>
  <script type='text/javascript' src="<?=base_url();?>assets/js/moment-with-locales.js"></script>  
  <script type='text/javascript' src="<?=base_url();?>assets/js/jQuery.print.js"></script>
	
	<!-- UNTUK MODAL -->
	<script src="<?=base_url();?>assets/plugin/bootstrap/3.3.7-dist/js/bootstrap.min.js"></script>

	<!-- UNTUK NAV MENU > hover dropdown -->
	<!-- <script src="<.?=base_url();?>assets/js/jquery-3.2.1.min.js"></script> -->
	<!-- <script src="<.?=base_url();?>assets/plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
	<script src="<?=base_url();?>assets/plugin/jquery.smartmenus/1.1.0/jquery.smartmenus.js"></script>
	<script src="<?=base_url();?>assets/plugin/jquery.smartmenus/1.1.0/addons/bootstrap/jquery.smartmenus.bootstrap.js"></script>
	
	<script type="text/javascript" src="<?=base_url();?>assets/plugin/lte/else/jquery.redirect.js"></script>


 	<script type='text/javascript' src="<?=base_url();?>assets/js/library.js"></script>
	<!-- <script type='text/javascript' src="<.?=base_url();?>assets/js/site.js"></script> -->
	<script type='text/javascript' src="<?=base_url();?>assets/js/site_lte.js"></script>
</body>
</html>