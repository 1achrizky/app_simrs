<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

/* contoh text */  
$text = "Ini adalah testing aplikasi cetak teks langsung ke printer dengan PHP lhoo.... "; 
echo $text."<br>";    
/* tulis dan buka koneksi ke printer */    
////$printer = printer_open("EPSON L120 Series");  
////$printer = printer_open("HP LaserJet 1020 on 192.168.1.138");  
//$printer = printer_open("HP LaserJet 1020");  
//printer_open('\\\\192.168.0.8\\Canon MF4320-4350'); 
//$printer = printer_open("\\\\192.168.1.138\\HP LaserJet 1020");  
$alamat = "\\\\192.168.1.138\\HP LaserJet 1020";
//$alamat = "\\\\192.168.1.138\\HP1020";
echo "\n Alamat : ".$alamat."<br>";
$printer = printer_open($alamat);
echo $printer."<br>";
if($printer){ echo "CONNECTED"; }
else{ echo "NOT CONNECTED"; }



//printer_set_option($printer, PRINTER_MODE, "RAW");
printer_set_option($printer, PRINTER_MODE, "TEXT");
printer_set_option($printer, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_FOLIO);

/* write the text to the print job */
printer_write($printer, $text);   
/* close the connection */ 
printer_close($printer);
?>