<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<style type="text/css">

</style>
<div style="border:0px;padding-bottom:5px;height:auto">
	<form action="" method="GET" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">

			<label> 选择省份 </label>
			<select name="province_id"><option value="0">全部</option>
            <{if $user_province_id > 0 }>
                <option value="<{$user_province_id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$data.province.$user_province_id.name}></option>

            <{else}>
			<{foreach name=province from=$data.province item=province}>
				<option value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
			<{/foreach}>
            <{/if}>
			</select>
			<!-- <{$data.province}> -->
		</div>
		<div style="float:left;margin-right:5px">
			<label> 统计月份 </label>
			<input type="text" id="start_date" name="start_date" value="<{$_GET.start_date}>" placeholder="统计月份">
		</div>
		<div style="float:left;margin-right:5px">
		<label> 具体业务名称</label>
			<input type="text" name="buss_name_detail" value="<{$_GET.buss_name_detail}>" placeholder="具体业务名称" > 
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
			<select id="complaint_type" name="complaint_type"><option value="0">全部</option>
			<{foreach name=complaintType from=$data.complaintType key=key item=complaintType}>
				<option value="<{$key}>" <{if $complaint_type == $key}> selected='selected'<{/if}>><{$complaintType}></option>
			<{/foreach}>
			</select>
			<!-- <{$data.complaintType}> -->
				<!-- <input type="text" name="sp_code" value="<{$_GET.sp_code}>" placeholder="投诉类型" >  -->
		</div>
		<div style="float:left;margin-right:5px">

		<label> 投诉问题分类 </label>
			<div class="problem_type">
			<select name="problem_type">
				<option value="0">全部</option>
			</select>				
			</div>

		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务类型</label>
			<select name="buss_name"><option value="0">全部</option>
			<{foreach name=bussLine from=$data.bussLine item=bussLine key=key}>
				<option value="<{$bussLine}>" <{if $param.buss_name == $bussLine}> selected='selected'<{/if}>><{$bussLine}></option>
			<{/foreach}>
			</select>
		</div>
		<div style="float:left;margin-right:5px">
		<label> 投诉分级</label>
			<select name="complaint_level"><option value="0">全部</option>
			<{foreach name=complaintLevel from=$data.complaintLevel key=key item=complaintLevel}>
				<option value="<{$key}>" <{if $complaint_level == $key}> selected='selected'<{/if}>><{$complaintLevel}></option>
			<{/foreach}>
			</select>
		</div>

	<!-- 	<div style="float:left;margin-right:5px">
		<label> sp接入号码11</label>
				<input type="text" name="buss_line" value="<{$_GET.buss_line}>" placeholder="sp接入号码" > 
		</div> -->
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
		<a style="float:right;padding:10px;" href="<{$export_excel}>" target="" >导出excel</a>
		<a style="float:right;padding:10px;" href="javascript:;" onclick="updateComplaintLevelAndType()" >手动更新</a>
        <a href="#page-stats" class="block-heading" data-toggle="collapse">操作记录</a>
        <{if $data.result|@count > 0}>
        <div id="page-stats" class="block-body collapse in" style="width:97%">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:50px">省市</th>
					<th style="width:55px">工单时间</th>
					<th style="width:35px">投诉号码</th>
					<th style="width:55px">具体业务名称</th>
					<th style="width:30px">统计月份</th>
					<th style="width:30px">sp公司名称</th>
					<th style="width:30px">sp企业代码</th>
					<th style="width:30px">sp接入代码</th>
					<th style="width:30px">投诉内容</th>
					<th style="width:30px">处理意见</th>
					<th style="width:30px">投诉类型</th>
					<th style="width:30px">投诉问题分类</th>
					<th style="width:30px">投诉分级</th>
					<th style="width:30px">业务类型</th>
                </tr>
              </thead>
              <tbody>							  
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$data.province[$result.province_id].name}></td>
					<td><{$result.order_time|date_format:'%Y-%m-%d %H:%M:%S'}></td>
					<td><{$result.complaint_phone}></td>
					<td><{$result.buss_name_detail}></td>
					<td><{$result.month|date_format:'%Y-%m'}></td>
					<td><{$result.sp_name}></td>
					<td><{$result.sp_corp_code}></td>
					<td><{$result.sp_code}></td>
					<td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.complaint_content}>" title="" data-original-title1="投诉内容">详情</a></td>
					<td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.suggestion}>" title="" data-original-title1="处理意见">详情</a></td>
					<td><{$result.complaint_type}></td>
					<td><{$result.problem_type}></td>
					<td><{$result.complaint_level}></td>
					<td><{$result.buss_name}></td>
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
        <{else}>
        	<h4>当月无数据！</h4>
        <{/if}>
    </div>

<script>
$(function() {
	var date=$( "#start_date" );
	date.datetimepicker({format: 'yyyy-mm',startView: 3,minView: 3,viewSelect:'year'});
});

var map = new Array();
map['服务规范性'] = 1;
map['业务可用性'] = 2;
map['用户原因'] = 3;
$(function(){
	$('[name="complaint_type"]').change(function(msg){

		if($(this).val()!=0)
		{
			// $('.question_type').html($('.question'+map[$(this).val()]).html());
			$('.problem_type').html($('.question'+$(this).val()).html());
		}
		else
		{
			$('.problem_type').html("<select name='problem_type'><option value='0'>全部</option>");
			
		}

	});
	$('.problem_type').html($('.question'+$('[name="complaint_type"]').val()).html());

})

function updateComplaintLevelAndType()
{
	alert("请不要关闭此页面，更新过程可能比较慢 ，大概1000条/分钟，更新完毕会提示更新成功");
	$.ajax({
        type: "POST",
        url: "search.php",
        data: {method:"updateComplaintLevelAndType",start_date:$('#start_date').val()},

        success: function(data){
            
            alert(data);
            
        }
	});
	
}
</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>