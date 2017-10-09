/**
 * Created by JQ on 2017/8/29.
 */
// 食物对象food
    // 属性  位置     宽高      color
    // 方法
    //  模块化 封装起来
(function () {
    // 建立一个数组，
    var ele = [];

    // 创建对象
    function Food (x, y, width, height, color) {
        this.x = x || 0;
        this.y = y || 0;
        this.width = width || 20;
        this.height = height || 20;
        this.color = color || "hotpink";
        //  后续用来处理创建好的食物
        this.obj = null;
    }

    //  将食物创建出来在地图上
    Food.prototype.render = function (map) {
        // 在生成新的食物之前，把之前的食物删除掉
        var that = this;
        remove();
        this.obj = document.createElement("div");
        //  位置是随机的
        this.x = Math.floor(Math.random() * (map.offsetWidth/this.width)) * this.width;
//                this.x = Math.floor(Math.random() * map.offsetWidth);
        this.y = Math.floor(Math.random() * (map.offsetHeight/this.height)) * this.height;
        // 给食物定位
        this.obj.style.position = "absolute";
        this.obj.style.left = this.x + "px";
        this.obj.style.top = this.y + "px";
        this.obj.style.width = this.width + 'px';
        this.obj.style.height = this.height + 'px';
        this.obj.style.backgroundColor = this.color;
        // 把食物放到页面里
        map.appendChild(this.obj);
        ele.push(this.obj);
    }
    //  私有方法
    function remove() {
        for (var i = 0; i < ele.length; i++) {
            ele[i].parentNode.removeChild(ele[i]);
        }
        ele = [];
    }
    // 暴露
    window.Food = Food;
})();