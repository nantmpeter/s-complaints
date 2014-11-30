<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('company_name','sp_company_code','sp_access_number');
$company_name = $sp_company_code = $sp_access_number = "";

$method = $id = '';
extract ( $_GET, EXTR_IF_EXISTS );
$user_info = UserSession::getSessionInfo();
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);


if ($method == 'del' && ! empty ( $id )) {
	$ret = Complaint::getUnicomBusinessSp($id);
	if(!$ret){
		OSAdmin::alert("error",'删除条目不存在');
	}else{
		$result = Complaint::delUnicomBusinessSp ( $id );
		if ($result>0) {
			SysLog::addLog ( UserSession::getUserName(), 'DELETE', 'UnicomBusiness',$id, json_encode($ret) );
			Common::exitWithSuccess ('删除成功','/complaint/unicom_business_sp_list.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}


if ($method == 'addUnicomBusinessSp' ) {
	
	if($company_name=="" || $sp_company_code=="" || $sp_access_number =="" ){
		
		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('sp_company_code' => $sp_company_code, 'company_name' => $company_name, 
		'sp_access_number' => $sp_access_number, 'create_time' => date("Y-m-d H:i:s"),
		'update_time'=>date("Y-m-d H:i:s"),'del_flag'=>0);
		$id = Complaint::addUnicomBusinessSp ( $input_data );

		
		if ($id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'UnicomBusiness' ,$id, json_encode($input_data) );
			Common::exitWithSuccess ('sp名单添加成功','/complaint/unicom_business_sp_list.php');
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
$page_no=!isset($_GET['page_no'])||intval($_GET['page_no'])<1?1:intval($_GET['page_no']);
$start = ($page_no - 1) * $page_size;

if($_GET['download']==1)
{
	$data['result'] = Complaint::getUnicomBusinessSpList($param,$start,0);
}
else 
{
	$data['result'] = Complaint::getUnicomBusinessSpList($param,$start,$page_size);
}

$row_count = Complaint::getUnicomBusinessSpListCount($param);





//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	//var_dump($data);exit;
	Common::exportExcel($downloadStr,'unicom_business_sp_list') ;
	exit;
}
$page_html=Pagination::showPager("unicom_business_sp_list.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
$export_excel="unicom_business_sp_list.php?download=1&".$http_query;

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
Template::display ('complaint/unicom_business_sp_list.tpl');



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