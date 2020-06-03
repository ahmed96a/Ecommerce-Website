<?php

    ob_start();
    session_start();
    $title = 'Main Front';
    include 'init.php';

?>

<!--Start The Page-->
    
    <div class="container">
        <h1 class="text-center">Show Category</h1>
        <div class="row">
        <?php
            $items = $db->getRows("select * from items where catId = ? and approve = 1 order by id desc", array($_GET['catid']));
            if(!empty($items))
            {
                foreach($items as $item)
                {
                    echo "<div class='col-sm-4 col-md-3'>";
                        echo "<div class='thumbnail item-box'>"; // https://getbootstrap.com/docs/3.3/components/#thumbnails
                            echo "<span class='price'>$" . $item['price'] . "</span>";
                            echo "<img src='layout/images/1.jpg' alt='item'>";
                            echo "<div class='caption'>";
                                echo "<h4><a href='items.php?itemid={$item['id']}'>" . $item['name'] . "</a></h4>";
                                echo "<p>" . $item['description'] . "</p>";
                                echo "<span>" . $item['date'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            }
            else
            {
                echo "<p>There isn't Ads</p>";
            }
        ?>
    </div>

<!--End The Page-->

<?php

    include "$tpl/footer.php";
    ob_end_flush();
?>