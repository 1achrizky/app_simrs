<?php

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$nosep = 'iki_nosep';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>PHPExcel Reader Example #01</title>

</head>
<body>

<h1>PHPExcel Reader Example #01</h1>
<h2>Simple File Reader using PHPExcel_IOFactory::load()</h2>
<?php

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';


$inputFileName = '../sample/RESUME_SEP.xlsx';
echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);


echo '<hr />';

/* add WRITER*/
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E1', 'Hello')
            ->setCellValue('E2', 'Rizky!');
/*/add WRITER*/


// $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
// var_dump(json_encode($sheetData));


//======================
// Save Excel 2007 file  ==============> (.xlsx)
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
////$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$objWriter->save($nosep.'.xlsx');
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// // Save Excel 95 file =======> (.xls)
// echo date('H:i:s') , " Write to Excel5 format" , EOL;
// $callStartTime = microtime(true);

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
// $objWriter->save(str_replace('.php', '.xls', __FILE__));
// $callEndTime = microtime(true);
// $callTime = $callEndTime - $callStartTime;

// echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
// echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// // Echo memory usage
// echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , getcwd() , EOL;
//==================================


?>
<body>
</html>