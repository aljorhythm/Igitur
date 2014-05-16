<?php

//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once(__DIR__ . '/DB.php');
include_once(__DIR__ . '/UAC.php');

if (URI::QUERY_ANY('class') === 'proposition') {
    $request = URI::QUERY_ANY('request');
    switch ($request) {
        case "proposition_add":
            if (UAC::IsLoggedIn()) {
                $p = URI::QUERY_POST('p', '');
                $q = URI::QUERY_POST('q', '');
                $logicalConnective = URI::QUERY_POST('logicalConnective_categoryId', '');
                echo json_encode(Proposition::INSERT_PROPOSITION($p, $q, $logicalConnective, UAC::GetUserId()));
            }
            break;
        case "proposition_get_user":
            $userId = URI::QUERY_ANY('userId');
            $rangeX = URI::QUERY_ANY('rangeX');
            $rangeY = URI::QUERY_ANY('rangeY');
            echo json_encode(Proposition::GET_PROPOSITIONS_USER($userId, $rangeX, $rangeY));
            break;
        case "proposition_get":
            $propositionId = filter_input($input, 'propostion_id', FILTER_SANITIZE_STRING);
            echo json_encode(Proposition::GET_PROPOSITION($propositionId));
            break;
        case "proposition_search":
            $propositionId = filter_input($input, 'propostion_id', FILTER_SANITIZE_STRING);
            echo json_encode(Proposition::GET_PROPOSITION($propositionId));
            break;
        default: echo "error";
    }
}

class Proposition {

    public static function INSERT_PROPOSITION($p, $q, $logicalConnective, $ownerId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
INSERT INTO `Igitur`.`Proposition`
(`propositionP`,
`propositionQ`,
`LogicalConnectiveCategory_idLogicalConnectiveCategory`,
`ownerId`)
VALUES
( '$p','$q','$logicalConnective','$ownerId');


SQL;
        $db->query($sql);
        return mysqli_insert_id($db) . "here";
    }

    public function __construct($id, $p, $q, $connective) {
        $this->id = $id;
        $this->p = $p;
        $this->q = $q;
        $this->connective = $connective;
    }

    public static function GET_PROPOSITION($propositionId) {
        $sql = <<<SQL
            SELECT Proposition.*
    FROM Proposition
    WHERE Proposition.idProposition = $propositionId
SQL;
        $db = (new DbController())->doConnect();
        $result = $db->query($sql);
        if (($row = mysqli_fetch_array($result)) !== false) {
            return $row;
        }
    }

    public static function GET_PROPOSITIONS_USER($userId, $rangeX = null, $rangeY = null) {
        $LIMIT = "";
        if ($rangeX !== null) {
            $LIMIT = "Limit $rangeX";
            if ($rangeY !== null) {
                $LIMIT .= ", $rangeY";
            }
        }
        $sql = <<<SQL
            SELECT *
    FROM Proposition
    WHERE ownerId = $userId $LIMIT;
SQL;
        $db = (new DbController())->doConnect();
        $result = $db->query($sql);
        $ret = array();
        if ($result !== false) {
            while (( $row = $result->fetch_assoc()) !== null) {
                array_push($ret, $row);
            }
        }
        return $ret;
    }

}
