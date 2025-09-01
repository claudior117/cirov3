//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    var f = añoActual() + "-" + mesActual() + "-" + "01"   
    $('#idFecha').val(f)
    buscaDatos()

    $('#idSelOs').change(function(){
        buscaDatos()

    })  

    $('#idSelCliente').change(function(){
        buscaDatos()

    })  
       
    $('#idFecha').change(function(){
        buscaDatos()

    })  


    $(document).on( 'click', '.expande', function(){
        expande_detalle_venta(parseInt($(this).attr("id")), parseInt($(this).parents("tr").attr("id")))  //le paso el id del mov vta y la fila de la tabla
    })
       
    
    $(document).on( 'click', '.comprime', function(){
       comprime_detalle_venta(parseInt($(this).attr("id")), parseInt($(this).parents("tr").attr("id")))  //le paso el id
    })

})
//=====================fin ready eventos===========================
    


function buscaDatos(){
    $("#tb1").empty()
   
        var lineabotones = "<td></td>"      
        espereShow()
        

        //SALDO INICIAL
        var idos = $("#idSelOs").val()
        var idcli = $("#idSelCliente").val()
        
        var fd = $("#idFecha").val()
        var u = site_url() + "SaldoProfOsAjax"

        q = "select SUM(CASE ubicacionP WHEN 'D' then importe else 0 END) as debe, SUM(CASE ubicacionP WHEN 'H' then importe else 0 END) as haber  from prof_movimientos where fecha < '" + fd + "'"
        if (idos > 0){
            q = q + " and id_os = " + idos; 
        }

        if (idcli > 0){
            q = q + " and id_clientep = " + idcli; 
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
                        "<td></td>" +
                        "<td class='text-end'>" + parseFloat(d).toFixed(2)  + "</td>" +
                        "<td class='text-end'>" + parseFloat(h).toFixed(2)  + "</td>" +
                        "<td class = 'text-end'>" + parseFloat(saldoAnt).toFixed(2)  + "</td>" +
                        "</tr>")

               
            }
        })



        //MOVIMIENTOS
        var lineabotones = ""      
        var u = site_url() + "MovProfOsAjax"
        var saldo = saldoAnt
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"fd": fd, "idos": idos, "idcli": idcli },
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    if (value.ubicacionP == 'D') {
                        d = value.importe
                        h = 0
                    }
                    else{
                        h = value.importe
                        d = 0
                    }

                    if (value.tipo == 500){
                        lineabotones = "<td class='centrartexto'><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='"+value.id_mov_vta+"'></i></td>"
                    }else{
                        lineabotones = "<td class='centrartexto'></td>"

                    }
                    saldo = saldo + parseFloat(d) - parseFloat(h) 
                    if (value.tipo <= 30 ){
                        if(value.estado == 'P'){
                            estado_pago = "Si" 
                        }else
                        {
                            estado_pago = "No"
                        }
                    }else{
                        estado_pago = ""

                    }
                    
                    $("#tb1").append("<tr class='align-middle' id='" + key + "'>" + lineabotones + 
                            "<td class='text-center'>" + value.fecha + "</td>" +
                            "<td>" + value.detalle +"</td>" +
                            "<td>" + value.origen +"</td>" +
                            "<td>" + value.destino +"</td>" +
                            "<td>"+ value.id_liquidacion + "</td>" +
                            "<td class='text-end'>" + parseFloat(d).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(h).toFixed(2)  + "</td>" +
                            "<td class = 'text-end'>" + parseFloat(saldo).toFixed(2)  + "</td>" +
                            "<td class='text-center'>" + estado_pago +"</td>" +
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
                        
                        $("#"+fila).find("i").addClass('bi bi-dash-square comprime' )	
                        $("#"+fila).find("i").removeClass('bi bi-plus-square expande') 

                               
                    })
            }
        })
        }
    }
   


function comprime_detalle_venta(idvta, fila){
   $(".ex" + idvta).remove();
   $("#"+fila).find("i").addClass('bi bi-plus-square expande')	
   $("#"+fila).find("i").removeClass('bi bi-dash-square comprime') 

}
