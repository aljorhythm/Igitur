<?php

//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');


include_once('DB.php');
include_once('UAC.php');

if (URI::QUERY_ANY('class') === 'proposition') {
    $request = URI::QUERY_ANY('request');
    switch ($request) {
        case "proposition_add":
            if (UAC::IsLoggedIn()) {
                $p = filter_input($input, 'p', FILTER_SANITIZE_STRING);
                $q = filter_input($input, 'q', FILTER_SANITIZE_STRING);
                $logicalConnective = filter_input($input, 'logicalConnective_categoryId', FILTER_SANITIZE_STRING);
                $contextId = URI::QUERY_ANY('contextId', '');
                echo json_encode(Proposition::INSERT_PROPOSITION($p, $q, $logicalConnective, UAC::GetUserId(), $contextId));
            }
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

    public static function INSERT_PROPOSITION($p, $q, $logicalConnective, $ownerId, $contextId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
INSERT INTO `Igitur`.`Proposition`
(`propositionP`,
`PropositionQ`,
`LogicalConnectiveCategory_idLogicalConnectiveCategory`,
`ownerId`,
`contextId`)
VALUES
( '$p','$q','$logicalConnective','$ownerId','$contextId');


SQL;
        $db->query($sql);
        return mysqli_insert_id($db);
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

}
