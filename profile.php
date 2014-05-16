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

    </head>
    <body>
        <?php include_once 'common/nav.php'; ?>
        <div id='main-container'>  
            <?php
            include_once 'libs/Users.php';
            $id = URI::QUERY_ANY('id');
            $user = Users::GetUser($id);
            echo json_encode($user);
            ?>
            <h3 style="margin-bottom:20px;"><?php echo $user['name']; ?></h3>
            <a class="submit" href="context.php?id=<?php echo $id ?>">Contexts</a>
            <h5>Alias</h5>
            <?php echo $user['username']; ?>
            <h5>Email</h5>
            <h5>www</h5>

        </div>
    </body>
</html>