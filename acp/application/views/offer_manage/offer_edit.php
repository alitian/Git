<?php $this->load->view('ckad/header') ?>
<script type="text/javascript" src="/static/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap-switch.min.css">
<script type="text/javascript" src="<?= static_url(); ?>js/own/judgment.js"></script>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>编辑广告</h2>
        </div>
        <div class="box-content">   
            <div class="row-fluid">
                <div class="well center login-box">
                    <div>		  
                        <form class="form-horizontal" name="form1" action="" method="post" >                         
                            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <tr>
                                    <span style="color:#FF0000"><?php echo $error['if_have']; ?></span>
                                </tr>
                                <tr>
                                    <td>广告name：
                                        <input type="text" name="name" id="name" value="<?php echo $offer_mes['name'];?>" placeholder="不能包含中文与中文符号" />
                                        <span style="color:#FF0000"><?php echo $error['name']; ?></span>
                                    </td>
                                    <td>打开状态：
                                        <select id="status" name="status" value="<?php echo $offer_mes['status'];?>">
                                            <option value="<?php echo $offer_mes['status'];?>"><?php echo $offer_mes['status_name'];?></option>
                                            <option value="-1">下架</option>
                                            <option value="0">上线</option>
                                            <option value="1">页面修改失败</option>
                                            <option value="2">没有下载地址</option>
                                        </select>
                                        <span style="color:#FF0000"><?php echo $error['status']; ?></span> 
                                    </td>                                 
                                </tr>
                                <tr>                                  
                                    <td>广告类型：
                                        <select id="type" name="type" value="<?php echo $offer_mes['type'];?>">
                                            <option value="<?php echo $offer_mes['type'];?>"><?php echo $offer_mes['type_name'];?></option>
                                            <option value="1">Apk Offer</option>
                                            <option value="3">Affliate Offer</option>
                                        </select>
                                        <span style="color:#FF0000"><?php echo $error['type']; ?></span> 
                                    </td>
                                    <td>adid(o_ad.id):
                                        <input type="text" name="adid" id="adid" value="<?php echo $offer_mes['adid'];?>" placeholder="int整型"/>
                                        <span style="color:#FF0000"><?php echo $error['adid']; ?></span>                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td>pullratio：
                                        <input type="text" name="pullratio" id="pullratio" value="<?php echo $offer_mes['pullratio'];?>" placeholder="int整型" />
                                        <span style="color:#FF0000"><?php echo $error['pullratio']; ?></span>
                                    </td>
                                    <td>广告联盟（provider）：
                                        <input type="text" name="provider" id="provider" value="<?php echo $offer_mes['provider'];?>" placeholder="int整型" />
                                        <span style="color:#FF0000"><?php echo $error['provider']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>权重weight：
                                        <input type="text" name="weight" id="weight" value="<?php echo $offer_mes['weight'];?>"  placeholder="int整型" />
                                        <span style="color:#FF0000"><?php echo $error['weight']; ?></span>
                                    </td>
                                    <td>预权重pre_weight：
                                        <input type="text" name="pre_weight" id="pre_weight" value="<?php echo $offer_mes['preweight'];?>"  placeholder="int整型" />
                                        <span style="color:#FF0000"><?php echo $error['pre_weight']; ?></span>
                                    </td>     
                                </tr>
                                <tr>
                                    <td>包名（pkg）：
                                        <input type="text" name="pkg" id="pkg" value="<?php echo $offer_mes['pkg'];?>"  placeholder="不能包含中文与中文符号" />
                                        <span style="color:#FF0000"><?php echo $error['pkg']; ?></span>
                                    </td>
                                    <td>Apk地址（apk）：
                                        <input type="text" name="apk" id="apk" value="<?php echo $offer_mes['apk'];?>"  placeholder="不能包含中文与中文符号" />
                                        <span style="color:#FF0000"><?php echo $error['apk']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>推广国家：
                                        <input type="text" name="country" id="country" value="<?php echo $offer_mes['country'];?>"  placeholder="ALL" />
                                        <span style="color:#FF0000"><?php echo $error['country']; ?></span>
                                    </td>
                                    <td>非推广国家：
                                        <input type="text" name="ecountry" id="ecountry" value="<?php echo $offer_mes['ecountry'];?>"  placeholder="" />
                                        <span style="color:#FF0000"><?php echo $error['ecountry']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>文件大小（mainicon）：
                                        <input type="text" name="mainicon" id="mainicon" value="<?php echo $offer_mes['mainicon'];?>"  placeholder="int整形" />
                                        <span style="color:#FF0000"><?php echo $error['mainicon']; ?></span>
                                    </td>
                                    <td>不可卸载率（sinstall）：
                                        <input type="text" name="sinstall" id="sinstall" value="<?php echo $offer_mes['sinstall'];?>"  placeholder="int整形" />
                                        <span style="color:#FF0000"><?php echo $error['sinstall']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p><input class="btn btn-primary" type="submit" name="btnSubmit" id="btnSubmit" value="保存"/>&nbsp;&nbsp;<a href="offer_optimization" class="btn btn-primary" >取消</a></p></td>
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
<script>
    $(function() {
       $("#btnSubmit").click(function(){
           var name = $('#name').val();
           var pkg = $('#pkg').val();
           var apk = $('#apk').val();
           if(if_have_chinese(name,'name')){
               return false;
           }
           if(if_have_chinese(pkg,'pkg')){
               return false;
           }
           if(if_have_chinese(apk,'apk')){
               return false;
           }
            $('form1').action='edit_offer?id=<?php echo $offer_mes['id'];?>';
            $('form1').submit();
       });
    });
</script>
<?php
$this->load->view('ckad/footer')?>