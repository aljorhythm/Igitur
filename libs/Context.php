<?php

include_once __DIR__.'/DB.php';
include_once __DIR__.'/UAC.php';
include_once __DIR__.'/Utilities.php';

//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (URI::QUERY_ANY('class') === 'context') {
    $request = URI::QUERY_ANY('request');
    switch ($request) {
        case 'create':
            if (UAC::IsLoggedIn()) {
                $contextName = URI::QUERY_ANY('contextName');
                echo json_encode(Context::InsertContext($contextName, UAC::GetUserId()));
            }
            break;
        case 'delete':
            if (UAC::IsLoggedIn()) {
                echo json_encode(Context::DeleteContext($contextName));
            }
            break;
        case 'getAll':
            $userId = URI::QUERY_ANY('userId', UAC::GetUserId());
            echo json_encode(Context::GetUserContexts($userId));
            break;
        case 'setDescription':
            if (UAC::IsLoggedIn()) {
                $description = URI::QUERY_ANY("description");
                $contextId = URI::QUERY_ANY("contextId");
                $userId = UAC::GetUserId();
                echo json_encode(Context::SetContextDescription($contextId, $description, $userId));
            }
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
        $sql = "Select * from Context where ownerId = '$userId'";
        
        $db = (new DbController())->doConnect();

        if (!!$result = $db->query($sql)) {
            $ret = array();
            while ($row = $result->fetch_assoc()) {
                array_push($ret, $row);
            }
            return $ret;
        }
    }

    public static function SetContextDescription($contextId, $description, $userId) {
        $sql = <<<SQL
                UPDATE `Igitur`.`Context` SET `contextDescription` = SUBSTRING('$description',1,400)
                WHERE `idContext` = $contextId AND ownerId = $userId;
SQL;
        $db = (new DbController())->doConnect(); 
        return $db->query($sql);
    }

    public static function GetContext($contextId) {
        $db = (new DbController())->doConnect();
        $sql = "Select * from Context where idContext = '$contextId'";

        if (!!$result = $db->query($sql)) {
            if (($row = $result->fetch_assoc())) {
                return $row;
            }
        }
        return null;
    }

}
