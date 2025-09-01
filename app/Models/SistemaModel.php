<?php 
namespace App\Models;

use CodeIgniter\Model;

class SistemaModel extends Model{
    protected $table      = 'g0';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';



    public function getSistema(){
        //recupera los profesionales 
        $q = "select * from g0 where id=1";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }
}
