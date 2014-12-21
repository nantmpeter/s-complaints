<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<div style="border:0px;padding-bottom:5px;height:auto">

	<form action="" method="GET" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">

			<label> 选择省份 </label>
			<select name="province_id"><option value="0">全部</option>
            <{if $user_province_id > 0 }>
                <option value="<{$user_province_id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$data.province.$user_province_id.name}></option>

            <{else}>
			<{foreach name=province from=$data.province item=province}>
				<option value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
			<{/foreach}>
            <{/if}>
			</select>
			<!-- <{$data.province}> -->
		</div>
		<div style="float:left;margin-right:5px">
			<label> 统计月份 </label>
			<input type="text" id="start_date" name="start_date" value="<{$_GET.start_date}>" placeholder="统计月份" >
		</div>
		<div style="float:left;margin-right:5px">
		<label> 具体业务名称</label>
			<input type="text" name="buss_name" value="<{$_GET.buss_name}>" placeholder="具体业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="part_name" value="<{$_GET.part_name}>" placeholder="SP公司名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP企业代码查询</label>
				<input type="text" name="part_code" value="<{$_GET.part_code}>" placeholder="SP企业代码查询" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> 业务类型</label>
			<select name="buss_type"><option value="0">全部</option>
			<{foreach name=bussLine from=$data.bussLine item=bussLine key=key}>
				<option value="<{$key}>" <{if $param.buss_type == $key}> selected='selected'<{/if}>><{$bussLine}></option>
			<{/foreach}>
			</select>
			<!-- <{$data.bussLine}> -->
		</div>

        <div style="float:left;margin-right:5px">
        <label> 万投比</label>
            <select name="wan"><option value="0">全部</option>
                <option value="5" <{if $param.wan == 5}> selected='selected'<{/if}>>5</option>
            </select>
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
        <{if $data.result|@count > 0}>
        <div id="page-stats" class="block-body collapse in" style="width:97%">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:50px">公司名称</th>
					<!-- <th style="width:50px">sp代码</th> -->
					
					<th style="width:30px">sp企业代码</th>
					<th style="width:30px">月不规范定制件数</th>
					<th style="width:30px">环比增长量</th>
					<th style="width:30px">环比增长率</th>
					<th style="width:30px">申诉成功</th>
					<th style="width:30px">申诉失败</th>
					<th style="width:30px">未申诉量</th>
					<th style="width:30px">不规范定制万投比</th>

					<th style="width:30px">投诉类型</th>
					<th style="width:30px">业务类型</th>
					<th style="width:30px">认定有效量</th>
					<th style="width:30px">不规范定制扣款(万元)</th>

                </tr>
              </thead>
              <tbody>
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><a href="/complaint/custom_sp_detail.php?month=<{$result.month}>&sp_corp_code=<{$result.part_code}>"><{$result.part_name}></a></td>
					<td><{$result.part_code}></td>
					<td><{$result.num}></td>
					<td><{if $result.increase}><{$result.increase}><{else}>--<{/if}></td>

					<td><{$result.increasePercent}></td>
					<td><{$result.appealSuc}></td>
					<td><{$result.appealFail}></td>
					<td><{$result.appealNot}></td>
					<td><{$result.wan|string_format:"%.2f"}></td>

					<td><{$result.complaint_type}></td>

					<td><{$data.bussLine[$result.buss_type]}></td>
					<td><{$result.valid}></td>
					<td><{$result.customCost|string_format:"%.2f"}></td>
					</tr>
				<{/foreach}>
              </tbody>
            </table>
				<!--- START 分页模板 -->
               <{$page_html}>
			   <!--- END -->
        </div>
        <{else}>
        	<h4>当月无数据！</h4>
        <{/if}>
    </div>
    <!--

    <div>
    	<h3>sp公司不规范定制TOP20</h3>
    	<canvas id="chart" width="700" height="400"></canvas>
    </div>
	<div>
    	<h3>sp公司不规范定制TOP20(万投比)</h3>
    	<canvas id="wanchart" width="700" height="400"></canvas>
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
        text: 'sp公司不规范定制TOP20',
        //subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['定制']
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
            data : [<{$data.chartName}>],
            axisLabel :{show:true,interval : 0,rotate:30},
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'定制',
            type:'bar',
            data:[<{$data.chartValue}>],
            itemStyle:{
               normal:{label:{show:true}},
               emphasis:{label:{show:true}}
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
    <div class="container-fluid" idx="1"  style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize"></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: 'sp公司不规范定制TOP20(万投比)',
        //subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['万投比']
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
            data : [<{$data.wanName}>]
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'万投比',
            type:'bar',
            data:[<{$data.chartWan}>],
            itemStyle:{
               normal:{label:{show:true}},
               emphasis:{label:{show:true}}
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
                	<button class="btn btn-sm btn-success" onclick="refresh(true,1)" type="button">刷 新</button>
                    <span md='wrong-message' style="color:red"></span>
                </div>
            </div><!--/span-->
        </div><!--/row-->
    </div><!--/.fluid-container-->
    
    
    <script src="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/js/all.js"></script>
         

<script>
$(function() {
/*
	var Data = {
		labels : [<{$data.chartName}>],
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [<{$data.chartValue}>]
			}
		]
	}

	var ctx = document.getElementById("chart").getContext("2d");
	new Chart(ctx).Bar(Data);

	var wanData = {
		labels : [<{$data.wanName}>],
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [<{$data.chartWan}>]
			}
		]
	}

	var ctx = document.getElementById("wanchart").getContext("2d");
	new Chart(ctx).Bar(wanData);
*/
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