<?php
	$str = 'my name is jiaoqiang';
	$arr = explode(" ", $str);
	print_r($arr);

	$str1 = implode("------------", $arr);
	echo $str1;