<?php

    ob_start();
    session_start();
    $title = "DashBoard"; // page title that will be printed in header.php

    // when the admin Enter the dashboard.php
    if(isset($_SESSION['Username']))
    {
        
        include 'include/templates/header.php';
        include 'include/languages/english.php';
        echo "<body class='dashboard'>";
        include 'include/templates/navbar.php';
        
        // Get members count
        
        include 'include/DBClass.php';
        $totalMembers = $db->getRow("select count(userId) from users");
        $pending = $db->getRow("select count(userId) from users where regStatus = 0");
        $items = $db->getRow("select count(id) from items");
        $comments = $db->getRow("select count(id) from comments");
?>        
        
<!--        Start Dashboard Page       -->
        
        <div class="container text-center">
            
            <h2>Dashboard</h2>
            
            <div class="row">
                <div class="col-sm-3">
                    <div class="stat members">
                        <h3>Total Members</h3>
                        <span><a href="members.php"><?php echo $totalMembers[0] ?></a></span>
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="stat pending">
                        <h3>Pending Members</h3>
                        <span><a href="members.php?action=pending"><?php echo $pending[0] ?></a></span>
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="stat items">
                        <h3>Total Items</h3>
                        <span><a href="items.php"><?php echo $items[0] ?></a></span>
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="stat comments">
                        <h3>Total Comments</h3>
                        <span><a href="comments.php"><?php echo $comments[0] ?></a></span>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest Registerd Members <i class="fa fa-plus pull-right select"></i>
                        </div>
                        <div class="panel-body">
                            <?php
                                require_once 'include/DBClass.php';
                                $rows = $db->getRows("select userName, userId, regStatus from users order by userId desc");                        
                                
                                if(!empty($rows))
                                {
                                    echo "<ul class='list-unstyled'>";
                                    foreach($rows as $row)
                                    {
                                        echo "<li>" . $row[0];

                                        if($row['regStatus'] == 0)
                                        {
                                            echo "<form class='pull-right' action='members.php?action=accept&id={$row['userId']}' method='post'><input type='submit' value='Accept' class='btn btn-primary'></form>";
                                        }
                                        echo "<a class='btn btn-success pull-right' href='members.php?action=edit&id={$row['userId']}'><i class='fa fa-edit'></i> Edit</a>"; 

                                        echo "</li>";
                                    }
                                    echo "</ul>";
                                }
                                else
                                {
                                    echo "There's no Members";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Latest Items <i class="fa fa-plus pull-right select"></i>
                        </div>
                        <div class="panel-body">
                            <?php
                                require_once 'include/DBClass.php';
                                $rows = $db->getRows("select name, id, approve from items order by id desc");
        
                                if($rows !== false)
                                {
                                    echo "<ul class='list-unstyled'>";
                                    foreach($rows as $row)
                                    {
                                        echo "<li>" . $row[0];

                                        if($row['approve'] == 0)
                                        {
                                            echo "<form action='items.php?action=Approve&Id={$row['id']}' method='post' class='pull-right'><input type='submit' value='Approve' class='btn btn-primary'></form>";
                                        }
                                        echo "<form action='items.php?action=Edit&Id={$row['id']}' method='post' class='pull-right'><input type='submit' value='Edit' class='btn btn-success '></form>";

                                        echo "</li>";
                                    }
                                    echo "</ul>";
                                }
                                else
                                {
                                    echo "There's no Items";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
<!-- Show The Latest Comments -->
            
    
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-comments"></i> Latest Comments <i class="fa fa-plus pull-right select"></i>
                        </div>
                        <div class="panel-body">
                            <?php
                                require_once 'include/DBClass.php';
                                $rows = $db->getRows("select comments.id, comments.comment, comments.status, users.userName, items.name from comments join items on comments.itemId = items.id join users on comments.memberId = users.userId order by comments.id desc");

                                if($rows !== false)
                                {
                                    foreach($rows as $row)
                                    {
                            ?>
                                        <div class="comment-box">
                                            
                                            <span class="comment-user"><?php echo $row['userName']; ?></span>
                                            <p class="comment-content"><?php echo $row['comment']; ?></p>
                                            
                                            <div class="comment-action">
                                                
                                                <span class="comment-item"><?php echo $row['name']; ?></span>
                                                <form action='comments.php?action=Edit&Id=<?php echo $row['id'] ?>' method='post'>
                                                    <button class='btn btn-primary' type='submit'><i class='fa fa-edit'></i> Edit</button>
                                                </form>
                                                <form action='comments.php?action=Delete&Id=<?php echo $row['id'] ?>' method='post'>
                                                    <button class='btn btn-danger' type='submit'><i class='fa fa-times-circle'></i> Delete</button>
                                                </form>
                                                <?php
                                                    if($row['status'] == 0)
                                                    {
                                                        echo "
                                                              <form action='comments.php?action=Enable&Id={$row['id']}' method='post'>
                                                                <button class='btn btn-success' type='submit'><i class='fa fa-check'></i> Enable</button>
                                                              </form>";
                                                    }
                                                    else
                                                    {
                                                        echo "
                                                              <form action='comments.php?action=Disable&Id={$row['id']}' method='post'>
                                                                <button class='btn btn-warning' type='submit'><i class='fa fa-close'></i> Disable</button>
                                                              </form>";
                                                    }
                                                ?>
                                            </div>
                                            <hr>
                                        </div>
                            <?php
                                    }
                                }
                                else
                                {
                                    echo "No Comments";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
<!--        End Dashboard Page      -->

<?php        
        include 'include/templates/footer.php';
    }

    
    // if we go to that page directly without login
    else
    {
        echo "<div class='alert alert-danger'>Sorry, you aren't admin, You will be redirected to the login page in 2 seconds</div>";
        header("refresh:2; url=index.php");
        ob_end_flush();
    }
    
?>