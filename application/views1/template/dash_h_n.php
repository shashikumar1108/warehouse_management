<?php 

$settings = $this->db->select('*')->from('settings')->where('id',1)->get()->result_array();

?>


<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>">
          <img src="<?php echo base_url(); ?>assets/images/<?php echo $settings[0]['logo']; ?>" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url(); ?>chromaTemplate/index.html">
          <img src="<?php echo base_url(); ?>assets/images/<?php echo $settings[0]['logo']; ?>" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center" >
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
                  <img class="img-xs rounded-circle" src="https://www.adweek.com/wp-content/uploads/sites/2/2015/09/Temporary.jpg" alt="Profile image">
                </div>
                <div class="inner">
                  <div class="inner">
                    <span class="profile-text font-weight-bold"><?php echo $this->session->userdata('username') ?></span>
                    <small class="profile-text small"><?php echo ($this->session->userdata('usertype') == 1 ? 'Super admin' : ($this->session->userdata('usertype') == 2 ? 'Warehouse admin' : ($this->session->userdata('usertype') == 3 ? 'Warehouse Accountant' : ($this->session->userdata('usertype') == 4 ? 'Warehouse Sales' : ($this->session->userdata('usertype') == 5 ? 'Supplier User' : ($this->session->userdata('usertype') == 6 ? 'Agent' : 'Shop Admin')))))) ?></small>
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
              <a class="dropdown-item" href="<?php echo base_url('auth/profile'); ?>">
                Profile
              </a>
              <a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">
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
            <img src="https://www.adweek.com/wp-content/uploads/sites/2/2015/09/Temporary.jpg" alt="profile image">
            <p class="text-center font-weight-medium"><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name')?></p>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Dashboard</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('department'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Department</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#warehouse" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Warehouse</span>
              <div class="badge badge-danger">*</div>
            </a>
            <div class="collapse" id="warehouse">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('warehouse'); ?>">Warehouses</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('WarehouseOrders'); ?>">Warehouse Orders</a>
                </li>                                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('users'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Users</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li>
	        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#shops" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Shops</span>
              <div class="badge badge-danger">3</div>
            </a>
            <div class="collapse" id="shops">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('shops'); ?>">Shops</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('ShopPayments'); ?>">Shop payments</a>
                </li>
              <?php
                  $user_id = $this->session->userdata['id'];
                  $shop_id = $this->db->select('s.id')
                              ->from('shops s')
                              ->join('user_shop_relationship us', 'us.shop_id = s.id')
                              ->join('users u', 'u.id = us.user_id')
                              ->where('u.id', $user_id)                  
                              ->get()
                              ->result_array();

              if(!empty($shop_id)){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('ShopOrders'); ?>">Shop orders</a>
                </li>  
              <?php  }

                ?>
                                              
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('suppliers'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Suppliers</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#initilization" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Initilizations</span>
              <div class="badge badge-danger">3</div>
            </a>
            <div class="collapse" id="initilization">
              <ul class="nav flex-column sub-menu">
                <!-- <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>Initilization/brands">Brands</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>Initilization/brandsSectors">Brand Sector</a>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>Initilization/regions">Regions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>Initilization/towns">Towns</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>Initilization/units">Units</a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>Initilization/stores">Stores</a>
                </li> -->
              </ul>
            </div>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('brand'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Brand</span>
              <div class="badge badge-success">3</div>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#brands" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Brand</span>
              <div class="badge badge-danger">2</div>
            </a>
            <div class="collapse" id="brands">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('brand/brands'); ?>">Brands</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('brand/BrandSector'); ?>">Brand Sector</a>
                </li>                                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#categories" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Category</span>
              <div class="badge badge-danger">3</div>
            </a>
            <div class="collapse" id="categories">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('category'); ?>">Categories</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('category/listSubCategoryOne'); ?>">Sub Category One</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('category/listSubCategoryTwo'); ?>">Sub Category Two</a>
                </li>                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#expenses" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Expense</span>
              <div class="badge badge-danger">2</div>
            </a>
            <div class="collapse" id="expenses">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('expense'); ?>">Expenses</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('expense/category'); ?>">Expense Category</a>
                </li>                                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#bank" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Bank</span>
              <div class="badge badge-danger">4</div>
            </a>
            <div class="collapse" id="bank">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>bank/cheques">Cheques</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>bank/banks">Banks</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>bank/deposits">Bank Deposits</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>bank/books">Bank Books</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#supply" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Supply</span>
              <div class="badge badge-danger">3</div>
            </a>
            <div class="collapse" id="supply">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('supply/supplylist'); ?>">Supply List</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('supply/driver'); ?>">Drivers</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('supply/vehicle'); ?>">Vehicles</a>
                </li>                                
              </ul>
            </div>
          </li>
                    
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('products'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Products</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('StateCode'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">State Codes</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('agents'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Agents</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('payments'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Payments</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('orders'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Orders</span>
              <!-- <div class="badge badge-success">3</div> -->
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Settings</span>
              <div class="badge badge-danger">1</div>
            </a>
            <div class="collapse" id="settings">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('settings'); ?>">System settings</a>
                </li>                                               
              </ul>
            </div>
          </li>                            
        </ul>
      </nav>
    

      
