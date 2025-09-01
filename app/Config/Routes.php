<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Inicio');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */





// Inicio y Login

$routes->get('/', 'Inicio::index');
$routes->get('/InicioIntra', 'Inicio::InicioIntra');
$routes->post('Login', 'Inicio::Login'); //recibe los datos del formulario del login y lo pasa al controlador 
$routes->get('/Login/CerrarSesion', 'Inicio::CerrarSesion'); //Cierra Sesion 
$routes->post('/InicioMsj', 'Inicio::BuscaMensajesAjax'); //busca los mensajes y los manda por ajax
$routes->post('/CambiaContraseña', 'Inicio::cambiaContraseña'); //busca los mensajes y los manda por ajax
$routes->get('/Tutoriales', 'Inicio::tutoriales'); //Cierra Sesion 
$routes->post('datosChartAjax', 'Inicio::datosChartAjax');
$routes->post('datosChartAjax2', 'Inicio::datosChartAjax2');
$routes->post('datosChartAjax3', 'Inicio::datosChartAjax3');

$routes->post('datosChartAjaxAdmin', 'Inicio::datosChartAjaxAdmin');

//liquidaciones Prof
$routes->get('/Liquidaciones', 'LiquidacionesController::Index'); //Inicio liquidaciones 
$routes->post('/MostrarLiq', 'LiquidacionesController::Buscar'); //Muestra liquidaciones 
$routes->get('/BuscarItems/(:any)', 'LiquidacionesController::buscarItemsLiq/$1'); //Busca Items de cada  liquidaciones 
$routes->post('/AgregarLiq', 'LiquidacionesController::Agregar'); //Muestra liquidaciones 
$routes->get('/BorrarLiq/(:any)', 'LiquidacionesController::borrarLiq/$1'); //Borrar liquidaciones 
$routes->post('/AgregaItemLiq', 'LiquidacionesController::AgregaItemLiq'); //Agrega los items en una liquidaciones 
$routes->post('/ActualizaLiq', 'LiquidacionesController::ActualizaLiq'); //Modifica los totales de la liquidacion 
$routes->post('EnviarLiq', 'LiquidacionesController::enviarLiq'); //Enviar liquidaciones 
$routes->get('FacturarLiq/(:any)/(:any)', 'FacturacionController::facturarLiq/$1/$2'); //Facturar liquidaciones 
$routes->get('/ReporteLiq/(:any)', 'LiquidacionesController::reporteLiq/$1'); //imprime reporte liquidaciones


//liquidaciones Admin
$routes->get('/LiquidacionesA', 'LiquidacionesController::IndexA'); //Inicio liquidaciones 
$routes->post('MostrarLiqA', 'LiquidacionesController::BuscarA'); //Muestra liquidaciones 
$routes->get('/BuscarItemsA/(:any)', 'LiquidacionesController::buscarItemsLiqA/$1'); //Busca Items de cada  liquidaciones 
$routes->post('DevolverLiq', 'LiquidacionesController::devolverLiq'); //Devuelve una liquidacion al profesional  
$routes->post('RevisarLiq', 'LiquidacionesController::revisarLiq'); //Actualiza aranceles de las liquidaciones  
$routes->post('DetalleLiqAjax', 'LiquidacionesController::detalleLiqAjax'); //Muestra detalle de comprobante 
$routes->post('/InsertarAjusteLiq', 'LiquidacionesController::InsertarAjusteLiq'); //Ajuste liquidaciones antes de facturar 
$routes->post('HistoriaLiqAjax', 'LiquidacionesController::historiaLiqAjax'); //Muestra detalle de comprobante 
$routes->get('ResumenLiqA', 'LiquidacionesController::resumenLiqA'); //resumen de liquidaciones 
$routes->post('ResumenLiqAjax', 'LiquidacionesController::resumenLiqAjax'); //Muestra detalle de comprobante 



//Ventas Admin
$routes->post('EmitirFacturaLiq', 'FacturacionController::EmitirFacturaLiq'); //Graba factura de liquidaciones 
$routes->get('EstadoCuentaClientes', 'VentasController::estadoCuentaClientes'); //Estado de cuenta clientes 
$routes->post('/SaldoCliAjax', 'VentasController::saldoCliAjax'); //Saldo de un cliente a una fecha  
$routes->post('/MovCliAjax', 'VentasController::movCliAjax'); //listado de los movimientos de un prof
$routes->post('/BorrarComp', 'VentasController::borrarComp'); //Borra comprobante con id por ajax
$routes->get('/EstadoCuentaA', 'VentasController::estadoCuentaA'); //Estado cuenta  

$routes->post('/SaldoProfOsAjaxA', 'VentasController::saldoProfOsAjaxA'); //Saldo  cuenta  
$routes->post('/MovProfOsAjaxA', 'VentasController::movProfOsAjaxA'); //listado de los movimientos de un prof
$routes->get('/FlujoPrestadoresPercapita', 'VentasController::flujoPrestadoresPercapita'); //saldo facturacion-liquidacion percapita 
$routes->get('ReportePercapita/(:any)/(:any)', 'VentasController::reportePercapita/$1/$2'); //imprime reporte cuneta percapita
$routes->post('/MovCliPercapitaAjax', 'VentasController::movCliPercapitaAjax'); //listado de los movimientos de un prof



//Ciro
$routes->get('/VerComprobantes', 'VentasController::verComprobantes'); //saldo facturacion-liquidacion percapita 
$routes->post('/VerComprobantesAjax', 'VentasController::verComprobantesAjax'); //listado de los movimientos de un prof
$routes->get('/VerResumenOp', 'VentasController::verResumenOp'); //Resumen de operacones por profesional 
$routes->post('/ResumenOpAjax', 'VentasController::resumenOpAjax'); //listado de los recibos ordenados por profesional
$routes->get('verComprobante/(:any)', 'FacturacionController::verComprobante/$1'); //Gestor de Facturas (ver, borrar y cambios menores)
$routes->post('/CuadroLiqMensualAjax', 'VentasController::cuadroLiqMensualAjax'); //consulta para el cuadro de liquidaciones mensuales resumen 



//Ventas Prof
$routes->get('/EstadoCuentaP', 'VentasController::estadoCuentaP'); //Estado cuenta  
$routes->post('/SaldoProfOsAjax', 'VentasController::saldoProfOsAjax'); //Saldo  cuenta  
$routes->post('/MovProfOsAjax', 'VentasController::movProfOsAjax'); //listado de los movimientos de un prof
$routes->post('DetalleVtaAjax', 'VentasController::detalleVtaAjax'); //Muestra detalle de comprobante 



//Caja
$routes->get('/FlujoCaja', 'CajaController::flujoCaja'); //Flujo Caja  
$routes->post('FlujoCajaAjax', 'CajaController::flujoCajaAjax'); //Lista flujo caja 




//Mensajes
$routes->get('/MsjActuPrecios/(:any)/(:any)', 'MensajesController::MsjActuPrecios/$1/$2'); //Mensaje actualizacion de precios 

//OS Admin
$routes->get('/AdminOS', 'OsController::Index'); //Inicia OS 
$routes->post('/MostrarOS', 'OsController::getOs'); //Muestra OS 
    //crud 
    $routes->get('/OsAgregar', 'OsController::agregarOs'); //Formulario agregar 
    $routes->post('/OsGuardar/(:any)', 'OsController::guardarOs/$1'); //I insert U Update
    $routes->get('/OsModif/(:any)', 'OsController::modifOs/$1'); //Formulario modificar 
    $routes->get('/OsBorrar/(:any)', 'OsController::borrarOs/$1'); //Formulario borrar 
    $routes->get('/OsActuXls', 'OsController::ActuXls'); //Actu precios desde xls
    $routes->post('OsProcesaXls', 'OsController::ProcesaXls'); //Sube el archivo y lo procesa 


    //Items Os
    $routes->get('/BuscarItemsOs/(:any)', 'OsController::buscarItemsOs/$1'); //Busca Items para cada OS 
    $routes->post('/actualizaPrecios', 'OsController::actualizaPrecios'); //Actualizar precios de items en OS
    $routes->post('/BorrarItemOs', 'OsController::borrarItemOs'); //Borra un item de la OS 
    $routes->get('/OsAgregarItemOs/(:any)', 'OsController::OsAgregarItemOs/$1'); //Carga vista para agregar items a la obra social 
    $routes->post('/agregaItemOs', 'OsController::AgregaItemOs'); //recibe datos y manda a agregar items a os  
    $routes->get('/BuscarOsItems/(:any)', 'OsController::buscarOsItems/$1'); //Busca las Os que cubren un item 
     

    
//OS prof
$routes->get('/AdminOSP', 'OsController::IndexP'); //Inicia OS 
$routes->post('/MostrarOSP', 'OsController::getOs'); //Muestra OS
$routes->get('/Mostrarpdf/(:any)', 'OsController::MostrarPdf/$1'); //Muestra Pdf de normas de trabajo

    //Items OS Prof
     //Items Os
     $routes->get('BuscarItemsOsP/(:any)', 'OsController::buscarItemsOs/$1'); //Busca Items para cada OS 
     $routes->post('MostrarItemOsAjaxP', 'OsController::getItemOsAjax'); //
     $routes->get('BuscarOsItemsP/(:any)', 'OsController::buscarOsItems/$1'); //Busca las Os que cubren un item 
     $routes->get('ReporteItemsOs/(:any)', 'OsController::reporteItemsOs/$1'); //imprime reporte item os


     

//Minimos Admin
$routes->get('/Minimos', 'MinimosController::Index'); //Inicia Minimos 
$routes->post('/MostrarMin', 'MinimosController::getMin'); //Muestra Items 
$routes->get('/MinActuXls', 'MinimosController::ActuXls'); //Inicia Minimos
$routes->post('/ProcesaXls', 'MinimosController::ProcesaXls'); //Sube el archivo y lo procesa 
$routes->get('/MinModif/(:any)', 'MinimosController::modifMin/$1'); //Formulario modificar 
$routes->get('/MinBorrar/(:any)', 'MinimosController::borrarMin/$1'); //Formulario Borrar 
$routes->post('/MinGuardar/(:any)', 'MinimosController::guardarMin/$1'); //I insert U Update
    
    
//Minimos Prof
$routes->get('/MinimosP', 'MinimosController::IndexP'); //Inicia Minimos Profe 
$routes->post('/MostrarMinP', 'MinimosController::getMin'); //Se usa el mismo que Admin 
$routes->get('/ReporteMin', 'MinimosController::reporteMin2'); //imprime reporte



//selects
$routes->get('/selectProfesionales', 'ProfesionalesController::getProfesionales()'); //Inicio liquidaciones 


//retenciones mensuales Admin
$routes->get('/RetencionesMes', 'RetencionesMes::Index'); //Inicia Retenciones Mes 
$routes->post('/ActualizaRetMes', 'RetencionesMes::actualizaRetMes'); //Actualiza Valores para las retenciones  
$routes->get('/RetMesProf', 'RetencionesMes::retMesProf'); //Asignar retencioenes a profesionales 
$routes->post('/ActualizaRetMesProf', 'RetencionesMes::actualizaRetMesProf'); //Actualiza cantidad de retenciones para cada profesional  
$routes->post('/LiquidarRetMes', 'RetencionesMes::liquidarRetMes'); //Realiza la liquidacion de las retenciones mensuales  
$routes->get('/RetencionesManuales', 'RetencionesMes::liquidarRetManual'); //Agrega modifica retencioens a mano  
$routes->post('/RetManualItemsAjax', 'RetencionesMes::retManualItemsAjax'); //busca las retenciones liquidadas a un profesional en un periodo  
$routes->post('/RetManualNuevaAjax', 'RetencionesMes::retManualNuevaAjax'); //carga los items del profesional para la retencion  
$routes->post('/ActualizaRetManual', 'RetencionesMes::actualizaRetManual'); //recibe los datos y hace el update  
$routes->post('/RetencionesSPAjax', 'RetencionesMes::RetencionesSPAjax'); //retenciones sin pagar  




//Pagos Admin
$routes->get('/Pagos', 'PagosController::Index'); //Inicia Pagos 
$routes->post('/ListaFactAjax', 'PagosController::listaFactAjax'); //Muestra Totas las Facturas a partir de una fecha  
$routes->get('/PagoFact/(:any)', 'PagosController::armaReciboFactura/$1'); //Inicia Pagos 
$routes->post('EmitirNcNdRbo', 'FacturacionController::EmitirNcNdRbo'); //Graba Nc o Nd emitida por recibos 
$routes->post('EmitirRbo', 'PagosController::EmitirRbo'); //Graba recibo 
$routes->post('EmitirNcBonos', 'FacturacionController::EmitirNcBonos'); //Graba Nc Interna(301) por bonos  


//transferencias
$routes->get('/Transferencias', 'TransferenciasController::transferencias'); //Flujo Caja  
$routes->get('ArmarTransferencia/(:any)/(:any)/(:any)', 'TransferenciasController::armarTransf/$1/$2/$3'); //Arma la trasnferencia 
$routes->post('ComprobantesSTAjax', 'TransferenciasController::ComprobantesSTAjax'); //trae la Lista comprobantes sin trasnferir a prof
$routes->post('TransferirAjax', 'TransferenciasController::EmitirTransferencia'); //Graba la trasnferencia 



//Informes Admin - Liquidacion Mensual
$routes->get('LiquidacionMensualA', 'InformesController::liquidacionMensualA'); //Liquidacion mensual por periodo y profesional  
$routes->post('LiqMensualAjax', 'InformesController::liqMensualAjax'); //Datos de los recibos del periodo
$routes->get('ReporteLiqMen/(:any)/(:any)/(:any)', 'InformesController::reporteLiqMen/$1/$2/$3'); //imprime reporte Liqudacion Mensual
$routes->post('RetProfMesAjax', 'VentasController::RetProfMesAjax'); //Datos de las retenciones del periodo 
$routes->get('CuadroLiqMensualA', 'InformesController::cuadroLiqMensualA'); //Liquidacion mensual por periodo y profesional  
$routes->post('RetDetProfMesAjax', 'VentasController::RetDetProfMesAjax'); //Detalle de las retenciones del periodo 



//informes prof
$routes->get('LiquidacionMensualP', 'InformesController::liquidacionMensualP'); //Liquidacion mensual del profesional
$routes->get('ReporteLiqMenP/(:any)/(:any)', 'InformesController::reporteLiqMen/$1/$2'); //imprime reporte Liqudacion Mensual(no manda profesional)


//Pacientes
$routes->get('/PacientesP', 'PacientesController::IndexP'); //Inicia Pacientes 
$routes->post('BuscaPacienteAx', 'PacientesController::consultarDNIAjax'); //Busca Paciente por dni 


//Odontograma
$routes->get('/OdontogramaP', 'OdontogramaController::Index'); //Inicia Odontograma 


//Atenciones
$routes->post('MostrarAtencionesAxP', 'AtencionesController::MostrarAtencionesAjax');  
$routes->post('BorrarAtencionesAxP', 'AtencionesController::BorrarAtencionesAjax');
$routes->post('AgregarAtencionesAxP', 'AtencionesController::AgregarAtencionesAjax');  



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
