<?php echo $this->load->view('ckad/header'); ?>

<!--<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-picture"></i>网站概况</h2>

        </div>
        <div class="box-content">        
            <table class="table table-striped table-bordered bootstrap-datatable datatable">								
                <tr>
                    <td>注册用户数：</td>
                    <td><?php echo $users_count; ?></td>
                    <td>在线人数：</td>
                    <td><?php echo $online_count; ?></td>					
                </tr>	
                <tr>
                    <td>众筹项目数：</td>
                    <td><?php echo $online_product; ?></td>
                    <td>总筹资金额：</td>
                    <td><?php echo $back_total; ?></td>					
                </tr>	
                <tr>
                    <td>筹资速度：</td>
                    <td><?php echo $back_speed; ?></td>
                    <td>支持者数量：</td>
                    <td><?php echo $backer_count; ?></td>					
                </tr>	
                <tr>
                    <td>今天最多支持项目：</td>
                    <td colspan="3">
                        <?php if (isset($products) && !empty($products)): ?>						
                            <?php foreach ($products as $key => $pro): ?>
                                <p><?php echo $pro['name']; ?><br/>--浏览量：<?php echo $pro['logs']; ?><br/>--总支持金额：<?php echo $pro['total']; ?></p>
                            <?php endforeach; ?>			
                        <?php endif; ?>	
                    </td>
                </tr>																
            </table>

        </div>
    </div>/span

</div>/row-->


<!-- content ends -->

<?php echo $this->load->view('ckad/footer');?>