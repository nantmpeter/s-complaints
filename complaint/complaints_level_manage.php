<?php
require ('../include/init.inc.php');
$method = $id = $keywords='';
extract ( $_REQUEST, EXTR_IF_EXISTS );

if($method=='update' && $id>0)
{
	$complaints_level = Complaint::getComplaintsLevelById ( $id );
	if(empty($complaints_level)){
		echo -1;exit;
	}
	
	if (Common::isPost ()) {
		$update_data = array ('keywords' => $keywords, 'update_time' => date('Y-m-d H:i:s',time()));
		$result = Complaint::updateComplaintsLevelKeywords ( $id,$update_data );
		
		if ($result>=0) {
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'ComplaintsLevelKeywords' ,$id, json_encode($update_data) );
			echo 1;exit;
			//Common::exitWithSuccess ( '投诉分级关键词修改完成','complaints/complaints_level_manage.php' );
		} else {
			 
			echo -2;exit;
		}
		
	}
}


$complaints_levels = Complaint::getAllComplaintsLevel();

Template::assign ( 'complaints_levels', $complaints_levels );
Template::display ( 'complaint/complaints_level_manage.tpl' );
