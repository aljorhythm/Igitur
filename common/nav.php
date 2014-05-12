<?php include_once 'UAC.php' ?>
<div id="side-nav">
    <div id='igitur-logo' style='margin-bottom: 10px;' class='fullWidthMiddle'>Igitur</div>
    <?php
    if (UAC::isLoggedIn()) {
        echo "<div class='fullWidthMiddle'>" . UAC::getUsername() . "</div>";
        ?>
        <div class="fullWidthMiddle"><a   href="" title="logout" onclick="Igitur.UAC.Logout();
                location.reload();">logout</a></div>

        <div id='side-nav-nav' style='width:100%;'>
            <ul> 
                <li>You
                    <ul><li><a href="contextUI.php">Context</a></li></ul>
                    <ul><li><a href="settings.php">Settings</a></li></ul>
                    <ul><li><a href="propositionsUI.php">Propositions</a></li></ul>
                </li>
            </ul>
        </div>
    <?php } else {
        ?>
        <script src='js/modalLogin/modalLogin.js'></script>
        <div class="fullWidthMiddle"> <a href="#"   title="login" onclick="ModalLogin.Display()">Login</a></div>

    <?php } ?>
</div>