<?php 
namespace App\Models;

use CodeIgniter\Model;

class LiquidacionesModel extends Model{
    protected $table      = 'liquidaciones';
    protected $primaryKey = 'id_liq';
    protected $allowedFields = ['id_usuario', 'periodo', 'mes', 'año','estado', 'fecha_envio', 'fecha_facturado', 'fecha_ult_modificacion', 'id_os', 'factura', 'importe', 'id_mov_vta', 'id_mov_vta_dto', 'id_mov_vta_rbo', 'descuento', 'estado_pago', 'id_mov_transf', 'fecha_rbo', 'fecha_dto', 'fecha_transf', 'incremento', 'id_mov_vta_inc', 'fecha_inc', 'retencion_hecha', 'id_mov_vta_ret', 'fecha_ret', 'bonos_anticipos', 'id_mov_vta_bono', 'fecha_bono' ];
    

    public function getLiquidaciones($q){
        //recupera los profesionales 
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getResultArray();
    }



    public function getUltimoId(){
       //no funciona
        $q = "select LAST_INSERT_ID() as idLiq ";
        $db = db_connect();
        $cons = $db->query($q);
        return $cons->getRow();
        
    }


public function buscarLiqUnica($profesional, $estado, $os, $año, $mes){
    $s = "";
    $qorden = "";
    $conector =" where ";
    $s = "select id_liq, liquidaciones.estado, periodo, os, importe, fecha_envio, fecha_facturado, fecha_ult_modificacion, nombre, liquidaciones.id_os, año, bonos_anticipos  from liquidaciones inner join os on liquidaciones.id_os = os.id_os inner join usuarios on liquidaciones.id_usuario = usuarios.id_usuario ";   
    if ($profesional!='0'){
        $s = $s . $conector . "liquidaciones.id_usuario =" . intval($profesional); 
        $conector = " and ";
    }
                  
    if ($estado!="T"){
        $s = $s . $conector . "liquidaciones.estado='" . $estado . "'";
        $conector = " and ";
    }

    if ($os!='0'){
       
        $s = $s . $conector . "liquidaciones.id_os =" . intval($os); 
        $conector = " and ";
       
    }

    if ($año!='0'){
       
        $s = $s . $conector . "año =" . intval($año); 
        $conector = " and ";
       
    }


    if ($mes!='0'){
       
        $s = $s . $conector . "mes =" . intval($mes); 
        $conector = " and ";
       
    }



    

    
    

    
    $db = db_connect();
    $q = $db->query($s);
    return $q->getRow();
     
    
}



public function buscarLiq($profesional, $estado, $os, $año, $mes=0, $estadoPago='T', $idcliente=0, $orden="P"){
    //orden "P" Profesional "L" Liquidacion  "p" periodo
    $s = "";
    $qorden = "";
    $conector =" where ";
    $s = "select id_liq, liquidaciones.estado, periodo, os, importe, fecha_envio, fecha_facturado, fecha_ult_modificacion, nombre, liquidaciones.id_os, estado_pago,  año, descuento, incremento, fecha_transf, bonos_anticipos  from liquidaciones inner join os on liquidaciones.id_os = os.id_os inner join usuarios on liquidaciones.id_usuario = usuarios.id_usuario ";   
    if ($profesional!='0'){
        $s = $s . $conector . "liquidaciones.id_usuario =" . $profesional; 
        $conector = " and ";
    }
                  
    if ($estado!="T"){
        $s = $s . $conector . "liquidaciones.estado='" . $estado . "'";
        $conector = " and ";
    }else{
        if(session('rol')=='A'){
            $s = $s . $conector . "liquidaciones.estado!='B'";
            $conector = " and ";
        }
    }

    if ($os!='0'){
       
        $s = $s . $conector . "liquidaciones.id_os =" . $os; 
        $conector = " and ";
       
    }

    if ($año!='0'){
       
        $s = $s . $conector . "año =" . $año; 
        $conector = " and ";
       
    }

    if ($mes!='0'){
       
        $s = $s . $conector . "mes =" . $mes; 
        $conector = " and ";
       
    }

    if ($estadoPago!="T"){
        if(session('rol')=='A'){
            $s = $s . $conector . "estado_pago='$estadoPago'";
            $conector = " and ";
        }
    }

    if ($idcliente!=0){
       
        $s = $s . $conector . "os.id_cliente =" . $idcliente; 
        $conector = " and ";
       
    }
    

    switch ($orden) {
        case "p":
            $s = $s . " order by periodo";
            break;
        case "P":
            $s = $s . " order by liquidaciones.id_usuario";
            break;
        case "L":
            $s = $s . " order by id_liq";
            break;
    }                    
    
    $db = db_connect();
    $q = $db->query($s);
    return $q->getResultArray();
     
    
}



public function resumenLiq($profesional, $os, $año, $mes=0, $idcliente=0){
    $s = "";
    $qorden = "";
    $c =" and ";
    $s = "select SUM(IF(estado<>'B', 1,  0)) as cantTotal, SUM(IF(estado<>'B', importe-descuento+incremento,  0)) as impTotal, SUM(CASE estado WHEN 'E' then importe-descuento+incremento else 0 END) as impSinFact, SUM(CASE estado WHEN 'E' then 1 else 0 END) as cantSinFact, SUM(IF(estado='F' or estado = 'P' , importe-descuento+incremento,  0)) as impFact, SUM(IF(estado='F' or estado = 'P' , 1,  0)) as cantFact, SUM(CASE estado_pago WHEN 'P' then importe-descuento+incremento else 0 END) as impRbo, SUM(CASE estado_pago WHEN 'P' then 1 else 0 END) as cantRbo,  SUM(IF((estado='F' or estado = 'P') and estado_pago <> 'P' , 1,  0)) as cantSinRbo, SUM(IF((estado='F' or estado = 'P') and estado_pago <> 'P' , importe-descuento+incremento,  0)) as impSinRbo,  SUM(CASE estado WHEN 'P' then importe-descuento+incremento else 0 END) as impTransf, SUM(CASE estado WHEN 'P' then 1 else 0 END) as cantTransf, SUM(IF(estado='F' and estado_pago = 'P', importe-descuento+incremento,  0)) as impSinTransf, SUM(IF(estado='F' and estado_pago = 'P', 1,  0)) as cantSinTransf,  periodo  from liquidaciones where año = $año ";   
    
    if ($mes!='0'){
        $s = $s . $c . "mes =" . $mes; 
        $c = " and ";
    }

    if ($profesional !='0'){
        $s = $s . $c . "id_usuario =" . $profesional; 
        $c = " and ";
    }


    if ($os !='0'){
        $s = $s . $c . "id_os =" . $os; 
        $c = " and ";
    }


    
    $s = $s . " group by periodo"; 
                        
    
    $db = db_connect();
    $q = $db->query($s);
    return $q->getResultArray();
     
    
}






public function buscarPorId($idl){
    $s = "select liquidaciones.*, os, nombre, matricula, os.id_cliente as id_cliente from liquidaciones inner join os on liquidaciones.id_os = os.id_os inner join usuarios on liquidaciones.id_usuario = usuarios.id_usuario";   
    $s = $s . " where id_liq = $idl ";
    
    $db = db_connect();
    $q = $db->query($s);
    return $q->getRow(); //devuelve el primer elemento 
     
    
}



public function buscarItemsLiq($L=0){
    $s = "";
    $qorden = "";
    $conector =" where ";
    $s = "select * from liq_items inner join items_os on liq_items.id_itemos = items_os.id_itemos where id_liquidacion = $L order by codigo";

    $db = db_connect();
    $q = $db->query($s);
    return $q->getResultArray();
     
    
}


public function historiaLiq($L=0){
    $s = "";
    $qorden = "";
    $conector =" where ";
    if (session('rol')=='A'){
        $s = "SELECT tipo_movvta, vta_movimientos.fecha as fechaMovVta, abreviatura, vta_movimientos.sucursal, num_comprobante, letra  FROM liquidaciones, vta_movimientos, vta_tipo_movimientos WHERE (id_vta = id_mov_vta or id_vta = id_mov_vta_rbo or id_vta = id_mov_vta_dto or  id_vta = id_mov_transf or id_vta = id_mov_vta_ret or id_vta = id_mov_vta_bono)  and vta_movimientos.tipo_movvta = vta_tipo_movimientos.id_tipomov and vta_movimientos.sucursal = vta_tipo_movimientos.sucursal   and id_liq = $L order by tipo_movvta desc";
    }else{
        $s = "SELECT tipo_movvta, vta_movimientos.fecha as fechaMovVta, abreviatura, vta_movimientos.sucursal, num_comprobante, letra  FROM liquidaciones, vta_movimientos, vta_tipo_movimientos WHERE (id_vta = id_mov_vta or id_vta = id_mov_vta_dto or id_vta = id_mov_transf or id_vta = id_mov_vta_ret or id_vta = id_mov_vta_bono)  and vta_movimientos.tipo_movvta = vta_tipo_movimientos.id_tipomov and vta_movimientos.sucursal = vta_tipo_movimientos.sucursal   and id_liq = $L order by tipo_movvta desc";
    }    
    $db = db_connect();
    $q = $db->query($s);
    return $q->getResultArray();
     
    
}



public function buscarLiqPorComp($idcomp){
    //busca todas las liquidaciones de un comprobante de venta
    $s = "";
    $s = "select * from vta_movimientos_detalle where id_vta = " . $idcomp ;   
    
    $db = db_connect();
    $q = $db->query($s);
    return $q->getResultArray();
     
    
}



public function agregarLiq($d){
    $salida = 0;
    $fa = date("Y-m-d"); 
    $db = db_connect();
    $q = "INSERT INTO liquidaciones(id_usuario, periodo, mes, año, estado, fecha_envio, fecha_facturado, fecha_ult_modificacion, id_os, factura, importe, id_mov_vta, id_mov_vta_dto,id_mov_vta_rbo, descuento, estado_pago, retencion_hecha, id_mov_vta_ret, fecha_ret, bonos_anticipos) VALUES (" . $d['id_usuario'] . ", " . $d['periodo'] . ", " . $d['mes'] . ", " . $d['año'] . ", 'B', '" . $fa . "', '" . $fa . "','". $fa . "', " . $d['id_os'] . ", 'A0000-00000000', 0,0,0,0,0,'N','N',0,'".$fa."',0)";
    $cons = $db->query($q);
    //$salida = $db->affectedRows();   
    //busco el id generado
    $idl=0;
    if($cons){
        $q = "select LAST_INSERT_ID() as idLiq ";
        $cons = $db->query($q)->getRow();
        $idl = $cons->idLiq; 
        
        //agrego todos los items en 0;
       
        $MIOs = new OsItemsModel;
        $r = $MIOs->buscarItemsOs($d['id_os']);
        foreach ($r as $valores){
                $q = "insert into liq_items (id_liquidacion, id_itemos, cantidad, pu, importe, fecha_ult_modificacion) values ($idl," . $valores['id_itemos'] . ",0,".$valores['precio']. ", 0, '". date('Y-m-d')."')"; 
               
                $r2 = $db->query($q);
        }   
    
        $datos = ["id_tipolog"=>1, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>$d['id_usuario'], "tabla"=>"Liquidaciones", "id_registro"=>$idl] ; 
        $MLog = new LogsModel;
        $MLog -> insert($datos);

    }


    $salida = $idl; 
    return $salida; //devuelve el id generado
} 


public function agregarItemsLiqNueva($iL, $idos){
    //busco todos los items de la os y los agrego a la liuquidacion
    $MIOs = new OsItemsModel;
     $r = $MIOs->buscarItemsOs($idos);
     if (isset($r)){
        $db = db_connect();
        foreach ($r as $valores){
            $q = "insert into liq_items (id_liquidacion, id_item, cantidad, pu, importe, fecha_ult_modificacion) values ($iL," . $valores['id_item'] . ",0,".$valores['precio']. ", 0, '".  date('Y-m-d')."'"; 
            $r2 = $db->query($q);
        }   
    } 

}


public function borrarLiq($iL){
    //busco todos los items de la os y los agrego a la liuquidacion
    //$s = "DELETE  liquidaciones, liq_items from liquidaciones LEFT JOIN liq_items ON id_liq = id_liquidacion  where id_liq = $iL and id_usuario = " . session("idUsuario") . " and estado = 'B'";
    //$db = db_connect();
    //$q = $db->query($s);

    $db = db_connect();

    $sql = "DELETE liquidaciones, liq_items 
            FROM liquidaciones 
            LEFT JOIN liq_items ON id_liq = id_liquidacion  
            WHERE id_liq = ? 
              AND id_usuario = ? 
              AND estado = 'B'";
    
    $q = $db->query($sql, [$iL, session("idUsuario")]);


    $sql = "UPDATE atenciones SET id_liquidacion=0, estado='S' WHERE id_liquidacion = ?";
    $q = $db->query($sql, [$iL]);

    //actualizo si tiene atenciones
    //$s ="UPDATE atenciones  SET id_liquidacion=0, estado='S' where id_liquidacion=". $iL;
    //$q = $db->query($s);

    $datos = ["id_tipolog"=>3, "fecha"=>date("Y-m-d H:i:s"), "id_usuario"=>session('idUsuario'), "tabla"=>"Liquidaciones", "id_registro"=>$iL] ; 
    $MLog = new LogsModel;
    $MLog -> insert($datos);

}    
    
    


public function sacaImporteTotal($idLiq){
    $s = "select sum(importe) as TotalLiq from liq_items  where id_liquidacion = $idLiq";
    $db = db_connect();
    $q = $db->query($s)->getRow();
    return $q->TotalLiq; 

}


public function totalPagosPorProf($fd, $fh, $prof){
    //calcula todos los pagos realizados por clientes al circulo en el periodo y que no se hayan trasferido
    //lo saco de las liquidaciones del profesional   
    //Se usa para calcular retenciones
    //$s = "SELECT SUM(importe-descuento+incremento) as totalPago , SUM(CASE WHEN id_os = 4 THEN importe-descuento+incremento ELSE 0 END) as totalIoma FROM liquidaciones WHERE id_usuario = $prof and fecha_rbo >= '$fd' and fecha_rbo <= '$fh' and estado_pago <> 'N' ";
    $s = "SELECT SUM(importe-descuento+incremento) as totalPago , SUM(CASE WHEN (id_os = 4 || id_os = 56) THEN importe-descuento+incremento ELSE 0 END) as totalIoma  , SUM(CASE WHEN (id_os = 4 || id_os = 56) THEN importe+incremento ELSE 0 END) as totalIomaSinDescuentos FROM liquidaciones WHERE id_usuario = $prof and estado_pago = 'P' and estado <> 'P' and fecha_rbo >= '" . $fd . "' and fecha_rbo <= '" . $fh . "'";
    $db = db_connect();
    $q = $db->query($s)->getRow();
    return $q; 
}


public function actuLiqRet($fret, $idvtaret, $idprof){
    //actualiza todas las liq con los datos de la retencion
     $s = "update liquidaciones set retencion_hecha = 'S', id_mov_vta_ret = $idvtaret, fecha_ret = '$fret'  WHERE id_usuario = $idprof and estado_pago <> 'N' and  retencion_hecha = 'N'";
    $db = db_connect();
    $q = $db->query($s);
    return $q; 
}

public function actualizaTotales($idl){
    //sumarizo todos los items de la liq y actualizo el importe
        $db = db_connect();

        $q = "UPDATE liquidaciones l
        SET l.importe = (
            SELECT SUM(i.cantidad * i.pu)
            FROM liq_items i
            WHERE i.id_liquidacion = l.id_liq
        )
        WHERE l.id_liq = " . $idl;
        $r2 = $db->query($q);


        //cambio estado  atenciones
        $q = "UPDATE atenciones a
        JOIN liquidaciones l ON a.id_profesional = l.id_usuario
        SET a.estado = 'L', a.id_liquidacion = " . $idl . " WHERE l.id_liq = " . $idl . " AND a.estado = 'S' AND l.id_os = a.id_os";    
        $r3 = $db->query($q);
}

    







}//fin clase