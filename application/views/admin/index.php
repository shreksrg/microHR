<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= MCIRO_PANEL_TITLE ?></title>
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/public/js/ui/themes/common.css">
    <script type="text/javascript" src="/public/js/ui/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/ui/jquery.easyui.min.js"></script>
</head>
<body class="easyui-layout">
<div data-options="region:'north',border:false" style="height:60px;background:#B3DFDA;padding:10px">
    <span style="font-size: 24px">海亮集团微信招聘管理平台</span>
    <span style="float: right"><a href="<?= SITE_URL ?>/admin/loginman/logout"
                                  onclick="return logout(this);">登出</a></span>
</div>
<div data-options="region:'west',split:true,title:'导航栏'" style="width:180px; padding-top: 10px">

    <ul class="easyui-tree">
        <li>
            <span>基础管理</span>
            <ul>
                <li><a class="btnNav" href="<?= SITE_URL ?>/admin/registerman">登记管理</a></li>
                <li><a class="btnNav" href="<?= SITE_URL ?>/admin/storyman">故事管理</a></li>
                <li><a class="btnNav" href="<?= SITE_URL ?>/admin/apiman/menu">微信菜单</a></li>
                <li><a class="btnNav" href="<?= SITE_URL ?>/admin/sysman?r=admin">系统用户</a></li>
            </ul>
        </li>
    </ul>
</div>
<div data-options="region:'south',border:false" style="height:50px;background:#A9FACD;padding:10px;">海亮集团 copyright
    2014~2015
</div>
<div id="mainArea" data-options="region:'center'" style="overflow: hidden">
    <iframe src="" frameborder="0" width="100%" height="100%"></iframe>
</div>
</body>
<script>
    $(function () {
        $('.btnNav').click(function () {
            $('iframe').attr('src', $(this).attr('href'));
            return false;
        })
    })
    function logout(e) {
        var url = $(e).attr('href');
        $.get(url, null, function (rep) {
            if (rep.code == 0) {
                location.href = '<?=SITE_URL?>/admin/loginman';
            } else alert('登出失败');
        }, 'json')
        return false;
    }
</script>
</html>