<?php 
    // 如果是点击登录  是post方式发送请求
    require '../functions.php';
    $errors = '';
    if (!empty($_POST)) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      // 判断是否和数据库中的数据一致   封装了几个函数调用
      $rows = query('SELECT * FROM users WHERE email="' . $email . '"');
      // print_r($rows[0]);
      // exit;
      if ($rows[0]) {
        if ($rows[0]['password'] == $password) {
          // 通过会话记录登录状态   cookie和session   
          // PHP中通过超全局数组$_SESSION存session
          session_start();
          $_SESSION['user_info'] = $rows[0];

          header('Location: /admin');
          exit;
        } else {
          $errors = '用户名或密码错误';
        }
      } else {
        $errors = '邮箱不存在';
      }
    }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="./login.php" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if (!empty($errors)) { ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $errors; ?>
      </div>
      <?php } ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" name="password" class="form-control" placeholder="密码">
      </div>
      <input class="btn btn-primary btn-block" type="submit" value="登 录" id="sub">
    </form>
  </div>
  <script>
    // var err = document.getElementsByTagName('strong')[0];
    // var ale = document.getElementsByClassName('alert-danger')[0];
    // var ema = document.getElementById('email');
    // var sub = document.getElementById('sub');
    // sub.onclick = function () {
    //   if ($errors == '用户名或密码错误' || $errors == '邮箱不存在') {
    //     var timer = setTimeout(function () {
    //       ale.style.display = 'none';
    //     }, 1500);
    //   }
    // }
  </script>
</body>
</html>
