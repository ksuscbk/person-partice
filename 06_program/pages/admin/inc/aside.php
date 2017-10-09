<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $_SESSION['user_info']['avatar']; ?>">
      <h3 class="name"><?php echo $_SESSION['user_info']['nickname']; ?></h3>
    </div>
    <ul class="nav">
    <!-- 当前页高亮显示 -->
      <li <?php if ($active == 'dashboard') { ?> class="active" <?php } ?>>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li <?php if (in_array($active, $actives)) { ?> class="active" <?php } ?>>
        <a href="#menu-posts" class="collapsed" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php if (in_array($active, $actives)) { ?> in <?php } ?>" >
        <!-- 判断变量是否等于当前 -->
          <li <?php if ($active == 'posts') { ?> class="active" <?php } ?>>
            <a href="/admin/posts.php">
            所有文章
            </a>
          </li>
          <li <?php if ($active == 'post') { ?> class="active" <?php } ?>>
            <a href="/admin/post.php">写文章
            </a>
          </li>
          <li <?php if ($active == 'category') { ?> class="active" <?php } ?>>
            <a href="/admin/categories.php">分类目录
            </a>
          </li>
        </ul>
      </li>
      <li>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li <?php if ($action == 'users') { ?> class="active" <?php } ?>>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li <?php if (in_array($active, $cogs)) { ?> class="active" <?php } ?>>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php if(in_array($active, $cogs)) { ?> in <?php } ?>">
          <li <?php if($active == 'menus') { ?> class="active" <?php } ?>><a href="nav-menus.php">导航菜单</a></li>
          <li <?php if($active == 'slides') { ?> class="active" <?php } ?>><a href="slides.php">图片轮播</a></li>
          <li <?php if($active == 'settings') { ?> class="active" <?php } ?>><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>