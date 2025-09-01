<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\OsModel;
use App\Models\VtaMovModel;
use App\Models\VtaMovDetalleModel;
use App\Models\LiquidacionesModel;
use App\Models\ProfMovModel;
use App\Models\UsuarioModel;
use App\Models\VtaTipoMovModel;
use App\Models\LogsModel;




class PagosController extends Controller{

    public function Index()    {
        if (session()->has("idUsuario")&& session('rol'=='A')) {
            return view('admin/pagos/index');
          }
          else{
              return redirect()->to(site_url());  
          }}


   


    public function listaFactAjax(){
        if (session()->has("idUsuario") && session('rol') =='A') {
                 $fd = $_POST['fd'];
                 $idcli = $_POST['idcli'];
                 $ep = $_POST['estadopago'];
                 
                 //$q = "select id_vta, fecha, cliente, tipo_movvta, letra, vta_movimientos.sucursal as suc, num_comprobante, periodo, estado_pago from vta_movimientos inner join vta_tipo_movimientos on tipo_movvta = id  where  tipo_movvta = 1 and fecha >= '$fd'" ;
                /* $q = "select * from vta_movimientos vm 
                        inner join vta_tipo_movimientos on tipo_movvta = id
                        inner join os on vm.id_cliente = os.id_cliente
                        where  tipo_movvta = 1 and fecha >= '$fd'" ;
                 
                */

                $q = "select * from vta_movimientos vm 
                inner join vta_tipo_movimientos on tipo_movvta = id
                where  tipo_movvta = 1 and fecha >= '$fd'" ;
         

                 if ($idcli > 0){
                      $q = $q . " and vm.id_cliente= $idcli";
                  }              
  
                  if ($ep <> 'T'){
                    $q = $q . " and estado_pago= '$ep'";
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
  

              public function armaReciboFactura($idfactura){
                //$a el listado de liq a facturar
                
              if (session()->has("idUsuario") && session('rol'=='A')) {  
                $MMov = new VtaMovModel;
                $r = $MMov -> buscarporId($idfactura);
                if (isset($r)){
                     if($r->tipo_movvta == 1 && $r->estado_pago = 'N'){
                        //$MOs = new OsModel;
                        //$r2 = $MOs -> buscarPorId($r->id_os);
                    
                        $MDet = new VtaMovDetalleModel;
                        $r3 = $MDet -> buscarPorId($idfactura);
                    

                        //$MCli = new ClientesModel;
                        //$r2 = $MCli -> buscarPorId($r ->id_cliente);
                    
                        
                        $data = ["arrayRbo"=>$r,  "arrayDet" => $r3, "periodo" => $r->periodo];
                        return view('admin/pagos/recibo', $data);

                     }   
                }
               
               
                }
                else{
                    return redirect()->to(site_url());  
                }
            
            }



//emitir nc por recibos
public function EmitirRbo(){
    if (session()->has("idUsuario") && session('rol'=='A')) {  
      $idcli = $_POST['idcliente'];
      $cliente = $_POST['cliente'];
      $idos = $_POST['idos'];
      $fecha = $_POST['fecha'];
      $pv = $_POST['puntoventa'];
      $nc = $_POST['numcomp'];
      $subtotal = $_POST['subtotal'];
      $otros = $_POST['otros'];
      $total = $_POST['total'];
      $periodo = $_POST['periodo'];; 
      $arraydetvta = json_decode($_POST['arraydetvta'], false);
      $arrayliq = json_decode($_POST['arrayliq'], false);
      $arrayimp = json_decode($_POST['arrayimporte'], false);
      $idfactura = $_POST['idfactura'];
      

    //buscar si el comporbante no existe
    $MVMov = new VtaMovModel;
    $r0 = $MVMov -> buscarComprobante(50, 'C', $pv, $nc);
    if(!isset($r0)){    
        //el comprobante no existe

      $data = ['fecha' => $fecha, 'tipo_movvta' => 50, 'id_cliente' =>$idcli, 'total' => $total, 'subtotal'=>$subtotal, 'otros_concepto'=>$otros, 'ubicacion_ctacte'=>'H', 'estado'=>'X', 'estado_pago'=>'N', 'cae'=>'0', 'fecha_vto_cae'=>$fecha, 'id_usuario_emision'=>session('idUsuario'), 'fecha_hora_emision'=>date("Y-m-d h:i:s"), 'ubicacion_caja' => 'E', 'cliente'=>$cliente, 'sucursal' => $pv, 'num_comprobante'=>$nc, 'letra'=>'C', 'contado'=>'N', 'periodo'=>$periodo, 'id_os' =>$idos];
     
      
      //1 agrego la nc
      $r = $MVMov -> insert($data);
      if ($r){
         
          $r4 = $MVMov -> getUltimoId();
          $idmovvta = $r4->idMovVta;
         
          $MLiq = new LiquidacionesModel;  
          $MMprof = new ProfMovModel;  
          $MVDet = new VtaMovDetalleModel;
          $MU = new UsuarioModel;
          $MTMov = new VtaTipoMovModel;
  

          //log 
          $datos = ["id_tipolog"=>9, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"VtaMovimientos", "id_registro"=>$idmovvta] ; 
          $MLog = new LogsModel;
          $MLog -> insert($datos);

          //2 modifico el numerador
          $r6 = $MTMov -> actualizaNumerador($pv, 50, $nc);
  
          $f = "C" . str_pad($pv, 4, "0", STR_PAD_LEFT) . "-" . str_pad($nc, 10, "0", STR_PAD_LEFT);
             
           
            //actualizo estado  factura
            $dataP = ['estado_pago' => 'P'];
            $r7 = $MVMov -> update($idfactura, $dataP);

            $r8 = $MVMov -> buscarPorId($idfactura);
            if (isset($r8)){
              $factura = $r8 -> letra . str_pad($r8->sucursal, 4, "0", STR_PAD_LEFT) . "-" . str_pad($r8->num_comprobante, 10, "0", STR_PAD_LEFT);
            }else{
              $factura = "C0000-0000000000";
            }

             
          foreach($arrayliq as $clave => $valor) {
  
              //Actualizo datos liquidacion 
              $r0 = $MLiq->buscarPorId($valor);
              if ($r0){
                      $idprof = $r0 -> id_usuario;
                      $importe = $r0 -> importe;
                      $idosLiq = $r0 -> id_os;
                      $detalle = "Rbo " . $f;  
                         
                      //actualizo estado liquidacion
                      $dataL = ['id_mov_vta_rbo' =>  $idmovvta, 'estado_pago' => 'P', 'fecha_rbo' => $fecha];    
                      $r2 = $MLiq -> update($valor, $dataL);   
                  
                     
                      //actualizo detalle Rbo
                      $r5 = $MU -> buscarPorId($idprof);
                      $dataD = ['id_vta'=>$idmovvta, 'renglon'=> $clave + 1, 'id_liquidacion'=>$valor, 'id_producto'=>0, 'detalle'=> 'Pago fact.'. $factura . ' '. substr($r5->nombre,0,111) . ' ' . $r5->matricula , 'pu'=>$arrayimp[$clave], 'cantidad'=>1, 'importe'=>$arrayimp[$clave], 'tasa_iva'=>21];
                      $r4 = $MVDet -> insert($dataD);
  
                       
                      
              
                    }
          }    
          echo(1); 
          
  
      }
       else
      {
        echo(0);  
      }
    }   
  else{
    echo(0); 
  }
}
else{
      return redirect()->to(site_url());  
  }  
}//fin recibo
  






      
}//Fin Clase Pagos