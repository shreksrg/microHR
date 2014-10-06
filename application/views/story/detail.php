<?php
CView::show('layout/header', array('title' => '海亮校园招聘'));
?>
<style>
    body {
        background: #f3f7fc url(<?= WEB_PATH ?>/public/img/storybg.png) no-repeat center 0;
        background-size: 100% 106px;
    }
</style>

<body>
<div class="story_wrapper">
    <?php
    if ($detail) {
        $info = $detail['info'];
        $storyId = $info['id'];
        ?>
        <div class="detail">
            <h2><?= $info['title'] ?></h2>

            <p>
                <?= $info['content'] ?></p>

            <div class="tabbar"><span><?= $info['comments'] ?>篇评论 | <?= $info['flowers'] ?>
                    个喜欢</span><a class="heart  _favorite" href="#">喜欢</a><a class="comment"
                                                                            href="<?= APP_URL ?>/stories/comment?id=<?= $storyId ?>">评论</a>
            </div>
            <div class="comment_box">
                <?php
                foreach ($detail['comments'] as $comment) {
                    ?>
                    <ul>
                        <li><?= $comment['content'] ?></li>
                        <div class="name"><?= $comment['nickname'] ?>:</div>
                        <div class="time"><?= Utils::diffDateLabel($comment['create_time'], time()) ?></div>
                    </ul>
                <?php } ?>

            </div>

        </div>
    <?php } ?>
</div>
</body>

<script>
    //点赞

    function favorite() {
        $.get('<?=APP_URL?>/stories/appraise?t=1&id=<?=$storyId?>', null, function (r) {
            var errCode = r.code;
            if (errCode == 0) {
                alert('操作完成');
            } else if (errCode == 1008) {
                alert('您已经执行过该操作');
                return false;
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
