<?php
require_once('./user_serv.php');

$accidentTags = mysql_real_escape_string($_POST['accidentTags']);
$nickname = mysql_real_escape_string($_POST['nickname']);
$username = mysql_real_escape_string($_POST['username']);
$longitude = (double)$_POST['longitude'];
$latitude = (double)$_POST['latitude'];
$filenames = mysql_real_escape_string($_POST['filenames']);

$history_json = (object)array(
  'username' => $username,
  'nickname' => $nickname,
  'longitude' => $longitude,
  'latitude' => $latitude,
  'accidentTags' => $accidentTags,
  'filenames' => $filenames,
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
if($ser->uploadHistory($history_json) && $ser->uploadLocation($history_json)){
  $response = array(
    'code' => 200,
    'info' => $history_json
  );
  echo json_encode($response);
}else{
  $response = array(
    'code' => 400,
    'info' => $history_json
  );
  echo json_encode($response);
}
