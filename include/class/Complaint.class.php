<?php
if(!defined('ACCESS')) {exit('Access denied.');}
class Complaint extends Base {

	// 表名
	// private static $table_name = 'co_base';

	//状态定义
	
	public static function getTableName(){
		return parent::$table_prefix.self::$table_name;
	}

	public static function save($param,$table){
		$columns['base'] = "province_id,order_id,order_time,complaint_phone,complaint_content,sp_name,sp_corp_code,sp_code,suggestion,order_department,buss_department,buss_name,buss_name_detail,buss_rates,problem,reconciliations,charge_back,buss_type,buss_type_name,complaint_type,problem_type,problem_result,complaint_level,buss_line,work_id";
		$columns['custom'] = "id,order_id,sub_order_id,part_name,responsibility_code,responsibility_name,part_code,order_time,buss_type,buss_type_code,buss_name,buss_code,complaint_status,appeal_status,user_name,complaint_phone,complaint_type,custom,complaint_total,complaint_content,appeal_content,province_id,cooperative,all_net,order_end_time";
		unset($param[0]);
		$sql = "insert into co_". $table ." (".$columns[$table].") values ('".implode("','", $param)."')";

		$db=self::__instance();
		return $db->query ($sql);
	}
}