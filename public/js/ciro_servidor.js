//funciones generales


function calculaEdad(f){
//calcula la edad reciviendo la fecha de nacimiento
  return 11

}


function mesActual(){
    const hoy = new Date();
    return (hoy.getMonth() + 1).toString().padStart(2, '0')

}

function añoActual(){
    const hoy = new Date();
    return hoy.getFullYear()

}

function primerDiaMesActual(){
    var fecha = new Date();
    var mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
    var año = fecha.getFullYear();
    return (año + "-" + mes + "-" + "01")  
}



function fechaActual(){
    var fecha = new Date();
    var dia = (fecha.getDate()).toString().padStart(2, '0');
    var mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
    var año = fecha.getFullYear();
 // muestra la fecha de hoy en formato `MM/DD/YYYY`
    return  año + "-" + mes + "-" + dia

}



function fechaActualGuion(){
    var fecha = new Date();
    var dia = (fecha.getDate()).toString().padStart(2, '0');
    var mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
    var año = fecha.getFullYear();
 // muestra la fecha de hoy en formato `MM/DD/YYYY`
    return  año + "-" + mes + "-" + dia

}

  
function imprimirElemento(nombre) {
    var opcion = confirm("Confirma Imprimir");
    if (opcion == true) {
      var ficha = document.getElementById(nombre);
	  var ventimp = window.open(' ', 'popimpr');
	  ventimp.document.write(ficha.innerHTML);
	  ventimp.document.close();
	  ventimp.print( );
	  ventimp.close();
    }
}


function espereHide(){
    $('#idEspere').css('visibility', 'hidden');
    
}
    
function espereShow(){
    $('#idEspere').css('visibility', 'visible');
}
    

function texto_estado_liquidaciones(letra_estado){
    var $texto
    switch (letra_estado){
        case "B":
            $texto = "Borrador"
            break
        case "E":
            $texto = "Enviada"
            break
        case "F":    
            $texto = "Facturada"
            break
        case "P":    
            $texto = "Paga"
            break      
    }
    return $texto
    
}


function site_url(){
   //var sur = "/cirov3/index.php/"
   var sur = ""
   return sur
   //sin public
}

function ciroMensaje(m, t){
    //t es success o error
    //m es el mensaje
    
    Swal.fire({
        position: 'center',
        icon: t,
        title: m,
        showConfirmButton: false,
        timer: 1500
      })
    
    
}