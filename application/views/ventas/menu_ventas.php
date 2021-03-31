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
                        Orden de Compra
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <div class="row-fluid">
                <!--BEGIN METRO STATES-->
                <div class="metro-nav">
                    <div class="metro-nav-block nav-block-blue">
                        <a data-original-title="" href="<?php echo site_url('compra_controller/nueva_orden_compra') ?>">
                            <i class="icon-table"></i>
                            <div class="info"></div>
                            <div class="status">Nueva Orden de Compra</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="<?php echo site_url('compra_controller/listado_orden_compra') ?>">
                            <i class="icon-list"></i>
                            <div class="info"></div>
                            <div class="status">Listado de Ordenes</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-purple">
                        <a data-original-title="" href="<?php echo site_url('compra_controller/facturas_compra') ?>">
                            <i class="icon-list"></i>
                            <div class="info"></div>
                            <div class="status">Nueva Factura de Compra</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-green">
                        <a data-original-title="" href="<?php echo site_url('compra_controller/listado_facturas_compra') ?>">
                            <i class="icon-list"></i>
                            <div class="info"></div>
                            <div class="status">Listado Facturas de Compra</div>
                        </a>
                    </div>
                    <!--
                    <div class="metro-nav-block nav-deep-gray">
                        <a data-original-title="" href="<?php echo site_url('compra_controller/recepcion_orden_compra') ?>">
                            <i class="icon-archive"></i>
                            <div class="info"></div>
                            <div class="status">Recepción de Mercadería</div>
                        </a>
                    </div>
                    -->
                </div>
                <div class="clear"></div>
            </div>

            <!--END METRO STATES-->
        </div>
        <!-- END PAGE HEADER-->       
        <div class="span7">
            <!--END GENERAL STATISTICS-->
        </div>

    </div>
</div>
<!-- END PAGE -->  
</div>

<!-- END PAGE -->
<?php $this->load->view('administrador/dashboard/footer'); ?>
