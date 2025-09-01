<?php 
namespace App\Models;

use CodeIgniter\Model;

class AtencionesModel extends Model{
    protected $table      = 'atenciones';
    protected $primaryKey = 'id_atencion';
    protected $allowedFields = ['fecha', 'id_profesional', 'id_paciente', 'id_os', 'id_itemos', 'elemento', 'cara', 'importe', 'id_liquidacion', 'estado'];
    
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
    

    public function borrarAte($id){
        //
        $salida = 0;
        $db = db_connect();
        $this->delete($id);
        $salida = $db->affectedRows();  
        return $salida; // 0 si no la agrega y 1 si la agrega
    
    }    
        
    public function agregarAte($d){
        //
        $salida = 0;
        $db = db_connect();
        $this->insert($d);
        $salida = $db->affectedRows();  
        return $salida; // 0 si no la agrega y 1 si la agrega
    
    }    
    
    
    

    

}