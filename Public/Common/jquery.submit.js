$(function () {
    $(function () {
        if ($(".valid_form").length > 0) {
            $(".valid_form").Validform({
                beforeSubmit: function () {
                    ajax_loading($(this))
                }
            });
        }
    });
    $('.ajax_get').click(function () {
        ajax_init($(this), 'get');
        return false;
    });
    $('.ajax_post').click(function () {
        ajax_init($(this), 'post');
        return false;
    });
    //ajax 表单提交
    $('.ajax_form').submit(function () {
        ajax_init($(this), 'ajax_form');
        return false;
    })
});
function ajax_init(obj, type) {
    if (typeof BeforeSubmit === 'function') {
        var is_submit = BeforeSubmit();
        if (!is_submit) {
            return false;
        }
    }
    if (obj.hasClass('confirm')) {
        text = '您确定要执行此操作吗？';
        if (typeof(obj.attr("confirm")) != "undefined") {
            text = obj.attr("confirm");
        }
        inquiry = layer.confirm(text, {
            btn: ['确定', '取消']
        }, function () {
            layer.close(inquiry);
            ajax_type(obj, type);
            return false;
        }, function () {
            layer.close(inquiry);
        });
        return false;
    }
    ajax_type(obj, type);
    return false;
}
function ajax_type(obj, type) {
    ajax_loading(obj);
    switch (type) {
        case 'get':
            AjaxButtonGet(obj);
            break;
        case 'post':
            AjaxButtonPost(obj);
            break;
        case 'ajax_form':
            AjaxFormSubmit(obj)
            break;
        default :
            return false;
    }
}
function ajax_loading(obj) {
    if (typeof AlertLoading === 'function') {
        AlertLoading();
    } else {
        if (typeof(obj.attr("load_msg")) != "undefined") {
            layer_loading_msg(obj.attr("load_msg"));
        } else {
            layer_loading_msg('加载中...');
        }
    }
}
function AjaxButtonGet(obj) {
    var target;
    if ((target = obj.attr('href')) || (target = obj.attr('url'))) {
        $.ajax({
            url: target,
            dataType: 'json', type: 'GET',
            success: function (data) {
                layer_notify(data);
            },
            error: function () {
                layer_error('请求失败');
            }
        });
    }
}
//传入点击对象
function AjaxButtonPost(obj) {
    var form, target, submit_data;
    form = $('.' + obj.attr('target_form'));
    target = form.attr('action');
    submit_data = form.serialize();
    if (typeof(obj.attr("name")) != "undefined" && typeof(obj.attr("value")) != "undefined") {
        submit_data += '&' + obj.attr('name') + '=' + obj.attr('value');
    }
    obj.attr('disabled', true);
    form.ajaxSubmit({
        url: target, data: submit_data,
        success: function (data) {
            obj.attr('disabled', false);
            if (typeof CallNotify === 'function') {
                CallNotify(data)
            } else {
                layer_notify(data);
            }
        },
        error: function () {
            obj.attr('disabled', false);
            layer_error('请求失败');
        }
    })
}
//validform扩展提交(传入表单对象)
function AjaxFormSubmit(form) {
    form.find("[type='submit']").attr('disabled', true);
    form.ajaxSubmit({
        success: function (data) {
            form.find("[type='submit']").attr('disabled', false);
            if (typeof CallNotify === 'function') {
                CallNotify(data)
            } else {
                layer_notify(data);
            }
        },
        error: function () {
            layer_error('请求失败');
            form.find("[type='submit']").attr('disabled', false);
        }
    })
}
//结果通知
function layer_notify(data) {
    var time = 1500;
    if (data.status == 1) {
        layer_close_all('loading');
        layer_success(data.info, data.url);
    } else {
        layer_close_all('loading');
        layer_error(data.info);
    }
}

//loding
function layer_loading() {
    layer.load(0, {shade: [0.2, '#ddd']});
}
//loading带文字
function layer_loading_msg(msg) {
    layer.msg(msg, {icon: 16, shade: [0.2, '#ddd']});
}
//成功弹框
function layer_success(msg, url) {
    layer.msg(msg, {
        skin: 'layer-success-color',
        shade: [0.2, '#ddd'],
        icon: 1,
        time: 1000
    }, function () {
        if (url !== false) {
            window.parent.location.href = url;
        }
    })
}
//错误弹框
function layer_error(msg) {
    layer.msg(msg, {
        skin: 'layer-error-color',
        shade: [0.2, '#ddd'],
        icon: 2,
        time: 1500
    })
}
//关闭所有弹框
function layer_close_all(box) {
    layer.closeAll(box);
}