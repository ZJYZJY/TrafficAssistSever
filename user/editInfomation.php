<?php
require_once('./user_serv.php');
$json = file_get_contents("php://input");
$data = json_decode($json, true);

$username = $data["username"];
$infoType = $data["infoType"];
$info = $data["info"];

$ser = new service();
$result=$ser->editInfomation($username,$infoType,$info);
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
?>
