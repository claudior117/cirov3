$(document).ready(function () {
    $('#idIdP').val(0)
    $('#idFec').val(fechaActual())
    var numero = 0
    var cara = "S" 
    
    $('.diente').on('click', function () {
        if ($('#idIdP').val()!= 0){ 
              numero = $(this).attr('id').substring(7, 9)
              cara = $(this).attr('id').substring(10, 11)
                
                console.log(numero, cara)
                               
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



})//fin ready 




function buscaPaciente(dni){
  //busca el paciente por DNI, si lo encuntra devuelve el id, sino devuelve 0
    var idp = 0    
    var u = site_url() + "BuscaPacienteAx"
    $.ajax({
        url: u,
        type: "POST",
        data: {"dni": dni},
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
            $('#idIOS').append(`<option value="${value.id_itemos}" data-precio="${value.precio}" data-aplica="${value.aplica}">${value.codigo}  ${value.desc_item} </option>`);
           })
       }
   })            
  
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
       data: {"idp": idp, "idos": idos, "estado":'S'},
       dataType: "json",
       async:false,
       success: function (respuesta) {
           $.each(respuesta, function (key, value) {
            lineaBotones = "<td class='centrartexto'><a id='btnTblBorrar' class ='btn_tbl_mini_borrar' href='javascript:borrarAte(" + value.id_atencion + ")' data-toggle='tooltip' data-placement='top' title='Borrar Atención'><i class='bi bi-trash-fill'></i></a></td>" 
                        
            
                $("#tb1").append("<tr id='" + key + "'>" + lineaBotones + 
                "<td>" + value.fecha + "</td>" +
                "<td>" + value.elemento.padStart(2, "0") + " " + value.cara + "</td>" +
                "<td>" + value.codigo + " " + value.desc_item.substring(0,40) + "</td>" +
                "<td>" + value.importe + "</td>" +


           "</tr>")
       
        })
       }
   })            
  
  }


function seleccionaPieCar(n,c){
    //if (n != $('#idPie').val() ) {
    //    $('#idPie').val(n).trigger('change')
        
    //}

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

function borrarAte(id) {
    var u = site_url() + "BorrarAtencionesAxP"
    $.ajax({
        url: u,
        type: "POST",
        data: {"id": id},
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
    
    cargaAtenciones()
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
    var cara = armaCara()
    console.log(importe)
    $.ajax({
        url: u,
        type: "POST",
        data: {"idp": idp, "f":f, "idos":idos, "iditem":iditem, "p":pieza, "c":cara, "imp":importe},
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





