<?php
	$user = array(
		'name'=>'xiaoming',
		'gender'=>'man',
		'age'=>16
	);
	$arr = array('html','css','javascript');
	print_r(array_keys($user));
	print_r(array_keys($arr));

	print_r(array_values($user));
	print_r(array_values($arr));

	print_r($user);
	var_dump(array_key_exists('age', $user));