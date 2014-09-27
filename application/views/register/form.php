<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="shortcut icon" href="img/favicon.ico">
    <meta http-equiv="expires" content="-1">
    <title>海亮校园招聘</title>
    <link rel="stylesheet" type="text/css" href="/public/wx/css/main.css">
    <script src="/public/wx/js/jquery.min.js"></script>
    <script src="/public/wx/js/common.js?v=<?= time() ?>"></script>
    <script src="/public/wx/js/main.js?v=<?= time() ?>"></script>
    <script type="text/javascript" src="/public/wx/js/iscroll.js"></script>
    <script type="text/javascript">
        var myScroll;

        function loaded() {
            myScroll = new iScroll('wrapper', {
                snap: true,
                momentum: false,
                hScrollbar: false,
                onScrollEnd: function () {
                    document.querySelector('#indicator > li.active').className = '';
                    document.querySelector('#indicator > li:nth-child(' + (this.currPageX + 1) + ')').className = 'active';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', loaded, false);
    </script>
    <style type="text/css" media="all">
        #wrapper {
            width: 300px;
            min-height: 300px;
            overflow: hidden;
            margin: 10% auto 0;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        #scroller {
            width: 1500px;
            height: 100%;
            float: left;
            padding: 0;
        }

        #scroller ul {
            list-style: none;
            display: block;
            float: left;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        #scroller li {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
            display: block;
            float: left;
            width: 300px;
            height: 300px;
            text-align: center;
            position: relative;
        }

        #nav {
            width: 225px;
            height: 30px;
            margin: 20px auto 0;
            background: url(/public/img/register_steplinebg.png) repeat-x;
            background-size: 1px 25px
        }

        #indicator, #indicator > li {
            display: block;
            float: left;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #indicator {
            width: 225px;
        }

        #indicator > li {
            width: 25px;
            height: 25px;
            -webkit-border-radius: 30px;
            background: #92cedd;
            overflow: hidden;
            margin-left: 25px;
            text-align: center;
            line-height: 25px;
        }

        #indicator > li:first-child {
            margin-left: 0;
        }

        #indicator > li.active {
            background: #fff83b;
            color: #4cbad5
        }

    </style>
</head>
<body>

<div id="wrapper">
    <div id="scroller">
        <ul id="thelist">
            <form action="<?= APP_URL ?>/register?action=append" id="frmRegister" method="post">
                <input type="hidden" name="token" value="<?= $token ?>"/>
                <li>
                    <div class="register_question_title">请输入昵称</div>
                    <div class="register_man"><input name="nickname" class="nickname" type="text"/></div>
                </li>
                <li>
                    <div class="register_question_title">你是男生or女生？</div>
                    <div class="register_sex">
                        <input name="gender" id="male" type="radio" checked="checked" value="1"/><label
                            class="register_man2 active" for="male"><span class="sex cur">男生</span></label>
                        <input name="gender" id="female" type="radio" value="0"/><label class="register_women"
                                                                                        for="female"><span
                                class="sex">女生</span></label>

                        <div class="register_education">
                </li>
                <li>
                    <div class="register_question_title">你是哪所学校的？</div>
                    <div class="register_hat"><input name="academy" class="university" type="text"/></div>
                </li>
                <li>
                    <div class="register_question_title">你的专业和学历是？</div>
                    <div class="register_special"><input name="major" class="special" type="text"/></div>
                    <div class="register_education">
                        <input name="edu" id="sc" type="radio" value="1" checked="checked"/><label class="active"
                                                                                                   style="margin:0"
                                                                                                   for="sc">大专</label>
                        <input name="edu" id="md" type="radio" value="2"/><label for="md">本科</label>
                        <input name="edu" id="ms" type="radio" value="3"/><label for="ms">硕士</label>
                    </div>
                </li>
                <li>
                    <div class="register_question_title">留下你的手机号？</div>
                    <div class="register_phone"><input class="phone" name="mobile" type="text" value=""/></div>
                    <button type="submit" class="register_submit">注册</button>
                </li>
            </form>
            <input name="reUrl" type="hidden" value="<?= APP_URL ?>"/>
        </ul>
    </div>

</div>
<div>
    <iframe id="frmAuth"
            src="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx8f7f91904d10aa54&redirect_uri=http%3A%2F%2Fapi.microhr.com%2Flogin%2Fauth&response_type=code&scope=snsapi_base&state=ok#wechat_redirect"
            frameborder="0" width="400" height="200" scrolling="no"
            style="display: block; background: darkgray;"></iframe>
</div>

<div id="nav">
    <ul id="indicator">
        <li class="active">1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
    </ul>
</div>

<script>
    $("#scroller li .register_sex label").click(function () {
        $("#scroller li .register_sex label").removeClass("active");
        $(this).addClass("active");
        $(".sex").removeClass("cur");
        $(this).find(".sex").addClass("cur");
    });
    $("#scroller li .register_education label").click(function () {
        $("#scroller li .register_education label").removeClass("active");
        $(this).addClass("active");
    });
</script>

<script>
    var frmReg = $('#frmRegister')
    frmReg.submit(function () {
        var chk = checkSubmitAll();
        if (chk) {
            $.get('<?=APP_URL?>/login/check?action=ajax', null, function (r) {
                if (r.code == 0) {
                    submit();
                } else {
                    alert('登录超时');
                    location.href = '<?=APP_URL?>/welcome/navigation';
                }
            }, 'json')
        }
        return false;
    })

    function error() {
        alert('验证授权失败');
    }

    function submit() {
        $.ajax({
            url: frmReg.attr('action'),
            type: 'post',
            data: frmReg.serializeArray(),
            dataType: "json",
            success: function (rep) {
                if (rep.code == 0) {
                    alert('注册成功');
                    //location.href = $('[name=reUrl]').val();
                } else {
                    alert(rep.message);
                }
            }
        })
    }
</script>
</body>
</html>