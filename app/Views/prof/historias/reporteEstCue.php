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
$GLOBALS['titulo'] ="HISTORIA CLÍNICA: " ;
$GLOBALS['pagina'] = 1;


function nuevaHoja($paciente){
  $lineas = 0;
 require APPPATH. "Views/plantilla/headerReportesProf.php";    
 
echo('<div style="font-family:courier; font-size:11px; border:solid 1px black; align:left; margin:5mm;">
<table style="width:90%; margin:auto;">
 <tr>
   <td><p style="font-size:16px;"><strong>'.$GLOBALS['titulo'] . '<strong></p></td>
   <td><p><strong>PACIENTE:'. $paciente .'<strong></p></td>
   
 </tr>
 
</table>

</div>
</div>');



  echo('<table style="width:95%; padding-bottom: 20px; margin:auto;" >
  <thead style="border-collapse: separate; background-color:#f8ffb8;  border:3px solid blue; font-size:13px;">
   <tr style="font-weight: bold; "> 
   <td>Fecha</td>
   <td>Cod.</td>
   <td>Item</td>
   <td>Pieza/Cara</td>
   <td>Pagas</td>
   <td>Impagas</td>
   <td>Saldo</td>
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
                             
                           $i = 0;
                           $pasada = 0;
                           $ti = 0;
                           $tp = 0;
                           $ts =0;   
                           foreach ($arreglo as $valores){

                                if($pasada==0){
                                  $paciente = $valores['denominacion'] . " (" . $valores['dni'] . ")" ; 
                                  nuevaHoja($paciente);  
                                  $lineas=0;
                                  $pasada =1;
                                }
                               
                                echo("<tr>");
                                echo("<td>". $valores['fecha']. "</td>");
                                echo("<td>". $valores['codigo']. "</td>");
                                echo("<td>". $valores['desc_item']. "</td>");
                                echo("<td>". $valores['elemento'] . " " . $valores['cara']. "</td>");
                                if ($valores['estado_pago'] == 'P'){
                                  echo("<td style='align:left;'>". sprintf("%.2f", $valores['importe']).  "</td><td></td>");
                                  $tp = $tp + $valores['importe'];                                    
                                }else{
                                  echo("<td></td><td style='align:left;'>". sprintf("%.2f", $valores['importe']).  "</td>");
                                  $ti = $ti + $valores['importe'];
                                }
                                echo("<td></td>");
                                echo("</tr>");
                                
                                $i += 1;
                                $lineas +=1;
                                //salto página
                                if ($lineas >= $lineasHoja){
                                  echo("</tbody>");
                                  echo("</table>");
                                  //require APPPATH. "Views/plantilla/FooterReportes.php";
                                  echo("<hr class='saltoLinea'>");  
                                  $lineas = 0;
                                  $GLOBALS['pagina'] += 1;
                                  nuevaHoja($paciente);
                                }

                            }
                            if($ti>$tp){
                              $ts = $ti-$tp;
                            }
                            echo("<tr><td></td><td></td><td></td><td></td><td><hr></td><td><hr></td><td><hr></td></tr>");
                            echo("<tr><td></td><td></td><td></td><td></td><td style='align:left;'>". sprintf("%.2f", $tp). "</td><td style='align:right;'>".sprintf("%.2f", $ti)."</td><td style='align:right;'>". sprintf("%.2f", $ts)."</td></tr>");
                            echo("</tbody>");
                            echo("</table>");
                            //require APPPATH. "Views/plantilla/FooterReportes.php";      
                        

                    ?>



                    </tbody>

                </table>

                
          </div>  
  
    </main>

   

  </body>
</html>

                 
                  
