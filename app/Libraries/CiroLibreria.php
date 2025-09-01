<?php namespace App\Libraries;

class CiroLibreria {

    public function convierteACiroFormat($cod){
        //verificar que el largo del codigo sea 5 (01-01) u 8(01-01-01)
    $codci = "00.00";
    if (strlen($cod) <= 11) {   
        $codsolonum = "";
        $codsolonum = preg_replace('/[^0-9]+/', '', $cod); 
        //valores posible de $codsolonum: 101 0101 10101 010101
        
        

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
  
}      
return $codci;
}
 


public function CiroMensajeOk($m="Base de Datos actualizada"){
  //Mensaje del crud ok  
if(session('message')){
  echo("<script>
  Swal.fire({
    position: 'center',
    icon: 'success',
    title: '" . $m ."',
    showConfirmButton: false,
    timer: 1100
  })</script>");}

}



}