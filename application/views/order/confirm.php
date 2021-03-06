<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,minimal-ui">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">

    <link rel="shortcut icon" href="/public/img/favicon.ico">
    <meta http-equiv="expires" content="-1">
    <title>信息确认</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/main.js"></script>


</head>


<body>
<div class="page show">
    <?php

    if ($info) {

        $order = (array)$info['order'];
        $item = (array)$info['item'];
        $goods = (array)$info['goods'];


        $time = Utils::getDiffTime(time(), $order['expire']);
        $leftTime = Utils::formatLTimeLabel($time);

        $expire = date('m月d日 H:i', $order['expire']);
        $lacks = $order['quota'] - $order['paids'];

        ?>
        <header>
            <h4>你即将发起一个节操测试：</h4>

            <h3><?= $order['message'] ?></h3>
        </header>

        <div class="tableview">
            <section class="status1 fix">
                <img class="pic" src="<?= $goods['img'] ?>"/>

                <h2>【<?= Matcher::matchOrigin($goods['origin']) ?>】 <?= $goods['title'] ?></h2>

                <div>总价：<span class="price"> <?= sprintf('%.2f', $order['gross']) ?></span>元</div>
                <div>筹集方式：<span class="collect"><?= $item['title'] ?></span></div>
            </section>
        </div>
        <div class="time">筹集截止时间：<span><?= $leftTime ?></span> （<?= $expire ?>
            ）<br/>离筹集成功还需<span> <?= $lacks ?> </span>人支持
        </div>
        <div class="information">联系人：<?= $consignee['consignee'] ?><br/>联系电话：<?= $consignee['mobile'] ?>
            <br/>收货地址：<?= $consignee['address'] ?><span
                class="tip">请确认收货地址，否则可能无法收到礼品</span></div>
        <!--<button type="button" class="share btn">点击右上方的按钮分享到朋友圈测人品</button>-->
        <div class="sharetipmask show"></div>
    <?php } ?>
</div>
</body>

<script>

    var shareData = {
        'imgUrl': "http://<?=SERVER_NAME?>/public/img/wexingimg.jpg",
        'link': "<?=SITE_URL?>/item/order?id=<?=$orderId?>",
        'title': "<?=$message?>",
        'desc': "我的人品挑战测试"
    };

    _namespace_micro.winxinShare(shareData);

</script>

</html>
