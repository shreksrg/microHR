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
<div class="easyui-panel" title="新增/编辑用户" style="width:100%; height: 100%">

    <div style="padding:10px 60px 20px 60px">

        <form id="ff" method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>"/>
            <table cellpadding="5">
                <tr>
                    <td>用户名:</td>
                    <td><input class="easyui-textbox" type="text" size="100" name="username"
                               data-options="required:true" value="<?= $user['username'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>类型:</td>
                    <td>
                        <select class="easyui-combobox" name="type">
                            <option value="0" selected>系统管理员</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>状态:</td>
                    <td>
                        <select class="easyui-combobox" name="status">
                            <option value="1" selected>开启</option>
                            <option value="0">关闭</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>备注:</td>
                    <td><input class="easyui-textbox" name="desc" value="<?= $user['desc'] ?>"
                               data-options="multiline:true,required:false"
                               style="width: 320px;height:120px"></td>
                </tr>

            </table>
        </form>

        <div style="padding:5px 0;">
            <a id="btnSave" href="<?= SITE_URL ?>/admin/sysman/edit?r=admin" class="easyui-linkbutton">保存</a>
            <a id="btnCancel" href="<?= SITE_URL ?>/admin/sysman?r=admin" class="easyui-linkbutton">取消</a>
        </div>
    </div>

</div>
</body>
<script>
    $('[name=status]').val(<?=$user['status']?>);
</script>

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
                            location.href = $('#btnCancel').attr('href');
                        } else {
                            alert(rep.message);
                            // alert('新增商品失败');
                        }
                    }, 'json')
                }
                return false;
            }
        });
    }


</script>
</html>