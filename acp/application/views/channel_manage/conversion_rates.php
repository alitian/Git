<?php $this->load->view('ckad/header') ?>  
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url(); ?>main/site">首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="channel_quality">渠道转化率</a>
        </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div id="p" class="easyui-panel" title="渠道转化率-查询条件" style="height:280px;padding:10px;margin: 0;" data-options="collapsible:true">
            <form method="POST" name='form1' id="form1" action="">
                <div class="span10">
                    <div class="span3">展示选择<br />
                        <select id="status" name="status" onchange='show_select();'>
                            <option value=""></option>
                            <option value="1">按渠道（同一渠道）</option>
                            <option value="2">按国家（同一个国家间；不同渠道）</option>
                            <option value="3">按国家级别（同一个国家级别间；不同渠道）</option>
                        </select>
                    </div>
                </div> 
                <div id="select" style="display:none">
                    <div class="span10">
                        <div class="row-fluid">
                            <div class="span4" id="for_channel" style="display:none;margin-left:0">渠道名称（channel_name） :<br />
                                <input type="text" id='channel_name' name='channel_name' value="" placeholder="渠道名称" />
                            </div> 
                            <div class="span4" id="for_country" style="display:none;margin-left:0">国家名称（country_code） :<br />
                                <input type="text" id='country_code' name='country_code' value="" placeholder="国家名称" />
                            </div>
                            <div class="span4" id="for_flag" style="display:none;margin-left:0">国家级别（flag） :<br />
                                <select id="flag" name="flag">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="span4">排序方法:<br />
                                <select id="bysort" name="bysort">
                                    <option value=""></option>
                                    <option value="asc">升序</option>
                                    <option value="desc">降序</option>
                                </select>
                            </div>
                            <div class="span4">自定义排序:<br />
                                <select id="byorder" name="byorder">
                                    <option value=""></option>
                                    <option value="id">id</option>
                                    <option value="uv">uv</option>
                                    <option value="rootuv">rootuv</option>
                                    <option value="cr">cr</option>
                                </select>
                            </div>                          
                        </div>
                        <div class="row-fluid">                          
                            <div class="span4">筛选日期（start）：<br>
                                <div id="datetimepicker1" class="input-append">
                                    <input data-format="yyyy-MM-dd" type="text" placeholder="筛选时间（start）" name='startdate' id='startdate' value="<?= $startTime ?>"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>   
                            </div>
                            <div class="span4">筛选日期（end）：<br>
                                <div id="datetimepicker2" class="input-append">
                                    <input data-format="yyyy-MM-dd" type="text" placeholder="筛选时间（end）" name='enddate' id='enddate' value="<?= $startTime ?>"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>   
                            </div> 
                            <div class="span4">筛选时间（整点start）:<br />
                                <select id="start_hour" name="start_hour">
                                    <option value=""></option>
                                    <?php for($i=0;$i<24;$i++){?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php }?>
                                </select>
                            </div> 
                        </div> 
                        <div class="row-fluid">
                            <div class="span4">筛选时间（整点end）:<br />
                                <select id="end_hour" name="end_hour">
                                    <option value=""></option>
                                    <?php for($i=0;$i<24;$i++){?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php }?>
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
        <div id="p2" class="easyui-panel" title="渠道转化率-数据图" style="height:auto;padding:10px;margin: 0;" data-options="collapsible:true">
            <div id="container" style="min-width: 310px; height: 650px; margin: 0 auto"></div>    
        </div>
        <div class="box-content" style="overflow:scroll;height:500px;">
            <table id="tt" class="easyui-datagrid" style="margin: 0;" title="查询结果" 
                   url="/channel_manage/ajax_conversion_rates" title="Load Data" iconCls="icon-save"
                   pageSize=10 pagePosition="both" 
                   rownumbers="true" pagination="true" showFooter="true">
                <thead>
                    <tr>    
                        <th field="id" align="center">渠道ID</th>
                        <th field="channel_name" align="center" width="200px">渠道</th>
                        <th field="date" align="center">记录日期（date）</th>
                        <th field="hour" align="center">记录时间（hour）</th>
                        <th field="country_code" align="center">国家编码（country_code）</th>
                        <th field="flag" align="center">国家级别（flag）</th>
                        <th field="uv" align="center">uv</th>
                        <th field="rootuv" align="center">rootuv(iphoto数)</th>
                        <th field="cr" align="center">cr(sum(rootuv)/SUM(uv))</th>
                        <th field="startdate" align="center">查看日期（start_date）</th>
                        <th field="enddate" align="center">查看日期（end_date）</th>
                        <th field="starthour" align="center">查看时间（start_hour）</th>
                        <th field="endhour" align="center">查看时间（end_hour）</th>
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
    $('#datetimepicker1,#datetimepicker2').datetimepicker({
        language: 'zh-CN',
        pickTime: false,
    });

});
$(document).ready(function() {
    $('#btn_search').click(function(e) {
        var select_obj = new Object();
        var show_status = $('#status').val();
        if (show_status == 1) {
            select_obj.channel_name = $("#channel_name").val();
            select_obj.country_code = '';
            select_obj.flag = '';
        }
        if (show_status == 2) {
            select_obj.channel_name = '';
            select_obj.country_code = $("#country_code").val();
            select_obj.flag = '';
        }
        if (show_status == 3) {
            select_obj.channel_name = '';
            select_obj.country_code = '';
            select_obj.flag = $("#flag").val();
        }
        e.preventDefault();
        form1.action = "/channel_manage/ajax_conversion_rates";
        $('#tt').datagrid('load', {
            status:$('#status').val(),
            channel_name:select_obj.channel_name,
            country_code:select_obj.country_code,
            flag:select_obj.flag,
            startdate:$('#startdate').val(),
            enddate:$('#enddate').val(),
            start_hour:$('#start_hour').val(),
            end_hour:$('#end_hour').val(),
            bysort:$('#bysort').val(),
            byorder:$('#byorder').val(),
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
                var channel_name = $("#channel_name").val();
                var startdate = $("#startdate").val();
                var enddate = $("#enddate").val();
                var start_hour = $('#start_hour').val();
                var end_hour = $('#end_hour').val();
                options.chart.type = 'spline';
                options.title.text = channel_name + '渠道的转化趋势';
                options.subtitle.text = 'source:' + startdate + ' '+start_hour+ ' h ~ ' + enddate + ' ' +end_hour+ 'h';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].country_code);
                }
            }
            if (show_status == 2) {
                var country_code = $("#country_code").val();
                var startdate = $("#startdate").val();
                var enddate = $("#enddate").val();
                var start_hour = $('#start_hour').val();
                var end_hour = $('#end_hour').val();
                options.chart.type = 'area';
                options.title.text = country_code+ '国家中渠道的数据走势';
                options.subtitle.text = 'source:' + startdate + ' '+start_hour+ ' h ~ ' + enddate + ' ' +end_hour+ 'h';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].channel_name);
                }
            }
            if (show_status == 3) {
                var flag = $("#flag").val();
                var startdate = $("#startdate").val();
                var enddate = $("#enddate").val();
                var start_hour = $('#start_hour').val();
                var end_hour = $('#end_hour').val();
                options.chart.type = 'area';
                options.title.text = '国家等级 '+ flag+ ' 中渠道的数据走势';
                options.subtitle.text = 'source:' + startdate + ' '+start_hour+ ' h ~ ' + enddate + ' ' +end_hour+ 'h';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].channel_name+'('+obj[i].country_code+')');
                }
            } 
            var data0 = [];
            var data1 = [];
            var data2 = [];
            for (var i = 0; i < (obj.length); i++) {
                data0.push(parseInt(obj[i].uv, 10));
                data1.push(parseInt(obj[i].rootuv, 10));
                data2.push(parseInt(obj[i].cr, 10));
            }
            options.xAxis.categories = categories;
            options.yAxis.title.text = 'source: channel trend';
            options.series[0] = {};
            options.series[0].name = 'uv';
            options.series[0].data = data0;

            options.series[1] = {};
            options.series[1].name = 'rootuv';
            options.series[1].data = data1;

            options.series[2] = {};
            options.series[2].name = 'cr';
            options.series[2].data = data2;

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
            $('#select').css('display', 'none');
        }
        if (show_status == 1) {
            $("#for_country :input").each(function () { 
                $(this).val(""); 
            });
            $("#for_flag :input").each(function () { 
                $(this).val(""); 
            });
            $('#select').css('display', 'block');
            $('#for_channel').css('display', 'block');
            $('#for_country').css('display', 'none');
            $('#for_flag').css('display', 'none');
        }
        if (show_status == 2) {
            $("#for_channel :input").each(function () { 
                $(this).val(""); 
            });
            $("#for_flag :input").each(function () { 
                $(this).val(""); 
            });
            $('#select').css('display', 'block');
            $('#for_channel').css('display', 'none');
            $('#for_country').css('display', 'block');
            $('#for_flag').css('display', 'none');
        }
        if (show_status == 3) {
            $("#for_channel :input").each(function () { 
                $(this).val(""); 
            });
            $("#for_country :input").each(function () { 
                $(this).val(""); 
            });
           $('#select').css('display', 'block');
            $('#for_channel').css('display', 'none');
            $('#for_country').css('display', 'none');
            $('#for_flag').css('display', 'block');
        }
    }
    
</script>
<?php
$this->load->view('ckad/footer')?>