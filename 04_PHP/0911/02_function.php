<?php
    // 大小写不敏感
    //function fn () {
    //    return 'hello world';
    //}
    //echo (fn ());

    // php 可以设置参数的默认值
    function sayHi ($name='小红') {
        echo '你好' . $name;
    }
    sayHi('小明');
?>    