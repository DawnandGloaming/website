$(document).ready(function () {
    $("#search").click(function () {
        var target = $(this).attr('url');
        var year_id =$("select").val();
        $.post(target, {"year_id":year_id, "url":target}, function (data, status) {
            if(status == 'success') {
                layer_notify(data);
            } else {
                layer_error('请求失败');
            }
        });
    });
});