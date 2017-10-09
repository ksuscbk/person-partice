<?php

	require __DIR__ . '/config.php';
	session_start();
	// 验证是否登陆
	function checkLogin () {
		if (isset($_SESSION['user_info'])) {

		} else {
		  header('Location: ./login.php');
		  exit;
		}
	}
	// 连接数据库
	function connect () {
		$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		mysqli_select_db($connect, DB_NAME);
      	mysqli_set_charset($connect, DB_CHARSET);
		return $connect;
		// die();  等同于  echo               . return
	}
	// 数据查询  查询数据库的文件
	function query ($sql) {
		$connect = connect();
		// 结果集
		$result = mysqli_query($connect, $sql);
		$rows = fetch($result);
		return $rows;
	}
	// 数据提取  取出数据库里的数据转成数组
	function fetch ($result) {
		$rows = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$rows[] = $row;
		}
		return $rows;
	}
	// 传递数组自动拼接数组
	function insert ($table, $arr) {
		$connect = connect();
		$keys = array_keys($arr);
		$values = array_values($arr);
		$sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES ("' . implode('", "', $values) . '")';
		//$sql = "INSERT INTO " . $table . " (" . implode(", ", $keys) . ") VALUES('" . implode("', '", $values) . "')";
		$result = mysqli_query($connect, $sql);
		return $result;
	}
	// 删除
	function delete ($sql) {
		$connect = connect();
		$result = mysqli_query($connect, $sql);
		return $result;
	}
	// 修改
	function update ($table, $arr, $id) {
		$connect = connect();
		$str = "";
		// 为拼接sql语句做准备
      	foreach ($arr as $key=>$value) {
        	$str .= $key . "=" . "'" . $value . "', ";
        }
        // 逗号后面还有个空格 所以第二个参数为-2
        $str = substr($str, 0, -2);
        
        $sql = "UPDATE " . $table . " SET " . $str . " WHERE id=" . $id;
        // 将对数据的操作结果返回
		$result = mysqli_query($connect, $sql);

		return $result;
	}