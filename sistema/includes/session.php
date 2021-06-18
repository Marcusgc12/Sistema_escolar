<?php
 
    $inativo = 400;
 
    if(isset($_SESSION['tempo']) ) {
    $vida_session = time() - $_SESSION['tempo'];
        if($vida_session > $inativo)
        {
            session_destroy();
            header("Location: ../"); 
        }
    }
 
    $_SESSION['tempo'] = time();
?>