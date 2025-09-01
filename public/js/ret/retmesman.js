//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    $("#idNumAño").val(añoActual())

    //muestro datos por defecto
    buscaDatos(); 


   $('#idSelProf').change(function () {
        buscaDatos()
    })


    $('#idAño').change(function () {
        buscaDatos()
    })
    
    $('#idMes').change(function () {
        buscaDatos()
    })

    $(document).on('change', '.claseInputCantidad', function(){
        var imp = parseFloat($(this).parents("tr").find("input").eq(1).val()) * $(this).val()
        $(this).parents("tr").find("td").eq(4).text(imp.toFixed(2))
        sumaTabla()
    })
      
 

    $(document).on('change', '.claseInputPu', function(){
        var imp = parseFloat($(this).parents("tr").find("input").eq(0).val()) * $(this).val()
        $(this).parents("tr").find("td").eq(4).text(imp.toFixed(2))
        sumaTabla()
    })
  
  
    $('#idBtGuardar').click(function () {
        //alta
        var msj = ""
        if($("#idIdVta").val()>0){
            msj = "Confirma actualizar la retención mensual"
            var o = confirm(msj)
            if (o == true) {
                //funcion guardar
                var cantidad =[]
                var iditem=[]
                var pu= [] 
                i = 0
                $('.CelImporte').each(function() {
                    cantidad[i]= parseInt($(this).parents("tr").find("input").eq(0).val()) 
                    iditem[i]= parseInt($(this).parents("tr").find("td").eq(0).text()) 
                    pu[i]= parseFloat($(this).parents("tr").find("input").eq(1).val()) 
                    i +=1
                    })
                    actualizaRet(cantidad, iditem, pu )
                    //actualizaLiq();
            }
        }     
    })
  




     $('#idBtImprimir').click(function () {
        $('#modal-header3').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
        $('#idFRImp').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
        $('#idBtImp').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
    
    
        $('#exampleModalLabel3').text('Imprimir' )
        $('#modalImp').modal('show');
    
    })
   
    






})
//=====================fin ready eventos===========================
    
function sumaTabla(){
    //suma columna
    var sum = 0;
    $('.CelImporte').each(function() {
    sum += parseFloat($(this).text());
     });
    $('#idTotal').val(sum.toFixed(2)).css("font-weight","bold" )
   

}





//====================FUNCIONES=========================================
function buscaDatos(){
   
   $btnazul = 'Detalle Items'
   $btnvioleta = 'Enviar Liquidacion'
   $btnrojo = 'Borrar Liquidación '
   $btnverde = 'Agregar'
  
   $('#idBtGuardar').css("display", "block");
   $('#idIdVta').val(0)
   $('#idEstadoPago').val("")
    $("#tb2").empty()
    var salida = 1
    var qestado = ""
          
        espereShow()
        var fe= ""
        var ff = "" 
        var ich = ""        
        var lineaBotones = ""
        var lineaEstado = ""
        var lineaEstado2 = "" 
        var idp = $('#idSelProf').val()
        var an = parseInt($('#idAño').val())
        var mes = parseInt($('#idMes').val())
        
        an = an.toString().padStart(4, '0')
        mes = mes.toString().padStart(2, '0')
        var p = an+mes
        var total = 0
        var u = site_url() + "RetManualItemsAjax"
        var cant = 0
        $.ajax({
            url: u,
            type: "POST",
            async: false,
            data: {"idp": idp , "p":p},
            dataType: "json",
            success: function (respuesta) {
              if (respuesta.length != 0){
                $.each(respuesta, function (key, value) {
                   total = total + parseFloat(value.importemov)
                   if (cant==0){
                       $('#idFecha').val(value.fecha)
                       $('#idIdVta').val(value.idvtamov)
                       $('#idTotal').val(value.total)
                       $('#idEstadoPago').val(value.estado_pago)
                       if (value.estado_pago=='P'){
                        $('#idBtGuardar').css("display", "none");
                       }else{
                        $('#idBtGuardar').css("display", "block");
                       }
                       
                       
                       cant = 1
                    }
                   
                   $("#tb2").append("<tr>" +
                        "<td>" + value.id_mov_detalle + "</td>" +
                        "<td>" + value.detalle + "</td>" +
                        "<td><input type='number' style='width: 90%;'  min=0  class='claseInputCantidad  text-center inputcss m-0' value=" + value.cantidad+ "></td>" +
                        "<td><input type='text' style='width: 90%;'  class='claseInputPu  text-end inputcss m-0' value=" + parseFloat(value.pu).toFixed(2)+ "></td>" +
                        "<td class='text-end CelImporte'><b>" + parseFloat(value.importemov).toFixed(2) + "</b></td>" +
                        "</tr>")

                })

            }
            else{
               
                cargaRetencionNueva()

            }

                /*/total
                $("#tb1").append("<tr class='table-danger'><td></td><td></td><td></td><td>" +
                "<td class='text-end table-danger'><b>TOTAL <b></td>" +
                "<td class='text-end'><b>" + parseFloat(total).toFixed(2) + "</b></td><td></td><td></td><td  class='text-end'><b>Cantidad:</td><td class='text-center'>" + cant + "</b></td><td></td>" +
                "</tr>")
                */
                espereHide()
            }
        })
       
    }  
   




function cargaRetencionNueva(){
    
    $btnazul = 'Detalle Items'
    $btnvioleta = 'Enviar Liquidacion'
    $btnrojo = 'Borrar Liquidación '
    $btnverde = 'Agregar'
   
     $("#tb2").empty()
         var idp = $('#idSelProf').val()
         var an = $('#idAño').val()
         var mes = $('#idMes').val()
         if (isNaN(an)){
             $("#idAño").val(añoActual())
             an = $('#idAño').val()
         }       
 
         if (isNaN(mes)){
             $("#idMes").val(mesActual())
             an = $('#idMes').val()
         }    
         var p = an+mes
         var pu = 0
         $('#idFecha').val(fechaActual())
         $('#idIdVta').val(0)
         $('#idTotal').val(0.00)
         var u = site_url() + "RetManualNuevaAjax"
         $.ajax({
             url: u,
             type: "POST",
             async:false,
             data: {"idp": idp},
             dataType: "json",
             success: function (respuesta) {
                 $.each(respuesta, function (key, value) {
                    if(value.tipo == "I"){
                         pu = value.valor   
                    }else
                    {
                        pu = 0
                    }
                    
                    $("#tb2").append("<tr>" +
                         "<td>0</td>" +
                         "<td>" + value.retencion + "</td>" +
                         "<td>" + value.cantidad + "</td>" +
                         "<td class='text-end'>" + parseFloat(pu).toFixed(2) + "</td>" +
                         "<td class='text-end'><b>" + parseFloat(value.cantidad * pu).toFixed(2) + "</b></td>" +
                         "</tr>")
 
                 })
 
                 
             }
         })
}


function limpiarform() {
    $('#idNuAño2').val(añoActual());
    $('#idNuMes2').val(mesActual());
    
    $('#modal-header').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
    $('#idFR1').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
    $('#idBtAct').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
  

}


function actualizaRet(can, idi, pu){
    //espereShow()    
   
    $.ajax({
            url: site_url() + "ActualizaRetManual",
            type: "POST",
            async: false,
            beforeSend: function(){
              
            }, 
            data: { "arrayCant": JSON.stringify(can), "arrayIdItem":JSON.stringify(idi), "arrayPu":JSON.stringify(pu), "idVta": parseInt($('#idIdVta').val()), "total": parseFloat($('#idTotal').val())},
            dataType: "json",
            success: function (respuesta) {
                if(respuesta!=0) {
                    ciroMensaje("Retención actualizada", "success")
                  }else{
                    ciroMensaje("Imposible actualizar retención", "error")    
                    
            }

              
           }
      })
      
   }
    