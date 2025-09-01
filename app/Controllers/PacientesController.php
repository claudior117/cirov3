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
            return view('admin/pacientes/index');
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
         $ci = $_POST['nameSelCondIva'];
         $cu = $_POST['nameCu'];
         $te = $_POST['nameTe'];
         $em = $_POST['nameEm'];

         //los chekbox no se envian por post cuando estan seleccionados
         $EP = isset($_POST['nameEP']) ? 1 : 0;
         $EC = isset($_POST['nameEC']) ? 1 : 0;
         $EA = isset($_POST['nameEA']) ? 1 : 0;
         $EH = isset($_POST['nameEH']) ? 1 : 0;
         $ET = isset($_POST['nameET']) ? 1 : 0;
         
         echo($EP);
         

         

         //armo estructura de datos
         $data = ["denominacion" => $de,
            "direccion" =>$di,
            "localidad" =>$lo,
            "id_condiva" =>$ci,
            "cuit" =>$cu,
            "te" =>$te,
            "email" =>$em,
            "esproveedor" =>$EP,
            "escliente" =>$EC,
            "esacopiador" =>$EA,
            "eschofer" =>$EH,
            "estransporte" =>$ET,
            "baja" => 0,
            "fecha_baja" => date("Y-m-d") 
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
        $M = new RelacionesModel;
        $r2 = $M->agregar($d);
        $r4 = $M->getUltimoId();
        if ($r2 != 0){
            $datos = ["mensaje"=>"Se agregó nueva Relacion  Id: ". $r4->lastId . " " . $d['denominacion'], "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
            $Mmsj = new MensajesModel;
            $Mmsj ->insertarMensaje($datos);
        }
         echo $r2;
}

public function modifica($d, $id){
        $M = new RelacionesModel;
        $r2 = $M->modificar($d, $id);
        if ($r2 != 0){
            $datos = ["mensaje"=>"Se modificó Relacion  Id: ". $id . " UP:" . $d['denominacion'], "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
            $Mmsj = new MensajesModel;
            $Mmsj ->insertarMensaje($datos);
        }
         echo $r2;
}

public function elimina($id){
        $M = new RelacionesModel;
        $r2 = $M->eliminar($id);
        if ($r2 != 0){
            $datos = ["mensaje"=>"Se eliminó Relacion  Id: ". $id . " " . $d['denominacion'], "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
            $Mmsj = new MensajesModel;
            $Mmsj ->insertarMensaje($datos);
        }
         echo $r2;
}
 



public function MostrarAjax()
{
    if (session()->has("idUsuario")) {
        
        $M = new RelacionesModel;
        $q = "select * from relaciones r inner join condiva ci on r.id_condiva = ci.id_condiva  order by denominacion";
        $r = $M->get($q);
        if (count($r)>0){
            echo json_encode($r);
        }

      }
      else{
          return redirect()->to(site_url());  
      }
}




public function consultarIdAjax(){
    if (session()->has("idUsuario")) {
        $id = $_POST['id'];
        $M = new RelacionesModel;
        $r = $M->buscarPorId($id); 
        if (isset($r)){
            echo json_encode($r);
        }
        

    }
    else{
        return redirect()->to(site_url());  
    }       
}    


public function consultarDNIAjax(){
    if (session()->has("idUsuario")) {
        $dni = $_POST['dni'];
        $M = new PacientesModel;
        $r = $M->buscarPorDNI($dni); 
        if (isset($r)){
            echo json_encode($r);
        }
    }
    else{
        return redirect()->to(site_url());  
    }       
}    




}