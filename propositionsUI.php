<?php
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'UAC.php';
include_once 'Users.php';
$userId = URI::QUERY_ANY('id', '');
$editable = UAC::IsLoggedIn() && ($userId === '' || $userId === UAC::GetUserId());
?>
<!DOCTYPE html> 
<html>
    <head> 
        <?php include_once 'common/head.php'; ?> 
        <?php include_once 'common/nav-head.php'; ?>   

        <link href='./propositions.css' rel='stylesheet' type='text/css'> 

        <link href='js/libs/tabify/tabify.css' rel='stylesheet' type='text/css'> 
        <script src="js/libs/tabify/tabify.js"></script> 
        <title>Index</title>
        <?php if ($editable) { ?>
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
                UI = {
                    Tabs: {
                        Init: function() {
                            Tabify($("#context"));
                        }
                    },
                    Forms: {
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
                    }
                };
                $(function() {
                    UI.Forms.Init();
                    UI.Tabs.Init();
                });
            </script>  
        <?php } ?>
    </head>
    <body>  
        <?php include_once 'common/nav.php'; ?>
        <div id='main-container'> 
            <?php if ($editable) { ?> 
                <h4>Add Proposition</h4>
                <form id="formAddProposition" action="Proposition.php">
                    <input type="hidden" name="request" value="proposition_add"/>
                    <input type="text" name="p" placeholder="p" class="previewText"/>
                    <select id="categoryId" name="logicalConnective_categoryId">
                        <?php
                        include_once './LogicalConnective.php';
                        $logicalConnectives = LogicalConnectiveCategory::GET_ALL_CATEGORIES();
                        foreach ($logicalConnectives as $connective) {
                            echo "<option value='$connective->id'>{$connective->category}</option>";
                        }
                        ?>
                    </select>
                    <input type="text" name="q" placeholder="q" class="previewText"/>
                    <input style='font-size:large' type="submit" value="Add"/> <br> 
                    <div id="preview">
                        <h5 style='margin-top:10px'>Preview</h5>
                        <span id="previewLC-prefix" class="previewLC a"></span>
                        <span id="previewP"></span>
                        <span id="previewLC-suffix" class="previewLC a"></span>
                        <span id="previewQ"></span> </div>            
                    <br>
                </form> 
            <?php } ?>
            <?php
            if (!UAC::IsLoggedIn() && $userId === '') {
                echo"no user found";
            } else {
                ?>      
                <h4><?php echo $editable ? "Your " : "<a href='profile.php?id=$userId'>" . Users::GetUsername($userId) . "'s</a>"; ?> Propositions</h4>
            <?php } ?>  
        </div> 
    </div>
</body>
</html> 