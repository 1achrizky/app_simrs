<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Third_party {

	private $base_url = array(
		'phpexcel' =>  'application/third_party/PHPExcel-1.8/'
	);



  public function php2excel($data_post){
		error_reporting(E_ALL);
		set_time_limit(0);

		date_default_timezone_set('Europe/London');

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		$js = json_decode($data_post);
		$nosep = $js->req->sep->nosep;
		
		
		/** Include path **/
		////set_include_path(get_include_path() . PATH_SEPARATOR . '../../Classes/');
		set_include_path($this->base_url['phpexcel'] . 'Classes/');

		/** PHPExcel_IOFactory */
		include 'PHPExcel/IOFactory.php';
		//include $this->base_url['phpexcel'].'Classes/'.'PHPExcel/IOFactory.php';


		$inputFileName = $this->base_url['phpexcel'] . 'Coba/sample/RESUME_SEP.xlsx';
		echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);


		echo '<hr />';

		/* add WRITER*/
		echo date('H:i:s') , " Add some data" , EOL;

		$objPHPExcel
				->setCellValue('C51', $js->req->sep->nosep )
        ->setCellValue('C52', $js->req->sep->tglSep )
        ->setCellValue('C53', $js->req->sep->noka )
        ->setCellValue('C54', $js->req->sep->nama )
        ->setCellValue('C55', $js->req->sep->tglLahir )
        ->setCellValue('C56', $js->req->sep->telp )
        ->setCellValue('C57', $js->req->sep->poli_tujuan )
        ->setCellValue('C58', $js->req->sep->faskes_perujuk )
        ->setCellValue('C59', $js->req->sep->diagnosa )
        ->setCellValue('C60', $js->req->sep->catatan );

		$objPHPExcel
					->setActiveSheetIndex(0)
          ->setCellValue('G52', $js->req->sep->tglSep )
          ->setCellValue('G53', $js->req->sep->COB )
          ->setCellValue('G54', $js->req->sep->jenisRawat )
          ->setCellValue('G55', $js->req->sep->kelasRawat )
          ->setCellValue('G56', $js->req->sep->telp );
		            

		/*/add WRITER*/


		// $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		// var_dump(json_encode($sheetData));


		//======================
		// Save Excel 2007 file  ==============> (.xlsx)
		echo date('H:i:s') , " Write to Excel2007 format" , EOL;
		$callStartTime = microtime(true);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		////$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
		////////////$objWriter->save($nosep.'.xlsx');
		$lokasi_simpan_output = "assets/output/";
		$objWriter->save($lokasi_simpan_output.$nosep.".xlsx");
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



  }
}