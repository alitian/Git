<?php $this->load->view('ckad/header') ?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>渠道添加</h2>
        </div>
        <div>		  
            <form class="form-horizontal" name="form1" action="" method="post" >                         
                <div class="span10">
                    <div class="row-fluid"> 
                        <div>渠道名称(name):<br />
                            <input type="text" id='name' name='name' value="" placeholder="渠道名称" /> 
                            <a href="javascript:;" id="select_nums" class="btn btn-info" style="margin-left:20px">点击查询</a>
                        </div>                                 
                    </div> 
                    <div id="show_channel" style="display:none;border:1px dashed #CACACA;border-radius: 5px;margin-top:30px">
                        <div class="row-fluid" style="margin:35px"> 
                            <div class="span4">已存在的最大下标:<br />
                                <input type="text" id='channel_name' name='channel_name' value="" readonly="true"/> 
                            </div>
                            <div class="span4">想要添加的数量:<br />
                                <input type="text" id='add_nums' name='add_nums' value=""/> 
                            </div>
                            <div class="span4">SDK选择:<br />
                                <select id="sdk" name="sdk" value="" onchange="getSdkMes();">
                                    <option value=""></option>
                                    <?php foreach ($sdk_mes as $key => $row) { ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div id="show_sdk" style="display:none;border:1px dashed #CACACA;border-radius: 5px;margin-top:30px">
                        <div class="row-fluid" style="margin:35px"> 
                            <div class="span4">update_pack:<br />
                                <input type="text" id='update_pack' name='update_pack' value=""  readonly="true"/> 
                            </div>
                            <div class="span4">update_ver:<br />
                                <input type="text" id='update_ver' name='update_ver' value="" readonly="true"/> 
                            </div>
                            <div class="span4">update_downurl_1:<br />
                                <input type="text" id='update_downurl_1' name='update_downurl_1' value=""  readonly="true"/> 
                            </div>
                        </div>
                        <div class="row-fluid" style="margin:35px"> 
                            <div class="span4">update_memo:<br />
                                <input type="text" id='update_memo' name='update_memo' value=""  readonly="true"/> 
                            </div>
                            <div class="span4">private_json:<br />
                                <input type="text" id='private_json' name='private_json' value=""  readonly="true"/> 
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="" style="clear:both;margin-top:30px">                 
                    <button class="btn btn-primary" id="btn_search" name="btn_search">确认并添加</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                </div>
            </form>
        </div>
    </div><!--/span-->

</div><!--/row-->
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
<script>
    $(document).ready(function() {
        $('#select_nums').click(function() {
            var channel_name = $('#name').val();
            $.ajax({
                type: "POST",
                traditional: true,
                url: "/channel_manage/ajax_channel_nums",
                dataType: "json",
                data: {
                    channel_name: channel_name,
                },
                success: function(data) {                          
                    if (data.status == 1) {
                        $('#channel_name').val(data.channel_name);
                        $('#show_channel').css('display','block');
                    }
                }
            });
        });
        
        $('#btn_search').click(function(){
            var sel_name = $('#name').val();
            var add_nums = $('#add_nums').val();
            var sdk = $('#sdk').val();
            if(sel_name.length ==0 || sel_name == ''){
                alert('请填写要添加的初始渠道名称');
                 return false;
            }
            if(add_nums.length ==0 || add_nums=='' || add_nums ==0){
                alert('请输入要添加的数量');
                return false;
            }else{
                if (if_num(add_nums, 'add_nums')) {
                    return false;
                }
            }
            if(sdk.length ==0 || sdk == ''){
                 alert('请选择要使用的sdk');
                 return false;
            }
            $('form1').action='create_channel';
            $('form1').submit();
        });
    });
    function getSdkMes() {
        var sdk_id = $('#sdk').val();
        if(sdk_id == ''){
            $('#update_pack').val('');
            $('#update_ver').val('');
            $('#update_downurl_1').val('');
            $('#update_memo').val('');                  
            $('#show_sdk').css('display','none');
        }else{
            $.ajax({
                type: "POST",
                traditional: true,
                url: "/channel_manage/ajax_sdk_mes",
                dataType: "json",
                data: {
                    sdk_id: sdk_id,
                },
                success: function(data) { 
                    if(data.status == -1){
                        alert('数据异常，请稍后再试');
                        return false;
                    }
                    if (data.status == 1) {
                        $('#update_pack').val(data.sdk_mes.update_pack);
                        $('#update_ver').val(data.sdk_mes.update_ver);
                        $('#update_downurl_1').val(data.sdk_mes.update_downurl_1);
                        $('#update_memo').val(data.sdk_mes.update_memo); 
                        $('#private_json').val(data.sdk_mes.private_json); 
                        $('#show_sdk').css('display','block');
                    }
                }
            });            
        }
    }
</script>
<!-- content ends -->

<?php
$this->load->view('ckad/footer')?>