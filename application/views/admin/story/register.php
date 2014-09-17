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
    <script type="text/javascript" src="/public/js/admin/formatter.js?v=<?=time()?>"></script>
</head>

<body>

<div>
    <table id="dg" style="width:100%; height:auto"
           data-options="rownumbers:false,singleSelect:true,method:'get',pageSize:10">
        <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'id',width:80">ID</th>
            <th data-options="field:'nickname',width:100,align:'left'">昵称</th>
            <th data-options="field:'wxid',width:100,align:'center'" formatter="formatWXID">微信ID</th>
            <th data-options="field:'gender',width:80,align:'center'" formatter="formatGender">性别</th>
            <th data-options="field:'mobile',width:120,align:'center'">手机号码</th>
            <th data-options="field:'academy',width:180,align:'left'">学院</th>
            <th data-options="field:'major',width:180,align:'left'">专业</th>
        </tr>
        </thead>
    </table>
</div>
<script>

</script>


<script type="text/javascript">
    var _micro_dataGrid, _micro_pager;
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