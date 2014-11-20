<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$user_info = UserSession::getSessionInfo();

$arr = array('start_date','start_date_search','table','del','delpro','id');
$start_date = $start_date_search = $table = $del = $delpro = $id = "";

extract ( $_GET, EXTR_IF_EXISTS );

$province_id = $user_info['province_id']?$user_info['province_id']:$province_id;

if($del && $table) {
	Complaint::delData($id,$table);
}
$data['result'] = Complaint::getImprotData($start_date_search,$table,$province_id);
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);
$name_map = array('基础信息'=>'base','不规范定制'=>'custom','工信部投诉'=>'complaints','收入'=>'income','增值收入'=>'value_income');
$mapName = array('base'=>'基础信息','custom'=>'不规范定制','complaints'=>'工信部投诉','income'=>'收入','value_income'=>'增值收入');
if (Common::isPost ()) {
	// $file = $_FILES['excel']['tmp_name'];
	// var_dump($file);
	// $excel_array = ExcelReader::readXLS($file);
	// var_dump($excel_array);
	// exit;

	$date = $_POST['start_date'];
	$table = $_POST['table'];
	$province_id = $_POST['province_id'];

	if($table && $date && $province_id !== null) {
	if(empty($_FILES['excel'])) {
		OSAdmin::alert("error","empty file");
	}else{
		if($_FILES['excel']['error'] != 0) {
			$message = 'ÉÏ´«ÎÄ¼þÊ§°Ü,error number('.$_FILES['excel']['error'].')';
			OSAdmin::alert("error",$message);
		}
		// $file_name = $_FILES['excel']['name'];
		// $tmp = explode('-', $file_name);
		// if($name_map[$tmp[0]] !== $_POST['table']){
		// 	$error[$_POST['table']][] = '您所导入的表不是正确的表或命名有误！';
		// }elseif(isset($tmp[1]) && is_numeric($tmp[1])){

			$file = $_FILES['excel']['tmp_name'];

			$excel_array = ExcelReader::readXLS($file);

			if($_POST['cover'] == 'on'){
				Complaint::delDataByMonth($_POST['table'],$tmp[1]);
			}else{
				$check = false;
				$check = Complaint::checkFirstLine($excel_array,$_POST['table']);
			}
			if($check){
				$error[$_POST['table']][] = $check['error'];
			}else{
				// TODO check if imported
				if($excel_array) {
					array_shift($excel_array);
					$error[$_POST['table']] = array();

					$record_id = Complaint::recordTable($_FILES['excel']['name'],$table,$date,$province_id,$user_info['user_id']);

					foreach ($excel_array as $key => $value) {
						$r = Complaint::save($value,$table,$date,$province_id,$record_id);
						if(!$r){
							file_put_contents('../error_'.date('Y-m-d').'.log',date('Y-m-d H:i:s').' '.$_FILES['excel']['name'].' \''.implode("','", $value)."'\n",FILE_APPEND);
							$error[$_POST['table']][] = '\''.implode("','", $value)."'<br>";
						}
					}
					if (empty($error[$_POST['table']])) {

						$error[$_POST['table']][] = '导入成功！';
					}
				}else{
					$error[$_POST['table']][] = "导入文件有问题！";
				}
			}
		}
	}else{
			$error[$_POST['table']][] = "请选择全部选项！";
		}
		// }else{
		// 	$error[$_POST['table']][] = "导入文件命名有问题！";
		// }
		// $output=print_r($excel_array,true);
	
}
if($error){
	$tmp = '';
	foreach ($error as $key => $value) {
		$tmp .= implode(',', $value).'<br>';
	}
}
$error = $tmp;
$data['province'] = Info::getProvince(false);
Template::assign("name_map",$mapName);
Template::assign("error" ,$error);
Template::assign("data" ,$data);
Template::assign("_POST" ,$_POST);
// Template::assign("output" ,$output);
Template::display ('complaint/import.tpl');