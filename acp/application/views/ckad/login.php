<?php $this->load->view('ckad/header');?>
<div class="row-fluid">
    <div class="well span5 center login-box">
        <div class="alert alert-info">
            登陆
        </div>
        <form class="form-horizontal" action="login" method="post">
            <?php if (isset($error['login_error']) && !empty($error['login_error'])): ?><p style="color:red"><?php echo $error['login_error']; ?></p><?php endif; ?>
            <table width="100%">
                <tr>
                    <td width="55px">邮箱: </td>
                    <td>
                        <div class="input-prepend" title="Username" data-rel="tooltip">
                            <span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="loginname" id="loginname" type="text" value="<?php echo isset($data['loginname']) ? $data['loginname'] : ''; ?>" /><span style="color:red"><?php echo isset($error['loginname']) ? $error['loginname'] : ''; ?></span>
                    </td>
                </tr>
                <tr>
                    <td width="55px">密码: </td>
                    <td>
                        <div class="input-prepend" title="Username" data-rel="tooltip">
                            <span class="add-on"><i class="icon-lock"></i></span><input autofocus class="input-large span10" name="password" id="password" type="password" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>" /><span style="color:red"><?php echo isset($error['password']) ? $error['password'] : ''; ?></span>
                    </td>
                </tr>		
                <tr>
                    <td></td>
                    <td>							
                        <br/>
                        <p class="center span5">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </p>									
                    </td>
                </tr>					
            </table>
        </form>
    </div><!--/span-->
</div><!--/row-->
<!-- content ends -->

<?php $this->load->view('ckad/footer');?>