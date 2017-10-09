/**
 * Created by JQ on 2017/8/27.
 */
// 设置一个定时器给页面背景变换随机颜色
timer = setInterval(function () {
    var arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f"];
    var randomColor = "#";
    for (var i = 0; i < 6; i++) {
        var index = parseInt(Math.random() * 16);
        randomColor += arr[index];
    }
    document.body.bgColor = randomColor;
}, 3000);
// 面向对象的方式写拖拽案例
(function () {  // 闭包形式
    function Drag (id) {
        // 给当前隐式对象this上挂一个属性，让这个属性等于拖拽物体
        this.obj = document.getElementById(id);
        this.x = 0;
        this.y = 0;
    }
    // 一般先在原型上写一个初始化方法，将各个基础数据进行初始化加载
    Drag.prototype.init = function () {
        var that = this;
        this.obj.onmousedown = function (e) {
            e = e || event;
            that.x = e.clientX - this.offsetLeft;
            that.y = e.clientY - this.offsetTop;

            document.onmousemove = function (e) {
                that.fnMove(e);
            }
            document.onmouseup = that.fnUp;
        }
    }
    Drag.prototype.fnMove = function (e) {
        var e = e || event;
        this.obj.style.left = e.clientX - this.x + "px";
        this.obj.style.top = e.clientY - this.y + "px";
    }
    Drag.prototype.fnUp = function () {
        document.onmousemove = document.onmouseup = null;
    }
    window.Drag = Drag;
    // 避免出现全局变量，将变量作为构造函数中this的属性存在
    // 根据实际情况，将事件和功能尽可能划分的细一些，划分清晰
    // 注意this 的问题，注意this指向更改问题，解决办法，在this改变前用that存储一下
})();
