//=============READY EVENTOS======================
$(document).ready(function () {
    
    //inicializacio
    $("#idBtBorrar").click(function(){
        j = confirm("Confirma eliminar comprobante ") 
        if (j){
            borrarComp($("#idVta").val())
        } 
    })

       

    

})
//=====================fin ready eventos===========================
    


function borrarComp(idvta){
    u = site_url() + "BorrarComp"
   
    $.ajax({
            url: u,
            type: "POST",
            data: {"idvta": idvta},
            dataType: "json",
            success: function (respuesta) {
                
                if(respuesta!=0) {
                    
                    ciroMensaje("Comprobante eliminado correctamente", "success")
                    $("#idBtBorrar").prop("disabled", true)
                    //windows.location.href = site_url() + "LiquidacionesA"
                }else{
                    ciroMensaje("Error al borrar el comprobante", "error")    
                }
                
             
            }
       
        })
}