<?php
if(!defined('ACCESS')) {exit('Access denied.');}
class Complaint extends Base {

	// public static $columns;
	// 表名
	// private static $table_name = 'co_base';
	private static $base = "province_id,order_id,order_time,complaint_phone,complaint_content,sp_name,sp_corp_code,sp_code,suggestion,order_department,buss_department,buss_name,buss_name_detail,buss_rates,problem,reconciliations,charge_back,buss_type,buss_type_name,complaint_type,problem_type,problem_result,complaint_level,buss_line,work_id,month,record_id";
	private static $custom = "order_id,sub_order_id,part_name,responsibility_code,responsibility_name,part_code,order_time,buss_type,buss_type_code,buss_name,buss_code,product_name,product_code,complaint_status,appeal_status,user_name,complaint_phone,complaint_type,custom,complaint_total,complaint_content,appeal_content,province_id,cooperative,all_net,order_end_time,complaint_id,deductions,buss_line,month,record_id";
	private static $complaints = "complaints_id,case_id,user_name,phone,dispute_phone,address,about_corp,corp_area,type_one,type_two,type_three,buss_one,buss_two,buss_three,buss_four,complaint_source,comfirm_user,complaint_time,get_time,handle_time,complaint_content,complaint10010,10010status,complaint10015,10015status,complaint_status,problem,problem_type,contact_element,element,buss_type,product_type,problem_channel,service_need,buss_way,netproblem,phoneproblem,vipuser,partment,buss_class,complaint_num,sp_corp_name,sp_corp_code,sp_code,buss_name,complaint_class,buss_line,month,record_id";
	private static $income = "province_id,sp_name,sp_code,buss_type,province_income,sp_income,owe,tuipei_cost,imbalance_cost,20_cost,diaozhang_cost,violate_cost,custom_cost,month,mastsp_code,mastsp_cost,mastsp_sleave,record_id";
	private static $value_income = "month,buss_type,value,custom_cost,record_id";
	private static $black_list = "complaint_phone,province_id,sp_corp_code,month,sp_corp_name,complaint_phone_tag,level,time_limit";
	private static $complaint_province = "province_id,num,month,record_id";
	private static $complaint_class = "class,num,month,record_id";

	public static function getTableName(){
		return parent::$table_prefix.self::$table_name;
	}

	public static function recordTable($name,$table,$month,$province_id,$user_id){
		$db=self::__instance();
		// $r = $db->insert('co_table_record',array('table'=>$table,'month'=>strtotime($month.'-01'),'province_id'=>$province_id,'name'=>$name,'user_id'=>$user_id));
		$db->query('insert into co_table_record (`table`,`month`,province_id,`name`,user_id,time) values("'.$table.'",'.strtotime($month.'-01').','.$province_id.',"'.$name.'",'.$user_id.','.time().')');
		$r = $db->query('select LAST_INSERT_ID()')->fetchAll();
		return $r[0][0];
	}

	public static function save($param,$table,$month,$province_id,$record_id){

		foreach ($param as $key => $value) {
			$param[$key] = addslashes($value);
		}
		$param[] = $record_id;
		$columns['base'] = self::$base;
		$columns['custom'] = self::$custom;
		$columns['complaints'] = self::$complaints;
		$columns['income'] = self::$income;
		$columns['value_income'] = self::$value_income;
		$columns['black_list'] = self::$black_list;
		$columns['complaint_province'] = self::$complaint_province;
		$columns['complaint_class'] = self::$complaint_class;
		// unset($param[0]);
		// var_dump(count(explode(',', $columns[$table])),count($param));exit;
		$bussLine = array(
				'联通在信' => 1,
				'彩信' => 2,
			);
		$db=self::__instance();

		if($table == 'complaint_province') {
			$param[0] = Info::getProvinceByName($param[0]);
			$param[2] = strtotime($param[2].'01');
			if(strtotime($month.'-01') != $param[2])
				return false;
		}
		if($table == 'complaint_class') {
			$param[2] = strtotime($param[2].'01');
			if(strtotime($month.'-01') != $param[2])
				return false;
		}
		if($table == 'base') {
			$param[0] = Info::getProvinceByName($param[0]);
			// $param[6] = ExcelReader::xlsTime($param[6]);
			$param[25] = strtotime($param[25].'01');
			if(strtotime($month.'-01') != $param[25])
				return false;
			if($province_id != $param[0])
				return false;

			$tmp = array($param[3],$param[0],$param[6],$param[25],$param[5],'',1,'一年');
			$num = $db->count('co_base',array('complaint_phone'=>$param[3]));
			if($num > 0) {
				$db->delete('co_black_list',array('complaint_phone'=>$param[3]));
				$tmp = array($param[3],$param[0],$param[6],$param[25],$param[5],'',2,'五年');
			}
			$sql = 'insert into co_black_list ('.$columns['black_list'].') values ("'.implode('","', $tmp).'")';
			if($param[3])
				$r = $db->query($sql);
		}
		if($table == 'custom') {
			$param[29] = strtotime($param[29].'01');
			if(strtotime($month.'-01') != $param[29])
				return false;
			$param[22] = Info::getProvinceByName($param[22]);
			// if($province_id != $param[22])
			// 	return true;
			$param[25] = ExcelReader::xlsTime($param[25]);
			//$param[6] = ExcelReader::xlsTime($param[6]);
			$param[6] = strtotime($param[6]);
			$param[7] = $bussLine[$param[7]];
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

			// $param[17] = ExcelReader::xlsTime($param[17]);
			// $param[18] = ExcelReader::xlsTime($param[18]);
			// $param[19] = ExcelReader::xlsTime($param[19]);
			$param[7] = Info::getProvinceByName($param[7]);
			// if($province_id != $param[7])
			// 	return true;
			$param[47] = strtotime($param[47].'01');
			if(strtotime($month.'-01') != $param[47])
				return false;
			$tmp = array($param[4],$param[7],$param[42],$param[47],$param[41],'',3,'永久屏蔽');
			$sql = 'insert into co_black_list ('.$columns['black_list'].') values ("'.implode('","', $tmp).'")';

			$db->query($sql);
		}
		if($table == 'income'){
			$param[0] = Info::getProvinceByName($param[0]);
			// if($province_id != $param[0])
			// 	return true;
			$param[13] = strtotime($param[13].'01');
			if(strtotime($month.'-01') != $param[13])
				return false;
		}
		if ($table == 'value_income') {
			$param[0] = strtotime($param[0].'01');
			if(strtotime($month.'-01') != $param[0])
				return false;
		}
		// var_dump($param);exit;
		$sql = "insert into co_". $table ." (".$columns[$table].") values ('".implode("','", $param)."')";
		// echo $sql.'<br>';exit;
		$r = $db->query ($sql);
		// if(!$r)
			// echo $sql;
		return $r;
	}


	public static function checkFirstLine($arr,$table) {
		// $checkParams['base'] = 1;
		$checkParams['custom'] = 29;
		$db=self::__instance();
		$params = explode(',', self::$$table);

		// var_dump(count($params),count($arr[1]),$arr[1]);exit;
		if($table=='custom')
		{
			$r = $db->select('co_'.$table,'*',array($params[$checkParams[$table]]=>strtotime($arr[1][$checkParams[$table]].'01 00:00:00')));
		}
		else {
			$r = $db->select('co_'.$table,'*',array($params[$checkParams[$table]]=>$arr[1][$checkParams[$table]]));
		}
		//var_dump(strtotime($arr[1][$checkParams[$table]].'01 00:00:00'),$arr[1][$checkParams[$table]],$db->last_query());exit;
		if($r && count($r) > 0) {
			return array('error'=>'该数据以导入过！');
		}
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
			if($key=='buss_name'||$key=='sp_name'||$key=='sp_corp_code')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}

		$ret=$db->select('co_base','*',$condition);
		//var_dump($db->last_query());exit;
		return $ret ;
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
	
	
	public static function updateComplaintLevelAndType($id,$update_data)
	{
		if (! $update_data || ! is_array ( $update_data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$id);
		$id = $db->update ( 'co_base', $update_data,$condition );
		
		return $id;
	
	
	}

	public static function customSearch($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			//$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			//$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date']." 00:00:00");
			$condition["AND"]['order_time[<]'] = strtotime($param['end_date']." 23:59:59");
			
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
			if($key=='buss_name'||$key=='sp_name'||$key=='complaint_phone'||$key=='part_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}

		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}

		$ret=$db->select('co_custom','*',$condition);
		//var_dump($db->last_query());exit;
		return $ret;
	}

	public static function customSearchCount($param)
	{
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			//$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			//$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date']." 00:00:00");
			$condition["AND"]['order_time[<]'] = strtotime($param['end_date']." 23:59:59");
			
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
			if($key=='case_id'||$key=='buss_name'||$key=='sp_name'||$key=='dispute_phone'||$key == 'complaint_time')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			elseif($key == 'question_type'){
				$complaintType = Info::getComplaintType();
				$questionType = Info::getQuestionType($param['problem_type']);
				$condition['AND']['problem_type'] = $complaintType[$param['problem_type']];
				$condition['AND']['contact_element'] = $questionType[$param['question_type']];
			}elseif($key == 'problem_type'){

			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$r = $db->select('co_complaints','*',$condition);
		return $r;
	}
	
	public static function updateComplaintProblemType($id,$update_data)
	{
		if (! $update_data || ! is_array ( $update_data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$id);
		$id = $db->update ( 'co_complaints', $update_data,$condition );
		//var_dump($db->last_query());exit;
		return $id;
	
	
	}
	
	
	public static function complaintsSpSearch($param,$start = 0,$page_size=20){
		$db=self::__instance();
		if($param['start_date']){
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='case_id'||$key=='buss_name'||$key=='sp_name'||$key=='dispute_phone')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$r = $db->select('co_complaints','*',$condition);
		return $r;
	}

	public static function customAnalayze($param,$start = 0,$page_size=20){
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
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'province_id';

		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			// $condition['LIMIT']=array($start,$page_size);
		}
		unset($condition['AND']['wan']);
		$r = $db->select('co_custom','*,sum(complaint_total) as num',$condition);
		if($param['wan']) {
			foreach ($r as $key => $value) {
				$num = $value['num'];
				$cos = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01 -1 month')))['cos']/10000;
				if($cos && $num/$cos >= $param['wan']){
					$tmp[$key] = $value;
					$tmp[$key]['score'] = $num/$cos;
				}
			}
			$r = $tmp;
		}

		if($r && isset($s)) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			// var_dump($condition);
			$r2 = $db->select('co_custom','*,sum(complaint_total) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				if(!$value['province_id']){
					unset($r[$key]);
					continue;
				}
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;
				// $valid = $db->count('co_custom',array('AND'=>array('complaint_status'=>'有效','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉成功','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealFail'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealNot'] = $r[$key]['num'] - $r[$key]['appealSuc'] - $r[$key]['appealFail'];
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['cos'] = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01')))['cos']/10000;
				//'sp_name'=>$param['part_name'],
				$costCondition = array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'));
				if(isset($param['part_name']) && $param['part_name'])
					$costCondition['sp_name'] = $param['part_name'];
				$r[$key]['customCost'] = $db->get('co_income','sum(custom_cost) as cos',array('AND'=>$costCondition))['cos']/10000;

				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;
				// $r[$key]['valid'] = $valid;
				$r[$key]['valid'] = $r[$key]['num'] - $r[$key]['appealSuc'];
				
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r?$r:array();
	}

	public static function getCos($params)
	{
		if(isset($params['province_id']) && $params['province_id'] == 0)
			unset($params['province_id']);

		$db=self::__instance();
		$r = $db->get('co_income','sum(province_income) as cos',array('AND'=>$params));
		// echo $db->last_query();
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
		// if($param['wan']) {
		// 	$condition['GROUP'] = 'province_id';
		// 	$r = $db->select('co_base','*,count(*) as num',$condition);

		// 	$tmpSort = array();
		// 	foreach ($r as $key => $value) {
		// 		$num = $value['num'];
		// 		$cos = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01 -1 month')))['cos']/10000;
		// 		if($num/$cos >= $param['wan']){
		// 			$tmp[$k] = $value;
		// 			$tmp[$k]['score'] = $num/$cos;
		// 		}
		// 		// var_dump($tmp);exit;
		// 	}
		// 	$r = $tmp;
		// }else{
			// unset($param['wan']);

			if(empty($param))
				$param = array();
			foreach ($param as $key => $value) {
				if($key=='buss_name'||$key=='sp_name'||$key=='sp_corp_code')
				{
					$condition["LIKE"]["AND"][$key] = $value;
				}else{
					$condition["AND"][$key] = $value;
				}
			}
			$condition['GROUP'] = 'province_id';
			//如果$page_size为0表示获取所有满足条件的记录
			if(0==$page_size)
			{
				$condition['LIMIT']=array($start);
			}
			else {
				$condition['LIMIT']=array($start,$page_size);
			}
			unset($condition['AND']['wan']);
			$r = $db->select('co_base','*,count(*) as num',$condition);	
			$r2Province = array();
			foreach ($r as $k => $value) {
				$num = $value['num'];
				$cos = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01 -1 month')))['cos']/10000;
				$score = $cos?$num/$cos:0;
				if($score >= $param['wan']){
					$r[$k] = $value;
					$r[$k]['score'] = $score;
					$r2Province[$value['province_id']] = $value['province_id'];
				}else{
					unset($r[$k]);
				}
			}

		// }
		

		if($r && isset($s)) {
			unset($condition["AND"]);
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$condition["AND"]['province_id'] = $r2Province;

			$r2 = $db->select('co_base','*,count(*) as num',$condition);

			$tmp = $lastMonth = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = $lastMonth[$value['province_id']] = $value['num'];
				$r2[$key]['cos'] = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01 -1 month')))['cos']/10000;
				if($r[$key]['cos'])
					$r2[$key]['wan'] = $value['num']/$r2[$key]['cos'];
				else
					$r2[$key]['wan'] = 0;

			}
		}

			foreach ($r as $key => $value) {
				if(!$value['province_id']){
					unset($r[$key]);
					continue;
				}
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;

				$r[$key]['cos'] = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01')))['cos']/10000;
				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;

				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		
		$r2 = $r2?$r2:array();
		$r = $r?$r:array();
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

	public static function customSpAnalayzeNum($param)
	{
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
			if($key=='buss_name'||$key=='sp_name'||$key=='part_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'part_name';
		$condition['ORDER'] = 'num desc';
		$r = $db->select('co_custom','*,count(*) as num',$condition);
		return count($r);
	}

	public static function customSpAnalayze($param,$start = 0,$page_size=20){

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
			if($key=='buss_name'||$key=='sp_name'||$key=='part_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'part_name';
		$condition['ORDER'] = 'num desc';

		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		unset($condition['AND']['wan']);
		$r = $db->select('co_custom','*,count(*) as num',$condition);


		if($r && $s) {
			$tmpCorp = array();
			foreach ($r as $key => $value) {
				$condition['AND']['part_name'][] = $value['part_name'];
			}
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			unset($condition['LIMIT']);
			$r2 = $db->select('co_custom','*,count(*) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['part_name']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				$r[$key]['num'] = $value['num'] = round($value['num']);
				$t = isset($tmp[$value['part_name']])?$tmp[$value['part_name']]:0;
				$tmpProCondition = array();
				if(isset($param['province_id'])){
					$condition['province_id']= $tmpProCondition['province_id'] = $value['province_id'];
				}

				$valid = $db->count('co_custom',array('AND'=>array('complaint_status'=>'有效','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉成功','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition));
				$r[$key]['appealFail'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition));
				$r[$key]['appealNot'] = $r[$key]['num'] - $r[$key]['appealSuc'] - $r[$key]['appealFail'];
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))));
				$r[$key]['customCost'] = $db->get('co_income','sum(custom_cost) as cos',array('AND'=>array('sp_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition))['cos']/10000;

				$cosCondition = array('sp_name'=>$value['part_name'],'month'=>strtotime($s.'-01'));
				
				$r[$key]['cos'] = self::getCos($cosCondition)['cos']/10000;

				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;
				// $r[$key]['valid'] = $valid;
				$r[$key]['valid'] = $r[$key]['num'] - $r[$key]['appealSuc'];

				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r;
	}

	public static function baseSpAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if(!$param['start_date']){
			$param['start_date'] = date('Y-m');
		}
		$s = $param['start_date'];
		$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<=]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'sp_name';
		$condition['ORDER'] = 'num desc';
		//如果$page_size为0表示获取所有满足条件的记录

		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			// if(!$param['wan'])
				$condition['LIMIT']=array($start,$page_size);
		}
		unset($condition['AND']['wan']);
		$r = $db->select('co_base','*,count(*) as num',$condition);


		if(isset($param['province_id']) && $param['province_id']){
			$cosCondition['province_id']=$param['province_id'];
		}else{
			$province = $db->select('co_base','province_id',array('AND'=>array('month'=>strtotime($s.'-01')),'GROUP'=>'province_id'));

			foreach ($province as $k => $v) {
				$cosCondition['province_id'][] = $v['province_id'];
			}

		}
		if($param['wan']) {
			foreach ($r as $key => $value) {
				$num = $value['num'];
				$cos = self::getCos(array('sp_code'=>$value['sp_corp_code'],'month'=>strtotime($s.'-01'))+$cosCondition)['cos']/10000;

				if($cos && $num/$cos >= $param['wan']){
					$tmp[$key] = $value;
					$tmp[$key]['score'] = $num/$cos;
				}
			}
			$r = $tmp;
		}

		if($r && $s) {
			$tmpCorp = array();
			foreach ($r as $key => $value) {
				$condition['AND']['sp_name'][] = $value['sp_name'];
			}
			unset($condition['LIMIT']);
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_base','*,count(*) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['sp_name']] = $value['num'];
			}

			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['sp_name']])?$tmp[$value['sp_name']]:0;

				// $cosCondition = array('sp_name'=>$value['sp_name'],'month'=>strtotime($s.'-01'));


				$r[$key]['cos'] = self::getCos(array('sp_code'=>$value['sp_corp_code'],'month'=>strtotime($s.'-01'))+$cosCondition)['cos']/10000;

				if($r[$key]['cos']){
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				}
				else{
					$r[$key]['wan'] = 0;
				}

				$r[$key]['increase'] = $value['num'] - $t;

				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';			}
		}

		return $r;
	}

	public static function baseSpAnalayzeCount($param)
	{
		$db=self::__instance();
		if(!$param['start_date']){
			$param['start_date'] = date('Y-m');
		}
		$s = $param['start_date'];
		$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<=]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'sp_name';
		// $condition['ORDER'] = 'num desc';
		//如果$page_size为0表示获取所有满足条件的记录

		unset($condition['AND']['wan']);
		$r = $db->select('co_base','*,count(*) as num',$condition);
		return count($r);

	}

	public static function complaintsSpAnalayzeCount($param)
	{
		$db=self::__instance();
		if($param['start_date']){
			$s = $param['start_date'];

			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<=]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
			// $condition["AND"]['month[>=]'] = '1406822401';

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'sp_corp_name';
		$r = $db->select('co_complaints','*,count(*) as num',$condition);
		return count($r);
	}

	public static function complaintsSpAnalayze($param,$start = 0,$page_size=20){

		$db=self::__instance();
		if($param['start_date']){
			$s = $param['start_date'];

			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<=]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
			// $condition["AND"]['month[>=]'] = '1406822401';

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'sp_corp_name';
		$condition['ORDER'] = 'num desc';

		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$r = $db->select('co_complaints','*,count(*) as num',$condition);

		if($r && $s) {
			unset($condition['LIMIT']);

			foreach ($r as $key => $value) {
				if($value['sp_corp_name']){
					$condition['AND']['sp_corp_name'][] = $value['sp_corp_name'];
				}else{					
					unset($r[$key]);
				}
			}
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['sp_corp_name']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['sp_corp_name']])?$tmp[$value['sp_corp_name']]:0;
				// $valid = $db->count('co_complaints',array('complaint_status'=>'有效'));
				// $r[$key]['appealSuc'] = $db->count('co_complaints',array('appeal_status'=>'申诉成功'));
				// $r[$key]['appealFail'] = $db->count('co_complaints',array('appeal_status'=>'申诉失败'));
				// $r[$key]['appealNot'] = $valid-$db->count('co_complaints',array('appeal_status'=>'失败'));
				// $r[$key]['cos'] = $db->get('co_income','sum(province_income) as cos',array('sp_name'=>$value['sp_corp_name']))['cos']/1000000;
				// if($r[$key]['cos'])
				// 	$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				// else
				// 	$r[$key]['wan'] = 0;
				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r;
	}

	public static function customSingleCount($param)
	{
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
			if($key=='buss_name'||$key=='sp_name'||$key=='part_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'buss_name';
		// var_dump($condition);
		unset($condition['AND']['wan']);
		$r = $db->select('co_custom','*,count(*) as num',$condition);
		return count($r);
	}

	public static function customSingle($param,$start = 0,$page_size=20){
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
			if($key=='buss_name'||$key=='sp_name'||$key=='part_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'buss_name';
		$condition['ORDER'] = 'num desc';

		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		// var_dump($condition);
		unset($condition['AND']['wan']);
		$r = $db->select('co_custom','*,count(*) as num',$condition);
		// if($param['wan']) {
		// 	foreach ($r as $key => $value) {
		// 		$r[$key]['cos'] = self::getCos(array('buss_type'=>$value['buss_name'],'province_id'=>$value['province_id'],'month'=>$value['month']))['cos']/10000;

		// 		$r[$key]['wan'] = $r[$key]['cos']?$value['num']/$r[$key]['cos']:0;
		// 	}
		// }
		// echo $db->last_query();
		// var_dump($r);
		if($r && isset($s)) {
			$tmpCorp = array();
			foreach ($r as $key => $value) {
				$condition['AND']['buss_name'][] = $value['buss_name'];
			}
			unset($condition['LIMIT']);
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_custom','*,count(*) as num',$condition);

			$tmp = array();
			$r2 = $r2?$r2:array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['buss_name']] = round($value['num']);
			}

			foreach ($r as $key => $value) {
				$r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['buss_name']])?$tmp[$value['buss_name']]:0;

				// $valid = $db->count('co_custom',array('AND'=>array('complaint_status'=>'有效','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))));
				$tmpCondition = array();
				if($param['province_id'])
					$tmpCondition = array('province_id'=>$param['province_id']);
				$r[$key]['appealSuc'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉成功','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))+$tmpCondition));
				$r[$key]['appealFail'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))+$tmpCondition));
				$r[$key]['appealNot'] = $r[$key]['num'] - $r[$key]['appealSuc'] - $r[$key]['appealFail'];
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))));
				// if(!isset($r[$key]['wan'])) {
				// 	$r[$key]['cos'] = self::getCos(array('buss_type'=>$value['buss_name'],'province_id'=>$value['province_id'],'month'=>$value['month']))['cos']/10000;
				// 	$r[$key]['wan'] = $r[$key]['cos']?$value['num']/$r[$key]['cos']:0;
				// }

				$r[$key]['valid'] = $r[$key]['num'] - $r[$key]['appealSuc'];
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r;
	}

	public static function baseSingleCount($param)
	{
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
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'buss_name_detail';

		$r = $db->select('co_base','*,count(*) as num',$condition);
		return count($r);
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
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'buss_name_detail';
		$condition['ORDER'] = 'num desc';
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$r = $db->select('co_base','*,count(*) as num',$condition);
// var_dump($condition,$r);
		if($r && isset($s)) {
			$tmpCorp = array();
			foreach ($r as $key => $value) {
				$condition['AND']['buss_name_detail'][] = $value['buss_name_detail'];
			}
			unset($condition['LIMIT']);
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
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r;
	}

	public static function complaintsSingleCount($param)
	{
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
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'buss_name';
		$r = $db->select('co_complaints','*,count(*) as num',$condition);
		return count($r);
	}

	public static function complaintsSingle($param,$start = 0,$page_size=20){

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
			if($key=='buss_name'||$key=='sp_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'buss_name';
		$condition['ORDER'] = 'num desc';

		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$r = $db->select('co_complaints','*,count(*) as num',$condition);
		// var_dump($r,$condition);

		if($r && isset($s)) {
			unset($condition['LIMIT']);

			foreach ($r as $key => $value) {
				$condition['AND']['buss_name'][] = $value['buss_name'];
			}
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);

			$r2 = $r2?$r2:array();
			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['buss_name']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				$r[$key]['num'] = $value['num'] = round($value['num']);
				$t = isset($tmp[$value['buss_name']])?$tmp[$value['buss_name']]:0;


				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r;
	}

	public static function customSpAnalayzeWan($param)
	{
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
			if($key=='buss_name'||$key=='sp_name'||$key=='part_name')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		$condition['GROUP'] = 'part_name';
		// $condition['ORDER'] = 'num desc';
		unset($condition['AND']['wan']);
		$r = $db->select('co_custom','*,count(*) as num',$condition);

		$tmp = $data = array();
		foreach ($r as $key => $value) {
			// var_dump($value);exit;
			$data[$key] = $value;

			$tmp['name'][$key] = $data[$key]['name'] = $value['part_name'];
			$cosCondition = array('sp_name'=>$value['part_name'],'month'=>strtotime($s.'-01'));
				
			$cos = self::getCos($cosCondition)['cos']/10000;

			// $cos = $db->get('co_income','sum(province_income) as cos',array('province_id'=>$value['province_id']))['cos']/10000;
			$tmp['score'][$key] = $data[$key]['score'] = $data[$key]['wan'] = $cos?($value['num']/$cos):0;
			if($param['wan'] && ($tmp['score'][$key] < $param['wan'])){
				unset($data[$key]);
				unset($tmp['score'][$key]);
				unset($tmp['name'][$key]);
			}else{
				$tmpProCondition = array();
				$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
				$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');

				$r2 = $db->select('co_custom','*,count(*) as num',$condition);

				$tmpR2 = array();
				foreach ($r2 as $value) {
					$tmpR2[$value['part_name']] = round($value['num']);
				}
				if(isset($param['province_id'])){
					$condition['province_id']= $tmpProCondition['province_id'] = $value['province_id'];
				}
				$t = isset($tmpR2[$value['part_name']])?$tmpR2[$value['part_name']]:0;

				$valid = $db->count('co_custom',array('AND'=>array('complaint_status'=>'有效','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition));
				$data[$key]['appealSuc'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉成功','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition));
				$data[$key]['appealFail'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition));
				$data[$key]['appealNot'] = $r[$key]['num'] - $r[$key]['appealSuc'] - $r[$key]['appealFail'];
				$data[$key]['valid'] = $r[$key]['num'] - $r[$key]['appealSuc'];

				$data[$key]['increase'] = $value['num'] - $t;
				$data[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
			// var_dump($cos,$value['num']);
		}
		if($r){
			array_multisort($tmp['score'], SORT_DESC, $tmp['name'], SORT_ASC, $data);
			// array_splice($data);
			return $data;
		}
		return array();
	}

	public static function customAnalayzeMonth($param)
	{
		unset($param['wan']);
		$condition = array();
		$db=self::__instance();
		// unset($param['province_id']);

		if($param['start_date']){
			$s = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime(substr($param['start_date'], 0,4).'-01-01');
			$condition["AND"]['month[<]'] = strtotime(substr($param['start_date'], 0,4).'-12-31');
			unset($param['start_date'],$param['end_date']);	
		}
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';

		$r = $db->select('co_custom','count(*) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);

		for ($i = 1;$i<=12;$i++){
			$tmp[substr($s, 0,4).'-'.sprintf('%02s',$i)] = 0;
		}

		foreach ($r as $key => $value) {
			if($value['m'] < substr($s, 0,4).'-01-01')
				continue;
			$tmp[$value['m']] = round($value['num']);
		}

		return implode(',', $tmp);
	}

	public static function baseAnalayzeMonth($param)
	{
		$condition = array();
		$db=self::__instance();
		// unset($param['province_id']);
		if($param['start_date']){
			$s = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime(substr($param['start_date'], 0,4).'-01-01');
			$condition["AND"]['month[<]'] = strtotime(substr($param['start_date'], 0,4).'-12-31');
			unset($param['start_date'],$param['end_date']);	
		}
		$s = isset($s)?$s:$year;
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';

		unset($condition['AND']['wan']);
		$r = $db->select('co_base','count(*) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);

		// if($r && $s) {
		// 	$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
		// 	$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
		// 	$r2 = $db->select('co_base','*,count(*) as num',$condition);
		// 	$r2 = $r2?$r2:array();
		// 	$tmp = $lastMonth = array();
		// 	foreach ($r2 as $key => $value) {
		// 		$tmp[$value['province_id']] = $lastMonth[$value['province_id']] = $value['num'];
		// 		$r2[$key]['cos'] = $db->get('co_income','sum(province_income) as cos',array('province_id'=>$value['province_id']))['cos']/10000;
		// 		if($r[$key]['cos'])
		// 			$r2[$key]['wan'] = $value['num']/$r2[$key]['cos'];
		// 		else
		// 			$r2[$key]['wan'] = 0;
		// 	}

		// }

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

	public static function baseTwoMonthWan($param,$resultProvince)
	{
		$db=self::__instance();

		if(empty($param))
			$param = array();
		$year = date('Y');
		if($param['start_date']){
			$year = substr($param['start_date'], 0,4);
		}
			// $start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($year.'-01-01');
			$condition["AND"]['month[<]'] = strtotime($year.'-12-31');
		// }
		$start = isset($start)?$start:date('Y-m');
		unset($param['start_date']);
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';
		// $r = $db->select('co_base','count(*) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);

		$tmpCon = array(
						// 'month[<]'=>strtotime($start.'-01 +1 month -1 day'),
						'month[>=]'=>strtotime($year.'-01-01'),
						'month[<]'=>strtotime($year.'-12-31'),
						// 'province_id'=>$resultProvince
						);
		if(isset($param['province_id']) && $param['province_id'] > 0) {
			$tmpCon['province_id'] = $param['province_id'];
		}
		// $r = $db->select(
		// 	'co_income',
		// 	'sum(province_income) as cos,month',
		// 	array(
		// 			'AND'=>$tmpCon,
		// 			'GROUP'=>'month',
		// 			)
		// 		);

		$rnum = $db->select(
			'co_base',
			'count(*) as num,month',
			array(
					'AND'=>$tmpCon,
					'GROUP'=>'month',
					)
				);
		$cos = $nums = array();
		foreach ($rnum as $key => $value) {
			$nums[date('m',$value['month'])*1] = $value['num'];
		}
		// foreach ($r as $key => $value) {
		// 	$cos[date('m',$value['month'])*1] = $value['cos'];
		// }

		for ($i=1; $i <= 12; $i++) { 
			// $db->select('co_base',array('month'=>strtotime($year.'-'.$i.'-01'),'GROUP'=>'province_id'));
			$province = $db->select('co_base','province_id',array('AND'=>array('month'=>strtotime($year.'-'.$i.'-01')),'GROUP'=>'province_id'));
			// echo $db->last_query();
			// var_dump($i,$province);

			$tmpLastProvince = array();
			if($province) {
			foreach ($province as $pro) {
				$tmpLastProvince[] = $pro['province_id'];
			}
			$tmpCon['province_id'] = $tmpLastProvince;
			if(isset($param['province_id']) && $param['province_id'] > 0) {
				$tmpCon['province_id'] = $param['province_id'];
			}
			// $cos[$i] = $db->select('co_income','cos',)
			// var_dump($tmpCon);
			$tmpCon['month'] = strtotime($year.'-'.$i.'-01');
			$cos[$i] = $db->select(
			'co_income',
			'sum(province_income) as cos,month',
			array(
					'AND'=>$tmpCon
					)
				)[0]['cos'];
			// echo $db->last_query();
			// var_dump($cos[$i]);
			if(isset($cos[$i])) {
				if(!isset($nums[$i]))
					$nums[$i] = 0;
				$wan[$i] = $nums[$i]/$cos[$i]*10000;
			}else{
				$wan[$i] = 0;
			}
		}else{
			$wan[$i] = 0;
		}

		}
		return $wan;
		var_dump($wan);
		// var_dump($rnum);exit;
		// $rNum = $db->get('co_base','count(*) as num',array(
		// 					'AND'=>array(
		// 						'month[<]'=>strtotime($start.'-01 +1 month -1 day'),
		// 						'month[>=]'=>strtotime($start.'-01'),
		// 						'province_id'=>$resultProvince
		// 						)
		// 					))['num'];
		// $lastMonth = array();
		// $province = $db->select('co_base','province_id',array('AND'=>array('month'=>strtotime($start.'-01 -1 month')),'GROUP'=>'province_id'));

		// $tmpLastProvince = array();
		// foreach ($province as $pro) {
		// 	$tmpLastProvince[] = $pro['province_id'];
		// }
		// if($_GET['province_id'])
		// 	$tmpLastProvince = $resultProvince;
		// $lastMonth = $db->get(
		// 	'co_income',
		// 	'sum(province_income) as cos',
		// 	array(
		// 		'AND'=>array(
		// 		'month'=>strtotime($start.'-01 -1 month'),
		// 		// 'month[<]'=>strtotime($start.'-01 -1 day'),
		// 		'province_id'=>$tmpLastProvince
		// 		// 'province_id'=>$resultProvince
		// 		)
		// 		)
		// 	)['cos']/10000;
		// $lastMonthNum = $db->get(
		// 	'co_base',
		// 	'count(*) as num',
		// 	array(
		// 		'AND'=>array(
		// 		'month[>=]'=>strtotime($start.'-01 -1 month'),
		// 		'month[<]'=>strtotime($start.'-01 -1 day'),
		// 		'province_id'=>$tmpLastProvince
		// 		// 'province_id'=>$resultProvince
		// 		)
		// 		)
		// 	)['num'];

		// for ($i = 1;$i<=12;$i++){
		// 	$tmp[substr($start, 0,4).'-'.sprintf('%02s',$i)] = 0;
		// }

		// foreach ($r as $key => $value) {
		// 	if($value['m'] < substr($start, 0,4).'-01-01')
		// 		continue;
		// 	$tmp[$value['m']] = $value['num'];
		// }

		if(!$rNum || !$r)
			$rn = 0;
		else
			$rn = $rNum/$r;

		if(!$lastMonthNum || !$lastMonth)
			$lastN = 0;
		else
			$lastN = $lastMonthNum/$lastMonth;
		// var_dump($rNum,$r,$lastMonthNum,$lastMonth);
		return array($start=>$rn,date('Y-m',strtotime($start.'-01 -1 month'))=>$lastN);

		// retrun array($start=>$r,date(strtotime($start.'-01 -1 month'),'Y-m')=>$lastMonth);
		// return implode(',', $tmp);
	}

	public static function complaintsAnalayzeMonth($param)
	{
		$condition = array();
		$db=self::__instance();
		$year = date('Y');
		if($param['start_date'])
			$year = substr($param['start_date'], 0,4);
		$start = isset($start)?$start:$year;
		if(empty($param))
			$param = array();
		unset($param['province_id'],$param['start_date']);
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';
		$r = $db->select('co_complaint_province','sum(num) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);
		for ($i = 1;$i<=12;$i++){
			$tmp[substr($start, 0,4).'-'.sprintf('%02s',$i)] = 0;
		}

		foreach ($r as $key => $value) {
			if($value['m'] < substr($start, 0,4).'-01-01')
				continue;
			$tmp[$value['m']] = round($value['num']);
		}
// var_dump($tmp);
		return implode(',', $tmp);
	}

	public static function customAnalayzeArea($param)
	{
		$flag = isset($param['flag'])?$param['flag']:0;
		unset($param['flag'],$param['wan']);
		$condition = array();
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
		$r = $db->select('co_custom','sum(complaint_total) as num,province_id',$condition);

		$province = Info::getProvince();
		foreach ($province as $key => $value) {
			$tmpProvince[$value['id']] = 0;
		}

		foreach ($r as $key => $value) {
			if($flag)
				$tmpProvince[$value['province_id']] = 0;
			else
				$tmpProvince[$value['province_id']] = round($value['num']);

			$r[$key]['cos'] = $db->get('co_income','sum(province_income) as cos',array('province_id'=>$value['province_id']))['cos']/1000000;
			if($r[$key]['cos'] && $flag)
				$tmpProvince[$value['province_id']] = $value['num']/$r[$key]['cos'];
		}
		return $tmpProvince;
	}


	public static function complaintsAnalayzeProvince($param)
	{
		$flag = isset($param['flag'])?$param['flag']:0;
		unset($param['flag']);
		$condition = array();
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
		// $condition['GROUP'] = 'province_id';
		$r = $db->select('co_complaint_province','*',$condition);

		$province = Info::getProvince();
		foreach ($province as $key => $value) {
			$tmpProvince['province'][$value['id']] = 0;
			$tmpProvince['complaints'][$value['id']] = 0;
		}

		foreach ($r as $key => $value) {
			// if($flag)
			// 	$tmpProvince['province'][$value['province_id']] = 0;
			// else
				if(!$value['province_id'])
					continue;
				$tmpProvince['province'][$value['province_id']] = round($value['num']);

			$cos = $db->get('co_income','sum(province_income) as cos',array('province_id'=>$value['province_id']))['cos']/1000000;
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
		$year = date('Y');
		$db=self::__instance();
		if($param['start_date']){
			$year = substr($param['start_date'], 0,4);
			$start = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}
		$start = isset($start)?$start:$year;
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'product_type';
		$r = $db->select('co_complaints','sum(complaint_num) as num,product_type',$condition);

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
			$tmp['num'][$key] = round($value['num']);
			// $cos = $db->get('co_income','sum(province_income) as cos',array('province_id'=>$value['province_id']))['cos']/1000000;
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
			if($key=='case_id'||$key=='buss_name'||$key=='sp_name'||$key=='dispute_phone'||$key == 'complaint_time')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			elseif($key == 'question_type'){
				$complaintType = Info::getComplaintType();
				$questionType = Info::getQuestionType($param['problem_type']);
				$condition['AND']['problem_type'] = $complaintType[$param['problem_type']];
				$condition['AND']['contact_element'] = $questionType[$param['question_type']];
			}elseif($key == 'problem_type'){

			}else
			{
				$condition["AND"][$key] = $value;
			}
		}
		return $db->count('co_complaints',$condition);
	}

	public static function complaintsSpSearchCount($param)
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
			$s = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='case_id'||$key=='buss_name'||$key=='sp_name'||$key=='dispute_phone')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		// $condition['GROUP'] = 'corp_area';
		// $condition['LIMIT']=array($start,$page_size);

		$r = $db->select('co_complaint_province','*',$condition);
		// $r = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);


		if($r && isset($s)) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');

			$r2 = $db->select('co_complaint_province','*',$condition);
			// $r2 = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);
			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				if(!$value['province_id']){
					unset($r[$key]);
					continue;
				}
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));

				$r[$key]['cos'] = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01')))['cos']/10000000;

				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;
				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}

		return $r;
	}

	public static function complaintsAnalayze2($param,$start = 0,$page_size=20){
		$db=self::__instance();
		if($param['start_date']){
			$s = $param['start_date'];
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date'],$param['province_id']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='case_id'||$key=='buss_name'||$key=='sp_name'||$key=='dispute_phone')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		// $condition['GROUP'] = 'buss_class';
		$condition['LIMIT']=array($start,$page_size);
		// var_dump($condition);
		$r = $db->select('co_complaint_class','*',$condition);
		// echo $db->last_query();exit;
		if($r && isset($s)) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			unset($condition['LIMIT']);
			$r2 = $db->select('co_complaint_class','*',$condition);
		// var_dump($start,$condition,$r2);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['class']] = round($value['num']);
			}
			// var_dump($tmp);
			$total = 0;
			foreach ($r as $key => $value) {
				// if(!$value['corp_area']){
				// 	unset($r[$key]);
				// 	continue;
				// }
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$total += $value['num'];
				$t = isset($tmp[$value['class']])?$tmp[$value['class']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				// $r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				// $r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));
				$r[$key]['cos'] = $db->get('co_value_income','sum(value) as cos',array('AND'=>array('buss_type'=>$value['class'],'month'=>strtotime($s.'-01'))))['cos']/10000000;
				if($r[$key]['cos'])
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				else
					$r[$key]['wan'] = 0;
				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return array('list'=>$r,'total'=>$total);
	}

	public static function complaintsAnalayze2Count($param){
		$db=self::__instance();
		$where = ' where 1=1 ';
		if($param['start_date']){
			$where .= ' and month >= '.strtotime($param['start_date'].'-01').' and month < '.strtotime($param['start_date'].'-01 +1 month -1 day');
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
			unset($param['start_date'],$param['end_date'],$param['province_id']);	
		}

		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='case_id'||$key=='buss_name'||$key=='sp_name'||$key=='dispute_phone'||$key =='class')
			{
				$condition["LIKE"]["AND"][$key] = $value;
				$where .= ' and '.$key.' "%'.$value.'%" ';
			}
			else
			{
				$condition["AND"][$key] = $value;
				$where .= ' and '.$key.'='.$value;
			}
		}
		// $where .= ' group by buss_class';
		// $condition['GROUP'] = 'buss_class';
		// $condition['LIMIT']=array($start,$page_size);
		// var_dump($condition);

		// $r = count($db->query('select id from co_complaint_class'.$where)->fetchAll());

		$r = $db->count('co_complaint_class',$condition);
		// var_dump($r);
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
			if($key=='buss_name'||$key=='sp_name'||$key=='sp_corp_code')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}

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
	
	public static function addUnicomBusiness($unicom_business_data) {
		if (! $unicom_business_data || ! is_array ( $unicom_business_data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ('dic_unicom_business', $unicom_business_data );
		return $id;
	}

	public static function getUnicomBusiness($id)
	{
		$db=self::__instance();
		$sql="select * from dic_unicom_business g where g.id = $id and del_flag=0";
		$list = $db->query ($sql)->fetchAll();
		if ($list) {
			return $list;
		}
		return array ();
		
	}
	
	public static function delUnicomBusiness($id) {
		if (! $id || ! is_numeric ( $id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id" => $id);
		$ret = $db->update ('dic_unicom_business', array('del_flag'=>1),$condition );
		return $ret;
	}
	
	public static function addUnicomBusinessSp($unicom_business_sp_data) {
		if (! $unicom_business_sp_data || ! is_array ( $unicom_business_sp_data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ('dic_unicom_business_sp', $unicom_business_sp_data );
		return $id;
	}
	
	public static function getUnicomBusinessWithSpList($param,$start = 0,$page_size = 20)
	{
		
		$db=self::__instance();
		if(empty($param))
			$param = array();
		$where="";
		foreach ($param as $key => $value) {
			if($key=='company_name'||$key=='sp_company_code'||$key=='business_name')
			{
				$where.=" and dub.".$key." like '%".$value."%' ";
			}
			if($key=='sp_access_number')
			{
				$where.=" and dubs.".$key." like '%".$value."%' ";
			}
		}
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$limit="";
		}
		else {
			$limit=" limit $start,$page_size ";
		}
		$sql="select dub.*,dubs.sp_access_number from dic_unicom_business dub,dic_unicom_business_sp dubs
		where dub.sp_company_code=dubs.sp_company_code and dub.del_flag=0 and dubs.del_flag=0 ".$where." order by dub.id ".$limit;
		//var_dump($sql);exit;
		$query=$db->query($sql);
		return $query ? $query->fetchAll(PDO::FETCH_ASSOC)
		 : false;
	}
	
	

	public static function getUnicomBusinessWithSpListCount($param)
	{
		$db=self::__instance();
		if(empty($param))
			$param = array();
		$where="";
		foreach ($param as $key => $value) {
			if($key=='company_name'||$key=='sp_company_code'||$key=='business_name')
			{
				$where.=" and dub.".$key." like '%".$value."%' ";
			}
			if($key=='sp_access_number')
			{
				$where.=" and dubs.".$key." like '%".$value."%' ";
			}
		}

		$sql="select count(1) as c from dic_unicom_business dub,dic_unicom_business_sp dubs
		where dub.sp_company_code=dubs.sp_company_code and dub.del_flag=0 and dubs.del_flag=0 ".$where;
		
		$query=$db->query($sql);
		return $query ? $query->fetchAll(PDO::FETCH_ASSOC)
		 : false;
		
	}
	
	public static function getUnicomBusinessList($param,$start = 0,$page_size = 20)
	{
		
		$db=self::__instance();
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='company_name'||$key=='sp_company_code'||$key=='business_code')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$condition["AND"]["del_flag"] = 0;

		return $db->select('dic_unicom_business','*',$condition);
	}
	
	

	public static function getUnicomBusinessListCount($param)
	{

		$db=self::__instance();
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='company_name'||$key=='sp_company_code'||$key=='business_code')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		
		$condition["AND"]["del_flag"] = 0;
		return $db->count('dic_unicom_business',$condition);
	}
	

	public static function getUnicomBusinessSp($id)
	{
		$db=self::__instance();
		$sql="select * from dic_unicom_business_sp g where g.id = $id and del_flag=0";
		$list = $db->query ($sql)->fetchAll();
		if ($list) {
			return $list;
		}
		return array ();
		
	}
	
	public static function delUnicomBusinessSp($id) {
		if (! $id || ! is_numeric ( $id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id" => $id);
		$ret = $db->update ('dic_unicom_business_sp', array('del_flag'=>1),$condition );
		return $ret;
	}
	
	public static function getUnicomBusinessSpList($param,$start = 0,$page_size = 20)
	{
		
		$db=self::__instance();
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='company_name'||$key=='sp_company_code'||$key=='sp_access_number')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$condition["AND"]["del_flag"] = 0;

		return $db->select('dic_unicom_business_sp','*',$condition);
	}
	
	

	public static function getUnicomBusinessSpListCount($param)
	{

		$db=self::__instance();
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			if($key=='company_name'||$key=='sp_company_code'||$key=='sp_access_number')
			{
				$condition["LIKE"]["AND"][$key] = $value;
			}
			else
			{
				$condition["AND"][$key] = $value;
			}
		}
		
		$condition["AND"]["del_flag"] = 0;
		return $db->count('dic_unicom_business_sp',$condition);
	}
	
	//检查是否有存在的联通在信业务sp名单
	public static function checkUnicomBusinessSp($sp_company_code,$sp_access_number)
	{
		$db=self::__instance();
		$condition["AND"]["sp_company_code"] = $sp_company_code;
		$condition["AND"]["sp_access_number"] = $sp_access_number;
		$condition["AND"]["del_flag"] = 0;
		return $db->count('dic_unicom_business_sp',$condition);
		
	}
	
	//检查是否有存在的联通在信业务 业务信息
	public static function checkUnicomBusiness($sp_company_code,$business_code)
	{
		$db=self::__instance();
		$condition["AND"]["sp_company_code"] = $sp_company_code;
		$condition["AND"]["business_code"] = $business_code;
		$condition["AND"]["del_flag"] = 0;
		return $db->count('dic_unicom_business',$condition);
		
	}
	
	
	//投诉分级列表 
	public static function getAllComplaintsLevel() {
		$db=self::__instance();
		$sql="select * from dic_complaints_level_manage  where del_flag=0  order by complaints_level_sort ";
		$list = $db->query($sql)->fetchAll();
		if ($list) {
			
			return $list;
		}
		return array ();
	}
	
	//根据id获取投诉分级信息
	public static function getComplaintsLevelById($id) {
		if (! $id || ! is_numeric ( $id )) {
			return false;
		}
		$db=self::__instance();
		$condition['id'] = $id;
		$list = $db->select ( "dic_complaints_level_manage", "*", $condition );
		if ($list) {
			return $list [0];
		}
		return array ();
	}
	
	//修改投诉分级的关键词
	public static function updateComplaintsLevelKeywords ( $id,$update_data ) {
		if (! $update_data || ! is_array ( $update_data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$id);
		$id = $db->update ( "dic_complaints_level_manage", $update_data,$condition );
		
		return $id;
	}
	
	//投诉类型及问题分类管理列表 
	public static function getAllComplaintsType() {
		$db=self::__instance();
		$sql="select * from dic_complaints_type_manage  where del_flag=0  order by complaints_type_sort ";
		$list = $db->query($sql)->fetchAll();
		if ($list) {
			
			return $list;
		}
		return array ();
	}
	
	//根据id获取投诉类型及问题分类信息
	public static function getComplaintsTypeById($id) {
		if (! $id || ! is_numeric ( $id )) {
			return false;
		}
		$db=self::__instance();
		$condition['id'] = $id;
		$list = $db->select ( "dic_complaints_type_manage", "*", $condition );
		if ($list) {
			return $list [0];
		}
		return array ();
	}
	
	//修改投诉类型及问题分类的关键词
	public static function updateComplaintsTypeKeywords ( $id,$update_data ) {
		if (! $update_data || ! is_array ( $update_data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$id);
		$id = $db->update ( "dic_complaints_type_manage", $update_data,$condition );
		
		return $id;
	}
	
	public static function delDataByMonth($table,$month)
	{
		$month = strtotime($month.'01');
		// var_dump($table,$month);exit;
		$db=self::__instance();
		$r = $db->delete('co_'.$table,array('month'=>$month));
	}


	public static function getProMonthTotal($province_id,$month)
	{
		$month = strtotime($month.'-01');
		$condition = array('AND'=>array('month'=>$month));
		if($province_id)
			$condition['AND']['province_id']=$province_id;
		$db=self::__instance();
		$r = $db->count('co_base',$condition);
		return $r;
	}

	public static function getBaseTotal($month,$province_id)
	{
		$db=self::__instance();
		$condition = array('AND'=>array('month'=>$month));
		if($province_id)
			$condition['AND']['province_id']=$province_id;
		$r = $db->count('co_base',$condition);

		return $r;
	}

	
	public static function getComplaintTotal($month,$province_id)
	{
		$db=self::__instance();
		$condition = array('AND'=>array('month'=>$month));
		if($province_id)
			$condition['AND']['province_id']=$province_id;
		$r = ceil($db->sum('co_complaint_province','num',$condition));

		return $r;
	}
	
	public static function getCustomTotal($month,$province_id)
	{
		$db=self::__instance();
		$condition = array('AND'=>array('month'=>$month));
		if($province_id)
			$condition['AND']['province_id']=$province_id;
		$r = ceil($db->sum('co_custom','complaint_total',$condition));

		return $r;
	}

	public static function getImprotData($date,$table)
	{
		$db=self::__instance();
		$condition = array('AND'=>array('month'=>strtotime($date.'-01'),'`table`'=>$table));
		$r = $db->query("SELECT * FROM co_table_record WHERE month = '".strtotime($date.'-01')."' AND `table` = '".$table."'")->fetchAll();
		// if($table == 'complaints'){
		// 	// $condition['AND'][] = array('corp_area'=>$province_id);
		// 	$condition['GROUP'] = 'corp_area';
		// }else{
		// 	// $condition['AND'][] = array('province_id'=>$province_id);
		// }
		// $condition['GROUP'] = 'province_id';
// var_dump($condition);
// 		$r = $db->select('co_table_record','*',$condition);
		return $r;

	}

	public static function delData($id,$table)
	{
		$provinceName = $table=='complaints'?'corp_area':'province_id';
		$db=self::__instance();
		$r = $db->delete('co_'.$table,array('AND'=>array('record_id'=>$id)));
		if($r)
			$db->delete('co_table_record',array('id'=>$id));
	}

	public static function getValueTotal($month)
	{
		$db=self::__instance();
		// $r = $db->sum('value',array('month'=>$month));
		$r = $db->query('select sum(value) as num from co_value_income where `month`='.$month)->fetchAll();
		return $r[0]['num'];
	}

	public static function getSpDetail($sp_corp_code,$month)
	{
		$db=self::__instance();
		$r = $db->select('co_base','*,count(*) as num',array('AND'=>array('sp_corp_code'=>$sp_corp_code,'month'=>$month),'GROUP'=>'province_id'));

		foreach ($r as $key => $value) {
			if(!$value['province_id']){
				unset($r[$key]);
				continue;
			}

			$r[$key]['cos'] = self::getCos(array('province_id'=>$value['province_id'],'month'=>$month,'sp_code'=>$sp_corp_code))['cos']/10000;

			$r[$key]['wan'] = $r[$key]['cos']?$value['num']/$r[$key]['cos']:0;

			# code...
		}
		return $r;
	}

	public static function getCustomSpDetail($sp_corp_code,$month)
	{
		$db=self::__instance();
		$r = $db->select('co_custom','*,count(*) as num',array('AND'=>array('part_code'=>$sp_corp_code,'month'=>$month),'GROUP'=>'province_id'));

		foreach ($r as $key => $value) {
			if(!$value['province_id']){
				unset($r[$key]);
				continue;
			}
			$r[$key]['valid'] = $db->select('co_custom','count(*) as num',array('AND'=>array('part_code'=>$sp_corp_code,'month'=>$month,'complaint_status'=>'有效','province_id'=>$value['province_id'])))[0]['num'];

			$r[$key]['cos'] = self::getCos(array('province_id'=>$value['province_id'],'month'=>$month,'sp_code'=>$sp_corp_code))['cos']/10000;

			$r[$key]['wan'] = $r[$key]['cos']?$value['num']/$r[$key]['cos']:0;
		}
		return $r;
	}
	
	public static function getCustomSingleDetail($buss_name_detail,$month)
	{
		$db=self::__instance();
		$r = $db->select('co_custom','*,count(*) as num',array('AND'=>array('buss_name'=>$buss_name_detail,'month'=>$month),'GROUP'=>'province_id'));
		if($r && isset($month)) {
			$condition["AND"]['month[=]'] = strtotime(date('Y-m-d',$month).' -1 month');
			$condition["AND"]['buss_name'] = $buss_name_detail;
			// var_dump($condition);
			$r2 = $db->select('co_custom','*,count(*) as num',$condition);
			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				if(!$value['province_id']){
					unset($r[$key]);
					continue;
				}
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;

				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r;
	}

	public static function getSingleDetail($buss_name_detail,$month)
	{
		$db=self::__instance();
		$r = $db->select('co_base','*,count(*) as num',array('AND'=>array('buss_name_detail'=>$buss_name_detail,'month'=>$month),'GROUP'=>'province_id'));
		if($r && isset($month)) {
			$condition["AND"]['month[=]'] = strtotime(date('Y-m-d',$month).' -1 month');
			$condition["AND"]['buss_name_detail'] = $buss_name_detail;
			// var_dump($condition);
			$r2 = $db->select('co_base','*,count(*) as num',$condition);
			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['province_id']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				if(!$value['province_id']){
					unset($r[$key]);
					continue;
				}
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['province_id']])?$tmp[$value['province_id']]:0;

				$r[$key]['valid'] = $valid;
				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(round(($value['num'] - $t)*10000/($t))/100).'%':'--';
			}
		}
		return $r;
	}

	public static function blackListPhoneContent($phone)
	{
		$db=self::__instance();
		$r1 = $db->select('co_base','complaint_content',array('complaint_phone'=>$phone));
		$r2 = $db->select('co_complaints','complaint_content',array('dispute_phone'=>$phone));
		$r3 = $db->select('co_custom','complaint_content',array('complaint_phone'=>$phone));
		if($r1)
			$r[1] = $r1[0]['complaint_content'];
		if($r2)
			$r[2] = $r2[0]['complaint_content'];
		if($r3)
			$r[3] = $r3[0]['complaint_content'];
		return $r;
	}
}