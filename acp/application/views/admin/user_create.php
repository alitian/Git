<?php $this->load->view('ckad/header') ?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>系统管理员</h2>

        </div>
        <div class="box-content">   
            <div class="row-fluid">
                <div class="well span5 center login-box">
                    <div>		  
                        <form class="form-horizontal" action="create_useradmin" method="post" >                         
                            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <tr>
                                    <td><span style="color:#FF0000"><?php echo $error['if_have']; ?></span></td>
                                </tr>                              
                                <tr>
                                    <td>用户名：<input type="text" name="name" id="name" value="<?php echo $data['user_name']; ?>" dataType="Require" msg="请填写用户名"/><span style="color:#FF0000"><?php echo $error['user_name']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>邮箱：<input type="text" name="email" id="email" value="<?php echo $data['user_email']; ?>" dataType="Email" msg="邮箱格式有误"/><span style="color:#FF0000"><?php echo $error['user_email']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>初始密码：<input type="password" name="password" id="password" value="<?php echo $data['user_password']; ?>" dataType="Limit" min="6" autocomplete="off" msg="最少6个字符" /><span style="color:#FF0000"><?php echo $error['user_password']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>管理员类型：<input type="radio" name="type[]" id="super_admin" value="1"  <?php if (isset($data['user_type']) && $data['user_type'] == 1): ?> checked="checked"<?php endif; ?>/>Admin管理员 <input type="radio" name="type[]" id="admin" value="2" <?php if (isset($data['user_type']) && $data['user_type'] == 2): ?> checked="checked"<?php endif; ?>/>普通管理员
                                        <span style="color:red" align="center"><?php echo isset($error['user_type']) ? '<br/>' . $error['user_type'] : ''; ?></span>								
                                    </td>
                                </tr>
                                <tr>
                                    <td>管理员权限组：
                                        <select id="group" name="group">
                                            <option value=""></option>
                                            <?php foreach($group as $k=>$row){?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['group_name']?></option>
                                            <?php }?>
                                        </select>
                                        <span style="color:red" align="center"><?php echo isset($error['admin_group']) ? '<br/>' . $error['admin_group'] : ''; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p><input class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit" value="保存"/>&nbsp;&nbsp;<a href="user_group_manage" class="btn btn-primary" >取消</a></p></td>
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