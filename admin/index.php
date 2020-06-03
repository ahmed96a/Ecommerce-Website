<?php

    ob_start();
    session_start();
    
    /*
    in that page we show the login form then after the login we submit (post method)
    
    Case 1- we check from the db if the user is exist and admin, if the user is exist in db and admin, we create a session variable with the user name
            then redirect to the dashboard (admin control page)
    
    Case 2- if the admin enter the index.php again he hadn't to login again to go to the dashboard, when he enter thre index.php he automatically 
            redirected to dashboard.php that mean that only one admin is allowed to enter the dashboard to make other admin enter the dashboard
            the current active admin should logout from the dashboard
    */

// Case 2

    if(isset($_SESSION['Username']))
    {
        header("Location: dashboard.php");
    }
    
    // include the header.php
    $title = "LogIn"; // page title that will be printed in header.php
    include 'include/templates/header.php'; // here we used an init.php variable as example but we also could write the path

// Case 1

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $username = $_POST['username'];
        $pass = sha1($_POST['password']);
        
        // check if the user is exist and admin in the db
        require_once 'include/DBClass.php';
        
        $row = $db->getRow("select userId from users where userName = ? and password = ? and permission = 1 limit 1", array($username, $pass));
        
        $message = "<div class='alert alert-danger text-center'>Failed To Login {Not Admin}</div>";
        
        if($row !== false)
        {
            $message = "<div class='alert alert-success text-center'>Welcome Admin</div>";
            $_SESSION['Username'] = $username;
            $_SESSION['Id'] = $row[0];
            
            header("Location: dashboard.php");
        }
    }

?>

<!-- Start Page Content -->
    
    <div class="container">
        <form class="login" method="post">
            <h3 class="text-center">Admin Login</h3>
            <?php if(isset($message)) { echo $message; } ?> <!-- when login print message with failed or success -->
            <input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off">
            <input class="form-control" type="password" name="password" placeholder="Password">
            <input class="btn btn-primary btn-block" type="submit" value="Login">
        </form>
    </div>

<!-- End Page Content -->

<!-- Footer -->

<?php 
    include "include/templates/footer.php";
    ob_end_flush();
?> <!-- here we used an init.php variable as example but we also could write the path  -->