<?php 
namespace App\Models;

use CodeIgniter\Model;

class MinimosModel extends Model{
    protected $table      = 'items';
    protected $primaryKey = 'id_item';
    protected $allowedFields = ['codigo', 'item', 'arancel', 'id_tipo_item','fecha_actu'];
    //protected $returnType ="array";


    public function getMin($q){
        //recupera minimos 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }


    public function getMinPorCod($c){
        //recupera minimos por codigo 
        $q = "select * from items where codigo = '$c'";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }


    public function buscarPorId($idl){
        $s = "select * from items where id_item = $idl ";
        
        $db = db_connect();
        $q = $db->query($s);
        return $q->getRow(); //devuelve el primer elemento 
         
        
    }



}