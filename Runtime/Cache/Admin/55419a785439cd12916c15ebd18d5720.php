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
        
    <ol class="breadcrumb admin_nav_bread">
        <button type="button" class="btn btn-sm btn-primary ajax_get" url="<?php echo U('Rule/get_all_rule');?>">更新规则</button>
    </ol>
    <table class="table table-hover table-condensed table_list">
        <thead>
        <tr class="active">
            <th width="15%">名称</th>
            <th width="10%">排序</th>
            <th width="60%">规则</th>
            <th width="15%">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($rule_list)): ?><tr>
                <td align="center" colspan="6">
                    <span style="color: red;">暂无规则</span>
                </td>
            </tr>
        <?php else: ?>
            <?php if(is_array($rule_list)): $i = 0; $__LIST__ = $rule_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tr_tree column_<?php echo ($vo["pid"]); ?> column_id_<?php echo ($vo["id"]); ?>" data-level="<?php echo ($vo['level']); ?>" data-id="<?php echo ($vo["id"]); ?>" data-pid="<?php echo ($vo["pid"]); ?>">
                    <td align="left">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true" style="cursor: pointer;" onclick="handleTree($(this),'<?php echo ($vo["id"]); ?>')"></span>
                        <span class="tree_img">&nbsp;&nbsp;<img src="/website/Public/Admin/images/bg_column.gif"></span><?php echo ($vo["name"]); ?>
                    </td>
                    <td align="center"><?php echo ($vo["sort"]); ?></td>
                    <td align="center"><?php echo ($vo["rule"]); ?></td>
                    <td align="center">
                        <button type="button" class="btn btn-sm btn-danger ajax_get confirm" url="<?php echo U('Rule/remove',array('id'=>$vo['id']));?>">删除</button>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
    </table>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.tr_tree').each(function(){
                var glyphicon = $(this).find('.glyphicon');
                var tree_img = $(this).find('.tree_img');
                var tr_level = $(this).attr('data-level');
                var id = $(this).attr('data-id');
                nextobj=$(this).next('.column_'+id).attr('data-id');
                if(tr_level != 1){
                    $(this).hide();
                    glyphicon.hide();
                }else {
                    tree_img.hide();
                }
            })
        })
        function handleTree(my,id,tp){
            var son = $('.column_'+id);
            if (son){
                if (son.is(":hidden")){
                    if(!tp){
                        son.show();
                        if(my.hasClass('glyphicon-plus')) {
                            my.removeClass('glyphicon-plus').addClass('glyphicon-minus');
                        }
                    }
                }else{
                    son.hide();
                    if(my.hasClass('glyphicon-minus')){
                        my.removeClass('glyphicon-minus').addClass('glyphicon-plus');
                    }
                    son.each(function(){
                        var sid = $(this).attr('id');
                        var sson = $(this).find(".columnname");
                        if (sid) oncolumn(sson,sid,1);
                    })
                }
            }
        }
    </script>

    </div>
    <script src="/website/Public/Plugin/validate/validform_v5.3.2.js"></script>
<script src="/website/Public/Plugin/layer/layer.js"></script>
<script src="/website/Public/Common/jquery.form.js"></script>
<script src="/website/Public/Common/create_layer.js"></script>
<script src="/website/Public/Common/jquery.submit.js"></script>
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