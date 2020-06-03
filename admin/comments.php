<?php
    
    ob_start(); // for header warning

    session_start();
    $title = "Comments"; // page title
    
    
    if(isset($_SESSION['Id'])) // if we login
    {
        
        include 'include/languages/english.php'; // include english version
        include 'include/templates/header.php'; // include header
        echo "<body>";
        include 'include/templates/navbar.php'; // include navbar
        
        echo "<div class='container comment'>\n";
        
        
// 1- MANAGE Comment
        if(!isset($_GET['action']))
        {
?>  
        <h2 class="text-center">Manage Comments</h2>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr>
                    <th>ID</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Member</th>
                    <th>Action</th>
                </tr>
                
                <?php
            
                require_once 'include/DBClass.php';
                $rows = $db->getRows("select comments.*, items.name as itemName, users.userName from comments join items on comments.itemId = items.id join users on comments.memberId = users.userId");
                foreach($rows as $row)
                {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['comment']}</td>";
                    echo $row['status'] == 1? "<td>Enabled</td>" : "<td>Disabled</td>";         
                    echo "  <td>{$row['date']}</td>
                            <td>{$row['itemName']}</td>
                            <td>{$row['userName']}</td>
                            <td>
                                <form action='?action=Edit&Id={$row['id']}' method='post'>
                                    <button class='btn btn-primary' type='submit'><i class='fa fa-edit'></i> Edit</button>
                                </form>
                                <form action='?action=Delete&Id={$row['id']}' method='post'>
                                    <button class='btn btn-danger' type='submit'><i class='fa fa-times-circle'></i> Delete</button>
                                </form>";
                    
                                if($row['status'] == 0)
                                {
                                    echo "
                                          <form action='?action=Enable&Id={$row['id']}' method='post'>
                                            <button class='btn btn-success' type='submit'><i class='fa fa-check'></i> Enable</button>
                                          </form>";
                                }
                                
                                
                                if($row['status'] == 1)
                                {
                                    echo "
                                          <form action='?action=Disable&Id={$row['id']}' method='post'>
                                            <button class='btn btn-warning' type='submit'><i class='fa fa-close'></i> Disable</button>
                                          </form>";
                                }
                                
                        echo "</td>
                          </tr>
                    ";
                }
            
                ?>
                
            </table>
        </div>
<?php
        }
// 2- Edit Comment        
        elseif($_GET['action'] == "Edit")
        {
            
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                require_once 'include/DBClass.php';
                $row = $db->getRow("select * from comments where id = ?", array($_GET['Id']));
            
?>
                <form class="form-horizontal" method="post" action="?action=Update&Id=<?php echo $row['id']; ?>">
                    <h2 class="text-center">Edit Comment</h2>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-2 control-label">Comment: </label>
                        <div class="col-sm-5">
                            <textarea class="form-control" name="comName" required><?php echo $row['comment'] ?></textarea>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Status: </label>
                        <div class="col-sm-5">
                            <select name="comStatus">
                                <option value="0" <?php echo $row['status'] == 0? 'selected':''; ?>>Disable</option>
                                <option value="1" <?php echo $row['status'] == 1? 'selected':''; ?>>Enabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" value="Update" class="btn btn-primary" style="width: 150px">
                    </div>

                </form> 
<?php
            }
            else
            {
                header("location: comments.php");
            }
        }
// 3- Update Comment
        elseif($_GET['action'] == "Update")
        {
            echo "<h2 class='text-center'>Update Comment</h2>";
            
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                $comId               = $_GET['Id'];
                $comName             = $_POST['comName'];
                $comStatus           = $_POST['comStatus'];
                
                require_once 'include/DBClass.php';
                $q = "update comments set comment = ?, status = ? where id = $comId";

                $num = $db->updateRow($q, array($comName, $comStatus));

                header("refresh:3; url=comments.php");
                echo "<div class='alert alert-success'>$num Record updated</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Comments Page(Manage Section)</div>";
            
            }
            else // if we go directly to the update 
            {
                header("Location: comments.php");
            }
        }
// 4- Delete Comment
        elseif($_GET['action'] == "Delete")
        {
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                echo "<h2 class='text-center'>Delete Comment</h2>";
                require_once 'include/DBClass.php';

                $num = $db->deleteRow("delete from comments where id = ?", array($_GET['Id']));
                echo "<div class='alert alert-success'>$num Record deleted</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Comments Page(Main Section)</div>";
                header("refresh:3; url=comments.php");
            }
            else // if we go directly to the delete section
            {
                header("location: comments.php");
            }
        }
// 5- Disable Comment
        elseif($_GET['action'] == "Disable")
        {
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                echo "<h2 class='text-center'>Disable Comment</h2>";
                require_once 'include/DBClass.php';

                $num = $db->updateRow("update comments set status = 0 where id = ?", array($_GET['Id']));
                echo "<div class='alert alert-success'>$num Comment Disabled</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Comments Page(Main Section)</div>";
                header("refresh:3; url=comments.php");
            }
            else // if we go directly to the Disable section
            {
                header("location: comments.php");
            }
        }
// 6- Enable Comment
        elseif($_GET['action'] == "Enable")
        {
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                echo "<h2 class='text-center'>Disable Comment</h2>";
                require_once 'include/DBClass.php';

                $num = $db->updateRow("update comments set status = 1 where id = ?", array($_GET['Id']));
                echo "<div class='alert alert-success'>$num Comment Enable</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Comments Page(Main Section)</div>";
                header("refresh:3; url=comments.php");
            }
            else // if we go directly to the Enable section
            {
                header("location: comments.php");
            }
        }
// 7- Anything else
        else
        {
            header("location: comments.php");
        }
        
        echo "</div>\n"; // container close
        include 'include/templates/footer.php'; // include footer
        
    }
    else // if we go to that page without login
    {
        header("location: index.php");
    }
    
    ob_end_flush(); // for header warning
?>