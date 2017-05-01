<?php
require_once('../dbManager.php');
class Service{

    public function login($username, $password) {
        $login_sql = "call trafficassist.police_login($username, $password)";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($login_sql);
        if($result->num_rows >= 1) {
            $conn->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function register($username, $password) {
        $register_sql = "call trafficassist.police_register($username, $password)";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($reg_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function getAccLoc($x, $y, $name) {
        $min_length = 100000;
        $getLocation_sql = "call trafficassist.police_getLocation()";
        $downloadAccTags_sql = "call trafficassist.police_downloadAccTags($name, '1')";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($getLocation_sql);
        while (!! $_row = $result ->fetch_object()) {
            $temp = pow($_row->location_x - $x, 2) + pow($_row->location_y - $y, 2);
            if($temp < $min_length) {
                $min_length = $temp;
                $min_x = $_row->location_x;
                $min_y = $_row->location_y;
                $username = $_row->username;
            }
        }

        $result = $conn->query($downloadAccTags_sql);
        while (!! $_row = $result ->fetch_object()) {
            $tagStr = $_row ->DETL;
            $filenameStr = $_row ->PicPath;
            $tags = explode("/", $tagStr);
            $filenames = explode("/", $filenameStr);
        }
        $db->close();
        if($username != null && $min_x != null && $min_y != null){
            $info = array(
                'username' => $username,
                'longitude' => $min_x,
                'latitude' => $min_y,
                'tags' => $tags,
                'filenames' => $filenames
            );
            return $info;
        }else
            return null;
    }

    public function downloadAccInfo($username) {
        $downloadAccTags_sql = "call trafficassist.police_downloadAccInfo($username, '1')";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($downloadAccTags_sql);
        while (!! $_row = $result ->fetch_object()) {
            $tagStr = $_row ->DETL;
            $filenameStr = $_row ->PicPath;
            $tags = explode("/", $tagStr);
            $filenames = explode("/", $filenameStr);
        }
        $db->close();
        $accidentTags = array(
            'tags' => $tags,
            'filenames' => $filenames
        );
        return $accidentTags;
    }
}
