//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    var f = fechaActual()   
    
    $('#idFechaD').val(f)
    $('#idFechaH').val(f)

    //buscaDatos()

    $('#idSelCliente').change(function(){
        buscaDatos()

    })  
       
    $('#idFechaD').change(function(){
        buscaDatos()

    })  
    
    $('#idFechaH').change(function(){
        buscaDatos()

    })  
    
    $('#idTipo').change(function(){
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
   var fd = $("#idFechaD").val()
   var fh = $("#idFechaH").val()
   var tipo = $("#idTipo").val()
   var origen = "", destino = ""
   
   $("#tb1").empty()
   
        var lineabotones = "<td></td>"      
        espereShow()
        

        //MOVIMIENTOS
          
        var u = site_url() + "VerComprobantesAjax"
        var comprobante =""
        var saldo2 = 0
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"fd": fd, "fh": fh, "idcli": idcli, "tipo":tipo},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                        saldo2 += parseFloat(value.total)
                        origen = value.cliente.substring(0,100)
                        
                    
                    comprobante = value.abreviatura + " " + value.letra + " " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0') 
                  
                    lineabotones = "<td class='centrartexto'><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='" + site_url() + "verComprobante/" + value.id_vta + "' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_vta+"'></i></td>" 
                   
                    $("#tb1").append("<tr class='align-middle' id='" + key + "'>" + lineabotones + 
                            "<td class='text-center'>" + value.id_vta + "</td>" +
                            "<td class='text-center'>" + value.fecha + "</td>" +
                            "<td>" + origen +"</td>" +
                            "<td>"+ comprobante  + "</td>" +
                            "<td>"+ value.periodo  + "</td>" +
                            "<td class='text-end'>" + parseFloat(value.total).toFixed(2)  + "</td>" +
                            "</tr>")
                            
                })
                $("#tb1").append("<tr class='align-middle'><td></td><td></td><td></td><td></td><td></td><td>Total:</td>" +
                "<td class='text-end'>" + parseFloat(saldo2).toFixed(2)  + "</td>" +
                "</tr>")
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

   

