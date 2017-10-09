/**
 * Created by JQ on 2017/9/3.
 */
$(function () {


    // top栏客户服务扩展栏
    $(".serv").mouseenter(function () {
        $(".god").slideDown(200);
    });
    $(".god").mouseenter(function () {
        $(this).css("display","block");
    });
    $(".god").mouseleave(function () {
        $(this).hide();
    });
    $(".serv").mouseleave(function () {
        $(".god").slideUp(200);
    });


    // top栏下载APP二维码
    $(".top-end").mouseenter(function () {
        $(".top-end>img").fadeIn();
    });
    $(".top-end").mouseleave(function () {
        $(".top-end>img").fadeOut();
    });


    //轮播图原生js写法
    var box = document.getElementById("out");
    var inner = document.getElementById("inner");
    var ul = document.getElementById("ul");
    var ulLiArr = ul.children;
    var ol = document.getElementById("ol");
    var arr = document.getElementById("arr");
    var right = document.getElementById("right");
    var left = document.getElementById("left");
    var imgWidth = inner.offsetWidth;
    //需求1：根据ul里面li的个数添加ol里面的li；点亮ol里面第一个li;复制ul里第一张li添加到ul最末尾;
    //根据ul里面li的个数添加ol里面的li
    for (var i = 0; i < ulLiArr.length; i++) {
        var olLi = document.createElement("li");
        olLi.style.borderRadius = "50%";
        ol.appendChild(olLi);
    }
    var olLiArr = ol.children;
    olLiArr[0].className = "current";

    var newLi = ulLiArr[0].cloneNode(true);
    ul.appendChild(newLi);
    // 让图片随数字滚动
    for (var i = 0; i < olLiArr.length; i++) {
        olLiArr[i].index = i;
        olLiArr[i].onmouseover = function () {
            for (var j = 0; j < olLiArr.length; j++) {
                olLiArr[j].className = "";
            }
            this.className = "current";
            var distance = -imgWidth * this.index;
            fn(ul, distance);
            olLiIndex = this.index;
            ulLiIndex = this.index;
        }
    }
    var olLiIndex = 0;
    var ulLiIndex = 0;
    right.onclick = autoPlay;
    // 左侧按钮，逻辑相反
    left.onclick = function () {
        ulLiIndex--;
        olLiIndex--;
        if (olLiIndex === -1) {
            olLiIndex = olLiArr.length - 1;
        }
        if (ulLiIndex === -1) {
            ul.style.left = -(ulLiArr.length - 1) * imgWidth + "px";
            ulLiIndex = ulLiArr.length - 2;
        }
        for (var i = 0; i < olLiArr.length; i++) {
            olLiArr[i].className = "";
        }
        olLiArr[olLiIndex].className = "current";
        var distance = -imgWidth * ulLiIndex;
        fn(ul, distance);
    }
    var timer = setInterval(autoPlay,3000);
    box.onmouseenter = function () {
        arr.style.display = "block";
        clearInterval(timer);
    }
    box.onmouseleave = function () {
        arr.style.display = "none";
        timer = setInterval(autoPlay,3000);
    }
    //右侧按钮逻辑
    function autoPlay() {
        ulLiIndex++;
        olLiIndex++;
        if(olLiIndex === olLiArr.length){
            olLiIndex = 0;
        }
        if(ulLiIndex === ulLiArr.length){
            ul.style.left = 0;
            ulLiIndex = 1;
        }
        for(var j = 0; j < olLiArr.length; j++){
            olLiArr[j].className = "";
        }
        olLiArr[olLiIndex].className = "current";
        var distance = -imgWidth * ulLiIndex;
        fn(ul,distance);
    }
    //匀速动画封装(1.让那个元素移动;  2.移动到哪里)
    function fn(ele,target) {
        clearInterval(ele.timer);
        ele.timer = setInterval(function () {
            var step = target > ele.offsetLeft ? 10 : -10;
            ele.style.left = ele.offsetLeft + step + "px";
            if(Math.abs(target - ele.offsetLeft) <= Math.abs(step)){
                ele.style.left = target + "px";
                clearInterval(ele.timer);
            }
        },7);
    }


    // 吸顶效果   当页面滚动超过导航栏顶部距文档顶部的距离时，吸顶
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 160) {
            $("nav ul").addClass("xitop");
            $("nav ul li").addClass("xili");
            $(".fix3").show();
            $("h1").css("margin-bottom",$("nav ul").outerHeight());
        } else {
            $("nav ul").removeClass("xitop");
            $("nav ul li").removeClass("xili");
            $("h1").css("margin-bottom","");
            $(".fix3").hide();
        }
    });


    // 点击喜欢收藏按钮
    $(".public .main .alike").click(function () {
        $(this).css({
            backgroundImage : "url(images/icon.png)",
            "background-position" : "0 -1512px"
        });
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
    // 匀速浏览界面
    /*var fix2 = document.getElementsByClassName("fix2")[0];
    var but1 = fix2.getElementsByTagName("button")[0];
    var body = document.getElementsByTagName("body")[0];
    but1.onclick = function () {
        var target = 6000;
        var timer4 = null;
        timer4 = setInterval(function () {
            var step = target > but1.scrollTop() ? 10 : -10;
            but1.style.top = but1.offsetTop + step + "px";
            if (Math.abs(target - but1.offsetTop) <= Math.abs(step)) {
                but1.style.top = target + "px";
                clearInterval(timer4);
            }
        },30);
    }*/
    //  封装获取页面被卷去部分方法
    function scrollTop () {
        return window.pageYOffset || document.documentElement.scrollTop;
    }


    //炸弹定时器相关功能
    var mingren = document.getElementsByClassName("timeout")[0];
    var timer2 = setTimeout(function () {
        //mingren.style.display = "block";
        $(".timeout").fadeIn(1000);
    },2000);

    $(".timeout .close").click(function () {
        //$(".timeout img").addClass("trans");
        $(".timeout").fadeOut(2000);
    });
    // 随机背景颜色给弹出的框
    //var timer3 = setInterval(function () {
    //    var arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f"];
    //    var randomColor = "#";
    //    for (var i = 0; i < 6; i++) {
    //        var index = parseInt(Math.random() * 16);
    //        randomColor += arr[index];
    //    }
    //    mingren.style.bgColor = randomColor;
    //}, 1000);

})