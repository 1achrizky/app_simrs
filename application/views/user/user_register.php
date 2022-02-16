<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registrasi User</title>

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
<body>

	<div class="container">
		<div class="row">
			<legend><center><h2><b>Registrasi Pengguna Aplikasi</b></h2></center></legend>
		</div>
		
		<!-- bisa  -->
		<?=form_open(base_url()."ajaxreq/tambah_user","name='tambah_user'");?>
		<!-- <.?=form_open(base_url()."user/register","name='tambah_user'");?> -->
		<!-- <.?=form_open(base_url()."user/register");?> -->
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
			    	<div class="row">
			    		<div class="col-md-6">
								<div class="input-group">
								  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								  <input type="text" name="noreg" class="form-control" placeholder="no.pegawai..." required>
						    </div>
			    		</div>
			    		<div class="col-md-6">
			    			<select class="form-control" name="level">
							    <option value="">-Level Pengguna-</option>
							    <option value="Staff">Staff</option>
							    <option value="Kanit">Kanit</option>
							  </select>
			    		</div>
			    	</div>
				</div>
				<div class="input-group form-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" name="username" class="form-control" placeholder="username..." required>
		    	</div>
			    <div class="input-group form-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="password" name="password" class="form-control" placeholder="password..." required>
			    </div>
		    
		    
				<input type="submit" name="submit_tambah_user" class="btn btn-success btn-block" value="Tambah User">
			</div>
		</div>
		<?=form_close();?>

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
	<!-- <script src="<?=base_url();?>assets/js/jquery-3.2.1.min.js"></script> -->
	<!-- <script src="<?=base_url();?>assets/plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
	<script src="<?=base_url();?>assets/plugin/jquery.smartmenus/1.1.0/jquery.smartmenus.js"></script>
	<script src="<?=base_url();?>assets/plugin/jquery.smartmenus/1.1.0/addons/bootstrap/jquery.smartmenus.bootstrap.js"></script>


 	<script type='text/javascript' src="<?=base_url();?>assets/js/library.js"></script>
	<script type='text/javascript' src="<?=base_url();?>assets/js/site.js"></script>
</body>
</html>