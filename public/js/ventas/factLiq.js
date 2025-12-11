//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
   
    
    

    $("#idBtFacturar").click(function(){
        j = confirm("Confirma emitir Factura ") 
        if (j){
            facturar()
        } 
    })

   
    $("#idOtrosConceptos").change(function(){
       if (isNaN(parseFloat($("#idOtrosConceptos").val()))){
        $("#idOtrosConceptos").val(0.00)
       }

        $("#idTotal").text((parseFloat($("#idSubtotal").text()) + parseFloat($("#idOtrosConceptos").val()) + parseFloat($("#idPercapita").val())).toFixed(2))
        $("#idOtrosConceptos").val(parseFloat($("#idOtrosConceptos").val()).toFixed(2))
    })

    $("#idPercapita").change(function(){
        if (isNaN(parseFloat($("#idPercapita").val()))){
            $("#idPercapita").val(0.00)
           }
    
       
        $("#idTotal").text((parseFloat($("#idSubtotal").text()) + parseFloat($("#idOtrosConceptos").val()) + parseFloat($("#idPercapita").val())).toFixed(2))
        $("#idPercapita").val(parseFloat($("#idPercapita").val()).toFixed(2))
    })

    

})
//=====================fin ready eventos===========================
    



//====================FUNCIONES=========================================


function facturar(){
    
    var idcli = parseInt($('#idIdCliente').text())
    var cli  = $('#idCliente').text().substring(0,149)
    var fec = $('#idFecha').val()
    //var idos = parseInt($('#idIdOs').text())
    
    var pv = parseInt($('#idPuntoVta').val())
    var nc  = parseInt($('#idNumComp').val())
    var s = parseFloat($('#idSubtotal').text())
    var o = parseFloat($('#idOtrosConceptos').val())
    var importeperc = parseFloat($('#idPercapita').val())
    var t = parseFloat($('#idTotal').text())
    var p = parseInt($('#idPeriodo').val())
    
    var liq = []
    //actualizo liq y detalle fact

    $('.classItemFactura').each(function(index){
        liq.push(parseInt($(this).text()))
    })
    


    
     u = u + "/EmitirFacturaLiq"

   
    $.ajax({
            url: u,
            type: "POST",
            data: {"idcliente": idcli, "cliente":cli, "fecha": fec, "puntoventa":pv, "numcomp":nc, "subtotal":s, "otros":o, "total":t, "arrayliq":  JSON.stringify(liq), "periodo": p, "importepercapita": importeperc},
            dataType: "json",
            success: function (respuesta) {
                
                if(respuesta!=0) {
                    
                    ciroMensaje("Comprobante generado Correctamente", "success")
                    $("#idBtFacturar").prop("disabled", true)
                    //windows.location.href = site_url() + "LiquidacionesA"
                }else{
                    ciroMensaje("Error al generar el comprobante", "error")    
                }
                
             
            }
       
        })
        
    }



