//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {

    rutaCrud = "arapro"

    //inicializacio
    $('#idBtMostrar').click(function () {
        
        buscaDatos();        
   })


   $('#idSerchNombre').keyup(function () {
        
    buscaDatos();        
})


$('#idSerchCod').keyup(function () {
        
    buscaDatos();        
})


$('#idSerchCod').focus(function () {
    $('#idSerchCod').val("")
})

$('#idSerchNombre').focus(function () {
    
    $('#idSerchNombre').val("")        
})



$('#idBtAgregar').click(function () {
    //alta
    limpiarform()
    alta()
})


$('#idFR1').submit(function(e) {
    e.preventDefault();
   
    Swal.fire(
        {
            title: "Alerta!",
            text: "Confirma actualizar arancel propio? " ,
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
    var salida = 1
    var qestado = ""
          
        espereShow()
        var lineaBotones = ""
        var lineaEstado = ""
        var lineaEstado2 = "" 
        var cod = $('#idSerchCod').val()
        var nombre = $('#idSerchNombre').val()
        var cant = 0
        $.ajax({
            url: "BuscaAraProAx",
            async: false,
            type: "POST",
            data: {"cod":cod, "nombre":nombre},
            dataType: "json",
            
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                   
                //lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='javascript:cargarMov(" + value.id_paciente + ", \"M\")' data-toggle='tooltip' data-placement='top' title='Modificar datos del paciente'> <i class='bi bi-stack-overflow'></i></a><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='<?= site_url('prof/atenciones/index.php?id=" + value.id_paciente + "') ?>' data-toggle='tooltip' data-placement='top' title='Cargar atenciones'> <i class='bi bi-stack-overflow'></i></a></td>" 
                lineaBotones = "<td class='centrartexto'>"
                    + "<a id='btnTblMostrar' class='btn_tbl_mini_mostrar' href='javascript:cargarMov(" + value.id_itemp + ", \"M\")' data-toggle='tooltip' data-placement='top' title='Modificar'><i class='bi bi-pencil-square'></i></a>"
                    + "</td>";
                cant += 1
                $("#tb1").append("<tr class='align-middle'>" + lineaBotones + 
                        "<td>" + value.id_itemp + "</td>" +
                        "<td>" + value.codigop + "</td>" +
                        "<td>" + value.itemp + "</td>" +
                        "<td>" + value.preciop + "</td>" +
                        "<td>" + value.aplicap + "</td>" +
                        "</tr>")

                })
                espereHide()
            }
        })
       
    }  
   

    function alta(){
        limpiarform()
        $('#idInFun').val('A');
        $('#idNuId').val('0');
        $('#exampleModal').modal('show');
        $('#idBtAct').text('Agregar')
    
    }
    
    
    
    function limpiarform() {
        $('#idCod').val("");
        $('#idIte').val("");
        $('#idPre').val("");
        
    }



//envia datos a CI para agregar  o modificar registro en BD
function enviarCI() {
    var f =$('#idInFun').val();
    $.ajax({
        url: site_url() +  rutaCrud + "/crudCIJx",
        async: false,
        type: "POST",
        data: $("#idFR1").serialize(),
        dataType: "json",
        success: function (respuesta) {
           
            if(respuesta!=0) {
              if(respuesta!=9) {      
                ciroMensaje("Operación realizada Exitosamente", "success")
              }else
              {
                ciroMensaje("El código existe ", "warning")
              }
            }else{
                    ciroMensaje("Error al grabar", "warning")    
                    
            }
            $('#exampleModal').modal('hide');
            buscaDatos()

        }
    })
}

//carga el formulario con los datos para editar o borrar registro
function cargarMov(id, funcion) {
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
                $('#idNuId').val(respuesta.id_itemp);
                $('#idCod1').val(respuesta.codigop.substring(0,2));
                $('#idCod2').val(respuesta.codigop.substring(3,5));
                $('#idCod3').val(respuesta.codigop.substring(6,8));
                $('#idIte').val(respuesta.itemp);
                $('#idPre').val(respuesta.preciop);
                


                
    }
})
$('#exampleModal').modal('show');
}

