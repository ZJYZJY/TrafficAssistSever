<?php
require_once('./police_serv.php');
$username = $_REQUEST['username'];

$ser = new Service();
$info = $ser->downloadAccInfo($username);

if($info != null){
  $response = array(
    'code' => 200,
    'info' => $info
  );
  echo json_encode($response);
}else{
  $response = array(
    'code' => 400,
    'info' => '获取事故信息失败'
  );
  echo json_encode($response);
}
