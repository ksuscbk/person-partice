<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();

  $active = 'settings';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');
  // 上传文件ajax
  if (!empty($_FILES)) {
    $path = '../uploads';
    if (!file_exists($path)) {
      mkdir($path);
    }
    $ext = explode('.', $_FILES['images']['name'])[1];
    $filename = time();
    $realpath = $path . '/' . $filename . '.' . $ext;
    move_uploaded_file($_FILES['logo']['tmp_name'], $realpath);
    echo substr($realpath, 2);
    exit();
  }

  // 设置网站内容
  if (!empty($_POST)) {
    $connect = connect();
    // 遍历$_POST
    foreach ($_POST as $key=>$val) {
      $sql = 'UPDATE options SET `value`="' . $val . '" WHERE `key`="' . $key . '"';
      mysqli_query($connect, $sql);
    }
  }  
  // 查询
  $lists = query('SELECT * FROM options WHERE id<9');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Settings &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>网站设置</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal" action="/admin/settings.php" method="post">
        <div class="form-group">
          <label for="site_logo" class="col-sm-2 control-label">网站图标</label>
          <div class="col-sm-6">
            <input id="site_logo" name="site_logo" type="hidden" value="<?php echo $lists[1]['value']; ?>">
            <label class="form-image">
              <input id="logo" type="file">
              <img id="preview" src="<?php echo $lists[1]['value']; ?>">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="site_name" class="col-sm-2 control-label"><?php echo $lists[2]['value']; ?></label>
          <div class="col-sm-6">
            <input id="site_name" name="site_name" class="form-control" type="type" placeholder="站点名称">
          </div>
        </div>
        <div class="form-group">
          <label for="site_description" class="col-sm-2 control-label">站点描述</label>
          <div class="col-sm-6">
            <textarea id="site_description" name="site_description" class="form-control" placeholder="站点描述" cols="30" rows="6"><?php echo $lists[3]['value']; ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="site_keywords" class="col-sm-2 control-label">站点关键词</label>
          <div class="col-sm-6">
            <input id="site_keywords" name="site_keywords" class="form-control" type="type" placeholder="站点关键词" value="<?php echo $lists[4]['value']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">评论</label>
          <div class="col-sm-6">
            <div class="checkbox">
              <label><input id="comment_status" name="comment_status" type="checkbox" 
              <?php if ($lists[6]['value'] == 1) { ?> checked <?php } ?> value="1">开启评论功能</label>
            </div>
            <div class="checkbox">
              <label><input id="comment_reviewed" name="comment_reviewed" <?php if ($lists[6]['value'] == 1) { ?> checked <?php } ?> type="checkbox" value="1">评论必须经人工批准</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-6">
            <button type="submit" class="btn btn-primary">保存设置</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>
  <script>
    $('#logo').on('change', function () {

      var data = new FormData();
      data.append('logo', this.files[0]);

      var xhr = new XMLHttpRequest;
      xhr.open('posts', '/admin/settings.php');
      xhr.send(data);
      xhr.onreadystatechange = function () {
        if (xhr.status == 200 && xhr.readyState == 4) {
          $('#preview').attr('src', xhr.responseText);

          $('#site_logo').val(xhr.responseText);
        }
      }

    });
  </script>
</body>
</html>
