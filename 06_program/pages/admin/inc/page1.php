<?php

    $total = 305;
    $pageSize = 10;
    $pageCount = ceil($total / $pageSize);

    $pageLimit = 11;

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $prevPage = $currentPage - 1;
    $nextPage = $currentPage + 1;

    $start = floor($currentPage - $pageLimit / 2);
    $start = $start < 1 ? 1 : $start;
    $end = $start + $pageLimit - 1;
    $end = $end >= $pageCount ? $pageCount : $end;
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
            font-size: 26px;
        }
        .box {
            width: 600px;
            height: 40px;
            margin: 200px auto;
            text-align: center;
            line-height: 40px;
            background-color: deepskyblue;
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
        <a href="./page1.php?page=<?php echo $prevPage; ?>">上一页</a>
    <?php } ?>
    <!-- 当前页 -->
    <?php foreach ($pages as $key=>$val) { ?>
        <?php if ($currentPage == $val) { ?>
            <a href="./page1.php?page=<?php echo $val; ?>" class="active">
                <?php echo $val; ?>
            </a>
        <?php } else { ?>
            <a href="./page1.php?page=<?php echo $val; ?>">
                <?php echo $val; ?>
            </a>
        <?php } ?>
    <?php } ?>
    <!-- 为最后一页时不显示 -->
    <?php if ($currentPage < $pageCount) { ?>
    <a href="./page1.php?page=<?php echo $nextPage; ?>">下一页</a>
    <?php } ?>  
    </div>
</body>
</html>      