<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<div style="border:0px;padding-bottom:5px;height:auto">

	<form action="" method="GET" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">
			<label> 投诉号码</label>
			<input type="text" name="complaint_phone" value="<{$_GET.complaint_phone}>" placeholder="投诉号码" > 
		</div>
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
		<label> 具体业务名称</label>
			<input type="text" name="buss_name" value="<{$_GET.buss_name}>" placeholder="具体业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="sp_corp_name" value="<{$_GET.sp_corp_name}>" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司代码</label>
				<input type="text" name="sp_corp_code" value="<{$_GET.sp_corp_code}>" placeholder="SP公司代码" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 黑名单级别</label>
			<select name="level"><option value="0">全部</option>
			<option value="1" <{if $param.level == 1}> selected='selected'<{/if}>>一级</option>
			<option value="2" <{if $param.level == 2}> selected='selected'<{/if}>>二级</option>
			<option value="3" <{if $param.level == 3}> selected='selected'<{/if}>>三级</option>
			</select>
		</div>

		
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">

		<div>
		<button type="submit" class="btn btn-primary"><strong>检索</strong></button>
			
		</div>
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
		<a style="float:right;padding:10px;" href="<{$export_excel}>" target="" >导出excel</a>
        <a href="#page-stats" class="block-heading" data-toggle="collapse">操作记录</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:50px">投诉号码</th>
					<th style="width:50px">省</th>
					<th style="width:50px">公司sp代码</th>
					<th style="width:50px">录入时间</th>
					<th style="width:50px">sp公司</th>
					<th style="width:30px">投诉号码标签</th>
					<th style="width:30px">黑名单级别</th>
					<th style="width:30px">屏蔽时限</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$result.complaint_phone}></td>
					<td><{$data.province[$result.province_id]['name']}></td>
					<td><{$result.sp_corp_code}></td>
					<td><{$result.month|date_format:'%Y-%m'}></td>
					<td><{$result.sp_corp_name}></td>
					<td><{$result.complaint_phone_tag}></td>
					<td><{$result.level}></td>
					<td><{$result.time_limit}></td>
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
	date.datetimepicker({format: 'yyyy-mm',startView: 3,minView: 3,viewSelect:'year'});
	// date.datepicker( "option", "firstDay", 1 );
});


$(function(){
	$('[name="complaint_type"]').change(function(msg){
		$('.question_type').html($('.question'+$(this).val()).html());
	});
})
</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>