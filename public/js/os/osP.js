//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    
        
      
    $('#idBtMostrar').click(function () {
        
        buscaDatos();        
   })

   

  
})
//=====================fin ready eventos===========================
    






//====================FUNCIONES=========================================
function buscaDatos(){
   
  
  
    $("#tb1").empty()
    var salida = 1
    var qestado = ""
          
        espereShow()
        var lineaBotones = ""
        var lineaEstado = ""
        var lineaEstado2 = "" 
        var cant = 0
        $.ajax({
            url: "MostrarOSP",
            type: "POST",
            data: {},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                cant +=1    
                lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItemsOsP/" + value.id_os + "' data-toggle='tooltip' data-placement='top' title='Aranceles'> <i class='bi bi-stack-overflow'></i></a><a id='btnTblPdf' class='btn_tbl_mini_editar'  href='Mostrarpdf/" + value.id_os + "' data-toggle='tooltip' data-placement='top' title='Normas de Trabajo'> <i class='bi bi-filetype-pdf'></i></a></td>" 
                
                $("#tb1").append("<tr class='align-middle'>" + lineaBotones + 
                        "<td>" + value.id_os + "</td>" +
                        "<td>" + value.os + "</td>" +
                        "<td>" + value.fecha_ult_actu_precios + "</td>" +
                        "</tr>")

                })
                $("#tb1").append("<tr class='align-middle'><td></td><td></td>" +
                "<td><b>Cantidad de OS: " + cant + "</b></td>" +
                "<td></td></tr>")

                espereHide()
            }
        })
       
    }  
   











