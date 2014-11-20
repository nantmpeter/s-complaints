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
		// $sheets = $objPHPExcel->getSheet(0);
		// $allColumn = $sheets->getCellIterator();
		/*取得一共有多少行*/
		// $allRow = $sheets->getHighestRow();
		// $allColumn++;
		// var_dump($allColumn);
		// for ($row = 1; $row <= $allRow; $row++) { 
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {     //遍历工作表
		       // echo 'Worksheet - ' , $worksheet->getTitle() , PHP_EOL;
		       foreach ($worksheet->getRowIterator() as $key=>$row) {       //遍历行
		             // echo '    Row number - ' , $row->getRowIndex() , PHP_EOL;
		            $cellIterator = $row->getCellIterator();   //得到所有列
		            $cellIterator->setIterateOnlyExistingCells( false); // Loop all cells, even if it is not set
		             foreach ($cellIterator as $k=>$cell) {  //遍历列
		                   if (!is_null($cell) && $worksheet->getTitle() == 'Sheet1') {  //如果列不给空就得到它的坐标和计算的值
		                         // echo '        Cell - ' , $cell->getCoordinate() , ' - ' , $cell->getCalculatedValue() , PHP_EOL;
								$array[$key][$k] = $cell->getCalculatedValue();

		                  }
		            }
		      }
		}
		// foreach ($objPHPExcel->getRowIterator() as $key => $row) {
		// 	$columns = $row->getCellIterator();
		// 	foreach ($columns as $k => $column) {
		// 		$array[$key][$k] = $column->getCalculatedValue();
		// 	}
		  //   for ($column = 'A'; $column < $allColumn; $column++)  { 
		  //   	// var_dump($column, $row);
		  //       $val = $sheets->getCell($column.$row)->getValue(); 
		  //       // var_dump($val);
				// $array[$row][$column] = $val;

		  //       // $val = iconv("utf-8","gb2312",$val);
		  //       // echo $val . "&nbsp;&nbsp;";
		  //   }       
		    // echo "<br />";
		// }
		// echo '<pre>';
		// var_dump($array);

		// exit;
		
		// $data = new Spreadsheet_Excel_Reader();
		// $data->setOutputEncoding('UTF-8'); //设置输出的编码为utf8
		// $ret = $data->read($file); //要读取的excel文件地址
		// // var_dump($data->sst); exit;
		// if($ret == -1){
		// 	$array = false;
		// }else{
		// 	for ($i =1 ; $i <= $data->sheets[0]['numRows']; $i++) {
		// 		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		// 			$array[$i-1][$j-1] = $data->sheets[0]['cells'][$i][$j];
		// 		}
		// 	}
		// }
		return $array;
	}

	public static function xlsTime($in){
		$time = ($in - 25569) * 24*60*60; //获得秒数
		$time = $time>0?$time:0;
		return $time;   //出来 2012-02-08
	}
}
?>