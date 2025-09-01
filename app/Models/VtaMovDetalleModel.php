<?php 
namespace App\Models;

use CodeIgniter\Model;

class VtaMovDetalleModel extends Model{
    protected $table      = 'vta_movimientos_detalle';
    protected $primaryKey = 'id_mov_detalle';
    protected $allowedFields = ['id_vta', 'renglon', 'id_liquidacion', 'id_producto', 'detalle', 'pu', 'cantidad', 'importe', 'tasa_iva', 'descuento'];


    public function buscarPorId($id){
        //devuelve los detalles de los comporbantes y su asociacion con  las liquidaciones 
        $q = "select fecha_rbo, detalle, vmd.importe, id_liquidacion, estado_pago, renglon, cantidad, pu, id_mov_detalle from  vta_movimientos_detalle vmd, liquidaciones where id_liquidacion = id_liq and id_vta = " . $id;
       
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }


    public function buscarPorId2($id){
        //devuelve los detalles de los comporbantes sin  las liquidaciones 
        $q = "select detalle, importe, id_liquidacion, renglon, cantidad, pu from  vta_movimientos_detalle where id_vta = " . $id;
       
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }


    public function borrarItemsComp($idvta){
        //borra todos los renglones de un comprobante de venta 
        $q = "delete from  vta_movimientos_detalle where id_vta = " . $idvta;
       
        $db = db_connect();
        $db->query($q);
        return $db->affectedRows();
    }


    public function buscarProfenComp($idprof, $idvta){
        //busca en el detalle del comp el profesional(con id_liq atravez de liquidaciones)
        $q = "select vmd.id_vta, id_liquidacion, vmd.importe, detalle,  id_usuario, sucursal, num_comprobante, letra, tipo_movvta, liquidaciones.periodo, liquidaciones.id_os, cliente, id_cliente, descuento, incremento, bonos_anticipos, liquidaciones.importe as importeliq  from  vta_movimientos_detalle vmd inner join liquidaciones on id_liq = id_liquidacion  inner join vta_movimientos vm on  vmd.id_vta = vm.id_vta where vmd.id_vta = " . $idvta . " and id_usuario = " . $idprof ;
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();

        
    }


    
    

}