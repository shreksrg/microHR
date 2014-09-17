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
<body style="height: 100%">

<?php
if ($t == 'edit' && !$user) {
    echo '该用户不存在';
    exit;
}

?>

<div class="easyui-panel" style="width:100%; height: 1000px">

    <div style="padding:10px 60px 20px 60px">

        <form id="ff" method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>"/>
            <table cellpadding="5">
                <tr>
                    <td>用户名:</td>
                    <td><input class="easyui-textbox" type="text" size="32" name="username"
                               data-options="required:true" value="<?= $user['username'] ?>">
                    </td>
                </tr>
                <?php
                if ($t == 'append') {
                    ?>
                    <tr>
                        <td>密码:</td>
                        <td><input class="easyui-textbox" type="password" size="32" name="password"
                                   data-options="required:true" value="<?= $user['username'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>确认密码:</td>
                        <td><input class="easyui-textbox" type="password" size="32" name="confirmPwd"
                                   data-options="required:true" value="<?= $user['username'] ?>">
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>类型:</td>
                    <td>
                        <select class="easyui-combobox" name="type" panelheight="auto">
                            <option value="0" selected>系统管理员</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>状态:</td>
                    <td>
                        <select class="easyui-combobox" name="status" panelheight="auto">
                            <option value="1" selected>开启</option>
                            <option value="0">关闭</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>备注:</td>
                    <td><input class="easyui-textbox" name="comment" value="<?= $user['comment'] ?>"
                               data-options="multiline:true,required:false"
                               style="width: 320px;height:120px"></td>
                </tr>

            </table>
        </form>

        <div style="padding:5px 0;">
            <a id="btnSave" href="<?= SITE_URL ?>/admin/sysman/<?= $t ?>?r=admin" class="easyui-linkbutton">保存</a>
        </div>
    </div>

</div>
</body>
<script>
    $('[name=status]').val(<?=$user['status']?>);

    <?php
        if($t=='append'){
    ?>
    function validatePwd() {
        var r = true;
        if ($('[name=password]').val().length != $('[name=confirmPwd]').val().length) {
            r = false;
        }
        return r;
    }
    <?php }?>
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
                    try {
                        if (typeof(eval('validatePwd')) == "function") {
                            if (!validatePwd()) {
                                $.messager.alert('提示', '密码不一致', 'warning');
                                return false;
                            }
                        }

                    } catch (e) {
                    }

                    $.post($('#btnSave').attr('href'), $('form').serializeArray(), function (rep) {
                        if (rep.code == 0) {
                            window.parent.dgReload(); //刷新列表
                            $.messager.alert('信息', '操作成功', 'info', function () {
                                window.parent.closeTab(); //关闭当前标签
                            });
                        } else {
                            $.messager.alert('错误', rep.message, 'error');
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