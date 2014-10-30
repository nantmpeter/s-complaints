<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','corp_area','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code','case_id','complaint_time','dispute_phone','sp_corp_name','product_type');
$start_date = $end_date = $page_no = $corp_area = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date = $case_id = $complaint_time = $dispute_phone = $sp_corp_name = $product_type = "";

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
$start_date = $param['start_date'] = $_GET['start_date'] = $_GET['start_date']?$_GET['start_date']:date('Y-m');

// if (Common::isPost ()) {
// if($start_date != '' && $end_date !=''){
	$page_size = PAGE_SIZE;
	$page_no=$page_no<1?1:$page_no;
	$start = ($page_no - 1) * $page_size;

	$data['result'] = Complaint::complaintsSearch($param,$start,$page_size);

	$row_count = Complaint::complaintsSearchCount($param);
// }
$data['product_type'] = Info::getProductType();
$data['province'] = Info::getProvince(false);
$data['complaintType'] = Info::getComplaintType('complaint_type',false);
$data['questionType'][1] = Info::getQuestionType(1,'question_type',true);
$data['questionType'][2] = Info::getQuestionType(2,'question_type',true);
$data['questionType'][3] = Info::getQuestionType(3,'question_type',true);
$data['complaintLevel'] = Info::getComplaintLevel('complaint_level',false);
$data['bussType'] = Info::getBussLine('buss_type',true);

$page_html=Pagination::showPager("complaints_search.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
// $page_html=Pagination::showPager("complaints_search.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date&case_id=$case_id&complaint_time=$complaint_time&dispute_phone=$dispute_phone&sp_corp_name=$sp_corp_name",$page_no,PAGE_SIZE,$row_count);

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
// Template::assign("output" ,$output);
Template::display ('complaint/complaints_search.tpl');