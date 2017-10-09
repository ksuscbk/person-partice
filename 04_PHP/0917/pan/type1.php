<?php

	$path = './pan/public/images';
	function findfile ($dir, $type) {
		// 设置一个数组
		static $types = array (
			'pic' => array('jpg', 'png', 'gif', 'ico'),
			'doc' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx')
		);
		$dir = iconv('utf-8', 'gbk', $dir);

		if (!is_dir($dir)) {
			echo "不是一个目录";
			return;
		}
		$row = scandir($dir);

		// 遍历查找符合条件的选项
		static $lists = array();
		// 为了获取文件的信息
		$temp = array();

		foreach ($row as $key => $value) {
			if ($value == '.' || $value == '..') {
				continue;
			}
			$value = iconv('utf-8', 'gbk', $value);

			$path = $dir . '/' . $value;
			// this is a problem
			// $path = realpath($row);

			if (is_file($path)) {
				$aaa = pathinfo($path)['extension'];

				if (in_array($aaa, $types[$type])) {
					//  获取符合条件的文件的相关信息  要展示在页面上
					$temp['name'] = basename($path);
					$temp['size'] = round(filesize($path) / 1024,1);
					$temp['mtime'] = date('Y-m-d h:i:s',filemtime($path));
					$temp['type'] = $aaa;
					$lists[] = $temp;
				}
			}
			// 是目录 继续查找
			if (is_dir($path)) {
				findfile($path);
			}
		}
		return $lists;
	}
	$data = findfile($path,'pic');
	print_r($data);