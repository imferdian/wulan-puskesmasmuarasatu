<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>   
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
      <div class="user-panel d-flex">
        <div class="info">
          <?php if($currentPage == "profile"){ ?>
            <a href="logout.php" class="btn btn-danger">Logout</a>
          <?php } else if(isset($_SESSION["nama"])) { ?>
            <a href="profile.php" class="d-block text-uppercase">
              <?= ($_SESSION["nama"]); ?>
          <?php } else { ?>
            <a href="../profile.php" class="d-block">
              <?= "Admin"; ?>
          <?php } ?>
          </a>  
        </div>
        <div class="image">
        <?= $currentPage == 'index' ? '<img src="../dist/img/user-profile.png" class="img-circle elevation-2 bg-white" alt="User Image">' : '' ?>
        </div>
      </div>
      </li>
    </ul>
  </nav>