<?php
//parametros de impresion

//hoja A4 Vertical
$anchoHoja ='210mm';
$altoHoja ='297mm'; 
$margenSup = '20mm';
$margenDer = '10mm';
$margenInf = '10mm';
$margenIzq = '20mm';
$margen = $margenSup . " " . $margenDer . " " . $margenInf . " " . $margenIzq ;   

$lineasHoja = 55;
$GLOBALS['titulo'] ="LIQUIDACIÓN MENSUAL: " . $periodo ;
$GLOBALS['pagina'] = 1;


function nuevaHoja($p, $prof){
  $lineas = 0;
 require APPPATH. "Views/plantilla/headerReportes.php";    
 
echo('<div style="font-family:courier; font-size:11px; border:solid 1px black; align:left; margin:5mm;">
<table style="width:90%; margin:auto;">
 <tr>
   <td><p style="font-size:16px;"><strong>'.$GLOBALS['titulo'] . '<strong></p></td>
   <td><p><strong>Profesional:'. $prof .'<strong></p></td>
   
 </tr>
 
</table>

</div>
</div>');



  echo('<table style="width:95%; margin:auto;" >
  <thead style="border-collapse: separate; background-color:#f8ffb8;  border:3px solid blue; font-size:13px;">
   <tr style="font-weight: bold; "> 
   <td>Liq</td>
   <td>Detalle Ingresos</td>
   <td>Período</td>
   <td >Detalle Egresos</td>
   <td style="text-align:end;">Ingresos</td>
   <td style="text-align:end;">Egresos</td>
   <td style="text-align:end;">Totales</td>
   </tr>

      </thead>
  <tbody style="font-size:11px;">');

}


?>






<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    

<style>

  /**Margenbes de la pagina */
  @page {
    /*margin:100px 25px;*/
    size: A4; 
    margin: <?=$margen?>;
  }

  @media print
{
.no-print, .no-print *
{
display: none !important;
}
}

  body {
     font-family: Courier;
     width: <?=$anchoHoja?>;
     height: <?=$altoHoja?>;
    }

  
  .saltoLinea{
    page-break-after: always;
  
  }
  </style>
</head>
<body>


                    <?php
                            if ($GLOBALS['pagina']==1){
                              echo ('<div class="no-print" style="background-color:#ff6961; color: white; height:11mm;margin:5px; font-family:courier; font-size:15px; display: flex;
                              align-items: center; justify-content: center;">ATENCIÓN:Para imprimir utilice CTRL + P </div>');
                            }
                           nuevaHoja($periodo, $arregloProf->nombre);  
                           $lineas=0;  
                           $total = 0;
                           $i = 0;
                           $subtotal = 0;
                           foreach ($arregloIngresos as $valores){
                             
                                echo("<tr>");
                                echo("<td>". $valores['id_liq']. "</td>");
                                echo("<td>". $valores['os']. "</td>");
                                echo("<td>". $valores['periodoliq']. "</td>");
                                echo("<td></td>");
                                echo("<td style='text-align: right;'>". number_format($valores['importe']-$valores['descuento'] + $valores['incremento'],2,".",""). "</td>");
                                echo("<td style='text-align: right;'></td>");

                                echo("</tr>");
                                $subtotal = $subtotal + $valores['importe'] + $valores['incremento'] - $valores['descuento'];    
                                
                                $i += 1;
                                $lineas +=1;
                                //salto página
                                if ($lineas >= $lineasHoja){
                                  echo("</tbody>");
                                  echo("</table>");
                                  require APPPATH. "Views/plantilla/FooterReportes.php";
                                  echo("<hr class='saltoLinea'>");  
                                  $lineas = 0;
                                  $GLOBALS['pagina'] += 1;
                                  nuevaHoja($periodo, $arregloProf->nombre);
                                }

                            }

                            echo("<tr class='align-middle'> <td></td><td></td><td></td><td></td><td></td><td></td> 
                            <td class='text-end'><b>SUBTOTAL</b></td> 
                            <td class='text-end'><b>". number_format($subtotal,2,".","") . "</b></td>
                            </tr>");
                           
                            //retenciones
                            $retenciones = 0;
                            foreach ($arregloRet as $valores){
                             
                              echo("<tr>");
                              echo("<td></td>");
                              echo("<td></td>");
                              echo("<td>". $valores['periodoliq']. "</td>");
                              echo("<td>". $valores['detalle']. "</td>");
                              echo("<td style='text-align: right;'></td>");
                              echo("<td style='text-align: right;'>". number_format($valores['importe'],2,".",""). "</td>");
                              

                              echo("</tr>");
                              $retenciones = $retenciones + $valores['importe'] ;    
                              
                              $i += 1;
                              $lineas +=1;
                              //salto página
                              if ($lineas >= $lineasHoja){
                                echo("</tbody>");
                                echo("</table>");
                                require APPPATH. "Views/plantilla/FooterReportes.php";
                                echo("<hr class='saltoLinea'>");  
                                $lineas = 0;
                                $GLOBALS['pagina'] += 1;
                                nuevaHoja($periodo, $prof->nombre);
                              }

                          }

                          echo("<tr class='align-middle'> <td></td><td></td><td></td><td></td><td></td><td></td> 
                          <td class='text-end'><b>RETENCIONES</b></td> 
                          <td class='text-end'><b>". number_format($retenciones,2,".","") . "</b></td>
                          </tr>");

                          echo("<tr class='align-middle'> <td></td><td></td><td></td><td></td><td></td><td></td> 
                          <td class='text-end'><b>TOTAL</b></td> 
                          <td class='text-end'><b>". number_format($subtotal - $retenciones,2,".","") . "</b></td>
                          </tr>");
                         
                            echo("</tbody>");
                            echo("</table>");
                            require APPPATH. "Views/plantilla/FooterReportes.php";      
                        

                    ?>



                    </tbody>

                </table>

                
          </div>  
  
    </main>

   

  </body>
</html>

                 
                  
