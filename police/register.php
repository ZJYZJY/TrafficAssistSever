<?php
require_once('./police_serv.php');
$username = $_REQUEST["username"];
$password = $_REQUEST["password"];

$ser = new service();
if($ser->register($username, $password)){
  $response = array(
    'code' => 200,
    'info' => '注册成功'
  );
  echo json_encode($response);
}else{
  $response = array(
    'code' => 400,
    'info' => '注册失败'
  );
  echo json_encode($response);
}
