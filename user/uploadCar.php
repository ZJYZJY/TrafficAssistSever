<?php
require_once('./user_serv.php');
$DATEDAY = $_POST['DATEDAY'];
$TIME = $_POST['TIME'];
$CITY = $_POST['CITY'];
$CAR_ID = $_POST['CAR_ID'];
$JD = $_POST['JD'];
$WD = $_POST['WD'];
$SPEED = $_POST['SPEED'];
$DIRECTION = $_POST['DIRECTION'];


$car_json = (object)array(
  'DATEDAY' => $DATEDAY,
  'TIME' => $TIME,
  'CITY' => $CITY,
  'CAR_ID' => $CAR_ID,
  'JD' => $JD,
  'WD' => $WD,
  'SPEED' => $SPEED,
  'DIRECTION' => $DIRECTION,
);

$ser = new service();
$result=$ser->uploadCar($car_json);
if($result==true){
  $response = array(
    'code' => 200,
    'info' => $car_json
  );
  echo json_encode($response);
} else {
  $response = array(
    'code' => 400,
    'info' => $car_json
  );
  echo json_encode($response);
}
?>