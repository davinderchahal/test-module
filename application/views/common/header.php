<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="<?php echo base_url('images/logo-light-svg.svg'); ?>">

  <title>Test Module</title>

  <!-- Vendors Style-->
  <link rel="stylesheet" href="<?php echo base_url('main/css/vendors_css.css'); ?>">

  <!-- Style-->
  <link rel="stylesheet" href="<?php echo base_url('main/css/style.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('main/css/skin_color.css'); ?>">

</head>

<body class="hold-transition light-skin sidebar-mini theme-success fixed">

  <div class="wrapper">
    <div id="loader"></div>

    <header class="main-header">
      <div class="d-flex align-items-center logo-box justify-content-start">
        <a href="#" class="waves-effect waves-light nav-link rounded d-none d-md-inline-block push-btn" data-toggle="push-menu" role="button">
          <img src="<?php echo base_url('images/svg-icon/collapse.svg'); ?>" class="img-fluid svg-icon" alt="">
        </a>
        <!-- Logo -->
        <a href="<?php echo site_url(); ?>" class="logo">
          <div class="logo-lg">
            <span class="light-logo"><img src="<?php echo base_url('images/logo-letter.png'); ?>" alt="logo" style="width:60px;"></span>
            <span class="dark-logo"><img src="<?php echo base_url('images/logo-letter.png'); ?>" alt="logo" style="width:60px;"></span>
          </div>
        </a>
      </div>
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div class="app-menu">
          <ul class="header-megamenu nav">
            <li class="btn-group nav-item d-md-none">
              <a href="#" class="waves-effect waves-light nav-link push-btn btn-outline no-border" data-toggle="push-menu" role="button">
                <img src="<?php echo base_url('images/svg-icon/collapse.svg'); ?>" class="img-fluid svg-icon" alt="">
              </a>
            </li>
            <li class="btn-group nav-item">
              <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link btn-outline no-border full-screen" title="Full Screen">
                <img src="<?php echo base_url('images/svg-icon/fullscreen.svg'); ?>" class="img-fluid svg-icon" alt="">
              </a>
            </li>
          </ul>
        </div>

        <div class="navbar-custom-menu r-side">
          <ul class="nav navbar-nav">
            <!-- User Account-->
            <li class="dropdown user user-menu">
              <a href="#" class="waves-effect waves-light dropdown-toggle btn-outline no-border" data-bs-toggle="dropdown" title="User">
                <img src="<?php echo base_url('images/svg-icon/user.svg'); ?>" class="rounded svg-icon" alt="" />
              </a>
              <ul class="dropdown-menu animated flipInX">
                <li class="user-body">
                  <a class="dropdown-item" href="<?php echo site_url('user/logout'); ?>"><i class="ti-lock text-muted me-2"></i> Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">
      <!-- sidebar-->
      <section class="sidebar position-relative">
        <div class="multinav">
          <div class="multinav-scroll" style="height: 100%;">
            <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">
              <li <?php echo ($this->uri->segment(2) == '') ? 'class="active"' : ''; ?>>
                <a href="<?php echo site_url(); ?>">
                  <img src="<?php echo base_url('images/svg-icon/sidebar-menu/dashboard.svg'); ?>" class="svg-icon" alt="">
                  <span>Dashboard</span>
                </a>
              </li>
              <?php if (get_user_role() == 1) { ?>
                <li <?php echo ($this->uri->segment(2) == 'manage_test') ? 'class="active"' : ''; ?>>
                  <a href="<?php echo site_url('test/manage_test'); ?>">
                    <img src="<?php echo base_url('images/svg-icon/sidebar-menu/pages.svg'); ?>" class="svg-icon" alt="">
                    <span>Manage Test</span>
                  </a>
                </li>
              <?php } ?>

            </ul>
          </div>
        </div>
      </section>
    </aside>