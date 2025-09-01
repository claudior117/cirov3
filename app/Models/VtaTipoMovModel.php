<?php 
namespace App\Models;

use CodeIgniter\Model;

class VtaTipoMovModel extends Model{
    protected $table      = 'vta_tipo_movimientos';
    // Uncomment below if you want add primary key
       protected $primaryKey = 'id';
       protected $allowedFields = ['sucursal', 'id_tipo_mov', 'movimiento', 'ult_num_c', 'ubica_ctacte_c', 'ubica_ctacte_p', 'ubica_caja', 'abreviatura'];
 




    public function getTipoMov($sucursal, $tipomov){
        //recupera  
        $q = "select * from vta_tipo_movimientos where sucursal = $sucursal and id_tipomov = $tipomov ";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }
      

    public function actualizaNumerador($sucursal, $tipomov, $numC){
        //recupera  
        $q = "update vta_tipo_movimientos set ult_num_c = $numC where sucursal = $sucursal and id_tipomov = $tipomov ";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons;
    }




    }

