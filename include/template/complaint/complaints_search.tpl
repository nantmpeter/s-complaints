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
			<label> 统计月份 </label>
			<input type="text" id="start_date" name="start_date" value="<{$_GET.start_date}>" placeholder="统计月份" >
		</div>
		<div style="float:left;margin-right:5px">
			<label> 申诉日期 </label>
			<input type="text" id="appeal_date" name="appeal_date" value="<{$_GET.appeal_date}>" placeholder="申诉日期" >
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务名称</label>
			<input type="text" name="buss_name" value="<{$_GET.buss_name}>" placeholder="具体业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 案件编号</label>
			<input type="text" name="case_id" value="<{$_GET.case_id}>" placeholder="案件编号" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 投诉号码</label>
			<input type="text" name="dispute_phone" value="<{$_GET.dispute_phone}>" placeholder="投诉号码" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="sp_name" value="<{$_GET.sp_name}>" placeholder="SP公司名称" > 
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
					<th style="width:50px">省市</th>
					<th style="width:50px">案件编号</th>
					<th style="width:55px">申诉日期</th>
					<th style="width:35px">投诉号码</th>
					<th style="width:35px">产品类别</th>
					<th style="width:35px">业务名称</th>
					<th style="width:35px">sp公司名称</th>
					<!-- <th style="width:55px">具体业务名称</th> -->
					<!-- <th style="width:30px">业务资费</th> -->
					<!-- <th style="width:30px">sp公司名称</th> -->
					<th style="width:30px">sp企业代码</th>
					<th style="width:30px">sp接入代码</th>
					<th style="width:30px">投诉内容</th>
					<th style="width:30px">申诉内容</th>
					<th style="width:30px">申诉核查情况</th>
					<!-- <th style="width:30px">处理意见</th> -->
					<!-- <th style="width:30px">投诉类型</th> -->
					<th style="width:30px">投诉问题分类</th>
					<!-- <th style="width:30px">投诉分级</th> -->
					<th style="width:30px">业务线</th>
                </tr>
              </thead>
              <tbody>							  
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$data.province[$result.corp_area]['name']}></td>
					<td><{$result.case_id}></td>
					<td><{$result.complaint_time|date_format:'%Y-%m-%d'}></td>
					<td><{$result.phone}></td>
					<td><{$result.product_type}></td>
					<td><{$result.buss_name}></td>
					<td><{$result.sp_corp_name}></td>
					<!-- <td><{$result.sp_name}></td> -->
					<td><{$result.sp_corp_code}></td>
					<td><{$result.sp_code}></td>
					<td><{$result.complaint_content}></td>
					<td><{$result.10010_content}></td>
					<td><{$result.complaint_status}></td>
					<!-- <td><{$result.suggestion}></td> -->
					<!-- <td><{$result.complaint_type}></td> -->
					<td><{$result.problem_type}></td>
					<td><{$result.buss_type}></td>
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

	$( "#start_date" ).datetimepicker({format: 'yyyy-mm',startView: 3,minView: 3,viewSelect:'year'});
	$( "#appeal_date" ).datetimepicker({format: 'yyyy-mm-dd',startView: 2,minView: 2,viewSelect:'year'});

});


$(function(){
	$('[name="complaint_type"]').change(function(msg){
		$('.question_type').html($('.question'+$(this).val()).html());
	});
})
</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>