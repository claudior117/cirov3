//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    $("#idInNumAño").val(añoActual())
    $("#idInNumMes").val(mesActual())
    buscaDatos()

    $("#idBtArma").click(function(){
        j = confirm("Confirma datos para armar transferiencia ") 
        if (j){
            armaTransferencia()
        } 
    })


    $(document).on( 'change', '#idSeleccionaTodos', function(){ 
      if($("#idSeleccionaTodos").prop('checked')){
          
        $('.claseCheckComp').each(function() {
                $(this).prop("checked",true) 
            })
        }else{
             
            $('.claseCheckComp').each(function() {
                $(this).prop("checked",false)
            })
        }  
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
   
  


   $btnvioleta = 'Manager Comprobante'
   
   $("#tb1").empty()
   var lineabotones = "<td></td>"      
   espereShow()
  //MOVIMIENTOS
          
        var u = site_url() + "ComprobantesSTAjax"
        var comprobante =""
        var imp = 0
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    comprobante =  value.abreviatura + value.letra + " " + value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0')  
                    if (value.tipo_movvta == 30 || value.tipo_movvta == 301) {
                       imp = -value.total    
                    }else{
                        imp = value.total
                    }
                    lineaBotones = "<td class='centrartexto'><i class='bi bi-plus-square btn_tbl_mini_mostrar expande' id='ex"+value.id_vta+"' data-toggle='tooltip' data-placement='top' title='Detalle del comprobante'></i></td>" 
                    var ep =""
                    if(value.estado_pago == 'N'){
                        ep = "No"
                    } else{
                        ep = "Si"
                    }       
                    $("#tb1").append("<tr class='align-middle' <tr id='" + key + "'>" + lineaBotones +
                            "<td class='text-center'>" + value.id_vta + "</td>" +
                            "<td class='text-center'>" + value.fecha + "</td>" +
                            "<td>" + value.cliente.substring(0,25) +"</td>" +
                            "<td>"+ comprobante  + "</td>" +
                            "<td>"+ value.periodo  + "</td>" +
                            "<td class='text-end'>" + parseFloat(imp).toFixed(2)  + "</td>" +
                            "<td class='text-center'><input class='claseCheckComp' type='checkbox'  id='c"+ value.id_vta + "'></></td>"+
                            "<td class='text-center'>"+ ep  + "</td>" + 
                            "</tr>")
                })
        }
    })
        espereHide()
       
    }  
   

function armaTransferencia(){
   var arrayComp=[]
   $('.claseCheckComp:checked').each(
       function() {
           arrayComp.push(parseFloat($(this).parents("tr").find("td").eq(1).text()))
       }
   );
   
    var p =   $("#idInNumAño").val() +  $("#idInNumMes").val()
    var a = JSON.stringify(arrayComp)
    if ($("#idChRet").prop("checked")){
       var r = 0
    }else{
       var r = 1
    }       
    var u = site_url() + "ArmarTransferencia/" + a  + "/" + p + "/" + r
    window.location= u ;  

}



function expande_detalle_venta(idvta, fila){
    if(idvta > 0){
        var lineabotones = ""      
        var u = site_url() + "DetalleVtaAjax"
        var fr = ""
        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"idvta": idvta},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    if(value.estado_pago == 'P'){
                        fr = "Fec.Rbo " + value.fecha_rbo
                    }else{
                        fr= ""
                    }

                    $("#"+fila).after("<tr style='background-color:#fffec2;' class='align-middle ex" + idvta + "'><td></td><td></td>" + 
                            "<td class=''>" + value.detalle + "</td>" +
                            "<td class='text-end' >" +  "$ " + parseFloat( value.importe).toFixed(2) +"</td>" +
                            "<td>Liq. " + value.id_liquidacion + "</td><td>"+ fr + "</td><td></td><td></td></tr>")
                   
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
