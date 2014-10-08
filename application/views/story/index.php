<?php
CView::show('layout/header', array('title' => '海亮校园招聘'));
?>

<style>
    body {
        background: #f3f7fc url(<?= WEB_PATH ?>/public/wx/img/storybg.png) no-repeat center 0;
        background-size: 100% 106px;
    }
</style>


<body>
<div class="story_wrapper">
    <div class="cont">
        <?php
        if ($rows) {
            foreach ($rows as $row) {
                ?>
                <a href="<?= APP_URL ?>/stories/show?id=<?= $row['id'] ?>">
                    <ul>
                        <h2><?= $row['title'] ?></h2>

                        <div class="heart">(<?= $row['comments'] ?>)</div>
                        <div class="comment">(<?= $row['flowers'] ?>)</div>
                        <p><?= $row['digest'] ?></p>
                    </ul>
                </a>
            <?php }
        } ?>
    </div>
</div>
</body>

</html>
