<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
	<{if $error}>
	<div class="error alert">
		<{$error}>

	</div>
	<{/if}>
	<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">数据导入</a>

	<div id="page-stats" class="block-body collapse in">

		<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<div style="float:left;margin-right:5px">
					<label> 				请选择报表统计时间：		 </label>
					<input type="text" id="start_date" name="start_date" value="<{$_GET.start_date}>" placeholder="统计时间" >
				</div>
				<div>
					<label>选择报表类型：</label>
					<select class="pro_select" name="table" >
						<option>请选择</option>
						<option value="base">每月全国各省客户投诉工单</option>
						<option value="custom">每月全国31省不规范定制表</option>
						<option value="complaints">每月全国31省工信部投诉表</option>
						<option value="income">每月全国31省联通在信业务收入</option>
						<option value="value_income">每月所有增值业务收入</option>
					</select>
				</div>
				<div>
					<label>选择报表地区：</label>
						<select name="province_id">
						<option>请选择</option>
						<option class="pro_all hide" value="0">全国</option>
						<{foreach name=province from=$data.province item=province}>
							<option class='pro_one' value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
						<{/foreach}>
						</select>
				</div>

				<div>
					<!-- <input type="checkbox" name="cover" />数据覆盖导入（该选项会清除导入表格月分的数据）<br> -->
					<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				</div>
				<!-- <input type="checkbox" name="cover" />数据覆盖导入（该选项会清除导入表格月分的数据）<br>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="base">
				  -->
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
	</div>

	<div id="page-stats" class="block-body collapse in">
		<form id="tab" method="get" action="" autocomplete="off">
				<hr />
				<div style="float:left;margin-right:5px">
					<label> 				请选择报表统计时间：		 </label>
					<input type="text" id="start_date_search" name="start_date_search" value="<{$smarty.get.start_date_search}>" placeholder="统计时间" >

				</div>
				<div>
					<label>选择报表类型：</label>
					<select name="table" >
						<option>请选择</option>
						<option value="base"<{if $smarty.get.table=='base'}> selected='selected' <{/if}>>每月全国各省客户投诉工单</option>
						<option value="custom"<{if $smarty.get.table=='custom'}> selected='selected' <{/if}>>每月全国31省不规范定制表</option>
						<option value="complaints"<{if $smarty.get.table=='complaints'}> selected='selected' <{/if}>>每月全国31省工信部投诉表</option>
						<option value="income"<{if $smarty.get.table=='income'}> selected='selected' <{/if}>>每月全国31省联通在信业务收入</option>
						<option value="value_income"<{if $smarty.get.table=='value_income'}> selected='selected' <{/if}>>每月所有增值业务收入</option>
					</select>
				</div>
			<!-- 	<div>
					<label>选择报表地区：</label>
						<select name="province_id"><option value="0">全部</option>
						<{foreach name=province from=$data.province item=province}>
							<option value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
						<{/foreach}>
						</select>
				</div> -->

				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>搜索</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
	</div>
	<div class="block">
		<a style="float:right;padding:10px;" href="<{$export_excel}>" target="" >导出excel</a>
        <a href="#page-stats" class="block-heading" data-toggle="collapse">操作记录</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:50px">统计时间</th>
					<th style="width:50px">报表类型</th>
					<th style="width:50px">省市</th>
					<th style="width:50px">文件名</th>
					<th style="width:50px">操作</th>
				</tr>
			</thead>
                <{foreach name=result from=$data.result item=result}>
			<tr>
			<td><{$result.month|date_format:'%Y-%m'}></td>
			<td><{$name_map[$smarty.get.table]}></td>
			<td><{$data.province[$result.province_id]['name']}></td>
			<td><{$result.name}></td>
			<td><a href="?del=1&start_date_search=<{$smarty.get.start_date_search}>&table=<{$smarty.get.table}>&delpro=<{$result.province_id}>&id=<{$result.id}>" onclick="if(confirm('确定删除?')==false)return false;">删除</a></td>
			</tr>
			<{/foreach}>
			</table>
		</div>
	</div>

	<!-- <div id="page-stats" class="block-body collapse in">
	
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

</div> -->
<script type="text/javascript">
	$(function(){
		var date=$( "#start_date,#start_date_search" );
		date.datetimepicker({format: 'yyyy-mm',startView: 3,minView: 3,viewSelect:'year'});

		$('.pro_select').change(function(){
			if($(this).val() == 'base') {
				$('.pro_one').show();
				$('.pro_all').hide();
			}else{
				$('.pro_one').hide();
				$('.pro_all').show();
			}
			// alert($(this).val());
		});
	})

</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>