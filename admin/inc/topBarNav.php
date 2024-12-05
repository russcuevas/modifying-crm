<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }

  p {
    margin-top: 15px;
  }

  .btn-rounded {
    border-radius: 50px;
  }

  .navbar-nav {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-left: 0;
  }

  .nav-item {
    margin-right: 20px;
  }

  .nav-link {
    display: flex;
    align-items: center;
    font-size: 16px;
    padding: 8px 12px;
  }

  .nav-link .nav-icon {
    margin-right: 8px;
    font-size: 18px;
  }

  .nav-link:hover {
    background-color: #f8f9fa;
  }

  .nav-link.active {
    background-color: darkblue;
    color: white !important;
  }
</style>


<!-- Navbar -->
<nav style="background-color: black !important;" class="main-header navbar navbar-expand border-top-0 border-left-0 border-right-0 text-sm shadow-sm">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo base_url ?>" class="nav-link"><b><?php echo (!isMobileDevice()) ? $_settings->info('name') : $_settings->info('short_name'); ?></b></a>
    </li>

    <li class="nav-item">
      <a href="./" class="nav-link nav-home">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo base_url ?>admin/?page=leads" class="nav-link nav-leads">
        <i class="nav-icon fas fa-stream"></i>
        <p>Leads</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo base_url ?>admin/?page=opportunities" class="nav-link nav-opportunities">
        <i class="nav-icon fas fa-circle"></i>
        <p>Opportunities</p>
      </a>
    </li>

    <!-- Admin-only options -->
    <?php if ($_settings->userdata('type') == 1): ?>
      <li class="nav-item">
        <a href="<?php echo base_url ?>admin/?page=sources" class="nav-link nav-sources">
          <i class="nav-icon fas fa-list"></i>
          <p>Source List</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
          <i class="nav-icon fas fa-users-cog"></i>
          <p>User List</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
          <i class="nav-icon fas fa-cogs"></i>
          <p>Settings</p>
        </a>
      </li>
    <?php endif; ?>
  </ul>

  <!-- Right navbar links (Aligned horizontally) -->
  <ul class="navbar-nav ml-auto">

  </ul>

  <!-- User Avatar and Dropdown -->
  <li style="list-style: none;" class="nav-item">
    <div class="btn-group nav-link">
      <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image"></span>
        <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname') . ' ' . $_settings->userdata('lastname')) ?></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu" role="menu">
        <a class="dropdown-item" href="<?php echo base_url . 'admin/?page=user' ?>"><span class="fa fa-user"></span> My Account</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo base_url . '/classes/Login.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
      </div>
    </div>
  </li>
</nav>
<!-- /.navbar -->