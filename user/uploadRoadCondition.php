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

//接收文件目录
$base_path = '../AccidentImage/';

$filename = $_FILES['image']['name'];
if(is_array($filename)){
  // print_r($filename);
  for($i = 0; $i < count($filename); $i++){
    $tmp_name = $_FILES["image"]["tmp_name"][$i];
    $name = $_FILES["image"]["name"][$i];
    $uploadfile = $base_path . $name;
    // echo $tmp_name."\n";
    // echo $name."\n";
    // echo $uploadfile."\n";
    move_uploaded_file($tmp_name, $uploadfile);
  }
}

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
