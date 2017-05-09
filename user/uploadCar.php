<?php
require_once('./user_serv.php');

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$DATEDAY = $data["DATEDAY"];
$TIME = $data["TIME"];
$CITY = $data["CITY"];
$CAR_ID = $data["CAR_ID"];
$JD = $data["JD"];
$WD = $data["WD"];
$SPEED = $data["SPEED"];
$DIRECTION = $data["DIRECTION"];

$ser = new service();

date_default_timezone_set('Asia/Shanghai');//设定时区
$date=date('Ymd');//获取年月日

if(date('H')==0&&date('i')==0&&date('s')==0)//时，分，秒皆为0则新建数据表
        $ser->createTable($date);

$car_json = (object)array(
  'DATEDAY' => $DATEDAY,
  'TIME' => $TIME,
  'CITY' => $CITY,
  'CAR_ID' => $CAR_ID,
  'JD' => $JD,
  'WD' => $WD,
  'SPEED'=> $SPEED,
  'DIRECTION'=> $DIRECTION,
  'date'=> $date
);

$result=$ser->uploadCar($car_json);
if($result==true){
  $response = array(
    'code' => 200,
    'info' => '上传成功'
  );
  echo json_encode($response);
} else {
  $response = array(
    'code' => 400,
    'info' => '上传失败'
  );
  echo json_encode($response);
}
?>