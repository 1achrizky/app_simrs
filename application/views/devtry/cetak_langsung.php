<?php
/* contoh text */  
$text = 'Eh, ini adalah testing aplikasi cetak teks langsung ke printer dengan PHP....';     
/* tulis dan buka koneksi ke printer */    
$alamat = "\\\\192.168.1.138\\HP LaserJet 1020";
echo $alamat;
////$printer = printer_open("EPSON L120 Series");  
//$printer = printer_open($alamat);  
$printer = printer_open($_POST['nama_printer']);  
/* write the text to the print job */  
printer_write($printer, $text);   
/* close the connection */ 
printer_close($printer);
?>