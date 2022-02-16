<?php mysql_connect("192.168.1.5","root","root"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RS. Citra Medika</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  	<style>
	.container{
		margin:0px auto;
		padding: 0px;
		background: #e8fff1;
	}
	.jumbotron{
		//display: block;
		padding-left: 0px;
		padding-right: 0px;
		text-align: center;
	}
	.container-poli{
		margin: 0px auto 0px;
		width:100%;
		padding:0px;
		//border:solid 1px black;
		overflow: auto;
		//text-align: center;

		display:grid;
		//grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
		grid-template-columns:repeat(auto-fill,minmax(130px,1fr));
		justify-items: center;
		grid-gap: 5px;
		grid-row-gap: 0px;

	}
	.obyek{
		//height:150px;
		//overflow: auto;
		width:130px;
		///width:100%;
		background:yellow;
		float: left;
		margin:5px;
		//border:solid 1px black;
		border-radius: 5px;

		-webkit-box-shadow: 0 4px 6px rgba(0, 0, 0, .3);
		-moz-box-shadow: 0 4px 6px rgba(0,0,0,.3);
		box-shadow: 0 4px 6px rgba(0,0,0,.3);
		-webkit-transition: all .15s linear;
		-moz-transition: all .15s linear;
		//transition: all .15s linear;
		z-index:0;

	}
	.obyek:hover{
		background: lightblue;
	}

	.obyek img{
		display: block;
		height: 100px;
		text-align: center;
		margin:3px auto 5px;
	}
	.obyek-title{
		height: 60px;
		/*margin:0px auto 0;*/
		margin:0px;
		//background: #edf3ff;
		color: #191919;
		font-weight: bold;
		font-size: 10pt;
		//display: block;

		position: relative;
  		//top: 50%;
  		//transform: translateY(-50%);
	}
	.obyek-title span{
		display: inline-block;
		vertical-align: middle;

		position: relative;
  		top: 50%;
  		transform: translateY(-50%);
	}
	
	.polaroid-images a:after {
		color: #333;
		//font-size: 20px;
		font-size: 11pt;
		font-weight:bold;
		content: attr(title);
		position: relative;
		top:5px;
	}

	.polaroid-images img { 
		display: block; 
		//width: inherit; 
		height: 100px; 
	}
	.polaroid-images a{
		background: white;
		display: inline;
		float: left;
		margin: 0 15px 30px;
		padding: 5px 5px 15px;
		text-align: center;
		text-decoration: none;
		-webkit-box-shadow: 0 4px 6px rgba(0, 0, 0, .3);
		-moz-box-shadow: 0 4px 6px rgba(0,0,0,.3);
		box-shadow: 0 4px 6px rgba(0,0,0,.3);
		-webkit-transition: all .15s linear;
		-moz-transition: all .15s linear;
		transition: all .15s linear;
		z-index:0;
	    position:relative;

	}

	</style>

  <script>
	$(document).ready(function(){
		/*
	    $("p").click(function(){
	        $(this).hide();
	    });*/
	    //var pilihPoli = $(this).text();
		var getUrl = window.location;
		var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+ "/" + getUrl.pathname.split('/')[2]+ "/" + getUrl.pathname.split('/')[3]+ "/" + getUrl.pathname.split('/')[4]+ "/";
	    $(".obyek").click(function(){
	    	var namaPoli = $(this).attr("id"); 
	    	//var namaPoli = $(this+" .obyek-title").text(); 
	    	alert(namaPoli);
	    	window.location = baseUrl+"peserta.php#"+namaPoli;

	    });
	    /*
	    $.ajax({
	    	url:"assets/json/spesialis.json",
	    	dataType:"json",
	    	type: "get",
	    	cache: false,
	    	success: function(data){
	    		var textHtml;
	    		$(data.spesialis).each(function(index,value){
	    			//console.log(value);
	    			//console.log(value.id +" dan "+index);
	    			//console.log(value.id +" dan "+index[1].label);
	    			textHtml = "<div class='obyek' id='"+value.id+"'>";
	    			textHtml += 	"<div class='obyek-title'><span>"+value.label+"</span></div>";
	    			textHtml += 	"<img src='assets/img/icon-spesialis/tes/"+value.label+".png' alt='"+value.label+"' />";
	    			textHtml += "</div>";
	    			//$("").append("<div class='obyek' id='"+value.id+"'>"++"</div>");
	    			//alert(textHtml);
	    			$("div.container-poli").append(textHtml);
	    		});
	    	}
	    });*/
	});
</script>
</head>
<body>
  <div class="jumbotron">
  	
	<h4>Pendaftaran Pasien Online</h4>      
	<p>Rumah Sakit Citra Medika</p>
	<div class="container-poli">
		<!--
		<div class='obyek' id='spesialis'>
			<div class='obyek-title'>Spesialis</div>
			<img src='img/klinik penyakit dalam.png'/>
		</div>
		-->
		<?php
		
			mysql_select_db("xlink");
			$query = "SELECT Kode,Keterangan from fomstlokasi where Kode>=20 AND Kode<=36";
			if($data= mysql_query($query)){
				while($row = mysql_fetch_array($data)){
					echo "<div class='obyek' id='".$row['Kode']."#".$row['Keterangan']."'>";
					echo "	<div class='obyek-title'><span>".$row['Keterangan']."</span></div>";
					echo "	<img src='assets/img/icon-spesialis/tes/".$row['Keterangan'].".png' alt='".$row['Keterangan']."' />";
					echo "</div>";
				}
			}else{
				//echo mysql_error();
				echo "<div class='obyek' id='Kode#Keterangan>";
				echo "	<div class='obyek-title'>SPESIALIS BEDAH</div>";
				echo "	<img src='assets/img/icon-spesialis/tes/SPESIALIS BEDAH.png' alt='SPESIALIS BEDAH' />";
				echo "</div>";
			}
			
		?>

	</div>
  </div>

	<?php include "menu.php";?>
	<!--
	<div class="polaroid-images">
		<a href="" title="Cave">
			<img height="200" src="img/klinik penyakit dalam.png" alt="Cave" title="Cave"/>
		</a>
		
	</div>
-->

	<?php
	/*
			mysql_select_db("xlink");
			$query = "SELECT Kode,Keterangan from fomstlokasi where Kode>=20 AND Kode<=37";
			if($data= mysql_query($query)){
				while($row = mysql_fetch_array($data)){
					echo "<div class='polaroid-images'>";
					echo "<a href='' title='".$row['Keterangan']."'>";
					echo "<img height='200' src='img/klinik penyakit dalam.png' alt='".$row['Keterangan']."' title='".$row['Keterangan']."'/>";
					echo "</a></div>";
				}
			}else{
				//echo mysql_error();
				echo "<option>Database tidak terkoneksi</option>";
			}
			*/
		?>

</body>
</html>