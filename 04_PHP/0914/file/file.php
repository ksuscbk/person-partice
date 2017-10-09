<?php
	
	//pathinfo() 文件信息 四个单元   dirname目录名   basename文件完整名   extension扩展名   filename文件名
	// pathinfo  dirname   basename  并不检测路径是否存在，只单纯分析路径格式  
	$path = '../math/math.php';
	$falsepath = './asdf.html';
	// print_r(pathinfo($path));

	// 目录名
	// echo dirname($path);
	// 文件完整名
	// echo basename($path);

	// 会检测文件是否存在，返回文件大小  以字节为单位
	// echo filesize($path);

	// echo file_exists($path);
	//  是否为文件
	// var_dump(is_file($path));

	// 检测绝对路径是否存在，返回绝对路径
	// var_dump(realpath($path));
	// echo realpath($falsepath);

	//  修改文件名
	// rename($path, './math1.php');

	// file_get_contents     file_put_contents
	// echo file_get_contents($path);
	// // 覆盖添加      第三个参数为FILE_APPEND变成内容添加
	// file_put_contents($path, array('name'=>'xiaoming'));

	//  移动上传文件
	// 上传上来的文件是在一个默认文件夹里，我们可以把它转移到具体的目录
	// move_uploaded_file($_FILES['upfile']['tmp_name'], './images/aaa.jpg');

	// copy()  复制时第二个参数应该包括路径和文件名

	// unlink();  删除文件

	// 查找指定路径还有多少空间
	echo disk_free_space('F:');
	echo "<br>";
	echo disk_total_space('F:');