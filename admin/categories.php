<?php
    
    ob_start(); // for header warning

    session_start();
    $title = "Categories"; // page title
    
    
    if(isset($_SESSION['Id'])) // if we login
    {
        
        include 'include/languages/english.php'; // include english version
        include 'include/templates/header.php'; // include header
        echo "<body>";
        include 'include/templates/navbar.php'; // include navbar
        
        echo "<div class='container category'>\n";
        
        
// 1- MANAGE
        if(!isset($_GET['action']))
        {
            // Sort Type by Id or Name
            $typearr = array('ID','Name');
            $type = isset($_GET['type']) && in_array($_GET['type'], $typearr)? $_GET['type'] : 'ID';
            
            // Sort Algorithem
            $sortarr = array('Asc','Desc');
            $sort = isset($_GET['sort']) && in_array($_GET['sort'], $sortarr)? $_GET['sort'] : 'Asc';

            require_once 'include/DBClass.php';
            $rows = $db->getRows("select * from categories where parent=0 order by $type $sort");
            
?>
            <h2 class="text-center">Manage Categories</h2>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-edit"></i> Manage Categories
                    <div class="sort pull-right">
                        <i class="fa fa-sort"></i> Type: [
                        <a class="<?php echo $type=='ID'? 'active': ''; ?>" href="?type=ID&sort=<?php echo $sort; ?>">ID</a> | 
                        <a class="<?php echo $type=='Name'? 'active': ''; ?>" href="?type=Name&sort=<?php echo $sort; ?>">Name</a>] 
                        
                        <i class="fa fa-random"></i> Ordering: [
                        <a class="<?php echo $sort=='Asc'? 'active': ''; ?>" href="?type=<?php echo $type; ?>&sort=Asc">Asc</a> | 
                        <a class="<?php echo $sort=='Desc'? 'active': ''; ?>" href="?type=<?php echo $type; ?>&sort=Desc">Desc</a>]
                    </div>
                </div>
                <div class="panel-body">
                    <?php

                    foreach($rows as $row)
                    {
                        echo "<div class='cat'>
                                <h4>{$row['name']}</h4>
                                <div class='cat-detail'>
                                    <p>{$row['description']}</p>";
                                    if($row['visibility'] == 0) echo "<span class='vis'><i class='fa fa-eye'></i> Hidden</span>";
                                    if($row['comment'] == 0) echo "<span class='com'><i class='fa fa-close'></i> Comment Disabeled</span>";
                                    if($row['ads'] == 0) echo "<span class='ads'><i class='fa fa-close'></i> No Ads</span>";

                        echo        "<div class='action'>
                                        <form action='?action=Edit&Id={$row['id']}' method='post'>
                                            <button class='btn btn-primary' type='submit'><i class='fa fa-edit'></i> Edit</button>
                                        </form>
                                        <form action='?action=Delete&Id={$row['id']}' method='post'>
                                            <button class='btn btn-danger' type='submit'><i class='fa fa-times-circle'></i> Delete</button>
                                        </form>
                                    </div>
                                </div>";
                                
                                // print the sub categories
                                
                                $subs = $db->getRows("select * from categories where parent = {$row['id']}");
                                if(!empty($subs))
                                {
                                    echo "<div class='cat-subs'>";
                                    echo "<h5>Sub Categories</h5>";
                                    echo "<ul>";
                                    foreach ($subs as $sub)
                                    {
                                        echo "<li>" . $sub['name'] . "
                                            <div class='sub-action'>
                                                <form action='?action=Edit&Id={$sub['id']}' method='post'>
                                                    <button class='btn btn-primary' type='submit'><i class='fa fa-edit'></i> Edit</button>
                                                </form>
                                                <form action='?action=Delete&Id={$sub['id']}' method='post'>
                                                    <button class='btn btn-danger' type='submit'><i class='fa fa-times-circle'></i> Delete</button>
                                                </form>
                                            </div>
                                        </li>";
                                    }        
                                    echo "</ul>";
                                    echo "</div>";
                                }    
                        
                        echo    "<hr>
                              </div>";
                    }

                    ?>
                </div>
            </div>
            <a href="categories.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Category</a>

<?php
        }
// 2- Add Category        
        elseif($_GET['action'] == "Add")
        {
?>
            <form class="form-horizontal" method="post" action="?action=Insert"> <!--action can be written like that { action="?action=insert" , or like that, action="members.php?action=insert" }-->

            <h2 class="text-center">Add Category</h2>

            <div class="form-group"> <!-- .form-groups to behave as grid rows, so no need for .row. -->
                <label class="col-sm-2 col-sm-offset-2 control-label">Category Name: </label> <!-- we could give the label the col class to specify it's width -->
                <div class="col-sm-5">
                    <input type="text" name="catName" class="form-control" required>
                </div>
                <!-- when we give the col class to the input it don't work because the width of the form-control override the width of .col
                     so we should put the input within div    -->
            </div>


            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Description: </label>
                <div class="col-sm-5">
                    <input type="text" name="catDescription" class="form-control" required>
                </div>
            </div>
                
            <div class="form-group">
                <label class="col-sm-2 col-sm-offset-2 control-label">Parent ?: </label>
                <div class="col-sm-5">
                    <select name="catParent">
                        <option value="0">None</option>
                        <?php
                            require_once 'include/DBClass.php';
                            $cats = $db->getRows("select * from categories where parent = 0");

                            foreach($cats as $cat)
                            {
                                echo "<option value='{$cat['id']}'>{$cat['name']}</option>\n";
                            }

                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Visibility</label>
                <div class="col-sm-5">
                    <div class="radio">
                        <label>
                            <input type="radio" name="catVisibility" value="1" checked> Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="catVisibility" value="0"> No
                        </label>
                    </div>
                </div>
            </div>
                
            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Comments</label>
                <div class="col-sm-5">
                    <div class="radio">
                        <label>
                            <input type="radio" name="catComment" value="1" checked> Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="catComment" value="0"> No
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group"> 
                <label class="col-sm-2 col-sm-offset-2 control-label">Ads</label>
                <div class="col-sm-5">
                    <div class="radio">
                        <label>
                            <input type="radio" name="catAds" value="1" checked> Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="catAds" value="0"> No
                        </label>
                    </div>
                </div>
            </div>


            <div class="form-group text-center">
                <input type="submit" value="Add" class="btn btn-primary" style="width: 150px">
            </div>

        </form> 
<?php
        }
// 3- Insert Category        
        elseif($_GET['action'] == "Insert")
        {
            echo "<h2 class='text-center'>Insert Category</h2>";
            
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                $catName            = $_POST['catName'];
                $catDescription     = $_POST['catDescription'];
                $catParent          = $_POST['catParent'];
                $catVisibility      = $_POST['catVisibility'];
                $catComment         = $_POST['catComment'];
                $catAds             = $_POST['catAds'];
                
                // if $catName is used
                require_once 'include/DBClass.php';
                $ret = $db->getRow("select id from categories where name = ?", array($catName));

                if($ret > 0)
                {
                    header("refresh:3; url={$_SERVER['HTTP_REFERER']}");
                    echo "<div class='alert alert-danger'>Category Name is Used.</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Add Section</div>";
                }

                else
                {
                    $q = "INSERT INTO categories(name, description, visibility, comment, ads, parent) VALUES (?, ?, ?, ?, ?, ?)";

                    $num = $db->insertRow($q, array($catName, $catDescription, $catVisibility, $catComment, $catAds, $catParent));
                    
                    header("refresh:3; url=categories.php");
                    echo "<div class='alert alert-success'>$num Record inserted</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Categories Page(Manage Section)</div>";
                }
            
            }
            else // if we go directly to the insert 
            {
                header("Location: categories.php");
            }
        }
// 4- Edit Category        
        elseif($_GET['action'] == "Edit")
        {
            
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                require_once 'include/DBClass.php';
                $row = $db->getRow("select * from categories where id = ?", array($_GET['Id']));
            
?>
                <form class="form-horizontal" method="post" action="?action=Update&Id=<?php echo $row[0]; ?>">

                    <h2 class="text-center">Edit Category</h2>

                    <div class="form-group"> <!-- .form-groups to behave as grid rows, so no need for .row. -->
                        <label class="col-sm-2 col-sm-offset-2 control-label">Category Name: </label> <!-- we could give the label the col class to specify it's width -->
                        <div class="col-sm-5">
                            <input type="text" name="catName" class="form-control" value="<?php echo $row['name'] ?>" required>
                        </div>
                        <!-- when we give the col class to the input it don't work because the width of the form-control override the width of .col
                             so we should put the input within div    -->
                    </div>


                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Description: </label>
                        <div class="col-sm-5">
                            <input type="text" name="catDescription" class="form-control" value="<?php echo $row['description'] ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-2 control-label">Parent ?: </label>
                        <div class="col-sm-5">
                            <select name="catParent">
                                <option value="0">None</option>
                                <?php
                                    require_once 'include/DBClass.php';
                                    $cats = $db->getRows("select * from categories where parent = 0");

                                    foreach($cats as $cat)
                                    {
                                        echo "<option value='{$cat['id']}'";
                                        if($row['parent'] == $cat['id'])
                                        {
                                            echo "selected";
                                        }
                                        echo ">{$cat['name']}</option>\n";
                                    }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Visibility</label>
                        <div class="col-sm-5">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="catVisibility" value="1" <?php echo $row['visibility'] == 1? 'checked' : '' ?>> Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="catVisibility" value="0" <?php echo $row['visibility'] == 0? 'checked' : '' ?>> No
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-offset-2 control-label">Comments</label>
                        <div class="col-sm-5">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="catComment" value="1" <?php echo $row['comment'] == 1? 'checked' : '' ?>> Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="catComment" value="0" <?php echo $row['comment'] == 0? 'checked' : '' ?>> No
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group"> 
                        <label class="col-sm-2 col-sm-offset-2 control-label">Ads</label>
                        <div class="col-sm-5">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="catAds" value="1" <?php echo $row['ads'] == 1? 'checked' : '' ?>> Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="catAds" value="0" <?php echo $row['ads'] == 0? 'checked' : '' ?>> No
                                </label>
                            </div>
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
                header("location: categories.php");
            }
        }
// 5- Update Category
        elseif($_GET['action'] == "Update")
        {
            echo "<h2 class='text-center'>Update Category</h2>";
            
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                $catId              = $_GET['Id'];
                $catName            = $_POST['catName'];
                $catDescription     = $_POST['catDescription'];
                $catParent          = $_POST['catParent'];
                $catVisibility      = $_POST['catVisibility'];
                $catComment         = $_POST['catComment'];
                $catAds             = $_POST['catAds'];
                
                // if $catName is used
                require_once 'include/DBClass.php';
                $ret = $db->getRow("select id from categories where name = ? and id != $catId", array($catName));

                if($ret > 0)
                {
                    header("refresh:3; url={$_SERVER['HTTP_REFERER']}");
                    echo "<div class='alert alert-danger'>Category Name is Used.</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Edit Section</div>";
                }

                else
                {
                    $q = "update categories set name = ?, description = ?, visibility = ?, comment = ?, ads = ?, parent = ? where id = $catId";

                    $num = $db->updateRow($q, array($catName, $catDescription, $catVisibility, $catComment, $catAds, $catParent));
                    
                    header("refresh:3; url=categories.php");
                    echo "<div class='alert alert-success'>$num Record updated</div>";
                    echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Categories Page(Manage Section)</div>";
                }
            
            }
            else // if we go directly to the insert 
            {
                header("Location: categories.php");
            }
        }
// 6- Delete Category
        elseif($_GET['action'] == "Delete")
        {
            if($_SERVER['REQUEST_METHOD'] === "POST")
            {
                echo "<h2 class='text-center'>Delete Category</h2>";
                require_once 'include/DBClass.php';

                $num = $db->deleteRow("delete from categories where id = ?", array($_GET['Id']));
                echo "<div class='alert alert-success'>$num Record deleted</div>";
                echo "<div class='alert alert-info'>You will be redirecting in 3 seconds to Members Page(Main Section)</div>";
                header("refresh:3; url=categories.php");
            }
            else // if we go directly to the delete section
            {
                header("location: categories.php");
            }
        }
// 7- Anything else
        else
        {
            header("location: categories.php");
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