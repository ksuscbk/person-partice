/**
 * Created by JQ on 2017/8/28.
 */

// 创建构造函数    这个对象有两个属性   一个是按钮组   一个是展示组
function Btn (a) {
    this.btn = document.getElementsByTagName(a);
    //this.div = document.getElementsByTagName(b);
    //this.index = -1;
}
//  先写一个让按钮变化的函数出来

// 绑定初始化方法
Btn.prototype.init = function () {
    var that = this;
    //console.log(this);
    for (var i = 0; i < that.btn.length; i++) {        // 条件改成了that.btn.length
        //console.log(this);
        that.btn[i].onclick = that.sSelf;              // 改成了that.self
    }
}

// 展示当前项
Btn.prototype.sSelf = function () {
    console.log(this.parentNode);
    for (var i = 0; i < this.parentNode.length; i++) {
        this.parentNode.children.length.className = "";
    }
    console.log(this);
    this.className = "active";
}
// 展示对应区域
//But.prototype.showArea = function (btn) {
//    for (var i = 0; i < btn.length; i++) {
//
//    }
//}