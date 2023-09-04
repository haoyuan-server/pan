<?php
include("./includes/common.php");

if(!$conf['userlogin']){
    @header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('未开启登录');window.location.href='./';</script>");
}
if(isset($_GET['logout'])){
	if(!checkRefererHost())exit();
	setcookie("user_token", "", time() - 1, '/');
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}elseif(isset($_GET['act']) && $_GET['act']=='connect'){
    @header('Content-Type: application/json; charset=UTF-8');
    $type = isset($_POST['type'])?$_POST['type']:exit('{"code":-1,"msg":"no type"}');
    if(!$conf['login_apiurl'] || !$conf['login_appid'] || !$conf['login_appkey'])exit('{"code":-1,"msg":"未配置好快捷登录接口信息"}');
    $Oauth = new \lib\Oauth($conf['login_apiurl'], $conf['login_appid'], $conf['login_appkey']);
    $res = $Oauth->login($type);
    if(isset($res['code']) && $res['code']==0){
        $result = ['code'=>0, 'url'=>$res['url']];
    }elseif(isset($res['code'])){
        $result = ['code'=>-1, 'msg'=>$res['msg']];
    }else{
        $result = ['code'=>-1, 'msg'=>'快捷登录接口请求失败'];
    }
    exit(json_encode($result));
}elseif($_GET['code'] && $_GET['type'] && $_GET['state']){
	if($_GET['state'] != $_SESSION['Oauth_state']){
		sysmsg("<h2>The state does not match. You may be a victim of CSRF.</h2>");
	}
	$type = $_GET['type'];
    $typename = $type=='wx'?'微信':'QQ';
	$Oauth = new \lib\Oauth($conf['login_apiurl'], $conf['login_appid'], $conf['login_appkey']);
	$arr = $Oauth->callback();
	if(isset($arr['code']) && $arr['code']==0){
		$openid=$arr['social_uid'];
		$access_token=$arr['access_token'];
		$nickname=trim($arr['nickname']);
        if(empty($nickname) || $nickname=='-') $nickname = $typename.'用户';
		$faceimg=$arr['faceimg'];
	}elseif(isset($arr['code'])){
		sysmsg('<h3>error:</h3>'.$arr['errcode'].'<h3>msg  :</h3>'.$arr['msg']);
	}else{
		sysmsg('获取登录数据失败');
	}

    $userrow=$DB->find('user','*',['type'=>$type, 'openid'=>$openid], null, '1');
	if(!$userrow){
        if(!$DB->insert('user', [
            'type' => $type,
            'openid' => $openid,
            'nickname' => $nickname,
            'faceimg' => $faceimg,
            'enable' => 1,
            'regip' => $clientip,
            'loginip' => $clientip,
            'addtime' => 'NOW()',
            'lasttime' => 'NOW()',
        ]))sysmsg('用户注册失败 '.$DB->error());
        $uid = $DB->lastInsertId();
	}else{
        if($userrow['enable']==0){
            $_SESSION['user_block'] = true;
            sysmsg('当前用户已被禁止登录');
        }
        $uid = $userrow['uid'];
        $DB->update('user', ['loginip' => $clientip, 'lasttime'=>'NOW()'], ['uid'=>$uid]);
    }
    if($_SESSION['user_block']){
        $DB->update('user', ['enable' => 0], ['uid'=>$uid]);
        sysmsg('当前用户已被禁止登录');
    }
    if(isset($_SESSION['fileids']) && count($_SESSION['fileids'])>0){
        $ids = array_reverse($_SESSION['fileids']);
        if(count($ids) > 60){
            $ids = array_splice($ids, 0, 60);
        }
        $ids = implode(',',$ids);
        $DB->exec("UPDATE pre_file SET uid='{$uid}' WHERE id IN ({$ids}) AND uid=0");
    }
    $session=md5($type.$openid.$password_hash);
    $expiretime=time()+2592000;
    $token=authcode("{$uid}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
    ob_clean();
    setcookie("user_token", $token, time() + 2592000, '/');
    exit("<script language='javascript'>window.location.href='./';</script>");
}

$title = '用户登录';
include SYSTEM_ROOT.'header.php';
?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-2">
                    <?php echo $title ?>
                </h1>
            </div>

        </div>
    </div>
</div>
<div class="content">
    <div class="row" id="loginform">
        <?php if($conf['login_qq']){?>
        <div class="col-6 col-lg-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> QQ登录 </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:connect('qq')">
                        <div class="block-content block-content-full">
                            <div class="fs-2 fw-semibold text-danger">
                                <i class="fab fa-qq"></i>
                            </div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <p class="fw-medium fs-sm text-danger mb-0">
                                QQ登录
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php }?>
        <?php if($conf['login_wx']){?>
        <div class="col-6 col-lg-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> 微信登录 </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <a class="block block-rounded block-link-shadow text-center" href="javascript:connect('wx')">
                        <div class="block-content block-content-full">
                            <div class="fs-2 fw-semibold text-success">
                                <i class="fab fa-weixin"></i>
                            </div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <p class="fw-medium fs-sm text-success mb-0">
                                微信登录
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <div class="mb-4">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-exclamation-circle"></i> <b>重要提示</b> </h3>
                <div class="block-options">
                    <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <p class="text-muted">新用户快捷登录后会自动注册账号</p>
            </div>
        </div>
    </div>
</div>
<?php include SYSTEM_ROOT.'footer.php';?>
<script>
function connect(type){
    var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : "POST",
		url : "login.php?act=connect",
		data : {type:type},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				window.location.href = data.url;
			}else{
				layer.alert(data.msg, {icon: 7});
			}
		} 
	});
}
</script>