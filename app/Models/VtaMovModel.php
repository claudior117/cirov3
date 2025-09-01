<?php 
namespace App\Models;

use CodeIgniter\Model;

class VtaMovModel extends Model{
    protected $table      = 'vta_movimientos';
    protected $primaryKey = 'id_vta';
    protected $allowedFields = ['fecha', 'tipo_movvta', 'id_cliente', 'total', 'subtotal', 'otros_concepto', 'ubicacion_ctacte', 'estado', 'estado_pago', 'cae', 'fecha_vto_cae', 'id_usuario_emision', 'fecha_hora_emision', 'ubicacion_caja', 'cliente', 'sucursal','num_comprobante', 'letra','periodo','contado', 'id_os', 'percapita','importe_percapita', 'saldo_impago', 'ubicacion_percapita'];



    public function getUltimoId(){
        $q = "select LAST_INSERT_ID() as idMovVta ";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
        
    }

    public function getSaldo($q){
        //devuelve el saldo segun la query mandada 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }


    public function getMovimientos($q){
        //devuelve el saldo segun la query mandada 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }


    public function getMovimiento($q){
        //devuelve el movimiento segun la query  
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }


    public function buscarPorId($id){
        //devuelve el saldo segun la query mandada 
        $q = "Select * from vta_movimientos where id_vta = " . $id;
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }


    public function buscarComprobante($tipo, $letra, $suc, $num) {
        //busca comporbante 
        $q = "Select * from vta_movimientos where tipo_movvta = $tipo and letra='$letra' and sucursal=$suc and num_comprobante = $num";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
    }

    public function getRetAjax($idprof, $periodo){
        //devuelve los movimientos de venta por retenciones de un periodo y un profesional 
        $q = "select id_vta, periodo, total, sucursal, num_comprobante, letra from vta_movimientos vm, usuarios where  vm.id_cliente = usuarios.id_cliente and  tipo_movvta = 500 and periodo = " . $periodo . " and id_usuario = " .  $idprof;   
        
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }

    

   


}