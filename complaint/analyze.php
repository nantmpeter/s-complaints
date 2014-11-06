<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name_detail','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code');
$start_date = $end_date = $page_no = $province_id = $buss_name_detail = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date ="";

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

	if($_GET['download']==1)
	{
		$result = Complaint::baseAnalayze($param,$start,0);
	}
	else 
	{
		$result = Complaint::baseAnalayze($param,$start,$page_size);
	}
	

	foreach ($result['now'] as $key => $value) {
		$resultProvince[] = $value['province_id'];
	}

	$row_count = Complaint::baseAnalayzeCount($param);

	$data['month'] = Complaint::baseAnalayzeMonth($param);

	// $data['provinces'] = Complaint::baseAnalayzeArea($param);
	$province = $strProvince = Info::getProvince();
		foreach ($province as $key => $value) {
			$tmpProvince[$value['id']] = $tmpProvince2[$value['id']] = 0;
		}

		$tmp = array();
		$total = array('province_id'=>'总计','num'=>0,'cos'=>0,'wan'=>0,'increase');
		foreach ($result['now'] as $key => $value) {
				if ($value['province_id']) {
					$total['num'] += $value['num'];
					$total['cos'] += $value['cos'];
					$total['wan'] += $value['wan'];
					$total['month'] = date('Y-m',$value['month']);
					// $total['increase'] += $value['increase'];
					$tmpProvince[$value['province_id']] = $value['num'];
					$rand = rand(0,100);
					$tmp[(string)($value['num']+$rand/100)] = $province[$value['province_id']]['name'];
					unset($strProvince[$value['province_id']]);

				}

		}
		$total['increase'] = $total['num'] - Complaint::getBaseTotal(strtotime(date('Y-m-d',$value['month'])." -1 month"),$province_id);
		$data['total'] = $total;
		// var_dump($total);
		// $result['now'] = $result['now']+array($total);
		$data['result'] = $result['now'];

		// var_dump($result['now']);
		// var_dump($total);
		krsort($tmp);

		foreach ($result['last'] as $key => $value) {
				if ($value['province_id']) {
					$tmpProvince2[$value['province_id']] = $value['num'];
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

	$baseTwoMonthWan = Complaint::baseTwoMonthWan($param,$resultProvince);

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
//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	Common::exportExcel($downloadStr,'analyze') ;
	exit;
}
$page_html=Pagination::showPager("custom_analyze.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);

$export_excel="analyze.php?download=1&class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date";

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );
// Template::assign("output" ,$output);
Template::display ('complaint/analyze.tpl');



//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "省市\t统计月份\t月投诉件数\t环比增长量\t环比增长率\t投诉量/业务收入(万)\n ";
 		
 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

			$dataStr.=$data['provinceMap'][$data['result'][$i]['province_id']]."\t";

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
