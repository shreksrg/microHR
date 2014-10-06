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

    <div class="hr_tab">
        <?php
        if ($rows) {
            foreach ($rows as $row) {
                ?>
                <a href="<?= APP_URL ?>/executive/show?id=<?= $row['id'] ?>">
                    <ul>
                        <img src="<?= $row['avatar'] ?>"/>

                        <div class="pop">(<?= $row['favorites'] ?>)</div>
                        <h3><span><?= $row['name'] ?></span><?= $row['title'] ?></h3>

                        <p><?= $row['digest'] ?></p>
                    </ul>
                </a>
            <?php
            }
        } ?>

    </div>

</div>
<!--<script>
 $(".seniormanager_wrapper .hr_tab ul").click(function(){
	var a = $(this);
	var b = $(this).child("li");
	 $(".seniormanager_wrapper .hr_tab ul").css("display","none")
	 a.css("display","block")
	
	 setTimeout(function(){ 
	 	b.css("width","95%"); 
		b.addClass("close") 
	
	
	},1000 );	

	 
	});
</script>
--></body>

</html>
