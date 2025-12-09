//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    $("#idInNumAño").val(añoActual())
    //$("#idInNumMes").val(mesActual())
    //muestro datos por defecto
    buscaDatos();    
    
    $("#idBotonesFactura").prop('hidden', true);
    

    //DataTable
    //$('#MiTabla').DataTable();


    $("#idBtFacturar").click(function(){
        j = confirm("Confirma Facturar " + $("idSel.Os").text()) 
        if (j){
            facturar()
        } 
    })


    $('#idFrAjuste').submit(function(e) {
        e.preventDefault();
        var o = confirm("Confirma actualizar liquidación: " +  $("#idIdLiq").val())
        if (o == true) {
            insertarAjuste();
            limpiarform();
        }
    })
    

    $(document).on( 'change', '#idSeleccionaTodos', function(){ 
        
        if($("#idSeleccionaTodos").prop('checked')){
          $('.claseCheckFactura').each(function() {
                  $(this).prop("checked",true) 
              })
          }else{
               
              $('.claseCheckFactura').each(function() {
                  $(this).prop("checked",false)
              })
          }  
      })
  
    

    $(document).on( 'click', '.claseCheckFactura', function(){
        //estop es el click sobre los inputs, se hace así porque se crearon dinamicamnete
        var sum = 0;
        //selecciona todos los check seleccionados
        $('.claseCheckFactura:checked').each(
            function() {
                //sumamos
                sum = sum +  parseFloat($(this).parents("tr").find("td").eq(4).text())
            }
        );

        $('#resultadoTotal').text(sum.toFixed(2)).css("font-weight","bold" )
        sum = sum.toFixed(2)
        
        if (sum > 0){
            //activo botones
            $("#idBotonesFactura").prop('hidden',false);
        } else{
            $("#idBotonesFactura").prop('hidden',true);
        }


    } );
       

   

    $('#idBtMostrar').click(function () {
        buscaDatos();        
   })

   $('#idSelEstado').change(function () {
        buscaDatos()
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

    $('#idSelEstadoPago').change(function () {
        buscaDatos()
    })
  
    $('#idSelCliente').change(function () {
        buscaDatos()
   })
    
   
   $(document).on( 'click', '.claseAjuste', function(){
    //ajuste liquidaciones
    limpiarform()

    var id = parseInt(($(this).attr("id")).substring(1))
    var os =  $(this).parents("tr").find("td").eq(3).text()
    var p =  $(this).parents("tr").find("td").eq(10).text()
    var pe =  $(this).parents("tr").find("td").eq(2).text()
    var inc =  $(this).parents("tr").find("td").eq(6).text()
    var des =  $(this).parents("tr").find("td").eq(5).text()
    
    Ajuste(id,os,p,pe, inc, des)
    })

    $(document).on( 'click', '.expande', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        expande_detalle_venta(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id del mov vta y la fila de la tabla
    })
       
    
    $(document).on( 'click', '.comprime', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        comprime_detalle_venta(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id
    })


    $(document).on( 'click', '.expandehi', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        expande_historia_venta(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id del mov vta y la fila de la tabla
    })
       
    
    $(document).on( 'click', '.comprimehi', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        comprime_historia_venta(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id
    })
   
    $('#idBtImprimir').click(function () {
        $('#modal-header3').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
        $('#idFRImp').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
        $('#idBtImp').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
    
    
        $('#exampleModalLabel3').text('Imprimir' )
        $('#modalImp').modal('show');
    
    })
   
    $(document).on( 'click', '.expandeat', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        expande_atenciones(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id del mov vta y la fila de la tabla
    })
       
    
    $(document).on( 'click', '.comprimeat', function(){
        var idmovvtarenglon = parseInt(($(this).attr("id")).substring(2)) 
        comprime_atenciones(idmovvtarenglon, parseInt($(this).parents("tr").attr("id")))  //le paso el id
    })
   
    
  

})
//=====================fin ready eventos===========================
    



//====================FUNCIONES=========================================


function facturar(){
    var sum = 0;
    var arrayLiq=[]
    //selecciona todos los check seleccionados
    $('.claseCheckFactura:checked').each(
        function() {
            //sumamos
            sum = sum +  parseFloat($(this).parents("tr").find("td").eq(4).text())
            arrayLiq.push(parseFloat($(this).parents("tr").find("td").eq(1).text()))
        }
    );

    
    var os = $('#idSelOs').val()
    var a = JSON.stringify(arrayLiq)
    var p = $('#idInNumAño').val() + $('#idInNumMes').val().padStart(2, '0')
    var cl = $('#idSelCliente').val()
    var u = site_url() + "FacturarLiq/" + a + "/"  + p 
    
    window.location= u ;    

    /*
    $.ajax({
            url: u,
            type: "POST",
            data: {"os": os, "arrayLiq":JSON.stringify(arrayLiq), "total":sum},
            dataType: "json",
            success: function (respuesta) {
            }
        })
        
        */
}



function buscaDatos(){
   
   $btnazul = 'Detalle Items'
   $btnvioleta = 'Devolver Liquidacion'
   $btnrojo = 'Borrar Liquidación '
   $btnverde = 'Actualizar Aranceles Liquidación'
  
    $("#tb1").empty()
    $("#idBotonesFactura").prop('hidden',true);
    var salida = 1
    var qestado = ""
    


        espereShow()
        var fe= ""
        var ff = "" 
        var ich = ""        
        var lineaBotones = ""
        var lineaEstado = ""
        var lineaEstadoPago = ""
        var lineaFact = ""  
        var esta = $('#idSelEstado').val()
        var os = $('#idSelOs').val()
        var an = parseInt($('#idInNumAño').val())
        var mes = parseInt($('#idInNumMes').val())
        var idprof = $('#idSelProf').val()
        var ep  = $('#idSelEstadoPago').val()
        var idcli  = $('#idSelCliente').val()
        
        if (isNaN(an)){
            an = 0
        }
        if (isNaN(mes)){
            mes = 0
        }       
        var total = 0
        var tDescuento = 0
        var tIncremento = 0
        var idch
        var u = site_url() + "MostrarLiqA"
        var cant = 0
        var t = 0
        var tt = 0
        $.ajax({
            
            url: u,
            type: "POST",
            data: {"e": esta, "o":os, "a":an, "m":mes, "p":idprof, "estadoPago":ep, "idc": idcli},
            dataType: "json",
            success: function (respuesta) {
                
                $.each(respuesta, function (key, value) {
                   //$estado = texto_estado_liquidaciones(value.estado)
                   total += parseFloat(value.importe)
                   tDescuento +=  parseFloat(value.descuento)
                   tIncremento += parseFloat(value.incremento)
                   t = parseFloat(value.importe)+parseFloat(value.incremento)-parseFloat(value.descuento)  
                   tt += t 

                   cant += 1
                   switch (value.estado){
                       case "E":
                           fe = value.fecha_envio
                           ff = ""
                           ft = ""
                           idch = "idch" + value.id_liq
                           ich = "<input type='checkbox' class='check_liq form-check-input'> </input>"
                           lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItemsA/" + value.id_liq  + "' data-toggle='tooltip' data-placement='top' title='" +  $btnazul + "'><i class='bi bi-stack-overflow'></i></a><a id='a" + value.id_liq + "' class='btn_tbl_mini_borrar claseAjuste'  data-toggle='tooltip' data-placement='top' title='Ajuste:Descuentos e Incrementos'><i class='bi bi-tools'></i></a><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='javascript:devolverLiq(" + value.id_liq + ")' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a><a id='btnTblRevisar' class ='btn_tbl_mini_agregar' href='javascript:revisarLiq(" + value.id_liq + ")' data-toggle='tooltip' data-placement='top' title='" +  $btnverde + "' ><i class='bi bi-pencil-square'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de items liquidados'></i><i class='bi bi-plus-square btn_tbl_mini_ver expandeat' id='at"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de atenciones'></i></td>" 
                           lineaEstado = "<td class='text-center'><b>" + value.estado + "</b></td>" 
                           if ((os>0 || idcli>0) && mes>0){
                            lineaFact = "<td class='text-center'><input class='claseCheckFactura' type='checkbox'  id="+ idch + "></></td>"  
                           }else{
                            lineaFact ="<td></td>"
                           }
                           lineaEstadoPago = "<td></td>" 
                            break
                      case "F":
                            fe = value.fecha_envio
                            ff = value.fecha_facturado
                            ft = ""
                            ich = ""
                            lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItemsA/" + value.id_liq  + "' data-toggle='tooltip' data-placement='top' title='" +  $btnazul + "'><i class='bi bi-stack-overflow'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de items liquidados'></i><i class='bi bi-columns-gap btn_tbl_mini_borrar expandehi' id='hi"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Comprobantes asociados'></i><i class='bi bi-plus-square btn_tbl_mini_ver expandeat' id='at"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de atenciones'></i></td>" 
                            lineaEstado = "<td class='text-center'><b>" + value.estado +"</b></td>" 
                            lineaFact ="<td></td>"
                            lineaEstadoPago = "<td class='text-center'><b>" + value.estado_pago + "</b></td>" 
                            break
                      case "P":
                                fe = value.fecha_envio
                                ff = value.fecha_facturado
                                ft = value.fecha_transf
                                ich = ""
                                lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItemsA/" + value.id_liq  + "' data-toggle='tooltip' data-placement='top' title='" +  $btnazul + "'><i class='bi bi-stack-overflow'></i></a><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de items liquidados'></i><i  class= 'bi bi-columns-gap btn_tbl_mini_borrar expandehi' id='hi"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Comprobantes asociados'></i><i class='bi bi-plus-square btn_tbl_mini_ver expandeat' id='at"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de atenciones'></i></td>" 
                                lineaEstado = "<td class='text-center'><b>" + value.estado +"</b></td>" 
                                lineaFact ="<td></td>"
                                lineaEstadoPago = "<td class='text-center'><b>" + value.estado_pago + "</b></td>" 
                                break                                   
                   } 
                  
                    $("#tb1").append("<tr id='" + key + "'>" + 
                         lineaBotones + 
                        "<td>" + value.id_liq + "</td>" +
                        "<td>" + value.periodo + "</td>" +
                        "<td>" + value.os.substring(0,30) + "</td>" +
                        "<td class='text-end CelImporte'><b>" + parseFloat(value.importe).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(value.descuento).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(value.incremento).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + t.toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(value.bonos_anticipos).toFixed(2) + "</b></td>" +
                        "<td class='text-center' >" + fe + "</td>" +
                        "<td class='text-center' >" + ff + "</td>" +
                        "<td class='text-center' >" + ft + "</td>" +
                        "<td>" + value.nombre.substring(0,30) + "</td>" +
                         lineaEstado + lineaEstadoPago + lineaFact+  
                         "<td>" + value.fecha_ult_modificacion + "</td>" +


                        "</tr>")

                })

                //total
                //$("#tb1").append("<tr class='table-danger'><td></td><td></td><td>" +
                //        "<td class='text-end table-danger'><b>TOTAL <b></td>" +
                //        "<td class='text-end'><b>" + parseFloat(total).toFixed(2) + "</b></td><td class='text-end'></td><td></td><td></td><td></td><td></td><td class='text-center' id='resultadoTotal'></td>" +
                //        "<td></td></tr>")


                        $("#tb1").append("<tr class='table-danger'><td></td><td></td><td>" +
                        "<td class='text-end table-danger'><b>TOTALES <b></td>" +
                        "<td class='text-end'><b>" + parseFloat(total).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(tDescuento).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(tIncremento).toFixed(2) + "</b></td>"+
                        "<td class='text-end'><b>" + tt.toFixed(2) + "</b></td><td></td><td></td><td></td>"+
                        "<td  class='text-end'><b>Cantidad:</td><td class='text-center'>" + cant + "</b></td><td></td><td></td>" +
                        "<td></td></tr>")   
                        
                        
                espereHide()
            }
        })
       
    }  
   




function Ajuste(idliq, os, prof, p, inc, des){
    limpiarform()
    
    $('#idIdLiq').val(idliq)
    $('#idProf').val(prof)
    $('#idOs').val(os)
    $('#idPeriodo').val(p)
    $('#idIncremento').val(inc)
    $('#idDescuento').val(des)
    
    $('#exampleModalLabel').text('Ajuste de liquidaciones: Descuentos e Incrementos')
    $('#ModalAjuste').modal('show');

}



function limpiarform() {
    
    $('#modal-header').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
    $('#idFrAjuste').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
    $('#idBtAct').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
  

}


function devolverLiq(id){
    
    var o = confirm("Confirma devolver Liquidacion id: " + id)
    if (o == true){

        var o = confirm("Le está devolviendo la Liquidación al profesional y dejará de verla en el panel de Liquidaciones, está seguro de DEVOLVER liquidacion id: " + id)
        if (o == true){
        
        $.ajax({
            url: site_url() + "DevolverLiq",
            async: false,
            type: "POST",
            data: {"idLiq": id},
            dataType: "json",
            success: function (respuesta) {
               
                if(respuesta!=0) {
                        ciroMensaje("Liquidación devuelta", "success")
                }else{
                        ciroMensaje("Imposible devolver Liquidación", "error")    
                        
                }
                buscaDatos()

            }
        })

    }   
    }

}
 

function revisarLiq(id){
    
    var o = confirm("Confirma actualizar aranceles de la Liquidacion id: " + id)
    if (o == true){

        $.ajax({
            url: site_url() + "RevisarLiq",
            async: false,
            type: "POST",
            data: {"idLiq": id},
            dataType: "json",
            success: function (respuesta) {
               
                if(respuesta!=0) {
                        ciroMensaje("Liquidación actualizada", "success")
                }else{
                        ciroMensaje("Imposible actualizar Liquidación", "error")    
                        
                }
                buscaDatos()

            }
        })

    }

}


function expande_detalle_venta(idliq, fila){
    if(idliq > 0){
        var lineabotones = ""      
        var u = site_url() + "DetalleLiqAjax"
        
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"idliq": idliq},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                   
                    $("#"+fila).after("<tr style='background-color:#fffec2;' class='align-middle ex" + idliq + "'><td></td><td></td>" + 
                            "<td class=''>" + value.codigo + "</td>" +
                            "<td class=''>" + value.desc_item.substring(0,30) + "</td>" +
                            "<td class='text-end' >" +  parseInt(value.cantidad) +"</td>" +
                            "<td class = 'text-end'>" + "$" + parseFloat(value.pu).toFixed(2)  + "</td>" +
                            "<td class = 'text-end'>" + "$" + parseFloat(value.importe).toFixed(2)  + "</td>" +
                            "<td></td><td></td><td></td><td></td><td></td><td></td></tr>")
                    
                    $("#ex"+idliq).addClass('bi bi-dash-square comprime' )	
                    $("#ex"+idliq).removeClass('bi bi-plus-square expande') 

                           
                })
        }
    })
    }
}



function comprime_detalle_venta(idliq, fila){
$(".ex" + idliq).remove();
$("#ex"+idliq).addClass('bi bi-plus-square expande')	
$("#ex"+idliq).removeClass('bi bi-dash-square comprime') 

}



function expande_historia_venta(idliq, fila){
    if(idliq > 0){
        var lineabotones = ""      
        var u = site_url() + "HistoriaLiqAjax"
        
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"idliq": idliq},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    comprobante = value.abreviatura + " " + value.letra + " " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0') 
                      
                    $("#"+fila).after("<tr style='background-color:#E1ECFF;' class='align-middle hi" + idliq + "'><td></td><td></td>" + 
                            "<td class=''>" + value.tipo_movvta + "</td>" +
                            "<td class=''>" + comprobante + "</td>" +
                            "<td class='text-end'>" + value.fechaMovVta + "</td>" +
                            "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>"+
                            "</tr>")
                    
                 
                            $("#hi"+idliq).addClass('comprimehi' )	
                            $("#hi"+idliq).removeClass('expandehi')

                           
                })
        }
    })
    }
}



function comprime_historia_venta(idliq, fila){
$(".hi" + idliq).remove();
$("#hi"+idliq).addClass('expandehi')	
$("#hi"+idliq).removeClass('comprimehi') 


}



function insertarAjuste() {
        $.ajax({
            url: site_url() + "InsertarAjusteLiq",
            async: false,
            type: "POST",
            data: $("#idFrAjuste").serialize(),
            dataType: "json",
            success: function (respuesta) {
               
                if(respuesta!=0) {
                        ciroMensaje("Base de Dato actualizada", "success")
                }else{
                        ciroMensaje("Imposible Actualizar, verifique que la Liquidación no existe", "warning")    
                        
                }
                $('#ModalAjuste').modal('hide');
                buscaDatos()

            }
        })
    }



    function expande_atenciones(idliq, fila){
        if(idliq > 0){
            
            var lineabotones = ""      
            var u = site_url() + "AtenLiqAx"
            
            $.ajax({
                url: u,
                type: "POST",
                async:false,
                data: {"idliq": idliq},
                dataType: "json",
                success: function (respuesta) {
                    $.each(respuesta, function (key, value) {
                       
                        $("#"+fila).after("<tr style='background-color:#fffec2;' class='align-middle at" + idliq + "'><td></td><td></td>" + 
                                "<td class=''>" + value.codigo + "</td>" +
                                "<td class=''>" + value.desc_item.substring(0,50) + "</td>" +
                                "<td class = 'text-end'>" + "$" + parseFloat(value.importe).toFixed(2)  + "</td>" +
                                "<td class='text-end' >" +  parseInt(value.elemento) + value.cara +"</td>" +
                                "<td></td><td></td><td></td><td></td><td></td><td></td>"+
                                "<td class = 'text-end'>" + value.denominacion.substring(0, 30)  + "</td>" +
                                "<td></td><td></td><td></td><td></td></tr>")
                        
                        $("#at"+idliq).addClass('bi bi-dash-square comprimeat' )	
                        $("#at"+idliq).removeClass('bi bi-plus-square expandeat') 
    
                               
                    })
            }
        })
        }
    }
    
    
    
    function comprime_atenciones(idliq, fila){
    $(".at" + idliq).remove();
    $("#at"+idliq).addClass('bi bi-plus-square expandeat')	
    $("#at"+idliq).removeClass('bi bi-dash-square comprimeat') 
    
    }
    
    


