<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= $_SESSION["role"] == 'admin'  ? 'admin.php' : 'index.php' ?>" class="brand-link">
      <img src="../dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Puskesmas Muara Satu</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= $_SESSION["role"] == 'admin' ? 'admin.php' : 'index.php' ?>" class="nav-link <?= $currentPage == 'index' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-table"></i>
              <p>
                <?= $_SESSION["role"] == "admin" ? "Data Pegawai" : "Dashboard" ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../profile.php" class="nav-link <?= $currentPage == 'profile'  ? 'active' : '' ?>">
              <!-- <i class="nav-icon fas fa-user"></i> -->
              <i class="nav-icon bi bi-person-circle"></i>
              <p>
                Profile
              </p>  
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
