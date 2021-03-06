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
    <title>支付通知</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/main.js"></script>
</head>


<body>
<div class="page show">
    <?php
    if ($status == 'fail') {
        ?>
        <div class="failtitle fix">
            本次支付失败了
        </div>
        <button url="<?= SITE_URL ?>/item/order?id=<?= $orderId ?>" type="button" class="btn">再次支付</button>
    <?php } ?>

    <?php
    if ($status == 'success') {
        ?>
        <div class="successtitle fix">
            你已经成功支付了<?= $amount ?> 元
        </div>
        <button type="button" class="retry btn">测试我的人品</button>

    <?php } ?>
</div>
</body>

</html>
