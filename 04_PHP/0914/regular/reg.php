<?php

	// php用四个函数来支持正则表达式
	//  查找内容
	// $str = 'aslkdjfhgskdla';
	// preg_match('/kdl/', $str, $aaa);
	// print_r($aaa);

	// replace(); 替换
	// echo preg_replace('/kdl/', 'ooo', $str);


	// preg_split  拆分
	// $info = 'my name is jq';
	// print_r(preg_split('/\s/', $info));
	// $css = 'background-color: red;margin:10px;padding:20px';
	// print_r(preg_split('/:/g', $css));

	// 查找符合条件的单元
	$user = array('name'=>'jq','age'=>22,'score'=>96);
	var_dump(preg_grep('/\d/', $user));