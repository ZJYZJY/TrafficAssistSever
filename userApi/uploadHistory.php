<?php
require_once('./user_serv.php');
$history = file_get_contents('php://input');
// 测试数据
// $history = json_encode(array(
//     'isSerious' => 'true',
//     'detail' => '打发第三方的说法',
//     'nickname' => '18767549068',
//     'username' => '18767549068',
//     'longitude' => '89.234321',
//     'latitude' => '29.283921'
// ));
$history_json = json_decode($history, false);

$ser = new service();
if($ser->uploadHistory($history_json) && $ser->uploadLocation($history_json))
    echo 'true';
else
    echo 'false';
