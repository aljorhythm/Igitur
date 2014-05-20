<?php include_once 'libs/UAC.php' ?> 
<div id="side-nav">  
    <div class='fullWidthMiddle'><a class='igitur-logo' href="" onclick='location.reload()'>Igitur</a></div>
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
                    History.replaceState({date: Date.now(), uac: true}, "State", location.href);
                }
            </script>
            <div class="fullWidthMiddle">
                <span class="a" onclick="logout();">logout</span>
            </div>
        <?php } else { ?>
            <script >
                $.getScript('js/modalLogin/modalLogin.js', function() {
                    ModalLogin.Close = function() {
                        ModalLogin.Hide(400);
                    };
                    ModalLogin.Success = function() {
                        ModalLogin.Destroy(400, function() {
                            History.replaceState({date: Date.now(), uac: true}, "State", location.href);
                        });
                    }; 
                });

                function login() {
                    ModalLogin.Display(400);
                }
            </script>
            <script src='' onload='EditModalLogin();'></script> 
            <div class="fullWidthMiddle"> <span class="a" href="" title="login" onclick="login();">Login</span></div> 
        <?php } ?>
        <div id='side-nav-nav' style='width:100%;'> 
            <ul> 
                <?php
                if ($loggedIn) {
                    $id = UAC::GetUserId();
                    ?>
                    <li><a href="profile.php">You</a>
                        <ul>
                            <li><a href="context.php?id=<?php echo $id; ?>">Contexts</a></li> 
                            <li><a href="definitions.php?id=<?php echo $id; ?>">Definitions</a></li>  
                            <li><a href="propositions.php?id=<?php echo $id; ?>">Propositions</a></li> 
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
                <li><a href="Development">Development</a>
                    <ul> <li><a href="dev-ajax.php">ajax</a></li> 
                        <li><a href="unset.php">session unset</a></li> 
                    </ul>
                </li>
                <li><a href="Development">Admin</a>
                    <ul> 
                        <li><a href="UACui.php">uac</a></li>  
                    </ul>
                </li>
            </ul> 
        </div> 
    </div>
</div>