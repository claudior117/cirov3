//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {

   
    //inicializacio
    $('#idFec').val(primerDiaMesActual())    


$('#idFec').change(function () {
    buscaDatos();        
})

$('#idSelPac').change(function () {
    buscaDatos();        
})

$('#idSelOS3').change(function () {
    buscaDatos();        
})

$('#idSelEstado').change(function () {
    buscaDatos();        
})

$('#idSelTipo').change(function () {
    buscaDatos();        
})

$('#idBtImprimir').click(function () {
    imprimir()
})

$('#idBtImprimir2').click(function () {
    imprimir2()
})

$('#idFR1').submit(function(e) {
    e.preventDefault();
   
    Swal.fire(
        {
            title: "Alerta!",
            text: "Confirma actualizar atención? " ,
            type: "warning",
            allowEscapeKey: false,
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        }).then((isConfirm) => {
            if (isConfirm.value === true) {
                enviarCI();
                limpiarform();
              
            }
            return false;
        });
    })



})

//=====================fin ready eventos===========================
    






//====================FUNCIONES=========================================
function buscaDatos(){
   $("#tb1").empty()
   $("#tbTot").empty()
    var salida = 1
    var qestado = ""
          
        espereShow()
        var lineaBotones = ""
        var lineaEstado = ""
        var lineaEstado2 = "" 
        var fecha = $('#idFec').val()
        var  paciente = $('#idSelPac').val()
        var os = $('#idSelOS3').val()
        var estado = $('#idSelEstado').val()
        var tipo = $('#idSelTipo').val()
        var cant = 0
        var totOsSinPagar = 0
        var totOsPagas = 0
        var totPSinPagar = 0
        var totPPagas = 0
        var total = 0
        var importe = 0
        $.ajax({
            url: "MostrarAtencionesAxP",
            async: false,
            type: "POST",
            data: {"idp":paciente, "idos":os, "estado":estado, "fecha":fecha, "tipo":tipo},
            dataType: "json",
            
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                   
                //lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='javascript:cargarMov(" + value.id_paciente + ", \"M\")' data-toggle='tooltip' data-placement='top' title='Modificar datos del paciente'> <i class='bi bi-stack-overflow'></i></a><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='<?= site_url('prof/atenciones/index.php?id=" + value.id_paciente + "') ?>' data-toggle='tooltip' data-placement='top' title='Cargar atenciones'> <i class='bi bi-stack-overflow'></i></a></td>" 
                
                 botonBorrar = "<a id='btnTblBorrar' class ='btn_tbl_mini_borrar' href='javascript:cargarMov(" + value.id_atencion + ", \"B\")' data-toggle='tooltip' data-placement='top' title='Borrar Atención'><i class='bi bi-trash-fill'></i></a>"
                 botonEditar = "<a id='btnTblMostrar' class='btn_tbl_mini_mostrar' href='javascript:cargarMov(" + value.id_atencion + ", \"M\")' data-toggle='tooltip' data-placement='top' title='Agregar observación'><i class='bi bi-pencil-square'></i></a>"
                 if(value.estado_pago == 'N'){
                    botonPago = "<a id='btnTblPagar' class='btn_tbl_mini_imprimir' href='javascript:pagarMov(" + value.id_atencion + ", \"P\")' data-toggle='tooltip' data-placement='top' title='Cambia estado Pago'><i class='bi bi-currency-dollar'></i></i></a>"
                }else
                {
                    botonPago = "<a id='btnTblPagar' class='btn_tbl_mini_imprimir icon_pago' href='javascript:pagarMov(" + value.id_atencion + ", \"P\")' data-toggle='tooltip' data-placement='top' title='Cambia estado Pago'><i class='bi bi-currency-dollar'></i></i></a>"
                }
                 lineaBotones = "<td class='centrartexto'>"
                 if (value.id_os == 61 || value.tipo_codigo=="P" || estado=="S"){
                     lineaBotones += botonBorrar+botonEditar
                     if (value.tipo_codigo!='O' || value.id_os == 61){
                        lineaBotones += botonPago
                     }

                 }
                 lineaBotones += "</td>";
                 cant += 1
                $("#tb1").append("<tr class='align-middle'>" + lineaBotones + 
                        "<td>" + value.fecha + "</td>" +
                        "<td>" + value.denominacion + "</td>" +
                        "<td>" + value.codigo_item + "</td>" +
                        "<td>" + value.desc_item + "</td>" +
                        "<td>" + value.elemento + " " + value.cara  + "</td>" +
                        "<td>" + value.obs + "</td>" +
                        "<td>" + value.importe + "</td>" +
                        "<td class='text-center'>" + value.estado + "</td>" +
                        "<td class='text-center'>" + value.estado_pago + "</td>" +
                        "<td class='text-center'>" + value.token + "</td>" +
                        
                        "</tr>")

                        importe = parseFloat(value.importe)

                        //totales
                        if (value.tipo_codigo=='O' && value.id_os != 61){
                            if (value.estado_pago=='N'){
                                totOsSinPagar+=importe
                            }else{
                                totOsPagas+=importe
                            }
                        }else{
                            if (value.estado_pago=='N'){
                                totPSinPagar+=importe
                            }else{
                                totPPagas+=importe
                            }
                        }
                })

                $("#tbTot").append("<tr class='align-middle text-end'>" + 
                        "<td>por OS</td>" +
                        "<td>" + totOsPagas.toFixed(2) + "</td>" +
                        "<td>" + totOsSinPagar.toFixed(2) + "</td>" +
                        "<td>" + (totOsPagas+ totOsSinPagar).toFixed(2) + "</td>" +
                        "</tr>")
                $("#tbTot").append("<tr class='align-middle text-end'>" + 
                        "<td>Sin OS</td>" +
                        "<td>" + totPPagas.toFixed(2) + "</td>" +
                        "<td>" + totPSinPagar.toFixed(2) + "</td>" +
                        "<td>" + (totPPagas+ totPSinPagar).toFixed(2) + "</td>" +
                        "</tr>")
                $("#tbTot").append("<tr class='align-middle text-end'>" + 
                        "<td>TOTALES</td>" +
                        "<td>" + (totOsPagas + totPPagas).toFixed(2) + "</td>" +
                        "<td>" + (totOsSinPagar + totPSinPagar).toFixed(2)  + "</td>" +
                        "<td>" + (totOsPagas + totOsSinPagar + totPPagas + totPSinPagar).toFixed(2) + "</td>" +
                        "</tr>")
         
 
                 

                espereHide()
            }


        })
       
    }  
   
    function cargarMov(id, funcion) {
        var rutaCrud = "atenciones"
        limpiarform()
        if (funcion == 'M') {
            $('#idBtAct').text('Modificar')
        }else{
            $('#idBtAct').text('Eliminar') 
        }  
        $.ajax({
                url: site_url() + rutaCrud + "/ConsultarIdJx",
                async: false,
                type: "POST",
                data: {"id":id},
                dataType: "json",
                success: function (respuesta) {
                    
                    limpiarform()
                    $('#idInFun').val(funcion);
                    $('#idNuId').val(respuesta.id_atencion);
                    $('#idObs').val(respuesta.obs);
                    $('#idPre').val(respuesta.importe);
    
                    if (respuesta.id_os == 61 || respuesta.tipo_codigo == "P" ){
                        $('#idPre').prop("disabled", false);
                    }else{
                        $('#idPre').prop("disabled", true);
                    }
        }
    })
    
    
    $('#exampleModal').modal('show');
    }
    

    
    
    
    
    //envia datos a CI para agregar  o modificar registro en BD
    function enviarCI() {
        var rutaCrud = "atenciones"
        var f =$('#idInFun').val();
        $.ajax({
            url: site_url() +  rutaCrud + "/crudCIJx",
            async: false,
            type: "POST",
            data: $("#idFR1").serialize(),
            dataType: "json",
            success: function (respuesta) {
               
                if(respuesta!=0) {
                    ciroMensaje("Operación realizada Exitosamente", "success")
                  
                }else{
                        ciroMensaje("Error al grabar", "warning")    
                        
                }
                $('#exampleModal').modal('hide');
                buscaDatos()
               
               
    
            }
        })
    }
    
    
    function limpiarform() {
        $('#idObs').val("");
        $('#idPre').val("");
        
    }
    

    function pagarMov(id) {
        var rutaCrud = "atenciones"
        $.ajax({
                url: site_url() + rutaCrud + "/pagoAteIdJx",
                async: false,
                type: "POST",
                data: {"id":id},
                dataType: "json",
                success: function (respuesta) {
                    if(respuesta!=0) {
                        buscaDatos()
                      
                    }   
        }
    })

}


function imprimir(){
    var fecha = $('#idFec').val()
    var  paciente = $('#idSelPac').val()
    var  tipo = $('#idSelTipo').val()
    var u = site_url() + "ReporteHisCli" + "/" +  fecha + "/" + paciente + "/"+ tipo   
    window.location.href = u
    
 }

 function imprimir2(){
    var fecha = $('#idFec').val()
    var  paciente = $('#idSelPac').val()
    var  tipo = $('#idSelTipo').val()
    var u = site_url() + "ReporteEstCue" + "/" +  fecha + "/" + paciente + "/"+ tipo   
    window.location.href = u
    
 }

