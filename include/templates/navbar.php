<div class="upper-bar">
    <div class="container">
        <?php
            if(isset($_SESSION['user']))
            {
        ?>        
                <div class="btn-group">
                    <img src="layout/images/1.jpg" alt="1" class="img-responsive img-circle">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user']; ?>
                        <span class="caret"></span>
                    </button>
                    
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="newads.php">Create Adv</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
                </div>
        <?php    
            }
            else
            {
                echo "<a class='btn btn-default pull-right' href='login.php'>Login/SignUp</a>";
            }
        ?>
    </div>
</div>
<nav class="navbar navbar-inverse">
  <div class="container">
      
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false"><!-- here we change the data-target value to app-nav -->
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        
      <a class="navbar-brand" href="index.php"><?php echo $lang['brand'] ?></a>
        
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav"> <!-- here we change the id value to app-nav -->
        
      <ul class="nav navbar-nav navbar-right">
          <?php
            require_once 'include/DBClass.php';
            $categories = $db->getRows("select * from categories where parent = 0");
            foreach($categories as $cat)
            {
                echo "<li><a href='categories.php?catid={$cat['id']}'>{$cat['name']}</a></li>";
            }
          ?>
      </ul>
        
    </div><!-- /.navbar-collapse -->
      
  </div><!-- /.container-fluid -->
</nav>