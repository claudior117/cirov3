<?php 
namespace App\Models;

use CodeIgniter\Model;

class PacientesModel extends Model{
    protected $table      = 'pacientes';
    protected $primaryKey = 'id_paciente';
    protected $allowedFields = ['num_afiliado', 'denominacion', 'direccion', 'dni', 'te', 'localidad', 'fecha_nac', 'tipo', 'dni_titular', 'fecha_alta', 'id_os'];


    public function getPacientes($q){
        //recupera los profesionales 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }

    
    public function buscarPorId($idl){
        $s = "select os, id_os, pdf_normas, factura_el_profesional,  clientes.*  from os inner join clientes on os.id_cliente = clientes.id_cliente where id_os = $idl ";
        
        $db = db_connect();
        $q = $db->query($s);
        return $q->getRow(); //devuelve el primer elemento 
         
        
    }

    public function buscarPorDNI($dni){
        $s = "select *  from pacientes  where dni = $dni ";
        $db = db_connect();
        $cons = $db->query($s);
        return $cons->getResultArray();
         
        
    }
    

    


}