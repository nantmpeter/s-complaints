<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code');
$start_date = $end_date = $page_no = $province_id = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date ="";

extract ( $_GET, EXTR_IF_EXISTS );
$user_info = UserSession::getSessionInfo();
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

	$result = Complaint::baseAnalayze($param,$start,$page_size);

	$data['result'] = $result['now'];
	$row_count = Complaint::baseAnalayzeCount($param);

	$data['month'] = Complaint::baseAnalayzeMonth($param);

	// $data['provinces'] = Complaint::baseAnalayzeArea($param);
	$province = $strProvince = Info::getProvince();
		foreach ($province as $key => $value) {
			$tmpProvince[$value['id']] = $tmpProvince2[$value['id']] = 0;
		}
		$tmp = array();
		foreach ($result['now'] as $key => $value) {
				if ($value['province_id']) {
					$tmpProvince[$value['province_id']] = $value['wan'];
					$rand = rand(0,100);
					$tmp[(string)($value['wan']+$rand/100)] = $province[$value['province_id']]['name'];
					unset($strProvince[$value['province_id']]);
				}
		}
		foreach ($result['last'] as $key => $value) {
				if ($value['province_id']) {
					$tmpProvince2[$value['province_id']] = $value['wan'];
				}
		} 
		rsort($tmpProvince);
		rsort($tmpProvince2);
		$data['provinces'] = implode(',', $tmpProvince);
		$data['provinces2'] = implode(',', $tmpProvince2);

	// $province = Info::getProvince();
	foreach ($province as $key => $value) {
		$data['provinceMap'][$key] = $value['name'];
	}

	$tmpP = array();
	foreach ($strProvince as $key => $value) {
		$tmpP[$key] = $value['name'];
	}

	$data['provinceString'] = '"'.implode('","', array_merge($tmp,$tmpP)).'"';

	$baseTwoMonthWan = Complaint::baseTwoMonthWan($param);
	foreach ($baseTwoMonthWan as $key => $value) {
		$baseTwoMonthWanString[] = $key;
		$baseTwoMonthWanVal[] = $value;
	}
	$data['baseTwoMonthWanString'] = '"'.implode('","', $baseTwoMonthWanString).'"';
	$data['baseTwoMonthWanVal'] = implode(',', $baseTwoMonthWanVal);



// }
$data['province'] = Info::getProvince(false);
$data['complaintType'] = Info::getComplaintType('complaint_type',false);
$data['questionType'][1] = Info::getQuestionType(1,'question_type',true);
$data['questionType'][2] = Info::getQuestionType(2,'question_type',true);
$data['questionType'][3] = Info::getQuestionType(3,'question_type',true);
$data['complaintLevel'] = Info::getComplaintLevel('complaint_level',false);
$data['bussLine'] = Info::getBussLine('buss_type',false);
// var_dump($data['bussLine']);

$page_html=Pagination::showPager("custom_analyze.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
// Template::assign("output" ,$output);
Template::display ('complaint/analyze2.tpl');