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
            <script>
                function testAjax() {
                    Igitur.Util.GET_AJAX_JSON($("#url").val(), function(d) {
                        console.log(d);
                        $("#result").html(d);
                    });
                } 
            </script>
            <input id="url" size="200"type="text"/>
            <button onclick="testAjax();">GET</button>
            <div id="result"></div>
        </div>
    </body>
</html>