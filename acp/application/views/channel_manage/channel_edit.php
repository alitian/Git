<?php $this->load->view('ckad/header') ?>
<script type="text/javascript" src="/static/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-switch.min.css">
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>编辑渠道</h2>
        </div>
        <div class="box-content">   
            <div class="row-fluid">
                <div class="well center login-box">
                    <div>		  
                        <form class="form-horizontal" name="form1" action="edit_channel?id=<?php echo $channel_mes['id'];?>" method="post" >                         
                            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <tr>
                                    <td>渠道name：
                                        <input type="text" name="name" id="name" value="<?php echo $channel_mes['name'];?>" readonly="true" />
                                        <span style="color:#FF0000"><?php echo $error['name']; ?></span>
                                    </td>
                                    <td>对应md5_key：
                                        <input type="text" name="md5_key" id="md5_key" value="<?php echo $channel_mes['md5_key'];?>" readonly="true" />
                                    </td>                                 
                                </tr>
                                <tr>                                  
                                    <td>update_pack：
                                        <input type="text" name="update_pack" id="update_pack" value="<?php echo $channel_mes['update_pack'];?>" />
                                    </td>
                                    <td>update_ver:
                                        <input type="text" name="update_ver" id="update_ver" value="<?php echo $channel_mes['update_ver'];?>" />
                                        <span style="color:#FF0000"><?php echo $error['adid']; ?></span>                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td>update_memo：
                                        <input type="text" name="update_memo" id="update_memo" value="<?php echo $channel_mes['update_memo'];?>"  />
                                        <span style="color:#FF0000"><?php echo $error['pullratio']; ?></span>
                                    </td>
                                    <td>update_downurl_1：
                                        <input type="text" name="update_downurl_1" id="update_downurl_1" value="<?php echo $channel_mes['update_downurl_1'];?>"  />
                                        <span style="color:#FF0000"><?php echo $error['provider']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p><input class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit" value="保存"/>&nbsp;&nbsp;<a href="show_channel" class="btn btn-primary" >取消</a></p></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/span-->

</div><!--/row-->
<!-- content ends -->
<?php
$this->load->view('ckad/footer')?>