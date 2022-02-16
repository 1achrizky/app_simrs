
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 include_once APPPATH.'/third_party/mpdf/mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
 
    // fungsi dibawah ini di '/third_party/mpdf/mpdf.php' di bagian class mPDF
    // public function __construct($mode = '', $format = 'A4', $default_font_size = 0, $default_font = '', $mgl = 15, $mgr = 15, $mgt = 16, $mgb = 16, $mgh = 9, $mgf = 9, $orientation = 'P')
    // {...}

    //function _getPageFormat($format) >>>> ada format kertas A3,A4,A5,FOLIO
    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    // public function __construct($param = '"UTF-8","A4","","",10,10,10,10,6,3')
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
        // $this->pdf->SetFont('tahoma');
        // $mpdf->SetFont('tahoma');
    }

    // coba. DURUNG ISO
    public function a5($param = '"en-GB-x","A5","","",10,10,10,10,6,3')
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}