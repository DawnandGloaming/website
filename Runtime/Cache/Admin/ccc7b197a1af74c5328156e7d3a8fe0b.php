<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
<meta name="keywords" content="">
<meta name="description" content="">
    <link href="/website/Public/Plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/website/Public/Plugin/validate/validate.css" rel="stylesheet">
<link href="/website/Public/Admin/css/common.css" rel="stylesheet">

    <script src="/website/Public/Common/jquery.min.js"></script>
<!--<script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>-->
<script src="/website/Public/Plugin/bootstrap/js/bootstrap.min.js"></script>
<script src="/website/Public/Admin/js/common.js"></script>

</head>
<body>
    <nav class="navbar navbar-inverse admin_nav" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo U('Index/index');?>">后台系统</a>
        </div>
        <div class="collapse navbar-collapse">
            <?php if(empty($nav)): ?><ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            权限管理<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('Navigation/index');?>">后台导航</a></li>
                        </ul>
                    </li>
                </ul>
            <?php else: ?>
                <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="<?php echo ($vo["url"]); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo ($vo["name"]); ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php if(is_array($vo['_child'])): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U($voo['url']);?>"><?php echo ($voo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </li>
                    </ul><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="<?php echo ($vo["url"]); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo ($admin_info["nickname"]); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a class="create_layer" url="<?php echo U('Public/change_info');?>" layer-w="450px" layer-h="450px" style="cursor: pointer;">个人资料</a></li>
                        <li><a class="create_layer" url="<?php echo U('Public/change_password');?>" layer-w="450px" layer-h="400px" style="cursor: pointer;">修改密码</a></li>
                        <li><a href="<?php echo U('Public/logout');?>">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <ol class="breadcrumb admin_nav_bread">
    <li><a href="<?php echo U('Index/index');?>">后台首页</a></li>
    <li><a href="<?php echo ($bread["controller_url"]); ?>"><?php echo ($bread["controller_name"]); ?></a></li>
    <?php if($bread["action_name"] != ''): ?><li class="active"><?php echo ($bread["action_name"]); ?></li><?php endif; ?>
    <li class="pull-right"><a href="<?php echo U('/');?>">前台首页</a></li>
    <li class="pull-right"><a href="<?php echo U('Clear/cache');?>" class="ajax_get">清除缓存</a></li>
    <span>
    <li class="pull-right">当前语言：
        <?php if($now_lanuage == 'zh_'): ?><a href="javascript:void(0);" class="for_language" onclick="check_langlage('english')">中文</a>
            <?php else: ?>
            <a href="javascript:void(0);" class="for_language" onclick="check_langlage('中文')">english</a><?php endif; ?>
    </li>
    </span>
</ol>
    <div class="body">
        
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px;">
        <div class="container-fluid">
            <div>
                <a href="<?php echo U('index',array('Action'=>'backup'));?>" class="ajax_get">
                    <button type="button" class="btn btn-success navbar-btn">立即备份</button>
                </a>
            </div>
        </div>
    </nav>
    <table class="table table-hover table_list">
        <thead>
        <tr class="active">
            <th width="10%" style="text-align: center;">顺序</th>
            <th width="20%" style="text-align: center;">文件名</th>
            <th width="20%" style="text-align: center;">备份时间</th>
            <th width="20%" style="text-align: center;">文件大小</th>
            <th width="10%" style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($sql_list)): $i = 0; $__LIST__ = $sql_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td align="center" ><?php echo ($key+1); ?></td>
                <td align="center" ><?php echo ($vo["filename"]); ?></td>
                <td align="center" ><?php echo ($vo["filetime"]); ?></td>
                <td align="center" ><?php echo ($vo["filesize"]); ?></td>
                <td align="center">
                    <a href="<?php echo U('index',array('Action'=>'download','file'=>$vo['filename']));?>">
                        <button type="button" class="btn btn-primary btn-xs">下载</button>
                    </a>
                    <a class="ajax_get confirm" href="<?php echo U('index',array('Action'=>'RL','file'=>$vo['filename']));?>">
                        <button type="button" class="btn btn-primary btn-xs">还原</button>
                    </a>
                    <a class="ajax_get confirm" confirm="您确定要删除吗？" href="<?php echo U('index',array('Action'=>'Del','file'=>$vo['filename']));?>">
                        <button type="button" class="btn btn-primary btn-xs">删除</button>
                    </a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>

    </div>
    <script src="/website/Public/Plugin/validate/validform_v5.3.2.js"></script>
<script src="/website/Public/Plugin/layer/layer.js"></script>
<script src="/website/Public/Common/jquery.form.js"></script>
<script src="/website/Public/Common/create_layer.js"></script>
<script src="/website/Public/Common/jquery.submit.js"></script>
<script src="/website/Public/Common/jquery.search.js"></script>
<link href="/website/Public/Plugin/kindeditor/themes/default/default.css" rel="stylesheet"/>
<script src="/website/Public/Plugin/kindeditor/kindeditor.js"></script>
<script src="/website/Public/Plugin/kindeditor/lang/zh_CN.js"></script>
<script>
    KindEditor.ready(function(K) {
        var editor_image = K.editor({
            allowFileManager : true,
            afterBlur: function () { this.sync(); },
            uploadJson : "<?php echo U('Admin/Upload/index');?>",
            fileManagerJson : "<?php echo U('Admin/Upload/filelist');?>"
        });
        //--上传图片
        K('.upload_image').click(function() {
            var urlinput=$(this).attr('for');
            editor_image.loadPlugin('image', function() {
                editor_image.plugin.imageDialog({
                    showRemote : false,
                    imageUrl : K('#'+urlinput).val(),
                    clickFn : function(url, title, width, height, border, align) {
                        K('#'+urlinput).val(url);
                        editor_image.hideDialog();
                    }
                });
            });
        });
    });
</script>
<script>
    function check_langlage(language) {
        $.ajax({
            type: "GET",
            url: "<?php echo U('switch_language');?>",
            data: { for_language : language}
        }).done(function() {
            window.location.reload();
        });
    }
</script>

</body>
</html>