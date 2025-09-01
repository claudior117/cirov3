$(document).ready(function () {
    $('#idBtGuardar').click(function () {
        //alta
       
        var o = confirm("Confirma actualizar valores para retenciones mensuales ")
        if (o == true) {
           //funcion guardar
           const entradas = document.getElementsByClassName("claseInputItem");
           if(entradas && entradas.length > 0){
            
            var valor =[]
            var iditem=[]
            
            for(let i=0;i<entradas.length;i++){
              //console.log(entradas[i].value, entradas[i].id)
             
              valor[i]= entradas[i].value 
              iditem[i]=  entradas[i].id
                     
            }
            
           
           actualizaItems(valor, iditem)
            
           
         } 
       
        }
    })

    
    $('#idBtAgregar').click(function () {
      //alta
      limpiarform()
      alta()
  })



  


  $('#idFR1').submit(function(e) {
    e.preventDefault();
    var o = confirm("Confirma enviar Liquidación de Retenciones (Recuerde que es necesario haber realizado los recibos del período antes de esta operación)")
    if (o == true) {
        liquidarRet();
      
    }
})




    
})

//fin ready




function actualizaItems(can, idi){
  //espereShow()    
 
  $.ajax({
          url: site_url() + "ActualizaRetMes",
          type: "POST",
          async: false,
          beforeSend: function(){
            
          }, 
          data: { "arrayValor": JSON.stringify(can), "arrayIdItem":JSON.stringify(idi)},
          dataType: "json",
          success: function (respuesta) {
            if(respuesta!=0) {
              ciroMensaje("Retenciones actualizadas", "success")
            }else{
              ciroMensaje("Imposible actualizar Retenciones", "error")    
          }
        }
    })
    
 }
      

 function limpiarform() {
  $('#idNuAño2').val(añoActual());
  $('#idNuMes2').val(mesActual());
  
  $('#modal-header').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
  $('#idFR1').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')
  $('#idBtAct').removeClass('fondoborrar', 'fondomodificar', 'fondoagregar').addClass('fondo')


}

function alta(){
  limpiarform()
  $('#exampleModal').modal('show');

}







function liquidarRet() {
   

      $.ajax({
          url: site_url() + "LiquidarRetMes",
          async: false,
          type: "POST",
          data: $("#idFR1").serialize(),
          dataType: "json",
          success: function (respuesta) {
             
              if(respuesta!=0) {
                      mensajeCiro("Base de Dato actualizada", "success")
              }else{
                      mensajeCiro("Imposible Actualizar, verifique que la Liquidación no existe", "warning")    
              }
              $('#exampleModal').modal('hide');
              

          }
      })
  }    
 
   
     


  