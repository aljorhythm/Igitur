<?php
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'libs/UAC.php';
include_once 'libs/Users.php';
$userId = URI::QUERY_ANY('id', '');
$editable = UAC::IsLoggedIn() && ($userId === '' || $userId === UAC::GetUserId());
if ($userId === '') {
    $userId = UAC::GetUserId();
}
?>
<!DOCTYPE html> 
<html>
    <head> 
        <?php include_once 'common/head.php'; ?> 
        <?php include_once 'common/nav-head.php'; ?>    
        <title>Propositions</title>

    </head>
    <body>    
        <?php include_once 'common/nav.php'; ?>
        <div id='main-container'>  
            <link href='./propositions.css' rel='stylesheet' type='text/css'>   
            <script src="js/jquery/jquery.form.min.js"></script> 
            <?php if ($editable) { ?> 
                <script>
                    UI = {
                        Propositions: {
                        },
                        Forms: {
                            FormAddProposition: {
                                PreviewPhrase: function(phraseObj) {
                                    phraseObj = phraseObj.phrase.split(':');
                                    if (phraseObj.length === 1) {
                                        UI.Forms.FormAddProposition.PreviewLCPrefix.html('');
                                        UI.Forms.FormAddProposition.PreviewLCSuffix.html(phraseObj[0] + "");
                                    } else {
                                        UI.Forms.FormAddProposition.PreviewLCPrefix.html(phraseObj[0]) + "";
                                        UI.Forms.FormAddProposition.PreviewLCSuffix.html(phraseObj[1]) + "";
                                    }
                                }, Init: function() {
                                    UI.Forms.FormAddProposition.PreviewLCPrefix = $("#formAddProposition #previewLC-prefix");
                                    UI.Forms.FormAddProposition.PreviewLCSuffix = $("#formAddProposition #previewLC-suffix");
                                    $("#formAddProposition select").on('change', function() {
                                        var categoryId = this.value;
                                        Igitur.LogicalConnective.Cache.Phrases.get(categoryId, function(phrases) {
                                            UI.Forms.FormAddProposition.PreviewLCPrefix.data('phrase', 0);
                                            UI.Forms.FormAddProposition.PreviewPhrase(phrases[0]);
                                        });
                                    }).trigger('change');
                                    $("#formAddProposition .previewLC").on('click', function() {
                                        var categoryId = $("#formAddProposition select#categoryId").val();
                                        Igitur.LogicalConnective.Cache.Phrases.get(categoryId, function(phrases) {
                                            var nextPhraseIndex = UI.Forms.FormAddProposition.PreviewLCPrefix.data('phrase') + 1;
                                            if (nextPhraseIndex >= phrases.length) {
                                                nextPhraseIndex = 0;
                                            }
                                            UI.Forms.FormAddProposition.PreviewPhrase(phrases[nextPhraseIndex]);
                                            UI.Forms.FormAddProposition.PreviewLCPrefix.data('phrase', nextPhraseIndex);
                                        });
                                    });
                                    $("#formAddProposition .previewText").keyup(function() {
                                        $("#formAddProposition #preview" + this.name.toUpperCase()).html(this.value);
                                    });
                                    $('#formAddProposition').ajaxForm({success: function() {
                                            $("#propositions").fadeOut({complete: function() {
                                                    $(this).load(location.href + ' #propositions').fadeIn();
                                                }});
                                        }});
                                }
                            }, Init: function() {
                                UI.Forms.FormAddProposition.Init();
                            }
                        }
                    };
                    $(function() {
                        UI.Forms.Init();
                    });
                </script> 
                <h4>Add Proposition</h4>
                <form id="formAddProposition" method="POST" action="Proposition.php">
                    <input type="hidden" name="class" value="proposition"/>
                    <input type="hidden" name="request" value="proposition_add"/>  
                    <input type="text" name="p" placeholder="  p" class="previewText"/>
                    <select id="categoryId" name="logicalConnective_categoryId">
                        <?php
                        include_once 'libs/LogicalConnective.php';
                        $logicalConnectives = LogicalConnectiveCategory::GET_ALL_CATEGORIES();
                        foreach ($logicalConnectives as $connective) {
                            echo "<option value='$connective->id'>{$connective->category}</option>";
                        }
                        ?>
                    </select>
                    <input type="text" name="q" placeholder="  q" class="previewText"/>
                    <input style='font-size:large' type="submit" value="Add"/> <br> 
                    <div id="preview">
                        <h5>Preview</h5>
                        <span id="previewLC-prefix" class="previewLC a"></span>
                        <span id="previewP">p</span>
                        <span id="previewLC-suffix" class="previewLC a"></span>
                        <span id="previewQ">q</span> </div>            
                    <br>
                </form> 
            <?php } ?>
            <?php
            if (!UAC::IsLoggedIn() && $userId === '') {
                echo "Login required";
            } else {
                ?>      
                <h4><?php echo $editable ? "Your " : "<a href='profile.php?id=$userId'>" . Users::GetUsername($userId) . "'s</a>"; ?> Propositions</h4>

                <div id="propositions">
                    <table>
                        <?php
                        include_once 'libs/Proposition.php';
                        include_once 'libs/LogicalConnective.php';
                        $props = Proposition::GET_PROPOSITIONS_USER($userId);
                        foreach ($props as $prop) {
                            $symbol = LogicalConnectiveCategory::GET_SYMBOLS($prop['LogicalConnectiveCategory_idLogicalConnectiveCategory'])[0]['symbol'];
                            echo "<tr><td><a href='proposition.php?id={$prop['idProposition']}'>{$prop['propositionP']} $symbol {$prop['propositionQ']}</a></td></tr>";
                        }
                        ?>
                    </table>
                </div>    
            <?php } ?>  
        </div> 


    </body>
</html> 