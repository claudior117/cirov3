<?php 
namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model{
    protected $table      = 'clientes';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = ['denominacion', 'direccion', 'localidad', 'cuit', 'tipo_iva', 'cp', 'te', 'percapita'];
    
    public function getClientes($q){
        //recupera los profesionales 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }

    public function buscarPorId($idl){
        $s = "select * from clientes where id_cliente = $idl ";
        
        $db = db_connect();
        $q = $db->query($s);
        return $q->getRow(); //devuelve el primer elemento 
         
        
    }

}