
		<?php
		if($_POST['type'] == 'test') 
		{
				// header( 'Content-type: text/html; charset=utf-8' );
				// echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
				
				// echo "<pre>",print_r( $_POST),"</pre>"; 
				echo "<pre>",print_r( json_decode($_POST['jadok_tampil'], 1) ),"</pre>"; 
				// echo $_POST['jadok_tampil'];

				// exit;
				
				// echo str_pad('',4096); //fill browser buffer
		
				// for($i = 0; $i < 10; $i++)
				// 		{
				// 				echo '<script type="text/javascript">window.parent.console.log(\''.$_POST['message'].'\');</script>';
				// 				ob_flush(); flush();
				// 				usleep(350000);
				// 		}
		}

		// echo "<pre>",print_r(arr_repair( $_POST)),"</pre>"; exit;
		?>
	