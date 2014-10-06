<?php
CView::show('layout/header', array('title' => '海亮校园招聘'));
?>

<body>
<div class="index_wrapper">
    <ul>
        <li class="box1"><a href="<?= APP_URL ?>/welcome/position">招聘职位</a></li>
        <li class="box2"><a href="<?= APP_URL ?>/welcome/process">应聘流程</a></li>
        <li class="box3"><a href="<?= APP_URL ?>/welcome">招聘政策</a></li>
        <li class="box4"><a href="<?= APP_URL ?>/welcome/schedule">招聘行程</a></li>
        <li class="box5"><a href="<?= APP_URL ?>/register">微注册</a></li>
        <li class="box6"><a href="<?= APP_URL ?>/welcome/post">简历投递</a></li>
        <li class="box7"><a href="#">QA</a></li>
    </ul>
</div>

</body>

</html>
