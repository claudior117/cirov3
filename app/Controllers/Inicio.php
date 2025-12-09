<?php

              

namespace App\Controllers;
//Heredamos el modelo usuario
use App\Models\UsuarioModel;
use App\Models\MensajesModel;
use App\Models\LiquidacionesModel;



   
class Inicio extends BaseController
{
    public function index()
    {
        return view('Inicio');
    }

    
    public function InicioIntra()
    {
      if (session()->has("idUsuario")) {
        if (session('rol')=='P') {
                return view('InicioIntraP');
            }
            else{
                return view('InicioIntraA');
        }
      }    
      else{
            return redirect()->to(site_url());  
        }
    }



    public function Login()
    {
        //reecibimos los datos derl formulario del login, puede ser de 2 formas
            //$u = $this->request->getPost('nameUsuario'); 
            //$p = $this->request->getPost('namePassword');
            $u = $_POST['nameUsuario'];
            $p = $_POST['namePassword'];

            $MUsuario = new UsuarioModel;
            $r = $MUsuario->validarUsuario($u, $p);
            if (count($r)>0){
               //Verifico que la contraseña no este vencida
               if($r[0]['antiguedad_contraseña'] <= 100){
                //creo la variable de sesion
                $varS = [
                    'usuario' => $r[0]['nombre'],
                    'rol' => $r[0]['tipo_usuario'],
                    'idUsuario' => $r[0]['id_usuario']
                ];

                $r2 = $MUsuario->sumaEntradaUsuario($r[0]['id_usuario']);

                //inicio la sesion
                session()->set($varS);
                return redirect()->to(site_url() . 'InicioIntra');
               
              }
                else{
                    return redirect()->to(site_url());
                }
            
            }else
            {
                return redirect()->to(site_url());
            }
            
    }


    public function CerrarSesion(){
        session()->destroy();
        return redirect()->to(site_url());
    }


  public function BuscaMensajesAjax(){
      //buscar mensajes para el profesional
      $MMsj = new MensajesModel;
      $r =  $MMsj -> buscaMensajeActivos();
      echo json_encode($r);
      
  }



  public function datosChartAjax(){
    //buscar mensajes para el profesional
    $a = $_POST['año'];
    $MLiq = new LiquidacionesModel;
    $q = "select * from (select sum(CASE WHEN estado <> 'B' then importe-descuento+incremento else 0 END) as total, periodo from liquidaciones where id_usuario = " . session("idUsuario") . " and año = " . $a . " group by periodo desc limit 12) temp order by temp.periodo asc"; 
    $r =  $MLiq -> getLiquidaciones($q);
    echo json_encode($r);
}

public function datosChartAjaxAdmin(){
    //buscar datos grafico liq admin
    $MLiq = new LiquidacionesModel;
    $q = "select * from (select round(sum(CASE WHEN estado <> 'B' then importe-descuento+incremento else 0 END),1) as total, round(SUM(IF(estado='F' or estado = 'P' , importe-descuento+incremento,  0))) as impFact, round(SUM(CASE estado_pago WHEN 'P' then importe-descuento+incremento else 0 END)) as impRbo,  round(SUM(CASE estado WHEN 'P' then importe-descuento+incremento else 0 END)) as impTransf, periodo from liquidaciones group by periodo order by periodo desc limit 7) temp order by temp.periodo asc"; 
    $r =  $MLiq -> getLiquidaciones($q);
    echo json_encode($r);
}



public function datosChartAjax2(){
    //buscar mensajes para el profesional
    $a = $_POST['año'];
    $MLiq = new LiquidacionesModel;
    $q = "select sum(CASE WHEN estado <> 'B' then importe-descuento+incremento else 0 END) as total, sum(CASE WHEN estado = 'P' then importe-descuento+incremento else 0 END) as pagas, os from liquidaciones, os where liquidaciones.id_os = os.id_os and  id_usuario = " . session("idUsuario") . " and año= " . $a . " group by liquidaciones.id_os "; 
    ; 
    $r =  $MLiq -> getLiquidaciones($q);
    echo json_encode($r);
}

public function datosChartAjax3(){
    //buscar mensajes para el profesional
    $a = $_POST['año'];
    $MLiq = new LiquidacionesModel;
    $q = "select SUM(CASE WHEN estado = 'P' then importe-descuento+incremento else 0 END) as totalPagas, SUM(CASE WHEN (estado <> 'P' and estado <>'B') then importe-descuento+incremento else 0 END) as totalImpagas  from liquidaciones where  id_usuario = " . session("idUsuario") . " and año = " . $a ; 
    $r =  $MLiq -> getLiquidaciones($q);
    echo json_encode($r);
}




  public function tutoriales()
    {
        return view('prof/Tutoriales');
    }

public function cambiaContraseña(){
    $p1 = $_POST['namePass1'];
    $p2 = $_POST['namePass2'];
    if ($p1 == $p2){
                
                $MU = new UsuarioModel;
                $r2 = $MU -> buscarPorId(session('idUsuario'));
                
                if ($r2 ->contraseña_anterior!= md5($p1))
                    {
                        $r = $MU -> actualizaPassword(session('idUsuario'), $p1);
                        echo '<script language="javascript">alert("Contraseña actualizada correctamente!!!");window.location.href="' . site_url() . 'InicioIntra"</script>';
                       
                        
                    }else{
                        echo '<script language="javascript">alert("ERROR al actualizar la contraseña: La contraseña no puede ser igual a la anterior !!!");window.location.href="' . site_url() . 'InicioIntra"</script>';
                    }        
             }
         else{
            echo '<script language="javascript">alert("ERROR al actualizar contraseña: Las contraseñas ingresadas no coinciden!!!");window.location.href="' . site_url() . 'InicioIntra"</script>';
         }    
}




}//fin clase