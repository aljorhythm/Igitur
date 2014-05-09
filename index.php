<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
        <script src="./js/jquery/jquery.min.js"></script> 
        <script src="./js/jquery/jquery.form.js"></script> 
        <script src="./igitur.js" ></script> 
        <title>Index</title>
        <script>
            var UI = {};
            var logicalConnectives_phrases = [];
            function  getPhrases(categoryId, callback) {
                if (categoryId in logicalConnectives_phrases) {
                    callback(logicalConnectives_phrases[categoryId]);
                } else {
                    Igitur.LogicalConnective.GetPhrasesFromCategory(categoryId, function(phrases) {
                        callback(phrases);
                        logicalConnectives_phrases[categoryId] = phrases;
                    });
                }
            }
            UI.Forms = {
                Init: function() {
                    UI.Forms.FormAddProposition.Init();
                },
                FormAddProposition: {
                    PreviewPhrase: function(phraseObj) {
                        phraseObj = phraseObj.phrase.split(':');
                        if (phraseObj.length === 1) {
                            $("#formAddProposition #previewLC-prefix").html('');
                            $("#formAddProposition #previewLC-suffix").html(phraseObj[0] + "");
                        } else {
                            $("#formAddProposition #previewLC-prefix").html(phraseObj[0]) + "";
                            $("#formAddProposition #previewLC-suffix").html(phraseObj[1]) + "";
                        }
                    }, Init: function() {
                        $("#formAddProposition select#categoryId").on('change', function() {
                            var categoryId = this.value;
                            getPhrases(categoryId, function(phrases) {
                                $("#formAddProposition #previewLC-prefix").data('phrase', 0);
                                UI.Forms.FormAddProposition.PreviewPhrase(phrases[0]);
                            });
                        });
                        $("#formAddProposition .previewLC").on('click', function() {
                            var categoryId = $("#formAddProposition select#categoryId").val();
                            getPhrases(categoryId, function(phrases) {
                                var nextPhraseIndex = $("#formAddProposition #previewLC-prefix").data('phrase') + 1;
                                if (nextPhraseIndex >= phrases.length) {
                                    nextPhraseIndex = 0;
                                }
                                UI.Forms.FormAddProposition.PreviewPhrase(phrases[nextPhraseIndex]);
                                $("#formAddProposition #previewLC-prefix").data('phrase', nextPhraseIndex);
                            });
                        });
                        $("#formAddProposition .previewText").keyup(function() {
                            $("#formAddProposition #preview" + this.name.toUpperCase()).html(this.value);
                        });
                    }
                }
            };
            $(function() {
                UI.Forms.Init();
            });
        </script> 
        <link href="index.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>  
        <?php
        include_once './UAC.php';
        if (UAC::isLoggedIn()) {
            echo "Hi, " . UAC::getUsername();
            ?>
            <div id="context">
                <h3>Add Proposition</h3>
                <form id="formAddProposition" action="Proposition.php">
                    <input type="hidden" name="request" value="proposition_add"/>
                    <input type="text" name="p" class="previewText"/>
                    <select id="categoryId" name="logicalConnective_categoryId">
                        <?php
                        include_once './LogicalConnective.php';
                        $logicalConnectives = LogicalConnectiveCategory::GET_ALL_CATEGORIES();
                        foreach ($logicalConnectives as $connective) {
                            echo "<option value='$connective->id'>{$connective->category}</option>";
                        }
                        ?>
                    </select>
                    <input type="text" name="q" class="previewText"/><br>
                    <input type="hidden" name="contextId"/>
                    <br>
                    <div id="preview">
                        <span id="previewLC-prefix" class="previewLC"></span>
                        <span id="previewP"></span>
                        <span id="previewLC-suffix" class="previewLC"></span>
                        <span id="previewQ"></span> </div>            
                    <br>
                    <input type="submit" value="Add"/>
                </form>
            </div>
        <?php } else { ?>
            <form action="UAC.php">

            </form>    
        <?php } ?>
    </body>
</html>
