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
        $createCarIDTable_sql = "CREATE TABLE IF NOT EXISTS CAR_ID_LIST".$str_date."(
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
        $uploadCar_sqlID = "insert into CAR_ID_LIST".$json->DATEDAY. "(CAR_ID) values('" .$json->DATEDAY."'); ";
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
    public function uploadRoadCondition($json) {
        $uploadRoadCondition_sqlID = "insert into road_issue(ISSUE_TYPE,DIRECTION,DETAIL_TAG,DETAIL,PIC_PATH,ADDRESS,JD,WD) values('" . $json->ISSUE_TYPE .
        "','" . $json->DIRECTION . "','" . $json->DETAIL_TAG . "','" . $json->DETAIL . "','" . $json->PIC_PATH . "','" . $json->ADDRESS . "','" . $json->JD . "','" . $json->WD . "'); ";
        $db = DBManager::getInstance();
        $conn = $db->connect();
        
        $result = $conn->query($uploadRoadCondition_sqlID);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
    }
    public function getDistance($lat1, $lng1, $lat2, $lng2){  //根据经纬度计算距离 
        $earthRadius = 6367000; //地球半径   
        $lat1 = ($lat1 * pi() ) / 180;   
        $lng1 = ($lng1 * pi() ) / 180;   
        $lat2 = ($lat2 * pi() ) / 180;   
        $lng2 = ($lng2 * pi() ) / 180;   
        $calcLongitude = $lng2 - $lng1;   
        $calcLatitude = $lat2 - $lat1;   
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);   
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));   
        $calculatedDistance = $earthRadius * $stepTwo;   
        return round($calculatedDistance);   
}   
    public function downloadRoadCondition($x,$y){
        $downloadRoadCondition_sql="select * from road_issue;";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $info=array();
        $min_length=20000;
        $result = $conn->query($downloadRoadCondition_sql);
        while (!! $_row = $result ->fetch_object()) {
            $Distance = $this->getDistance($x,$y,$_row->JD,$_row->WD);
            if($Distance < $min_length) {
                $picUrl=explode("/",$_row->PIC_PATH);
                $issueType=$_row->ISSUE_TYPE;
                $direction=$_row->DIRECTION;
                $detail_tag=$_row->DETAIL_TAG ;
                $detail=$_row->detail;
                $address=$_row->ADDRESS;
                $longitude = $_row->JD;
                $latitude = $_row->WD;

                $temp=array(
                    'picUrl'=> $picUrl,
                    'issueType'=> $issueType,
                    'direction'=> $direction,
                    'detail_tag'=> $detail_tag,
                    'detail'=>$detail,
                    'address'=>$address,
                    'longitude'=>$longitude,
                    'latitude'=>$latitude
                );
               array_push($info,$temp);
            }
        }
        if($info!=null){
            $db->close();
            return $info;
        }else
            {
                $db->close();
                return null;
            }
            
    }
}
