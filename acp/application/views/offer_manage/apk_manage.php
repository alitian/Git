<?php $this->load->view('ckad/header') ?>
<link href='<?= static_url(); ?>css/bootstrap-datetimepicker.min.css' rel='stylesheet' />
<link href='<?= static_url(); ?>css/style.css' rel='stylesheet'>
<script src="<?= static_url(); ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?= static_url(); ?>js/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= static_url(); ?>js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
<script type="text/javascript">
    $(function() {
        $('#datetimepicker1,#datetimepicker2,#datetimepicker3,#datetimepicker4').datetimepicker({
            language: 'zh-CN',
            pickTime: false,
        });
    });
</script>
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
            <a href="offer_apk">APK管理</a>
        </li>
    </ul>
</div>
<div class="row-fluid sortable">
    <div class="box span12">
        <div id="p" class="easyui-panel" title="APK管理-查询条件" style="height:260px;padding:10px;margin: 0;" data-options="collapsible:true">
            <form method="POST" name='form1' id="form1" action="">
                <div class="span10">
                    <div class="row-fluid">
                        <div class="span4">APKID:<br /><input type="text" id='id' name='id' value="" placeholder="APKID,多个使用,分割" /></div>
                        <div class="span4">创建时间（cstart）：<br>
                            <div id="datetimepicker1" class="input-append">
                                <input data-format="yyyy-MM-dd 00:00:00" type="text" placeholder="开始时间" name='c_start_time' id='c_start_time' value=""></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
                        </div>
                        <div class="span4">创建时间（cedn）：<br>
                            <div id="datetimepicker2" class="input-append">
                                <input data-format="yyyy-MM-dd 23:59:59" type="text" placeholder="结束时间" name='c_end_time' id='c_end_time' value=""></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
                        </div>                                          
                    </div>
                    <div class="row-fluid">
                        <div class="span4">APK名称:<br />
                            <input type="text" id='name' name='name' value="" placeholder="APK名称,采用模糊查询" />
                        </div>
                        <div class="span4">更新时间（ustart）：<br>
                            <div id="datetimepicker1" class="input-append">
                                <input data-format="yyyy-MM-dd 00:00:00" type="text" placeholder="开始时间" name='u_start_time' id='u_start_time' value=""></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
                        </div>
                        <div class="span4">更新时间（uedn）：<br>
                            <div id="datetimepicker2" class="input-append">
                                <input data-format="yyyy-MM-dd 23:59:59" type="text" placeholder="结束时间" name='u_end_time' id='u_end_time' value=""></input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                </span>
                            </div>   
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
                        <div class="span3">自定义排序:<br />
                            <select id="byorder" name="byorder">
                                <option value=""></option>
                                <option value="id">APK id</option>
                                <option value="versioncode">版本号（versioncode）</option>
                                <option value="size">大小（size）</option>
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
                   url="/offer_manage/ajax_all_apk" title="Load Data" iconCls="icon-save"
                   pageSize=20 pagePosition="both" 
                   rownumbers="true" pagination="true" showFooter="true">
                <thead>
                    <tr> 
                        <th field="work" align="center">操作</th>
                        <th field="status" align="center" sortable="true">状态</th>
                        <th field="id" align="center" sortable="true">APK-ID</th>
                        <th field="name" align="center">APK名称（name）</th>
                        <th field="pkg" align="center">pkg</th>
                        <th field="apk" align="center" width='300px'>apk包名</th>
                        <th field="icon" align="center" width='300px'>apk图标（icon）</th>
                        <th field="versioncode" align="center">版本号（versioncode）</th>
                        <th field="size" align="center">版本大小（size）</th>
                        <th field="md5" align="center">加密包（md5）</th>
                        <th field="createdate" align="center">创建时间（createdate）</th>
                        <th field="updatedate" align="center">更新时间（updatedate）</th>
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
        <h3>新建APK<a href="javascript:;" id="close" class="close">Close</a></h3>
        <div style="width:100%;height:1px; background:#E0E0E0;"></div>
        <div id="apk_mess" class="apk_mess">
            <input type="hidden" id='id' name='id' value="<?php echo $apk_mes['id'];?>"/>
            <p style="margin-top:20px;">APK名称:<input style="margin-left:20px;" type="text" id='apk_name' name='apk_name' value="<?php echo $apk_mes['name'];?>" placeholder="请不要填写中文"/></p>
            <p style="margin-top:20px;">pkg:<input style="margin-left:20px;" type="text" id='pkg' name='pkg' value="<?php echo $apk_mes['pkg'];?>" placeholder="" /></p>
            <p style="margin-top:20px;">apk:<input style="margin-left:20px;" type="text" name="apk" id="apk" value="<?php echo $apk_mes['apk'];?>" placeholder="对应下载的地址"></p>
            <p style="margin-top:20px;">versioncode:<input style="margin-left:20px;" type="text" id='versioncode' name='versioncode' value="<?php echo $apk_mes['versioncode'];?>" placeholder="对应apk版本号" /></p>
            <p style="margin-top:20px;">size:<input style="margin-left:20px;" type="text" id='size' name='size' value="<?php echo $apk_mes['size'];?>"  placeholder="目前版本的大小；换算成字节k"/></p>
            <p style="margin-top:20px;">md5:<input type="text" id="md5" name="md5" value="<?php echo $apk_mes['md5'];?>" placeholder="手动对应生成的加密值；必填"/></p>	    	
            <p style="margin-top:20px;">icon:<input style="margin-left:20px;" type="text" id='icon' name='icon' value="<?php echo $apk_mes['icon'];?>" placeholder="apk生成时附带的图片；如果不存在可为空"/></p>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_search').click(function(e) {
            e.preventDefault();
            form1.action = "/offer_manage/ajax_all_apk";
            $('#tt').datagrid('load', {
                id: $("#id").val(),
                name: $("#name").val(),
                c_start_time: $("#c_start_time").val(),
                c_end_time: $("#c_end_time").val(),
                u_start_time: $("#u_start_time").val(),
                u_end_time: $("#u_end_time").val(),
                byorder: $("#byorder").val(),
                bysort: $("#bysort").val(),
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
            $(".apk_mess").find("input[type='text']").val("");
        });

        $("#btn_add").click(function() {
            if (judgment_obj()) {
                var doc = document.getElementById('FORMSUBMIT').contentWindow.document;

                addform.action = "/offer_manage/create_new_apk";
                addform.submit();
                var oFrm = document.getElementById("FORMSUBMIT");
                oFrm.onload = oFrm.onreadystatechange = function() {
                    if (this.readyState && this.readyState != 'complete')
                        return;
                    else {
                        $(".apk_mess").find("input[type='text']").val("");
                        $('#light').css('display', 'none');
                        $('#fade').css('display', 'none');
                    }
                }
            }
        });
    });
</script>
<?php
$this->load->view('ckad/footer')?>