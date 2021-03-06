<?php
include_once 'libs/UAC.php';
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

        <?php include 'common/nav.php'; ?> 
        <div id='main-container'>  
            <?php $id = URI::QUERY_ANY('id', ''); ?>
            <div id="ui-main-data" <?php echo UAC::GetUserId() === $id ? "data-requireRefresh='1'" : ""; ?>>             </div>
            <link href='context.css' rel='stylesheet' type='text/css'>  
            <h2><?php
                if ($id === UAC::GetUserId()) {
                    echo 'Your';
                } else {
                    include 'libs/Users.php';
                    echo "<a href='profile.php?id=$id'>" . Users::GetUsername($id) . "'s</a>";
                }
                ?> Contexts</h2>
            <div id='contexts'> <?php
                include_once 'libs/Context.php';
                $contexts = Context::GetUserContexts($id === '' ? UAC::GetUserId() : $id );
                foreach ($contexts as $context) {
                    ?>  
                    <div class="context-indiv border-box hoverable">
                        <h4><a href="context_view.php?id=<?php echo $context['idContext']; ?>"><?php echo $context['contextName']; ?></a></h4>
                        <?php echo $context['contextDescription'] ?>
                    </div>
                    <?php
                }
                ?>
            </div>     

        </div> 
    </body>
</html>