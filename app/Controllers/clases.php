<?php
namespace App\Controllers;
//namespace App;

use App\Models\UsuarioModel;
use App\Models\OsModel;
use App\Models\ClientesModel;
use App\Models\PacientesModel;
use App\Models\ArancelesPropiosModel;

class clases{

    public function selectProfesionales($mt='S'){
        //mt = muestra todos Si / No 


        echo('<select id="idSelProf" class="form-control form-select ms-1">');

        if ($mt=='S'){
                echo('<option value="0">**Todos**</option>');
        }        

        $MUsuario = new UsuarioModel;
        $r = $MUsuario->getProfesionales();
        foreach ($r as $row) {
                echo("<option value='" . $row['id_usuario'] . "'>". $row['nombre'] . "</option>");
        }    
        echo "</select>";       
    }


    public function selectOS($todas='N', $id="idSelOs", $name="nameIdSelOs", $propiedades=""){
        //$todas tiene "S" si muestra opcion todas o "N"(por defecto) si no la muestra 
        //id
        //name
        //propiedades del objeto como required enabled
        echo('<select id="'.$id.'" name="'. $name . '"class="form-control form-select ms-1 "'. $propiedades . '>');
        
        if ($todas == "S"){
            echo('<option value="0">**Todas las OS**</option>');
        }
        $MOs = new OsModel;
        $r = $MOs->getOs("select * from os order by os");
        foreach ($r as $row) {
            echo("<option value='" . $row['id_os'] . "'>". $row['os'] . "</option>");
        } 
        echo "</select>";       
    }


    public function selectClientes($mt='S'){
        //mt = muestra todos Si / No  
        echo('<select id="idSelCliente" class="form-control form-select ms-1">');
        if ($mt=='S'){
                echo('<option value="0">**Todos**</option>');
        }        
        $MCli = new ClientesModel;
        $r = $MCli->getClientes("select * from clientes order by denominacion");
        foreach ($r as $row) {
                echo("<option value='" . $row['id_cliente'] . "'>". $row['denominacion'] . "</option>");
        }    
        echo "</select>";       
    }


    public function selectClientesPercapita($mt='S'){
        //mt = muestra todos Si / No  / P solo percapita
        echo('<select id="idSelCliente" class="form-control form-select ms-1">');
        if ($mt=='S'){
                echo('<option value="0">**Todos**</option>');
        }        
        $MCli = new ClientesModel;
        $r = $MCli->getClientes("select * from clientes where percapita = 'S' order by denominacion");
        foreach ($r as $row) {
                echo("<option value='" . $row['id_cliente'] . "'>". $row['denominacion'] . "</option>");
        }    
        echo "</select>";       
    }


    public function selectItemOS($mt='S', $idos){
        //mt = muestra todos Si / No 
        //idos = obra social de los items

        echo('<select id="idSelIOS" class="form-control form-select ms-1">');

        if ($mt=='S'){
                echo('<option value="0">**Todos**</option>');
        }        

        $M = new OsItemsModel;
        $r = $M->buscarItemsOs();
        foreach ($r as $row) {
                echo("<option value='" . $row['id_itemos'] . "'>". $row['codigo'] . " " . $row['desc_item'] . "</option>");
        }    
        echo "</select>";       
    }


    public function selectItemOSyPropios($mt='S', $idos, $idprof=0){
        //mt = muestra todos Si / No 
        //idos = obra social de los items
        //idprof = profesional para items propios
        if($idprof ==0){
            $idprof= session("idUsuario"); 
        }


        echo('<select id="idSelIOP" class="form-control form-select ms-1">');

        if ($mt=='S'){
                echo('<option value="0">**Todos**</option>');
        }        

        $M = new OsItemsModel;
        $r = $M->buscarItemsOs();
        foreach ($r as $row) {
                echo("<option value='" . $row['id_itemos'] . "'>". $row['codigo'] . " " . $row['desc_item'] . " data-grupo='OS'</option>");
        }
        
        $M = new ArancelesPropiosModel;
        $q = "select * from items_propios where id_profesional = ". $idprof . " order by codigop";
        $r = $M->getAranceles($q);
        foreach ($r as $row) {
                echo("<option value='" . $row['id_itemp'] . "'>". $row['codigop'] . " " . $row['itemp'] . " data-grupo='PROPIOS'</option>");
        }

        echo "</select>";       
    }


    public function selectPacientes($todas='N', $id="idSelPac", $name="nameSelPac", $propiedades=""){
        //$todas tiene "S" si muestra opcion todas o "N"(por defecto) si no la muestra 
        //id
        //name
        //propiedades del objeto como required enabled
        echo('<select id="'.$id.'" name="'. $name . '"class="form-control form-select ms-1 "'. $propiedades . '>');
        
        if ($todas == "S"){
            echo('<option value="0">**Todos los Pacientes**</option>');
        }
        $M = new PacientesModel;
        $q = "select * from pacientes where id_usuario = " . session('idUsuario') . " order by denominacion";
        $r = $M->getPacientes($q);
        foreach ($r as $row) {
            echo("<option value='" . $row['id_paciente'] . "'>". $row['denominacion'] . "</option>");
        } 
        echo "</select>";       
    }






    public function convierteACiroFormat($cod){
        //verificar que el largo del codigo sea 5 (01-01) u 8(01-01-01)
        $codsolonum = "";
        $codsolonum = preg_replace('/[^0-9]+/', '', $cod); 
        //valores posible de $codsolonum: 101 0101 10101 010101
        
        $codci = "00.00";

        if (intVal($codsolonum) > 0){
         //suponemos que si es un numero es un codigo valido
         
         switch (strlen($codsolonum)) {
             case 3:
                 $c1 = substr($codsolonum,0,1);
                 $c2 = substr($codsolonum,1,2);
                 //formateo al formato de ciro
                 $codci = str_pad(intval($c1), 2, "0", STR_PAD_LEFT) . "." . str_pad(intval($c2), 2, "0", STR_PAD_LEFT);
                 break;
             case 4:
                 $c1 = substr($codsolonum,0,2);
                 $c2 = substr($codsolonum,2,2);
                 //formateo al formato de ciro
                 $codci = str_pad(intval($c1), 2, "0", STR_PAD_LEFT) . "." . str_pad(intval($c2), 2, "0", STR_PAD_LEFT);
                 break;
             case 5: 
                 $c1 = substr($codsolonum,0,1);
                 $c2 = substr($codsolonum,1,2);
                 $c3=substr($codsolonum,3,2);
                 $codci = str_pad(intval($c1), 2, "0", STR_PAD_LEFT) . "." . str_pad(intval($c2), 2, "0", STR_PAD_LEFT) . "." . str_pad(intval($c3), 2, "0", STR_PAD_LEFT);
                 break;
             case 6: 
                     $c1 = substr($codsolonum,0,2);
                     $c2 = substr($codsolonum,2,2);
                     $c3=substr($codsolonum,4,2);
                     $codci = str_pad(intval($c1), 2, "0", STR_PAD_LEFT) . "." . str_pad(intval($c2), 2, "0", STR_PAD_LEFT) . "." . str_pad(intval($c3), 2, "0", STR_PAD_LEFT);
                     break;
 
                 
             }
             
          
     }
    
     return $codci;

 }





}//Fin clases

?>