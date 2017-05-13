<?php
require_once('./user_serv.php');

$DATEDAY = $_POST["DATEDAY"];
$TIME = $_POST["TIME"];
$CITY = $_POST["CITY"];
$CAR_ID = $_POST["CAR_ID"];
$JD = (double)$_POST["JD"];
$WD = (double)$_POST["WD"];
$SPEED = (double)$_POST["SPEED"];
$DIRECTION = (double)$_POST["DIRECTION"];

$ser = new service();

date_default_timezone_set('Asia/Shanghai');//设定时区
$date=date('Ymd');//获取年月日

//if(date('H')==0&&date('i')==0&&date('s')==0)//时，分，秒皆为0则新建数据表
        $ser->createDateTable($DATEDAY);
        $ser->createCarIDTable($DATEDAY);

$car_json = (object)array(
  'DATEDAY' => $DATEDAY,
  'TIME' => $TIME,
  'CITY' => $CITY,
  'CAR_ID' => $CAR_ID,
  'JD' => $JD,
  'WD' => $WD,
  'SPEED'=> $SPEED,
  'DIRECTION'=> $DIRECTION
);

$result=$ser->uploadCar($car_json);
$ser->uploadCarID($car_json);
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