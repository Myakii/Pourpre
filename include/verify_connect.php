<?php

    if(isset($_SESSION['validtoken']) && $_SESSION['validtoken'] == false) {


        header('Location: login.php');
        session_destroy();
        exit();


    }
    
?>