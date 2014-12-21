<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('company_name','sp_company_code','business_code');
$company_name = $sp_company_code = $business_code = "";

$business_type=$business_name=$apply_time=$business_state=$business_apply_state=$area="";

$method = $id = '';
extract ( $_GET, EXTR_IF_EXISTS );

$user_info = UserSession::getSessionInfo();
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);


if ($method == 'del' && ! empty ( $id )) {
	$ret = Complaint::getUnicomBusiness($id);
	if(!$ret){
		OSAdmin::alert("error",'删除条目不存在');
	}else{
		$result = Complaint::delUnicomBusiness ( $id );
		if ($result>0) {
			SysLog::addLog ( UserSession::getUserName(), 'DELETE', 'UnicomBusiness',$id, json_encode($ret) );
			Common::exitWithSuccess ('删除成功','/complaint/unicom_business_list.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}


if (Common::isPost ()&&$_POST['importunicombl']==1) {
	if(empty($_FILES['excel'])) {
		OSAdmin::alert("error","empty file");
	}else{
		if($_FILES['excel']['error'] != 0) {
			$message = '导入出错,error number('.$_FILES['excel']['error'].')';
			OSAdmin::alert("error",$message);
		}

		$file = $_FILES['excel']['tmp_name'];

		$excel_array = ExcelReader::readXLS($file);
		$error = '';
		if($excel_array) {
			array_shift($excel_array);

			$successnum=0;
			$existnum=0;
			foreach ($excel_array as $key => $value) {
				if(count($value)>=8&&$value[0]&&$value[3])
				$r=Complaint::checkUnicomBusiness($value[0],$value[3]);
				if(!$r){
					$ret=Complaint::addUnicomBusiness(array(
														'sp_company_code'=>$value[0],
														'company_name'=>$value[1],
														'business_type'=>$value[2],
														'business_code'=>$value[3],
														'business_name'=>$value[4],
														'business_format'=>'',
														'apply_time'=>$value[5],
														'business_state'=>$value[6],
														'business_apply_state'=>$value[7],
														'area'=>$value[8],
														'create_time'=>date('Y-m-d H:i:s'),
														'update_time'=>date('Y-m-d H:i:s')));
					if($ret){
						$successnum++;
					}
				}
				else{
					$existnum++;
					continue;
				}
			}
			
			$error = '需要导入'.count($excel_array).'条，已经存在'.$existnum.'条，成功'.$successnum.'条！';
			
		}else{
			$error= "导入文件有问题！";
		}
	}
}

if ($method == 'addUnicomBusiness' ) {
	
	if($company_name=="" || $sp_company_code=="" || $business_code =="" || $business_type =="" ||
	 $business_name =="" || $apply_time=="" || $business_state =="" || $business_apply_state ==""|| $area ==""){
		
		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('sp_company_code' => $sp_company_code, 'company_name' => $company_name, 
		'business_type' => $business_type, 'business_code' => $business_code, 'business_name' => $business_name, 
		'apply_time' => $apply_time, 'business_state' => $business_state, 'business_apply_state' => $business_apply_state, 
		'area' => $area , 'create_time' => date("Y-m-d H:i:s"),'update_time'=>date("Y-m-d H:i:s"),'del_flag'=>0);
		$id = Complaint::addUnicomBusiness ( $input_data );

		
		if ($id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'UnicomBusiness' ,$id, json_encode($input_data) );
			Common::exitWithSuccess ('业务信息添加成功','/complaint/unicom_business_list.php');
		}else{
			OSAdmin::alert("error");
		}
	}
	
}


$http_query = '';
foreach ($arr as $key => $value) {
     $http_query .= $value.'='.$$value.'&';
     if($$value) {
          $param[$value] = $$value;
     }
}

$page_size = PAGE_SIZE;
//$page_no=$page_no<1?1:$page_no;

$page_no=!isset($_GET['page_no'])||intval($_GET['page_no'])<1?1:intval($_GET['page_no']);
$start = ($page_no - 1) * $page_size;

if($_GET['download']==1)
{
	$data['result'] = Complaint::getUnicomBusinessList($param,$start,0);
}
else 
{
	$data['result'] = Complaint::getUnicomBusinessList($param,$start,$page_size);
}

$row_count = Complaint::getUnicomBusinessListCount($param);





//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	//var_dump($data);exit;
	Common::exportExcel($downloadStr,'unicom_business_list') ;
	exit;
}
$page_html=Pagination::showPager("unicom_business_list.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
$export_excel="unicom_business_list.php?download=1&".$http_query;

// $page_html=Pagination::showPager("black_list.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );


$confirm_html = OSAdmin::renderJsConfirm("icon-remove");
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
// Template::assign("output" ,$output);
Template::display ('complaint/unicom_business_list.tpl');



//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "投诉号码\t省\t公司sp代码\t录入时间\tsp公司\t投诉号码标签\t黑名单级别\t屏蔽时限\n ";

 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

					
			$dataStr.=$data['result'][$i]['complaint_phone']."\t";
			$dataStr.=$data['province'][$data['result'][$i]['province_id']]['name']."\t";

			$dataStr.=$data['result'][$i]['sp_corp_code']."\t";
			$dataStr.=date('Y-m',$data['result'][$i]['month'])."\t";
			$dataStr.=$data['result'][$i]['sp_corp_name']."\t";
			$dataStr.=$data['result'][$i]['complaint_phone_tag']."\t";
			$dataStr.=$data['result'][$i]['level']."\t";
			$dataStr.=$data['result'][$i]['time_limit']."\n";
		}
		
	}
	$dataStr = mb_convert_encoding($dataStr,"gb2312","UTF-8");
	return $dataStr;
}