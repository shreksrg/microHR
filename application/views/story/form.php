<?php
CView::show('layout/header', array('title' => '海亮校园招聘'));
?>


<body>
<div class="uploadstory_wrapper">
    <div class="uploadstory_title">你的故事</div>
    <div class="message">每个人是一个载体，更是一种能量，<span>请以下面卡片中的命题为主题，</span>写一篇故事，标题自拟，谈谈你的能力、经历、与众不同。</div>
    <div id="card_Container" class="small">
        <div id="cover">
            <h2><span>你抽到的命题是</span><br/>"我，是这么一个人"</h2>

            <form id="frmStory" action="<?= APP_URL ?>/stories/append?action=save">
                <input type="text" name="title" value="故事标题"/>
                <textarea name="content">请根据以上命题写下你的故事，字数不超过600字</textarea>
                <input type="hidden" name="token" value="<?= $token ?>"/>
            </form>
            <button class="submitstory">提交故事</button>
        </div>
        <div id="mask"></div>
    </div>
</div>

<script>
    $("#card_Container").click(function () {
        $(".uploadstory_title").addClass("fadeout");
        $(".message").addClass("fadeout");
        $("#card_Container").removeClass("small");
        $("#card_Container").toggleClass('flipped');
        $(this).unbind("click");
        setTimeout(function () {
            $("#card_Container #mask").css("display", "none");
        }, 1000);
    });
</script>

<script>

    function checkSubmit() {
        if ($('[name=title]').val().length <= 0) {
            alert('请填写故事标题');
            return false;
        }
        if ($('[name=content]').html().length <= 0) {
            alert('请填写故事内容');
            return false;
        }
        return true;
    }

    function submit() {
        var frm = $('#frmStory');
        $.post(frm.attr('action'), frm.serializeArray(), function (r) {
            if (r.code == 0) {
                alert('故事提交完成');
                location.href = '<?=APP_URL?>';
            } else {
                alert(r.message);
            }
        }, 'json')
    }


    $('.submitstory').click(function () {
        var reVal = checkSubmit();
        if (reVal != true) return false;
        submit();
        return false;

        $.get('<?=APP_URL?>/login/check?action=ajax', null, function (r) {
            alert(r.code);
            if (r.code == 0) {
                submit();
            } else {
                alert('登录超时');
                location.href = '<?=APP_URL?>/welcome/navigation';
            }
        }, 'json');
        return false;
    })

</script>

</body>

</html>
