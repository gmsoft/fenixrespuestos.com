<?php $this->load->view('administrador/default_layout/header');?>
<!-- BEGIN PAGE -->
<div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
      <?php $this->load->view('administrador/dashboard/sidebar');?>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div id="main-content">
         <div class="container-fluid">
             <?php echo $output ?>
         </div>
            <!-- END PAGE HEADER-->       
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
<!-- END PAGE -->
<!-- Button trigger modal -->

<?php $this->load->view('administrador/default_layout/footer');?>
