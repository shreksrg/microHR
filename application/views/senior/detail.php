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

            <h3><span>许成宝</span>高级人事总监</h3>
        </ul>
        <ul class="center">
            <p>
                文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介履历等两行文字简介职务、履历等两行文字简介</p>
        </ul>
        <ul class="bottom"><a href="#">喜欢</a>
        </ul>

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
    -->
</body>

</html>
