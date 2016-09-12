<?php $this->load->view('ckad/header') ?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>联盟添加</h2>
        </div>
        <div class="box-content">   
            <div class="row-fluid">
                <div class="well span5 center login-box">
                    <div>		  
                        <form class="form-horizontal" action="create_oper" method="post" >                         
                            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <tr>
                                    <td><span style="color:#FF0000"><?php echo $error['if_have']; ?></span></td>
                                </tr> 
                                <tr>
                                    <td>联盟id：<input type="text" name="oper_id" id="oper_id" value="<?php echo $data['id'];?>" placeholder="填写联盟id;按套数填写" /><span style="color:#FF0000"><?php echo $error['id']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>联盟名称name：<input type="text" name="oper_name" id="oper_name" value="<?php echo $data['name'];?>" placeholder="填写联盟名;不能包含中文与中文符号" /><span style="color:#FF0000"><?php echo $error['name']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>联盟权重weight：<input type="text" name="oper_weight" id="oper_weight" value="<?php echo $data['weight'];?>"  placeholder="默认权重 5" /><span style="color:#FF0000"><?php echo $error['url']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>联盟预权重pre_weight：<input type="text" name="pre_weight" id="pre_weight" value="<?php echo $data['pre_weight'];?>"  placeholder="默认预权重 20" /><span style="color:#FF0000"><?php echo $error['url']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>安装限制cap：<input type="text" name="oper_cap" id="oper_cap" value="<?php echo $data['cap'];?>" placeholder="安装百分比；最大100" /><span style="color:#FF0000"><?php echo $error['cap']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>安装率sinstall：<input type="text" name="oper_sinstall" id="oper_sinstall" value="25" placeholder="默认25 不许修改" readonly="true"/><span style="color:#FF0000"><?php echo $error['sinstall']; ?></span></td>
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

<!-- content ends -->

<?php
$this->load->view('ckad/footer')?>