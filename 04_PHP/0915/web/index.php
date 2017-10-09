<?php
    
    // 包含外部文件（磁盘信息）
    $diskinfo = include './disk.php';

    $dir = isset($_GET['name']) ? $_GET['name'] : DISK;

    // 测试
    // print_r($diskinfo);

	function finddir($dir) {
		static $parents = array();
		// 
		$pars = dirname($dir);
		$parents[] = $pars;

		if($pars != DISK) {
			finddir($pars);
		}
		
		return $parents;
	}

	// 面包导航
	$breadcrumb = array_reverse(finddir($dir));

	print_r($breadcrumb);

    // 定义函数遍历目录
    function scan_dir($dir) {
    	// 检测是否为目录
    	if(!is_dir($dir)) {
    		echo '不是一个目录'; 
    		return;
    	}

    	global $breadcrumb;

    	// $breadcrumb[] = dirname($dir);

    	// $breadcrumb[] = $dir;

    	// 获得目录下所有子目录和文件
    	$rows = scandir($dir);

    	// 定义一个数组
    	// 这个数组用来存储目录和文件信息
    	// 例如文件名、文件大小、修改时间
    	$lists = array();
    	// 遍历目录
    	foreach ($rows as $key => $val) {

    		// . 和 .. 不是有意义的目录
    		if($val == '.' || $val == '..') {
    			continue;
    		}

    		// 拼凑完整路径
    		$path = $dir . '/' . $val;

    		// 临时目录
    		$tmp = array();
    		// 文件名
    		$tmp['name'] = iconv('gbk', 'utf-8', $val);
    		// 文件修改时间
			$tmp['mtime'] = date('Y-m-d h:i:s', filemtime($path));
			// 
			$tmp['realpath'] = realpath($path);
			// 是否是目录标识
			$tmp['flag'] = true;
			// 文件或目录类型
			$tmp['type'] = 'folder';

			// 如果为文件
    		if(is_file($path)) {
    			// 文件大小
    			$tmp['size'] = filesize($path);
    			// 非目录，值为 false
    			$tmp['flag'] = false;
    			// 文件扩展名
    			$tmp['type'] = pathinfo($path)['extension'];
    		}

    		// 为目录
    		if(is_dir($path)) {
    			// 目录不计算大小
    			$tmp['size'] = '-';
    		}

    		// 将处后的数据存起来
    		$lists[] = $tmp;
    	}

    	// print_r($lists);
    	return $lists;
    }

    // 目录信息
    $items = scan_dir($dir);

    // 包含外部文件（展示数据）
    include './views/index.html';
