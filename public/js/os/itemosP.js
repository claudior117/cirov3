$(document).ready(function () {
   
    $('#idSerchDesc').keyup(function () {
        
        buscaDatos(2);        
    })
    
    
    $('#idSerchCod').keyup(function () {
            
        buscaDatos(3);        
    })
    
      
    $('#idSerchCod').blur(function () {
        $('#idSerchCod').val("")
    })
    
    $('#idSerchDesc').blur(function () {
        
        $('#idSerchDesc').val("")        
    })
    

})


function buscaDatos(tipo){
    $("#tb2").empty()
     var salida = 1
     var qestado = ""
           
         espereShow()
         var lineaBotones = ""
         var lineaEstado = ""
         var lineaEstado2 = "" 
         var arancel, q 
         switch (tipo) {
             case 1:
                 
             case 2:
                 q = " where id_os = " + $('#idIdOs').val() + "  and UPPER(desc_item) like '%" + $("#idSerchDesc").val().toUpperCase() + "%'" //por desc
                 break
             case 3:
                 q = " where id_os = " + $('#idIdOs').val() + " and codigo like '" + $("#idSerchCod").val() + "%'" //por codigo
                 break
         }        
         var u = site_url() + "MostrarItemOsAjaxP" 
         $.ajax({
             url: u,
             async: false,
             type: "POST",
             data: {"q":q},
             dataType: "json",
             success: function (respuesta) {
                 $.each(respuesta, function (key, value) {
                    
                 lineaBotones = "<td></td>" 
                 
                 $("#tb2").append("<tr class='align-middle'>" + lineaBotones + 
                         "<td>" + value.codigo + "</td>" +
                         "<td>" + value.desc_item + "</td>" +
                         "<td class='text-end'><b>" + parseFloat(value.precio).toFixed(2)  + "</b></td>" +
                         "<td class='text-center'>" + value.fecha_ult_actualizacion + "</td>" +
                         "</tr>")
 
                 })
                 espereHide()
             }
         })
        
     }  
    
 