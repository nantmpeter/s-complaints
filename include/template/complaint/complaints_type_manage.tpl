<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->


<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">投诉类型及问题分类管理列表</a>
	<div id="page-stats" class="block-body collapse in" style="width:97%">
		<table class="table table-striped">
			<thead>
			<tr>
				<th>#</th>
				<th>投诉类型</th>
				<th>投诉问题分类</th>
				<th>关键词</th>
				<th width="80px">操作</th>
			</tr>
			</thead>
			<tbody>							  
			<{foreach name=complaints_type from=$complaints_types item=complaints_type}>
				 
				<tr>
 
				<td><{$complaints_type.id}></td>
				<td>
				<{if $complaints_type.id eq 1|| $complaints_type.id eq 5 ||$complaints_type.id eq 11}>
				<{$complaints_type.complaints_type}>
				<{else}>
				<{/if}>
				</td>
				<td><{$complaints_type.complaints_problem_type}></td>
				<td>
				<textarea title="多个关键词请用'|'分隔" name="complaints_type_<{$complaints_type.id}>" id="complaints_type_<{$complaints_type.id}>" rows="2" cols=""><{$complaints_type.keywords}></textarea>
				
				<!--<input title="多个关键词请用'|'分隔" type="text" name="complaints_type_<{$complaints_type.id}>" id="complaints_type_<{$complaints_type.id}>" value="<{$complaints_type.keywords}>" />
				--></td>
				<td>
				
				<a onclick="updateComplaintsTypeKeywords(<{$complaints_type.id}>)" href="javascript:;" title= "修改" ><i class="icon-pencil"></i></a>
				
				</td>
				</tr>
			<{/foreach}>
		  </tbody>
		</table>  
	</div>
</div>
<script>

	function updateComplaintsTypeKeywords(id)
	{
		$.ajax({
	        type: "POST",
	        url: "complaints_type_manage.php?id=<{$complaints_type.id}>",
	        data: {method:"update",id:id,keywords:$("#complaints_type_"+id).val()},
	
	        success: function(data){
	            if(data==1)
	            {
	                alert("修改成功");
	            }
	            else
	            {
	                alert("修改失败");
	            }
	        }
		});
	}

</script>

<!---操作的确认层，相当于javascript:confirm函数--->
<{$osadmin_action_confirm}>
	
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>