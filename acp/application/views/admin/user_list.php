<?php $this->load->view('ckad/header') ?>


<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>系统管理员</h2>

        </div>
        <div class="box-content"> 
            <?php if (isset($_SESSION['save_message']) && !empty($_SESSION['save_message'])): ?>
                <?php echo $_SESSION['save_message'];
                unset($_SESSION['save_message']); ?>
            <?php endif; ?>
            <p align="right"><?php if ($_SESSION['admin_type'] == 1){?><a class="btn btn-primary"  href="create_useradmin">添加管理员</a><?php }?></p>
            <table class="table table-striped table-bordered bootstrap-datatable datatable">								
                <tr>
                    <td>用户名</td>
                    <td>邮箱</td>
                    <td>类型</td>
                    <td>操作</td>
                </tr>		
                <?php if (isset($data) && !empty($data)): ?>
                    <?php foreach ($data as $d): ?>
                        <tr>
                            <td><?php echo $d['user_name']; ?></td>
                            <td><?php echo $d['user_email']; ?></td>
                            <td><?php echo $d['type_text']; ?></td>
                            <td>
                                <?php if ($_SESSION['admin_type'] == 1){?>
                                <a href="user_edit/<?php echo $d['id']; ?>">编辑</a> | <a href="user_delete/<?php echo $d['id']; ?>" onclick="return confirm('确认删除?');">删除</a>
                                <?php }else{ ?>
                                        普通权限无允许操作
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">没有管理员</td>
                    </tr>
                <?php endif; ?>													
            </table>
            <div style="clear:both">
                <br/>
                <?php if (isset($pagination)): ?>
                    <?php echo $pagination; ?>
                <?php endif; ?>
            </div>						

        </div>
    </div><!--/span-->

</div><!--/row-->


<!-- content ends -->

<?php
$this->load->view('ckad/footer')?>