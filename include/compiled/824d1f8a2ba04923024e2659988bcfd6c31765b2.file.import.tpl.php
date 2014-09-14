<?php /* Smarty version Smarty-3.1.15, created on 2014-09-13 23:04:30
         compiled from "D:\wjy\an\include\template\complaint\import.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2696054143944418bd6-74112870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '824d1f8a2ba04923024e2659988bcfd6c31765b2' => 
    array (
      0 => 'D:\\wjy\\an\\include\\template\\complaint\\import.tpl',
      1 => 1410620667,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2696054143944418bd6-74112870',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5414394441a379_42713203',
  'variables' => 
  array (
    'error' => 0,
    'module' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5414394441a379_42713203')) {function content_5414394441a379_42713203($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">数据导入</a>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国各省客户投诉工单</h4>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="base">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<?php if ($_smarty_tpl->tpl_vars['error']->value['base']) {?>
		<pre>
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['error']->value['base']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->_loop = true;
?>
				<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
<br>
			<?php } ?>
		</pre>
		<?php }?>
	</div>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国31省不规范定制表</h4>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="custom">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<?php if ($_smarty_tpl->tpl_vars['error']->value['custom']) {?>
		<pre>
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['error']->value['custom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->_loop = true;
?>
				<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
<br>
			<?php } ?>
		</pre>
		<?php }?>
	</div>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国31省工信部投诉表</h4>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="complaints">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<?php if ($_smarty_tpl->tpl_vars['error']->value['complaints']) {?>
		<pre>
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['error']->value['complaints']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->_loop = true;
?>
				<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
<br>
			<?php } ?>
		</pre>
		<?php }?>
	</div>

	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<h4>每月全国31省联通在信业务收入</h4>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				<input type="hidden" name="table" value="income">
				 
				<span class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</span>
		</form>
		<?php if ($_smarty_tpl->tpl_vars['error']->value['income']) {?>
		<pre>
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['error']->value['income']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->_loop = true;
?>
				<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
<br>
			<?php } ?>
		</pre>
		<?php }?>
	</div>
</div>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
