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
        <a href="<?= APP_URL ?>/senior/show">
            <ul>
                <img src="<?= WEB_PATH ?>/public/img/hr.png"/>

                <div class="pop">(99)</div>
                <h3><span>姓名</span>高级人事总监</h3>

                <p>履历等两行文字简介职务、履历等两行文字简介</p>
            </ul>
        </a>
        <ul>
            <img src="<?= WEB_PATH ?>/public/img/hr.png"/>

            <div class="pop">(99)</div>
            <h3><span>姓名</span>高级人事总监</h3>

            <p>履历等两行文字简介职务、履历等两行文字简介</p>
        </ul>
        <ul>
            <img src="<?= WEB_PATH ?>/public/img/hr.png"/>

            <div class="pop">(99)</div>
            <h3><span>姓名</span>高级人事总监</h3>

            <p>履历等两行文字简介职务、履历等两行文字简介</p>
        </ul>
        <ul>
            <img src="<?= WEB_PATH ?>/public/img/hr.png"/>

            <div class="pop">(99)</div>
            <h3><span>姓名</span>高级人事总监</h3>

            <p>履历等两行文字简介职务、履历等两行文字简介</p>
        </ul>

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
