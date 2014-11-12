<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>
<select name="group_id" onchange="javascript:location.replace('manage.php?group_id='+this.options[this.selectedIndex].value)" style="margin:5px 0px 0px">
	<{html_options options=$group_option_list selected=$group_id}>
</select>
<form method="post" action="">
		<div class="block">
			<a href="#page-stats_<{$role.module_id}>" class="block-heading" data-toggle="collapse">所属省份</a>
			<div>
			<select name="province_id"><option value="0">全部</option>
			<{foreach name=province from=$data.province item=province}>
				<option value="<{$province.id}>" <{if $province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
			<{/foreach}>
			</select>
			</div>
		</div>
<{foreach from=$role_list item=role}>
	<{if count($role.menu_info) >0 }>
		<div class="block">
			<a href="#page-stats_<{$role.module_id}>" class="block-heading" data-toggle="collapse"><{$role.module_name}></a>
			<div id="page-stats_<{$role.module_id}>" class="block-body collapse in">
			<{if $role.module_name == '客诉分析'}>
			<div id="page-stats_3" class="block-body collapse in">
			<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="104" <{if 104|in_array:$group_role}>checked="checked"<{/if}>>数据导入</label><br>
			<!-- <label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="105" <{if 105|in_array:$group_role}>checked="checked"<{/if}>>基本信息分析</label><br> -->
			<h5>基本信息分析</h5>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="107" <{if 107|in_array:$group_role}>checked="checked"<{/if}>>客户投诉查询</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="106" <{if 106|in_array:$group_role}>checked="checked"<{/if}>>全国投诉情况分析</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="119" <{if 119|in_array:$group_role}>checked="checked"<{/if}>>单产品投诉情况</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="118" <{if 118|in_array:$group_role}>checked="checked"<{/if}>>sp公司投诉情况分析</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="121" <{if 121|in_array:$group_role}>checked="checked"<{/if}>>全国各省月投诉量/业务收入</label><br>						
			<h5>不规范定制分析</h5>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="108" <{if 108|in_array:$group_role}>checked="checked"<{/if}>>不规范定制查询</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="109" <{if 109|in_array:$group_role}>checked="checked"<{/if}>>不规范定制分析</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="113" <{if 113|in_array:$group_role}>checked="checked"<{/if}>>单产品不规范定制情况</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="111" <{if 111|in_array:$group_role}>checked="checked"<{/if}>>全国不规范定制件数/各省业务收入</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="112" <{if 112|in_array:$group_role}>checked="checked"<{/if}>>sp公司不规范定制TOP20</label><br>
			<h5>工信部投诉分析</h5>

			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="110" <{if 110|in_array:$group_role}>checked="checked"<{/if}>>工信部投诉查询</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="114" <{if 114|in_array:$group_role}>checked="checked"<{/if}>>全国工信部投诉分析</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="115" <{if 115|in_array:$group_role}>checked="checked"<{/if}>>sp公司工信部投诉分析</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="116" <{if 116|in_array:$group_role}>checked="checked"<{/if}>>图标分析</label><br>
			&nbsp;&nbsp;&nbsp;&nbsp;<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="117" <{if 117|in_array:$group_role}>checked="checked"<{/if}>>单产品工信部投诉情况</label><br>
			
			<label style="display: inline-block;font-size: 12px;width: 180px"><input type="checkbox" name="menu_ids[]" value="120" <{if 120|in_array:$group_role}>checked="checked"<{/if}>>黑名单</label><br>
			</div>
			<{else}>
			<{html_checkboxes name="menu_ids"  options=$role.menu_info checked=$group_role separator="&nbsp;&nbsp;" labels="1"  }>						
			<{/if}>
			</div>
		</div>
	<{/if }>
<{/foreach}>											
	<div>
		<button class="btn btn-primary">更新</button>
	</div>
</form>

<{include file="footer.tpl" }>