var chart
var chart2
var chart3

$(document).ready(function () {
    
   $("#idaño").val(añoActual()) 
   $("#idaño").attr('max', añoActual())
   $("#idaño").attr('min', 2023)
   

    
    graficoLiq()
    graficoLiq2()
    graficoLiq3()

    $('#idaño').change(function(){
      graficoLiq()
      graficoLiq2()
      graficoLiq3()
    })

    //Actualiza Mensajes cada vez que se entra con el miouse al cuadro
    $('#idBtnMsj').click(function () {
        //carga mensjases
        cargaMensajes()
    })

    
    $('#BtnCambiarPass').click(function () {
        //carga mensjases
       cambiaContraseña()
    })

    


})


function cargaMensajes(){
    $('#idMarcoMsj').empty()
    $('#idMarcoMsj').append("MENSAJES DE LOS ÚLTIMOS 7 DíAS<br>")
    $.ajax({url: site_url() +"InicioMsj",
            type: "POST",
            async: false,
            data: {},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    $('#idMarcoMsj').append(value.fecha + " *** " + value.mensaje + " <br>")
                })   
            }
        })
    } 

function cambiaContraseña(){
    $('#exampleModalLabel').text('Cambiar contraseña')
    $('#exampleModal').modal('show');
}


function graficoLiq(){
  var ctx = document.getElementById('idChartLiq');  
  etiquetas=[]
  datos = []
  var a = $('#idaño').val()
  $.ajax({url: site_url() + "datosChartAjax",
            type: "POST",
            async: false,
            data: {"año":a},
            dataType: "json",
            success: function (respuesta) {
                $.each(respuesta, function (key, value) {
                    etiquetas.push(value.periodo)
                    datos.push(value.total)
                })   
            }
        })




  var configuration =  {
    type: 'bar',
    data: {
      labels: etiquetas,
      datasets: [{
        label: 'Liquidación por período ',
        data: datos,
        backgroundColor: 'rgba(255, 159, 64, 0.2)',
        borderColor: 'rgb(255, 159, 64)',
        borderWidth: 1
      }]
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

    }

if (chart) {
    chart.destroy();
    chart = new Chart(ctx, configuration);
  } else {
    chart = new Chart(ctx, configuration);
  }


}//fin cuncion chart



function graficoLiq2(){
    
    const ctx2 = document.getElementById('idChartLiq2');
    etiquetas=[]
    datos = []
    datos2 = []
    var a = $('#idaño').val()
    $.ajax({url: site_url() +"datosChartAjax2",
              type: "POST",
              async: false,
              data: {"año": a},
              dataType: "json",
              success: function (respuesta) {
                  $.each(respuesta, function (key, value) {
                      etiquetas.push(value.os.substring(0,7))
                      datos.push(value.total)
                      datos2.push(value.pagas)
                  })   
              }
          })
  
   
    configuration = {
      type: 'bar',
      data: {
        labels: etiquetas,
        datasets: [{
          label: 'Liquidado',
          data: datos,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgb(255, 99, 132)',
          borderWidth: 1
        }, 
        {
          label: 'Transferido',
          data: datos2,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgb(75, 192, 192)',
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
               size: '11'
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
      }
  
    if (chart2) {
      chart2.destroy();
      chart2 = new Chart(ctx2, configuration);
    } else {
      chart2 = new Chart(ctx2, configuration);
    }
  
  
  
  }//fin cuncion chart2



  function graficoLiq3(){
    const ctx3 = document.getElementById('idChartLiq3');
    etiquetas=[]
    datos = []
    var a = $('#idaño').val()
    $.ajax({url: site_url() +"datosChartAjax3",
              type: "POST",
              async: false,
              data: {"año": a},
              dataType: "json",
              success: function (respuesta) {
                  $.each(respuesta, function (key, value) {
                      datos.push(value.totalPagas)
                      datos.push(value.totalImpagas)
                  })   
              }
          })
  
    etiquetas = ['Liq. transferidas', 'Liq. sin transferir']      
    configuration = {
      type: 'doughnut',
      data: {
        labels: etiquetas,
        datasets: [{
          data: datos,
          backgroundColor: ['rgba(255, 205, 86, 0.2)','rgba(153, 102, 255, 0.2)'],
          borderColor: ['rgb(255, 205, 86)','rgb(153, 102, 255)'],
          borderWidth: 1
        }]
      },
      options: {
        animation: {
              duration: 1200,
              easing: "easeOutQuart"
          },
      
      maintainAspectRatio: false,
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
               size: '11'
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
  
    }

    if (chart3) {
      chart3.destroy();
      chart3 = new Chart(ctx3, configuration);
    } else {
      chart3 = new Chart(ctx3, configuration);
    }

  }//fin cuncion chart3
