<?php 

  require '../functions.php';

  checkLogin();

  // 定义导航状态
  $active = 'users';

  $message = '';
  // 定义变量修改不同功能时的页面提示和按钮
  $title = '添加用户';
  $btnText = '添加';

  // 获取地址参数 //被做成变量
  $action = isset($_GET['action']) ? $_GET['action'] : 'add';//如果没有就认为是add添加操作

  if(!empty($_POST)){ //有post方式的时候才会执行

    // 添加
    if($action == 'add'){    

      // 接收用户提交的数据 //这部分有post插入
      /*$slug = $_POST['slug'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $status = 'unactivated';*/
      // 拼接字符串  进行封装处理
      // 这个老方法不用了
      // $result = insert('INSERT INTO users(id,slug,email,password,status) VALUES(null,"'.$slug.'","'.$email.'","'.$password.'","'.$status.'") ');
      
      // 为数组添加新的单元
      $_POST['status'] = 'unactivated';//一开始都是未激活的
      // 封装的引用:执行插入操作（新方法替换上述插入操作）
      $result = insert('users',$_POST);

      // 插入成功
      if($result){
        header('Location: /admin/users.php');
      } else {
        $message = '添加新用户失败！';
      }
    }


    // 更新/修改
    if($action == 'update'){
      // 应该包含id，在这下获得id
      $id = $_POST['id'];
      // 要把它从数组中取出，如果不拿出的话，数组就是 set id=2,nickname='小明' 这种结构
      // 但是id是主键，主键自增长，id=2的话相当于改它值了，主键不应该被更改
      // 我们要从数组中去除一个数据(就是id)
      unset($_POST['id']);//虽然不要，但是把它已经赋给$id了，后面还是可以使用

      // 执行修改操作
      $result = update('users',$_POST,$id);//到这里就没有id了，不会重新赋值了
      // 如果成功了，跳转本页面
      if($result){
        header('Location:/admin/users.php');
        exit;
      }
    }


    // 批量删除
    if($action == 'deleteAll'){
      // echo json_encode($_POST);//post接收的就是下面的数组
      // 
      // print_r( $_POST['ids'] );//索引数组
      // DELETE FROM users WHERE id in (1,  3, 5);
      // 拼凑语句
      $sql = 'DELETE FROM users WHERE id in (' .implode(',', $_POST['ids']). ')';

      // 删除
      $result = delete($sql);

      // 响应头设置，jQuery自动解析 json
      header('Content-Type:application/json');

      if($result){ // 成功提示信息
        $info = array('code'=>10000,'message'=>'删除成功！');
        echo json_encode($info);
      } else { // 失败提示信息
        $info = array('code'=>10001,'message'=>'删除失败！');
        echo json_encode($info);


      }
      // echo '你要批量进行删除吗';
      exit;
    }
  }


  // 查询所有用户 
  //SELECT *  这是偷懒写法，实际工作不这样写，浪费性能，一般用哪个字段就查哪个字段 ，在此本身就获取全部数据了，所以看不出性能损失 
  $lists = query('SELECT * FROM users');
  //print_r($rows);exit;  //得到二维数组，里面是关联数组。显示第1,2,3个用户，然后遍历操作数组 


  
  // if(isset($_GET['action'])){//这部分判断上面重新定义了


  // 编辑/删除操作
  // 
  // 有操作才获取用户id
  $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

  if($action == 'edit'){ // 编辑操作

    // 操作名
    $action = 'update';
    $title = '编辑用户';
    $btnText = '更新';

    // 查询结果
    $rows = query('SELECT * FROM users WHERE id=' .$user_id); 
    // print_r($rows);exit;//查询出的哪怕只有一条数据，也是在二维数组之中
    // 被编辑的内容必须展示在页面,修改html，只查出一条数据，所以0索引
    
  } else if($action == 'delete'){ //  删除操作
    $result = delete('DELETE FROM users WHERE id=' .$user_id);//但是这种直接删除的操作不安全，所以加权限判断，只能以post方式才能执行，在此不做补充操作 
    
    if($result){// 删除完页面刷新的跳转
      header('Location:/admin/users.php');
      exit;
    }
  }

  // }


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
      <?php if(!empty($message)){ ?>
      <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $message; ?>
      </div>
      <?php } ?>

      <div class="row">
        <div class="col-md-4">
          <!-- from表单 -->
          <!-- <form action="/admin/users.php" method="post"> --> <!-- 编辑提交是到这里 -->
          <!-- <form action="/admin/users.php?action=add/update" method="post">如果是添加/修改都提交到一个表单，所以要进行区分，做成变量 -->
          <form action="/admin/users.php?action=<?php echo $action; ?>" method="post">

            <h2><?php echo $title; ?></h2>
            <div class="form-group">
              <label for="email">邮箱</label>

              <!-- 表单操作id -->
              <!-- add的时候id自增，最后修改的时候id才有用，所以要做判断 -->

              <?php if($action != 'add'){ ?>
              <input type="hidden" name="id" value="<?php echo $rows[0]['id']; ?>" >
              <?php } ?>
              <!-- type="hidden"是表单的表单项，这个表单项是在页面上看不见的，但是点击提交的时候，这个数据可以被提交过去的。不是用来页面展示的，单纯用来做数据传输的 -->
              <input id="email" value="<?php echo isset($rows[0]['email']) ?$rows[0]['email'] :''; ?>" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" value="<?php echo isset($rows[0]['slug']) ?$rows[0]['slug'] :''; ?>" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" value="<?php echo isset($rows[0]['nickname']) ?$rows[0]['nickname'] :''; ?>" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" value="<?php echo isset($rows[0]['password']) ?$rows[0]['password'] :''; ?>" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit"><?php echo $btnText; ?></button>
            </div>
          </form>

        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm delete" href="javascript:;" style="display: none">批量删除</a><!-- delete -->
          </div>


          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>

                <th class="text-center" width="40">
                  <input type="checkbox" id="toggle"><!-- toggle -->
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
              <!-- tr就是里面每一行用户的信息，通过php连接数据库查询数据，查询结果放到页面展示，就是tr，所以保留一个tr，其他数据动态循环输出 -->
              <!-- 遍历$rows数组 -->
              <?php foreach($lists as $key=>$val){ ?>
              <tr>
                <td class="text-center"><input type="checkbox" value="<?php echo $val['id']; ?>" class="chk"></td> <!-- chk -->

                <td class="text-center"><img class="avatar" src="<?php echo $val['avatar']; ?>"></td><!-- 显示一个图片的路径 -->

                <td><?php echo $val['email']; ?></td>
                <td><?php echo $val['slug']; ?></td>
                <td><?php echo $val['nickname']; ?></td>
                <!-- 状态，需要判断 -->
                <?php if($val['status'] == 'activated'){ ?>
                <td>已激活</td>
                <?php } else if($val['status'] == 'unactivated'){ ?>
                <td>未激活</td>
                <?php } else if($val['status'] == 'forbidden'){ ?>
                <td>已禁用</td>
                <?php } else { ?>
                <td>已删除</td>
                <?php } ?>

                <td class="text-center">
                  <!-- 希望以当前页面显示 -->
                  <!-- 在页面点击编辑，地址栏http://baixiu.com/admin/users.php?user_id=1 带了参数了-->
                  <!-- <a href="/admin/users.php?user_id=1" class="btn btn-default btn-xs">编辑</a> -->
                  <!-- php可以获得这个参数，也就是要取出修改1这个用户 -->
                  <!-- 不能写死，所以要获得这个用户对应的真实id -->
                  <a href="/admin/users.php?action=edit&user_id=<?php echo $val['id']; ?>" class="btn btn-default btn-xs">编辑</a>
                  <!-- 试验点击编辑，左侧列表还是无法获得要修改的数据，所以还要查询操作 -->
                  <!-- 但是删除也会用user_id,所以再各加一个参数区分 -->
                  <a href="/admin/users.php?action=delete&user_id=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
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
    $('#toggle').on('click',function(){
      // console.log($(this));//这是按钮
      // console.log(this.checked);//this是原生DOM，选中了是true，取消选中是false

      if(this.checked){//全选
        $('.chk').prop('checked',true);//把这个属性变成true
        $('.delete').show();
      } else {//取消全选
        $('.chk').prop('checked',false);
        $('.delete').hide();
      }
    })

    // 单个选择
    $('.chk').on('change',function(){
      // console.log( $('.chk:checked').size() ); //size看个数
      
      // 获得当前选中用户的个数
      var size = $('.chk:checked').size();

      if(size > 0){// 如果大于0则显示批量按钮
        $('.delete').show();
        return;
      }
      $('.delete').hide();// 如果小于等于0则隐藏批量按钮
    })


    // 点击批量删除的时候能够删除已经选中的用户，点击按钮发送请求，向服务端去执行删除操作，所以要通过ajax
    $('.delete').on('click',function(){

      // 获得所有被选中用户的 id
      var ids = [];
      // 被选中的input框
      $('.chk:checked').each(function(){//遍历取出每一个被选中元素id，然后放入一个数组当中，然后把这个数组当做参数传给data（服务端）
        // console.log( $(this).val() );//获得id
        ids.push( $(this).val() );
      });

      // 发送 ajax 请求
      $.ajax({
        
        url:'/admin/users.php?action=deleteAll',
        type:'post',
        data:{ids:ids},//当做参数(将所有的选中的用户的 id )传给服务端
        beforeSend:function(){
          // 禁用按钮防止重复提交
          NProgress.start();
        },
        success:function(info){
          // console.log(info);

          // 提示信息
          alert(info.message);
          if(info.code == 10000){// 成功后刷新当前页
            location.reload();
            NProgress.done();
          }
        }

      })
    })
  </script>
</body>
</html>
