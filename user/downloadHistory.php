<?php
require_once('./user_serv.php');
$username = $_GET["username"];

$ser = new service();
$array = $ser->downloadHistory($username);
if($array != null){
  $response = array(
    'code' => 200 ,
    'info' => $array
  );
  echo json_encode($response);
}else{
  $response = array(
    'code' => 201 ,
    'info' => '历史记录为空'
  );
}
