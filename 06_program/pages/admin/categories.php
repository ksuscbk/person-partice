<?php
  // 利用session检测是否登陆
  require '../functions.php';
  checkLogin();
  $active = 'category';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');
  // 获取页面提交方式，确定逻辑处理方式
  $action = isset($_GET['action']) ? $_GET['action'] : 'add';
  $uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
  // 获取列表数据
  $lists = query('SELECT * FROM categories');
  // 添加
  if ($action == 'add') {

    $btnText = '添加';
    $title = '添加分类目录';
    // 只有点击添加按钮才提交数据库
    if (!empty($_GET)) {
      // 去掉不需要的参数
      unset($_GET['id']);
      unset($_GET['action']);
  
      $result = insert('categories', $_GET);
      if ($result) {
        header('Location: /admin/categories.php');
        exit();
      }
    }
  } else if ($action == 'edit') {
    // 更新展示页面
    $action = 'update';
    $btnText = '编辑';
    $title = '修改分类目录';

    $sql = 'SELECT * FROM categories WHERE id=' . $uid;
    $result = query($sql);
  } else if ($action == 'update') {
    // 更新修改功能
    // 删除掉action属性
    unset($_GET['action']);

    $uid = $_GET['id'];
    unset($_GET['id']);
    $result = update('categories', $_GET, $uid);
    if ($result) {
      header('Location: /admin/categories.php');
    }
    $errors = '更新失败';
  } else if ($action == 'delete') {
    // 删除
    $sql = 'DELETE FROM categories WHERE id=' . $uid;
    $result = delete($sql);
    if ($result) {
      header('Location: /admin/categories.php');
      exit;
    }
  } 

  
    // 批量删除
  if ($action == 'deleteall') {
    // 拼接全部删除的sql语句
    $sql = 'DELETE FROM categories WHERE id IN (' . implode(',', $_POST['ids']) . ')';      
    $result = delete($sql);
    // header('Content-Type: application/json');
    header('Content-Type: application/json');
    if ($result) {
      echo json_encode(array('code'=>1, 'message'=>'删除成功'));
    } else {
      echo json_encode(array('code'=>0, 'message'=>'删除失败'));
    }
  }
  
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if (!empty($errors)) { ?>
      <div class="alert alert-danger">
        <strong>错误！</strong>更新错误
      </div>
      <?php } ?>
      <div class="row">
        <div class="col-md-4">
          <form action="/admin/categories.php" method="get">
          <input type="hidden" name="action" value="<?php echo $action; ?>">
          <input type="hidden" name="id" value="<?php echo $uid; ?>">
            <h2><?php echo $title; ?></h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" value="<?php echo isset($result[0]['name']) ? $result[0]['name'] : ''; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo isset($result[0]['slug']) ? $result[0]['slug'] : ''; ?>">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit"><?php echo $btnText; ?></button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="del" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input id="allChk" type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($lists as $key=>$val) { ?>
                <tr>
                  <td class="text-center">
                    <input class="selChk" type="checkbox" value="<?php echo $val['id']; ?>">
                  </td>
                  <td><?php echo $val['name']; ?></td>
                  <td><?php echo $val['slug']; ?></td>
                  <td class="text-center">
                    <a href="/admin/categories.php?action=edit&uid=<?php echo $val['id']; ?>" class="btn btn-info btn-xs">编辑</a>
                    <a href="/admin/categories.php?action=delete&uid=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
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
    // 全选
    $('#allChk').on('click', function () {
      if (this.checked) {
        $('.selChk').prop('checked', true);
        $('#del').show();
      } else {
        $('.selChk').prop('checked', false);
        $('#del').hide();
      }
    });
    // 只选择下面的
    $('.selChk').on('change', function () {
      var size = $('.selChk:checked').size();
      if (size > 0) {
        $('#del').show();
        return;
      }
      $('#del').hide();
    });
    // 批量删除
    $('#del').on('click', function () {
      // alert(1);
      var ids = [];
      $('.selChk:checked').each(function () {
        // 将勾选的文章的id放进数组
        ids.push($(this).val());
      });
      console.log(ids);
      // ajax 页面不重新加载刷新局部
      $.ajax({
        url: './categories.php?action=deleteall',
        type: 'post',
        data: {ids: ids},
        success: function (info) {
          // if (info.code == 1) {
            location.reload();
          // }
        }
      });
    });
  </script>
</body>
</html>
