<?php
require ('../include/init.inc.php');
$method = $id = $keywords='';
extract ( $_REQUEST, EXTR_IF_EXISTS );

if($method=='update' && $id>0)
{
	$complaints_type = Complaint::getComplaintsTypeById ( $id );
	if(empty($complaints_type)){
		echo -1;exit;
	}
	
	if (Common::isPost ()) {
		$update_data = array ('keywords' => $keywords, 'update_time' => date('Y-m-d H:i:s',time()));
		$result = Complaint::updateComplaintsTypeKeywords ( $id,$update_data );
		
		if ($result>=0) {
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'ComplaintsTypeKeywords' ,$id, json_encode($update_data) );
			echo 1;exit;
			//Common::exitWithSuccess ( '投诉分级关键词修改完成','complaints/complaints_type_manage.php' );
		} else {
			 
			echo -2;exit;
		}
		
	}
}


$complaints_types = Complaint::getAllComplaintsType();

Template::assign ( 'complaints_types', $complaints_types );
Template::display ( 'complaint/complaints_type_manage.tpl' );
