<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre', 'usuario', 'contraseña', 'tipo_usuario', 'estado', 'matricula', 'id_cliente'];

    

    public function __construct()
    {
        parent::__construct();
        $session = \Config\Services::session();
     }
    
    
    public function validarUsuario($u, $p){
        //valida un usuario y contraseña y devuelve los datos en un array 
        $db = db_connect();
        $query = "select * from usuarios where usuario=" . $db->escape($u). " and contraseña='" . md5($p) . "' and estado = 'A'";
        //echo($query);
        $q = $db->query($query);
        return $q->getResultArray();
    }

    public function sumaEntradaUsuario($idu){
        $db = db_connect();
        $query = "update usuarios set antiguedad_contraseña = antiguedad_contraseña + 1  where id_usuario=" . $idu;
        $q = $db->query($query);
    }

    public function actualizaPassword($idu, $p){
        $db = db_connect();
        $query = "update usuarios set contraseña_anterior = contraseña, antiguedad_contraseña = 0, contraseña = '". md5($p) . "'  where id_usuario=" . $idu;
        $q = $db->query($query);
    }

    
    public function getProfesionales(){
        //recupera los profesionales 
        $db = db_connect();
        $cons = $db->query("select * from usuarios where tipo_usuario = 'P' order by nombre");
        return $cons->getResultArray();
    }


    public function buscarPorId($idU){
        //recupera los profesionales 
        $db = db_connect();
        $q = "select * from usuarios where id_usuario = $idU";
        $cons = $db->query($q);
        return $cons->getRow();
    }
}