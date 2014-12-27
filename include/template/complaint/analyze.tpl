<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<div style="border:0px;padding-bottom:5px;height:auto">
<ul class="nav nav-tabs">
  <li class="active">
    <a href="/complaint/analyze.php">全国发展趋势及各省分布情况</a>
  </li>
  <li><a href="/complaint/analyze2.php">全国各省万投比</a></li>
</ul>
	<form action="" method="GET" style="margin-bottom:0px">
		<div style="float:left;margin-right:5px">

			<label> 选择省份 </label>
			<select name="province_id"><option value="0">全部</option>
            <{if $user_province_id > 0 }>
                <option value="<{$user_province_id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$data.province.$user_province_id.name}></option>

            <{else}>
            <{if $user_province_id > 0 }>
                <option value="<{$user_province_id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$data.province.$user_province_id.name}></option>

            <{else}>
			<{foreach name=province from=$data.province item=province}>
				<option value="<{$province.id}>" <{if $param.province_id == $province.id}> selected='selected'<{/if}>><{$province.name}></option>
			<{/foreach}>
            <{/if}>
            <{/if}>
			</select>
			<!-- <{$data.province}> -->
		</div>
		<div style="float:left;margin-right:5px">
			<label> 统计时间 </label>
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
<!-- 		<div style="float:left;margin-right:5px">
		<label> 业务线</label>
			<select name="buss_type"><option value="0">全部</option>
			<{foreach name=bussLine from=$data.bussLine item=bussLine key=key}>
				<option value="<{$key}>" <{if $param.buss_type == $key}> selected='selected'<{/if}>><{$bussLine}></option>
			<{/foreach}>
			</select>
		</div>
 -->
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
					<th>省市</th>
					<!-- <th style="width:55px">工单时间</th> -->
					<!-- <th style="width:35px">投诉号码</th> -->
					<!-- <th style="width:55px">具体业务名称</th> -->
					<th>统计月份</th>
					<th >月投诉件数</th>
					<th >环比增长量</th>
					<th >环比增长率</th>

					<th >业务收入(万元)</th>
					<th >万投比</th>
					<!-- <th style="width:30px">sp接入代码</th> -->
					<!-- <th style="width:30px">投诉内容</th> -->
					<!-- <th style="width:30px">处理意见</th> -->

                </tr>
              </thead>
              <tbody>
                <{foreach name=result from=$data.result item=result}>
					<tr>
					<td><{$data.provinceMap[$result.province_id]}></td>
					<!-- <td><{$result.order_time|date_format:'%Y-%m-%d %H:%M:%S'}></td> -->
					<!-- <td><{$result.complaint_phone}></td> -->
					<!-- <td><{$result.buss_name}></td> -->
					<td><{$result.month|date_format:'%Y-%m'}></td>
					<td><{$result.num}></td>
					<td><{if $result.increase}><{$result.increase}><{else}>--<{/if}></td>

					<td><{$result.increasePercent}></td>

					<td><{$result.cos|string_format:"%.2f"}></td>
					<td><{$result.wan|string_format:"%.2f"}></td>

					<!-- <td><{$result.sp_code}></td> -->
					<!-- <td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.complaint_content}>" title="" data-original-title1="投诉内容">详情</a></td> -->
					<!-- <td><a href="#" class="detail" data-toggle="popover" data-placement="top" data-original-title="<{$result.suggestion}>" title="" data-original-title1="">详情</a></td> -->

					<!-- <td><{$result.problem_type}></td>
					<td><{$result.complaint_level}></td> -->


					<!-- <td style = "word-break: break-all; word-wrap:break-word;"><{$result.result}></td> -->
					<!-- <td><{$result.op_time}></td> -->
					</tr>
				<{/foreach}>
					<tr>
					<td>总计</td>
					<!-- <td><{$result.order_time|date_format:'%Y-%m-%d %H:%M:%S'}></td> -->
					<!-- <td><{$result.complaint_phone}></td> -->
					<!-- <td><{$result.buss_name}></td> -->
					<td><{$data.total.month}></td>
					<td><{$data.total.num}></td>
					<td><{if $data.total.increase}><{$data.total.increase}><{else}>--<{/if}></td>
					<td><{if ($data.total.num-$data.total.increase)}><{($data.total.increase/($data.total.num-$data.total.increase)*100)|string_format:"%.2f"}><{else}>--<{/if}>%</td>

					<td><{$data.total.cos|string_format:"%.2f"}></td>
					<td><{if $data.total.cos}><{($data.total.num/$data.total.cos)|string_format:"%.2f"}><{else}>0.00<{/if}></td>
					</tr>
              </tbody>
            </table>
				<!--- START 分页模板 -->
               <!-- <{$page_html}> -->
			   <!--- END -->
        </div>
                <{else}>
        	<h4>当月无数据！</h4>
        <{/if}>
    </div>
    <!--
    
    <div>
    	<h3>全年短彩信业务发展趋势图</h3>
    	<canvas id="month" width="600" height="300"></canvas>
    </div>
    <div>
    	<h3>全网联通短彩信业务重点省份投诉量</h3>
    	<canvas id="province" width="900" height="400"></canvas>
    </div>
        <div>
    	<h3>最近两月投诉量与收入比</h3>
    	<canvas id="baseTwoMonthWan" width="300" height="200"></canvas>
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

    <{if $user_province_id == 0}>
    
    <div class="container-fluid" idx='0' style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize" ></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: '全年短彩信业务发展趋势图',
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
            data : ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'投诉量',
            type:'bar',
            data:[<{$data.month}>],
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
    <{/if}>
    <!--------1:bar-->
    <div class="container-fluid" idx="1"  style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize"></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: '全网联通短彩信业务重点省份投诉量',
        //subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['本月投诉量']
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
            data : [<{$data.provinceString}>],
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
            name:'本月投诉量',
            type:'bar',
            data:[<{$data.provinces}>],
            itemStyle:{
               normal:{label:{show:true}},
               emphasis:{label:{show:true}}
           },
            markLine : {
                data : [
                    {type : 'average', name: '平均值'}
                ]
            }
        },
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
    <!--------2:scatter--------->
    <div class="container-fluid" idx="2"  style="padding:0;">
        <div class="row-fluid">
            <div md="sidebar-code" class="span4" style="display:none;">
                <div class="well sidebar-nav">
                    <div class="nav-header"><a href="#" onclick="autoResize()" class="icon-resize-full" md ="icon-resize" ></a>option</div>
                    <textarea md="code" name="code">
option = {
    title : {
        text: '全年万投比',
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
            data : ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]
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
            data:[<{$data.baseTwoMonthWanVal}>],
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
                    <button class="btn btn-sm btn-success" onclick="refresh(true,2)" type="button">刷 新</button>
                    <span md='wrong-message' style="color:red"></span>
                </div>
            </div><!--/span-->
        </div><!--/row-->
    </div><!--/.fluid-container-->
    <!--------3:k--------->
    
    
    <script src="<{$smarty.const.ADMIN_URL}>/assets/echarts-2.0.4/doc/asset/js/all.js"></script>
         
<script>


		

$(function() {
	/*
	var monthData = {
		labels : ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [<{$data.month}>]
			}
		]
	}

	var ctx = document.getElementById("month").getContext("2d");
	new Chart(ctx).Bar(monthData);

	var provinceData = {
		labels : [<{$data.provinceString}>],
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [<{$data.provinces}>]
			},
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				data : [<{$data.provinces2}>]
			}
		]
	}

	var ctx = document.getElementById("province").getContext("2d");
	new Chart(ctx).Bar(provinceData);

		var baseTwoMonthWan = {
		labels : [<{$data.baseTwoMonthWanString}>],
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [<{$data.baseTwoMonthWanVal}>]
			}
		]
	}

	var ctx = document.getElementById("baseTwoMonthWan").getContext("2d");
	new Chart(ctx).Bar(baseTwoMonthWan);
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