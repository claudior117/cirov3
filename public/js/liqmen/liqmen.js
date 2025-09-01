//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    $("#idInNumAño").val(añoActual())
    $("#idInNumMes").val(mesActual())
    //muestro datos por defecto
   
   
      
       
    $('#idInNumAño').change(function(){
        buscaDatos()
    })  
       
    $('#idInNumMes').change(function(){
        buscaDatos()
    })  

   
    $('#idSelTipo').change(function () {
        buscaDatos()
    })


    $('#idBtImprimir').click(function () {
        imprimir()
    })

    

   



})
//=====================fin ready eventos===========================
    


function buscaDatos(){
   
   $btnvioleta = 'Manager Comprobante'
   
   $("#tb1").empty()
   var lineabotones = "<td></td>"      
   espereShow()
   var idprof = $("#idSelProf").val()
   var a = $("#idInNumAño").val()
   var m = $("#idInNumMes").val()
   var p = a.padStart(4, '0') + m.padStart(2, '0')
   var u = site_url() + "LiqMensualAjax"
   var tipo = $("#idSelTipo").val()
  
   var idcomp = 0
   var mov =""
   var comprobante = ""

   var subtotal = 0
   var imp = 0
   $.ajax({
        url: u,
        type: "POST",
        async: false,
        data: {"mes": m, "año":a},
        dataType: "json",
        success: function (respuesta) {
            $.each(respuesta, function (key, value) {
                lineaBotones = "<td class='centrartexto'><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_vta+"'></i></td>" 
               // comprobante = value.abreviatura + " " + value.letra + " " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0') 
               imp  = parseFloat(value.importe) + parseFloat(value.incremento) - parseFloat(value.descuento) - parseFloat(value.bonos_anticipos)  
               subtotal += imp 
               if (value.estadoliq == 'P') {
                   estado = "Transferida"
               }else
               {
                   estado = "Sin Transferir" 
               }
               comprobante = "Rbo " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0')
               $("#tb1").append("<tr class='align-middle' id='" + key + "'>" + lineaBotones + 
                        "<td class='text-center'>" + value.id_liq + "</td>" +
                        "<td>" + value.cliente + "-" + value.os + "</td>" +
                        "<td>"+ value.periodoliq  + "</td>" +
                        "<td></td>" +
                        "<td>"+ comprobante + "</td>" +
                        "<td class='text-end'>" + parseFloat(imp).toFixed(2)  + "</td>" +
                        "<td class='text-end'></td>" + "<td class='text-end'></td>"+
                        "<td class='text-center'>"+ estado +"</td>" +
                        "</tr>")
            })
        } 
        })

        var u = site_url() + "RetDetProfMesAjax"
        var subtotalRet = 0
        $.ajax({
            url: u,
            type: "POST",
            async: false,
            data: {"p":p},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                   lineaBotones = "<td class='centrartexto'></td>" 
                   imp  = parseFloat(value.importe)   
                   subtotalRet += imp 
                   comprobante = "Ret " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0')
                   $("#tb1").append("<tr class='align-middle'>" + lineaBotones + 
                            "<td class='text-center'></td>" +
                            "<td></td>" +
                            "<td>"+ value.periodo + "</td>" +
                            "<td>"+ value.detalle + "</td>" +
                            "<td>"+ comprobante + "</td>" +
                            "<td class='text-end'></td>" +
                            "<td class='text-end'>"+  parseFloat(imp).toFixed(2)  +"</td>" + "<td class='text-end'></td>"+
                            "<td class='text-center'></td>" +
                            "</tr>")
                })
                

            } 
            })
            $("#tb1").append("<tr class='align-middle'> <td></td><td></td><td></td><td></td><td></td><td></td><td></td>" + 
            "<td class='text-end'><b>INGRESOS:</b></td>" +
            "<td class='text-end'><b>" + parseFloat(subtotal).toFixed(2)  + "</b></td>" +
            "</tr>")
            $("#tb1").append("<tr class='align-middle'> <td></td><td></td><td></td><td></td><td></td><td></td><td></td>" + 
                            "<td class='text-end'><b>EGRESOS:</b></td>" +
                            "<td class='text-end'><b>" + parseFloat(subtotalRet).toFixed(2)  + "</b></td>" +
                            "</tr>")
            $("#tb1").append("<tr class='align-middle'> <td></td><td></td><td></td><td></td><td></td><td></td><td></td>" + 
                            "<td class='text-end'><b>RESULTADO:</b></td>" +
                            "<td class='text-end'><b>" + parseFloat(subtotal - subtotalRet).toFixed(2)  + "</b></td>" +
                            "</tr>")
    






        
        espereHide()
       
    }  
   
    
function imprimir(){
   var a = $("#idInNumAño").val()
   var m = $("#idInNumMes").val()
   var u = site_url() + "ReporteLiqMenP" + "/" +  a + "/" + m   
   window.location.href = u
   
}


