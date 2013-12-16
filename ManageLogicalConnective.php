<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
include('LogicalConnective.php');
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
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>  
        <script src="igitur.js" ></script> 
        <title>Manage Logical Connectives</title>
        <style>
            #categoryPhrasesCB{ 
                width:20em;
            }
            #categorySymbolsCB{ 
                width:20em;
                height:30em;
            } 
            #restSymbolsCB{ 
                width:20em; 
                height:30em;
            } 
            #contentTable td{
                width:500px;
                vertical-align: top;
            } 
        </style>
        <style>
            .defaultTable {
                font-family: verdana,arial,sans-serif;
                font-size:11px;
                color:#333333;
                border-width: 1px;
                border-color: #666666;
                border-collapse: collapse;
            }
            .defaultTable th {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #dedede;
            }
            .defaultTable td {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #ffffff;
            }
        </style> 
        <script>
            $(function() {
                $('#addPhraseInput').keypress(function(event) {

                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if (keycode === '13' || keycode === 13) {
                        addPhrase();
                    }

                });
                $('#searchPhrasesInput').keypress(function(event) {

                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if (keycode === '13' || keycode === 13) {
                        searchPhrases();
                    }

                });
                $("#symbolsCB").change(function() {
                    refresh();
                });
                $("#categoriesCB").change(function() {
                    categorySelected();
                });
                categorySelected();
                refresh();
            });
            var UI = {};
            UI.concatSelectors = function(selector, addOn) {
                if (arguments.length === 1 || typeof addOn === "undefined") {
                    return selector;
                } else {
                    return  selector.concat(" ".concat(addOn));
                }
            };
            UI.categoriesCB = function(selector) {
                return  $(UI.concatSelectors("#categoriesCB", selector));
            };
            UI.categoryPhrasesCB = function(selector) {
                return  $(UI.concatSelectors("#categoryPhrasesCB", selector));
            };
            UI.categorySymbolsCB = function(selector) {
                return  $(UI.concatSelectors("#categorySymbolsCB", selector));
            };
            UI.restSymbolsCB = function(selector) {
                return  $(UI.concatSelectors("#restSymbolsCB", selector));
            };
            function refresh() {
                findPhrasesAndShow();
                searchPhrases();
                symbolsRefresh();
            }
            function categorySelected() {
                UI.category = {id: UI.categoriesCB("option:selected").val(), category: UI.categoriesCB("option:selected").text()};
                refresh();
            }
            function addPhraseToCategory(element) {
                var phraseId = $(element).attr("data-phraseId");
                var phrase = $(element).html();
                var categoryId = UI.categoriesCB("option:selected").val();
                var category = UI.categoriesCB("option:selected").text();
                var r = true;//= confirm("Add '" + phrase + "' to category " + category);
                if (r === true)
                {
                    Igitur.LogicalConnective.AddPhraseToCategory(categoryId, phraseId);
                    refresh();
                }
            }
            function removePhraseFromCategory() {
                var phraseId = UI.categoryPhrasesCB("option:selected").attr("data-phraseId");
                Igitur.LogicalConnective.RemovePhraseFromCategory(UI.category.id, phraseId);
                refresh();
            }

            function addSymbolToCategory() {
                var symbolId = UI.restSymbolsCB("option:selected").attr("data-symbolId");
                var symbol = UI.restSymbolsCB("option:selected").val();
                var categoryId = UI.categoriesCB("option:selected").val();
                var category = UI.categoriesCB("option:selected").text();
                var r = true;//= confirm("Add '" + symbol + "' to category " + category);
                if (r === true)
                {
                    Igitur.LogicalConnective.AddSymbolToCategory(categoryId, symbolId);
                    refresh();
                }
            }
            function removeSymbolFromCategory() {
                var symbol = UI.categorySymbolsCB("option:selected").attr("data-symbolId");
                Igitur.LogicalConnective.RemoveSymbolFromCategory(UI.category.id, symbol);
                refresh();
            }

            function findPhrasesAndShow() {
                UI.categoryPhrasesCB().empty();
                var phrases = Igitur.LogicalConnective.GetPhrasesFromCategory(UI.category.id);
                $.each(phrases, function(key, val) {
                    UI.categoryPhrasesCB().append("<option data-phraseId=" + val.id + ">" + val.phrase + "</option>");
                });
            }
            function showSearchPhrases(phrases) {
                $("#phrasesTB").empty();
                $.each(phrases, function(key, val) {
                    $("#phrasesTB").append("<tr><td data-phraseId=" + val.id + " onclick=\"addPhraseToCategory(this);\">" + val.phrase + "</td></tr>");
                });
            }
            function addPhrase() {
                Igitur.LogicalConnective.AddPhrase($("#addPhraseInput").val());
            }
            function addCategory() {
                Igitur.LogicalConnective.AddCategory($("#addCategoryInput").val());
            }
            function searchPhrases() {
                var phrases = Igitur.LogicalConnective.SearchPhrases($("#searchPhrasesInput").val(), UI.category.id);
                showSearchPhrases(phrases);
            }
            function symbolsRefresh() {
                findCategorySymbols();
                findRestOfSymbols();
            }
            function findCategorySymbols() {
                var symbols = Igitur.LogicalConnective.GetSymbolsFromCategory(UI.category.id);
                UI.categorySymbolsCB().empty();
                $.each(symbols, function(key, value) {
                    UI.categorySymbolsCB().append("<option data-symbolId=" + value.id + ">" + value.symbol + "</option>");
                });
            }
            function findRestOfSymbols() {
                var symbols = Igitur.LogicalConnective.GetAllSymbols(UI.category.id);
                UI.restSymbolsCB().empty();
                $.each(symbols, function(key, value) {
                    UI.restSymbolsCB().append("<option data-symbolId=" + value.id + ">" + value.symbol + "</option>");
                });
            }
        </script>
    </head>
    <body>
        <table id="contentTable">
            <tbody> 
                <tr>
                    <td>
                        <h1>Categories</h1>
                        <input id="addCategoryInput" size="20"></input>
                        <button id="addCategoryButton" onclick="addCategory();">Add Category to Database</button>
                        <br> <br> 
                        Category: <select id="categoriesCB">
                            <?php
                            $categories = LogicalConnectiveCategory::GET_ALL_CATEGORIES();
                            foreach ($categories as $value) {
                                echo "<option value=\"" . $value->id . "\">" . $value->category . "</option>";
                            }
                            ?>
                        </select> 
                    </td>
                    <td> 

                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <h2>Phrases</h2> 
                        <select id="categoryPhrasesCB" multiple="multiple"> 
                        </select><br><br> 
                        <button onclick="removePhraseFromCategory();">Remove</button>
                        <br>    <br>
                        <input id="addPhraseInput" type="text" size="25"/> <br>    <br>
                        <button onclick="addPhrase();">Add Phrase To Database</button><br><br>click on phrase to add to category<br>
                        <input id="searchPhrasesInput" type ="text" size="25"/>
                        <br>
                        <button onclick="searchPhrases();">Search</button>
                        <br>  <br>
                        <div style="height:400px;width:20em;overflow:auto;">
                            <table id="phrasesTB" class="defaultTable" style="width:200px;"> 
                            </table> 
                        </div>
                    </td>
                    <td>
                        <h2>Symbols</h2>
                        <table>
                            <tr>
                                <td>
                                    <select id="categorySymbolsCB" multiple="multiple"> 
                                    </select>
                                </td>
                                <td> 
                                    <button onclick="removeSymbolFromCategory();">Remove</button>
                                    <button onclick="addSymbolToCategory();">Add</button>
                                </td>
                                <td>
                                    <select id="restSymbolsCB" multiple="multiple"> 
                                    </select>
                                </td>

                            </tr>

                        </table> 
                    </td>
                </tr>

            </tbody>
        </table>
    </body>
</html> 
