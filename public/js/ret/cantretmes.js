$(document).ready(function () {
    $('#idBtGuardar').click(function () {
        //alta
       
        var o = confirm("Confirma actualizar cantidades para profesionales ")
        if (o == true) {
           //funcion guardar
            var valor =[]
            var iditem=[]
            var idprof=[]
            var i = 0
            $('.claseInputItem').each(function() {
              valor[i]= $(this).val() 
              iditem[i]=  $(this).prop("id")
              idprof[i]= $(this).parents("tr").prop("id")
              i +=1
               });
             
            console.log(valor)
            actualizaItems(valor, iditem, idprof)
            
           
         } 
       
    })

    


    
})

//fin ready




function actualizaItems(can, idi, idp){
  //espereShow()    
 
  $.ajax({
          url: site_url() + "ActualizaRetMesProf",
          type: "POST",
          async: false,
          beforeSend: function(){
            
          }, 
          data: { "arrayValor": JSON.stringify(can), "arrayIdItem":JSON.stringify(idi), "arrayProf":JSON.stringify(idp)},
          dataType: "json",
          success: function (respuesta) {
            if(respuesta!=0) {
              ciroMensaje("Base de Datos actualizada", "success")
              
            }else{
              ciroMensaje("Imposible actualizar Base de Datos", "error")    
          }
        }
    })
    
 }
      
    
      
 
   
     


  