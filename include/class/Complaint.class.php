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
		$columns['custom'] = "order_id,sub_order_id,part_name,responsibility_code,responsibility_name,part_code,order_time,buss_type,buss_type_code,buss_name,buss_code,product_name,product_code,complaint_status,appeal_status,user_name,complaint_phone,complaint_type,custom,complaint_total,complaint_content,appeal_content,province_id,cooperative,all_net,order_end_time";
		$columns['complaints'] = "complaints_id,case_id,user_name,phone,dispute_phone,address,about_corp,corp_area,type_one,type_two,type_three,buss_one,buss_two,buss_three,buss_four,complaint_source,comfirm_user,complaint_time,get_time,handle_time,complaint_content,complaint10010,10010status,complaint10015,10015status,complaint_status,problem,problem_type,contact_element,element,buss_type,product_type,problem_channel,service_need,buss_way,netproblem,phoneproblem,vipuser,partment";
		$columns['income'] = "province_id,sp_code,sp_name,buss_type,province_income,sp_income,sp_sleave,sp_clear_data,owe,tuipei_cost,imbalance_cost,20_cost,diaozhang_cost,violate_cost,custom_cost";
		unset($param[0]);
		// var_dump(count(explode(',', $columns[$table])),count($param));
		$sql = "insert into co_". $table ." (".$columns[$table].") values ('".implode("','", $param)."')";
		// echo $sql;
		$db=self::__instance();
		return $db->query ($sql);
	}

	public static function search($param,$start = 0,$page_size=20){
		$db=self::__instance();
		$condition["AND"]['order_time[>]'] = strtotime($param['start_date']);
		$condition["AND"]['order_time[<]'] = strtotime($param['end_date']);
		unset($param['start_date'],$param['end_date']);
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['LIMIT']=array($start,$page_size);

		return $db->select('co_base','*',$condition);
	}

	public static function searchCount($param)
	{
		$condition = array();
		$db=self::__instance();
		return $db->count('co_base',$condition);
	}
}