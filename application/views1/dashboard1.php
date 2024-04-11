<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Chroma Admin Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>chromaTemplate/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>chromaTemplate/index.html">
          <img src="<?php echo base_url(); ?>chromaTemplate/images/logo.svg" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url(); ?>chromaTemplate/index.html">
          <img src="<?php echo base_url(); ?>chromaTemplate/images/logo-mini.svg" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav d-none d-md-block">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="LanguageDropdown" href="<?php echo base_url(); ?>chromaTemplate/#" data-toggle="dropdown" aria-expanded="false">
              <i class="flag-icon flag-icon-us"></i>
              English
            </a>
            <div class="dropdown-menu navbar-dropdown pb-0" aria-labelledby="LanguageDropdown">
              <a class="dropdown-item preview-item px-3 py-0">
                <div class="preview-thumbnail">
                  <div class="preview-icon">
                    <i class="flag-icon flag-icon-cn"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="font-weight-light mb-0 small-text">
                    Chinese
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item px-3 py-0">
                <div class="preview-thumbnail">
                  <div class="preview-icon">
                    <i class="flag-icon flag-icon-es"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="font-weight-light mb-0 small-text">
                    Spanish
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item px-3 py-0">
                <div class="preview-thumbnail">
                  <div class="preview-icon">
                    <i class="flag-icon flag-icon-bl"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="font-weight-light mb-0 small-text">
                    French
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item px-3 py-0">
                <div class="preview-thumbnail">
                  <div class="preview-icon">
                    <i class="flag-icon flag-icon-ae"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="font-weight-light mb-0 small-text">
                    Arabic
                  </p>
                </div>
              </a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item search-wrapper d-none d-md-block">
            <form action="#">
              <div class="form-group mb-0">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="mdi mdi-magnify"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" placeholder="Search">
                </div>
              </div>
            </form>
          </li>
          <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="<?php echo base_url(); ?>chromaTemplate/#" data-toggle="dropdown" aria-expanded="false">
              <div class="dropdown-toggle-wrapper">
                <div class="inner">
                  <img class="img-xs rounded-circle" src="https://www.placehold.it/37x37" alt="Profile image">
                </div>
                <div class="inner">
                  <div class="inner">
                    <span class="profile-text font-weight-bold">Larry Garner</span>
                    <small class="profile-text small">Admin</small>
                  </div>
                  <div class="inner">
                    <div class="icon-wrapper">
                      <i class="mdi mdi-chevron-down"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <a class="dropdown-item p-0">
                <div class="d-flex border-bottom">
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                    <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                  </div>
                </div>
              </a>
              <a class="dropdown-item mt-2">
                Manage Accounts
              </a>
              <a class="dropdown-item">
                Change Password
              </a>
              <a class="dropdown-item">
                Check Inbox
              </a>
              <a class="dropdown-item">
                Sign Out
              </a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="<?php echo base_url(); ?>chromaTemplate/#" data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count">4</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <a class="dropdown-item">
                <p class="mb-0 font-weight-normal float-left">You have 4 new notifications
                </p>
                <span class="badge badge-pill badge-warning float-right">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-alert-circle-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">Application Error</h6>
                  <p class="font-weight-light small-text">
                    Just now
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-comment-text-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
                  <p class="font-weight-light small-text">
                    Private message
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-email-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
                  <p class="font-weight-light small-text">
                    2 days ago
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle count-indicator" id="messageDropdown" href="<?php echo base_url(); ?>chromaTemplate/#" data-toggle="dropdown" aria-expanded="false">
              <i class="mdi mdi-email-outline"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <div class="dropdown-item">
                <p class="mb-0 font-weight-normal float-left">You have 7 unread mails
                </p>
                <span class="badge badge-info badge-pill float-right">View all</span>
              </div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="https://www.placehold.it/36x36" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
                    <span class="float-right font-weight-light small-text">1 Minutes ago</span>
                  </h6>
                  <p class="font-weight-light small-text">
                    The meeting is cancelled
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="https://www.placehold.it/36x36" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-medium text-dark">Tim Cook
                    <span class="float-right font-weight-light small-text">15 Minutes ago</span>
                  </h6>
                  <p class="font-weight-light small-text">
                    New product launch
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="https://www.placehold.it/36x36" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-medium text-dark"> Johnson
                    <span class="float-right font-weight-light small-text">18 Minutes ago</span>
                  </h6>
                  <p class="font-weight-light small-text">
                    Upcoming board meeting
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown color-setting d-none d-md-block">
            <a class="nav-link count-indicator" href="<?php echo base_url(); ?>chromaTemplate/#">
              <i class="mdi mdi-invert-colors"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close mdi mdi-close"></i>
          <div class="d-flex align-items-center justify-content-between border-bottom">
            <p class="settings-heading font-weight-bold border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Template Skins</p>
          </div>
          <div class="sidebar-bg-options" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options selected" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <p class="settings-heading font-weight-bold mt-2">Header Skins</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles primary"></div>
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles pink"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas sidebar-dark" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <img src="https://www.placehold.it/100x100" alt="profile image">
            <p class="text-center font-weight-medium">Larry Garner</p>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/index.html">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Dashboard</span>
              <div class="badge badge-success">3</div>
            </a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#page-layouts" aria-expanded="false" aria-controls="page-layouts">
              <i class="menu-icon icon-compass"></i>
              <span class="menu-title">Page Layouts</span>
            </a>
            <div class="collapse" id="page-layouts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/boxed-layout.html">Boxed</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/rtl-layout.html">RTL</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/horizontal-menu.html">Horizontal Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/horizontal-menu-2.html">Horizontal Menu 2</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#apps-dropdown" aria-expanded="false" aria-controls="apps-dropdown">
              <i class="menu-icon icon-settings"></i>
              <span class="menu-title">Apps</span>
              <div class="badge badge-info">2</div>
            </a>
            <div class="collapse" id="apps-dropdown">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/apps/email.html">E-mail</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/apps/calendar.html">Calendar</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/apps/todo.html">Todo List</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/apps/gallery.html">Gallery</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/widgets.html">
              <i class="menu-icon icon-speedometer"></i>
              <span class="menu-title">Widgets</span>
              <div class="badge badge-warning">7</div>
            </a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#sidebar-layouts" aria-expanded="false" aria-controls="sidebar-layouts">
              <i class="menu-icon icon-layers"></i>
              <span class="menu-title">Sidebar Layouts</span>
            </a>
            <div class="collapse" id="sidebar-layouts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/compact-menu.html">Compact menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/sidebar-collapsed.html">Icon menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/sidebar-hidden.html">Sidebar Hidden</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/sidebar-hidden-overlay.html">Sidebar Overlay</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/layout/sidebar-fixed.html">Sidebar Fixed</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse navbar-collapse" href="<?php echo base_url(); ?>chromaTemplate/#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon icon-star"></i>
              <span class="menu-title">Basic UI Elements</span>
              <div class="badge badge-danger">2</div>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/accordions.html">Accordions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/buttons.html">Buttons</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/badges.html">Badges</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/breadcrumbs.html">Breadcrumbs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/dropdowns.html">Dropdowns</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/modals.html">Modals</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/progress.html">Progress bar</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/pagination.html">Pagination</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/tabs.html">Tabs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/typography.html">Typography</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/tooltips.html">Tooltips</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
              <i class="menu-icon icon-equalizer"></i>
              <span class="menu-title">Advanced Elements</span>
              <div class="badge badge-success">3</div>
            </a>
            <div class="collapse" id="ui-advanced">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/dragula.html">Dragula</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/clipboard.html">Clipboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/context-menu.html">Context menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/slider.html">Sliders</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/carousel.html">Carousel</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/colcade.html">Colcade</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/loaders.html">Loaders</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="menu-icon icon-screen-desktop"></i>
              <span class="menu-title">Form elements</span>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/forms/basic_elements.html">Basic Elements</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/forms/advanced_elements.html">Advanced Elements</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/forms/validation.html">Validation</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/forms/wizard.html">Wizard</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#editors" aria-expanded="false" aria-controls="editors">
              <i class="menu-icon icon-loop"></i>
              <span class="menu-title">Editors</span>
            </a>
            <div class="collapse" id="editors">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/forms/text_editor.html">Text editors</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/forms/code_editor.html">Code editors</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#charts" aria-expanded="false" aria-controls="charts">
              <i class="menu-icon icon-pie-chart"></i>
              <span class="menu-title">Charts</span>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/chartjs.html">ChartJs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/morris.html">Morris</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/flot-chart.html">Flot</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/google-charts.html">Google charts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/sparkline.html">Sparkline js</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/c3.html">C3 charts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/chartist.html">Chartists</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/charts/justGage.html">JustGage</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#tables" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Tables</span>
              <div class="badge badge-danger">4</div>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/tables/basic-table.html">Basic table</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/tables/data-table.html">Data table</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/tables/js-grid.html">Js-grid</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/tables/sortable-table.html">Sortable table</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/popups.html">
              <i class="menu-icon icon-bubbles"></i>
              <span class="menu-title">Popups</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/ui-features/notifications.html">
              <i class="menu-icon icon-support"></i>
              <span class="menu-title">Notifications</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#icons" aria-expanded="false" aria-controls="icons">
              <i class="menu-icon icon-badge"></i>
              <span class="menu-title">Icons</span>
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/icons/flag-icons.html">Flag icons</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/icons/font-awesome.html">Font Awesome</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/icons/simple-line-icon.html">Simple line icons</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/icons/themify.html">Themify icons</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#maps" aria-expanded="false" aria-controls="maps">
              <i class="menu-icon icon-map"></i>
              <span class="menu-title">Maps</span>
            </a>
            <div class="collapse" id="maps">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/maps/mapeal.html">Mapeal</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/maps/vector-map.html">Vector Map</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/maps/google-maps.html">Google Map</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#auth" aria-expanded="false" aria-controls="auth">
              <i class="menu-icon icon-lock"></i>
              <span class="menu-title">User Pages</span>
              <div class="badge badge-danger">4</div>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/login.html"> Login </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/login-2.html"> Login 2 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/register.html"> Register </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/register-2.html"> Register 2 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/lock-screen.html"> Lockscreen </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#error" aria-expanded="false" aria-controls="error">
              <i class="menu-icon icon-folder"></i>
              <span class="menu-title">Error pages</span>
              <div class="badge badge-info">1</div>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/error-404.html"> 404 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/error-500.html"> 500 </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#general-pages" aria-expanded="false" aria-controls="general-pages">
              <i class="menu-icon icon-user"></i>
              <span class="menu-title">General Pages</span>
              <div class="badge badge-success">2</div>
            </a>
            <div class="collapse" id="general-pages">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/blank-page.html"> Blank Page </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/profile.html"> Profile </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/faq.html"> FAQ </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/faq-2.html"> FAQ 2 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/news-grid.html"> News grid </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/timeline.html"> Timeline </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/search-results.html"> Search Results </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/portfolio.html"> Portfolio </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="<?php echo base_url(); ?>chromaTemplate/#e-commerce" aria-expanded="false" aria-controls="e-commerce">
              <i class="menu-icon icon-briefcase"></i>
              <span class="menu-title">E-commerce</span>
            </a>
            <div class="collapse" id="e-commerce">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/invoice.html"> Invoice </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/pricing-table.html"> Pricing Table </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/pages/samples/orders.html"> Orders </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>chromaTemplate/documentation/documentation.html">
              <i class="menu-icon icon-docs"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row mb-4">
            <div class="col-12 d-flex align-items-center justify-content-between">
              <h4 class="page-title">Dashboard</h4>
              <div class="d-flex align-items-center">
                <div class="wrapper mr-4 d-none d-sm-block">
                  <p class="mb-0">Summary for
                    <b class="mb-0">September 2017</b>
                  </p>
                </div>
                <div class="wrapper">
                  <a href="<?php echo base_url(); ?>chromaTemplate/#" class="btn btn-link btn-sm font-weight-bold">
                    <i class="icon-share-alt"></i>Export CSV</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 card-statistics">
              <div class="row">
                <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card card-tile">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between pb-2">
                        <h5>Todays Income</h5>
                        <i class="icon-docs"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <p class="text-muted">Avg. Session</p>
                        <p class="text-muted">max: 40</p>
                      </div>
                      <div class="progress progress-md">
                        <div class="progress-bar bg-info w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card card-tile">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between pb-2">
                        <h5>Total Revenue</h5>
                        <i class="icon-pie-chart"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <p class="text-muted">Avg. Session</p>
                        <p class="text-muted">max: 120</p>
                      </div>
                      <div class="progress progress-md">
                        <div class="progress-bar bg-success w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card card-tile">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between pb-2">
                        <h5>Pending Product</h5>
                        <i class="icon-wallet"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <p class="text-muted">Avg. Session</p>
                        <p class="text-muted">max: 54</p>
                      </div>
                      <div class="progress progress-md">
                        <div class="progress-bar bg-danger w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card card-tile">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between pb-2">
                        <h5>Sales</h5>
                        <i class="icon-screen-desktop"></i>
                      </div>
                      <div class="d-flex justify-content-between">
                        <p class="text-muted">Avg. Session</p>
                        <p class="text-muted">max: 143</p>
                      </div>
                      <div class="progress progress-md">
                        <div class="progress-bar bg-warning w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h6 class="card-title">Total Revenue</h6>
                  <div class="w-75 mx-auto mt-4">
                    <div class="d-flex justify-content-between text-center mb-2">
                      <div class="wrapper">
                        <h4>6,256</h4>
                        <small class="text-muted">Total sales</small>
                      </div>
                      <div class="wrapper">
                        <h4>8569</h4>
                        <small class="text-muted">Open Campaign</small>
                      </div>
                    </div>
                  </div>
                  <div id="morris-line-example"></div>
                </div>
              </div>
            </div>
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between pb-4">
                    <h4 class="card-title mb-0">Email Campaign</h4>
                    <p class="mb-0">Last 6 day
                      <i class="mdi mdi-chevron-down"></i>
                    </p>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex">
                            <div class="inner flex-grow">
                              <p class="mb-0">New orders</p>
                              <h4 class="font-weight-bold">16543</h4>
                            </div>
                            <div class="inner d-flex align-items-center">
                              <h1 class="text-primary font-weight-bold">13%</h1>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex">
                            <div class="inner flex-grow">
                              <p class="mb-0">New Users</p>
                              <h4 class="font-weight-bold">26458</h4>
                            </div>
                            <div class="inner d-flex align-items-center">
                              <h1 class="text-info font-weight-bold">64%</h1>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 grid-margin-sm-down stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex">
                            <div class="inner flex-grow">
                              <p class="mb-0">Bounced</p>
                              <h4 class="font-weight-bold">2398</h4>
                            </div>
                            <div class="inner d-flex align-items-center">
                              <h1 class="text-danger font-weight-bold">24%</h1>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 grid-margin-sm-down stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex">
                            <div class="inner flex-grow">
                              <p class="mb-0">Unique Visitors</p>
                              <h4 class="font-weight-bold">12790</h4>
                            </div>
                            <div class="inner d-flex align-items-center">
                              <h1 class="text-success font-weight-bold">30%</h1>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <h4 class="card-title">Sales Status</h4>
                    <p class="text-muted d-none d-md-block">29-May-2018, 11.00 AM</p>
                  </div>
                  <div class="chart-container">
                    <canvas class="mt-4" id="sales-status" height="150"></canvas>
                    <div id="sales-status-legend" class="legend-con mt-4 mb-0"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Total Sales By Products</h4>
                  <div class="d-flex justify-content-between pb-4">
                    <p class="card-description mb-0 d-none d-sm-block">Activity from 4 Jan 2017 to 10 Jan 2017</p>
                    <div id="product-sales-legend"></div>
                  </div>
                  <canvas id="product-sales" height="150"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card dashboard-news-card">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between pb-4">
                    <h4 class="card-title text-white mb-0">News</h4>
                    <i class="icon-reload text-white"></i>
                  </div>
                  <div class="text-white mt-auto">
                    <div class="wrapper">
                      <h4 class="border-bottom">The Idea Of God Is Not Henceforth Relevant</h4>
                      <p>Vivamus suscipit tortor eget felis porttitor volutpat.</p>
                      <a class="text-small text-white font-weight-bold" href="<?php echo base_url(); ?>chromaTemplate/#">READ MORE</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <h4 class="card-title">Activity</h4>
                  </div>
                  <p class="card-description">What're people doing right now</p>
                  <div class="list d-flex align-items-center border-bottom py-3">
                    <img class="img-sm rounded-circle" src="https://www.placehold.it/43x43" alt="">
                    <div class="wrapper w-100 ml-3">
                      <p class="mb-0">
                        <b>Dobrick </b>posted in Material</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                          <p class="mb-0">That's awesome!</p>
                        </div>
                        <small class="text-muted ml-auto">2 hours ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list d-flex align-items-center border-bottom py-3">
                    <img class="img-sm rounded-circle" src="https://www.placehold.it/43x43" alt="">
                    <div class="wrapper w-100 ml-3">
                      <p class="mb-0">
                        <b>Stella </b>posted in Material</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                          <p class="mb-0">That's awesome!</p>
                        </div>
                        <small class="text-muted ml-auto">3 hours ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list d-flex align-items-center border-bottom py-3">
                    <img class="img-sm rounded-circle" src="https://www.placehold.it/43x43" alt="">
                    <div class="wrapper w-100 ml-3">
                      <p class="mb-0">
                        <b>Peter </b>posted in Material</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                          <p class="mb-0">That's Great!</p>
                        </div>
                        <small class="text-muted ml-auto">1 hours ago</small>
                      </div>
                    </div>
                  </div>
                  <div class="list d-flex align-items-center pt-3">
                    <img class="img-sm rounded-circle" src="https://www.placehold.it/43x43" alt="">
                    <div class="wrapper w-100 ml-3">
                      <p class="mb-0">
                        <b>Natalia </b>posted in Material</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                          <p class="mb-0">That's awesome!</p>
                        </div>
                        <small class="text-muted ml-auto">1 hours ago</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body d-flex flex-column">
                  <h4 class="card-title">Sales Chart</h4>
                  <p class="card-description">Based on last month analytics.</p>
                  <div class="mt-auto" id="dashboard-sales-chart"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card support-pane-card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Customer support</h4>
                    <div class="btn-toolbar mb-0 d-none d-sm-block" role="toolbar" aria-label="Toolbar with button groups">
                      <div class="btn-group" role="group" aria-label="First group">
                        <button type="button" class="btn btn-success">
                          <i class="mdi mdi-plus-circle"></i> Add
                        </button>
                      </div>
                      <div class="btn-group" role="group" aria-label="Second group">
                        <button type="button" class="btn btn-outline-secondary">
                          <i class="mdi mdi-alert-circle-outline"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                          <i class="mdi mdi-delete-empty"></i>
                        </button>
                      </div>
                      <div class="btn-group" role="group" aria-label="Third group">
                        <button type="button" class="btn btn-outline-secondary">
                          <i class="mdi mdi-printer"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive support-pane no-wrap">
                    <div class="t-row">
                      <div class="tumb">
                        <div class="img-sm rounded-circle bg-info d-flex align-items-center justify-content-center text-white">EC</div>
                      </div>
                      <div class="content">
                        <p class="font-weight-bold mb-2 d-inline-block">John Alexander</p>
                        <p class="text-muted mb-2 d-inline-block">30 Nov 2018</p>
                        <p>3 Smart Reasons Why You Should Consider Paying For Your Traffic</p>
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">Dashboard</p>
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">3 hours</p>
                      </div>
                    </div>
                    <div class="t-row">
                      <div class="tumb">
                        <div class="img-sm rounded-circle bg-danger d-flex align-items-center justify-content-center text-white">EC</div>
                      </div>
                      <div class="content">
                        <p class="font-weight-bold mb-2 d-inline-block">Landon Simpson</p>
                        <p class="text-muted mb-2 d-inline-block">07 Sep 2018</p>
                        <p>Low-Cost Advertising</p>
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">Mobile app
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">5 hours</p>
                      </div>
                    </div>
                    <div class="t-row">
                      <div class="tumb">
                        <div class="img-sm rounded-circle bg-success d-flex align-items-center justify-content-center text-white">EC</div>
                      </div>
                      <div class="content">
                        <p class="font-weight-bold mb-2 d-inline-block">David Burns</p>
                        <p class="text-muted mb-2 d-inline-block">06 Aug 2018</p>
                        <p>Pos Hardware More Options In Less Space</p>
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">Website</p>
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">2 hours</p>
                      </div>
                    </div>
                    <div class="t-row">
                      <div class="tumb">
                        <div class="img-sm rounded-circle bg-warning d-flex align-items-center justify-content-center text-white">EC</div>
                      </div>
                      <div class="content">
                        <p class="font-weight-bold mb-2 d-inline-block">Cordelia Mitchell</p>
                        <p class="text-muted mb-2 d-inline-block">06 Apr 2018</p>
                        <p>5 Reasons To Choose A Notebook Over A Computer Desktop</p>
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">Dashboard</p>
                      </div>
                      <div class="tile">
                        <p class="text-muted mb-2">Project</p>
                        <p class="font-weight-bold">4 hours</p>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mt-4">
                    <p class="mb-0 d-none d-md-block">Showing 1 to 20 of 20 entries</p>
                    <nav>
                      <ul class="pagination rounded mb-0 pagination-success">
                        <li class="page-item">
                          <a class="page-link" href="<?php echo base_url(); ?>chromaTemplate/#">
                            <i class="mdi mdi-chevron-left"></i>
                          </a>
                        </li>
                        <li class="page-item active">
                          <a class="page-link" href="<?php echo base_url(); ?>chromaTemplate/#">1</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo base_url(); ?>chromaTemplate/#">2</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo base_url(); ?>chromaTemplate/#">3</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo base_url(); ?>chromaTemplate/#">4</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo base_url(); ?>chromaTemplate/#">
                            <i class="mdi mdi-chevron-right"></i>
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
              <a href="<?php echo base_url(); ?>chromaTemplate/http://urbanui.com" target="_blank">UrbanUI</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
              <i class="mdi mdi-heart-outline text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?php echo base_url(); ?>chromaTemplate/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>chromaTemplate/js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate/js/misc.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate/js/settings.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url(); ?>chromaTemplate/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>