<?php
    ob_start();
    //start the session
    session_start();

    //check if already logged in
    if (isset($_SESSION['name']) && isset($_SESSION['last_login'])) {
        //redirect to home page
        header('location:home.php');
    } else {
        /*remove PHPSESSID cookie from browser, that was created by session_start() above.
        This is when after log out user hits back button to go inside the application again */
        setcookie( 'PHPSESSID', '', time()-3600, '/' );
    }
?>
<!doctype html>
<html>
    <body>
        <h3>Ayaan Gallery Admin Login</h3>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username"/>
            <br/>
            <input type="password" name="pwd" placeholder="Password"/>
            <br/>
            <input type="submit" value="Submit"/>
        </form>
        <p>
            <?php
                if(isset($_GET['msg'])){
                    echo $_GET['msg'] . "<br/>";
                }
            ?>
        </p>
    </body>
</html>
<?php ob_end_flush(); ?>