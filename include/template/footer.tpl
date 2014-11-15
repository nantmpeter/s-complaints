
	
					<footer>
                        <hr>
                        <{if $isLogin eq 1}>
                        <div align="center">中国联通宽带公司©版权所有</div>
						<{/if}>
                    </footer>
				</div>
			</div>
		</div>
    <script src="<{$smarty.const.ADMIN_URL}>/assets/lib/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
	$(function(){
		$('.detail').tooltip({delay: 400});
	})
	</script>
<!--- + -快捷方式的提示 --->
	
<script type="text/javascript">	
	
alertDismiss("alert-success",3);
alertDismiss("alert-info",10);
	
listenShortCut("icon-plus");
listenShortCut("icon-minus");
doSidebar();
</script>
  </body>
</html>