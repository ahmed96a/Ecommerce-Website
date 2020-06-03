<nav class="navbar navbar-default">
  <div class="container">
      
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false"><!-- here we change the data-target value to app-nav -->
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        
      <a class="navbar-brand" href="#"><?php echo $lang['brand'] ?></a>
        
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav"> <!-- here we change the id value to app-nav -->
        
      <ul class="nav navbar-nav">
        <li class="active"><a href="dashboard.php"><?php echo $lang['dashboard'] ?><span class="sr-only">(current)</span></a></li>
        <li><a href="categories.php"><?php echo $lang['categories'] ?></a></li>
        <li><a href="items.php"><?php echo $lang['items'] ?></a></li>
        <li><a href="members.php"><?php echo $lang['members'] ?></a></li>
        <li><a href="comments.php"><?php echo $lang['comments'] ?></a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $lang['dropdown'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop</a></li>
            <li><a href="members.php?action=edit&id=<?php echo $_SESSION['Id']; ?>"><?php echo $lang['edit'] ?></a></li>
            <li><a href="#"><?php echo $lang['settings'] ?></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php"><?php echo $lang['logout'] ?></a></li>
          </ul>
        </li>
      </ul>
        
    </div><!-- /.navbar-collapse -->
      
  </div><!-- /.container-fluid -->
</nav>