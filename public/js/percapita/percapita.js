$(document).ready(function () {
    
    //inicializacio
    var f = añoActual() + "-" + mesActual() + "-" + "01"   
    $('#idFecha').val(f)
    buscaDatos()

    $('#idSelCliente').change(function(){
        buscaDatos()

    })  
       
    $('#idFecha').change(function(){
        buscaDatos()

    })  
       
    $('#idBtImprimir').click(function () {
        imprimir()
    })
    
    $(document).on( 'click', '.expande', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        
        expande_detalle_venta(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id del mov vta y la fila de la tabla
    })
       
    
    $(document).on( 'click', '.comprime', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        comprime_detalle_venta(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id
    })




   



})
//=====================fin ready eventos===========================
    
function buscaDatos(){
   
    $btnvioleta = ''
    
    $("#tb1").empty()
    
         var lineabotones = "<td></td>"      
         espereShow()
         
 
         //SALDO INICIAL
         var idcli = $("#idSelCliente").val()
         var fd = $("#idFecha").val()
         var u = site_url() + "SaldoCliAjax"
 
         q = "select SUM(CASE percapita WHEN 'S' then otros_conceptos else 0 END) as percapita, SUM(CASE percapita WHEN 'S' then total else 0 END) as total,  SUM(CASE percapita WHEN 'S' then subtotal else 0 END) as liquidaciones from vta_movimientos where fecha <= '" + fd + "'"
         if (idcli > 0){
             q = q + " and id_cliente = " + idcli; 
         }
         var p = 0
         var l = 0
         var t =0   
         $.ajax({
             url: u,
             type: "POST",
             async: false,
             data: {"q": q},
             dataType: "json",
             success: function (respuesta) {
                 if (respuesta.percapita == null) {
                     p = 0
                 }
                 else{
                     p = respuesta.percapita
                }
                if (respuesta.total === null) {
                     t = 0
                 }else{
                     t = respuesta.total
                 }

                 if (respuesta.liquidaciones === null) {
                    l = 0
                }else{
                    l = respuesta.liquidaciones
                }

                 
                 $("#tb1").append("<tr class='align-middle'>" + lineabotones + 
                         "<td class='text-center'>" + fd + "</td>" +
                         "<td>SALDO ANTERIOR</td>" +
                         "<td></td>" +
                         "<td></td>" +
                         "<td class='text-end'>" + parseFloat(l).toFixed(2)  + "</td>" +
                         "<td class='text-end'>" + parseFloat(p).toFixed(2)  + "</td>" +
                         "<td class = 'text-end'>" + parseFloat(t).toFixed(2)  + "</td>" +
                         "</tr>")
 
                
             }
         })
 
 
 
         //MOVIMIENTOS
         var lineabotones = "<td></td>"      
         var u = site_url() + "MovCliPercapitaAjax"
         var saldo = parseFloat(p)
         var comprobante
         
         $.ajax({
             url: u,
             type: "POST",
             async:false,
             data: {"fd": fd, "idcli": idcli},
             dataType: "json",
             success: function (respuesta) {
                 $.each(respuesta, function (key, value) {
                     

                     lineaBotones = "<td class='centrartexto'><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='" + site_url() + "verComprobante/" + value.id_vta + "' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_vta+"'></i></td>" 
                     saldo = saldo +  parseFloat(value.importe_percapita)  
                     comprobante = value.abreviatura + " " + value.letra + " " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0') 
                     $("#tb1").append("<tr class='align-middle' id='" + key + "'>" + lineaBotones + 
                             "<td class='text-center'>" + value.fecha + "</td>" +
                             "<td>" + value.cliente +"</td>" +
                             "<td>"+ comprobante  + "</td>" +
                             "<td>"+ value.periodo  + "</td>" +
                             "<td class='text-end'>" + parseFloat(value.subtotal).toFixed(2)  + "</td>" +
                             "<td class='text-end'>" + parseFloat(value.otros_concepto).toFixed(2)  + "</td>" +
                             "<td class='text-end'>" + parseFloat(value.importe_percapita).toFixed(2)  + "</td>" +
                             "<td class = 'text-end'>" + parseFloat(value.total).toFixed(2)  + "</td>" +
                             "<td class = 'text-end'>" + saldo.toFixed(2)  + "</td>" +
                             "</tr>")
                 })
         }
     })
 
 
         espereHide()
        
     }  
    
 
     function expande_detalle_venta(idvta, fila){
         if(idvta > 0){
             var lineabotones = ""      
             var u = site_url() + "DetalleVtaAjax"
             $.ajax({
                 url: u,
                 type: "POST",
                 async:false,
                 data: {"idvta": idvta},
                 dataType: "json",
                 success: function (respuesta) {
                     $.each(respuesta, function (key, value) {
                         $("#"+fila).after("<tr style='background-color:#fffec2;' class='align-middle ex" + idvta + "'><td></td><td></td>" + 
                                 "<td class=''>" + value.detalle + "</td>" +
                                 "<td class='text-end' >" +  "$ " + parseFloat( value.importe).toFixed(2) +"</td>" +
                                 "<td></td><td></td><td></td><td></td><td></td></tr>")
                        
                                 $("#ex"+idvta).addClass('bi bi-dash-square comprime' )	
                                 $("#ex"+idvta).removeClass('bi bi-plus-square expande') 
             
                                
                     })
             }
         })
         }
     }
    
 
 
     function comprime_detalle_venta(idvta, fila){
        $(".ex" + idvta).remove();
        $("#ex"+idvta).addClass('bi bi-plus-square expande')	
        $("#ex"+idvta).removeClass('bi bi-dash-square comprime') 
        
        }
        
 

        function imprimir(){
            var fd = $("#idFecha").val()
            var idcli =  $('#idSelCliente').val()

            var u = site_url() + "ReportePercapita" + "/" + fd +  "/" + idcli 
            window.location.href = u
            
         }
         