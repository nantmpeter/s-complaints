<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<{if $error}>
<div class="error alert">
	<{$error}>
</div>
<{/if}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div style="border:1px solid #CCCCCC;padding-left:10px;padding-bottom:5px;margin-bottom:10px;height:auto">
	<form action="" method="GET" style="margin-bottom:0px">
	
		<input type="hidden" name="method" value="addUnicomBusiness"/>
		<div style="float:left;margin-right:5px">
			<label> SP公司名称</label>
			<input type="text" name="company_name" value="" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> SP公司代码</label>
			<input type="text" name="sp_company_code" value="" placeholder="SP公司代码" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 业务类型</label>
			<input type="text" name="business_type" value="" placeholder="业务类型" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 业务代码</label>
			<input type="text" name="business_code" value="" placeholder="业务代码" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 业务名称</label>
			<input type="text" name="business_name" value="" placeholder="业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 申请时间</label>
			<input type="text" id="apply_time" name="apply_time" value="" placeholder="申请时间" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 业务状态</label>
			<input type="text" name="business_state" value="" placeholder="业务申请状态" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 业务申请状态</label>
			<input type="text" name="business_apply_state" value="" placeholder="业务申请状态" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> 所属区域</label>
			<input type="text" name="area" value="" placeholder="所属区域" > 
		</div>
		
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">

		<button type="submit" class="btn btn-primary"><strong>添加</strong></button>
			
		</div>
		<div style="clear:both;"></div>

	</form>
</div>

<div style="border:1px solid #CCCCCC;padding-left:10px;padding-bottom:5px;margin-bottom:10px;height:auto">
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data" style="margin-bottom:0px;">
		<div>
			<input type="hidden" name="importunicombl" value=1 />
			<div style="float:left;margin-right:5px">
			<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge"/>
			</div>
			<div class="btn-toolbar" style="padding-bottom:0px;margin-bottom:0px">
			<button type="submit" class="btn btn-primary"><strong>提交</strong></button>	
			</div>
		</div>
	</form>	
</div>

<div style="border:1px solid #CCCCCC;padding-left:10px;padding-bottom:5px;height:auto">

	<form action="" method="GET" style="margin-bottom:0px">
		
		
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="company_name" value="<{$_GET.company_name}>" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司代码</label>
				<input type="text" name="sp_company_code" value="<{$_GET.sp_company_code}>" placeholder="SP公司代码" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务代码</label>
			<input type="text" name="business_code" value="<{$_GET.business_code}>" placeholder="业务代码" > 
		</div>
		
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">

		<button type="submit" class="btn btn-primary"><strong>检索</strong></button>
			
		</div>
		<div style="clear:both;"></div>
	</div>
	</form>
</div>


<div class="block">
		<!--<a style="float:right;padding:10px;" href="<{$export_excel}>" target="" >导出excel</a>
        --><a href="#page-stats" class="block-heading" data-toggle="collapse">操作记录</a>
        <div id="page-stats" class="block-body collapse in" style="width:97%">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:50px">sp公司代码</th>
					<th style="width:50px">公司名称</th>
					<th style="width:50px">业务类型</th>
					<th style="width:50px">业务代码</th>
					<th style="width:50px">业务名称</th>
					<th style="width:30px">申请时间</th>
					<th style="width:30px">业务状态</th>
					<th style="width:30px">业务申请状态</th>
					<th style="width:30px">所属区域</th>
					<th style="width:30px">操作</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$result.sp_company_code}></td>
					<td><{$result.company_name}></td>
					<td><{$result.business_type}></td>
					<td><{$result.business_code}></td>
					<td><{$result.business_name}></td>
					<td><{$result.apply_time}></td>
					<td><{$result.business_state}></td>
					<td><{$result.business_apply_state}></td>
					<td><{$result.area}></td>
					<td>
					<a data-toggle="modal" href="#myModal"  title= "删除" ><i class="icon-remove" href="unicom_business_list.php?method=del&id=<{$result.id}>#myModal" data-toggle="modal" ></i></a>
					</td>
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
	var date=$( "#apply_time" );
	date.datetimepicker({format: 'yyyy-mm-dd HH:ii:ss'});
});
</script>
<{$osadmin_action_confirm}>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>