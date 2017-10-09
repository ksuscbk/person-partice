<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();
  $active = 'post';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');
  // 获取前端处理逻辑
  $action = isset($_GET['action']) ? $_GET['action'] : 'add';

  if (!empty($_POST) || $action == 'upfile') {
    // 添加文章
    if ($action == 'add') {
      $result = insert('posts', $_POST);
      if ($result) {
        header('Location: /admin/posts.php');
        exit();
      }
      $errors = '文章添加失败';
    } else if ($action == 'upfile') {
      // 上传文件
      $path = '../uploads/thumbs';
      if (!file_exists($path)) {
        mkdir($path);
      }
      // 扩展名
      $ext = explode('.', $_FILES['feature']['name'])[1];
      // 文件名(以时间戳为文件名)
      $filename = time();
      // 拼凑上传到服务器的路径
      $dest = $path . '/' . $filename . '.' . $ext;
      // 上传
      move_uploaded_file($_FILES['feature']['tmp_name'], $dest);
      // 处理好路径返回给前台展示
      echo substr($dest, 2);
      exit();
    }
  } else if ($action == 'update') {
    $id = $_POST['id'];
    unset($_POST['id']);
    $result = update('posts', $_POST, $id);
    if ($result) {
      header('Location: /admin/posts.php');
      exit;
    }
  }

  // 所属分类由数据库决定
  $lists = query('SELECT * FROM categories');

  // 处理从posts页面过来的逻辑
  if ($action = 'edit') {
    $action = 'update';
    $pid = $_GET['pid'];
    $sql = 'SELECT * FROM posts WHERE id=' . $pid;
    $rows = query($sql);
  }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="/admin/post.php" method="post">
      <input type="hidden" name="id" id="<?php echo $pid; ?>">
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_info']['id']; ?>">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" value="<?php echo isset($rows[0]['title']) ? $rows[0]['title'] : "" ;?>" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容">
              <?php echo isset($rows[0]['content']) ? $rows[0]['content'] : '' ;?>
            </textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo isset($rows[0]['slug']) ? $rows[0]['slug'] : "" ;?>">
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image choose -->
            <?php if (empty($rows[0]['feature'])) { ?>
              <img class="help-block thumbnail preview" style="display: none">
            <?php } else { ?>
              <img class="help-block thumbnail preview" src="<?php echo $rows[0]['feature']; ?>">
            <?php } ?>  
            <input id="feature" class="form-control" type="file">
            <!-- value有什么作用呢  提交表单的时候让服务器通过$_GET获取吗 -->
            <input type="hidden" value="<?php echo isset($rows[0]['feature']) ? $rows[0]['feature'] : ""; ?>" name="feature" id="thumb">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category_id">
              <?php foreach ($lists as $key=>$val) { ?>
                <option value="<?php echo $val['id']; ?>" 
                  <?php if (isset($rows) && $rows[0]['category_id'] == $val['id']) { ?>
                    selected 
                  <?php } ?>>
                  <?php echo $val['name']; ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input value="<?php echo isset($rows[0]['created']) ? $rows[0]['created'] : "" ;?>" id="created" class="form-control" name="created" type="text">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted" 
                <?php if (isset($rows) && $rows[0]['status'] == 'drafted') { ?> selected <?php } ?>>草稿
              </option>
              <option value="published" <?php if ($rows[0]['status'] == 'published') { ?> selected <?php } ?>>已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>


  <script src="/assets/vendors/ueditor/ueditor.config.js"></script>
  <script src="/assets/vendors/ueditor/ueditor.all.min.js"></script>
  <script>
    // 富文本编辑器
    UE.getEditor('content', {
      autoHeightEnabled: true
    });


    $('#feature').on('change', function () {
      var data = new FormData();
      data.append('feature', this.files[0]);
      var xhr = new XMLHttpRequest;
      xhr.open('post', '/admin/post.php?action=upfile');
      xhr.send(data);
      xhr.onreadystatechange = function () {
        if (xhr.status == 200 && xhr.readyState == 4) {
          // 将图片的路径作为隐藏表单的值进行存储
          $('#thumb').val(xhr.respnseText);
          $('.preview').attr('src', xhr.responseText).show();
        }
      }
    });
  </script>
</body>
</html>
