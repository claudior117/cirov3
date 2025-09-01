<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VtaMovModel;
use App\Models\UsuarioModel;
use App\Models\RetMesModel;



class InformesController extends Controller{

    public function liquidacionMensualA()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/liqmensual/liqmensual');
          }
          else{
              return redirect()->to(site_url());  
          }
    }

    public function liquidacionMensualP()
    {
        if (session()->has("idUsuario")) {
            return view('prof/liqmensual/liqmensual');
          }
          else{
              return redirect()->to(site_url());  
          }
    }

    public function cuadroLiqMensualA()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            $q = "select * from prof_retenciones";
            $MRet = new RetMesModel;
            $r1 = $MRet->getRetMes($q);
            $data = ["arregloCabeceraRet" => $r1];  
    
            return view('admin/liqmensual/cuadroliqmensual', $data);
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function liqMensualAjax(){
        if (session()->has("idUsuario")) {
                 $a = $_POST['año'];
                 $m = $_POST['mes'] + 1; //todo lo trasnferido en un mes corrsponde al periodo anterior
                 if ($m > 12) {          // por ejemplo selecciono periodo 3, se toman las transfericas del mes 4(abril)
                     $m=1;
                     $a+=1;
                 }
                
                 if (isset($_POST['idprof']) && session('rol') =='A'){ 
                    $idprof = $_POST['idprof'];
                 }else{
                    $idprof = session('idUsuario'); 
                 }   
                 $fd = $a . "-" . $m . "-01";
                 $fh = new \DateTime($fd); 
                 $fh = $fh->format( 'Y-m-t' );
                 $q = "select id_liq, importe, descuento, incremento, bonos_anticipos, liq.estado estadoliq, liq.periodo as periodoliq, cliente, os, sucursal, num_comprobante  from  liquidaciones liq, vta_movimientos vm, os where id_mov_vta_rbo = id_vta and  liq.id_os = os.id_os and id_mov_vta_rbo <> 0 and fecha_transf >= '$fd' and fecha_transf <= '$fh' and liq.id_usuario = $idprof " ;
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


    public function reporteLiqMen($a, $m, $idprof=0){
        
        if($idprof==0){
           $idprof = session('idUsuario');
        }

        $p = str_pad($a, 4, "0", STR_PAD_LEFT) . str_pad($m, 2, "0", STR_PAD_LEFT);
        $m = $m + 1; //todo lo trasnferido en un mes corrsponde al periodo anterior
        if ($m > 12) {          // por ejemplo selecciono periodo 3, se toman las transfericas del mes 4(abril)
                     $m=1;
                     $a+=1;
        }
         
        $fd = $a . "-" . $m . "-01";
        $fh = new \DateTime($fd); 
        $fh = $fh->format( 'Y-m-t' );

        
        //ingresos
        $q1 = "select id_liq, importe, descuento, incremento, bonos_anticipos, liq.estado estadoliq, liq.periodo as periodoliq, cliente, os, sucursal, num_comprobante  from  liquidaciones liq, vta_movimientos vm, os where id_mov_vta_rbo = id_vta and  liq.id_os = os.id_os and id_mov_vta_rbo <> 0 and fecha_transf >= '$fd' and fecha_transf <= '$fh' and liq.id_usuario = $idprof " ;
                
        //retenciones
        $q2 = "select importe, detalle, sucursal, num_comprobante, periodo from vta_movimientos vm inner join  vta_movimientos_detalle vmd  on  vm.id_vta = vmd.id_vta   inner join usuarios on vm.id_cliente = usuarios.id_cliente where  tipo_movvta = 500 and periodo = " . $p . " and id_usuario = " .  $idprof;   
        


        $MProf = new UsuarioModel;
        $prof = $MProf -> buscarPorId($idprof); 

        $MMVta = new VtaMovModel;
        $r1 = $MMVta->getMovimientos($q1);
        $r2 = $MMVta->getMovimientos($q2);
        if(session()->has("idUsuario") && (session("rol")=='A' || session("idUsuario")== $idprof)){ 
                $data = ["arregloIngresos" => $r1, "arregloRet" => $r2, "periodo" => $p, "idprof" => $idprof, "arregloProf" =>$prof];  
    
                return view('admin/liqmensual/reporteliqmen', $data);
    
            }    
    }
    
   








 }//fin clase