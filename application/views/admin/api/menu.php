<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Full Layout - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/common.css">
    <script type="text/javascript" src="/public/js/ui/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/ui/jquery.easyui.min.js"></script>
</head>
<body>

<div class="easyui-panel" title="编辑微信菜单" style="width:100%; height: 100%">
    <div style="padding:10px 60px 20px 60px">
        <form id="ff"
              action="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=8DwfqEJOTWNC19wHZu3lEtLLbCVzxktWGxQsUf__l8XyHxvYaJ6oH35S3Jou6DWD45E0BpewlCe-b_P3yvpwKQ"
              method="post">
            <table cellpadding="5">
                <tr>
                    <td>菜单构建代码:</td>
                    <td><textarea name="content" id="content" cols="120" rows="10"><?= $content ?></textarea></td>
                </tr>
            </table>
        </form>
        <div style="padding:5px 0;">
            <button id="btnSave" href="###" class="easyui-linkbutton">创建菜单</button>
            <button id="btnCancel" href="" class="easyui-linkbutton">取消</button>
        </div>
    </div>

</div>
</body>

<script>
    var _microHR_menu = {
        "button": [

            {
                "name": "菜单",
                "sub_button": [
                    {
                        "type": "view",
                        "name": "搜索",
                        "url": "http://www.soso.com/"
                    },
                    {
                        "type": "view",
                        "name": "视频",
                        "url": "http://v.qq.com/"
                    },
                    {
                        "type": "click",
                        "name": "赞一下我们",
                        "key": "V1001_GOOD"
                    }
                ]
            }
        ]
    }

    var _new = {
        "button": [
            {
            "name": "海亮招聘",
            "sub_button": [
                {"type": "view", "name": "社会招聘"},
                {"type": "view", "name": "微注册"},
                {
                "type": "view",
                "name": "Q&A"
            }]
        }, {
            "name": "精彩互动",
            "sub_button": [{"type": "view", "name": "求职故事"}, {"type": "view", "name": "直面高管"}]
        }, {"name": "@海亮", "sub_button": [{"type": "view", "name": "动态信息"}, {"type": "view", "name": "关于海亮"}]}]
    };

</script>

<script>
    var _validate = false;
    $(function () {
        //  $('[name=content]').html(JSON.stringify(_microHR_menu));
    })

    $('#btnSave').click(function () {
        submit();
        return false;
    })

    function submit() {
        var url = '<?=APP_URL?>/apiman/menu';
        $.post(url, {}, function (resp) {
            if (resp.code == 0) {
                $.messager.alert('提示', '菜单创建成功', 'info')
            } else {
                $.messager.alert('错误', '菜单创建失败:[' + resp.message + ']', 'error');
            }
        }, 'json')
    }

    function requestCreate(url) {
        $.post(url, _microHR_menu, function (resp) {
            alert('ok');
            if (resp.errcode <= 0)
                $.messager.alert('提示', '菜单创建完成', 'info');
            else
                $.messager.alert('错误', '菜单创建失败:[' + resp.errmsg + ']', 'error');
        }, 'json')
    }


</script>
</html>