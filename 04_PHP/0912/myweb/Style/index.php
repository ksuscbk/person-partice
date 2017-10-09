<?php
    
    header('Content-Type: text/css; charset=utf-8');

    // 通知浏览器60秒后再来请求
    // （协商缓存）
    header('Cache-Control: max-age=60');

    // 响应一段css代码
    echo '#header .topnav {background-color: red;}';

    // 
    $num = file_get_contents('./count.txt');

    $num++;

    file_put_contents('./count.txt', $num);
