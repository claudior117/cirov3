$(document).ready(function () {
  
  $('#idBtnDescuento').click(function(){
    $('#ModalDescuento').modal('show');
  })


  $('#idBtCalcDesc').click(function(){
    j = confirm("Confirme aplicar descuentos") 
    if (j){
      aplicaDescuento()
    }
    })



 
  $('#idBtNc').click(function () {        //
     if (parseFloat($('#idDescuento').text()) > 0){  
        var o = confirm("Confirma Emitir Nota de Crédito por " +  $('#idDescuento').text() + " de descuentos recibidos")
        if (o == true) {
           //funcion guardar
           NotaCrDb(30)  
 
        }
      }   
     else{
       alert("No se puede emitir NC con descuentos en cero")
     }   
      
    }) //fin guardar rbo


    $('#idBtNd').click(function () {        //
      if (parseFloat($('#idIncremento').text()) > 0){  
         var o = confirm("Confirma Emitir Nota de Débito por " +  $('#idIncremento').text() + " de incrementos recibidos")
         if (o == true) {
            //funcion guardar
            NotaCrDb(20)  
  
         }
       }   
      else{
        alert("No se puede emitir ND con incrementos en cero")
      }   
       
     }) //fin 
    

    $('#idBtRecibo').click(function () {        //
      if (parseFloat($('#idPago').text()) > 0){  
         var o = confirm("Confirma Emitir Recibo por " +  $('#idPago').text() + " recibidos")
         if (o == true) {
            //funcion guardar
            Recibo()  
  
         }
       }   
      else{
        alert("No se puede emitir Recibo con importe total en  cero")
      }   
       
     }) //fin guardar rbo
 

     $('#idBtBonos').click(function () {        //
      if (parseFloat($('#idBonos').text()) > 0){  
         var o = confirm("Confirma Emitir Nota de Crédito de Bonos por " +  $('#idBonos').text())
         if (o == true) {
            //funcion guardar
            Bonos()  
         }
       }   
      else{
        alert("No se puede emitir NC con descuentos en cero")
      }   
       
     }) //fin guardar rbo
 
 



     $(document).on( 'change', '.CelDescuento', function(){
      
      
      var imp = parseFloat($(this).parents("tr").find("td").eq(4).text()) + parseFloat($(this).parents("tr").find("input").eq(1).val()) - parseFloat($(this).val())-  parseFloat($(this).parents("tr").find("input").eq(2).val())
      $(this).parents("tr").find("td").eq(8).text(imp.toFixed(2))
       
      sumaTabla()
})


$(document).on( 'change', '.CelIncremento', function(){
      
  var imp = parseFloat($(this).parents("tr").find("td").eq(4).text()) - parseFloat($(this).parents("tr").find("input").eq(0).val()) + parseFloat($(this).val()) -  parseFloat($(this).parents("tr").find("input").eq(2).val())
  $(this).parents("tr").find("td").eq(8).text(imp.toFixed(2))
   
  sumaTabla()
})


$(document).on( 'change', '.CelBono', function(){
      
  var imp = parseFloat($(this).parents("tr").find("td").eq(4).text()) - parseFloat($(this).parents("tr").find("input").eq(0).val()) - parseFloat($(this).val()) +  parseFloat($(this).parents("tr").find("input").eq(1).val())
  $(this).parents("tr").find("td").eq(8).text(imp.toFixed(2))
   
  sumaTabla()
})




})



//fin ready



function sumaTabla(){
    //suma columna
    var sumI = 0;
    var sumD = 0;
    var sumInc = 0;
    var sumP = 0;
    var sumB = 0    
    $('.CelImporte').each(function() {
    sumI += parseFloat($(this).text());
     });
    $('.CelDescuento').each(function() {
      sumD += parseFloat($(this).val());
       });
    $('.CelIncremento').each(function() {
        sumInc += parseFloat($(this).val());
    });

    $('.CelBono').each(function() {
      sumB += parseFloat($(this).val());
  });

     
       
  $('.CelPago').each(function() {
      sumP += parseFloat($(this).text());
       });
       
  

    $('#idSubtotal').text(sumI.toFixed(2)).css("font-weight","bold" )
    $('#idDescuento').text(sumD.toFixed(2)).css("font-weight","bold" )
    $('#idIncremento').text(sumInc.toFixed(2)).css("font-weight","bold" )
    $('#idBonos').text(sumB.toFixed(2)).css("font-weight","bold" )
    $('#idPago').text(sumP.toFixed(2)).css("font-weight","bold" )
    
   

}


function NotaCrDb(idtc){
    
  var idcli = parseInt($('#idIdCliente').text())
  var cli  = $('#idCliente').text().substring(0,149)
  var fec = $('#idFecha').val()
  var idos = parseInt($('#idIdOs').text())
  
 
  var p = parseInt($('#idPeriodo').val())
  var idf = parseFloat($('#idIdFactura').text())
  
  var ite = []
  var liq = []
  var imp = []
  
  //actualizo datos para nc
  if (idtc == 30){
      var i = 0
      var pv = parseInt($('#idPuntoVtaNc').val())
      var nc  = parseInt($('#idNumNc').val())
      var s = parseFloat($('#idDescuento').text())
      var o = 0
      var t = parseFloat($('#idDescuento').text())
      $(".CelDescuento").each(function(){
        if ($(this).val()>0){  
          ite.push($(this).parents("tr").find("td").eq(1).text())
          liq.push($(this).parents("tr").find("td").eq(2).text())
          imp.push($(this).val())
        }
      });
  }else
  {
    var i = 0
    var pv = parseInt($('#idPuntoVtaNd').val())
    var nc  = parseInt($('#idNumNd').val())
    var s = parseFloat($('#idIncremento').text())
    var o = 0
    var t = parseFloat($('#idIncremento').text())
    $(".CelIncremento").each(function(){
      if ($(this).val()>0){  
        ite.push($(this).parents("tr").find("td").eq(1).text())
        liq.push($(this).parents("tr").find("td").eq(2).text())
        imp.push($(this).val())
      }
    });
  }    
 

  u = site_url() + "EmitirNcNdRbo"
  $.ajax({
          url: u,
          type: "POST",
          data: {"idcliente": idcli, "cliente":cli, "idos":idos, "fecha": fec, "puntoventa":pv, "numcomp":nc, "subtotal":s, "otros":o, "total":t, "arraydetvta":  JSON.stringify(ite), "arrayliq":  JSON.stringify(liq),  "arraydescuento":  JSON.stringify(imp), "periodo":p, "idfactura":idf, "tipocomp":idtc},
          dataType: "json",
          success: function (respuesta) {
              
              if(respuesta!=0) {
                if (idtc == 30){   
                  ciroMensaje("Nota Crédito generada Correctamente", "success")
                  $("#idBtNc").prop("disabled", true)
                }
                else{
                  ciroMensaje("Nota Débito generada Correctamente", "success")
                  $("#idBtNd").prop("disabled", true)
                }  
              }else{
                  ciroMensaje("Error al generar el comprobante", "error")    
              }
              
           
          }
     
      })
  
  
}




function NotaDebito(){
    
  var idcli = parseInt($('#idIdCliente').text())
  var cli  = $('#idCliente').text().substring(0,149)
  var fec = $('#idFecha').val()
  var idos = parseInt($('#idIdOs').text())
  
  var pv = parseInt($('#idPuntoVtaNd').val())
  var nc  = parseInt($('#idNumNd').val())
  var s = parseFloat($('#idIncremento').text())
  var o = 0
  var t = parseFloat($('#idIncremento').text())
  var p = parseInt($('#idPeriodo').val())
  var idf = parseFloat($('#idIdFactura').text())
  
  var ite = []
  var liq = []
  var imp = []
  
  //actualizo datos para nd
  var i = 0
  $(".CelIncremento").each(function(){
    if ($(this).val()>0){  
      ite.push($(this).parents("tr").find("td").eq(1).text())
      liq.push($(this).parents("tr").find("td").eq(2).text())
      imp.push($(this).val())
    }
  });
  
 

  u = site_url() + "EmitirNcNdRbo"
  $.ajax({
          url: u,
          type: "POST",
          data: {"idcliente": idcli, "cliente":cli, "idos":idos, "fecha": fec, "puntoventa":pv, "numcomp":nc, "subtotal":s, "otros":o, "total":t, "arraydetvta":  JSON.stringify(ite), "arrayliq":  JSON.stringify(liq),  "arraydescuento":  JSON.stringify(imp), "periodo":p, "idfactura":idf},
          dataType: "json",
          success: function (respuesta) {
              
              if(respuesta!=0) {
                  
                  ciroMensaje("Nota Crédito generada Correctamente", "success")
                  $("#idBtNc").prop("disabled", true)
                  //windows.location.href = site_url() + "LiquidacionesA"
              }else{
                  ciroMensaje("Error al generar Nota Crédito", "error")    
              }
              
           
          }
     
      })
  
  
}



function Recibo(){
    
  var idcli = parseInt($('#idIdCliente').text())
  var cli  = $('#idCliente').text().substring(0,149)
  var fec = $('#idFecha').val()
  var idos = parseInt($('#idIdOs').text())
  
  var pv = parseInt($('#idPuntoVtaR').val())
  var nc  = parseInt($('#idNumR').val())
  var s = parseFloat($('#idPago').text())
  var o = 0
  var t = parseFloat($('#idPago').text())
  var idf = parseFloat($('#idIdFactura').text())
  var p = parseInt($('#idPeriodo').val())

  var ite = []
  var liq = []
  var imp = []
  
  //actualizo datos para nc
  var i = 0
  $(".CelPago").each(function(){
    if (parseFloat($(this).text())>0){  
      ite.push($(this).parents("tr").find("td").eq(1).text())
      liq.push($(this).parents("tr").find("td").eq(2).text())
      imp.push(parseFloat($(this).text()))
    }
  });
  
 

  u = site_url() + "EmitirRbo"
  $.ajax({
          url: u,
          type: "POST",
          data: {"idcliente": idcli, "cliente":cli, "idos":idos, "fecha": fec, "puntoventa":pv, "numcomp":nc, "subtotal":s, "otros":o, "total":t, "arraydetvta":  JSON.stringify(ite), "arrayliq":  JSON.stringify(liq),  "arrayimporte":  JSON.stringify(imp), "idfactura": idf, "periodo": p },
          dataType: "json",
          success: function (respuesta) {
              
              if(respuesta!=0) {
                  
                  ciroMensaje("Recibo generado correctamente", "success")
                  $("#idBtRecibo").prop("disabled", true)
                  //windows.location.href = site_url() + "LiquidacionesA"
              }else{
                  ciroMensaje("Error al generar Recibo", "error")    
              }
              
           
          }
     
      })
  
  
}


function Bonos(idtc){
    
  var idcli = parseInt($('#idIdCliente').text())
  var cli  = $('#idCliente').text().substring(0,149)
  var fec = $('#idFecha').val()
  var idos = parseInt($('#idIdOs').text())
  
 
  var p = parseInt($('#idPeriodo').val())
  var idf = parseFloat($('#idIdFactura').text())
  
  var ite = []
  var liq = []
  var imp = []
  
      var i = 0
      var s = parseFloat($('#idBonos').text())
      var o = 0
      var t = parseFloat($('#idBonos').text())
      $(".CelBono").each(function(){
        if ($(this).val()>0){  
          ite.push($(this).parents("tr").find("td").eq(1).text())
          liq.push($(this).parents("tr").find("td").eq(2).text())
          imp.push($(this).val())
        }
      });
  

  u = site_url() + "EmitirNcBonos"
  $.ajax({
          url: u,
          type: "POST",
          data: {"idcliente": idcli, "cliente":cli, "idos":idos, "fecha": fec, "subtotal":s, "otros":o, "total":t, "arraydetvta":  JSON.stringify(ite), "arrayliq":  JSON.stringify(liq),  "arraydescuento":  JSON.stringify(imp), "periodo":p, "idfactura":idf},
          dataType: "json",
          success: function (respuesta) {
              
              if(respuesta!=0) {
                  ciroMensaje("Nota Crédito por Bonos generada Correctamente", "success")
                  $("#idBtBonos").prop("disabled", true)
              }else{
                  ciroMensaje("Error al generar el comprobante", "error")    
              }
              
           
          }
     
      })
  
  
}

function aplicaDescuento(){
  var d = 0
  var imp = 0  
  $('.CelDescuento').each(function() {
    if ($('#idTipoDescuento').val() == 'P'){
      //porcentaje
      d =   parseFloat($(this).parents("tr").find("td").eq(4).text()) * parseFloat($('#idValorDescuento').val())/100
    } else
    {
      //importe
       d = parseFloat($('#idValorDescuento').val())
       
      }  

      $(this).val((parseFloat($(this).val())+d).toFixed(2));
      imp = parseFloat($(this).parents("tr").find("td").eq(4).text()) + parseFloat($(this).parents("tr").find("input").eq(1).val()) - parseFloat($(this).val()) - parseFloat($(this).parents("tr").find("input").eq(2).val())
      $(this).parents("tr").find("td").eq(8).text(imp.toFixed(2))
    
    })
    

     sumaTabla()
     $('#ModalDescuento').modal('hide');

}     


  