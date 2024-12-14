<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <span class="brand-text font-weight-light">Puskesmas Muara Satu</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.php" class="nav-link <?= $currentPage == 'index' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                <?= $_SESSION["role"] == "admin" ? "Data Karyawan" : "Dashboard" ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="profile.php" class="nav-link <?= $currentPage == 'profile'  ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user"></i>
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