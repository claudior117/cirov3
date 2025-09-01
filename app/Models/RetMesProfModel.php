<?php 
namespace App\Models;

use CodeIgniter\Model;

class RetMesProfModel extends Model{
    protected $table      = 'prof_retmes';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_usuario_retmes';
    protected $allowedFields = ['id_usuario', 'id_retmes', 'cantidad', 'fecha_ult_actu'];


    public function getRetMesporProf($idp){
        
        $q = "select * from prof_retmes inner join prof_retenciones on prof_retmes.id_retmes = prof_retenciones.id_retmes where id_usuario = $idp ";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }
}