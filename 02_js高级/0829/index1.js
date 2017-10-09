/**
 * Created by JQ on 2017/8/29.
 */
// ===========================================================
// 食物对象
(function (window) {
    //创建一个空数组用来存放在页面生成的食物
    var foodArr = [];
    // 食物对象的构造函数    宽20   高 20   颜色
    function Food (map) {
        this.x = 0;           // 水平位置
        this.y = 0;           // 垂直位置
        this.width = 20;
        this.height = 20;
        this.color = "gold";
        //this.borderRadius = "5px";
        //this.obj = null;
    }
    function randColor() {
        return "rgb("+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+")"
    }
    // 食物的创建方法
    Food.prototype.createFood = function (map) {
        // 每次创建先删除上一个食物
        remove();
        // 创建食物
        this.obj = document.createElement("div");
        // 给食物赋值对应的属性
        this.x = Math.floor(Math.random() * (map.offsetWidth / this.width)) * this.width;
        this.y = Math.floor(Math.random() * (map.offsetHeight / this.height)) * this.height;
        this.obj.style.width = this.width + "px";
        this.obj.style.height = this.height + "px";
        this.obj.style.position = "absolute";
        this.obj.style.left = this.x + "px";
        this.obj.style.top = this.y + "px";
        this.color = randColor();
        this.obj.style.backgroundColor = this.color;
        // 生成到游戏区域
        map.appendChild(this.obj);
        // 添加到食物数组里
        foodArr.push(this.obj);
    }
    // 食物的删除方法
    function remove () {
        for (var i = 0; i < foodArr.length; i++) {
            foodArr[i].parentNode.removeChild(foodArr[i]);
        }
        foodArr = [];
    }
    window.Food = Food;
})(window);
// ===========================================================
// 蛇对象
(function (window, Food) {
    var snakeArr = [];
    // 蛇的构造函数   蛇的胖瘦   方向   身体
    function Snake () {
        this.width = 20;
        this.height = 20;
        this.direction = "down";
        this.obj = null;
        this.body = [
            {x:20, y:3, color: "gold"},
            {x:19, y:3, color: "#ff3"},
            {x:18, y:3, color: "#ff6"},
            {x:17, y:3, color: "#ff9"},
            {x:16, y:3, color: "#ffc"}
        ];
    }
    function randColor() {
        return "rgb("+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+")"
    }
    // 蛇的创建
    Snake.prototype.createSnake = function (map) {  // 一会要用到map
        // 生成蛇之前要清除蛇
        remove();
        // 根据定义蛇的初始身体去生成蛇
        for (var i = 0; i < this.body.length; i++) {
            //var that = this;

            this.obj = document.createElement("div");
            this.obj.style.width = this.width + "px";
            this.obj.style.height = this.height + "px";
            this.obj.style.position = "absolute";
            this.obj.style.left = this.body[i].x * this.width + "px";
            this.obj.style.top = this.body[i].y * this.height + "px";
            //console.log(that.body[i].color);
            this.color = randColor();
            this.obj.style.borderRadius = "8px";
            this.obj.style.backgroundColor = this.color;
            //this.obj.style.backgroundColor = this.body[i].color;
            // 把每一节蛇肉放到游戏区
            map.appendChild(this.obj);
            // 把每一次添加的身体放到数组中
            snakeArr.push(this.obj);
        }
    }
    // 蛇的删除
    function remove () {
        for (var i = 0; i < snakeArr.length; i++) {
            snakeArr[i].parentNode.removeChild(snakeArr[i]);
        }
        snakeArr = [];
    }

    // 蛇的移动
    Snake.prototype.move = function (food, map) {
        // 身体的移动
        for (var i = this.body.length - 1; i > 0; i--) {
            this.body[i].x = this.body[i - 1].x;
            this.body[i].y = this.body[i - 1].y;
        }
        // 蛇头的移动
        switch (this.direction) {
            case "left" :
                this.body[0].x -= 1;
                break;
            case "right" :
                this.body[0].x += 1;
                break;
            case "up" :
                this.body[0].y -= 1;
                break;
            case "down" :
                this.body[0].y += 1;
                break;
        }
        // 判断是否碰到了食物   碰到了的话就让把最后一节身体的数据复制在最末尾。删除食物并重新生成一个
        var hx = this.body[0].x * this.width;
        var hy = this.body[0].y * this.height;

        if (hx == food.x && hy == food.y) {
            var last = this.body[this.body.length - 1];
            this.body.push({
                x : last.x,
                y : last.y,
                color : last.color
            });
            food.createFood(map);
        }
    }
    window.Snake = Snake;
})(window,Food);
// ===========================================================
// 游戏对象
(function (window, Food, Snake) {
    // 构造函数创建游戏    食物    蛇    地图
    function Game (map) {
        this.Food = new Food();
        this.Snake = new Snake();
        this.map = map;
    }
    // 开始游戏的方法
    Game.prototype.start = function () {
        this.Food.createFood(this.map);
        this.Snake.createSnake(this.map);
        runSnake(this);
        bindKey(this);
    }
    // 设置定时器让蛇跑起来  调用蛇移动的方法
    function runSnake (that) {
        var timer = setInterval(function (e) {
            e = e || event;
            that.Snake.move(that.Food,that.map);
            that.Snake.createSnake(that.map);
            // 判断蛇是否撞墙
            var hx = that.Snake.body[0].x * that.Snake.width;
            var hy = that.Snake.body[0].y * that.Snake.height;
            var maxx = that.map.offsetWidth;
            var maxy = that.map.offsetHeight;
            if (hx < 0 || hy < 0 || hx > maxx || hy > maxy) {
                clearInterval(timer);
                alert("游戏结束");
            }
        }, 100);
    }
    // 绑定键盘事件
    function bindKey (that) {
        document.addEventListener("keydown", function (e) {
            e = e || event;
            switch (e.keyCode) {
                case 37 :
                    that.Snake.direction = "left";
                    break;
                case 38 :
                    that.Snake.direction = "up";
                    break;
                case 39 :
                    that.Snake.direction = "right";
                    break;
                case 40 :
                    that.Snake.direction = "down";
                    break;
            }
        }, false);
    }
    window.Game = Game;
})(window, Food, Snake);
