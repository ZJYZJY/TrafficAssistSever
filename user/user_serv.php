<?php
require_once('../dbManager.php');
class Service{

    public function login($username, $password) {
        $login_sql = "call trafficassist.user_login($username,$password);";
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($login_sql);

        if($result->num_rows >= 1) {
            $result = $result ->fetch_object();
            $realname=$result->Urlname;
            $sex=$result->Usex;
            $telephone=$reasult->Utel;
            $driver_licence_number=$result->Udl_no;
            $car_type=$result->Ucar_type;
            $car_number=$result->Ucar_no;

            $array=array(
                'realname'=>$realname,
                'sex'=>$sex,
                'telephone'=>$telephone,
                'driver_licence_number'=>$driver_licence_number,
                'car_type'=>$car_type,
                'car_number'=>$car_number
            );
            $conn->close(); 
            $allDetails = array(
            'allDetails' => $array
           );
        return $allDetails;
        }
        echo $conn->error;
        $db->close();
        return false;
    }

    public function signup($username, $password) {
        $reg_sql = "call trafficassist.user_signup($username,$password);";
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
        $save_sql = "call trafficassist.user_uploadHistory($json->username , $json->realname , $json->longitude ,
             $json->latitude , $json->accidentTags ,$json->filenames ,1); ";
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
        $saveRealtime_sql = "call trafficassist.user_uploadLocation($json->username, $json->longitude, $json->latitude );";
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

    public function editInfomation($username,$select,$value){
        switch($select){
            case 1: $editInfomation_sql="call trafficassist.user_editRlname($username,$value);";break;
            case 2: $editInfomation_sql="call trafficassist.user_editTel($username,$value);";break;
            case 3: $editInfomation_sql="call trafficassist.user_editDl_no($username,$value);";break;
            case 4: $editInfomation_sql="call trafficassist.user_editCar_type($username,$value);";break;
            case 5: $editInfomation_sql="call trafficassist.user_editCar_no($username,$value);";break;
            default:
        }
        
        $db = DBManager::getInstance();
        $conn = $db->connect();

        $result = $conn->query($editInfomation_sql);
        if($result === true) {
            $db->close();
            return true;
        }
        echo $conn->error;
        $db->close();
        return false;
        
    }
}
