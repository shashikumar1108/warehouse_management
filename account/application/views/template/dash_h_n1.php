<?php 
$settings = $this->db->select('*')->from('settings')->where('id',1)->get()->result_array();
?>
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>">
          <img src="<?php echo asset_url(); ?>assets/images/<?php echo $settings[0]['logo']; ?>" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url(); ?>chromaTemplate/index.html">
          <img src="<?php echo asset_url(); ?>assets/images/<?php echo $settings[0]['logo']; ?>" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center" >
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="<?php echo base_url(); ?>chromaTemplate/#" data-toggle="dropdown" aria-expanded="false">
              <div class="dropdown-toggle-wrapper">
                <div class="inner">
                  <!-- <img class="img-xs rounded-circle" src="https://www.adweek.com/wp-content/uploads/sites/2/2015/09/Temporary.jpg" alt="Profile image"> -->
                  <img class="img-xs rounded-circle" src="<?=base_url().$this->session->userdata('profile_pic')?>" alt="Profile Picture">
                </div>
                <div class="inner">
                  <div class="inner">
                    <span class="profile-text font-weight-bold"><?php echo $this->session->userdata('username') ?></span>
                    <small class="profile-text small"><?php echo ($this->session->userdata('usertype') == 3 ? 'Account' : '')?></small>
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
              <a class="dropdown-item" href="<?php echo base_url('auth/change_password'); ?>">
                Change Password
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
            <!-- <img src="https://www.adweek.com/wp-content/uploads/sites/2/2015/09/Temporary.jpg" alt="profile image"> -->
            <p class="text-center font-weight-medium"><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name')?></p>
          </li>
          
          
          

    <?php
        if($this->session->userdata('user_type') == 3){  ?>
                 <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('products'); ?>">
              <i class="menu-icon icon-diamond"></i>
              <span class="menu-title">Products</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#orders" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-grid"></i>
              <span class="menu-title">Orders</span>
              <!-- <div class="badge badge-danger">5</div> -->
            </a>
            <div class="collapse" id="orders">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('orders/approve_rfq'); ?>">Approve RFQ</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('orders/new_confirm_quotation_list'); ?>">Confirm Quote</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('orders/track_shipment'); ?>">Track Shipment</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('orders/confirmed_goods_receipt_list'); ?>">Confirm Goods Reciept Note</a>
                </li>              
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#accounting" aria-expanded="false" aria-controls="tables">
              <i class="menu-icon icon-briefcase"></i>
              <span class="menu-title">Accounting</span>
            </a>
            <div class="collapse" id="accounting">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('accounting/advance_payments'); ?>">Advance Payments</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('accounting/awaiting_order_confirmation'); ?>">Awaiting Order Confirmation</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('accounting/pending_invoice'); ?>">Pending Invoice</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('accounting/paid_invoice'); ?>">Paid Invoice</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('accounting/account_reconcilation'); ?>">Acccount Reconcilation</a>
                </li>              
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('auth/logout'); ?>">
              <i class="menu-icon icon-logout"></i>
              <span class="menu-title">Sign Out</span>
            </a>
          </li>
        <?php  }else{ } ?>
                
        

  
                                     
        </ul>
      </nav>
    

      
