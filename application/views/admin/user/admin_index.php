<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/common.css">
    <script type="text/javascript" src="/public/js/ui/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/ui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/public/js/admin/formatter.js?v=<?= time() ?>"></script>
    <script type="text/javascript" src="/public/js/admin/common.js?v=<?= time() ?>"></script>
</head>

<body>

<div id="tt" class="easyui-tabs" style="height:auto">
    <div title="系统用户管理">
        <table id="dg" style="width:100%; height:auto"
               data-options="rownumbers:true,singleSelect:false,method:'get',toolbar:toolbar,pageSize:20">
            <thead>
            <tr>
                <th data-options="field:'ck',checkbox:true"></th>
                <th data-options="field:'id',width:60">ID</th>
                <th data-options="field:'username',width:150,align:'center'">用户名</th>
                <th data-options="field:'type',width:120,align:'center'" formatter="formatUserType">用户类型</th>
                <th data-options="field:'status',width:100,align:'center'" formatter="formatStatus">状态</th>
                <th data-options="field:'create_time',width:180,align:'left'" formatter="formatTime">创建时间</th>
            </tr>
            </thead>
        </table>
    </div>
</div>


<div id="dlg" class="easyui-dialog" style="width:400px;height:180px;padding:10px 20px"
     closed="true" buttons="#dlg-buttons" modal="true">

    <form id="fm" method="post" novalidate>
        <table cellspacing="8">
            <tr>
                <td>新 密 码</td>
                <td><input name="password" class="easyui-textbox" required="true" type="password"></td>
            </tr>
            <tr>
                <td>确认密码</td>
                <td><input name="confirm" class="easyui-textbox" required="true" type="password"></td>
            </tr>
        </table>
    </form>
</div>


<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePassword()"
       style="width:60px">确定</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
       onclick="javascript:$('#dlg').dialog('close')" style="width:60px">取消</a>
</div>


<script type="text/javascript">

    var toolbar = [
        {
            text: '新增用户',
            iconCls: 'icon-add',
            handler: function () {
                addTab('新增管理员', '<?=SITE_URL?>/admin/sysman/append?r=admin');

            }
        },
        {
            text: '编辑用户',
            iconCls: 'icon-edit',
            handler: function () {
                editUser();
            }
        },
        {
            text: '设置密码',
            iconCls: 'icon-edit',
            handler: function () {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('setTitle', '设置密码');
                    $('#fm').form('clear');
                } else {
                    $.messager.alert('提示', '请选择用户', 'info');
                }

            }
        },
        {
            text: '删除用户',
            iconCls: 'icon-cut',
            handler: function () {
                deleteUser()
            }
        }

    ];
</script>
<script type="text/javascript">
    var _micro_dataGrid, _micro_pager;
    $(function () {
        //动态加载数据
        // $('#dg').datagrid()

        _micro_dataGrid = $('#dg').datagrid({
            'url': '<?=SITE_URL?>/admin/sysman/users',
            'pagination': true
        })

        _micro_pager = _micro_dataGrid.datagrid('getPager');

        _micro_pager.pagination({
            showPageList: true,
            layout: ['list', 'sep', 'first', 'prev', 'links', 'next', 'last', 'sep', 'refresh']
        })
        //  var pager = _micro_dataGrid.datagrid('getPager');    // get the pager of datagrid
    })

    //编辑会员
    function editUser() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            addTab('编辑用户', "<?=SITE_URL?>/admin/sysman/edit?r=admin&id=" + row.id);

        } else {
            $.messager.alert('提示', '请选择用户!', 'info');
        }
    }

    //保存编辑密码
    function savePassword() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            var url = "<?=SITE_URL?>/admin/sysman/edit?r=password&id=" + row.id;
            var pwd = $('[name=password]').val(), cpwd = $('[name=confirm]').val();

            $('#fm').form('submit', {
                onSubmit: function () {
                    var re = $(this).form('validate');
                    if (re != true) return false;
                    if (cpwd != pwd) {
                        $.messager.alert('错误', '密码不一致!', 'error');
                        return false;
                    }

                    $.post(url, {'password': pwd}, function (rep) {
                        if (rep.code == 0) {
                            $.messager.alert('信息', '设置成功!', 'info');
                            $('#dlg').dialog('close');
                        } else {
                            $.messager.alert('错误', '设置失败!', 'error');
                        }
                    }, 'json');
                    return false;
                }
            })

            /*  $('#fm').form('submit', {
             onSubmit: function () {
             var re = $(this).form('validate');
             if (re != true) return false;
             if (cpwd != pwd) return false;
             $.post(url, {'password': pwd}, function (rep) {
             if (rep.code == 0) {
             alert('设置成功');
             $('#dlg').dialog('close');
             } else {
             alert('设置失败')
             }
             }, 'json')
             return false;
             }
             )*/

        } else {
            $.messager.alert('信息', '请选择用户!', 'warning');
        }
    }

    // 删除用户
    function deleteUser() {
        var rows = $('#dg').datagrid('getSelections');
        //console.log(rows);
        var ids = [];
        if (rows.length > 0) {
            $.messager.confirm('删除用户', '确定删除选择的用户?', function (r) {
                if (r) {
                    for (var i = 0 in rows) {
                        ids[i] = rows[i]['id'];
                    }
                    $.post('<?=SITE_URL?>/admin/sysman/drop', {'id': ids}, function (rep) {
                        if (rep.code == 0) {
                            $.messager.alert('信息', '删除成功!', 'info');
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert('错误', '删除失败!', 'error');
                        }
                    }, 'json')

                }
            });
        } else {
            $.messager.alert('信息', '请选择用户!', 'warning');
        }
    }
</script>
</body>
</html>