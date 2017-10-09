<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();

  $active = 'slides';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');

  $lists = query('SELECT `value` FROM options WHERE `key`="home_slides"');
  // true 强制转为数组 数据展示
  $lists = json_decode($lists[0]['value'], true);
  // 为了让轮播图序号从1开始
  $lists = array_values($lists);

  $action = isset($_GET['action']) ? $_GET['action'] : 'add';
  // 上传文件的数据
  if (!empty($_FILES)) {
    $path = '../uploads/slides';
    if (!file_exists($path)) {
      mkdir($path);
    }

    $ext = explode('.', $_FILES['images']['name'])[1];
    $filename = time();
    $realpath = $path . '/' . $filename . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $realpath);
    echo substr($realpath, 2);
    exit();
  }
  // 把表单数据添加到数据库
  if (!empty($_POST)) {

    $lists[] = $_POST;
    // 往json字符串中添加一个单元
    $result = update('options', array('value'=>json_encode($lists)), 10);
    if ($result) {
      header('Location: /admin/slides.php');
      exit;
    }
  }
  // 删除
  if ($action == 'delete') {
    $sid = $_GET['sid'];
    unset($lists[$sid]);

    $json = json_encode($lists);
    $result = update('options', array('value'=>$json), 10);
    if ($result) {
      header('Location: /admin/slides.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Slides &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>图片轮播</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form action="/admin/slides.php" method="post">
            <h2>添加新轮播内容</h2>
            <div class="form-group">
              <label for="image">图片</label>
              <!-- show when image chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="image" class="form-control" type="file">
              <input type="hidden" name="image">
            </div>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="80">序号</th>
                <th class="text-center">图片</th>
                <th>文本</th>
                <th>链接</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($lists as $key=>$val) { ?>
              <tr>
                <td class="text-center"><?php echo $key + 1; ?></td>
                <td class="text-center"><img class="slide" src="<?php echo $val['image']; ?>"></td>
                <td><?php echo $val['text']; ?></td>
                <td><?php echo $val['link']; ?></td>
                <td class="text-center">
                  <a href="/admin/slides.php?action=delete&sid=<?php echo $key; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>
  <script>
  // 图片预览
    $('#image').on('change', function () {
      var data = new FormData();
      data.append('image', this.files[0]);

      var xhr = new XMLHttpRequest;
      xhr.open('post', '/admin/slides.php?action=upfile');
      xhr.send(data);
      xhr.onreadystatechange = function () {
        if (xhr.status == 200 && xhr.readyState ==4) {
          $('.thumbnail').attr('src', xhr.responseText).show();

          $('input[name="image"]').val(xhr.responseText);
        }
      }
    });
  </script>
</body>
</html>
