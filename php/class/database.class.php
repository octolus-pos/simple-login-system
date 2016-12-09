<?php
/*
* author Lachie
*/

class Database
{
    public static $errors = [];
    public static $instance = null;
    public static function instance($host, $user, $pass, $database)
    {

        if (self::$instance === null) {
            self::$instance = new PDO('mysql:host='.$host.';dbname='.$database, $user, $pass);
        }
        return self::$instance;
    }

    public static function Query($q, $data = [])
    {
        $query = self::$instance->prepare($q);
        $query->execute($data);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($q, $data = [])
    {
        $query = self::$instance->prepare($q);
        return $query->execute($data);
    }

    public static function QueryAll($q, $data = [])
    {
        $query = self::$instance->prepare($q);
        $query->execute($data);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function Checkexists($input ,$input1, $table, $error = true)
    {
        $arr = [
            "input_" => stripcslashes(strip_tags($input))
        ];
        $u = self::Query("SELECT * FROM $table WHERE $input1=:input_", $arr);
        if(!empty($u)) {
            self::SetError($error);
        }
    }

    public static function SetError($input)
    {
        self::$errors[] = $input;
    }

    public static function GetErrors()
    {
        return self::$errors;
    }

    public static function GetLastError()
    {
        if(!empty(self::$errors)) {
            return self::$errors[sizeof(self::$errors) - 1];
        }
    }

    public static function CheckEmpty($input, $error)
    {
        if(strlen($input) <= 0) {
            self::SetError($error);
        }
    }

    public static function strip(...$str)
    {
        $out = [];
        foreach ($str as $ptr) {
            $out[] = strip_tags(htmlspecialchars($ptr));
        }
        return $out;
    }

    public static function cmpStr($str1, $str2, $error = "")
    {
        if($str1 == $str2) {

        } else {
            self::SetError($error);
        }
    }

    public static function isNull($str1, $error = "")
    {
        if($str1 == "") {
            self::SetError($error);
        }
    }

    public function __destruct() {
        self::$instance = null;
    }
}


