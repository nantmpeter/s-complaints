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
	private static $black_list = "complaint_phone,province_id,sp_corp_code,month,sp_corp_name,complaint_phone_tag,level,time_limit,record_id";

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
			if(strtotime($month.'-01') != $param[25])
				return true;
			if($province_id != $param[0])
				return true;

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
			$param[29] = strtotime($param[29].'01');
			if(strtotime($month.'-01') != $param[29])
				return true;
			$param[22] = Info::getProvinceByName($param[22]);
			// if($province_id != $param[22])
			// 	return true;
			$param[25] = ExcelReader::xlsTime($param[25]);
			$param[6] = ExcelReader::xlsTime($param[6]);
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
				return true;
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
				return true;
		}
		if ($table == 'value_income') {
			$param[0] = strtotime($param[0].'01');
			if(strtotime($month.'-01') != $param[0])
				return true;
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
		$checkParams['custom'] = 20;
		$db=self::__instance();
		$params = explode(',', self::$$table);

		// var_dump(count($params),count($arr[1]),$arr[1]);exit;
		$r = $db->select('co_'.$table,'*',array($params[$checkParams[$table]]=>$arr[1][$checkParams[$table]]));
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
			$condition["AND"]['order_time[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['order_time[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
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
			if($key=='buss_name'||$key=='sp_name'||$key=='complaint_phone'||$key='part_name')
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
		return $db->select('co_custom','*',$condition);
	}

	public static function customSearchCount($param)
	{
		$condition = array();
		$db=self::__instance();
		if($param['start_date']){
			$condition["AND"]['month[>=]'] = strtotime($param['start_date'].'-01');
			$condition["AND"]['month[<]'] = strtotime($param['start_date'].'-01 +1 month -1 day');
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
		$r = $db->select('co_custom','*,sum(complaint_total) as num',$condition);

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
				$valid = $db->count('co_custom',array('AND'=>array('complaint_status'=>'有效','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉成功','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealFail'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealNot'] = $valid-$db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','province_id'=>$value['province_id'],'month'=>strtotime($s.'-01'))));
				$r[$key]['cos'] = self::getCos(array('province_id'=>$value['province_id'],'month'=>strtotime($s.'-01')))['cos']/10000;
				$r[$key]['customCost'] = $db->get('co_income','sum(custom_cost) as cos',array('AND'=>array('sp_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))))['cos'];

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

	public static function getCos($params)
	{
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
		$condition['GROUP'] = 'province_id';
		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$r = $db->select('co_base','*,count(*) as num',$condition);

		if($r && isset($s)) {
			unset($condition["AND"]);
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
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
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		$r2 = $r2?$r2:array();

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

		//如果$page_size为0表示获取所有满足条件的记录
		if(0==$page_size)
		{
			$condition['LIMIT']=array($start);
		}
		else {
			$condition['LIMIT']=array($start,$page_size);
		}
		$r = $db->select('co_custom','*,count(*) as num',$condition);


		if($r && $s) {
			$condition["AND"]['order_time[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['order_time[<]'] = strtotime($s.'-01 -1 day');
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
				$r[$key]['appealNot'] = $valid-$db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','part_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))));
				$r[$key]['customCost'] = $db->get('co_income','sum(custom_cost) as cos',array('AND'=>array('sp_name'=>$value['part_name'],'month'=>strtotime($s.'-01'))+$tmpProCondition))['cos'];

				$cosCondition = array('sp_name'=>$value['part_name'],'month'=>strtotime($s.'-01'));
				
				$r[$key]['cos'] = self::getCos($cosCondition)['cos']/10000;

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
			$condition['LIMIT']=array($start,$page_size);
		}

		$r = $db->select('co_base','*,count(*) as num',$condition);

		if($r && $s) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_base','*,count(*) as num',$condition);


			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['sp_name']] = $value['num'];
			}

			foreach ($r as $key => $value) {
				$t = isset($tmp[$value['sp_name']])?$tmp[$value['sp_name']]:0;

				$cosCondition = array('sp_name'=>$value['sp_name'],'month'=>strtotime($s.'-01'));

				if(isset($param['province_id']) && $param['province_id']){
					$cosCondition['province_id']=$param['province_id'];
				}else{
					$province = $db->select('co_base','province_id',array('AND'=>array('month'=>strtotime($s.'-01')),'GROUP'=>'province_id'));
					// $a = $db->query('SELECT `province_id` FROM `co_base` GROUP BY `province_id`')->fetchAll();
					foreach ($province as $k => $v) {
						$cosCondition['province_id'][] = $v['province_id'];
					}
					// $cosCondition['province_id'] = implode(',', $cosCondition['province_id']);
				}

				$r[$key]['cos'] = self::getCos($cosCondition)['cos']/10000;

				if($r[$key]['cos']){
					$r[$key]['wan'] = $value['num']/$r[$key]['cos'];
				}
				else{
					$r[$key]['wan'] = 0;
				}

				$r[$key]['increase'] = $value['num'] - $t;
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}

		return $r;
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
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			$r2 = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['sp_corp_name']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['part_name']])?$tmp[$value['part_name']]:0;
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
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
			}
		}
		return $r;
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
		// var_dump($condition);
		$r = $db->select('co_custom','*,count(*) as num',$condition);
		// echo $db->last_query();
		// var_dump($r);
		if($r && isset($s)) {
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

				$valid = $db->count('co_custom',array('AND'=>array('complaint_status'=>'有效','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealSuc'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉成功','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealFail'] = $db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))));
				$r[$key]['appealNot'] = $valid-$db->count('co_custom',array('AND'=>array('appeal_status'=>'申诉失败','buss_name'=>$value['buss_name'],'month'=>strtotime($s.'-01'))));

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
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
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

		$r = $db->select('co_custom','*,count(*) as num',$condition);
		$tmp = $data = array();
		foreach ($r as $key => $value) {
			// var_dump($value);exit;
			$tmp['name'][$key] = $data[$key]['name'] = $value['part_name'];
			$cosCondition = array('sp_name'=>$value['part_name'],'month'=>strtotime($s.'-01'));
				
			$cos = self::getCos($cosCondition)['cos']/10000;

			// $cos = $db->get('co_income','sum(province_income) as cos',array('province_id'=>$value['province_id']))['cos']/10000;
			$tmp['score'][$key] = $data[$key]['score'] = $cos?($value['num']/$cos):0;
			// var_dump($cos,$value['num']);
		}
		if($r){
			array_multisort($tmp['score'], SORT_DESC, $tmp['name'], SORT_ASC, $data);
			array_splice($data, 20);
			return $data;
		}
		return array();
	}

	public static function customAnalayzeMonth($param)
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
		$s = isset($s)?$s:date('Y');
		if(empty($param))
			$param = array();
		foreach ($param as $key => $value) {
			$condition["AND"][$key] = $value;
		}
		$condition['GROUP'] = 'm';

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
			'sum(province_income) as cos',
			array(
					'AND'=>array(
						'month[<]'=>strtotime($start.'-01 +1 month -1 day'),
						'month[>=]'=>strtotime($start.'-01'),
						'province_id'=>$resultProvince
						)
					)
				)['cos']/10000;
		$rNum = $db->get('co_base','count(*) as num',array(
							'AND'=>array(
								'month[<]'=>strtotime($start.'-01 +1 month -1 day'),
								'month[>=]'=>strtotime($start.'-01'),
								)
							))['num'];
		$lastMonth = array();

		$lastMonth = $db->get(
			'co_income',
			'sum(province_income) as cos',
			array(
				'AND'=>array(
				'month[>=]'=>strtotime($start.'-01 -1 month'),
				'month[<]'=>strtotime($start.'-01 -1 day'),
				'province_id'=>$resultProvince
				)
				)
			)['cos']/10000;
		$lastMonthNum = $db->get(
			'co_base',
			'count(*) as num',
			array(
				'AND'=>array(
				'month[>=]'=>strtotime($start.'-01 -1 month'),
				'month[<]'=>strtotime($start.'-01 -1 day')
				)
				)
			)['num'];

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

		return array($start=>$rn,date('Y-m',strtotime($start.'-01 -1 month'))=>$lastN);

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
		$r = $db->select('co_complaints','sum(complaint_num) as num,FROM_UNIXTIME(month,"%Y-%m") AS m',$condition);
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
		return implode(',', $tmpProvince);
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
		$condition['GROUP'] = 'province_id';
		$r = $db->select('co_complaints','sum(complaint_num) as num,corp_area as province_id',$condition);

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
			$condition["AND"][$key] = $value;
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
		$condition['GROUP'] = 'corp_area';
		// $condition['LIMIT']=array($start,$page_size);

		$r = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);


		if($r && isset($s)) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');

			$r2 = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);
			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['corp_area']] = round($value['num']);
			}
			foreach ($r as $key => $value) {
				if(!$value['corp_area']){
					unset($r[$key]);
					continue;
				}
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$t = isset($tmp[$value['corp_area']])?$tmp[$value['corp_area']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				// $r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				// $r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));
				// $r2 = $db->select('co_value_income','sum(value) as num',$condition);
				// var_dump($r2);exit;
				// echo 'select sum(custom_cost) as num where month='.strtotime($s.'-01').' and province_id='.$value['corp_area'];
				// $r = $db->query('select sum(custom_cost) as num where month='.strtotime($s.'-01').' and province_id='.$value['corp_area'].' ')->fetchAll();
				// var_dump($r);exit;
				// $r[$key]['cos'] = $db->sum('co_value_income','value',array('AND'=>array('month'=>strtotime($s.'-01'))))/10000000;
				$r[$key]['cos'] = self::getCos(array('province_id'=>$value['corp_area'],'month'=>strtotime($s.'-01')))['cos']/10000000;

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
		$condition['GROUP'] = 'buss_class';
		$condition['LIMIT']=array($start,$page_size);

		$r = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);

		if($r && isset($s)) {
			$condition["AND"]['month[>=]'] = strtotime($s.'-01 -1 month');
			$condition["AND"]['month[<]'] = strtotime($s.'-01 -1 day');
			unset($condition['LIMIT']);
			$r2 = $db->select('co_complaints','*,sum(complaint_num) as num',$condition);
		// var_dump($start,$condition,$r2);

			$tmp = array();
			foreach ($r2 as $key => $value) {
				$tmp[$value['buss_class']] = round($value['num']);
			}
			// var_dump($tmp);
			$total = 0;
			foreach ($r as $key => $value) {
				if(!$value['corp_area']){
					unset($r[$key]);
					continue;
				}
				$value['num'] = $r[$key]['num'] = round($value['num']);
				$total += $value['num'];
				$t = isset($tmp[$value['buss_class']])?$tmp[$value['buss_class']]:0;
				$valid = $db->count('co_custom',array('complaint_status'=>'有效'));
				// $r[$key]['appealSuc'] = $db->count('co_custom',array('appeal_status'=>'申诉成功'));
				// $r[$key]['appealFail'] = $db->count('co_custom',array('appeal_status'=>'申诉失败'));
				// $r[$key]['appealNot'] = $valid-$db->count('co_custom',array('appeal_status'=>'失败'));
				$r[$key]['cos'] = $db->get('co_value_income','sum(value) as cos',array('AND'=>array('buss_type'=>$value['buss_class'],'month'=>strtotime($s.'-01'))))['cos']/10000000;
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
		$where = ' where 1=1 ';
		if($param['start_date']){
			$where .= ' and month >= '.strtotime($param['start_date'].'-01').' and month < '.strtotime($param['start_date'].'-01 +1 month -1 day');
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
				$where .= ' and '.$key.' "%'.$value.'%" ';
			}
			else
			{
				$condition["AND"][$key] = $value;
				$where .= ' and '.$key.'='.$value;
			}
		}
		$where .= ' group by buss_class';
		$condition['GROUP'] = 'buss_class';
		// $condition['LIMIT']=array($start,$page_size);
		// var_dump($condition);

		$r = count($db->query('select id from co_complaints'.$where)->fetchAll());
		// $r = $db->count('co_complaints',$condition);
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
			$condition['AND']['corp_area']=$province_id;
		$r = ceil($db->sum('co_complaints','complaint_num',$condition));

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
				$r[$key]['increasePercent'] = $t?(($value['num'] - $t)/$t * 100).'%':'';
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