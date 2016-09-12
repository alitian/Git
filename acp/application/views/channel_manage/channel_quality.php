<?php $this->load->view('ckad/header') ?>  
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url(); ?>main/site">首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="channel_quality">渠道质量</a>
        </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div id="p" class="easyui-panel" title="渠道质量-查询条件" style="height:280px;padding:10px;margin: 0;" data-options="collapsible:true">
            <form method="POST" name='form1' id="form1" action="">
                <div class="span10">
                    <div class="span3">展示选择<br />
                        <select id="status" name="status" onchange='show_select();'>
                            <option value=""></option>
                            <option value="1">按渠道（同一渠道；不同时间）</option>
                            <option value="2">按日期（同一时间内；不同渠道）</option>
                        </select>
                    </div>
                </div> 
                <div id="select_1" style="display:none">
                    <div class="span10">
                        <div class="row-fluid">
                            <div class="span4">渠道名称（channel_name） :<br />
                                <input type="text" id='name1' name='name1' value="" placeholder="渠道名称" />
                            </div> 
                            <div class="span4">排序方法:<br />
                                <select id="bysort1" name="bysort1">
                                    <option value=""></option>
                                    <option value="asc">升序</option>
                                    <option value="desc">降序</option>
                                </select>
                            </div>
                        </div>
                        <div class="row-fluid">                          
                            <div class="span4">筛选时间（start）：<br>
                                <div id="datetimepicker1" class="input-append">
                                    <input data-format="yyyy-MM-dd" type="text" placeholder="筛选时间（start）" name='start_time1' id='start_time1' value="<?= $startTime ?>"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>   
                            </div>
                            <div class="span4">筛选时间（end）：<br>
                                <div id="datetimepicker2" class="input-append">
                                    <input data-format="yyyy-MM-dd" type="text" placeholder="筛选时间（end）" name='end_time1' id='end_time1' value="<?= $startTime ?>"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>   
                            </div> 
                            <div class="span4">自定义排序:<br />
                                <select id="byorder1" name="byorder1">
                                    <option value=""></option>
                                    <option value="id">id</option>
                                    <option value="req_uv">req_uv</option>
                                    <option value="req_ad">req_ad</option>
                                    <option value="click_uv">click_uv</option>
                                    <option value="click_ad">click_ad</option>
                                    <option value="down_uv">down_uv</option>
                                    <option value="down_ad">down_ad</option>
                                    <option value="install_uv">install_uv</option>
                                    <option value="install_ad">install_ad</option>
                                </select>
                            </div> 
                        </div>                                    
                    </div>                    
                </div>
                <div id="select_2" style="display:none">
                    <div class="span10">
                        <div class="row-fluid">
                            <div class="span4">筛选时间（start）：<br>
                                <div id="datetimepicker3" class="input-append">
                                    <input data-format="yyyy-MM-dd" type="text" placeholder="筛选时间（start）" name='start_time2' id='start_time2' value="<?= $startTime ?>"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>   
                            </div>
                            <div class="span4">排序方法:<br />
                                <select id="bysort2" name="bysort2">
                                    <option value=""></option>
                                    <option value="asc">升序</option>
                                    <option value="desc">降序</option>
                                </select>
                            </div>
                        </div>
                        <div class="row-fluid">

                            <div class="span4">筛选时间（end）：<br>
                                <div id="datetimepicker4" class="input-append">
                                    <input data-format="yyyy-MM-dd" type="text" placeholder="筛选时间（end）" name='end_time2' id='end_time2' value="<?= $startTime ?>"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>   
                            </div> 
                            <div class="span4">自定义排序:<br />
                                <select id="byorder2" name="byorder2">
                                    <option value=""></option>
                                    <option value="id">id</option>
                                    <option value="req_uv">req_uv</option>
                                    <option value="req_ad">req_ad</option>
                                    <option value="click_uv">click_uv</option>
                                    <option value="click_ad">click_ad</option>
                                    <option value="down_uv">down_uv</option>
                                    <option value="down_ad">down_ad</option>
                                    <option value="install_uv">install_uv</option>
                                    <option value="install_ad">install_ad</option>
                                </select>
                            </div> 
                        </div>                                    
                    </div>                    
                </div>
                <div class="span1" style="height:200px;text-align: center;vertical-align:middle;overflow:hidden;padding-top:32px;">                 
                    <button class="btn btn-primary" id="btn_search" name="btn_search">查询</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                </div>               
            </form>
        </div>              	
        <div id="p2" class="easyui-panel" title="渠道质量-数据图" style="height:auto;padding:10px;margin: 0;" data-options="collapsible:true">
            <div id="container" style="min-width: 310px; height: 650px; margin: 0 auto"></div>           
        </div>
        <div class="box-content" style="overflow:scroll;height:500px;">
            <table id="tt" class="easyui-datagrid" style="margin: 0;" title="查询结果" 
                   url="/channel_manage/ajax_channel_quality" title="Load Data" iconCls="icon-save"
                   pageSize=10 pagePosition="both" 
                   rownumbers="true" pagination="true" showFooter="true">
                <thead>
                    <tr>    
                        <th field="id" align="center">渠道ID</th>
                        <th field="channel_name" align="center" width="200px">渠道</th>
                        <th field="date" align="center">记录日期（date）</th>
                        <th field="req_uv" align="center">req_uv</th>
                        <th field="req_ad" align="center">req_ad</th>
                        <th field="click_uv" align="center">click_uv</th>
                        <th field="click_ad" align="center">click_ad</th>
                        <th field="down_uv" align="center">down_uv</th>
                        <th field="down_ad" align="center">down_ad</th>
                        <th field="install_uv" align="center">install_uv</th>
                        <th field="install_ad" align="center">install_ad</th>
                        <th field="start_time" align="center">查看日期（start）</th>
                        <th field="end_time" align="center">查看日期（end）</th>
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
        var select_obj = new Object();
        var show_status = $('#status').val();
        select_obj.status = show_status;
        if (show_status == 1) {
            select_obj.name = $("#name1").val();
            select_obj.start_time = $("#start_time1").val();
            select_obj.end_time = $("#end_time1").val();
            select_obj.bysort = $("#bysort1").val();
            select_obj.byorder = $("#byorder1").val();
        }
        if (show_status == 2) {
            select_obj.name = '';
            select_obj.start_time = $("#start_time2").val();
            select_obj.end_time = $("#end_time2").val();
            select_obj.bysort = $("#bysort2").val();
        }
        e.preventDefault();
        form1.action = "/channel_manage/ajax_channel_quality";
        $('#tt').datagrid('load', {
            status: select_obj.status,
            name: select_obj.name,
            start_time: select_obj.start_time,
            end_time: select_obj.end_time,
            bysort: select_obj.bysort,
            byorder: select_obj.byorder,
        });
    });
    $("#tt").datagrid({
        onLoadSuccess: function(data) {
            var options = get_highcharts();
            var chart_canvas = $('#container');
            var categories = [];
            var obj = data.rows;
            var show_status = $('#status').val();
            if (show_status == 1) {
                var channel_name = $("#name1").val();
                var start_time = $("#start_time1").val();
                var end_time = $("#end_time1").val();
                options.chart.type = 'spline';
                options.title.text = channel_name + '渠道的数据走势';
                options.subtitle.text = 'source:' + start_time + '~' + end_time;
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].date);
                }
            }
            if (show_status == 2) {
                var start_time = $("#start_time2").val();
                var end_time = $("#end_time2").val();
                options.chart.type = 'area';
                options.title.text = start_time + '~' + end_time + '渠道的数据走势';
                options.subtitle.text = 'source:期间渠道对比';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].channel_name);
                }
            }          
            var data0 = [];
            var data1 = [];
            var data2 = [];
            var data3 = [];
            var data4 = [];
            var data5 = [];
            var data6 = [];
            var data7 = [];
            for (var i = 0; i < (obj.length); i++) {              
                data0.push(parseInt(obj[i].req_uv, 10));
                data1.push(parseInt(obj[i].req_ad, 10));
                data2.push(parseInt(obj[i].click_uv, 10));
                data3.push(parseInt(obj[i].click_ad, 10));
                data4.push(parseInt(obj[i].down_uv, 10));
                data5.push(parseInt(obj[i].down_ad, 10));
                data6.push(parseInt(obj[i].install_uv, 10));
                data7.push(parseInt(obj[i].install_ad, 10));
            }
            options.xAxis.categories = categories;
            options.yAxis.title.text = 'source: channel trend';
            options.series[0] = {};
            options.series[0].name = 'req_uv';
            options.series[0].data = data0;

            options.series[1] = {};
            options.series[1].name = 'req_ad';
            options.series[1].data = data1;

            options.series[2] = {};
            options.series[2].name = 'click_uv';
            options.series[2].data = data2;

            options.series[3] = {};
            options.series[3].name = 'click_ad';
            options.series[3].data = data3;

            options.series[4] = {};
            options.series[4].name = 'down_uv';
            options.series[4].data = data4;

            options.series[5] = {};
            options.series[5].name = 'down_ad';
            options.series[5].data = data5;

            options.series[6] = {};
            options.series[6].name = 'install_uv';
            options.series[6].data = data6;

            options.series[7] = {};
            options.series[7].name = 'install_ad';
            options.series[7].data = data7;
            var chart = new Highcharts.Chart(options);
        },
    });
});
</script>
<script>
    function show_select() { 
        var show_status = $('#status').val();
        if (show_status == '') {
            $("#form1 :input").each(function () { 
                $(this).val(""); 
            });
            $('#select_1').css('display', 'none');
            $('#select_2').css('display', 'none');
        }
        if (show_status == 1) {
            $("#select_2 :input").each(function () { 
                $(this).val(""); 
            });
            $('#select_1').css('display', 'block');
            $('#select_2').css('display', 'none');
        }
        if (show_status == 2) {
            $("#select_1 :input").each(function () { 
                $(this).val(""); 
            });
            $('#select_1').css('display', 'none');
            $('#select_2').css('display', 'block');
        }
    }
</script>
<?php
$this->load->view('ckad/footer')?>