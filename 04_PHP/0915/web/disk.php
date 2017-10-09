<?php
    
    // 定义常量
    define('DISK', 'E:\\');

    // 获取磁盘空间信息并返回
    $total = round(disk_total_space(DISK) / 1024 / 1024 / 1024, 1);
    $free = round(disk_free_space(DISK) / 1024 /1204 / 1024, 1);
    $used = $total - $free;

    return array(
        'total' => $total,
        'free' => $free,
        'used' => $used,
        'percent' => round($used / $total, 1) * 100 . '%'
    );