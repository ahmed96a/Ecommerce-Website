<?php
    
    ob_start();
    session_start();
    
    
    if(!isset($_SESSION['Id'])) // If we go to that page(members.php) directly without login, we redirect to the index.php(login page)
    {
        header("location: index.php");
    }
    
    $title = "Members"; // page title
    include 'include/templates/header.php';
    include 'include/languages/english.php';
    

    echo "<body class='member'>";
    include 'include/templates/navbar.php';

    echo "\n<div class='container'>\n"; // echo the container of the members.php


//2- EDIT MEMBER DATA

    /*
    ** {Docs}
    ** when we go to the edit section with sending action = edit and the id of the member that we want to edit {members.php?action=edit&id=1}
    ** 1- get the member informations by his id :
    **    we go to that edit section through 
    **    ( members.php {Main section} or by current user Edit data option in the dropdown or by go directly to the edit section with correct id } ) so **   in that three cases the id sent will be correct and we will get the information successfully, but if we go to the edit section directly writing
    **    wrong id the value that will be returned of retriving information will be false and in that case we will be redirected to the Main Section
    **    of members.php {Note:- Main section in members.php is num 1- } ,, Note: we also can prevent direct access to edit section by replacing the
    **    <a> by form and use method post
    **    
    ** 2- when we go successfully to the edit section and after finish of editing the data we submit to update section
    **    {members.php?action=update} with sending all the informations to that section with post method
    */


    if(isset($_GET['action']) && $_GET['action'] === "edit") // we use isset because when we go to 1- members.php without action the $_Get['action'] will not be exist so there is no thing to compare to the value we write in the conditin, so that we should write isset() first.
        
    {
        
        // 1- get the member informations by his id
        require_once 'include/DBClass.php';
        $row = $db->getRow("select * from users where userId = ?", array($_GET['id']));
        
        if($row !== false) // even if we go directly to the Edit with any id(not exist) or string the value of $row in that case will be false
        {
?>          

            <!-- Use Bootstrap's predefined grid classes to align labels and groups of form controls in a horizontal layout by adding .form-horizontal to the form (which doesn't have to be a <form>). Doing so changes .form-groups to behave as grid rows, so no need for .row. -->

            <!-- we perform Client Validation here by using different attributes like required, pattern, min and max also by using of the good type -->

            <form class="form-horizontal" method="post" action="members.php?action=update">  
                <!--action attribute can be written like that { action="?action=update" , or like that, action="members.php?action=update" }-->

                <h2 class="text-center"><?php echo $lang['editmember'] ?></h2>

                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

                <div class="form-group"> <!-- .form-groups to behave as grid rows, so no need for .row. -->
                    <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['username'] ?></label> <!-- we could give the label the col class to specify it's width -->
                    <div class="col-sm-5">
                        <input type="text" name="username" value="<?php echo $row['userName'] ?>" autocomplete="off" class="form-control" required pattern="[A-Za-z0-9]{4+}"> <!-- here we allow in that input >= 4 characters at max that lay between A-Z , a-z, 0-9 -->
                    </div>
                    <!-- when we give the col class to the input it don't work because the width of the form-control override the width of .col
                         so we should put the input within div    -->
                </div>

                <div class="form-group"> 
                    <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['password'] ?></label>
                    <div class="col-sm-5">
                        <input type="password" name="password" autocomplete="new-password" class="form-control" placeholder="Leave blank for not changing the pass"> <!-- new-password is used with chorome to prevent him from keeping the pass in the input -->
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['email'] ?></label>
                    <div class="col-sm-5">
                        <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['fullname'] ?></label>
                    <div class="col-sm-5">
                        <input type="text" name="fullname" value="<?php echo $row['fullName'] ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['permission'] ?></label>
                    <div class="col-sm-5">
                        <input type="number" name="permission" value="<?php echo $row['permission'] ?>" class="form-control" min="0" max="1" maxlength="1" required>
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['truststats'] ?></label>
                    <div class="col-sm-5">
                        <input type="number" name="truststatus" value="<?php echo $row['trustStatus'] ?>" class="form-control" min="0" max="1" maxlength="1" required>
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['regstats'] ?></label>
                    <div class="col-sm-5">
                        <input type="number" name="regstatus" value="<?php echo $row['regStatus'] ?>" class="form-control" min="0" max="1" maxlength="1" required>
                    </div>
                </div>

                <div class="form-group text-center">
                    <input type="submit" value="Update" class="btn btn-primary" style="width: 150px">
                </div>

            </form>
<?php
        
        } // the end of if($row !== false)
        else
        {
            echo "<div class='alert alert-danger'>That id not exist, You will be redirecting in 3 seconds to Members Page(Main Section)</div>";
            header("refresh:3; url=members.php");
        }
    
    } // END EDIT MEMBER DATA



//3- UPDATE MEMBER DATA
    
    /*
    ** {Docs}
    ** when we submitted from edit section and come here we take the values that sent with post method and store them in variables
    ** perform validation on the fields that we want (server validation) if we have errors we print them and go back to the update section
    ** else we perform the update in the database then go to the Main section.
    ** one of our validates is to check if the user name that we update is exist or not so we retrive from the database the recrod that have
    ** the same username but not the has the id (the id of the current record that we update, and we use the id to prevent retrieving of the 
    ** record that we update) so if we havent retrieved any record that means that the username isn't used
    */

    // We Perforn Client Validation in the form in the Edit section, Here We Perform Server Validation by Php
    // We will perform the server validation on the userName only as example but of course in real we should perform it in all the required inputs.
    elseif(isset($_GET['action']) && $_GET['action'] === "update")
    {
        echo "<h2 class='text-center'>Update Member</h2>";
            
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            $id         = $_POST['id'];
            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $email      = $_POST['email'];
            $fullname   = $_POST['fullname'];
            $permission = $_POST['permission'];
            $truststatus= $_POST['truststatus'];
            $regstatus  = $_POST['regstatus'];

            // SERVER VALIDATION ON USERNAME INPUT
            $errors = array();
            
            // if username is empty
            if(empty($username))
            {
                $errors[] = "The User Name Shouldn't be Empty";
            }
            
            // if username more than 4 letters
            if(strlen($username) <= 4)
            {
                $errors[] = "The User Name Should be more than 4 characters";
            }
            
            // if username is used
            include 'include/DBClass.php';
            $ret = $db->getRow("select userId from users where userName = ? and userId != $id", array($username)); // will not return the current editing user record
            
            if($ret > 0)
            {
                $errors[] = "The User Name is Used";
            }
            
            if(!empty($errors))
            {
                foreach($errors as $error)
                {
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Edit Section</div>";
                    header("refresh:3; url={$_SERVER['HTTP_REFERER']}"); // $_SERVER['HTTP_REFERER'] represent the previous page that sent you to the current page
                }
            }
            else
            {
                if(!empty($password))
                {
                    $q = "update users set userName = ?, password = ?, email = ?, fullName = ?, permission = ?, trustStatus = ?, regStatus = ? where userId = ?";
                    $num = $db->updateRow($q, array($username, sha1($password), $email, $fullname, $permission, $truststatus, $regstatus, $id));
                }
                else
                {
                    $q = "update users set userName = ?, email = ?, fullName = ?, permission = ?, trustStatus = ?, regStatus = ? where userId = ?";
                    $num = $db->updateRow($q, array($username, $email, $fullname, $permission, $truststatus, $regstatus, $id));
                }

                echo "<div class='alert alert-success'>$num Record Updated</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Members Page(Main Section)</div>";
                header("refresh:3; url=members.php");
            }
            
        }
        else // if we go directly to the update 
        {
            header("Location: members.php");
        }
    } // END UPDATE MEMBER DATA
    
//4- ADD MEMBER

    elseif(isset($_GET['action']) && $_GET['action'] === "add")
    {
?>
        <form class="form-horizontal" method="post" action="?action=insert" enctype="multipart/form-data">
            <!--            when we have input[type='file'] we should use enctype = "multipart/form-data"        -->
            <!--action can be written like that { action="?action=insert" , or like that, action="members.php?action=insert" }-->

            <h2 class="text-center">Add Member</h2>

            <div class="form-group"> <!-- .form-groups to behave as grid rows, so no need for .row. -->
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['username'] ?></label> <!-- we could give the label the col class to specify it's width -->
                <div class="col-sm-5">
                    <input type="text" name="username" autocomplete="off" class="form-control" required pattern="[A-Za-z0-9]{4+}"> <!-- here we allow in that input >= 4 characters at max that lay between A-Z , a-z , 0-9 -->
                </div>
                <!-- when we give the col class to the input it don't work because the width of the form-control override the width of .col
                     so we should put the input within div    -->
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['password'] ?></label>
                <div class="col-sm-5">
                    <input type="password" name="password" autocomplete="new-password" class="form-control" required> <!-- new-password is used with chorome to prevent him from keeping the pass in the input -->
                    <i class="show-pass fa fa-eye"></i>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['email'] ?></label>
                <div class="col-sm-5">
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['fullname'] ?></label>
                <div class="col-sm-5">
                    <input type="text" name="fullname" class="form-control" required>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['permission'] ?></label>
                <div class="col-sm-5">
                    <input type="number" name="permission" class="form-control" min="0" max="1" maxlength="1" required>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['truststats'] ?></label>
                <div class="col-sm-5">
                    <input type="number" name="truststatus" class="form-control" min="0" max="1" maxlength="1" required>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['regstats'] ?></label>
                <div class="col-sm-5">
                    <input type="number" name="regstatus" class="form-control" min="0" max="1" maxlength="1" required>
                </div>
            </div>
            
            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label"><?php echo $lang['truststats'] ?></label>
                <div class="col-sm-5">
                    <input type="file" name="memImage" class="form-control" required>
                </div>
            </div>

            <div class="form-group text-center">
                <input type="submit" value="Add" class="btn btn-primary" style="width: 150px">
            </div>

        </form> 
            
<?php
    }// End ADD MEMBER


//5- INSERT MEMBER DATA

    /*
    ** {Docs}
    ** when we submitted from Add section and come here we take the values that sent with post method and store them in variables
    ** perform validation on the fields that we want (server validation) if we have errors we print them and go back to the Add section, 
    ** then we check in the username if exist we print error then go back to add section or
    ** we perform the insert in the database then go to the Main section
    */

    elseif(isset($_GET['action']) && $_GET['action'] === "insert")
    {
        echo "<h2 class='text-center'>Insert Member</h2>";
            
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            
            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $email      = $_POST['email'];
            $fullname   = $_POST['fullname'];
            $permission = $_POST['permission'];
            $truststatus= $_POST['truststatus'];
            $regstatus  = $_POST['regstatus'];
            $memImage   = $_FILES['memImage'];  // array of image data
            
            $imageExtensions = array("jpeg", "jpg", "png", "gif");   // list of allowed types of the image
            
            $imgExten = strtolower(end(explode("/", $memImage['type']))); // end get the last item from the array returned from the explode function which will be the file extension then to be insure we convert the file extension to lower case
            

            // SERVER VALIDATION ON USERNAME INPUT
            $errors = array();
            
            // if username is empty
            if(empty($username))
            {
                $errors[] = "The User Name Shouldn't be Empty";
            }
            
            // if username less than or equal 4 letters
            if(strlen($username) <= 4)
            {
                $errors[] = "The User Name Should be more than 4 characters";
            }
            
            // if the file that is uploaded isn't in the allowed extensions then show error
            if(! in_array($imgExten, $imageExtensions))
            {
                $errors[] = "This file isn't allowed to be uploaded";
            }
            
            // Check for the file size if more than 4MB
            if($memImage['size'] > 4194304)
            {
                $errors[] = "This file is more than 4MB";
            }
            
            if(!empty($errors))
            {
                foreach($errors as $error)
                {
                    header("refresh:3; url={$_SERVER['HTTP_REFERER']}"); // $_SERVER['HTTP_REFERER'] represent the previous page that sent you to the current page ,,, we should put the header first , if we put it in the down it will produce warning and it will not work
                    // { https://stackoverflow.com/questions/8028957/how-to-fix-headers-already-sent-error-in-php }
                    
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Add Section</div>";
                }
            }
            else
            {
                require_once 'include/DBClass.php';
                
                $ret = $db->getRow("select userId from users where userName = ?", array($username));
                
                if(empty($ret))
                {
                    $imgName = rand(0, 1000000) . '_' . $memImage['name']; // we make that concat to prevent the duplicate of images names
                    
                    move_uploaded_file($memImage['tmp_name'], "layout\uploads\avaters\\$imgName"); // move the uploaded file from the temp path to our path
                    
                    $q = "INSERT INTO users(userName, password, email, fullName, permission, trustStatus, regStatus, regDate, image) VALUES (?, ?, ?, ?, ?, ?, ?, now(), ?)";

                    $num = $db->insertRow($q, array($username, sha1($password), $email, $fullname, $permission, $truststatus, $regstatus, $imgName));

                    echo "<div class='alert alert-success'>$num Record inserted</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Members Page(Main Section)</div>";
                    header("refresh:3; url=members.php");
                }
                else
                {
                    echo "<div class='alert alert-danger'>The username is used</div>"; 
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Add Section</div>";
                    header("refresh:3; url={$_SERVER['HTTP_REFERER']}"); // $_SERVER['HTTP_REFERER'] represent the previous page that sent you to the current page
                }

            }
            
        }
        else // if we go directly to the insert 
        {
            header("Location: members.php");
        }
    } // END INSERT MEMBER DATA


//6- DELETE MEMBER

    /*
    ** {Docs}
    ** when we go to delete section by the button within the form in the Main Section we go to the delete section by post submit usin that link
    ** members.php?action=delete&id=1 , so we send action = delete and id that is always correct , and we can't go to that section directly 
    ** the only way is go by submit.
    */

    elseif(isset($_GET['action']) && $_GET['action'] === "delete")
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            echo "<h2 class='text-center'>Delete Member</h2>";
            require_once 'include/DBClass.php';
            
            $num = $db->deleteRow("delete from users where userId = ?", array($_GET['id']));
            echo "<div class='alert alert-success'>$num Record deleted</div>";
            echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Members Page(Main Section)</div>";
            header("refresh:3; url=members.php");
        }
        else // if we go directly to the delete section
        {
            header("location: members.php");
        }
    }

//7- PENDING MEMBER

    elseif(isset($_GET['action']) && $_GET['action'] === "pending")
    {   
        require_once 'include/DBClass.php';
        $rows = $db->getRows("select * from users where regStatus = 0");
        
        echo "<h2 class='text-center'>Pending Members</h2>";
?>
    <div class="table-responsive">    
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Permission</th>
                <th>Trust</th>
                <th>Register</th>
                <th>Reg Date</th>
                <th>Action</th>
            </tr>
<?php
            foreach($rows as $row)
            {
?>
            <tr>
                <td><?php echo $row['userId']; ?></td>
                <td><?php echo $row['userName']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['fullName']; ?></td>
                <td><?php echo $row['permission']; ?></td>
                <td><?php echo $row['trustStatus']; ?></td>
                <td><?php echo $row['regStatus']; ?></td>
                <td><?php echo $row['regDate']; ?></td>
                <td>
                    <form class='formdel' action='?action=accept&id=<?php echo $row[0]; ?>' method='post'><input type='submit' value='Accept' class='btn btn-success'></form>
                    <form class='formdel' action='?action=delete&id=<?php echo $row[0]; ?>' method='post'><input type='submit' value='Decline' class='btn btn-danger confirm'></form>
                </td>
            </tr>
<?php
            }// the close of foreach braces
?>
        </table>
    </div>

<?php
    }

//8- ACCEPTING PENDING MEMBERS

    elseif(isset($_GET['action']) && $_GET['action'] === "accept")
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            echo "<h2 class='text-center'>Accepting Members</h2>";
            require_once 'include/DBClass.php';
            
            $num = $db->updateRow("update users set regStatus = 1 where userId = ?", array($_GET['id']));
            echo "<div class='alert alert-success'>$num Member Accepted</div>";
            echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Members Page(Main Section)</div>";
            header("refresh:3; url={$_SERVER['HTTP_REFERER']}");
        }
        else // if we go directly to the Accept section
        {
            header("location: members.php?action=pending");
        }
    }

//1- MEMBERS.PHP {without any action}

    else
    {
?>  
        <h2 class="text-center">Manage Members</h2>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr>
                    <th>ID</th>
                    <th>Avater</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Permission</th>
                    <th>Trust</th>
                    <th>Register</th>
                    <th>Reg Date</th>
                    <th>Action</th>
                </tr>
<?php
                require_once 'include/DBClass.php';
                $rows = $db->getRows("select * from users where userId != ?", array($_SESSION['Id'])); // get all rows excpt the current user
                foreach($rows as $row)
                {
                    echo "<tr>
                            <td>{$row['userId']}</td>
                            <td>";
                            if(!empty($row['image']))
                            {
                                echo "<img src='layout/uploads/avaters/{$row['image']}'>";
                            }
                            else
                            {
                                echo "<img src='layout/images/1.jpg'>";
                            }
                    echo "  </td>
                            <td>{$row['userName']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['fullName']}</td>
                            <td>{$row['permission']}</td>
                            <td>{$row['trustStatus']}</td>
                            <td>{$row['regStatus']}</td>
                            <td>{$row['regDate']}</td>
                            <td>
                            <a href='?action=edit&id=$row[0]' class='btn btn-success'>Edit</a>
                            <form class='formdel' action='?action=delete&id=$row[0]' method='post'><input type='submit' value='Delete' class='btn btn-danger confirm'></form>
                            </td>
                          </tr>
                    ";
                    // here we use form to go to the delete section by post submit and with that way we prevent the direct going to delete section
                    // but with update button we use <a> with href to go to the edit section, if we go directly to the edit section with correct
                    // id we show the data of that id, but if have wrong id we show message and move to members.php , we prevent direct move to 
                    // the delete section because if the id is correct the data of that id will be removed without knowing the identity of that id
                    // so we use form with post submit
                }
?>
                
            </table>
        </div>
        <a href="members.php?action=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>

<?php
    } // end of members section
    
    echo "</div>\n"; // the close of container div, and the close of the body tag exist in the footer
    include 'include/templates/footer.php'; // include footer
    ob_end_flush();
?>