<?php
require_once('./user_serv.php');
$JD = $_POST['JD'];
$WD = $_POST['WD'];

$ser = new service();
$array = $ser->downloadRoadCondition($JD,$WD);
if($array != null){
    $response = array(
        'code' => 200 ,
        'info' => $array
    );
    echo json_encode($response);
}else{
    $response = array(
        'code' => 400 ,
        'info' => '获取路况信息失败'
    );
}