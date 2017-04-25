<?php
/**
 * 获取用户Token
 */
include 'rongcloud.php';
$appKey = 'x18ywvqfxlm1c';
$appSecret = 'CJWZIhYBD0cjMe';
$RongCloud = new RongCloud($appKey, $appSecret);

$username = $_REQUEST['username'];
$tname = $_REQUEST['tname'];

$result = $RongCloud->user()->getToken($username, $tname, 'http://120.27.130.203:8001/trafficassist/userIcon/user_default_icon.jpg');
echo $result;
