<?php

//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Users {

    static function setUserProperty($property) {
        
    }

    static function getUsername($userId) {
        $db = (new DbController())->doConnect();
        $sql = "Select username from `Igitur`.`Users` where idUsers = '$userId'";
        $result = $db->query($sql);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            if ($row !== null) {
                return $row['username'];
            }
        } return false;
    }

}