    <?php
        //echo "Gallery Page";
        $dirPath = "../images/thumbs/";  //folder name

        $files = scandir($dirPath);
        // Count number of files and store them to variable..
        $num_files = count($files);

        echo "<p>Total images: <b>" . ($num_files - 3) . "</b></p>";

        //$imageExt = array('jpg','png');
        $imageExt = array("gif", "jpeg", "jpg", "png", "JPG", "PNG", "GIF"); //image file types allowed
        //$temp = explode(".", $_FILES["file"]["name"]);
        //$extension = end($temp);
        echo "<ul>";
        if(file_exists($dirPath)){
            if(is_dir($dirPath)){
                $dp = opendir($dirPath) or die("Cannot Open Directory");
                while($file=readdir($dp)){
                    if($file!='.' && $file!='..' && is_file("$dirPath/" . $file)){ //cuts out the thumbs folder as well.
                        //var_dump(is_file("$dirPath/" . $file)) . "<br/>";
                        $fileData = pathinfo($file);
                        //echo "<br/>$dirPath/$file";
                        if(in_array($fileData['extension'],$imageExt)){
                            echo "<li><img class='lazy' src='../assets/grey.gif' data-original='$dirPath/" . $file . "'/><p><a href='delete.php?id=$file'/>Delete</a> " . round(filesize("$dirPath/$file")/1024) . "KB</p></li>";
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

