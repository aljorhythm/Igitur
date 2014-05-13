<?php header('Content-type: text/html; charset=utf-8'); ?>
<script src="js/jquery/jquery.min.js"></script> 
<script src="./js/jquery/jquery.form.js"></script> 
<script src="./igitur.js" ></script>  
<link href='./css/reset.css' rel='stylesheet' type='text/css'>      
<link href='./css/igitur.css' rel='stylesheet' type='text/css'>            

<!-- jQuery ScrollTo Plugin -->
<script src="//balupton.github.io/jquery-scrollto/lib/jquery-scrollto.js"></script>

<!-- History.js -->
<script src="//browserstate.github.io/history.js/scripts/bundled/html4+html5/jquery.history.js"></script>

<!-- Ajaxify -->
<script src="//rawgithub.com/browserstate/ajaxify/master/ajaxify-html5.js"></script>

<script>
    $(document).ready(function() {
        History.Adapter.bind(window, 'statechange', handleStateChange);
    });

    function handleStateChange() {

    }
</script>