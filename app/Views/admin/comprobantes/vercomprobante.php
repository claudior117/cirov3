<?php
    //clases propias globales
    $s = new App\Controllers\clases();
    $MSis = new App\Models\SistemaModel;
    $MLiq = new App\Models\LiquidacionesModel;
    $MTMov = new App\Models\VtaTipoMovModel;

    
?>

 

<?= $this->extend('Views/plantilla/plantillaAdmin');?>


   

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

 

  <main id="main" class="container">
   
    <section id="about" class="about">
      <div class="container">
          <div class="row">
              <div class="col-4 LineaTituloP me-5" style="font-size:21px;"><b><?= $arrayTipoMov->movimiento;?></b></div>
              <div class="col-1 text-center mt-3" style="width:61px; height:61px; border:2px solid black; font-size:41px;">C</div>  
              
              <div class="col-5 mt-3"><p>Comprobante: <?=str_pad($arrayFact->sucursal, 4, "0", STR_PAD_LEFT) . "-" . str_pad($arrayFact ->num_comprobante, 10, "0", STR_PAD_LEFT);?></p>
              <p>Fecha: <?= $arrayFact -> fecha; ?></p>
              </div>
              <div class="col-1 mt-3">
                        <!--<a class="btn_mc_mini_volver" href=tadoCuentaClientes" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>-->
              <a class="btn_mc_mini_volver no-print" href="javascript:window.history.go(-1)" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
                      </div>
          </div>  
      </div>
      

      <!--cliente-->
      <div class="" style="background-color: #7FB3D5; color:white; margin:0px 2px 0px 2px;border-radius:5px;">  
        
          <div class="row">
            <div class="row" style="margin:10px 5px;">
              <div class="col-9" style="border:1px solid white; margin:5px; border-radius:3px;"><b>Cliente:</b><p style="display:inline;"><?=" ". $arrayFact->cliente;?></p> </div>
              <div class="col-2" style="border:1px solid white; margin:5px; border-radius:3px; ">Id:<p style="display:inline;"><?=" ". $arrayFact->id_cliente;?></p></b>  </div>
            </div>   
          
            <div class="row"  style="margin:0px 5px 10px 5px;">
              <div class="col-9" style="border:1px solid white; margin:5px; border-radius:3px; "><b>Observaciones:</b><p style="display:inline;"><?=" ";?></p> </div>
            </div>   
            
          </div>  
        </div>  
      <!--fin cliente-->
   
   
   
      <!--Tabla de datos-->
    <div class="container"> 
        <div class="row">
            <div class="col-12" style="border: 1px solid #ff6565; margin:11px 0px; border-radius:3px;">
                <table class="table table-sm  table-black-50 table-striped table-hover table-bordered m-2">
                    <thead>
                        <td></td>
                        <td></td>
                        <td>Liq </td>
                        <td>Detalle</td>
                        <td>Cant</td>
                        <td>PU</td>
                        <td>%Iva</td>
                        <td>Importe</td>
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:13px;">
                    <?php 
                    
                      foreach($arrayItems as  $clave) {
                              
                              echo "<tr><td></td><td>". $clave['renglon'] . "</td><td class='classItemFactura'>" .$clave['id_liquidacion'] ."</td><td>".$clave['detalle'] . "</td><td>". $clave['cantidad'] ."</td><td class='text-end'>". number_format($clave['pu'],2,".","") ."<td>21%</td><td class='text-end'>".number_format($clave['importe'],2,".","")."</tr>";
                      } 
                                              
                    ?>
                    </tbody>
                </table>
                
                <div class="row">
                  <div class="col-6"></div>
                    <div class="col-6">
                    <table class="table table-sm  table-black-50 table-striped table-hover table-bordered m-2">
                        <thead class="text-end">
                            <td>Subtotal</td>
                            <td>Importe percapita</td>
                            <td>Otros Tributos</td>
                            <td>Total</td>
                        </thead>
                        <tbody class ="text-end" style="font-size:13px;">
                        <?php 
                          echo("<tr><td id='idSubtotal'>".number_format($arrayFact->subtotal,2,".","") ."</td><td>".number_format($arrayFact->importe_percapita,2,".","") ."</td><td>".number_format($arrayFact->otros_concepto,2,".","") ."</td><td id='idTotal'>".number_format($arrayFact->total,2,".","") ."</td></tr>")
                        ?>  
                        </tbody>
                    </table>
                  </div>
                </div>       
                
            </div>
             <!--detalle comp -->
             <div class="row">
              <div class="col-5">
                    <p>Número interno: <input type="number"  readonly id="idVta" value=<?=$arrayFact->id_vta;?>></p>
              </div>       
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
<script src="<?= base_url(); ?>js/ciro.js"></script>
<script src="<?= base_url(); ?>js/comprobantes/vercomprobante.js"></script>




<?= $this->endSection(); ?>
