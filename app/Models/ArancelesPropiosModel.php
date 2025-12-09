<?php 
namespace App\Models;

use CodeIgniter\Model;

class ArancelesPropiosModel extends Model{
    protected $table      = 'items_propios';
    protected $primaryKey = 'id_itemp';
    protected $allowedFields = ['id_profesional', 'itemp', 'codigop', 'preciop', 'aplicap'];


    public function getAranceles($q){
        //recupera los profesionales 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
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


    public function buscarPorId($idl){
        $s = "select * from items_propios where id_itemp = $idl ";
        $db = db_connect();
        $q = $db->query($s);
        return $q->getRow(); //devuelve el primer elemento 
        
    }

    public function getUltimoId(){
        $q = "select LAST_INSERT_ID() as lastId";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
        
    }


}