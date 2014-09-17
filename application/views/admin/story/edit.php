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
<?php
if ($t == 'edit' && !$row) {
    echo '记录不存在';
    exit;
}
?>
<div class="easyui-panel" title="编辑故事" style="width:100%; height: 100%">

    <div style="padding:10px 60px 20px 60px">
        <form id="ff" method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
            <table cellpadding="5">
                <tr>
                    <td>登记ID:</td>
                    <td><input class="easyui-textbox" type="text" size="32" name="register_id"
                               data-options="required:true"
                               value="<?= $row['register_id'] ?>" readonly>
                        <input type="button" id="btnSelRegister" value="选择登记Id"/>
                    </td>
                </tr>
                <tr>
                    <td>微信ID:</td>
                    <td><input class="easyui-textbox" type="text" size="32" name="wxid" data-options=""
                               value="<?= $row['wxid'] ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>鲜花数:</td>
                    <td><input class="easyui-numberbox" type="text" size="32" name="flowers" data-options="required:true"
                               value="<?= $row['flowers'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>鸡蛋数:</td>
                    <td><input class="easyui-numberbox" type="text" size="32" name="eggs" data-options="required:true"
                               value="<?= $row['eggs'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>评分数:</td>
                    <td><input class="easyui-numberbox" type="text" size="32" name="grade" data-options="required:true"
                               value="<?= $row['grade'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>状态:</td>
                    <td>
                        <select class="easyui-combobox" name="status">
                            <option value="1" selected>通过审核</option>
                            <option value="0">等待审核</option>
                            <option value="-1">未通过审核</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>故事摘要:</td>
                    <td><input class="easyui-textbox" name="digest" data-options="multiline:true,required:true"
                               style="width: 640px;height:120px" value="<?= $row['digest'] ?>"></td>
                </tr>
                <tr>
                    <td>故事内容:</td>
                    <td><input class="easyui-textbox" name="content" data-options="multiline:true,required:true"
                               style="width: 640px;height:240px" value="<?= $row['content'] ?>"></td>
                </tr>

            </table>
        </form>
        <div style="padding:5px 0;">
            <a id="btnSave" href="<?= SITE_URL ?>/admin/storyman/<?= $t ?>" class="easyui-linkbutton">保存</a>
            <a id="btnCancel" href="<?= SITE_URL ?>/admin/storyman" class="easyui-linkbutton">取消</a>
        </div>
    </div>


</div>


<div id="dlg" class="easyui-dialog" title="选择登记信息"
     style="width:808px;height:430px; overflow:hidden "
     data-options="buttons:'#dlg-buttons',modal:true,closed:true">
    <iframe id="frmRegister" name="frmRegister" src="" frameborder="0" width="100%" height="100%"
            scrolling="no"></iframe>
</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:saveSelected()">确定</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')">关闭</a>
</div>


</body>
<script>
    $('[name=gender]').val(<?=$row['gender']?>);
    $('[name=status]').val(<?=$row['status']?>);
</script>

<script>
    var _validate = false;
    $('#btnSave').click(function () {
        submitForm();
        return false;
    })

    $('#btnSelRegister').click(function () {
        $('#dlg').dialog('open')
        $('#frmRegister').attr('src', '<?=APP_URL?>/storyman/register')
        return false;
    })

    /**
     * 保存选择
     */
    function saveSelected() {
        var _micro_dataGrid = window.frames['frmRegister']._micro_dataGrid;
        var row = _micro_dataGrid.datagrid('getSelected');
        if (row) {
            $('#ff').form('disableValidation').form('load', {
                register_id: row.id,
                wxid: row.wxid,
                mobile: row.mobile
            });
            $('#dlg').dialog('close');
        } else {
            $.messager.alert('提示', '请选择记录', 'warning');
        }
    }


    function submitForm() {
        $('form').form('submit', {
            onSubmit: function () {
                var re = $(this).form('enableValidation').form('validate');
                if (re == true) {
                    $.post($('#btnSave').attr('href'), $('form').serializeArray(), function (rep) {
                        if (rep.code == 0) {
                            $.messager.alert('信息', '操作成功', 'info', function () {
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