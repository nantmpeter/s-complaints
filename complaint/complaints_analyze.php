<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code','case_id','dispute_phone');
$start_date = $end_date = $page_no = $province_id = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date = $case_id = $dispute_phone = "";

extract ( $_GET, EXTR_IF_EXISTS );
$user_info = UserSession::getSessionInfo();
$province_id = $user_info['province_id']?$user_info['province_id']:$province_id;
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);
foreach ($arr as $key => $value) {

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
		$data['result'] = Complaint::complaintsAnalayze($param,$start,0);
	}
	else 
	{
		$data['result'] = Complaint::complaintsAnalayze($param,$start,$page_size);
		foreach ($data['result'] as $key => $value) {
			$total['num'] += $value['num'];
			$total['cos'] += $value['cos'];
			$total['wan'] += $value['wan'];
			$total['month'] = date('Y-m',$value['month']);
		}
	}
	$total['increase'] = $total['num'] - Complaint::getComplaintTotal(strtotime($start_date."-01 -1 month"),$province_id);

	$data['total'] = $total;

	$row_count = Complaint::customAnalayzeCount($param);

	$data['month'] = Complaint::complaintsAnalayzeMonth($param);

	// $data['provinces'] = implode(',',Complaint::complaintsAnalayzeProvince($param)['province']);
	// $data['complaints'] = implode(',',Complaint::complaintsAnalayzeProvince($param)['complaints']);
	$tmp = Complaint::complaintsAnalayzeProvince($param);
	$provincesData = $tmp['province'];
	$complaintsData = $tmp['complaints'];
	$province = Info::getProvince();
	foreach ($province as $key => $value) {
		$data['provinceMap'][$key] = $value['name'];
		$province[$key] = $data['provinces'][$key]['name'] = $data['complaints'][$key]['name'] = $value['name'];
		$data['provinces'][$key]['score'] = $provincesData[$key];
		$data['complaints'][$key]['score'] = $complaintsData[$key];
		// $data['provinces']['name'] = $provincesData[$key];
	}

	array_multisort($provincesData, SORT_DESC, $province, SORT_ASC, $data['provinces']); 
	array_multisort($complaintsData, SORT_DESC, $province, SORT_ASC, $data['complaints']); 
	$proName = $proScore = array();
	foreach ($data['provinces'] as $key => $value) {
		if (!$value['name'] || $value['score'] == 0)
			continue;
		$proName[] = $value['name'];
		$proScore[] = $value['score'];
	}
	foreach ($data['complaints'] as $key => $value) {
		$comName[] = $value['name'];
		$comScore[] = $value['score'];
	}

	$data['provinces'] = implode(',', $proScore);
	$data['complaints'] = implode(',', $comScore);

	// foreach ($province as $key => $value) {
	// 	$data['provinceMap'][$key] = $value['name'];
	// }
	$data['provinceString'] = '"'.implode('","', $proName).'"';
	$data['provinceString2'] = '"'.implode('","', $comName).'"';

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
$page_html=Pagination::showPager("custom_analyze.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);
$export_excel="custom_analyze.php?download=1&class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date";


Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );
// Template::assign("output" ,$output);
Template::display ('complaint/complaints_analyze.tpl');



//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "省市\t统计月份\t月工信部投诉量\t环比增长量\t环比增长率\t不规范定制/业务收入(百万)\n ";

 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

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