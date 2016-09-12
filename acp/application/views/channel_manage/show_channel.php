<?php $this->load->view('ckad/header') ?>  
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url(); ?>main/site">首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="show_channel">渠道查询</a>
        </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div id="p" class="easyui-panel" title="渠道-查询条件" style="height:200px;padding:10px;margin: 0;" data-options="collapsible:true">
            <form method="POST" name='form1' id="form1" action="">
                <div class="span10">
                    <div class="row-fluid">
                        <div class="span4">渠道ID(多id用,分割):<br /><input type="text" id='id' name='id' value="" placeholder="广告ID(多id用,分割)" /></div>
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
                        <div class="span4">渠道名称(token):<br />
                            <input type="text" id='token' name='token' value="" placeholder="渠道名称" />
                        </div>
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
                    </div>  
                </div>
                <div class="span1" style="height:200px;text-align: center;vertical-align:middle;overflow:hidden;padding-top:32px;">                 
                    <button class="btn btn-primary" id="btn_search" name="btn_search">查询</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                </div>               
            </form>
        </div>              	
        <div class="box-content" style="overflow:scroll;height:500px;">
            <table id="tt" class="easyui-datagrid" style="margin: 0;" title="查询结果" 
                   url="/channel_manage/ajax_channel_list" title="Load Data" iconCls="icon-save"
                   pageSize=20 pagePosition="both" 
                   rownumbers="true" pagination="true" showFooter="true">
                <thead>
                    <tr>    
                        <th field="work" align="center">操作</th>
                        <th field="id" align="center">渠道ID</th>
                        <th field="name" align="center">渠道名称（token）</th>
                        <th field="md5_key" align="center">渠道键值（channel_name）</th>
                        <th field="update_pack" align="center">update_pack</th>
                        <th field="update_ver" align="center">update_ver</th>
                        <th field="update_memo" align="center">update_memo</th>                     
                        <th field="update_downurl_1" align="center">update_downurl_1</th>
                        <th field="ctime" align="center">创建时间（ctime）</th>
                        <th field="update_time" align="center">最后更新时间（update_time）</th>
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
            form1.action = "/channel_manage/ajax_channel_list";
            $('#tt').datagrid('load', {
                type: $("#type").val(),
                id: $("#id").val(),
                token: $("#token").val(),
                adid: $("#adid").val(),
                pkg: $("#pkg").val(),
                status: $("#status").val(),
                c_start_time: $("#c_start_time").val(),
                c_end_time: $("#c_end_time").val(),
                u_start_time:$("#u_start_time").val(),
                u_end_time:$("#u_end_time").val(),
                bysort:$("#bysort").val(),
                byorder:$("#byorder").val(),
            });
        }); 
    });
</script>
<?php
$this->load->view('ckad/footer')?>