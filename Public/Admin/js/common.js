$(document).ready(function () {
    /*导航栏hover下拉效果*/
    $(".dropdown").mouseover(function () {
        $(this).addClass("open");
    });
    $(".dropdown").mouseleave(function () {
        $(this).removeClass("open");
    });

    /*批量操作*/
    $(".list_save").click(function () {
        $('.list_form').submit();
    });

    /*复选框全选/全不选*/
    $("input[name='checkall']").click(function () {
        var a = $(".file_dir");
        if (a[0].checked) {
            for (var i = 0; i < a.length; i++) {
                if (a[i].type == "checkbox") a[i].checked = false;
            }
        }
        else {
            for (var i = 0; i < a.length; i++) {
                if (a[i].type == "checkbox") a[i].checked = true;
            }
        }
    });


})