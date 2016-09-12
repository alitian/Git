<?php $this->load->view('ckad/header') ?> 
<style type="text/css">
    .black_overlay{  
        display: none;  
        position: absolute;  
        top: 0%;  
        left: 0%;  
        width: 100%;  
        height: 2000px;  
        background-color: black;  
        z-index:1001;  
        -moz-opacity: 0.8;  
        opacity:.80;  
        filter: alpha(opacity=80);  
    }  
    .white_content {  
        display: none;  
        position: absolute;  
        top: 25%;  
        left: 25%;  
        width: 50%;  
        height: 0 auto;  
        padding: 16px;  
        border: 2px solid rgba(68, 218, 224, 0.5);  
        background-color: white;  
        z-index:1002;  
    }
    .edit_pro{
        display: none;  
        position: absolute;  
        top: 25%;  
        left: 25%;  
        width: 50%;  
        height: 70%;  
        padding: 16px;  
        border: 2px solid rgba(68, 218, 224, 0.5);  
        background-color: white;  
        z-index:1002;  	
    }
</style>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url(); ?>main/site">首页</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="channel_sdk">SDK查询</a>
        </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div id="p" class="easyui-panel" title="SDK-查询条件" style="height:200px;padding:10px;margin: 0;" data-options="collapsible:true">
            <form method="POST" name='form1' id="form1" action="">
                <div class="span10">
                    <div class="row-fluid">
                        <div class="span4">SDK-ID(多id用,分割):<br /><input type="text" id='id' name='id' value="" placeholder="SDK-ID(多id用,分割)" /></div>
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
                        <div class="span4">SDK名称(name):<br />
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
                    <div class="row-fluid">
                        <div class="span4">状态(status)<br />
                            <select id="status" name="status">
                                <option value=""></option>
                                <option value="-1">废弃</option>
                                <option value="1">使用</option>
                                <option value="2">延时使用</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span1" style="height:200px;text-align: center;vertical-align:middle;overflow:hidden;padding-top:32px;">                 
                    <button class="btn btn-primary" id="btn_search" name="btn_search">查询</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                    <a class="btn btn-primary" id="btn_create" name="btn_create">创建新APK</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>  
                </div>               
            </form>
        </div>              	
        <div class="box-content" style="overflow:scroll;height:500px;">
            <table id="tt" class="easyui-datagrid" style="margin: 0;" title="查询结果" 
                   url="/channel_manage/ajax_channel_sdk" title="Load Data" iconCls="icon-save"
                   pageSize=20 pagePosition="both" 
                   rownumbers="true" pagination="true" showFooter="true">
                <thead>
                    <tr>    
                        <th field="work" align="center">操作</th>
                        <th field="status" align="center">SDK状态</th>
                        <th field="id" align="center">ID</th>
                        <th field="name" align="center">名称（name）</th>
                        <th field="update_pack" align="center">update_pack</th>
                        <th field="update_ver" align="center">update_ver</th>
                        <th field="update_memo" align="center">update_memo</th>                     
                        <th field="update_downurl_1" align="center">update_downurl_1</th>
                        <th field="ctime" align="center">创建时间（ctime）</th>
                        <th field="utime" align="center">最后更新时间（update_time）</th>
                    </tr>                   
                </thead>
            </table>            
        </div>
    </div><!--/span-->
</div>
<!-- 发起新APK弹窗   -->

<div id="light" class="white_content">
    <iframe name="FORMSUBMIT" width="1" height="1" id="FORMSUBMIT"></iframe> 
    <form class="forms addform" name="addform" id="addform" target="FORMSUBMIT" action="" method="post"> 
        <h3>新建SDK<a href="javascript:;" id="close" class="close">Close</a></h3>
        <div style="width:100%;height:1px; background:#E0E0E0;"></div>
        <div id="sdk_mess" class="sdk_mess">
            <p style="margin-top:20px;">SDK名称:<input style="margin-left:20px;" type="text" id='name' name='name' value="" placeholder="请不要填写中文"/></p>
            <p style="margin-top:20px;">update_pack：<input style="margin-left:20px;" type="text" id='update_pack' name='update_pack' value="" placeholder="" /></p>
            <p style="margin-top:20px;">update_ver:<input style="margin-left:20px;" type="text" name="update_ver" id="update_ver" value="" placeholder=""></p>
            <p style="margin-top:20px;">update_downurl_1:<input style="margin-left:20px;" type="text" id='update_downurl_1' name='update_downurl_1' value="" placeholder="" /></p>
            <p style="margin-top:20px;">update_memo:<input style="margin-left:20px;" type="text" id='update_memo' name='update_memo' value=""  placeholder=""/></p>
            <p style="margin-top:20px;">private_json:<input style="margin-left:20px;" type="text" id='private_json' name='private_json' value=""  placeholder=""/></p>
        </div>
        <div>
            <a style="margin-left:40%" class="btn btn-primary" id="btn_add" name="btn_add">提交</a>  
            <a class="btn btn-primary" id="btn_del" name="btn_del">取消</a>                
        </div>
    </form>
</div> 
<!-- 发起APK弹窗结束 -->
<div id="fade" class="black_overlay"> 
</div> 
<script src="<?= static_url(); ?>js/highcharts/highcharts.js"></script>
<script src="<?= static_url(); ?>js/highcharts/modules/exporting.js"></script>
<script src="<?= static_url(); ?>js/own/public_highcharts.js"></script>
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
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
            form1.action = "/channel_manage/ajax_channel_sdk";
            $('#tt').datagrid('load', {
                id: $("#id").val(),
                name: $("#name").val(),
                status: $("#status").val(),
                c_start_time: $("#c_start_time").val(),
                c_end_time: $("#c_end_time").val(),
                u_start_time:$("#u_start_time").val(),
                u_end_time:$("#u_end_time").val(),
            });
        }); 
        
        $('#btn_create').click(function(e) {
            $('#light').css('display', 'block');
            $('#fade').css('display', 'block');
        });
        $('#close').click(function(e) {
            $('#light').css('display', 'none');
            $('#fade').css('display', 'none');
        });
        $("#btn_del").click(function() {
            $(".sdk_mess").find("input[type='text']").val("");
        });
        
         $("#btn_add").click(function() {
            if (judgment_sdk_obj()) {
                var doc = document.getElementById('FORMSUBMIT').contentWindow.document;

                addform.action = "/channel_manage/create_new_sdk";
                addform.submit();
                var oFrm = document.getElementById("FORMSUBMIT");
                oFrm.onload = oFrm.onreadystatechange = function() {
                    if (this.readyState && this.readyState != 'complete')
                        return;
                    else {
                        alert('创建成功');
                        location.replace('channel_sdk');
                    }
                }
            }
        });
    });
</script>
<?php
$this->load->view('ckad/footer')?>