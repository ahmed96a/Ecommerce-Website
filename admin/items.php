<?php
    
    ob_start(); // for header warning

    session_start();
    $title = "Items"; // page title
    
    
    if(isset($_SESSION['Id'])) // if we login
    {
        
        include 'include/languages/english.php'; // include english version
        include 'include/templates/header.php'; // include header
        echo "<body>";
        include 'include/templates/navbar.php'; // include navbar
        
        echo "<div class='container Item'>\n";
        
        
// 1- MANAGE Item
        if(!isset($_GET['action']))
        {
?>  
        <h2 class="text-center">Manage Items</h2>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Member</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                
                <?php
            
                require_once 'include/DBClass.php';
                $rows = $db->getRows("SELECT items.*, categories.name as cat_name, users.userName FROM `items` join `categories` on items.catId = categories.id join users on users.userId = items.memberId");
                foreach($rows as $row)
                {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['date']}</td>
                            <td>{$row['cat_name']}</td>
                            <td>{$row['userName']}</td>
                            <td>{$row['country']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form action='?action=Edit&Id={$row['id']}' method='post'>
                                    <button class='btn btn-primary' type='submit'><i class='fa fa-edit'></i> Edit</button>
                                </form>
                                <form action='?action=Delete&Id={$row['id']}' method='post'>
                                    <button class='btn btn-danger' type='submit'><i class='fa fa-times-circle'></i> Delete</button>
                                </form>";
                                
                                if($row['approve'] == 0)
                                {
                                    echo "
                                          <form action='?action=Approve&Id={$row['id']}' method='post'>
                                            <button class='btn btn-success' type='submit'><i class='fa fa-check'></i> Approve</button>
                                          </form>";
                                }
                                
                        echo "</td>
                          </tr>
                    ";
                }
            
                ?>
                
            </table>
        </div>
        <a href="items.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
<?php
        }
// 2- Add Item        
        elseif($_GET['action'] == "Add")
        {
?>
            <form class="form-horizontal" method="post" action="?action=Insert">
            <h2 class="text-center">Add Item</h2>

            <div class="form-group">
                <label class="col-sm-2 col-sm-offset-2 control-label">Item Name: </label>
                <div class="col-sm-5">
                    <input type="text" name="itemName" class="form-control" required>
                </div>
            </div>


            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Description: </label>
                <div class="col-sm-5">
                    <input type="text" name="itemDescription" class="form-control" required>
                </div>
            </div>
                
            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Price: </label>
                <div class="col-sm-5">
                    <input type="text" name="itemPrice" class="form-control" required>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Country: </label>
                <div class="col-sm-5">
                    <input type="text" name="itemCountry" class="form-control" required>
                </div>
            </div>
                
            <div class="form-group">
                <label class="col-sm-2 col-sm-offset-2 control-label">Status: </label>
                <div class="col-sm-5">
                    <select name="itemStatus">
                        <option value="New">New</option>
                        <option value="Used">Used</option>
                        <option value="Old">Old</option>
                    </select>
                </div>
            </div>
                
            <div class="form-group">
                <label class="col-sm-2 col-sm-offset-2 control-label">Member: </label>
                <div class="col-sm-5">
                    <select name="itemMember">
                        <?php
                            require_once 'include/DBClass.php';
                            $rows = $db->getRows("select userId, userName from users");
            
                            foreach($rows as $row)
                            {
                                echo "<option value='$row[0]'>$row[1]</option>\n";
                            }
                            
                        ?>
                    </select>
                </div>
            </div>
                
            <div class="form-group">
                <label class="col-sm-2 col-sm-offset-2 control-label">Category: </label>
                <div class="col-sm-5">
                    <select name="itemCategory">
                        <?php
                            require_once 'include/DBClass.php';
                            $rows = $db->getRows("select id, name from categories where parent = 0");
            
                            foreach($rows as $row)
                            {
                                echo "<option value='$row[0]'>$row[1]</option>\n";
                                
                                $subs = $db->getRows("select * from categories where parent = {$row['id']}");
                                foreach($subs as $sub)
                                {
                                    echo "<option value='{$sub['id']}'>--- {$sub['name']}</option>";
                                }
                            }
                            
                        ?>
                    </select>
                </div>
            </div>
                
            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Tags: </label>
                <div class="col-sm-5">
                    <input type="text" name="itemTags" class="form-control" placeholder="Seberate tags by comma (,)">
                </div>
            </div>

            <div class="form-group text-center">
                <input type="submit" value="Add" class="btn btn-primary" style="width: 150px">
            </div>

        </form> 
<?php
        }
// 3- Insert Item        
        elseif($_GET['action'] == "Insert")
        {
            echo "<h2 class='text-center'>Insert Item</h2>";
            
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                $itemName            = $_POST['itemName'];
                $itemDescription     = $_POST['itemDescription'];
                $itemPrice           = $_POST['itemPrice'];
                $itemCountry         = $_POST['itemCountry'];
                $itemStatus          = $_POST['itemStatus'];
                $itemCategory        = $_POST['itemCategory'];
                $itemMember          = $_POST['itemMember'];
                $itemTags            = $_POST['itemTags'];
                
                require_once 'include/DBClass.php';


                $q = "INSERT INTO items(name, description, price, date, country, status, catId, memberId, tags) VALUES (?, ?, ?, now(), ?, ?, ?, ?, ?)";

                $num = $db->insertRow($q, array($itemName, $itemDescription, $itemPrice, $itemCountry, $itemStatus, $itemCategory, $itemMember, $itemTags));

                header("refresh:3; url=items.php");
                echo "<div class='alert alert-success'>$num Record inserted</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Items Page(Manage Section)</div>";

            }
            else // if we go directly to the insert 
            {
                header("Location: items.php");
            }
        }
// 4- Edit Item        
        elseif($_GET['action'] == "Edit")
        {
            
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                require_once 'include/DBClass.php';
                $row = $db->getRow("select * from items where id = ?", array($_GET['Id']));
            
?>
                <form class="form-horizontal" method="post" action="?action=Update&Id=<?php echo $row['id']; ?>">
                    <h2 class="text-center">Edit Item</h2>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-2 control-label">Item Name: </label>
                        <div class="col-sm-5">
                            <input type="text" name="itemName" class="form-control" value="<?php echo $row['name'] ?>" required>
                        </div>
                    </div>


                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Description: </label>
                        <div class="col-sm-5">
                            <input type="text" name="itemDescription" class="form-control" value="<?php echo $row['description'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Price: </label>
                        <div class="col-sm-5">
                            <input type="text" name="itemPrice" class="form-control" value="<?php echo $row['price'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Country: </label>
                        <div class="col-sm-5">
                            <input type="text" name="itemCountry" class="form-control" value="<?php echo $row['country'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-2 control-label">Status: </label>
                        <div class="col-sm-5">
                            <select name="itemStatus">
                                <option value="New" <?php if($row['status'] == "New"){echo "selected";} ?>>New</option>
                                <option value="Used" <?php if($row['status'] == "Used"){echo "selected";} ?>>Used</option>
                                <option value="Old" <?php if($row['status'] == "Old"){echo "selected";} ?>>Old</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-2 control-label">Category: </label>
                        <div class="col-sm-5">
                            <select name="itemCategory">
                                <?php
                                    require_once 'include/DBClass.php';
                                    $cats = $db->getRows("select id, name from categories");

                                    foreach($cats as $cat)
                                    {
                                        echo "<option value='{$cat['id']}'"; 
                                        if($cat['id'] == $row['catId']){ echo "selected";}
                                        echo ">{$cat['name']}</option>\n";
                                    }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-2 control-label">Member: </label>
                        <div class="col-sm-5">
                            <select name="itemMember">
                                <?php
                                    require_once 'include/DBClass.php';
                                    $members = $db->getRows("select userId, userName from users");

                                    foreach($members as $member)
                                    {
                                        echo "<option value='{$member['userId']}'"; 
                                        if($member['userId'] == $row['memberId']){ echo "selected";}
                                        echo ">{$member['userName']}</option>\n";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Tags: </label>
                        <div class="col-sm-5">
                            <input type="text" name="itemTags" class="form-control" value="<?php echo $row['tags']; ?>" placeholder="Seberate tags by comma (,)">
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" value="Update" class="btn btn-primary" style="width: 150px">
                    </div>

                </form>

<!-- Show the Item Comments -->

                <?php
                     require_once 'include/DBClass.php';
                    $rows = $db->getRows("select comments.id, comments.comment, comments.date, comments.status, users.userName from comments join users on comments.memberId = users.userId where comments.itemId = {$_GET['Id']}");
                    
                    if(count($rows) > 0)
                    {
                ?>
                
                        <h2 class="text-center">Manage Comments</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Member</th>
                                    <th>Action</th>
                                </tr>

                                <?php


                                foreach($rows as $row)
                                {
                                    echo "<tr>
                                            <td>{$row['comment']}</td>";         
                                    echo "  <td>{$row['date']}</td>
                                            <td>{$row['userName']}</td>
                                            <td>
                                                <form action='comments.php?action=Edit&Id={$row['id']}' method='post'>
                                                    <button class='btn btn-primary' type='submit'><i class='fa fa-edit'></i> Edit</button>
                                                </form>
                                                <form action='comments.php?action=Delete&Id={$row['id']}' method='post'>
                                                    <button class='btn btn-danger' type='submit'><i class='fa fa-times-circle'></i> Delete</button>
                                                </form>";

                                                if($row['status'] == 0)
                                                {
                                                    echo "
                                                          <form action='comments.php?action=Enable&Id={$row['id']}' method='post'>
                                                            <button class='btn btn-success' type='submit'><i class='fa fa-check'></i> Enable</button>
                                                          </form>";
                                                }


                                                if($row['status'] == 1)
                                                {
                                                    echo "
                                                          <form action='comments.php?action=Disable&Id={$row['id']}' method='post'>
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
                    } // close of if(count($rows) > 0)
            } // close of if($_SERVER['REQUEST_METHOD'] == "POST")
            else
            {
                header("location: items.php");
            }
        }
// 5- Update Item
        elseif($_GET['action'] == "Update")
        {
            echo "<h2 class='text-center'>Update Item</h2>";
            
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                $itemId              = $_GET['Id'];
                $itemName            = $_POST['itemName'];
                $itemDescription     = $_POST['itemDescription'];
                $itemPrice           = $_POST['itemPrice'];
                $itemCountry         = $_POST['itelljmCountry'];
                $itemStatus          = $_POST['itemStatus'];
                $itemCategory        = $_POST['itemCategory'];
                $itemMember          = $_POST['itemMember'];
                $itemTags            = $_POST['itemTags'];
                
                // if $catName is used
                require_once 'include/DBClass.php';
                $ret = $db->getRow("select id from items where name = ? and id != $itemId", array($itemName));

                if($ret > 0)
                {
                    header("refresh:3; url={$_SERVER['HTTP_REFERER']}");
                    echo "<div class='alert alert-danger'>Item Name is Used.</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Edit Section</div>";
                }

                else
                {
                    $q = "update items set name = ?, description = ?, price = ?, country = ?, status = ?, catId = ?, memberId = ?, tags = ? where id = $itemId";

                    $num = $db->updateRow($q, array($itemName, $itemDescription, $itemPrice, $itemCountry, $itemStatus, $itemCategory, $itemMember, $itemTags));
                    
                    header("refresh:3; url=items.php");
                    echo "<div class='alert alert-success'>$num Record updated</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Items Page(Manage Section)</div>";
                }
            
            }
            else // if we go directly to the insert 
            {
                header("Location: items.php");
            }
        }
// 6- Delete Item
        elseif($_GET['action'] == "Delete")
        {
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                echo "<h2 class='text-center'>Delete Item</h2>";
                require_once 'include/DBClass.php';

                $num = $db->deleteRow("delete from items where id = ?", array($_GET['Id']));
                echo "<div class='alert alert-success'>$num Record deleted</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Items Page(Main Section)</div>";
                header("refresh:3; url=items.php");
            }
            else // if we go directly to the delete section
            {
                header("location: items.php");
            }
        }
// 7- Approve Item
        elseif($_GET['action'] == "Approve")
        {
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                echo "<h2 class='text-center'>Approve Item</h2>";
                require_once 'include/DBClass.php';

                $num = $db->updateRow("update items set approve = 1 where id = ?", array($_GET['Id']));
                echo "<div class='alert alert-success'>$num Item Approved</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Items Page(Main Section)</div>";
                header("refresh:3; url=items.php");
            }
            else // if we go directly to the delete section
            {
                header("location: items.php");
            }
        }
// 8- Anything else
        else
        {
            header("location: items.php");
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