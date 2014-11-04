<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('company_name','sp_company_code','sp_access_number','business_name');
$company_name = $sp_company_code = $sp_access_number = $business_name ="";


extract ( $_GET, EXTR_IF_EXISTS );
$user_info = UserSession::getSessionInfo();
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);




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
	$data['result'] = Complaint::getUnicomBusinessWithSpList($param,$start,0);
}
else 
{
	$data['result'] = Complaint::getUnicomBusinessWithSpList($param,$start,$page_size);
}

$row_count = Complaint::getUnicomBusinessWithSpListCount($param);

$row_count=isset($row_count[0]['c'])?$row_count[0]['c']:0;




//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	//var_dump($data);exit;
	Common::exportExcel($downloadStr,'unicom_business_list_with_sp') ;
	exit;
}
$page_html=Pagination::showPager("sp_search.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
$export_excel="sp_search.php?download=1&".$http_query;

// $page_html=Pagination::showPager("black_list.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );

// Template::assign("output" ,$output);
Template::display ('complaint/sp_search.tpl');



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