<?php
	
	define('DISK', 'F:\\');
	$total = round(disk_total_space(DISK) / 1024 / 1024 / 1024, 1);
	$free = round(disk_free_space(DISK) / 1024 / 1024 / 1024, 1);
	$used = $total - $free;
	return array(
		'total' => $total,
		'free' => $free,
		'used' => $used,
		'percent' => $used / $total * 100 . '%'
	);