<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code','wan');
$start_date = $end_date = $page_no = $province_id = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date = $wan = "";

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
		$data['result'] = Complaint::customAnalayze($param,$start,0);
	}
	else 
	{
		$data['result'] = Complaint::customAnalayze($param,$start,$page_size);
	}

	$row_count = Complaint::customAnalayzeCount($param);

	$data['month'] = Complaint::customAnalayzeMonth($param);

	$data['provinces'] = Complaint::customAnalayzeArea($param);

	// $tmp = explode(',', $data['provinces']);
	$province = Info::getProvince();

	foreach ($data['provinces'] as $key => $value) {
		$tmp[$key]['score'] = $value;
		$tmp[$key]['name'] = $province[$key]['name'];
	}

	foreach ($tmp as $key => $row) { 
	$volume[$key] = $row['score']; 
	$edition[$key] = $row['name']; 
	} 

	// 将数据根据 volume 降序排列，根据 edition 升序排列 
	// 把 $data 作为最后一个参数，以通用键排序 
	array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $tmp);
	foreach ($tmp as $key => $value) {
		if (!$value['name'])
			continue;
		$name[] = $value['name'];
		$score[] = $value['score'];
	}

	foreach ($province as $key => $value) {
		$data['provinceMap'][$key] = $value['name'];
	}
	$data['provinceString'] = '"'.implode('","', $name).'"';
	$data['provinces'] = implode(',', $score);

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
Template::display ('complaint/custom_analyze.tpl');


//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "省市\t月不规范定制件数\t环比增长量\t环比增长率\t申诉成功\t申诉失败\t未申诉量\t不规范定制/业务收入(百万)\t投诉类型\t业务线\t认定有效量\n ";

 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

			$dataStr.=$data['provinceMap'][$data['result'][$i]['province_id']]."\t";
			$dataStr.=$data['result'][$i]['num']."\t";
			$dataStr.=$data['result'][$i]['increase']."\t";
			$dataStr.=sprintf("%.2f",$data['result'][$i]['increasePercent'])."\t";
			$dataStr.=$data['result'][$i]['appealSuc']."\t";
			$dataStr.=$data['result'][$i]['appealFail']."\t";
			$dataStr.=$data['result'][$i]['appealNot']."\t";
			$dataStr.=sprintf("%.2f",$data['result'][$i]['cos'])."\t";

			$dataStr.=$data['result'][$i]['complaint_type']."\t";
			
			$dataStr.=$data['bussLine'][$data['result'][$i]['buss_type']]."\t";

			$dataStr.=$data['result'][$i]['valid']."\n";
		}
		
	}
	$dataStr = mb_convert_encoding($dataStr,"gb2312","UTF-8");
	return $dataStr;
}