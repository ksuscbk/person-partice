<?php
	// strstr(); strchr();  查找字符或字符串的首次出现并截取
	$str = 'my name is ksuscbk';
	echo strstr($str, 'name');
	echo "<br>";
	echo strstr($str, 'is');
	echo "<br>";
	echo strchr($str, 'is');