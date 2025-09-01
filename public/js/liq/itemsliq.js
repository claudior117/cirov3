$(document).ready(function () {
    $('#idBtGuardar').click(function () {
        //alta
       
        var o = confirm("Confirma actualizar liquidación")
        if (o == true) {
           //funcion guardar
          

          
           const entradas = document.getElementsByClassName("claseInputItem");
           if(entradas && entradas.length > 0){
            
            var cantidad =[]
            var iditem=[]
            for(let i=0;i<entradas.length;i++){
              //console.log(entradas[i].value, entradas[i].id)
             
              cantidad[i]= entradas[i].value 
              iditem[i]=  entradas[i].id
                                
            }
            
            actualizaItems(cantidad, iditem)
            actualizaLiq();
           
         } 
       
        }
    })



    $('#idBtGuardar2').click(function () {
      //alta
     
      var o = confirm("Confirma actualizar liquidación")
      if (o == true) {
         //funcion guardar
        

        
         const entradas = document.getElementsByClassName("claseInputItem");
         if(entradas && entradas.length > 0){
          
          var cantidad =[]
          var iditem=[]
          for(let i=0;i<entradas.length;i++){
            //console.log(entradas[i].value, entradas[i].id)
           
            cantidad[i]= entradas[i].value 
            iditem[i]=  entradas[i].id
                              
          }
          
          actualizaItems(cantidad, iditem)
          actualizaLiq();
         
       } 
     
      }
  })

    


    $('.claseInputItem').change(function(){
      
      if ($(this).val()>0){    
        //$(this).css('background-color', '#99F38A');
        //$(this).parents("tr").css('background-color', '#99F38A');
        $(this).css({"font-weight":"bold"});
        $(this).parents("tr").css({"font-weight":"bold"});
    }
      else{
        $(this).css({"font-weight":"normal"});
        $(this).parents("tr").css({"font-weight":"normal"});
      } 
      
      var imp = parseFloat($(this).parents("tr").find("td").eq(5).text()) * $(this).val()
      $(this).parents("tr").find("td").eq(6).text(imp.toFixed(2))
       
      sumaTabla()
})

})

//fin ready



function sumaTabla(){
    //suma columna
    var sum = 0;
    $('.CelImporte').each(function() {
    sum += parseFloat($(this).text());
     });
    $('#resultado_total').text(sum.toFixed(2)).css("font-weight","bold" )
   

}




function actualizaItems(can, idi){
  //espereShow()    
 
  $.ajax({
          url: site_url() + "AgregaItemLiq",
          type: "POST",
          async: false,
          beforeSend: function(){
            
          }, 
          data: { "arrayCant": JSON.stringify(can), "arrayIdItem":JSON.stringify(idi), "idLiq": $("#idTeIdLiq").val()},
          dataType: "json",
          success: function (respuesta) {
            
         }
    })
    
 }
      
 function actualizaLiq(){
      
  $.ajax({
          url: site_url()+"ActualizaLiq",
          type: "POST",
          async: false,
          data: {"idLiq": $("#idTeIdLiq").val()},
          dataType: "json",
          beforeSend: function(){
          },
          success: function (respuesta) {
            if(respuesta!=0) {
              ciroMensaje("Liquidación actualizada", "success")
            }else{
              ciroMensaje("Imposible actualizar Liquidación", "error")    
              
      }
         }
    })
    
 }
      
 
   
     


  