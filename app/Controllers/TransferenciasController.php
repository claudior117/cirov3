<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\VtaMovModel;
use App\Models\LiquidacionesModel;
use App\Models\ClientesModel;
use App\Models\UsuarioModel;
use App\Models\ProfMovModel;
use App\Models\VtaMovDetalleModel;
use App\Models\VtaTipoMovModel;
use App\Models\SistemaModel;
use App\Models\MensajesModel;


class TransferenciasController extends Controller{
    
    public function transferencias(){
        if (session()->has("idUsuario")&& session('rol'=='A')) {
            return view('admin/transferencias/transferencias');
          }
          else{
              return redirect()->to(site_url());  
        }
    }



    public function ComprobantesSTAjax(){
        //lista recibos sin transferir
        if (session()->has("idUsuario") && session('rol') =='A') {
                 $q = "select * from vta_movimientos vm,  clientes,  vta_tipo_movimientos vtm where vm.id_cliente = clientes.id_cliente
                        and  vm.tipo_movvta = vtm.id_tipomov and vm.sucursal = vtm.sucursal and  vm.tipo_movvta = 1  and estado <>'P'"; 
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
      
      
    public function armarTransf($a, $p, $ret){
      //$a el listado de comprobantes a cancelar
      if (session()->has("idUsuario") && session('rol'=='A')) {  
       //mando todos los profesionales
       //los datos del cliente para la operacion(contado)
       //y los comprobantes afectados
       
       $a = json_decode($a, true);
       $MCli = new ClientesModel;
       $r2 = $MCli -> buscarPorId(1); //contado
       
       $MProf = new UsuarioModel;
       $r3 = $MProf -> getProfesionales(); //todos los profesionales
       
       
       $data = ["arrayComp"=>$a, "arrayCli" => $r2, "periodo"=>$p, "arrayProf"=>$r3, "haceret" =>$ret];
      
       return view('admin/transferencias/transferencias2', $data);
      }
        else{
            return redirect()->to(site_url());  
        }
    
    }
        

    public function EmitirTransferencia(){
      if (session()->has("idUsuario") && session('rol'=='A')) {  
          $idcli = $_POST['idcliente'];
          $cliente = $_POST['cliente'];
          //$idos = $_POST['idos'];
          $fecha = $_POST['fecha'];
          $pv = $_POST['puntoventa'];
          $nc = $_POST['numcomp'];
          $total = $_POST['total'];
          $otros = $_POST['otros'];
          $subtotal = $_POST['subtotal'];

          $periodo = $_POST['periodo']; 
          $haceret = $_POST['haceret'];
          $arraycomp = json_decode($_POST['arraycomp'], false);
          if(isset($_POST['arrayComp'])){
            $arrayret = json_decode($_POST['arrayret'], false);
          }  else{
            $arrayret = []; 
          }
          

          
          //agrego comprobante en ventas  
          $data = ['fecha' => $fecha, 'tipo_movvta' => 201, 'id_cliente' =>1, 'total' => $total, 'subtotal'=>$subtotal, 'otros_concepto'=>$total-$subtotal, 'ubicacion_ctacte'=>'N', 'estado'=>'X', 'estado_pago'=>'N', 'cae'=>'0', 'fecha_vto_cae'=>$fecha, 'id_usuario_emision'=>session('idUsuario'), 'fecha_hora_emision'=>date("Y-m-d h:i:s"), 'ubicacion_caja' => 'S', 'cliente'=>$cliente . "(Profesionales)", 'sucursal' => $pv, 'num_comprobante'=>$nc, 'letra'=>'C', 'contado'=>'S', 'periodo'=>$periodo, 'id_os' =>0, 'percapita' => 'N'];
          $MVMov = new VtaMovModel;
          $r = $MVMov -> insert($data);
          if ($r){
              $r4 = $MVMov -> getUltimoId();
              $idmovvta = $r4->idMovVta;
             
              $MLiq = new LiquidacionesModel;  
              $MMprof = new ProfMovModel;  
              $MVDet = new VtaMovDetalleModel;
              $MU = new UsuarioModel;
              $MTMov = new VtaTipoMovModel;
              $MMVta = new VtaMovModel;
              $MSis = new SistemaModel;
              
      
              $r6 = $MTMov -> actualizaNumerador($pv, 201, $nc);
              $f = "C" . str_pad($pv, 4, "0", STR_PAD_LEFT) . "-" . str_pad($nc, 10, "0", STR_PAD_LEFT);
              
              
              //Para cada profesional calculo
              $MProf = new UsuarioModel;
              $r3 = $MProf -> getProfesionales(); //todos los profesionales
              $retenciones = 0;
              $subtotal = 0;
              $otros = 0;
              $total = 0;
              $renglon = 1;
              $totaldescuentos = 0;
              $totalincrementos = 0;
              $totalbonos = 0;
              foreach($r3 as $valorP) {
                      $totalprof = 0;
                      $subtotalprof = 0;
                      $retprof = 0;
                      foreach($arraycomp as $clave => $valor) {
                            //busco en el detalle del comprobante lo facturado al prof
                            $r = $MVDet->buscarProfenComp($valorP['id_usuario'], $valor);
                            
                            foreach($r as $valores) {  
                                   $imp = $valores['importeliq'] - $valores['descuento']  +  $valores['incremento'] - $valores['bonos_anticipos'] ;
                                   $subtotalprof += $imp;
                                   $tipoc = "Fc C" . str_pad($valores['sucursal'], 4, "0", STR_PAD_LEFT) . "-" . str_pad($valores['num_comprobante'], 10, "0", STR_PAD_LEFT);
                                   $detalle = "Transf " . $f . " por " . $tipoc;
                                   $totaldescuentos+=$valores['descuento'];     
                                   $totalincrementos+=$valores['incremento'];
                                   $totalbonos+=$valores['bonos_anticipos']; 

                                    //actualizo liquidacion
                                    $dataL = ["estado" => "P", "fecha_transf" => $fecha, "id_mov_transf" => $idmovvta];    
                                    $r2 = $MLiq -> update($valores['id_liquidacion'], $dataL);

                                    //actualizo movimientos prof (uno por prof)
                                    $dataP = ['fecha' => $fecha, 'importe' => $imp, 'tipo' => 201, 'estado' => 'X', 'periodo' => $periodo, 'ubicacionP' => 'H', 'id_os' => $valores['id_os'], 'id_liquidacion' => $valores['id_liquidacion'], 'id_mov_vta' => $idmovvta, 'id_profesional' =>$valorP['id_usuario'], 'detalle' => $detalle, 'origen' => $valores['cliente'] . "(CIRO)", 'destino' =>substr($valorP['nombre'], 0, 93), 'id_clientep' => $valores['id_cliente']] ;
                                    $r3 = $MMprof -> insert($dataP);
  
                                    
                            }
                        
                          
                          }   
                          

                          if($haceret == 1) {
                            //busco retenciones
                            $q = "select * from vta_movimientos where id_cliente = " . $valorP['id_cliente'] . " and estado_pago <> 'P' and tipo_movvta = 500"; 
                            $r12 = $MMVta->getMovimientos($q); 
                            foreach($r12 as $ret) {
                              
                                  $imp = $ret['saldo_impago'];
                               
                                  
                                  //agrego rbo por retenciones
                                  $rrr = $MSis -> getSistema();
                                  $puntoVentaRboRet = $rrr->sucursal_inicio;
                                  $rrr = $MTMov -> getTipoMov($puntoVentaRboRet,55);
                                  $numCompRboRet =  $rrr->ult_num_c + 1;
                                    
                                  //agrego vta
                                  
                                  if ($imp > $subtotalprof){
                                    $saldoimpago = $imp - $subtotalprof; 
                                    $imp = $subtotalprof;
                                    $subtotalprof = 0;
                                    $dataR=["estado_pago"=>'N', "saldo_impago"=>$saldoimpago];
                                    
                                  }else{
                                    $subtotalprof = $subtotalprof - $imp; 
                                    $dataR=["estado_pago"=>'P', "saldo_impago"=>0];
                                  }
                                  $r17 = $MMVta -> update($ret['id_vta'] ,$dataR);
                              

                                  $retprof += -$imp;
                                  $dataRet = ['fecha' => $fecha, 'tipo_movvta' => 55, 'id_cliente' =>$valorP['id_cliente'], 'total' => $imp, 'subtotal'=>$imp, 'otros_concepto'=>0, 'ubicacion_ctacte'=>$rrr->ubica_ctacte_cir, 'estado'=>'X', 'estado_pago'=>'P', 'cae'=>'0', 'fecha_vto_cae'=>$fecha, 'id_usuario_emision'=>session('idUsuario'), 'fecha_hora_emision'=>date("Y-m-d h:i:s"), 'ubicacion_caja' => $rrr->ubica_caja, 'cliente'=>$valorP['nombre'] . "(CIRO)", 'sucursal' => $puntoVentaRboRet, 'num_comprobante'=>$numCompRboRet, 'letra'=>'C', 'contado'=>'N', 'periodo'=>$periodo, 'id_os' =>0];
                                  $MVMov = new VtaMovModel;
                                  $rrr =  $MMVta -> insert($dataRet);

                                  //obtengo id
                                  $rrr = $MMVta -> getUltimoId();
                                  $idmovvtaRet = $rrr->idMovVta;
                                  

                                  //modifico numerador
                                  $rrr = $MTMov -> actualizaNumerador( $puntoVentaRboRet,  55, $numCompRboRet);
      
                                  //agrgo detalle
                                  //actualizo detalle NcNd
                                  $detalleRet = "Pago Ret C" . str_pad($ret['sucursal'], 4, "0", STR_PAD_LEFT) . "-" . str_pad($ret['num_comprobante'], 10, "0", STR_PAD_LEFT);
                
                                    $dataRet = ['id_vta'=>$idmovvtaRet, 'renglon'=> 1, 'id_liquidacion'=>0, 'id_producto'=>0, 'detalle'=> $detalleRet, 'pu'=>$imp, 'cantidad'=>1, 'importe'=>$imp, 'tasa_iva'=>21];
                                    $rrr = $MVDet -> insert($dataRet);
                
                                    //actualizo profesionales
                                    $dataPRet = ['fecha' => $fecha, 'importe' => $imp, 'tipo' => 55, 'estado' => 'X', 'periodo' => $periodo, 'ubicacionP' => 'D', 'id_os' => 0, 'id_liquidacion' =>0 , 'id_mov_vta' => $idmovvtaRet, 'id_profesional' =>$valorP['id_usuario'], 'detalle' => $detalleRet, 'origen' =>substr($valorP['nombre'], 0, 93), 'destino' =>"CIRO(Retenciones)", 'id_clientep' => 1] ;
                                    $rrr = $MMprof -> insert($dataPRet);
                               
                            }
                           
                          }

                          
                          //$subtotalprof = $subtotalprof; 
                          
                          $totalprof = $subtotalprof;
                          $subtotal += $subtotalprof;
                          $retenciones += $retprof;
                          $total += $totalprof;
                          
                         
                         if($totalprof != 0 || $subtotalprof !=0 || $retprof !=0){ 
                                //actualizo detalle trasnferecis
                                $dataD = ['id_vta'=>$idmovvta, 'renglon'=> $renglon, 'id_liquidacion'=>0, 'id_producto'=>$valorP['id_usuario'], 'detalle'=> substr($valorP['nombre'], 0, 149), 'pu'=>$totalprof, 'cantidad'=>1, 'importe'=>$totalprof, 'tasa_iva'=>10.5];
                                $r4 = $MVDet -> insert($dataD);
            
                               
                                $renglon += 1;
                         }  

                        }//fin profesional              

                        //actualizar los totales de la trsnferencia 
                        $otros = $total -  $subtotal;
                        $data = ['total' => $total, 'subtotal'=>$subtotal, 'otros_concepto'=>$otros];
                        $r = $MVMov -> update($idmovvta, $data);    

                        //actualizo las liquidaciones
                        foreach($arraycomp as $clave => $valor) {
                                                    
                          //actualizo estado comprobante venta
                          $dataC = ["estado" => "P"];    
                          $r2 = $MVMov -> update($valor, $dataC); 

                        }

                        //mensjaes
                        $datos = ["mensaje"=>"Transferencia mensual realizada ", "tipo"=>"IMPORTANTE", "fecha"=>$fecha, "id_usuario"=>1, "duracion"=>7] ; 
                        $Mmsj = new MensajesModel;
                        $Mmsj ->insertarMensaje($datos);
                  
              echo(1); 
          }
           else
          {
            echo(0);  
          }
      }
      else{
          return redirect()->to(site_url());  
      }  
      } //fin emitir factura
      





}