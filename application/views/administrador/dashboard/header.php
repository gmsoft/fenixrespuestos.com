<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->  <!--<![endif]-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fenix Repuestos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="mosaddek" name="author">
    <link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico"/>
    <link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style-responsive.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style-default.css" rel="stylesheet" id="style_color">
    <link href="<?=base_url()?>assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen">
    <link href="<?= base_url() ?>assets/chosen-bootstrap/chosen/chosen.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />

    <script src="<?= base_url() ?>assets/js/jquery-1.8.3.min.js"></script>

</head>
<body id="internal" class="dashboard fixed-top">
    <!-- MODAL ERRORES -->
    <div class="modal hide fade" id="modal-error">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><i class="icon-remove-sign"></i> Atención</h3>
        </div>
        <div class="modal-body">
            <span id="msg-modal-error"></span>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Aceptar</button>
            <!--<button id="btn-guardar-precio" class="btn btn-primary">Guardar</button>-->
        </div>
    </div>
    
    <!-- MODAL PROCESANDO -->
    <div class="modal hide fade" id="modal-procesando">
        <div class="modal-header">
            <h3>Procesando...</h3>
        </div>
        <div class="modal-body">
            <span id="msg-modal-procesando"></span>
        </div>
        <div class="modal-footer">
            
            <!--<button id="btn-guardar-precio" class="btn btn-primary">Guardar</button>-->
        </div>
    </div>

   <?php //$this->load->view('administrador/dashboard/modal_consulta_articulos'); ?> 
    
    <!-- BEGIN HEADER -->
    <div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner">
           <div class="container-fluid">
               <!--BEGIN SIDEBAR TOGGLE-->
               <div class="sidebar-toggle-box hidden-phone">
                   <div class="icon-reorder tooltips" data-placement="right" data-original-title="Menu Desplegable"></div>
               </div>
               <!--END SIDEBAR TOGGLE-->
               <!-- BEGIN LOGO -->
               <a class="brand" href="<?php echo site_url('administrador/dashboard') ?>">
                   <img class="center" alt="logo" src="<?php echo base_url() . 'assets/img/logo.png' ?>" />
               </a>
               <!-- END LOGO -->
               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="arrow"></span>
               </a>
               <!-- END RESPONSIVE MENU TOGGLER -->
               <div id="top_menu" class="nav notify-row">
                  
               </div>
               <!-- END  NOTIFICATION -->
               <div class="top-nav ">
                   <ul class="nav pull-right top-menu" >
                       <!-- BEGIN USER LOGIN DROPDOWN -->
                       <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <span class="username"><?php echo renderName(); ?></span>
                               <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu extended logout">
                               <li><a href="<?php echo site_url('salir') ?>"><i class="icon-key"></i> Salir</a></li>
                           </ul>
                       </li>
                       <!-- END USER LOGIN DROPDOWN -->
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
           </div>
       </div>
       <!-- END TOP NAVIGATION BAR -->
    </div>
        <!-- END HEADER -->