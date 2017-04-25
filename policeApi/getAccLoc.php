<?php
require_once('./police_serv.php');
$longitude = $_REQUEST['longitude'];
$latitude = $_REQUEST['latitude'];

$ser = new Service();
echo $ser->getAccLoc($longitude, $latitude);