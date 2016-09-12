<?php $this->load->view('ckad/header') ?>
<script type="text/javascript" src="/static/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-switch.min.css">
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>联盟编辑</h2>
        </div>
        <div class="box-content">   
            <div class="row-fluid">
                <div class="well span5 center login-box">
                    <div>		  
                        <form class="form-horizontal" name="form1" action="" method="post" >                         
                            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <tr>
                                    <span style="color:#FF0000"><?php echo $error['if_have']; ?></span>
                                </tr>
                                <tr>
                                    <td>打开状态：<input type="checkbox" <?php echo $oper_mes['status'] == 0 ? 'checked' : ''; ?> key='1' class="switch-mini" name="status" vtype="status" vid="<?= $oper_mes['id']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>联盟名称name：<input type="text" name="oper_name" id="oper_name" value="<?php echo $oper_mes['name'];?>" placeholder="填写联盟名;不能包含中文与中文符号" /><span style="color:#FF0000"><?php echo $error['name']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>联盟权重weight：<input type="text" name="oper_weight" id="oper_weight" value="<?php echo $oper_mes['weight'];?>"  placeholder="默认权重 5" /><span style="color:#FF0000"><?php echo $error['url']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>联盟预权重pre_weight：<input type="text" name="pre_weight" id="pre_weight" value="<?php echo $oper_mes['pre_weight'];?>"  placeholder="默认预权重 20" /><span style="color:#FF0000"><?php echo $error['url']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>安装限制cap：<input type="text" name="oper_cap" id="oper_cap" value="<?php echo $oper_mes['cap'];?>" placeholder="安装百分比；最大100" /><span style="color:#FF0000"><?php echo $error['cap']; ?></span></td>
                                </tr>
                                <tr>
                                    <td><p><input class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit" value="保存"/>&nbsp;&nbsp;<a href="show_oper" class="btn btn-primary" >取消</a></p></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/span-->

</div><!--/row-->
<script language="javascript">
    $(function() {
        $('input[type="checkbox"]').not('#create-switch').bootstrapSwitch();
        $('input[type="checkbox"]').on('switch-change', function(e, data) {
            var value = data.value;
            var swth = $(this);
            jQuery.post("update_oper_status", { type: $(this).attr('vtype'),id: $(this).attr('vid'), val: value}, function(data) {
                if (data.result == 'error')
                {
                    alert(data.error);
                }
            }, 'json');
        });
        
       $("#btnSubmit").click(function(){
           var oper_name = $('#oper_name').val();
           if(if_have_chinese(oper_name,'name')){
               return false;
           }
            $('form1').action='edit_operator?oper_id=<?php echo $oper_mes['id'];?>';
            $('form1').submit();
       });
    });
</script>
<!-- content ends -->

<?php
$this->load->view('ckad/footer')?>