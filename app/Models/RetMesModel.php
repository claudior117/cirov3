<?php 
namespace App\Models;

use CodeIgniter\Model;

class RetMesModel extends Model{
    protected $table      = 'prof_retenciones';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_retmes';
    protected $allowedFields = ['retención', 'valor', 'tipo', 'relacion_porcentaje', 'abreviatura', 'fecha_ult_actu'];

    public function getRetMes($q){
        //devuelve los movimientos la query mandada 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }

    public function getRetMesProf($idp, $idret){
        //devuelve los movimientos la query mandada 
        $q = "select * from prof_retmes where id_usuario = $idp and id_retmes = $idret";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }


    public function getRetMesVta($q){
        //devuelve los movimientos la query mandada 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }

    



}