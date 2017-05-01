<?php
require_once('./user_serv.php');

$username = $_GET["username"];
$infoType = $_GET["infoType"];
$info = "'".$_GET["info"]."'";

$ser = new service();
$result=$ser->editInformation($username,$infoType,$info);
if($result==true){
  $response = array(
    'code' => 200,
    'info' => '修改成功'
  );
  echo json_encode($response);
} else {
  $response = array(
    'code' => 400,
    'info' => '修改失败'
  );
  echo json_encode($response);
}
