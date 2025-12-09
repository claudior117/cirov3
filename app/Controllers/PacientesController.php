<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PacientesModel;
use App\Models\MensajesModel;

class PacientesController extends Controller{
   /*Los controlers de crud tienen:
      index() --> Devuelve la vista con todos los registros
      MostrarAjax() -->Responde a una solicitud js donde se poasan los filtros y se devuelve con ajax los datos para ser mostrados por js 
      AgregarAjax() --> Recibe por ajax de js los datos y los almacena en la BD 
      edit($id), update($id), delete($id) --> actualiza y elimina  
   */
   
  public function Index()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('prof/pacientes/index');
        }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function IndexP()
    {
        if (session()->has("idUsuario") && session('rol')=='P') {
            return view('prof/pacientes/index');
        }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function crudCIAjax()
    {
      if (session()->has("idUsuario")) {
         //recibo datos
         $id = $_POST['nameId'];
         $f =  $_POST['nameFuncion'];
         $de = $_POST['nameDe'];
         $di = $_POST['nameDi'];
         $lo = $_POST['nameLo'];
         $ci = $_POST['nameSelOS2'];
         $cu = $_POST['nameCu'];
         $te = $_POST['nameTe'];
         $em = $_POST['nameEm'];
         $fn = $_POST['nameFN'];
         

                  //armo estructura de datos
         $data = ["denominacion" => $de,
            "direccion" =>$di,
            "localidad" =>$lo,
            "id_os" =>$ci,
            "dni" =>$cu,
            "te" =>$te,
            "email" =>$em,
            "id_usuario" =>session("idUsuario"),
            "tipo"=>'T',
            "fecha_nac"=> $fn
        ];
       
        //definoi accion
        switch ($f) {
            case 'A':
                $this->alta($data);
                break;
            case 'M':
                $this->modifica($data, $id);
                break;
            case 'B':
                $this->elimina($id);
                break;
        }
        

        
      }  


    }

public function alta($d){
        $M = new PacientesModel;

        $q = "select dni from pacientes where dni = " . $d['dni'] . " and id_usuario= " . session("idUsuario");
        $r5 = $M->getPacientes($q);
        if (empty($r5)) {  
                //dni no existe se puede agregar
                $r2 = $M->agregar($d);
                $r4 = $M->getUltimoId();
                if ($r2 != 0){
                    $datos = ["mensaje"=>"Se agregó nuevo Paciente  Id: ". $r4->lastId . " " . $d['denominacion'], "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
                    $Mmsj = new MensajesModel;
                    $Mmsj ->insertarMensaje($datos);
                }
                echo $r2;
            }else
            {
                //el dni existe, no agrego y mando 9 para mostrar mensaje
                echo "9"; 
            }        
}

public function modifica($d, $id){
        $M = new PacientesModel;
        $r2 = $M->modificar($d, $id);
        if ($r2 != 0){
            $datos = ["mensaje"=>"Se modificó Relacion  Id: ". $id . " UP:" . $d['denominacion'], "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
            $Mmsj = new MensajesModel;
            $Mmsj ->insertarMensaje($datos);
        }
         echo $r2;
}

public function elimina($id){
        $M = new PacientesModel;
        $r2 = $M->eliminar($id);
        if ($r2 != 0){
            $datos = ["mensaje"=>"Se eliminó Relacion  Id: ". $id . " " . $d['denominacion'], "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
            $Mmsj = new MensajesModel;
            $Mmsj ->insertarMensaje($datos);
        }
         echo $r2;
}
 


public function consultarIdAjax(){
    if (session()->has("idUsuario")) {
        $id = $_POST['id'];
        $M = new PacientesModel;
        $r = $M->buscarPorId($id); 
        if (isset($r)){
            echo json_encode($r);
        }
        

    }
    else{
        return redirect()->to(site_url());  
    }       
}    


public function consultarAjax(){
    //tipo 1 todos // 2 por nombre //3 por dni
    if (session()->has("idUsuario")) {
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $idos = $_POST['os'];
        
        $q = "select * from pacientes p INNER JOIN os o ON  p.id_os = o.id_os where p.id_usuario = " . session("idUsuario") ;
    
        if (!empty($dni)){
            $q = $q . " and CONVERT(p.dni, CHAR) LIKE '" . $dni ."%'";
        }

        if (!empty($nombre)){
            $q = $q . " and UPPER(p.denominacion) like UPPER('%".$nombre."%')";
        }

        if ($idos > 0){
            $q = $q . " and p.id_os= " . $idos;
        
        }
        
        /*
        switch ($tipo) {
            case 2:
             $q = $q . " and UPPER(p.denominacion) like UPPER('%".$nombre."%')";
             break;
            case 3:
             $q = $q . " and CONVERT(p.dni, CHAR) LIKE '" . $dni ."%'";
             break;
            }           
        */    
        $M = new PacientesModel;
        $r = $M->getPacientes($q); 
        if (isset($r)){
            echo json_encode($r);
        }
    }
    else{
        return redirect()->to(site_url());  
    }       
}    




}