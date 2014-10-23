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
		$columns['base'] = "province_id,order_id,order_time,complaint_phone,complaint_content,sp_name,sp_corp_code,sp_code,suggestion,order_department,buss_department,buss_name,buss_name_detail,buss_rates,problem,reconciliations,charge_back,buss_type,buss_type_name,complaint_type,problem_type,problem_result,complaint_level,buss_line,work_id,month";
		$columns['custom'] = "order_id,sub_order_id,part_name,responsibility_code,responsibility_name,part_code,order_time,buss_type,buss_type_code,buss_name,buss_code,product_name,product_code,complaint_status,appeal_status,user_name,complaint_phone,complaint_type,custom,complaint_total,complaint_content,appeal_content,province_id,cooperative,all_net,order_end_time,complaint_id,deductions,buss_line,month";
		$columns['complaints'] = "complaints_id,case_id,user_name,phone,dispute_phone,address,about_corp,corp_area,type_one,type_two,type_three,buss_one,buss_two,buss_three,buss_four,complaint_source,comfirm_user,complaint_time,get_time,handle_time,complaint_content,complaint10010,10010status,complaint10015,10015status,complaint_status,problem,problem_type,contact_element,element,buss_type,product_type,problem_channel,service_need,buss_way,netproblem,phoneproblem,vipuser,partment,buss_class,complaint_num,sp_corp_name,sp_corp_code,sp_code,buss_name,complaint_class,buss_line,month";
		$columns['income'] = "province_id,sp_name,sp_code,buss_type,province_income,sp_income,owe,tuipei_cost,imbalance_cost,20_cost,diaozhang_cost,violate_cost,custom_cost,month,mastsp_code,mastsp_cost,mastsp_sleave";
		$columns['value_income'] = "month,buss_type,value,custom_cost";
		$columns['black_list'] = "complaint_phone,province_id,sp_corp_code,month,sp_corp_name,complaint_phone_tag,level,time_limit";
		// unset($param[0]);

		// var_dump(count(explode(',', $columns[$table])),count($param));exit;
		$bussLine = array(
				'联通在信' => 1,
				'彩信' => 2,
			);
		$db=self::__instance();

		if($table == 'base') {
			$param[0] = Info::getProvinceByName($param[0]);
			// $param[6] = ExcelReader::xlsTime($param[6]);
			$param[25] = strtotime($param[25].'01');
			$tmp = array($param[3],$param[0],$param[6],$param[25],$param[5],'',1,'一年');
			$num = $db->count('co_base',array('complaint_phone'=>$param[3]));
			if($num > 0) {
				$db->delete('co_black_list',array('complaint_phone'=>$param[3]));
				$tmp = array($param[3],$param[0],$param[6],$param[25],$param[5],'',2,'五年');
			}
			$sql = 'insert into co_black_list ('.$columns['black_list'].') values ("'.implode('","', $tmp).'")';
			if($param[3])
				$db->query($sql);
		}
		if($table == 'custom') {
			$param[25] = ExcelReader::xlsTime($param[25]);
			$param[6] = ExcelReader::xlsTime($param[6]);
			$param[29] = strtotime($param[29].'01');
			$param[7] = $bussLine[$param[7]];
			$param[22] = Info::getProvinceByName($param[22]);
			$tmp = array($param[16],$param[22],$param[6],$param[29],$param[2],'',1,'一年');
			$num = $db->count('co_custom',array('complaint_phone'=>$param[16]));
			if($num > 0) {
				$db->delete('co_black_list',array('complaint_phone'=>$param[16]));
				$tmp = array($param[16],$param[22],$param[6],$param[29],$param[2],'',2,'五年');
			}
			$sql = 'insert into co_black_list ('.$columns['black_list'].') values ("'.implode('","', $tmp).'")';
			if($param[16])
				$db->query($sql);
			// var_dump(Info::getProvinceByName($param[22]));exit;
		}
		if($table == 'complaints'){
			$param[17] = ExcelReader::xlsTime($param[17]);
			$param[18] = ExcelReader::xlsTime($param[18]);
			$param[19] = ExcelReader::xlsTime($param[19]);
			$param[7] = Info::getProvinceByName($param[7]);
			$param[47] = strtotime($param[47].'01');
			$tmp = array($param[4],$param[7],$param[42],$param[47],$param[41],'',3,'永久屏蔽');
			$sql = 'insert into co_black_list ('.$columns['black_list'].') values ("'.implode('","', $tmp).'")';

			$db->query($sql);
		}
		if($table == 'income'){
			$param[0] = Info::getProvinceByName($param[0]);
			$param[13] = strtotime($param[13].'01');
		}
		if ($table == 'value_income') {
			$param[0] = strtotime($param[0].'01');
		}
		// var_dump($param);exit;
		$sql = "insert into co_". $table ." (".$columns[$table].") values ('".implode("','", $param)."')";
		// echo $sql.'<br>';exit;
		return $db->query ($sql);
	}

	public static function search($param,$start = 0,$page_size=20){
		$db=self::__instance();
		if($param['start_date']) {
			$s = $param['start_date'];
			$condition["AND"]['month'] = strtotime($param['start_date'].'-01');
			// $condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
		}
		// $condition["AND"]['month[>=]'] = strtotime($param['start_date']);
		// $condition["AND"]['month[<]'] = strtotime($param['end_date']);
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
		$condition["AND"]['month'] = strtotime($param['start_date'].'-01');
		// $condition["AND"]['month[<]'] = strtotime($param['end_date'].'-01 +1 month -1 day');
		unset($param['start_date'],$param['end_date']);
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}

		return $db->count('co_base',$condition);
	}

	public static function customSearch($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date'] && $param['end_date']){
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date']);
			$condition["AND"]['order_time[<]'] = strtotime($param['end_date']);
			unset($param['start_date'],$param['end_date']);	
		}

		if($param['month']) {
			$condition["AND"]['month[>=]'] = strtotime($param['month'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['month'].'-01 +1 month -1 day');
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
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date']);
			$condition["AND"]['order_time[<]'] = strtotime($param['end_date']);
			unset($param['start_date'],$param['end_date']);	
		}

		if($param['month']) {
			$condition["AND"]['month[>=]'] = strtotime($param['month'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['month'].'-01 +1 month -1 day');
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
		if($param['start_date']){
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['LIMIT']=array($start,$page_size);
		$r = $db->select('co_complaints','*',$condition);
		return $r;
	}

	public static function customAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$s = $param['start_date'];
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
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

		if($r && isset($s)) {
			$condition["AND"]['order_time[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['order_time[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_custom','*,count(*) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉成功','province_id'=>$value['province_id'])));
				$r[$key]['appealFail'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','province_id'=>$value['province_id'])));
				$r[$key]['appealNot'] = $valid-$db->count('co_custom',array('AND'=>array('appeal_status'=>'失败','province_id'=>$value['province_id'])));
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

		public static function baseAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$s = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'province_id';
		$condition['LIMIT']=array($start,$page_size);
		$r = $db->select('co_base','*,count(*) as num',$condition);

		if($r && isset($s)) {
			unset($condition["AND"]);
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_base','*,count(*) as num',$condition);

			$tmp = $lastMonth = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = $lastMonth[$value['province_id']] = $value['num'];
				$r2[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('province_id'=>$value['province_id']))['cos']/10000;
				if($r[$key]['cos'])
					$r2[$key]['wan'] = $value['num']/$r2[$key]['cos'];
				else
					$r2[$key]['wan'] = 0;

			}

			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;

				$r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('province_id'=>$value['province_id']))['cos']/10000;
				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;

				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		$r2 = $r2?$r2:array();
		// var_dump($r);
		return array('now' => $r,'last'=>$r2);
	}

	public static function customAnalayzeCount($param)
	{
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'province_id';

		return count($db->select('co_custom','*',$condition));
	}

		public static function baseAnalayzeCount($param)
	{
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'province_id';

		return count($db->select('co_custom','*',$condition));
	}

	public static function customSpAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'part_name';
		$condition['ORDER'] = 'num desc';
		$condition['LIMIT'] = 20;
		$r = $db->select('co_custom','*,count(*) as num',$condition);

		if($r && $start) {
			$condition["AND"]['order_time[>=]'] = strtotime($start.'-01 -1 month');
			$condition["AND"]['order_time[<]'] = strtotime($start.'-01 -1 day');
			$r2 = $db->select('co_custom','*,count(*) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['part_name']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['part_name']])?$tmp[$value['part_name']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				$r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				$r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));
				$r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('sp_name'=>$value['sp_corp_name']))['cos']/1000000;
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

	public static function baseSpAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if(!$param['start_date']){
			$param['start_date'] = date('Y-m');
		}
		$start = $param['start_date'];
		$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<=]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'sp_name';
		$condition['ORDER'] = 'num desc';
		$condition['LIMIT'] = 20;
		$r = $db->select('co_base','*,count(*) as num',$condition);

// var_dump($condition,$r);
		if($r && $start) {
			$condition["AND"]['month[>=]'] = strtotime($start.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($start.'-01 -1 day');
			$r2 = $db->select('co_base','*,count(*) as num',$condition);


			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['sp_name']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['sp_name']])?$tmp[$value['sp_name']]:0;

				$r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('sp_name'=>$value['sp_name']))['cos']/10000;

				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;

				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		return $r;
	}

	public static function complaintsSpAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];

			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<=]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
			// $condition["AND"]['month[>=]'] = '1406822401';

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'sp_corp_name';
		$condition['ORDER'] = 'num desc';
		$condition['LIMIT'] = 20;
		$r = $db->select('co_complaints','*,count(*) as num',$condition);

		if($r && $start) {
			$condition["AND"]['month[>=]'] = strtotime($start.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($start.'-01 -1 day');
			$r2 = $db->select('co_complaints','*,count(*) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['sp_corp_name']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['part_name']])?$tmp[$value['part_name']]:0;
				$valid = $db->count('co_complaints',array('complaint_status'=>'有效'));
				// $r[$key]['appealSuc'] = $db->count('co_complaints',array('appeal_status'=>'申诉成功'));
				// $r[$key]['appealFail'] = $db->count('co_complaints',array('appeal_status'=>'申诉失败'));
				// $r[$key]['appealNot'] = $valid-$db->count('co_complaints',array('appeal_status'=>'失败'));
				// $r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('sp_name'=>$value['sp_corp_name']))['cos']/1000000;
				// if($r[$key]['cos'])
				// 	$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				// else
				// 	$r[$key]['wan'] = 0;
				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		return $r;
	}

	public static function customSingle($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'buss_name';
		$condition['ORDER'] = 'num desc';
		$condition['LIMIT'] = 20;
		$r = $db->select('co_custom','*,count(*) as num',$condition);
		if($r && isset($start)) {
			$condition["AND"]['order_time[>=]'] = strtotime($start.'-01 -1 month');
			$condition["AND"]['order_time[<]'] = strtotime($start.'-01 -1 day');
			$r2 = $db->select('co_custom','*,count(*) as num',$condition);

			$tmp = array();
			$r2 = $r2?$r2:array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['buss_name']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['buss_name']])?$tmp[$value['buss_name']]:0;

				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				$r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				$r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));

				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		return $r;
	}

		public static function baseSingle($param,$start = 0,$page_size=20){

		$db=self::__instance();

		if($param['start_date']){
			$s = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'buss_name_detail';
		$condition['ORDER'] = 'num desc';
		$condition['LIMIT'] = 20;

		$r = $db->select('co_base','*,count(*) as num',$condition);
// var_dump($condition,$r);
		if($r && isset($s)) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');

			$r2 = $db->select('co_base','*,count(*) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['buss_name_detail']] = $value['num'];
			}

			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['buss_name_detail']])?$tmp[$value['buss_name_detail']]:0;

				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		return $r;
	}

	public static function complaintsSingle($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['month'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['month'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'buss_name';
		$condition['ORDER'] = 'num desc';
		$condition['LIMIT'] = 20;
		$r = $db->select('co_complaints','*,count(*) as num',$condition);

		if($r && isset($start)) {
			$condition["AND"]['month[>=]'] = strtotime($start.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($start.'-01 -1 day');
			$r2 = $db->select('co_complaints','*,count(*) as num',$condition);

			$r2 = $r2?$r2:array();
			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['buss_name']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['buss_name']])?$tmp[$value['buss_name']]:0;


				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		return $r;
	}

	public static function customSpAnalayzeChart()
	{

	}

	public static function customAnalayzeMonth($param)
	{
		$condition = array();
		$db=self::__instance();
		unset($param['province_id']);
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['order_time[>=]'] = strtotime(substr($param['start_date'], 0,4).'-01-01');
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

	public static function baseAnalayzeMonth($param)
	{
		$condition = array();
		$db=self::__instance();
		unset($param['province_id']);
		if($param['start_date']){
			$s = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime(substr($param['start_date'], 0,4).'-01-01');
			$condition["AND"]['month[<]'] = strtotime(substr($param['start_date'], 0,4).'-12-31');
			unset($param['start_date'],$param['end_date']);	
		}
		$s = isset($s)?$s:date('Y');
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';
		$r = $db->select('co_base','count(*) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);
		if($r && $s) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_base','*,count(*) as num',$condition);
			$r2 = $r2?$r2:array();
			$tmp = $lastMonth = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = $lastMonth[$value['province_id']] = $value['num'];
				$r2[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('province_id'=>$value['province_id']))['cos']/10000;
				if($r[$key]['cos'])
					$r2[$key]['wan'] = $value['num']/$r2[$key]['cos'];
				else
					$r2[$key]['wan'] = 0;
			}

		}

		// var_dump($r);
		for ($i = 1;$i<=12;$i++){
			$tmp[substr($s, 0,4).'-'.sprintf('%02s',$i)] = 0;
		}

		foreach ($r as $key => $value) {
			if($value['m'] < substr($s, 0,4).'-01-01')
				continue;
			$tmp[$value['m']] = $value['num'];
		}
		return implode(',', $tmp);
	}

	public static function baseTwoMonthWan($param)
	{
		$db=self::__instance();

		if(empty($param))
			$param = array();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
		}
		$start = isset($start)?$start:date('Y-m');
		unset($param['province_id'],$param['start_date']);
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';
		// $r = $db->select('co_base','count(*) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);

		$r = $db->get(
			'co_income',
			'sum(custom_cost) as cos',
			array(
					'AND'=>array(
						'month[<]'=>strtotime($start.'-01 +1 month -1 day'),
						'month[>=]'=>strtotime($start.'-01'),
						)
					)
				)['cos']/10000;

		$lastMonth = array();

		$lastMonth = $db->get(
			'co_income',
			'sum(custom_cost) as cos',
			array(
				'AND'=>array(
				'month[>=]'=>strtotime($start.'-01 -1 month'),
				'month[<]'=>strtotime($start.'-01 -1 day')
				)
				)
			)['cos']/10000;
		// for ($i = 1;$i<=12;$i++){
		// 	$tmp[substr($start, 0,4).'-'.sprintf('%02s',$i)] = 0;
		// }

		// foreach ($r as $key => $value) {
		// 	if($value['m'] < substr($start, 0,4).'-01-01')
		// 		continue;
		// 	$tmp[$value['m']] = $value['num'];
		// }
		return array($start=>$r,date('Y-m',strtotime($start.'-01 -1 month'))=>$lastMonth);

		// retrun array($start=>$r,date(strtotime($start.'-01 -1 month'),'Y-m')=>$lastMonth);
		// return implode(',', $tmp);
	}

	public static function complaintsAnalayzeMonth($param)
	{
		$condition = array();
		$db=self::__instance();

		$start = isset($start)?$start:date('Y');
		if(empty($param))
			$param = array();
		unset($param['province_id'],$param['start_date']);
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';
		$r = $db->select('co_complaints','count(*) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);
		for ($i = 1;$i<=12;$i++){
			$tmp[substr($start, 0,4).'-'.sprintf('%02s',$i)] = 0;
		}

		foreach ($r as $key => $value) {
			if($value['m'] < substr($start, 0,4).'-01-01')
				continue;
			$tmp[$value['m']] = $value['num'];
		}
// var_dump($tmp);
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
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
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


	public static function complaintsAnalayzeProvince($param)
	{
		$flag = isset($param['flag'])?$param['flag']:0;
		unset($param['flag']);
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		$start = isset($start)?$start:date('Y');
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'province_id';
		$r = $db->select('co_complaints','count(*) as num,corp_area as province_id',$condition);

		$province = Info::getProvince();
		foreach ($province as $key => $value) {
			$tmpProvince['province'][$value['id']] = 0;
			$tmpProvince['complaints'][$value['id']] = 0;
		}

		foreach ($r as $key => $value) {
			// if($flag)
			// 	$tmpProvince['province'][$value['province_id']] = 0;
			// else
				$tmpProvince['province'][$value['province_id']] = $value['num'];

			$cos = $db->get('co_income','sum(custom_cost) as cos',array('province_id'=>$value['province_id']))['cos']/1000000;
			if($cos)
				$tmpProvince['complaints'][$value['province_id']] = $value['num']/$cos;
			// if($r[$key]['cos'] && $flag)
			// 	$tmpProvince['province'][$value['province_id']] = $value['num']/$r[$key]['cos'];
		}
		return $tmpProvince;
	}

	public static function complaintsAnalayzeType($param)
	{
		$flag = isset($param['flag'])?$param['flag']:0;
		unset($param['flag']);
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		$start = isset($start)?$start:date('Y');
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'product_type';
		$r = $db->select('co_complaints','count(*) as num,product_type',$condition);

		$province = Info::getProvince();
		foreach ($province as $key => $value) {
			$tmpProvince['province'][$value['id']] = 0;
			$tmpProvince['complaints'][$value['id']] = 0;
		}
		// var_dump($r);
		foreach ($r as $key => $value) {
			// if($flag)
			// 	$tmpProvince['province'][$value['province_id']] = 0;
			// else
				// $tmpProvince['province'][$value['province_id']] = $value['num'];
			$tmp['name'][$key] = $value['product_type'];
			$tmp['num'][$key] = $value['num'];
			// $cos = $db->get('co_income','sum(custom_cost) as cos',array('province_id'=>$value['province_id']))['cos']/1000000;
			// if($cos)
			// 	$tmpProvince['complaints'][$value['province_id']] = $value['num']/$cos;
			// if($r[$key]['cos'] && $flag)
			// 	$tmpProvince['province'][$value['province_id']] = $value['num']/$r[$key]['cos'];
		}
		return $tmp;
	}

	public static function complaintsSearchCount($param)
	{
		$condition = array();
		$db=self::__instance();

		if($param['start_date']){
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		return $db->count('co_complaints',$condition);
	}


	public static function complaintsAnalayze($param,$start = 0,$page_size=20){
		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'corp_area';
		// $condition['LIMIT']=array($start,$page_size);

		$r = $db->select('co_complaints','*,count(*) as num',$condition);
		$start = $start?$start:date('Y-m');
		if($r && isset($start)) {
			$condition["AND"]['month[>=]'] = strtotime($start.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($start.'-01 -1 day');

			$r2 = $db->select('co_complaints','*,count(*) as num',$condition);
		// var_dump($start,$condition,$r2);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['corp_area']] = $value['num'];
			}
			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['corp_area']])?$tmp[$value['corp_area']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				// $r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				// $r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));
				$r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('corp_area'=>$value['corp_area']))['cos']/1000000;
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

	public static function complaintsAnalayze2($param,$start = 0,$page_size=20){
		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'product_type';
		// $condition['LIMIT']=array($start,$page_size);

		$r = $db->select('co_complaints','*,count(*) as num',$condition);
		$start = $start?$start:date('Y-m');
		if($r && isset($start)) {
			$condition["AND"]['month[>=]'] = strtotime($start.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($start.'-01 -1 day');

			$r2 = $db->select('co_complaints','*,count(*) as num',$condition);
		// var_dump($start,$condition,$r2);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['corp_area']] = $value['num'];
			}
			$total = 0;
			foreach ($r as $key => $value) {
				$total += $value['num'];
				$t = isset($tmp[$value['corp_area']])?$tmp[$value['corp_area']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				// $r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				// $r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));
				$r[$key]['cos'] = $db->get('co_income','sum(custom_cost) as cos',array('corp_area'=>$value['corp_area']))['cos']/1000000;
				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;
				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}

		return array('list'=>$r,'total'=>$total);
	}

	public static function complaintsAnalayze2Count($param){
		$db=self::__instance();
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'product_type';
		// $condition['LIMIT']=array($start,$page_size);
		$r = $db->count('co_complaints',$condition);
		// $start = $start?$start:date('Y-m');


		return $r;
	}

	public static function getBlackList($param,$start = 0,$page_size = 20)
	{
		if($param['start_date']){
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		$db=self::__instance();
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['LIMIT']=array($start,$page_size);

		return $db->select('co_black_list','*',$condition);
	}

	public static function getBlackListCount($param)
	{
		if($param['start_date']){
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		$db=self::__instance();
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		return $db->count('co_black_list',$condition);
	}

}