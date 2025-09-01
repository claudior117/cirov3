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
$GLOBALS['titulo'] ="ESTADO CUENTA PERCAPITA ";
$GLOBALS['pagina'] = 1;


function nuevaHoja($fd){
  $lineas = 0;
 require APPPATH. "Views/plantilla/headerReportes.php";    
 
echo('<div style="font-family:courier; font-size:11px; border:solid 1px black; align:left; margin:5mm;">
<table style="width:90%; margin:auto;">
 <tr>
   <td><p style="font-size:16px;"><strong>'.$GLOBALS['titulo'] . '<strong></p></td>
   <td><p><strong>Fecha desde :'. $fd .'<strong></p></td>
   
   
 </tr>
 
</table>

</div>
</div>');



  echo('<table style="width:95%; margin:auto;" >
  <thead style="border-collapse: separate; background-color:#f8ffb8;  border:3px solid blue; font-size:13px;">
   <tr style="font-weight: bold; "> 
   <td>Fecha</td>
   <td>Prestador</td>
   <td>Comprobante</td>
   <td>Período</td>
   <td style="text-align:end;">Ingreso</td>
   <td style="text-align:end;">Egresos</td>
   <td style="text-align:end;">Saldo</td>
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
                           nuevaHoja($fechaDesde);  
                           $lineas=0;  
                           $total = 0;
                           $i = 0;
                           foreach ($arregloMov as $valores){
                                  
                                $c = $valores['abreviatura']. " " . $valores['letra']. str_pad( $valores['sucursal'], 4, "0", STR_PAD_LEFT) ."-". str_pad( $valores['num_comprobante'], 10, "0", STR_PAD_LEFT) ;
                               
                                if($valores['ubicacion_percapita'] == 'E'){
                                  $ing = number_format($valores['importe_percapita'],2);
                                  $egr = "";
                                  $total += $valores['importe_percapita'];
                                }
                                else{
                                  $egr = number_format($valores['importe_percapita'],2 );
                                  $ing = "";
                                  $total -= $valores['importe_percapita'];
                                }
                                echo("<tr>");
                                echo("<td>". $valores['fecha']. "</td>");
                                echo("<td>". $valores['cliente']. "</td>");
                                echo("<td>". $c. "</td>");
                                echo("<td>".$valores['periodo']."</td>");
                                echo("<td style='text-align: right;'>". $ing. "</td>");
                                echo("<td style='text-align: right;'>". $egr. "</td>");
                                echo("<td style='text-align: right;'>". number_format($total,2)."</td>");

                                echo("</tr>");
                                
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
                                  nuevaHoja($fechaDesde);
                                }

                            }

                           
                            require APPPATH. "Views/plantilla/FooterReportes.php";      
                        

                    ?>



                    </tbody>

                </table>

                
          </div>  
  
    </main>

   

  </body>
</html>

                 
                  
