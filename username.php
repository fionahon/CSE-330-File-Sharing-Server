<!DOCTYPE HTML>
    <html>
        <head>
            <title> Login page </title>
        </head>
        <body>
            <h1> File Sharing Site </h1>
            <form method="POST">
                <label for= "username">Enter username</label>
                <input type="text" name="user" id="username"/>
                <input type="submit" value="Login">
                
            </form>
            <form action="addnewuser.php" method="POST">
                 <label for="newuser">New User</label>
                <input type="text" name="newuser" id="newusername"/>
                <input type="submit" value="Login new user">
            </form>
            
            <div>
                <?php
                    session_start();
                
                    if (isset($_POST['user']) && !empty($_POST['user'])) {
                        $user = $_POST['user'];
                       
                       //checking for username
                        if (!preg_match('/^[\w_\-]+$/', $user)) {
                            echo "Please enter the correct username";
                            exit;
                        }
                            
                        $_SESSION['user']= $user;
                        $correctuser = false;
                        
                        //using users.txt to log in with the 3 usernames
                        $h = fopen ("/home/users/users.txt", "r");
                        $line = 1;
                        $found = false;
                        
                        while (!feof($h)) {
                            $trim = trim(fgets($h));
                            
                            if ($trim == $user){    
                                $_SESSION['successful_login']= "yes";
                                $found = true;
                                break;
                            }
                            
                            else {
                                $line++;
                            }  
                        }
                        
                        fclose($h);
                        
                        if ($found) {
                            header("Location: fileshare.php");
                            exit;
                        }
                    }
                    
                    
                ?>
            </div>
        </body>
    </html>