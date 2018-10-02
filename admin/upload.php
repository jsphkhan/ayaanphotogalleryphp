<?php
    require_once("image_resize_class/resize-class.php");
    $resizeObj;  //global object

    //only Authenticated users can upload files - i.e Admin only
    //start the session
    session_start();
    if (isset($_SESSION['name']) && isset($_SESSION['last_login'])){  //check if the session variable is there. true - session active, false - session destroyed

        //imp code to check if uploaded file is an image.
        //an image must have width and height. We can check that using php's getimagesize()
        $tmpFile = $_FILES["file"]["tmp_name"];
        list($width, $height) = getimagesize($tmpFile);
        if ($width == null && $height == null) { //if not an image then do not upload
            sendMessage("You can upload only image files");
            return;
        }
        //Reject images that do not meet minimum dimensions
        if($width < 400 || $height < 300) {
            sendMessage("Rejected!!. Minimum width: 400px and Minimum height: 300px");
            return;
        }

        $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG", "GIF"); //image file types allowed
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        $max_file_size = ini_get('upload_max_filesize') * 1024 * 1024; // read from php.ini file - 4M (2M by default) converted to bytes
        //echo $max_file_size;

        if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < $max_file_size) && in_array($extension, $allowedExts))
        {
            if ($_FILES["file"]["error"] > 0)
            {
                //echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                sendMessage("Error in uploading file: " . $_FILES["file"]["error"]);
            }
            else
            {
                //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                //echo "Type: " . $_FILES["file"]["type"] . "<br>";
                //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

                if (file_exists("../images/" . $_FILES["file"]["name"]))
                {
                    //echo $_FILES["file"]["name"] . " already exists. ";
                    sendMessage("FAILED!! " . $_FILES["file"]["name"] . " already exists");
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"],"../images/" . $_FILES["file"]["name"]);

                    //Image Resizer Here
                    global $resizeObj;
                    $resizeObj = new Resize("../images/" . $_FILES["file"]["name"]);
                    //Resize image (options: exact, portrait, landscape, auto, crop)
                    generateImage(170, 120, 'exact', '../images/thumbs/' . $_FILES["file"]["name"]);//generate thumbnail
                    generateImage(750, 700, 'auto', '../images/' . $_FILES["file"]["name"]);//generate bigger image

                    sendMessage("SUCCESS!! File Uploaded And Resized: " . $_FILES["file"]["name"]);
                }
            }
        }
        else
        {
            //echo "Invalid file";
            sendMessage("Invalid File. File types allowed are: " . implode(' , ', $allowedExts));
        }
    } else {
        /*remove PHPSESSID cookie from browser, that was created by session_start() above.
        This is when after log out user hits back button to go inside the application again */
        setcookie( session_name(), '', time()-3600, '/' );
        $msg = "You need to login to view this page";
        header('location:index.php?msg=' . $msg);  //pass the message as query string and redirect
    }

    //sends status of file upload
    function sendMessage($msg) {
        header('location:home.php?msg=' . $msg);  //pass the message as query string
    }
    //function that generates thumbnail and big images
    function generateImage($width, $height, $method, $savedPath) {
        global $resizeObj;
        // Resize image (options: exact, portrait, landscape, auto, crop)
        $resizeObj -> resizeImage($width, $height, $method);
        //3) Save image
        $resizeObj -> saveImage($savedPath, 100);
                            //END of Image Resizer
    }
?>
