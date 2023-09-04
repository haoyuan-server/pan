<?php
define('IN_ADMIN', true);
include("../includes/common.php");
$title='存储类型设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div id="pjax-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <?php echo $title ?>
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="./index.php">后台首页</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            系统设置
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content animated fadeIn">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"> 存储类型设置 </h3>
                <div class="block-options">
                    <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                    <div class="mb-4">
                        <label class="form-label" for="storage"><b>切换存储类型</b></label>
                        <select name="storage" class="form-select" default="<?php echo $conf['storage']?>"><option value="local">本地存储</option><option value="oss">阿里云OSS</option><option value="qcloud">腾讯云COS</option><option value="obs">华为云OBS</option><option value="upyun">又拍云</option><option value="qiniu">七牛云</option><?php if (defined('SAE_ACCESSKEY')) {?><option value="sae">SaeStorage</option><?php }?></select><font color="green">已有文件的情况下请勿随意变更，否则之前上传的文件全部无法下载</font>
                    </div>
                    <?php if($conf['storage']==oss || $conf['storage']==qcloud || $conf['storage']==obs || $conf['storage']==upyun || $conf['storage']==qiniu){?>
                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="form-label" for="uploadfile_type"><b>文件上传方式</b></label>
                                <select name="uploadfile_type" class="form-select" default="<?php echo $conf['uploadfile_type']?>"><option value="0">网站中转</option><option value="1">直接链接</option></select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="downfile_type"><b>文件下载方式</b></label>
                                <select name="downfile_type" class="form-select" default="<?php echo $conf['downfile_type']?>"><option value="0">网站中转</option><option value="1">直接链接</option></select>
                            </div>
                        </div>
                        <?php if($conf['downfile_type']==1){?>
                            <div class="row mb-4">
                                <label class="form-label">文件下载域名</label>
                                <div class="col-4">
                                    <select class="form-control" name="downfile_protocol" default="<?php echo $conf['downfile_protocol']; ?>"><option value="0">http://</option><option value="1">https://</option></select>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="downfile_domain" value="<?php echo $conf['downfile_domain']; ?>" placeholder="留空则使用云存储默认域名">
                                </div>
                                <font color="green">填写Bucket绑定的域名，也可使用CDN域名</font>
                            </div>
                        <?php }?>
                    <?php }?>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                        </button>
                    </div>
                </form>
                <div class="panel-footer">
                    <p><b>文件上传方式说明：</b>
                        <br/>网站中转：上传文件先经过本站服务器，然后上传到云存储，速度较慢。
                        <br/>直接链接：文件直接上传到云存储，不经过本站服务器，上传速度更快，支持更大文件。需要先在云存储设置跨域！</p>
                    <p><b>文件下载方式说明：</b>
                        <br/>网站中转：下载文件经过本站服务器中转，如果本机与云存储是内网连接则不消耗流量。
                        <br/>直接链接：需支付流量费用，下载速度更快。</p>
                </div>
            </div>
        </div>
    </div>
    <div id="accordion">
        <div class="content animated fadeIn">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> <a data-toggle="collapse" data-parent="#accordion" href="#stor_local" class="collapsed">本地存储</a> </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div id="stor_local" style="<?php echo $conf['storage']!='local'?'display:none;':null; ?>">
                    <div class="block-content">
                        <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                            <div class="mb-4">
                                <label class="form-label" for="filepath"><b>本地存储路径</b></label>
                                <input type="text" class="form-control form-control-lg" name="filepath" value="<?php echo $conf['filepath']; ?>" placeholder="默认存储在网站file目录"><font color="green">不填写则默认存储在网站file目录下，如需填写，只能填写以服务器根目录/开始的绝对路径。</font>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if (defined('SAE_ACCESSKEY')) {?>
        <div class="content animated fadeIn">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> <a data-toggle="collapse" data-parent="#accordion" href="#stor_sae" class="collapsed">SaeStorage</a> </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div id="stor_sae" style="<?php echo $conf['storage']!='sae'?'display:none;':null; ?>">
                    <div class="block-content">
                        <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                            <div class="mb-4">
                                <label class="form-label" for="ragename"><b>SAE Storage名称</b></label>
                                <input type="text" class="form-control form-control-lg" name="ragename" value="<?php echo $conf['ragename']; ?>" placeholder="">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <div class="content animated fadeIn">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> <a data-toggle="collapse" data-parent="#accordion" href="#stor_oss" class="collapsed">阿里云OSS</a><span class="pull-right"><a href="https://www.aliyun.com/product/oss?userCode=1cyrqim7" rel="noreferrer" target="_blank" class="btn btn-default btn-xs">开通地址</a></span> </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div id="stor_oss" style="<?php echo $conf['storage']!='oss'?'display:none;':null; ?>">
                    <div class="block-content">
                        <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                            <div class="mb-4">
                                <label class="form-label" for="oss_ak"><b>阿里云AccessKey Id</b></label>
                                <input type="text" class="form-control form-control-lg" name="oss_ak" value="<?php echo $conf['oss_ak']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="oss_sk"><b>阿里云AccessKey Secret</b></label>
                                <input type="text" class="form-control form-control-lg" name="oss_sk" value="<?php echo $conf['oss_sk']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="oss_endpoint"><b>阿里云OSS EndPoint</b></label>
                                <input type="text" class="form-control form-control-lg" name="oss_endpoint" value="<?php echo $conf['oss_endpoint']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="oss_bucket"><b>阿里云OSS Bucket</b></label>
                                <input type="text" class="form-control form-control-lg" name="oss_bucket" value="<?php echo $conf['oss_bucket']; ?>">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content animated fadeIn">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> <a data-toggle="collapse" data-parent="#accordion" href="#stor_qcloud" class="collapsed">腾讯云COS</a><span class="pull-right"><a href="https://cloud.tencent.com/act/cps/redirect?redirect=10042&cps_key=11eaac2f518cd09a6288f4b1912228b8" rel="noreferrer" target="_blank" class="btn btn-default btn-xs">开通地址</a></span> </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div id="stor_qcloud" style="<?php echo $conf['storage']!='qcloud'?'display:none;':null; ?>">
                    <div class="block-content">
                        <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                            <div class="mb-4">
                                <label class="form-label" for="qcloud_id"><b>腾讯云SecretId</b></label>
                                <input type="text" class="form-control form-control-lg" name="qcloud_id" value="<?php echo $conf['qcloud_id']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="qcloud_key"><b>腾讯云SecretKey</b></label>
                                <input type="text" class="form-control form-control-lg" name="qcloud_key" value="<?php echo $conf['qcloud_key']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="qcloud_region"><b>COS存储桶地域</b></label>
                                <input type="text" class="form-control form-control-lg" name="qcloud_region" value="<?php echo $conf['qcloud_region']; ?>" placeholder="填写英文名称，例如：ap-shanghai">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="qcloud_bucket"><b>COS存储桶名称</b></label>
                                <input type="text" class="form-control form-control-lg" name="qcloud_bucket" value="<?php echo $conf['qcloud_bucket']; ?>" placeholder="格式：BucketName-APPID">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content animated fadeIn">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> <a data-toggle="collapse" data-parent="#accordion" href="#stor_obs" class="collapsed">华为云OBS</a><span class="pull-right"><a href="https://www.huaweicloud.com/product/obs.html?fromacct=b70162c8-fbde-42ca-9f3d-5d99dc1951ba&utm_source=bmV0MjAy=&utm_medium=cps&utm_campaign=201905" rel="noreferrer" target="_blank" class="btn btn-default btn-xs">开通地址</a></span> </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div id="stor_obs" style="<?php echo $conf['storage']!='obs'?'display:none;':null; ?>">
                    <div class="block-content">
                        <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                            <div class="mb-4">
                                <label class="form-label" for="obs_ak"><b>华为云AccessKeyId</b></label>
                                <input type="text" class="form-control form-control-lg" name="obs_ak" value="<?php echo $conf['obs_ak']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="obs_sk"><b>华为云SecretAccessKey</b></label>
                                <input type="text" class="form-control form-control-lg" name="obs_sk" value="<?php echo $conf['obs_sk']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="obs_endpoint"><b>OBS EndPoint</b></label>
                                <input type="text" class="form-control form-control-lg" name="obs_endpoint" value="<?php echo $conf['obs_endpoint']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="obs_bucket"><b>OBS桶名称</b></label>
                                <input type="text" class="form-control form-control-lg" name="obs_bucket" value="<?php echo $conf['obs_bucket']; ?>">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content animated fadeIn">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> <a data-toggle="collapse" data-parent="#accordion" href="#stor_upyun" class="collapsed">又拍云</a><span class="pull-right"><a href="https://console.upyun.com/register/?invite=jUSQy3jyE" rel="noreferrer" target="_blank" class="btn btn-default btn-xs">开通地址</a></span> </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div id="stor_upyun" style="<?php echo $conf['storage']!='upyun'?'display:none;':null; ?>">
                    <div class="block-content">
                        <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                            <div class="mb-4">
                                <label class="form-label" for="upyun_name"><b>云存储服务名称</b></label>
                                <input type="text" class="form-control form-control-lg" name="upyun_name" value="<?php echo $conf['upyun_name']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="upyun_user"><b>操作员名称</b></label>
                                <input type="text" class="form-control form-control-lg" name="upyun_user" value="<?php echo $conf['upyun_user']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="upyun_pwd"><b>操作员密码</b></label>
                                <input type="text" class="form-control form-control-lg" name="upyun_pwd" value="<?php echo $conf['upyun_pwd']; ?>">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content animated fadeIn">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title"> <a data-toggle="collapse" data-parent="#accordion" href="#stor_qiniu" class="collapsed">七牛云</a><span class="pull-right"><a href="https://s.qiniu.com/j6zy63" rel="noreferrer" target="_blank" class="btn btn-default btn-xs">开通地址</a></span> </h3>
                    <div class="block-options">
                        <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div id="stor_qiniu" style="<?php echo $conf['storage']!='qiniu'?'display:none;':null; ?>">
                    <div class="block-content">
                        <form onsubmit="return saveSetting(this)" method="post" class="form-horizontal" role="form">
                            <div class="mb-4">
                                <label class="form-label" for="qiniu_ak"><b>AccessKey</b></label>
                                <input type="text" class="form-control form-control-lg" name="qiniu_ak" value="<?php echo $conf['qiniu_ak']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="qiniu_sk"><b>SecretKey</b></label>
                                <input type="text" class="form-control form-control-lg" name="qiniu_sk" value="<?php echo $conf['qiniu_sk']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="qiniu_bucket"><b>存储空间名称</b></label>
                                <input type="text" class="form-control form-control-lg" name="qiniu_bucket" value="<?php echo $conf['qiniu_bucket']; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="qiniu_domain"><b>空间绑定域名</b></label>
                                <input type="text" class="form-control form-control-lg" name="qiniu_domain" value="<?php echo $conf['qiniu_domain']; ?>">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check opacity-50 me-1"></i> <b>保存设置</b>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'foot.php';?>
<script>
    var items = $("select[default]");
    for (i = 0; i < items.length; i++) {
        $(items[i]).val($(items[i]).attr("default")||0);
    }
    $('#stor_'+$("select[name='storage']").val()).collapse('show');
    $("select[name='storage']").change();
    function checkURL(obj)
    {
        var url = $(obj).val();
        if (url.indexOf(" ")>=0){
            url = url.replace(/ /g,"");
        }
        if (url.indexOf("，")>=0){
            url = url.replace(/，/g,",");
        }
        if (url.toLowerCase().indexOf("http://")==0){
            url = url.slice(7);
        }
        if (url.toLowerCase().indexOf("https://")==0){
            url = url.slice(8);
        }
        if (url.slice(url.length-1)=="/"){
            url = url.slice(0,url.length-1);
        }
        $(obj).val(url);
    }
    function saveSetting(obj){
        if($("input[name='downfile_domain']").length>0 && $("input[name='downfile_domain']").val()!=''){
            checkURL("input[name='downfile_domain']");
        }
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : 'POST',
            url : 'ajax.php?act=set',
            data : $(obj).serialize(),
            dataType : 'json',
            success : function(data) {
                layer.close(ii);
                if(data.code == 0){
                    layer.alert('设置保存成功！', {
                        icon: 1,
                        closeBtn: false
                    }, function(){
                        window.location.reload()
                    });
                }else{
                    layer.alert(data.msg, {icon: 2})
                }
            },
            error:function(data){
                layer.msg('服务器错误');
                return false;
            }
        });
        return false;
    }
</script>