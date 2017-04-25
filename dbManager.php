<?php

class DBManager{
    static private $_instance;
    static private $_conn;
    private $_dbConfig = array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'trafficassist',
        'database' => 'trafficassist'
    );

    private function __construct() {}

    static public function getInstance() {
       if(!(self::$_instance instanceof self)) {
           self::$_instance = new self();
       }
       return self::$_instance;
    }

    public function connect() {
        self::$_conn = new mysqli($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);

        if(self::$_conn->connect_error) {
            die('mysql connect error' . self::$_conn->connect_error);
        }
        self::$_conn->select_db($this->_dbConfig['database']);

        return self::$_conn;
    }

    // 查询
    public function execQuery($sql) {
        return self::$_conn->query($sql);
    }

    // 增添/删除/修改
    public function execUpdate($sql) {
        return self::$_conn->query($sql);
    }

    public function close() {
        if(!self::$_conn) {
            self::$_conn->close();
            echo 'database is closed.';
        }
    }
}
