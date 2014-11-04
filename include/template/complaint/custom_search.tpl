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
		<label> 投诉号码</label>
			<input type="text" name="complaint_phone" value="<{$_GET.complaint_phone}>" placeholder="具体业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 具体业务名称</label>
			<input type="text" name="buss_name" value="<{$_GET.buss_name}>" placeholder="具体业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="part_name" value="<{$_GET.part_name}>" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务线</label>
			<select name="buss_type"><option value="0">全部</option>
			<{foreach name=bussLine from=$data.bussLine item=bussLine key=key}>
				<option value="<{$key}>" <{if $param.buss_type == $key}> selected='selected'<{/if}>><{$bussLine}></option>
			<{/foreach}>
			</select>
		</div>
		<div style="float:left;margin-right:5px">
			<label> 投诉状态</label>
			<select name="complaint_status"><option value="0">全部</option>
				<option value="有效" <{if $param.complaint_status == '有效'}> selected='selected'<{/if}>>有效</option>
				<option value="无效" <{if $param.complaint_status == '无效'}> selected='selected'<{/if}>>无效</option>
			</select>
		</div>
		<div style="float:left;margin-right:5px">
			<label> 申诉状态</label>
			<select name="appeal_status"><option value="0">全部</option>
				<option value="申诉成功" <{if $param.appeal_status == '申诉成功'}> selected='selected'<{/if}>>申诉成功</option>
				<option value="申诉失败" <{if $param.appeal_status == '申诉失败'}> selected='selected'<{/if}>>申诉失败</option>
			</select>
		</div>
		<div style="float:left;margin-right:5px">
			<label> 统计月份 </label>
			<input type="text" id="month" name="month" value="<{$_GET.month}>" placeholder="起始时间" >
		</div>
		<!-- <div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px"> -->

		<div style="float:left;margin-right:5px">
		<label><br></label>

		<button type="submit" class="btn btn-primary"><strong>检索</strong></button>
			
		</div>
		<!-- </div> -->
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
					<th style="width:30px">#</th>
					<th style="width:50px">省市</th>
					<th style="width:50px">合作伙伴代码</th>
					<th style="width:50px">公司名称</th>
					<th style="width:50px">业务类型</th>
					<th style="width:50px">业务名称</th>
					<th style="width:50px">投诉类型名称</th>
					<th style="width:55px">统计月份</th>
					<th style="width:55px">不规范定制投诉量</th>
					<th style="width:35px">投诉号码</th>

					<th style="width:30px">投诉内容</th>
					<th style="width:30px">申诉内容</th>
					<th style="width:30px">投诉状态</th>
					<th style="width:30px">申诉状态</th>
					<!-- <th style="width:30px">扣款金额</th> -->
					<th style="width:30px">业务线</th>
                </tr>
              </thead>
              <tbody>							  
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$result.id}></td>
					<td><{$data.province[$result.province_id]['name']}></td>
					<td><{$result.part_code}></td>
					<td><{$result.part_name}></td>
					<td><{$data.bussLine[$result.buss_type]}></td>
					<td><{$result.buss_name}></td>
					<td><{$result.complaint_type}></td>
					<!-- <td><{if $result.order_time }><{$result.order_time|date_format:'%Y-%m'}><{/if}></td> -->
					<td><{$result.month|date_format:'%Y-%m'}></td>
					<td><{$result.complaint_total}></td>
					<td><{$result.complaint_phone}></td>

					<td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.complaint_content}>" title="" data-original-title1="投诉内容">详情</a></td>
					<td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.appeal_content}>" title="" data-original-title1="投诉内容">详情</a></td>
					<td><{$result.complaint_status}></td>
					<td><{$result.appeal_status}></td>
					<!-- <td></td> -->
					<td><{$result.buss_line}></td>
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

$( "#month" ).datetimepicker({format: 'yyyy-mm',startView: 3,minView: 3,viewSelect:'year'});

$(function(){
	$('[name="complaint_type"]').change(function(msg){
		$('.question_type').html($('.question'+$(this).val()).html());
	});
})
</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>