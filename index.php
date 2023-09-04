<?php
if (version_compare(PHP_VERSION, '7.1.0', '<')) {
    die('require PHP >= 7.1 !');
}
include("./includes/common.php");

if(isset($_GET['m']) && $_GET['m']=='mine'){
    $title = '我的文件';
    $htext = '我上传的文件';
    if($islogin2){
        $sql = " uid='{$uid}'";
    }else{
        if($conf['userlogin']==1){
            $htext .= '<span class="text-muted" style="font-size:16px">（根据浏览器缓存记录，<a href="login.php">登录</a>后可永久保留记录）</span>';
        }else{
            $htext .= '<span class="text-muted" style="font-size:16px">（根据浏览器缓存记录）</span>';
        }
        if(isset($_SESSION['fileids']) && count($_SESSION['fileids'])>0){
            $ids = array_reverse($_SESSION['fileids']);
            if(count($ids) > 60){
                $ids = array_splice($ids, 0, 60);
            }
            $ids = implode(',',$ids);
            $sql = " id IN ($ids)";
        }else{
            $sql = " 1=2";
        }
    }
    $link = '&m=mine';
}else{
    $title = $conf['title'];
    $htext = '文件列表';
    $sql = " hide=0";
    $link = '';
}
$kw = isset($_GET['kw'])?daddslashes(trim(strip_tags($_GET['kw']))):null;
if($conf['filesearch']==1 && $kw){
    $sql.=" AND name LIKE '%{$kw}%'";
    $link .= '&kw='.$kw;
}

include SYSTEM_ROOT.'header.php';
?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-2">
                    <?php echo $htext?>
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title"> <?php echo $htext?> </h3>
            <div class="block-options">
                <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <?php if($conf['filesearch']==1){?>
                <span class="searchbox">
                    <form class="form-inline" action="./" method="GET">
                        <?php if(isset($_GET['m'])){?><input name="m" type="hidden" value="<?php echo $_GET['m']?>"><?php }?>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control" name="kw" id="kw" placeholder="搜索内容">
                        </div>
                        <div class="form-group mb-2">
                            <button type="submit" class="btn btn-alt-primary form-control mb-2">搜索</button>
                        </div>
                    </form>
                </span>
            <?php }?>
            <div class="table-responsive">
                <table class="table table-striped table-hover filelist">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>操作</th>
                        <th>文件名</th>
                        <th>文件大小</th>
                        <th>文件格式</th>
                        <th>上传时间</th>
                        <th>上传者IP</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $numrows=$DB->getColumn("SELECT count(*) from pre_file WHERE{$sql}");
                    $pagesize=15;
                    $pages=ceil($numrows/$pagesize);
                    $page=isset($_GET['page'])?intval($_GET['page']):1;
                    $offset=$pagesize*($page - 1);

                    $rs=$DB->query("SELECT * FROM pre_file WHERE{$sql} ORDER BY id DESC LIMIT $offset,$pagesize");
                    $i=1;
                    while($res = $rs->fetch())
                    {
                        $fileurl = './down.php/'.$res['hash'].'.'.($res['type']?$res['type']:'file');
                        $viewurl = './file.php?hash='.$res['hash'];
                        echo '<tr><td><b>'.$i++.'</b></td><td><a href="'.$fileurl.'">下载</a>｜<a href="'.$viewurl.'">查看</a></td><td><i class="fa '.type_to_icon($res['type']).' fa-fw"></i>'.$res['name'].'</td><td>'.size_format($res['size']).'</td><td><font color="blue">'.($res['type']?$res['type']:'未知').'</font></td><td>'.$res['addtime'].'</td><td>'.preg_replace('/\d+$/','*',$res['ip']).'</b></td></tr>';
                    }
                    if($numrows == 0) echo '<tr><td colspan="7" align="center">还没上传过任何文件</td></tr>';
                    ?>
                    </tbody>
                </table>
            </div>
            <div>共有 <?php echo $numrows?> 个文件&nbsp;&nbsp;当前第 <?php echo $page?> 页，共 <?php echo $pages?> 页</div>
            <?php
            echo'<div class="dataTables_paginate paging_full_numbers d-flex justify-content-center"><ul class="pagination">';
            $first=1;
            $prev=$page-1;
            $next=$page+1;
            $last=$pages;
            if ($page>1)
            {
                echo '<li class="paginate_button page-item next"><a class="page-link" href="javascript:void(0)" onclick="listTable(\'page='.$first.$link.'\')"><i class="fa fa-angle-double-left"></i></a></li>';
                echo '<li class="paginate_button page-item last"><a class="page-link" href="javascript:void(0)" onclick="listTable(\'page='.$prev.$link.'\')"><i class="fa fa-angle-left"></i></a></li>';
            } else {
                echo '<li class="paginate_button page-item next"><a class="page-link"><i class="fa fa-angle-double-left"></i></a></li>';
                echo '<li class="paginate_button page-item last"><a class="page-link"><i class="fa fa-angle-left"></i></a></li>';
            }
            $start=$page-10>1?$page-10:1;
            $end=$page+10<$pages?$page+10:$pages;
            for ($i=$start;$i<$page;$i++)
                echo '<li class="paginate_button page-item"><a class="page-link" href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
            echo '<li class="paginate_button page-item active"><a class="page-link">'.$page.'</a></li>';
            for ($i=$page+1;$i<=$end;$i++)
                echo '<li class="paginate_button page-item "><a  class="page-link" href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
            if ($page<$pages)
            {
                echo '<li class="paginate_button page-item next"><a class="page-link" href="javascript:void(0)" onclick="listTable(\'page='.$next.$link.'\')"><i class="fa fa-angle-right"></i></a></li>';
                echo '<li class="paginate_button page-item last"><a class="page-link" href="javascript:void(0)" onclick="listTable(\'page='.$last.$link.'\')"><i class="fa fa-angle-double-right"></i></a></li>';
            } else {
                echo '<li class="paginate_button page-item next"><a class="page-link"><i class="fa fa-angle-right"></i></a></li>';
                echo '<li class="paginate_button page-item last"><a class="page-link"><i class="fa fa-angle-double-right"></i></a></li>';
            }
            echo'</ul></div>';
            ?>
        </div>
    </div>
    <?php if(!empty($conf['gonggao'])){?>
    <div class="mb-4">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-exclamation-circle"></i> <b>公告通知</b> </h3>
                <div class="block-options">
                    <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <?php echo $conf['gonggao']?>
            </div>
        </div>
    </div>
    <?php }?>
</div>
<?php include SYSTEM_ROOT.'footer.php';?>
<link href="//cdn.staticfile.org/snackbarjs/1.1.0/snackbar.min.css" rel="stylesheet">
<script src="//cdn.staticfile.org/snackbarjs/1.1.0/snackbar.min.js"></script>
<script src="//cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>