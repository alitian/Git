<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>网站管理后台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
        <meta name="author" content="Muhammad Usman">
        <link id="bs-css" href="<?= static_url(); ?>css/bootstrap-cerulean.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }
            * {word-break:break-all; word-wrap:break-word;}
        </style>

        <script src="<?= static_url(); ?>js/jquery.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?= static_url(); ?>js/easyui/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="<?= static_url(); ?>js/easyui/icon.css">
        <link rel="stylesheet" type="text/css" href="<?= static_url(); ?>css/header.css">
        <script type="text/javascript" src="<?= static_url(); ?>js/easyui/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="<?= static_url(); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var menuParent = $('.menu > .ListTitlePanel > div');//获取menu下的父层的DIV
                var menuList = $('.menuList');
                $('.menu > .menuParent > .ListTitlePanel > .ListTitle').each(function(i) {//获取列表的大标题并遍历
                    $(this).click(function() {
                        if ($(menuList[i]).css('display') == 'none') {
                            $(menuList[i]).slideDown(300);
                        }
                        else {
                            $(menuList[i]).slideUp(300);
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>				
                </div>
            </div>
        </div> 

        <div class="container-fluid">
            <div class="row-fluid">			
                <div class="span2 main-menu-span">
                    <?php if ($_SESSION['admin_id']): ?>
                        <div class="leftMenu">
                            <div class="menu nav nav-list">
                                <div class="menuParent">
                                    <div class="ListTitlePanel">
                                        <div class="ListTitle">
                                            <strong>个人中心</strong>
                                            <div class="leftbgbt"> </div>
                                        </div>
                                    </div>
                                    <div class="menuList">
                                        <div> <a href="<?= base_url(); ?>welcome/logout">退出登录 </a> </div>
                                        <div> <a href="<?= base_url(); ?>welcome/set_pwd">修改密碼</a></div>
                                    </div>
                                </div> 
                                <?php $arr_menu = $this->offer_m->md_admin_menu();foreach ($arr_menu as $menu_item): ?>
                                    <div class="menuParent ">
                                        <div class="ListTitlePanel">
                                            <div class="ListTitle">
                                                <strong><?= $menu_item['name']; ?></strong>
                                                <div class="leftbgbt"> </div>
                                            </div>
                                        </div>
                                        <div class="menuList">
                                            <?php foreach ($menu_item['children'] as $children_item): ?> 
                                                <?php if (stripos($_SESSION['power_ids'], ",{$children_item['id']},") !== false && $children_item['if_show'] == '1'): ?>
                                                    <div> <a href="<?= $children_item['uri']; ?>"><?= $children_item['name']; ?></a> </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>                    
                    <?php endif; ?>
                </div>

                <div id="content" class="span10">
                    <!-- content starts -->
