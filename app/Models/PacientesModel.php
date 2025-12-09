<?php 
namespace App\Models;

use CodeIgniter\Model;

class PacientesModel extends Model{
    protected $table      = 'pacientes';
    protected $primaryKey = 'id_paciente';
    protected $allowedFields = ['num_afiliado', 'denominacion', 'direccion', 'dni', 'te', 'localidad', 'fecha_nac', 'tipo', 'dni_titular', 'fecha_alta', 'id_os', 'id_usuario'];


    public function getPacientes($q){
        //recupera los profesionales 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }

    
    public function buscarPorId($idl){
        $s = "select *  from pacientes where id_paciente = $idl ";
        
        $db = db_connect();
        $q = $db->query($s);
        return $q->getRow(); //devuelve el primer elemento 
         
        
    }


public function agregar($d){
        $salida = 0;
        $db = db_connect();
        $this->insert($d);
        $salida = $db->affectedRows();  
        return $salida; // 0 si no la agrega y 1 si la agrega
    } 


    public function modificar($d, $id){
        $salida = 0;
        $db = db_connect();
        $this->update($id, $d);
        $salida = $db->affectedRows();  
        return $salida; // 0 si no la agrega y 1 si la agrega
    } 


    public function eliminar($id){
        $salida = 0;
        $db = db_connect();
        $this->delete($id);
        $salida = $db->affectedRows();  
        return $salida; // 0 si no la agrega y 1 si la agrega
    }


    public function getUltimoId(){
        $q = "select LAST_INSERT_ID() as lastId";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
        
    }


    

  
    


}