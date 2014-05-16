<?php include_once 'UAC.php' ?>

<div id="side-nav">  
    <div class='fullWidthMiddle'><a class='igitur-logo' onclick='location.reload()'>Igitur</a></div>
    <div id="opatable"> 
        <div id="ui-data" data-loggedin="<?php echo (int) UAC::IsLoggedIn(); ?>"></div>
        <?php
        $loggedIn = UAC::IsLoggedIn();
        if ($loggedIn) {
            echo "<div class='fullWidthMiddle'>" . UAC::getUsername() . "</div>";
            ?>
            <script>
                function logout() {
                    Igitur.UAC.Logout();
                    History.replaceState(null, "State", location.href);
                }
            </script>
            <div class="fullWidthMiddle">
                <span class="a" onclick="logout();">logout</span>
            </div>
        <?php } else { ?>
            <script src='js/modalLogin/modalLogin.js'></script>
            <script>
                    ModalLogin.Success = function() {
                        ModalLogin.Destroy();
                        History.replaceState(null, "State", location.href);
                    };
                    function login() {
                        console.log('here');
                        ModalLogin.Display();
                    }
            </script>
            <div class="fullWidthMiddle"> <span class="a" href="" title="login" onclick="login();">Login</span></div> 
        <?php } ?>
        <div id='side-nav-nav' style='width:100%;'>

            <ul> 
                <?php if ($loggedIn) { ?>
                    <li><a href="profile.php">You</a>
                        <ul>
                            <li><a href="contextUI.php">Context</a></li> 
                            <li><a href="definitionsUI.php">Definitions</a></li>  
                            <li><a href="propositionsUI.php">Propositions</a></li> 
                            <li><a href="settings.php">Settings</a></li>
                        </ul>
                    </li>

                <?php } ?>

                <li><a href="index.php">Community</a> 
                    <ul>
                        <li><a href="fieldsUI.php">Fields</a></li>
                        <li><a href="propositionsAll.php">Propositions</a></li>
                        <li><a href="people.php">People</a></li>
                    </ul>
                </li>
                <li><a href="Development">Development
                        <ul><li><a href="dev-ajax.php">ajax</a></li></ul>
                        <ul><li><a href="unset.php">session unset</a></li></ul>
                </li>
            </ul> 
        </div> </div>
</div>