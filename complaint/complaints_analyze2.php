<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code','case_id','dispute_phone');
$start_date = $end_date = $page_no = $province_id = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date = $case_id = $dispute_phone = "";

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

	$result = Complaint::complaintsAnalayze2($param,$start,$page_size);
	if($_GET['download']==1)
	{
		$result = Complaint::complaintsAnalayze2($param,$start,0);
	}
	else 
	{
		$result = Complaint::complaintsAnalayze2($param,$start,$page_size);
	}
	$data['result'] = $result['list'];
	$num=0;
	foreach ($data['result'] as $key => $value) {
		$total['num'] += $value['num'];
		$total['wan'] += $value['wan'];
		$total['month'] = date('Y-m',$value['month']);
		$tmp['typeName'][$key] = $value['product_type'];
		$data['pie'][$num]['value'] = round($value['num']/$result['total'],4);
		$data['pie'][$num]['name'] = $value['product_type'];
		$num++;
		// $data['pie'][$key]['color'] = "#F38630";
		if($value['cos'])
			$tmp['value'][$key] = $value['num']/$value['cos'];
		else
			$tmp['value'][$key] = 0;
	}
	$total['cos'] = Complaint::getValueTotal(strtotime($start_date."-01"));

	$total['increase'] = $total['num'] - Complaint::getComplaintTotal(strtotime($start_date."-01 -1 month"),$province_id);

	$data['total'] = $total;

	$row_count = Complaint::complaintsAnalayze2Count($param);

	$data['month'] = Complaint::baseAnalayzeMonth($param);
	// $r = Complaint::complaintsAnalayzeType($param);
	// var_dump($r);
	// $data['provinces'] = implode(',',Complaint::complaintsAnalayzeType($param)['province']);
	// $data['complaints'] = Complaint::complaintsAnalayzeType($param)['complaints'];

	$province = Info::getProvince();
	foreach ($province as $key => $value) {
		$data['provinceMap'][$key] = $value['name'];
	}
	if(isset($tmp['typeName'])) {
		$data['zhuString'] = '"'.implode('","', $tmp['typeName']).'"';
		$data['zhuData'] = '"'.implode('","', $tmp['value']).'"';
	}
	$data['pie'] = json_encode($data['pie']);




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
$page_html=Pagination::showPager("complaints_analyze2.php?".$http_query,$page_no,PAGE_SIZE,$row_count);

// $page_html=Pagination::showPager("custom_analyze2.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);
$export_excel="custom_analyze.php?download=1&class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date";

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );
// Template::assign("output" ,$output);
Template::display ('complaint/complaints_analyze2.tpl');


//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "产品类别\t省市\t统计月份\t月工信部投诉量\t环比增长量\t环比增长率\t不规范定制/业务收入(百万)\n ";

 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

					
			$dataStr.=$data['result'][$i]['product_type']."\t";
			$dataStr.=$data['provinceMap'][$data['result'][$i]['corp_area']]."\t";
			$dataStr.=date('Y-m',$data['result'][$i]['month'])."\t";
			$dataStr.=$data['result'][$i]['num']."\t";
			$dataStr.=$data['result'][$i]['increase']."\t";
			$dataStr.=sprintf("%.2f",$data['result'][$i]['increasePercent'])."\t";
			$dataStr.=sprintf("%.2f",$data['result'][$i]['cos'])."\n";

		}
		
	}
	$dataStr = mb_convert_encoding($dataStr,"gb2312","UTF-8");
	return $dataStr;
}