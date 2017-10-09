/**
 * Created by JQ on 2017/8/29.
 */
(function (Food) {
    //  建立一个数组  放蛇的身体
    var ele = [];
    //  属性  宽高  颜色   方向   身体 蛇的组成部分
    function Snake(direction) {
        this.width = 20;
        this.height = 20;
        // 蛇默认走的方向
        this.direction = direction || "right";
        // 蛇的身体  用数组来存储身体的初始身体  每一个部位都有颜色color和位置x y
        this.body = [
            {x:3, y:2, color:"red"},
            {x:2, y:2, color:"blue"},
            {x:1, y:2, color:"black"}
        ];
    }

    Snake.prototype.render = function (map) {
        //  生成新的蛇之前先删除之前的蛇
        remove();
        for (var i = 0; i < this.body.length; i++) {
            var oDiv  = document.createElement("div");
            //  宽高
            oDiv.style.width = this.width + 'px';
            oDiv.style.height = this.height + 'px';
            //  位置
            oDiv.style.position = "absolute";
            oDiv.style.left = this.body[i].x * this.width + "px";
            oDiv.style.top = this.body[i].y * this.height + "px";
            // 颜色
            oDiv.style.backgroundColor = this.body[i].color;
            map.appendChild(oDiv);
            // 在循环渲染当中，只要加进去一个蛇的部位，就将这个部位存到ele数组
            ele.push(oDiv);
        }
    }


    function remove () {
        for (var i = 0; i < ele.length; i++) {
            ele[i].parentNode.removeChild(ele[i]);
        }
        ele = [];
    }
    // 让蛇移动
    Snake.prototype.move = function (food,map) {
        // 蛇的身体移动方法
        for (var i = this.body.length - 1; i > 0; i--) {
            this.body[i].x = this.body[i - 1].x;
            this.body[i].y = this.body[i - 1].y;
        }
        // 蛇头的方法
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
        }
        // 检测是否吃到食物，碰到则自身增加一个长度，删除食物，再生成一个食物
        // 获取当前蛇头坐标
        var hx = this.body[0].x * this.width;
        var hy = this.body[0].y * this.height;
        // 检测是否吃到食物,吃到的话将原身体的最后一个复制给新的身体
        if (hx === food.x && hy === food.y) {
            var last = this.body[this.body.length - 1];
            this.body.push({
                x : last.x,
                y : last.y,
                color : last.color
            });
            food.render(map);
        }
    }
    window.Snake = Snake;
}) (Food);