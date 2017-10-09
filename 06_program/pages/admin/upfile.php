<?php
	
	require '../functions.php';
	// 
	if (file_exists('../uploads')) {
		$filename = time();
		// 获取文件后缀
		$ext = explode('.', $_FILES['avatar']['name'])[1];
		// 文件路径
		$path = '/uploads/' . $filename . '.' . $ext;
		$user_id = $_SESSION['user_info']['id'];
		// 将文件上传到服务器上
		move_uploaded_file($_FILES['avatar']['tmp_name'], '..' . $path);
		// 存到数据库
		update('users', array('avatar'=>$path), $user_id);
		// 返回路径，前端作展示用
		echo $path;
	} else {
		mkdir('../uploads');
	}