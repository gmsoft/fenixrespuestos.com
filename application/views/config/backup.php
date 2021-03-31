<?php $this->load->view('administrador/dashboard/header'); ?>
<!-- BEGIN PAGE -->
<div id="container" class="row-fluid">
    <!-- BEGIN SIDEBAR -->
    <?php $this->load->view('administrador/dashboard/sidebar'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->  
    <div id="main-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        <button class="btn btn-danger" onclick="window.history.back()"><i class="icon-arrow-left"></i></button>
                        BackUp Base de Datos
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>

                <div>
                    <button type="button" id="btn-backup" class="btn btn-primary">BackUp Base de Datos</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- END PAGE -->
<?php $this->load->view('administrador/dashboard/footer'); ?>

<script>
    jQuery(document).ready(function() {
        EditableTable.init();
    });

    $('#btn-backup').click(function(){

        $('#btn-backup').attr('disable', true);
        $('#btn-backup').text('Respaldando...');

        $.ajax({
          url: "/configuration_controller/do_backup_database"
          //context: document.body
        }).done(function(data) {
          //$( this ).addClass( "done" );
          //console.log(data);
          alert(data);
          $('#btn-backup').attr('disable', false);
          $('#btn-backup').text('BackUp Base de Datos');
        });
    });

    //$(".chosen-select").chosen();
    //$(".chosen-select-deselect").chosen({allow_single_deselect: true});
</script>