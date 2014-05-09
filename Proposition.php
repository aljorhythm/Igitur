<?php

//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php

include_once('DB.php');
// p: proposition
// d: definition
// s: statement


if (($post = filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') || filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    if ($post) {
        $input = INPUT_POST;
    } else {
        $input = INPUT_GET;
    }
    $type = filter_input($input, 'type', FILTER_SANITIZE_STRING);

    if ($type == 'json' || true) {//dunnid type
        header('Content-Type: application/json');
        $request = filter_input($input, 'request', FILTER_SANITIZE_STRING);
        switch ($request) {
            case "proposition_add":
                $p = filter_input($input, 'p', FILTER_SANITIZE_STRING);
                $q = filter_input($input, 'q', FILTER_SANITIZE_STRING);
                $logicalConnective = filter_input($input, 'logicalConnective_categoryId', FILTER_SANITIZE_STRING);
                $contextId = filter_input($input, 'contextId', FILTER_SANITIZE_STRING);
                echo json_encode(Proposition::INSERT_PROPOSITION($p, $q, $logicalConnective));
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
}

class Proposition { 

    public static function INSERT_PROPOSITION($p, $q, $logicalConnective,$contextId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
INSERT INTO `Igitur`.`Proposition`
(`idProposition`,`propositionP`,`PropositionQ`,`LogicalConnectiveCategory_idLogicalConnectiveCategory`.`Context_idContext`)
VALUES
('$p','$q',$logicalConnective,$contextId);

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
            echo $row['idProposition'] . " " . $row['propositionP'] . " " . $row['PropositionQ'] . " " . $row['LogicalConnectiveCategory_idLogicalConnectiveCategory'];
        }
    }
            
}
