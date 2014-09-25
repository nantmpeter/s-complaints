<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$user_info = UserSession::getSessionInfo();
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);
if (Common::isPost ()) {
	if(empty($_FILES['excel'])) {
		OSAdmin::alert("error","empty file");
	}else{
		if($_FILES['excel']['error'] != 0) {
			$message = 'ÉÏ´«ÎÄ¼þÊ§°Ü,error number('.$_FILES['excel']['error'].')';
			OSAdmin::alert("error",$message);
		}
		$file = $_FILES['excel']['tmp_name'];

		$excel_array = ExcelReader::readXLS($file);
		if($excel_array) {

			unset($excel_array[0]);
			$error[$_POST['table']] = array();

			foreach ($excel_array as $key => $value) {
				$r = Complaint::save($value,$_POST['table']);
				if(!$r)
					$error[$_POST['table']][] = implode(",", $value);
			}
			if (empty($error[$_POST['table']])) {
				$error[$_POST['table']][] = '导入成功！';
			}
		}else{
			$error[$_POST['table']][] = "导入文件有问题！";
		}
		// $output=print_r($excel_array,true);
	}
}

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
// Template::assign("output" ,$output);
Template::display ('complaint/import.tpl');