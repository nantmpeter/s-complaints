<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','part_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_line','sp_code','month','complaint_status','appeal_status','buss_type','part_code');
$start_date = $end_date = $page_no = $province_id = $buss_name = $part_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_line = $sp_code =$start_date = $end_date = $month = $complaint_status = $appeal_status = $buss_type = $part_code = "";

extract ( $_GET, EXTR_IF_EXISTS );
$user_info = UserSession::getSessionInfo();
$province_id = $user_info['province_id']?$user_info['province_id']:$province_id;
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);

$http_query = '';
foreach ($arr as $key => $value) {
     $http_query .= $value.'='.$$value.'&';
     if($$value) {
          $param[$value] = $$value;
     }
}
$start_date = $param['month'] = $_GET['month'] = $_GET['month']?$_GET['month']:date('Y-m');

// if (Common::isPost ()) {
// if($start_date != '' && $end_date !=''){
	$page_size = PAGE_SIZE;
	$page_no=$page_no<1?1:$page_no;
	$start = ($page_no - 1) * $page_size;
	if($_GET['download']==1)
	{
		$data['result'] = Complaint::customSearch($param,$start,0);
	}
	else 
	{
		$data['result'] = Complaint::customSearch($param,$start,$page_size);
	}
	$row_count = Complaint::customSearchCount($param);
// }
$data['province'] = Info::getProvince(false);
$data['complaintType'] = Info::getComplaintType('complaint_type',false);
$data['questionType'][1] = Info::getQuestionType(1,'question_type',true);
$data['questionType'][2] = Info::getQuestionType(2,'question_type',true);
$data['questionType'][3] = Info::getQuestionType(3,'question_type',true);
$data['complaintLevel'] = Info::getComplaintLevel('complaint_level',false);
$data['bussLine'] = Info::getBussLine('buss_type',false);
//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	//var_dump($data);exit;
	Common::exportExcel($downloadStr,'black_list') ;
	exit;
}
$page_html=Pagination::showPager("custom_search.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
// $page_html=Pagination::showPager("custom_search.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);
$export_excel="custom_search.php?download=1&".$http_query;

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );
// Template::assign("output" ,$output);
Template::display ('complaint/custom_search.tpl');


//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "#\t省市\t合作伙伴代码\t公司名称\t业务类型\t业务名称\t投诉类型名称\t工单时间\t不规范定制投诉量\t投诉号码\t投诉内容\t申诉内容\t投诉状态\t申诉状态\t扣款金额\t业务线\n ";

 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

					
			$dataStr.=$data['result'][$i]['id']."\t";
			$dataStr.=$data['province'][$data['result'][$i]['province_id']]['name']."\t";

			$dataStr.=$data['result'][$i]['part_code']."\t";
			$dataStr.=$data['result'][$i]['part_name']."\t";
			$dataStr.=$data['bussLine'][$data['result'][$i]['buss_type']]."\t";
			$dataStr.=$data['result'][$i]['buss_name']."\t";
			$dataStr.=$data['result'][$i]['complaint_type']."\t";
			$dataStr.=date('Y-m',$data['result'][$i]['order_time'])."\t";
			
			$dataStr.=$data['result'][$i]['complaint_total']."\t";
			$dataStr.=$data['result'][$i]['complaint_phone']."\t";
			$dataStr.=preg_replace('/\s/iu', ' ', $data['result'][$i]['complaint_content'])."\t";
			$dataStr.=preg_replace('/\s/iu', ' ', $data['result'][$i]['appeal_content'])."\t";
			
			$dataStr.=$data['result'][$i]['complaint_status']."\t";
			$dataStr.=$data['result'][$i]['appeal_status']."\t";
			$dataStr.="\t";
			$dataStr.=$data['result'][$i]['buss_line']."\n";
		}
		
	}
	$dataStr = mb_convert_encoding($dataStr,"gb2312","UTF-8");
	return $dataStr;
}