<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">投诉分级列表</a>
	<div id="page-stats" class="block-body collapse in" style="width:97%">
$province_id = $user_info['province_id']?$user_info['province_id']:$province_id;
		<table class="table table-striped">
			<thead>
			<tr>
				<th>#</th>
				<th>投诉分级名称</th>
				<th>投诉分类名称</th>
				<th>关键词</th>
				<th width="80px">操作</th>
			</tr>
			</thead>
			<tbody>							  
			<{foreach name=complaints_level from=$complaints_levels item=complaints_level}>
				 
				<tr>
 
				<td><{$complaints_level.id}></td>
				<td>
				<{if $complaints_level.id eq 1|| $complaints_level.id eq 5 ||$complaints_level.id eq 9}>
				<{$complaints_level.complaints_level}>
				<{else}>
				<{/if}>
				
				</td>
				<td><{$complaints_level.complaints_type}></td>
				<td>
				<textarea title="多个关键词请用'|'分隔" name="complaints_level_<{$complaints_level.id}>" id="complaints_level_<{$complaints_level.id}>" rows="2" cols=""><{$complaints_level.keywords}></textarea>
				<!--<input title="多个关键词请用'|'分隔" type="text" name="complaints_level_<{$complaints_level.id}>" id="complaints_level_<{$complaints_level.id}>" value="<{$complaints_level.keywords}>" />
				--></td>
				<td>
				
				<a onclick="updateComplaintsLevelKeywords(<{$complaints_level.id}>)" href="javascript:;" title= "修改" ><i class="icon-pencil"></i></a>
				
				</td>
				</tr>
			<{/foreach}>
		  </tbody>
		</table>  
	</div>
</div>
<script>

	function updateComplaintsLevelKeywords(id)
	{
		$.ajax({
	        type: "POST",
	        url: "complaints_level_manage.php?id=<{$complaints_level.id}>",
	        data: {method:"update",id:id,keywords:$("#complaints_level_"+id).val()},
	
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