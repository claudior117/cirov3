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
   
   $("#tb1").empty()
   
        var lineabotones = "<td></td>"      
        espereShow()
        

        //SALDO INICIAL
        var idcli = $("#idSelCliente").val()
        var fd = $("#idFecha").val()
        var u = site_url() + "SaldoCliAjax"

        q = "select SUM(CASE ubicacion_ctacte WHEN 'D' then total else 0 END) as debe, SUM(CASE ubicacion_ctacte WHEN 'H' then total else 0 END) as haber  from vta_movimientos where fecha <= '" + fd + "'"
        if (idcli > 0){
            q = q + " and id_cliente = " + idcli; 
        }
        var d, h, saldoAnt   
        $.ajax({
            url: u,
            type: "POST",
            async: false,
            data: {"q": q},
            dataType: "json",
            success: function (respuesta) {
                if (respuesta.debe == null) {
                    d = 0
                }
                else{
                    d = respuesta.debe
                }
                if (respuesta.haber === null) {
                    h = 0
                }else{
                    h = respuesta.haber
                }
                saldoAnt = d - h
                
                $("#tb1").append("<tr class='align-middle'>" + lineabotones + 
                        "<td class='text-center'>" + fd + "</td>" +
                        "<td>SALDO ANTERIOR</td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td class='text-end'>" + parseFloat(d).toFixed(2)  + "</td>" +
                        "<td class='text-end'>" + parseFloat(h).toFixed(2)  + "</td>" +
                        "<td class = 'text-end'>" + parseFloat(saldoAnt).toFixed(2)  + "</td>" +
                        "</tr>")

               
            }
        })



        //MOVIMIENTOS
        var lineabotones = "<td></td>"      
        var u = site_url() + "MovCliAjax"
        var saldo = saldoAnt
        var comprobante
        
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"fd": fd, "idcli": idcli},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    if (value.ubicacion_ctacte == 'D') {
                        d = value.total
                        h = 0
                    }
                    else{
                        h = value.total
                        d = 0
                    }
                    lineaBotones = "<td class='centrartexto'><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='" + site_url() + "verComprobante/" + value.id_vta + "' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_vta+"'></i></td>" 
                    saldo = saldo + parseFloat(d) - parseFloat(h) 
                    comprobante = value.abreviatura + " " + value.letra + " " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0') 
                    $("#tb1").append("<tr class='align-middle' id='" + key + "'>" + lineaBotones + 
                            "<td class='text-center'>" + value.fecha + "</td>" +
                            "<td>" + value.cliente +"</td>" +
                            "<td>"+ comprobante  + "</td>" +
                            "<td>"+ value.periodo  + "</td>" +
                            "<td class='text-end'>" + parseFloat(d).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(h).toFixed(2)  + "</td>" +
                            "<td class = 'text-end'>" + parseFloat(saldo).toFixed(2)  + "</td>" +
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
                        $("#"+fila).after("<tr style='background-color:#fffec2;' class='align-middle ex" + idvta + "'><td></td><td>Liq. "+ value.id_liquidacion + "</td>" + 
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
