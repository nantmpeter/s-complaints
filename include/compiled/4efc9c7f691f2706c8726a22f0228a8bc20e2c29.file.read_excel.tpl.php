<?php /* Smarty version Smarty-3.1.15, created on 2014-09-13 13:40:35
         compiled from "D:\wjy\an\include\template\sample\read_excel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:269155413d8d358b834-74063336%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4efc9c7f691f2706c8726a22f0228a8bc20e2c29' => 
    array (
      0 => 'D:\\wjy\\an\\include\\template\\sample\\read_excel.tpl',
      1 => 1387527376,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '269155413d8d358b834-74063336',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5413d8d35c3da9_45391404',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5413d8d35c3da9_45391404')) {function content_5413d8d35c3da9_45391404($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">读取Excel.xls</a>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<label>只限于xls文件</label>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				 
				<div class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</div>
		</form>
		<pre>
		读取Excel.xls文件输出结果
		<?php echo $_smarty_tpl->tpl_vars['output']->value;?>

		</pre>
	</div>
</div>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
