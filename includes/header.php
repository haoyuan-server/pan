<?php
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="author" content="一个失踪的Ma.">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php echo $title?> | <?php echo $conf['title']?></title>
    <meta name="keywords" content="<?php echo $conf['keywords']?>">
    <meta name="description" content="<?php echo $conf['description']?>">
    <link rel="shortcut icon" href="/assets/oneui/media/favicon.png" type="image/x-icon">
    <!-- 框架核心样式 -->
    <link rel="stylesheet" id="css-main" href="/assets/oneui/css/oneui.min-5.6.css">
    <!-- 图片预览 -->
    <link rel="stylesheet" href="/assets/oneui/js/plugins/magnific-popup/magnific-popup.css">
    <!-- nprogress -->
    <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.css" rel="stylesheet">
    <!-- jquery -->
    <script src="/assets/oneui/js/lib/jquery.min.js"></script>
    <!-- jquery pjax-->
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <!--nprogress-->
    <script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.js"></script>
    <!-- layer -->
    <script src="/assets/oneui/js/lib/layer.min.js"></script>
    <!-- 框架核心js -->
    <script src="/assets/oneui/js/oneui.app.min-5.6.js"></script>
    <!-- 图表库 -->
    <script src="/assets/oneui/js/plugins/chart.js/chart.min.js"></script>
    <!-- 通知库 -->
    <script src="/assets/oneui/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
    <!-- 图片预览 -->
    <script src="/assets/oneui/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- 日期选择 -->
    <script src="/assets/oneui/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap-table-->
    <script src="https://cdn.bootcdn.net/ajax/libs/bootstrap-table/1.18.3/bootstrap-table.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/bootstrap-table/1.15.4/locale/bootstrap-table-zh-CN.min.js"></script>
    <!-- 引入 filter-control 插件所需的 CSS 和 JS 文件 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/extensions/filter-control/bootstrap-table-filter-control.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/extensions/filter-control/bootstrap-table-filter-control.js"></script>

    <?php if($is_file){?><link rel="stylesheet" href="//cdn.staticfile.org/aplayer/1.10.1/APlayer.min.css"><link href="assets/css/ckplayer.css" rel="stylesheet"><?php }?>
    <link href="assets/css/style.css?v=<?php echo VERSION?>" rel="stylesheet">
    <script src="//cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <!-- App核心文件 -->
    <script src="/assets/oneui/js/app.js"></script>
    <style>
        .btn-xs {
            --bs-btn-padding-y: 0.125rem;
            --bs-btn-padding-x: 0.25rem;
            --bs-btn-font-size: 0.75rem;
            /*--bs-btn-border-radius: 0.125rem;*/
        }
        .table thead th {
            text-transform: none;
        }
        tbody, td, tfoot, th, thead, tr {
            border-color: inherit;
            border-style: none;
            border-width: 0;
        }
    </style>
</head>
<body>
<div id="page-container" class="page-header-dark main-content-boxed">
    <header id="page-header">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <a class="fw-semibold fs-5 tracking-wider text-dual me-3" href="./"> <?php echo $conf['title']?> </a>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown d-inline-block me-2">
                    <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-paint-brush"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0" aria-labelledby="page-header-notifications-dropdown">
                        <ul class="nav-items mb-0">
                            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium active" data-toggle="theme" data-theme="default" href="#">
                                <span>Default</span>
                                <i class="fa fa-circle text-default"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="/assets/oneui/css/themes/amethyst.min-5.5.css" href="#">
                                <span>Amethyst</span>
                                <i class="fa fa-circle text-amethyst"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="/assets/oneui/css/themes/city.min-5.5.css" href="#">
                                <span>City</span>
                                <i class="fa fa-circle text-city"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="/assets/oneui/css/themes/flat.min-5.5.css" href="#">
                                <span>Flat</span>
                                <i class="fa fa-circle text-flat"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="/assets/oneui/css/themes/modern.min-5.5.css" href="#">
                                <span>Modern</span>
                                <i class="fa fa-circle text-modern"></i>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="/assets/oneui/css/themes/smooth.min-5.5.css" href="#">
                                <span>Smooth</span>
                                <i class="fa fa-circle text-smooth"></i>
                            </a>
                        </ul>
                    </div>
                </div>
                <div class="dropdown d-inline-block ms-2">
                    <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <main id="main-container">
        <div class="bg-primary-darker">
            <div class="bg-black-10">
                <div class="content py-1">
                    <div id="main-navigation" class="d-none d-lg-block mt-2 mt-lg-0">
                        <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover">
                            <li class="nav-main-heading">首页</li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="./">
                                    <i class="nav-main-link-icon fa fa-list"></i>
                                    <span class="nav-main-link-name">文件列表</span>
                                </a>
                            </li>
                            <li class="nav-main-heading">文件</li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="./upload.php">
                                    <i class="nav-main-link-icon fa fa-upload"></i>
                                    <span class="nav-main-link-name">上传文件</span>
                                </a>
                            </li>
                            <?php if($is_file){?>
                            <li class="nav-main-heading">查看</li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="">
                                    <i class="nav-main-link-icon fa fa-file"></i>
                                    <span class="nav-main-link-name">文件查看</span>
                                </a>
                            </li>
                            <?php }?>
                            <li class="nav-main-heading">我的</li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="./?m=mine">
                                    <i class="nav-main-link-icon fa fa-file"></i>
                                    <span class="nav-main-link-name">我的文件</span>
                                </a>
                            </li>
                            <?php if($conf['userlogin']){?>
                                <li class="nav-main-heading">登录</li>
                                <?php if($islogin2){?>
                                    <li class="nav-main-item ms-lg-auto">
                                        <a class="nav-main-link" href="./?m=mine">
                                            <i class="nav-main-link-icon fa fa-<?php echo $userrow['type']=='qq'?'qq':'wechat';?>"></i>
                                            <span class="nav-main-link-name"><?php echo $userrow['nickname']?></span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item ms-lg-auto">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                            <i class="nav-main-link-icon fa fa-<?php echo $uerrow['type']=='qq'?'qq':'wechat';?>"></i>
                                            <span class="nav-main-link-name"><?php echo $userrow['nickname']?></span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            <li class="nav-main-item">
                                                <a class="nav-main-link" href="./login.php?logout=1" onclick="return confirm('是否确定退出登录？')">
                                                    <span class="nav-main-link-name">退出登录</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php }else{?>
                                    <li class="nav-main-item ms-lg-auto">
                                        <a class="nav-main-link" href="./login.php">
                                            <i class="nav-main-link-icon fa fa-user-circle"></i>
                                            <span class="nav-main-link-name">未登录</span>
                                        </a>
                                    </li>
                                <?php }?>
                            <?php }?>
                            <li class="nav-main-heading"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
