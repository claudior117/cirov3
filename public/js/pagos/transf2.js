//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    $("#idBtTransferir").click(function(){
        j = confirm("Confirma realizar transferencia ") 
        if (j){
            transferir()
        } 
    })

})
//=====================fin ready eventos===========================
    


//====================FUNCIONES=========================================


function transferir(){
    
    var idcli = parseInt($('#idIdCliente').text())
    var cli  = $('#idCliente').text().substring(0,149)
    var fec = $('#idFecha').val()
    //var idos = parseInt($('#idIdOs').text())
    
    var pv = parseInt($('#idPuntoVta').val())
    var nc  = parseInt($('#idNumComp').val())
    var s = parseFloat($('#idSubtotal').text())
    var o = parseFloat($('#idOtrosConceptos').val())
    var t = parseFloat($('#idTotal').text())
    var p = parseInt($('#idPeriodo').val())
    
    var comp = []
    $('.classItemFactura').each(function(index){
        comp.push(parseInt($(this).text()))
    })
    
    var ret = []
    $('.classItemRet').each(function(index){
        ret.push(parseInt($(this).text()))
    })

    if ($("#idchret").prop("checked")){
        var hr = 1
     }else{
        var hr = 0
     }       

    u = site_url() + "TransferirAjax"
    
    $.ajax({
            url: u,
            type: "POST",
            data: {"idcliente": idcli, "cliente":cli, "fecha": fec, "puntoventa":pv, "numcomp":nc, "subtotal":s, "otros":o, "total":t, "arraycomp":  JSON.stringify(comp), "arrayret":  JSON.stringify(ret), "periodo": p, "haceret":hr},
            dataType: "json",
            success: function (respuesta) {
                
                if(respuesta!=0) {
                    ciroMensaje("Comprobante generado Correctamente", "success")
                    $("#idBtTransferir").prop("disabled", true)
                    //windows.location.href = site_url() + "LiquidacionesA"
                }else{
                    ciroMensaje("Error al generar el comprobante", "error")    
                }
                
             
            }
       
        })
        
    }



