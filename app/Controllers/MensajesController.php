<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MensajesModel;

class MensajesController extends Controller{

public function MsjActuPrecios($m, $codm){
   //mensaje de actualizacvion de precios
   if (session()->has("idUsuario")) {  
    $MMsj = new MensajesModel;
   
    switch ($codm) {
        case 1:
            $data = ["mensaje"=> $m . ": Actualiacion de precios",
            "fecha"=> date("Y-m-d h:i:s"),
            "id_usuario" =>1,
            "tipo" => "IMPORTANTE",
            "duracion" =>7];
            break;
    
        case 2:
                $data = ["mensaje"=> $m . ": Actualización en la prestación",
                "fecha"=> date("Y-m-d h:i:s"),
                "id_usuario" =>1,
                "tipo" => "IMPORTANTE",
                "duracion" =>7];
                break;
        case 3: 
            //generico
            $data = ["mensaje"=> $m,
            "fecha"=> date("Y-m-d h:i:s"),
            "id_usuario" =>1,
            "tipo" => "IMPORTANTE",
            "duracion" =>7];
             break;        
        }    
   
    $MMsj->insert($data);
    return redirect()->back();
}
else{
    return redirect()->to(site_url());  
}  

}

}