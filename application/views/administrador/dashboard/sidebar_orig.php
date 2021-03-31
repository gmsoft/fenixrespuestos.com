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
              
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>Articulos</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/consulta_articulos') ?>">Consulta Articulos</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/abm_articulos') ?>">ABM Articulos</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/abm_rubros') ?>">ABM Rubros</a></li>
                  </ul>
              </li>

              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>Listas de Precio</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/abm_proveedores') ?>">ABM Proveedores</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/abm_listas') ?>">ABM Listas</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/importar_listas') ?>">Importar Listas</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/listavw') ?>">Lista VW</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/listachevrolet') ?>">Lista Chevrolet</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/listaford') ?>">Lista Ford</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/tabla_dto') ?>">Tabla Dto</a></li>
                  </ul>
              </li>
              
               <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>Stock</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/stock') ?>">Stock</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/transferencias') ?>">Transferencias Stock</a></li>
                  </ul>
              </li>
              
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>Ventas</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/clientes') ?>">Clientes</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/presupuesto') ?>">Presupuestos</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/listado_presupuesto') ?>">Listado de Presupuestos</a></li>
                      <!--
                      <li><a class="" href="#">Pedidos</a></li>
                      -->
                      <li><a class="" href="<?php echo site_url('administrador/nueva_factura') ?>">Nueva Factura</a></li>
                  </ul>
              </li>
              
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>Costos</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/costos_proveedor') ?>">Costo Proveedor</a></li>
                  </ul>
              </li>
              
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>Compras</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('compra_controller/nueva_orden_compra') ?>">Nueva Orden de Compra</a></li>
                      <li><a class="" href="<?php echo site_url('compra_controller/listado_orden_compra') ?>">Listado de Ordenes</a></li>
                      <li><a class="" href="<?php echo site_url('compra_controller/facturas_compra') ?>">Facturas de Compras</a></li>
                  </ul>
              </li>

              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-book"></i>
                      <span>ABM Auxiliares</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/abm_sucursales') ?>">ABM Sucursales</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/abm_marcas') ?>">ABM Marcas</a></li>
                  </ul>
              </li>

              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-user"></i>
                      <span>Usuarios</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/usuarios/add') ?>">Agregar</a></li>
                      <li><a class="" href="<?php echo site_url('administrador/usuarios') ?>">Listado</a></li>
                  </ul>
              </li>
              <!--
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-user"></i>
                      <span>Clientes</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a class="" href="<?php echo site_url('administrador/clientes') ?>">Listado</a></li>
                  </ul>
              </li>
              -->
              
          </ul>
         <!-- END SIDEBAR MENU -->
      </div>
      </div>
<!-- END SIDEBAR -->