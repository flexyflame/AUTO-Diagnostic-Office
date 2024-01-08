
<!--Include Navigation | Menu--> 

<div class="app-dashboard shrink-medium" style="display: block;">
  <div class="row expanded app-dashboard-top-nav-bar" style="height: auto;">
    <div class="small-12 medium-4 columns" style="height: 55px; text-align: center;">
      <!--<button data-toggle="app-dashboard-sidebar" class="menu-icon hide-for-medium"></button>-->
      <a class="button app-dashboard-logo" href="<?php echo $SESSION->Generate_Link("index", ""); ?>" style="border: none; font-size: inherit; color: #c7c7c7; font-weight: bold; background-color: transparent;"><img src="/images/auto_logo.png" style="width: 60px; background-color: #ffffff82; border-radius: 5px; margin-right: 10px;"><em style="font-weight: 500; color: white;">AUTO</em> Diagnostic Office</a>
    </div>
    <!--<div class="columns show-for-large">
      <div class="app-dashboard-search-bar-container">
        <input class="app-dashboard-search" type="search" placeholder="Search">
        <i class="app-dashboard-search-icon fa fa-search"></i>
      </div>
    </div>-->

    <div class="medium-4 columns show-for-medium">
      <ul class="menu simple vertical medium-horizontal">
        <li><a style="color: aliceblue;" href="#">Features</a></li>
        <li><a style="color: aliceblue;" href="/index.php#services">Services</a></li>
        <li><a style="color: aliceblue;" href="#">Support</a></li>
        <li><a style="color: aliceblue;" href="/index.php#about-us">About</a></li>
      </ul>
    </div>

    <div class="small-12 medium-4 columns shrink app-dashboard-top-bar-actions" style="height: 55px; text-align: center;">
      <?php  
        echo  '<a class="button hollow topbar-responsive-button" name="btn_login" id="btn_login" data-open="LoginModal" style="margin: 0 5px; color: #ffffff; border: 1px solid #ffffff; min-width: 100px;">Login</a>';  
        echo  '<a class="button warning hollow topbar-responsive-button" id="btn_logout" type="button" data-toggle="user_administration_dropdown" style="margin: 0 5px; border: 1px solid #cacaca; color: #fff;">';
        echo  '   <i class="fa fa-bars" style="margin-right: 10px; font-size: medium; color: orange;"></i><span id="btn_logout_text">***</span>';
        echo  '</a>';
        echo  '<a href="#"  title="Info...!!!" style="font-size: x-large;"><i class="fa fa-info-circle"></i></a>';
      ?>
      
      <div class="dropdown-pane" id="user_administration_dropdown" data-dropdown data-alignment="center" data-close-on-click="true" style="background-color: #600819; border: 1px solid black;">
        <div>
          <ul class="vertical menu" data-accordion-menu style="text-align: left;">
            <li>
              <a href='#0'>File <i class="far fa-caret-square-down"></i></a>
              <ul class="menu vertical" style="margin-left: 20px;">
                <li><a href='<?php echo $SESSION->Generate_Link("vehicle_tests_overview", ""); ?>'>Vehicle Tests</a></li>
                <li><a href='#'>Reports</a></li>
                <li><a href='#'>Shops</a></li>
                <li><a href='#'>Statistics</a></li>
              </ul>
            </li>
            <li>
              <a href='#0'>Administration <i class="far fa-caret-square-down"></i></a>
              <ul class="menu vertical" style="margin-left: 20px;">
                <li><a href='<?php echo $SESSION->Generate_Link("customer_overview", ""); ?>'>Customers</a></li>
                <li><a href='<?php echo $SESSION->Generate_Link("users_overview", ""); ?>'>Users</a></li>
                <li><a href='<?php echo $SESSION->Generate_Link("test_shops_overview", ""); ?>'>Test Shops</a></li>
              </ul>
            </li>
            <li>
              <a href='#0'>Settings <i class="far fa-caret-square-down"></i></a>
              <ul class="menu vertical" style="margin-left: 20px;">
                <li><a href='<?php echo $SESSION->Generate_Link("vehicle_class_overview", ""); ?>'>Vehicle Class</a></li>
                <li><a href='<?php echo $SESSION->Generate_Link("vehicle_producer_overview", ""); ?>'>Vehicle Producer</a></li>
                <li><a href='#0'>Vehicle Model</a></li>
                <li><a href='<?php echo $SESSION->Generate_Link("limits_overview", ""); ?>'>Vehicle Limits</a></li>
              </ul>
            </li>
            <li><a href='#0'>Help Center</a></li>
            <li><a style="color: #ffa600;" href='<?php echo $SESSION->Generate_Link("index", "aktion=logout"); ?>'>Logout</a></li>
          </ul>
        </div>
      </div>

    </div>

    <div class="tiny reveal" id="LoginModal" data-close-on-click="false" data-reveal style="padding: 0; border: 0; border-radius: 10px;">
      <form action="<?php echo $SESSION->Generate_Link("index", ""); ?>" id="form_login_access" name="form_login_access" method="POST">
        <div class="sign-in-form">
          <h4 class="text-center">Login</h4>
          <label for="sign-in-form-username">Username</label>
          <input type="text" class="sign-in-form-username" id="text_username" name="text_username">
          <label for="sign-in-form-password">Password</label>
          <input type="password" class="sign-in-form-password" id="text_password" name="text_password">
          <button type="submit" class="sign-in-form-button">Login</button>
          <p style="font-size: small; margin: 0; text-align: center;"><a>Forgot username/password? </a></p>
          <input name="aktion" type="hidden" id="aktion" value="login" />
        </div>
      </form>

      <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

  </div>

  <div class="app-dashboard-body off-canvas-wrapper">
    <?php if ($SESSION->GLOBAL_LOGIN_ACCESS == 1) { ?>

      <div id="app-dashboard-sidebar" class="app-dashboard-sidebar position-left off-canvas off-canvas-absolute reveal-for-medium" data-off-canvas>
        <div class="app-dashboard-sidebar-title-area">
          <div class="app-dashboard-close-sidebar">
            <h4 class="app-dashboard-sidebar-block-title">File</h4>
            <!-- Close button -->
            <button id="close-sidebar" data-app-dashboard-toggle-shrink class="app-dashboard-sidebar-close-button show-for-medium" aria-label="Close menu" type="button">
              <span aria-hidden="true"><a href="#"><i class="large fa fa-angle-double-left"></i></a></span>
            </button>
          </div>
          <div class="app-dashboard-open-sidebar">
            <button id="open-sidebar" data-app-dashboard-toggle-shrink class="app-dashboard-open-sidebar-button show-for-medium" aria-label="open menu" type="button">
              <span aria-hidden="true"><a href="#"><i class="large fa fa-angle-double-right"></i></a></span>
            </button>
          </div>
        </div>
        <div class="app-dashboard-sidebar-inner">
          <ul class="menu vertical">
            <li><a href="<?php echo $SESSION->Generate_Link("vehicle_tests_overview", ""); ?>" class="is-active">
              <i class="large fa fa-tasks"></i><span class="app-dashboard-sidebar-text">Vehicle Tests</span>
            </a></li>
            <li><a href="<?php echo $SESSION->Generate_Link("customer_overview", ""); ?>">
              <i class="large fa fa-users"></i><span class="app-dashboard-sidebar-text">Customers</span>
            </a></li>
            <li><a href="<?php echo $SESSION->Generate_Link("test_shops_overview", ""); ?>">
              <i class="large fas fa-store-alt"></i><span class="app-dashboard-sidebar-text">Test Shops</span>
            </a></li>
            <li><a>
              <i class="large fas fa-link"></i><span class="app-dashboard-sidebar-text">Statistics</span>
            </a></li>
          </ul>
        </div>
      </div>
    <?php } ?>

    <div class="app-dashboard-body-content off-canvas-content" style="min-height: 70vh;" data-off-canvas-content>

    <!-- Page body comes and followed by the nav_footer.php-->
  

