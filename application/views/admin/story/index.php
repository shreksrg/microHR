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
    <script type="text/javascript" src="/public/js/admin/formatter.js?v=<?= time(); ?>"></script>
</head>

<body>

<div>
    <table id="dg" title="故事管理" style="width:100%; height:auto"
           data-options="rownumbers:true,singleSelect:false,method:'get',toolbar:'#toolbar',pageSize:20">
        <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'id',width:100">ID</th>
            <th data-options="field:'register_id',width:100">登记ID</th>
            <th data-options="field:'wxid',width:100">微信ID</th>
            <th data-options="field:'flowers',width:100,align:'center'">鲜花数</th>
            <th data-options="field:'eggs',width:100,align:'center'">鸡蛋数</th>
            <th data-options="field:'grade',width:100,align:'center'">评分</th>
            <th data-options="field:'digest',width:300,align:'left'">故事摘要</th>
            <th data-options="field:'status',width:100,align:'center'" formatter="formatAudit">状态</th>
            <th data-options="field:'create_time',width:150,align:'left'" formatter="formatTime">创建时间</th>
        </tr>
        </thead>
    </table>

    <div id="toolbar" style="padding:5px;height:auto">
        <div style="margin-bottom:5px">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="append();">新增故事</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="edit();">编辑故事</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="drop();">删除故事</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="audit();">故事审核</a>
        </div>
        <div>
            <div style="padding-bottom: 8px">
                登记ID: <input class="easyui-numberbox" name="register_id" size="10" value="">
                微信ID: <input class="easyui-textbox" name="wxid" size="12" value="">

                创建日期: <input class="easyui-datebox" name="ab_time" style="width:120px">
                To: <input class="easyui-datebox" name="ae_time" style="width:120px">
                <a href="#" class="easyui-linkbutton" iconCls="icon-search"
                   onclick="doSearch();return false;">Search</a>
            </div>

            <div style="padding-bottom: 8px">

                审核状态: <select class="easyui-combobox" name="status" panelHeight="auto" style="width:100px">
                    <option value="">全部</option>
                    <option value="1">通过审核</option>
                    <option value="0">等待审核</option>
                    <option value="-1">未通过审核</option>
                </select>

                排序: <select class="easyui-combobox" name="sort" panelHeight="auto" style="width:150px">
                    <option value="">不限</option>
                    <option value="flowers_desc">鲜花数(降序)</option>
                    <option value="flowers_asc">鲜花数(升序)</option>
                    <option value="eggs_desc">鸡蛋数(降序)</option>
                    <option value="eggs_asc">鸡蛋数(升序)</option>
                    <option value="grade_desc">评分数(降序)</option>
                    <option value="grade_asc">评分数(升序)</option>
                </select>


                鲜花数: <input class="easyui-numberbox" name="min_flowers" size="6"> ~ <input class="easyui-numberbox"
                                                                                           name="max_flowers" size="6">
                鸡蛋数: <input class="easyui-numberbox" name="min_eggs" size="6"> ~ <input class="easyui-numberbox"
                                                                                        name="max_eggs" size="6">
                评分数: <input class="easyui-numberbox" name="min_grade" size="6"> ~ <input class="easyui-numberbox"
                                                                                         name="max_grade" size="6">

            </div>
        </div>
    </div>
</div>

<div id="dlg" class="easyui-dialog" style="width:400px;height:180px;padding:10px 20px"
     closed="true" buttons="#dlg-buttons" modal="true">

    <form id="fm" method="post" novalidate>
        <table cellspacing="8">
            <tr>
                <td>选择审核状态</td>
                <td>
                    <select class="easyui-combobox" name="status" panelHeight="auto" style="width:150px">
                        <option value="-1">不通过审核</option>
                        <option value="0">等待审核</option>
                        <option value="1" selected>通过审核</option>
                    </select></td>
            </tr>
        </table>
    </form>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveAudit()"
       style="width:60px">确定</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
       onclick="javascript:$('#dlg').dialog('close')" style="width:60px">取消</a>
</div>


<script type="text/javascript">
    var _micro_dataGrid, _micro_pager;

    //订单查询
    function doSearch() {
        _micro_dataGrid.datagrid('load', {
            register_id: $('[name=register_id]').val(),
            wxid: $('[name=wxid]').val(),
            min_flowers: $('[name=min_flowers]').val(),
            max_flowers: $('[name=max_flowers]').val(),
            min_eggs: $('[name=min_eggs]').val(),
            max_eggs: $('[name=max_eggs]').val(),
            min_grade: $('[name=min_grade]').val(),
            max_grade: $('[name=max_grade]').val(),
            status: $('[name=status]').val(),
            sort: $('[name=sort]').val(),
            ab_time: $('[name=ab_time]').val(),
            ae_time: $('[name=ae_time]').val()
        });
    }

    function append() {
        location.href = '<?=SITE_URL?>/admin/storyman/append';
    }


    //编辑
    function edit() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            location.href = "<?=SITE_URL?>/admin/storyman/edit?id=" + parseInt(row.id);
        } else {
            $.messager.alert('提示', '请选择故事', 'warning')
        }
    }

    // 删除
    function drop() {
        var rows = $('#dg').datagrid('getSelections');
        //console.log(rows);
        var ids = [];
        if (rows.length > 0) {
            $.messager.confirm('删除故事', '确定删除选择的故事?', function (r) {
                if (r) {
                    for (var i = 0 in rows) {
                        ids[i] = rows[i]['id'];
                    }
                    $.post('<?=SITE_URL?>/admin/storyman/drop', {'id': ids}, function (rep) {
                        if (rep.code == 0) {
                            $.messager.alert('提示', '删除成功', 'info')
                            $('#dg').datagrid('reload')
                        } else {
                            $.messager.alert('错误', '删除失败', 'error')
                        }
                    }, 'json')

                }
            });
        } else {
            $.messager.alert('提示', '请选择故事', 'warning')

        }
    }

    //审核
    function audit() {
        var rows = $('#dg').datagrid('getSelections');
        if (rows.length > 0) {
            $('#dlg').dialog('open').dialog('setTitle', '审核故事');
            $('#fm input[name=status]').val(1);
        } else {
            $.messager.alert('提示', '请选择故事', 'info');
        }
    }


    function saveAudit() {
        var rows = $('#dg').datagrid('getSelections');
        var ids = [];

        var status = $('#fm').find('[name=status]').val();

        if (rows.length > 0) {
            for (var i = 0 in rows) {
                ids[i] = rows[i]['id'];
            }

            $.post('<?=SITE_URL?>/admin/storyman/audit', {'id': ids, 'status': status}, function (rep) {
                if (rep.code == 0) {
                    $.messager.alert('信息', '设置成功!', 'info');
                    $('#dlg').dialog('close')
                    $('#dg').datagrid('reload');
                } else {
                    $.messager.alert('错误', '设置失败!', 'error');
                }
            }, 'json')


        } else {
            $.messager.alert('信息', '请选择用户!', 'warning');
        }
    }


</script>
<script type="text/javascript">

    $(function () {
        _micro_dataGrid = $('#dg').datagrid({
            'url': '<?=SITE_URL?>/admin/storyman/stories',
            'pagination': true
        })

        _micro_pager = _micro_dataGrid.datagrid('getPager');

        _micro_pager.pagination({
            showPageList: true,
            layout: ['list', 'sep', 'first', 'prev', 'links', 'next', 'last', 'sep', 'refresh']
        })

        //  var pager = _micro_dataGrid.datagrid('getPager');    // get the pager of datagrid

    })


    function formatAudit(val, row) {
        var val = parseInt(val);
        var txt = "--";
        if (val == -1) {
            txt = '<span style="color: red">未通过审核</span>';
        }
        if (val == 0) {
            txt = '<span style="color:sandybrown">等待审核</span>';
        }
        if (val == 1) {
            txt = '<span style="color: green">通过审核</span>';
        }
        return txt;
    }


</script>
</body>
</html>