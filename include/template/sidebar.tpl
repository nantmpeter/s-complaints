<{if $sidebarStatus=='yes' }>
<div id="sidebar-nav" class="sidebar-nav" style="background: url('../assets/images/leftbg.png') repeat scroll 0 0 rgba(0, 0, 0, 0);">
<{else}>
<div id="sidebar-nav" class="sidebar-nav-hide" >
<{/if}>
		<{foreach from=$sidebar item=module}>
			<{if count($module.menu_list)> 0}>
				<{if $module.module_id == 3}>
				<style>
				
				.top_ul{margin:0;}
				.top_ul .top_li{list-style:none;background: none repeat scroll 0 0 #30394A;color: #67768B;font-size: 14px;height: 36px;line-height: 36px;padding-top: 0;position: relative;text-indent: 12px;}
    			
    			.top_ul .top_li a{color: #9FAABC;display: block;}
    			.top_ul .top_li a:hover{color:#fff;background:#30394a;}
    			
    			.top_ul .second_ul{margin:0;background: url("../assets/images/line.png") repeat-x scroll 0 bottom rgba(0, 0, 0, 0);font-size: 12px;overflow: hidden;padding-bottom: 6px;  padding: 5px 0;}
    			.top_ul .second_ul .second_li{line-height: 22px;text-indent: 22px;}
    			.top_ul .second_ul .second_li a{color: #9FAABC;display: block;}
    			.top_ul .second_ul .second_li a:hover{color:#fff;background:#30394a;}
    			
    			.top_ul .second_ul .third_ul{margin:0;background: url("../assets/images/line.png") repeat-x scroll 0 bottom rgba(0, 0, 0, 0);font-size: 12px; overflow: hidden;padding-bottom: 6px;  padding: 5px 0;}
    			.top_ul .second_ul .third_ul .third_li{line-height: 22px;text-indent: 22px;list-style: none outside none;}
    			.top_ul .second_ul .third_ul .third_li a{padding:0 0 0 15px;background: url("../assets/images/arrow.png") no-repeat scroll 27px 8px rgba(0, 0, 0, 0);color: #A2ADBF ;display: block;height: 22px;line-height: 22px;overflow: hidden;white-space: nowrap;}
    			.top_ul .second_ul .third_ul .third_li a:hover{ color:#999;background:url(../assets/images/arrow.png) no-repeat 27px 8px #30394a;}
				

				</style>

				<{$menu}>
				<!-- <ul class="top_ul" >
					<li class="top_li" style="border-left: 3px solid #12AEFF;">客诉分析</li>
					<ul class="second_ul" >
						<li class="second_li"><a href="/complaint/import.php">数据导入</a></li>
					</ul>
					<li class="top_li" style="border-left: 3px solid #4DC0B1;">基本信息分析</li>
					<ul class="second_ul">
						<li class="second_li"><a href="/complaint/sp_search.php">全网SP信息查询</a></li>
						<li class="second_li"><a href="/complaint/search.php">客户投诉查询</a></li>
						<li class="second_li">客户投诉分析</li>
						<ul class="third_ul">
							<li class="third_li"><a href="/complaint/analyze.php">全国投诉情况分析</a></li>
							<li class="third_li"><a href="/complaint/sp_analyze.php">sp公司投诉情况分析</a></li>
							
							<li class="third_li"><a href="/complaint/single.php">单产品投诉情况</a></li>
						</ul>
					</ul>
					<li class="top_li" style="border-left:3px solid #f6735f;">不规范定制分析</li>
					<ul  class="second_ul">
						<li class="second_li"><a href="/complaint/custom_search.php">不规范定制查询</a></li>
						<li class="second_li">客户投诉分析</li>
						<ul class="third_ul">
							<li class="third_li"><a href="/complaint/custom_analyze.php">全国投诉情况分析</a></li>
							<li class="third_li"><a href="/complaint/custom_sp_analyze.php">sp公司投诉情况分析</a></li>
							<li class="third_li"><a href="/complaint/custom_single.php">单产品不规范定制情况</a></li>

						</ul>
					</ul>
					<li class="top_li" style="border-left: 3px solid #aa67ae;">工信部投诉分析</li>
					<ul class="second_ul">
						<li class="second_li"><a href="/complaint/complaints_search.php">工信部投诉查询</a></li>
						<li class="second_li"><a href="/complaint/complaints_sp_search.php">全网SP公司投诉查询</a></li>
						<li class="second_li">工信部投诉分析</li>
						<ul class="third_ul">
							<li class="third_li"><a href="/complaint/complaints_analyze.php">全国工信部投诉分析</a></li>
							<li class="third_li"><a href="/complaint/complaints_sp_analyze.php">sp公司工信部投诉分析</a></li>
							<li class="third_li"><a href="/complaint/complaints_single.php">单产品工信部投诉情况</a></li>
						</ul>
					</ul>
					<li class="top_li" style="border-left: 3px solid #e64444;"><a href="/complaint/black_list.php">黑名单</a></li>
					<li class="top_li" style="border-left: 3px solid #4DC0B1;">数据字典</li>
					<ul class="second_ul">
						<li class="second_li"><a href="/complaint/complaints_type_manage.php">投诉类型及问题分类管理</a></li>
						<li class="second_li"><a href="/complaint/complaints_level_manage.php">投诉分级管理</a></li>
						
						<li class="second_li"><a href="/complaint/unicom_business_sp_list.php">全网联通在信业务-sp名单</a></li>
						<li class="second_li"><a href="/complaint/unicom_business_list.php">全网联通在信业务-业务信息</a></li>
							
					</ul>
				</ul> -->
				<{else}>
			<a href="#sidebar_menu_<{$module.module_id}>" class="nav-header collapsed" data-toggle="collapse"><i class="<{$module.module_icon}>"></i><{$module.module_name}> <i class="icon-chevron-up"></i></a>
				<{if $module.module_id == $current_module_id }>
					<ul id="sidebar_menu_<{$module.module_id}>" class="nav nav-list collapse in">
				<{else}>
					<ul id="sidebar_menu_<{$module.module_id}>" class="nav nav-list collapse">
				<{/if}>
				
				<{foreach from=$module.menu_list item=menu_list name=menu_url_list}>
				
				<{if strtolower(substr($menu_list.menu_url,0,7))=='http://'}>
					<li><a target=_blank href="<{$menu_list.menu_url}>"><{$menu_list.menu_name}></a></li>
				<{else}>
					<li><a href="<{$smarty.const.ADMIN_URL}><{$menu_list.menu_url}>"><{$menu_list.menu_name}></a></li>
				<{/if}>
				
				<{/foreach}>
			</ul>
			<{/if}>
			<{/if}>
			
		<{/foreach}>
</div>
	 <!--- 以上为左侧菜单栏 sidebar --->
<{if $sidebarStatus=='yes' }>
<div id="content" class="content">
<{else}>
<div id="content" class="content-fullscreen">
<{/if}>        
        <div class="header">
            <div class="stats">
			<p class="stat"><!--span class="number"></span--></p>
			</div>

            <h1 class="page-title"><{$content_header.menu_name}></h1>
        </div>
        
		<ul class="breadcrumb">
            <li> <{$content_header.module_name}> <span class="divider">/</span></li>
           
			<{if $content_header.father_menu}>
			<li><a href="<{$smarty.const.ADMIN_URL}><{$content_header.father_menu_url}>"> <{$content_header.father_menu_name}> </a> <span class="divider">/</span></li>
			<{/if}>
			
			<li class="active"><{$content_header.menu_name}></li>
			
        </ul>
        <script>
        $(function(){
            var cur_location=window.location;
            
            $('a','.top_ul').each(
                function(){
                	//$(this).parent().removeClass('cur_li');
                	//$(this).css('color','#A2ADBF');
					//alert($(this).attr('href'));
					//alert(cur_location.toString().indexOf($(this).attr('href')));
					var pos=cur_location.toString().indexOf($(this).attr('href'));
					if(pos>-1&&pos<40)
					{
						$(this).parent().css('background-color','#99aa99');
	                	$(this).css('color','#111111');
	                	$(this).mouseenter(function(){$(this).css('color','#ffffff');});
	                	$(this).mouseleave(function(){$(this).css('color','#111111');});
					}
                });
            });
        </script>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="bb-alert alert alert-info" style="display: none;">
			<span>操作成功</span>
		</div>