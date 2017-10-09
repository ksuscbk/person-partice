<?php 


  require '../functions.php';

  checkLogin();

  // 定义二级导航
  $actives = array('category','post','posts');

  // 定义导航状态
  $active = 'post';

  // 下面的ajax也用的post，所以要区分执行，借助action来实现
  
  $action = isset($_GET['action']) ? $_GET['action'] : 'add'; //这里我们要的默认就是添加功能
  // echo $action; //测试当前action

  if(!empty($_POST) || $action == 'upfile'){ //这个是原来的逻辑，被分成了两部分
    // 这个post要有数据传给它,所以前面为空是false，||后面是true，就可以进入到后面的逻辑
    // 因为我们传递的是文件，用$_FILES接收，而不是$_POST，所以为空，所以进入action的逻辑
    // print_r($_POST);exit;
    
    if($action == 'add'){

      // 将用户提交上的数据插入数据库
      $result = insert('posts',$_POST);

      if($result){
        header('Location:/admin/posts.php');exit;
      }
      $message = '添加文章失败！';
    } else if ($action == 'upfile'){ //文件上传
      // print_r($_FILES);exit; //测试下，能不能接收到传过来的结果，从response中可以看到二维数组
      
      // 目录变量,设置一个上传目录
      $path = '../uploads/thumbs'; //因为要交给浏览器执行，浏览器要使用绝对路径，使用的时候要截取字符串      
      
      // 下面要把数据放到目录下，最好能把不同功能的图片分类放
      if(!file_exists($path)){ //检查有没有这个目录，有才能上传，没有就帮我去创建
        mkdir($path);
      }
      // 把临时图片放到具体的目录下，一个文件不仅要有路径，还要有后缀,这个要看二维数组书写,点前面是一部分，点后面又是一部分
      
      // 书写后缀
      $ext = explode('.',$_FILES['feature']['name'])[1];//1代表后面的部分

      // 以时间戳做为文件名，一定程度上避免重复
      $filename = time();

      // echo $path. '/' .$filename. '.' .$ext; //测试下完整路径

      // 放入哪个目录
      $dest = $path. '/' .$filename. '.' .$ext;

      // 放入具体目录下
      move_uploaded_file($_FILES['feature']['tmp_name'],$dest);

      // 最后将结果（截取的绝对完整路径）返回给浏览器
      // (处理成网络路径)
      echo substr($dest,2); //预览显示的话，把这个路径显示在页面就可以了
      exit;//我们只要返回这个结果（$dest），所以不让后面执行
    } else if($action == 'update'){ // 更新
      // print_r($_POST);exit;

      // 获取文章id，根据文章id更新 
      $id = $_POST['id'];

      // id 是主键不允许更新
      unset($_POST['id']);

      // 执行更新
      $result = update('posts',$_POST,$id);

      if($result){
        header('Location: /admin/posts.php');exit;
      }

    }
  }


  // 取出现有所有分类
  $sql = 'SELECT * FROM categories';
  $lists = query($sql);

  // print_r($lists);exit;

  // 编辑操作
  if($action == 'edit'){

    $action = 'update';
    // 获取文章id
    $pid = $_GET['pid'];

    // 查询文章原始信息
    $sql = 'SELECT * FROM posts WHERE id=' .$pid;

    $rows = query($sql);
    // print_r($rows);exit;
  }

 ?>

<!-- 上传图片有预览功能，点击选择文件时会触发change事件，这时可以发送一个请求，把图片发送给服务端，服务端来进行上传 -->

<!-- 我们要保证，一个post文件，能处理多个逻辑，相互之间不干扰，保证这一点才能使数据接收正确 -->

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

      <form action="/admin/post.php?action=<?php echo $action; ?>" method="post" class="row">

        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_info']['id']; ?>">

        <input type="hidden" name="id" value="<?php echo $pid; ?>">

        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" value="<?php echo isset($rows[0]['title']) ? $rows[0]['title'] : ''; ?>" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea style="height: 300px" id="content" name="content" cols="30" rows="10" placeholder="内容">
              <?php echo isset($rows[0]['content']) ? $rows[0]['content'] : ''; ?>
            </textarea> 
          </div>  
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" value="<?php echo isset($rows[0]['slug']) ? $rows[0]['slug'] : ''; ?>" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>

          <!-- 特色图像部分feature,可以更改透明度样式美化 -->
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->

            <?php if(empty($rows[0]['feature'])){ ?>
            <img class="help-block thumbnail" style="display: none">
            <?php } else { ?>
            <img class="help-block thumbnail" src="<?php echo $rows[0]['feature']; ?>">
            <?php } ?>

            <input id="feature" class="form-control" type="file"> 
            <!-- 去掉name，这个仅仅是用来做上传的，后面的处理数据 -->
            <input type="hidden" value="<?php echo isset($rows[0]['feature']) ? $rows[0]['feature'] :'' ?>" name="feature" id="thumb">

          </div>

          <div class="form-group">
            <label for="category">所属分类</label>
              <!-- 遍历的时候要做一个判断 -->
            <select id="category" class="form-control" name="category_id">
              
              <?php foreach($lists as $key=>$val){ ?>
              <option value="<?php echo $val['id']; ?>"  <?php if( isset($rows) && $rows[0]['category_id'] == $val['id'] ){ ?>selected<?php } ?> >
                <?php echo $val['name']; ?>
              </option>
              <?php } ?><!-- 有详解 -->

            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" value="<?php echo isset($rows[0]['created']) ? $rows[0]['created'] : ''; ?>"  class="form-control" name="created" type="text">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted" <?php if( isset($rows) && $rows[0]['status'] == 'drafted'){ ?>selected<?php } ?> >草稿</option>
              <option value="published" <?php if( isset($rows) && $rows[0]['status'] == 'published'){ ?>selected<?php } ?> >已发布</option>
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
    UE.getEditor('content',{
      autoHeightEnabled: true
    });
    // 默认样式冲突，去掉默认样式
    // 前端配置说明：toolbars: [  来定义都有哪些工具，参考网页
    //     ['fullscreen'（全屏功能）, 'source'（源代码功能）, 'undo'（撤销）, 'redo'（重做）, 'bold']
    // ],
    // autoHeightEnabled: true,  自动高度
    // autoFloatEnabled: true

    // 特色图像ajax
    $('#feature').on('change',function(){

      // 可以通过原生 DOM 可以获得文件信息
      // 另解释这个点：this指的是原生DOM，$()就是调用函数，$(this);就是this可以把原生DOM转换成jq对象的。但是在这里不要转为jq对象，这里用原生DOM
      
      // this.files[0];//只上传一个就是
      // 上传时，需要对其转换成ajax能够支持的数据格式
      // 通过H5内置的对象 FromData 可以实现文件数据的管理

      var data = new FormData();//实例化的时候没有传数据，但是可以通过这个方法后去追加
      // 实例对象有一个方法，数据的形式是键值对形式
      data.append('feature',this.files[0]);//key一般要和数据的字段做对应,逗号后面是val

      // 通过ajax发送服务端
      var xhr = new XMLHttpRequest;

      xhr.open('post','/admin/post.php?action=upfile'); //通过这里发送请求，php中通过get获取action，但又是以post方式提交的，upfile就可以进行这块的逻辑
      // 虽然是以post发请求，但是?后面get形式的也是可以发送的，不冲突，两种形式的书写位置都不一样，可以同时使用
      
      xhr.send(data);
      xhr.onreadystatechange = function(){
        if(xhr.readyState ==4 && xhr.status ==200){
          console.log(xhr.responseText); //测试下，点击按钮上传文件，看请求头，有没有数据

          $('.thumbnail').attr('src',xhr.responseText).show();//展示页面预览操作

          // 需要存储到数据库中，只有存储了，再用的时候才能调取出来
          // 通过点击保存操作图片路径
          // 将图片的路径作为隐藏表单的值
          // 提交给服务端进行存储
          $('#thumb').val(xhr.responseText);//js动态追加value

        }
      }


    })
  </script>
</body>
</html>
