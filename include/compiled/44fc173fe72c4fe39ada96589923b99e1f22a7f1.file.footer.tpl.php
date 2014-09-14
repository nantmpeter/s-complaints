<?php /* Smarty version Smarty-3.1.15, created on 2014-09-13 13:31:50
         compiled from "D:\wjy\an\include\template\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:204805413d6c6744e01-43622742%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '44fc173fe72c4fe39ada96589923b99e1f22a7f1' => 
    array (
      0 => 'D:\\wjy\\an\\include\\template\\footer.tpl',
      1 => 1402405900,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '204805413d6c6744e01-43622742',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5413d6c6752de7_17665899',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5413d6c6752de7_17665899')) {function content_5413d6c6752de7_17665899($_smarty_tpl) {?>                    
	
					<footer>
                        <hr>
                        <p class="pull-right">A <a href="http://osadmin.org/" target="_blank">Basic Backstage Management System for China Only.</a> by <a href="http://weibo.com/osadmin" target="_blank">SomewhereYu</a>. 安卓应用【<a href="http://app.herobig.com" target="_blank">短信卫士</a>】</p>

                        <p>&copy; 2013 <a href="http://osadmin.org" target="_blank">OSAdmin</a></p>
                    </footer>
				</div>
			</div>
		</div>
    <script src="<?php echo @constant('ADMIN_URL');?>
/assets/lib/bootstrap/js/bootstrap.js"></script>
	
<!--- + -快捷方式的提示 --->
	
<script type="text/javascript">	
	
alertDismiss("alert-success",3);
alertDismiss("alert-info",10);
	
listenShortCut("icon-plus");
listenShortCut("icon-minus");
doSidebar();
</script>
  </body>
</html><?php }} ?>
