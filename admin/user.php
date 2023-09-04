<?php
include("../includes/common.php");
$title='用户管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="modal" id="modal-store" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="block block-rounded shadow-none mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title">用户信息修改</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="关闭">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <div class="alert alert-info">高级权限的用户无每日上传数量、文件类型、关键词屏蔽等限制，且视频文件无需审核。</div>
                    <form class="form-horizontal" id="form-store">
                        <input type="hidden" name="action" id="action"/>
                        <input type="hidden" name="uid" id="uid"/>
                        <div class="mb-4">
                            <label class="form-label">用户权限</label>
                            <select name="level" id="level" class="form-select form-control">
                                <option value="0">0_普通</option>
                                <option value="1">1_高级</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full block-content-sm text-end border-top">
                    <button  class="btn btn-alt-secondary" id="store" onclick="save()">保存</button>
                    <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</div>
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
                            <?php echo $title ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"> 文件列表 </h3>
                <div class="block-options">
                    <button type="button" onclick="" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <link rel="stylesheet" id="css-main" href="./assets/css/bootstrap-table.css">
                <form onsubmit="return searchSubmit()" method="GET" class="form-inline" id="searchToolbar">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-sm-none">菜单</span>
                            <span class="d-none d-sm-inline-block fw-semibold">菜单</span>
                            <i class="fa fa-align-center opacity-50 ms-1"></i>
                        </button>
                        <div class="dropdown-menu fs-sm" style="min-width: 315px;" aria-labelledby="dropdown-content-rich-primary" data-popper-placement="bottom-start">
                            <div class="form-group mb-2">
                                <label class="form-label" for="type">搜索</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="1">UID</option>
                                    <option value="2">第三方账号UID</option>
                                    <option value="3">昵称</option>
                                    <option value="4">登录IP</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control" name="kw" id="kw" placeholder="搜索内容">
                            </div>
                            <div class="form-group mb-2">
                                <select name="dstatus" id="dstatus" class="form-select">
                                    <option value="-1">全部状态</option>
                                    <option value="0">正常状态</option>
                                    <option value="1">封禁状态</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-alt-primary form-control mb-2">搜索</button>
                        </div>
                    </div>
                </form>
                <table class="text-center" id="listTable"></table>
            </div>
        </div>
    </div>
</div>
<a style="display: none;" href="" id="vurl" rel="noreferrer" target="_blank"></a>
<?php include 'foot.php';?>
<script src="../assets/js/custom.js"></script>
<script>
$(document).ready(function(){
	updateToolbar();
	const defaultPageSize = 15;
	const pageNumber = typeof window.$_GET['pageNumber'] != 'undefined' ? parseInt(window.$_GET['pageNumber']) : 1;
	const pageSize = typeof window.$_GET['pageSize'] != 'undefined' ? parseInt(window.$_GET['pageSize']) : defaultPageSize;

	$("#listTable").bootstrapTable({
		url: 'ajax.php?act=userList',
        pageNumber: pageNumber,
        pageSize: pageSize,
        showJumpTo:false,
        paginationDetailHAlign: 'right', // 分页详细信息水平对齐方式
        paginationHAlign: 'left', // 分页水平对齐方式
        paginationVAlign: 'bottom', // 分页垂直对齐方式
        sidePagination: "server", //分页方式：client客户端分页，server服务端分页（*）
        buttonsClass: 'light btn-dim btn-sm', // 工具按钮样式
        showButtonText: false, // 是否显示按钮文字
        pageList: [15, 25, 50, 100], //可供选择的每页的行数（*）
        searchHighlight: true, // 搜索内容高亮
        classes: 'table table-striped table-hover table-bordered',
		columns: [
			{
				field: 'uid',
				title: 'UID',
				formatter: function(value, row, index) {
					return '<b>'+value+'</b>';
				}
			},
			{
				field: 'openid',
				title: '头像&昵称',
				formatter: function(value, row, index) {
					return '<img src="'+row.faceimg+'" alt="Avatar" width="40" class="img-circle">'+row.nickname;
				}
			},
			{
				field: 'openid',
				title: '登录方式/第三方账号UID',
				formatter: function(value, row, index) {
					return '<b>'+row.type+'</b><br/>'+value;
				}
			},
			{
				field: 'regip',
				title: '注册IP/登录IP',
				formatter: function(value, row, index) {
					return '<a href="https://m.ip138.com/iplookup.asp?ip='+value+'" target="_blank" rel="noreferrer">'+value+'</a><br/><a href="https://m.ip138.com/iplookup.asp?ip='+row.loginip+'" target="_blank" rel="noreferrer">'+row.loginip+'</a>';
				}
			},
			{
				field: 'addtime',
				title: '注册时间/最后登录',
				formatter: function(value, row, index) {
					return value+'<br/>'+row.lasttime;
				}
			},
			{
				field: 'level',
				title: '权限',
				formatter: function(value, row, index) {
					if(value == '1'){
						return '<a href="javascript:setLevel('+row.uid+','+value+')" style="color:orange" title="修改用户权限">高级</a>';
					}else{
						return '<a href="javascript:setLevel('+row.uid+','+value+')" style="color:blue" title="修改用户权限">普通</a>';
					}
				}
			},
			{
				field: 'enable',
				title: '状态',
				formatter: function(value, row, index) {
					if(value == '1'){
						return '<a href="javascript:setEnable('+row.uid+',0)" class="btn btn-xs btn-success">正常</a>';
					}else{
						return '<a href="javascript:setEnable('+row.uid+',1)" class="btn btn-xs btn-danger">封禁</a>';
					}
				}
			},
			{
				field: 'status',
				title: '操作',
				formatter: function(value, row, index) {
					return '<a href="./file.php?uid='+row.uid+'" class="btn btn-xs btn-info" target="_blank">文件</a>&nbsp;<a href="javascript:delUser('+row.uid+')" class="btn btn-xs btn-danger">删除</a></td></tr>';
				}
			},
		],
	})
})

function setEnable(uid,enable) {
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=setUserEnable',
		data: {uid:uid, enable:enable},
		dataType : 'json',
		success : function(data) {
			searchSubmit();
		},
		error:function(data){
			layer.msg('服务器错误');
		}
	});
}

function setLevel(uid, level){
	$("#modal-store").modal('show');
	$("#action").val("edit");
	$("#form-store #uid").val(uid);
	$("#form-store #level").val(level);
}

function save(){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?act=saveUserInfo',
		data : $("#form-store").serialize(),
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert(data.msg,{
					icon: 1,
					closeBtn: false
				}, function(){
					$("#modal-store").modal('hide');
					searchSubmit();
					layer.closeAll();
				});
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
		}
	});
}

function delUser(uid) {
	var confirmobj = layer.confirm('你确定要删除此用户吗？', {
	  btn: ['确定','取消'], icon: 0
	}, function(){
	  $.ajax({
		type : 'POST',
		url : 'ajax.php?act=delUser',
		data : {uid: uid},
		dataType : 'json',
		success : function(data) {
			if(data.code == 0){
				searchSubmit();
				layer.alert('删除成功', {icon:1});
			}else{
				layer.alert(data.msg, {icon:2});
			}
		},
		error:function(data){
			layer.msg('服务器错误');
		}
	  });
	}, function(){
	  layer.close(confirmobj);
	});
}

</script>