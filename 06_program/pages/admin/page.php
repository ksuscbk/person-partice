<?php
    // 根据数据库总的数据条数  和  每页显示的条数来确定要分几页
    // php什么大小写不敏感
    $total = 400;
    // 每页条数
    $pageSize = 10;
    // 总页数
    $pageCount = ceil($total / $pageSize);
    // 一页最多显示
    $pageLimit = 5;
    // 当前页
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    // 上一页
    $prev = $currentPage - 1;
    // 下一页
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .active {
            background-color: pink;
            color: deepskyblue;
        }
        body {
            font-size: 20px;
        }
        .box {
            width: 440px;
            height: 40px;
            margin: 100px auto;
            text-align: center;
            line-height: 40px;
            background-color: skyblue;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="box">
         <!-- 为1不显示上一页 -->
    <?php if ($currentPage > 1) { ?>
        <a href="./page.php?page=<?php echo $prevPage; ?>">上一页</a>
    <?php } ?>
    <!-- 当前页 -->
    <?php foreach ($pages as $key=>$val) { ?>
        <?php if ($currentPage == $val) { ?>
            <a href="./page.php?page=<?php echo $val; ?>" class="active">
                <?php echo $val; ?>
            </a>
        <?php } else { ?>
            <a href="./page.php?page=<?php echo $val; ?>">
                <?php echo $val; ?>
            </a>
        <?php } ?>
    <?php } ?>
    <!-- 为最后一页时不显示 -->
    <?php if ($currentPage < $pageCount) { ?>
    <a href="./page.php?page=<?php echo $nextPage; ?>">下一页</a>
    <?php } ?>  
    </div>
</body>
</html>      
