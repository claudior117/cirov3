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
$GLOBALS['titulo'] ="LIQUIDACIÓN: ";
$GLOBALS['pagina'] = 1;


function nuevaHoja($idl, $a, $m, $os2, $p, $e){
  $lineas = 0;
 require APPPATH. "Views/plantilla/headerReportes.php";    
 
echo('<div style="font-family:courier; font-size:11px; border:solid 1px black; align:left; margin:5mm;">
<table style="width:90%; margin:auto;">
 <tr>
   <td><p style="font-size:16px;"><strong>'.$GLOBALS['titulo']. $idl . '<strong></p></td>
   <td><p><strong>Periodo:'. $a.$m.'<strong></p></td>
   <td><p><strong>ESTADO:'. $e.'<strong></p></td>
 </tr>
 <tr>  
   <td><p><strong>Profesional:'.$p.'<strong></p></td>
   <td><p><strong>Obra Social:'.$os2.'<strong></p></td>
 </tr>
</table>

</div>
</div>');



  echo('<table style="width:95%; margin:auto;" >
  <thead style="border-collapse: separate; background-color:#f8ffb8;  border:3px solid blue; font-size:13px;">
   <tr style="font-weight: bold; "> 
   <td></td>
   <td>Id</td>
   <td>Código</td>
   <td >Item</td>
   <td style="text-align:end;">Cant.</td>
   <td style="text-align:end;">Arancel</td>
   <td style="text-align:end;">Importe</td>
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
                            nuevaHoja($idliquidacion, $año, $mes, $os, $prof, $estado);  
                           $lineas=0;  
                           $total = 0;
                            $i = 0;
                           
                            foreach ($arregloItems as $valores){
                             
                                echo("<tr>");
                                echo("<td></td>");
                                echo("<td>". $valores['id_itemos']. "</td>");
                                echo("<td>". $valores['codigo']. "</td>");
                                echo("<td>". $valores['desc_item']. "</td>");
                                echo("<td>". $valores['cantidad']. "</td>");
                                echo("<td style='text-align: right;'>". number_format($valores['pu'],2,".",""). "</td>");
                                echo("<td style='text-align: right;'>". number_format($valores['importe'],2,".",""). "</td>");

                                echo("</tr>");
                                $total = $total + $valores['importe'];    
                                
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

                                  nuevaHoja($idliquidacion, $año, $mes, $os, $prof, $estado);
                                }

                            }
                            echo("<tr>");
                            echo("<td></td>");
                            echo("<td></td>");
                            echo("<td></td>");
                            echo("<td></td>");
                            echo("<td></td>");
                            echo("<td style='text-align: right;font-size:13px;'><b> TOTAL</b> </td>");
                            echo("<td style='text-align: right;font-size:13px;'><b>". number_format($total,2,".","") . "</b></td>");
                            
                            echo("</tr>");

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

                 
                  
