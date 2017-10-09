<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();
  // 设置导航菜单
  $active = 'menus';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');

  $sql = 'SELECT `value` FROM options WHERE `key`="nav_menus"';
  $lists = query($sql);
  // 第二个参数转化为数组
  $data = json_decode($lists[0]['value'], true);

  // 删除
  $action = isset($_GET['action']) ? $_GET['action'] : 'add';
  if ($action == 'delete') {
    $index = $_GET['index'];
    // 如何从数组中删除某个单元
    unset($data[$index]);
    // 笨办法
    // foreach ($data as $key=>$val) {
    //   if ($key == $index) {
    //     unset($data[$key]);
    //   }
    // }
    $data = array_values($arr);
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    $result = update('options', array('val'=>$json, 9));
    if ($result) {
      header('Location: /admin/nav-menus.php');
    }
  }

  // 添加
  if (!empty($_POST)) {
    $data[] = $_POST;
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    $result = update('options', array('value'=>$json), 9);
    if ($result) {
      header('Location: /admin/nav-menus.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Navigation menus &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>导航菜单</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form action="/admin/nav-menus.php" method="post">
            <h2>添加新导航链接</h2>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="title">标题</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="标题">
            </div>
            <div class="form-group">
              <label for="title">图标</label>
              <input id="title" class="form-control" name="icon" type="text" placeholder="图标">
            </div>
            <div class="form-group">
              <label for="href">链接</label>
              <input id="href" class="form-control" name="link" type="text" placeholder="链接">
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
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>文本</th>
                <th>标题</th>
                <th>链接</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $key=>$val) { ?>
              <tr>
                <td class="text-center">
                  <input type="checkbox">
                  </td>
                <td>
                  <i class="<?echo $val['icon']; ?>"></i><?php echo $val['text']; ?>
                </td>
                <td><?php echo $val['title']; ?></td>
                <td><?php echo $val['link']; ?></td>
                <td class="text-center">
                  <a href="/admin/nav-menus.php?action=delete&index=<?php echo $key; ?>" class="btn btn-danger btn-xs">删除</a>
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
  <script>NProgress.done()</script>
</body>
</html>
