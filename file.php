<?php
include("./includes/common.php");

$title = '文件查看';
$is_file=true;
include SYSTEM_ROOT.'header.php';

$csrf_token = md5(mt_rand(0,999).time());
$_SESSION['csrf_token'] = $csrf_token;

$hash = isset($_GET['hash'])?$_GET['hash']:exit("<script language='javascript'>window.location.href='./';</script>");
$pwd = isset($_GET['pwd'])?$_GET['pwd']:null;
$row = $DB->getRow("SELECT * FROM pre_file WHERE hash=:hash", [':hash'=>$hash]);
if(!$row)exit("<script language='javascript'>alert('文件不存在');window.location.href='./';</script>");
$name = $row['name'];
$type = $row['type'];

$downurl = 'down.php/'.$row['hash'].'.'.$type;
if(!empty($row['pwd']))$downurl .= '&'.$row['pwd'];
$viewurl = 'view.php/'.$row['hash'].'.'.$type;

$downurl_all = $siteurl.$downurl;
$viewurl_all = $siteurl.$viewurl;

$thisurl = $siteurl.'file.php?hash='.$row['hash'];
if(!empty($pwd))$thisurl .= '&pwd='.$pwd;

if($islogin2 && $row['uid']==$uid || !$islogin2 && isset($_SESSION['fileids']) && in_array($row['id'], $_SESSION['fileids']) && strtotime($row['addtime'])>strtotime("-7 days")){
    $is_mine = true;
}

$view_type = get_view_type($type);

if($view_type == 'image'){
    $filetype = 1;
    $title = '图片查看器';
    $htmlcode = htmlspecialchars('<img src="'.$viewurl_all.'"/>');
    $ubbcode = '[img]'.$viewurl_all.'[/img]';
    $linktitle = '图片链接';
}elseif($view_type == 'audio'){
    $filetype = 2;
    $title = '音乐播放器';
    $htmlcode = htmlspecialchars('<audio id="bgmMusic" src="'.$viewurl_all.'" autoplay="autoplay" loop="loop" preload="auto"></audio>');
    $htmlcode2 = htmlspecialchars('<iframe src="'.$siteurl.'player.php?hash='.$hash.'" width="407" scrolling="no"frameborder="0"height="70"></iframe>');
    $ubbcode = '[audio=X]'.$viewurl_all.'[/audio]';
    $linktitle = '音乐链接';
}elseif($view_type == 'video'){
    $filetype = 3;
    $title = '视频播放器';
    $htmlcode = htmlspecialchars('<video id="movies" src="'.$viewurl_all.'" autobuffer="true" controls="" width="100
  %"></video>');
    $htmlcode2 = htmlspecialchars('<iframe src="'.$siteurl.'player.php?hash='.$hash.'" width="800" height="500" scrolling="no" frameborder="0"></iframe>');
    $ubbcode = '[movie=320*180]'.$viewurl_all.'[/movie]';
    $linktitle = '视频链接';
}else{
    $filetype = 0;
    $title = '文件查看';
    $htmlcode = htmlspecialchars('<a href="'.$downurl_all.'" target="_blank">'.$name.'</a>');
    $ubbcode = '[url='.$downurl_all.']'.$name.'[/url]';
    if($view_type == 'office'){
        $office_url = 'https://view.officeapps.live.com/op/view.aspx?src='.rawurlencode($downurl_all);
    }
}
?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-2">
                    <?php echo $title?>
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <?php
    if($row['pwd']!=null && $row['pwd']!=$pwd){ ?>
        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
        <title>请输入密码下载文件</title>
        <script type="text/javascript">
            var pwd=prompt("请输入密码","")
            if (pwd!=null && pwd!="")
            {
                window.location.href="./file.php?hash=<?php echo $row['hash']?>&pwd="+pwd
            }
        </script>
        请刷新页面，或[ <a href="javascript:history.back();">返回上一页</a> ]
        <?php
        exit;
    }
    ?>
    <div class="mb-4">
        <div class="block block-rounded mb-0">
            <div class="block-header block-header-default">
                <h3 class="block-title"> <?php echo $title?> </h3>
                <div class="block-options">
                    <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <?php
                if($filetype==1){
                    echo '<div class="image_view"><a href="'.$viewurl.'" title="点击查看原图"><img alt="loading" src="'.$viewurl.'" class="image"></a></div>';
                }elseif($filetype==2){
                    echo '<div class="view"><div id="aplayer"></div></div>';
                }elseif($filetype==3 && $row['block']==0){
                    echo '<div class="videoplayer"></div>';
                }elseif($filetype==3){
                    echo '
                        <div class="view">
                            <div class="elseview">
                                <div class="tubiao"><i class="fa '.type_to_icon($type).'"></i> </div>
                            </div>
                            <div class="elsetext"><p>'.$name.'</p><p>视频文件需审核通过后才能在线播放和下载，请等待审核通过！</p></div>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="view">
                            <div class="elseview">
                                <div class="tubiao"><i class="fa '.type_to_icon($type).'"></i> </div>
                            </div>
                            <div class="elsetext"><p>'.$name.'（'.size_format($row['size']).'）</p>
                                <a href="'.$downurl.'" class="btn btn-raised btn-primary btn-lg"><i class="fa fa-download" aria-hidden="true"></i> 下载文件<div class="ripple-container"></div></a>'.($view_type=='office'?'&nbsp;<a href="'.$office_url.'" class="btn btn-raised btn-info btn-lg" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> 在线预览<div class="ripple-container"></div></a>':'').'
                            </div>
                        </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="block block-rounded">
            <ul class="nav nav-tabs nav-tabs-alt" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="link-tab" data-bs-toggle="tab" data-bs-target="#link" role="tab" aria-controls="link" aria-selected="ture"><i class="fa fa-link" aria-hidden="true"></i> 文件外链</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code" role="tab" aria-controls="code" aria-selected="false"><i class="fa fa-code" aria-hidden="true"></i> 代码调用</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" role="tab" aria-controls="info" aria-selected="false"><i class="fa fa-info-circle" aria-hidden="true"></i> 文件详情</button>
                </li>
                <li class="nav-item <?php echo $is_mine?'':'hide';?>" role="presentation" >
                    <button class="nav-link" id="manager-tab" data-bs-toggle="tab" data-bs-target="#manager" role="tab" aria-controls="manager" aria-selected="false"><i class="fa fa-cog" aria-hidden="true"></i> 管理</button>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div id="myTabContent" class="tab-content" style="padding: 19px;">
                    <div class="tab-pane fade active in" id="link">
                        <div class="form-group row <?php echo $filetype==0?'hide':'';?>">
                            <label for="link1" class="col-md-2 control-label"><?php echo $linktitle?>：</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="link1" readonly="readonly" value="<?php echo $viewurl_all?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-raised copy-btn" type="button" data-clipboard-text="<?php echo $viewurl_all?>">复制<div class="ripple-container"></div></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="link2" class="col-md-2 control-label">下载链接：</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="link2" readonly="readonly" value="<?php echo $downurl_all?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-raised copy-btn" type="button" data-clipboard-text="<?php echo $downurl_all?>">复制<div class="ripple-container"></div></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="code">
                        <div class="form-group row <?php echo $filetype<2?'hide':'';?>">
                            <label for="code1" class="col-md-2 control-label">播放器代码：</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="code1" readonly="readonly" value="<?php echo $htmlcode2?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-raised copy-btn" type="button" data-clipboard-text="<?php echo $htmlcode2?>">复制<div class="ripple-container"></div></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="code2" class="col-md-2 control-label">HTML代码：</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="code2" readonly="readonly" value="<?php echo $htmlcode?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-raised copy-btn" type="button" data-clipboard-text="<?php echo $htmlcode?>">复制<div class="ripple-container"></div></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="code3" class="col-md-2 control-label">UBB代码：</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="code3" readonly="readonly" value="<?php echo $ubbcode?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-raised copy-btn" type="button" data-clipboard-text="<?php echo $ubbcode?>">复制<div class="ripple-container"></div></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="info">
                        <div class="row" align="center">
                            <table class="table table-bordered fileinfo-table">
                                <tr>
                                    <th width="97">上传者IP：</td><td width="100"><?php echo preg_replace('/\d+$/','*',$row['ip'])?></td>
                                    <th width="100">上传时间：</td><td width="168"><?php echo $row['addtime']?></td>
                                </tr>
                                <tr>
                                    <th>下载次数：</td><td><?php echo $row['count']?></td>
                                    <th>文件大小：</td><td><?php echo size_format($row['size']).' ('.$row['size'].' 字节)'?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="manager">
                        <div class="row" align="center">
                            <div class="col-md-12">
                                <input type="hidden" id="hash" name="hash" value="<?php echo $hash?>">
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $csrf_token?>">
                                <button onclick="delete_confirm()" class="btn btn-raised btn-danger"><i class="fa fa-close" aria-hidden="true"></i> 删除文件</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="block block-rounded mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title"><i class="fa fa-exclamation-circle"></i> <b>提示</b></h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="fw-medium fs-sm">
                        <div class="border-start border-4 rounded-2 border-primary mb-2">
                            <div class="rounded p-2 text-pulse-light">
                                <ul class="list-group text-dark">
                                    <li class="list-group-item"><?php echo $conf['gg_file']?></li>
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
                    <h3 class="block-title"><i class="fa fa-qrcode"></i> <b>手机扫码下载</b></h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="fw-medium fs-sm">
                        <div class="border-start border-4 rounded-2 border-primary mb-2">
                            <div class="rounded p-2 text-pulse-light">
                                <ul class="list-group text-dark">
                                    <img alt="二维码" src="//api.qrserver.com/v1/create-qr-code/?size=180x180&margin=10&data=<?php echo urlencode($thisurl);?>">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include SYSTEM_ROOT.'footer.php';?>
<?php if($filetype==2){?>
    <script type="text/javascript" src="//cdn.staticfile.org/aplayer/1.10.1/APlayer.min.js"></script>
    <script type="text/javascript">
        var ap = new APlayer({
            container: document.getElementById('aplayer'),
            loop: 'none',
            theme: '#b2dae6',
            audio: [{
                title: '<?php echo $name?>',
                author: 'none',
                url: '<?php echo $viewurl_all?>',
                cover: './assets/img/music.png',
            }]
        });
    </script>
<?php }elseif($filetype==3 && $row['block']==0){?>
    <script type="text/javascript" src="assets/js/ckplayer.min.js"></script>
    <?php if($type=='m3u8'){$plug='hls.js';?><script src="//cdn.staticfile.org/hls.js/1.2.4/hls.min.js"></script><?php }?>
    <?php if($type=='flv'||$type=='f4v'){$plug='flv.js';?><script src="//cdn.staticfile.org/flv.js/1.6.2/flv.min.js"></script><?php }?>
    <script type="text/javascript">
        var videoObject = {
            container: '.videoplayer',
            plug:'<?php echo $plug?>',
            video:'<?php echo $viewurl_all?>',
            webFull:true,
        };
        var player=new ckplayer(videoObject);
    </script>
<?php }?>
<script>
    function delete_confirm(){
        var hash = $("#hash").val();
        var csrf_token = $("#csrf_token").val();
        var confirmobj = layer.confirm('删除文件后不可恢复，确定删除吗？', {
            btn: ['确定','取消'], icon: 0
        }, function(){
            var ii = layer.load(2);
            $.ajax({
                type : 'POST',
                url : 'ajax.php?act=deleteFile',
                data : {hash:hash, csrf_token:csrf_token},
                dataType : 'json',
                success : function(data) {
                    layer.close(ii);
                    if(data.code == 0){
                        layer.alert('删除成功', {icon:1}, function(){window.location.href="./";});
                    }else{
                        layer.alert(data.msg, {icon:2});
                    }
                },
                error:function(data){
                    layer.close(ii);
                    layer.msg('服务器错误');
                }
            });
        }, function(){
            layer.close(confirmobj);
        });
    }
    $(document).ready(function(){
        var clipboard = new Clipboard('.copy-btn');
        clipboard.on('success', function (e) {
            layer.msg('复制成功！', {icon: 1});
        });
        clipboard.on('error', function (e) {
            layer.msg('复制失败，请长按链接后手动复制', {icon: 2});
        });
    })
</script>