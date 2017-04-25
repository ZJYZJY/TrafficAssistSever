<?php
require_once('./police_serv.php');
$longitude = $_REQUEST['longitude'];
$latitude = $_REQUEST['latitude'];
$name = $_REQUEST['username'];

$ser = new Service();
$info = $ser->getAccLoc($longitude, $latitude, $name);

if($info != null){
  $response = array(
    'code' => 200,
    'info' => $info
  );
  echo json_encode($response);
}else{
  $response = array(
    'code' => 400,
    'info' => '获取事故位置失败'
  );
  echo json_encode($response);
}
