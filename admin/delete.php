<?php
    //deletes a file from directory
    //only authenticated users can delete - i.e Admin
    //only Authenticated users can upload files - i.e Admin only
    //start the session
    session_start();
    $dirPath = "../images/";  //folder name
    if (isset($_SESSION['name']) && isset($_SESSION['last_login'])){
        if(isset($_GET['id'])) {
            if (is_file($dirPath . $_GET['id'])) //checks if it is a file and not dir - ./ and ../
            {
                unlink($dirPath . $_GET['id']); //deletes the file
                unlink($dirPath . "thumbs/" . $_GET['id']);//delete the thumbnail as well

                header('location:home.php');  //redirect
            }
        } else {
            header('location:home.php');
        }
    } else{
        /*remove PHPSESSID cookie from browser, that was created by session_start() above.
        This is when after log out user hits back button to go inside the application again */
        setcookie(session_name(), '', time()-3600, '/' );
        $msg = "You need to login to view this page";
        header('location:index.php?msg=' . $msg);  //pass the message as query string and redirect
    }
?>


