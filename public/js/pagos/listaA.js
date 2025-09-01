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
    

})
//=====================fin ready eventos===========================
    


function buscaDatos(){
   
   $btnvioleta = 'Manager Comprobante'
   var idcli = $("#idSelCliente").val()
   var fd = $("#idFecha").val()
   var ep = $("#idEstadoPago").val()
   
   $("#tb1").empty()
   
        var lineabotones = "<td></td>"      
        espereShow()
        

        //MOVIMIENTOS
          
        var u = site_url() + "ListaFactAjax"
        var comprobante =""
        
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"fd": fd, "idcli": idcli, "estadopago":ep},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    if (value.estado_pago=="P"){
                        lineaBotones = "<td class='centrartexto'><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='" + site_url() + "FacturarLiqManager/" + value.id_vta + "' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a></td>" 
                    }else{
                         //habilito boton pago
                        lineaBotones = "<td class='centrartexto'><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='" + site_url() + "FacturarLiqManager/" + value.id_vta + "' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a><a id='btnTblPagar' class ='btn_tbl_mini_borrar' href='" + site_url() + "PagoFact/" + value.id_vta + "' data-toggle='tooltip' data-placement='top' title='Imputar Pago Factura' ><i class='bi bi-currency-dollar'></i></a></td>" 
                    }
                    
                    comprobante = value.abreviatura + " " + value.letra + " " + value.sucursal + "-" + value.num_comprobante 
                    $("#tb1").append("<tr class='align-middle'>" + lineaBotones + 
                            "<td class='text-center'>" + value.id_vta + "</td>" +
                            "<td class='text-center'>" + value.fecha + "</td>" +
                            "<td>" + value.cliente +"</td>" +
                            "<td>"+ comprobante  + "</td>" +
                            "<td class='text-center'>" + value.periodo  + "</td>" +
                            "<td class='text-end'>" + parseFloat(value.total).toFixed(2)  + "</td>" +
                            "<td class = 'text-center'>" + value.estado_pago + "</td>" +
                            
                            
                            "</tr>")
                })
        }
    })


        espereHide()
       
    }  
   

