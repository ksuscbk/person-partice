/**
 * Created by JQ on 2017/8/30.
 */
// 食物对象
(function (window) {
    var foodArr = [];
    // 构造函数创建食物对象   宽  高   颜色  位置
    function Food (map) {
        this.width = 20;
        this.height = 20;
        this.x = 0;
        this.y = 0;
        this.color = "gold";
    }
    Food.prototype.createFood = function (map) {
        // 生成食物之前先删除食物
        remove();
        // 获取食物的属性
        this.obj = document.createElement("div");
        this.x = Math.floor(Math.random() * (map.offsetWidth / this.width)) * this.width;
        this.y = Math.floor(Math.random() * (map.offsetHeight / this.height)) * this.height;
        // 给食物设置样式
        this.obj.style.position = "absolute";
        this.obj.style.left = this.x + "px";
        this.obj.style.top = this.y + "px";
        this.obj.style.width = this.width + "px";
        this.obj.style.height = this.height + "px";
        this.obj.style.backgroundColor = this.color;
        // 添加到游戏区域
        map.appendChild(this.obj);
        // 添加到食物数组中
        foodArr.push(this.obj);
    }
    function remove () {
        for (var i = 0; i < foodArr.length; i++) {
            foodArr[i].parentNode.removeChild(foodArr[i]);
        }
        foodArr = [];
    }
    window.Food = Food;
})(window);
// ===============================================================
// 蛇对象
(function (window,Food) {
    var snakeArr = [];
    // 蛇的构造函数    宽高  位置   身体
    function Snake () {
        this.x = 0;
        this.y = 0;
        this.width = 20;
        this.height = 20;
        this.obj = null;
        this.body = [
            {x : 15, y : 5, color : "gold"},
            {x : 14, y : 5, color : "silver"},
            {x : 13, y : 5, color : "silver"},
            {x : 12, y : 5, color : "silver"},
            {x : 11, y : 5, color : "silver"}
        ];
    }
    function randColor () {
        return "rgb("+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+","+Math.round(Math.random()*255)+")"
    }
    // 蛇的创建
    Snake.prototype.createSnake = function (map) {
        // 生成蛇之前先删除蛇
        remove();
        // 根据数组生成蛇
        for (var i = 0; i < this.body.length; i++) {
            this.obj = document.createElement("div");
            this.obj.style.width = this.width + "px";
            this.obj.style.height = this.height + "px";
            this.obj.style.position = "absolute";
            this.obj.style.left = this.body[i].x * this.width + "px";
            this.obj.style.top = this.body[i].y * this.height + "px";
            this.color = randColor();
            this.obj.style.backgroundColor = this.color;
            // 把蛇添加到画布上
            map.appendChild(this.obj);
            // 添加到数组中
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
        // 蛇的移动
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
        // 判断是否碰到了食物   如果碰到了复制最后一节的数据添加一节身体，删除食物，生成新的食物
        var hx = this.body[0].x * this.width;
        var hy = this.body[0].y * this.height;
        if (hx == food.x && hy == food.y) {
            var last = this.body[this.body.length - 1];
            this.body.push({
                    x : last.x,
                    y : last.y,
                    color : last.color
                });
            // 生成新的食物
            food.createFood(map);
        }
    }
    window.Snake = Snake;
})(window,Food);
// ===============================================================
// 游戏对象
(function (window, Food, Snake) {
    function Game (map) {
        this.Food = new Food();
        this.Snake = new Snake();
        this.map = map;
    }
    // 游戏开始的方法
    Game.prototype.start = function () {
        this.Food.createFood(this.map);
        this.Snake.createSnake(this.map);
        run(this);
        bindkey(this);
    }

    function run (that) {
        // 用定时器调用蛇的移动方法
        var timer = setInterval(function (e) {
            e = e || event;
            that.Snake.move(that.Food, that.map);
            that.Snake.createSnake(that.map);
            // 判断蛇是否撞墙
            var hx = that.Snake.body[0].x * that.width;
            var hy = that.Snake.body[0].y * that.height;
            var maxx = that.map.offsetWidth;
            var maxy = that.map.offsetHeight;
            if (hx == 0 || hy == 0 || hx > maxx || hy > maxy) {
                clearInterval(timer);
                alert("Game Over");
            }
        }, 60)
    }
    function bindkey (that) {
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
        }, false)
    }
    window.Game = Game;
})(window, Food, Snake);