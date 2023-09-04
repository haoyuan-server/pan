<?php
define('IN_ADMIN', true);
include("../includes/common.php");
$title='彩虹外链网盘管理中心';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<?php
$mysqlversion=$DB->getColumn("select VERSION()");
$checkupdate = '//auth.cccyun.cc/app/pan.php?ver='.VERSION;
?>
<div id="pjax-container">
    <div class="content animated fadeIn">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">
                    <?php echo $conf['title']?>
                </h1>
                <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                    Welcome <a class="fw-semibold" href="javascript:void(0)"><?php echo $conf['admin_user']; ?></a>, everything looks great.
                </h2>
            </div>
            <div class="mt-3 mt-md-0 ms-md-3 space-x-1">
                <a class="btn btn-sm btn-alt-secondary space-x-1" data-pjax href="./file.php">
                    <i class="fa fa-cloud opacity-50"></i>
                    <span>文件列表</span>
                </a>
                <a class="btn btn-sm btn-alt-secondary space-x-1" data-pjax href="./user.php">
                    <i class="fa fa-users opacity-50"></i>
                    <span>用户列表</span>
                </a>
            </div>
        </div>
    </div>
    <div class="content animated fadeIn">
        <div class="row items-push">
            <div class="col-sm-12 col-xxl-12">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold"><?php echo $date ?></dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">实时时间</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-clock fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" data-pjax href="https://www.baidu.com/s?ie=utf-8&f=3&rsv_bp=1&rsv_idx=1&tn=baidu&wd=%E5%8C%97%E4%BA%AC%E6%97%B6%E9%97%B4&fenlei=256&rsv_pq=0xe6c613fc0012848f&rsv_t=47732m6160ybVthifYOHqzCkYzBMMNSOZygvkXLL39dqfxZa6LJD9uHd%2BBVr&rqlang=en&rsv_enter=1&rsv_dl=ts_0&rsv_sug3=16&rsv_sug1=14&rsv_sug7=100&rsv_sug2=1&rsv_btype=i&prefixsug=beijingshijian&rsp=0&inputT=7004&rsv_sug4=8902">
                            <span>北京时间</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold" id="count1">0</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">文件上传总数</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-cloud fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" data-pjax href="./file.php">
                            <span>查看详情</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold" id="count2">0</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">今日上传文件</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-cloud-upload fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" data-pjax href="./file.php">
                            <span>查看详情</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold" id="count3">0</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">昨日上传文件</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-inbox fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" data-pjax href="./file.php">
                            <span>查看详情</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold" id="count4">0</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">用户总共数量</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-users fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" data-pjax href="./user.php">
                            <span>查看详情</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content animated fadeIn">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="block block-rounded mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><b>服务器信息</b></h3>
                        <div class="block-options">
                            <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full" data-toggle="slimscroll" data-height="259px">
                        <div class="fw-medium fs-sm">
                            <div class="border-start border-4 rounded-2 border-primary mb-2">
                                <div class="rounded p-2 text-pulse-light">
                                    <ul class="list-group text-dark">
                                        <li class="list-group-item"><b>PHP 版本：</b><?php echo phpversion() ?><?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?></li>
                                        <li class="list-group-item"><b>MySQL 版本：</b><?php echo $mysqlversion ?></li>
                                        <li class="list-group-item"><b>WEB软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?></li>
                                        <li class="list-group-item"><b>服务器时间：</b><?php echo $date ?></li>
                                        <li class="list-group-item"><b>POST许可：</b><?php echo ini_get('post_max_size'); ?></li>
                                        <li class="list-group-item"><b>文件上传许可：</b><?php echo ini_get('upload_max_filesize'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="block block-rounded mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><b>系统信息</b></h3>
                        <div class="block-options">
                            <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full" data-toggle="slimscroll" data-height="259px">
                        <div class="fw-medium fs-sm">
                            <div class="border-start border-4 rounded-2 border-primary mb-2">
                                <div class="rounded p-2 text-pulse-light">
                                    <ul class="list-group text-dark" id="checkupdate"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="block block-rounded mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><b>模板信息</b></h3>
                        <div class="block-options">
                            <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full" data-toggle="slimscroll" data-height="259px">
                        <div class="fw-medium fs-sm">
                            <div class="border-start border-4 rounded-2 border-primary mb-2">
                                <div class="rounded p-2 text-pulse-light">
                                    <ul class="list-group text-dark">
                                        <li class="list-group-item"><font color="green">您使用的已是最新版本！</font></li>
                                        <li class="list-group-item">模板版本：V1.0.1 (Build 1001) 适配系统版本：V5.4 (Build 1531)</li>
                                        <li class="list-group-item">Powered by 一个失踪的Ma.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><b>快捷按键</b></h3>
                        <div class="block-options">
                            <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="block-content block-content-full">
                            <div class="py-3 text-center">
                                <div class="mb-3">
                                    <i class="fa fa-folder-open fa-4x text-primary"></i>
                                </div>
                                <div class="fs-4 fw-semibold">现在去查看文件列表</div>
                                <div class="pt-3">
                                    <a class="btn btn-alt-primary" href="./file.php">
                                        <i class="fa fa-folder-open opacity-50 me-1"></i> <b>文件列表</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><b>快捷按键</b></h3>
                        <div class="block-options">
                            <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="block-content block-content-full">
                            <div class="py-3 text-center">
                                <div class="mb-3">
                                    <i class="fa fa-users fa-4x text-primary"></i>
                                </div>
                                <div class="fs-4 fw-semibold">现在去查看用户列表</div>
                                <div class="pt-3">
                                    <a class="btn btn-alt-primary" href="./user.php">
                                        <i class="fa fa-users opacity-50 me-1"></i> <b>用户列表</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'foot.php';?>
<script>
$(document).ready(function(){
    $.ajax({
        type : "GET",
        url : "ajax.php?act=getcount",
        dataType : 'json',
        async: true,
        success : function(data) {
            $('#count1').html(data.count1);
            $('#count2').html(data.count2);
            $('#count3').html(data.count3);
            $('#count4').html(data.count4);
            $.ajax({
                url: '<?php echo $checkupdate?>',
                type: 'get',
                dataType: 'jsonp',
                jsonpCallback: 'callback'
            }).done(function(data){
                $("#checkupdate").html(data.msg);
            })
        }
    })
})
</script>
<script>
function speedModeNotice(){
    var ua = window.navigator.userAgent;
    if(ua.indexOf('Windows NT')>-1 && ua.indexOf('Trident/')>-1){
        var html = "<div class=\"panel panel-default\"><div class=\"panel-body\">当前浏览器是兼容模式，为确保后台功能正常使用，请切换到<b style='color:#51b72f'>极速模式</b>！<br>操作方法：点击浏览器地址栏右侧的IE符号<b style='color:#51b72f;'><i class='fa fa-internet-explorer fa-fw'></i></b>→选择“<b style='color:#51b72f;'><i class='fa fa-flash fa-fw'></i></b><b style='color:#51b72f;'>极速模式</b>”</div></div>";
        $("#browser-notice").html(html)
    }
}
speedModeNotice();
</script>