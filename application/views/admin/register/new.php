<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/common.css">
    <script type="text/javascript" src="/public/js/ui/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/ui/jquery.easyui.min.js"></script>
</head>
<body>
<div class="easyui-panel" title="新增注册" style="width:100%; height: 100%">
    <div style="padding:10px 60px 20px 60px">
        <form id="ff" method="post">
            <table cellpadding="5">
                <tr>
                    <td>昵称:</td>
                    <td><input class="easyui-textbox" type="text" size="32" name="nickname"
                               data-options="required:true">
                    </td>
                </tr>

                <tr>
                    <td>性别:</td>
                    <td>
                        <select class="easyui-combobox" name="gender">
                            <option value="0">女</option>
                            <option value="1">男</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>微信ID:</td>
                    <td><input class="easyui-textbox" type="text" size="32" name="wxid" data-options="">
                    </td>
                </tr>
                <tr>
                    <td>手机号码:</td>
                    <td><input class="easyui-textbox" type="text" size="32" name="mobile" data-options="required:true">
                    </td>
                </tr>
                <tr>
                    <td>学院:</td>
                    <td><input class="easyui-textbox" type="text" size="80" name="academy" data-options="required:true">
                    </td>
                </tr>
                <tr>
                    <td>专业:</td>
                    <td><input class="easyui-textbox" type="text" size="80" name="major" data-options="required:true">
                    </td>
                </tr>
                <tr>
                    <td>状态:</td>
                    <td>
                        <select class="easyui-combobox" name="status">
                            <option value="1" selected>发布</option>
                            <option value="0">关闭</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>备注:</td>
                    <td><input class="easyui-textbox" name="comment" data-options="multiline:true"
                               style="width: 320px;height:120px"></td>
                </tr>

            </table>
        </form>
        <div style="padding:5px 0;">
            <a id="btnSave" href="<?= SITE_URL ?>/admin/registerman/append" class="easyui-linkbutton">保存</a>
            <a id="btnCancel" href="<?= SITE_URL ?>/admin/registerman" class="easyui-linkbutton">取消</a>
        </div>
    </div>


</div>
</body>
<script>
    var _validate = false;
    $('#btnSave').click(function () {
        submitForm();
        return false;
    })

    function submitForm() {
        $('form').form('submit', {
            onSubmit: function () {
                var re = $(this).form('enableValidation').form('validate');
                if (re == true) {
                    $.post($('#btnSave').attr('href'), $('form').serializeArray(), function (rep) {
                        if (rep.code == 0) {
                            $.messager.alert('提示', '操作成功', 'info', function () {
                                location.href = $('#btnCancel').attr('href');
                            });
                        } else {
                            $.messager.alert('错误', rep.message, 'error');
                        }
                    }, 'json')
                }
                return false;
            }
        });
    }

</script>
</html>