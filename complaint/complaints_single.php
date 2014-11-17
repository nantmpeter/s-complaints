<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code','month');
$start_date = $end_date = $page_no = $province_id = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date = $month = "";

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
$start_date = $param['start_date'] = $_GET['start_date'] = $_GET['start_date']?$_GET['start_date']:date('Y-m');

// if (Common::isPost ()) {
// if($start_date != '' && $end_date !=''){
	$page_size = PAGE_SIZE;
	$page_no=$page_no<1?1:$page_no;
	$start = ($page_no - 1) * $page_size;
	if($_GET['download']==1)
	{
		$data['result'] = Complaint::complaintsSingle($param,$start,0);
	}
	else 
	{
		$data['result'] = Complaint::complaintsSingle($param,$start,$page_size);
	}

	if($data['result']) {
		foreach ($data['result'] as $key => $value) {
			if ($value['buss_name'] == '') {
				unset($data['result'][$key]);
				// var_dump(current($data['result']));
				if($key == 0){
					$data['result'][0] = current($data['result']);
				}
				continue;
			}
			$tmp['name'][] = $value['buss_name'];
			$tmp['value'][] = $value['num'];
			$data['chartName'] = '"'.implode('","', $tmp['name']).'"';
			$data['chartValue'] = implode(',', $tmp['value']);
		}
	}
	// rsort($tmp['wan']);

	$row_count = Complaint::complaintsSingleCount($param);

	// $data['month'] = Complaint::customAnalayzeMonth($param);

	// $data['provinces'] = Complaint::customAnalayzeArea($param);
	$province = Info::getProvince();
	foreach ($province as $key => $value) {
		$data['provinceMap'][$key] = $value['name'];
	}
	$data['provinceString'] = '"'.implode('","', $data['provinceMap']).'"';

// }



$data['province'] = Info::getProvince(false);
$data['complaintType'] = Info::getComplaintType('complaint_type',false);
$data['questionType'][1] = Info::getQuestionType(1,'question_type',true);
$data['questionType'][2] = Info::getQuestionType(2,'question_type',true);
$data['questionType'][3] = Info::getQuestionType(3,'question_type',true);
$data['complaintLevel'] = Info::getComplaintLevel('complaint_level',false);
$data['bussLine'] = Info::getBussLine('buss_type',false);
// var_dump($data['bussLine']);
//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	//var_dump($data);exit;
	Common::exportExcel($downloadStr,'black_list') ;
	exit;
}

$page_html=Pagination::showPager("complaints_single.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
$export_excel="complaints_single.php?download=1&".$http_query;

// $page_html=Pagination::showPager("custom_sp_analyze.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);
// $export_excel="complaints_single.php?download=1&class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date";

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );
// Template::assign("output" ,$output);
Template::display ('complaint/complaints_single.tpl');


//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "产品名称\t公司名称\t月不规范定制件数<\t环比增长量\t环比增长率\n ";

 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

			$dataStr.=$data['result'][$i]['buss_name']."\t";
			$dataStr.=$data['result'][$i]['sp_corp_name']."\t";
			$dataStr.=$data['result'][$i]['num']."\t";
			$dataStr.=$data['result'][$i]['increase']."\t";
			$dataStr.=sprintf("%.2f",$data['result'][$i]['increasePercent'])."\n";
		}
		
	}
	$dataStr = mb_convert_encoding($dataStr,"gb2312","UTF-8");
	return $dataStr;
}
