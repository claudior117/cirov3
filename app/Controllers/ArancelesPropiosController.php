<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArancelesPropiosModel;


class ArancelesPropiosController extends Controller{

    public function Index()
    {
        if (session()->has("idUsuario")) {
            
            return view('prof/arancelespropios/index');
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function consultarAjax(){
        if (session()->has("idUsuario")) {
            $cod = $_POST['cod'];
            $nombre = $_POST['nombre'];
            
            $q = "select * from items_propios i where i.id_profesional = " . session("idUsuario") ;
        
            if (!empty($cod)){
                $q = $q . " and i.codigop LIKE '%" . $cod ."%'";
            }
    
            if (!empty($nombre)){
                $q = $q . " and UPPER(i.itemp) like UPPER('%".$nombre."%')";
            }
    
            
                
            $M = new ArancelesPropiosModel;
            $r = $M->getAranceles($q); 
            if (isset($r)){
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
            $M = new ArancelesPropiosModel;
            $r = $M->buscarPorId($id); 
            if (isset($r)){
                echo json_encode($r);
            }
            
    
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
         $cod1 = $_POST['nameCod1'];
         $cod2 = $_POST['nameCod2'];
         $cod3 = $_POST['nameCod3'];
         $ite = $_POST['nameIte'];
         $pre = $_POST['namePre'];
         $ci = $_POST['nameSelApl'];
   
         $codigo = "61.".sprintf("%02d", $cod2).".".sprintf("%02d", $cod3);

                  //armo estructura de datos
         $data = ["codigop" => $codigo,
            "itemp" =>$ite,
            "preciop" =>$pre,
            "aplicap" =>$ci,
            "id_profesional" =>session("idUsuario"),
            
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
        $M = new ArancelesPropiosModel;
        $q = "select id_itemp from items_propios where codigop = '". $d["codigop"]."'"; 
        $r3 = $M->getAranceles($q);
        if (empty($r3)) {
            $r2 = $M->agregar($d);
            $r4 = $M->getUltimoId();
            echo $r2;
        }else{
            echo "9";
        }      
}

public function modifica($d, $id){
        $M = new ArancelesPropiosModel;
        $r2 = $M->modificar($d, $id);
        
         echo $r2;
}

public function elimina($id){
        $M = new ArancelesPropiosModel;
        $r2 = $M->eliminar($id);
       
         echo $r2;
}
 

}