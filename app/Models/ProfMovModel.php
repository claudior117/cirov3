<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProfMovModel extends Model{
    protected $table      = 'prof_movimientos';
    protected $primaryKey = 'id_mov';
    protected $allowedFields = ['fecha', 'importe', 'tipo', 'estado', 'periodo', 'ubicacionP', 'id_os', 'id_liquidacion', 'id_mov_vta','id_profesional', 'detalle', 'origen', 'destino', 'id_clientep'];


    public function getSaldo($q){
        //devuelve el saldo segun la query mandada 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }

    public function getMovimientos($q){
        //devuelve los movimientos la query mandada 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }



    public function queryMovProf($q){
        //devuelve los movimientos la query mandada 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons;
    }





}