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
    <script type="text/javascript" src="/public/js/admin/formatter.js?v=<?= time() ?>"></script>
</head>

<body>

<div>
    <table id="dg" title="注册登记管理" style="width:100%; height:auto"
           data-options="rownumbers:true,singleSelect:false,method:'get',toolbar:'#toolbar',pageSize:20">
        <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'id',width:80">ID</th>
            <th data-options="field:'nickname',width:120,align:'left'">昵称</th>
            <th data-options="field:'wxid',width:120,align:'center'" formatter="formatWXID">微信ID</th>
            <th data-options="field:'gender',width:80,align:'center'" formatter="formatGender">性别</th>
            <th data-options="field:'mobile',width:120,align:'center'">手机号码</th>
            <th data-options="field:'academy',width:250,align:'left'">学院</th>
            <th data-options="field:'major',width:250,align:'left'">专业</th>
            <th data-options="field:'status',width:80,align:'center'" formatter="formatStatus">状态</th>
            <th data-options="field:'create_time',width:150,align:'left'" formatter="formatTime">创建时间</th>
        </tr>
        </thead>
    </table>
    <div id="toolbar" style="padding:5px;height:auto">
        <div style="margin-bottom:5px">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="append();">新增注册</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="edit();">编辑注册</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="drop();">删除注册</a>
        </div>
        <div>
            <div style="padding-bottom: 8px">
                昵称: <input class="easyui-numberbox" name="nickname" size="10" value="">
                微信ID: <input class="easyui-textbox" name="wxid" size="12" value="">
                性别: <select class="easyui-combobox" name="gender" panelHeight="auto" style="width:100px">
                    <option value="">全部</option>
                    <option value="0">女</option>
                    <option value="1">男</option>
                </select>
                手机号: <input class="easyui-textbox" name="mobile" size="12" value="">

                创建日期: <input class="easyui-datebox" name="ab_time" style="width:120px">
                To: <input class="easyui-datebox" name="ae_time" style="width:120px">

            </div>

            <div style="padding-bottom: 8px">

                状态: <select class="easyui-combobox" name="status" panelHeight="auto" style="width:100px">
                    <option value="">全部</option>
                    <option value="1">发布</option>
                    <option value="0">关闭</option>
                </select>

                学院: <input class="easyui-textbox" name="academy" size="18" value="">
                专业: <input class="easyui-textbox" name="major" size="18" value="">
                <a href="#" class="easyui-linkbutton" iconCls="icon-search"
                   onclick="doSearch();return false;">Search</a>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    var _micro_dataGrid, _micro_pager;

    //订单查询
    function doSearch() {
        _micro_dataGrid.datagrid('load', {
            nickname: $('[name=nickname]').val(),
            wxid: $('[name=wxid]').val(),
            gender: $('[name=gender]').val(),
            mobile: $('[name=mobile]').val(),
            academy: $('[name=academy]').val(),
            major: $('[name=major]').val(),
            status: $('[name=status]').val(),
            ab_time: $('[name=ab_time]').val(),
            ae_time: $('[name=ae_time]').val()
        });
    }

    function append() {
        location.href = '<?=SITE_URL?>/admin/registerman/append?r=admin';
    }

    //编辑
    function edit() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            location.href = "<?=SITE_URL?>/admin/registerman/edit?id=" + parseInt(row.id);
        } else {
            $.messager.alert('提示','请选择记录!','warning');
        }
    }

    // 删除
    function drop() {
        var rows = $('#dg').datagrid('getSelections');
        //console.log(rows);
        var ids = [];
        if (rows.length > 0) {
            $.messager.confirm('删除注册', '确定删除选择的注册记录?', function (r) {
                if (r) {
                    for (var i = 0 in rows) {
                        ids[i] = rows[i]['id'];
                    }
                    $.post('<?=SITE_URL?>/admin/registerman/drop', {'id': ids}, function (rep) {
                        if (rep.code == 0) {
                            $.messager.alert('信息','删除成功!','info');
                            // _micro_pager.pagination('refresh');
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert('错误','删除失败!','error');
                        }
                    }, 'json')

                }
            });
        } else {
            $.messager.alert('提示','请选择记录!','warning');
        }
    }

</script>
<script type="text/javascript">

    $(function () {
        _micro_dataGrid = $('#dg').datagrid({
            'url': '<?=SITE_URL?>/admin/registerman/registrant',
            'pagination': true
        })

        _micro_pager = _micro_dataGrid.datagrid('getPager');

        _micro_pager.pagination({
            showPageList: true,
            layout: ['list', 'sep', 'first', 'prev', 'links', 'next', 'last', 'sep', 'refresh']
        })

        //  var pager = _micro_dataGrid.datagrid('getPager');    // get the pager of datagrid

    })


</script>
</body>
</html>