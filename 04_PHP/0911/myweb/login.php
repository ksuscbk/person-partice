<?php
	////  模拟数据库
	//$user = array(
	//	'admin'=>'111',
	//	'jq'=>'222',
	//	'slf'=>'333'
	//);
	////  取出前端传给后台的数据
	////echo $_POST['name'];
	//$name = $_POST['name'];
	//$pwd = $_POST['pwd'];
	////  判断
	//if (array_key_exists($name, $user)) {
	//	if ($pwd == $user[$name]) {
	//		echo "登陆成功";
	//		echo "<>";
	//		echo "3秒后跳转到首页";
	//		header('Refresh:3; url=index.php');
	//	} else {
	//		echo '请仔细核对用户名或密码是否正确';
	//	}
	//} else {
	//	echo "用户名不存在";
	//}


	// 模拟数据库
	$userlist = array(
		'hairui'=>'111',
		'anyi'=>'222',
		'renbin'=>'333',
		'sunjie'=>'555'
	);
	// 取到前端传过来的数据
	// print_r($_POST);
	// var_dump($_POST);
	$aaa = $_POST['name'];
	$bbb = $_POST['pwd'];
	// 判断
	if (array_key_exists($aaa, $userlist)) {
		if ($userlist[$aaa] == $bbb) {
			echo "登陆成功";
			echo "<br>";
			header('Refresh:2;url=index.php');
		} else {
			echo "用户名或密码不正确";
			header('Refresh:2;url=login.html');
		}
	} else {
		echo "用户名不存在";
		echo "<br>";
		header('Refresh:2;url=login.html');
	}