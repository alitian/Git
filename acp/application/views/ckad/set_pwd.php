<?php  $this->load->view('ckad/header'); ?>
<?php if (isset($error) && $error): ?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Warning!</strong> <?= $error; ?>
    </div>
<?php endif; ?>
<?php if (isset($ok) && $ok): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Well done!</strong> <?= $ok; ?>
    </div>
<?php endif; ?>
    <form class="form-horizontal" method="POST" action="set_pwd" style="display:block">
        <div class="control-group">
            <label class="control-label" for="inputPassword">老密碼</label>
            <div class="controls">
                <input type="password" id="old_pwd" name="old_pwd" placeholder="老密码">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputPassword">新密码</label>
            <div class="controls">
                <input type="password" id="new_pwd" name="new_pwd" placeholder="新密码">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputPassword">确认密码</label>
            <div class="controls">
                <input type="password" id="cnew_pwd" name="cnew_pwd" placeholder="确认密码">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn">修改</button>
            </div>
        </div>
    </form>    

<?php echo $this->load->view('ckad/footer'); ?>