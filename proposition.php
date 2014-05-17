<?php
include_once 'UAC.php';
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once 'common/head.php'; ?>
        <?php include_once 'common/nav-head.php'; ?>    
    </head>
    <body> 
        <?php include_once 'common/nav.php'; ?>
        <div id='main-container'>  
            <h3>Proposition</h3>
            <?php include_once 'libs/Proposition.php';
            $propositionId = URI::QUERY_GET('id');
            $proposition = Proposition::GET_PROPOSITION($propositionId);
            echo json_encode($proposition);
            ?>
        </div>   
    </body>
</html>