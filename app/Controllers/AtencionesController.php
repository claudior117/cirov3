<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\AtencionesModel;

class AtencionesController extends Controller{

    public function mostrarAtencionesAjax(){
        //muestra las atenciones realizadas a un paciente en una obra social por un profesional
        if (session()->has("idUsuario")) {
            $idos = $_POST['idos'];
            $idp = $_POST['idp'];
            $e  = $_POST['estado'];
            
            //estado T->Todas, S->Sin lIquidar, L -> Liquidadas  
            
            $q = "select a.fecha, a.id_itemos, a.elemento, a.cara, a.importe, i.codigo,  i.desc_item, a.id_atencion from atenciones a INNER JOIN items_os i ON  a.id_itemos = i.id_itemos where a.id_profesional= " . session('idUsuario') . " and a.id_paciente = " . $idp . " and a.id_os=". $idos . " and a.estado = '" . $e . "' order by a.fecha, a.elemento, a.id_atencion";

            $M = new AtencionesModel;
            $r = $M->getAtenciones($q); 
            if (isset($r)){
                echo json_encode($r);
            }
        }
        else{
            return redirect()->to(site_url());  
        }       
    }    


    public function borrarAtencionesAjax(){
        if (session()->has("idUsuario") && session("rol")=='P') {
            $id =  $_POST['id'];
            $M = new AtencionesModel;
            $r2 = $M->borrarAte($id);
            if ($r2 != 0){
              //  $datos = ["mensaje"=>"Se eliminó atencion  Id: ". $rs->id, "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
              //  $Mmsj = new MensajesModel;
              //  $Mmsj ->insertarMensaje($datos);
            }
             echo $r2;
            
            }    
        }   
        
        

        public function agregarAtencionesAjax(){
            if (session()->has("idUsuario") && session("rol")=='P') {
                $f =  $_POST['f'];
                $idp =  $_POST['idp'];
                $idos =  $_POST['idos'];
                $iditem =  $_POST['iditem'];
                $p =  $_POST['p'];
                $c =  $_POST['c'];
                $imp =  $_POST['imp'];
                $e = "S";
                $idl = 0; 
                
                $data = ["fecha" => $f,
                    "id_profesional" =>session("idUsuario"),
                    "id_paciente" =>$idp,
                    "id_os" =>$idos,
                    "id_itemos" =>$iditem,
                    "elemento" =>$p,
                    "cara" =>$c,
                    "importe" =>$imp,
                    "observaciones" =>" ",
                    "id_odontograma" =>0,
                    "id_liquidacion" =>0,
                    "estado" =>$e,
                ];
       
               
                $M = new AtencionesModel;
                $r2 = $M->agregarAte($data);
                if ($r2 != 0){
                  //  $datos = ["mensaje"=>"Se eliminó atencion  Id: ". $rs->id, "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>session("idUsuario"), "duracion"=>7] ; 
                  //  $Mmsj = new MensajesModel;
                  //  $Mmsj ->insertarMensaje($datos);
                }
                 echo $r2;
                
                }    
            }       














}