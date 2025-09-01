$(document).ready(function () {
    //actualiza lista completa
    $('#IdBtnActualizar').click(function () {
        //alta
        var o = confirm("Confirma actualizar lista de precios")
        if (o == true) {
           //funcion guardar
          
           const entradas = document.getElementsByClassName("claseInputItem");
           if(entradas && entradas.length > 0){
            for(let i=0;i<entradas.length;i++){
               actualizaItems(entradas[i].value, entradas[i].id)
                 
            }

            if ($("#chb1").prop('checked')) {
                window.location.href = site_url() + "MsjActuPrecios/" + $("#idos").val()+"/1";
            }

            bdactualizada()


            
         } 
           
        }
    })

        $('#IdBtnAgregarItemOs').click(function () {
            //alta
            var o = confirm("Confirma agregar prestación a Obra Social")
            if (o == true) {
               //funcion guardar
               $("input:checkbox[class=chbagregaritemos]:checked").each(function(){
                let v = $(this).attr('id');
                agregaItemOs(v, $("#idIdOs").val())
                });
            }
    
            if ($("#chb1").prop('checked')) {
                window.location.href = site_url()  + "MsjActuPrecios/" + $("#idos").val()+"/2";
            }
            bdactualizada()
       })




})


function bdactualizada(){
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Base de Datos actualizada',
        showConfirmButton: false,
        timer: 1100
      })    
}

function actualizaItems(precio, idio){    
    
    espereShow()
    $.ajax({url: site_url() + "actualizaPrecios",
            type: "POST",
            async: false,
            data: { "iditemos": idio, "precio": precio},
            dataType: "json",
            success: function (respuesta) {
              
           }
      })
       espereHide()
   }

function  agregaItemOs(iditem, idos){    
    espereShow()
    $.ajax({url: site_url() + "agregaItemOs",
            type: "POST",
            async: false,
            data: { "iditem": iditem, "idos": idos},
            dataType: "json",
            success: function (respuesta) {
              
           }
      })
       espereHide()
   }




   function actualizaItems2(idio){
    var o = confirm("Está por cambiar el precio de un Item individual para la obra social. ¿Confirma?")
    if (o == true) {
       var p = $("#"+idio).val()
       actualizaItems(p, idio)
       bdactualizada() 
    }
}     
   
 function borrarItemOs(idio){
    var o = confirm("Va eliminar un item de la lista de precios de la Obra social. ¿Confirma?")
    if (o == true) {
       
        espereShow()
        $.ajax({url: site_url() + "BorrarItemOs",
                type: "POST",
                async: false,
                data: {"iditemos":idio},
                dataType: "json",
                success: function (respuesta) {
                   
               }
          })
           espereHide()

        }        
        window.location.reload(true)
        
    }
  
