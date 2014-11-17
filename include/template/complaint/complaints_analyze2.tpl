<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<div style="border:0px;padding-bottom:5px;height:auto">
<ul class="nav nav-tabs">
  <li>
    <a href="/complaint/complaints_analyze.php">综合分析</a>
  </li>
  <li class="active"><a href="/complaint/complaints_analyze2.php">图标分析</a></li>
</ul>
	<form action="" method="GET" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">

			<label> 选择省份 </label>
			<select name="province_id"><option value="0">全部</option>
			<{foreach name=province from=$data.province item=province}>
				<option value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
			<{/foreach}>
			</select>
			<!-- <{$data.province}> -->
		</div>
		<div style="float:left;margin-right:5px">
			<label> 统计时间 </label>
			<input type="text" id="start_date" name="start_date" value="<{$_GET.start_date}>" placeholder="统计时间" >
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务名称</label>
			<input type="text" name="buss_name" value="<{$_GET.buss_name}>" placeholder="具体业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 案件编号</label>
			<input type="text" name="case_id" value="<{$_GET.case_id}>" placeholder="案件编号" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 投诉号码</label>
			<input type="text" name="dispute_phone" value="<{$_GET.dispute_phone}>" placeholder="投诉号码" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="sp_name" value="<{$_GET.sp_name}>" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务线</label>
			<select name="buss_type"><option value="0">全部</option>
			<{foreach name=bussLine from=$data.bussLine item=bussLine key=key}>
				<option value="<{$key}>" <{if $param.buss_type == $key}> selected='selected'<{/if}>><{$bussLine}></option>
			<{/foreach}>
			</select>
			<!-- <{$data.bussLine}> -->
		</div>
		
		<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">

		<div>
		<button type="submit" class="btn btn-primary"><strong>检索</strong></button>
			
		</div>
		</div>
		<div style="clear:both;"></div>
	</div>
	</form>
</div>
<div class="hide">
<div class="question1">
			<{$data.questionType.1}>	
</div>
<div class="question2">
			<{$data.questionType.2}>	
</div>
<div class="question3">
			<{$data.questionType.3}>	
</div>
</div>

<div class="block">
		<a style="float:right;padding:10px;" href="<{$export_excel}>" target="" >导出excel</a>
        <a href="#page-stats" class="block-heading" data-toggle="collapse">操作记录</a>
        <div id="page-stats" class="block-body collapse in" style="width:97%">
$province_id = $user_info['province_id']?$user_info['province_id']:$province_id;
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:50px">业务分类</th>
					<!-- <th style="width:50px">省市</th> -->
					<th style="width:50px">统计月份</th>
					<!-- <th style="width:55px">工单时间</th> -->
					<!-- <th style="width:35px">投诉号码</th> -->
					<!-- <th style="width:55px">具体业务名称</th> -->
					<th style="width:30px">月工信部投诉量</th>
					<th style="width:30px">环比增长量</th>
					<th style="width:30px">环比增长率</th>
			<!-- 		<th style="width:30px">申诉成功</th>
					<th style="width:30px">申诉失败</th>
					<th style="width:30px">未申诉量</th> -->
					<th style="width:30px">万投比(千万)</th>
					<!-- <th style="width:30px">sp接入代码</th> -->
					<!-- <th style="width:30px">投诉内容</th> -->
					<!-- <th style="width:30px">处理意见</th> -->

				<!-- 	<th style="width:30px">投诉问题分类</th>
					<th style="width:30px">投诉分级</th> -->

                </tr>
              </thead>
              <tbody>
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$result.buss_class}></td>
					<!-- <td><{$data.provinceMap[$result.corp_area]}></td> -->
					<td><{$result.month|date_format:'%Y-%m'}></td>
					<!-- <td><{$result.complaint_phone}></td> -->
					<!-- <td><{$result.buss_name}></td> -->
					<td><{$result.num}></td>
					<td><{$result.increase}></td>
					<td><{$result.increasePercent|string_format:"%.2f"}>%</td>
<!-- 					<td><{$result.appealSuc}></td>
					<td><{$result.appealFail}></td>
					<td><{$result.appealNot}></td> -->
					<td><{$result.wan|string_format:"%.2f"}></td>
					</tr>
				<{/foreach}>
				<tr>
					<td>总计</td>
					<!-- <td><{$result.order_time|date_format:'%Y-%m-%d %H:%M:%S'}></td> -->
					<!-- <td><{$result.complaint_phone}></td> -->
					<!-- <td><{$result.buss_name}></td> -->
					<td><{$data.total.month}></td>
					<td><{$data.total.num}></td>
					<td><{$data.total.increase}></td>
					<td><{if ($data.total.num-$data.total.increase)}><{($data.total.increase/($data.total.num-$data.total.increase)*100)|string_format:"%.2f"}><{else}>0.00<{/if}>%</td>

					<!-- <td><{$data.total.cos|string_format:"%.2f"}></td> -->
					<td><{if $data.total.cos}><{($data.total.num/$data.total.cos)|string_format:"%.2f"}><{else}>0.00<{/if}></td>
					</tr>
              </tbody>
            </table>
				<!--- START 分页模板 -->
               <{$page_html}>
			   <!--- END -->
        </div>
    </div>
 <!--    <div>
    	<h3>全网业务申诉量变化趋势分析</h3>
    	<canvas id="line" width="600" height="300"></canvas>
    </div> -->
    <!--
    <div>
    	<h3>全网业务申诉量/业务收入（千万元）</h3>
    	<canvas id="zhuData" width="600" height="300"></canvas>
    </div>
    <div>
    	<h3></h3>
    	<canvas id="pie" width="900" height="400"></canvas>
    </div>
    
    
    -->
    <script src="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/js/esl/esl.js"></script>
    <script src="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/js/codemirror.js"></script>
	<script src="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/js/javascript.js"></script>
	<!-- Fixed navbar -->
    <link href="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/css/codemirror.css" rel="stylesheet">
    <link href="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/css/monokai.css" rel="stylesheet">
   
    <style type="text/css">
        .test-head {padding-left: 20px;margin-top:0;background-color:#eee;}
        .CodeMirror pre{color: #f8f8f2;}
        .sidebar-nav {
            padding: 9px 0;
            margin-bottom: 0;
        }
        .icon-resize-full, .icon-resize-small {
            float: right;
            opacity: .3;
        }
        .span4.ani {
            transition: width 1s;
            -moz-transition: width 1s; /* Firefox 4 */
            -webkit-transition: width 1s; /* Safari and Chrome */
            -o-transition: width 1s; /* Opera */
        }
        .span12.ani {
            transition: width 1s;
            -moz-transition: width 1s; /* Firefox 4 */
            -webkit-transition: width 1s; /* Safari and Chrome */
            -o-transition: width 1s; /* Opera */
        }
        .main {
            height: 400px;
            overflow: hidden;
            padding : 10px;
            margin-bottom: 10px;
            border: 1px solid #e3e3e3;
            -webkit-border-radius: 4px;
               -moz-border-radius: 4px;
                    border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
               -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
                    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        }

    </style>

    
    <div class="container-fluid" idx='0'  style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize" ></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: '全网业务申诉量/业务收入（千万元）',
        //subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['申诉量/业务收入']
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data : [<{$data.zhuString}>]
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'申诉量/业务收入',
            type:'bar',
            data:[<{$data.zhuData}>],
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name: '平均值'}
                ]
            }
        }
    ]
};
                    </textarea>
              </div><!--/.well -->
            </div><!--/span-->
            <div md="graphic" class="span12" style="margin: 0;">
                <div md="main" class="main"></div>
                <div>
                    <button class="btn btn-sm btn-success" onclick="refresh(true,0)" type="button">刷 新</button>
                    <span md='wrong-message' style="color:red"></span>
                </div>
            </div><!--/span-->
        </div><!--/row-->
    </div><!--/.fluid-container-->
    <!--------1:bar--------->
    <div class="container-fluid" idx="1" style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize"></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: '',
        //subtext: '纯属虚构',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient : 'vertical',
        x : 'left',
        data:[<{$data.zhuString}>]
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    series : [
        {
            name:'',
            type:'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:<{$data.pie}>
            	 
        }
    ]
};
                    </textarea>
              </div><!--/.well -->
            </div><!--/span-->
            <div md="graphic" class="span12" style="margin: 0;">
                <div md="main" class="main"></div>
                <div>
                	<button class="btn btn-sm btn-success" onclick="refresh(true,1)" type="button">刷 新</button>
                    <span md='wrong-message' style="color:red"></span>
                </div>
            </div><!--/span-->
        </div><!--/row-->
    </div><!--/.fluid-container-->
    
    
    <script src="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/js/all.js"></script>
        
<script>
$(function() {

	// var lineData = {
	// 	labels : ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
	// 	datasets : [
			// {
			// 	fillColor : "rgba(255,255,255,0.5)",
			// 	// fillColor : "rgba(220,220,220,0.5)",
			// 	strokeColor : "rgba(220,220,220,1)",
			// 	pointColor : "rgba(220,220,220,1)",
			// 	pointStrokeColor : "#fff",
			// 	data : [65,59,90,81,56,55,40]
			// },
			// {
			// 	fillColor : "rgba(151,187,205,0.5)",
			// 	strokeColor : "rgba(151,187,205,1)",
			// 	pointColor : "rgba(151,187,205,1)",
			// 	pointStrokeColor : "#fff",
			// 	data : [28,48,40,19,96,27,100]
			// }
	// 		<{$lineData}>
	// 	]
	// }
	// var ctx = document.getElementById("line").getContext("2d");
	// new Chart(ctx).Line(lineData);

	// var zhuData = {
	// 	labels : [<{$data.zhuString}>],
	// 	datasets : [
	// 		{
	// 			fillColor : "rgba(151,187,205,0.5)",
	// 			strokeColor : "rgba(151,187,205,1)",
	// 			pointColor : "rgba(151,187,205,1)",
	// 			pointStrokeColor : "#fff",
	// 			data : [<{$data.zhuData}>]
	// 		}
	// 	]
	// }

	// var ctx = document.getElementById("zhuData").getContext("2d");
	// new Chart(ctx).Bar(zhuData);

	// var zhuData = {
	// 	labels : [<{$data.zhuString}>],
	// 	datasets : [
	// 		{
	// 			fillColor : "rgba(151,187,205,0.5)",
	// 			strokeColor : "rgba(151,187,205,1)",
	// 			pointColor : "rgba(151,187,205,1)",
	// 			pointStrokeColor : "#fff",
	// 			data : [<{$data.zhuData}>]
	// 		}
	// 	]
	// }

	// var ctx = document.getElementById("province").getContext("2d");
	// new Chart(ctx).Bar(zhuData);

	// var complaintsData = {
	// 	labels : [<{$data.provinceString}>],
	// 	datasets : [
	// 		{
	// 			fillColor : "rgba(151,187,205,0.5)",
	// 			strokeColor : "rgba(151,187,205,1)",
	// 			pointColor : "rgba(151,187,205,1)",
	// 			pointStrokeColor : "#fff",
	// 			data : [<{$data.complaints}>]
	// 		}
	// 	]
	// }

	// var ctx = document.getElementById("complaints").getContext("2d");
	// new Chart(ctx).Bar(complaintsData);


	// var pieData = {
	// 	labels : [<{$data.zhuString}>],
	// 	datasets : <{$data.pie}>
	// }
	// var pieData = <{$data.pie}>;

	// var ctx = document.getElementById("pie").getContext("2d");
	// new Chart(ctx).Pie(pieData,{segmentStrokeColor:"#F38630"});




	var date=$( "#start_date" );
	date.datetimepicker({format: 'yyyy-mm',startView: 3,minView: 3,viewSelect:'year'});
	// date.datepicker( "option", "firstDay", 1 );
});


$(function(){
	$('[name="complaint_type"]').change(function(msg){
		$('.question_type').html($('.question'+$(this).val()).html());
	});
})
</script>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>
