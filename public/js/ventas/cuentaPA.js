//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    var f = añoActual() + "-" + mesActual() + "-" + "01"   
    $('#idFecha').val(f)
   

    $('#idSelOs').change(function(){
        buscaDatos()

    })  

    $('#idSelCliente').change(function(){
        buscaDatos()

    })  


    $('#idSelProf').change(function(){
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
        var idprof = $("#idSelProf").val()
        var fd = $("#idFecha").val()
        var idcli = $("#idSelCliente").val()
        
        var u = site_url() + "SaldoProfOsAjaxA"

        q = "select SUM(CASE ubicacionP WHEN 'D' then importe else 0 END) as debe, SUM(CASE ubicacionP WHEN 'H' then importe else 0 END) as haber  from prof_movimientos where fecha < '" + fd + "'"
        if (idos > 0){
            q = q + " and id_os = " + idos; 
        }

        if (idcli > 0){
            q = q + " and id_clientep = " + idcli; 
        }

        if (idprof > 0){
            q = q + " and id_profesional = " + idprof; 
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
        var lineabotones = "<td></td>"      
        var u = site_url() + "MovProfOsAjaxA"
        var saldo = saldoAnt
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"fd": fd, "idos": idos, "idprof":idprof, "idcli":idcli },
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
                    saldo = saldo + parseFloat(d) - parseFloat(h) 
                    lineabotones = "<td class='centrartexto'><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='" + site_url() + "verComprobante/" + value.id_mov_vta + "' data-toggle='tooltip' data-placement='top' title='Ver comprobante' ><i class='bi bi-box-arrow-up-right'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='"+value.id_mov_vta+"'></i></td>"
                    $("#tb1").append("<tr class='align-middle'  id='" + key + "'>" + lineabotones + 
                            "<td class='text-center'>" + value.fecha + "</td>" +
                            "<td>" + value.detalle +"</td>" +
                            "<td>"+ value.id_liquidacion + "</td>" +
                            "<td>"+ value.origen + "</td>" +
                            "<td>"+ value.destino + "</td>" +
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
                        $("#"+fila).after("<tr style='background-color:#fffec2;' class='align-middle ex" + idvta + "'><td></td><td></td>" + 
                                "<td class=''>" + value.detalle + "</td><td></td>" +
                                "<td class='text-end' >" +  "$ " + parseFloat( value.importe).toFixed(2) +"</td>" +
                                "<td></td><td></td><td></td><td></td></tr>")
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

