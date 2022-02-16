<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Jadwal Dokter - <?=date('m-Y');?></title>

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

	</style>

</head>
<body>

	
	
	<div class="container" style="width: 800px; ">
		<div class="ft_normal" style="font-size: 10pt; margin-top: 20px;">
			<div>
				<img src="<?=base_url();?>/assets/img/LOGO RSCM BARU - tepi putih tipisRiz.png" alt="" style="width:150px;">
				<!-- <span style="float: right;"><.?=$NoBill;?></span> -->
				<div class="bold" style="text-align:center; font-size: 14pt;">JADWAL PRAKTEK KLINIK DOKTER SPESIALIS</div> 
			</div>
			<div>
						<table id="li_jadok" border=1 style="width:100%;">
							<thead>
								<tr>
									<th>Hari</th>
									<th>Poli Spesialis</th>
									<th>Nama Dokter</th>
									<th>Jam Praktek</th>
									<!-- <th>Opsi</th> -->
								</tr>
							</thead>
							<tbody>
								<?php
									//echo "<pre>",print_r( json_decode($_POST['jadok_tampil'], 1) ),"</pre>"; 
									// $jadok_tampil = json_decode($_POST['jadok_tampil'], 1);
									$jadok_tampil = $db['jadok_tampil'];
									$el = '';
									$hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
									$chari = [0, 0, 0, 0, 0, 0];
										

									for ($i=0; $i < count($jadok_tampil); $i++) { 
										for ($h=0; $h < count($hari); $h++) { 
											if($jadok_tampil[$i]['hari'] == $hari[$h]) $chari[$h]++;
										}
									}
									// $chari = [17, 17, 18, 18, 15, 9];


									$rspan = [0, 0, 0, 0, 0, 0];
									for ($r=0; $r < count($chari); $r++) { 
										// for ($s=0; $s <= $r; $s++) { 
										for ($s=0; $s < $r; $s++) { 
											$rspan[$r] += $chari[$s];
										}
									}


									$c = 0;
									$rowspan = '';
									for ($i=0; $i < count($jadok_tampil); $i++) { 
										
										if(in_array($i, $rspan)) {
											$rowspan = '<td rowspan="'.$chari[$c].'">'.$jadok_tampil[$i]['hari'].'</td>';
											$c++;                            
										}else{
											$rowspan = '';
										}

										$el .= '<tr>'
												.$rowspan
												// .'<td>'.$i.'</td>'
												.'<td>'.$jadok_tampil[$i]['Spesialis'].'</td>'
												.'<td>'.$jadok_tampil[$i]['Nama'].'</td>'
												.'<td>'.$jadok_tampil[$i]['jamMasuk'].' - '.$jadok_tampil[$i]['jamPulang'].'</td>'
												// .'<td style="text-align:center;"><button class="btn_del btn-danger" data-id="'.$jadok_tampil[$i]['Id'].'" style="margin:2px auto;">x</button></td>'
											.'</tr>';
																		
									}
									echo $el;
								?>
							</tbody>
						</table>
      </div>

      
      <div>
				<span class="">Dicetak pada: <?=date('H:i:s d-m-Y');?></span>
				<span class=""><?//=$user;?></span>
			</div>

			
			<?php exit;?>
			

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