<?php

/**
 * Excel Generator for CodeIgniter
 * 
 * @author Dida Nurwanda <didanurwanda@gmail.com>
 * @link http://didanurwanda.blogspot.com 
 * 
 */
require_once dirname(__FILE__) . '/PHPExcel/PHPExcel.php';

class Excel_generator extends PHPExcel {

    /**
     * @var CI_DB_result
     */
    private $query;
    private $column = array();
    private $header = array();
    private $width = array();
    private $header_bold = TRUE;
    private $start = 1;

    /**
     * Diisi dengan query Anda
     * <pre>
     * $query = $this->db->get('users');
     * $this->excel_generator->set_query($query);
     * </pre>
     * 
     * @access public
     * @param CI_DB_result $query
     * @return Excel_generator
     */

    // LOAD() buatan rizky
    public function load( $fileType='Excel5', $fullpath_file=null){
        require_once dirname(__FILE__) . '/PHPExcel/PHPExcel/IOFactory.php';
        // $fileType = 'Excel5';
        // $filename = 'RAWAT JALAN.xls';
        // $fullName = FCPATH.'assets\upload\bpjs_verif\FEB 2020\\'.$filename;
        // echo $fullName; exit;

        // Read the file
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load($fullpath_file);
        return $objPHPExcel;
    }

    public function getting_start(){
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
        
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
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

    public function data_array($filename=null, $set=null, $arr=null){
        // FUNGSI INI BISA PAKAI result_array() di model(db query ci)
        // $query = $this->db->get();
        // return $query->result_array();
        
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $char = str_split($chars);

        // $char_push = ["AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ"];
        $char_push = [];
        for ($cj=0; $cj < 8; $cj++) { // sampai HZ
            for ($ci=0; $ci < 26; $ci++) {
                // array_push( $char_push , "A".$char[$ci] );
                array_push( $char_push , $char[$cj].$char[$ci] );
            }
        }
        // AA - HZ
        // MAX :: column iv

        // print_r($char_push);
        // exit;

        
        $len_tot = count($char)+count($char_push);
        // for ($i=0; $i < $len_tot ; $i++) { 
        for ($i=0; $i < count($char_push) ; $i++) { 
            array_push($char, $char_push[$i]);
        }

        // print_r($char);
        // exit;
        

        //load our new PHPExcel library
        // $this->load->library('excel');
        //activate worksheet number 1
        $this->setActiveSheetIndex(0);
        //name the worksheet
        $this->getActiveSheet()->setTitle('test worksheet');

        for ($header=0; $header < count($set) ; $header++) { 
             //set cell A1 content with some text
            $this->getActiveSheet()->setCellValue($char[$header].'1', $set[$header]["header"]);            
            $this->getActiveSheet()->getColumnDimension($char[$header])->setWidth($set[$header]["width"]);
            //change the font size
            $this->getActiveSheet()->getStyle($char[$header].'1')->getFont()->setSize(12);
            //make the font become bold
            $this->getActiveSheet()->getStyle($char[$header].'1')->getFont()->setBold(true);            
               
        }

        for ($i=0; $i < count($arr) ; $i++) { 
            for ($header=0; $header < count($set) ; $header++) { // loop header
                $id_arr_excel = $i+2;
                 //set cell A1 content with some text
                // $this->getActiveSheet()->setCellValue($char[$header].$id_arr_excel, $set[$header]["column"]);
                $this->getActiveSheet()->setCellValue($char[$header].$id_arr_excel, $arr[$i][ $set[$header]["column"] ] );
                //change the font size
                $this->getActiveSheet()->getStyle($char[$header].$id_arr_excel)->getFont()->setSize(12);
                //make the font become bold
                // $this->getActiveSheet()->getStyle($char[$header].$id_arr_excel)->getFont()->setBold(true);
            }
               
        }
        

        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        // $filename='just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function set_query(CI_DB_result $query) {
        $this->query = $query;
        return $this;
    }

    /**
     * Diisi sesuai dengan field pada table
     * <pre>
     * $this->excel_generator->set_column(array('name', 'address', 'email'));
     * </pre>
     * 
     * @access public
     * @param array $column
     * @return Excel_generator
     */
    public function set_column($column = array()) {
        $this->column = $column;
        return $this;
    }

    /**
     * Untuk mengisi header pada table excel
     * <pre>
     * $this->excel_generator->set_header(array('Name', 'Address', 'Email'));
     * </pre>
     * Jika ingin tulisannya tidak dalam bentuk bold
     * <pre>
     * $this->excel_generator->set_header(array('...'), FALSE);
     * </pre>
     * 
     * @access public
     * @param array $header
     * @param bool $set_bold
     * @return Excel_generator
     */
    public function set_header($header = array(), $set_bold = TRUE) {
        $this->header = $header;
        $this->header_bold = $set_bold;
        return $this;
    }

    /**
     * Mengubah lebar kolom
     * <pre>
     * $this->excel_generator->set_width(array(25, 30, 15));
     * </pre>     * 
     * 
     * @access public
     * @param array $width
     * @return Excel_generator
     */
    public function set_width($width = array()) {
        $this->width = $width;
        return $this;
    }

    /**
     * Mengubah baris saat memulai membuat daftar
     * <pre>
     * $this->excel_generator->start_at(5);
     * </pre>
     * 
     * @access public
     * @param int $start
     * @return Excel_generator
     */
    public function start_at($start = 1) {
        $this->start = $start;
        return $this;
    }

    /**
     * Untuk menghasilkan data excel
     * 
     * @access public
     * @return Excel_generator
     */
    public function generate() {
        $start = $this->start;
        if (count($this->header) > 0) {
            $abj = 1;
            foreach ($this->header as $row) {
                $this->getActiveSheet()->setCellValue($this->columnName($abj) . $this->start, $row);
                if ($this->header_bold) {
                    $this->getActiveSheet()->getStyle($this->columnName($abj) . $this->start)->getFont()->setBold(TRUE);
                }
                $abj++;
            }
            $start = $this->start + 1;
        }

        foreach ($this->query->result_array() as $result_db) {
            $index = 1;
            foreach ($this->column as $row) {
                if (count($this->width) > 0) {
                    $this->getActiveSheet()->getColumnDimension($this->columnName($index))->setWidth($this->width[$index - 1]);
                }

                $this->getActiveSheet()->setCellValue($this->columnName($index) . $start, $result_db[$row]);
                $index++;
            }
            $start++;
        }
        return $this;
    }

    private function columnName($index) {
        --$index;
        if ($index >= 0 && $index < 26)
            return chr(ord('A') + $index);
        else if ($index > 25)
            return ($this->columnName($index / 26)) . ($this->columnName($index % 26 + 1));
        else
            show_error("Invalid Column # " . ($index + 1));
    }

    /**
     * Untuk membuat file excel
     * 
     * @param string $filename
     * @param string $writerType
     * @param string $mimes
     */
    private function writeToFile($filename = 'doc', $writerType = 'Excel5', $mimes = 'application/vnd.ms-excel') {
        $this->generate();
        header("Content-Type: $mimes");
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this, $writerType);
        $objWriter->save('php://output');
    }

    /**
     * @param string $filename
     */
    public function exportTo2003($filename = 'doc') {
        $this->writeToFile($filename . '.xls');
    }

    /**
     * @param string $filename
     */
    public function exportTo2007($filename = 'doc') {
        $this->writeToFile($filename . '.xlsx', 'Excel2007', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

}