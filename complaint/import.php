<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$user_info = UserSession::getSessionInfo();
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);
$name_map = array('基础信息'=>'base','不规范定制'=>'custom','工信部投诉'=>'complaints','收入'=>'income','增值收入'=>'value_income');

if (Common::isPost ()) {
	if(empty($_FILES['excel'])) {
		OSAdmin::alert("error","empty file");
	}else{
		if($_FILES['excel']['error'] != 0) {
			$message = 'ÉÏ´«ÎÄ¼þÊ§°Ü,error number('.$_FILES['excel']['error'].')';
			OSAdmin::alert("error",$message);
		}
		$file_name = $_FILES['excel']['name'];
		$tmp = explode('-', $file_name);
		if($name_map[$tmp[0]] !== $_POST['table']){
			$error[$_POST['table']][] = '您所导入的表不是正确的表或命名有误！';
		}elseif(isset($tmp[1]) && is_numeric($tmp[1])){

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

					unset($excel_array[0]);
					$error[$_POST['table']] = array();

					foreach ($excel_array as $key => $value) {
						$r = Complaint::save($value,$_POST['table'],$tmp[1]);
						if(!$r)
							$error[$_POST['table']][] = implode("','", $value);
					}
					if (empty($error[$_POST['table']])) {
						$error[$_POST['table']][] = '导入成功！';
					}
				}else{
					$error[$_POST['table']][] = "导入文件有问题！";
				}
			}
		}else{
			$error[$_POST['table']][] = "导入文件命名有问题！";
		}
		// $output=print_r($excel_array,true);
	}
}

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
// Template::assign("output" ,$output);
Template::display ('complaint/import.tpl');