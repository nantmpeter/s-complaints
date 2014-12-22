<?php
if(!defined('ACCESS')) {exit('Access denied.');}
class Info extends Base{
	public static function getProvince($format = false)
	{
		$db=new Medoo(OSA_DB_ID);
		$r = $db->select('province','*',array('ORDER'=>'pinyin'));
		$tmp = array();
		foreach ($r as $key => $value) {
			$tmp[$value['id']] = $value;
		}
		$r = $tmp;
		if($format) {
			$user_info = UserSession::getSessionInfo();
			$html = '<select name="province" id="DropDownTimezone"><option value="0" id="DropDownTimezone-0">全部</option>';
			if($user_info && $user_info['province_id'] > 0) {
				$html.='<option value="'.$user_info['province_id'].'" id="DropDownTimezone-0">'.$r[$user_info['province_id']]['name'].'</option>';
			}else{
				foreach ($r as $key => $value) {
					$html.='<option value="'.$value['id'].'" id="DropDownTimezone-0">'.$value['name'].'</option>';
				}
			}
			$html.='</select>'; 
			$r = $html;
		}
		return $r;
	}


	public static function getComplaintType($name = '',$format = false)
	{
		$r = array(
				1 => '服务规范性',
				2 => '业务可用性',
				3 => '用户原因',
			);
		if($format) {
			$r = self::format($r,$name);
		}
		return $r;
	}

	public static function getQuestionType($class,$name = '',$format=false,$problem_type=0)
	{
		$r = array(
				1 => array(
						1 => '定制不规范',
						2 => '业务取消不规范',
						3 => '资费不明确',
						4 => '收费不规范',
						5 => '业务信息不规范',
						6 => '其他',
					),
				2 => array(
						1 => '产品功能设计不完善',
						2 => '内容设计不合理',
						3 => '系统支撑不到位业务不可用',
						4 => '其他',
					),
				3 => array(
						1 => '用户自行定制业务'
					)
			);
		if(isset($r[$class])) {
			if($format)
				$r[$class] = self::format($r[$class],$name,$problem_type);
			return $r[$class];
		}
	}
	
	private static function format($result,$name,$problem_type=0) {
		$html = '<select name="'.$name.'"><option value="0">全部</option>';

			foreach ($result as $key => $value) {
				if($problem_type==$key)
				{
					$seleced="selected=selected";
				}
				else {
					$seleced='';
				}
				$html.='<option '.$seleced.' value="'.$key.'">'.$value.'</option>';
			}
			$html.='</select>'; 
			return $html;
	}

	public static function getComplaintLevel($name,$format = false)
	{
		$r = array(
				1 => '一般投诉',
				2 => '疑难投诉',
				3 => '越级投诉',
			);
				if($format) {
			$r = self::format($r,$name);
		}
		return $r;
	}

	public static function getBussLine($name,$format=false)
	{
		$r = array(
				1 => '联通在信',
				2 => '彩信',
			);
				if($format) {
			$r = self::format($r,$name);
		}
		return $r;
	}

	public static function getProvinceByName($name)
	{
		$db=new Medoo(OSA_DB_ID);
		$r = $db->get('province','id',array('name'=>$name));
		if(isset($r['id']))
			return $r['id'];
		return '';
	}

	public static function getProvinceById($id)
	{
		$db=new Medoo(OSA_DB_ID);
		$r = $db->get('province','name',array('id'=>$id));
		if(isset($r['id']))
			return $r['id'];
		return '';
	}

	public static function getProductType()
	{
		$db=new Medoo(OSA_DB_ID);
		$r = $db->query('SELECT `buss_class` FROM `co_complaints` GROUP BY `buss_class`')->fetchAll();
		$result = array();
		foreach ($r as $key => $value) {
			$result[] = $value['buss_class'];
		}
		return $result;
		// $r = $db->select('co_complaints','product_type',array('group'=>'product_type'));
		var_dump($r);exit;
	}
}