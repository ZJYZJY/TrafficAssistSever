<?php
require_once('./user_serv.php');
$json = file_get_contents("php://input");
$data = json_decode($json, true);

$username = $data["username"];
$password = $data["password"];

$ser = new service();
$array = $ser->login($username, $password);
if($array != null){
  $response = array(
    'code' => 200,
    'info' => $array
  );
  echo json_encode($response);
} else {
  $response = array(
    'code' => 400,
    'info' => '登录失败'
  );
  echo json_encode($response);
}
