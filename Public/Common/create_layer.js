//layer自定义页面弹出
$(function () {
    $(document).on('click', '.create_layer', function () {
        if (typeof($(this).attr("url")) != "undefined") {
            url = $(this).attr('url');
        } else {
            alert('地址不正确')
        }
        if (typeof($(this).attr("title")) != "undefined") {
            title = $(this).attr('title');
        } else if ($(this).html() != '') {
            title = $(this).html();
        } else {
            title = '信息';
        }

        if (typeof($(this).attr("layer-w")) != "undefined") {
            width = $(this).attr('layer-w')
        } else {
            width = '800px';
        }
        if (typeof($(this).attr("layer-h")) != "undefined") {
            height = $(this).attr('layer-h')
        } else {
            height = '80%';
        }
        layer.open({
            type: 2,
            title: title,
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: true, //开启最大化最小化按钮
            area: [width, height],
            content: url, //iframe的url
            cancel: function (index) {
                if (typeof close_iframe === 'function') {
                    close_iframe(index);
                } else {
                    return true;
                }
            }
        });
        return false;
    })
})