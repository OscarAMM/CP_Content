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


$route['test'] = 'test';

$route['inicio'] = 'inicio/portada';
$route['salir'] = 'inicio/salir';
$route['solicitudes'] = 'solicitudes';
$route['bienes'] = 'solicitudes/bienes/index';
$route['verificacion_bienes'] = "verificacion_bienes";
$route['alta'] = 'solicitud_alta';
$route['solicitud_baja/(:any)'] = 'solicitud_baja/solicitud_baja/index/$1';
$route['solicitud_traspaso/(:any)'] = 'solicitud_traspaso/index/$1';
$route['solicitud_correccion/(:any)'] = 'solicitud_correccion/index/$1';
$route['enlistarCts/(:any)'] = 'solicitud_traspaso/lista_ct/$1';

$route['obtenerAnexos/(:num)'] = 'solicitud_baja/anexos_solicitud/$1';
$route['obtenerAnexos2/(:num)'] = 'solicitud_baja/anexos_solicitud2/$1';
$route['eliminarAnexo'] = 'solicitud_baja/eliminar_anexo';

$route['cargar_bienes_cct'] = 'solicitud_baja/solicitud_baja/cargarBienesCct';
//Nueva ruta 2019
$route['cargar_bienes_cct_extravio'] = 'solicitud_baja/solicitud_baja/filtroExtravio';
//FIN NUEVA RUTA
$route['cargar_elementos_solicitud'] = 'solicitud_baja/solicitud_baja/cargarElementosSolicitud';
$route['cargar_elementos_solicitud_correccion'] = 'solicitud_correccion/solicitud_correccion/cargarElementosSolicitud';
$route['ajax/detalles_incluir_bienes'] = 'solicitud_baja/solicitud_baja/cargarDetalleIncluirBienes';
$route['ajax/detalles_incluir_bienes_traspaso'] = 'solicitud_traspaso/solicitud_traspaso/cargarDetalleIncluirBienes';
$route['ajax/detalles_incluir_bienes_correccion'] = 'solicitud_correccion/solicitud_correccion/cargarDetalleIncluirBienes';
$route['ajax/guardar_incluir_bienes'] = 'solicitud_baja/solicitud_baja/guardarBajaBienes';
$route['guardar_baja_bienes'] = 'solicitud_baja/baja_bienes';
$route['guardar_baja_bienes_traspaso'] = 'solicitud_traspaso/baja_bienes';
$route['guardar_baja_bienes_traspaso_dir'] = 'solicitud_traspaso/traspaso_bienes';

$route['guardar_baja_bienes_correccion'] = 'solicitud_correccion/baja_bienes';
$route['eliminarBienesSolicitud'] = 'solicitud_baja/eliminar_Bienes_Solicitud';
$route['baja_bien_guardar'] = "solicitud_baja/agregar_bienes_baja";
$route['ReporteControlPatrimonial'] = "solicitud_baja/ReporteControlPatrimonial";
$route['ReporteControlPatrimonialNoVerificados'] = "solicitud_baja/ReporteControlPatrimonialNoVerificados";
$route['ReporteBienesVerificacion'] = "solicitud_baja/ReporteBienesVerificacion";
$route['ReporteBienesVerificacion2'] = "solicitud_baja/ReporteBienesVerificacion";
$route['descargar_reporte/(:any)'] = "solicitud_baja/d_re/$1";
$route['descargar_reporte_eliminar/(:any)'] = "solicitud_baja/eliminar_archivo/$1";

$route['obtenerCamposCorrecciones'] = 'solicitud_correccion/getCamposCorreccion';
$route['obtenerValoresCorrecciones'] = 'solicitud_correccion/getValoresCorreccion';

$route['traspaso_guardar_ct_recibe'] = 'solicitud_traspaso/guardarCtrecibe';

$route['testGrid'] = 'test/testGrid';
$route['ajax/cargar_datos'] = 'test/test_cargar_datos';
$route['solicitudes/ajax'] = 'solicitudes/ajax';
$route['solicitudespdf/eliminarpdf'] = 'solicitudes/solicitudespdf/eliminarpdf';
$route['solicitudespdf/generarpdf'] = 'solicitudes/solicitudespdf/generarpdf';
$route['solicitudespdf/generarActa'] = 'solicitudes/solicitudespdf/generarActa';
$route['solicitudespdf/generarRecoleccion'] = 'solicitudes/solicitudespdf/generarRecoleccion';
$route['solicitudespdf/anexospdf']  = 'solicitudes/solicitudespdf/veranexos';
$route['solicitudespdf/generarZip/(:num)/(:any)'] = 'solicitudes/solicitudespdf/generarZip/$1/$2';
$route['solicitudes/eliminar_Solicitud'] = 'solicitudes/eliminar_Solicitud';


$route['alta_bien_guardar'] = "solicitud_alta/agregar_bienes";
$route['alta_anexo_guardar'] = 'solicitud_alta/agregar_anexos';
$route['safb_listaAnexosSol'] = 'solicitud_alta/listar_anexos_solicitud';
$route['safb_agregaAnexoBien'] = 'solicitud_alta/agregar_anexos_lista';
$route['safb_updBienes'] = 'solicitud_alta/modificar_bienes';
$route['safb_delBienes'] = 'solicitud_alta/eliminar_bienes';
$route['safb_frmBienes'] = 'solicitud_alta/get_frm_bienes';
$route['safa_frmAnexos'] = 'solicitud_alta/abre_vista_frmAnexos';
$route['safb_refreshlistresp'] = 'solicitud_alta/get_html_reponsables';
$route['safb_obcmbrecb'] = 'solicitud_alta/get_cmbval_recursos';
$route['ajax/alta_cargar_bienes'] = 'solicitud_alta/cargar_bienes';
$route['solicitud_alta/(:any)'] = "solicitud_alta/solicitud_alta/index/$1";
$route['safb_frmprov'] = 'solicitud_alta/abre_vista_frmProveedor';
$route['safb_addProv'] = 'solicitud_alta/agregar_proveedor';
$route['safb_listart'] = 'solicitud_alta/get_listado_articulos';
$route['alta_edittelsol'] = 'solicitud_alta/editar_solicitud';
$route['baja_edittelsol'] = 'solicitud_baja/editar_telefono_solicitud';
$route['baja_editcorreosol'] = 'solicitud_baja/editar_telefono_solicitud';
$route['alta_delAnexo'] = 'solicitud_alta/eliminar_anexo';
$route['solicitudes'] = 'solicitudes';
$route['solicitudes/ajax'] = 'solicitudes/ajax';
$route['viewpdf/(:any)'] = 'solicitudes/verpdf/$1';
$route['solicitudes/validarsolicitud'] = 'solicitudes/validarsolicitud';
$route['solicitudes/RevisarSolicitud'] = 'solicitudes/revisarSolicitudDirNivel';

$route['guardarActas'] = "solicitud_baja/guardarActa";

$route['solicitudescp'] = 'solicitudes/index_administrador';
$route['solicitudesdir'] = 'solicitudes/index_nivel';
$route['ajax/cargarsol2'] = 'solicitudes/ajax2';
$route['ajax/mvflistar'] = 'verificacion_bienes/listar_bienes_ct';
$route['ajax/mvbguardar'] = 'verificacion_bienes/guardar';
$route['ajax/mvbterminar'] = 'verificacion_bienes/terminar';
$route['ajax/mvfrmresp'] = 'verificacion_bienes/vista_frm_responsables';
$route['ajax/anexosSolicitudes'] = 'solicitudes/listaAnexosSolicitudes';
$route['ajax/bienesSolicitudAdmin'] = 'solicitud_alta/listaBienesSolicitudes';
$route['ajax/anexarEvidencia'] = 'solicitudes/solicitudAnexarEvidencia';
$route['ajax/eliminarEvidencia'] = 'solicitudes/eliminarAnexoEvidencia';
//GAC
$route['enlistarMM/(:any)'] = 'solicitudes/lista_MM/$1';

$route['catalogoscp'] = 'catalogos';
$route['listadocatalogos'] = 'catalogos/catalogos/listado';
$route['Catalogo/(:any)/(:num)'] = 'catalogos/catalogos/catalogo/$1/$2';
/******************NUEVA RUTA 2019 ********* */
$route['SerieSearch']= 'catalogos/execute_search' ;

//ADMIN GESTION USUARIOS 
$route['usuarios_perfiles'] = 'gestion_usuarios/gestion_usuarios/adminPerfiles';
$route['admin_usuarios'] = 'gestion_usuarios/gestion_usuarios/adminUsuarios';
$route['admin_perfiles'] = 'gestion_usuarios/gestion_usuarios/adminPerfiles';
$route['ajax/cargarPerfil'] = 'gestion_usuarios/gestion_usuarios/adminCargarPerfil';
$route['ajax/guardarPerfilCambios'] = 'gestion_usuarios/gestion_usuarios/guardarPerfil';
$route['ajax/obtenerUsuariosCp'] = 'gestion_usuarios/gestion_usuarios/cargarUsuarios';
$route['ajax/gestionUsuarioCp'] = 'gestion_usuarios/gestion_usuarios/gestionUsuario';
$route['ajax/gestionModalidades'] = 'gestion_usuarios/gestion_usuarios/gestionModalidades';
$route['ajax/gestionModalidadesGuardar'] = 'gestion_usuarios/gestion_usuarios/gestionModalidadesGuardar';

$route['ajax/guardarUsuarioCp'] = 'gestion_usuarios/gestion_usuarios/guardarUsuarioCp/nuevo';
$route['ajax/editarUsuarioCp'] = 'gestion_usuarios/gestion_usuarios/guardarUsuarioCp/editar';

$route['listaCT'] = 'catalogos/listaCentrosTrabajo';
$route['documentos_descargables'] = 'catalogos/DocumentosDescargables';
$route['preguntas_frecuentes'] = 'catalogos/FAQ';
$route['GuardarArchivoDescargable'] = 'catalogos/GuardarArchivoDescargable';
$route['Archivos_Descargables'] = 'catalogos/Archivos_Descargables';
$route['eliminarArchivoDescargable'] = 'catalogos/eliminar_Archivo';
$route['bienes_adm'] = 'catalogos/bienes_administrador';
$route['vistaHTML'] = 'catalogos/vistaHTML';
$route['plantilla_ALTA'] = 'catalogos/plantilla_ALTAPERSONAL';

$route['GuardarArchivoTutorial'] = 'catalogos/GuardarArchivoTutorial';
$route['Archivos_Tutoriales'] = 'catalogos/Archivos_Tutoriales';
$route['obtenerAnexosBien'] = 'catalogos/getAnexosBien';
$route['obtenerAnexosBien2'] = 'catalogos/getAnexosBien2';
$route['eliminarArchivoTutoriales'] = 'catalogos/eliminar_Tutorial';
$route['tutoriales'] = 'catalogos/tutorialesVista';
$route['prueba_pdf'] = 'solicitud_baja/reporteFPDF';
//*************************RUTA CALENDARIO**************************** */
$route['calendar'] = 'calendario';
$route['vista_calendario'] = 'calendario/index';
$route['calendario_agregar'] = 'calendario/save';
$route['calendario_eventos'] = 'calendario/list_all';
$route['eliminar'] = 'calendario/delete_data';

/******************************************************************** */
/******* RUTA PRUEBA ******** ******************************/
$route['vista_anexo_prueba'] = 'solicitud_alta/abrir_view_anexo_vista';
/*****************FIN RUTA PRUEBA************************** */
$route['(:any)'] = 'inicio/login';
$route['default_controller'] = "inicio/login";
$route['404_override'] = '';
/* End of file routes.php */
/* Location: ./application/config/routes.php */