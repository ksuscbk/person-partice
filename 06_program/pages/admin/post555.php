<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();

  // 获取数据库里的信息
  $lists = query('SELECT * FROM posts');

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <option value="">未分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lists as $key=>$val) { ?>
            <tr>
              <td class="text-center"><input type="checkbox"></td>
              <td><?php echo $val['title']; ?></td>
              <td>
                <?php
                  // 根据作者id取作者信息  users表
                  $user_id = $val['user_id'];
                  $sql = 'SELECT nickname FROM users WHERE id=' . $user_id;
                  // 根据id查询到作者
                  $rows = query($sql);
                  foreach ($rows as $key1=>$val1) {
                    echo $val1['nickname'];
                  }
                ?>
              </td>
              <td>
                <?php
                  // 根据文章id取分类信息 categorues表
                  $user_id = $val['id'];
                  $sql = 'SELECT name FROM categories WHERE id=' . $user_id;
                  // 根据id查询到分类信息
                  $rows = query($sql);
                  foreach ($rows as $key1=>$val1) {
                    echo $val1['name'];
                  }
                ?>
              </td>
              <td class="text-center"><?php echo $val['created']; ?></td>
              <?php if ($val['status'] == 'published') { ?>
              <td class="text-center">已发布</td>
              <?php } else { ?>
              <td class="text-center">草稿</td>
              <?php }?>
              <td class="text-center">
                <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>
  <script>NProgress.done()</script>
</body>
</html>
