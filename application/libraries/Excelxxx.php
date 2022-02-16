<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
// require_once APPPATH."/third_party/PHPExcel.php";

require_once dirname(__FILE__) . '/PHPExcel/PHPExcel.php';
 
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }

    // KETEMU INI, DIPINDAH KE LIBRARY EXCEL_GENERATOR
    public function testing(){
    	//load our new PHPExcel library
		// $this->load->library('excel');
		//activate worksheet number 1
		$this->setActiveSheetIndex(0);
		//name the worksheet
		$this->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		$this->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		//change the font size
		$this->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		//make the font become bold
		$this->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//set aligment to center for that merged cell (A1 to D1)
		$this->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='just_some_random_name.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
    }
}