<?php 

    ob_start();
    session_start();
    $title = "Profile";
    include 'init.php';
    
    if(isset($_SESSION['user']))
    {
        
        $info = $db->getRow("select * from users where userName = ?", array($_SESSION['user']));
?>        
     
    <div class="container profile">
        
        <h1 class="text-center">My Profile</h1>
        
        <div class="information">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    My Informations
                </div>
                <div class="panel-body">
                    <p>Name: <?php echo $info['userName']; ?></p>
                    <p>Email: <?php echo $info['email']; ?></p>
                    <p>Full Name: <?php echo $info['fullName']; ?></p>
                    <p>Register Date: <?php echo $info['regDate']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="ads">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Latest Ads
                </div>
                <div class="panel-body">
                    <?php
                        $items = $db->getRows("select * from items where memberId = ? order by id desc", array($info['userId']));
                        if(!empty($items))
                        {
                            echo "<div class='row'>";
                            foreach($items as $item)
                            {
                                echo "<div class='col-sm-4 col-md-3'>";
                                    echo "<div class='thumbnail item-box'>"; // https://getbootstrap.com/docs/3.3/components/#thumbnails
                                        echo "<span class='price'>" . $item['price'] . "</span>";
                                        if($item['approve'] == 0)
                                        {
                                            echo "<span class='approve'>Waiting Approve</span>";
                                        }
                                        echo "<img src='layout/images/1.jpg' alt='item'>";
                                        echo "<div class='caption'>";
                                            echo "<h4><a href='items.php?itemid={$item['id']}'>" . $item['name'] . "</a></h4>";
                                            echo "<p>" . $item['description'] . "</p>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                        else
                        {
                            echo "<p>There isn't Ads, Create <a href='ads.php'>New Ad</a></p>";
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="comments">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Latest Comments
                </div>
                <div class="panel-body">
                    <?php
                        $comments = $db->getRows("select * from comments where memberId = ? order by id desc", array($info['userId']));
                        if(!empty($comments))
                        {
                            foreach($comments as $comment)
                            {
                                echo "<p>{$comment['comment']}</p>";
                            }
                        }
                        else
                        {
                            echo "<p>There isn't Comments</p>";
                        } 
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php        
    }
    else
    {
        header("location: index.php");
    }

?>



<?php 
    include $tpl . '/footer.php';
    ob_end_flush();
?>