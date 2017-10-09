<?php
    // 登录功能
    // 1、用户通过表单输入 用户名和密码
    // 并且将数据提交至后端
    // 2、后端接收数据并处理逻辑
    // a) 将获得的数据与数据库中存储数据进行比对
    // b) 比对成功或失败
    // 变量来模拟数据库
    // $users = array(
    //     'admin'=>123456,
    //     'test'=>654321
    // );
    // 用户提交的用户名
    // $name = $_POST['name'];
    // // 用户提交的密码
    // $pwd = $_POST['pwd'];

    // 如果用户提交的是 admin

    // 在通过数组模拟数据库时，使用的关联数组的 key 充当用户名
    // 所以要想判断用户存不存在只需要检测数组中有没有对应的 key

    // PHP 通过 array_key_exists 来检测数组中是否存在某个 key 
    // 返回布尔值
    // var_dump(array_key_exists('admin1', $users));
    // if(array_key_exists($name, $users)) {
    //     // 判断用户提交上来的密码与数据库中（数组）的密码是否一致
    //     if($pwd == $users[$name]) {
    //         header('Refresh: 3; url=./index.php');
    //         echo '登录成功!';
    //     } else {
    //         echo '用户或密码错误！';
    //     }
    // } else {
    //     echo '用户不存在!';
    // }

    // 文件user.txt模拟数据库
    // $name = $_POST['name'];
    // $pwd = $_POST['pwd'];
    // $res = fopen('./user.txt', 'r');
    // $arr = array();
    // while ($txt = fgets($res)) {
    //     array_push($arr, $txt);
    //     // echo fgetc($res);
    // }
    // // print_r($arr);
    // // 把数组中用户名和对应密码存放在新数组中
    // $newarr = array();
    // foreach ($arr as $key => $value) {
    //     $userarr = explode(" ", $value);
    //     array_pop($userarr);
    //     $newarr[$userarr[0]] = $userarr[1];
    //     // print_r($userarr);
    // }

    // if (array_key_exists($name, $newarr)) {
    //     if ($pwd == $newarr[$name]) {
    //         echo "登陆成功";
    //         header('Refresh:1;url=index.php');
    //     } else {
    //         echo "用户名或密码不正确";
    //     }
    // } else {
    //     echo "用户不存在";
    // }




    // try write by self
    // 获取用户输入的用户民和密码
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    // 获取数据库里的用户名和密码
    // 打开数据库  把数据存在数组中
    $file = fopen('./user.txt', 'a+');
    $arr = array();
    while ($txt = fgets($file)) {
        array_push($arr, $txt);
    }
    // 把二维数组中的第一项和第二张取出来放在一个新数组中
    $newarr = array();
    foreach ($arr as $key => $value) {
        $userinfo = explode(' ', $value);
        array_pop($userinfo);
        $newarr[$userinfo[0]] = $userinfo[1];
    }

    // 判断
    if (array_key_exists($name, $newarr)) {
        if ($pwd == $newarr[$name]) {
            echo "登录成功, 3秒后跳转到首页";
            header('Refresh:3;url=./index.php');
        } else {
            echo "用户名或密码不正确";
        }
    } else {
        echo "不存在此用户";
        header('Refresh:2;url=./login.html');
    }

    // $name = $_POST['name'];
    // $pwd = $_POST['pwd'];
    // $file = fopen('./user.txt', 'a');
    // $arr = array();
    // while ($txt = fgets($file)) {
    //     array_push($arr, $txt);
    // }
    // $newarr = array();
    // foreach ($arr as $key => $value) {
    //     $userinfo = explode(' ', $value);
    //     $newarr[$userinfo[0]] = userinfo[1];
    // }
    // if (array_key_exists($name, $newarr)) {
    //     if ($pwd == $newarr[$name]) {
    //         echo "登录成功,2秒后跳转到首页";
    //         header('Refresh:2;url=index.php');
    //     } else {
    //         echo "用户名或密码不正确";
    //         header('Refresh:2;url=register.html');
    //     }
    // } else {
    //     echo "不存在此用户";
    //     header('Refresh:3;url=register.html');
    // }