<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\AtencionesModel;

class AtencionesController extends Controller{

    public function index(){
    if (session()->has("idUsuario") && session('rol')=='P') {
        return view('prof/atenciones/index');
    }
      else{
          return redirect()->to(site_url());  
      }
    }



    public function index2(){
        if (session()->has("idUsuario") && session('rol')=='P') {
            $id = $this->request->getGet('id'); // lee ?id=123
            return view('prof/atenciones/index', ['id' => $id]);
        
        }
          else{
              return redirect()->to(site_url());  
          }
        }

    public function Historia(){
            if (session()->has("idUsuario") && session('rol')=='P') {
                return view('prof/historias/index');
            }
              else{
                  return redirect()->to(site_url());  
              }
            }
        


    public function mostrarAtencionesAjax(){
        //muestra las atenciones realizadas a un paciente en una obra social por un profesional
        if (session()->has("idUsuario")) {
            
            $idos = $_POST['idos'];
            $idp = $_POST['idp'];
            $estado  = $_POST['estado'];  //estado T->Todas, S->Sin lIquidar, L -> Liquidadas  
            $tipo  = $_POST['tipo']; 
            
            //$q = "select a.fecha, a.id_itemos, a.elemento, a.cara, a.importe, i.codigo,  i.desc_item, a.id_atencion, a.estado, p.denominacion from atenciones a INNER JOIN items_os i ON  a.id_itemos = i.id_itemos INNER JOIN pacientes p ON a.id_paciente = p.id_paciente where a.id_profesional= " . session('idUsuario');
            //$c = " and ";

            $q2=" where a.id_profesional = " . session("idUsuario");
            $c = " AND ";
            if($idp > 0){
                $q2 = $q2 . $c .  " a.id_paciente = " . $idp;
                $c = " AND ";
             }
             
 
            
 
            
             if($estado != 'T'){
                 $q2 = $q2 . $c .  " a.estado = '" . $estado . "'";
                 $c = " AND ";   
             }
            

             if($tipo != 'T'){ 
               if($tipo=='P'){
                    //sin obra social(propios y os 61)
                    $q2 = $q2 . $c .  " (a.tipo_codigo = '" . $tipo . "' or a.id_os = 61)";
                    $c = " AND ";
               } else{
                    //solo os 
                    $q2 = $q2 . $c .  " (a.tipo_codigo = '" . $tipo . "' and a.id_os <> 61)";
                    $c = " AND ";
               }
                   
            }else{
                if($idos > 0){
                    $q2 = $q2 . $c . " a.id_os = " . $idos;
                    $c = " AND ";   
                }
            }
             
             
             if (isset($_POST['fecha'])) {
                 //la fecha es opcional
                 $fecha = $_POST['fecha'];
                  $q2 = $q2 . $c . " a.fecha >= '" . $fecha . "'";
             } 
 
             


            $q = "SELECT a.*, p.denominacion, COALESCE(os.codigo, ip.codigop)   AS codigo_item,  COALESCE(os.desc_item, ip.itemp)  AS desc_item FROM atenciones a JOIN pacientes p ON a.id_paciente = p.id_paciente LEFT JOIN items_os os ON a.tipo_codigo = 'O' AND a.id_itemos = os.id_itemos ";
            
            $q = $q . " LEFT JOIN items_propios ip ON a.tipo_codigo = 'P' AND a.id_itemos = ip.id_itemp " ;

            $q = $q . $q2 .  " order by a.fecha, a.elemento, a.id_atencion";
 
            //error_log($q);
            
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

     

        public function agregarAtencionesAjax(){
            if (session()->has("idUsuario") && session("rol")=='P') {
                $f =  $_POST['f'];
                $idp =  $_POST['idp'];
                $idos =  $_POST['idos'];
                $iditem =  $_POST['iditem'];
                $p =  $_POST['p'];
                $c =  $_POST['c'];
                $imp =  $_POST['imp'];
                $tipo =  $_POST['tipo'];
                $token =  $_POST['token'];
                $obs =  $_POST['obs'];
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
                    "obs" =>$obs,
                    "id_odontograma" =>0,
                    "id_liquidacion" =>0,
                    "estado" =>$e,
                    "tipo_codigo" => $tipo,
                    "estado_pago" => "N",
                    "fecha_pago" => $f,
                    "id_trans_pago" => 0,
                    "token" => $token,
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


            public function AtencionesLiqAjax(){
                //muestra las atenciones por liquidaciones
                if (session()->has("idUsuario")) {
                    $idliq = $_POST['idliq'];
                                      
                    $q = "select a.fecha, a.id_itemos, a.elemento, a.cara, a.importe, i.codigo,  i.desc_item, a.id_atencion, a.estado, p.denominacion from atenciones a INNER JOIN items_os i ON  a.id_itemos = i.id_itemos INNER JOIN pacientes p ON a.id_paciente = p.id_paciente where a.id_liquidacion = " . $idliq ;
                    if (session('rol')=='P'){
                        $q = $q . " and a.id_profesional= " . session('idUsuario');
                    }
                    
                    $q = $q .  " order by a.fecha, a.elemento, a.id_atencion";
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
        
            


            public function consultarIdAjax(){
                if (session()->has("idUsuario")) {
                    $id = $_POST['id'];
                    $M = new AtencionesModel;
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
                 $obs = $_POST['nameObs'];
                 $tok = $_POST['nameTok'];
                 
                 if (isset($_POST['namePre'])) {
                    $pre = $_POST['namePre'];
                    //armo estructura de datos
                    $data = ["obs" => $obs,
                        "importe" =>$pre,
                        "token" =>$tok,
                        "id_profesional" =>session("idUsuario"),
                    ];
                }else{
                    $data = ["obs" => $obs,
                    "token" =>$tok,
                    "id_profesional" =>session("idUsuario"),
                ];
                }   
               
                //definoi accion
                switch ($f) {
                    case 'M':
                        $this->modifica($data, $id);
                        break;
                    case 'B':
                        $this->elimina($id);
                        break;
                }
                
              }  
        
            }
        

         public function modifica($d, $id){
                $M = new AtencionesModel;
                $r2 = $M->modificar($d, $id);
                
                 echo $r2;
        }
        
        public function elimina($id){
                $M = new AtencionesModel;
                $r2 = $M->eliminar($id);
               
                 echo $r2;
        }


        public function PagoAteIdAjax()
        {
          if (session()->has("idUsuario")) {
             //recibo datos
             $id = $_POST['id'];
             $M = new AtencionesModel;
             $r2 = $M->cambiarEstadoPago($id);
             echo $r2;
            
          }  
    
        }
    



}