<?php
    //clases propias globales
    $s = new App\Controllers\clases();
    $MSis = new App\Models\SistemaModel;
    $MLiq = new App\Models\LiquidacionesModel;
    $MTMov = new App\Models\VtaTipoMovModel;

    $r = $MSis -> getSistema();
    if (isset($r)) {
      $puntoVentaR = $r->sucursal_inicio;
      $puntoVentaNc = $r->sucursal_inicio;
      $puntoVentaNd = $r->sucursal_inicio;
    }else{
      $puntoVentaR = 1;
      $puntoVentaNc = 1;
      $puntoVentaNd = 1;
    }    


    $r = $MTMov -> getTipoMov($puntoVentaR,50);
    if (isset($r)) {
      $numRbo =  $r->ult_num_c + 1;
    }
    else{
      $numRbo = 0;
    }  

    $r = $MTMov -> getTipoMov($puntoVentaR,30);
    if (isset($r)) {
      $numNc =  $r->ult_num_c + 1;
    }
    else{
      $numNc = 0;
    }  
     
     
    $r = $MTMov -> getTipoMov($puntoVentaR,20);
    if (isset($r)) {
      $numNd =  $r->ult_num_c + 1;
    }
    else{
      $numNd = 0;
    }  
     

?>

 

<?= $this->extend('Views/plantilla/plantillaAdmin');?>


   

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

 

  <main id="main" class ="container">
   
    <section id="about" class="about">
      <!--<div class="container">-->
          <div class="row">
              <div class="col-4" style="font-size:41px;"><b>RECIBO/NC</b></div>
              <div class="col-1 text-center" style="width:61px; height:61px; border:2px solid black; font-size:41px;">C</div>  
              <div class="col-1"></div>
              <div class="col-5 w-50"><p>Número Recibo: <input id='idPuntoVtaR' value="<?=str_pad($puntoVentaR, 4, "0", STR_PAD_LEFT);?>" type="number" min="1" max="9999">- <input id="idNumR" type="number" min="<?=str_pad($numRbo, 10, "0", STR_PAD_LEFT);?>"  value="<?=str_pad($numRbo, 10, "0", STR_PAD_LEFT);?>"> </p>
                <p>Número Crédito: <input id='idPuntoVtaNc' value="<?=str_pad($puntoVentaNc, 4, "0", STR_PAD_LEFT);?>" type="number" min="1" max="9999">- <input id="idNumNc" type="number" min="<?=str_pad($numNc, 10, "0", STR_PAD_LEFT);?>"  value="<?=str_pad($numNc, 10, "0", STR_PAD_LEFT);?>"> </p>  
                <p>Número Débito: <input id='idPuntoVtaNd' value="<?=str_pad($puntoVentaNd, 4, "0", STR_PAD_LEFT);?>" type="number" min="1" max="9999">- <input id="idNumNd" type="number" min="<?=str_pad($numNd, 10, "0", STR_PAD_LEFT);?>"  value="<?=str_pad($numNd, 10, "0", STR_PAD_LEFT);?>"> </p>  
                <p>Fecha Emisión: <input  class="w-25 me-3" type="date" id="idFecha" value="<?=date("Y-m-d");?>"> <input  class="w-25 "readonly type="text" id="idPeriodo" value="<?=$periodo;?>">   </p>
              </div>
              
          </div>  
      <!--</div>-->
      

        <!--cliente-->
        <!--<div style="border: 10px solid  #fffec4; margin:0; border-radious:5px;">  -->
        <div class="row" style="background-color: #CD6155  ;color:white; margin:0px 2px 0px 2px;border-radius:5px;">  
            <div class="row" style="margin:10px 5px; ">
              <div class="col-4" style="border:1px solid #ff6565;  margin:5px; border-radius:3px;padding:3px;"><b>Cliente:</b><p style="display:inline;" id="idCliente"><?=" ". $arrayRbo->cliente;?></p> </div>
              <div class="col-1" style="border:1px solid #ff6565; margin:5px; border-radius:3px; "><p style="display:inline;" id="idIdCliente"><?=" ". $arrayRbo->id_cliente;?></p></b> </div>
              <div class="col-1"></div>
              <div class="col-4" style="border:1px solid #ff6565; margin:5px; border-radius:3px; "><b>Factura Ref:</b><p style="display:inline;" id="idRef"><?=" ". $arrayRbo->letra . str_pad($arrayRbo->sucursal, 4, "0", STR_PAD_LEFT). "-" . str_pad($arrayRbo->num_comprobante, 10, "0", STR_PAD_LEFT);?></p> </div>
              <div class="col-1" style="border:1px solid #ff6565; margin:5px; border-radius:3px; "><p style="display:inline;" id="idIdFactura"><?=" ". $arrayRbo->id_vta;?></p></b> </div>
              
            </div>   
          
            
          </div>  
       <!-- </div> --> 
      <!--fin cliente-->
   
      <!--Tabla de datos-->
    <div class="container"> 
      
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                 <table class="table table-sm  table-hover table-bordered m-2">
                    <thead class="text-center">
                        <td></td>
                        <td>Id</td>
                        <td>Liq</td>
                        <td>Detalle</td>
                        <td>Importe</td>
                        <td class="text-center">Descuento <i id="idBtnDescuento" class="bi bi-percent btn_tbl_mini_borrar"></i></td>
                        <td class="text-center">Incremento</td>
                        <td>Bonos/Anticipos</td>
                        <td>A aplicar</td>
                       
                    </thead>
                    <tbody id="tb1" style="font-size:13px;">
                    <?php 
                    
                      $subtotal = 0;
                      $descuento = 0;
                      $incremento = 0;
                      $bonos = 0;
                      foreach($arrayDet as $clave => $valor) {
                              echo "<tr><td></td><td>". $valor['id_mov_detalle'] . "</td><td>" .$valor['id_liquidacion'] ."</td><td>".$valor['detalle'] . "</td><td class='CelImporte text-end'>". number_format($valor['importe'],2,".",""). "</td><td style='width:121px;'><input class='claseInputItem  text-center inputcss m-0 CelDescuento' style='width:100%;' type='number' value=0 ></td><td style='width:121px;'><input class='claseInputItem  text-center inputcss m-0 CelIncremento' type='number' value=0 style='width:100%;'></td><td style='width:121px;'><input class='claseInputItem  text-center inputcss m-0 CelBono' type='number' value=0 style='width:100%;'></td><td class='text-end CelPago'>". number_format($valor['importe'],2,".","") ."</td></tr>";
                              $subtotal += $valor['importe'];
                              
                            }
                     
                    ?>
                    </tbody>
                </table>
                
                <div class="row">
                  <div class="col-5"></div>
                    <div class="col-7">
                    <table class="table table-sm  table-hover table-bordered m-2">
                        <thead class="text-end">
                            <td><b>Subtotal</b></td>
                            <td><b>Descuentos</b></td>
                            <td><b>Icrementos</b></td>
                            <td><b>Bonos</b></td>
                            <td><b>Total</b></td>
                        </thead>
                        <tbody class ="text-end" style="font-size:13px;">
                        <?php 
                          echo("<tr><td style='width:141px;' id='idSubtotal'><b>".number_format($subtotal,2,".","") ."</b></td><td style='width:141px;' id='idDescuento'><b>".number_format($descuento,2,".","") ."</b></td><td style='width:141px;'id='idIncremento'><b>".number_format($incremento,2,".","") ."</b></td><td style='width:141px;' id='idBonos'><b>".number_format($bonos,2,".","") ."</b></td><td style='width:141px;' id='idPago'><b>".number_format($subtotal - $descuento + $incremento -$bonos,2,".","") ."</b></td></tr>");
                        ?>  
                        </tbody>
                    </table>
                   

                  </div>
                </div>       
                </div> 
              </div>  
              </div>  
              </div>   
              </div>       

                <div id="idBotonesFactura" class="no-print" >
                        <a href="<?= site_url();?>Pagos"> <button type="button" id="idBtCerrar" class="btn btn-sm btn-secondary m-3">Cerrar</button></a>
                        <?php
                          echo('<button id="idBtRecibo" type="button" class="btn btn-sm btn-danger m-3">Emitir Recibo</button>');
                          echo('<button id="idBtNc" type="button" class="btn btn-sm btn-danger m-3">Emitir NC Descuentos</button>');
                          echo('<button id="idBtNd" type="button" class="btn btn-sm btn-danger m-3">Emitir ND Incrementos</button>');
                          echo('<button id="idBtBonos" type="button" class="btn btn-sm btn-danger m-3">Emitir NC Bonos</button>');
                    
                    ?>
                   </div>
               
           
           
       
    
    
     

  



  </section><!-- End About Section -->
 <center> <div id="idEspere" style="margin:3px; visibility:hidden;background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
 
</main><!-- End #main -->



<!-- JS -->
<script src="<?= base_url(); ?>public/js/ciro.js"></script>
<script src="<?= base_url(); ?>public/js/pagos/rbo.js"></script>




<!-- Modal Agrega Descuento-->
    <!-- data-bs-target  apunta al id -->
    <div class="modal fade" id="ModalDescuento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm ">
            <div class="modal-content ">
                <div id="modal-header" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Calcula y aplica descuentos</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">


                    <!--cuerpo del modal-->
              
                        <div class="row mb-2">
                           
                            <div class="col-6">
                                <label for="idTipoDescuento" class="form-label">Tipo</label>
                                <select id="idTipoDescuento" name="nameTipoDescuento" class="form-control form-select form-control-sm inputcss ">
                                  <option value="P">Porcentaje</option>
                                  <option value="I">Importe</option>
                                </select>  
                            </div>
                            <div class="col-6">
                                <label for="idValorDescuento" class="form-label">Valor</label>
                                <input type="Numeric"    id="idValorDescuento" name="nameValorDescuento" class="form-control form-control-sm inputcss">
                            </div>
                            </div>
                            
                        
                        <div class="row">
                        <div class="col-3"></div>  
                        <div class="col-9">    
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button id="idBtCalcDesc"  class="btn btn-sm  btn-danger ">Aplicar</button>
                            </div>
                         </div>    
                        </div>
              
                </div>
                <!--
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtAct" type="button" class="btn btn-sm getstarted">Guardar</button>
                </div> -->
            </div>
        </div>
    </div>
    <!--FIN Modal -->





<?= $this->endSection(); ?>
