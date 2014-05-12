<?php
include 'UAC.php';
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include 'common/head.php'; ?>
        <?php include 'common/nav-head.php'; ?>
        <link href='context.css' rel='stylesheet' type='text/css'>            

    </head>
    <body>
        <?php include 'common/nav.php'; ?>
        <div id='main-container'>  
            <?php
            if (UAC::isLoggedIn()) {
                ?> 
                <h2>Your Contexts</h2>
                <div id='contexts'> <?php
                    include_once 'Context.php';
                    $contexts = Context::GetUserContexts(UAC::getUserId());
                    foreach ($contexts as $context) {
                        ?>  
                        <div class="context-indiv border-box">
                            <h4><a href="context_view.php?id=<?php echo $context['idContext']; ?>"><?php echo $context['contextName']; ?></a></h4>
                            <?php echo $context['contextDescription'] ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>     
                <div class="fullWidthMiddle"> You are not logged in</div>
                <?php ?>
            <?php } ?> 
        </div>
    </body>
</html>