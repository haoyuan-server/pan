<?php
include("../includes/common.php");
$title='文件管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="modal" id="modal-store" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="block block-rounded shadow-none mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title">文件信息修改</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="关闭">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form class="form-horizontal" id="form-store">
                        <input type="hidden" name="action" id="action"/>
                        <input type="hidden" name="id" id="id"/>
                        <div class="mb-4">
                            <label class="form-label">文件名称</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">文件类型</label>
                            <input type="text" class="form-control" name="type" id="type">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">文件大小</label>
                            <input type="text" class="form-control" name="size" id="size" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">文件MD5</label>
                            <input type="text" class="form-control" name="hash" id="hash" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">是否隐藏</label>
                            <select name="hide" id="hide" class="form-select form-control">
                                <option value="0">0_否</option>
                                <option value="1">1_是</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">开启密码</label>
                            <select name="ispwd" id="ispwd" class="form-select form-control" onchange="change_ispwd(this)">
                                <option value="0">0_否</option>
                                <option value="1">1_是</option>
                            </select>
                        </div>
                        <div class="mb-4" id="pwd_frame">
                            <label class="form-label">下载密码</label>
                            <input type="text" class="form-control" name="pwd" id="pwd">
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
                                    <option value="1">文件名</option>
                                    <option value="2">文件Hash</option>
                                    <option value="3">文件格式</option>
                                    <option value="4">上传者IP</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control" name="kw" id="kw" placeholder="搜索内容">
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control" name="uid" id="uid" placeholder="UID">
                            </div>
                            <div class="form-group mb-2">
                                <select name="dstatus" id="dstatus" class="form-select">
                                    <option value="-1">全部状态</option>
                                    <option value="0">正常文件</option>
                                    <option value="1">已屏蔽文件</option>
                                    <option value="2">待审核文件</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-alt-primary form-control mb-2">搜索</button>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-sm-none">批量操作</span>
                            <span class="d-none d-sm-inline-block fw-semibold">批量操作</span>
                            <i class="fa fa-align-left opacity-50 ms-1"></i>
                        </button>
                        <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-content-rich-primary" data-popper-placement="bottom-start">
                            <a class="dropdown-item" href="javascript:operation()">删除</a>
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
		url: 'ajax_file.php?act=fileList',
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
				field: '',
				checkbox: true
			},
			{
				field: 'id',
				title: 'ID',
				formatter: function(value, row, index) {
					return '<b>'+value+'</b>';
				}
			},
			{
				field: 'uid',
				title: '用户',
				formatter: function(value, row, index) {
					return value>0?'<a href="./user.php?type=1&kw='+value+'" target="_blank">'+value+'</a>':'游客';
				}
			},
			{
				field: 'name',
				title: '文件名',
				formatter: function(value, row, index) {
					var html = '<a href="'+row.fileurl+'" title="点击下载"><i class="fa '+row.icon+' fa-fw"></i>'+value+'</a>';
					if(row.view){
						if(row.view_type == 'image'){
							html += ' [<a href="javascript:showimage(\''+row.viewurl+'\')">预览</a>]';
						}else{
							html += ' [<a href="javascript:showfile('+row.id+',\''+row.view_type+'\')">预览</a>]';
						}
					}
					return html;
				}
			},
			{
				field: 'size',
				title: '文件大小'
			},
			{
				field: 'type',
				title: '文件格式',
				formatter: function(value, row, index) {
					return value ? value : '未知';
				}
			},
			{
				field: 'addtime',
				title: '上传日期/上次下载',
				formatter: function(value, row, index) {
					return value + '<br/>' + row.lasttime;
				}
			},
			{
				field: 'ip',
				title: '上传IP/下载量',
				formatter: function(value, row, index) {
					return '<a href="https://m.ip138.com/iplookup.asp?ip='+value+'" target="_blank" rel="noreferrer">'+value+'</a><br/><b>'+row.count+'</b>';
				}
			},
			{
				field: 'block',
				title: '状态',
				formatter: function(value, row, index) {
					switch(value){
						case '2': return '<a href="javascript:setBlock('+row.id+',0)" class="btn btn-xs btn-warning">待审</a>';break;
						case '1': return '<a href="javascript:setBlock('+row.id+',0)" class="btn btn-xs btn-danger">封禁</a>';break;
						case '0': return '<a href="javascript:setBlock('+row.id+',1)" class="btn btn-xs btn-success">正常</a>';break;
						default: return '';break;
					}
				}
			},
			{
				field: 'status',
				title: '操作',
				formatter: function(value, row, index) {
					return '<a href="javascript:editframe('+row.id+')" class="btn btn-xs btn-info">编辑</a>&nbsp;<a href="'+row.pageurl+'" class="btn btn-xs btn-warning" target="_blank">查看</a>&nbsp;<a href="javascript:delFile('+row.id+')" class="btn btn-xs btn-danger">删除</a></td></tr>';
				}
			},
		],
	})
})

function change_ispwd(obj){
	if($(obj).val()==1){
		$('#pwd_frame').show()
	}else{
		$('#pwd_frame').hide()
	}
}
function setBlock(id,status) {
	$.ajax({
		type : 'GET',
		url : 'ajax_file.php?act=setBlock&id='+id+'&status='+status,
		dataType : 'json',
		success : function(data) {
			searchSubmit();
		},
		error:function(data){
			layer.msg('服务器错误');
		}
	});
}
function editframe(id){
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'GET',
		url : 'ajax_file.php?act=getFileInfo&id='+id,
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				$("#modal-store").modal('show');
				$("#action").val("edit");
				$("#form-store #id").val(data.id);
				$("#form-store #name").val(data.name);
				$("#form-store #type").val(data.type);
				$("#form-store #size").val(data.size2+" ("+data.size+" 字节)");
				$("#form-store #hash").val(data.hash);
				$("#form-store #hide").val(data.hide);
				if(data.pwd==null||data.pwd==""){
					$("#form-store #ispwd").val(0);
					$("#form-store #pwd").val("");
					$('#pwd_frame').hide()
				}else{
					$("#form-store #ispwd").val(1);
					$("#form-store #pwd").val(data.pwd);
					$('#pwd_frame').show()
				}
			}else{
				layer.alert(data.msg, {icon: 2})
			}
		},
		error:function(data){
			layer.msg('服务器错误');
		}
	});
}
function save(){
	if($("#name").val()==''){
		layer.alert('请确保各项不能为空！');return false;
	}
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax_file.php?act=saveFileInfo',
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
function delFile(id) {
	var confirmobj = layer.confirm('你确定要删除此文件吗？', {
	  btn: ['确定','取消'], icon: 0
	}, function(){
	  $.ajax({
		type : 'GET',
		url : 'ajax_file.php?act=delFile&id='+id,
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
function operation(){
	var selected = $('#listTable').bootstrapTable('getSelections');
	if(selected.length == 0){
		layer.msg('未选中文件', {time:1500});return;
	}
	var checkbox = new Array();
	$.each(selected, function(key, item){
		checkbox.push(item.id)
	})
	var confirmobj = layer.confirm('确定要删除已选中的'+selected.length+'个文件吗？', {
	  btn: ['确定','取消'], icon: 0
	}, function(){
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : 'POST',
			url : 'ajax_file.php?act=operation',
			data : {checkbox: checkbox},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					searchSubmit();
					layer.alert(data.msg, {icon:1});
				}else{
					layer.alert(data.msg, {icon:2});
				}
			},
			error:function(data){
				layer.msg('请求超时');
				searchSubmit();
			}
		});
	}, function(){
	  layer.close(confirmobj);
	});
}
function showfile(id, type) {
	if(type == 'image'){
		view_image();
	}else if(type == 'audio'){
		if($(window).width() >= 1200){
			var area = ['50%','120px'];
		}else if($(window).width() >= 992){
			var area = ['75%','120px'];
		}else if($(window).width() >= 768){
			var area = ['95%','120px'];
		}else{
			var area = ['100%','120px'];
		}
	}else if(type == 'video'){
		if($(window).width() >= 1200){
			var area = ['50%', '60%'];
		}else if($(window).width() >= 992){
			var area = ['75%', '70%'];
		}else if($(window).width() >= 768){
			var area = ['95%', '75%'];
		}else{
			var area = ['100%', '55%'];
		}
	}
	layer.open({
	   type: 2,
	   title: '文件预览',
	   shadeClose: true,
	   area: area,
	   content: './file-view.php?id='+id
	});
}
function showimage(resourcesUrl){
    var img = new Image();
    img.onload = function () {//避免图片还未加载完成无法获取到图片的大小。
        //避免图片太大，导致弹出展示超出了网页显示访问，所以图片大于浏览器时下窗口可视区域时，进行等比例缩小。
        var max_height = $(window).height() - 200;
        var max_width = $(window).width();

        //rate1，rate2，rate3 三个比例中取最小的。
        var rate1 = max_height / img.height;
        var rate2 = max_width / img.width;
        var rate3 = 1;
        var rate = Math.min(rate1, rate2, rate3);
        //等比例缩放
        var imgHeight = img.height * rate; //获取图片高度
        var imgWidth = img.width * rate; //获取图片宽度

        var imgHtml = "<img src='" + resourcesUrl + "' width='" + imgWidth + "px' height='" + imgHeight + "px'/>";
        //弹出层
        layer.open({
            type:1,
            shade: 0.6,
            title: false,
            area: ['auto', 'auto'],
            shadeClose: true,
            content: imgHtml
        });
    }
	img.onerror = function(){ layer.msg('图片加载错误'); }
    img.src = resourcesUrl;
}

</script>