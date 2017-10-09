<?php

	$connect = mysqli_connect('localhost','root','123456');
	mysqli_select_db($connect,'users');
	mysqli_set_charset($connect,'utf-8');
	mysqli_query($connect,"delete from users where hobby='大司马'");
	echo "删除成功";