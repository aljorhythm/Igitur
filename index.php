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
        <script src="igitur.js" /> 

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <title>Index</title>
        <script>
            var getAllSymbolsAutoComplete = function() {
                $.each(Igitur.LogicalConnective.GetAllSymbols(), function(key, val) {
                    var symbolsAutoComplete = new Array();
                    symbolsAutoComplete.push({label: val.symbol, value: val.id});
                    getAllSymbolsAutoComplete = symbolsAutoComplete;
                    return symbolsAutoComplete;
                });
            };
            $(function() {
                $("#symbolsAC").autocomplete({
                    source: getAllSymbolsAutoComplete()
                });
                $("#symbolsAC").autocomplete("enable");
            });
        </script>
    </head>
    <body>
        <?php
        // put your code here
        include('LogicalConnective.php');
        $array = LogicalConnectiveSymbol::GET_SYMBOLS();
        foreach ($array as $value) {
            echo $value->symbol . "&nbsp";
        }
        ?>
        <div class="ui-widget">
            <label for="symbolsAC">Symbols: </label>
            <input id="symbolsAC" />
        </div>
    </body>
</html>
