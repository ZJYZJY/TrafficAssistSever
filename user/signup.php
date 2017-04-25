<?php
require_once('./user_serv.php');
$json = file_get_contents("php://input");
$data = json_decode($json, true);

$username = $data["username"];
$password = $data["password"];

$ser = new service();
if($ser->signup($username, $password)){
  $response = array(
    'code' => 200,
    'info' => '注册成功'
  );
  echo json_encode($response);
} else {
  $response = array(
    'code' => 400,
    'info' => '注册失败'
  );
  echo json_encode($response);
}
