<?php

	// 局部变量定义在函数中 
	// function fn () {
	// 	$name = 'ksuscbk';
	// }
	// fn();
	// echo $name;

	// 定义在函数外部的变量为全局变量  函数内部要使用全局变量需要使用关键字global
	// $sex = 'man';
	// function fn1 () {
	// 	// global $sex;
	// 	// $sex = 'woman';

	// 	$_GLOBALS['sex'] = 'woman111';
	// 	echo $_GLOBALS['sex'];
	// }
	// fn1();
	// echo $sex;

	// 静态变量
	// function fn2 () {
	// 	// 声明静态变量
	// 	static $count = 1;
	// 	$count++;
	// 	echo $count;
	// }
	// fn2();
	// fn2();
	// fn2();
	// fn2();
	// fn2();

	// 常量  一般用大写   参数分别为  常量名   值   是否区分大小写（默认区分flase）
	// define('CONST1', 15);
	// echo CONST1;

	// 文件
	// $aaa = file_get_contents('../getfile.txt');
	// // echo $aaa;
	// file_put_contents('../getfile.txt', $aaa);

	// 