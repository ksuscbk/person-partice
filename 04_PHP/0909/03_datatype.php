<?php
    // 数据类型
    // 弱类型语言




    // 1 在php中，单引号与双引号有差别
    // 使用单引号定义字符串不能对变量进行解析
    //$hello = 'hello';
    //$world = '$hello world';
    // 使用双引号定义字符串能对变量进行解析
    //$hello = 'hello';
    //$world = "$hello world";


    // 2 数值类型
    //$num = 12;
    //echo $num;
    //$float = 12.12;
    //echo $float;




    //  php中使用关键字 array 定义数组
    // var arr = ["a", "b", "html"];
    //$arr = array('a', 'b', 'html', 'css', 'js');

    // 分两类
        //索引数组  通过索引（数字下标）访问
    $arr = array('a', 'b', 'html', 'css', 'js');
    echo $arr[2];

        //关联数组 通过键值对来定义数组单元，通过键来访问数组单元
    $arr1 = array('name'=>'小明', 'age'=>16, 'gender'=>'男');
    echo $arr1['name'];