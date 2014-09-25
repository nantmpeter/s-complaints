<?php 
header("Content-Type:text/html;charset=utf-8");
require ('../include/init.inc.php');
$user_info = UserSession::getSessionInfo();
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);
if (Common::isPost ()) {
	
}
$data['province'] = Info::getProvince();
Template::assign("error" ,$error);
Template::assign("_POST" ,$_POST);
Template::assign("data" ,$data);
// Template::assign("output" ,$output);
Template::display ('complaint/analyze.tpl');