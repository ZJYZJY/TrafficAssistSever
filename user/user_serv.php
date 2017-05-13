<?php
require_once('../dbManager.php');
class Service{

    public function login($username, $password) {
        $login_sql = "call trafficassist.user_login($username, $password);";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($login_sql);
        // if($result->num_rows >= 1) {
        //     $conn->close();
        //     return true;
        // }
        if(!!$_row = $result ->fetch_object()) {

            $realname = $_row->Urlname;
            $sex = $_row->Usex;
            $telephone = $_row->Utel;
            $driver_licence_number = $_row->Udl_no;
            $car_type = $_row->Ucar_type;
            $car_number = $_row->Ucar_no;

            $array = array(
                'realname' => $realname,
                'sex' => $sex,
                'telephone' => $telephone,
                'driver_licence_number' => $driver_licence_number,
                'car_type' => $car_type,
                'car_number' => $car_number
            );
            $conn->close();
            return $array;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function signup($username, $password) {
        $reg_sql = "call trafficassist.user_signup($username, $password);";
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

    public function uploadHistory($json) {
        // $$save_sql = "call trafficassist.user_uploadHistory($json->username, $json->realname, $json->longitude,
        //      $json->latitude, $json->accidentTags, $json->filenames, 1);";
        $save_sql = "insert into user_history(Uusername, Urlname, lng, lat, DETL, PicPath, isVaild)" .
                "values('" . $json->username . "','" . $json->realname . "','" . $json->longitude . "','"
                . $json->latitude . "','" . $json->accidentTags . "','" . $json->filenames . "','1') ";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($save_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function downloadHistory($username) {
        $downloadHistory_sql = "call trafficassist.user_downloadHistory($username);";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($downloadHistory_sql);
        $arrays = array();
        while (!! $_row = $result ->fetch_object()) {
            $Detail = $_row->DETL;
            $fileNames = $_row->PicPath;
            $fileNamesarr = explode("/", $fileNames);
            // $tags = explode("/", $Detail);
            $tmp = array(
                'detail' => $Detail,
                'fileNames' => $fileNamesarr
            );
            array_push($arrays, $tmp);
        }
        $db->close();
        $allDetails = array(
            'allDetails' => $arrays
        );
        return $allDetails;
    }

    public function uploadLocation($json) {
        $saveRealtime_sql = "call trafficassist.user_uploadLocation($json->username, $json->longitude, $json->latitude);";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($saveRealtime_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

     public function editInformation($username,$infoType,$info){

        $editInformation_sql="call trafficassist.user_editInformation($username,$infoType,$info);";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($editInformation_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;

    }

    public function createDateTable($str_date) {
        $createDateTable_sql = "CREATE TABLE IF NOT EXISTS DATE".$str_date."(
        `DATEDAY` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `TIME` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `CITY` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `CAR_ID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `JD` double(10, 7) COLLATE utf8_unicode_ci DEFAULT NULL,
        `WD` double(10, 7) COLLATE utf8_unicode_ci DEFAULT NULL,
        `SPEED` double(5, 2) COLLATE utf8_unicode_ci DEFAULT NULL,
        `DIRECTION` double(5, 2) COLLATE utf8_unicode_ci DEFAULT NULL,
        `EMPTY` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
        `RECEIVE_TIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($createDateTable_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function uploadCar($json) {
        $uploadCar_sql = "insert into DATE".$json->DATEDAY. "(DATEDAY, TIME,CITY,CAR_ID,JD,WD,SPEED,DIRECTION,EMPTY) values('" . $json->DATEDAY . "','" . $json->TIME . 
        "','" . $json->CITY . "','" . $json->CAR_ID . "','" . $json->JD . "','" . $json->WD . "','" . $json->SPEED . "','" . $json->DIRECTION . "', '1;'); ";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($uploadCar_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function createCarIDTable($str_date) {
        $createCarIDTable_sql = "CREATE TABLE IF NOT EXISTS car_id_list".$str_date."(
        `CAR_ID` varchar(10) NOT NULL,
        `SIGN` double DEFAULT NULL,
         PRIMARY KEY (`CAR_ID`)
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($createCarIDTable_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function uploadCarID($json) {
        $uploadCar_sqlID = "insert into car_id_list".$json->DATEDAY. "(CAR_ID) values('" .$json->DATEDAY."'); ";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($uploadCar_sqlID);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }
}
