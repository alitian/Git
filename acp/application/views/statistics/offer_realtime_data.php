<?php $this->load->view('ckad/header') ?>  
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url(); ?>main/site">首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="history_data">实时数据</a>
        </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div id="p" class="easyui-panel" title="实时数据-查询条件" style="height:280px;padding:10px;margin: 0;" data-options="collapsible:true">
            <form method="POST" name='form1' id="form1" action="">
                <div class="span10">
                    <div class="span3">展示选择<br />
                        <select id="show_status" name="show_status" onchange='show_select();'>
                            <option value=""></option>
                            <option value="1">按ad（同一ad_name）</option>
                            <option value="2">按联盟（同一provider）</option>
                            <option value="3">按type类别（同一type）</option>
                        </select>
                    </div>
                </div> 
                <div id="show_select" style="display:none">
                    <div class="span10">                       
                        <div class="row-fluid"> 
                            <div id="for_ad" style="display:none">
                                <div class="span4">ad名称（ad_name,唯一） :<br />
                                    <input type="text" id='ad_name' name='ad_name' value="" placeholder="名称" />
                                </div> 
                                <div class="span4">provider_id :<br />
                                    <input type="text" id='provider_id1' name='provider_id1' value="" placeholder="多个请用,分割" />
                                </div>
                            </div>
                            <div id="for_provider"  style="display:none">
                                <div class="span4">provider_id :<br />
                                    <input type="text" id='provider_id2' name='provider_id2' value="" placeholder="单一" />
                                </div> 
                                <div class="span4">ad_id :<br />
                                    <input type="text" id='ad_id2' name='ad_id2' value="" placeholder="多个请用,分割" />
                                </div>
                            </div>
                            <div id="for_type" style="display:none">
                                <div class="span4">类别（type） :<br />
                                    <select id="type" name="type">
                                        <option value=""></option>
                                        <option value="1">Apk Offer</option>
                                        <option value="3">Affliate Offer</option>
                                    </select>
                                </div> 
                                <div class="span4">provider_id :<br />
                                    <input type="text" id='provider_id3' name='provider_id3' value="" placeholder="多个请用,分割" />
                                </div>
                                <div class="span4">ad_id :<br />
                                    <input type="text" id='ad_id3' name='ad_id3' value="" placeholder="多个请用,分割" />
                                </div>
                            </div>                        
                        </div>
                        <div class="row-fluid">
                            <div class="span4">自定义排序:<br />
                                <select id="byorder" name="byorder">
                                    <option value=""></option>
                                    <option value="adid">ad_id</option>
                                    <option value="a.provider">provider_id</option>
                                    <option value="weight">weight</option>
                                    <option value="preweight">pre_weight</option>
                                    <option value="price">price</option>
                                    <option value="cap">cap</option>
                                    <option value="sendnum">sendnum</option>
                                    <option value="postnum">postnum</option>
                                    <option value="installnum">installnum</option>
                                    <option value="cr">cr</option>
                                </select>
                            </div>
                            <div class="span4">排序方法:<br />
                                <select id="bysort" name="bysort">
                                    <option value=""></option>
                                    <option value="asc">升序</option>
                                    <option value="desc">降序</option>
                                </select>
                            </div>
                            <div class="span4">状态<br />
                                <select id="status" name="status">
                                    <option value=""></option>
                                    <option value="-1">下架</option>
                                    <option value="3">上线</option>
                                    <option value="1">页面修改失败</option>
                                    <option value="-2">没有下载地址</option>
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
        <div id="p2" class="easyui-panel" title="实时数据-数据图" style="height:auto;padding:10px;margin: 0;" data-options="collapsible:true">
            <div id="container" style="min-width: 310px; height: 650px; margin: 0 auto"></div>           
        </div>
        <div class="box-content" style="overflow:scroll;height:500px;">
            <table id="tt" class="easyui-datagrid" style="margin: 0;" title="查询结果" 
                   url="/statistics/ajax_realtime_data" title="Load Data" iconCls="icon-save"
                   pageSize=10 pagePosition="both" 
                   rownumbers="true" pagination="true" showFooter="true">
                <thead>
                    <tr>    
                        <th field="date" align="center" >记录日期（date）</th>
                        <th field="status" align="center" >状态</th>
                       <th field="adid" align="center">adid</th>
                        <th field="ad_name" align="center" width="200px">ad_name</th>
                        <th field="type" align="center">ad_type</th>
                        <th field="provider_id" align="center">provider_id</th>
                        <th field="weight" align="center">weight</th>
                        <th field="preweight" align="center">pre_weight</th>
                        <th field="cap" align="center">cap</th>
                        <th field="price" align="center">price</th>
                        <th field="sendnum" align="center">sendnum</th>
                        <th field="postnum" align="center">postnum</th>
                        <th field="installnum" align="center">installnum</th>
                        <th field="cr" align="center">cr(SUM(installnum)/SUM(sendnum) %)</th>
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
        var show_status = $('#show_status').val();
        if (show_status == 1) {
            select_obj.type = '';
            select_obj.ad_id='',
            select_obj.ad_name = $('#ad_name').val();
            select_obj.provider_id = $('#provider_id1').val();
        }
        if (show_status == 2) {
            select_obj.type = '';
            select_obj.ad_id = $('#ad_id2').val();
            select_obj.ad_name ='';
            select_obj.provider_id = $('#provider_id2').val();           
        }
        if (show_status == 3) {
            select_obj.type = $('#type').val();
            select_obj.provider_id = $('#provider_id3').val();
            select_obj.ad_id = $('#ad_id3').val();
            select_obj.ad_name ='';
        }
        select_obj.status = $('#status').val();
        select_obj.bysort = $('#bysort').val();
        select_obj.byorder = $('#byorder').val();
        e.preventDefault();
        form1.action = "/statistics/ajax_realtime_data";
        $('#tt').datagrid('load', {
            show_status:show_status,
            status:select_obj.status,
            ad_id:select_obj.ad_id,
            ad_name:select_obj.ad_name,
            provider_id:select_obj.provider_id,
            type: select_obj.type,
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
            var show_status = $('#show_status').val();
            if(show_status == ''){
                options.chart.type = 'spline';
                options.title.text = '下发/安装/回调/数据整体走势';
                options.subtitle.text = 'source';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].ad_name+'('+obj[i].date+')');
                }
            }
            if (show_status == 1) {
                var ad_name = $("#ad_name").val();
                options.chart.type = 'spline';
                options.title.text = ad_name + '下发/安装/回调/数据走势';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].date+'('+obj[i].provider_id+')');
                }
            }
            if (show_status == 2) {
                var provider_id = $("#provider_id2").val();
                options.chart.type = 'area';
                options.title.text = '联盟：'+ provider_id + '下发/安装/回调/数据走势';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].ad_name);
                }
            }
            if (show_status == 3) {
                var type = $("#type").val();
                if(type == 1){
                    type = 'Apk Offer';
                }else{
                    type = 'Affliate Offer';
                }
                options.chart.type = 'area';
                options.title.text = '类别：'+type+'下发/安装/回调/数据走势';
                for (var i = 0; i < (obj.length); i++) {
                    categories.push(obj[i].ad_name+'('+obj[i].provider_id+')');
                }
            }
            var data0 = [];
            var data1 = [];
            var data2 = [];
            var data3 = [];
            var data4 = [];
            var data5 = [];
            var data6 = [];
            for (var i = 0; i < (obj.length); i++) {              
                data0.push(parseInt(obj[i].weight, 10));
                data1.push(parseInt(obj[i].preweight, 10));
                data2.push(parseInt(obj[i].cap, 10));
                data3.push(parseInt(obj[i].sendnum, 10));
                data4.push(parseInt(obj[i].postnum, 10));
                data5.push(parseInt(obj[i].installnum, 10));
                data6.push(parseInt(obj[i].cr, 10));
            }
            options.xAxis.categories = categories;
            options.yAxis.title.text = 'source: ad trend';
            options.series[0] = {};
            options.series[0].name = 'weight';
            options.series[0].data = data0;

            options.series[1] = {};
            options.series[1].name = 'preweight';
            options.series[1].data = data1;

            options.series[2] = {};
            options.series[2].name = 'cap';
            options.series[2].data = data2;

            options.series[3] = {};
            options.series[3].name = 'sendnum';
            options.series[3].data = data3;

            options.series[4] = {};
            options.series[4].name = 'postnum';
            options.series[4].data = data4;

            options.series[5] = {};
            options.series[5].name = 'installnum';
            options.series[5].data = data5;

            options.series[6] = {};
            options.series[6].name = 'cr';
            options.series[6].data = data6;

            var chart = new Highcharts.Chart(options);
        },
    });
});
</script>
<script>
    function show_select() {      
        var show_status = $('#show_status').val();
        if (show_status == '') {
            $("#form1 :input").each(function () { 
                $(this).val(""); 
            });
            $('#show_select').css('display', 'none');
        }
        if (show_status == 1) {
            $("#show_select :input").each(function () { 
                $(this).val(""); 
            });
            $('#show_select').css('display', 'block');
            $('#for_ad').css('display', 'block');
            $('#for_provider').css('display', 'none');
            $('#for_type').css('display', 'none');
        }
        if (show_status == 2) {
            $("#show_select :input").each(function () { 
                $(this).val(""); 
            });
            $('#show_select').css('display', 'block');
            $('#for_ad').css('display', 'none');
            $('#for_provider').css('display', 'block');
            $('#for_type').css('display', 'none');
        }
        if (show_status == 3) {
            $("#show_select :input").each(function () { 
                $(this).val(""); 
            });
            $('#show_select').css('display', 'block');
            $('#for_ad').css('display', 'none');
            $('#for_provider').css('display', 'none');
            $('#for_type').css('display', 'block');
        }
    }
</script>
<?php
$this->load->view('ckad/footer')?>