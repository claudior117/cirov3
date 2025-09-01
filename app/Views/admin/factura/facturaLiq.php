<?php
    //clases propias globales
    $s = new App\Controllers\clases();
    $MSis = new App\Models\SistemaModel;
    $MLiq = new App\Models\LiquidacionesModel;
    $MTMov = new App\Models\VtaTipoMovModel;


   if ($arrayOs->factura_el_profesional == "N"){

          $r = $MSis -> getSistema();
          if (isset($r)) {
            $puntoVenta = $r->sucursal_inicio;
          }else{
            $puntoVenta = 99;
          }
        }
    else{
      $puntoVenta = 99;
    }              


    $r = $MTMov -> getTipoMov($puntoVenta,1);
    if (isset($r)) {
      $numComp =  $r->ult_num_c + 1;
      $descComp = $r->movimiento;
    }
    else{
      $numComp = 0;
      $descComp = "ERR Comp.";
    }  

     
     

?>

 

<?= $this->extend('Views/plantilla/plantillaAdmin');?>


   

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

 

  <main id="main" class ="container">
   
    <section id="about" class="about">
      <div class="container">
          <div class="row">
              <div class="col-4" style="font-size:31px;"><b><?=$descComp;?></b></div>
              <div class="col-1 text-center" style="width:51px; height:51px; border:2px solid black; font-size:31px;">C</div>  
              
              <div class="col-6">Número comprobante: <input id='idPuntoVta' value="<?=str_pad($puntoVenta, 4, "0", STR_PAD_LEFT);?>" type="number" min="1" max="9999">- <input class="w-25" id="idNumComp" type="number" min="<?=str_pad($numComp, 10, "0", STR_PAD_LEFT);?>"  value="<?=str_pad($numComp, 10, "0", STR_PAD_LEFT);?>"> </div>
          </div>    
          <div class="row">
              <div class="col-5"></div>  
              <div class="col-4 "><p>Fecha: <input class="w-50 me-3" type="date" id="idFecha" value="<?=date("Y-m-d");?>"></p></div>
              <div class="col-3 no-print">Período: <input class="" id='idPeriodo' value="<?=$periodo?>" type="number" readonly></div> 
          </div>
              
          </div>  
      </div>
      

        <!--cliente-->
        <div class="" style="background-color: #7FB3D5 ;color:white; margin:0px 2px 0px 2px;border-radius:5px;">  
          <div class="row">
            <div class="row d-flex justify-content-evenly " style="margin:10px 2px;">
              <div class="col-9" style="border:1px solid #EAF2F8; margin:5px; border-radius:3px;"><b>Cliente:</b><p style="display:inline;" id="idCliente"><?=" ". $arrayCli->denominacion;?></p> </div>
              <div class="col-2" style="border:1px solid #EAF2F8; margin:5px; border-radius:3px; ">Id:<p style="display:inline;" id="idIdCliente"><?=" ". $arrayCli->id_cliente;?></p></b>  </div>
            </div>   
          
            
          </div>  
        </div>  
      <!--fin cliente-->
   
      <!--Tabla de datos-->
    <div class="container"> 
      
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <table class="table table-sm  table-bordered m-2">
                    <thead>
                        <td></td>
                        <td></td>
                        <td>Liq </td>
                        <td>Detalle Liquidación</td>
                        <td>Cant</td>
                        <td>PU</td>
                        <td>%Iva</td>
                        <td>Parcial</td>
                        <td>Importe</td>
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:13px;">
                    <?php 
                    
                      
                                   
                      $MLiq = new App\Models\LiquidacionesModel;
                      $total = 0;
                      $profactual = 0;
                       
                      foreach($arrayLiq as $clave => $valor) {
                            $r = $MLiq->buscarPorId($valor);
                            if (isset($r)) {
                              if ($profactual== 0){
                                $profactual = $r->id_usuario;
                                $nombreactual = $r->nombre;
                                $matricula = $r->matricula;
                                $totalprof =0;
                              }

                              if($profactual != $r->id_usuario){
                                  // muestro renglon a facturar
                                  echo "<tr style='background-color:#e4fbfb'><td></td><td></td><td></td><td><b>".$nombreactual . " " . $matricula ."</b></td><td class='text-center'><b>1</b></td><td class='text-end'><b>". number_format($totalprof,2,".","") ."</b><td class='text-center'><b>21%</b></td><td></td><td class='text-end'><b>".number_format($totalprof,2,".","")."</b></td></tr>";
                                  $total += $totalprof;
                                  $profactual = $r->id_usuario;
                                  $nombreactual = $r->nombre;
                                  $matricula = $r->matricula;
                                  $totalprof =0;    
                              }    
                              echo "<tr class='no-print'><td></td><td>". $clave+1 . "</td><td class='classItemFactura'>" .$valor ."</td><td>".$r->nombre . " " . $r->os ."</td><td></td><td class='text-end'><td></td><td class='text-end'>". number_format($r->importe + $r->incremento - $r->descuento ,2,".","") . "</td><td class='text-end'></td></tr>";
                              $totalprof += $r->importe+$r->incremento-$r->descuento;
                              
                            }
                      }    
                      // muestro renglon final facturar
                      echo "<tr style='background-color:#e4fbfb'><td></td><td></td><td></td><td><b>".$nombreactual . " " . $matricula ."</b></td><td class='text-center'><b>1</b></td><td class='text-end'><b>". number_format($totalprof,2,".","") ."</b><td class='text-center'><b>21%</b></td><td></td><td class='text-end'><b>".number_format($totalprof,2,".","")."</b></td></tr>";
                      $total += $totalprof;                     
                    ?>
                    </tbody>
                </table>
                
                <div class="row">
                  <div class="col-5">
                    <?php
                       if ($arrayCli->percapita == "S"){
                         echo("<p class='m-3 text-danger'>Factura Percapita: modifique Otros Conceptos para ajustar al valor asignado por el prestador</p>"); 
                       }
                    ?>
                  </div>
                    <div class="col-7">
                    <table class="table table-sm  table-black-50 table-striped table-hover table-bordered m-2">
                        <thead class="text-end">
                            <td>Subtotal</td>
                            <td>Percapita</td>
                            <td>Otros Tributos</td>
                            <td>Total</td>
                        </thead>
                        <tbody class ="text-end" style="font-size:13px;">
                        <?php 
                          echo("<tr><td id='idSubtotal'>".number_format($total,2,".","") ."</td>");
                          if ($arrayCli->percapita == "S"){
                             echo("<td id='idPerca'><input id='idPercapita' class='claseInputItem  inputcss text-center m-0' type='number' value='0.00'></td>"); 
                          }
                          else{
                            echo("<td id='idPerca'><input id='idPercapita' value = '0.00' disabled class='text-center m-0' type='number'></td>");
                          }
                          echo("<td id='idOtros'><input id='idOtrosConceptos' class='claseInputItem  inputcss text-center m-0' type='number' value='0.00'></td>"); 
                          echo("<td id='idTotal'>".number_format($total,2,".","") ."</td></tr>");

                        
                             ?>  
                        </tbody>
                    </table>
                    <div id="idBotonesFactura" class="modal-footer no-print" >
                        <a href="<?= site_url();?>LiquidacionesA"> <button type="button" id="idBtCerrar" class="btn btn-sm btn-secondary me-3">Cerrar</button></a>
                        <?php
                          echo('<button id="idBtFacturar" type="button" class="btn btn-sm btn-danger">Emitir Factura</button>');
                        ?>
                   </div>

                  </div>
                </div>       



                <br>
                <br>
               
            </div>
           
        </div>
    </div>
    
    </div>    

  </div>

</div> 

  </section><!-- End About Section -->
 <center> <div id="idEspere" style="margin:3px; visibility:hidden;background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
 
</main><!-- End #main -->



<!-- JS -->
<script src="<?= base_url(); ?>public/js/ciro.js"></script>
<script src="<?= base_url(); ?>public/js/ventas/factLiq.js"></script>




<?= $this->endSection(); ?>
