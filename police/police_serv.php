<?php
require_once('../dbManager.php');
class Service{

    public function login($username, $password) {
        $login_sql = "select * from police_info where Pusername = '" . $username . "' and Ppassword = '" . $password . "'";
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
        $reg_sql = "insert into police_info(Pusername, Ppassword) values('" . $username . "','" . $password . "') ";
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
        $getLocation_sql = "select username, location_x, location_y from accident_realtime";
        $downloadAccTags_sql = "select * from user_history where Uusername = '" . $name . "' and isVaild = '1'";
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
            $tagStr = $_row ->Detail;
            $filenameStr = $_row ->PicturePath;
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
        $downloadAccTags_sql = "select * from user_history where Uusername = '" . $username . "' and isVaild = '1'";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($downloadAccTags_sql);
        while (!! $_row = $result ->fetch_object()) {
            $tagStr = $_row ->Detail;
            $filenameStr = $_row ->PicturePath;
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
