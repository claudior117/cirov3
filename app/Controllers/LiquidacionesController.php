<?php 
namespace App\Controllers;


use CodeIgniter\Controller;
use App\Models\LiquidacionesModel;
use App\Models\LiquidacionesItemsModel;
use App\Models\OsItemsModel;
use App\Models\LogsModel;



class LiquidacionesController extends Controller{

    public function Index()
    {
        if (session()->has("idUsuario")) {
            
            return view('prof/liquidaciones/index');
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function IndexA()
    {
        if (session()->has("idUsuario") && session('rol') == "A") {
            
            return view('admin/liquidaciones/index');
          }
          else{
              return redirect()->to(site_url());  
          }
    }

    public function Buscar()
    {
        if (session()->has("idUsuario")) {
            $profL = session('idUsuario');
            $estadoL = $_POST['e'];
            $osL = $_POST['o'];
            $aL = $_POST['a'];
            $m = $_POST['m'];
            $MLiq = new LiquidacionesModel;
            $r = $MLiq->buscarLiq($profL, $estadoL, $osL, $aL, $m);
            if (count($r)>0){
                echo json_encode($r);
            }
            

          }
          else{
              return redirect()->to(site_url());  
          }
    }



    public function BuscarA()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            
            $profL = $_POST['p'];
            $estadoL = $_POST['e'];
            $osL = $_POST['o'];
            $aL = $_POST['a'];
            $m = $_POST['m'];
            $ep = $_POST['estadoPago'];
            $ic = $_POST['idc'];
            
            $MLiq = new LiquidacionesModel;
            $r = $MLiq->buscarLiq($profL, $estadoL, $osL, $aL, $m, $ep, $ic);
            if (count($r)>0){
                echo json_encode($r);
            }
            

          }
          else{
              return redirect()->to(site_url());  
          }
    }



    public function resumenLiqA()
    {
        if (session()->has("idUsuario") && session('rol') == "A") {
            
            return view('admin/liquidaciones/resumenliq');
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function resumenLiqAjax()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            $profL = $_POST['p'];
            $osL = $_POST['o'];
            $aL = $_POST['a'];
            $m = $_POST['m'];
          
            
            $MLiq = new LiquidacionesModel;
            $r = $MLiq->resumenLiq($profL, $osL, $aL, $m);
            
            if (count($r)>0){
                echo json_encode($r);
            }
            

          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function BuscarItemsLiq($L)
    {
        if (session()->has("idUsuario")) {
            $MLiq = new LiquidacionesModel;
            $r = $MLiq->buscarItemsLiq($L);
            
            $r2 = $MLiq->buscarPorId($L);
            $datos = ["arregloItems"=>$r, "arregloLiq"=>$r2]; 

            if(isset($r2)){
                if ($r2->id_usuario == session("idUsuario")){
                    //tanto arregloRes como idLiq se convierten en variables en la vista como $arregloRes que es un vector, y $idLiq que es una variable simple 
                    return view('prof/liquidaciones/itemsliq', $datos);
                }else{
                    return redirect()->to(site_url());  
                }
            }else{
                return redirect()->to(site_url()); 
            }

          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function BuscarItemsLiqA($L)
    {
        if (session()->has("idUsuario") && session('rol'=='A')) {
            $MLiq = new LiquidacionesModel;
            $r = $MLiq->buscarItemsLiq($L);
            
            $r2 = $MLiq->buscarPorId($L);
            $datos = ["arregloItems"=>$r, "arregloLiq"=>$r2]; 

            //tanto arregloRes como idLiq se convierten en variables en la vista como $arregloRes que es un vector, y $idLiq que es una variable simple 
            return view('admin/liquidaciones/itemsliq', $datos);
            
          }
          else{
              return redirect()->to(site_url());  
          }
    }


   

public function Agregar(){
    if (session()->has("idUsuario")) {
        $mes = $_POST['nameMes2'];
        $año = $_POST['nameAño2'];
        $idos = $_POST['nameSelOS2'];
        $p =  $año . sprintf("%'.02d\n", $mes);
        $fechaactual = date("Y-m-d");
        $data = ["id_usuario"=> session('idUsuario'),
            "periodo"=> intVal($p),
            "mes" =>intVal($mes),
            "año" => intVal($año),
            "id_os" =>intVal($idos),
            "id_mov_vta" => 0,
            "descuento" =>0,
            "id_mov_vta_dto" => 0,
            "id_mov_vta_rbo" => 0,
            "estado_pago" => 'N',
            "id_mov_transf" => 0,
            "fecha_rbo" => '2023-01-01',
            "fecha_dto" => '2023-01-01',
            "fecha_transf" => '2023-01-01',
        ];
    

        
        //inserto la modificacion
        $MLiq = new LiquidacionesModel;
        $r = $MLiq->buscarLiqUnica(session('idUsuario'), 'T', $idos, $año, $mes);
        if (!isset($r)){
            $r2 = $MLiq->agregarLiq($data);
            
            
            echo $r2;
        }
        else{
            echo(0); //la liquidacion ya existe y no se puede agregar
        }
        
        

    }
 
else
{
    //sin sesion
    return redirect()->to(site_url());  
}

}



public function borrarLiq($idL){
    if (session()->has("idUsuario") && session("rol")=='P') {
        $MLiq = new LiquidacionesModel;
        $r = $MLiq->borrarLiq($idL); 
        return redirect()->back()->with('message', 'ok') ;
    }
    else{
        return redirect()->to(site_url());  
    }       
}    


public function enviarLiq(){
    if (session()->has("idUsuario") && session("rol")=='P') {
        
        
        $idL = $_POST['idLiq'];
        $MLiq = new LiquidacionesModel;
        $r = $MLiq->buscarPorId($idL);  
        $fechaActual = date("y-m-d");
        
        if (isset($r)) {
        
            if($r->id_usuario == session('idUsuario') && $r->estado == 'B' ){
                $data = ["estado"=> 'E',
                "fecha_ult_modificacion" =>$fechaActual
            ];
            $r = $MLiq -> update($idL, $data);
             
            
            $MILiq = new LiquidacionesItemsModel;
            $r2 = $MILiq -> deleteItemLiqEnCero($idL);

            $datos = ["id_tipolog"=>4, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"Liquidaciones", "id_registro"=>$idL] ; 
            $MLog = new LogsModel;
            $MLog -> insert($datos);
    
            if($r){
                echo(1);
             }
             else{
                echo(0);
             }   
             
             
            } 
        }    
    }
    else{
        return redirect()->to(site_url());  
    }       
}    




public function actualizaLiq(){
    if (session()->has("idUsuario") && session("rol")=='P') {
        $idLiq = $_POST['idLiq'];
        
        $MLiq = new LiquidacionesModel;
        $r = $MLiq->buscarPorId($idLiq);  
        $fechaActual = date("y-m-d");
        if (isset($r)) {
        
            if($r->id_usuario == session('idUsuario') && $r->estado == 'B' ){
                $importe = $MLiq->sacaImporteTotal($idLiq);
                $data = ["importe"=> $importe,
                "fecha_ult_modificacion" =>$fechaActual
            ];
        
             $r = $MLiq -> update($idLiq, $data);
             if ($r){
                echo(1);
             }else{
               echo(0);  
             }   
    
            $datos = ["id_tipolog"=>2, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"Liquidaciones", "id_registro"=>$idLiq] ; 
            $MLog = new LogsModel;
            $MLog -> insert($datos);
             
            } 
        }    
    }
    else{
        return redirect()->to(site_url());  
    }       
}    



public function AgregaItemLiq(){
    if (session()->has("idUsuario") && session('rol'=='P')) {
        //primero verifico que la  liquidacion que modifico pertenezca al usuario loggeado
        $cantidad = json_decode($_POST['arrayCant'], false);
        $idItemLiq = json_decode($_POST['arrayIdItem'], false);
        $idLiq = $_POST['idLiq'];
        $fechaactual = date("Y-m-d");
       
        for ($i = 0; $i < count($cantidad); $i++){
            $data = ["iditemliq"=> intval($idItemLiq[$i]), "cantidad"=> intval($cantidad[$i])];
            //update
            $MILiq = new LiquidacionesItemsModel;
            $r = $MILiq->updateItemLiq($data);
        }

    }
 
else
{
    //sin sesion
    return redirect()->to(site_url());  
}

}


public function devolverLiq(){
    if (session()->has("idUsuario") && session("rol")=='A') {
        
        
        $idL = $_POST['idLiq'];
        $MLiq = new LiquidacionesModel;
        $r = $MLiq->buscarPorId($idL);  
        $fechaActual = date("y-m-d");
        
        if (isset($r)) {
        
            if($r->estado == 'E' ){
                $data = ["estado"=> 'B',
                "fecha_ult_modificacion" =>$fechaActual
            ];
            $idos = $r->id_os;
            $r = $MLiq->update($idL, $data);
             

            //tengo que poner en cero todos los items no usados de una liquidacion
            //1 busco todos los items 
            $MIOs = new OsItemsModel;
            $r2 = $MIOs->buscarItemsOs($idos);
            $MILiq = new LiquidacionesItemsModel;
            foreach ($r2 as $valores){
                //cada itemos lo busco si existe en la liquidacion
                $r3 = $MILiq -> buscarItemenLiq($idL, $valores['id_itemos']);
                if (!isset($r3)){
                    $data=['id_liquidacion'=>$idL, 'id_itemos' => $valores['id_itemos'], 'cantidad' =>0, 'pu'=>$valores['precio'],'importe'=>0, 'fecha_ult_modificacion'=>$fechaActual];
                    $MILiq -> insert($data);

                }    
            }   

            if($r){
                echo(1);
             }
             else{
                echo(0);
             }   


            $datos = ["id_tipolog"=>5, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"Liquidaciones", "id_registro"=>$idL] ; 
            $MLog = new LogsModel;
            $MLog -> insert($datos);
             

             
            } 
        }    
    }
    else{
        return redirect()->to(site_url());  
    }       
}    

public function revisarLiq(){
    //actualiza valores de aranceles segun precios actuales
    if (session()->has("idUsuario") && session("rol")=='A') {
        $idL = $_POST['idLiq'];
        $MLiq = new LiquidacionesModel;
        $r = $MLiq->buscarPorId($idL);  
        $fechaActual = date("y-m-d");
        if (isset($r)) {
            if($r->estado == 'E' ){
                $r2 = $MLiq ->buscarItemsLiq($idL);  //busco todos los items
                
                $MILiq = new LiquidacionesItemsModel;
                $total = 0;
                foreach($r2 as  $valores) {
                    $data=["pu" => $valores['precio'], "importe" => $valores['precio']*$valores['cantidad'], "fecha_ult_modificacion" => $fechaActual];
                    $MILiq -> update($valores['id_liqitem'], $data);
                    $total = $total + ($valores['precio']*$valores['cantidad']);
                } 
                    $data=["fecha_ult_modificacion"=> $fechaActual, "importe" => $total];
                    $MLiq -> update($idL, $data);

                }  
                echo(1);    
                
                $datos = ["id_tipolog"=>6, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"Liquidaciones", "id_registro"=>$idL] ; 
                $MLog = new LogsModel;
                $MLog -> insert($datos);

            } 
        else{
            echo(0);
        }
        }    
    else{
        return redirect()->to(site_url());  
    }       
}    



public function reporteLiq($idl){
    

    $MLiq = new LiquidacionesModel;

    $r2 = $MLiq ->buscarPorId($idl);
    if (isset($r2)){ 
        if($r2->id_usuario == session('idUsuario') || session('rol')=='A' ){ 
            
            $r =  $MLiq ->buscarItemsLiq($idl);
            $data = ["arregloItems"=>$r, "idliquidacion"=>$idl, "año"=>$r2->año, "mes"=>$r2->mes, "os"=>$r2->os, "prof"=>$r2->nombre, "estado"=>$r2->estado, "fechaEnvio"=>$r2->fecha_envio, "fechaFactura"=>$r2->fecha_facturado];  

            return view('prof/liquidaciones/reporteitemsliq', $data);

            }    
    }

}



public function detalleLiqAjax(){
    if (session()->has("idUsuario")) {
        $idliq = $_POST['idliq'];
        $MLiq = new LiquidacionesModel;
        $r = $MLiq->buscarItemsLiq($idliq);
        if ($r){
           if (session('rol')=='A'){
            echo json_encode($r);
           }else
           {
             $r2 = $MLiq->buscarPorId($idliq);    
             if(session('idUsuario')== $r2->id_usuario){
                echo json_encode($r);
               }
           }
        }
    }
    else{
        return redirect()->to(site_url());  
    }
    }



    public function historiaLiqAjax(){
        if (session()->has("idUsuario")) {
            $idliq = $_POST['idliq'];
            $MLiq = new LiquidacionesModel;
            $r = $MLiq->historiaLiq($idliq);
            if ($r){
               if (session('rol')=='A'){
                echo json_encode($r);
               }else
               {
                 $r2 = $MLiq->buscarPorId($idliq);    
                 if(session('idUsuario')== $r2->id_usuario){
                    echo json_encode($r);
                   }
               }
            }
        }
        else{
            return redirect()->to(site_url());  
        }
        }
    
    



    public function InsertarAjusteLiq(){
        if (session()->has("idUsuario") && session('rol')=='A') {
            $idLiq = $_POST['nameIdLiq'];
            $incremento = $_POST['nameIncremento'];
            $descuento = $_POST['nameDescuento'];
            $fechaactual = date("Y-m-d");
            $data = ["incremento"=> floatVal($incremento),
                "descuento" =>floatVal($descuento),
                "fecha_ult_modificacion" => $fechaactual,
                "fecha_dto" => $fechaactual,
                "fecha_inc" => $fechaactual
            ];
        
    
            
            //inserto la modificacion
            $MLiq = new LiquidacionesModel;
            $r = $MLiq->update($idLiq, $data);
            if ($r){
                echo(1);


            $datos = ["id_tipolog"=>7, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"Liquidaciones", "id_registro"=>$idLiq] ; 
            $MLog = new LogsModel;
            $MLog -> insert($datos);
            }
            else{
                echo(0); //la liquidacion ya existe y no se puede agregar
            }
        }
    else
    {
        //sin sesion
        return redirect()->to(site_url());  
    }
    }
    





}//fin clase