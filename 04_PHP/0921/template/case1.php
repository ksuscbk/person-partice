<?php

	$stars = array(
		array('name'=>'刘德华', 'age'=>58, 'gender'=>'男', 'ablum'=>'一起走过的日子'),
		array('name'=>'王力宏', 'age'=>38, 'gender'=>'男', 'ablum'=>'心跳'),
		array('name'=>'孙燕姿', 'age'=>42, 'gender'=>'女', 'ablum'=>'绿光'),
		array('name'=>'吴彦祖', 'age'=>18, 'gender'=>'男', 'ablum'=>'好歌'),
		array('name'=>'刘备', 'age'=>108, 'gender'=>'男', 'ablum'=>'三顾茅庐')
	);

	// 将数组转成了 json 格式的字符串
	echo json_encode($stars);