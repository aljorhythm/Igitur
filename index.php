<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> 
        <script src="./igitur.js" ></script> 
        <title>Index</title>
        <script>
            $(function() {
                var str = "asd:d:1";
                var log = Igitur.Parser.RemoveMeta(str);
                console.log(log);
                var str = "asd:d:1 abd:s:2";
                var log = Igitur.Parser.RemoveAllMeta(str);
                console.log(log);
                console.log(Igitur.LogicalConnective.GetCategory(1));
            });
        </script>
    </head>
    <body> 


        <?php
        echo phpversion();
        echo filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        echo $_SERVER['REQUEST_METHOD'];

        ?> 
        ?>
    </body>
</html>
