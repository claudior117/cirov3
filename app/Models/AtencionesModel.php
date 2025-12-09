<?php 
namespace App\Models;

use CodeIgniter\Model;

class AtencionesModel extends Model{
    protected $table      = 'atenciones';
    protected $primaryKey = 'id_atencion';
    protected $allowedFields = ['fecha', 'id_profesional', 'id_paciente', 'id_os', 'id_itemos', 'elemento', 'cara', 'importe', 'id_liquidacion', 'estado', 'tipo_codigo', 'obs', 'estado_pago', 'fecha_pago', 'id_trans_pago', 'token'];
    
    public function getAtenciones($q){
        //recupera atenciones 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }

    public function buscarPorId($idl){
        $s = "select * from atenciones where id_atencion = $idl ";
            
        $db = db_connect();
        $q = $db->query($s);
        return $q->getRow(); //devuelve el primer elemento 
    }
    

    
        
    public function agregarAte($d){
        //
        $salida = 0;
        $db = db_connect();
        $this->insert($d);
        $salida = $db->affectedRows();  
        return $salida; // 0 si no la agrega y 1 si la agrega
    
    }    
    
    
    public function modificar($d, $id){
        
        $salida = 0;
        $db = db_connect();
        $row = $this -> buscarPorId($id);
        if ($row){
           
            if($row->id_profesional == session('idUsuario')){
           
                $this->update($id, $d);
                $salida = $db->affectedRows();  
          }
        } 
        return $salida; // 0 si no la agrega y 1 si la agrega
} 


    public function eliminar($id){
        $salida = 0;
        $db = db_connect();
        $row = $this -> buscarPorId($id);
        if ($row){
            if($row->id_profesional == session('idUsuario')){
                $this->delete($id);
                $salida = $db->affectedRows();  
          }
        } 
        return $salida; // 0 si no la agrega y 1 si la agrega
    }

    
    public function actualizaSinLiq(){
        //poner como liquidados todas las atenciones en S de OS=61 y toda las atenciones de tipo P del resto de las OS 
        $db = db_connect();
        $q = "UPDATE atenciones  SET estado ='L' WHERE estado = 'S' and id_profesional = ". session('idUsuario');   
        $cons = $db->query($q);
        
} 



public function cambiarEstadoPago($id){
    $salida = 0;
    $db = db_connect();
    $row = $this -> buscarPorId($id);
    if ($row){
        if($row->id_profesional == session('idUsuario') && ($row->tipo_codigo == 'P' || $row->id_os == 61)){
            if($row->estado_pago == 'N'){
                $estadop = 'P';	
            }else{
                $estadop = 'N';
            }
            $data = ["estado_pago" => $estadop,
                ];

            $this->update($id, $data);
            $salida = $db->affectedRows();  
      }
    } 
    return $salida; // 0 si no la agrega y 1 si la agrega
} 

public function actualizaPagoPorLiq($idLiq, $f, $idt){
    //marca como pagas todas las atencuiones de la liquidacion

    $q = "UPDATE atenciones SET estado_pago='P', fecha_pago='" . $f ."', id_trans_pago=".$idt . " where id_liquidacion=" . $idLiq;
    $db = db_connect();
    $cons = $db->query($q);
    }



}
