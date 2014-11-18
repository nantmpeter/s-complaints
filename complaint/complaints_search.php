<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','corp_area','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_type','sp_code','case_id','complaint_time','dispute_phone','sp_corp_name','buss_class','appeal_date');
$start_date = $end_date = $page_no = $corp_area = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_type = $sp_code =$start_date = $end_date = $case_id = $complaint_time = $dispute_phone = $sp_corp_name = $buss_class = $appeal_date = "";
$method=$start_date='';

extract ( $_REQUEST, EXTR_IF_EXISTS );
$user_info = UserSession::getSessionInfo();
$province_id = $user_info['province_id']?$user_info['province_id']:$province_id;
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);


//var_dump($method,$start_date);exit;
if($method=='updateComplaintProblemType' && $start_date!='')
{
	set_time_limit(0);
	
	$complaints_types=Complaint::getAllComplaintsType();
	//一天只能被更新一次
	$curDate=date('Y-m-d');
	$complaints=Complaint::complaintsSearch(array('start_date'=>$start_date,
				"update_complaint_problem_type[!]"=>$curDate),0,100);

	$successNum=0;
	while($complaints&&count($complaints)>0)
	{
		foreach($complaints as $k=>$v)
		{
			
			$complaints_problem_type='用户自行定制业务';
			$find_type=0;
			if($v['complaint_content']!='')
			{
				
				foreach($complaints_types as $k3=>$v3)
				{
					if($v3['keywords']=='')
					{
						continue;
					}
					$keywordArr=explode('|', $v3['keywords']);
					
					
					foreach($keywordArr as $v4)
					{
						if($v['complaint_content']!=''&&mb_strpos($v['complaint_content'], $v4,0,'utf8')!==false)
						{
							$complaints_problem_type=$v1['complaints_problem_type'];
							$find_type=1;
							break;
						}
						
					}
					if($find_type==1)
					{
						break;
					}
				}
			}
			
			$update_complaint_problem_type=$curDate;
			$ret=Complaint::updateComplaintProblemType($v['id'],
					array(
						"complaints_problem_type"=>$complaints_problem_type,
						"update_complaint_problem_type"=>$update_complaint_problem_type));
			if($ret>0)
			{
				$successNum++;
			}
			
		}
		
		$complaints=Complaint::complaintsSearch(array('start_date'=>$start_date,
				"update_complaint_problem_type[!]"=>$curDate),0,100);
		if($successNum>900)
		{
			$complaints=false;
		}
	}
	
	echo "更新成功".$successNum."个";exit;
}


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
		$data['result'] = Complaint::complaintsSearch($param,$start,0);
	}
	else 
	{
		$data['result'] = Complaint::complaintsSearch($param,$start,$page_size);
	}

	$row_count = Complaint::complaintsSearchCount($param);
// }
$data['buss_class'] = Info::getProductType();
$data['province'] = Info::getProvince(false);
$data['complaintType'] = Info::getComplaintType('complaint_type',false);
$data['questionType'][1] = Info::getQuestionType(1,'question_type',true);
$data['questionType'][2] = Info::getQuestionType(2,'question_type',true);
$data['questionType'][3] = Info::getQuestionType(3,'question_type',true);
$data['complaintLevel'] = Info::getComplaintLevel('complaint_level',false);
$data['bussType'] = Info::getBussLine('buss_type',true);
//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	//var_dump($data);exit;
	Common::exportExcel($downloadStr,'black_list') ;
	exit;
}
$page_html=Pagination::showPager("complaints_search.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
// $page_html=Pagination::showPager("complaints_search.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date&case_id=$case_id&complaint_time=$complaint_time&dispute_phone=$dispute_phone&sp_corp_name=$sp_corp_name",$page_no,PAGE_SIZE,$row_count);
$export_excel="complaints_search.php?download=1&".$http_query;

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );
// Template::assign("output" ,$output);
Template::display ('complaint/complaints_search.tpl');


//列表数据转化为字符串
function array_to_string($data) {
	if(empty($data)||!isset($data['result'])||empty($data['result'])) {
		$dataStr="没有符合您要求的数据！^_^";
	}
	else {
 		$dataStr = "省市\t案件编号\t申诉日期\t投诉号码\t产品类别\t业务名称\tsp公司名称\tsp企业代码\tsp接入代码\t投诉内容\t申诉内容\t申诉核查情况\t投诉问题分类\t业务线\n ";

 		$size_result = count($data['result']);
 		
		for($i = 0 ; $i < $size_result ; $i++) {

			$dataStr.=$data['province'][$data['result'][$i]['corp_area']]['name']."\t";
			$dataStr.=$data['result'][$i]['case_id']."\t";
			$dataStr.=date('Y-m-d H:i:s',$data['result'][$i]['complaint_time'])."\t";

			$dataStr.=$data['result'][$i]['phone']."\t";
			$dataStr.=$data['result'][$i]['product_type']."\t";
			$dataStr.=$data['result'][$i]['buss_name']."\t";
			$dataStr.=$data['result'][$i]['sp_corp_name']."\t";
			$dataStr.=$data['result'][$i]['sp_corp_code']."\t";
			$dataStr.=$data['result'][$i]['sp_code']."\t";
			$dataStr.=preg_replace('/\s/iu', ' ', $data['result'][$i]['complaint_content'])."\t";
			$dataStr.=preg_replace('/\s/iu', ' ', $data['result'][$i]['10010status'])."\t";
			$dataStr.=preg_replace('/\s/iu', ' ', $data['result'][$i]['complaint_status'])."\t";
			$dataStr.=$data['result'][$i]['problem_type']."\t";
			$dataStr.=$data['result'][$i]['buss_type']."\n";
		}
		
	}
	$dataStr = mb_convert_encoding($dataStr,"gb2312","UTF-8");
	return $dataStr;
}
