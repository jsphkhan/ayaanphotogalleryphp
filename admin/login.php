<?php
    if(!empty($_POST['username']) && !empty($_POST['pwd'])) {
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];//"ayan@786";

    //db details
    $dbhost = 'ayaangallerydb.db.10960547.hostedresource.com';  // localhost - db host machine 
    $dbusername = 'ayaangallerydb';  // root 
    $dbpassword = 'ayaN@786'; //
    $dbname = 'ayaangallerydb';  //ayaan_db - database name 
    $con = @mysqli_connect($dbhost,$dbusername,$dbpassword,$dbname) or die('could not connect to db');

    $username = mysqli_real_escape_string($con,$username);
    $pwd = mysqli_real_escape_string($con,$pwd);

    //use prepared statements instead to query
    $query = "SELECT * FROM admin WHERE username='$username'";
    $result_set = @mysqli_query($con,$query) or die("Query Problem");


    if(mysqli_num_rows($result_set) == 1) {
        while($row = @mysqli_fetch_array($result_set))
        {
            $hash = hash('sha256', $pwd);   //hashing the password - 64 char random string
            //hashing again with the salt from db
            $hash = hash('sha256', $row['salt'] . $hash);

            if($hash == $row['password']) { //if password matches. Full Authentication
                //start the session
                session_start();
                //store in session variable
                $_SESSION['name'] = $row['name'];
                //last login in DB is stored in UTC for my local machine. Convert to IST timezone  IST = UTC + 5:30
                //last login in DB is stored in US time in pompomlabs.com - Go Daddy. Convert to IST time.  IST = US + 12:30
                $t = (((12*60) + 30) * 60) + strtotime($row['last']);
                $_SESSION['last_login'] = date('h:i:s a, d F Y',$t); //get the last login data from DB and format it eg. 02 July 2013
                //echo $_SESSION['last_login'] . "<br/>";

                //update last login field with new date/time
                //UTC time - localhost
                //US time - GoDaddy
                $now = date('Y-m-d h:i:s',mktime());  //current datetime - mysql format
                //echo $now;
                $query = "UPDATE admin SET last = '$now' WHERE 1"; //CURDATE()
                @mysqli_query($con,$query) or die("Query Problem In Updating Last Login");
                @mysqli_close($con);


                //redirect to home page
                header('location:home.php');
            } else {
                logout("Login Failed. Try Again");
            }
        }
    } else {
        logout("Login Failed. Try Again");
    }
    } else {
        logout("Empty fields can be dangerous!!");
    }

    function logout($msg) {
        header('location:index.php?msg=' . $msg);  //pass the message as query string
    }
?>
