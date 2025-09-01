//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    $("#idInNumAño").val(añoActual())

    //muestro datos por defecto
    buscaDatos(); 



        
    $('#idBtAgregar').click(function () {
        //alta
        limpiarform()
        alta()
    })

   
  
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
    
    
    $('#idFR1').submit(function(e) {
        e.preventDefault();
        var o = confirm("Confirme para continuar")
        if (o == true) {
            insertarRegistro();
            limpiarform();
        }
    })
    

    $('#idBtImprimir').click(function () {
        $('#modal-header3').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
        $('#idFRImp').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
        $('#idBtImp').removeClass('fondo', 'fondomodificar', 'fondoborrar').addClass('fondoagregar')
    
    
        $('#exampleModalLabel3').text('Imprimir' )
        $('#modalImp').modal('show');
    
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
   


})
//=====================fin ready eventos===========================
    






//====================FUNCIONES=========================================
function buscaDatos(){
   
   $btnazul = 'Detalle Items'
   $btnvioleta = 'Enviar Liquidacion'
   $btnrojo = 'Borrar Liquidación '
   $btnverde = 'Agregar'
  
    $("#tb1").empty()
    var salida = 1
    var qestado = ""
          
        espereShow()
        var fe= ""
        var ff = "" 
        var ich = ""        
        var lineaBotones = ""
        var lineaEstado = ""
        var lineaEstado2 = "<td></td>" 
        var esta = $('#idSelEstado').val()
        var os = $('#idSelOs').val()
        var an = parseInt($('#idInNumAño').val())
        var mes = parseInt($('#idInNumMes').val())
        if (isNaN(an)){
            an = 0
        }       
        if (isNaN(mes)){
            mes = 0
        }    
        var total = 0, tIncremento=0, tDescuento=0, t=0, tt=0
        var u = site_url() + "MostrarLiq"
        var cant = 0
        $.ajax({
            
            url: u,
            type: "POST",
            data: {"e": esta, "o":os, "a":an, "m":mes},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    total += parseFloat(value.importe)
                    tDescuento +=  parseFloat(value.descuento)
                    tIncremento += parseFloat(value.incremento)
                    t = parseFloat(value.importe)+parseFloat(value.incremento)-parseFloat(value.descuento)  
                    tt += t
                    $estado = texto_estado_liquidaciones(value.estado)
                   cant += 1
                   switch (value.estado){
                       case "B":
                        fe=""
                        ff = ""
                        fp = ""
                        ich = ""
                        lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItems/" + value.id_liq + "' data-toggle='tooltip' data-placement='top' title='" +  $btnazul + "'> <i class='bi bi-stack-overflow'></i></a><a id='btnTblEnviar' class ='btn_tbl_mini_editar' href='javascript:enviarLiq(" + value.id_liq + ")' data-toggle='tooltip' data-placement='top' title='" +  $btnvioleta + "' ><i class='bi bi-box-arrow-up-right'></i></a><a id='btnTblBorrar' class ='btn_tbl_mini_borrar' href='javascript:borrarLiq(" + value.id_liq + ")' data-toggle='tooltip' data-placement='top' title='" +  $btnrojo + "'><i class='bi bi-trash-fill'></i></a></td>" 
                        lineaEstado = "<td class='centrartexto'><b>" + $estado + "</b></td>" 
                         
                        break
                       case "E":
                           fe = value.fecha_envio
                           ff = ""
                           fp = ""
                           ich = "<input type='checkbox' class='check_liq form-check-input'> </input>"
                           lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItems/" + value.id_liq  + "' data-toggle='tooltip' data-placement='top' title='" +  $btnazul + "'><i class='bi bi-stack-overflow'></i></a><i class='bi bi-plus-square btn_tbl_mini_borrar expande' id='ex"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de items liquidados'></i></td>" 
                           lineaEstado = "<td class='centrartexto'><b>" + $estado + "</b></td>" 
                           break
                      case "F":
                            fe = value.fecha_envio
                            ff = value.fecha_facturado
                            fp = ""
                             
                            ich = ""
                            lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItems/" + value.id_liq + "' data-toggle='tooltip' data-placement='top' title='" +  $btnazul + "'><i class='bi bi-stack-overflow'></i></a><i class='bi bi-plus-square btn_tbl_mini_borrar expande' id='ex"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de items liquidados'></i><i class='bi bi-columns-gap btn_tbl_mini_editar expandehi' id='hi"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Comprobantes asociados'></i></td>" 
                            lineaEstado = "<td class='centrartexto'><b>" + $estado + "</b></td>" 
                            break
                      case "P":
                                fe = value.fecha_envio
                                ff = value.fecha_facturado
                                fp =  value.fecha_transf
                                ich = ""
                                lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarItems/" + value.id_liq + "' data-toggle='tooltip' data-placement='top' title='" +  $btnazul + "'><i class='bi bi-stack-overflow'></i></a><i class='bi bi-plus-square btn_tbl_mini_borrar expande' id='ex"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Detalle de items liquidados'></i><i class='bi bi-columns-gap btn_tbl_mini_editar expandehi' id='hi"+value.id_liq+"' data-toggle='tooltip' data-placement='top' title='Comprobantes asociados'></i></td>" 
                                lineaEstado = "<td class='centrartexto'><b>" + $estado + "</b></td>" 
                                break
                            
      

                   } 

                    $("#tb1").append("<tr id='" + key + "'>" + lineaEstado2+
                         lineaBotones + 
                        "<td>" + value.id_liq + "</td>" +
                        "<td>" + value.periodo + "</td>" +
                        "<td>" + value.os + "</td>" +
                        "<td class='text-end'><b>" + parseFloat(value.importe).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(value.descuento).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(value.incremento).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + t.toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(value.bonos_anticipos).toFixed(2) + "</b></td>" +
                        "<td>" + fe + "</td>" +
                        "<td>" + ff + "</td>" +
                        "<td>" + fp + "</td>" +
                        "<td>" + value.nombre + "</td>" +
                         lineaEstado +


                        "</tr>")

                })

                //total
                $("#tb1").append("<tr class='table-danger'><td></td><td></td><td></td><td>" +
                "<td class='text-end table-danger'><b>TOTAL <b></td>" +
                "<td class='text-end'><b>" + parseFloat(total).toFixed(2) + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(tDescuento).toFixed(2) + "</b></td>" +
                        "<td class='text-end'><b>" + parseFloat(tIncremento).toFixed(2) + "</b></td>"+
                        "<td class='text-end'><b>" + tt.toFixed(2) + "</b></td><td></td>"+
                        "<td  class='text-end'><b>Cantidad:</td><td class='text-start'>" + cant + "</b></td><td></td><td></td>" +
                "</tr>")
         
                espereHide()
            }
        })
       
    }  
   




function alta(){
    limpiarform()
    

    $('#exampleModalLabel').text('Agregar Liquidación')
    $('#idInFun').val('A');
    $('#idNuId').val('0');
    $('#exampleModal').modal('show');

}


function modificarDatos(id){
    console.log("Modificar " + id);
    limpiarform()
     $('#exampleModalLabel').text('Modificar Datos de Socios')
    $('#idInFun').val('M');
    $('#idNuId').val(id);
    llenaformulario(id);
    $('#exampleModal').modal('show');

}


function enviarLiq(id){
    
    var o = confirm("Confirma Enviar Liquidacion id: " + id)
    if (o == true){

        var o = confirm("Esta operación es irreversible, está seguro de ENVIAR liquidacion id: " + id)
        if (o == true){
        
        $.ajax({
            url: site_url() + "EnviarLiq",
            async: false,
            type: "POST",
            data: {"idLiq": id},
            dataType: "json",
            success: function (respuesta) {
               
                if(respuesta!=0) {
                        mensaje("Liquidación enviada", "success")
                }else{
                        mensaje("Imposible enviar Liquidación", "error")    
                        
                }
                buscaDatos()

            }
        })

    }   
    }

}


function borrarLiq(id) {
   
    var o = confirm("Confirma borrar Liquidacion Id: " + id)
    if (o == true){
       // window.location="/ciro/public/BorrarLiq/" + id;    
       window.location= site_url() + "BorrarLiq/" + id;
    
    }
     
             
    }




function limpiarform() {
    $('#idNuAño2').val(añoActual());
    $('#idNuMes2').val(mesActual());
    
  

}


function insertarRegistro() {
   

    var f =$('#idInFun').val();
        $.ajax({
            url: site_url() + "AgregarLiq",
            async: false,
            type: "POST",
            data: $("#idFR1").serialize(),
            dataType: "json",
            success: function (respuesta) {
               
                if(respuesta!=0) {
                        mensaje("Base de Dato actualizada", "success")
                }else{
                        mensaje("Imposible Actualizar, verifique que la Liquidación no existe", "warning")    
                        
                }
                $('#exampleModal').modal('hide');
                buscaDatos()

            }
        })
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
                                "<td class=''>" + value.desc_item.substring(0,50) + "</td>" +
                                "<td class='text-end' >" +  parseInt(value.cantidad) +"</td>" +
                                "<td class = 'text-end'>" + "$" + parseFloat(value.pu).toFixed(2)  + "</td>" +
                                "<td class = 'text-end'>" + "$" + parseFloat(value.importe).toFixed(2)  + "</td>" +
                                "<td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>")
                        
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
                                "<td class=''>" + value.fechaMovVta + "</td>" +
                                "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>"+
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
    



  
function mensaje(m, t){
    //t es success o error
    //m es el mensaje
    
    Swal.fire({
        position: 'center',
        icon: t,
        title: m,
        showConfirmButton: false,
        timer: 1500
      })
    
    
}