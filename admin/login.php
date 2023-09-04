<?php
/**
 * 登录
**/
$verifycode = 1;//验证码开关

if(!function_exists("imagecreate") || !file_exists('code.php'))$verifycode=0;
define('IN_ADMIN', true);
include("../includes/common.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
	if(!$_SESSION['pass_error'])$_SESSION['pass_error']=0;
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
	$code=daddslashes($_POST['code']);
	if ($verifycode==1 && (!$code || strtolower($code) != $_SESSION['vc_code'])) {
		unset($_SESSION['vc_code']);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('验证码错误！');history.go(-1);</script>");
	}elseif($_SESSION['pass_error']>5) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}elseif($user==$conf['admin_user'] && $pass==$conf['admin_pwd']) {
		$session=md5($user.$pass.$password_hash);
		$expiretime=time()+2592000;
		$token=authcode("{$user}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		ob_clean();
		setcookie("admin_token", $token, time() + 2592000);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('登陆管理中心成功！');window.location.href='./';</script>");
	}else {
		$_SESSION['pass_error']++;
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}
}elseif(isset($_GET['logout'])){
	setcookie("admin_token", "", time() - 2592000);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='./login.php';</script>");
}elseif($islogin==1){
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}
$title='管理员登录';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>管理员登录 | <?php echo $conf['title']?></title>
    <link rel="shortcut icon" href="../assets/oneui/media/favicon.png" type="image/x-icon">
    <link rel="stylesheet" id="css-main" href="../assets/oneui/css/oneui.min-5.6.css">
</head>
<body>
<div id="page-container">
    <main id="main-container">
        <div class="hero-static d-flex align-items-center">
            <div class="content">
                <div class="row justify-content-center push">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="block block-rounded mb-0">
                            <div class="block-content">
                                <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                                    <h1 class="h2 mb-1"><?php echo $conf['title']?></h1>
                                    <p class="fw-medium text-muted">欢迎登录，今天是个不错的日子</p>
                                    <form class="form-horizontal" method="post">
                                        <div class="py-3">
                                            <div class="mb-4">
                                                <input type="text" name="user" class="form-control form-control-alt form-control-lg"  placeholder="管理员账号">
                                            </div>
                                            <div class="mb-4">
                                                <input type="password" name="pass" class="form-control form-control-alt form-control-lg" placeholder="管理员密码" autocomplete>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6 col-xl-5">
                                                <button type="submit" id="submit" class="btn w-100 btn-alt-primary">
                                                    <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> 登录
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fs-sm text-muted text-center">
                    <strong><?php echo $conf['title']?></strong> © <span data-toggle="year-copy" class="js-year-copy-enabled">2023</span>
                </div>
            </div>
        </div>
    </main>
</div>
<!-- jquery -->
<script src="../assets/oneui/js/lib/jquery.min.js"></script>
<!-- jquery pjax-->
<script src="https://cdn.bootcdn.net/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<!--nprogress-->
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.js"></script>
<!-- layer -->
<script src="../assets/oneui/js/lib/layer.min.js"></script>
<!-- 框架核心js -->
<script src="../assets/oneui/js/oneui.app.min-5.6.js"></script>
<!-- 图表库 -->
<script src="../assets/oneui/js/plugins/chart.js/chart.min.js"></script>
<!-- 通知库 -->
<script src="../assets/oneui/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<!-- App核心文件 -->
<script src="../assets/oneui/js/app.js"></script>