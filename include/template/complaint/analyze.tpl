<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<div style="border:0px;padding-bottom:5px;height:auto">
	<form action="" method="POST" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">
			<label> 选择省份 </label>
			<select name="province_id"><option value="0">全部</option>
			<{foreach name=province from=$data.province item=province}>
				<option value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
			<{/foreach}>
			</select>
		</div>
		<div style="float:left;margin-right:5px">
			<label> 选择起始时间 </label>
			<input type="text" id="start_date" name="start_date" value="<{$_GET.start_date}>" placeholder="起始时间" >
		</div>
		<div style="float:left;margin-right:5px">
			<label>选择结束时间</label>	
			<input type="text" id="end_date" name="end_date" value="<{$_GET.end_date}>" placeholder="结束时间" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 具体业务名称</label>
				<input type="text" name="buss_name" value="<{$_GET.buss_name}>" placeholder="具体业务名称" > 

		</div>
		<div style="float:left;margin-right:5px">
		<label> SP接入号码</label>
				<input type="text" name="sp_code" value="<{$_GET.sp_code}>" placeholder="SP接入号码" > 

		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="sp_name" value="<{$_GET.sp_name}>" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP企业代码</label>
				<input type="text" name="sp_corp_code" value="<{$_GET.sp_corp_code}>" placeholder="SP企业代码" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务线</label>
				<input type="text" name="buss_line" value="<{$_GET.buss_line}>" placeholder="业务线" > 
		</div>
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">
		<button type="submit" class="btn btn-primary"><strong>检索</strong></button>
		</div>
		<div style="clear:both;"></div>
	</div>
	</form>
</div>

<div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">操作记录</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:30px">#</th>
					<th style="width:50px">省市</th>
					<th style="width:55px">工单时间</th>
					<th style="width:35px">月投诉件数</th>
					<th style="width:55px">投诉量/业务收入</th>
					<th style="width:30px">环比增长量</th>
					<th style="width:30px">环比增长率</th>
                </tr>
              </thead>
              <tbody>							  
                <{foreach name=sys_log from=$sys_logs item=sys_log}>
					<tr>
					<td><{$sys_log.op_id}></td>
					<td><{$sys_log.user_name}></td>
					<td><{$sys_log.action}></td>
					<td><{$sys_log.class_name}></td>
					<td><{$sys_log.class_obj}></td>
					<td style = "word-break: break-all; word-wrap:break-word;"><{$sys_log.result}></td>
					<td><{$sys_log.op_time}></td>
					
					</tr>
				<{/foreach}>
              </tbody>
            </table>
				<!--- START 分页模板 --->
               <{$page_html}>
			   <!--- END -->
        </div>
    </div>
    <div>
    	<canvas id="myChart" width="" height=""></canvas>
    </div>
<script>
$(function() {
	var data = {
		labels : ["January","February","March","April","May","June","July"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : [65,59,90,81,56,55,40]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [28,48,40,19,96,27,100]
			}
		]
	}

	var ctx = document.getElementById("myChart").getContext("2d");
	// var myNewChart = new Chart(ctx).PolarArea(data);
	new Chart(ctx).Bar(data);
	var date=$( "#start_date" );
	date.datepicker({ dateFormat: "yy-mm-dd" });
	date.datepicker( "option", "firstDay", 1 );
});
$(function() {
	var date=$( "#end_date" );
	date.datepicker({ dateFormat: "yy-mm-dd" });
	date.datepicker( "option", "firstDay", 1 );
});
</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>