<!-- BEGIN SIDEBAR -->
      <div class="sidebar-scroll">
        <div id="sidebar" class="nav-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->
          <ul class="sidebar-menu">
              <li class="sub-menu active">
                  <a class="" href="<?php echo site_url('administrador/dashboard') ?>">
                      <i class="icon-dashboard"></i>
                      <span>Tablero</span>
                  </a>
              </li>
              
              <?php 
              $CI =&get_instance();
              $CI->load->model('menu_model');
              $user = $CI->session->userdata('logged_in');
              $user_id = $user['guestData']['tbl_users_id'];

              $menu = $CI->menu_model->get_full_menu($user_id);

              echo $menu;
              ?>
              
          </ul>
         <!-- END SIDEBAR MENU -->
      </div>
      </div>
<!-- END SIDEBAR -->
