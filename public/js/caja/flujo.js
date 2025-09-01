//=============READY EVENTOS======================
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
       
    $('#idEstadoPago').change(function(){
        buscaDatos()

    }) 
    

    $(document).on( 'click', '.expande', function(){
        expande_detalle_venta(parseInt(($(this).attr("id")).substring(2)), parseInt($(this).parents("tr").attr("id")))  //le paso el id del mov vta y la fila de la tabla
    })
       
    
    $(document).on( 'click', '.comprime', function(){
       comprime_detalle_venta(parseInt(($(this).attr("id")).substring(2)), parseInt($(this).parents("tr").attr("id")))  //le paso el id
    })





})
//=====================fin ready eventos===========================
    


function buscaDatos(){
   
   $btnvioleta = 'Manager Comprobante'
   var idcli = $("#idSelCliente").val()
   var fd = $("#idFecha").val()
   var tipo = $("#idTipo").val()
   var entrada = 0, salida = 0, saldo = 0
   var origen = "", destino = ""
   
   $("#tb1").empty()
   
        var lineabotones = "<td></td>"      
        espereShow()
        

        //MOVIMIENTOS
          
        var u = site_url() + "FlujoCajaAjax"
        var comprobante =""
        
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"fd": fd, "idcli": idcli, "tipo":tipo},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    if(value.ubicacion_caja == "E"){
                        entrada = parseFloat(value.total)
                        salida = 0 
                        saldo = saldo + entrada
                        origen = value.cliente.substring(0,50)
                        destino = "CIRO"
                    }else{
                        entrada = 0
                        salida = parseFloat(value.total) 
                        saldo = saldo - salida
                        origen = "CIRO"
                        destino = value.cliente.substring(0,50)
                    }

                    comprobante = value.abreviatura + " " + value.letra + " " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0') 
                  
                    lineabotones = "<td class='centrartexto'><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='" + site_url() + "verComprobante/" + value.id_vta + "' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_vta+"'></i></td>" 
                   
                    $("#tb1").append("<tr class='align-middle' id='" + key + "'>" + lineabotones + 
                            "<td class='text-center'>" + value.id_vta + "</td>" +
                            "<td class='text-center'>" + value.fecha + "</td>" +
                            "<td>" + origen +"</td>" +
                            "<td>" + destino +"</td>" +
                            "<td>"+ comprobante  + "</td>" +
                            "<td class='text-end'>" + parseFloat(entrada).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(salida).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(saldo).toFixed(2)  + "</td>" +
                            
                            
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
                                "<td class=''>" + value.detalle + "</td><td></td>" +
                                "<td class='text-end' >" +  "$ " + parseFloat( value.importe).toFixed(2) +"</td>" +
                                "<td></td><td></td><td></td><td></td></tr>")
                       
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

   

