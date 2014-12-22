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
			<input type="text" name="buss_name_detail" value="<{$_GET.buss_name_detail}>" placeholder="具体业务名称" > 
		</div>
		<div style="float:left;margin-right:5px">
		<label> SP公司名称</label>
				<input type="text" name="sp_name" value="<{$_GET.sp_name}>" placeholder="SP公司名称" > 
		</div>
        <div style="float:left;margin-right:5px">
        <label> SP企业代码</label>
                <input type="text" name="sp_corp_code" value="<{$_GET.sp_corp_code}>" placeholder="SP企业代码" > 
        </div>

        <div style="float:left;margin-right:5px">
        <label> 业务类型</label>
            <select name="buss_name"><option value="0">全部</option>
            <{foreach name=bussLine from=$data.bussLine item=bussLine key=key}>
                <option value="<{$bussLine}>" <{if $param.buss_name == $bussLine}> selected='selected'<{/if}>><{$bussLine}></option>
            <{/foreach}>
            </select>
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
       				<{if $smarty.get.province_id}>
					<th style="width:80px">省</th>
					<{/if}>
					<th style="width:50px">公司名称</th>
					<th style="width:50px">sp企业代码</th>
					<th style="width:50px">sp接入号码</th>
					<th style="width:50px">统计月份</th>
					<!-- <th style="width:55px">工单时间</th> -->
					<!-- <th style="width:35px">投诉号码</th> -->
					<!-- <th style="width:55px">具体业务名称</th> -->
					<th style="width:30px">月投诉件数</th>
					<th style="width:30px">环比增长量</th>
					<th style="width:30px">环比增长率</th>
					<th style="width:30px">全国投诉占比</th>
					<th style="width:30px">sp应收(万元)</th>

					<th style="width:30px">sp万投比</th>
					<!-- <th style="width:30px">sp接入代码</th> -->
					<!-- <th style="width:30px">投诉内容</th> -->
					<!-- <th style="width:30px">处理意见</th> -->

				<!-- 	<th style="width:30px">投诉问题分类</th>
					<th style="width:30px">投诉分级</th> -->
					<!-- <th style="width:30px">业务线</th> -->

                </tr>
              </thead>
              <tbody>
                <{foreach name=result from=$data.result item=result}>
					<tr>
       				<{if $smarty.get.province_id}>
					<td><{$data.province[$result.province_id]['name']}></td>
					<{/if}>
					<td><a href="/complaint/sp_analyze_detail.php?sp_corp_code=<{$result.sp_corp_code}>&month=<{$result.month}>" ><{$result.sp_name}></a></td>
					<td><{$result.sp_corp_code}></td>
					<td><{$result.sp_code}></td>
					<td><{$result.month|date_format:'%Y-%m'}></td>
					<!-- <td><{$result.order_time|date_format:'%Y-%m-%d %H:%M:%S'}></td> -->
					<!-- <td><{$result.complaint_phone}></td> -->
					<!-- <td><{$result.buss_name}></td> -->
					<td><{$result.num}></td>
					<td><{if $result.increase}><{$result.increase}><{else}>--<{/if}></td>

					<td><{$result.increasePercent}></td>
					<td><{if $data.total}><{($result.num/$data.total * 100)|string_format:'%.2f'}><{else}>0<{/if}>%</td>
					<td><{$result.cos|string_format:'%.2f'}></td>

					<td><{$result.wan|string_format:'%.2f'}></td>

					<!-- <td><{$result.sp_code}></td> -->
					<!-- <td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.complaint_content}>" title="" data-original-title1="投诉内容">详情</a></td> -->
					<!-- <td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.suggestion}>" title="" data-original-title1="">详情</a></td> -->

					<!-- <td><{$result.problem_type}></td>
					<td><{$result.complaint_level}></td> -->
					<!-- <td><{$data.bussLine[$result.buss_type]}></td> -->

					<!-- <td style = "word-break: break-all; word-wrap:break-word;"><{$result.result}></td> -->
					<!-- <td><{$result.op_time}></td> -->
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
    <{if $data.result}>
    <!--
    <div>
    	<h3>sp公司投诉情况TOP20</h3>
    	<canvas id="chart" width="700" height="400"></canvas>
    </div>
	<div>
    	<h3>sp公司投诉情况TOP20(万投比)</h3>
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

    <{if $smarty.get.page_no < 2}>
    <div class="container-fluid" idx='0' style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize" ></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: 'sp公司投诉情况TOP20',
        //subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['投诉量']
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
            axisLabel :{show:true,interval : 0,rotate:20,margin:0,textStyle:{fontSize:1}},
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    grid:{y2:'30%',x:'15%'},
    series : [
        {
            name:'投诉量',
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
    <!--------1:bar-->
    <div class="container-fluid" idx="1" style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize"></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: 'sp公司投诉情况TOP20(万投比)',
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
            data : [<{$data.wanString}>],
            axisLabel :{show:true,interval : 0,rotate:20,margin:0,textStyle:{fontSize:1}},
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    grid:{y2:'30%',x:'15%'},

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
    <{/if}>
    
    <script src="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/js/all.js"></script>
         
    <{/if}>
<script>
$(function() {
	/*
    // <{if $data.result}>

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
		labels : [<{$data.wanString}>],
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
    // <{/if}>
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