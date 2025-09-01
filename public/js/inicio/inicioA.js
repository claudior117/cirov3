$(document).ready(function () {
    
    
    graficoLiq()
    
    
    
    $('#BtnCambiarPass').click(function () {
        //carga mensjases
       cambiaContraseña()
    })

    


})



function cambiaContraseña(){
    $('#exampleModalLabel').text('Cambiar contraseña')
    $('#exampleModal').modal('show');
}




function graficoLiq(){
    
  const ctx = document.getElementById('idChartLiq');
  etiquetas=[]
  datos = []
  datos2 = []
  datos3 = []
  datos4 = [] 
  $.ajax({url: site_url() +"datosChartAjaxAdmin",
            type: "POST",
            async: false,
            data: {},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    etiquetas.push(value.periodo)
                    datos.push(value.total)
                    datos2.push(value.impFact)
                    datos3.push(value.impRbo)
                    datos4.push(value.impTransf)
                    
                })   
            }
        })

  
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: etiquetas,
      datasets: [{
        label: 'Liquidado ',
        data: datos,
        backgroundColor: 'rgba(255, 159, 64, 0.2)',
        borderColor: 'rgb(255, 159, 64)',
        borderWidth: 1
      },
      {
        label: 'Facturado',
        data: datos2,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgb(75, 192, 192)',
        borderWidth: 1
      },
      {
        label: 'Cobrado',
        data: datos3,
        backgroundColor: 'rgba(51, 255, 16, 0.2)',
        borderColor: 'rgb(51, 255, 16)',
        borderWidth: 1
      },
      {
        label: 'Transferido',
        data: datos4,
        backgroundColor: 'rgba(246, 255, 51, 0.2)',
        borderColor: 'rgb(246, 255, 51)',
        borderWidth: 1
      }
    ]
    },
    options: {
      animation: {
            duration: 1200,
            easing: "easeOutQuart"
        },
        
      
    tooltips: false,
    plugins: {
          datalabels: {
           anchor: 'end',
           backgroundColor: function(context) {
             return context.dataset.backgroundColor;
           },
          
           borderColor: 'white',
           borderRadius: 5,
           borderWidth: 0,
           color: 'white',
           display: function(context) {
             var dataset = context.dataset;
             var count = dataset.data.length;
             var value = dataset.data[context.dataIndex];
             return value;// > count * 1.5;
           },
           formatter: Math.round,
           font: {
             weight: 'bold',
             size: '16'
           },
          }
        },
      },
      
      scales: {
        xAxes: [{
          stacked: true
        }],
        yAxes: [{
          stacked: true
        }]
      }

  });




}//fin cuncion chart



