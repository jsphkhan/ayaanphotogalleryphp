<?php
    //start the session
    session_start();
    if (isset($_SESSION['name']) && isset($_SESSION['last_login'])){   //logout users only if they are currently logged in

        //clear session from server's disk
        session_destroy();
        //clear session from globals
        $_SESSION = array();

        //remove PHPSESSID cookie from browser
        setcookie( session_name(), '', time()-3600, '/' );

        //redirect
        header('location:index.php');
    } else {
        /*remove PHPSESSID cookie from browser, that was created by session_start() above.
        This is when after log out user hits back button to go inside the application again */
        setcookie( session_name(), '', time()-3600, '/' );
        $msg = "You need to login to view this page";
        header('location:index.php?msg=' . $msg);  //pass the message as query string and redirect
    }
?>