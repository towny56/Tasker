<?php

    session_start();

    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.html');
        exit();
    }else{
        header('Location: home.html');
    }

?>