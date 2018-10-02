<?php
    ob_start();
    //start the session
    session_start();
?>
<html>
<head>
    <style type="text/css">
        html, body {
            font-family: sans-serif;
        }
        h3 {
            display: inline;
        }
        a {
            float: right;
            font-size: 0.8em;
        }
        span {
            color:red;
        }
        ul{
            padding:10px;
            overflow:hidden;
            width:900px;
            /*text-align:left; */
            margin-top:20px;

        }
        ul li{
            list-style:none;
            float:left;
            padding:10px;
        }
        ul li:hover{
            background:#FFE873;
        }
        ul li img{
            display:block;
            border:1px solid #333300;
            width: 170px;
            height:160px;
        }
    </style>
</head>
<body>
    <?php
        if (isset($_SESSION['name']) && isset($_SESSION['last_login'])){  //check if the session variable is there. true - session active, false - session destroyed
            echo "<h3>Welcome: " .  $_SESSION['name'] . " (Admin) | Last Login: " . $_SESSION['last_login'] . "</h3>";
            echo "<a href='logout.php'>Logout</a>";
    ?>
        <p>Upload Ayaan's Photo</p>
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <input type="file" name="file"/>
            <br/>
            <input type="submit" value="Upload"/>
            <!--<p>Upload progress bar here</p>-->
        </form>
    <?php
        if(isset($_GET['msg'])){
            echo "<span>" . $_GET['msg'] . "</span><br/>";
        }
    ?>
    <hr/>
    <?php
        require_once('gallery.php');
        }else{
            /*remove PHPSESSID cookie from browser, that was created by session_start() above.
            This is when after log out user hits back button to go inside the application again */
            setcookie( session_name(), '', time()-3600, '/' );
            $msg = "You need to login to view this page";
            header('location:index.php?msg=' . $msg);  //pass the message as query string and redirect
        }
    ?>
    <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
    <script src="../js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $("img.lazy").lazyload();
    </script>
</body>
</html>
<?php ob_end_flush(); ?>