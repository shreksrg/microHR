<?php
CView::show('layout/header', array('title' => '海亮校园招聘'));
?>
<style>
    body {
        background: #fff url(<?=WEB_PATH?>/public/img/hiring_process_bg.png) repeat-x;
        background-size: 1px 275px;
        height: 100%;
        overflow: hidden
    }
</style>

<body>

<div id="page">
    <div class="hiring_process_earth rotation"></div>

    <div class="hiring_process_step1">
        <div class="hr_man fadein_move"></div>
    </div>
    <div class="hiring_process_step2">
        <div class="hr_man">111</div>
    </div>
    <div class="hiring_process_step3">
        <div class="hr_man"></div>
    </div>
    <div class="hiring_process_step4">
        <div class="hr_man"></div>
    </div>
    <div class="hiring_process_step5">
        <div class="hr_man"></div>
    </div>
    <div class="hiring_process_step6">
        <div class="hr_man"></div>
    </div>
    <div class="hiring_process_step7">
        <div class="hr_man"></div>
    </div>
</div>
<script>
    var startX, startY, endX, endY, curPage = 1;
    document.getElementById("page").addEventListener("touchstart", touchStart, false);
    document.getElementById("page").addEventListener("touchmove", touchMove, false);
    document.getElementById("page").addEventListener("touchend", touchEnd, false);
    function touchStart(event) {
        var touch = event.touches[0];
        startX = touch.pageX;
    }

    function touchMove(event) {
        var touch = event.touches[0];
        endX = (startX - touch.pageX);

    }

    function touchEnd(event) {
        if (endX > 0) {
            //alert(curPage);
            if (curPage < 7) {
                nextPage = curPage + 1;
                $(".hiring_process_step" + curPage).css("visibility", "hidden");
                $(".hiring_process_step" + curPage).css("opacity", "0");
                $(".hiring_process_step" + curPage).css("-webkit-transform", "rotate(-90deg)");
                $(".hiring_process_step" + nextPage).css("visibility", "visible");
                $(".hiring_process_step" + nextPage).css("opacity", "1");
                $(".hiring_process_step" + nextPage).css("-webkit-transform", "rotate(0deg)");
                $(".hiring_process_step" + nextPage + " .hr_man").addClass("fadein_move");
                curPage++;
            }

        } else if (endX < 0) {
           // alert("22");
        }
        endX = 0;
    }

    //$("#page div").click(function(){
    function next_page() {
        var curPage = parseInt($(this).attr("class").substring(19, 20));
        var nextPage = curPage + 1;

        if (nextPage < 8) {
            $(this).css("visibility", "hidden");
            $(this).css("opacity", "0");
            $(this).css("-webkit-transform", "rotate(-90deg)");
            $(".hiring_process_step" + nextPage).css("visibility", "visible");
            $(".hiring_process_step" + nextPage).css("opacity", "1");
            $(".hiring_process_step" + nextPage).css("-webkit-transform", "rotate(0deg)");
            $(".hiring_process_step" + nextPage + " .hr_man").addClass("fadein_move");
        }
    }

</script>

</body>

</html>
