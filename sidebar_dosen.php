<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    
    <!-- Menu Home / Dashboard -->
    <li class="nav-item">
      <a href="../home_dosen" class="nav-link <?php if ($halaman == 'Home_Dosen') {echo 'active';}?>">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="../ganti_password_Dosen" class="nav-link  <?php if ($halaman == 'ganti_password_Dosen') {echo 'active';}?>">
        <i class="nav-icon fas fa-user-lock"></i>
        <p>Ganti Password</p>
      </a>
    </li>

    <!-- Menu Keluar / Logout -->
    <li class="nav-item">
      <a href="../logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Keluar</p>
      </a>
    </li>

  </ul>
</nav>