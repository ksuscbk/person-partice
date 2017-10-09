<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();

  $active = 'posts';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');

  $sql = 'SELECT count(*) AS total FROM posts';
  $total = query($sql)[0]['total'];
  $pageSize = 10;

  $pageCount = ceil($total / $pageSize);
  $pageLimit = 5;
  // 当前页
  $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
  $prevPage = $currentPage - 1;
  $nextPage = $currentPage + 1;
  // 起点
  $start = $currentPage - floor($pageLimit / 2);
  $start = $start < 1 ? 1 : $start;
  // 终点
  $end = $start + $pageLimit - 1;
  $end = $end >= $pageCount ? $pageCount : $end;
  // 根据终点计算最后一页显示的BUG
  $start = $end - $pageLimit + 1;
  $start = $start < 1 ? 1 : $start;

  $pages = range($start, $end);
  $offset = ($currentPage - 1) * $pageSize;
  // 页面需要展示的数据来自于多张表
  $sql = 'SELECT posts.id, posts.title, posts.created, posts.status, users.nickname, categories.name FROM posts LEFT JOIN users ON posts.user_id=users.id LEFT JOIN categories ON posts.category_id = categories.id LIMIT ' . $offset . ', ' . $pageSize;
  // 获取数据库里的信息
  $lists = query($sql); 


  // 删除
  if ($_GET['action'] == 'delete') {
    $sql = 'DELETE FROM posts WHERE id=' . $_GET['pid'];
    $result = delete($sql);
    if ($result) {
      header('Location: /admin/posts.php');
    }
  }
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
          <?php if ($currentPage > 1) { ?>
            <li>
              <a href="./posts.php?page=<?php echo $prevPage; ?>">
                上一页
              </a>
            </li>
          <?php } ?>
          <?php foreach ($pages as $key=>$val) { ?>
            <?php if ($currentPage == $val) { ?>
              <li class="active">
                <a href="./posts.php?page=<?php echo $val; ?>">
                  <?php echo $val; ?>
                </a>
              </li>
            <?php } else { ?>
              <li>
                <a href="./posts.php?page=<?php echo $val; ?>">
                  <?php echo $val; ?>
                </a>
              </li>
            <?php } ?>
          <?php } ?>
          <?php if ($currentPage < $pageCount) { ?>
            <li>
              <a href="./posts.php?page=<?php echo $nextPage; ?>">
                下一页
              </a>
            </li>
          <?php } ?>
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
        <?php foreach($lists as $key=>$val) { ?>
          <tr>
            <td class="text-center">
              <input type="checkbox">
            </td>
            <td><?php echo $val['title']; ?></td>
            <td><?php echo $val['nickname']; ?></td>
            <?php if(empty($val['name'])) { ?>
            <td>未分类</td>
            <?php } else { ?>
            <td><?php echo $val['name']; ?></td>
            <?php } ?>
            <td class="text-center"><?php echo $val['created']; ?></td>
            <?php if($val['status'] == 'published') { ?>
            <td class="text-center">已发布</td>
            <?php } else { ?>
            <td class="text-center">草稿</td>
            <?php } ?>
            <td class="text-center">
              <a href="/admin/post.php?action=update&pid=<?php echo $val['id']; ?>" class="btn btn-default btn-xs">编辑</a>
              <a href="/admin/posts.php?page=<?php echo $currentPage; ?>&action=delete&pid=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>
</body>
</html>
