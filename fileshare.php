<!DOCTYPE HTML>
    <html>
        <head>
            <title> Share a File! </title>
            <link rel="stylesheet" type="text/css" href="fileshare.css">
            
        </head>
        <body>
            <h1>Welcome to Your Filesharing Page!</h1>
            <?php
                session_start();
                if (!isset($_SESSION['successful_login']) && empty($_SESSION['successful_login'])) {
                    header("Location: username.php");
                    exit;
                }
                
                $user=$_SESSION['user'];
            ?>
            
            <h2>Hello <?php echo $user; ?></h2>
            <form action="logout.php" method="POST">
                <input type="submit" value="Logout" id="logout"/>
            </form>
            <fieldset>
                
                <div id = "fileupload">
                <form enctype="multipart/form-data" action="fileshare.php" method="POST">
                    <p>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                        <label for="fileupload_input">Upload File</label>
                        <input name="uploadedfile" type="file" id="fileupload_input"/>
                    </p>
                    <p>
                        <input type="submit" name="upload" value="Upload File" id="uploadfilebutton"/>
                    </p>
                </form>
            </div>
            </fieldset>
            

            <div id = "filesuploaded">
                <fieldset>
                <p>Files you have uploaded:</p>
                    <?php
                        $full_path = sprintf("/srv/storefiles/%s", $user);
                        if ($handle = opendir($full_path)) {
                            while (false !== ($entry = readdir($handle))) {
                                if ($entry != "." && $entry != "..") {
                                    echo "$entry<br>";
                                    echo "<a href=\"fileviewer.php?file=$entry\">View</a><br>";
                                    echo "<a href=\"filedownloader.php?file=$entry\">Download</a><br>";
                                    echo "<a href=\"deletefile.php?file=$entry\">Delete</a><br>";
                                }
                            }
                            closedir($handle);
                        }
                     ?>
                     <?php
                        
                        //Double check that file name is valid
                        if (isset($_FILES["uploadedfile"])) {
                            $filename = basename($_FILES['uploadedfile']['name']);
                            if (!preg_match('/^[\w_\.\-]+$/', $filename)) {
                                echo "Invalid filename";
                                exit;
                            }
                            
                            
                            //Make sure username is valid
                            if (isset($_POST['user'])) {
                                $user = $_SESSION['user'];
                                if (!preg_match('/^[\w_\-]+$/', $user)) {
                                    echo "Invalid username";
                                    exit;
                                }
                            }
                       
                            $full_path = sprintf("/srv/storefiles/%s/%s", $user, $filename);
                        
                        
                            if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path)) {
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mime = $finfo-->file($full_path);
                       
                                header("Content-Type: ".$mime);
                                //echo $filename;
                                echo $filename."<br>";
                                echo "<a href=\"fileviewer.php?file=$filename\">View</a><br>";
                                echo "<a href=\"filedownloader.php?file=$filename\">Download</a><br>";
                                echo "<a href=\"deletefile.php?file=$filename\">Delete</a><br>";
                                exit;
                        }
                        
                        else {
                            echo "File failed to upload";
                            exit;
                        }   
                    } 
                ?>
                </fieldset>
            </div>
        </body> 
    </html>