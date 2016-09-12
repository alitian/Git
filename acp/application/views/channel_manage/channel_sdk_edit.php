<?php $this->load->view('ckad/header') ?>
<script type="text/javascript" src="/static/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-switch.min.css">
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>SDK编辑</h2>
        </div>
        <div class="box-content">   
            <div class="row-fluid">
                <div class="well span5 center login-box">
                    <div>	
                        <iframe name="FORMSUBMIT" width="1" height="1" id="FORMSUBMIT"></iframe> 
                        <form class="forms addform" name="addform" id="addform" target="FORMSUBMIT" action="" method="post"> 
                            <div style="width:100%;height:1px; background:#E0E0E0;"></div>
                            <div id="apk_mess" class="apk_mess">
                                <input type="hidden" id='id' name='id' value="<?php echo $sdk_mes['id'];?>"/>
                                <p style="margin-top:20px;">SDK名称:<input style="margin-left:20px;" type="text" id='name' name='name' value="<?php echo $sdk_mes['name'];?>" placeholder=""/></p>
                                <p style="margin-top:20px;">update_pack:<input style="margin-left:20px;" type="text" id='update_pack' name='update_pack' value="<?php echo $sdk_mes['update_pack'];?>" placeholder="" /></p>
                                <p style="margin-top:20px;">update_ver:<input style="margin-left:20px;" type="text" name="update_ver" id="update_ver" value="<?php echo $sdk_mes['update_ver'];?>" placeholder=""></p>
                                <p style="margin-top:20px;">update_downurl_1:<input style="margin-left:20px;" type="text" id='update_downurl_1' name='update_downurl_1' value="<?php echo $sdk_mes['update_downurl_1'];?>" placeholder="" /></p>
                                <p style="margin-top:20px;">update_memo:<input style="margin-left:20px;" type="text" id='update_memo' name='update_memo' value="<?php echo $sdk_mes['update_memo'];?>"  placeholder=""/></p>
                                <p style="margin-top:20px;">private_json:<input style="margin-left:20px;" type="text" id='private_json' name='private_json' value="<?php echo $sdk_mes['private_json'];?>"  placeholder=""/></p>
                                <p style="margin-top:20px;">status:
                                    <select id="status" name="status" value="<?php echo $sdk_mes['status'];?>">
                                        <option value="<?php echo $sdk_mes['status'];?>"><?php echo $sdk_mes['status_name'];?></option>
                                        <option value="-1">废弃</option>
                                        <option value="1">使用</option>
                                        <option value="2">延时使用</option>
                                    </select>
                                </p>	    	
                            </div>
                            <div>
                                <input class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit" value="保存"/>                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/span-->

</div><!--/row-->
<script language="javascript">
    $(function() {
        $("#btnSubmit").click(function() {
            if (judgment_sdk_obj()) {
                var doc = document.getElementById('FORMSUBMIT').contentWindow.document;

                addform.action = "/channel_manage/create_new_sdk";
                addform.submit();
                var oFrm = document.getElementById("FORMSUBMIT");
                oFrm.onload = oFrm.onreadystatechange = function() {
                    if (this.readyState && this.readyState != 'complete')
                        return;
                    else {
                        alert('编辑更新成功！');
                        location.replace('channel_sdk');
                    }
                }
            }
        });

    });
</script>
<!-- content ends -->

<?php
$this->load->view('ckad/footer')?>