<?php

    //how to view a file
    session_start();
    $file= $_GET['file'];
    $user = $_SESSION['user'];
    $full_path = sprintf("/srv/storefiles/%s/%s", $user, $file);
    
    if (!preg_match('/^[\w_\.\-]+$/', $file) ){
        echo "Invalid filename";
        exit;
    }
    
    if (!preg_match('/^[\w_\-]+$/', $user) ){
        echo "Invalid username";
        exit;
    }
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($full_path);

        header('Content-Description: File Transfer');
        header('Content-Type: '.$mime);
        header('Content-Disposition: inline; filename="'.basename($file).'"');
        readfile($full_path);
        exit;
?>