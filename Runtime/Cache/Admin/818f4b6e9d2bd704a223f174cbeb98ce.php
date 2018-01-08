<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="/website/Public/Plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/website/Public/Plugin/validate/validate.css" rel="stylesheet">
<link href="/website/Public/Admin/css/common.css" rel="stylesheet">
    <script src="/website/Public/Common/jquery.min.js"></script>
<script src="/website/Public/Plugin/bootstrap/js/bootstrap.min.js"></script>
<script src="/website/Public/Admin/js/common.js"></script>
</head>
<body>

    <form role="form" method="post" action="<?php echo U('Config/create');?>" class="create_page valid_form">
        <div class="form-group">
            <label>设置分组</label>
            <select name="group_id" class="form-control">
                <?php if(is_array($config_type_list)): $i = 0; $__LIST__ = $config_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $group_id): ?>selected = "selected"<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label>设置名称</label>
            <input type="text" name="name" class="form-control" autocomplete="off" placeholder="请输入设置名称">
        </div>
        <div class="form-group">
            <label>变量名称</label>
            <input type="text" name="varname" class="form-control" autocomplete="off" placeholder="请输入变量名称">
        </div>
        <div class="form-group">
            <label>单位/数量</label>
            <input type="text" name="unit" class="form-control" autocomplete="off" placeholder="请输入单位/数量">
        </div>
        <label>设置类型</label>
        <div class="form-group">
            <label class="checkbox-inline">
                <input type="radio" name="type" value="string" checked>单行文本
            </label>
            <label class="checkbox-inline">
                <input type="radio" name="type" value="bstring">多行文本
            </label>
            <label class="checkbox-inline">
                <input type="radio" name="type" value="image">图片上传
            </label>
            <label class="checkbox-inline">
                <input type="radio" name="type" value="bool">枚举
            </label>
        </div>
        <div class="form-group">
            <label></label>
            <button type="submit" class="btn btn-primary btn-block">保存</button>
        </div>
    </form>

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