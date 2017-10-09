<?php

	$diskinfo = include './disk.php';

	print_r($_GET);
	$dir = isset($_GET['name']) ? $_GET['name'] : DISK;

	// 父子级模块
	function finddir ($dir) {
		// 静态变量防止递归时重复调用
		static $parents = array();
		// 定义数组存放父级目录
		$temp = array();
		// 获取父级目录
		$pars = dirname($dir);
		// 父级目录名称
		$name = basename($dir);
		// 存放到数组中
		$temp['path'] = $pars;
		$temp['name'] = $name;

		$parents[] = $temp;
		if ($pars != DISK) {
			finddir($pars);
		}
		return $parents;
	}

	// 面包屑模块
	$breadcrumb = array_reverse(finddir($dir));
	// 定义函数遍历目录
	function scan_dir ($dir) {
		// 如果不是目录就不能打开
		if (!is_dir($dir)) {
			echo "非法目录";
			return;
		}
		global $breadcrumb;
		$breadcrumb[] = dirname($dir);
		$breadcrumb[] = $dir;

		$rows = scandir($dir);
		$lists = array();

		foreach ($rows as $key => $value) {
			// 处理点和点点
			if ($value == '.' || $value == '..') {
				continue;
			}

			$path = $dir . '/' . $value;

			// print_r($path);

			$temp = array();
			$temp['name'] = iconv('gbk', 'utf-8', $value);
			$temp['mtime'] = date('Y-m-d h:i:s',filemtime($path));
			// 绝对路径
			$temp['realpath'] = realpath($path);

			// print_r($temp['realpath']);

			$temp['flag'] = true;
			$temp['type'] = 'folder';
			if (is_file($path)) {
				$temp['size'] = round(filesize($path) / 1024) . 'KB';
				$temp['flag'] = false;
				$temp['type'] = pathinfo($path)['extension'];
			}
			if (is_dir($path)) {
				$temp['size'] = ' ';
			}

			$lists[] = $temp;
		}
		// print_r($lists);
		return $lists;

	}

	$items = scan_dir($dir);

	// print_r($items);
	// print_r($breadcrumb);
	// var_dump($parents);
	include './view/index.html';