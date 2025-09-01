<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VtaMovModel;

class CajaController extends Controller{

    public function flujoCaja(){
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/caja/flujocaja');
        }
    }  


    public function flujoCajaAjax(){
        if (session()->has("idUsuario") && session('rol') =='A') {
                 $fd = $_POST['fd'];
                 $idcli = $_POST['idcli'];
                 $tipo = $_POST['tipo'];
                 
                 //$q = "select id_vta, fecha, cliente, tipo_movvta, letra, vta_movimientos.sucursal as suc, num_comprobante, periodo, estado_pago from vta_movimientos inner join vta_tipo_movimientos on tipo_movvta = id  where  tipo_movvta = 1 and fecha >= '$fd'" ;
                 $q = "select * from vta_movimientos vm,  vta_tipo_movimientos vtm where tipo_movvta = id_tipomov  and vm.sucursal = vtm.sucursal
                        and  ubicacion_caja <> 'N' and fecha >= '$fd'" ;
                 
                 if ($idcli > 0){
                      $q = $q . " and id_cliente= $idcli";
                  }              
  
                  if ($tipo != 'T'){
                    $q = $q . " and ubicacion_caja = '$tipo'";
                }              

                  $q = $q . " order by fecha, letra, vm.sucursal, num_comprobante";
                 
                 
                  $MVMov = new VtaMovModel;
                  $r = $MVMov->getMovimientos($q);
                  if ($r){
                      echo json_encode($r);
                  }
              }
              else{
                  return redirect()->to(site_url());  
              }
              }
  



}