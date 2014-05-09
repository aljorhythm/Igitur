<?php

include_once 'DB.php';
include_once 'UAC.php';
include_once 'Utilities.php';

//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (URI::QUERY_ANY('class') === 'context') {
    $request = URI::QUERY_ANY('request');
    switch ($request) {
        case 'create':
            if (UAC::isLoggedIn()) {
                $contextName = URI::QUERY_ANY('contextName');
                echo json_encode(Context::InsertContext($contextName, UAC::getUserId()));
            }
            break;
        case 'delete':
            if (UAC::isLoggedIn()) {
                echo json_encode(Context::DeleteContext($contextName));
            }
            break;
        case 'getAll':
            $userId = URI::QUERY_ANY('userId', UAC::getUserId());
            echo json_encode(Context::GetUserContexts($userId));
            break;
    }
}

class Context {

    public static function InsertContext($contextName, $userId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
INSERT INTO `Igitur`.`Context`
(`contextName`,`ownerId`) VALUES ('$contextName','$userId'); 
SQL;
        $db->query($sql);
        return mysqli_insert_id($db);
    }

    public static function DeleteContext($contextName) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
DELETE FROM `Igitur`.`Context`
WHERE contextName = '$contextName';
SQL;
        return $db->query($sql) === false;
    }

    public static function GetUserContexts($userId) {
        UAC::getUserId();
        $db = (new DbController())->doConnect();
        $sql = "Select * from Context where ownerId = '$userId'";

        if (!!$result = $db->query($sql)) {
            $ret = array();
            while ($row = $result->fetch_assoc()) {
                array_push($ret, $row);
            }
            return $ret;
        }
    }

}