<?php

    // PHP 通过 超全局变量来获取浏览器（客户端）提交过来的数据

    // $_POST、$_GET、$_REQUEST 来获取

    // $_GET 是一个数组，浏览器（客户端）
    // 以 get 方式提交上来的数据会被自动放到
    // $_GET 这个数组中

    // print_r($_GET);

    // $_POST 是一个数组，浏览器（客户端）
    // 以 post 方式提交上来的数据会被自动放到
    // $_POST 这个数组中

    // print_r($_POST);

    // $_REQUEST 是一个数组，浏览器（客户端）
    // 以 get 或 post 提交上来的数据会被自动放到
    // $_REQUEST 这个数组中

    print_r($_REQUEST);

    // 使用超全局变量 $_FILES 可以获取浏览器（客户端）提交上来的文件

    // $_FILES 就一个二维数组，数组中记录了上传文件的详情

    // print_r($_FILES);