<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['administrador'] = 'user_admin_controller/index';

/* Usuarios */
$route['administrador/usuarios'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/add'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/insert'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/success/(:num)'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/insert_validation'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/ajax_list_info'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/ajax_list'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/read/(:num)'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/edit/(:num)'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/update/(:num)'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/update_validation/(:num)'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/delete/(:num)'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/export'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios/print'] = 'user_admin_controller/usuarios';
$route['administrador/usuarios'] = 'user_admin_controller/usuarios';


/* Clientes */
$route['administrador/clientes'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/add'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/insert'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/success/(:num)'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/insert_validation'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/ajax_list_info'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/ajax_list'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/read/(:num)'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/edit/(:num)'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/update/(:num)'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/update_validation/(:num)'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/delete/(:num)'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/export'] = 'customer_controller/manager_clientes';
$route['administrador/clientes/print'] = 'customer_controller/manager_clientes';
$route['administrador/clientes'] = 'customer_controller/manager_clientes';



/* categorias */
$route['administrador/categorias/add'] = 'category_controller/manager_category';
$route['administrador/categorias/insert'] = 'category_controller/manager_category';
$route['administrador/categorias/success/(:num)'] = 'category_controller/manager_category';
$route['administrador/categorias/insert_validation'] = 'category_controller/manager_category';
$route['administrador/categorias/ajax_list_info'] = 'category_controller/manager_category';
$route['administrador/categorias/ajax_list'] = 'category_controller/manager_category';
$route['administrador/categorias/read/(:num)'] = 'category_controller/manager_category';
$route['administrador/categorias/edit/(:num)'] = 'category_controller/manager_category';
$route['administrador/categorias/update/(:num)'] = 'category_controller/manager_category';
$route['administrador/categorias/update_validation/(:num)'] = 'category_controller/manager_category';
$route['administrador/categorias/delete/(:num)'] = 'category_controller/manager_category';
$route['administrador/categorias/export'] = 'category_controller/manager_category';
$route['administrador/categorias/print'] = 'category_controller/manager_category';
$route['administrador/categorias'] = 'category_controller/manager_category';
$route['administrador/categorias/upload_file/image_tile_url'] = 'category_controller/manager_category';
$route['administrador/categorias/delete_file/image_tile_url/'] = 'category_controller/manager_category';
$route['administrador/categorias/(:any)'] = 'category_controller/manager_category';

/* Sub categorias */
$route['administrador/sub-categorias/add'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/insert'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/success/(:num)'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/insert_validation'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/ajax_list_info'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/ajax_list'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/read/(:num)'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/edit/(:num)'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/update/(:num)'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/update_validation/(:num)'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/delete/(:num)'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/export'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/print'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/upload_file/image_tile_url'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/delete_file/image_tile_url/'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias/(:any)'] = 'subcategory_controller/manager_subcategory';
$route['administrador/sub-categorias'] = 'subcategory_controller/manager_subcategory';

/* configuracion */
$route['administrador/configuracion/add'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/insert'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/success/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/insert_validation'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/ajax_list_info'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/ajax_list'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/read/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/edit/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/update/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/update_validation/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/delete/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/export'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/print'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/upload_file/image_tile_url'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/delete_file/image_tile_url/'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/(:any)'] = 'category_controller/manager_configuration';

/* Roles */
$route['administrador/roles/add'] = 'rol_controller/manager_rol';
$route['administrador/roles/insert'] = 'rol_controller/manager_rol';
$route['administrador/roles/success/(:num)'] = 'rol_controller/manager_rol';
$route['administrador/roles/insert_validation'] = 'rol_controller/manager_rol';
$route['administrador/roles/ajax_list_info'] = 'rol_controller/manager_rol';
$route['administrador/roles/ajax_list'] = 'rol_controller/manager_rol';
$route['administrador/roles/read/(:num)'] = 'rol_controller/manager_rol';
$route['administrador/roles/edit/(:num)'] = 'rol_controller/manager_rol';
$route['administrador/roles/update/(:num)'] = 'rol_controller/manager_rol';
$route['administrador/roles/update_validation/(:num)'] = 'rol_controller/manager_rol';
$route['administrador/roles/delete/(:num)'] = 'rol_controller/manager_rol';
$route['administrador/roles/export'] = 'rol_controller/manager_rol';
$route['administrador/roles/print'] = 'rol_controller/manager_rol';
$route['administrador/roles'] = 'rol_controller/manager_rol';
$route['administrador/roles/upload_file/image_tile_url'] = 'rol_controller/manager_rol';
$route['administrador/roles/delete_file/image_tile_url/'] = 'rol_controller/manager_rol';
$route['administrador/roles/(:any)'] = 'rol_controller/manager_rol';



/* User Manager */
$route['registracion'] = 'user_manager_controller/register';
$route['activate'] = 'user_manager_controller/activate';
$route['ingresar'] = 'user_manager_controller/login';
$route['salir'] = 'user_manager_controller/logout'; 
$route['perfil'] = 'user_manager_controller/show_profile';
$route['editar-perfil'] = 'user_manager_controller/edit_profile';
$route['cambiar-password'] = 'user_manager_controller/reset_pass';
$route['reiniciar-password'] = 'user_manager_controller/reset';

/* Dashboard */
$route['administrador/dashboard'] = 'dashboard_controller/index';

/*Consulta Articulos*/
$route['administrador/consulta_articulos'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/add'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/insert'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/success/(:num)'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/insert_validation'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/ajax_list_info'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/ajax_list'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/read/(:num)'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/edit/(:num)'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/update/(:num)'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/update_validation/(:num)'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/delete/(:num)'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/export'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/print'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/upload_file/image_tile_url'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/delete_file/image_tile_url/'] = 'articulo_controller/consulta_articulos';
$route['administrador/consulta_articulos/(:any)'] = 'articulo_controller/consulta_articulos';

/*Consulta Articulo Individual*/
$route['administrador/articulo'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/add'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/insert'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/success/(:num)'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/insert_validation'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/ajax_list_info'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/ajax_list'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/read/(:num)'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/edit/(:num)'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/update/(:num)'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/update_validation/(:num)'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/delete/(:num)'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/export'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/print'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/upload_file/image_tile_url'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/delete_file/image_tile_url/'] = 'articulo_controller/consulta_articulo_individual';
$route['administrador/articulo/(:any)'] = 'articulo_controller/consulta_articulo_individual';

/*ABM Articulos*/
$route['administrador/abm_articulos'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/add'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/insert'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/success/(:num)'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/insert_validation'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/ajax_list_info'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/ajax_list'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/read/(:num)'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/edit/(:num)'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/update/(:num)'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/update_validation/(:num)'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/delete/(:num)'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/export'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/print'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/upload_file/image_tile_url'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/delete_file/image_tile_url/'] = 'articulo_controller/abm_articulos';
$route['administrador/abm_articulos/(:any)'] = 'articulo_controller/abm_articulos';

/*Listas de precios*/
$route['administrador/abm_listas'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/add'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/insert'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/success/(:num)'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/insert_validation'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/ajax_list_info'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/ajax_list'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/read/(:num)'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/edit/(:num)'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/update/(:num)'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/update_validation/(:num)'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/delete/(:num)'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/export'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/print'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/upload_file/image_tile_url'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/delete_file/image_tile_url/'] = 'lista_precio_controller/abm_listas';
$route['administrador/abm_listas/(:any)'] = 'lista_precio_controller/abm_listas';

/*IMPORTAR Listas de precios*/
$route['administrador/importar_listas'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/add'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/insert'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/success/(:num)'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/insert_validation'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/ajax_list_info'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/ajax_list'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/read/(:num)'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/edit/(:num)'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/update/(:num)'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/update_validation/(:num)'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/delete/(:num)'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/export'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/print'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/upload_file/image_tile_url'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/delete_file/image_tile_url/'] = 'lista_precio_controller/importar_listas';
$route['administrador/importar_listas/(:any)'] = 'lista_precio_controller/importar_listas';


/*ABM Proveedores*/
$route['administrador/abm_proveedores'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/add'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/insert'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/success/(:num)'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/insert_validation'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/ajax_list_info'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/ajax_list'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/read/(:num)'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/edit/(:num)'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/update/(:num)'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/update_validation/(:num)'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/delete/(:num)'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/export'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/print'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/upload_file/image_tile_url'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/delete_file/image_tile_url/'] = 'proveedor_controller/abm_proveedores';
$route['administrador/abm_proveedores/(:any)'] = 'proveedor_controller/abm_proveedores';

/*ABM Rubros*/
$route['administrador/abm_rubros'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/add'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/insert'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/success/(:num)'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/insert_validation'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/ajax_list_info'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/ajax_list'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/read/(:num)'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/edit/(:num)'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/update/(:num)'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/update_validation/(:num)'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/delete/(:num)'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/export'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/print'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/upload_file/image_tile_url'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/delete_file/image_tile_url/'] = 'rubro_controller/abm_rubros';
$route['administrador/abm_rubros/(:any)'] = 'rubro_controller/abm_rubros';

/*ABM Sucursales*/
$route['administrador/abm_sucursales'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/add'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/insert'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/success/(:num)'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/insert_validation'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/ajax_list_info'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/ajax_list'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/read/(:num)'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/edit/(:num)'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/update/(:num)'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/update_validation/(:num)'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/delete/(:num)'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/export'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/print'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/upload_file/image_tile_url'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/delete_file/image_tile_url/'] = 'sucursal_controller/abm_sucursales';
$route['administrador/abm_sucursales/(:any)'] = 'sucursal_controller/abm_sucursales';

/*ABM marca*/
$route['administrador/abm_marcas'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/add'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/insert'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/success/(:num)'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/insert_validation'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/ajax_list_info'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/ajax_list'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/read/(:num)'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/edit/(:num)'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/update/(:num)'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/update_validation/(:num)'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/delete/(:num)'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/export'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/print'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/upload_file/image_tile_url'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/delete_file/image_tile_url/'] = 'marca_controller/abm_marcas';
$route['administrador/abm_marcas/(:any)'] = 'marca_controller/abm_marcas';

/*ABM Modelos*/
$route['administrador/abm_modelos'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/add'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/insert'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/success/(:num)'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/insert_validation'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/ajax_list_info'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/ajax_list'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/read/(:num)'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/edit/(:num)'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/update/(:num)'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/update_validation/(:num)'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/delete/(:num)'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/export'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/print'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/upload_file/image_tile_url'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/delete_file/image_tile_url/'] = 'marca_controller/abm_modelos';
$route['administrador/abm_modelos/(:any)'] = 'marca_controller/abm_modelos';


/* Lista VW */
$route['administrador/listavw'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/add'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/insert'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/success/(:num)'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/insert_validation'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/ajax_list_info'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/ajax_list'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/read/(:num)'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/edit/(:num)'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/update/(:num)'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/update_validation/(:num)'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/delete/(:num)'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/export'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/print'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/upload_file/image_tile_url'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/delete_file/image_tile_url/'] = 'lista_precio_controller/lista_vw';
$route['administrador/listavw/(:any)'] = 'lista_precio_controller/lista_vw';


/* Lista chevrolet */
$route['administrador/listachevrolet'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/add'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/insert'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/success/(:num)'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/insert_validation'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/ajax_list_info'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/ajax_list'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/read/(:num)'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/edit/(:num)'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/update/(:num)'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/update_validation/(:num)'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/delete/(:num)'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/export'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/print'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/upload_file/image_tile_url'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/delete_file/image_tile_url/'] = 'lista_precio_controller/lista_chevrolet';
$route['administrador/listachevrolet/(:any)'] = 'lista_precio_controller/lista_chevrolet';

/* Lista Ford*/
$route['administrador/listaford'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/add'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/insert'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/success/(:num)'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/insert_validation'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/ajax_list_info'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/ajax_list'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/read/(:num)'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/edit/(:num)'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/update/(:num)'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/update_validation/(:num)'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/delete/(:num)'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/export'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/print'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/upload_file/image_tile_url'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/delete_file/image_tile_url/'] = 'lista_precio_controller/lista_ford';
$route['administrador/listaford/(:any)'] = 'lista_precio_controller/lista_ford';

/* Lista Renault */
$route['administrador/listarenault'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/add'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/insert'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/success/(:num)'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/insert_validation'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/ajax_list_info'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/ajax_list'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/read/(:num)'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/edit/(:num)'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/update/(:num)'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/update_validation/(:num)'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/delete/(:num)'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/export'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/print'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/upload_file/image_tile_url'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/delete_file/image_tile_url/'] = 'lista_precio_controller/lista_renault';
$route['administrador/listarenault/(:any)'] = 'lista_precio_controller/lista_renault';


/*ABM Stock*/
$route['administrador/stock'] = 'stock_controller/abm_stock';
$route['administrador/stock/add'] = 'stock_controller/abm_stock';
$route['administrador/stock/insert'] = 'stock_controller/abm_stock';
$route['administrador/stock/success/(:num)'] = 'stock_controller/abm_stock';
$route['administrador/stock/insert_validation'] = 'stock_controller/abm_stock';
$route['administrador/stock/ajax_list_info'] = 'stock_controller/abm_stock';
$route['administrador/stock/ajax_list'] = 'stock_controller/abm_stock';
$route['administrador/stock/read/(:num)'] = 'stock_controller/abm_stock';
$route['administrador/stock/edit/(:num)'] = 'stock_controller/abm_stock';
$route['administrador/stock/update/(:num)'] = 'stock_controller/abm_stock';
$route['administrador/stock/update_validation/(:num)'] = 'stock_controller/abm_stock';
$route['administrador/stock/delete/(:num)'] = 'stock_controller/abm_stock';
$route['administrador/stock/export'] = 'stock_controller/abm_stock';
$route['administrador/stock/print'] = 'stock_controller/abm_stock';
$route['administrador/stock/upload_file/image_tile_url'] = 'stock_controller/abm_stock';
$route['administrador/stock/delete_file/image_tile_url/'] = 'stock_controller/abm_stock';
$route['administrador/stock/(:any)'] = 'stock_controller/abm_stock';

/*ABM Ubicaciones*/
$route['administrador/ubicaciones'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/add'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/insert'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/success/(:num)'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/insert_validation'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/ajax_list_info'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/ajax_list'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/read/(:num)'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/edit/(:num)'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/update/(:num)'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/update_validation/(:num)'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/delete/(:num)'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/export'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/print'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/upload_file/image_tile_url'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/delete_file/image_tile_url/'] = 'stock_controller/abm_ubicacion';
$route['administrador/ubicaciones/(:any)'] = 'stock_controller/abm_ubicacion';

/*Tabla Dto*/

$route['administrador/tabla_dto'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/add'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/insert'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/success/(:num)'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/insert_validation'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/ajax_list_info'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/ajax_list'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/read/(:num)'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/edit/(:num)'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/update/(:num)'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/update_validation/(:num)'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/delete/(:num)'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/export'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/print'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/upload_file/image_tile_url'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/delete_file/image_tile_url/'] = 'lista_precio_controller/tabla_dto';
$route['administrador/tabla_dto/(:any)'] = 'lista_precio_controller/tabla_dto';

/*Edit Precio*/

$route['administrador/edit_precio'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/add'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/insert'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/success/(:num)'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/insert_validation'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/ajax_list_info'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/ajax_list'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/read/(:num)'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/edit/(:num)'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/update/(:num)'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/update_validation/(:num)'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/delete/(:num)'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/export'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/print'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/upload_file/image_tile_url'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/delete_file/image_tile_url/'] = 'lista_precio_controller/edit_precio';
$route['administrador/edit_precio/(:any)'] = 'lista_precio_controller/edit_precio';

/*Edit Stock*/
$route['administrador/edit_stock'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/add'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/insert'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/success/(:num)'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/insert_validation'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/ajax_list_info'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/ajax_list'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/read/(:num)'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/edit/(:num)'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/update/(:num)'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/update_validation/(:num)'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/delete/(:num)'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/export'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/print'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/upload_file/image_tile_url'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/delete_file/image_tile_url/'] = 'lista_precio_controller/edit_stock';
$route['administrador/edit_stock/(:any)'] = 'lista_precio_controller/edit_stock';

/* Costos proveedor */
$route['administrador/costos_proveedor'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/add'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/insert'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/success/(:num)'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/insert_validation'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/ajax_list_info'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/ajax_list'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/read/(:num)'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/edit/(:num)'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/update/(:num)'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/update_validation/(:num)'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/delete/(:num)'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/export'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/print'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/upload_file/image_tile_url'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/delete_file/image_tile_url/'] = 'costo_proveedor_controller/menu';
$route['administrador/costos_proveedor/(:any)'] = 'costo_proveedor_controller/menu';

/*Configuracion*/
$route['administrador/configuracion'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/add'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/insert'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/success/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/insert_validation'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/ajax_list_info'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/ajax_list'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/read/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/edit/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/update/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/update_validation/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/delete/(:num)'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/export'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/print'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/upload_file/image_tile_url'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/delete_file/image_tile_url/'] = 'configuration_controller/manager_configuration';
$route['administrador/configuracion/(:any)'] = 'configuration_controller/manager_configuration';

/* Transferencias */
$route['administrador/transferencias'] = 'stock_controller/transferencias';
$route['administrador/transferencias/add'] = 'stock_controller/transferencias';
$route['administrador/transferencias/insert'] = 'stock_controller/transferencias';
$route['administrador/transferencias/success/(:num)'] = 'stock_controller/transferencias';
$route['administrador/transferencias/insert_validation'] = 'stock_controller/transferencias';
$route['administrador/transferencias/ajax_list_info'] = 'stock_controller/transferencias';
$route['administrador/transferencias/ajax_list'] = 'stock_controller/transferencias';
$route['administrador/transferencias/read/(:num)'] = 'stock_controller/transferencias';
$route['administrador/transferencias/edit/(:num)'] = 'stock_controller/transferencias';
$route['administrador/transferencias/update/(:num)'] = 'stock_controller/transferencias';
$route['administrador/transferencias/update_validation/(:num)'] = 'stock_controller/transferencias';
$route['administrador/transferencias/delete/(:num)'] = 'stock_controller/transferencias';
$route['administrador/transferencias/export'] = 'stock_controller/transferencias';
$route['administrador/transferencias/print'] = 'stock_controller/transferencias';
$route['administrador/transferencias'] = 'stock_controller/transferencias';

/*ORDEN DE COMPRA*/
$route['administrador/orden_compra'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/add'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/insert'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/success/(:num)'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/insert_validation'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/ajax_list_info'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/ajax_list'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/read/(:num)'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/edit/(:num)'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/update/(:num)'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/update_validation/(:num)'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/delete/(:num)'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/export'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/print'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/upload_file/image_tile_url'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/delete_file/image_tile_url/'] = 'compra_controller/orden_compra';
$route['administrador/orden_compra/(:any)'] = 'compra_controller/orden_compra';

/*Factura de Venta*/
$route['administrador/nueva_factura'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/add'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/insert'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/success/(:num)'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/insert_validation'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/ajax_list_info'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/ajax_list'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/read/(:num)'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/edit/(:num)'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/update/(:num)'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/update_validation/(:num)'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/delete/(:num)'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/export'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/print'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/upload_file/image_tile_url'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/delete_file/image_tile_url/'] = 'venta_controller/nueva_factura';
$route['administrador/nueva_factura/(:any)'] = 'venta_controller/nueva_factura';

/*Presupuestos*/
$route['administrador/presupuesto'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/add'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/insert'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/success/(:num)'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/insert_validation'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/ajax_list_info'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/ajax_list'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/read/(:num)'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/edit/(:num)'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/update/(:num)'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/update_validation/(:num)'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/delete/(:num)'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/export'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/print'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/upload_file/image_tile_url'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/delete_file/image_tile_url/'] = 'venta_controller/presupuesto';
$route['administrador/presupuesto/(:any)'] = 'venta_controller/presupuesto';

/*Listado de Presupuestos*/
$route['administrador/listado_presupuesto'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/add'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/insert'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/success/(:num)'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/insert_validation'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/ajax_list_info'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/ajax_list'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/read/(:num)'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/edit/(:num)'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/update/(:num)'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/update_validation/(:num)'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/delete/(:num)'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/export'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/print'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/upload_file/image_tile_url'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/delete_file/image_tile_url/'] = 'venta_controller/listado_presupuesto';
$route['administrador/listado_presupuesto/(:any)'] = 'venta_controller/listado_presupuesto';

/*ABM de Modulos*/
$route['administrador/modulos'] = 'configuration_controller/modulos';
$route['administrador/modulos/add'] = 'configuration_controller/modulos';
$route['administrador/modulos/insert'] = 'configuration_controller/modulos';
$route['administrador/modulos/success/(:num)'] = 'configuration_controller/modulos';
$route['administrador/modulos/insert_validation'] = 'configuration_controller/modulos';
$route['administrador/modulos/ajax_list_info'] = 'configuration_controller/modulos';
$route['administrador/modulos/ajax_list'] = 'configuration_controller/modulos';
$route['administrador/modulos/read/(:num)'] = 'configuration_controller/modulos';
$route['administrador/modulos/edit/(:num)'] = 'configuration_controller/modulos';
$route['administrador/modulos/update/(:num)'] = 'configuration_controller/modulos';
$route['administrador/modulos/update_validation/(:num)'] = 'configuration_controller/modulos';
$route['administrador/modulos/delete/(:num)'] = 'configuration_controller/modulos';
$route['administrador/modulos/export'] = 'configuration_controller/modulos';
$route['administrador/modulos/print'] = 'configuration_controller/modulos';
$route['administrador/modulos/upload_file/image_tile_url'] = 'configuration_controller/modulos';
$route['administrador/modulos/delete_file/image_tile_url/'] = 'configuration_controller/modulos';
$route['administrador/modulos/(:any)'] = 'configuration_controller/modulos';

/*ABM de Menues*/
$route['administrador/menues'] = 'configuration_controller/menues';
$route['administrador/menues/add'] = 'configuration_controller/menues';
$route['administrador/menues/insert'] = 'configuration_controller/menues';
$route['administrador/menues/success/(:num)'] = 'configuration_controller/menues';
$route['administrador/menues/insert_validation'] = 'configuration_controller/menues';
$route['administrador/menues/ajax_list_info'] = 'configuration_controller/menues';
$route['administrador/menues/ajax_list'] = 'configuration_controller/menues';
$route['administrador/menues/read/(:num)'] = 'configuration_controller/menues';
$route['administrador/menues/edit/(:num)'] = 'configuration_controller/menues';
$route['administrador/menues/update/(:num)'] = 'configuration_controller/menues';
$route['administrador/menues/update_validation/(:num)'] = 'configuration_controller/menues';
$route['administrador/menues/delete/(:num)'] = 'configuration_controller/menues';
$route['administrador/menues/export'] = 'configuration_controller/menues';
$route['administrador/menues/print'] = 'configuration_controller/menues';
$route['administrador/menues/upload_file/image_tile_url'] = 'configuration_controller/menues';
$route['administrador/menues/delete_file/image_tile_url/'] = 'configuration_controller/menues';
$route['administrador/menues/(:any)'] = 'configuration_controller/menues';

/*ABM de Permisos*/
$route['administrador/permisos'] = 'configuration_controller/permisos';
$route['administrador/permisos/add'] = 'configuration_controller/permisos';
$route['administrador/permisos/insert'] = 'configuration_controller/permisos';
$route['administrador/permisos/success/(:num)'] = 'configuration_controller/permisos';
$route['administrador/permisos/insert_validation'] = 'configuration_controller/permisos';
$route['administrador/permisos/ajax_list_info'] = 'configuration_controller/permisos';
$route['administrador/permisos/ajax_list'] = 'configuration_controller/permisos';
$route['administrador/permisos/read/(:num)'] = 'configuration_controller/permisos';
$route['administrador/permisos/edit/(:num)'] = 'configuration_controller/permisos';
$route['administrador/permisos/update/(:num)'] = 'configuration_controller/permisos';
$route['administrador/permisos/update_validation/(:num)'] = 'configuration_controller/permisos';
$route['administrador/permisos/delete/(:num)'] = 'configuration_controller/permisos';
$route['administrador/permisos/export'] = 'configuration_controller/permisos';
$route['administrador/permisos/print'] = 'configuration_controller/permisos';
$route['administrador/permisos/upload_file/image_tile_url'] = 'configuration_controller/permisos';
$route['administrador/permisos/delete_file/image_tile_url/'] = 'configuration_controller/permisos';
$route['administrador/permisos/(:any)'] = 'configuration_controller/permisos';

/*ABM Companias de Seguro*/
$route['administrador/abm_companias'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/add'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/insert'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/success/(:num)'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/insert_validation'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/ajax_list_info'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/ajax_list'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/read/(:num)'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/edit/(:num)'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/update/(:num)'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/update_validation/(:num)'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/delete/(:num)'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/export'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/print'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/upload_file/image_tile_url'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/delete_file/image_tile_url/'] = 'compania_controller/abm_companias';
$route['administrador/abm_companias/(:any)'] = 'compania_controller/abm_companias';

/*ABM de Peritos*/
$route['administrador/abm_peritos'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/add'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/insert'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/success/(:num)'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/insert_validation'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/ajax_list_info'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/ajax_list'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/read/(:num)'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/edit/(:num)'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/update/(:num)'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/update_validation/(:num)'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/delete/(:num)'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/export'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/print'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/upload_file/image_tile_url'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/delete_file/image_tile_url/'] = 'compania_controller/abm_peritos';
$route['administrador/abm_peritos/(:any)'] = 'compania_controller/abm_peritos';

/*Listado de Facturas*/
$route['administrador/listado_facturas'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/add'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/insert'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/success/(:num)'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/insert_validation'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/ajax_list_info'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/ajax_list'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/read/(:num)'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/edit/(:num)'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/update/(:num)'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/update_validation/(:num)'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/delete/(:num)'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/export'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/print'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/upload_file/image_tile_url'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/delete_file/image_tile_url/'] = 'venta_controller/listado_facturas';
$route['administrador/listado_facturas/(:any)'] = 'venta_controller/listado_facturas';

/*Numeracion*/
$route['administrador/numeracion'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/add'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/insert'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/success/(:num)'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/insert_validation'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/ajax_list_info'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/ajax_list'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/read/(:num)'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/edit/(:num)'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/update/(:num)'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/update_validation/(:num)'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/delete/(:num)'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/export'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/print'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/upload_file/image_tile_url'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/delete_file/image_tile_url/'] = 'configuration_controller/numeracion';
$route['administrador/numeracion/(:any)'] = 'configuration_controller/numeracion';

/* Filtrar Articulos */
$route['administrador/filtrar_articulos'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/add'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/insert'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/success/(:num)'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/insert_validation'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/ajax_list_info'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/ajax_list'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/read/(:num)'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/edit/(:num)'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/update/(:num)'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/update_validation/(:num)'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/delete/(:num)'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/export'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/print'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/upload_file/image_tile_url'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/delete_file/image_tile_url/'] = 'articulo_controller/filtrar_articulos';
$route['administrador/filtrar_articulos/(:any)'] = 'articulo_controller/filtrar_articulos';


/*ABM Transporte */
$route['administrador/transportes'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/add'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/insert'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/success/(:num)'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/insert_validation'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/ajax_list_info'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/ajax_list'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/read/(:num)'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/edit/(:num)'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/update/(:num)'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/update_validation/(:num)'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/delete/(:num)'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/export'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/print'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/upload_file/image_tile_url'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/delete_file/image_tile_url/'] = 'transporte_controller/abm_transporte';
$route['administrador/transportes/(:any)'] = 'transporte_controller/abm_transporte';

/*Cta Cte */
$route['administrador/ctacte'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/add'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/insert'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/success/(:num)'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/insert_validation'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/ajax_list_info'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/ajax_list'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/read/(:num)'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/edit/(:num)'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/update/(:num)'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/update_validation/(:num)'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/delete/(:num)'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/export'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/print'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/upload_file/image_tile_url'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/delete_file/image_tile_url/'] = 'customer_controller/cta_cte';
$route['administrador/ctacte/(:any)'] = 'customer_controller/cta_cte';

/*Backup database*/
$route['administrador/backup'] = 'configuration_controller/backup_database';
$route['administrador/backup/add'] = 'configuration_controller/backup_database';
$route['administrador/backup/insert'] = 'configuration_controller/backup_database';
$route['administrador/backup/success/(:num)'] = 'configuration_controller/backup_database';
$route['administrador/backup/insert_validation'] = 'configuration_controller/backup_database';
$route['administrador/backup/ajax_list_info'] = 'configuration_controller/backup_database';
$route['administrador/backup/ajax_list'] = 'configuration_controller/backup_database';
$route['administrador/backup/read/(:num)'] = 'configuration_controller/backup_database';
$route['administrador/backup/edit/(:num)'] = 'configuration_controller/backup_database';
$route['administrador/backup/update/(:num)'] = 'configuration_controller/backup_database';
$route['administrador/backup/update_validation/(:num)'] = 'configuration_controller/backup_database';
$route['administrador/backup/delete/(:num)'] = 'configuration_controller/backup_database';
$route['administrador/backup/export'] = 'configuration_controller/backup_database';
$route['administrador/backup/print'] = 'configuration_controller/backup_database';
$route['administrador/backup/upload_file/image_tile_url'] = 'configuration_controller/backup_database';
$route['administrador/backup/delete_file/image_tile_url/'] = 'configuration_controller/backup_database';
$route['administrador/backup/(:any)'] = 'configuration_controller/backup_database';

$route['default_controller'] = "user_manager_controller/login";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */