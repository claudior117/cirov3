<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProfMovModel;
use App\Models\VtaMovModel;
use App\Models\VtaMovDetalleModel;
use App\Models\LiquidacionesModel;

class VentasController extends Controller{

    public function estadoCuentaP(){
        if (session()->has("idUsuario") && session('rol')=='P') {
            return view('prof/cuenta/index');
        }
    }  
    

    public function estadoCuentaA(){
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/cuentaprof/index');
        }
    } 
    

    public function verComprobantes(){
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/comprobantes/vercomprobantes');
        }
    } 
    
    public function verResumenOp(){
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/comprobantes/resumenop');
        }
    } 
    


    public function borrarComp(){
        if (session()->has("idUsuario") && session('rol')=='A') {
            $idvta = $_POST['idvta'];
            //elimino detalles de comp
            $MVMDet = new VtaMovDetalleModel;
            $r = $MVMDet ->borrarItemsComp($idvta);

            //busco comprobante de la cuenta del profesional
            $MMProf = new ProfMovModel;
            $q="select * from prof_movimientos where id_mov_vta = $idvta";
            $r2 = $MMProf ->getMovimientos($q);
            foreach($r2 as  $valores) {
                //actualizo liquidacion a E (enviada si es comp venta es factura)
                $data = ["estado" => 'E'];
                $MLiq = new LiquidacionesModel;
                $r3 = $MLiq -> update($valores['id_liquidacion'], $data);

                //borro el moviento de profesional
                $r4 = $MMProf -> delete($valores['id_mov']);
            }    

            //borrar el comprobante
            $MVMov = new VtaMovModel;
            $r = $MVMov->delete($idvta); 
            if($r){
                echo(1);
            }else
            {
                echo(0);
            }

        }
    }    


    public function getTipoMov($sucursal, $tipomov){
        if (session()->has("idUsuario") && session('rol')=='A') {
            $MTMov = new VtaTipoMovModel;
            $r = $MTMov->getTipoMov($sucursal, $tipomov); //busca todas la Os que tienen un item
            $datos = ["arregloItems"=>$r]; 
            return $datos;
        }
    }    

    public function saldoProfOsAjax(){
        if (session()->has("idUsuario") && session('rol') =='P') {
           $q = $_POST['q'];
           $q = $q . " and id_profesional = " . session('idUsuario');
          
           
            $MPMov = new ProfMovModel;
            $r = $MPMov->getSaldo($q);
            if ($r){
                echo json_encode($r);
            }
        }
        else{
            return redirect()->to(site_url());  
        }
        }

        public function saldoProfOsAjaxA(){
            if (session()->has("idUsuario") && session('rol') =='A') {
               $q = $_POST['q'];
               $MPMov = new ProfMovModel;
               $r = $MPMov->getSaldo($q);
               if ($r){
                    echo json_encode($r);
                }
            }
            else{
                return redirect()->to(site_url());  
            }
            }

    public function movProfOsAjax(){
      if (session()->has("idUsuario") && session('rol') =='P') {
               $fd = $_POST['fd'];
               $idos = $_POST['idos'];
               $idcli = $_POST['idcli'];
               $q = "select importe, tipo, id_mov_vta, vm.estado, pm.fecha, detalle, origen, destino, id_liquidacion, ubicacionP from prof_movimientos pm, vta_movimientos vm where id_mov_vta = id_vta and  pm.fecha >= '$fd'  and id_profesional = " . session('idUsuario');
                if ($idos > 0){
                    $q = $q . " and pm.id_os= $idos";
                }              

                if ($idcli > 0){
                    $q = $q . " and id_clientep= $idcli";
                }              

                $q = $q . " order by pm.fecha, pm.periodo, pm.id_liquidacion";
               
                $MPMov = new ProfMovModel;
                $r = $MPMov->getMovimientos($q);
                if ($r){
                    echo json_encode($r);
                }
            }
            else{
                return redirect()->to(site_url());  
            }
    }


    public function movProfOsAjaxA(){
        if (session()->has("idUsuario") && session('rol') =='A') {
                 $fd = $_POST['fd'];
                 $idos = $_POST['idos'];
                 $idprof = $_POST['idprof'];
                 $idcli = $_POST['idcli'];
                 
                    $q = "select * from prof_movimientos  where fecha >= '$fd' ";
                    
                 if ($idos > 0){
                      $q = $q . " and id_os= $idos";
                  }              
  
                  if ($idcli > 0){
                    $q = $q . " and id_clientep = $idcli";
                }              

                  if ($idprof > 0){
                    $q = $q . " and id_profesional = $idprof ";
                }              

                  $q = $q . " order by fecha, periodo, id_liquidacion";
                 
                  $MPMov = new ProfMovModel;
                  $r = $MPMov->getMovimientos($q);
                  if ($r){
                      echo json_encode($r);
                  }
              }
              else{
                  return redirect()->to(site_url());  
              }
              }
  

            public function estadoCuentaClientes(){
                if (session()->has("idUsuario") && session('rol')=='A') {
                    return view('admin/factura/cuentaClientes');
                }
            }
            
            
            public function saldoCliAjax(){
                if (session()->has("idUsuario") && session('rol') =='A') {
                   $q = $_POST['q'];
                                      
                    $MVMov = new VtaMovModel;
                    $r = $MVMov->getSaldo($q);
                    if ($r){
                        echo json_encode($r);
                    }
                }
                else{
                    return redirect()->to(site_url());  
                }
                }

                public function movCliAjax(){
                    if (session()->has("idUsuario") && session('rol') =='A') {
                             $fd = $_POST['fd'];
                             $idcli = $_POST['idcli'];
                             $q = "select * from vta_movimientos,  vta_tipo_movimientos where  tipo_movvta = id_tipomov  and vta_movimientos.sucursal = vta_tipo_movimientos.sucursal and  fecha >= '$fd' and ubicacion_ctacte <> 'N'" ;
                              if ($idcli > 0){
                                  $q = $q . " and id_cliente= $idcli";
                              }              
              
                              $q = $q . " order by fecha, tipo_movvta, letra, vta_movimientos.sucursal, num_comprobante";
                             
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
              

                          public function verComprobantesAjax(){
                            if (session()->has("idUsuario") && session('rol') =='A') {
                                     $fd = $_POST['fd'];
                                     $fh = $_POST['fh'];
                                     $idcli = $_POST['idcli'];
                                     $tipo = $_POST['tipo'];
                                     $q = "select * from vta_movimientos,  vta_tipo_movimientos where  tipo_movvta = id_tipomov  and vta_movimientos.sucursal = vta_tipo_movimientos.sucursal and fecha >= '$fd' and fecha <= '$fh' " ;
                                      if ($idcli > 0){
                                          $q = $q . " and id_cliente= $idcli";
                                      }
                                      
                                      switch ($tipo){
                                        case 'T':
                                            $tipo = "";
                                            break;
                                        case 'FDC':
                                             $tipo = " and  tipo_movvta <= 30";
                                             break;
                                        default:           
                                            $tipo = " and tipo_movvta = " . $tipo;   

                                      }

                      
                                      $q = $q . $tipo . " order by fecha, tipo_movvta, letra, vta_movimientos.sucursal, num_comprobante";
                                     
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
                      
        
                                  public function resumenOpAjax(){
                                    if (session()->has("idUsuario") && session('rol') =='A') {
                                             $fd = $_POST['fd'];
                                             $fh = $_POST['fh'];
                                             $idcli = $_POST['idcli'];
                                             $estado = $_POST['estado'];
                                             $q = "select nombre, liq.id_usuario as idusuarioliq, cliente, sucursal, num_comprobante, id_liq, factura, liq.importe as liqimporte, descuento, incremento, bonos_anticipos, vmd.importe as detimporte, liq.estado as liqtransferida, fecha_rbo, fecha_transf from vta_movimientos vm, vta_movimientos_detalle vmd, liquidaciones liq, usuarios where  vm.id_vta = vmd.id_vta and id_liquidacion = id_liq and  usuarios.id_usuario = liq.id_usuario and vm.fecha >= '$fd' and vm.fecha <= '$fh'  and tipo_movvta = 50 " ;
                                             if ($idcli > 0){
                                                  $q = $q . " and vm.id_cliente= $idcli";
                                              }
                                             
                                              if ($estado != 'T' ){
                                               if ($estado == 'P'){ 
                                                    $q = $q . " and liq.estado ='P'";
                                               }else
                                               {
                                                    $q = $q . " and liq.estado <>'P'";
                                               } 
                                            }
                                           

                                              $q = $q . " order by liq.id_usuario, vm.fecha";
                                             
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
                              
                




                          public function movCliPercapitaAjax(){
                            if (session()->has("idUsuario") && session('rol') =='A') {
                                     $fd = $_POST['fd'];
                                     $idcli = $_POST['idcli'];
                                     $q = "select * from vta_movimientos,  vta_tipo_movimientos where  tipo_movvta = id_tipomov  and vta_movimientos.sucursal = vta_tipo_movimientos.sucursal and  fecha >= '$fd' and percapita = 'S'" ;
                                      if ($idcli > 0){
                                          $q = $q . " and id_cliente= $idcli";
                                      }              
                      
                                      $q = $q . " order by fecha, tipo_movvta, letra, vta_movimientos.sucursal, num_comprobante";
                                     
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
                      


                public function detalleVtaAjax(){
                            if (session()->has("idUsuario")) {
                                $idvta = $_POST['idvta'];
                                $MVDet = new VtaMovDetalleModel;
                                $r = $MVDet->buscarPorId2($idvta);
                                if ($r){
                                   
                                    echo json_encode($r);
                                }
                            }
                            else{
                                return redirect()->to(site_url());  
                            }
                }
                    
                        

        public function flujoPrestadoresPercapita(){
            if (session()->has("idUsuario") && session('rol')=='A') {
                return view('admin/percapita/index');
            }
        }  


        public function RetProfMesAjax(){
            if (session()->has("idUsuario")) {
                     $p = $_POST['p'];

                     if(isset($_POST['idprof']) && session('rol') =='A'){
                        $idprof = $_POST['idprof'];
                     }
                     else{
                        $idprof = session('idUsuario');    
                     }
                      $MVMov = new VtaMovModel;
                      $r = $MVMov->getRetAjax($idprof, $p);
                      if ($r){
                          echo json_encode($r);
                      }
    
                  }
                  else{
                      return redirect()->to(site_url());  
                  }
        }
     

//transferencias a rpofesionales


public function reportePercapita($fd, $idcli){
    if (session()->has("idUsuario") && session('rol')=='A') {   
    
        $q = "select * from vta_movimientos,  vta_tipo_movimientos where  tipo_movvta = id_tipomov  and vta_movimientos.sucursal = vta_tipo_movimientos.sucursal and  fecha >= '$fd' and percapita = 'S'" ;
        if ($idcli > 0){
            $q = $q . " and id_cliente= $idcli";
        }              
        $q = $q . " order by fecha, tipo_movvta, letra, vta_movimientos.sucursal, num_comprobante";
                                    
        $MVMov = new VtaMovModel;
        $r = $MVMov->getMovimientos($q);
        $data = ["arregloMov"=>$r, "fechaDesde"=>$fd];  
        return view('admin/percapita/reportepercapita', $data);
   
    }

}




public function cuadroLiqMensualAjax(){
    if (session()->has("idUsuario")  && session('rol') =='A'){
        $t = $_POST['tipo'];
        if ($t == 1){
            //por trasnferencias
            $a = $_POST['año'];
            $m = $_POST['mes'] + 1; //todo lo trasnferido en un mes corrsponde al periodo anterior
            if ($m > 12) {          // por ejemplo selecciono periodo 3, se toman las transfericas del mes 4(abril)
                $m+=1;
                $a+=1;
            }
            $fd = $a . "-" . $m . "-01";
            $fh = new \DateTime($fd); 
            $fh = $fh->format( 'Y-m-t' );
            $q = "select liq.id_usuario, nombre, id_cliente,  sum(importe) as simporte, sum(descuento) as sdescuento, sum(incremento) as sincremento, sum(bonos_anticipos) as sbonos_anticipos  from  liquidaciones liq, usuarios where liq.id_usuario = usuarios.id_usuario and id_mov_vta_rbo <> 0 and fecha_transf >= '$fd' and fecha_transf <= '$fh' group by id_usuario";
        }else
        {
            //por recibos pendientes de trasnferir
            $a = $_POST['año'];
            $m = $_POST['mes']; //todo lo trasnferido en un mes corrsponde al periodo anterior
            $fd = $a . "-" . $m . "-01"; //NO IMPORTA FECHA DESDE 
            $fh = new \DateTime($fd); 
            $fh = $fh->format( 'Y-m-t' );
            $q = "select liq.id_usuario, nombre, id_cliente,  sum(importe) as simporte, sum(descuento) as sdescuento, sum(incremento) as sincremento, sum(bonos_anticipos) as sbonos_anticipos  from  liquidaciones liq, usuarios where liq.id_usuario = usuarios.id_usuario and id_mov_vta_rbo <> 0 and fecha_rbo <= '$fh' and liq.estado <> 'P' and estado_pago = 'P' group by id_usuario";
            
            
        }
        
            //echo($q);
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


public function RetDetProfMesAjax(){
    if (session()->has("idUsuario")){
        $p = $_POST['p'];
       
        if (isset($_POST['idprof'])){
            $idprof = $_POST['idprof']; 
        }
        else{
            //si no se recibe el profesional muestra los datos del que está logueado
            $idprof = session('idUsuario');
        }
        //retenciones
        $q2 = "select importe, detalle, sucursal, num_comprobante, periodo from vta_movimientos vm inner join  vta_movimientos_detalle vmd  on  vm.id_vta = vmd.id_vta   inner join usuarios on vm.id_cliente = usuarios.id_cliente where  tipo_movvta = 500 and periodo = " . $p . " and id_usuario = " .  $idprof;   
        
        $MMVta = new VtaMovModel;
        $r2 = $MMVta->getMovimientos($q2);
         $MVMov = new VtaMovModel;
         if ($r2){
                  echo json_encode($r2);
         }    
    }
    else{
              return redirect()->to(site_url());  
    }
}







}//fin controlador