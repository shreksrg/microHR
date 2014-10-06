<?php
CView::show('layout/header', array('title' => '海亮校园招聘'));
?>


<body>
<div class="uploadstory_wrapper">
    <div class="small">
        <div id="cover">

            <form id="frmComment" action="<?= APP_URL ?>/stories/comment?r=save">
                <input type="hidden" name="id" value="<?= $storyId ?>"/>
                <textarea rows="8" cols="48" name="content"></textarea>
                <input type="hidden" name="token" value="<?= $token ?>"/>
            </form>
            <button class="submitComment">提交评论</button>
        </div>
    </div>
</div>

<script>


    function checkSubmit() {
        if ($('[name=content]').val().length <= 0) {
            alert('请填写评论内容');
            return false;
        }
        return true;
    }

    function submit() {
        var frm = $('#frmComment');
        $.post(frm.attr('action'), frm.serializeArray(), function (r) {
            if (r.code == 0) {
                alert('评论提交完成');
                location.href = '<?=APP_URL?>';
            } else {
                alert(r.message);
            }
        }, 'json')
    }

    $('.submitComment').click(function () {
        var reVal = checkSubmit();
        if (reVal != true) return false;
        submit();
        return false;

        $.get('<?=APP_URL?>/login/check?action=ajax', null, function (r) {
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
