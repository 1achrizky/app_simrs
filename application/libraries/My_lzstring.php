<?php
require_once dirname(__FILE__) . '/LZCompressor/LZString.php';
require_once dirname(__FILE__) . '/LZCompressor/LZReverseDictionary.php';
require_once dirname(__FILE__) . '/LZCompressor/LZData.php';
require_once dirname(__FILE__) . '/LZCompressor/LZUtil.php';

class My_lzstring extends \LZCompressor\LZString {
  public $lz;
  public function __construct(){
    $this->lz = new \LZCompressor\LZString;
    // return $this->lz;
  }

  // public function load(){
  //   return $this->lz;
  // }

  // public function load( $fileType='Excel5', $fullpath_file=null){
  //   require_once dirname(__FILE__) . '/PHPExcel/PHPExcel/IOFactory.php';
    
  //   // Read the file
  //   $objReader = PHPExcel_IOFactory::createReader($fileType);
  //   $objPHPExcel = $objReader->load($fullpath_file);
  //   return $objPHPExcel;
  // }


  // public function decBase64($string){ 
  //   // return \LZCompressor\LZString::decompressFromBase64($string);
  //   // return \LZCompressor\LZString::decompressFromBase64($string);
  //   return $this->lz->decompressFromBase64($string);
  // }
}