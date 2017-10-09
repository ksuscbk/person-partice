<?php
	$connect = mysqli_connect('localhost','root','123456');
	mysqli_select_db($connect,'users');
	mysqli_set_charset($connect,'utf-8');

	$rows = mysqli_query($connect,'select * from users');
	// 从查询到的资源中逐行取出数据
	$lists = array();
	while ($row = mysqli_fetch_assoc($rows)) {
		$lists[] = $row;
		// array_push($lists, $row);
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>display</title>
</head>
<body>
	<table>
		<?php foreach ($lists as $key=>$value) { ?>
		<tr>
			<td><?php echo $value['name']; ?></td>
			<td><?php echo $value['pass']; ?></td>
			<td><?php echo $value['gender']; ?></td>
			<td><?php echo $value['hobby']; ?></td>
		</tr>
		<?php } ?>
	</table>
</body>
</html>