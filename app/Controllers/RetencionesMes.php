<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RetMesModel;
use App\Models\UsuarioModel;
use App\Models\RetMesProfModel;
use App\Models\VtaMovModel;
use App\Models\VtaMovDetalleModel;
use App\Models\VtaTipoMovModel;
use App\Models\ProfMovModel;
use App\Models\LiquidacionesModel;
use App\Models\MensajesModel;

use App\Models\G0Model;

use DateTime;


class RetencionesMes extends Controller{

    public function Index()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            //consulta antes
            $q = "select * from prof_retenciones";
            $MRMes = new RetMesModel;
            $r = $MRMes -> getRetMes($q); 
            $datos = ["arregloItems"=>$r];
            return view('admin/retmensual/retmes', $datos);
          }
          else{
              return redirect()->to(site_url());  
          }
    }



    public function actualizaRetMes(){
        if (session()->has("idUsuario") && session('rol'=='A')) {
            $valor = json_decode($_POST['arrayValor'], false);
            $idItemLiq = json_decode($_POST['arrayIdItem'], false);
            $fechaactual = date("Y-m-d");
           
            for ($i = 0; $i < count($valor); $i++){
                $data = ["valor"=> floatval($valor[$i]), "fecha_ult_actu" => $fechaactual];
                //update
                $MRMes = new RetMesModel;
                $r = $MRMes->update(intval($idItemLiq[$i]), $data);
            }
            
            echo(1);
        }
     
    else
    {
        //sin sesion
        return redirect()->to(site_url());  
    }
    
    }


    public function actualizaRetMesProf(){
        if (session()->has("idUsuario") && session('rol'=='A')) {
            $valor = json_decode($_POST['arrayValor'], false);
            $idItem = json_decode($_POST['arrayIdItem'], false);
            $idProf = json_decode($_POST['arrayProf'], false);
            $fechaactual = date("Y-m-d");
            $MRMProf = new RetMesProfModel;
            for ($i = 0; $i < count($idItem); $i++){
                if ($valor[$i] >= 0) {
                    //update
                    $data = ["cantidad"=> floatval($valor[$i]), "fecha_ult_actu" => $fechaactual];
                    $r = $MRMProf->update(intval($idItem[$i]), $data);
                }
                else{
                    //insert
                    $data = ["id_usuario" => $idProf[$i], "cantidad"=> 1, "fecha_ult_actu" => $fechaactual, "id_retmes"=>$idItem[$i]];
                    $r = $MRMProf->insert($data);
                   }
            
                }
            
            echo(1);
        }
     
    else
    {
        //sin sesion
        return redirect()->to(site_url());  
    }
    
    }

    public function retMesProf()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            //consulta antes
            $MProf = new UsuarioModel;
            $r = $MProf -> getProfesionales();
            
            $MRet = new RetMesModel;
            $q = "select * from prof_retenciones";
            $r2 = $MRet -> getRetMes($q);
            
            $datos = ["arregloProf"=>$r, "arregloRet"=>$r2 ];
            return view('admin/retmensual/retmesprof', $datos);
          }
          else{
              return redirect()->to(site_url());  
          }
    }
    


    public function liquidarRetMes(){
        if (session()->has("idUsuario") && session('rol'=='A')) {
            $mes = $_POST['nameMes2'];
            $año = $_POST['nameAño2'];
            $fecha = $_POST['nameFecha'];
            //validacion

           

            //buscar si no está emiltida la liquidacion
            $idcomprobante = 500;
            $letra = "C";
            $periodo =  $año . sprintf("%'.02d\n", $mes);
           
            $MVta = new VtaMovModel;
            $MRMProf = new RetMesProfModel;
                //agrego liquidacion 
                //1 para cada prof
                $MProf = new UsuarioModel;
                $r2 = $MProf ->getProfesionales();
                foreach($r2 as  $prof) {
                        //agrego mov vta con total en 0
                        $MPara = new G0Model;
                        $r = $MPara -> getParametros();
                        $sucursal = $r -> sucursal_inicio;
                        
                        $MTipoMov = New VtaTipoMovModel;
                        $r2 = $MTipoMov -> getTipoMov($sucursal, 500);
                        $numcomprobante = ($r2 ->ult_num_c) + 1;
                        $datosVta = ['fecha'=>$fecha, 'tipo_movvta'=>500, 'id_cliente'=>$prof['id_cliente'], 'total'=>0, 'subtotal'=>0,  'otros_concepto'=>0,  'ubicacion_ctacte'=>'D', 'estado'=>'A', 'estado_pago'=>'N', 'cae'=>0, 'fecha_vto_cae'=>date('Y-m-d'), 'id_usuario_emision'=>session('idUsuario'), 'ubicacion_caja'=>'N', 'cliente'=>$prof['nombre'], 'sucursal'=>$sucursal,'num_comprobante'=>$numcomprobante, 'contado' => 'N ', 'letra'=>'C',  'periodo' => $periodo, 'saldo_impago'=>0];
                        $r3 = $MVta ->insert($datosVta);

                        $r31 = $MVta ->getUltimoId();
                        $idMovVta = $r31->idMovVta;
                                            
                        $datosCompVta = ['ult_num_c' => $numcomprobante];
                        $r4 = $MTipoMov->update($r2 -> id, $datosCompVta);


                        //cálculo del total cobrado por el profesional en el periodo(entre fechas)
                        //por ejemplo periodo 202309 01/09/23 al 30/9/23  
                        $fdesde = $año . "-" . $mes . "-01";
                        $L = new DateTime($fdesde); 
                        $fhasta =  $L->format( 'Y-m-t' );
                        $MLiq = new LiquidacionesModel;
                        $totalCobrado = 0;
                        $r9 = $MLiq -> totalPagosPorProf($fdesde, $fhasta, $prof['id_usuario']);
                        //agrego detalle movvta y calculo total
                        if (isset($r9)){
                            $totalCobrado = $r9->totalPago;
                            $totalIoma = $r9->totalIoma;
                            $totalIomaSinDescuentos = $r9->totalIomaSinDescuentos;
                            $totalSinIoma = $totalCobrado - $totalIoma;
                        }else
                        {
                            $totalCobrado = 0;
                            $totalIoma = 0;
                            $totalIomaSinDescuentos=0;
                            $totalSinIoma = 0;
                        }
                        $r3 = $MRMProf -> getRetMesporProf($prof['id_usuario']);
                        $MDetVta = new VtaMovDetalleModel;
                        $i = 1;
                        $total = 0;
                        $pu = 0;
                        foreach($r3 as  $rmprof){
                            //calculo
                            //if($rmprof['cantidad']>0){
                                $importe = 0;
                                if($rmprof['tipo']=='I'){
                                    $importe = $rmprof['valor'] * $rmprof['cantidad'];
                                    $pu = $rmprof['valor'];
                                } 
                                else{
                                    //retenciones por porcentaje
                                    if ($rmprof['relacion_porcentaje']== 'PM'){
                                        //porcentajes de los pagos en el mes
                                        if ($rmprof['id_retmes']== 1){
                                            //retencion circulo
                                            $importe = ($totalSinIoma * $rmprof['valor']/100) * $rmprof['cantidad'] ;
                                        }else{
                                            $importe = ($totalIomaSinDescuentos * $rmprof['valor']/100) * $rmprof['cantidad'] ;
                                        }
                                        $pu = $importe;
                                        
                                    }
                                    else{
                                        $importe = 0;
                                        $pu = 0;
                                    }
                                }

                                //detalle de venta en id_producto tiene el id del profesional
                                $data=['id_vta'=>$idMovVta, 'renglon'=>$i, 'id_liquidacion'=>0, 'id_producto'=>$prof['id_usuario'], 'detalle'=> $rmprof['retencion'], 'pu'=>$pu, 'cantidad'=>$rmprof['cantidad'], 'importe'=>$importe, 'tasa_iva'=>21];
                                $r5 = $MDetVta ->insert($data);
                                $i+=1;
                                $total = $total + $importe;
                            //}    
                        }

                        //actualizo total en comprobante ventas
                        $dataVta = ["total" => $total, "subtotal"=>$total, "saldo_impago"=>$total];
                        $r32 = $MVta -> update($idMovVta, $dataVta);


                        //agrego mov profesionales
                        $MPMov = new ProfMovModel;
                        $dataProf = ['fecha'=>$fecha, 'importe'=>$total, 'tipo'=>500, 'estado'=>'A', 'periodo'=>$periodo, 'ubicacionP'=>'H', 'id_os'=>0, 'id_liquidacion'=>0, 'id_mov_vta'=>$idMovVta,'id_profesional'=>$prof['id_usuario'], 'detalle'=>'Retenciones Mes ->' . $periodo, 'destino' => substr($prof['nombre'],0,99), 'origen'=>'CIRO ROJAS'];
                        $MPMov -> insert($dataProf);


                        //actualizo liquidaciones 
                        $MLiq -> actuLiqRet($fecha, $idMovVta, $prof['id_usuario']);    


                        //mensajes
                        $datos = ["mensaje"=>"Retenciones mensuales cargadas ", "tipo"=>"IMPORTANTE", "fecha"=>$fecha, "id_usuario"=>1, "duracion"=>7] ; 
                        $Mmsj = new MensajesModel;
                        $Mmsj ->insertarMensaje($datos);
                       
            } 
            echo(1);
        }
    else
      {
            //sin sesion
            return redirect()->to(site_url());  
       }
    
    }




    public function liquidarRetManual(){
        if (session()->has("idUsuario") && session('rol'=='A')) {
                return view('admin/retmensual/retmesmanual');
        }
        else
        {
                //sin sesion
                return redirect()->to(site_url());  
        }
    }


    public function retManualItemsAjax(){
        if (session()->has("idUsuario") && session('rol'=='A')) {
            $idp = $_POST['idp'];
            $periodo = $_POST['p'];
            //validacion
            $MProf = new UsuarioModel();
            $r = $MProf -> buscarPorId($idp);
            if (isset($r)){
                  //busco el mov venta de retenciones en el periodo
                  $MVMov = new VtaMovModel();
                  $q = "select id_mov_detalle, fecha, total, detalle, cantidad, pu, vta_movimientos_detalle.importe as importemov, vta_movimientos_detalle.id_vta as idvtamov, estado_pago  from vta_movimientos, vta_movimientos_detalle where vta_movimientos.id_vta = vta_movimientos_detalle.id_vta and  id_cliente = " . $r->id_cliente . " and  periodo = $periodo and tipo_movvta = 500";  
                  //echo($q);
                  $r2 = $MVMov -> getMovimientos($q);
                  echo json_encode($r2);
            }
        }        
    }



    public function retManualNuevaAjax(){
        if (session()->has("idUsuario") && session('rol'=='A')) {
            $idp = $_POST['idp'];
            //validacion
            $MRMProf = new RetMesProfModel;
            $r3 = $MRMProf -> getRetMesporProf($idp);
            if (isset($r3)){
                  echo json_encode($r3);
            }
        }        
    }




    public function actualizaRetManual(){
            if (session()->has("idUsuario") && session('rol'=='A')) {
                $cantidad = json_decode($_POST['arrayCant'], false);
                $idItem = json_decode($_POST['arrayIdItem'], false);
                $pu = json_decode($_POST['arrayPu'], false);
                $idvta = $_POST['idVta'];
               
                 
                $total = $_POST['total'];
                $fechaactual = date("Y-m-d");
                $MVDet = new VtaMovDetalleModel;
                for ($i = 0; $i < count($idItem); $i++){
                        $data = ["cantidad"=> $cantidad[$i], "pu" => $pu[$i], "importe" => $pu[$i]*$cantidad[$i]];
                        $r = $MVDet->update($idItem[$i], $data);
                }

                 //modfico movimiento de venta
                 $MVMov = new VtaMovModel();
                 $data = ["total" =>$total, "subtotal" =>$total, "saldo_impago" => $total];
                 $r2 = $MVMov->update($idvta, $data);
                 
                 //modifico mov profesional
                 //agrego mov profesionales
                 $MPMov = new ProfMovModel;
                 $q = "update prof_movimientos set importe= " . $total . " where id_mov_vta = " . $idvta;
                 $MPMov -> queryMovProf($q);
                echo(1);
            }
         
        else
        {
            //sin sesion
            return redirect()->to(site_url());  
        }
        
       

    }


    public function RetencionesSPAjax(){
        if (session()->has("idUsuario") && session('rol'=='A')) {
            //retenciones sin pagar
             $MVMov = new VtaMovModel();
             $q = "select * from vta_movimientos where tipo_movvta = 500 and estado_pago='N'";  
                  //echo($q);
                  $r2 = $MVMov -> getMovimientos($q);
                  echo json_encode($r2);
            
        }       
    }





}//fin clase