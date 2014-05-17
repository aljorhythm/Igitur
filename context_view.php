<?php
include 'libs/UAC.php';
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'libs/Context.php';
$editId = URI::QUERY_ANY('id', '');
if ($editId !== '') {
    $context = Context::GetContext($editId);
    if ($context !== null) {
        $editable = UAC::GetUserId() === $context['ownerId'];
    }
}
?> 
<!DOCTYPE html>
<html>
    <head>
        <?php include 'common/head.php'; ?>
        <?php include 'common/nav-head.php'; ?>           

    </head>
    <body>
        <?php include 'common/nav.php'; ?>
        <div id='main-container'> 
            <?php if ($context !== null) { ?>
                <?php if ($editable) { ?> 
                    <script>
                        var contextId = <?php echo $context['idContext'] ?>;
                        var UI = {
                            Description: {
                                Edit: function() {
                                    function realEdit() {
                                        var textAreaDescription = $("#description > textarea");
                                        textAreaDescription.removeAttr("readonly").next().addClass('editing').html('Save');
                                        UI.Description.Edit = function() {
                                            var textAreaDescription = $("#description > textarea");
                                            textAreaDescription.attr("readonly", '').next().removeClass('editing').html('Edit');
                                            Igitur.Context.SetDescription(contextId, textAreaDescription.val());
                                            UI.Description.Edit = realEdit;
                                        };
                                    }
                                    realEdit();
                                }

                            }
                        };
                    </script>
                    <style> 
                        #description > textArea:hover ~ span{ 
                            visibility: visible;
                            opacity: 1;
                            -webkit-transition: visibility 1s,opacity 1s;  
                            transition: visibility 1s,opacity 1s; 
                        } 
                        #description > textArea ~ span{ 
                            display:block; 
                            float:right;
                            visibility:hidden; 
                            color: #FE7276;
                            opacity: 0;
                            -webkit-transition: visibility 1.1s, opacity 1s;  
                            transition: visibility 1s, opacity 1s; 
                        }
                        #description > textArea  + span.editing{ 
                            visibility: visible;
                            opacity: 1; 
                            -webkit-transition: visibility 1s,opacity 1s;  
                            transition: visibility 1s,opacity 1s;  
                        }
                        #description > textArea  + span:hover{   
                            opacity:1;
                            visibility: visible;
                            color: #FE7276; 
                            cursor:pointer;
                            -webkit-transition: visibility 1.2s,opacity 1s;  
                            transition: visibility 1s,opacity 1s; 
                        }
                        #description > textarea:not([readonly]){ 
                            outline: none !important; 
                            box-shadow: 0 0 10px #719ECE;
                        }
                    </style>
                <?php } ?>
                <style>
                    #description{
                        width:700px; 
                    } 
                    #description > textarea{
                        width:100%;
                        border:0;
                        border-bottom: 1px solid #dedede ;
                    }
                    #description > textarea[readonly]{
                        background:none;
                    }
                    #description > textarea:focus{
                        outline:none;
                    }
                </style> 
            <?php } ?>
            <?php
            if ($context === null) {
                echo "Context not found";
            } else {

                include 'libs/Users.php';
                $owner = Users::GetUsername($context['ownerId']);
                echo "<a href='profile.php?id={$context['ownerId']}'>$owner</a> > <a class='alt' href='context.php?id={$context['ownerId']}'>contexts</a>";
                echo "<h3>{$context['contextName']}</h3>";
                ?>
                <div id="description">
                    <?php echo "<span class='h4'>Description</span>"; ?>
                    <textarea rows="5" maxlength="400" readonly><?php echo $context['contextDescription']; ?></textarea>  
                    <?php if ($editable) { ?>        <span onclick="UI.Description.Edit()">Edit</span> <?php } ?>
                </div>    
                <div id="definitions">
                    <h4>Definitions</h4>
                    <form class="search">
                        <input type="text" placeholder="Search definitions in context..." required>
                        <input type="button" value="Search">
                    </form>
                </div>
            <?php } ?>
        </div>
    </body>
</html>