
<?php
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

    if ($type == 'json') {
        header('Content-Type: application/json');
        $request = filter_input($input, 'request', FILTER_SANITIZE_STRING);
        switch ($request) {
            case "proposition_add":
                $excludeCategoryId = filter_input($input, 'exclude_category', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveSymbol::GET_SYMBOLS($excludeCategoryId));
                break;

            default: echo "error";
        }
    }
}

class Proposition {

    var $id, $p, $q, $connective;

    public static function INSERT_PROPOSITION($phrase) {
        $db = (new DbController())->doConnect();
        $sql = "INSERT INTO `Igitur`.`LogicalConnectivePhrase` ( `logicalConnectivePhrase`) VALUES ('$phrase');";
        $db->query($sql);
        return mysqli_insert_id($db);
    }

    public function __construct($id, $p, $q, $connective) {
        $this->id = $id;
        $this->p = $p;
        $this->q = $q;
        $this->connective = $connective;
    }

}
