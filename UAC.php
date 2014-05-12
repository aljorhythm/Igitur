<?php

//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once './DB.php';
include_once './Utilities.php';

session_start();
if (URI::QUERY_ANY('class') === 'uac') {
    $request = URI::QUERY_ANY('request');
    if ($request === 'create') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo json_encode(UAC::createUser($username, $password));
    } elseif ($request === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo json_encode(UAC::login($username, $password));
    } elseif ($request === 'checkUsername') {
        $username = $request = URI::QUERY_ANY('username');
        echo json_encode(UAC::doesUserExist($username));
    } elseif ($request === 'logout') {
        echo json_encode(UAC::logout());
    }
}

class UAC {

    static function IsLoggedIn() {
        return isset($_SESSION['user']);
    }

    static function logout() {
        unset($_SESSION['user']);
    }

    static function getUsername() {
        return isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : "";
    }

    static function GetUserId() {
        return isset($_SESSION['user']['userId']) ? $_SESSION['user']['userId'] : "";
    }

    static function login($username, $password) {
        $ret = UAC::isValidUser($username, $password);
        if ($ret !== false) {
            $user = array("userId" => $ret['idUsers'], "username" => $ret['username']);
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    static function isValidUser($username, $password) {
        $db = (new DbController())->doConnect();
        $sql = "Select * from `Igitur`.`Users` where username = '$username'";
        $result = $db->query($sql);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            if ($row !== null && password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    static function isValidPassword($password) {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return false;
        }return true;
    }

    static function createUser($username, $password) {
        $db = (new DbController())->doConnect();
        if (!preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/', $username) || !self::isValidPassword($password)) {
            $errorMsg = <<<msg
Password:
Must be a minimum of 8 characters
Must contain at least 1 number
Must contain at least one uppercase character
Must contain at least one lowercase character
Username:
Must start with letter
6-32 characters
Letters and numbers only
msg;
            return array("error", $errorMsg);
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = <<<SQL
INSERT INTO `Igitur`.`Users`
(`username`,`password`) VALUES ('$username','$password'); 
SQL;
        $db->query($sql);
        return mysqli_insert_id($db);
    }

    static function doesUserExist($username) {
        $db = (new DbController())->doConnect();
        $sql = "Select Count(*) as c from `Igitur`.`Users` where username = '$username'";
        $result = $db->query($sql);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            if ($row['c'] === '1') {
                return true;
            }
        }
        return false;
    }

}
