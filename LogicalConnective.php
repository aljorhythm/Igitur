<?php

include_once('DB.php');

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
            case "category_add_phrase":
                $categoryId = filter_input($input, 'category_id', FILTER_SANITIZE_STRING);
                $phraseId = filter_input($input, 'phrase_id', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::ADD_PHRASE($categoryId, $phraseId));
                break;
            case "category_remove_phrase":
                $categoryId = filter_input($input, 'category_id', FILTER_SANITIZE_STRING);
                $phraseId = filter_input($input, 'phrase_id', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::REMOVE_PHRASE($categoryId, $phraseId));
                break;
            case "category_add_symbol":
                $categoryId = filter_input($input, 'category_id', FILTER_SANITIZE_STRING);
                $symbolId = filter_input($input, 'symbol_id', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::ADD_SYMBOL($categoryId, $symbolId));
                break;
            case "category_remove_symbol":
                $categoryId = filter_input($input, 'category_id', FILTER_SANITIZE_STRING);
                $symbolId = filter_input($input, 'symbol_id', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::REMOVE_SYMBOL($categoryId, $symbolId));
                break;
            case "category_all":
                echo json_encode(LogicalConnectiveCategory::GET_ALL_CATEGORIES());
                break;
            case "category_add":
                $categoryName = filter_input($input, 'category_name', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::ADD_CATEGORY($categoryName));
                break;
            case "category_phrases":
                $categoryId = filter_input($input, 'category_id', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::GET_PHRASES($categoryId));
                break;
            case "category_symbols":
                $categoryId = filter_input($input, 'category_id', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::GET_SYMBOLS($categoryId));
                break;
            case "category_get":
                $categoryId = filter_input($input, 'category_id', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveCategory::GET_CATEGORY($categoryId));
                break;
            case "phrase_add":
                $phrase = filter_input($input, 'phrase', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectivePhrase::INSERT_PHRASE($phrase));
                break;
            case "phrase_search":
                $searchTerm = filter_input($input, 'search_term', FILTER_SANITIZE_STRING);
                $excludeCategoryId = filter_input($input, 'exclude_category', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectivePhrase::SEARCH_PHRASES($searchTerm, $excludeCategoryId));
                break;
            case "symbol_get":
                $excludeCategoryId = filter_input($input, 'exclude_category', FILTER_SANITIZE_STRING);
                echo json_encode(LogicalConnectiveSymbol::GET_SYMBOLS($excludeCategoryId));
                break;

            default: echo "error";
        }
    }
}

function Test() {
    $db = (new DbController())->doConnect();
    if (!$db->set_charset("utf8")) {
        die('sumting wong');
    }
    $sql = "Select * from LogicalConnectiveSymbol";

    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    }
    while ($row = $result->fetch_assoc()) {
        echo $row['idLogicalConnectiveSymbol'] . '&nbsp;' . $row['logicalConnectiveSymbol'] . '<br />';
    }
}

class LogicalConnectiveCategory {

    public $category, $id;

    public function __construct($id, $category) {
        $this->id = $id;
        $this->category = $category;
    }

    public static function GET_ALL_CATEGORIES() {
        $db = (new DbController())->doConnect();
        $sql = "Select * from LogicalConnectiveCategory ORDER BY idLogicalConnectiveCategory";

        if (!!$result = $db->query($sql)) {
            $array = array();
            while ($row = $result->fetch_assoc()) {
                $add = new LogicalConnectiveCategory($row['idLogicalConnectiveCategory'], $row['logicalConnectiveCategoryName']);
                array_push($array, $add);
            }
            return $array;
        }
    }

    public static function ADD_CATEGORY($categoryName) {
        $db = (new DbController())->doConnect();

        $sql = <<<SQL
INSERT INTO `Igitur`.`LogicalConnectiveCategory` (`logicalConnectiveCategoryName`) VALUES ('$categoryName');
SQL;

        $db->query($sql);
        return mysqli_insert_id($db);
    }

    public static function GET_PHRASES($categoryId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
           SELECT 
    p.idLogicalConnectivePhrase, p.logicalConnectivePhrase
FROM
    Igitur.LogicalConnectiveCategory_has_LogicalConnectivePhrase chp
        inner join
    Igitur.LogicalConnectivePhrase p ON chp.LogicalConnectivePhrase_idLogicalConnectivePhrase = p.idLogicalConnectivePhrase
where
    chp.LogicalConnectiveCategory_idLogicalConnectiveCategory = $categoryId;
SQL;

        if (!!$result = $db->query($sql)) {
            $array = array();
            while ($row = $result->fetch_assoc()) {
                $add = new LogicalConnectivePhrase($row['idLogicalConnectivePhrase'], $row['logicalConnectivePhrase']);
                array_push($array, $add);
            }
            return $array;
        }
    }

    public static function ADD_PHRASE($categoryId, $phraseId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
                INSERT INTO `Igitur`.`LogicalConnectiveCategory_has_LogicalConnectivePhrase`
(`LogicalConnectiveCategory_idLogicalConnectiveCategory`,
`LogicalConnectivePhrase_idLogicalConnectivePhrase`)
VALUES
($categoryId,$phraseId);
SQL;
        $db->query($sql);
        return mysqli_insert_id($db);
    }

    public static function REMOVE_PHRASE($categoryId, $phraseId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
     
     SET SQL_SAFE_UPDATES=0;
DELETE FROM `Igitur`.`LogicalConnectiveCategory_has_LogicalConnectivePhrase` 
WHERE
    `Igitur`.`LogicalConnectiveCategory_has_LogicalConnectivePhrase`.LogicalConnectiveCategory_idLogicalConnectiveCategory = $categoryId
    AND `Igitur`.`LogicalConnectiveCategory_has_LogicalConnectivePhrase`.LogicalConnectivePhrase_idLogicalConnectivePhrase = $phraseId;
SQL;

        $db->multi_query($sql);
        return $db->affected_rows;
    }

    public static function GET_SYMBOLS($categoryId) {
        $db = (new DbController())->doConnect();
        mysqli_set_charset($db, "utf8");
        $sql = <<<SQL
         SELECT 
    s.idLogicalConnectiveSymbol, s.logicalConnectiveSymbol
FROM
    Igitur.LogicalConnectiveCategory_has_LogicalConnectiveSymbol chs
        inner join
    Igitur.LogicalConnectiveSymbol s ON chs.LogicalConnectiveSymbol_idLogicalConnectiveSymbol = s.idLogicalConnectiveSymbol
where
    chs.LogicalConnectiveCategory_idLogicalConnectiveCategory = $categoryId;
SQL;

        if (!!$result = $db->query($sql)) {

            $array = array();
            while ($row = $result->fetch_assoc()) {
                $add = array('id' => $row['idLogicalConnectiveSymbol'], 'symbol' => $row['logicalConnectiveSymbol']);
                array_push($array, $add);
            }
            return $array;
        }
    }

    public static function ADD_SYMBOL($categoryId, $symbolId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
               INSERT INTO `Igitur`.`LogicalConnectiveCategory_has_LogicalConnectiveSymbol`
(`LogicalConnectiveCategory_idLogicalConnectiveCategory`,
`LogicalConnectiveSymbol_idLogicalConnectiveSymbol`)
VALUES
($categoryId,$symbolId);
SQL;
        $db->query($sql);
        return mysqli_insert_id($db);
    }

    public static function REMOVE_SYMBOL($categoryId, $symbolId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
     
     SET SQL_SAFE_UPDATES=0;
DELETE FROM `Igitur`.`LogicalConnectiveCategory_has_LogicalConnectiveSymbol` 
WHERE
    Igitur.LogicalConnectiveCategory_has_LogicalConnectiveSymbol.LogicalConnectiveCategory_idLogicalConnectiveCategory = $categoryId
    AND Igitur.LogicalConnectiveCategory_has_LogicalConnectiveSymbol.LogicalConnectiveSymbol_idLogicalConnectiveSymbol = $symbolId;
SQL;

        $db->multi_query($sql);
        return $db->affected_rows;
    }

    public static function GET_CATEGORY($categoryId) {
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
                SELECT `LogicalConnectiveCategory`.`idLogicalConnectiveCategory`,
        `LogicalConnectiveCategory`.`logicalConnectiveCategoryName`
        FROM `Igitur` . `LogicalConnectiveCategory` WHERE `LogicalConnectiveCategory`.`idLogicalConnectiveCategory`=$categoryId;
SQL;
        if (!!$result = $db->query($sql)) {
            if (($row = $result->fetch_assoc())) {
                return new LogicalConnectiveCategory($row['idLogicalConnectiveCategory'], $row['logicalConnectiveCategoryName']);
            }
        }
        return null;
    }

}

class LogicalConnectiveSymbol {

    public $symbol, $id;

    public function __construct($id, $symbol) {
        $this->id = $id;
        $this->symbol = $symbol;
    }

    public static function GET_SYMBOLS($excludeCategoryId) {
        $db = (new DbController())->doConnect();
        if (is_null($excludeCategoryId)) {
            $sql = "Select * from LogicalConnectiveSymbol ORDER BY idLogicalConnectiveSymbol";
        } else {
            $sql = <<<SQL
SELECT 
    *,
    SUM(IF(chs.LogicalConnectiveCategory_idLogicalConnectiveCategory = $excludeCategoryId,
        1,
        0)) AS exclude
FROM
    Igitur.LogicalConnectiveSymbol s
        left join
    Igitur.LogicalConnectiveCategory_has_LogicalConnectiveSymbol chs ON s.idLogicalConnectiveSymbol = chs.LogicalConnectiveSymbol_idLogicalConnectiveSymbol
 
group by s.idLogicalConnectiveSymbol
having exclude = 0
order by s.idLogicalConnectiveSymbol;
SQL;
        }
        mysqli_set_charset($db, "utf8");
        if (!!$result = $db->query($sql)) {
            $array = array();
            while ($row = $result->fetch_assoc()) {
                $add = new LogicalConnectiveSymbol($row['idLogicalConnectiveSymbol'], $row['logicalConnectiveSymbol']);
                array_push($array, $add);
            }
            return $array;
        }
    }

}

class LogicalConnectivePhrase {

    public $phrase, $id;

    public function __construct($id, $phrase) {
        $this->id = $id;
        $this->phrase = $phrase;
    }

    public static function SEARCH_PHRASES($searchTerm, $excludeCategoryId) {
        if (is_null($excludeCategoryId)) {
            $excludeCategoryId = 0;
        }
        $db = (new DbController())->doConnect();
        $sql = <<<SQL
            SELECT 
    *,
    SUM(IF(chp.LogicalConnectiveCategory_idLogicalConnectiveCategory = '$excludeCategoryId',
        1,
        0)) AS exclude
FROM
    Igitur.LogicalConnectivePhrase p
        left join
    Igitur.LogicalConnectiveCategory_has_LogicalConnectivePhrase chp ON p.idLogicalConnectivePhrase = chp.LogicalConnectivePhrase_idLogicalConnectivePhrase
where p.logicalConnectivePhrase like ('%$searchTerm%')
    group by p.idLogicalConnectivePhrase
having exclude = 0 order by p.LogicalConnectivePhrase; 
SQL;

        if (!!$result = $db->query($sql)) {

            $array = array();
            while ($row = $result->fetch_assoc()) {
                $add = new LogicalConnectivePhrase($row['idLogicalConnectivePhrase'], $row['logicalConnectivePhrase']);
                array_push($array, $add);
            }
            return $array;
        }
    }

    public static function INSERT_PHRASE($phrase) {
        $db = (new DbController())->doConnect();
        $sql = "INSERT INTO `Igitur`.`LogicalConnectivePhrase` ( `logicalConnectivePhrase`) VALUES ('$phrase');";
        $db->query($sql);
        return mysqli_insert_id($db);
    }

}
