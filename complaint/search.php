<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','sp_name','sp_corp_code','complaint_type','question_type','complaint_level','buss_line','sp_code');
$start_date = $end_date = $page_no = $province_id = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $question_type = $complaint_level = $buss_line = $sp_code =$start_date = $end_date ="";

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
if($start_date != ''){
	$page_size = PAGE_SIZE;
	$page_no=$page_no<1?1:$page_no;
	$start = ($page_no - 1) * $page_size;

	$data['result'] = Complaint::search($param,$start,$page_size);

	$row_count = Complaint::searchCount($param);
}

$data['province'] = Info::getProvince(false);

$data['complaintType'] = Info::getComplaintType('complaint_type',false);
$data['questionType'][1] = Info::getQuestionType(1,'question_type',true);
$data['questionType'][2] = Info::getQuestionType(2,'question_type',true);
$data['questionType'][3] = Info::getQuestionType(3,'question_type',true);
$data['complaintLevel'] = Info::getComplaintLevel('complaint_level',false);
$data['bussLine'] = Info::getBussLine('buss_line',false);

//导出excel下载
if($_GET['download']==1)
{
	$data['result'] = Complaint::search($param,$start,0);
	$downloadStr=array_to_string($data);
	Common::exportExcel($downloadStr,$filename) ;
	exit;
}
$page_html=Pagination::showPager("search.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
$export_excel="search.php?download=1&".$http_query;

// $page_html=Pagination::showPager("search.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);

Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign ( '_GET', $_GET );
Template::assign("data" ,$data);
Template::assign("param" ,$param);
Template::assign ( 'page_html', $page_html );
Template::assign ( 'export_excel', $export_excel );

// Template::assign("output" ,$output);
Template::display ('complaint/search.tpl');


//列表数据转化为字符串
function array_to_string($data) {
		if(empty($data)||!isset($data['result'])||empty($data['result'])) {
			$dataStr="没有符合您要求的数据！^_^";
		}
		else {
	 		$dataStr = "省市\t工单时间\t投诉号码\t具体业务名称\t统计月份\tsp公司名称\tsp企业代码\tsp接入代码\t投诉内容\t处理意见\t投诉类型\t投诉问题分类\t投诉分级\t业务线\n ";
	 		
	 		$size_result = count($data['result']);
	 		
			for($i = 0 ; $i < $size_result ; $i++) {
				$dataStr.=$data['province'][$data['result'][$i]['province_id']]['name']."\t";
				if($data['result'][$i]['order_time']=="")
				{
					$dataStr.="\t";
				}
				else {
					$dataStr.=date('Y-m-d H:i:s',$data['result'][$i]['order_time'])."\t";
				}
				$dataStr.=$data['result'][$i]['complaint_phone']."\t";
				$dataStr.=$data['result'][$i]['buss_name']."\t";
				//var_dump($data['result'][$i]['month']);exit;
				$dataStr.=date('Y-m',$data['result'][$i]['month'])."\t";
				$dataStr.=$data['result'][$i]['sp_name']."\t";
				$dataStr.=$data['result'][$i]['sp_corp_code']."\t";
				$dataStr.=$data['result'][$i]['sp_code']."\t";
				$dataStr.=preg_replace('/\s/iu', ' ', $data['result'][$i]['complaint_content'])."\t";
				$dataStr.=preg_replace('/\s/iu', ' ', $data['result'][$i]['suggestion'])."\t";
				$dataStr.=$data['result'][$i]['complaint_type']."\t";
				$dataStr.=$data['result'][$i]['problem_type']."\t";
				$dataStr.=$data['result'][$i]['complaint_level']."\t";
				$dataStr.=$data['result'][$i]['buss_line']."\n";
			}
			
		}
		$dataStr = mb_convert_encoding($dataStr,"gb2312","UTF-8");
		return $dataStr;
	}

