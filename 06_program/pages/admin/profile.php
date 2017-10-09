<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();

  $active = '';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');

  $user_id = $_SESSION['user_info']['id'];
  $rows = query('SELECT * FROM users WHERE id=' . $user_id);

  if (!empty($_POST)) {
    $result = update('users', $_POST, $user_id);
    if ($result) {
      header('Location: ./profile.php');
      exit;
    }
    $errors = '更新失败';
  }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <!-- 调用公共样式 -->
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if (isset($errors)) { ?>
      <div class="alert alert-danger">
        <strong>错误！</strong>更改信息失败
      </div>
      <?php } ?>
      <form class="form-horizontal" action="/admin/profile.php" method="post">
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file">
              <!-- 判断是否有头像，没有的话是默认头像 -->
              <?php if ($rows[0]['avatar']) { ?>
              <img class="preview" src="<?php echo $rows[0]['avatar']; ?>">
              <?php } else { ?>
              <img src="/assets/img/default.png" alt="">
              <?php } ?>
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" class="form-control" type="type" value="<?php echo $rows[0]['email']; ?>" placeholder="邮箱" readonly>
            <p class="help-block">登录邮箱不允许修改</p>
          </div>
        </div>
        <div class="form-group">
          <label for="slug" class="col-sm-3 control-label">别名</label>
          <div class="col-sm-6">
            <input id="slug" class="form-control" name="slug" type="type" value="<?php echo $rows[0]['slug']; ?>" placeholder="slug">
            <p class="help-block">https://zce.me/author/<strong>zce</strong></p>
          </div>
        </div>
        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" class="form-control" name="nickname" type="type" value="<?php echo $rows[0]['nickname']; ?>" placeholder="昵称">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="bio" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="bio" name="bio" class="form-control" placeholder="Bio" cols="30" rows="6"><?php echo $rows[0]['bio']; ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary">更新</button>
            <a class="btn btn-link" href="password-reset.html">修改密码</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>
  <script>
    // 上传文件时用change事件把文件资源展示在页面上
    $('#avatar').on('change', function () {
      var data = new FormData();
      data.append('avatar', this.files[0]);

      var xhr = new XMLHttpRequest;
      xhr.open('post', '/admin/upfile.php');
      xhr.send(data);
      xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200) {
          $('.preview').attr('src', xhr.responseText);
        }
      }
    });
  </script>
</body>
</html>