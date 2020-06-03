<?php
    
    ob_start();
    session_start();
    $title = "Items";
    include "init.php";

    $item = $db->getRow("select items.*, categories.name as catName, users.userName from items join categories on items.catId = categories.id join users on items.memberId = users.userId where items.id = ?", array($_GET['itemid']));
    
    if(!empty($item))
    {
        
?>

    <div class="container Item">
        <h1 class='text-center'><?php echo $item['name']; ?></h1>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-2">
                <img src="layout/images/1.jpg" alt="item" class="img-responsive img-thumbnail">
            </div>
            <div class="col-sm-4">
                <h3><?php echo $item['name'] ?></h3>
                <p><?php echo $item['description'] ?></p>
                <p><?php echo $item['price'] ?></p>
                <p><?php echo $item['date'] ?></p>
                <p>Made In: <?php echo $item['country'] ?></p>
                <p>Category: <a href="categories.php?catid=<?php echo $item['catId']; ?>"><?php echo $item['catName'] ?></a></p>
                <p>Added By: <?php echo $item['userName'] ?></p>
                <p>Tags: <?php
                    $tags = explode(", ", $item['tags']);
                    foreach($tags as $tag)
                    {
                        echo "<a href='tags.php?name=$tag'>" . $tag ."</a> | ";
                    }
                ?></p>
            </div>
        </div>
        <hr>
        
<!--        Add Comment if User     -->
        <?php
        if(isset($_SESSION['user']) && $item['approve'] == 1)
        {
            echo '<div class="row">
                    <div class="col-sm-5 col-sm-offset-2">
                        <h3>Add Comment</h3>
                        <form method="post">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" name="comment"></textarea>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Add Comment">
                            </div>
                        </form>';
                        if($_SERVER['REQUEST_METHOD'] == "POST")
                        {
                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

                            if(!empty($comment))
                            {
                                $db->insertRow("insert into comments(comment, date, itemId, memberId) values(?, now(), ?, ?)", array($comment, $item['id'], $_SESSION['userId']));
                                echo "<div class='alert alert-success'>Comment Added</div>";
                            }
                        }
                        
            echo     '</div>
                </div>';
            
        }
        else
        {
            if($item['approve'] == 0)
            {
                echo "<p>The item isn't approved yet by the admin.</p>";
            }
            else
            {
                echo "<a href='login.php'>Login</a> or <a href='login.php'>signup</a> to add comment";
            }
        }
        ?>
        
<!--        Show Comments Related to that item     -->
        
        <?php

        $rows = $db->getRows("select comments.comment, comments.date, users.userName from comments join users on comments.memberId = users.userId where comments.itemId = {$item['id']} order by comments.id desc");

        foreach($rows as $row)
        {

        ?>
            <hr>
            <div class="row">
                <div class="comment-box">
                        <div class='col-sm-2 text-center'>
                        <img src='layout/images/1.jpg' class='img-responsive img-thumbnail img-circle'>
                        <p><?php echo $row['userName']; ?></p>
                        <span><?php echo $row['date']; ?></span>
                    </div>
                    <div class='col-sm-6'>
                        <p class="comm lead"><?php echo $row['comment']; ?></p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

<?php
    }
    else
    {
        echo "<h1 class='text-center'> There is no item</h1>";
    }
     include "$tpl/footer.php";
    ob_end_flush();
?>