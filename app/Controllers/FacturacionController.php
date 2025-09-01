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
use App\Models\ClientesModel;
use App\Models\MensajesModel;
use App\Models\LogsModel;
use App\Models\SistemaModel;



class FacturacionController extends Controller{


public function verComprobante($idmovvta){
    if (session()->has("idUsuario") && session('rol'=='A')) {  
         $MVMov = new VtaMovModel;
         $r = $MVMov -> buscarPorId($idmovvta);
         if (isset($r)) {
            $MVMovDet = new VtaMovDetalleModel;
            $r2 = $MVMovDet -> buscarPorId2($idmovvta);

            $Mos = new OsModel;
            $r3 = $Mos -> buscarPorId($r -> id_os);

            $MVTMov = new VtaTipoMovModel();
            $r4 = $MVTMov -> getTipoMov($r->sucursal, $r->tipo_movvta);
            

            $data = ["arrayFact" => $r, "arrayItems" => $r2, "arrayOs" => $r3, "arrayTipoMov" => $r4]; 
            return view('admin/comprobantes/vercomprobante', $data);
        
         }    


         


        }
    else{
        return redirect()->to(site_url());  
    }
       
     
}


public function facturarLiq($a, $p){
    //$a el listado de liq a facturar
    
  if (session()->has("idUsuario") && session('rol'=='A')) {  
   $a = json_decode($a, true);
   $MLiq = new LiquidacionesModel();
   //tengo que armar un array de los profesionales de las liquidaciones
   //y ordenar ambos (liq y prof) por profesional
   

   $r0 = $MLiq ->buscarPorId($a[0]);
   $MOs = new OsModel;
   $r3 = $MOs -> buscarPorId($r0 -> id_os);
   
   $MCli = new ClientesModel;
   $r2 = $MCli -> buscarPorId($r0 -> id_cliente);
   $data = ["arrayLiq"=>$a, "arrayCli" => $r2, "periodo"=>$p, "arrayOs" => $r3];
   return view('admin/factura/facturaLiq', $data);
  }
    else{
        return redirect()->to(site_url());  
    }

}



public function EmitirFacturaLiq(){
  if (session()->has("idUsuario") && session('rol'=='A')) {  
    $idcli = $_POST['idcliente'];
    $cliente = $_POST['cliente'];
    //$idos = $_POST['idos'];
    $fecha = $_POST['fecha'];
    $pv = $_POST['puntoventa'];
    $nc = $_POST['numcomp'];
    $subtotal = $_POST['subtotal'];
    $otros = $_POST['otros'];
    $total = $_POST['total'];
    $importepercapita = $_POST['importepercapita'];
    $periodo = $_POST['periodo']; 
    $arrayliq = json_decode($_POST['arrayliq'], false);
    
    $MCli = new ClientesModel;
    $r11 = $MCli ->  buscarPorId($idcli);

    if ($r11->percapita == "S") {
      $ubicapercapita = "E";
    }
    else {
      $ubicapercapita = "N";
    }

    $data = ['fecha' => $fecha, 'tipo_movvta' => 1, 'id_cliente' =>$idcli, 'total' => $total, 'subtotal'=>$subtotal, 'otros_concepto'=>$otros, 'ubicacion_ctacte'=>'D', 'estado'=>'X', 'estado_pago'=>'N', 'cae'=>'0', 'fecha_vto_cae'=>$fecha, 'id_usuario_emision'=>session('idUsuario'), 'fecha_hora_emision'=>date("Y-m-d h:i:s"), 'ubicacion_caja' => 'N', 'cliente'=>$cliente, 'sucursal' => $pv, 'num_comprobante'=>$nc, 'letra'=>'C', 'contado'=>'N', 'periodo'=>$periodo, 'id_os' =>0, 'percapita' => $r11->percapita, 'importe_percapita' =>$importepercapita, 'ubicacion_percapita' => $ubicapercapita];
   
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

        //log 
        $datos = ["id_tipolog"=>10, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"VtaMovimientos", "id_registro"=>$idmovvta] ; 
        $MLog = new LogsModel;
        $MLog -> insert($datos);

        $r6 = $MTMov -> actualizaNumerador($pv, 1, $nc);

        $f = "C" . str_pad($pv, 4, "0", STR_PAD_LEFT) . "-" . str_pad($nc, 10, "0", STR_PAD_LEFT);
           
        foreach($arrayliq as $clave => $valor) {

            //buscarla liq 
            $r0 = $MLiq->buscarPorId($valor);
            if ($r0){
                    $idprof = $r0 -> id_usuario;
                    $importe = $r0 -> importe + $r0 -> incremento - $r0 -> descuento ;
                    $idosLiq = $r0 -> id_os;
                    $detalle = "Fact. " . $f;  
                       
                    //actualizo estado
                    $dataL = ["estado" => "F", "fecha_facturado" => $fecha, "factura" => $f, "id_mov_vta" => $idmovvta];    
                    $r2 = $MLiq -> update($valor, $dataL);   
                
                   
                    //actualizo detalle factura
                    $r5 = $MU -> buscarPorId($idprof);

                    $dataD = ['id_vta'=>$idmovvta, 'renglon'=> $clave + 1, 'id_liquidacion'=>$valor, 'id_producto'=>0, 'detalle'=> substr($r5->nombre . ' ' . $r0->os, 0, 149), 'pu'=>$importe, 'cantidad'=>1, 'importe'=>$importe, 'tasa_iva'=>10.5];
                    $r4 = $MVDet -> insert($dataD);

                     //actualizo movimientos prof
                     $dataP = ['fecha' => $fecha, 'importe' => $importe, 'tipo' => 1, 'estado' => 'X', 'periodo' => $periodo, 'ubicacionP' => 'D', 'id_os' => $idosLiq, 'id_liquidacion' => $valor, 'id_mov_vta' => $idmovvta, 'id_profesional' =>$idprof, 'detalle' => $detalle . " " . $r0->os, 'origen' => substr($r5->nombre, 0, 93)."(CIRO)", 'destino' =>substr($cliente, 0, 99), 'id_clientep' => $idcli] ;
                     $r3 = $MMprof -> insert($dataP);
 
            }
        }    

        if ($r11->percapita == "S"){
           //actualizo detalle factura con el ajuste percapita
           $dataD = ['id_vta'=>$idmovvta, 'renglon'=> $clave + 1, 'id_liquidacion'=>0, 'id_producto'=>0, 'id_profesional'=>0, 'detalle'=> 'Ajuste percapita', 'pu'=>$importepercapita, 'cantidad'=>1, 'importe'=>$importepercapita, 'tasa_iva'=>10.5];
           $r4 = $MVDet -> insert($dataD);
        }


        //mensjaes
        $datos = ["mensaje"=>"Facturación mensual " . $periodo . " " . substr($cliente, 0, 100), "tipo"=>"IMPORTANTE", "fecha"=>$fecha, "id_usuario"=>1, "duracion"=>7] ; 
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




//emitir nc o nd por recibos
public function EmitirNcNdRbo(){
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
      $periodo = $_POST['periodo']; 
      $arraydetvta = json_decode($_POST['arraydetvta'], false);
      $arrayliq = json_decode($_POST['arrayliq'], false);
      $arrayimp = json_decode($_POST['arraydescuento'], false);
      $idfactura =$_POST['idfactura'];       
      $tipocomp =$_POST['tipocomp'];
      if($tipocomp== 30){
        $ubicaCaja = "N";
        $ubicacc = "H";
        $ubicap = "H";
      }else
      {
        $ubicaCaja = "N";
        $ubicacc = "D";
        $ubicap = "D";
      }

      $data = ['fecha' => $fecha, 'tipo_movvta' => $tipocomp, 'id_cliente' =>$idcli, 'total' => $total, 'subtotal'=>$subtotal, 'otros_concepto'=>$otros, 'ubicacion_ctacte'=>$ubicacc, 'estado'=>'X', 'estado_pago'=>'P', 'cae'=>'0', 'fecha_vto_cae'=>$fecha, 'id_usuario_emision'=>session('idUsuario'), 'fecha_hora_emision'=>date("Y-m-d h:i:s"), 'ubicacion_caja' => $ubicaCaja, 'cliente'=>$cliente, 'sucursal' => $pv, 'num_comprobante'=>$nc, 'letra'=>'C', 'contado'=>'N', 'periodo'=>$periodo, 'id_os' =>$idos];
     
      
      //1 agrego la nc
      $MVMov = new VtaMovModel;
      $r0 = $MVMov -> buscarComprobante($tipocomp, 'C', $pv, $nc);
    if(!isset($r0)){    
        //el comprobante no existe
     
     
     
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
          $datos = ["id_tipolog"=>8, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"VtaMovimientos", "id_registro"=>$idmovvta] ; 
          $MLog = new LogsModel;
          $MLog -> insert($datos);
  
          
          //2 modifico el numerador
          $r6 = $MTMov -> actualizaNumerador($pv, $tipocomp, $nc);
  
          $f = "C" . str_pad($pv, 4, "0", STR_PAD_LEFT) . "-" . str_pad($nc, 10, "0", STR_PAD_LEFT);
          
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
                         
                      $r5 = $MU -> buscarPorId($idprof);

                      //actualizo estado liquidacion
                      if($tipocomp==30) {
                          $dataL = ['descuento'=>$arrayimp[$clave], 'id_mov_vta_dto' =>  $idmovvta, 'fecha_dto' => $fecha];    
                          $r2 = $MLiq -> update($valor, $dataL);   
                          $detalleItem = 'Descuento s/ fact.'. $factura . ' '. substr($r5->nombre,0,111) . ' ' . $r5->matricula;
                          $detalle = "NC " . $f . " por Descuentos";  
                      
                        }else
                      {
                        $dataL = ['incremento'=>$arrayimp[$clave], 'id_mov_vta_inc' =>  $idmovvta, 'fecha_inc' => $fecha];    
                        $r2 = $MLiq -> update($valor, $dataL);
                        $detalleItem = 'Incremento s/ fact.'. $factura . ' '. substr($r5->nombre,0,111) . ' ' . $r5->matricula;
                        $detalle = "ND " . $f . " por Incrementos";  
                      
                      }  
                     
                      //actualizo detalle NcNd
                      $dataD = ['id_vta'=>$idmovvta, 'renglon'=> $clave + 1, 'id_liquidacion'=>$valor, 'id_producto'=>0, 'detalle'=> $detalleItem, 'pu'=>$arrayimp[$clave], 'cantidad'=>1, 'importe'=>$arrayimp[$clave], 'tasa_iva'=>21];
                      $r4 = $MVDet -> insert($dataD);
  
                       //actualizo movimientos prof
                       $dataP = ['fecha' => $fecha, 'importe' => $arrayimp[$clave], 'tipo' => $tipocomp, 'estado' => 'X', 'periodo' => $periodo, 'ubicacionP' => $ubicap, 'id_os' => $idosLiq, 'id_liquidacion' => $valor, 'id_mov_vta' => $idmovvta, 'id_profesional' =>$idprof, 'detalle' => $detalle, 'origen' => substr($r5->nombre, 0, 93)."(CIRO)", 'destino' =>substr($cliente, 0, 99), 'id_clientep' => $idcli] ;
                       $r3 = $MMprof -> insert($dataP);
   
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
  } //fin nc rbo
  


  //emitir nc interna(301) por bonos
public function EmitirNcBonos(){
  if (session()->has("idUsuario") && session('rol'=='A')) {  
    $idcli = $_POST['idcliente'];
    $cliente = $_POST['cliente'];
    $idos = $_POST['idos'];
    $fecha = $_POST['fecha'];
    $subtotal = $_POST['subtotal'];
    $otros = $_POST['otros'];
    $total = $_POST['total'];
    $periodo = $_POST['periodo']; 
    $arraydetvta = json_decode($_POST['arraydetvta'], false);
    $arrayliq = json_decode($_POST['arrayliq'], false);
    $arrayimp = json_decode($_POST['arraydescuento'], false);
    $idfactura =$_POST['idfactura'];       
    
    //numero nc interna automatica
    $tipocomp = 301;
    
    $MSis = new SistemaModel;
    $MTMov = new VtaTipoMovModel;

    $r = $MSis -> getSistema();
    if (isset($r)) {
      $pv = $r->sucursal_inicio;
    }else{
      $pv = 1;
    }    

    $r = $MTMov -> getTipoMov($pv,301);
    if (isset($r)) {
      $nc =  $r->ult_num_c + 1;
      $ubicaCaja = $r->ubica_caja;
      $ubicacc = $r->ubica_ctacte_cir;
      $ubicap = $r->ubica_ctacte_prof;
    }
    else{
      $nc = 0;
      $ubicaCaja = "N";
      $ubicacc = "H";
      $ubicap = "H";
    }  

   
    
    $data = ['fecha' => $fecha, 'tipo_movvta' => $tipocomp, 'id_cliente' =>$idcli, 'total' => $total, 'subtotal'=>$subtotal, 'otros_concepto'=>$otros, 'ubicacion_ctacte'=>$ubicacc, 'estado'=>'X', 'estado_pago'=>'P', 'cae'=>'0', 'fecha_vto_cae'=>$fecha, 'id_usuario_emision'=>session('idUsuario'), 'fecha_hora_emision'=>date("Y-m-d h:i:s"), 'ubicacion_caja' => $ubicaCaja, 'cliente'=>$cliente, 'sucursal' => $pv, 'num_comprobante'=>$nc, 'letra'=>'C', 'contado'=>'N', 'periodo'=>$periodo, 'id_os' =>$idos];
   
    
    //1 agrego la nc
    $MVMov = new VtaMovModel;
    $r0 = $MVMov -> buscarComprobante($tipocomp, 'C', $pv, $nc);
  if(!isset($r0)){    
      //el comprobante no existe
   
   
   
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
        $datos = ["id_tipolog"=>11, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"VtaMovimientos", "id_registro"=>$idmovvta] ; 
        $MLog = new LogsModel;
        $MLog -> insert($datos);

        
        //2 modifico el numerador
        $r6 = $MTMov -> actualizaNumerador($pv, $tipocomp, $nc);

        $f = "C" . str_pad($pv, 4, "0", STR_PAD_LEFT) . "-" . str_pad($nc, 10, "0", STR_PAD_LEFT);
        
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
                       
                    $r5 = $MU -> buscarPorId($idprof);

                    //actualizo estado liquidacion
                    $dataL = ['bonos_anticipos'=>$arrayimp[$clave], 'id_mov_vta_bono' =>  $idmovvta, 'fecha_bono' => $fecha];    
                    $r2 = $MLiq -> update($valor, $dataL);   
                   
                   $detalleItem = 'Bonos/Anticipos s/ fact.'. $factura . ' '. substr($r5->nombre,0,101) . ' ' . $r5->matricula;
                   $detalle = "NC Int. " . $f . " por Bonos/Anticipos";  
                   
                   
                    //actualizo detalle Nc
                    $dataD = ['id_vta'=>$idmovvta, 'renglon'=> $clave + 1, 'id_liquidacion'=>$valor, 'id_producto'=>0, 'detalle'=> $detalleItem, 'pu'=>$arrayimp[$clave], 'cantidad'=>1, 'importe'=>$arrayimp[$clave], 'tasa_iva'=>21];
                    $r4 = $MVDet -> insert($dataD);

                     //actualizo movimientos prof
                     $dataP = ['fecha' => $fecha, 'importe' => $arrayimp[$clave], 'tipo' => $tipocomp, 'estado' => 'X', 'periodo' => $periodo, 'ubicacionP' => $ubicap, 'id_os' => $idosLiq, 'id_liquidacion' => $valor, 'id_mov_vta' => $idmovvta, 'id_profesional' =>$idprof, 'detalle' => $detalle, 'origen' => substr($r5->nombre, 0, 93)."(CIRO)", 'destino' =>substr($cliente, 0, 99), 'id_clientep' => $idcli] ;
                     $r3 = $MMprof -> insert($dataP);
 
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
} //fin nc int bonos



}//fin