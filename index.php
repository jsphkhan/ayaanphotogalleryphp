<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Ayaan Gallery - Copyright 2013</title>
    <link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" />
    <style type="text/css">
       body {
       	margin: 20px auto;
       	padding: 0;
       	width: 780px;
       	font: 70%/140% Arial, Helvetica, sans-serif;
       	background: #dcd6d1;
       }
       h1 {
       	font: normal 420%/110% Garamond, Georgia, serif;
       	letter-spacing: -1px;
       	text-transform: uppercase;
       	text-align: center;
       	margin: 0;
       }
       .credits {
       	font: 130%/110% Garamond, Georgia, serif;
       	text-align: center;
       	color: #999;
       	width: 300px;
       	margin: .5em auto 1.5em;
       	padding-top: 8px;
       	border-top: 1px solid #999;
       	letter-spacing: 2px;
       }
       .credits em {
       	color: #666;
       }
       .credits a {
       	color: #333;
       	text-decoration: none;
       	text-transform: uppercase;
       }
       .credits a:hover {
       	text-decoration: underline;
       }
       img {
       	border: none;
       }

       /* ---------- gallery styles start here ----------------------- */
       .gallery {
       	list-style: none;
       	margin: 0;
       	padding: 0;
       }
       .gallery li {
       	margin: 20px;
       	padding: 0;
       	float: left;
       	position: relative;
       	width: 212px;
       	height: 175px;
       }

       .gallery a {
       	text-decoration: none;
       	color: #666;
       }
       .gallery a:hover {
       	color: #000;
       	text-decoration: underline;
       }
       .gallery img {
       	padding: 20px 0 0 21px;
       }
       .gallery em {
       	width: 216px;
       	background: url(assets/gold-frame.png) no-repeat;
       	display: block;
       	position: absolute;
       	top: -2px;
       	left: -2px;
       	text-align: center;
       	font: 100%/100% Georgia, "Times New Roman", Times, serif;
       	padding-top: 168px;
       }
       #header {
            height: 50px;
            background: #000;
       }
    </style>
</head>
<body>
    <h1>AYAAN'S GALLERY</h1>
    <p class="credits"><a href="admin" target="_blank">Admin Login</a></p>
    <?php
        //echo "Gallery Page";
        $dirPath = "images/";  //folder name

        $files = scandir($dirPath);
        // Count number of files and store them to variable..
        $num_files = count($files);

        //echo "<p>Total images: <b>" . ($num_files - 3) . "</b></p>";

        //$imageExt = array('jpg','png');
        $imageExt = array("gif", "jpeg", "jpg", "png", "JPG", "PNG", "GIF"); //image file types allowed
        //$temp = explode(".", $_FILES["file"]["name"]);
        //$extension = end($temp);
        echo "<ul class='gallery'>";
        if(file_exists($dirPath)){
            if(is_dir($dirPath)){
                $dp = opendir($dirPath) or die("Cannot Open Directory");
                while($file=readdir($dp)){
                    if($file!='.' && $file!='..' && is_file("$dirPath/" . $file)){ //cuts out the thumbs folder as well.
                        //var_dump(is_file("$dirPath/" . $file)) . "<br/>";
                        $fileData = pathinfo($file);
                        //echo "<br/>$dirPath/$file";
                        if(in_array($fileData['extension'],$imageExt)){
                            echo "<li><a href='$dirPath" . $file . "' rel='lightbox-babu'><em></em><img class='lazy' src='assets/grey.gif' data-original='$dirPath" . "thumbs/" . $file . "'/></a></li>";
                        }
                    }
                }
                closedir($dp);
                //echo "<br/> Directory success";
            }else{
                echo "<br/>Not a Directory";
            }
        }else{
            echo "<br/>Directory does not exists";
        }
    ?>
</ul>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script src="js/jquery.lazyload.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/slimbox2.js"></script>
<script type="text/javascript">
    $("img.lazy").lazyload();
</script>
</body>
</html>

