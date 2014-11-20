<?php
if(!defined('ACCESS')) {exit('Access denied.');}
// require (__DIR__.'/Spreadsheet_Excel_Reader.class.php');
require_once (__DIR__.'/PHPExcel/Classes/PHPExcel/IOFactory.php');
ini_set('memory_limit','512M');

class ExcelReader {
	public static function readXLS($xlsfile){

		$fileType = PHPExcel_IOFactory::identify($xlsfile);
		$objReader = PHPExcel_IOFactory::createReader($fileType);
		$objPHPExcel = $objReader->load($xlsfile);
		$sheets = $objPHPExcel->getSheet(0)->toArray();
		return $sheets;

	}

	public static function xlsTime($in){
		$time = ($in - 25569) * 24*60*60; //获得秒数
		$time = $time>0?$time:0;
		return $time;   //出来 2012-02-08
	}
}
?>