/*------------------------------------------------------------------------
 * Copyright (c) 2014 hailiang All rights reserved. by Jackal
 ------------------------------------------------------------------------*/

$(function () {

    document.querySelector(".blackboard").addEventListener("webkitAnimationEnd", function () {
        $(".boardleg").addClass("fadein");
    })
    document.querySelector(".boardleg").addEventListener("webkitAnimationEnd", function () {
        $(".man").addClass("out");
    })
    document.querySelector(".man").addEventListener("webkitAnimationEnd", function () {
        $(".text_title1").addClass("fadein");
    })
    document.querySelector(".text_title1").addEventListener("webkitAnimationEnd", function () {
        $(".text_cont1").addClass("zoomin");
    })
    document.querySelector(".text_cont1").addEventListener("webkitAnimationEnd", function () {
        $(".text_title2").addClass("fadein");
    })
    document.querySelector(".text_title2").addEventListener("webkitAnimationEnd", function () {
        $(".text_cont2").addClass("zoomin");
    })
    document.querySelector(".text_cont2").addEventListener("webkitAnimationEnd", function () {
        $(".nextarrow").addClass("fadein");
    })

    $(".nextarrow").click(function () {
        //$(".page1").css("left","-100%");
        //$(".page2").css("left","0");
        $(".blackboard").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".boardleg").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".man").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".text_title1").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".text_cont1").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".text_title2").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".text_cont2").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".nextarrow").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".blackboard").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".blackboard").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");

        $(".biground").addClass("roundin");

    });
    document.querySelector(".biground").addEventListener("webkitAnimationEnd", function () {
        $(".man2").addClass("fadein");
    })
    document.querySelector(".man2").addEventListener("webkitAnimationEnd", function () {
        $(".light").addClass("shineN");
    })
    document.querySelector(".light").addEventListener("webkitAnimationEnd", function () {
        $(".nextarrow2").addClass("fadein");
    })

    $(".nextarrow2").click(function () {
        $(".biground").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".man2").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".light").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");
        $(".nextarrow2").css("transition", "all .3s linear").css("left", "-400px").css("top", "-100px");

        $(".man3").addClass("roundin");

    });
    document.querySelector(".man3").addEventListener("webkitAnimationEnd", function () {
        $(".nextarrow3").addClass("fadein");
    })


//	$(".indexbg").click(function(){ 
//		$(this).addClass("dismiss");
//		//$(this).removeClass("show");
//		document.querySelector(".indexbg").addEventListener("webkitAnimationEnd", function(){
//			$(this).removeClass("show");
//			$(".page").addClass("show");
//		})
//	});
});


function alertView(wrongmessage) {
    $(".mask").addClass("show");
    $(".dailog span").text(wrongmessage);
}


//验证手机
function checkSubmitAll() {
    if ($(".nickname").val() == "") {
        alert("昵称不能为空！")
        myScroll.scrollToPage(0, 0);
        //setTimeout(function(){$(".nickname").focus();},1000 );
        return false;
    }

    if ($(".university").val() == "") {
        alert("学校不能为空！")
        myScroll.scrollToPage(2, 0);
        //setTimeout(function(){$(".university").focus();},1000 );
        return false;
    }

    if ($(".special").val() == "") {
        alert("专业不能为空！")
        myScroll.scrollToPage(3, 0);
        //setTimeout(function(){$(".special").focus();},1000 );
        return false;
    }

    if ($(".phone").val() == "") {
        alert("手机号码不能为空！")
        //setTimeout(function(){$(".phone").focus();},1000 );
        return false;
    }

    if (!$(".phone").val().match(/^1[3|4|5|8][0-9]\d{4,8}$/)) {
        alert("手机号码格式不正确！请重新输入！")
        //setTimeout(function(){$(".phone").focus();},1000 );
        return false;
    }

    return true;
}

//验证邮箱 
//function checkSubmitEmail(){ 
//    if($("#email").val()==""){ 
//    	$("#confirmMsg").html("<font color='red'>邮箱地址不能为空！</font>"); 
//    	$("#email").focus(); 
//    	return false; 
//	} 
//   if(!$("#email").val().match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)){ 
//    	$("#confirmMsg").html("<font color='red'>邮箱格式不正确！请重新输入！</font>"); 
//    	$("#email").focus(); 
//		return false; 
//   } 
//   return true; 
//} 
