<?php 
namespace App\Models;

use CodeIgniter\Model;

class OsModel extends Model{
    protected $table      = 'os';
    protected $primaryKey = 'id_os';
    protected $allowedFields = ['os', 'fecha_ult_actu_precios', 'pdf_normas', 'factura_el_profesional'];


    public function getOs($q){
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

    
    

    


}