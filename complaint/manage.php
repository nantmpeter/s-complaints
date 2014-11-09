<?php
require ('../include/init.inc.php');
$group_id = $province_id = '';
$menu_ids = array ();
extract ( $_REQUEST, EXTR_IF_EXISTS );

$group_id =  $group_id == ""? 1:intval($group_id);

$group_option_list = GroupRole::getGroupForOptions ();
unset($group_option_list[1]);
$group_info = UserGroup::getGroupById ( $group_id );

if(!$group_info){
	$group_id =1;
	$group_info = UserGroup::getGroupById ( $group_id );
}
$role_list = GroupRole::getGroupRoles ( $group_id );
unset($role_list[0]);

$group_role = $group_info ['group_role'];

$group_role_array = explode ( ',', $group_role );

if (Common::isPost ()) {
	if($group_id==1){
		$temp = array();
		foreach ($group_role_array as $group_role){
			
			//系统预留菜单id为100以内
			if($group_role>100){
				$temp[]=$group_role;
			}
		}
		
		$admin_role = array_diff($group_role_array,$temp);
		
		$menu_ids = array_merge($admin_role,$menu_ids);
		$menu_ids = array_unique($menu_ids);
		asort($menu_ids);
	}
	$group_role = join ( ',', $menu_ids );
	$group_data = array ('group_role' => $group_role ,'province_id'=>$province_id);

	$result = UserGroup::updateGroupInfo ( $group_id, $group_data );
	if ($result>=0) {
		SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'UserGroup' ,$group_id, json_encode($group_data) );
		UserSession::reload();
		Common::exitWithSuccess (ErrorMessage::SUCCESS_NEED_LOGIN,'complaint/manage.php');
	}else{
		OSAdmin::alert("error");
	}	
}
$province_id = $group_info['province_id'];

$data['province'] = Info::getProvince(false);

Template::assign ( 'data', $data );
Template::assign ( 'province_id', $province_id );
Template::assign ( 'role_list', $role_list );
Template::assign ( 'group_id', $group_id );
Template::assign ( 'group_option_list', $group_option_list );
Template::assign ( 'group_role', $group_role_array );
Template::display ( 'complaint/manage.tpl' );