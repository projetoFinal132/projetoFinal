<?php
    $status = session_status();
    if($status == PHP_SESSION_NONE){
        //There is no active session
        session_start();
    }
    $_SESSION['cliente'] = array();
    session_destroy();
    header("Location: ../login.html");
    die();
?>