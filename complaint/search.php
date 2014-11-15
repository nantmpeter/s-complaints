<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$arr = array('start_date','end_date','province_id','buss_name','sp_name','sp_corp_code','complaint_type','problem_type','complaint_level','buss_line','sp_code');
$start_date = $end_date = $page_no = $province_id = $buss_name = $sp_name = $sp_corp_code = $complaint_type = $problem_type = $complaint_level = $buss_line = $sp_code =$start_date = $end_date ="";

$method=$start_date='';

extract ( $_REQUEST, EXTR_IF_EXISTS );
$user_info = UserSession::getSessionInfo();
$province_id = $user_info['province_id']?$user_info['province_id']:$province_id;
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);


if($method=='updateComplaintLevelAndType' && $start_date!='')
{
	set_time_limit(0);
	$complaints_levels=Complaint::getAllComplaintsLevel();
	
	$complaints_types=Complaint::getAllComplaintsType();
	//一天只能被更新一次
	$curDate=date('Y-m-d');
	$complaints=Complaint::search(array('start_date'=>$start_date,
				"update_complaint_level_and_type[!]"=>$curDate),0,100);

	$successNum=0;
	while($complaints&&count($complaints)>0)
	{
		foreach($complaints as $k=>$v)
		{
			//var_dump($v['complaint_content'],$v['suggestion']);
			$complaint_level='一般投诉';
			$find_level=0;
			if($v['complaint_content']!=''||$v['suggestion']!='')
			{
				foreach($complaints_levels as $k1=>$v1)
				{
					if($v1['keywords']=='')
					{
						break;
					}
					$keywordArr=explode('|', $v1['keywords']);
					foreach($keywordArr as $v2)
					{
						if($v['complaint_content']!=''&&mb_strpos($v['complaint_content'], $v2,0,'utf8')!==false)
						{
							$complaint_level=$v1['complaints_level'];
							$find_level=1;
							break;
						}
						if($v['suggestion']!=''&&mb_strpos($v['suggestion'], $v2,0,'utf8')!==false)
						{
							$complaint_level=$v1['complaints_level'];
							$find_level=1;
							break;
						}
					}
					if($find_level==1)
					{
						break;
					}
				}
			}
			$complaint_type='用户愿意';
			$problem_type='用户自行定制业务';
			$find_type=0;
			if($v['complaint_content']!=''||$v['suggestion']!='')
			{
				foreach($complaints_types as $k3=>$v3)
				{
					if($v3['keywords']=='')
					{
						break;
					}
					$keywordArr=explode('|', $v3['keywords']);
					
					
					foreach($keywordArr as $v4)
					{
						if($v['complaint_content']!=''&&mb_strpos($v['complaint_content'], $v4,0,'utf8')!==false)
						{
							$complaint_type=$v1['complaints_type'];
							$problem_type=$v1['complaints_problem_type'];
							$find_type=1;
							break;
						}
						if($v['suggestion']!=''&&mb_strpos($v['suggestion'], $v4,0,'utf8')!==false)
						{
							$complaint_type=$v1['complaints_type'];
							$problem_type=$v1['complaints_problem_type'];
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
			
			$update_complaint_level_and_type=$curDate;
			$ret=Complaint::updateComplaintLevelAndType($v['id'],
					array("complaint_level"=>$complaint_level,
						"complaint_type"=>$complaint_type,
						"problem_type"=>$problem_type,
						"update_complaint_level_and_type"=>$update_complaint_level_and_type));
			if($ret>0)
			{
				$successNum++;
			}
			
		}
		
		$complaints=Complaint::search(array('start_date'=>$start_date,
				"update_complaint_level_and_type[!]"=>$curDate),0,100);
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
//var_dump($param);exit;
$data['complaintType'] = Info::getComplaintType('complaint_type',false);
$data['questionType'][1] = Info::getQuestionType(1,'problem_type',true,$problem_type);
$data['questionType'][2] = Info::getQuestionType(2,'problem_type',true,$problem_type);
$data['questionType'][3] = Info::getQuestionType(3,'problem_type',true,$problem_type);

$data['complaintLevel'] = Info::getComplaintLevel('complaint_level',false);

//var_dump($param,$complaint_level);
if($complaint_type!='')
{
	if($complaint_type=='0')
	{
		Template::assign ( 'complaint_type', $complaint_type );
	}
	else {
		if($problem_type!='')
		{
			if($problem_type=='0')
			{
				Template::assign ( 'problem_type', $problem_type );
			}
			else {//var_dump($param['problem_type']);exit;
				Template::assign ( 'problem_type', $param['problem_type'] );
				$questionType = Info::getQuestionType($param['complaint_type'],'question_type',false);
				$param['problem_type']=$questionType[$param['problem_type']];
			}
		}
		Template::assign ( 'complaint_type', $param['complaint_type'] );
		$param['complaint_type']=$data['complaintType'][$param['complaint_type']];
	}
}
if($complaint_level!='')
{
	if($complaint_level=='0')
	{
		Template::assign ( 'complaint_level', $complaint_level );
	}
	else {
		Template::assign ( 'complaint_level', $param['complaint_level'] );
		$param['complaint_level']=$data['complaintLevel'][$param['complaint_level']];
	}
}
$start_date = $param['start_date'] = $_GET['start_date'] = $_GET['start_date']?$_GET['start_date']:date('Y-m');
//var_dump($param);exit;
// if (Common::isPost ()) {
if($start_date != ''){
	$page_size = PAGE_SIZE;
	$page_no=$page_no<1?1:$page_no;
	$start = ($page_no - 1) * $page_size;

	if($_GET['download']==1)
	{
		$data['result'] = Complaint::search($param,$start,0);
	}
	else 
	{
		$data['result'] = Complaint::search($param,$start,$page_size);
	}
	$row_count = Complaint::searchCount($param);
}
$data['province'] = Info::getProvince(false);



$data['bussLine'] = Info::getBussLine('buss_line',false);


//导出excel下载
if($_GET['download']==1)
{
	$downloadStr=array_to_string($data);
	Common::exportExcel($downloadStr,'search') ;
	exit;
}

$page_html=Pagination::showPager("search.php?".$http_query,$page_no,PAGE_SIZE,$row_count);
// $page_html=Pagination::showPager("search.php?class_name=$class_name&user_name=$user_name&start_date=$start_date&end_date=$end_date",$page_no,PAGE_SIZE,$row_count);
$export_excel="search.php?download=1&".$http_query;


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


