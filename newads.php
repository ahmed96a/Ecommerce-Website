<?php
    
    ob_start();
    session_start();
    $title = "Cresate Ad";
    include "init.php";

    if(isset($_SESSION['user']))
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $itemName            = $_POST['itemName'];
            $itemDescription     = $_POST['itemDescription'];
            $itemPrice           = $_POST['itemPrice'];
            $itemCountry         = $_POST['itemCountry'];
            $itemStatus          = $_POST['itemStatus'];
            $itemCategory        = $_POST['itemCategory'];
            $itemMember          = $_SESSION['userId'];
            $itemTags            = $_POST['itemTags'];
            
            // must perform server validattion video #100

            $q = "INSERT INTO items(name, description, price, date, country, status, catId, memberId, tags) VALUES (?, ?, ?, now(), ?, ?, ?, ?, ?)";

            $num = $db->insertRow($q, array($itemName, $itemDescription, $itemPrice, $itemCountry, $itemStatus, $itemCategory, $itemMember, $itemTags));

            echo "<div class='alert alert-success'>Ad is created.</div>";
        }
?>

    <div class="container ads">
        
        <h1 class="text-center">Create New Ad</h1>
        
        <div class="ad">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Create New Ad
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-8">
                            
                            <form class="form-horizontal" method="post">

                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-offset-2 control-label">Item Name: </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="itemName" class="form-control" required>
                                    </div>
                                </div>


                                <div class="form-group"> 
                                    <label class="col-sm-2 col-sm-offset-2 control-label">Description: </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="itemDescription" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="col-sm-2 col-sm-offset-2 control-label">Price: </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="itemPrice" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="col-sm-2 col-sm-offset-2 control-label">Country: </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="itemCountry" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-offset-2 control-label">Status: </label>
                                    <div class="col-sm-7">
                                        <select name="itemStatus">
                                            <option value="New">New</option>
                                            <option value="Used">Used</option>
                                            <option value="Old">Old</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-offset-2 control-label">Category: </label>
                                    <div class="col-sm-7">
                                        <select name="itemCategory">
                                            <?php
                                                require_once 'include/DBClass.php';
                                                $rows = $db->getRows("select id, name from categories");

                                                foreach($rows as $row)
                                                {
                                                    echo "<option value='$row[0]'>$row[1]</option>\n";
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
                            
                        </div>
                        <div class="col-sm-4">
                            
                            <div class='thumbnail item-box'>
                                <span class='price'>0</span>
                                <img src='layout/images/1.jpg' alt='item'>
                                <div class='caption'>
                                    <h4>Title</h4>
                                    <p>Description</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    }
    else
    {
        header("location: login.php");
    }

     include "$tpl/footer.php";
     ob_end_flush();
?>