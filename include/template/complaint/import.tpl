<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">数据导入</a>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国各省客户投诉工单</h4>
				<input type="checkbox" name="cover" />数据覆盖导入（该选项会清除导入表格月分的数据）<br>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="base">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<{if $error.base }>
		<pre>
			<{foreach from=$error.base item=module}>
				<{$module}><br>
			<{/foreach}>
		</pre>
		<{/if}>
	</div>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国31省不规范定制表</h4>
				<input type="checkbox" name="cover" />数据覆盖导入（该选项会清除导入表格月分的数据）<br>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="custom">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<{if $error.custom }>
		<pre>
			<{foreach from=$error.custom item=module}>
				<{$module}><br>
			<{/foreach}>
		</pre>
		<{/if}>
	</div>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国31省工信部投诉表</h4>
				<input type="checkbox" name="cover" />数据覆盖导入（该选项会清除导入表格月分的数据）<br>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="complaints">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<{if $error.complaints }>
		<pre>
			<{foreach from=$error.complaints item=module}>
				<{$module}><br>
			<{/foreach}>
		</pre>
		<{/if}>
	</div>

	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国31省联通在信业务收入</h4>
				<input type="checkbox" name="cover" />数据覆盖导入（该选项会清除导入表格月分的数据）<br>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="income">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<{if $error.income }>
		<pre>
			<{foreach from=$error.income item=module}>
				<{$module}><br>
			<{/foreach}>
		</pre>
		<{/if}>
	</div>

	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月所有增值业务收入</h4>
				<input type="checkbox" name="cover" />数据覆盖导入（该选项会清除导入表格月分的数据）<br>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="value_income">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<{if $error.value_income }>
		<pre>
			<{foreach from=$error.value_income item=module}>
				<{$module}><br>
			<{/foreach}>
		</pre>
		<{/if}>
	</div>

</div>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>