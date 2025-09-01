<?php 
namespace App\Models;

use CodeIgniter\Model;

class LiquidacionesItemsModel extends Model{
    protected $table      = 'liq_items';
    protected $primaryKey = 'id_liqitem';
    protected $allowedFields = ['id_liquidacion', 'id_itemos', 'cantidad', 'pu','importe', 'fecha_ult_modificacion'];
    


    public function updateItemLiq($d){

    $db = db_connect();
    $q = "UPDATE liq_items set  cantidad = " . $d['cantidad'] . ", importe = " . $d['cantidad'] . " * pu, fecha_ult_modificacion='" . date('Y-m-d')   . "' where id_liqitem = " . $d['iditemliq'];
    $db->query($q);

   
    }


    public function deleteItemLiqEnCero($idL){

        $db = db_connect();
        $q = "DELETE FROM liq_items WHERE id_liquidacion = $idL and cantidad = 0" ;
        $db->query($q);
    }
    

    public function buscarItemenLiq($idL, $iditem){
        $db = db_connect();
        $q = "select * from liq_items WHERE id_liquidacion = $idL and id_itemos = $iditem" ;
        $cons = $db->query($q)->getRow();
        return $cons;

    }
    


    
    
}