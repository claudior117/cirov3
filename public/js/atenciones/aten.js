$(document).ready(function () {
    $('#idIdP').val(0)
    $('#idFec').val(fechaActual())
    var numero = 0
    var cara = "S" 

    
    $('.diente').on('click', function () {
        if ($('#idIdP').val()!= 0  &&  $('#idIOS').find("option:selected").data("aplica") != 'S'){ 
            
            numero = $(this).attr('id').substring(7, 9)
              cara = $(this).attr('id').substring(10, 11)
                
                if (numero != $('#idPie').val() ) {
                    //limpiaOdonto()
                    $('#idPie').val(numero).trigger('change')
                    
                }
                


        // Cambiar estilo visual
        if (cara == 'T' || cara == 'S'){
            if ($(this).hasClass("diente-sel")) {
                $(this).removeClass("diente-sel")
            } else {
                $(this).addClass("diente-sel");
            }
            
        }
        else if(cara != 'S')
            {
                if ($(this).hasClass("cara-sel")) {
                    $(this).removeClass("cara-sel")
                } else {
                    $(this).addClass("cara-sel");
                }
             }
         }  
         else{
            var numero = 0
            var cara = "S" 
         }     
    
        //seleccionar numero y cara
         seleccionaPieCar(numero, cara)
      
        })

      $('#idDNI').blur(function() {
        if ($(this).val().length < 5) {
          alert('El Paciente no está ingresado');
        }
        else{
            if (buscaPaciente($(this).val()) > 0 ){
                //paciente encontrado
                limpiaCh()
                cargaItemsOs($('#idSelOs').val())
                cargaAtenciones()
                habilitaColumnas()
            }else{
                alert('El Paciente no está ingresado');
            }
        }    
      });


      $('#idSelOs').change(function() {
        if($('#idIdP').val()!= 0){
            cargaItemsOs($('#idSelOs').val())
            cargaAtenciones()
        }
        
       });  

       $('#idPie').change(function() {
        limpiaOdonto()
        limpiaCh()
        
       });  

       $('#idIOS').change(function() {
        limpiaOdonto()
        limpiaCh()
       });  



       $('#idBAgr').click(function () {
         agregarAte()
       });

       $('#idIOS').change(function() {
        habilitaColumnas()
       });  

       
      $('#chIdI').change(function () {
        if ($("#chIdI").is(":checked")) {
            $("#chIdO").prop("checked", false);
        }
      });

      $('#chIdO').change(function () {
        if ($("#chIdO").is(":checked")) {
            $("#chIdI").prop("checked", false);
        }
      });


      $('#chIdP').change(function () {
        if ($("#chIdP").is(":checked")) {
            $("#chIdL").prop("checked", false);
        }
      });

      $('#chIdL').change(function () {
        if ($("#chIdL").is(":checked")) {
            $("#chIdP").prop("checked", false);
        }
      });


    $('#radio1').change(function () {
        activarItems()
      });

    $('#radio2').change(function () {
        activarItems()
      });


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
    






})//fin ready 




function buscaPaciente(dni){
  //busca el paciente por DNI, si lo encuntra devuelve el id, sino devuelve 0
    var idp = 0    
    var u = site_url() + "BuscaPacienteAx"
    $.ajax({
        url: u,
        type: "POST",
        data: {"dni": dni, "nombre":"", "os":""},
        dataType: "json",
        async:false,
        success: function (respuesta) {
            $.each(respuesta, function (key, value) {
                idp =value.id_paciente
                $('#idNom').val(value.denominacion)
                $('#idIdP').val(value.id_paciente)
                $('#idSelOs').val(value.id_os)
                
            })
        }
    })            
    return idp
}

function cargaItemsOs(idos){
    //carga el lsitado de items de la obra social

            $('#idIOS').empty();
            var u = site_url() + "MostrarItemOsAjaxP"
            var q = " where id_os = " + idos
            
            $.ajax({
                url: u,
                type: "POST",
                data: {"q": q},
                dataType: "json",
                async:false,
                success: function (respuesta) {
                    $.each(respuesta, function (key, value) {
                        $('#idIOS').append(`<option value="${value.id_itemos}" data-grupo= 'OS' data-precio="${value.precio}" data-aplica="${value.aplica}" data-codigo="${value.codigo}"  >${value.codigo}  ${value.desc_item} </option>`);
                    })
                }
            })   
            
   var u = site_url() + "BuscaAraProAx"
   
   $.ajax({
       url: u,
       type: "POST",
       data: {"cod":"", "nombre":""},
       dataType: "json",
       async:false,
       success: function (respuesta) {
           $.each(respuesta, function (key, value) {
            $('#idIOS').append(`<option value="${value.id_itemp}" data-grupo= 'PROPIOS' data-precio="${value.preciop}" data-aplica="${value.aplicap}" data-codigo="${value.codigop}">${value.codigop}  ${value.itemp} </option>`);
           })
       }
   })   
   
   activarItems()
  }

  function activarItems(){
    var opciones = $("#idIOS option[data-grupo]");
    var grupo
    if ($("#radio1").is(":checked")) {
        grupo = $("#radio1").val();
    }else
    {
        grupo = $("#radio2").val();
    }
    var b=0
    opciones.each(function() {
        if ($(this).data("grupo") === grupo) {
        $(this).show();
        } else {
        $(this).hide();
        }

    });

    const opcion = $('#idIOS option').filter(function() {
        return $(this).data('grupo') === grupo;
      }).first();
      
      // Asignarla al select
      if(opcion.length) {
        $('#idIOS').val(opcion.val());
      }
    
    
  }

  function cargaAtenciones(){
    //carga atenciones sin liquidar del paciente y la OS
   idp = $('#idIdP').val()
   idos = $('#idSelOs').val()
   
   $('#tb1').empty();
   var u = site_url() + "MostrarAtencionesAxP"
   $.ajax({
       url: u,
       type: "POST",
       data: {"idp": idp, "idos": idos, "estado":'S', "tipo":'T'},
       dataType: "json",
       async:false,
       success: function (respuesta) {
           $.each(respuesta, function (key, value) {
            lineaBotones = "<td class='centrartexto'><a id='btnTblBorrar' class ='btn_tbl_mini_borrar' href='javascript:cargarMov(" + value.id_atencion + ", \"B\")' data-toggle='tooltip' data-placement='top' title='Borrar Atención'><i class='bi bi-trash-fill'></i></a><a id='btnTblMostrar' class='btn_tbl_mini_mostrar' href='javascript:cargarMov(" + value.id_atencion + ", \"M\")' data-toggle='tooltip' data-placement='top' title='Agregar observación'><i class='bi bi-pencil-square'></i></a></td>" 
            
            
                $("#tb1").append("<tr id='" + key + "'>" + lineaBotones + 
                "<td>" + value.fecha + "</td>" +
                "<td>" + value.elemento.padStart(2, "0") + " " + value.cara + "</td>" +
                "<td>" + value.codigo_item + " " + value.desc_item.substring(0,40) + "</td>" +
                "<td>" + value.importe + "</td>" +
                "<td>" + value.obs + "</td>" +
                "<td>" + value.token + "</td>" +
                
                
           "</tr>")
       
        })
       }
   })            
  
  }


function seleccionaPieCar(n,c){
    //if (n != $('#idPie').val() ) {
    //    $('#idPie').val(n).trigger('change')
        
    //}
    if($('#idIOS').find("option:selected").data("aplica") == 'C'){
    switch (c) {
        case "V":
            if($('#chIdV').is(':checked')) {
                $('#chIdV').prop('checked', false);
            }else{
                $('#chIdV').prop('checked', true);
            }
            break;
        case "P":
            if($('#chIdP').is(':checked')) {
                $('#chIdP').prop('checked', false);
            }else{
                $('#chIdP').prop('checked', true);
            }
            break;
        case "L":
            if($('#chIdL').is(':checked')) {
                $('#chIdL').prop('checked', false);
            }else{
                $('#chIdL').prop('checked', true);
            }
            break;
        case "I":
            if($('#chIdI').is(':checked')) {
                $('#chIdI').prop('checked', false);
            }else{
                $('#chIdI').prop('checked', true);
            }
            break;    
        case "O":
            if($('#chIdO').is(':checked')) {
                $('#chIdO').prop('checked', false);
            }else{
                $('#chIdO').prop('checked', true);
            }
            break;    
        case "M":
            if($('#chIdM').is(':checked')) {
                $('#chIdM').prop('checked', false);
            }else{
                $('#chIdM').prop('checked', true);
            }
            break;    
        case "D":
            if($('#chIdD').is(':checked')) {
                $('#chIdD').prop('checked', false);
            }else{
                $('#chIdD').prop('checked', true);
            }
            break;    
        case "T":  //ejecuta lo mismo que S(no tiene breack)
        case "S":
                limpiaCh() 
                $('#chIdS').prop('checked', true);
                break;
    

        default:
          // Código a ejecutar si no coincide ningún case
      }
    }
    }

      function limpiaCh(){
        $('#chIdV').prop('checked', false);
        $('#chIdP').prop('checked', false);
        $('#chIdL').prop('checked', false);
        $('#chIdI').prop('checked', false);
        $('#chIdO').prop('checked', false);
        $('#chIdM').prop('checked', false);
        $('#chIdD').prop('checked', false);
        $('#chIdS').prop('checked', false);
      }

function limpiaOdonto(){
    $('.odonto').removeClass("diente-sel")
    $('.odonto').removeClass("cara-sel")
}



function agregarAte() {
 
 if (verificaAgregar()){
    var u = site_url() + "AgregarAtencionesAxP"
   
    var idp = $('#idIdP').val()
    var f = $('#idFec').val()
    var idos = $('#idSelOs').val()
    var iditem =  $('#idIOS').val()
    var pieza = $('#idPie').val()
    var importe = $('#idIOS').find("option:selected").data("precio")
    var grupo = $("#idIOS option:selected").data("grupo");
    var token =$('#idToken').val()
    var tipo
    if (grupo === "OS") {
        tipo = "O"
    }else
    {
        tipo = "P"
    }
    var cara = armaCara()

    
    var selectedOption = $('#idIOS').find('option:selected');
    var codigo = selectedOption.data('codigo');
    var diagnostico = '';
    
    if (codigo && codigo.substring(0, 2) === '09') {
        
        // Pedir diagnóstico hasta que no esté vacío
        while (diagnostico.trim() === '') {
            diagnostico = prompt('La categoría 09.xx.xx se requiere diagnóstico. Por favor ingrese el diagnóstico:');
            
            // Si el usuario cancela, resetear el select
            if (diagnostico === null) {
                $(this).val('').trigger('change');
                return;
            }
            
            // Si está vacío, mostrar alerta
            if (diagnostico.trim() === '') {
                alert('El diagnóstico no puede estar vacío. Por favor ingrese un diagnóstico válido.');
            }
        }
    }
    
    $.ajax({
        url: u,
        type: "POST",
        data: {"idp": idp, "f":f, "idos":idos, "iditem":iditem, "p":pieza, "c":cara, "imp":importe, "tipo":tipo , "token":token, "obs":diagnostico},
        dataType: "json",
        async:false,
        success: function (respuesta) {
            if(respuesta!=0) {
                cargaAtenciones()
                limpiaCh()
                limpiaOdonto()
            }
         
        }
    })            
    
    
}

}

function armaCara(){
c = ""
$('input[type="checkbox"]:checked').each(function() {
    // Tu código para cada checkbox seleccionado
     console.log($(this).val()); // Obtiene el valor del checkbox seleccionado
    c = c + $(this).val()
 });
return c

}

function habilitaColumnas(){
    aplica = $('#idIOS').find("option:selected").data("aplica")
    
    switch (aplica) {
        case "S":
            $("#idPie option:first").prop("selected", true);
            $("#idPie").prop("disabled", true);
            $("#bloque-caras").prop("disabled", true);  
            break;
        case "P":
            $("#idPie").prop("disabled", false);
            $("#bloque-caras").prop("disabled", true);  
            break;
        case "C":
            $("#idPie").prop("disabled", false);
            $("#bloque-caras").prop("disabled", false);  
            break;        

    }  
    
    
    
        
}




function verificaAgregar(){
  a = true  
  if  ($('#idIOS').find("option:selected").data("aplica") == 'S'  &&  $("#idPie").val()!=0){
      alert("El código seleccionado no requiere pieza dentaria. Seleccione 00 o cambie de código")
      a = false
  }

  if  ($('#idIOS').find("option:selected").data("aplica") != 'S'  &&  $("#idPie").val()==0){
    alert("El código seleccionado requiere pieza dentaria. Seleccione una pieza distinta a 00 o cambie de código")
    a = false
}

if  ($('#idIOS').find("option:selected").data("aplica") == 'C'){
    if  ($("#idPie").val()==0){
        alert("El código seleccionado requiere Pieza dentaria y Cara. La pieza dentaria no puede ser 00. Cambie la pieza dentaria o seleccione otro código")
        a  = false
        }
    else
        {
        if ($("fieldset input[type='checkbox']:checked").length == 0) {
            alert("El código seleccionado requiere Pieza dentaria y Cara. Seleccione alguna CARA o cambie el código")
            a  = false
        } 
    }    
}





if (a==true){
   //busca en la tabla si la pieza ya fue ingresada sin liquidar
   var idp = $('#idPie').val()
   $("#tb1 tr").each(function() {
    let codigoTabla = $(this).find("td:eq(2)").text().trim();
   
    if (codigoTabla.substring(0,3) == idp) {
      let respuesta = confirm("Se va a ingresar una pieza que ya fue ingresada")
      if (!respuesta){
          a = false
      }  
      return false; // corta el each
      }  
});
}
 
return a 


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
                $('#idTok').val(respuesta.token);

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
            cargaAtenciones()
            limpiaCh()
            limpiaOdonto()

        }
    })
}


function limpiarform() {
    $('#idObs').val("");
    $('#idPre').val("");
    
}