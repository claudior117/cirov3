<?php 
namespace App\Models;

use CodeIgniter\Model;

class G0Model extends Model{
    protected $table      = 'g0';
    // Uncomment below if you want add primary key
     protected $primaryKey = 'id';
     protected $allowedFields = ['sucursal_inicio', 'razon_social', 'direccion', 'telefono','email' ];
    

     public function getParametros(){
        $s = "select * from g0 where id = 1";
        $db = db_connect();
        $q = $db->query($s);
        return $q->getRow(); 
     }

}