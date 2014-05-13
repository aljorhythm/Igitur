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
        <script>
            function testAjax() {
                Igitur.Util.GET_AJAX_JSON($("#url").val(), function(d) {
                    console.log(d);
                });
            }
            $(document).ready(function() {
                var logger = document.getElementById('result');
                console.log(logger);
                console.log = function(message) {
                    if (typeof message === 'object') {
                        logger.innerHTML += (JSON && JSON.stringify ? JSON.stringify(message) : message) + '<br />';
                    } else {
                        logger.innerHTML += message + '<br />';
                    }
                }
            });
        </script>
    </head>
    <body>
        <?php include_once 'common/nav.php'; ?>
        <div id='main-container'>  
            <input id="url" size="200"type="text"/>
            <button onclick="testAjax();">GET</button>
            <div id="result"></div>
        </div>
    </body>
</html>