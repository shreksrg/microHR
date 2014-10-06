<?php
CView::show('layout/header', array('title' => '海亮校园招聘'));
?>

<style>
    body {
        background: #e9f7fa url(<?=WEB_PATH?>/public/img/seniormanagerbg.png) no-repeat center top;
        background-size: 480px 186px;
    }
</style>


<body>
<div class="seniormanager_wrapper">
    <h2>高管面对面</h2>

    <div class="hr_tab_detail">
        <ul class="top">
            <img class="portrait" src="<?= WEB_PATH ?>/public/img/hr.png"/>

            <h3><span><?= $detail['name'] ?></span><?= $detail['title'] ?></h3>
        </ul>
        <ul class="center">
            <p><?= $detail['content'] ?></p>

        </ul>
        <ul class="bottom _favorite"><a href="#">喜欢</a>
        </ul>

    </div>

</body>
<script>
    //点赞

    function favorite() {
        $.get('<?=APP_URL?>/executive/appraise?id=<?=$detail['id']?>', null, function (r) {
            var errCode = r.code;
            if (errCode == 0) {
                alert('操作完成');
            } else if (errCode == 1001) {
                alert('记录不存在');
            } else if (errCode == 1008) {
                alert('您已经执行过该操作');
            } else {
                alert('系统执行异常');
            }
        }, 'json');
    }

    $('._favorite').click(function () {
        favorite();
        return false;
        $.get('<?=APP_URL?>/login/check?action=ajax', null, function (r) {
            if (r.code == 0) {
                favorite();
            } else {
                alert('登录超时');
                location.href = '<?=APP_URL?>/welcome/navigation';
            }
        }, 'json');

    })


</script>

</html>
