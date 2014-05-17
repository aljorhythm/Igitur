<?php
include_once 'libs/UAC.php';
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
                <h3>People</h3>
                <form class="search">
                    <input type="text" placeholder="Search for people..." required>
                    <input type="button" value="Search">
                </form> 
            </div>  
    </body>
</html>