//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    $("#idInNumAño").val(añoActual())
    $("#idInNumMes").val(mesActual())
    //muestro datos por defecto
   
   //buscaDatos() 
      
       
    $('#idInNumAño').change(function(){
        buscaDatos()
    })  
       
    $('#idInNumMes').change(function(){
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
   var a = $("#idInNumAño").val()
   var m = $("#idInNumMes").val()
   var p = a.padStart(4, '0') + m.padStart(2, '0')
   var u = site_url() + "CuadroLiqMensualAjax"
   var tingresos = 0
   var tretenciones = 0
   var ttotal = 0
   var ttransferir = 0 
   var ttotal = 0
   var imp = 0
   var impRet = 0
   var idprof = 0
   var tingresousuario = 0
   var ttotalusuario = 0
   var ttransferirusuario = 0 
   var tipo = $('#idSelTipo').val()

   $.ajax({
        url: u,
        type: "POST",
        async: false,
        data: {"mes": m, "año":a, "tipo":tipo},
        dataType: "json",
        success: function (respuesta) {
            $.each(respuesta, function (key, value) {
               idcliprof = value.id_cliente
               lineaBotones = "<td class='centrartexto'></td>" 
               imp  = parseFloat(value.simporte) + parseFloat(value.sincremento) - parseFloat(value.sdescuento) - parseFloat(value.sbonos_anticipos)  
               tingresos += imp
               tingresousuario = imp 
               $("#tb1").append("<tr class='' id='" + key + "'>" + lineaBotones + 
               "<td class='text-start'>" + value.nombre + "</td>" + 
               "<td class='text-end'></td></tr>") 


               //retenciones
               var tretusuario = 0
               u = site_url() + "RetDetProfMesAjax"
               $.ajax({
                url: u,
                type: "POST",
                async: false,
                data: {"p": p, "idcliprof":idcliprof},
                dataType: "json",
                success: function (respuesta2) {
                    $.each(respuesta2, function (key2, value2) {
                        impRet  = parseFloat(value2.importe)
                        tretusuario += impRet
                        tretenciones += impRet 
                         $("#tb1").append("<tr><td></td><td></td><td></td><td>" + value2.detalle + "</td><td class='text-end'>" + parseFloat(value2.importe).toFixed(2) + "</td></tr>")
                    })
                    
                } 
                })//fin retenciones
                ttotalusuario = parseFloat(tingresousuario).toFixed(2) - parseFloat(tretusuario).toFixed(2)
                if(ttotalusuario > 0) {
                    ttransferirusuario = ttotalusuario
                }else
                {
                    ttransferirusuario = 0
                }
                $("#tb1").append("<tr class='fw-bold'><td></td><td></td><td class='text-end'>" + parseFloat(tingresousuario).toFixed(2) + "</td><td></td><td class='text-end'>" + parseFloat(tretusuario).toFixed(2) + "</td><td class='text-end'>" + parseFloat(ttotalusuario).toFixed(2) + "</td><td class='text-end'>" + parseFloat(ttransferirusuario).toFixed(2) + "</td></tr>")
                ttotal += ttotalusuario
                ttransferir += ttransferirusuario
                ttransferirusuario = 0
                ttotalusuario = 0

                

            })
        } 
        })//fin cuadro


                $("#tb1").append("<tr></tr><tr><td></td><td class='fw-bold'>TOTALES</td>" + 
                            "<td class='text-end'><b>" + parseFloat(tingresos).toFixed(2)  + "</b></td><td></td>" +
                            "<td class='text-end'><b>" + parseFloat(tretenciones).toFixed(2)  + "</b></td>"+
                            "<td class='text-end'><b>" + parseFloat(ttotal).toFixed(2)  + "</b></td>"+
                            "<td class='text-end'><b>" + parseFloat(ttransferir).toFixed(2)  + "</b></td>"+
                            "</tr>")
                

        
        
        espereHide()
       
    }  
   
    
function imprimir(){
   var a = $("#idInNumAño").val()
   var m = $("#idInNumMes").val()
   var p = a.padStart(4, '0') + m.padStart(2, '0')
   var u = site_url() + "ReporteLiqMen" + "/" +  a + "/" + m +  "/" + $("#idSelProf").val() 
   window.location.href = u
   
}


