<?php $this->load->view('administrador/dashboard/header');?>
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
                        Tablero
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <?php
            $this->load->view('administrador/dashboard/tiles');
            ?>
            <!-- END PAGE HEADER-->       

            <!-- begin widget -->
            <!--
 <div class="widget ">
     <div class="widget-title">
         <h4><i class="icon-reorder"></i> Doughnut</h4>
         <span class="tools">
             <a href="javascript:;" class="icon-chevron-down"></a>
             <a href="javascript:;" class="icon-remove"></a>
         </span>
     </div>
     <div class="widget-body">
         <div class="text-center">
             <canvas id="doughnut" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
         </div>
     </div>
 </div>
            -->


            <div class="span7">
                <!--BEGIN GENERAL STATISTICS-->
				<!--
                <div class="widget orange">
                    <div class="widget-title">
                        <h4><i class="icon-tasks"></i> Estadisticas Generales </h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
                        <div class="update-btn">
                            <a href="javascript:;" class="btn update-easy-pie-chart"><i class="icon-repeat"></i> Actualizar</a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="text-center">
                            <div class="easy-pie-chart">
                                <div class="percentage success easyPieChart" data-percent="55" style="width: 95px; height: 95px; line-height: 95px;"><span>95</span>%<canvas width="95" height="95"></canvas></div>
                                <div class="title">% Asistencia</div>
                            </div>
                            <div class="easy-pie-chart">
                                <div class="percentage easyPieChart" data-percent="46" style="width: 95px; height: 95px; line-height: 95px;"><span>26</span>%<canvas width="95" height="95"></canvas></div>
                                <div class="title">% de Licencias</div>
                            </div>
                            <div class="easy-pie-chart">
                                <div class="percentage easyPieChart" data-percent="92" style="width: 95px; height: 95px; line-height: 95px;"><span>33</span>%<canvas width="95" height="95"></canvas></div>
                                <div class="title">Licencias rechazadas</div>
                            </div>
                            <div class="easy-pie-chart">
                                <div class="percentage easyPieChart" data-percent="84" style="width: 95px; height: 95px; line-height: 95px;"><span>64</span>%<canvas width="95" height="95"></canvas></div>
                                <div class="title">% de Ausentismo</div>
                            </div>
                        </div>
                    </div>
                </div>
				-->
                <!--END GENERAL STATISTICS-->
            </div>
            
			<!--
            <div class="widget blue">
                <div class="widget-title">
                    <h4><i class="icon-bell"></i> Notificationes </h4>
                    <span class="tools">
                        <a href="javascript:;" class="icon-chevron-down"></a>
                        <a href="javascript:;" class="icon-remove"></a>
                    </span>
                </div>
                <div class="widget-body">
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 380px;"><ul class="item-list scroller padding" style="overflow: hidden; width: auto; height: 380px;" data-always-visible="1">
                            <li>
                                <span class="label label-success"><i class="icon-bell"></i></span>
                                <span>Nueva solicitud de licencia.</span>
                                <div class="pull-right">
                                    <span class="small italic ">Ahora</span>

                                </div>
                            </li>
                            <li>
                                <span class="label label-success"><i class="icon-bell"></i></span>
                                <span>Licencia para Juan Perez Aprobada.</span>
                                <div class="pull-right">
                                    <span class="small italic ">hace 15 min</span>

                                </div>
                            </li>
                            <li>
                                <span class="label label-warning"><i class="icon-bullhorn"></i></span>
                                <span>Ver asistencia.</span>
                                <div class="pull-right">
                                    <span class="small italic ">hace 3 horas</span>

                                </div>
                            </li>
                            <li>
                                <span class="label label-important"><i class=" icon-bug"></i></span>
                                <span>Notificar vacaciones.</span>
                                <div class="pull-right">
                                    <span class="small italic ">hace 1</span>

                                </div>
                            </li>
                            
                        </ul><div class="slimScrollBar ui-draggable" style="background-color: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; z-index: 99; right: 1px; height: 187.04663212435233px; display: none; background-position: initial initial; background-repeat: initial initial;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; background-color: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px; background-position: initial initial; background-repeat: initial initial;"></div></div>
                    <div class="space10"></div>
                    <a href="#" class="pull-right">Ver todas las notificationes</a>
                    <div class="clearfix no-top-space no-bottom-space"></div>
                </div>
            </div>
-->
            <!-- end widget -->



        </div>
    </div>
    <!-- END PAGE -->  
</div>

<!-- END PAGE -->
<?php $this->load->view('administrador/dashboard/footer'); ?>
