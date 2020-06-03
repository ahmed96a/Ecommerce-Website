<?php
    
    // that page to logout and destory the session variable $_SESSION['Username'] so we can login again through index.php
    
    session_start();
    session_unset();
    session_destroy();

    header("Location: index.php");
    
?>