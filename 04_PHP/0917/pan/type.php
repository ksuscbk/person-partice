<?php

	// include './disk.php';
	$diskinfo = include './disk.php';

	$type = $_GET['type'];
	// 点击侧边栏tab选项时，查询相应类型的文件并显示 pic video  audio  bt  extra  doc
	function findfile ($dir, $type) {
		// 设置一个数组
		static $types = array (
			'pic' => array('jpg', 'png', 'gif', 'ico'),
			'doc' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'),
			'video' => array('mp4','rmvb','wmv','rm','avi','itcast'),
			'audio' => array('mp3','wav'),
			'bt' => array('torrent'),
			'extra' => array('php','html','css','less','txt')
		);

		if (!is_dir($dir)) {
			echo "不是一个目录";
			return;
		}
		// 浏览目录
		$row = scandir($dir);

		// 遍历查找符合条件的选项
		static $lists = array();
		// 为了获取文件的信息
		$temp = array();

		foreach ($row as $key => $value) {
			if ($value == '.' || $value == '..') {
				continue;
			}

			$path = $dir . '/' . $value;
			// this is a problem
			// $path = realpath($row);

			if (is_file($path)) {
				// 是否有后缀名
				$aaa = "";
				if (isset(pathinfo($path)['extension'])) {
					$aaa = pathinfo($path)['extension'];

					if (in_array($aaa, $types[$type])) {
					//  获取符合条件的文件的相关信息  要展示在页面上
						$temp['name'] = basename(iconv('gbk', 'utf-8', $path));
						$temp['size'] = round(filesize($path) / 1024,1) . 'KB';
						$temp['mtime'] = date('Y-m-d h:i:s',filemtime($path));
						$temp['type'] = $aaa;
						
						$lists[] = $temp;
					}
				}	
			}
			// 是目录 继续查找
			if (is_dir($path)) {
				findfile($path,$type);
			}
		}
		return $lists;
	}

	// print_r(findfile(DISK,$type));
	$list = findfile(DISK, $type);

	// 如果是图片 展示页面是type.html  别的是另一种页面布局
	if ($type == 'pic') {
		include './view/type.html';
	} else {
		include './view/extra.html';
	}