<?php include_once 'UAC.php' ?>
<div id="side-nav">
    <div class='fullWidthMiddle'><a class='igitur-logo'  onclick='location.reload()' href="">Igitur</a></div>
    <?php
    $loggedIn = UAC::IsLoggedIn();
    if ($loggedIn) {
        echo "<div class='fullWidthMiddle'>" . UAC::getUsername() . "</div>";
        ?>
        <div class="fullWidthMiddle"><a   href="" title="logout" onclick="Igitur.UAC.Logout();
                location.reload();">logout</a></div>
        <?php } ?>

    <?php if (!$loggedIn) { ?>
        <script src='js/modalLogin/modalLogin.js'></script>
        <div class="fullWidthMiddle"> <a href="#"   title="login" onclick="ModalLogin.Display()">Login</a></div> 
    <?php } ?>
    <div id='side-nav-nav' style='width:100%;'>
        <?php if ($loggedIn) { ?>
            <ul> 
                <li><a href="profile.php">You</a>
                    <ul>
                        <li><a href="contextUI.php">Context</a></li> 
                        <li><a href="definitionsUI.php">Definitions</a></li>  
                        <li><a href="propositionsUI.php">Propositions</a></li> 
                        <li><a href="settings.php">Settings</a></li>
                    </ul>
                </li>
            </ul>
        <?php } ?>
        <ul> 
            <li><a href="index.php">Community</a> 
                <ul>
                    <li><a href="fieldsUI.php">Fields</a></li>
                    <li><a href="propositionsAll.php">Propositions</a></li>
                    <li><a href="people.php">People</a></li>
                </ul>
            </li>
        </ul>
    </div> 
</div>