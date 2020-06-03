<?php
    
    ob_start();
    session_start();

    // if the user is already logged in and enter that page
    if(isset($_SESSION['user']))
    {
        header("location: index.php");
    }
    
    $title = 'Login/SignUp';
    include 'init.php';


    if($_SERVER['REQUEST_METHOD'] == 'POST' )
    {
        // when we log in then submit
        if(count($_POST) == 2)
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $row = $db->getRow("select * from users where userName = ? and password = ?", array($username, sha1($password)));

            if($row !== false)
            {
                $_SESSION['user']   = $username;
                $_SESSION['userId'] = $row['userId'];
                header("location: index.php");
            }
            else
            {
                $messagelog = "<div class='alert alert-danger'>Login Failed</div>";
            }
        }
        
        // when we sign up then submit
        else
        {
            $username        = $_POST['username'];
            $password        = $_POST['password'];
            $password2       = $_POST['password2'];
            $email           = $_POST['email'];
            

            // We Should Perform Server Validation on the inputs {see video #94, #95}
            
            $row = $db->getRow("select * from users where userName = ?", array($username));
            $messageSign = array();

            if(!empty($row))
            {
                $messageSign[] = "<div class='alert alert-danger'>User Name is used</div>";
            }
            if($password != $password2)
            {
                $messageSign[] = "<div class='alert alert-danger'>Password isn't matched</div>";
            }

            if(empty($messageSign))
            {
                $db->insertRow("insert into users(userName, password, email, fullName, regStatus, regDate) values(?, ?, ?, ?, 0, now())", array($username, sha1($password), $email, $username));
                echo "<div class='alert alert-success center-block' style='width: 420px; margin-top: 50px'>You SignedUp Successfully</div>";

                header("refresh:2; url=index.php");
            }
        }
    }

?>

<!--Start The Page-->

<div class="container logsign">
    <h1 class="text-center"><span class="login active">Login</span> / <span class="signup">SignUp</span></h1>
<!--    Start Login Form-->
    <form class="login" method="post">    
        <?php
        if(isset($messagelog))
        {
            echo $messagelog;
        }
        ?>
        
        <div class="form-group">
            <input type="text" class='form-control' name="username" placeholder="Type Your Username" autocomplete="off" required>
        </div>
        
        <div class="form-group">
            <input type="password" class='form-control' name="password" placeholder="Type Your Password" autocomplete="new-password" required>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Log In" class="btn btn-primary btn-block">
        </div>
    </form>
    
<!--    Start Signup Form-->
    <form class="signup" method="post">
        <?php
        if(!empty($messageSign))
        {
            foreach($messageSign as $mess)
            {
                echo $mess;
            }
        }
        ?>
        <div class="form-group">
            <input type="text" class='form-control' name="username" placeholder="Type Your Username" autocomplete="off" required>
        </div>
        
        <div class="form-group">
            <input type="password" class='form-control' name="password" placeholder="Type Your Password" autocomplete="new-password" required>
        </div>
        
        <div class="form-group">
            <input type="password" class='form-control' name="password2" placeholder="Repeat Your Password" autocomplete="new-password" required>
        </div>
        
        <div class="form-group">
            <input type="email" class='form-control' name="email" placeholder="Type Your Email" required>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Sign Up" class="btn btn-success btn-block">
        </div>
    </form>
</div>

<!--End The Page-->

<?php

    include "$tpl/footer.php";
    ob_end_flush();
?>