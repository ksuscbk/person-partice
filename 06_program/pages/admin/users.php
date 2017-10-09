<?php
  require '../functions.php';
  checkLogin();
  $active = 'users';
  $actives = array('category', 'post', 'posts');
  $cogs = array('menus', 'slides', 'settings');

  $errors = '';
  $title = '添加用户';
  $btnText = '添加';

  $action = isset($_GET['action']) ? $_GET['action'] : 'add';
  
  // 判断是否以post方式提交
  if (!empty($_POST)) {
    // 获取地址参数
    $action = isset($_GET['action']) ? $_GET['action'] : 'add';
    // 添加     判断方式为post且
    if ($action == 'add') {
      // 封装insert函数之后没有status这个状态
      $_POST['status'] = 'unactivated';
      $result = insert('users', $_POST);
      if ($result) {
        header('Location: ./users.php');
      } else {
        $errors = '添加失败';
      }
    }
    // 更新
    if ($action == 'update') {
      // 存储一下id
      $id = $_POST['id'];
      // 去掉提交的时候里面的id
      unset($_POST['id']);
      $result = update('users', $_POST, $id);
      if ($result) {
        header('Location: /admin/users.php');
      }
    }
    // 批量删除
    if ($action == 'deleteall') {
      $sql = 'DELETE FROM users WHERE id IN (' . implode(',', $_POST['ids']) . ')';
      // echo $_POST['ids'];exit();
      $result = delete($sql);
      header('Content-Type: application/json');
      if ($result) {
        echo json_encode(array('code'=>10000, 'message'=>'删除成功'));
      } else {
        echo json_encode(array('code'=>9999, 'message'=>'删除失败'));
      }
      exit;
    }

  }
  // 获取所有用户信息
  $data = query('SELECT * FROM users');
  // 获取id
  $uid = isset($_GET['uid']) ? $_GET['uid'] : '';
  // 编辑
  if ($action == 'edit') {
      $title = '修改用户信息';
      $btnText = '确定修改';
      // 改为编辑状态
      $action = 'update';
      // 获取用户数据展示在页面上
      $result1 = query('SELECT * FROM users WHERE id=' . $uid);
  }
  // 删除
  if ($action == 'delete') {
    $result = delete('DELETE FROM users WHERE id=' . $uid);
    if ($result) {
      header('Location: /admin/users.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if (!empty($errors)) { ?>
      <div class="alert alert-danger">
        <strong>错误！</strong>添加失败
      </div>
      <?php } ?>
      <div class="row">
        <div class="col-md-4">
          <form action="./users.php?action=<?php echo $action; ?>" method="post">
          <!-- <form action="./users.php?action=" method="post"> -->
            <h2><?php echo $title; ?></h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <!-- 当操作是编辑操作时 -->
              <?php if ($action != 'add') { ?>
              <input type="hidden" name="id" value="<?php echo $result1[0]['id']; ?>">
              <?php } ?>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱" value="<?php echo isset($result1[0]['email']) ? $result1[0]['email'] : ''; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo isset($result1[0]['slug']) ? $result1[0]['slug'] : ''; ?>">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="<?php echo isset($result1[0]['nickname']) ? $result1[0]['nickname'] : ''; ?>">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码" value="<?php echo isset($result1[0]['password']) ? $result1[0]['password'] : ''; ?>">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit"><?php echo $btnText; ?></button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm delete" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40">
                  <input type="checkbox" id="toggle">
                </th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            <!-- 遍历把数据库中的数据放到页面上 -->
              <?php foreach ($data as $key=>$val) { ?>
                <tr>
                  <td class="text-center"><input type="checkbox" class="chk" value="<?php echo $val['id']; ?>"></td>
                  <td class="text-center"><img class="avatar" src="<?php echo $val['avatar']; ?>"></td>
                  <td><?php echo $val['email']; ?></td>
                  <td><?php echo $val['slug']; ?></td>
                  <td><?php echo $val['nickname']; ?></td>
                  <?php if ($val['status'] == 'activated') { ?>
                  <td>激活</td>
                  <?php } else if ($val['status'] == 'unactivated') { ?>
                  <td>未激活</td>
                  <?php } else if ($val['status'] == 'forbiddden') { ?>
                  <td>已禁用</td>
                  <?php } else { ?>
                  <td>已删除</td>
                  <?php } ?>
                  <td class="text-center">
                  <!-- 以get方式发送请求，action的值为操作类型，数据的id属性用来判断对谁进行操作 -->
                    <a href="./users.php?action=edit&uid=<?php echo $val['id']; ?>" class="btn btn-default btn-xs">编辑</a>
                    <a href="./users.php?action=delete&uid=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
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
    // 删除全选反选交互提升
    $('#toggle').on('click', function () {
      if (this.checked) {
        $('.chk').prop('checked', true);
        $('.delete').show();
      } else {
        $('.chk').prop('checked', false);
        $('.delete').hide();
      }
    });
    $('.chk').on('change', function () {
      var size = $('.chk:checked').size();
      if (size > 0) {
        $('.delete').show();
        return;
      }
      $('.delete').hide();
    });
    // 批量删除
    $('.delete').on('click', function () {
      // 
      var ids = [];
      $('.chk:checked').each(function () {
        ids.push($(this).val());
      });
      // 
      $.ajax({
        url: './users.php?action=deleteall',
        type: 'post',
        data: {ids: ids},
        success: function (info) {
          if(info.code == 10000) {
            location.reload();
          }
        }
      });
    });
  </script>

</body>
</html>
