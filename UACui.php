<!DOCTYPE html>
<html>
    <head> 
        <?php include_once 'common/head.php'; ?>
        <?php include_once 'common/nav-head.php'; ?> 
    </head>
    <body> 
        <?php include_once 'common/nav.php'; ?>
        <div id='main-container'>
            <script>
                $(function() {
                    $("#createUsername").keyup(function() {
                        Igitur.Util.GET_AJAX_JSON('UAC.php?class=uac&request=checkUsername&username=' + this.value, function(data) {
                            if (data) {
                                $("#checkUsernameResult").html("Username exists");
                            } else {
                                $("#checkUsernameResult").html("Username not used");
                            }
                        });
                    });
                });
            </script>
            <?php
            include_once 'libs/UAC.php';
            echo "Hi ", UAC::getUsername();
            ?>
            <form style="border:1px black solid" target="_blank" action="UAC.php" method="POST">
                <h3>Create</h3>
                <input type="hidden" name="request" value="create"/>
                <input type="hidden" name="class" value="uac"/> 
                Username:   <input type="text" id="createUsername" name="username"/><span id="checkUsernameResult"></span><br>
                Password   <input type="password" name ="password"/><br>
                <input type="submit" value="Create User"/>
            </form>
            <form style="border:1px black solid" target="_blank" action="UAC.php" method="POST">
                <h3>Login</h3>
                <input type="hidden" name="request" value="login"/>
                <input type="hidden" name="class" value="uac"/> 
                Username:   <input type="text" name="username"/><br>
                Password   <input type="password" name ="password"/><br>
                <input type="submit" value="Login"/>
            </form> 
            <form style="border:1px black solid" target="_blank" action="UAC.php" method="POST">
                <h3>Logout</h3>
                <input type="hidden" name="request" value="logout"/> 
                <input type="hidden" name="class" value="uac"/> 
                <input type="submit" value="Logout"/>
            </form>
        </div>
    </body>
</html>