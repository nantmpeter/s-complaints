<?php
if(!defined('ACCESS')) {exit('Access denied.');}
class Info extends Base{
	public static function getProvince($format = false)
	{
		$db=new Medoo(OSA_DB_ID);
		$r = $db->select('province','*');
		if($format) {
			$html = '<select name="province" id="DropDownTimezone"><option value="0" id="DropDownTimezone-0">全部</option>';

			foreach ($r as $key => $value) {
				$html.='<option value="'.$value['id'].'" id="DropDownTimezone-0">'.$value['name'].'</option>';
			}
			$html.='</select>'; 
			$r = $html;
		}
		return $r;
	}


	public static function getComplaintType($name,$format = false)
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

	public static function getQuestionType($class,$name,$format=false)
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
						1 => '客户自行定制业务'
					)
			);
		if(isset($r[$class])) {
			if($format)
				$r[$class] = self::format($r[$class],$name);
			return $r[$class];
		}
	}

	private static function format($result,$name) {
		$html = '<select name="'.$name.'"><option value="0">全部</option>';

			foreach ($result as $key => $value) {
				$html.='<option value="'.$key.'">'.$value.'</option>';
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
}