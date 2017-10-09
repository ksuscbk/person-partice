<?php
	
	header('Content-Type: application/json');
	$arr1 = array(
		array('name'=>'焦强', 'age'=>22, 'gender'=>'男', 'ablum'=>'坚强'),
		array('name'=>'小帅', 'age'=>22, 'gender'=>'女', 'ablum'=>'雨爱'),
		array('name'=>'齐天', 'age'=>22, 'gender'=>'男', 'ablum'=>'坚强'),
		array('name'=>'杨洋', 'age'=>22, 'gender'=>'男', 'ablum'=>'微微一笑很倾城'),
		array('name'=>'郑爽', 'age'=>22, 'gender'=>'女', 'ablum'=>'流星花园')
	);
	echo json_encode($arr1);