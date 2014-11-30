<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div style="border:0px;padding-bottom:5px;height:auto">
	<form action="" method="GET" style="margin-bottom:0px">
	
		<input type="hidden" name="method" value="addUnicomBusinessSp"/>
		<div style="float:left;margin-right:5px">
			<label> SP公司名称</label>
			<input type="text" name="company_name" value="" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> SP公司代码</label>
			<input type="text" name="sp_company_code" value="" placeholder="SP公司代码" > 
		</div>
		<div style="float:left;margin-right:5px">
			<label> sp接入代码</label>
			<input type="text" name="sp_access_number" value="" placeholder="sp接入代码" > 
		</div>
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">

		<button type="submit" class="btn btn-primary"><strong>添加</strong></button>
			
		</div>
		<div style="clear:both;"></div>
	</div>
	</form>
</div>
<div style="border:0px;padding-bottom:5px;height:auto">

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
		<label> sp接入代码</label>
			<input type="text" name="sp_access_number" value="<{$_GET.sp_access_number}>" placeholder="sp接入代码" > 
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
					<th style="width:50px">公司名称</th>
					<th style="width:50px">sp公司代码</th>
					<th style="width:30px">sp接入号码</th>
					<th style="width:30px">操作</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$result.company_name}></td>
					<td><{$result.sp_company_code}></td>
					<td><{$result.sp_access_number}></td>
					<td>
					<a data-toggle="modal" href="#myModal"  title= "删除" ><i class="icon-remove" href="unicom_business_sp_list.php?method=del&id=<{$result.id}>#myModal" data-toggle="modal" ></i></a>
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
<{$osadmin_action_confirm}>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>