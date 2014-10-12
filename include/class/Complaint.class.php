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
		$columns['custom'] = "order_id,sub_order_id,part_name,responsibility_code,responsibility_name,part_code,order_time,buss_type,buss_type_code,buss_name,buss_code,product_name,product_code,complaint_status,appeal_status,user_name,complaint_phone,complaint_type,custom,complaint_total,complaint_content,appeal_content,province_id,cooperative,all_net,order_end_time,complaint_id,deductions,buss_line,month";
		$columns['complaints'] = "complaints_id,case_id,user_name,phone,dispute_phone,address,about_corp,corp_area,type_one,type_two,type_three,buss_one,buss_two,buss_three,buss_four,complaint_source,comfirm_user,complaint_time,get_time,handle_time,complaint_content,complaint10010,10010status,complaint10015,10015status,complaint_status,problem,problem_type,contact_element,element,buss_type,product_type,problem_channel,service_need,buss_way,netproblem,phoneproblem,vipuser,partment";
		$columns['income'] = "province_id,sp_name,sp_code,buss_type,province_income,sp_income,owe,tuipei_cost,imbalance_cost,20_cost,diaozhang_cost,violate_cost,custom_cost,month,mastsp_code,mastsp_cost,mastsp_sleave";
		// unset($param[0]);

		// var_dump(count(explode(',', $columns[$table])),count($param));exit;
		$bussLine = array(
				'联通在信' => 1,
				'彩信' => 2,
			);

		if($table == 'custom') {
			$param[25] = ExcelReader::xlsTime($param[25]);
			$param[6] = ExcelReader::xlsTime($param[6]);
			$param[29] = strtotime($param[29]);
			$param[7] = $bussLine[$param[7]];
			$param[22] = Info::getProvinceByName($param[22]);
			// var_dump(Info::getProvinceByName($param[22]));exit;
		}
		if($table == 'complaints'){
			$param[17] = ExcelReader::xlsTime($param[17]);
			$param[18] = ExcelReader::xlsTime($param[18]);
			$param[19] = ExcelReader::xlsTime($param[19]);
			$param[7] = Info::getProvinceByName($param[7]);
		}
		if($table == 'income'){
			$param[0] = Info::getProvinceByName($param[0]);
			$param[13] = strtotime($param[13]);
		}
		// var_dump($param);exit;
		$sql = "insert into co_". $table ." (".$columns[$table].") values ('".implode("','", $param)."')";
		// echo $sql.'<br>';
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
		$condition["AND"]['order_time[>]'] = strtotime($param['start_date']);
		$condition["AND"]['order_time[<]'] = strtotime($param['end_date']);
		unset($param['start_date'],$param['end_date']);
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		return $db->count('co_base',$condition);
	}

	public static function customSearch($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date'] && $param['end_date']){
			$condition["AND"]['order_time[>]'] = strtotime($param['start_date']);
			$condition["AND"]['order_time[<]'] = strtotime($param['end_date']);
			unset($param['start_date'],$param['end_date']);	
		}

		if($param['month']) {
			$condition["AND"]['month[>]'] = strtotime($param['month'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['month'].'-31');
			unset($param['month']);
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['LIMIT']=array($start,$page_size);

		return $db->select('co_custom','*',$condition);
	}

	public static function customSearchCount($param)
	{
		$condition = array();
		$db=self::__instance();
		if($param['start_date'] && $param['end_date']){
			$condition["AND"]['order_time[>]'] = strtotime($param['start_date']);
			$condition["AND"]['order_time[<]'] = strtotime($param['end_date']);
			unset($param['start_date'],$param['end_date']);	
		}

		if($param['month']) {
			$condition["AND"]['month[>]'] = strtotime($param['month'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['month'].'-31');
			unset($param['month']);
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}

		return $db->count('co_custom',$condition);
	}

		public static function complaintsSearch($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date'] && $param['end_date']){
			$condition["AND"]['complaint_time[>]'] = strtotime($param['start_date']);
			$condition["AND"]['complaint_time[<]'] = strtotime($param['end_date']);
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['LIMIT']=array($start,$page_size);
		return $db->select('co_complaints','*',$condition);
	}

	public static function customAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['order_time[>]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-31');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'province_id';
		$condition['LIMIT']=array($start,$page_size);
		$r = $db->select('co_custom','*,count(*) as num',$condition);

		if($r && isset($start)) {
			$condition["AND"]['order_time[>]'] = strtotime($start.'-01')-3600*24*30;
			$condition["AND"]['order_time[<]'] = strtotime($start.'-31')-3600*24*30;
			$r2 = $db->select('co_custom','*,count(*) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				$r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				$r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));
				$r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('province_id'=>$value['province_id']))['cos']/1000000;
				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;
				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}

		return $r;
	}

	public static function customAnalayzeCount($param)
	{
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			$condition["AND"]['order_time[>]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-31');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'province_id';

		return $db->count('co_custom',$condition);
	}


	public static function customAnalayzeMonth($param)
	{
		$condition = array();
		$db=self::__instance();
		unset($param['province_id']);
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['order_time[>]'] = strtotime(substr($param['start_date'], 0,4).'-01-01');
			$condition["AND"]['order_time[<]'] = strtotime(substr($param['start_date'], 0,4).'-12-31');
			unset($param['start_date'],$param['end_date']);	
		}
		$start = isset($start)?$start:date('Y');
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';
		$r = $db->select('co_custom','count(*) as num,FROM_UNIXTIME(order_time,"%Y-%m") AS m',$condition);
		for ($i = 1;$i<=12;$i++){
			$tmp[substr($start, 0,4).'-'.sprintf('%02s',$i)] = 0;
		}

		foreach ($r as $key => $value) {
			if($value['m'] < substr($start, 0,4).'-01-01')
				continue;
			$tmp[$value['m']] = $value['num'];
		}
		return implode(',', $tmp);
	}

	public static function customAnalayzeArea($param)
	{
		$flag = isset($param['flag'])?$param['flag']:0;
		unset($param['flag']);
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['order_time[>]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-31');
			unset($param['start_date'],$param['end_date']);	
		}
		$start = isset($start)?$start:date('Y');
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'province_id';
		$r = $db->select('co_custom','count(*) as num,province_id',$condition);

		$province = Info::getProvince();
		foreach ($province as $key => $value) {
			$tmpProvince[$value['id']] = 0;
		}

		foreach ($r as $key => $value) {
			if($flag)
				$tmpProvince[$value['province_id']] = 0;
			else
				$tmpProvince[$value['province_id']] = $value['num'];

			$r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('province_id'=>$value['province_id']))['cos']/1000000;
			if($r[$key]['cos'] && $flag)
				$tmpProvince[$value['province_id']] = $value['num']/$r[$key]['cos'];
		}
		return implode(',', $tmpProvince);
	}


	public static function complaintsSearchCount($param)
	{
		$condition = array();
		$db=self::__instance();
		if($param['start_date'] && $param['end_date']){
			$condition["AND"]['complaint_time[>]'] = strtotime($param['start_date']);
			$condition["AND"]['complaint_time[<]'] = strtotime($param['end_date']);
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}

		return $db->count('co_complaints',$condition);
	}
}