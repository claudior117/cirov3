//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    var f = fechaActual()   
    
    $('#idFechaD').val(f)
    $('#idFechaH').val(f)

    //buscaDatos()

    $('#idSelCliente').change(function(){
        buscaDatos()

    })  
       
    $('#idFechaD').change(function(){
        buscaDatos()

    })  
    
    $('#idFechaH').change(function(){
        buscaDatos()

    })  
    
    $('#idTipo').change(function(){
        buscaDatos()

    }) 
    

    $('#idSelTrans').change(function(){
        buscaDatos()

    })  
   
})
//=====================fin ready eventos===========================
    


function buscaDatos(){
   
   $btnvioleta = 'Manager Comprobante'
   var idcli = $("#idSelCliente").val()
   var fd = $("#idFechaD").val()
   var fh = $("#idFechaH").val()
   var e =  $('#idSelTrans').val()  
   
   
   $("#tb1").empty()
   
        espereShow()
        

        //MOVIMIENTOS
          
        var u = site_url() + "ResumenOpAjax"
        
        var  idprofactual=0 
        transferido =""

        var totLiqProf = 0
        var totDescProf = 0
        var totIncProf = 0
        var totBonoProf = 0
        var totIngProf = 0

        var totLiq = 0
        var totDesc = 0
        var totInc = 0
        var totBono = 0
        var totIng = 0

        $.ajax({
            url: u,
            type: "POST",
            async:false,
            data: {"fd": fd, "fh": fh, "idcli": idcli, "estado":e},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                        if (idprofactual != value.idusuarioliq){
                            if (idprofactual !=0){
                                //totalesprof
                                
                                $("#tb1").append("<tr><td></td><td></td><td></td>"+ 
                                "<td><b> **TOTALES**</b></td>" +
                                "<td class='text-end'><b>" + parseFloat(totLiqProf).toFixed(2)  + "</b></td>" +
                                "<td class='text-end'><b>" + parseFloat(totDescProf).toFixed(2)  + "</b></td>" +
                                "<td class='text-end'><b>" + parseFloat(totIncProf).toFixed(2)  + "</b></td>" +
                                "<td class='text-end'><b>" + parseFloat(totBonoProf).toFixed(2)  + "</b></td>" +
                                "<td class='text-end'><b>" + parseFloat(totIngProf).toFixed(2)  + "</b></td>" +
                                "</tr>")
                            }
                            //cabecera profesional    
                            $("#tb1").append("<tr>"+ 
                            "<td>"+ value.nombre  + "</td>" +
                            "</tr>")
                            idprofactual = value.idusuarioliq
                            totLiq += totLiqProf
                            totDesc += totDescProf
                            totInc += totIncProf
                            totBono += totBonoProf 
                            totIng += totIngProf
                    
                            totLiqProf = 0
                            totDescProf = 0
                            totIncProf = 0
                            totBonoProf = 0
                            totIngProf = 0
                    
                            


                        }
                    
                    recibo = value.sucursal.padStart(4, '0') + "-" + value.num_comprobante.padStart(10, '0') 
                    
                    if (value.liqtransferida=="P"){
                        transferido= "Si"
                        fect =  value.fecha_transf
                    }else{
                        transferido = "No"
                        fect = ""
                    }
                    totLiqProf += parseFloat(value.liqimporte)
                    totDescProf += parseFloat(value.descuento)
                    totIncProf += parseFloat(value.incremento) 
                    totBonoProf += parseFloat(value.bonos_anticipos)
                    totIngProf += parseFloat(value.detimporte)
                    

                    $("#tb1").append("<tr class='align-middle'><td>"+value.cliente +"</td>" + value.cliente + 
                            "<td class='text-center'>" + recibo + "</td>" +
                            "<td class='text-center'>" + value.id_liq + "</td>" +
                            "<td class='text-center'>" + value.factura + "</td>" +
                            "<td class='text-end'>" + parseFloat(value.liqimporte).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(value.descuento).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(value.incremento).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(value.bonos_anticipos).toFixed(2)  + "</td>" +
                            "<td class='text-end'>" + parseFloat(value.detimporte).toFixed(2)  + "</td>" +
                            "<td class='text-center'>" + transferido + "</td>" +
                            "<td class='text-center'>" + value.fecha_rbo + "</td>" +
                            "<td class='text-center'>" + fect + "</td>" +
                            
                            
                            
                            "</tr>")
                            
                })
                $("#tb1").append("<tr><td></td><td></td><td></td>"+ 
                "<td><b> **TOTALES**</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totLiqProf).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totDescProf).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totIncProf).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totBonoProf).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totIngProf).toFixed(2)  + "</b></td>" +
                "</tr>")
                totLiq += totLiqProf
                totDesc += totDescProf
                totInc += totIncProf
                totBono += totBonoProf 
                totIng += totIngProf

                $("#tb1").append("<tr></tr>")
                $("#tb1").append("<tr><td></td><td></td><td></td>"+ 
                "<td></td>" +
                "<td class='text-end'><b>" + parseFloat(totLiq).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totDesc).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totInc).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totBono).toFixed(2)  + "</b></td>" +
                "<td class='text-end'><b>" + parseFloat(totIng).toFixed(2)  + "</b></td>" +
                
                "</tr>")



            }
        })
        espereHide()
       
    }  
