<?php 
namespace App\Models;

use CodeIgniter\Model;

class OsItemsModel extends Model{
    protected $table      = 'items_os';
    protected $primaryKey = 'id_itemos';
    protected $allowedFields = ['precio', 'coseguro', 'fecha_ult_actualizacion', 'id_item', 'id_os', 'codigo', 'desc_item', 'tasa_iva', 'cant_max_liq','activo'];


    public function buscarItemsOs($idl){
        //busca todos los items de una os
        $s = "select * from items_os  inner join os on items_os.id_os = os.id_os where items_os.id_os = $idl and activo = 1 order by codigo ";
        $db = db_connect();
        $cons = $db->query($s);
        return $cons->getResultArray();
        
    }
    
    public function buscarNoItemsOs($idos){
     //busca todos los items que no estan agrgados a la obra social
    $q = "SELECT * FROM items WHERE id_item NOT IN (SELECT id_item FROM items_os where id_os=$idos) order by codigo";
    $db = db_connect();
    $cons = $db->query($q);
    return $cons->getResultArray();
    }    


    public function buscaItemporId($id){
        //busca un item por id en la tabla item
        //devuelve una sola fila
       $q = "SELECT * FROM items WHERE id_item = $id";
       $db = db_connect();
       $cons = $db->query($q);
       return $cons->getRow();
       }    
   
       public function  getItemOsporId($ii, $idos){

        $q = "SELECT * FROM items_os WHERE id_item = $ii and id_os = $idos";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();

       }

       public function  getItemOsporCod($cod, $idos){

        $q = "SELECT * FROM items_os WHERE codigo ='$cod' and id_os = $idos";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();

       }

       public function  getItemOs($q){
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();

       }

       

       public function buscarOsenItems($idi){
        $s = "select * from os  inner join  items_os on os.id_os = items_os.id_os  where id_item = $idi ";
        $db = db_connect();
        $cons = $db->query($s);
        return $cons->getResultArray();
        
    }


}