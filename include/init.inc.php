<?php
error_reporting( E_ALL );
require 'config/config.inc.php';
session_start();
function OSAdminAutoLoad($classname){
	
	$filename = str_replace('_', '/', $classname) . '.class.php';
    // class类
    $filepath = ADMIN_BASE_CLASS . $filename;
    if (file_exists($filepath)) {
        return include $filepath;
    }else{
		//仅对Class仅支持一级子目录
		//如果子目录中class文件与CLASS根下文件同名，则子目录里的class文件将被忽略

		$handle=opendir(ADMIN_BASE_CLASS);
		
		while (false !== ($file = readdir($handle))) {
			if (is_dir(ADMIN_BASE_CLASS. "/" . $file)) {
				$filepath=ADMIN_BASE_CLASS."/".$file."/".$filename;
				if (file_exists($filepath)) {
					return include $filepath;
				}
			}
		}
	}
    //lib库文件
    $filepath = ADMIN_BASE_LIB . $filename;
    if (file_exists($filepath)) {
        return include $filepath;
    }

    throw new Exception( $filepath . ' NOT FOUND!');
}
spl_autoload_register('OSAdminAutoLoad');

if(!isset($_SESSION['osa_timezone'])){
		$timezone = System::get('timezone');
		$_SESSION['osa_timezone']=$timezone;
}

date_default_timezone_set($_SESSION['osa_timezone']);

/*
不需要登录就可以访问的链接，也可以是某个目录，不含子目录
如"/nologin/","/nologin/aaa/"
*/

$no_need_login_page=array("/block.php","/panel/login.php","/panel/logout.php",);

//如果不需要登录就可以访问的话
$action_url = Common::getActionUrl();
if( OSAdmin::checkNoNeedLogin($action_url,$no_need_login_page) ){	
	//for login.php logout.php etc....
	;
}else{
	//else之后 需要验证登录信息
	if(empty($_SESSION[UserSession::SESSION_NAME])){
		$user_id=User::getCookieRemember();
		if($user_id>0){
			User::loginDoSomething($user_id);
		}
	}
	
	User::checkLogin();
	
	User::checkActionAccess();
	$current_user_info=UserSession::getSessionInfo();
	//如果非ajax请求
	if(stripos($_SERVER['SCRIPT_NAME'],"/ajax")===false){
		//显示菜单、导航条、模板
		$sidebar = SideBar::getTree ();
		//是否显示quick note
		if($current_user_info['show_quicknote']){
			OSAdmin::showQuickNote();
		}
		
		$menu = MenuUrl::getMenuByUrl(Common::getActionUrl());
		Template::assign ( 'page_title', $menu['menu_name']);
		Template::assign ( 'content_header', $menu );
		Template::assign ( 'sidebar', $sidebar );
		Template::assign ( 'current_module_id', $menu['module_id'] );
		Template::assign ( 'user_info', UserSession::getSessionInfo());
	}
}

 $user_info = UserSession::getSessionInfo();
		
					$role_menu_url = MenuUrl::getMenuByRole ( $user_info['user_role']); 
					$menus = array(
							'客诉分析'=>array(
									'数据导入'=>'/complaint/import.php',
								),
							'基本信息分析'=>array(
									'全网SP信息查询'=>'/complaint/sp_search.php',
									'客户投诉查询'=>'/complaint/search.php',
									'客户投诉分析'=> array(
											'全国投诉情况分析'=>'/complaint/analyze.php',
											'sp公司投诉情况分析'=>'/complaint/sp_analyze.php',
											'单产品投诉情况'=>'/complaint/single.php'
										),
								),
							'不规范定制分析'=>array(
									'不规范定制查询'=>'/complaint/custom_search.php',
									'客户投诉分析'=> array(
											'全国投诉情况分析'=>'/complaint/custom_analyze.php',
											'sp公司投诉情况分析'=>'/complaint/custom_sp_analyze.php',
											'单产品投诉情况'=>'/complaint/custom_single.php'
										),
								),
							'工信部投诉分析'=>array(
									'全网SP信息查询'=>'/complaint/complaints_sp_search.php',
									'工信部投诉查询'=>'/complaint/complaints_search.php',
									'客户投诉分析'=> array(
											'全国投诉情况分析'=>'/complaint/complaints_analyze.php',
											'sp公司投诉情况分析'=>'/complaint/complaints_sp_analyze.php',
											'单产品投诉情况'=>'/complaint/complaints_single.php'
										),
								),
							'黑名单'=>'/complaint/black_list.php',
							'数据字典'=>array(
											'投诉类型及问题分类管理'=>'/complaint/complaints_type_manage.php',
											'投诉分级管理'=>'/complaint/complaints_level_manage.php',
											'全网联通在信业务-sp名单'=>'/complaint/unicom_business_sp_list.php',
											'全网联通在信业务-业务信息'=>'/complaint/unicom_business_list.php'
										),
						);
					$m = '<ul class="top_ul" >';
					foreach ($menus as $k1 => $menu1) {
						$m1 = '';
						if(!is_array($menu1)){
							$m .= '<li class="top_li" style="border-left: 3px solid #12AEFF;"><a href="'.$menu1.'">'.$k1.'</a></li>';
							continue;
						}
						foreach ($menu1 as $k2 => $menu2) {
							$m2 = '';
							$flag2 = 0;
							$arr = array();
							if(is_array($menu2)){
								$flag3 = 0;
								$tmp = '';
								foreach ($menu2 as $k3 => $menu3) {
									if(in_array($menu3, $role_menu_url)){
										$flag3 = 1;
										$tmp .= '<li class="third_li"><a href="'.$menu3.'">'.$k3.'</a></li>';
									}
								}
								if($flag3) {
									$m2 .= '<li class="second_li">'.$k2.'</li><ul class="third_ul">'.$tmp.'</ul>';
								}
							}else{
								if(in_array($menu2, $role_menu_url)){
									$flag2 = 1;

									$m1 .= '<li class="second_li"><a href="'.$menu2.'">'.$k2.'</a></li>';
								}
							}

							if($flag3) {
								$m1 = $m1 . $m2; 
							}
						}
						if($flag2 || $flag3 && $m1) {
							$m .= '<li class="top_li" style="border-left: 3px solid #12AEFF;">'.$k1.'</li><ul class="second_ul">'.$m1.'</ul>';

						}
					}
					$m .= '</ul>';
					// var_dump($m);exit;

					


Template::assign ( 'osa_templates', $OSA_TEMPLATES);
$sidebarStatus=$_COOKIE['sidebarStatus']==null?"yes":$_COOKIE['sidebarStatus'];
Template::assign ( 'sidebarStatus', $sidebarStatus);
Template::assign ( 'isLogin', 0);
Template::assign( 'menu', $m);
?>