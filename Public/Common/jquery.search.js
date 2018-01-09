$(document).ready(function () {
    $(".museum_search").click(function () {
        var target = $(this).attr('url');
        var year_id =$("select").val();
        $.post(target, {"year_id":year_id}, function (data, status) {
            if(status) {
                // layer_notify(data);
                layer_success('搜索成功', false);
            } else {
                layer_error('请求失败');
            }
            myobjs = eval("(" + data + ")");
            console.log(myobjs);
            var str = "";
            for(i = 0; i < myobjs.length; i ++) {
                key = i + 1;
                str += "<tr>";
                str += "<td align = 'center'>" + key + "</td>";
                str += "<td align = 'center'>" + myobjs[i].name + "</td>";
                str += "<td align = 'center'>" + myobjs[i].museum_type + "</td>";
                str += "<td align = 'center'>" + myobjs[i].museum_level + "</td>";
                str += "</tr>";
            }
            $("#search_result").html(str);
        });
    });

    $(".expert_search").click(function () {
        var target = $(this).attr('url');
        var year_id =$("select").val();
        $.post(target, {"year_id":year_id}, function (data, status) {
            if(status) {
                // layer_notify(data);
                layer_success('搜索成功', false);
            } else {
                layer_error('请求失败');
            }
            myobjs = eval("(" + data[0] + ")");
            myobjs_candidate = eval("(" + data[1] + ")");
            console.log(myobjs_candidate);
            var str = "";
            for(i = 0; i < myobjs.length; i ++) {
                key = i + 1;
                str += "<tr>";
                str += "<td align = 'center'>" + key + "</td>";
                str += "<td align = 'center'>" + myobjs[i].nickname + "</td>";
                str += "<td align = 'center'>" + myobjs[i].indicator_name + "</td>";
                str += "</tr>";
            }
            // $("#search_result").html(str);
        });
    });
});