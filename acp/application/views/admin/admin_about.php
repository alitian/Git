<?php $this->load->view('ckad/header') ?>
<div class="easyui-panel" title="权限项目管理" style="width:auto;height:500px;padding:1px;">
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'west',split:true" style="width:500px;padding:10px;">
            <table title="权限树" class="easyui-treegrid" style="width:350;height:400px"
                   data-options="
                   url: '/admin_manage/ajax_pw_tree',
                   method: 'get',
                   rownumbers: true,
                   idField: 'id',
                   treeField: 'text'
                   ">
                <thead>
                    <tr>
                        <th data-options="field:'text'">名称</th>
                        <th data-options="field:'operation'" align="center">操作</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div data-options="region:'center'" style="width:50%;padding:10px">
            <div style="padding:10px 60px 20px 60px">
                <form id="ff" class="easyui-form" method="post" action='' data-options="novalidate:true">
                    <table cellpadding="5">
                        <tr>
                            <td width="100">上级菜单:</td>
                            <td>
                                <select name="pid">
                                    <option value="0">主菜单</option>
                                    <?php foreach ($list as $item): ?>
                                        <option value="<?= $item['id']; ?>" <?php
                                        if (isset($edit_data['pid']) && $edit_data['pid'] == $item['id']) {
                                            echo 'selected';
                                        }
                                        ?>><?= $item['name']; ?></option>
                                            <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>权限名称:</td>
                            <td><input class="easyui-textbox" type="text" name="name" value='<?= $edit_data['name'] ?>' data-options="required:true"></input></td>
                        </tr>
                        <tr>
                            <td>Controller:</td>
                            <td><input class="easyui-textbox" type="text" name="controller" value='<?= $edit_data['controller'] ?>' data-options=""></input></td>
                        </tr>
                        <tr>
                            <td>Action:</td>
                            <td><input class="easyui-textbox" type="text" name="action" value='<?= $edit_data['action'] ?>' data-options=""></input></td>
                        </tr>
                        <tr>
                            <td>菜单中显示:</td>
                            <td><input class="easyui-textbox" type="checkbox" name="if_show" <?php echo $edit_data['if_show'] == '1' ? 'checked' : ''; ?> value='1' /> 显示</td>
                        </tr>
                        <tr>
                            <td>附加URI(注:此处用于填写没有实质页面的，例如ajax或者保存跳转请求的action【举例:admin_manage:ajax_pw_tree】):</td>
                            <td><textarea class="easyui-textbox" type="text" name="plus_uri" data-options=""><?= $edit_data['plus_uri'] ?></textarea></td>
                        </tr>
                    </table>
                </form>
                <div style="text-align:center;padding:5px">
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Submit</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function submitForm() {
        $('#ff').submit();
    }
    function clearForm() {
        $('#ff').form('clear');
    }
</script>
<?php $this->load->view('ckad/footer') ?>