//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    $("#idInNumAño").val(añoActual())
    //$("#idInNumMes").val(mesActual())
    //muestro datos por defecto
    buscaDatos();    
    
   

    $('#idBtMostrar').click(function () {
        buscaDatos();        
   })


    $('#idInNumAño').change(function () {
        buscaDatos()
    })
    
    $('#idInNumMes').change(function () {
        buscaDatos()
    })
    

    $('#idSelOs').change(function () {
         buscaDatos()
    })
  
    $('#idSelProf').change(function () {
        buscaDatos()
    })

    $('#idSelCliente').change(function () {
        buscaDatos()
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
    



//====================FUNCIONES=========================================





function buscaDatos(){
   
    $("#tb1").empty()
   
    var salida = 1
    var qestado = ""
    
        espereShow()
        var fe= ""
        var ff = "" 
        var os = $('#idSelOs').val()
        var an = parseInt($('#idInNumAño').val())
        var mes = parseInt($('#idInNumMes').val())
        var idprof = $('#idSelProf').val()
        
        if (isNaN(an)){
            an = 0
        }
        if (isNaN(mes)){
            mes = 0
        }       

        var detalle="OS:" + $('#idSelOs option:selected').text() + " Prof:" + $('#idSelProf option:selected').text()
        var it = 0
        var ct = 0
        var isf =0
        var csf =0
        var iff =0
        var cff =0
        var isr =0
        var csr =0
        var icr =0
        var ccr =0
        var ist =0
        var cst =0
        var itt =0
        var ctt =0
        var u = site_url() + "ResumenLiqAjax"
        $.ajax({
            
            url: u,
            type: "POST",
            data: {"o":os, "a":an, "m":mes, "p":idprof},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                   //$estado = texto_estado_liquidaciones(value.estado)
                   it += parseFloat(value.impTotal)
                   ct +=  parseFloat(value.cantTotal)
                   isf += parseFloat(value.impSinFact)
                   csf +=  parseFloat(value.cantSinFact)
                   iff += parseFloat(value.impFact)
                   cff +=  parseFloat(value.cantFact)
                   isr += parseFloat(value.impSinRbo)
                   csr +=  parseFloat(value.cantSinRbo)
                   icr += parseFloat(value.impRbo)
                   ccr +=  parseFloat(value.cantRbo)
                   ist += parseFloat(value.impSinTransf)
                   cst +=  parseFloat(value.cantSinTransf)
                   itt += parseFloat(value.impTransf)
                   ctt +=  parseFloat(value.cantTransf)
                  
                  
                   $("#tb1").append("<tr>" + 
                        "<td>" + value.periodo + "</td>" +
                        "<td>" + detalle + "</td>" +
                        "<td class='text-end'>" + parseFloat(value.impTotal).toFixed(2) + " (" + parseInt(value.cantTotal) + ")</td>" +
                        "<td class='text-end'>" + parseFloat(value.impSinFact).toFixed(2) + " (" + parseInt(value.cantSinFact) + ")</td>" +
                        "<td class='text-end'>" + parseFloat(value.impFact).toFixed(2) + " (" + parseInt(value.cantFact) + ")</td>" +
                        "<td class='text-end'>" + parseFloat(value.impSinRbo).toFixed(2) + " (" + parseInt(value.cantSinRbo) + ")</td>" +
                        "<td class='text-end'>" + parseFloat(value.impRbo).toFixed(2) + " (" + parseInt(value.cantRbo) + ")</td>" +
                        "<td class='text-end'>" + parseFloat(value.impSinTransf).toFixed(2) + " (" + parseInt(value.cantSinTransf) + ")</td>" +
                        "<td class='text-end'>" + parseFloat(value.impTransf).toFixed(2) + " (" + parseInt(value.cantTransf) + ")</td>" +
                        
                        "</tr>")

                })

                $("#tb1").append("<tr>" + 
                "<td></td>" +
                "<td>Totales</td>" +
                "<td class='text-end'><b>" + parseFloat(it).toFixed(2) + " (" + parseInt(ct) + ")</b></td>" +
                "<td class='text-end'><b>" + parseFloat(isf).toFixed(2) + " (" + parseInt(csf) + ")</b></td>" +
                "<td class='text-end'><b>" + parseFloat(iff).toFixed(2) + " (" + parseInt(cff) + ")</b></td>" +
                "<td class='text-end'><b>" + parseFloat(isr).toFixed(2) + " (" + parseInt(csr) + ")</b></td>" +
                "<td class='text-end'><b>" + parseFloat(icr).toFixed(2) + " (" + parseInt(ccr) + ")</b></td>" +
                "<td class='text-end'><b>" + parseFloat(ist).toFixed(2) + " (" + parseInt(cst) + ")</b></td>" +
                "<td class='text-end'><b>" + parseFloat(itt).toFixed(2) + " (" + parseInt(ctt) + ")</b></td>" +
               
                "</tr>")

                espereHide()
            }
        })
       
    }  
   




    


