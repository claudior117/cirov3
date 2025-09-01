//Inicializacion documento, funciones ajax y control de eventos  

//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    $('#idBtMostrar').click(function () {
        
        buscaDatos(1);        
   })


   $('#idSerchDesc').keyup(function () {
        
    buscaDatos(2);        
})


$('#idSerchCod').keyup(function () {
        
    buscaDatos(3);        
})

  
$('#idSerchCod').blur(function () {
    $('#idSerchCod').val("")
})

$('#idSerchDesc').blur(function () {
    
    $('#idSerchDesc').val("")        
})

})
//=====================fin ready eventos===========================
    






//====================FUNCIONES=========================================
function buscaDatos(tipo){
   $("#tb1").empty()
    var salida = 1
    var qestado = ""
          
        espereShow()
        var lineaBotones = ""
        var lineaEstado = ""
        var lineaEstado2 = "" 
        var arancel, q 
        switch (tipo) {
            case 1:
                q= " where id_item > 0" //todos  
                break
            case 2:
                q = " where UPPER(item) like '%" + $("#idSerchDesc").val().toUpperCase() + "%'" //por desc
                break
            case 3:
                    q = " where codigo like '" + $("#idSerchCod").val() + "%'" //por codigo
                    break
        }        
        
        //var u = site_url() + "MostrarMinP"  
        //var u = "MostrarMinP"
        q = q + " order by codigo"
        var cant = 0
        $.ajax({
            url: "MostrarMinP",
            async: false,
            type: "POST",
            data: {"q":q},
            dataType: "json",
            
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                   
                lineaBotones = "<td class='centrartexto'><a id='btnTblMostrar' class='btn_tbl_mini_mostrar'  href='BuscarOsItemsP/" + value.id_item + "' data-toggle='tooltip' data-placement='top' title='Mostrar OS con cobertura'> <i class='bi bi-stack-overflow'></i></a></td>" 
                arancel = value.arancel 
                cant += 1
                $("#tb1").append("<tr class='align-middle'>" + lineaBotones + 
                        "<td>" + value.id_item + "</td>" +
                        "<td>" + value.codigo + "</td>" +
                        "<td>" + value.item + "</td>" +
                        "<td class='text-end' style='font-size:15px;'><b>" + parseFloat(value.arancel).toFixed(2)  + "</b></td>" +
                        "<td class='text-center'>" + value.fecha_actu + "</td>" +
                        "</tr>")

                })
                $("#tb1").append("<tr class='align-middle'><td></td><td></td><td></td>" +
                "<td><b>Cantidad de items: " + cant + "</b></td>" +
                "<td></td><td></td></tr>")
                espereHide()
            }
        })
       
    }  
   







