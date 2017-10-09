/**
 * Created by JQ on 2017/9/7.
 */
/**
 * Created by JQ on 2017/9/3.
 */
$(function () {


    // top栏客户服务扩展栏
    $(".serv").mouseenter(function () {
        $(".god").slideDown(200);
    });
    $(".serv").mouseleave(function () {
        $(".god").slideUp(200);
    });
    $(".god").mouseenter(function () {
        $(this).show();
    });
    $(".god").mouseleave(function () {
        $(this).hide();
    });


    // top栏下载APP二维码
    $(".top-end").mouseenter(function () {
        $(".top>img").fadeIn();
    });
    $(".top-end").mouseleave(function () {
        $(".top>img").fadeOut();
    });


    // jQuery轮播图效果
    //让当前需要出现的li淡入，让其余的li淡出
    var timer4 = null;
    var num = 0;
    $("ol li").mouseenter(function () {
        $("#ul li").eq($(this).index()).fadeIn().siblings().fadeOut();
        $(this).addClass("active").siblings().removeClass("active");
        num = $(this).index();
    });
    // ul自动走起来
    timer4 = setInterval(autoplay, 4000);
    // 移动到整个box上清除定时器   进入显示  移出隐藏
    $("#out").mouseenter(function () {
        clearInterval(timer4);
        $("#arr").fadeIn();
    });
    // 移开再开启定时器
    $("#out").mouseleave(function () {
        timer4 = setInterval(autoplay, 4000)
        $("#arr").fadeOut();
    });
    // 左右按钮事件
    $("#left").click(function () {
        num--;
        if (num == -1) {
            num = $("#ol>li").length - 1;
        }
        $("#ol li").eq(num).addClass("active").siblings().removeClass("active");
        $("#ul li").eq(num).fadeIn().siblings().fadeOut();
    });
    $("#right").click(function () {
        autoplay();
    });

    function autoplay(){
        num++;
        // ol 的li走
        if (num === 4) {
            num = 0;
        }
        $("#ol li").eq(num).addClass("active").siblings().removeClass("active");
        //   ul跟着走
        $("#ul li").eq(num).fadeIn().siblings().fadeOut();
    }


    // 定时器效果
    var timer3 = setInterval (function workTime () {
        var div = document.getElementsByClassName("outtime")[0];
        var now = new Date().getTime();
        var future = new Date("2017/10/01 12:00:00").getTime();
        var allTime = future - now;
        var days = parseInt(allTime / 1000 / 60 / 60 / 24);
        var hours = parseInt(allTime / 1000 / 60 / 60 % 24);
        var minutes = parseInt(allTime / 1000 / 60 % 60);
        var seconds = parseInt(allTime / 1000 % 60);
        days = days > 10 ? days : "0" + days;
        hours = hours > 10 ? hours : "0" + hours;
        minutes = minutes > 10 ? minutes : "0" + minutes;
        seconds = seconds > 10 ? seconds : "0" + seconds;
        div.innerText = "距离下次版本更新还有" + days + "天" + hours + "小时" + minutes + "分钟" + seconds + "秒";
    }, 100);


    // 吸顶效果   当页面滚动超过导航栏顶部距文档顶部的距离时，吸顶
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 160) {
            $("nav ul").addClass("xitop");
            $("nav ul li").addClass("xili");
            $(".fix3").css("display","block");
            $("h1").css("margin-bottom",$("nav ul").outerHeight());
        } else {
            $("nav ul").removeClass("xitop");
            $("nav ul li").removeClass("xili");
            $("h1").css("margin-bottom","");
            $(".fix3").hide();
        }
    });


    // 侧边固定栏进入显式移除隐藏效果
    $(".f1").mouseenter(function () {
        $(".aside1").fadeIn();
    });
    $(".f1").mouseleave(function () {
        $(".aside1").fadeOut();
    });


    //返回顶部小火箭
    // 页面滚动超过600px显示小火箭,不足600px隐藏
    $(window).scroll(function(){
        if($(window).scrollTop() > 600) {
            $(".fix2>.f4").show();
        }
        if($(window).scrollTop() <= 600) {
            $(".fix2>.f4").hide();
        }
    });
    // 缓动动画
    var socket = document.getElementById("f4");
    socket.onclick = function () {
        var target = 0, timer = null, leader = 0;
        timer = setInterval(function () {
            leader = scrollTop();
            var step = (target - leader) / 10;
            step = step > 0 ? Math.ceil(step) : Math.floor(step);
            leader += step;
            window.scrollTo(0, leader);
            if (target === leader) {
                clearInterval(timer);
            }
        },30);
    }

    //  封装获取页面被卷去部分方法
    function scrollTop () {
        return window.pageYOffset || document.documentElement.scrollTop;
    }


    //炸弹定时器相关功能
    var timer2 = setTimeout(function () {
        $(".timeout").fadeIn(1000);
    },2000);

    $(".timeout .close").click(function () {
        $(".timeout img").addClass("trans");
        $(".timeout").fadeOut(2000);
        clearTimeout(timer2);
    });


    // 高亮显示当前产品
    $(".product").mouseenter(function () {
        $(this).css("opacity","1").siblings().css("opacity",.5)
    });
    $(".product").mouseleave(function () {
        $(this).css("opacity","1").siblings().css("opacity","1");
    });


    // 随机背景颜色给主体
    $(function () {
        var timer5 = setInterval(function () {
            $(".product").css("background",randomColor());
        },2000);
        function randomColor() {
            return "rgb("+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+")";
        }
    });


})