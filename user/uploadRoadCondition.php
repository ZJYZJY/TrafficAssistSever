<?php
require_once('./user_serv.php');

$PROBLEM_TYPE = $_POST['PROBLEM_TYPE'];
$LANE_TYPE = $_POST['LANE_TYPE'];
$DETAIL_TAG = $_POST['DETAIL_TAG'];
$DETAIL = $_POST['DETAIL'];
$PIC_PATH = $_POST['PIC_PATH'];
$JD = $_POST['JD'];
$WD = $_POST['WD'];

$car_json = (object)array(
  'PROBLEM_TYPE' => $PROBLEM_TYPE,
  'LANE_TYPE' => $LANE_TYPE,
  'DETAIL_TAG' => $DETAIL_TAG,
  'DETAIL' => $DETAIL,
  'PIC_PATH' => $PIC_PATH,
  'JD' => $JD,
  'WD'=> $WD
);

$ser = new service();
$result = $ser->uploadRoadCondition($car_json);

if($result == true){
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
