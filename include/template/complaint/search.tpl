<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<div style="border:0px;padding-bottom:5px;height:auto">
	<form action="" method="GET" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">

			<label> 选择省份 </label>
			<select name="province_id"><option value="0">全部</option>
			<{foreach name=province from=$data.province item=province}>
				<option value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
			<{/foreach}>
			</select>
			<!-- <{$data.province}> -->
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
		<label> SP公司名称</label>
				<input type="text" name="sp_name" value="<{$_GET.sp_name}>" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP企业代码</label>
				<input type="text" name="sp_corp_code" value="<{$_GET.sp_corp_code}>" placeholder="SP企业代码" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 投诉类型 </label>
			<select name="complaint_type"><option value="0">全部</option>
			<{foreach name=complaintType from=$data.complaintType key=key item=complaintType}>
				<option value="<{$key}>" <{if $param.complaint_type == $key}> selected='selected'<{/if}>><{$complaintType}></option>
			<{/foreach}>
			</select>
			<!-- <{$data.complaintType}> -->
				<!-- <input type="text" name="sp_code" value="<{$_GET.sp_code}>" placeholder="投诉类型" >  -->
		</div>
		<div style="float:left;margin-right:5px">

		<label> 投诉问题分类 </label>
			<div class="question_type">
			<select name="question_type">
				<option value="0">全部</option>
			</select>				
			</div>

		</div>
		<div style="float:left;margin-right:5px">
		<label> 投诉分级 </label>
			<select name="complaint_level"><option value="0">全部</option>
			<{foreach name=complaintLevel from=$data.complaintLevel key=key item=complaintLevel}>
				<option value="<{$key}>" <{if $param.complaint_level == $key}> selected='selected'<{/if}>><{$complaintLevel}></option>
			<{/foreach}>
			<!-- <{$data.complaintLevel}> -->
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务线</label>
			<{$data.bussLine}>
		</div>
		<div style="float:left;margin-right:5px">
		<label> sp接入号码</label>
				<input type="text" name="buss_line" value="<{$_GET.buss_line}>" placeholder="sp接入号码" > 
		</div>
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">
		<button type="submit" class="btn btn-primary"><strong>检索</strong></button>
		</div>
		<div style="clear:both;"></div>
	</div>
	</form>
</div>
<div class="hide">
<div class="question1">
			<{$data.questionType.1}>	
</div>
<div class="question2">
			<{$data.questionType.2}>	
</div>
<div class="question3">
			<{$data.questionType.3}>	
</div>
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
					<th style="width:35px">投诉号码</th>
					<th style="width:55px">具体业务名称</th>
					<th style="width:30px">业务资费</th>
					<th style="width:30px">sp公司名称</th>
					<th style="width:30px">sp企业代码</th>
					<th style="width:30px">sp接入代码</th>
					<th style="width:30px">投诉内容</th>
					<th style="width:30px">处理意见</th>
					<th style="width:30px">投诉类型</th>
					<th style="width:30px">投诉问题分类</th>
					<th style="width:30px">投诉分级</th>
					<th style="width:30px">业务线</th>
                </tr>
              </thead>
              <tbody>							  
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$result.id}></td>
					<td><{$result.province_id}></td>
					<td><{$result.order_time|date_format:'%Y-%m-%d %H:%M:%S'}></td>
					<td><{$result.complaint_phone}></td>
					<td><{$result.buss_name}></td>
					<td><{$result.buss_rates}></td>
					<td><{$result.sp_name}></td>
					<td><{$result.sp_corp_code}></td>
					<td><{$result.sp_code}></td>
					<td><{$result.complaint_content}></td>
					<td><{$result.suggestion}></td>
					<td><{$result.complaint_type}></td>
					<td><{$result.problem_type}></td>
					<td><{$result.complaint_level}></td>
					<td><{$result.buss_line}></td>
					<!-- <td style = "word-break: break-all; word-wrap:break-word;"><{$result.result}></td> -->
					<!-- <td><{$result.op_time}></td> -->
					</tr>
				<{/foreach}>
              </tbody>
            </table>
				<!--- START 分页模板 -->
               <{$page_html}>
			   <!--- END -->
        </div>
    </div>
<script>
$(function() {
	var date=$( "#start_date" );
	date.datepicker({ dateFormat: "yy-mm-dd" });
	date.datepicker( "option", "firstDay", 1 );
});
$(function() {
	var date=$( "#end_date" );
	date.datepicker({ dateFormat: "yy-mm-dd" });
	date.datepicker( "option", "firstDay", 1 );
});

$(function(){
	$('[name="complaint_type"]').change(function(msg){
		$('.question_type').html($('.question'+$(this).val()).html());
	});
})
</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>