<?php $this->load->view('ckad/header') ?>
<script type="text/javascript" src="/static/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-switch.min.css">
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>APK编辑</h2>
        </div>
        <div class="box-content">   
            <div class="row-fluid">
                <div class="well span5 center login-box">
                    <div>	
                        <iframe name="FORMSUBMIT" width="1" height="1" id="FORMSUBMIT"></iframe> 
                        <form class="forms addform" name="addform" id="addform" target="FORMSUBMIT" action="" method="post"> 
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
            if (judgment_obj()) {
                var doc = document.getElementById('FORMSUBMIT').contentWindow.document;

                addform.action = "/offer_manage/create_new_apk";
                addform.submit();
                var oFrm = document.getElementById("FORMSUBMIT");
                oFrm.onload = oFrm.onreadystatechange = function() {
                    if (this.readyState && this.readyState != 'complete')
                        return;
                    else {
                        location.replace('offer_apk');
                    }
                }
            }
        });

    });
</script>
<!-- content ends -->

<?php
$this->load->view('ckad/footer')?>