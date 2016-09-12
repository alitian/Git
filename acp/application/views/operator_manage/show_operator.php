<?php $this->load->view('ckad/header') ?>  
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url(); ?>main/site">首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="realtime_data">联盟管理</a>
        </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div id="p" class="easyui-panel" title="联盟-查询条件" style="height:280px;padding:10px;margin: 0;" data-options="collapsible:true">
            <form method="POST" name='form1' id="form1" action="">
                <div class="span10">
                    <div class="row-fluid">
                        <div class="span4">联盟ID(多id用,分割):<br /><input type="text" id='id' name='id' value="" placeholder="联盟ID(多id用,分割)" /></div>
                        <div class="span4">联盟名称:<br />
                            <input type="text" id='name' name='name' value="" placeholder="联盟名称" />
                        </div> 
                        <div class="span3">状态<br />
                            <select id="status" name="status">
                                <option value=""></option>
                                <option value="0">打开</option>
                                <option value="-1">关闭</option>
                            </select>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">排序方法:<br />
                            <select id="bysort" name="bysort">
                                <option value=""></option>
                                <option value="asc">升序</option>
                                <option value="desc">降序</option>
                            </select>
                        </div>
                        <div class="span4">创建时间（start）：<br>
                            <div id="datetimepicker1" class="input-append">
                                <input data-format="yyyy-MM-dd 00:00:00" type="text" placeholder="创建时间（start）" name='c_start_time' id='c_start_time' value="<?= $startTime ?>"></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
                        </div>
                        <div class="span4">创建时间（end）：<br>
                            <div id="datetimepicker2" class="input-append">
                                <input data-format="yyyy-MM-dd 23:59:59" type="text" placeholder="创建时间（end）" name='c_end_time' id='c_end_time' value="<?= $startTime ?>"></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
                        </div> 
                    </div>                 
                    <div class="row-fluid"> 
                        <div class="span4">更新时间（start）：<br>
                            <div id="datetimepicker3" class="input-append">
                                <input data-format="yyyy-MM-dd 00:00:00" type="text" placeholder="更新时间（start）" name='u_start_time' id='u_start_time' value="<?= $startTime ?>"></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
                        </div>
                        <div class="span4">更新时间（end）：<br>
                            <div id="datetimepicker4" class="input-append">
                                <input data-format="yyyy-MM-dd 23:59:59" type="text" placeholder="更新时间（end）" name='u_end_time' id='u_end_time' value="<?= $startTime ?>"></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
                        </div>
                        <div class="span4">自定义排序:<br />
                            <select id="byorder" name="byorder">
                                <option value=""></option>
                                <option value="id">联盟id</option>
                                <option value="weight">weight</option>
                                <option value="pre_weight">pre_weight</option>
                                <option value="cap">cap</option>
                                <option value="sinstall">sinstall</option>
                            </select>
                        </div>                                                   	                    					
                    </div>                    
                </div>
                <div class="span1" style="height:200px;text-align: center;vertical-align:middle;overflow:hidden;padding-top:32px;">                 
                    <button class="btn btn-primary" id="btn_search" name="btn_search">查询</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                </div>               
            </form>
        </div>              	
        <div id="p2" class="easyui-panel" title="联盟-数据图" style="height:auto;padding:10px;margin: 0;" data-options="collapsible:true">
            <div id="container" style="min-width: 310px; height: 650px; margin: 0 auto"></div>           
        </div>
        <div class="box-content" style="overflow:scroll;height:500px;">
            <table id="tt" class="easyui-datagrid" style="margin: 0;" title="查询结果" 
                   url="/operator_manage/ajax_operator_list" title="Load Data" iconCls="icon-save"
                   pageSize=10 pagePosition="both" 
                   rownumbers="true" pagination="true" showFooter="true">
                <thead>
                    <tr>    
                        <th field="work" align="center">操作</th>
                        <th field="status" align="center">状态（status）</th>
                        <th field="id" align="center">联盟ID</th>
                        <th field="name" align="center">联盟名称</th>
                        <th field="url" align="center">联盟对应URL</th>
                        <th field="weight" align="center">权重（weight）</th>
                        <th field="pre_weight" align="center">预权重（pre_weight）</th>
                        <th field="cap" align="center">安装限制（百分比%cap）</th>
                        <th field="sinstall" align="center">安装率（sinstall）</th>
                        <th field="ctime" align="center">创建时间（ctime）</th>
                        <th field="utime" align="center">最后更新时间（update_time）</th>
                    </tr>                   
                </thead>
            </table>            
        </div>
    </div><!--/span-->
</div>
<script src="<?= static_url(); ?>js/highcharts/highcharts.js"></script>
<script src="<?= static_url(); ?>js/highcharts/modules/exporting.js"></script>
<script src="<?= static_url(); ?>js/own/public_highcharts.js"></script>
<link href='<?= static_url(); ?>css/bootstrap-datetimepicker.min.css' rel='stylesheet' />
<link href='<?= static_url(); ?>css/style.css' rel='stylesheet'>
<script src="<?= static_url(); ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?= static_url(); ?>js/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= static_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= static_url(); ?>js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?= static_url(); ?>js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= static_url(); ?>css/bootstrap-switch.min.css">
<script type="text/javascript">
    $(function() {
        $('#datetimepicker1,#datetimepicker2,#datetimepicker3,#datetimepicker4').datetimepicker({
            language: 'zh-CN',
            pickTime: false,
        });

    });    
    $(document).ready(function() {
        $('#btn_search').click(function(e) {
            e.preventDefault();
            form1.action = "/operator_manage/ajax_operator_list";
            $('#tt').datagrid('load', {
                id: $("#id").val(),
                name: $("#name").val(),
                status: $("#status").val(),
                c_start_time: $("#c_start_time").val(),
                c_end_time: $("#c_end_time").val(),
                u_start_time:$("#u_start_time").val(),
                u_end_time:$("#u_end_time").val(),
                bysort:$("#bysort").val(),
                byorder:$("#byorder").val(),
            });
        }); 
        $("#tt").datagrid({
            onLoadSuccess:function(data){
                var options = get_highcharts();
                var chart_canvas = $('#container');
                var categories = [];
                var obj = data.rows;
                options.chart.type = 'bar';
                options.title.text = '联盟数据走势';
                options.subtitle.text = 'source: provider trend';
                var data0 = [];
                var data1 = [];
                var data2 =[];
                var data3 = [];
                for(var i=0;i<(obj.length);i++){
                    categories.push(obj[i].name);
                    data0.push(parseInt(obj[i].weight,10));
                    data1.push(parseInt(obj[i].pre_weight,10));
                    data2.push(parseInt(obj[i].cap,10));
                    data3.push(parseInt(obj[i].sinstall,10));
                }
                options.xAxis.categories = categories;
                options.yAxis.title.text = 'provider：weight;pre_weight;cap;sinstall';
                options.series[0]={};
                options.series[0].name = 'weight';
                options.series[0].data = data0;
                
                options.series[1]={};
                options.series[1].name = 'pre_weight';
                options.series[1].data = data1;
                
                options.series[2]={};
                options.series[2].name = 'cap';
                options.series[2].data = data2;
                
                options.series[3]={};
                options.series[3].name = 'sinstall';
                options.series[3].data = data3;
                var chart = new Highcharts.Chart(options);
            },
        });
    });
</script>
<?php
$this->load->view('ckad/footer')?>