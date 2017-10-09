<?php

	// 需求 根据目录查找其子文件及目录
		// 判断是目录还是文件并获取修改时间   如果是文件，获得文件大小
	// opendir();  readdir();   closedir();   三个的作用相当于scandir();

	function myscan ($dir) {
		if (!is_dir($dir)) {
			echo "当前目录为非法目录";
			return;
		}
	}