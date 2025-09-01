<?php 
namespace App\Models;

use CodeIgniter\Model;

class MensajesModel extends Model{
    protected $table      = 'mensajes';
    protected $primaryKey = 'id_msj';
    protected $allowedFields = ['mensaje', 'fecha', 'id_usuario', 'tipo'];


public function insertarMensaje($datos){
    //$datos es un array asociativo de tipo ["mensaje"=>fff, "tipo"=>hhhh, "fecha"=2023-01-01, "id_usuario"=1, "duracion"=7 ] 
    $db = db_connect();
    $q = "INSERT INTO mensajes(mensaje, tipo, fecha, id_usuario, duracion) VALUES (" . $db->escape($datos['mensaje']) . ", " . $db->escape($datos['tipo']) . ", '" . $datos['fecha'] . "', " . $datos['id_usuario'] . ", " . $datos['duracion'] . " )";
    
    $db->query($q);
        
}

public function buscaMensajeActivos(){
    //Son aquellos que la fecha de emision + la duracion en dias es menor a la fecha actual  
    $db = db_connect();
    $fechaactual = date('Y-m-d');
    $q = "select * from mensajes where date_add(fecha, interval duracion day) > '$fechaactual'";
    $cons = $db->query($q);
    return $cons->getResultArray();   
}



}